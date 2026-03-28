<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller {
    public function index() {
        return view('admin.profil.index');
    }

    public function update(Request $request) {
        /** @var User $user */
        $user = Auth::user();

        // Validasi disesuaikan dengan databasemu (tanpa no_hp, username required)
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan akun lain.',
            'foto.image'        => 'File harus berupa gambar.',
            'foto.max'          => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only(['name', 'username', 'email']);

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $user->update($data);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // Fungsi Generate dan Kirim OTP
    public function sendOtp(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        
        // Pastikan user punya email sebelum mengirim OTP
        if (empty($user->email)) {
            return response()->json([
                'success' => false, 
                'message' => 'Email Anda belum diatur. Silakan perbarui profil Anda terlebih dahulu.'
            ], 400);
        }

        // Generate 6 digit angka acak
        $otp = rand(100000, 999999);

        // Simpan ke database dengan batas waktu 5 menit
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        try {
            // Kirim email
            Mail::raw("Halo {$user->name},\n\nKode OTP Anda untuk mengubah password adalah: {$otp}\n\nKode ini berlaku selama 5 menit. Jangan berikan kode ini kepada siapapun demi keamanan akun Anda.", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Ubah Password - Keamanan Akun');
            });

            return response()->json([
                'success' => true, 
                'message' => 'OTP berhasil dikirim ke ' . $user->email
            ]);
        } catch (\Exception $e) {
            // Bersihkan OTP di database jika email gagal terkirim
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Gagal mengirim email. Pastikan konfigurasi SMTP di file .env sudah benar.'
            ], 500);
        }
    }

    // Fungsi Update Password
    // Fungsi Update Password yang diperbarui
    // Fungsi Update Password (Hanya butuh OTP dan Password Baru)
    // Fungsi Update Password (Hanya butuh OTP dan Password Baru)
    public function updatePassword(Request $request) {
        // 1. Validasi Input Form
        $request->validate([
            'new_password'     => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
            'otp'              => 'required|digits:6',
        ], [
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'new_password.min'          => 'Password minimal 8 karakter.',
            'otp.required'              => 'Kode OTP wajib diisi.',
            'otp.digits'                => 'Kode OTP harus 6 angka.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // 2. Validasi Batas Waktu OTP
        $expiresAt = \Carbon\Carbon::parse($user->otp_expires_at);
        if (!$user->otp_code || now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak ditemukan atau sudah kedaluwarsa. Silakan minta ulang.'])->withInput();
        }

        // 3. CEK KECOCOKAN OTP KE DATABASE (Sangat Ketat)
        // Kita jadikan (string) agar PHP tidak bingung membedakan teks dan angka
        if ((string) $request->otp !== (string) $user->otp_code) {
            return back()->withErrors(['otp' => '🚨 GAGAL: Kode OTP yang Anda masukkan SALAH / TIDAK COCOK dengan sistem!'])->withInput();
        }

        // 4. Eksekusi Update Password (HANYA JALAN KALAU OTP BENAR)
        $user->update([
            'password'       => Hash::make($request->new_password),
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('admin.profil')->with('success', 'Password berhasil diperbarui dengan aman!');
    }
    // Fungsi baru untuk ngecek OTP secara Real-Time via AJAX
    public function verifyOtp(Request $request) {
        $request->validate(['otp' => 'required|digits:6']);

        /** @var User $user */
        $user = Auth::user();

        // Cek apakah ada OTP dan apakah sudah kedaluwarsa
        $expiresAt = \Carbon\Carbon::parse($user->otp_expires_at);
        if (!$user->otp_code || now()->greaterThan($expiresAt)) {
            return response()->json([
                'success' => false, 
                'message' => 'Kode OTP tidak ditemukan atau sudah kedaluwarsa.'
            ]);
        }

        // Cek apakah angkanya cocok dengan database
        if ((string) $request->otp !== (string) $user->otp_code) {
            return response()->json([
                'success' => false, 
                'message' => 'Kode OTP salah. Silakan periksa kembali email Anda.'
            ]);
        }

        // Kalau cocok, kasih sinyal OK ke tampilan web
        return response()->json(['success' => true]);
    }
}