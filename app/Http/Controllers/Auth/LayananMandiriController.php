<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LayananMandiri;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class LayananMandiriController extends Controller {
    /**
     * Tampilkan halaman login Layanan Mandiri.
     */
    public function showLoginForm() {
        if (session('lm_penduduk_id') && \Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        // Bersihkan session lm yang mungkin tersisa
        session()->forget(['lm_penduduk_id', 'lm_nama', 'lm_nik', 'lm_akun_id']);

        return view('auth.layanan-mandiri');
    }

    /**
     * Proses login warga dengan NIK + PIN.
     */
    public function login(Request $request) {
        $request->validate([
            'nik' => ['required', 'digits:16'],
            'pin' => ['required', 'string', 'min:6'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits'   => 'NIK harus 16 digit.',
            'pin.required' => 'PIN wajib diisi.',
            'pin.min'      => 'PIN minimal 6 karakter.',
        ]);

        // Rate limiting – maks 5 percobaan per menit per IP
        $throttleKey = 'lm-login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'nik' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('nik'));
        }

        // 1. Cari penduduk berdasarkan NIK
        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors(['nik' => 'NIK atau PIN salah.'])
                ->withInput($request->only('nik'));
        }

        // 2. Cari akun layanan mandiri milik penduduk ini
        $akun = LayananMandiri::where('penduduk_id', $penduduk->id)->first();

        if (!$akun || !$akun->pin) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'nik' => 'Akun Layanan Mandiri belum dibuat. Hubungi kantor desa.'
            ])->withInput($request->only('nik'));
        }

        // 3. Verifikasi PIN
        if (!Hash::check($request->pin, $akun->pin)) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors(['nik' => 'NIK atau PIN salah.'])
                ->withInput($request->only('nik'));
        }

        // 4. Login berhasil — simpan ke session
        RateLimiter::clear($throttleKey);
        // Catat waktu login terakhir
        $akun->update(['last_login_at' => now()]);

        // ── TAMBAHKAN INI ──────────────────────────────────
        // Tampilkan peringatan jika PIN masih default
        if ($akun->pin_default) {
            session(['show_pin_warning' => true]);
        }
        // ───────────────────────────────────────────────────

        // Cari atau buat user otomatis
        $user = \App\Models\Users::firstOrCreate(...);
        $request->session()->regenerate();

        session([
            'lm_penduduk_id' => $penduduk->id,
            'lm_nama'        => $penduduk->nama,
            'lm_nik'         => $penduduk->nik,
            'lm_akun_id'     => $akun->id,
        ]);

        // Catat waktu login terakhir
        $akun->update(['last_login_at' => now()]);

        // Cari atau buat user otomatis
        $user = \App\Models\Users::firstOrCreate(
            ['penduduk_id' => $penduduk->id],
            [
                'name'     => $penduduk->nama,
                'username' => $penduduk->nik,
                'email'    => $penduduk->nik . '@warga.local',
                'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                'role'     => 'warga',
            ]
        );

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('warga.dashboard')
            ->with('success', 'Selamat datang, ' . $penduduk->nama . '!');
    }

    /**
     * Logout dari Layanan Mandiri.
     */
    public function logout(Request $request) {
        \Illuminate\Support\Facades\Auth::logout();

        $request->session()->forget([
            'lm_penduduk_id',
            'lm_nama',
            'lm_nik',
            'lm_akun_id',
        ]);

        return redirect()->route('layanan-mandiri')
            ->with('success', 'Anda telah keluar dari Layanan Mandiri.');
    }

    /**
     * Tampilkan halaman masuk dengan E-KTP (QR Scanner)
     */
    public function showMasukEktp() {
        return view('auth.masuk-ektp');
    }

    /**
     * Proses login dari E-KTP (NIK dari QR + PIN)
     */
    public function prosesMasukEktp(Request $request) {
        $request->validate([
            'nik' => ['required', 'digits:16'],
            'pin' => ['required', 'string', 'min:6'],
        ], [
            'nik.required' => 'NIK tidak ditemukan. Silakan scan ulang e-KTP Anda.',
            'nik.digits'   => 'NIK harus 16 digit.',
            'pin.required' => 'PIN wajib diisi.',
            'pin.min'      => 'PIN minimal 6 karakter.',
        ]);

        $throttleKey = 'lm-ektp.' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'pin' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $penduduk = Penduduk::where('nik', $request->nik)->first();

        if (!$penduduk) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors(['pin' => 'NIK tidak terdaftar di sistem.']);
        }

        $akun = LayananMandiri::where('penduduk_id', $penduduk->id)->first();

        if (!$akun || !$akun->pin) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors([
                'pin' => 'Akun Layanan Mandiri belum dibuat. Hubungi kantor desa.'
            ]);
        }

        if (!Hash::check($request->pin, $akun->pin)) {
            RateLimiter::hit($throttleKey);
            return back()->withErrors(['pin' => 'PIN yang Anda masukkan salah.']);
        }

        // Login berhasil — sama persis dengan method login() yang sudah ada
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        session([
            'lm_penduduk_id' => $penduduk->id,
            'lm_nama'        => $penduduk->nama,
            'lm_nik'         => $penduduk->nik,
            'lm_akun_id'     => $akun->id,
        ]);

        $akun->update(['last_login_at' => now()]);

        $user = \App\Models\Users::firstOrCreate(
            ['penduduk_id' => $penduduk->id],
            [
                'name'     => $penduduk->nama,
                'username' => $penduduk->nik,
                'email'    => $penduduk->nik . '@warga.local',
                'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                'role'     => 'warga',
            ]
        );

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('warga.dashboard')
            ->with('success', 'Selamat datang, ' . $penduduk->nama . '!');
    }

    /**
     * Tampilkan halaman Lupa PIN
     */
    public function showLupaPin() {
        return view('auth.lupa-pin');
    }

    /**
     * Proses pengiriman PIN baru via Telegram atau Email
     */
    public function kirimLupaPin(Request $request) {
        $request->validate([
            'nik'     => ['required', 'digits:16'],
            'channel' => ['required', 'in:telegram,email'],
        ], [
            'nik.required'     => 'NIK wajib diisi.',
            'nik.digits'       => 'NIK harus 16 digit.',
            'channel.required' => 'Pilih metode pengiriman PIN.',
            'channel.in'       => 'Metode pengiriman tidak valid.',
        ]);

        // Rate limiting – maks 3 percobaan per 10 menit per IP
        $throttleKey = 'lm-lupa-pin.' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'nik' => "Terlalu banyak permintaan. Coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('nik'));
        }

        // 1. Cari penduduk
        $penduduk = Penduduk::where('nik', $request->nik)->first();
        if (!$penduduk) {
            RateLimiter::hit($throttleKey, 600); // 10 menit
            // Pesan generik agar tidak bocorkan info NIK
            return back()->with('success', 'Jika NIK terdaftar, PIN baru akan segera dikirimkan.');
        }

        // 2. Cari akun layanan mandiri
        $akun = LayananMandiri::where('penduduk_id', $penduduk->id)->first();
        if (!$akun) {
            RateLimiter::hit($throttleKey, 600);
            return back()->with('success', 'Jika NIK terdaftar, PIN baru akan segera dikirimkan.');
        }

        // 3. Generate PIN baru (6 digit)
        $pinBaru = (string) random_int(100000, 999999);
        $akun->update(['pin' => bcrypt($pinBaru)]);

        RateLimiter::hit($throttleKey, 600);

        // 4. Kirim sesuai channel
        try {
            if ($request->channel === 'telegram') {
                $this->kirimPinViaTelegram($penduduk, $pinBaru);
            } else {
                $this->kirimPinViaEmail($penduduk, $pinBaru);
            }
        } catch (\Exception $e) {
            \Log::error('Gagal kirim PIN: ' . $e->getMessage());
            return back()->withErrors([
                'nik' => 'Gagal mengirim PIN. Pastikan data kontak penduduk sudah diisi dan konfigurasi '
                    . strtoupper($request->channel) . ' sudah benar.'
            ])->withInput($request->only('nik'));
        }

        return back()->with(
            'success',
            'PIN baru telah dikirim ke ' . strtoupper($request->channel) . ' Anda. '
                . 'Silakan masuk menggunakan PIN baru tersebut.'
        );
    }

    /**
     * Kirim PIN via Telegram Bot
     */
    private function kirimPinViaTelegram(Penduduk $penduduk, string $pin): void {
        $pengaturan = \App\Models\LayananMandiriPengaturan::first();

        // Chat ID bisa dari data penduduk atau pengaturan global
        $chatId = $penduduk->telegram_id ?? optional($pengaturan)->telegram_chat_id;

        if (!$chatId || !optional($pengaturan)->telegram_bot_token) {
            throw new \Exception('Telegram belum dikonfigurasi atau penduduk tidak memiliki Telegram ID.');
        }

        $token = $pengaturan->telegram_bot_token;
        $nama  = $penduduk->nama;
        $nik   = $penduduk->nik;

        $pesan = "🔐 *Reset PIN Layanan Mandiri*\n\n"
            . "Halo, *{$nama}*!\n\n"
            . "PIN Layanan Mandiri Anda telah direset.\n\n"
            . "NIK  : `{$nik}`\n"
            . "PIN Baru : `{$pin}`\n\n"
            . "⚠️ Jaga kerahasiaan PIN Anda. Jangan bagikan kepada siapapun.\n\n"
            . "_Pesan ini dikirim otomatis oleh sistem._";

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = \Illuminate\Support\Facades\Http::post($url, [
            'chat_id'    => $chatId,
            'text'       => $pesan,
            'parse_mode' => 'Markdown',
        ]);

        if (!$response->successful() || !($response->json('ok'))) {
            throw new \Exception('Telegram API error: ' . $response->body());
        }
    }

    /**
     * Kirim PIN via Email
     */
    private function kirimPinViaEmail(Penduduk $penduduk, string $pin): void {
        // Cek email penduduk
        if (empty($penduduk->email)) {
            throw new \Exception('Penduduk tidak memiliki alamat email.');
        }

        $nama = $penduduk->nama;
        $nik  = $penduduk->nik;

        Mail::send([], [], function ($message) use ($penduduk, $nama, $nik, $pin) {
            $message->to($penduduk->email, $nama)
                ->subject('Reset PIN Layanan Mandiri')
                ->html("
                <div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:24px;'>
                    <h2 style='color:#059669;margin-bottom:8px;'>Reset PIN Layanan Mandiri</h2>
                    <p>Halo, <strong>{$nama}</strong>!</p>
                    <p>PIN Layanan Mandiri Anda telah direset.</p>
                    <div style='background:#f0fdf4;border-left:4px solid #059669;border-radius:8px;padding:16px;margin:20px 0;'>
                        <div style='margin-bottom:6px;'>
                            <span style='color:#6b7280;font-size:13px;'>NIK</span><br>
                            <strong style='font-size:16px;letter-spacing:1px;'>{$nik}</strong>
                        </div>
                        <div>
                            <span style='color:#6b7280;font-size:13px;'>PIN Baru</span><br>
                            <strong style='font-size:22px;letter-spacing:4px;color:#059669;'>{$pin}</strong>
                        </div>
                    </div>
                    <p style='color:#ef4444;font-size:13px;'>
                        ⚠️ Jaga kerahasiaan PIN Anda. Jangan bagikan kepada siapapun.
                    </p>
                    <p style='color:#9ca3af;font-size:12px;margin-top:16px;'>
                        Pesan ini dikirim otomatis oleh sistem. Abaikan jika Anda tidak merasa meminta reset PIN.
                    </p>
                </div>
            ");
        });
    }
}
