<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPermohonan;
use App\Models\SuratTemplate;
use App\Models\Penduduk;

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
        $user        = Auth::user();
        $penduduk    = $user->penduduk;
        $anggotaKk   = collect();

        if ($penduduk && $penduduk->keluarga_id) {
            $anggotaKk = Penduduk::where('keluarga_id', $penduduk->keluarga_id)
                ->where('id', '!=', $penduduk->id)
                ->hidup()
                ->get(['id', 'nama', 'nik', 'kk_level']);
        }

        $suratTemplates = SuratTemplate::aktif()->with('persyaratan')->get();

        return view('warga.surat.create', compact('suratTemplates', 'penduduk', 'anggotaKk'));
    }

    public function store(Request $request)
    {
        $user        = Auth::user();
        $userPenduduk = $user->penduduk;

        $request->validate([
            'penduduk_id'           => 'required|integer|exists:penduduk,id',
            'surat_template_id'     => 'required|exists:surat_templates,id',
            'keperluan'             => 'required|string|max:500',
            'dokumen_persyaratan'   => 'required|array|min:1',
            'dokumen_persyaratan.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Pastikan penduduk yang dipilih adalah diri sendiri atau anggota KK yang sama
        $selectedId = (int) $request->penduduk_id;

        if ($selectedId !== (int) $userPenduduk->id) {
            $valid = Penduduk::where('id', $selectedId)
                ->where('keluarga_id', $userPenduduk->keluarga_id)
                ->exists();

            if (!$valid) {
                return back()
                    ->withErrors(['penduduk_id' => 'Pemohon yang dipilih tidak valid atau bukan anggota KK Anda.'])
                    ->withInput();
            }
        }

        $template = SuratTemplate::with('persyaratan')->findOrFail($request->surat_template_id);

        if ($template->persyaratan->isNotEmpty()) {
            foreach ($template->persyaratan as $syarat) {
                if (!$request->hasFile("dokumen_persyaratan.{$syarat->id}")) {
                    return back()
                        ->withErrors(["dokumen_persyaratan.{$syarat->id}" => "Unggah dokumen persyaratan: {$syarat->nama}."])
                        ->withInput();
                }
            }
        } else {
            if (!$request->hasFile('dokumen_persyaratan.general')) {
                return back()
                    ->withErrors(['dokumen_persyaratan' => 'Unggah minimal satu dokumen pendukung untuk permohonan surat ini.'])
                    ->withInput();
            }
        }

        $uploadedFiles = [];
        foreach ($request->file('dokumen_persyaratan') as $key => $uploadedFile) {
            if ($uploadedFile && $uploadedFile->isValid()) {
                $uploadedFiles[$key] = $uploadedFile->store('surat/dokumen_pendukung', 'public');
            }
        }

        $firstFilePath = reset($uploadedFiles) ?: null;
        $dataIsian = [
            'pemohon' => [
                'id'   => $selectedId,
                'nama' => Penduduk::find($selectedId)->nama ?? null,
                'nik'  => Penduduk::find($selectedId)->nik ?? null,
            ],
            'surat_template'       => $template->judul,
            'dokumen_persyaratan' => [],
        ];

        foreach ($template->persyaratan as $syarat) {
            if (isset($uploadedFiles[$syarat->id])) {
                $dataIsian['dokumen_persyaratan'][$syarat->nama] = $uploadedFiles[$syarat->id];
            }
        }

        if ($template->persyaratan->isEmpty() && isset($uploadedFiles['general'])) {
            $dataIsian['dokumen_persyaratan']['Dokumen Pendukung Utama'] = $uploadedFiles['general'];
        }

        SuratPermohonan::create([
            'penduduk_id'        => $selectedId,
            'surat_template_id'  => $request->surat_template_id,
            'keperluan'          => $request->keperluan,
            'dokumen_pendukung'  => $firstFilePath,
            'data_isian'         => $dataIsian,
            'status'             => 'sedang diperiksa',
            'tanggal_permohonan' => now(),
        ]);

        return redirect()->route('warga.surat.index')
            ->with('success', 'Permohonan surat berhasil diajukan!');
    }
}
