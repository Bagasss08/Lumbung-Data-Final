<?php

namespace App\Http\Controllers\Admin\layanansurat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratTemplate; 
use App\Models\SuratPermohonan;
use App\Models\PersyaratanSurat;
use App\Models\IdentitasDesa;
use App\Models\ArsipSurat; // Pastikan model ArsipSurat di-import

class LayananSuratController extends Controller 
{
    /**
     * Display permohonan surat page (Index Table)
     */
    public function permohonan(Request $request) 
    {
        $query = SuratPermohonan::with(['penduduk', 'suratTemplate']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('penduduk', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 25);
        $permohonan = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        $autoNomorSurat = $this->generateAutoNomorSurat();

        return view('admin.layanan-surat.permohonan.index', compact('permohonan', 'autoNomorSurat'));
    }

    /**
     * Show detail permohonan surat
     */
    public function showPermohonan($id)
    {
        $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($id);
        
        return view('admin.layanan-surat.permohonan.show', compact('permohonan'));
    }

    /**
     * Update status permohonan
     */
    public function updateStatusPermohonan(Request $request, $id) {
        $request->validate([
            'status'           => 'required|in:belum lengkap,sedang diperiksa,menunggu tandatangan,siap diambil,sudah diambil,dibatalkan',
            'catatan_petugas'  => 'nullable|string',
        ]);

        $permohonan = SuratPermohonan::findOrFail($id);

        $permohonan->update([
            'status'          => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
            'notif_dibaca'    => false,
        ]);

        if ($permohonan->user_id && class_exists(\App\Models\Pesan::class)) {

            $labelStatus = match ($request->status) {
                'belum lengkap'         => 'Belum Lengkap — mohon lengkapi berkas Anda',
                'sedang diperiksa'      => 'Sedang Diperiksa oleh petugas',
                'menunggu tandatangan'  => 'Menunggu Tanda Tangan pejabat',
                'siap diambil'          => 'Siap Diambil ✅ — silakan ambil surat Anda',
                'sudah diambil'         => 'Sudah Diambil — selesai',
                'dibatalkan'            => 'Dibatalkan ❌',
                default                 => ucfirst($request->status),
            };

            $namaSurat = $permohonan->jenisSurat->nama_jenis_surat
                ?? $permohonan->jenis_surat
                ?? $permohonan->nama_surat
                ?? 'Surat';

            $isiPesan = "📋 *Update Status Permohonan Surat*\n\n"
                . "Jenis Surat : {$namaSurat}\n"
                . "Status Baru : {$labelStatus}";

            if ($request->filled('catatan_petugas')) {
                $isiPesan .= "\nCatatan     : {$request->catatan_petugas}";
            }

            \App\Models\Pesan::create([
                'pengirim_id'  => \Illuminate\Support\Facades\Auth::id(),
                'penerima_id'  => $permohonan->user_id,
                'subjek'       => "Status Surat: {$namaSurat}",
                'isi'          => $isiPesan,
                'sudah_dibaca' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Status permohonan surat berhasil diperbarui!');
    }

    /**
     * Display arsip surat page
     */
    public function arsip(Request $request) 
    {
        // 1. Tambahkan eager loading relasi templateSurat
        $query = ArsipSurat::with('templateSurat');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_surat', $request->tahun)
                  ->orWhereYear('created_at', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_surat', $request->bulan)
                  ->orWhereMonth('created_at', $request->bulan);
        }

        // 2. Filter berdasarkan Jenis Surat (Karena nyambung ke ID template, gunakan match langsung)
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%");
            });
        }

        $statPermohonan = SuratPermohonan::whereNotIn('status', ['sudah diambil', 'dibatalkan'])->count();
        $statDitolak = SuratPermohonan::where('status', 'dibatalkan')->count();
        $statArsip = ArsipSurat::count();

        // 3. Set default per_page jadi 10, dan tangkap request per_page
        $perPage = $request->get('per_page', 10); 
        
        // withQueryString() inilah yang bertugas membawa semua filter & per_page ke "Halaman 2, 3, dst"
        $arsip = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        $jenisSuratList = SuratTemplate::all();
        $tahunList = range(date('Y'), date('Y') - 5); 

        return view('admin.layanan-surat.arsip', compact(
            'arsip',
            'statPermohonan',
            'statArsip',
            'statDitolak',
            'jenisSuratList',
            'tahunList'
        ));
    }

    /**
     * Display pengaturan layanan surat page
     */
    public function pengaturan()
    {
        $templates = SuratTemplate::with('persyaratan')->get();
        return view('admin.layanan-surat.pengaturan', compact('templates'));
    }

    /**
     * Hapus Arsip
     */
    public function destroyArsip($id) {
        // --- PERUBAHAN: Hapus data dari model ArsipSurat, bukan SuratPermohonan ---
        $arsip = ArsipSurat::findOrFail($id);
        
        // Cek nama kolom file yang ada di model ArsipSurat ('file_path')
        if ($arsip->file_path) {
            Storage::disk('public')->delete($arsip->file_path);
        }

        $arsip->delete();

        return redirect()->back()->with('success', 'Data arsip surat berhasil dihapus.');
    }

    /**
     * Display daftar persyaratan page
     */
    public function daftarPersyaratan() 
    {
        $persyaratan = PersyaratanSurat::all();
        return view('admin.layanan-surat.daftar-persyaratan', compact('persyaratan'));
    }

    public function destroyTemplate($id)
    {
        $template = SuratTemplate::findOrFail($id);

        if ($template->file_template) {
            Storage::disk('public')->delete($template->file_template);
        }

        $template->delete();

        return back()->with('success', 'Template berhasil dihapus');
    }

    /**
     * MEMPROSES CETAK SURAT
     */
    public function prosesCetak($permohonan_id)
    {
        $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($permohonan_id);
        $templateSurat = $permohonan->suratTemplate;

        return view('admin.layanan-surat.cetak.proses', compact('permohonan', 'templateSurat'));
    }

    /**
     * MENGARAHKAN KE HALAMAN CETAK SURAT (LETTERS CREATE)
     */
    public function createLetter(Request $request)
    {
        $permohonan_id = $request->query('permohonan_id');
        
        $permohonan = null;
        $selectedTemplate = null;
        $autoNomorSurat = ''; 

        if ($permohonan_id) {
            $permohonan = SuratPermohonan::with(['penduduk', 'suratTemplate'])->findOrFail($permohonan_id);
            $selectedTemplate = $permohonan->suratTemplate;

            $templateId = $selectedTemplate ? $selectedTemplate->id : null;
            $autoNomorSurat = $this->generateAutoNomorSurat($templateId);
        }

        return view('admin.layanan-surat.letters.create', compact('permohonan', 'selectedTemplate', 'autoNomorSurat'));
    }

    private function generateAutoNomorSurat($templateId = null)
    {
        $kodeKlasifikasi = 'S-41'; 

        if ($templateId) {
            $template = SuratTemplate::find($templateId);
            $kodeKlasifikasi = $template->kode_klasifikasi ?? 'S-41';
        }
        
        $desa = IdentitasDesa::first();
        $kodeWilayah = $desa ? ($desa->kode_wilayah ?? $desa->kode_desa ?? '9202172009') : '9202172009'; 
        
        $tahun = date('Y');
        $bulan = date('n'); 
        
        $romawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRomawi = $romawi[$bulan];
        
        $jumlahSurat = ArsipSurat::whereYear('created_at', $tahun)->count();
        $nomorUrut = str_pad($jumlahSurat + 1, 3, '0', STR_PAD_LEFT); 
        
        return "{$kodeKlasifikasi}/{$nomorUrut}/{$kodeWilayah}/{$bulanRomawi}/{$tahun}";
    }
}