<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi\ArsipDesa;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Models\ArsipSurat;
use App\Models\PpidDokumen;
use Illuminate\Http\Request;

class ArsipDesaController extends Controller {
    public function index(Request $request) {
        $kategori       = $request->get('kategori', 'dokumen_desa');
        $isLayananSurat = $kategori === 'layanan_surat';

        // ── Validasi kategori ──────────────────────────────────────────
        $validKategori = ['dokumen_desa', 'surat_masuk', 'surat_keluar', 'kependudukan', 'layanan_surat'];
        if (!in_array($kategori, $validKategori)) {
            $kategori = 'dokumen_desa';
        }

        // ── Stats cards ────────────────────────────────────────────────
        $stats = [
            'dokumen_desa'  => PpidDokumen::count(),
            'surat_masuk'   => Arsip::where('jenis_dokumen', 'surat_masuk')->count(),
            'surat_keluar'  => Arsip::where('jenis_dokumen', 'surat_keluar')->count(),
            'kependudukan'  => Arsip::where('jenis_dokumen', 'kependudukan')->count(),
            'layanan_surat' => ArsipSurat::count(),
        ];

        // ── Data tabel ─────────────────────────────────────────────────
        $arsip     = collect();
        $tahunList = collect();

        if ($kategori === 'dokumen_desa') {

            $query = PpidDokumen::with('jenisDokumen');

            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }
            if ($request->filled('jenis_filter')) {
                $query->where('ppid_jenis_dokumen_id', $request->jenis_filter);
            }
            if ($request->filled('search')) {
                $query->where('judul_dokumen', 'like', '%' . $request->search . '%');
            }

            $arsip = $query->latest()->paginate(10)->withQueryString();

            $tahunList = PpidDokumen::selectRaw('DISTINCT tahun')
                ->whereNotNull('tahun')
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');
        } elseif ($kategori === 'layanan_surat') {

            $query = ArsipSurat::query();

            if ($request->filled('tahun')) {
                $query->whereYear('tanggal_surat', $request->tahun);
            }
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                        ->orWhere('jenis_surat', 'like', '%' . $request->search . '%')
                        ->orWhere('nama_pemohon', 'like', '%' . $request->search . '%');
                });
            }

            $arsip = $query->latest()->paginate(10)->withQueryString();

            $tahunList = ArsipSurat::selectRaw('DISTINCT YEAR(tanggal_surat) as tahun')
                ->whereNotNull('tanggal_surat')
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');
        } else {

            // surat_masuk / surat_keluar / kependudukan → dari tabel arsip
            $query = Arsip::where('jenis_dokumen', $kategori);

            if ($request->filled('tahun')) {
                $query->whereYear('tanggal_dokumen', $request->tahun);
            }
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_dokumen', 'like', '%' . $request->search . '%')
                        ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
                });
            }

            $arsip = $query->latest()->paginate(10)->withQueryString();

            $tahunList = Arsip::where('jenis_dokumen', $kategori)
                ->selectRaw('DISTINCT YEAR(tanggal_dokumen) as tahun')
                ->whereNotNull('tanggal_dokumen')
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');
        }

        return view('admin.buku-administrasi.arsip', compact(
            'arsip',
            'kategori',
            'stats',
            'tahunList',
            'isLayananSurat',
        ));
    }

    public function show($id, Request $request) {
        $kategori = $request->get('kategori', 'dokumen_desa');

        if ($kategori === 'dokumen_desa') {
            return redirect()->route('admin.ppid.show', $id);
        }

        $arsip = Arsip::findOrFail($id);
        return view('admin.buku-administrasi.arsip-show', compact('arsip', 'kategori'));
    }
}
