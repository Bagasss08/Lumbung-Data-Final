<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi\ArsipDesa;

use App\Http\Controllers\Controller;
use App\Models\Arsip;
use App\Models\ArsipSurat;
use App\Models\PpidDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipDesaController extends Controller {
    public function index(Request $request) {
        $kategori       = $request->get('kategori', 'dokumen_desa');
        $isLayananSurat = $kategori === 'layanan_surat';

        $validKategori = ['dokumen_desa', 'surat_masuk', 'surat_keluar', 'kependudukan', 'layanan_surat'];
        if (!in_array($kategori, $validKategori)) {
            $kategori = 'dokumen_desa';
        }

        $stats = [
            'dokumen_desa'  => PpidDokumen::where('status', 'aktif')->count(),
            'surat_masuk'   => Arsip::where('jenis_dokumen', 'surat_masuk')->count(),
            'surat_keluar'  => Arsip::where('jenis_dokumen', 'surat_keluar')->count(),
            'kependudukan'  => Arsip::where('jenis_dokumen', 'kependudukan')->count(),
            'layanan_surat' => ArsipSurat::count(),
        ];

        $arsip     = collect();
        $tahunList = collect();

        if ($kategori === 'dokumen_desa') {
            $query = PpidDokumen::with('jenisDokumen')->where('status', 'aktif');
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }
            if ($request->filled('jenis_dokumen')) {
                $query->whereHas('jenisDokumen', fn($q) => $q->where('nama', $request->jenis_dokumen));
            }
            if ($request->filled('search')) {
                $query->where('judul_dokumen', 'like', '%' . $request->search . '%');
            }
            $arsip     = $query->latest()->paginate(10)->withQueryString();
            $tahunList = PpidDokumen::where('status', 'aktif')->whereNotNull('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');
        } elseif ($kategori === 'layanan_surat') {
            $query = ArsipSurat::query();
            if ($request->filled('tahun')) {
                $query->whereYear('tanggal_surat', $request->tahun);
            }
            if ($request->filled('search')) {
                $query->where(fn($q) => $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('jenis_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pemohon', 'like', '%' . $request->search . '%'));
            }
            $arsip     = $query->latest()->paginate(10)->withQueryString();
            $tahunList = ArsipSurat::selectRaw('DISTINCT YEAR(tanggal_surat) as tahun')->whereNotNull('tanggal_surat')->orderBy('tahun', 'desc')->pluck('tahun');
        } else {
            $query = Arsip::where('jenis_dokumen', $kategori);
            if ($request->filled('tahun')) {
                $query->whereYear('tanggal_dokumen', $request->tahun);
            }
            if ($request->filled('search')) {
                $query->where(fn($q) => $q->where('nama_dokumen', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%'));
            }
            $arsip     = $query->latest()->paginate(10)->withQueryString();
            $tahunList = Arsip::where('jenis_dokumen', $kategori)->selectRaw('DISTINCT YEAR(tanggal_dokumen) as tahun')->whereNotNull('tanggal_dokumen')->orderBy('tahun', 'desc')->pluck('tahun');
        }

        return view('admin.buku-administrasi.arsip', compact('arsip', 'kategori', 'stats', 'tahunList', 'isLayananSurat'));
    }

    /**
     * Tombol 1 — TAMPILKAN
     * Redirect ke halaman daftar (index) modul asal.
     */
    public function show($id, Request $request) {
        $kategori = $request->get('kategori', 'dokumen_desa');

        return match ($kategori) {
            'dokumen_desa'  => redirect()->route('admin.ppid.index'),
            'surat_masuk'   => redirect()->route('admin.sekretariat.agenda-surat-masuk.index'),
            'surat_keluar'  => redirect()->route('admin.sekretariat.agenda-surat-keluar.index'),
            'layanan_surat' => redirect()->route('admin.layanan-surat.arsip'),
            default         => redirect()->route('admin.buku-administrasi.arsip.index', ['kategori' => $kategori]),
        };
    }

    /**
     * Tombol 2 — UBAH LOKASI ARSIP
     * Update kolom lokasi_arsip.
     */
    public function updateLokasi(Request $request, $id) {
        $request->validate([
            'lokasi_arsip' => 'nullable|string|max:255',
            'kategori'     => 'required|string',
        ]);

        if ($request->kategori === 'dokumen_desa') {
            PpidDokumen::findOrFail($id)->update(['lokasi_arsip' => $request->lokasi_arsip]);
        } else {
            Arsip::findOrFail($id)->update(['lokasi_arsip' => $request->lokasi_arsip]);
        }

        return redirect()
            ->route('admin.buku-administrasi.arsip.index', [
                'kategori' => $request->kategori,
                'tahun'    => $request->tahun,
                'page'     => $request->page,
            ])
            ->with('success', 'Lokasi arsip berhasil diperbarui.');
    }

    public function lihat($id, Request $request) {
        $kategori = $request->get('kategori', 'dokumen_desa');
        $filePath = $this->resolveFilePath($id, $kategori);

        abort_if(!$filePath || !Storage::disk('public')->exists($filePath), 404, 'File tidak ditemukan.');

        return response()->file(Storage::disk('public')->path($filePath));
    }

    public function unduh($id, Request $request) {
        $kategori = $request->get('kategori', 'dokumen_desa');
        $filePath = $this->resolveFilePath($id, $kategori);

        abort_if(!$filePath || !Storage::disk('public')->exists($filePath), 404, 'File tidak ditemukan.');

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Helper: ambil file_path berdasarkan kategori & id.
     */
    private function resolveFilePath($id, $kategori): ?string {
        return match ($kategori) {
            'dokumen_desa'  => PpidDokumen::find($id)?->file_path,
            'layanan_surat' => null,
            default         => Arsip::find($id)?->file_path,
        };
    }
}