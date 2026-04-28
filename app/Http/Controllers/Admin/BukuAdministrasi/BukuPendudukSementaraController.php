<?php
// app/Http/Controllers/Admin/BukuAdministrasi/BukuPendudukSementaraController.php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\PendudukSementara;
use Illuminate\Http\Request;

class BukuPendudukSementaraController extends Controller {
    public function index(Request $request) {
        $query = PendudukSementara::query()->orderBy('tanggal_datang', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama', 'like', "%$s%")
                ->orWhere('nik', 'like', "%$s%")
                ->orWhere('asal_daerah', 'like', "%$s%"));
        }

        if ($request->filled('status')) {
            if ($request->status === 'ada') $query->masihAda();
            elseif ($request->status === 'pergi') $query->sudahPergi();
        }

        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'Semua') {
            $map = ['Laki-laki' => 'L', 'Perempuan' => 'P'];
            $query->where('jenis_kelamin', $map[$request->jenis_kelamin] ?? $request->jenis_kelamin);
        }

        $penduduk    = $query->paginate(15)->withQueryString();
        $total       = PendudukSementara::count();
        $masihAda    = PendudukSementara::masihAda()->count();
        $sudahPergi  = PendudukSementara::sudahPergi()->count();

        return view(
            'admin.buku-administrasi.penduduk.penduduk-sementara.index',
            compact('penduduk', 'total', 'masihAda', 'sudahPergi')
        );
    }

    public function create() {
        return view('admin.buku-administrasi.penduduk.penduduk-sementara.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik'               => 'nullable|string|max:16',
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:L,P',
            'tempat_lahir'      => 'nullable|string|max:100',
            'tanggal_lahir'     => 'nullable|date',
            'agama'             => 'nullable|string|max:20',
            'pekerjaan'         => 'nullable|string|max:100',
            'kewarganegaraan'   => 'nullable|string|max:50',
            'asal_daerah'       => 'nullable|string|max:255',
            'tujuan_kedatangan' => 'nullable|string|max:255',
            'tanggal_datang'    => 'required|date',
            'tanggal_pergi'     => 'nullable|date|after_or_equal:tanggal_datang',
            'no_surat_ket'      => 'nullable|string|max:100',
            'tempat_menginap'   => 'nullable|string|max:255',
            'keterangan'        => 'nullable|string',
        ]);

        PendudukSementara::create($validated);

        return redirect()
            ->route('admin.buku-administrasi.penduduk.penduduk-sementara.index')
            ->with('success', 'Data penduduk sementara berhasil ditambahkan.');
    }

    public function show(PendudukSementara $pendudukSementara) {
        return view(
            'admin.buku-administrasi.penduduk.penduduk-sementara.show',
            compact('pendudukSementara')
        );
    }

    public function edit(PendudukSementara $pendudukSementara) {
        return view(
            'admin.buku-administrasi.penduduk.penduduk-sementara.edit',
            compact('pendudukSementara')
        );
    }

    public function update(Request $request, PendudukSementara $pendudukSementara) {
        $validated = $request->validate([
            'nik'               => 'nullable|string|max:16',
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:L,P',
            'tempat_lahir'      => 'nullable|string|max:100',
            'tanggal_lahir'     => 'nullable|date',
            'agama'             => 'nullable|string|max:20',
            'pekerjaan'         => 'nullable|string|max:100',
            'kewarganegaraan'   => 'nullable|string|max:50',
            'asal_daerah'       => 'nullable|string|max:255',
            'tujuan_kedatangan' => 'nullable|string|max:255',
            'tanggal_datang'    => 'required|date',
            'tanggal_pergi'     => 'nullable|date|after_or_equal:tanggal_datang',
            'no_surat_ket'      => 'nullable|string|max:100',
            'tempat_menginap'   => 'nullable|string|max:255',
            'keterangan'        => 'nullable|string',
        ]);

        $pendudukSementara->update($validated);

        return redirect()
            ->route('admin.buku-administrasi.penduduk.penduduk-sementara.index')
            ->with('success', 'Data penduduk sementara berhasil diperbarui.');
    }

    public function destroy(PendudukSementara $pendudukSementara) {
        $pendudukSementara->delete();

        return redirect()
            ->route('admin.buku-administrasi.penduduk.penduduk-sementara.index')
            ->with('success', 'Data penduduk sementara berhasil dihapus.');
    }
}
