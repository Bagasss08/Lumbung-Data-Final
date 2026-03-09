<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuTanahKasDesa;

class TanahKasDesaController extends Controller
{
    public function index()
    {
        $tanahKas = BukuTanahKasDesa::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.tanah-kas-desa.index', compact('tanahKas'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.tanah-kas-desa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asal_tanah_kas_desa' => 'required|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'luas' => 'required|numeric|min:0',
            'kelas' => 'nullable|string|max:100',
            'asal_perolehan' => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'jenis_tanah' => 'required|string|max:100',
            'status_patok' => 'required|in:Ada,Tidak Ada',
            'status_papan_nama' => 'required|in:Ada,Tidak Ada',
            'lokasi' => 'required|string',
            'peruntukan' => 'nullable|string|max:255',
            'mutasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        BukuTanahKasDesa::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.tanah-kas-desa.index')
                         ->with('success', 'Data Buku Tanah Kas Desa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $tanahKas = BukuTanahKasDesa::findOrFail($id);
        return view('admin.buku-administrasi.umum.tanah-kas-desa.edit', compact('tanahKas'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'asal_tanah_kas_desa' => 'required|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'luas' => 'required|numeric|min:0',
            'kelas' => 'nullable|string|max:100',
            'asal_perolehan' => 'required|string|max:255',
            'tanggal_perolehan' => 'required|date',
            'jenis_tanah' => 'required|string|max:100',
            'status_patok' => 'required|in:Ada,Tidak Ada',
            'status_papan_nama' => 'required|in:Ada,Tidak Ada',
            'lokasi' => 'required|string',
            'peruntukan' => 'nullable|string|max:255',
            'mutasi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $tanahKas = BukuTanahKasDesa::findOrFail($id);
        $tanahKas->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.tanah-kas-desa.index')
                         ->with('success', 'Data Buku Tanah Kas Desa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $tanahKas = BukuTanahKasDesa::findOrFail($id);
        $tanahKas->delete();

        return redirect()->route('admin.buku-administrasi.umum.tanah-kas-desa.index')
                         ->with('success', 'Data Buku Tanah Kas Desa berhasil dihapus.');
    }
}