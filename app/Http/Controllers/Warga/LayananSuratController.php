<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananSuratController extends Controller
{
    // Halaman Riwayat Surat
    public function index()
    {
        // Nanti di sini kita ambil data surat dari database
        // $surat = Surat::where('penduduk_id', Auth::user()->penduduk_id)->get();
        return view('warga.surat.index');
    }

    // Halaman Form Tambah Surat
    public function create()
    {
        // Pastikan user punya data penduduk sebelum mengajukan surat
        if (!Auth::user()->penduduk) {
            return redirect()->route('warga.profil')->with('error', 'Lengkapi data profil terlebih dahulu.');
        }
        
        return view('warga.surat.create');
    }

    // Proses Simpan Surat
    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'keperluan'   => 'required|string',
            'file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // LOGIKA PENYIMPANAN KE DATABASE (NANTI DISESUAIKAN DENGAN TABEL SURAT)
        // Contoh:
        // Surat::create([
        //     'penduduk_id' => Auth::user()->penduduk_id,
        //     'jenis_surat' => $request->jenis_surat,
        //     'keperluan'   => $request->keperluan,
        //     'status'      => 'menunggu',
        // ]);

        // Redirect sementara (karena belum ada tabel surat)
        return redirect()->route('warga.surat.index')->with('success', 'Permohonan berhasil dikirim.');
    }
}