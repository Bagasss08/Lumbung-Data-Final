<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Models\SuratTemplate;
use App\Models\PersyaratanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // 🔥 WAJIB DITAMBAHKAN UNTUK FORMAT NAMA FILE
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

use App\Http\Controllers\Controller;

class SuratTemplateController extends Controller
{
    public function index()
    {
        $templates = SuratTemplate::with('persyaratan')->latest()->get();
        // Menambahkan prefix 'admin.' pada view
        return view('admin.surat.template-index', compact('templates'));
    }

    public function create()
    {
        $persyaratans = PersyaratanSurat::orderBy('nama')->get();
        // Menambahkan prefix 'admin.' pada view
        return view('admin.surat.template-create', compact('persyaratans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'format_nomor'     => 'nullable|string|max:255',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'status'           => 'nullable|in:aktif,noaktif',
            'konten_template'  => 'required',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'exists:persyaratan_surats,id',
        ]);

        // 1. Simpan template ke Database
        $template = SuratTemplate::create([
            'judul'            => $request->judul,
            'format_nomor'     => $request->format_nomor,
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'status'           => $request->status ?? 'aktif',
            'konten_template'  => $request->konten_template,
        ]);

        // 2. Simpan relasi persyaratan
        if ($request->filled('persyaratan')) {
            $template->persyaratan()->sync($request->persyaratan);
        }

        // 3. Generate DOCX menggunakan helper
        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.layanan-surat.template-surat.index')
            ->with('success', 'Template berhasil disimpan.');
    }

    public function edit($id)
    {
        $template = SuratTemplate::with('persyaratan')->findOrFail($id);
        $persyaratans = PersyaratanSurat::orderBy('nama')->get();

        // Menambahkan prefix 'admin.' pada view
        return view('admin.surat.template-edit', compact('template', 'persyaratans'));
    }

    public function update(Request $request, $id)
    {
        $template = SuratTemplate::findOrFail($id);

        $request->validate([
            'judul'            => 'required|string|max:255',
            'format_nomor'     => 'nullable|string|max:255',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'status'           => 'required|in:aktif,noaktif',
            'konten_template'  => 'required',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'exists:persyaratan_surats,id',
        ]);

        // Update database
        $template->update([
            'judul'            => $request->judul,
            'format_nomor'     => $request->format_nomor,
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'status'           => $request->status,
            'konten_template'  => $request->konten_template,
        ]);

        // Update relasi
        $template->persyaratan()->sync($request->persyaratan ?? []);

        // Re-generate DOCX karena konten berubah
        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.template-surat.index')
            ->with('success', 'Template berhasil diupdate.');
    }

    public function destroy($id)
    {
        $template = SuratTemplate::findOrFail($id);

        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->persyaratan()->detach();
        $template->delete();

        return redirect()->route('admin.template-surat.index')
            ->with('success', 'Template berhasil dihapus.');
    }

    /**
     * Fungsi helper untuk generate file Word
     */
    private function generateWordFile($template, $htmlContent)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // 1. Ubah tag HTML5 menjadi penulisan gaya XML
        $htmlContent = str_ireplace(
            ['<br>', '<hr>', '<img>'], 
            ['<br/>', '<hr/>', '<img/>'], 
            $htmlContent
        );

        // 2. 🔥 PERBAIKAN BORDER: Gunakan Regex agar atribut tidak terduplikasi.
        // Hapus atribut border bawaan TinyMCE agar tidak dobel.
        $htmlContent = preg_replace('/border="[^"]*"/', '', $htmlContent);
        
        // Tambahkan style border:none ke semua tag table, th, dan td
        $htmlContent = str_ireplace('<table', '<table style="border: none; border-collapse: collapse;"', $htmlContent);
        $htmlContent = str_ireplace('<td', '<td style="border: none;"', $htmlContent);
        $htmlContent = str_ireplace('<th', '<th style="border: none;"', $htmlContent);

        // 3. Render HTML ke dalam Word
        Html::addHtml($section, $htmlContent, false, false);

        // 4. FORMAT NAMA FILE BARU
        $safeJudul = \Illuminate\Support\Str::slug($template->judul); // Pastikan pakai \ sebelum Illuminate
        $fileName = $safeJudul . '-' . $template->id . '.docx';
        $folderPath = storage_path('app/public/templates');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $filePath = $folderPath . '/' . $fileName;

        // 5. Hapus file lama jika ada (saat update)
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            if ($template->file_path !== 'templates/' . $fileName) {
                Storage::disk('public')->delete($template->file_path);
            }
        }

        // 6. Simpan file baru
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        // 7. Update path file ke database
        $template->update([
            'file_path' => 'templates/' . $fileName,
        ]);
    }
}