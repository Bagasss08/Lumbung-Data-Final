<?php

namespace App\Http\Controllers\Admin\layanansurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratTemplate; 
use App\Models\SuratPermohonan;
use App\Models\PersyaratanSurat;

class LayananSuratController extends Controller 
{
    /**
     * Display permohonan surat page (Index Table)
     */
    public function permohonan(Request $request) 
    {
        // Menggunakan relasi 'suratTemplate'
        $query = SuratPermohonan::with(['penduduk', 'suratTemplate']);

        // 1. Filter Berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Fitur Search (Cari NIK atau Nama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('penduduk', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 25);
        $permohonan = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.layanan-surat.permohonan.index', compact('permohonan'));
    }

    /**
     * Show detail permohonan surat
     */
    public function showPermohonan($id)
    {
        // Menggunakan relasi 'suratTemplate'
        $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($id);
        
        return view('admin.layanan-surat.permohonan.show', compact('permohonan'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatusPermohonan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:belum lengkap,sedang diperiksa,menunggu tandatangan,siap diambil,sudah diambil,dibatalkan',
            'catatan_petugas' => 'nullable|string'
        ]);

        $permohonan = SuratPermohonan::findOrFail($id);
        $permohonan->update([
            'status' => $request->status,
            'catatan_petugas' => $request->catatan_petugas
        ]);

        return redirect()->back()->with('success', 'Status permohonan surat berhasil diperbarui!');
    }

    /**
     * Display arsip surat page
     */
    public function arsip(Request $request) 
    {
        // Menggunakan relasi 'suratTemplate'
        $query = SuratPermohonan::with(['penduduk', 'suratTemplate']);

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // Filter berdasarkan ID template surat (Karena di DB sudah diubah, gunakan surat_template_id)
        if ($request->filled('jenis_surat')) {
            $query->where('surat_template_id', $request->jenis_surat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('penduduk', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $statPermohonan = SuratPermohonan::whereNotIn('status', ['sudah diambil', 'dibatalkan'])->count();
        $statArsip = SuratPermohonan::where('status', 'sudah diambil')->count();
        $statDitolak = SuratPermohonan::where('status', 'dibatalkan')->count();

        $perPage = $request->get('per_page', 25);
        $arsip = $query->orderBy('updated_at', 'desc')->paginate($perPage)->withQueryString();

        // Ambil data template surat untuk dropdown filter
        $jenisSuratList = SuratTemplate::all();
        $tahunList = range(date('Y'), date('Y') - 5); 

        return view('admin.layanan-surat.arsip', compact(
            'arsip', 'statPermohonan', 'statArsip', 'statDitolak', 'jenisSuratList', 'tahunList'
        ));
    }

    /**
     * Display pengaturan layanan surat page
     */
    public function pengaturan()
    {
        $templates = SuratTemplate::with('persyaratan')->get();
        
        return view('admin.layanan-surat.pengaturan', compact('templates'));
    }

    /**
     * Hapus Arsip/Permohonan
     */
    public function destroyArsip($id)
    {
        $permohonan = SuratPermohonan::findOrFail($id);
        
        if ($permohonan->dokumen_pendukung) {
            Storage::disk('public')->delete($permohonan->dokumen_pendukung);
        }

        $permohonan->delete();

        return redirect()->back()->with('success', 'Data arsip permohonan berhasil dihapus.');
    }

    /**
     * Display daftar persyaratan page
     */
    public function daftarPersyaratan() 
    {
        $persyaratan = PersyaratanSurat::all();
        return view('admin.layanan-surat.daftar-persyaratan', compact('persyaratan'));
    }

    public function destroyTemplate($id)
    {
        $template = SuratTemplate::findOrFail($id);

        if ($template->file_template) {
            Storage::disk('public')->delete($template->file_template);
        }

        $template->delete();

        return back()->with('success', 'Template berhasil dihapus');
    }

    /**
     * MEMPROSES CETAK SURAT (Auto-fill data ke form cetak)
     */
    public function prosesCetak($permohonan_id)
    {
        // Ambil data permohonan beserta relasi penduduk dan template suratnya
        $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($permohonan_id);

        // Ambil data template surat yang terkait
        $templateSurat = $permohonan->suratTemplate;

        return view('admin.layanan-surat.cetak.proses', compact('permohonan', 'templateSurat'));
    }

    /**
     * MENGARAHKAN KE HALAMAN CETAK SURAT (LETTERS CREATE)
     * Beserta data auto-fill dari permohonan
     */
    public function createLetter(Request $request)
    {
        $permohonan_id = $request->query('permohonan_id');
        
        $permohonan = null;
        $selectedTemplate = null;

        if ($permohonan_id) {
            // Tarik data menggunakan relasi yang benar: 'suratTemplate'
            $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($permohonan_id);
            
            // Masukkan ke variabel $selectedTemplate agar dikenali oleh create.blade.php
            $selectedTemplate = $permohonan->suratTemplate;
        }

        return view('admin.layanan-surat.letters.create', compact('permohonan', 'selectedTemplate'));
    }
}