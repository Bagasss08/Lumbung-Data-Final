<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Penduduk;
use App\Models\IdentitasDesa;
use App\Models\ArsipSurat; 
use App\Models\SuratTemplate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth; 

class LetterController extends Controller
{
    /**
     * Tampilkan daftar template surat
     */
    public function index()
    {
        $templates = SuratTemplate::where('status', 'aktif')->get();
        return view('admin.layanan-surat.letters.index', compact('templates'));
    }

    /**
     * Tampilkan form isian dinamis
     */
    public function create(Request $request)
    {
        $templateId = $request->query('id');
        $selectedTemplate = SuratTemplate::findOrFail($templateId);
        
        // Ekstrak variabel dari konten HTML untuk ditampilkan di form (jika perlu)
        // Logika ekstraksi variabel [tag] dari konten_template
        $variables = [];
        if ($selectedTemplate->konten_template) {
            preg_match_all('/\[([a-zA-Z0-9_]+)\]/i', $selectedTemplate->konten_template, $matches);
            $variables = array_unique($matches[1] ?? []);
        }

        return view('admin.layanan-surat.letters.create', compact('selectedTemplate', 'variables'));
    }

    /**
     * LANGKAH 2: Mengolah Form ke Preview TinyMCE
     * Menangani validasi nomor unik dan penggantian variabel [tag]
     */
    public function preview(Request $request)
{
    // 1. Validasi
    $request->validate([
        'format_nomor' => 'required|unique:arsip_surat,nomor_surat',
        'template_id'  => 'required|exists:surat_templates,id'
    ], [
        'format_nomor.required' => 'Nomor surat wajib diisi.',
        'format_nomor.unique'   => 'Nomor surat sudah terdaftar di arsip! Gunakan nomor lain.',
    ]);

    $template = SuratTemplate::findOrFail($request->template_id);
    $htmlContent = $template->konten_template; 

    // Ambil semua data input
    $formData = $request->except(['_token', 'template_id']);

    // 2. Penggantian variabel [tag]
    foreach ($formData as $key => $value) {
        // Gunakan str_replace atau preg_replace untuk mengganti [nama_tag]
        $htmlContent = str_ireplace('[' . $key . ']', $value ?? '', $htmlContent);
    }

    // 3. Kirim ke view preview
    // Pastikan route-nya: return view(...)
    return view('admin.layanan-surat.letters.preview', [
        'htmlContent' => $htmlContent,
        'formData'    => $formData,
        'template'    => $template
    ]);
}

    /**
     * LANGKAH 3: Cetak PDF Final dari hasil edit TinyMCE
     */
    public function generateFinal(Request $request)
    {
        try {
            $content = $request->final_content; // Konten HTML dari TinyMCE

            // 1. Generate PDF
            $pdf = Pdf::loadHTML($content)->setPaper('a4', 'portrait');
            
            // 2. Penamaan File unik
            $fileName = 'Surat-' . Str::slug($request->nama_pemohon ?? 'dokumen') . '-' . time() . '.pdf';
            $dbPath = 'arsip_surat/' . $fileName;
            $fullPath = storage_path('app/public/' . $dbPath);

            // 3. Simpan File Fisik
            if (!File::exists(storage_path('app/public/arsip_surat'))) {
                File::makeDirectory(storage_path('app/public/arsip_surat'), 0755, true);
            }
            File::put($fullPath, $pdf->output());

            // 4. Simpan ke Arsip (Sekarang aman dari Duplicate karena sudah divalidasi di preview)
            ArsipSurat::create([
                'nomor_surat'   => $request->nomor_surat,
                'jenis_surat'   => $request->jenis_surat, 
                'nama_pemohon'  => $request->nama_pemohon,
                'nik'           => $request->nik_pemohon ?? '-',
                'tanggal_surat' => $request->tanggal_surat ?? now()->format('Y-m-d'),
                'file_path'     => $dbPath, 
                'status'        => 'selesai', 
                'user_id'       => Auth::id() ?? 1, 
            ]);

            return $pdf->download($fileName);

        } catch (\Exception $e) {
            return redirect()->route('admin.layanan-surat.cetak.index')->with('error', 'Gagal Cetak: ' . $e->getMessage());
        }
    }

    // --- Helpers AJAX ---

    public function liveSearchNik(Request $request) {
        $keyword = $request->keyword;
        if (empty($keyword)) return response()->json([]);
        $penduduk = Penduduk::where('nik', 'LIKE', $keyword . '%')
                    ->orWhere('nama', 'LIKE', '%' . $keyword . '%')
                    ->limit(10)
                    ->get(['nik', 'nama']);
        return response()->json($penduduk);
    }

    public function getDataByNik($nik) {
        $penduduk = Penduduk::where('nik', $nik)->first();
        $desa = IdentitasDesa::first();
        if ($penduduk) {
            return response()->json(['success' => true, 'penduduk' => $penduduk, 'desa' => $desa]);
        }
        return response()->json(['success' => false, 'message' => 'Warga tidak ditemukan']);
    }

    // Alias untuk rute getPenduduk
    public function getPendudukData($nik) {
        return $this->getDataByNik($nik);
    }

    // --- CRUD Standard ---

    public function store(Request $request)
    {
        $validated = $this->validateLetterRequest($request);
        $letter = Letter::create($validated);
        return redirect()->route('admin.layanan-surat.cetak.show', $letter->id);
    }

    public function show($id)
    {
        $letter = Letter::find($id);
        if (!$letter) {
            $letter = ArsipSurat::findOrFail($id);
        }
        return view('admin.layanan-surat.letters.show', compact('letter')); 
    }

    public function cetak($id)
    {
        $arsip = ArsipSurat::findOrFail($id);
        $filePath = storage_path('app/public/' . $arsip->file_path);
        
        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        return back()->with('error', 'File PDF tidak ditemukan di server.');
    }

    private function validateLetterRequest(Request $request)
    {
        return $request->validate([
            'template_id'     => 'nullable|exists:surat_templates,id', // Diubah sedikit agar menyesuaikan form
            'kode_kabupaten'  => 'nullable|string|max:255',
            'nama_kabupaten'  => 'nullable|string|max:255',
            'kecamatan'       => 'nullable|string|max:255',
            'kantor_desa'     => 'nullable|string|max:255',
            'nama_desa'       => 'nullable|string|max:255',
            'alamat_kantor'   => 'nullable|string',
            'format_nomor'    => 'nullable|string|max:255',
            'kepala_desa'     => 'nullable|string|max:255',
            'kode_provinsi'   => 'nullable|string|max:255',
            'nama'            => 'required|string|max:255',
            'nik'             => 'required|string|max:50',
            'no_kk'           => 'nullable|string|max:50',
            'kepala_kk'       => 'nullable|string|max:255',
            'tempat_lahir'    => 'nullable|string|max:255',
            'tanggal_lahir'   => 'nullable|date',
            'jenis_kelamin'   => 'nullable|string|max:50',
            'Alamat'          => 'nullable|string',
            'kabupaten'       => 'nullable|string|max:255',
            'agama'           => 'nullable|string|max:50',
            'status'          => 'nullable|string|max:50',
            'Pendidikan'      => 'nullable|string|max:100',
            'pekerjaan'       => 'nullable|string|max:255',
            'warga_negara'    => 'nullable|string|max:50',
            'form_keterangan' => 'nullable|string',
            'mulai_berlaku'   => 'nullable|date',
            'tgl_akhir'       => 'nullable|date',
            'tgl_surat'       => 'nullable|date',
            'penandatangan'   => 'nullable|string|max:255',
            'nip_kepala_desa' => 'nullable|string|max:50',
        ]);
    }
}