<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Ganti method login() yang lama dengan ini:

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required', // Bisa email atau username (NIK)
            'password' => 'required'
        ]);

        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'username';

        $credentials = [
            $login_type => $request->input('login'),
            'password'  => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai Role
            if (Auth::user()->role === 'warga') {
                return redirect()->route('warga.dashboard');
            }
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'NIK/Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
