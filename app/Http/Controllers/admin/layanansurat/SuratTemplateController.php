<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Models\SuratTemplate;
use App\Models\PersyaratanSurat;
use App\Models\KlasifikasiSurat;
use App\Models\IdentitasDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use App\Http\Controllers\Controller;

class SuratTemplateController extends Controller
{

    public function index()
    {
        // Eager load 'persyaratan' dan 'klasifikasi' agar relasi langsung tersedia di view
        $templates = SuratTemplate::with(['persyaratan', 'klasifikasi'])->latest()->get();

        return view('admin.surat.template-index', compact('templates'));
    }


    public function create()
    {
        $persyaratans = PersyaratanSurat::all();
        // Ambil semua klasifikasi yang aktif (status = 1 karena tipe tinyint(1))
        $klasifikasis = KlasifikasiSurat::where('status', 1)->get();

        return view('admin.surat.template-create', compact('persyaratans', 'klasifikasis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul'                => 'required|string|max:255',
            'lampiran'             => 'nullable|string|max:255',
            'klasifikasi_surat_id' => 'required|exists:klasifikasi_surats,id',
            'status'               => 'nullable|in:aktif,noaktif',
            'konten_template'      => 'required',
            'persyaratan'          => 'nullable|array',
            'persyaratan.*'        => 'exists:persyaratan_surats,id',
        ]);

        $template = SuratTemplate::create([
            'judul'                => $request->judul,
            'lampiran'             => $request->lampiran,
            'klasifikasi_surat_id' => $request->klasifikasi_surat_id,
            'status'               => $request->status ?? 'aktif',
            'konten_template'      => $request->konten_template,
        ]);

        if ($request->filled('persyaratan')) {
            $template->persyaratan()->sync($request->persyaratan);
        }

        // Generate file Word secara otomatis
        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.layanan-surat.template-surat.index')
            ->with('success', 'Template berhasil disimpan.');
    }


    public function edit($id)
    {
        $template = SuratTemplate::with(['persyaratan', 'klasifikasi'])->findOrFail($id);

        $persyaratans = PersyaratanSurat::orderBy('nama')->get();
        // Ambil semua klasifikasi aktif (status = 1)
        $klasifikasis = KlasifikasiSurat::where('status', 1)->get();

        return view('admin.surat.template-edit', compact('template', 'persyaratans', 'klasifikasis'));
    }


    public function update(Request $request, $id)
    {
        $template = SuratTemplate::findOrFail($id);

        $request->validate([
            'judul'                => 'required|string|max:255',
            'lampiran'             => 'nullable|string|max:255',
            'klasifikasi_surat_id' => 'required|exists:klasifikasi_surats,id',
            'status'               => 'required|in:aktif,noaktif',
            'konten_template'      => 'required',
            'persyaratan'          => 'nullable|array',
            'persyaratan.*'        => 'exists:persyaratan_surats,id',
        ]);

        $template->update([
            'judul'                => $request->judul,
            'lampiran'             => $request->lampiran,
            'klasifikasi_surat_id' => $request->klasifikasi_surat_id,
            'status'               => $request->status,
            'konten_template'      => $request->konten_template,
        ]);

        // Update relasi pivot persyaratan
        if ($request->has('persyaratan')) {
            $template->persyaratan()->sync($request->persyaratan);
        } else {
            $template->persyaratan()->detach();
        }

        // Hapus file lama jika ada
        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        // Generate ulang file Word dengan konten baru
        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.layanan-surat.template-surat.index')
            ->with('success', 'Template berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $template = SuratTemplate::findOrFail($id);

        if ($template->file_path && Storage::disk('public')->exists($template->file_path)) {
            Storage::disk('public')->delete($template->file_path);
        }

        $template->persyaratan()->detach();
        $template->delete();

        return redirect()->route('admin.layanan-surat.template-surat.index')
            ->with('success', 'Template berhasil dihapus.');
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE FILE WORD
    |--------------------------------------------------------------------------
    */
    private function generateWordFile($template, $htmlContent)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA IDENTITAS DESA
        |--------------------------------------------------------------------------
        */
        $identitas = IdentitasDesa::first();
        $logoPath  = '';

        if ($identitas && $identitas->logo_desa) {
            $logoPath = storage_path('app/public/logo-desa/' . $identitas->logo_desa);
            if (!file_exists($logoPath)) {
                $logoPath = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GANTI VARIABLE TEMPLATE
        |--------------------------------------------------------------------------
        */
        if ($logoPath) {
            $htmlContent = str_replace('[logo_desa]', $logoPath, $htmlContent);
        }

        /*
        |--------------------------------------------------------------------------
        | FIX HTML AGAR XML VALID
        |--------------------------------------------------------------------------
        */
        $htmlContent = str_ireplace('<br>', '<br/>', $htmlContent);
        $htmlContent = str_ireplace('<hr>', '<hr/>', $htmlContent);
        $htmlContent = preg_replace('/<img([^>]*)>/', '<img$1 />', $htmlContent);
        $htmlContent = str_replace('&nbsp;', ' ', $htmlContent);

        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN BORDER TABLE
        |--------------------------------------------------------------------------
        */
        $htmlContent = preg_replace('/border="[^"]*"/', '', $htmlContent);
        $htmlContent = str_ireplace('<table', '<table style="border:none;border-collapse:collapse;"', $htmlContent);
        $htmlContent = str_ireplace('<td',    '<td style="border:none;"', $htmlContent);
        $htmlContent = str_ireplace('<th',    '<th style="border:none;"', $htmlContent);

        /*
        |--------------------------------------------------------------------------
        | MASUKKAN HTML KE WORD
        |--------------------------------------------------------------------------
        */
        Html::addHtml($section, $htmlContent, false, false);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN FILE WORD
        |--------------------------------------------------------------------------
        */
        $safeJudul  = Str::slug($template->judul);
        $fileName   = $safeJudul . '-' . $template->id . '.docx';
        $folderPath = storage_path('app/public/templates');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $filePath = $folderPath . '/' . $fileName;
        $writer   = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */
        $template->update([
            'file_path' => 'templates/' . $fileName,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PENGATURAN
    |--------------------------------------------------------------------------
    */
    public function pengaturan()
    {
        $setting = [
            'kop_surat'     => 'Pemerintah Desa Maju Jaya',
            'format_nomor'  => '[KODE]/[NO]/[BULAN]/[TAHUN]',
            'nama_ttd'      => 'Budi Santoso, S.E.'
        ];

        return view('admin.surat.pengaturan', compact('setting'));
    }

    public function simpanPengaturan(Request $request)
    {
        $request->validate([
            'kop_surat'    => 'required|string|max:255',
            'format_nomor' => 'required|string|max:100',
            'nama_ttd'     => 'required|string|max:255',
        ]);

        // Logika simpan ke database di sini...

        return redirect()
            ->route('admin.surat.pengaturan')
            ->with('success', 'Pengaturan template surat berhasil diperbarui!');
    }
}