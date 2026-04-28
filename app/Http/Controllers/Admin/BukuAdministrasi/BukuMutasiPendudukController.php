<?php
// app/Http/Controllers/Admin/BukuAdministrasi/BukuMutasiPendudukController.php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\MutasiPenduduk;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class BukuMutasiPendudukController extends Controller {
    public function index(Request $request) {
        $query = MutasiPenduduk::query()->orderBy('tanggal_mutasi', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_surat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_mutasi') && $request->jenis_mutasi !== 'Semua') {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_mutasi', $request->tahun);
        }

        $mutasi      = $query->paginate(15)->withQueryString();
        $totalMasuk  = MutasiPenduduk::pindahMasuk()->count();
        $totalKeluar = MutasiPenduduk::pindahKeluar()->count();
        $total       = MutasiPenduduk::count();

        // Untuk dropdown tahun
        $tahunList = MutasiPenduduk::selectRaw('YEAR(tanggal_mutasi) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view(
            'admin.buku-administrasi.penduduk.mutasi-penduduk.index',
            compact('mutasi', 'totalMasuk', 'totalKeluar', 'total', 'tahunList')
        );
    }

    public function create() {
        $pendudukList = Penduduk::orderBy('nama')->get(['id', 'nik', 'nama']);
        return view(
            'admin.buku-administrasi.penduduk.mutasi-penduduk.create',
            compact('pendudukList')
        );
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'penduduk_id'    => 'nullable|exists:penduduk,id',
            'nik'            => 'required|string|max:16',
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|string|max:20',
            'no_kk'          => 'nullable|string|max:16',
            'jenis_mutasi'   => 'required|in:pindah_masuk,pindah_keluar',
            'tanggal_mutasi' => 'required|date',
            'asal'           => 'nullable|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'no_surat'       => 'nullable|string|max:100',
            'alasan'         => 'nullable|string',
            'keterangan'     => 'nullable|string',
        ]);

        MutasiPenduduk::create($validated);

        return redirect()
            ->route('admin.buku-administrasi.penduduk.mutasi-penduduk.index')
            ->with('success', 'Data mutasi penduduk berhasil ditambahkan.');
    }

    public function show(MutasiPenduduk $mutasiPenduduk) {
        return view(
            'admin.buku-administrasi.penduduk.mutasi-penduduk.show',
            compact('mutasiPenduduk')
        );
    }

    public function edit(MutasiPenduduk $mutasiPenduduk) {
        $pendudukList = Penduduk::orderBy('nama')->get(['id', 'nik', 'nama']);
        return view(
            'admin.buku-administrasi.penduduk.mutasi-penduduk.edit',
            compact('mutasiPenduduk', 'pendudukList')
        );
    }

    public function update(Request $request, MutasiPenduduk $mutasiPenduduk) {
        $validated = $request->validate([
            'penduduk_id'    => 'nullable|exists:penduduk,id',
            'nik'            => 'required|string|max:16',
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|string|max:20',
            'no_kk'          => 'nullable|string|max:16',
            'jenis_mutasi'   => 'required|in:pindah_masuk,pindah_keluar',
            'tanggal_mutasi' => 'required|date',
            'asal'           => 'nullable|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'no_surat'       => 'nullable|string|max:100',
            'alasan'         => 'nullable|string',
            'keterangan'     => 'nullable|string',
        ]);

        $mutasiPenduduk->update($validated);

        return redirect()
            ->route('admin.buku-administrasi.penduduk.mutasi-penduduk.index')
            ->with('success', 'Data mutasi penduduk berhasil diperbarui.');
    }

    public function destroy(MutasiPenduduk $mutasiPenduduk) {
        $mutasiPenduduk->delete();

        return redirect()
            ->route('admin.buku-administrasi.penduduk.mutasi-penduduk.index')
            ->with('success', 'Data mutasi penduduk berhasil dihapus.');
    }
}
