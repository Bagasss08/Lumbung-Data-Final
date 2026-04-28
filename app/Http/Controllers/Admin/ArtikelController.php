<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'publish_at' => 'nullable|date',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'publish_at']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
            $data['gambar'] = basename($gambarPath);
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan');
    }

    public function show(Artikel $artikel)
    {
        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'publish_at' => 'nullable|date',
        ]);

        $data = $request->only(['nama', 'deskripsi', 'publish_at']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($artikel->gambar && Storage::disk('public')->exists('artikel/' . $artikel->gambar)) {
                Storage::disk('public')->delete('artikel/' . $artikel->gambar);
            }
            $gambarPath = $request->file('gambar')->store('artikel', 'public');
            $data['gambar'] = basename($gambarPath);
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy(Artikel $artikel)
    {
        // Delete image if exists
        if ($artikel->gambar && Storage::disk('public')->exists('artikel/' . $artikel->gambar)) {
            Storage::disk('public')->delete('artikel/' . $artikel->gambar);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
