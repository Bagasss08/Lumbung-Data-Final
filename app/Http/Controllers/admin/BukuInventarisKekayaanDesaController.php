<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuInventarisKekayaanDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BukuInventarisKekayaanDesaController extends Controller {
    /**
     * Tampilkan daftar inventaris
     */
    public function index(Request $request) {
        $query = BukuInventarisKekayaanDesa::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $inventaris = $query->latest()->paginate(10)->withQueryString();

        // Statistik ringkasan
        $stats = [
            'total_item'       => BukuInventarisKekayaanDesa::count(),
            'total_nilai'      => BukuInventarisKekayaanDesa::sum('harga_total'),
            'kondisi_baik'     => BukuInventarisKekayaanDesa::where('kondisi', 'Baik')->count(),
            'kondisi_rusak'    => BukuInventarisKekayaanDesa::whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])->count(),
        ];

        return view('admin.buku-administrasi.umum.buku-inventaris-dan-kekayaan-desa.index', compact('inventaris', 'stats'));
    }

    /**
     * Form tambah inventaris
     */
    public function create() {
        $kategoriList  = BukuInventarisKekayaanDesa::kategoriList();
        $asalUsulList  = BukuInventarisKekayaanDesa::asalUsulList();
        $satuanList    = BukuInventarisKekayaanDesa::satuanList();
        $kodeOtomatis  = $this->generateKodeBarang();

        return view('admin.buku-administrasi.umum.buku-inventaris-dan-kekayaan-desa.create', compact(
            'kategoriList',
            'asalUsulList',
            'satuanList',
            'kodeOtomatis'
        ));
    }

    /**
     * Simpan data inventaris baru
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'kode_barang'      => 'required|string|max:50|unique:buku_inventaris_kekayaan_desa,kode_barang',
            'nama_barang'      => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'jumlah'           => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'tahun_pengadaan'  => 'nullable|integer|min:1900|max:' . date('Y'),
            'asal_usul'        => 'nullable|string|max:100',
            'harga_satuan'     => 'nullable|numeric|min:0',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
        ], [
            'kode_barang.required'   => 'Kode barang wajib diisi.',
            'kode_barang.unique'     => 'Kode barang sudah digunakan.',
            'nama_barang.required'   => 'Nama barang wajib diisi.',
            'kategori.required'      => 'Kategori wajib dipilih.',
            'jumlah.required'        => 'Jumlah wajib diisi.',
            'jumlah.numeric'         => 'Jumlah harus berupa angka.',
            'satuan.required'        => 'Satuan wajib diisi.',
            'kondisi.required'       => 'Kondisi wajib dipilih.',
        ]);

        BukuInventarisKekayaanDesa::create($validated);

        return redirect()
            ->route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index')
            ->with('success', 'Data inventaris berhasil ditambahkan.');
    }

    /**
     * Detail inventaris
     */
    public function show(BukuInventarisKekayaanDesa $inventarisKekayaanDesa) {
        return view('admin.buku-administrasi.umum.buku-inventaris-dan-kekayaan-desa.show', [
            'item' => $inventarisKekayaanDesa,
        ]);
    }

    /**
     * Form edit inventaris
     */
    public function edit(BukuInventarisKekayaanDesa $inventarisKekayaanDesa) {
        $kategoriList = BukuInventarisKekayaanDesa::kategoriList();
        $asalUsulList = BukuInventarisKekayaanDesa::asalUsulList();
        $satuanList   = BukuInventarisKekayaanDesa::satuanList();

        return view('admin.buku-administrasi.umum.buku-inventaris-dan-kekayaan-desa.edit', [
            'item'         => $inventarisKekayaanDesa,
            'kategoriList' => $kategoriList,
            'asalUsulList' => $asalUsulList,
            'satuanList'   => $satuanList,
        ]);
    }

    /**
     * Update data inventaris
     */
    public function update(Request $request, BukuInventarisKekayaanDesa $inventarisKekayaanDesa) {
        $validated = $request->validate([
            'kode_barang'      => 'required|string|max:50|unique:buku_inventaris_kekayaan_desa,kode_barang,' . $inventarisKekayaanDesa->id,
            'nama_barang'      => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'jumlah'           => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'tahun_pengadaan'  => 'nullable|integer|min:1900|max:' . date('Y'),
            'asal_usul'        => 'nullable|string|max:100',
            'harga_satuan'     => 'nullable|numeric|min:0',
            'kondisi'          => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'lokasi'           => 'nullable|string|max:255',
            'keterangan'       => 'nullable|string',
        ]);

        $inventarisKekayaanDesa->update($validated);

        return redirect()
            ->route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index')
            ->with('success', 'Data inventaris berhasil diperbarui.');
    }

    /**
     * Hapus data inventaris (soft delete)
     */
    public function destroy(BukuInventarisKekayaanDesa $inventarisKekayaanDesa) {
        $inventarisKekayaanDesa->delete();

        return redirect()
            ->route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index')
            ->with('success', 'Data inventaris berhasil dihapus.');
    }

    /**
     * Generate kode barang otomatis
     */
    private function generateKodeBarang(): string {
        $tahun  = date('Y');
        $prefix = 'INV-' . $tahun . '-';
        $last   = BukuInventarisKekayaanDesa::withTrashed()
            ->where('kode_barang', 'like', $prefix . '%')
            ->orderByDesc('kode_barang')
            ->value('kode_barang');

        if ($last) {
            $lastNum = (int) substr($last, strlen($prefix));
            return $prefix . str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        }

        return $prefix . '0001';
    }
}
