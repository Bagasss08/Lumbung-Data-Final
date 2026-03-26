<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Penduduk;
use App\Models\IdentitasDesa;
use App\Models\ArsipSurat; 
use App\Models\SuratTemplate;
use App\Models\Keluarga; 
use App\Models\BukuPemerintah; // Model BukuPemerintah sudah dipanggil di sini
use App\Models\KlasifikasiSurat; 
use App\Models\Setting; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon;

class LetterController extends Controller
{
    /**
     * Menampilkan halaman Pengaturan Kop/Header Surat
     */
    public function pengaturan()
    {
        // Mengambil data setting dengan key 'header_surat'
        $setting = Setting::where('key', 'header_surat')->first();
        
        // Kirim ke view dalam bentuk array agar cocok dengan $setting['header_surat'] di Blade
        $settingArray = [
            'header_surat' => $setting ? $setting->value : null
        ];

        return view('admin.layanan-surat.pengaturan', ['setting' => $settingArray]);
    }

    /**
     * Menyimpan hasil editan TinyMCE dari halaman pengaturan
     */
    public function simpanPengaturan(Request $request)
    {
        $request->validate([
            'header_surat' => 'required'
        ]);

        Setting::updateOrCreate(
            ['key' => 'header_surat'],
            ['value' => $request->header_surat]
        );

        return redirect()->back()->with('success', 'Pengaturan Header Surat berhasil diperbarui!');
    }

    public function index()
    {
        $templates = SuratTemplate::with('klasifikasi')->where('status', 'aktif')->get();
        return view('admin.layanan-surat.letters.index', compact('templates'));
    }

    public function create(Request $request)
    {
        $templateId = $request->query('id');
        $selectedTemplate = SuratTemplate::with('klasifikasi')->findOrFail($templateId);
        
        $variables = [];
        if ($selectedTemplate->konten_template) {
            preg_match_all('/\[([a-zA-Z0-9_]+)\]/i', $selectedTemplate->konten_template, $matches);
            $variables = array_unique($matches[1] ?? []);
        }

        $autoNomorSurat = $this->generateAutoNomorSuratPreview($selectedTemplate);

        // Ambil data pemerintah desa untuk opsi penandatangan surat
        $pemerintah = BukuPemerintah::all();

        // Mengirimkan data $pemerintah ke view
        return view('admin.layanan-surat.letters.create', compact('selectedTemplate', 'variables', 'autoNomorSurat', 'pemerintah'));
    }

    public function preview(Request $request)
    {
        $template = SuratTemplate::with('klasifikasi')->findOrFail($request->template_id);

        if (!$request->filled('format_nomor')) {
            $autoNomor = $this->generateAutoNomorSuratPreview($template);
            $request->merge([
                'format_nomor' => $autoNomor,
                'nomor_surat'  => $autoNomor 
            ]);
        }

        $request->validate([
            'format_nomor' => 'required|unique:arsip_surat,nomor_surat',
            'template_id'  => 'required|exists:surat_templates,id'
        ], [
            'format_nomor.required' => 'Nomor surat wajib diisi.',
            'format_nomor.unique'   => 'Nomor surat sudah terdaftar di arsip! Gunakan nomor lain.',
        ]);

        $htmlContent = $template->konten_template; 
        $formData = $request->except(['_token', 'template_id']);

        // 1. Penggantian variabel inputan form biasa untuk Isi Surat
        foreach ($formData as $key => $value) {
            $htmlContent = str_ireplace('[' . $key . ']', $value ?? '', $htmlContent);
        }

        // =========================================================
        // 2. PROSES PENGGABUNGAN KOP SURAT (HEADER)
        // =========================================================
        $desa = IdentitasDesa::first();
        $setting = Setting::where('key', 'header_surat')->first(); 
        $templateHeader = $setting ? $setting->value : '';

        if ($desa && !empty($templateHeader)) {
            $cariHeader = [
                '[kabupaten]',
                '[kecamatan]',
                '[nama_desa]',
                '[provinsi]'
            ];
            $gantiHeader = [
                strtoupper($desa->kabupaten ?? 'KABUPATEN'),
                strtoupper($desa->kecamatan ?? 'KECAMATAN'),
                strtoupper($desa->nama_desa ?? 'DESA'),
                strtoupper($desa->provinsi ?? 'PROVINSI')
            ];
            
            // Tukar variabel teks pada header
            $templateHeader = str_ireplace($cariHeader, $gantiHeader, $templateHeader);
            
            // Gabungkan Header di atas konten surat
            $htmlContent = $templateHeader . '<div style="margin-top: 15px;"></div>' . $htmlContent;
        }

        // =========================================================
        // 3. AUTO LOGO DESA
        // =========================================================
        $htmlContent = preg_replace('/<img[^>]*src="\[logo_desa\]"[^>]*>/i', '[logo_desa]', $htmlContent);

        if (stripos($htmlContent, '[logo_desa]') !== false) {
            $logoHtml = ''; 

            if ($desa) {
                $namaFileLogo = $desa->logo ?? $desa->logo_desa ?? $desa->file_logo ?? null;

                if (!empty($namaFileLogo)) {
                    $logoPath = str_contains($namaFileLogo, 'logo-desa') 
                                ? storage_path('app/public/' . $namaFileLogo) 
                                : storage_path('app/public/logo-desa/' . $namaFileLogo);
                    
                    if (File::exists($logoPath)) {
                        $fileType = mime_content_type($logoPath);
                        $fileData = base64_encode(file_get_contents($logoPath));
                        $base64Image = 'data:' . $fileType . ';base64,' . str_replace(["\r", "\n"], '', $fileData);
                        $logoHtml = '<img src="' . $base64Image . '" style="width: 85px; height: auto; object-fit: contain;" />';
                    } else {
                        $logoHtml = '<strong style="color:red; font-size:12px;">[ERROR: LOGO TIDAK ADA]</strong>';
                    }
                } else {
                    $logoHtml = '<strong style="color:orange; font-size:12px;">[ERROR: LOGO KOSONG DI DB]</strong>';
                }
            } else {
                $logoHtml = '<strong style="color:purple; font-size:12px;">[ERROR: DATA DESA KOSONG]</strong>';
            }

            $htmlContent = str_ireplace('[logo_desa]', $logoHtml, $htmlContent);
        }

        // Mengambil data aparatur desa untuk jaga-jaga jika di view preview juga diperlukan
        $pemerintah = BukuPemerintah::all();

        return view('admin.layanan-surat.letters.preview', [
            'htmlContent' => $htmlContent,
            'formData'    => $formData,
            'template'    => $template,
            'pemerintah'  => $pemerintah
        ]);
    }

    public function generateFinal(Request $request)
    {
        try {
            $content = $request->final_content;
            $templateId = $request->template_id;
            $template = SuratTemplate::with('klasifikasi')->find($templateId);
            $nomorSuratFinal = $request->nomor_surat; 
            
            if ($template && $template->klasifikasi) {
                $klasifikasi = $template->klasifikasi;
                $klasifikasi->increment('jumlah'); 
                
                $kodeKlasifikasi = $klasifikasi->kode;
                $nomorUrutReal = str_pad($klasifikasi->jumlah, 3, '0', STR_PAD_LEFT);
                
                $desa = IdentitasDesa::first();
                $kodeWilayah = $desa ? ($desa->kode_wilayah ?? $desa->kode_desa ?? '22424') : '22424'; 
                
                $tahun = Carbon::now()->format('Y');
                $bulanRomawi = $this->getBulanRomawi(Carbon::now()->format('n'));

                $nomorSuratFinal = "{$kodeKlasifikasi}/{$nomorUrutReal}/{$kodeWilayah}/{$bulanRomawi}/{$tahun}";
            }

            $pdf = Pdf::loadHTML($content)->setPaper('a4', 'portrait');
            $fileName = 'Surat-' . Str::slug($request->nama_pemohon ?? 'dokumen') . '-' . time() . '.pdf';
            $dbPath = 'arsip_surat/' . $fileName;
            $fullPath = storage_path('app/public/' . $dbPath);

            if (!File::exists(storage_path('app/public/arsip_surat'))) {
                File::makeDirectory(storage_path('app/public/arsip_surat'), 0755, true);
            }
            File::put($fullPath, $pdf->output());

            ArsipSurat::create([
                'nomor_surat'   => $nomorSuratFinal, 
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
            $keluarga = Keluarga::whereHas('anggota', function($query) use ($nik) {
                $query->where('nik', $nik);
            })->with(['anggota'])->first();

            $dataKeluarga = null;
            if ($keluarga) {
                $dataKeluarga = [
                    'no_kk' => $keluarga->no_kk,
                    'alamat_kk' => $keluarga->alamat,
                    'kepala_keluarga' => $keluarga->getKepalaKeluarga() ? $keluarga->getKepalaKeluarga()->nama : '-',
                    'nik_kepala' => $keluarga->getKepalaKeluarga() ? $keluarga->getKepalaKeluarga()->nik : '-',
                    'daftar_anggota' => $keluarga->anggota 
                ];
            }

            return response()->json([
                'success' => true, 
                'penduduk' => $penduduk, 
                'desa' => $desa,
                'keluarga' => $dataKeluarga
            ]);
        }
        
        return response()->json(['success' => false, 'message' => 'Warga tidak ditemukan']);
    }

    public function getPendudukData($nik) {
        return $this->getDataByNik($nik);
    }

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
            'template_id'     => 'nullable|exists:surat_templates,id', 
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
            'jabatan'         => 'nullable|string|max:255',
        ]);
    }

    private function getBulanRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[(int)$bulan];
    }

    private function generateAutoNomorSuratPreview($template)
    {
        $kodeKlasifikasi = '000';
        $nomorUrutPreview = '001';

        if ($template && $template->klasifikasi) {
            $kodeKlasifikasi = $template->klasifikasi->kode;
            $simulasiJumlah = $template->klasifikasi->jumlah + 1;
            $nomorUrutPreview = str_pad($simulasiJumlah, 3, '0', STR_PAD_LEFT);
        } else {
            $kodeKlasifikasi = $template->kode_klasifikasi ?? 'S-41'; 
            $tahun = date('Y');
            $jumlahSurat = ArsipSurat::whereYear('created_at', $tahun)->count();
            $nomorUrutPreview = str_pad($jumlahSurat + 1, 3, '0', STR_PAD_LEFT); 
        }
        
        $desa = IdentitasDesa::first();
        $kodeWilayah = $desa ? ($desa->kode_wilayah ?? $desa->kode_desa ?? '22424') : '22424'; 
        
        $tahun = Carbon::now()->format('Y');
        $bulanRomawi = $this->getBulanRomawi(Carbon::now()->format('n'));
        
        return "{$kodeKlasifikasi}/{$nomorUrutPreview}/{$kodeWilayah}/{$bulanRomawi}/{$tahun}";
    }
}