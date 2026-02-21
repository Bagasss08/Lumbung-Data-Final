<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapak;
use App\Models\LapakProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapakProdukController extends Controller {
    public function index(Lapak $lapak) {
        $produk = $lapak->produk()->latest()->paginate(10);
        return view('admin.lapak.produk.index', compact('lapak', 'produk'));
    }

    public function create(Lapak $lapak) {
        return view('admin.lapak.produk.create', compact('lapak'));
    }

    public function store(Request $request, Lapak $lapak) {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:30',
            'status'      => 'required|in:aktif,habis,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('lapak/produk', 'public');
        }

        $validated['lapak_id'] = $lapak->id;

        LapakProduk::create($validated);

        return redirect()->route('admin.lapak.produk.index', $lapak)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Lapak $lapak, LapakProduk $produk) {
        return view('admin.lapak.produk.edit', compact('lapak', 'produk'));
    }

    public function update(Request $request, Lapak $lapak, LapakProduk $produk) {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:30',
            'status'      => 'required|in:aktif,habis,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $validated['foto'] = $request->file('foto')->store('lapak/produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('admin.lapak.produk.index', $lapak)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Lapak $lapak, LapakProduk $produk) {
        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.lapak.produk.index', $lapak)
            ->with('success', 'Produk berhasil dihapus.');
    }
}
