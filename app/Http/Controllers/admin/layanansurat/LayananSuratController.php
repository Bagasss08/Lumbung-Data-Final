<?php

namespace App\Http\Controllers\Admin\layanansurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TemplateSurat;
use App\Models\JenisSurat;
use App\Models\SuratPermohonan;

class LayananSuratController extends Controller {
    /**
     * Display pengaturan layanan surat page
     */
    public function pengaturan()
{
    $templates = TemplateSurat::with('jenisSurat')->get();
    // INI KODE YANG BENAR
    $jenisSurat = JenisSurat::where('is_active', true)->get();

    return view('admin.layanan-surat.pengaturan', compact(
        'templates',
        'jenisSurat'
    ));
    }

    /**
     * Display cetak surat page
     */
    public function cetak() {
        $templates = TemplateSurat::with('jenisSurat')->get();

        return view('admin.layanan-surat.cetak', compact('templates'));
    }

/**
     * Display permohonan surat page (Index Table)
     */
    public function permohonan(Request $request) 
    {
        // Panggil relasi untuk mencegah N+1 Query
        $query = SuratPermohonan::with(['penduduk', 'jenisSurat']);

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

        // Ambil data pagination (default 25 sesuai gambar, bisa diubah via request)
        $perPage = $request->get('per_page', 25);
        $permohonan = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.layanan-surat.permohonan.index', compact('permohonan'));
    }

    /**
     * Show detail permohonan surat
     */
    public function showPermohonan($id)
    {
        $permohonan = SuratPermohonan::with(['penduduk', 'jenisSurat'])->findOrFail($id);
        
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
        // 1. Inisiasi Query Data (Relasi ke Penduduk & JenisSurat)
        $query = SuratPermohonan::with(['penduduk', 'jenisSurat']);

        // 2. Filter Berdasarkan Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // 3. Filter Berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // 4. Filter Berdasarkan Jenis Surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat_id', $request->jenis_surat);
        }

        // 5. Fitur Search (Pencarian Teks)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('penduduk', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // 6. Hitung Statistik untuk Kartu di Atas (Summary Cards)
        $statPermohonan = SuratPermohonan::whereNotIn('status', ['sudah diambil', 'dibatalkan'])->count();
        $statArsip = SuratPermohonan::where('status', 'sudah diambil')->count(); // Yang sudah selesai
        $statDitolak = SuratPermohonan::where('status', 'dibatalkan')->count();

        // 7. Ambil Data dengan Pagination
        $perPage = $request->get('per_page', 25);
        $arsip = $query->orderBy('updated_at', 'desc')->paginate($perPage)->withQueryString();

        // 8. Data Pendukung untuk Dropdown Filter
        $jenisSuratList = JenisSurat::all();
        // Generate list 5 tahun terakhir
        $tahunList = range(date('Y'), date('Y') - 5); 

        return view('admin.layanan-surat.arsip', compact(
            'arsip', 'statPermohonan', 'statArsip', 'statDitolak', 'jenisSuratList', 'tahunList'
        ));
    }

    /**
     * Hapus Arsip/Permohonan (Aksi Tombol Tong Sampah)
     */
    public function destroyArsip($id)
    {
        $permohonan = SuratPermohonan::findOrFail($id);
        
        // Hapus file lampiran jika ada
        if ($permohonan->dokumen_pendukung) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($permohonan->dokumen_pendukung);
        }

        $permohonan->delete();

        return redirect()->back()->with('success', 'Data arsip permohonan berhasil dihapus secara permanen.');
    }

    /**
     * Display daftar persyaratan page
     */
    public function daftarPersyaratan() {
        return view('admin.layanan-surat.daftar-persyaratan');
    }

    // ============================================
    // PENGATURAN METHODS
    // ============================================

    /**
     * Store template settings
     */
    public function storeTemplate(Request $request)
{
    $validated = $request->validate([
        'jenis_surat_id' => 'required|exists:jenis_surat,id',
        'nama_template'  => 'required|string|max:255',
        'versi_template' => 'required|string|max:100',
        'file_template'  => 'nullable|file|mimes:doc,docx,pdf|max:5120',
        'tanggal_berlaku'=> 'nullable|date',
        'is_active'      => 'nullable|boolean',
    ]);

    $filePath = null;

    if ($request->hasFile('file_template')) {
        $filePath = $request->file('file_template')
                            ->store('Surat/Template', 'public');
    }

    TemplateSurat::create([
        'jenis_surat_id' => $validated['jenis_surat_id'],
        'nama_template'  => $validated['nama_template'],
        'versi_template' => $validated['versi_template'],
        'file_template'  => $filePath, // ← ini WAJIB sama dengan nama kolom
        'tanggal_berlaku'=> $validated['tanggal_berlaku'] ?? null,
        'is_active'      => $request->has('is_active'),
    ]);

    return back()->with('success', 'Template berhasil disimpan');
}


    /**
     * Download / preview template file
     */
    public function downloadTemplate($id) {
        $template = TemplateSurat::findOrFail($id);
        $pathsToTry = [
            storage_path('app/' . $template->path),
            storage_path('app/private/' . $template->path),
            storage_path('app/public/' . basename($template->path)),
            storage_path('app/' . basename($template->path)),
        ];

        $fullPath = null;
        foreach ($pathsToTry as $p) {
            if ($p && file_exists($p)) {
                $fullPath = $p;
                break;
            }
        }

        if (!$fullPath) {
            abort(404, 'File not found.');
        }

        $mime = $template->mime ?? mime_content_type($fullPath);

        // Set disposition: inline for PDF, image; attachment for others (docx, etc.)
        $inlineTypes = ['application/pdf', 'image/png', 'image/jpeg', 'image/jpg'];
        $disposition = in_array($mime, $inlineTypes) ? 'inline' : 'attachment';

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Content-Disposition' => $disposition . '; filename="' . $template->original_name . '"',
        ]);
    }

    /**
     * Update template settings
     */
    public function updateTemplate(Request $request, $id)
{
    $template = TemplateSurat::findOrFail($id);

    $validated = $request->validate([
        'jenis_surat_id' => 'required|exists:jenis_surat,id',
        'nama_template'  => 'required|string|max:255',
        'versi_template' => 'required|string|max:100',
        'file_template'  => 'nullable|file|mimes:doc,docx,pdf|max:5120',
        'tanggal_berlaku'=> 'nullable|date',
        'is_active'      => 'nullable|in:1',
    ]);

    // Jika upload file baru
    if ($request->hasFile('file_template')) {

        if ($template->file_path) {
            Storage::delete($template->file_path);
        }

        $path = $request->file('file_template')
                        ->store('public/Surat/Template');

        $validated['file_path'] = $path;
        $validated['original_name'] = $request->file('file_template')->getClientOriginalName();
    }

    $validated['is_active'] = $request->has('is_active');

    $template->update($validated);

    return redirect()
        ->route('admin.layanan-surat.pengaturan')
        ->with('success', 'Template berhasil diperbarui');
}

    // ============================================
    // CETAK METHODS
    // ============================================

    /**
     * Generate and print letter
     */
    public function printSurat(Request $request) {
        $validated = $request->validate([
            'id_permohonan' => 'required|integer',
            'jenis_surat' => 'required|string',
        ]);

        // TODO: Generate PDF surat
        // Example:
        // $data = PermohonanSurat::with('penduduk')->findOrFail($validated['id_permohonan']);
        // $pdf = PDF::loadView('admin.layanan-surat.template-'.$validated['jenis_surat'], compact('data'));
        // return $pdf->download('surat-'.$validated['jenis_surat'].'.pdf');

        return redirect()->route('admin.layanan-surat.cetak')
            ->with('info', 'Fitur cetak surat dalam pengembangan');
    }

    // ============================================
    // PERMOHONAN METHODS
    // ============================================

    /**
     * Store new letter request
     */
    public function storePermohonan(Request $request) {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_surat' => 'required|string',
            'keperluan' => 'required|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // TODO: Simpan permohonan ke database
        // Example: PermohonanSurat::create($validated);

        return redirect()->route('admin.layanan-surat.permohonan')
            ->with('success', 'Permohonan surat berhasil diajukan');
    }

    /**
     * Approve letter request
     */
    public function approvePermohonan($id) {
        // TODO: Update status permohonan
        // Example: PermohonanSurat::findOrFail($id)->update(['status' => 'disetujui']);

        return redirect()->route('admin.layanan-surat.permohonan')
            ->with('success', 'Permohonan surat berhasil disetujui');
    }

    /**
     * Reject letter request
     */
    public function rejectPermohonan($id) {
        // TODO: Update status permohonan
        // Example: PermohonanSurat::findOrFail($id)->update(['status' => 'ditolak']);

        return redirect()->route('admin.layanan-surat.permohonan')
            ->with('success', 'Permohonan surat berhasil ditolak');
    }

    // ============================================
    // ARSIP METHODS
    // ============================================

    /**
     * Archive letter
     */
    public function archiveSurat($id) {
        // TODO: Pindahkan surat ke arsip
        // Example: Surat::findOrFail($id)->update(['status' => 'arsip']);

        return redirect()->route('admin.layanan-surat.arsip')
            ->with('success', 'Surat berhasil diarsipkan');
    }

    /**
     * Search archived letters
     */
    public function searchArsip(Request $request) {
        $search = $request->get('search');
        // TODO: Implement search functionality
        // Example: $surat = ArsipSurat::where('nomor_surat', 'like', '%'.$search.'%')->get();

        return view('admin.layanan-surat.arsip', compact('surat'));
    }

    // ============================================
    // DAFTAR PERSYARATAN METHODS
    // ============================================

    /**
     * Store new requirements
     */
    public function storePersyaratan(Request $request) {
        $validated = $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'persyaratan' => 'required|string',
        ]);

        // TODO: Simpan persyaratan ke database
        // Example: PersyaratanSurat::create($validated);

        return redirect()->route('admin.layanan-surat.daftar-persyaratan')
            ->with('success', 'Persyaratan surat berhasil ditambahkan');
    }

    /**
     * Update requirements
     */
    public function updatePersyaratan(Request $request, $id) {
        $validated = $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'persyaratan' => 'required|string',
        ]);

        // TODO: Update persyaratan di database
        // Example: PersyaratanSurat::findOrFail($id)->update($validated);

        return redirect()->route('admin.layanan-surat.daftar-persyaratan')
            ->with('success', 'Persyaratan surat berhasil diperbarui');
    }

    /**
     * Delete requirements
     */
    public function destroyPersyaratan($id) {
        // TODO: Hapus persyaratan dari database
        // Example: PersyaratanSurat::findOrFail($id)->delete();

        return redirect()->route('admin.layanan-surat.daftar-persyaratan')
            ->with('success', 'Persyaratan surat berhasil dihapus');
    }

    // ============================================
    // EXPORT METHODS
    // ============================================

    /**
     * Export data to Excel
     */
    public function export($type) {
        // TODO: Implement export functionality
        // Example using Laravel Excel:
        // return Excel::download(new LayananSuratExport($type), "layanan-surat-{$type}.xlsx");

        return redirect()->back()
            ->with('info', 'Fitur export dalam pengembangan');
    }

    /**
     * Print report
     */
    public function print($type) {
        // TODO: Generate PDF report
        // Example:
        // $pdf = PDF::loadView("admin.layanan-surat.print-{$type}");
        // return $pdf->stream("laporan-{$type}.pdf");

        return redirect()->back()
            ->with('info', 'Fitur cetak dalam pengembangan');
    }

    public function destroyTemplate($id)
{
    $template = TemplateSurat::findOrFail($id);

    if ($template->file_template) {
        Storage::disk('public')->delete($template->file_template);
    }

    $template->delete();

    return back()->with('success', 'Template berhasil dihapus');
}
    
}
