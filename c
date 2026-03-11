<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\BukuPembangunan;
use App\Models\BukuPembangunanDokumentasi;
use Illuminate\Http\Request;

class BukuActivitiesPembangunanController extends Controller
{
    /**
     * Display a listing of the resource (with progress from dokumentasi).
     */
    public function index(Request $request)
    {
        $query = BukuPembangunan::query()
            ->with('dokumentasis')
            ->orderBy('tahun_anggaran', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter tahun anggaran
        if ($request->filled('tahun')) {
            $query->where('tahun_anggaran', $request->tahun);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('pelaksana', 'like', "%{$search}%")
                    ->orWhere('sumber_dana', 'like', "%{$search}%");
            });
        }

        $pembangunan = $query->paginate(15)->withQueryString();

        // Data untuk dropdown tahun
        $tahunList = BukuPembangunan::select('tahun_anggaran')
            ->distinct()
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');

        return view('admin.buku-administrasi.pembangunan.kegitan.index', compact('pembangunan', 'tahunList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buku-administrasi.pembangunan.kegitan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'id_lokasi' => 'nullable|integer',
            'tahun_anggaran' => 'required|integer|min:2000|max:2100',
            'bidang' => 'nullable|string|max:255',
            'sasaran' => 'nullable|string',
            'volume' => 'nullable|string|max:50',
            'satuan' => 'nullable|string|max:50',
            'pelaksana' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|max:255',
            'anggaran_pemerintah' => 'nullable|numeric|min:0',
            'anggaran_provinsi' => 'nullable|numeric|min:0',
            'anggaran_kabkota' => 'nullable|numeric|min:0',
            'anggaran_swakelola' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        try {
            $validated['aktif'] = $validated['aktif'] ?? 1;
            $pembangunan = BukuPembangunan::create($validated);

            // Jika ada dokumentasi awal
            if ($request->filled('persentase')) {
                BukuPembangunanDokumentasi::create([
                    'id_pembangunan' => $pembangunan->id,
                    'tanggal' => now()->toDateString(),
                    'persentase' => $request->persentase,
                    'keterangan' => $request->keterangan_dokumentasi,
                ]);
            }

            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kegitan.index')
                ->with('success', 'Data kegiatan pembangunan berhasil ditambahkan.');
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
    public function show(BukuPembangunan $kegitan)
    {
        $kegitan->load('dokumentasis');
        return view('admin.buku-administrasi.pembangunan.kegitan.show', compact('kegitan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BukuPembangunan $kegitan)
    {
        return view('admin.buku-administrasi.pembangunan.kegitan.edit', compact('kegitan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BukuPembangunan $kegitan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'id_lokasi' => 'nullable|integer',
            'tahun_anggaran' => 'required|integer|min:2000|max:2100',
            'bidang' => 'nullable|string|max:255',
            'sasaran' => 'nullable|string',
            'volume' => 'nullable|string|max:50',
            'satuan' => 'nullable|string|max:50',
            'pelaksana' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|max:255',
            'anggaran_pemerintah' => 'nullable|numeric|min:0',
            'anggaran_provinsi' => 'nullable|numeric|min:0',
            'anggaran_kabkota' => 'nullable|numeric|min:0',
            'anggaran_swakelola' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
            'aktif' => 'nullable|boolean',
        ]);

        try {
            $validated['aktif'] = $validated['aktif'] ?? 1;
            $kegitan->update($validated);

            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kegitan.index')
                ->with('success', 'Data kegiatan pembangunan berhasil diperbarui.');
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
    public function destroy(BukuPembangunan $kegitan)
    {
        try {
            $kegitan->delete();
            return redirect()
                ->route('admin.buku-administrasi.pembangunan.kegitan.index')
                ->with('success', 'Data kegiatan pembangunan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Store dokumentasi (progress) for a pembangunan.
     */
    public function storeDokumentasi(Request $request, BukuPembangunan $kegitan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'persentase' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('pembangunan/dokumentasi', 'public');
                $validated['foto'] = $path;
            }

            $kegitan->dokumentasis()->create($validated);

            return redirect()
                ->back()
                ->with('success', 'Dokumentasi progress berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan dokumentasi: ' . $e->getMessage());
        }
    }

    /**
     * Delete dokumentasi.
     */
    public function destroyDokumentasi(BukuPembangunanDokumentasi $dokumentasi)
    {
        try {
            $dokumentasi->delete();
            return redirect()
                ->back()
                ->with('success', 'Dokumentasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus dokumentasi: ' . $e->getMessage());
        }
    }
}
