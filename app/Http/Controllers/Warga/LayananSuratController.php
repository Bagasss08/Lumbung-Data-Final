<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPermohonan;
use App\Models\JenisSurat;

class LayananSuratController extends Controller
{
    /**
     * Menampilkan riwayat permohonan surat warga
     */
    public function index()
    {
        // Pastikan user memiliki data penduduk (warga terdaftar)
        $user = Auth::user();
        $penduduk_id = $user->penduduk_id;

        if (!$penduduk_id) {
            return redirect()->route('warga.dashboard')
                ->with('error', 'Akun Anda belum terhubung dengan data kependudukan. Silakan hubungi admin.');
        }

        // Ambil riwayat surat milik user ini
        $riwayatSurat = SuratPermohonan::with('jenisSurat')
            ->where('penduduk_id', $penduduk_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('warga.surat.index', compact('riwayatSurat'));
    }

    /**
     * Menampilkan form pengajuan surat
     */
    public function create()
    {
        // Hanya ambil jenis surat yang statusnya 'ya' (aktif)
        $jenisSurat = JenisSurat::where('aktif', 'ya')->get();

        return view('warga.surat.create', compact('jenisSurat'));
    }

    /**
     * Menyimpan permohonan surat ke database
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'keperluan'      => 'required|string|max:500',
            'file'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // max 2MB
        ], [
            'jenis_surat_id.required' => 'Silakan pilih jenis surat.',
            'keperluan.required'      => 'Keperluan surat wajib diisi.',
            'file.mimes'              => 'Format file hanya boleh JPG, PNG, atau PDF.',
            'file.max'                => 'Ukuran file maksimal 2 MB.',
        ]);

        // Upload File Pendukung (jika ada)
        $filePath = null;
        if ($request->hasFile('file')) {
            // File akan disimpan di storage/app/public/surat/dokumen_pendukung
            $filePath = $request->file('file')->store('surat/dokumen_pendukung', 'public');
        }

        // Simpan ke database
        SuratPermohonan::create([
            'penduduk_id'        => $user->penduduk_id,
            'jenis_surat_id'     => $request->jenis_surat_id,
            'keperluan'          => $request->keperluan,
            'dokumen_pendukung'  => $filePath,
            'status'             => 'sedang diperiksa', // Status default
            'tanggal_permohonan' => now(),
        ]);

        return redirect()->route('warga.surat.index')
            ->with('success', 'Permohonan surat berhasil diajukan! Silakan tunggu proses dari admin desa.');
    }
}