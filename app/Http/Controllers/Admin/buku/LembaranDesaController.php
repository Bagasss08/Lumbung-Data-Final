<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuLembaranDesa;

class LembaranDesaController extends Controller
{
    public function index()
    {
        $lembaran = BukuLembaranDesa::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.lembaran-desa.index', compact('lembaran'));
    }

    public function create()
    {
        return view('admin.buku-administrasi.umum.lembaran-desa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_peraturan' => 'required|string|max:255',
            'nomor_ditetapkan' => 'required|string|max:255',
            'tanggal_ditetapkan' => 'required|date',
            'tentang' => 'required|string',
            'tanggal_diundangkan_lembaran' => 'nullable|date',
            'nomor_diundangkan_lembaran' => 'nullable|string|max:255',
            'tanggal_diundangkan_berita' => 'nullable|date',
            'nomor_diundangkan_berita' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        BukuLembaranDesa::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.lembaran-desa.index')
                         ->with('success', 'Data Lembaran/Berita Desa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $lembaran = BukuLembaranDesa::findOrFail($id);
        return view('admin.buku-administrasi.umum.lembaran-desa.edit', compact('lembaran'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'jenis_peraturan' => 'required|string|max:255',
            'nomor_ditetapkan' => 'required|string|max:255',
            'tanggal_ditetapkan' => 'required|date',
            'tentang' => 'required|string',
            'tanggal_diundangkan_lembaran' => 'nullable|date',
            'nomor_diundangkan_lembaran' => 'nullable|string|max:255',
            'tanggal_diundangkan_berita' => 'nullable|date',
            'nomor_diundangkan_berita' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $lembaran = BukuLembaranDesa::findOrFail($id);
        $lembaran->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.lembaran-desa.index')
                         ->with('success', 'Data Lembaran/Berita Desa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $lembaran = BukuLembaranDesa::findOrFail($id);
        $lembaran->delete();

        return redirect()->route('admin.buku-administrasi.umum.lembaran-desa.index')
                         ->with('success', 'Data Lembaran/Berita Desa berhasil dihapus.');
    }
}