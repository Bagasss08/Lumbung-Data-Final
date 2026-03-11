<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\KaderPemberdayaanMasyarakat;
use Illuminate\Http\Request;

class BukuKaderPemberdayaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KaderPemberdayaanMasyarakat::query()->orderBy('nama', 'asc');

        // Filter tahun aktif
        if ($request->filled('tahun')) {
            $query->where('tahun_aktif', $request->tahun);
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'Semua') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('bidang_tugas', 'like', "%{$search}%");
            });
        }

        $kader = $query->paginate(15)->withQueryString();

        // Data untuk dropdown tahun
        $tahunList = KaderPemberdayaanMasyarakat::select('tahun_aktif')
            ->distinct()
            ->whereNotNull('tahun_aktif')
            ->orderBy('tahun_aktif', 'desc')
            ->pluck('tahun_aktif');

        // Statistik
        $totalKader = KaderPemberdayaanMasyarakat::count();
        $lakiLaki = KaderPemberdayaanMasyarakat::where('jenis_kelamin', 'L')->count();
        $perempuan = KaderPemberdayaanMasyarakat::where('jenis_kelamin', 'P')->count();

        return view('admin.buku-administrasi.pembangunan.kader-pemberdayaan.index', 
            compact('kader', 'tahunList', 'totalKader', 'lakiLaki', 'perempuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buku-administrasi.pembangunan.kader-pemberdayaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:100',
            'bidang_tugas' => 'nullable|string|max:255',
            'tahun_aktif' => 'nullable|integer|min:2000|max:2100',
            'keterangan' => 'nullable|string',
        ]);

        try {
            KaderPemberdayaanMasyarakat::create($validated);

            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kader-pemberdayaan.index')
                ->with('success', 'Data kader pemberdayaan masyarakat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KaderPemberdayaanMasyarakat $kaderPemberdayaan)
    {
        return view('admin.buku-administrasi.pembangunan.kader-pemberdayaan.show', compact('kaderPemberdayaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KaderPemberdayaanMasyarakat $kader)
    {
        return view('admin.buku-administrasi.pembangunan.kader-pemberdayaan.edit', compact('kader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KaderPemberdayaanMasyarakat $kaderPemberdayaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'pendidikan' => 'nullable|string|max:100',
            'bidang_tugas' => 'nullable|string|max:255',
            'tahun_aktif' => 'nullable|integer|min:2000|max:2100',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $kaderPemberdayaan->update($validated);

            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kader-pemberdayaan.index')
                ->with('success', 'Data kader pemberdayaan masyarakat berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KaderPemberdayaanMasyarakat $kaderPemberdayaan)
    {
        try {
            $kaderPemberdayaan->delete();
            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kader-pemberdayaan.index')
                ->with('success', 'Data kader pemberdayaan masyarakat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}

