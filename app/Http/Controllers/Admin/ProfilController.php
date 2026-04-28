<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users;
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
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
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

    // =======================
    // 🔥 KIRIM OTP (FIXED)
    // =======================
    public function sendOtp(Request $request) {
        $user = Auth::user();

        if (empty($user->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email Anda belum diatur.'
            ], 400);
        }

        $otp = rand(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(5)
        ]);

        try {
            Mail::raw(
                "Halo {$user->name},\n\nKode OTP Anda: {$otp}\n\nBerlaku 5 menit.",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Kode OTP Ubah Password');
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'OTP berhasil dikirim ke ' . $user->email
            ]);

        } catch (\Exception $e) {

            // ❗ HAPUS OTP kalau gagal
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null
            ]);

            // 🔥 TAMPILKAN ERROR ASLI
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // =======================
    // 🔥 VERIFY OTP (AJAX)
    // =======================
    public function verifyOtp(Request $request) {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user();

        if (!$user->otp_code || now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah kadaluarsa.'
            ]);
        }

        if ((string)$request->otp !== (string)$user->otp_code) {
            return response()->json([
                'success' => false,
                'message' => 'OTP salah.'
            ]);
        }

        return response()->json(['success' => true]);
    }

    // =======================
    // 🔥 UPDATE PASSWORD
    // =======================
    public function updatePassword(Request $request) {

        $request->validate([
            'new_password' => ['required', 'confirmed', Password::min(8)],
            'otp' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if (!$user->otp_code || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors([
                'otp' => 'OTP tidak valid atau kadaluarsa'
            ])->withInput();
        }

        if ((string)$request->otp !== (string)$user->otp_code) {
            return back()->withErrors([
                'otp' => 'OTP salah'
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Password berhasil diperbarui');
    }
}