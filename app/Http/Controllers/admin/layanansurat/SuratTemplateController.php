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
        $templates = SuratTemplate::with(['persyaratan', 'klasifikasi'])->latest()->get();

        return view('admin.surat.template-index', compact('templates'));
    }


    public function create()
    {
        $persyaratans = PersyaratanSurat::all();
        $klasifikasis = KlasifikasiSurat::where('status', true)->get();

        return view('admin.surat.template-create', compact('persyaratans', 'klasifikasis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'lampiran'         => 'nullable|string|max:255',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'status'           => 'nullable|in:aktif,noaktif',
            'konten_template'  => 'required',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'exists:persyaratan_surats,id',
        ]);

        $template = SuratTemplate::create([
            'judul'            => $request->judul,
            'lampiran'         => $request->lampiran,
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'status'           => $request->status ?? 'aktif',
            'konten_template'  => $request->konten_template,
        ]);

        if ($request->filled('persyaratan')) {
            $template->persyaratan()->sync($request->persyaratan);
        }

        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.layanan-surat.template-surat.index')
            ->with('success', 'Template berhasil disimpan.');
    }


    public function edit($id)
    {
        $template = SuratTemplate::with('persyaratan')->findOrFail($id);

        $persyaratans = PersyaratanSurat::orderBy('nama')->get();
        $klasifikasis = KlasifikasiSurat::where('status', true)->get();

        return view('admin.surat.template-edit', compact('template', 'persyaratans', 'klasifikasis'));
    }


    public function update(Request $request, $id)
    {
        $template = SuratTemplate::findOrFail($id);

        $request->validate([
            'judul'            => 'required|string|max:255',
            'lampiran'         => 'nullable|string|max:255',
            'kode_klasifikasi' => 'nullable|string|max:100',
            'status'           => 'required|in:aktif,noaktif',
            'konten_template'  => 'required',
            'persyaratan'      => 'nullable|array',
            'persyaratan.*'    => 'exists:persyaratan_surats,id',
        ]);

        $template->update([
            'judul'            => $request->judul,
            'lampiran'         => $request->lampiran,
            'kode_klasifikasi' => $request->kode_klasifikasi,
            'status'           => $request->status,
            'konten_template'  => $request->konten_template,
        ]);

        $template->persyaratan()->sync($request->persyaratan ?? []);

        $this->generateWordFile($template, $request->konten_template);

        return redirect()->route('admin.layanan-surat.template-surat.index')
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

        $logoPath = '';

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

            $htmlContent = str_replace(
                '[logo_desa]',
                $logoPath,
                $htmlContent
            );
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

        $htmlContent = str_ireplace(
            '<table',
            '<table style="border:none;border-collapse:collapse;"',
            $htmlContent
        );

        $htmlContent = str_ireplace(
            '<td',
            '<td style="border:none;"',
            $htmlContent
        );

        $htmlContent = str_ireplace(
            '<th',
            '<th style="border:none;"',
            $htmlContent
        );


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

        $safeJudul = Str::slug($template->judul);

        $fileName = $safeJudul . '-' . $template->id . '.docx';

        $folderPath = storage_path('app/public/templates');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        $filePath = $folderPath . '/' . $fileName;


        $writer = IOFactory::createWriter($phpWord, 'Word2007');

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
}