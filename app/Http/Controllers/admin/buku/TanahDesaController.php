<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuTanahDesa;

class TanahDesaController extends Controller
{
    public function index()
    {
        $tanah = BukuTanahDesa::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.tanah-desa.index', compact('tanah'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.tanah-desa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'luas_tanah' => 'required|numeric|min:0',
            'status_hak_tanah' => 'required|string|max:100',
            'penggunaan_tanah' => 'required|string|max:100',
            'letak_tanah' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        BukuTanahDesa::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.tanah-desa.index')
                         ->with('success', 'Data Buku Tanah di Desa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $tanah = BukuTanahDesa::findOrFail($id);
        return view('admin.buku-administrasi.umum.tanah-desa.edit', compact('tanah'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'luas_tanah' => 'required|numeric|min:0',
            'status_hak_tanah' => 'required|string|max:100',
            'penggunaan_tanah' => 'required|string|max:100',
            'letak_tanah' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $tanah = BukuTanahDesa::findOrFail($id);
        $tanah->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.tanah-desa.index')
                         ->with('success', 'Data Buku Tanah di Desa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $tanah = BukuTanahDesa::findOrFail($id);
        $tanah->delete();

        return redirect()->route('admin.buku-administrasi.umum.tanah-desa.index')
                         ->with('success', 'Data Buku Tanah di Desa berhasil dihapus.');
    }
}