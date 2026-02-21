<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TemplateSurat;

class LayananSuratController extends Controller {
    /**
     * Display pengaturan layanan surat page
     */
    public function pengaturan() {
        $templates = TemplateSurat::orderBy('created_at', 'desc')->get();
        return view('admin.layanan-surat.pengaturan', compact('templates'));
    }

    /**
     * Display cetak surat page
     */
    public function cetak() {
        return view('admin.layanan-surat.cetak');
    }

    /**
     * Display permohonan surat page
     */
    public function permohonan() {
        return view('admin.layanan-surat.permohonan');
    }

    /**
     * Display arsip surat page
     */
    public function arsip() {
        return view('admin.layanan-surat.arsip');
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
    public function storeTemplate(Request $request) {
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'jenis_surat' => 'nullable|string|max:255',
            'template_file' => 'required|file|mimes:doc,docx,pdf|max:5120',
            'status' => 'nullable|in:1',
        ]);

        $file = $request->file('template_file');
        $path = $file->store('public/surat_templates');

        $template = TemplateSurat::create([
            'tahun' => date('Y'),
            'nama_template' => $validated['nama_template'],
            'jenis_surat' => $validated['jenis_surat'] ?? null,
            // some older installations have a `jenis` column instead of `jenis_surat`
            'jenis' => $validated['jenis_surat'] ?? null,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'status' => isset($validated['status']) && $validated['status'] == '1',
        ]);

        return redirect()->route('admin.layanan-surat.pengaturan')
            ->with('success', 'Template surat berhasil disimpan');
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
    public function updateTemplate(Request $request, $id) {
        // Validasi data
        $validated = $request->validate([
            'nama_template' => 'required|string|max:255',
            'jenis_surat' => 'required|string',
            'konten_template' => 'required|string',
        ]);

        // TODO: Update template di database
        // Example: TemplateSurat::findOrFail($id)->update($validated);

        return redirect()->route('admin.layanan-surat.pengaturan')
            ->with('success', 'Template surat berhasil diperbarui');
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
}
