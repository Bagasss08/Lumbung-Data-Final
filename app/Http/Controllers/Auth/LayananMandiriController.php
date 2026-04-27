<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LayananMandiri;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

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
}
