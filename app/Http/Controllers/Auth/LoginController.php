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

            // Ambil data role user yang sedang login
            $role = Auth::user()->role;

            // Redirect sesuai Role masing-masing
            if ($role === 'superadmin') {
                return redirect()->route('superadmin.dashboard'); 
            } elseif ($role === 'admin' || $role === 'operator') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'warga') {
                return redirect()->route('warga.dashboard');
            }

            // Fallback (jaga-jaga jika ada user yang rolenya kosong/tidak valid)
            return redirect('/');
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