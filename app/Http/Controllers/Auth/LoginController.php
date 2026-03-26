<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login dengan data desa
     */
    public function showLogin()
    {
        // Mengambil data identitas desa dari database untuk logo & nama
        $desa = DB::table('identitas_desa')->first();

        return view('auth.login', compact('desa'));
    }

    /**
     * Proses Login Manual (Username/Email/NIK)
     */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required', // Bisa email atau username (NIK)
            'password' => 'required'
        ]);

        // Cek apakah input login adalah email atau username/NIK
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'username';

        $credentials = [
            $login_type => $request->input('login'),
            'password'  => $request->input('password')
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return $this->authenticatedRedirect(Auth::user());
        }

        return back()->withErrors([
            'login' => 'NIK/Email atau password salah',
        ])->withInput($request->only('login'));
    }

    /**
     * Redirect User ke Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan email google
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user ditemukan, langsung login
                Auth::login($user);
                return $this->authenticatedRedirect($user);
            } else {
                // Jika user tidak ada, arahkan kembali dengan pesan error
                // Atau Anda bisa modifikasi untuk otomatis registrasi di sini
                return redirect()->route('login')->withErrors([
                    'login' => 'Email Google Anda belum terdaftar di sistem kami.',
                ]);
            }

        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'login' => 'Terjadi kesalahan saat login menggunakan Google.',
            ]);
        }
    }

    /**
     * Helper untuk mengarahkan user berdasarkan role
     */
    protected function authenticatedRedirect($user)
    {
        $role = $user->role;

        if ($role === 'superadmin') {
            return redirect()->route('superadmin.dashboard'); 
        } elseif ($role === 'admin' || $role === 'operator') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'warga') {
            return redirect()->route('warga.dashboard');
        }

        return redirect('/');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}