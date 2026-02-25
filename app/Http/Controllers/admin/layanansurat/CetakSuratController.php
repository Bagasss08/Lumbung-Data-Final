<?php

namespace App\Http\Controllers\Admin\layanansurat;

use App\Http\Controllers\Controller;
use App\Models\TemplateSurat;
use App\Models\CetakSurat;
use App\Models\Penduduk;
use App\Models\Desa;
use App\Models\IdentitasDesa;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CetakSuratController extends Controller
{
    public function index()
    {
        $templates = TemplateSurat::where('is_active', true)->get();
        $cetakSurat = CetakSurat::with('template')
            ->latest()
            ->paginate(10);

        return view('admin.layanan-surat.cetak.index', compact('templates', 'cetakSurat'));
    }

    /**
     * Get penduduk data by NIK with auto-fill desa and identitas_desa data
     */
    public function getPendudukData($nik)
    {
        try {
            $penduduk = Penduduk::where('nik', $nik)->first();
            
            if (!$penduduk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data penduduk dengan NIK tersebut tidak ditemukan'
                ], 404);
            }

            // Get desa data
            $desa = Desa::first();
            
            // Get identitas desa data
            $identitasDesa = IdentitasDesa::first();

            // Format tanggal lahir
            $tanggalLahir = '';
            if ($penduduk->tanggal_lahir) {
                try {
                    $tanggalLahir = Carbon::parse($penduduk->tanggal_lahir)->locale('id')->isoFormat('DD-MM-YYYY');
                } catch (\Exception $e) {
                    $tanggalLahir = $penduduk->tanggal_lahir;
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    // Data Penduduk dari tabel penduduk
                    'nama' => $penduduk->nama ?? '',
                    'nik' => $penduduk->nik ?? '',
                    'jenis_kelamin' => $penduduk->jenis_kelamin ?? '',
                    'tempat_lahir' => $penduduk->tempat_lahir ?? '',
                    'tanggal_lahir' => $tanggalLahir,
                    'agama' => $penduduk->agama ?? '',
                    'pendidikan' => $penduduk->pendidikan ?? '',
                    'pekerjaan' => $penduduk->pekerjaan ?? '',
                    'status_kawin' => $penduduk->status_kawin ?? '',
                    'status_hidup' => $penduduk->status_hidup ?? '',
                    'kewarganegaraan' => $penduduk->kewarganegaraan ?? 'Indonesia',
                    'alamat' => $penduduk->alamat ?? '',
                    'no_telp' => $penduduk->no_telp ?? '',
                    'email' => $penduduk->email ?? '',
                    'golongan_darah' => $penduduk->golongan_darah ?? '',
                    
                    // Data Desa dari tabel desa
                    'kode_desa' => $desa->kode_desa ?? '',
                    'nama_desa' => $desa->nama_desa ?? '',
                    'kecamatan' => $desa->kecamatan ?? '',
                    'kabupaten' => $desa->kabupaten ?? '',
                    'provinsi' => $desa->provinsi ?? '',
                    'kode_pos' => $desa->kode_pos ?? '',
                    'luas_wilayah' => $desa->luas_wilayah ?? '',
                    'klasifikasi_desa' => $desa->klasifikasi_desa ?? '',
                    'alamat_kantor' => $desa->alamat_kantor ?? '',
                    'telp' => $desa->telp ?? '',
                    'logo_desa' => $desa->logo_desa ?? '',
                    'gambar_kantor' => $desa->gambar_kantor ?? '',
                    
                    // Data Identitas Desa dari tabel identitas_desa
                    'kode_bps_desa' => $identitasDesa->kode_bps_desa ?? '',
                    'kode_kecamatan' => $identitasDesa->kode_kecamatan ?? '',
                    'nama_camat' => $identitasDesa->nama_camat ?? '',
                    'nip_camat' => $identitasDesa->nip_camat ?? '',
                    'kode_kabupaten' => $identitasDesa->kode_kabupaten ?? '',
                    'kode_provinsi' => $identitasDesa->kode_provinsi ?? '',
                    'kantor_desa' => $identitasDesa->kantor_desa ?? 'KANTOR KEPALA DESA',
                    'email_desa' => $identitasDesa->email_desa ?? '',
                    'telepon_desa' => $identitasDesa->telepon_desa ?? '',
                    'ponsel_desa' => $identitasDesa->ponsel_desa ?? '',
                    'website_desa' => $identitasDesa->website_desa ?? '',
                    'kepala_desa' => $identitasDesa->kepala_desa ?? '',
                    'nip_kepala_desa' => $identitasDesa->nip_kepala_desa ?? '',
                    'nama_penanggung_jawab_desa' => $identitasDesa->nama_penanggung_jawab_desa ?? '',
                    'no_ppwa' => $identitasDesa->no_ppwa ?? '',
                    'penandatangan' => 'Kepala Desa', // Default value
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request) {
    // 1. Ambil data dari form dan NIK
    $warga = $request->data_warga; // Data dari NIK (nama, alamat, dll)
    $form  = $request->except(['_token', 'data_warga']); // Data form (keperluan, masa berlaku)
    
    // Gabungkan semua data
    $allData = array_merge($warga, $form);

    // 2. Load Template Word Surat Jalan
    $template = new TemplateProcessor(storage_path('app/templates/surat_jalan.doc'));

    // 3. Timpa {{variabel}} di Word dengan data dari gabungan Form
    foreach($allData as $key => $value) {
        $template->setValue($key, $value);
    }

    // 4. Download file hasil generate
    $fileName = 'Surat_Jalan_' . $warga['nama'] . '.docx';
    $template->saveAs(storage_path('app/public/' . $fileName));

    return response()->download(storage_path('app/public/' . $fileName));
}

    private function generateWordDocument($cetakSurat)
    {
        $template = $cetakSurat->template;
        $templatePath = storage_path('app/public/' . $template->file_path);
        
        if (!file_exists($templatePath)) {
            throw new \Exception('Template file tidak ditemukan di: ' . $templatePath);
        }

        $templateProcessor = new TemplateProcessor($templatePath);
        
        // Get data warga
        $dataWarga = is_array($cetakSurat->data_warga) 
            ? $cetakSurat->data_warga 
            : json_decode($cetakSurat->data_warga, true);
        
        // Get desa and identitas desa data
        $desa = Desa::first();
        $identitasDesa = IdentitasDesa::first();

        // Format tanggal surat
        $tanggalSurat = Carbon::parse($cetakSurat->tanggal_surat)->locale('id')->isoFormat('D MMMM Y');

        // Merge all data
        $allData = array_merge($dataWarga ?? [], [
            // Format nomor dan tanggal
            'format_nomor' => $cetakSurat->nomor_surat,
            'tgl_surat' => $tanggalSurat,
            
            // Data Desa
            'kode_desa' => $desa->kode_desa ?? '',
            'nama_desa' => $desa->nama_desa ?? '',
            'kecamatan' => $desa->kecamatan ?? '',
            'kabupaten' => $desa->kabupaten ?? '',
            'provinsi' => $desa->provinsi ?? '',
            'kode_pos' => $desa->kode_pos ?? '',
            'alamat_kantor' => $desa->alamat_kantor ?? '',
            'telp' => $desa->telp ?? '',
            
            // Data Identitas Desa
            'kode_bps_desa' => $identitasDesa->kode_bps_desa ?? '',
            'kode_kecamatan' => $identitasDesa->kode_kecamatan ?? '',
            'nama_camat' => $identitasDesa->nama_camat ?? '',
            'nip_camat' => $identitasDesa->nip_camat ?? '',
            'kode_kabupaten' => $identitasDesa->kode_kabupaten ?? '',
            'kode_provinsi' => $identitasDesa->kode_provinsi ?? '',
            'kantor_desa' => $identitasDesa->kantor_desa ?? 'KANTOR KEPALA DESA',
            'email_desa' => $identitasDesa->email_desa ?? '',
            'telepon_desa' => $identitasDesa->telepon_desa ?? '',
            'website_desa' => $identitasDesa->website_desa ?? '',
            'kepala_desa' => $identitasDesa->kepala_desa ?? '',
            'nip_kepala_desa' => $identitasDesa->nip_kepala_desa ?? '',
            'penandatangan' => 'Kepala Desa',
        ]);

        // Replace variables in template
        foreach ($allData as $key => $value) {
            try {
                $templateProcessor->setValue($key, $value ?? '-');
            } catch (\Exception $e) {
                // Skip if variable not found in template
                continue;
            }
        }

        // Save generated document
        $outputDir = storage_path('app/public/surat-hasil');
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputPath = $outputDir . '/' . $cetakSurat->id . '.docx';
        $templateProcessor->saveAs($outputPath);
        
        // Update cetak surat with generated file path
        $cetakSurat->update([
            'generated_file' => 'surat-hasil/' . $cetakSurat->id . '.docx'
        ]);
    }

    public function print($id)
    {
        $cetakSurat = CetakSurat::with('template')->findOrFail($id);
        
        $filePath = storage_path('app/public/' . $cetakSurat->generated_file);
        
        if (!file_exists($filePath)) {
            // Regenerate if file not found
            $this->generateWordDocument($cetakSurat);
        }

        return response()->download($filePath, 'Surat-' . $cetakSurat->nomor_surat . '.docx');
    }

    public function show($id)
    {
        $cetakSurat = CetakSurat::with('template')->findOrFail($id);
        
        return view('admin.layanan-surat.cetak.show', compact('cetakSurat'));
    }

    public function edit($id)
    {
        $cetakSurat = CetakSurat::with('template')->findOrFail($id);
        $templates = TemplateSurat::where('status', 'aktif')->get();
        
        return view('admin.layanan-surat.cetak.edit', compact('cetakSurat', 'templates'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template_id' => 'required|exists:template_surat,id',
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string',
            'data_warga' => 'required|array',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        try {
            $cetakSurat = CetakSurat::findOrFail($id);
            
            // Upload new file if exists
            $filePath = $cetakSurat->file_surat;
            if ($request->hasFile('file_surat')) {
                // Delete old file
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = $request->file('file_surat')->store('surat-pendukung', 'public');
            }

            // Update cetak surat record
            $cetakSurat->update([
                'template_id' => $request->template_id,
                'nomor_surat' => $request->nomor_surat,
                'tanggal_surat' => $request->tanggal_surat,
                'perihal' => $request->perihal,
                'keterangan' => $request->keterangan,
                'data_warga' => json_encode($request->data_warga),
                'file_surat' => $filePath,
            ]);

            // Regenerate Word document
            $this->generateWordDocument($cetakSurat);

            return redirect()
                ->route('admin.layanan-surat.cetak.index')
                ->with('success', 'Surat berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui surat: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $cetakSurat = CetakSurat::findOrFail($id);
            
            // Delete files
            if ($cetakSurat->file_surat && Storage::disk('public')->exists($cetakSurat->file_surat)) {
                Storage::disk('public')->delete($cetakSurat->file_surat);
            }
            
            if ($cetakSurat->generated_file && Storage::disk('public')->exists($cetakSurat->generated_file)) {
                Storage::disk('public')->delete($cetakSurat->generated_file);
            }
            
            $cetakSurat->delete();
            
            return redirect()
                ->route('admin.layanan-surat.cetak.index')
                ->with('success', 'Surat berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus surat: ' . $e->getMessage());
        }
    }
    
}