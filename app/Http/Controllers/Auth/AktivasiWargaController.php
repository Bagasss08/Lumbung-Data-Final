<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AktivasiWargaController extends Controller
{
    // Form Cek Data (Langkah 1)
    public function showCheckForm()
    {
        return view('auth.aktivasi-check');
    }

    // Proses Cek Data
    public function check(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'tanggal_lahir' => 'required|date',
        ]);

        // 1. Cari Penduduk
        $penduduk = Penduduk::where('nik', $request->nik)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$penduduk) {
            return back()->withErrors(['nik' => 'Data penduduk tidak ditemukan atau tanggal lahir salah.']);
        }

        // 2. Cek apakah sudah punya akun
        if ($penduduk->user) {
            return back()->withErrors(['nik' => 'Akun untuk NIK ini sudah aktif. Silakan login.']);
        }

        // Jika lolos, tampilkan form buat password (Langkah 2)
        // Kita kirim NIK terenkripsi atau via session flash agar aman
        return view('auth.aktivasi-register', compact('penduduk'));
    }

    // Proses Simpan Akun
    public function register(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'email' => 'nullable|email|unique:users,email', // Email opsional buat warga
            'password' => 'required|min:6|confirmed',
        ]);

        $penduduk = Penduduk::findOrFail($request->penduduk_id);

        // Buat User
        $user = User::create([
            'penduduk_id' => $penduduk->id,
            'name' => $penduduk->nama,
            'username' => $penduduk->nik, // Username pakai NIK
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga',
        ]);

        // Login otomatis
        Auth::login($user);

        return redirect()->route('warga.dashboard');
    }
}
