<?php

namespace App\Http\Controllers\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\InfoDesa\LembagaKategori;
use Illuminate\Http\Request;

class LembagaKategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = LembagaKategori::withCount('lembagaDesa')
            ->orderBy('nama')
            ->paginate(25)
            ->withQueryString();

        return view('admin.info-desa.lembaga-kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.info-desa.lembaga-kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:lembaga_kategoris,nama',
            'deskripsi' => 'nullable|string',
        ]);

        LembagaKategori::create($request->only(['nama', 'deskripsi']));

        return redirect()->route('admin.lembaga-kategori.index')
            ->with('success', 'Kategori lembaga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = LembagaKategori::findOrFail($id);
        return view('admin.info-desa.lembaga-kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = LembagaKategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:lembaga_kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->only(['nama', 'deskripsi']));

        return redirect()->route('admin.lembaga-kategori.index')
            ->with('success', 'Kategori lembaga berhasil diperbarui.');
    }

    public function destroy(Request $request, $id = null)
    {
        $ids = $request->input('ids', []);

        if ($id) {
            $ids = array_merge($ids, [$id]);
        }

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada kategori yang dipilih untuk dihapus.');
        }

        foreach ($ids as $kategoriId) {
            $kategori = LembagaKategori::withCount('lembagaDesa')->find($kategoriId);

            if (!$kategori) {
                continue;
            }

            if ($kategori->lembaga_desa_count > 0) {
                return back()->with('error', "Kategori '{$kategori->nama}' tidak dapat dihapus karena memiliki lembaga aktif.");
            }

            $kategori->delete();
        }

        return redirect()->route('admin.lembaga-kategori.index')->with('success', 'Kategori lembaga berhasil dihapus.');
    }
}
