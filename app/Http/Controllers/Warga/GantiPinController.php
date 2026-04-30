<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\LayananMandiri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GantiPinController extends Controller {
    public function index() {
        return view('warga.ganti-pin');
    }

    public function update(Request $request) {
        $request->validate([
            'pin_lama'              => ['required', 'digits:6'],
            'pin_baru'              => ['required', 'digits:6', 'confirmed', 'different:pin_lama'],
            'pin_baru_confirmation' => ['required', 'digits:6'],
        ], [
            'pin_lama.required'  => 'PIN lama wajib diisi.',
            'pin_lama.digits'    => 'PIN lama harus 6 digit angka.',
            'pin_baru.required'  => 'PIN baru wajib diisi.',
            'pin_baru.digits'    => 'PIN baru harus 6 digit angka.',
            'pin_baru.confirmed' => 'Konfirmasi PIN baru tidak cocok.',
            'pin_baru.different' => 'PIN baru tidak boleh sama dengan PIN lama.',
        ]);

        // Ambil akun layanan_mandiri milik user yang sedang login
        $akun = LayananMandiri::where('penduduk_id', Auth::user()->penduduk_id)->first();

        if (!$akun) {
            return back()->withErrors(['pin_lama' => 'Akun Layanan Mandiri tidak ditemukan.']);
        }

        // Verifikasi PIN lama
        if (!Hash::check($request->pin_lama, $akun->pin)) {
            return back()
                ->withErrors(['pin_lama' => 'PIN lama yang Anda masukkan salah.'])
                ->withInput();
        }

        // Cek PIN lemah
        $pin        = $request->pin_baru;
        $allSame    = preg_match('/^(\d)\1+$/', $pin);
        $sequential = in_array($pin, [
            '012345',
            '123456',
            '234567',
            '345678',
            '456789',
            '987654',
            '876543',
            '765432',
            '654321',
            '543210',
        ]);

        if ($allSame || $sequential) {
            return back()
                ->withErrors(['pin_baru' => 'PIN terlalu mudah ditebak. Pilih kombinasi angka yang lebih aman.'])
                ->withInput();
        }

        // Simpan PIN baru ke tabel layanan_mandiri
        $akun->pin = Hash::make($pin);
        $akun->pin_default = false;
        $akun->save();

        return redirect()->route('warga.ganti-pin')
            ->with('success', 'PIN berhasil diperbarui. Gunakan PIN baru untuk login berikutnya.');
    }
}
