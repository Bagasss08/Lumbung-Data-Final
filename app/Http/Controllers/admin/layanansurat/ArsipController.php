<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\ArsipSurat;
use App\Models\SuratTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    /**
     * Halaman arsip layanan surat (dengan filter & search)
     */
    public function arsip(Request $request)
    {
        $query = ArsipSurat::query();

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_surat', $request->tahun);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        // Filter jenis surat berdasarkan surat_template_id
        if ($request->filled('jenis_surat')) {
            $query->where('surat_template_id', $request->jenis_surat);
        }

        // Pencarian kata kunci
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_surat',   'like', "%{$keyword}%")
                  ->orWhere('nama_pemohon', 'like', "%{$keyword}%")
                  ->orWhere('nik',          'like', "%{$keyword}%")
                  ->orWhere('jenis_surat',  'like', "%{$keyword}%");
            });
        }

        $perPage = in_array($request->per_page, [10, 25, 50, 100])
            ? (int) $request->per_page
            : 10;

        $arsip = $query->latest('tanggal_surat')->paginate($perPage)->withQueryString();

        // Statistik
        $statPermohonan = ArsipSurat::count();
        $statArsip      = ArsipSurat::whereNotIn('status', ['ditolak', 'batal'])->count();
        $statDitolak    = ArsipSurat::where(function ($q) {
            $q->where('status', 'like', '%tolak%')
              ->orWhere('status', 'like', '%batal%');
        })->count();

        // Daftar tahun untuk dropdown
        $tahunList = ArsipSurat::selectRaw('YEAR(tanggal_surat) as tahun')
            ->whereNotNull('tanggal_surat')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Jenis surat dari tabel surat_templates
        $suratTemplates = SuratTemplate::orderBy('judul')->get();

        return view('admin.layanan-surat.arsip', compact(
            'arsip',
            'suratTemplates',
            'tahunList',
            'statPermohonan',
            'statArsip',
            'statDitolak'
        ));
    }

    /**
     * Halaman daftar arsip (legacy)
     */
    public function index()
    {
        $arsip = ArsipSurat::latest()->paginate(10);

        return view('arsip.index', compact('arsip'));
    }

    /**
     * Detail arsip
     */
    public function show($id)
    {
        $arsip = ArsipSurat::findOrFail($id);

        return view('arsip.show', compact('arsip'));
    }

    /**
     * Download file arsip
     */
    public function download($id)
    {
        $arsip = ArsipSurat::findOrFail($id);

        if (!Storage::exists($arsip->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::download($arsip->file_path);
    }

    /**
     * Soft delete arsip
     */
    public function destroy($id)
    {
        $arsip = ArsipSurat::findOrFail($id);
        $arsip->delete();

        return redirect()->route('arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }
}