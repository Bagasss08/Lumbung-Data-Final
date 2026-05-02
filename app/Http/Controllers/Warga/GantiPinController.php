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
            'pin_lama.required'              => 'PIN lama wajib diisi.',
            'pin_lama.digits'                => 'PIN lama harus 6 digit angka.',
            'pin_baru.required'              => 'PIN baru wajib diisi.',
            'pin_baru.digits'                => 'PIN baru harus 6 digit angka.',
            'pin_baru.confirmed'             => 'Konfirmasi PIN baru tidak cocok.',
            'pin_baru.different'             => 'PIN baru tidak boleh sama dengan PIN lama.',
            'pin_baru_confirmation.required' => 'Konfirmasi PIN baru wajib diisi.',
        ]);

        $user = Auth::user();

        // Ambil data dari tabel layanan_mandiri berdasarkan penduduk_id
        $lm = LayananMandiri::where('penduduk_id', $user->penduduk_id)->first();

        if (! $lm) {
            return back()->withErrors(['pin_lama' => 'Data layanan mandiri tidak ditemukan.']);
        }

        // Verifikasi PIN lama — PIN di-hash bcrypt
        if (! Hash::check($request->pin_lama, $lm->pin)) {
            return back()->withErrors(['pin_lama' => 'PIN lama tidak sesuai.'])->withInput();
        }

        // Simpan PIN baru + tandai pin_default = 0 (sudah bukan PIN default)
        $lm->update([
            'pin'         => Hash::make($request->pin_baru),
            'pin_default' => 0,
        ]);

        // Redirect ke halaman ini dengan session 'pin_changed'
        // Blade akan tampilkan modal sukses, user klik OK → logout → ke login
        return redirect()->route('warga.ganti-pin')
            ->with('pin_changed', true);
    }
}
