<?php

namespace App\Http\Controllers\Admin\Pertanahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CDesa;
use App\Models\CDesaPersil;
use App\Models\Penduduk;

class CDesaController extends Controller
{
    // 1. Halaman Daftar C-Desa
    public function index(Request $request)
    {
        $query = CDesa::with('penduduk')->withCount('persil');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nomor_cdesa', 'like', "%{$search}%")
                  ->orWhere('nama_di_cdesa', 'like', "%{$search}%")
                  ->orWhereHas('penduduk', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%");
                  });
        }

        $perPage = $request->get('per_page', 10);
        $cdesa = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.pertanahan.c-desa.index', compact('cdesa'));
    }

    // 2. Halaman Tambah C-Desa
    public function create()
    {
        // Ambil data penduduk aktif untuk dropdown
        $penduduk = Penduduk::where('status_hidup', 'hidup')->get();
        return view('admin.pertanahan.c-desa.create', compact('penduduk'));
    }

    // 3. Simpan C-Desa Baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pemilik' => 'required|in:warga_desa,warga_luar',
            'nomor_cdesa' => 'required|unique:c_desa,nomor_cdesa',
            'nama_di_cdesa' => 'required|string|max:100',
        ]);

        $data = [
            'jenis_pemilik' => $request->jenis_pemilik,
            'nomor_cdesa' => $request->nomor_cdesa,
            'nama_di_cdesa' => $request->nama_di_cdesa,
        ];

        if ($request->jenis_pemilik == 'warga_desa') {
            $request->validate(['penduduk_id' => 'required|exists:penduduk,id']);
            $data['penduduk_id'] = $request->penduduk_id;
        } else {
            $request->validate(['nik_luar' => 'required', 'nama_luar' => 'required']);
            $data['nik_luar'] = $request->nik_luar;
            $data['nama_luar'] = $request->nama_luar;
            $data['alamat_luar'] = $request->alamat_luar;
        }

        CDesa::create($data);

        return redirect()->route('admin.pertanahan.c-desa.index')->with('success', 'Data C-Desa berhasil ditambahkan.');
    }

    // 4. Halaman Rincian C-Desa (Show)
    public function show($id)
    {
        $cdesa = CDesa::with(['penduduk', 'persil'])->findOrFail($id);
        return view('admin.pertanahan.c-desa.show', compact('cdesa'));
    }

    // 5. Simpan Persil Baru
    public function storePersil(Request $request, $id)
    {
        $request->validate([
            'nomor_persil' => 'required|string|max:50',
            'kelas_tanah' => 'required|string|max:20',
            'lokasi' => 'required|string',
            'luas' => 'required|numeric|min:0',
        ]);

        CDesaPersil::create([
            'c_desa_id' => $id,
            'nomor_persil' => $request->nomor_persil,
            'kelas_tanah' => $request->kelas_tanah,
            'lokasi' => $request->lokasi,
            'luas' => $request->luas,
        ]);

        return redirect()->back()->with('success', 'Data Persil berhasil ditambahkan ke C-Desa ini.');
    }

    // 6. Hapus Data
    public function destroy($id)
    {
        CDesa::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data C-Desa beserta persil didalamnya berhasil dihapus.');
    }
}