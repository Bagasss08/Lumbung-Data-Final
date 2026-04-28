<?php

namespace App\Http\Controllers\Admin\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SekretariatInformasiPublik;
use App\Models\Inventaris;
use App\Models\KlasifikasiSurat;
use Illuminate\Support\Facades\Storage;

class SekretariatController extends Controller
{
    // Informasi Publik
    public function index()
    {
        $informasiPublik = SekretariatInformasiPublik::paginate(10);
        return view('admin.sekretariat.informasi-publik', compact('informasiPublik'));
    }

    public function create()
    {
        return view('admin.sekretariat.informasi-publik-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'tipe_dokumen' => 'required|in:file,link,teks',
            'unggah_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'retensi_dokumen' => 'nullable|integer|min:0|max:31',
            'satuan_retensi' => 'nullable|in:hari,bulan,tahun',
            'kategori_info_publik' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tahun' => 'nullable|integer',
            'tanggal_terbit' => 'required|date',
            'status_terbit' => 'required|in:ya,tidak',
        ]);

        $data = $request->only([
            'judul_dokumen',
            'tipe_dokumen',
            'retensi_dokumen',
            'satuan_retensi',
            'kategori_info_publik',
            'keterangan',
            'tahun',
            'tanggal_terbit',
            'status_terbit'
        ]);

        if ($request->hasFile('unggah_dokumen')) {
            $data['unggah_dokumen'] = $request->file('unggah_dokumen')->store('sekretariat/informasi-publik', 'public');
        }

        SekretariatInformasiPublik::create($data);

        return redirect()->route('admin.sekretariat.informasi-publik.index')->with('success', 'Informasi publik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $informasi = SekretariatInformasiPublik::findOrFail($id);
        return view('admin.sekretariat.informasi-publik-edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = SekretariatInformasiPublik::findOrFail($id);

        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'tipe_dokumen' => 'required|in:file,link,teks',
            'unggah_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'retensi_dokumen' => 'nullable|integer|min:0|max:31',
            'satuan_retensi' => 'nullable|in:hari,bulan,tahun',
            'kategori_info_publik' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tahun' => 'nullable|integer',
            'tanggal_terbit' => 'required|date',
            'status_terbit' => 'required|in:ya,tidak',
        ]);

        $data = $request->only([
            'judul_dokumen',
            'tipe_dokumen',
            'retensi_dokumen',
            'satuan_retensi',
            'kategori_info_publik',
            'keterangan',
            'tahun',
            'tanggal_terbit',
            'status_terbit'
        ]);

        if ($request->hasFile('unggah_dokumen')) {
            if ($informasi->unggah_dokumen) {
                Storage::disk('public')->delete($informasi->unggah_dokumen);
            }
            $data['unggah_dokumen'] = $request->file('unggah_dokumen')->store('sekretariat/informasi-publik', 'public');
        }

        $informasi->update($data);

        return redirect()->route('admin.sekretariat.informasi-publik.index')->with('success', 'Informasi publik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = SekretariatInformasiPublik::findOrFail($id);

        if ($informasi->file_path) {
            Storage::disk('public')->delete($informasi->file_path);
        }

        $informasi->delete();

        return redirect()->route('admin.sekretariat.informasi-publik.index')->with('success', 'Informasi publik berhasil dihapus.');
    }

    public function download($id)
    {
        $informasi = SekretariatInformasiPublik::findOrFail($id);

        if ($informasi->unggah_dokumen && Storage::disk('public')->exists($informasi->unggah_dokumen)) {
            return Storage::disk('public')->download($informasi->unggah_dokumen);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    // Inventaris
    public function inventaris()
    {
        $inventaris = Inventaris::paginate(10);

        $stats = [
            'total' => Inventaris::count(),
            'baik' => Inventaris::where('kondisi', 'baik')->count(),
            'rusak' => Inventaris::where('kondisi', 'rusak')->count(),
            'perlu_perbaikan' => Inventaris::where('kondisi', 'perlu_perbaikan')->count(),
        ];

        return view('admin.sekretariat.inventaris', compact('inventaris', 'stats'));
    }

    public function inventarisCreate()
    {
        return view('admin.sekretariat.inventaris-create');
    }

    public function inventarisStore(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Inventaris::create($request->all());

        return redirect()->route('admin.sekretariat.inventaris')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function inventarisEdit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('admin.sekretariat.inventaris-edit', compact('inventaris'));
    }

    public function inventarisUpdate(Request $request, $id)
    {
        $inventaris = Inventaris::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $inventaris->update($request->all());

        return redirect()->route('admin.sekretariat.inventaris')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function inventarisDestroy($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('admin.sekretariat.inventaris')->with('success', 'Inventaris berhasil dihapus.');
    }

    // ==========================================
    // Klasifikasi Surat
    // ==========================================
    public function klasifikasiSurat(Request $request)
    {
        $query = KlasifikasiSurat::query();

        // Search functionality (mencari kode, nama klasifikasi, atau nama/kategori baru)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_klasifikasi', 'like', '%' . $search . '%')
                  ->orWhere('kode', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%') // <-- 'kategori' diganti 'nama'
                  ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter by nama (karena form dropdown kategori sudah kita hapus di blade, tapi jika sewaktu-waktu dipakai lagi)
        if ($request->has('nama') && !empty($request->nama)) {
            $query->where('nama', $request->nama);
        }

        // --- TAMBAHAN UNTUK FITUR TAMPILKAN PER PAGE ---
        // Ambil nilai per_page dari request, default ke 10 jika kosong
        $perPage = $request->input('per_page', 10);
        
        // Gunakan $perPage di method paginate()
        $klasifikasiSurat = $query->paginate($perPage)->appends($request->query());
        // -------------------------------------------------

        $stats = [
            'total' => KlasifikasiSurat::count(),
            'aktif' => KlasifikasiSurat::where('status', true)->count(),
            'tidak_aktif' => KlasifikasiSurat::where('status', false)->count(),
        ];

        return view('admin.sekretariat.klasifikasi-surat', compact('klasifikasiSurat', 'stats'));
    }

    public function klasifikasiSuratCreate()
    {
        return view('admin.sekretariat.klasifikasi-surat-create');
    }

    public function klasifikasiSuratStore(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:klasifikasi_surats,kode',
            'nama_klasifikasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255', // <-- Validasi 'kategori' diganti 'nama'
            'retensi_aktif' => 'required|integer|min:1',
            'retensi_inaktif' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        KlasifikasiSurat::create($request->all());

        return redirect()->route('admin.sekretariat.klasifikasi-surat')->with('success', 'Klasifikasi surat berhasil ditambahkan.');
    }

    public function klasifikasiSuratEdit($id)
    {
        $klasifikasi = KlasifikasiSurat::findOrFail($id);
        return view('admin.sekretariat.klasifikasi-surat-edit', compact('klasifikasi'));
    }

    public function klasifikasiSuratUpdate(Request $request, $id)
    {
        $klasifikasi = KlasifikasiSurat::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:10|unique:klasifikasi_surats,kode,' . $id,
            'nama_klasifikasi' => 'required|string|max:255',
            'nama' => 'required|string|max:255', // <-- Validasi 'kategori' diganti 'nama'
            'retensi_aktif' => 'required|integer|min:1',
            'retensi_inaktif' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $klasifikasi->update($request->all());

        return redirect()->route('admin.sekretariat.klasifikasi-surat')->with('success', 'Klasifikasi surat berhasil diperbarui.');
    }

    public function klasifikasiSuratShow($id)
    {
        $klasifikasi = KlasifikasiSurat::findOrFail($id);
        return view('admin.sekretariat.klasifikasi-surat-show', compact('klasifikasi'));
    }

    public function klasifikasiSuratDestroy($id)
    {
        $klasifikasi = KlasifikasiSurat::findOrFail($id);
        $klasifikasi->delete();

        return redirect()->route('admin.sekretariat.klasifikasi-surat')->with('success', 'Klasifikasi surat berhasil dihapus.');
    }
    /**
     * Menghapus banyak data Klasifikasi Surat sekaligus.
     */
    public function klasifikasiSuratBulkDestroy(Request $request)
    {
        // 1. Validasi request untuk memastikan 'ids' dikirim dan berupa array
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:klasifikasi_surats,id' // Sesuaikan nama tabel jika berbeda
        ]);

        try {
            // 2. Lakukan penghapusan massal
            // Sesuaikan "KlasifikasiSurat" dengan nama Model yang Anda gunakan
            KlasifikasiSurat::whereIn('id', $request->ids)->delete();

            // 3. Kembalikan response sukses
            return redirect()->route('admin.sekretariat.klasifikasi-surat')
                ->with('success', count($request->ids) . ' data klasifikasi surat berhasil dihapus.');
                
        } catch (\Exception $e) {
            // 4. Tangani jika terjadi error (misalnya constraint dari database)
            return redirect()->route('admin.sekretariat.klasifikasi-surat')
                ->with('error', 'Gagal menghapus data. Pastikan data ini tidak sedang digunakan di tempat lain.');
        }
    }
}