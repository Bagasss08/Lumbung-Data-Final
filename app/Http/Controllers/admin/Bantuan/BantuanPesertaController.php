<?php

namespace App\Http\Controllers\Admin\Bantuan;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Program;
use App\Models\ProgramPeserta;
use Illuminate\Http\Request;

class BantuanPesertaController extends Controller {

    public function create(Program $bantuan) {
        return view('admin.bantuan.peserta.create', compact('bantuan'));
    }

    public function store(Request $request, Program $bantuan) {
        $request->validate([
            'peserta' => 'required|string|max:20', // NIK yang diketik user
        ]);

        // Cari penduduk berdasarkan NIK di database lokal
        $penduduk = Penduduk::where('nik', $request->peserta)
            ->where('status_hidup', 'hidup')
            ->first();

        if ($penduduk) {
            // Cek apakah sudah terdaftar di program ini
            $sudahAda = $bantuan->peserta()
                ->where('penduduk_id', $penduduk->id)
                ->exists();

            if ($sudahAda) {
                return back()
                    ->withInput()
                    ->with('error', "Penduduk dengan NIK {$request->peserta} sudah terdaftar di program ini.");
            }

            // Auto-fill dari data penduduk
            $bantuan->peserta()->create([
                'penduduk_id'         => $penduduk->id,
                'peserta'             => $penduduk->nik,
                'kartu_nama'          => $penduduk->nama,
                'kartu_nik'           => $penduduk->nik,
                'kartu_tempat_lahir'  => $penduduk->tempat_lahir,
                'kartu_tanggal_lahir' => $penduduk->tanggal_lahir,
                'kartu_alamat'        => $penduduk->alamat,
            ]);
        } else {
            // NIK tidak ditemukan di database — isi manual
            $request->validate([
                'kartu_nama'          => 'required|string|max:255',
                'kartu_nik'           => 'nullable|string|max:20',
                'kartu_no_id'         => 'nullable|string|max:50',
                'kartu_tempat_lahir'  => 'nullable|string|max:100',
                'kartu_tanggal_lahir' => 'nullable|date',
                'kartu_alamat'        => 'nullable|string',
            ]);

            $bantuan->peserta()->create([
                'penduduk_id'         => null, // tidak ada di database lokal
                'peserta'             => $request->peserta,
                'kartu_nama'          => $request->kartu_nama,
                'kartu_nik'           => $request->kartu_nik,
                'kartu_no_id'         => $request->kartu_no_id,
                'kartu_tempat_lahir'  => $request->kartu_tempat_lahir,
                'kartu_tanggal_lahir' => $request->kartu_tanggal_lahir,
                'kartu_alamat'        => $request->kartu_alamat,
            ]);
        }

        return redirect()->route('admin.bantuan.show', $bantuan->id)
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function destroy(Program $bantuan, ProgramPeserta $peserta) {
        $peserta->delete();
        return redirect()->route('admin.bantuan.show', $bantuan->id)
            ->with('success', 'Peserta berhasil dihapus.');
    }
}
