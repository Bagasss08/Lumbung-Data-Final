<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Penduduk;
use App\Models\IdentitasDesa;
use App\Models\ArsipSurat;
use App\Models\SuratTemplate;
use App\Models\Keluarga; 
use App\Models\PerangkatDesa;
use App\Models\KlasifikasiSurat; 
use App\Models\Setting; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LetterController extends Controller 
{
    /**
     * Menampilkan halaman Pengaturan Kop/Header Surat
     */
    public function pengaturan()
    {
        $setting = Setting::where('key', 'header_surat')->first();
        
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
        
        // Pengecekan 1: Klasifikasi Surat
        if (is_null($selectedTemplate->klasifikasi_surat_id)) {
            return redirect()->back()->with('error', "Gagal! Template surat '{$selectedTemplate->nama_surat}' belum memiliki Kode/Klasifikasi. Silakan atur klasifikasinya terlebih dahulu di menu Pengaturan Surat.");
        }

        // --- TAMBAHKAN PENGECEKAN 2: Perangkat Desa ---
        if (PerangkatDesa::aktif()->count() === 0) {
            return redirect()->back()->with('error', "Gagal! Data Aparatur/Perangkat Desa masih kosong. Surat membutuhkan penandatangan. Silakan isi data di menu Pemerintah Desa terlebih dahulu.");
        }
        // ----------------------------------------------

        $variables = [];
        if ($selectedTemplate->konten_template) {
            preg_match_all('/\[([a-zA-Z0-9_]+)\]/i', $selectedTemplate->konten_template, $matches);
            $variables = array_unique($matches[1] ?? []);
        }

        $autoNomorSurat = $this->generateAutoNomorSuratPreview($selectedTemplate);
        $pemerintah = PerangkatDesa::aktif()->orderBy('urutan')->get();

        return view('admin.layanan-surat.letters.create', compact('selectedTemplate', 'variables', 'autoNomorSurat', 'pemerintah'));
    }

    public function preview(Request $request)
    {
        $template = SuratTemplate::with('klasifikasi')->findOrFail($request->template_id);

        // Pengecekan 1: Klasifikasi Surat
        if (is_null($template->klasifikasi_surat_id)) {
            return redirect()->back()->with('error', "Gagal! Template surat '{$template->nama_surat}' belum memiliki Kode/Klasifikasi. Silakan atur klasifikasinya terlebih dahulu.");
        }

        // --- TAMBAHKAN PENGECEKAN 2: Perangkat Desa ---
        if (PerangkatDesa::aktif()->count() === 0) {
            return redirect()->back()->with('error', "Gagal! Data Aparatur/Perangkat Desa masih kosong. Silakan isi data di menu Pemerintah Desa terlebih dahulu.");
        }
        // ----------------------------------------------

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
            'format_nomor.unique'   => 'Nomor surat sudah terdaftar di arsip!',
        ]);

        $htmlContent = $template->konten_template; 
        $formData = $request->except(['_token', 'template_id']);

        // =========================================================
        // 1. AUTO GENERATE SEMUA DATA PENDUDUK (SISTEM BACKEND)
        // Ini memastikan jika ada tag seperti [nama_ayah], [umur], dll 
        // di template tapi tidak dikirim via form, sistem tetap mengisinya!
        // =========================================================
        $dbData = [];
        $nikPemohon = $request->nik_pemohon ?? $request->nik ?? $request->no_nik;
        
        if (!empty($nikPemohon)) {
            $penduduk = Penduduk::with([
                'agama', 'pendidikanKk', 'pekerjaan', 'statusKawin', 
                'golonganDarah', 'warganegara', 'shdk', 'keluarga'
            ])->where('nik', $nikPemohon)->first();

            if ($penduduk) {
                // Semua kemungkinan data dari model yang mungkin dijadikan tag
                $dbData = [
                    'nama' => $penduduk->nama,
                    'nik' => $penduduk->nik,
                    'tempat_lahir' => $penduduk->tempat_lahir,
                    'tanggal_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d-m-Y') : '',
                    'tgl_lahir' => $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d-m-Y') : '',
                    'waktu_lahir' => $penduduk->waktu_lahir,
                    'umur' => $penduduk->umur,
                    'jenis_kelamin' => $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan',
                    'kelamin' => $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan',
                    'jk' => $penduduk->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan',
                    'agama' => $penduduk->agama->nama ?? $penduduk->agama_lama ?? '',
                    'pekerjaan' => $penduduk->pekerjaan->nama ?? $penduduk->pekerjaan_lama ?? '',
                    'pendidikan' => $penduduk->pendidikanKk->nama ?? $penduduk->pendidikan_lama ?? '',
                    'status_kawin' => $penduduk->statusKawin->nama ?? $penduduk->status_kawin_lama ?? '',
                    'status_perkawinan' => $penduduk->statusKawin->nama ?? $penduduk->status_kawin_lama ?? '',
                    'golongan_darah' => $penduduk->golonganDarah->nama ?? $penduduk->golongan_darah_lama ?? '',
                    'warga_negara' => $penduduk->warganegara->nama ?? $penduduk->kewarganegaraan_lama ?? 'WNI',
                    'alamat' => $penduduk->alamat,
                    'no_telp' => $penduduk->no_telp,
                    'email' => $penduduk->email,
                    'nama_ayah' => $penduduk->nama_ayah,
                    'nama_ibu' => $penduduk->nama_ibu,
                    'nik_ayah' => $penduduk->nik_ayah,
                    'nik_ibu' => $penduduk->nik_ibu,
                    'no_kk' => $penduduk->keluarga->no_kk ?? '',
                    'kepala_kk' => $penduduk->keluarga->kepalaKeluarga->nama ?? '',
                    'kepala_keluarga' => $penduduk->keluarga->kepalaKeluarga->nama ?? '',
                    'nik_kepala' => $penduduk->keluarga->kepalaKeluarga->nik ?? '',
                    'no_asuransi' => $penduduk->no_asuransi,
                    'akta_lahir' => $penduduk->akta_lahir,
                    'akta_perkawinan' => $penduduk->akta_perkawinan,
                    'akta_perceraian' => $penduduk->akta_perceraian,
                    'tanggal_perkawinan' => $penduduk->tanggal_perkawinan ? $penduduk->tanggal_perkawinan->format('d-m-Y') : '',
                    'tanggal_perceraian' => $penduduk->tanggal_perceraian ? $penduduk->tanggal_perceraian->format('d-m-Y') : '',
                    'tempat_dilahirkan' => $penduduk->tempat_dilahirkan,
                    'jenis_kelahiran' => $penduduk->jenis_kelahiran,
                    'anak_ke' => $penduduk->kelahiran_anak_ke,
                    'penolong_kelahiran' => $penduduk->penolong_kelahiran,
                    'berat_lahir' => $penduduk->berat_lahir,
                    'panjang_lahir' => $penduduk->panjang_lahir,
                    'dokumen_pasport' => $penduduk->dokumen_pasport,
                    'dokumen_kitas' => $penduduk->dokumen_kitas,
                    'status_hidup' => $penduduk->label_status_dasar,
                    'shdk' => $penduduk->label_shdk,
                ];
            }
        }

        // Terapkan data dari Database DULU (Fallback jika form tidak mengirim inputannya)
        foreach ($dbData as $key => $val) {
            // Jika form tidak mengirim input ini, atau kosong, maka paksa isi pakai data DB
            if (!isset($formData[$key]) || empty($formData[$key])) {
                $htmlContent = str_ireplace('[' . $key . ']', $val ?? '', $htmlContent);
            }
        }

        // =========================================================
        // 1.5 AUTO GENERATE DAFTAR ANGGOTA KELUARGA [klg1_...], [klg2_...]
        // =========================================================
        if (isset($penduduk) && $penduduk->keluarga) {
            // Ambil semua anggota keluarga dari KK tersebut
            $anggotaKeluarga = \App\Models\Penduduk::where('keluarga_id', $penduduk->keluarga_id)
                                ->with('shdk')
                                ->orderBy('kk_level', 'asc') // Urutkan dari Kepala Keluarga, Istri, Anak
                                ->get();
            
            $i = 1;
            foreach ($anggotaKeluarga as $anggota) {
                $ttl = ($anggota->tempat_lahir ?? '-') . ', ' . ($anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d-m-Y') : '-');
                $shdk = $anggota->shdk->nama ?? $anggota->label_shdk ?? '-';
                
                // Replace sesuai urutan nomor
                $htmlContent = str_ireplace('[klg' . $i . '_no]', $i, $htmlContent);
                $htmlContent = str_ireplace('[klg' . $i . '_nik]', $anggota->nik, $htmlContent);
                $htmlContent = str_ireplace('[klg' . $i . '_nama]', $anggota->nama, $htmlContent);
                $htmlContent = str_ireplace('[klg' . $i . '_jenis_kelamin]', $anggota->jenis_kelamin, $htmlContent);
                $htmlContent = str_ireplace('[klg' . $i . '_ttl]', $ttl, $htmlContent);
                $htmlContent = str_ireplace('[klg' . $i . '_hubungan_kk]', $shdk, $htmlContent);
                
                $i++;
            }
        }

        // PENTING: Bersihkan sisa tag [klgX_...] yang tidak terpakai di template!
        // Misal di template ada sampai [klg10_nama], tapi anggota keluarga cuma 3 orang.
        // Script ini akan menghapus sisa tag [klg4...] sampai [klg10...] agar tabelnya kosong bersih.
        $htmlContent = preg_replace('/\[klg\d+_[a-zA-Z0-9_]+\]/i', '', $htmlContent);

        // =========================================================
        // 2. PENGGANTIAN VARIABEL INPUTAN FORM BIASA (PRIORITAS UTAMA)
        // =========================================================
        // Tambahkan 'hitung' ke dalam array ini agar tidak tertimpa angka random dari request
        $abaikanField = [
            'penandatangan', 'nama_pamong', 'sebutan_nip_desa', 'nip_pamong', 
            'jabatan_penandatangan', 'jabatan', 'pangkat_penandatangan', 'hitung'
        ];

        foreach ($formData as $key => $value) {
            if (!in_array(strtolower($key), $abaikanField) && !empty($value)) {
                $htmlContent = str_ireplace('[' . $key . ']', $value, $htmlContent);
            }
        }

        // =========================================================
        // 3. AUTO GENERATE VARIABEL PERANGKAT DESA (PAMONG)
        // =========================================================
        $penandatanganInput = $request->penandatangan ?? $request->nama_pamong;

        if (!empty($penandatanganInput)) {
            $pejabat = PerangkatDesa::with('jabatan')->find($penandatanganInput);

            if ($pejabat) {
                $cariPejabat = [
                    '[nama_penandatangan]', '[nama_pamong]', 
                    '[jabatan_penandatangan]', '[jabatan]', 
                    '[nip_penandatangan]', '[nip_pamong]', 
                    '[sebutan_nip_desa]',
                    '[pangkat_penandatangan]'
                ];
                
                $sebutanNip = (empty($pejabat->nip) || $pejabat->nip == '-' || $pejabat->nip == null) ? 'NIAP' : 'NIP';
                $nomorNip = (empty($pejabat->nip) || $pejabat->nip == '-' || $pejabat->nip == null) ? ($pejabat->niap ?? '-') : $pejabat->nip;
                
                $gantiPejabat = [
                    $pejabat->nama ?? '.......................', 
                    $pejabat->nama ?? '.......................', 
                    $pejabat->jabatan->nama ?? '.......................', 
                    $pejabat->jabatan->nama ?? '.......................', 
                    $nomorNip, 
                    $nomorNip, 
                    $sebutanNip, 
                    $pejabat->pangkat_golongan ?? '-' 
                ];
                
                $htmlContent = str_ireplace($cariPejabat, $gantiPejabat, $htmlContent);
            }
        }

        // =========================================================
        // 3.5 AUTO CALCULATE RUMUS MATEMATIKA [hitung][...]
        // =========================================================
        // 1. Ubah tag operator pseudo menjadi operator matematika asli
        $htmlContent = str_replace(
            ['[op+]', '[op-]', '[op*]', '[op/]'], 
            ['+', '-', '*', '/'], 
            $htmlContent
        );

        // 2. Eksekusi perhitungan
        $htmlContent = preg_replace_callback('/\[hitung\]\[(.*?)\]/is', function($matches) {
            $expression = $matches[1];

            // Bersihkan semua karakter selain angka dan simbol matematika
            // Ini juga otomatis menghapus sisa kurung siku "[" atau "]" jika ada form yang kosong
            $sanitizedExpr = preg_replace('/[^0-9\+\-\*\/\(\)\.]/', '', $expression);

            if ($sanitizedExpr === '') return '0';

            try {
                $result = 0;
                eval('$result = (' . $sanitizedExpr . ');');
                // Format angka jadi ribuan (misal: 18.088)
                return number_format($result, 0, ',', '.');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Error Hitung Surat: ' . $e->getMessage());
                return '0';
            }
        }, $htmlContent);

        // =========================================================
// 3.6 PROSES TAG [terbilang]
// =========================================================
$htmlContent = preg_replace_callback('/\[terbilang\]\[(.*?)\]/is', function($matches) {
    // Ambil angka di dalam tag (bisa berupa angka murni atau hasil [hitung])
    $nilai = str_replace(['.', ','], '', $matches[1]); // Bersihkan titik/koma formatan sebelumnya
    $angka = (float) $nilai;
    
    if ($angka <= 0) return "nol rupiah";
    return ucwords($this->terbilang($angka)) . " Rupiah";
}, $htmlContent);

// =========================================================
// 3.7 AUTO DATA DETAIL ORANG TUA (Jika ada)
// =========================================================
if (isset($penduduk)) {
    // Ambil data Ayah & Ibu berdasarkan NIK yang tercatat di data Penduduk
    $ayah = \App\Models\Penduduk::where('nik', $penduduk->nik_ayah)->first();
    $ibu  = \App\Models\Penduduk::where('nik', $penduduk->nik_ibu)->first();

    if ($ayah) {
        $htmlContent = str_ireplace('[ttl_ayah]', ($ayah->tempat_lahir ?? '-') . ', ' . ($ayah->tanggal_lahir ? $ayah->tanggal_lahir->format('d-m-Y') : '-'), $htmlContent);
        $htmlContent = str_ireplace('[agama_ayah]', $ayah->agama->nama ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[pekerjaan_ayah]', $ayah->pekerjaan->nama ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[alamat_ayah]', $ayah->alamat ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[jenis_kelamin_ayah]', 'Laki-Laki', $htmlContent);
    }
    
    if ($ibu) {
        $htmlContent = str_ireplace('[ttl_ibu]', ($ibu->tempat_lahir ?? '-') . ', ' . ($ibu->tanggal_lahir ? $ibu->tanggal_lahir->format('d-m-Y') : '-'), $htmlContent);
        $htmlContent = str_ireplace('[agama_ibu]', $ibu->agama->nama ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[pekerjaan_ibu]', $ibu->pekerjaan->nama ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[alamat_ibu]', $ibu->alamat ?? '-', $htmlContent);
        $htmlContent = str_ireplace('[jenis_kelamin_ibu]', 'Perempuan', $htmlContent);
    }
}
        // =========================================================
        // 4. PROSES PENGGABUNGAN KOP SURAT (HEADER)
        // =========================================================
        $desa = IdentitasDesa::first();
        $setting = Setting::where('key', 'header_surat')->first(); 
        $templateHeader = $setting ? $setting->value : '';

        if ($desa && !empty($templateHeader)) {
            $cariHeader = [
                '[kabupaten]', '[kecamatan]', '[nama_desa]', '[provinsi]'
            ];
            $gantiHeader = [
                strtoupper($desa->kabupaten ?? 'KABUPATEN'),
                strtoupper($desa->kecamatan ?? 'KECAMATAN'),
                strtoupper($desa->nama_desa ?? 'DESA'),
                strtoupper($desa->provinsi ?? 'PROVINSI')
            ];
            
            $templateHeader = str_ireplace($cariHeader, $gantiHeader, $templateHeader);
            $htmlContent = $templateHeader . '<div style="margin-top: 15px;"></div>' . $htmlContent;
        }

        // =========================================================
        // 5. AUTO GENERATE VARIABEL IDENTITAS DESA
        // =========================================================
        if ($desa) {
            $cariDesa = [
                '[nama_desa]', '[kode_desa]', '[kode_pos]', '[kecamatan]',
                '[kabupaten]', '[provinsi]', '[alamat_kantor]', '[email_desa]',
                '[telepon_desa]', '[website_desa]', '[kepala_desa]', '[nip_kepala_desa]'
            ];
            
            $gantiDesa = [
                $desa->nama_desa ?? '', $desa->kode_desa ?? '', $desa->kode_pos ?? '', 
                $desa->kecamatan ?? '', $desa->kabupaten ?? '', $desa->provinsi ?? '', 
                $desa->alamat_kantor ?? '', $desa->email_desa ?? '', $desa->telepon_desa ?? '', 
                $desa->website_desa ?? '', $desa->kepala_desa ?? '', $desa->nip_kepala_desa ?? ''
            ];
            
            $htmlContent = str_ireplace($cariDesa, $gantiDesa, $htmlContent);
        }
        
        // =========================================================
        // 6. AUTO LOGO DESA
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

        $pemerintah = PerangkatDesa::aktif()->orderBy('urutan')->get();

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
            $this->syncDataPendudukDanKeluarga($request);

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
                'nik'           => $request->nik_pemohon ?? ($request->nik ?? '-'),
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
        // PERBAIKAN: Me-load semua relasi tabel yang dibutuhkan
        $penduduk = Penduduk::with([
            'agama', 'pendidikanKk', 'pekerjaan', 'statusKawin', 
            'golonganDarah', 'warganegara', 'shdk', 'cacat', 
            'sakitMenahun', 'caraKb', 'asuransi', 'bahasa',
            'keluarga.rumahTangga'
        ])->where('nik', $nik)->first();

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

            $dataPenduduk = $penduduk->toArray();
            
            $dataPenduduk['tanggal_lahir_format'] = $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('Y-m-d') : '';

            // Map semua teks dari Relasi Master ke response JSON agar javascript mudah membaca
            $dataPenduduk['agama_teks'] = $penduduk->agama->nama ?? $penduduk->agama_lama ?? '';
            $dataPenduduk['pendidikan_teks'] = $penduduk->pendidikanKk->nama ?? $penduduk->pendidikan_lama ?? '';
            $dataPenduduk['pekerjaan_teks'] = $penduduk->pekerjaan->nama ?? $penduduk->pekerjaan_lama ?? '';
            $dataPenduduk['status_kawin_teks'] = $penduduk->statusKawin->nama ?? $penduduk->status_kawin_lama ?? '';
            $dataPenduduk['gol_darah_teks'] = $penduduk->golonganDarah->nama ?? $penduduk->golongan_darah_lama ?? '';
            $dataPenduduk['warga_negara_teks'] = $penduduk->warganegara->nama ?? $penduduk->kewarganegaraan_lama ?? 'WNI';
            
            // Tambahan Mapping
            $dataPenduduk['cacat_teks'] = $penduduk->cacat->nama ?? '';
            $dataPenduduk['sakit_menahun_teks'] = $penduduk->sakitMenahun->nama ?? '';
            $dataPenduduk['cara_kb_teks'] = $penduduk->caraKb->nama ?? '';
            $dataPenduduk['asuransi_teks'] = $penduduk->asuransi->nama ?? '';
            $dataPenduduk['bahasa_teks'] = $penduduk->bahasa->nama ?? '';
            
            $dataPenduduk['shdk_teks'] = $penduduk->shdk->nama ?? $penduduk->label_shdk ?? '';
            $dataPenduduk['umur'] = $penduduk->umur;

            return response()->json([
                'success' => true,
                'penduduk' => $dataPenduduk, 
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
        $this->syncDataPendudukDanKeluarga($request);

        $validated = $this->validateLetterRequest($request);
        $letter = Letter::create($validated);
        return redirect()->route('admin.layanan-surat.cetak.show', $letter->id);
    }

    public function show($id) {
        $letter = Letter::find($id) ?: ArsipSurat::findOrFail($id);
        return view('admin.layanan-surat.letters.show', compact('letter'));
    }

    public function cetak($id) {
        $arsip = ArsipSurat::findOrFail($id);
        $filePath = storage_path('app/public/' . $arsip->file_path);

        if (File::exists($filePath)) {
            return response()->file($filePath);
        }
        return back()->with('error', 'File PDF tidak ditemukan di server.');
    }

    // =========================================================================
    // FUNGSI PRIVATE (LOGIKA INTERNAL)
    // =========================================================================

    private function syncDataPendudukDanKeluarga(Request $request)
    {
        $nik = $request->nik_pemohon ?? $request->nik;
        $nama = $request->nama_pemohon ?? $request->nama;
        $no_kk = $request->no_kk;

        if (empty($nik) || empty($nama) || $nik === '-') {
            return;
        }

        DB::beginTransaction();
        try {
            $keluargaId = null;

            if (!empty($no_kk)) {
                $keluarga = Keluarga::firstOrCreate(
                    ['no_kk' => $no_kk],
                    [
                        'alamat' => $request->Alamat ?? $request->alamat ?? '-',
                        'status' => Keluarga::STATUS_AKTIF,
                        'tgl_terdaftar' => now()->toDateString()
                    ]
                );
                $keluargaId = $keluarga->id;
            }

            $agamaId = \App\Models\Ref\RefAgama::where('nama', 'LIKE', ($request->agama ?? '') . '%')->value('id');
            $pendidikanId = \App\Models\Ref\RefPendidikan::where('nama', 'LIKE', ($request->Pendidikan ?? '') . '%')->value('id');
            $pekerjaanId = \App\Models\Ref\RefPekerjaan::where('nama', 'LIKE', ($request->pekerjaan ?? '') . '%')->value('id');
            $statusKawinId = \App\Models\Ref\RefStatusKawin::where('nama', 'LIKE', ($request->status ?? '') . '%')->value('id') ?? 1;
            $wargaNegaraId = \App\Models\Ref\RefWarganegara::where('nama', 'LIKE', ($request->warga_negara ?? '') . '%')->value('id') ?? 1;

            $jenisKelamin = in_array(strtoupper($request->jenis_kelamin ?? 'L'), ['L', 'P']) ? strtoupper($request->jenis_kelamin ?? 'L') : 'L';

            $tglLahir = now()->toDateString();
            if ($request->filled('tanggal_lahir')) {
                try {
                    $tglLahir = \Carbon\Carbon::parse($request->tanggal_lahir)->format('Y-m-d');
                } catch (\Exception $e) {}
            }

            $isKepala = false;
            if ($request->filled('kepala_kk') && strtolower(trim($request->kepala_kk)) === strtolower(trim($nama))) {
                $isKepala = true;
            }

            $penduduk = Penduduk::updateOrCreate(
                ['nik' => $nik],
                [
                    'nama' => $nama,
                    'keluarga_id' => $keluargaId,
                    'tempat_lahir' => $request->tempat_lahir ?? '-',
                    'tanggal_lahir' => $tglLahir,
                    'jenis_kelamin' => $jenisKelamin,
                    'alamat' => $request->Alamat ?? $request->alamat ?? '-',
                    'agama_id' => $agamaId,
                    'pendidikan_kk_id' => $pendidikanId,
                    'pekerjaan_id' => $pekerjaanId,
                    'status_kawin_id' => $statusKawinId,
                    'warganegara_id' => $wargaNegaraId,
                    'status_hidup' => Penduduk::STATUS_DASAR_HIDUP,
                    'status' => Penduduk::STATUS_TETAP,
                    'jenis_tambah' => Penduduk::JENIS_TAMBAH_MASUK,
                    'kk_level' => $isKepala ? Penduduk::SHDK_KEPALA_KELUARGA : Penduduk::SHDK_FAMILI_LAIN,
                ]
            );

            if ($keluargaId && $isKepala) {
                Keluarga::where('id', $keluargaId)->update([
                    'kepala_keluarga_id' => $penduduk->id,
                    'nik_kepala' => $penduduk->nik
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan otomatis penduduk dari menu Cetak Surat: ' . $e->getMessage());
        }
    }

    private function validateLetterRequest(Request $request) {
        return $request->validate([
            'template_id'     => 'nullable|exists:surat_templates,id',
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
    private function terbilang($angka) {
    $angka = abs($angka);
    $baca = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
    $terbilang = "";

    if ($angka < 12) {
        $terbilang = " " . $baca[$angka];
    } else if ($angka < 20) {
        $terbilang = $this->terbilang($angka - 10) . " belas";
    } else if ($angka < 100) {
        $terbilang = $this->terbilang($angka / 10) . " puluh" . $this->terbilang($angka % 10);
    } else if ($angka < 200) {
        $terbilang = " seratus" . $this->terbilang($angka - 100);
    } else if ($angka < 1000) {
        $terbilang = $this->terbilang($angka / 100) . " ratus" . $this->terbilang($angka % 100);
    } else if ($angka < 2000) {
        $terbilang = " seribu" . $this->terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        $terbilang = $this->terbilang($angka / 1000) . " ribu" . $this->terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        $terbilang = $this->terbilang($angka / 1000000) . " juta" . $this->terbilang($angka % 1000000);
    }

    return trim($terbilang);
}
}