<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BukuKeputusan; // Pastikan Anda sudah membuat Model ini

class KeputusanController extends Controller
{
    /**
     * Menampilkan daftar buku keputusan.
     */
    public function index()
    {
        $keputusan = BukuKeputusan::latest()->paginate(10);
        return view('admin.buku-administrasi.umum.keputusan.index', compact('keputusan'));
    }

    /**
     * Menampilkan form untuk menambah data.
     */
    public function create()
    {
        return view('admin.buku-administrasi.umum.keputusan.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_keputusan' => 'required|string|max:255',
            'tanggal_keputusan' => 'required|date',
            'tentang' => 'required|string',
            'uraian_singkat' => 'nullable|string',
            'nomor_dilaporkan' => 'nullable|string|max:255',
            'tanggal_dilaporkan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        BukuKeputusan::create($validated);

        return redirect()->route('keputusan.index')->with('success', 'Data Keputusan Kepala Desa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(string $id)
    {
        $keputusan = BukuKeputusan::findOrFail($id);
        return view('admin.buku-administrasi.umum.keputusan.edit', compact('keputusan'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nomor_keputusan' => 'required|string|max:255',
            'tanggal_keputusan' => 'required|date',
            'tentang' => 'required|string',
            'uraian_singkat' => 'nullable|string',
            'nomor_dilaporkan' => 'nullable|string|max:255',
            'tanggal_dilaporkan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $keputusan = BukuKeputusan::findOrFail($id);
        $keputusan->update($validated);

        return redirect()->route('keputusan.index')->with('success', 'Data Keputusan Kepala Desa berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(string $id)
    {
        $keputusan = BukuKeputusan::findOrFail($id);
        $keputusan->delete();

        return redirect()->route('keputusan.index')->with('success', 'Data Keputusan Kepala Desa berhasil dihapus.');
    }
}