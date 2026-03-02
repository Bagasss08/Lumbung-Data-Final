<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Penduduk;
use App\Models\IdentitasDesa;
use App\Models\ArsipSurat; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth; 

class LetterController extends Controller
{
    /**
     * Tampilkan halaman utama Cetak Surat
     */
    public function index()
    {
        return $this->create();
    }

    /**
     * Tampilkan form dan kirim daftar template Word yang tersedia
     */
    public function create()
    {
        $templateDir = storage_path('app/public/templates');
        $templates = [];

        if (is_dir($templateDir)) {
            $files = File::files($templateDir);
            foreach ($files as $file) {
                if ($file->getExtension() === 'docx') {
                    $templates[] = $file->getFilename();
                }
            }
        }

        return view('admin.layanan-surat.letters.create', compact('templates'));
    }

    /**
     * Live Search NIK untuk memunculkan kotak saran di bawah input (AJAX)
     */
    public function liveSearchNik(Request $request)
    {
        try {
            $keyword = $request->keyword;

            if (empty($keyword)) {
                return response()->json([]);
            }

            $penduduk = Penduduk::where('nik', 'LIKE', $keyword . '%')
                ->orWhere('nama', 'LIKE', '%' . $keyword . '%') // Saya tambahkan agar bisa cari pakai nama juga
                ->limit(10)
                ->get(['nik', 'nama']); // Hanya ambil kolom yang diperlukan untuk saran

            return response()->json($penduduk);
        } catch (\Exception $e) {
            return response()->json([[
                'nik' => 'ERROR DB',
                'nama' => $e->getMessage()
            ]]);
        }
    }

    /**
     * Cari Data NIK via AJAX untuk mengisi Full Form (Tombol Cari/Klik Saran)
     */
    public function getDataByNik($nik)
    {
        try {
            $penduduk = Penduduk::where('nik', $nik)->first();
            $desa = IdentitasDesa::first();

            if ($penduduk) {
                return response()->json([
                    'success' => true,
                    'penduduk' => $penduduk,
                    'desa' => $desa
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Warga tidak ditemukan di database!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error Sistem/Database: ' . $e->getMessage()
            ], 500); // Set HTTP status 500 jika error server
        }
    }

    /**
     * Simpan data ke database (Jika ingin menyimpan riwayat di model Letter)
     */
    public function store(Request $request)
    {
        $validated = $this->validateLetterRequest($request);
        $letter = Letter::create($validated);

        return redirect()->route('admin.layanan-surat.cetak.show', $letter->id);
    }

    public function show($id)
    {
        $letter = Letter::findOrFail($id);
        return view('admin.layanansurat.letters.show', compact('letter')); 
    }

    public function download($id)
    {
        $letter = Letter::findOrFail($id);
        $pdf = Pdf::loadView('letters.pdf', compact('letter'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('surat-jalan-' . $letter->nama . '.pdf');
    }

    /**
     * GENERATE KE WORD (SECARA DINAMIS UNTUK SEMUA TEMPLATE) & SIMPAN KE ARSIP
     */
    public function generateFromTemplate(Request $request)
    {
        // 1. Validasi minimal
        $request->validate([
            'template_file' => 'required|string',
            'nama' => 'required|string',
            'nik' => 'nullable|string', 
        ]);

        $templateName = basename($request->input('template_file'));
        $templatePath = storage_path('app/public/templates/' . $templateName);

        if (!file_exists($templatePath)) {
            return back()->with('error', 'Template Word tidak ditemukan di server!');
        }

        // 2. Inisialisasi Template Processor
        $processor = new TemplateProcessor($templatePath);
        $processor->setMacroChars('[', ']');

        // 3. AMBIL SEMUA INPUT DARI FORM SECARA DINAMIS
        $inputs = $request->except(['_token', 'template_file']);

        // 4. LOOPING OTOMATIS: Ganti semua [nama_input] di Word dengan isinya
        foreach ($inputs as $key => $value) {
            $processor->setValue($key, $value ?? '');
        }

        // 5. Buat nama file unik dan folder arsip
        $fileName = 'Surat-' . 
            str_replace('.docx', '', $templateName) . '-' . 
            Str::slug($request->input('nama')) . '-' . 
            time() . '.docx'; 

        $arsipFolder = storage_path('app/public/arsip_surat');
        
        if (!is_dir($arsipFolder)) {
            File::makeDirectory($arsipFolder, 0755, true);
        }

        $outputPath = $arsipFolder . '/' . $fileName;

        // 6. Simpan file Word ke storage
        $processor->saveAs($outputPath);

        // 7. SIMPAN DATA KE DATABASE ARSIP_SURAT
        $jenisSurat = str_replace(['_', '-'], ' ', str_replace('.docx', '', $templateName));
        $tanggalSurat = $request->input('tgl_surat') ? \Carbon\Carbon::parse($request->input('tgl_surat'))->format('Y-m-d') : now()->format('Y-m-d');

        ArsipSurat::create([
            'nomor_surat'   => $request->input('format_nomor') ?? '-',
            'jenis_surat'   => ucwords($jenisSurat), 
            'nama_pemohon'  => $request->input('nama'),
            'nik'           => $request->input('nik') ?? '-',
            'tanggal_surat' => $tanggalSurat,
            'file_path'     => 'arsip_surat/' . $fileName, 
            'status'        => 'selesai', 
            'user_id'       => Auth::id() ?? 1, 
        ]);

        // 8. Download file
        return response()->download($outputPath);
    }

    private function validateLetterRequest(Request $request)
    {
        return $request->validate([
            'template_file'   => 'nullable|string',
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