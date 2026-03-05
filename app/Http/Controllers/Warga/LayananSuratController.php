<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPermohonan;
use App\Models\SuratTemplate;

class LayananSuratController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penduduk_id = $user->penduduk_id;

        if (!$penduduk_id) {
            return redirect()->route('warga.dashboard')
                ->with('error', 'Akun Anda belum terhubung dengan data kependudukan.');
        }

        $riwayatSurat = SuratPermohonan::with('suratTemplate')
            ->where('penduduk_id', $penduduk_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('warga.surat.index', compact('riwayatSurat'));
    }

    public function create()
    {
        // Ambil template aktif beserta daftar persyaratannya
        $suratTemplates = SuratTemplate::aktif()->with('persyaratan')->get();

        return view('warga.surat.create', compact('suratTemplates'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'surat_template_id' => 'required|exists:surat_templates,id',
            'keperluan'         => 'required|string|max:500',
            'file'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat/dokumen_pendukung', 'public');
        }

        SuratPermohonan::create([
            'penduduk_id'        => $user->penduduk_id,
            'surat_template_id'  => $request->surat_template_id,
            'keperluan'          => $request->keperluan,
            'dokumen_pendukung'  => $filePath,
            'status'             => 'sedang diperiksa',
            'tanggal_permohonan' => now(),
        ]);

        return redirect()->route('warga.surat.index')
            ->with('success', 'Permohonan surat berhasil diajukan!');
    }
}