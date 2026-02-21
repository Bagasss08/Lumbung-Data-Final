<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lapak;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LapakController extends Controller {
    public function index(Request $request) {
        $query = Lapak::with('penduduk')
            ->withCount('produk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_toko', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhereHas('penduduk', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lapak = $query->latest()->paginate(10)->withQueryString();

        return view('admin.lapak.index', compact('lapak'));
    }

    public function create() {
        $penduduk = Penduduk::orderBy('nama')->get();
        return view('admin.lapak.create', compact('penduduk'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'nama_toko'   => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'telepon'     => 'nullable|string|max:20',
            'alamat'      => 'nullable|string',
            'link_maps'   => 'nullable|url|max:500',
            'status'      => 'required|in:aktif,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('lapak/toko', 'public');
        }

        $validated['slug'] = Str::slug($validated['nama_toko']);

        Lapak::create($validated);

        return redirect()->route('admin.lapak.index')
            ->with('success', 'Lapak berhasil ditambahkan.');
    }

    public function show(Lapak $lapak) {
        $lapak->load(['penduduk', 'produk']);
        return view('admin.lapak.show', compact('lapak'));
    }

    public function edit(Lapak $lapak) {
        $penduduk = Penduduk::orderBy('nama')->get();
        return view('admin.lapak.edit', compact('lapak', 'penduduk'));
    }

    public function update(Request $request, Lapak $lapak) {
        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'nama_toko'   => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'telepon'     => 'nullable|string|max:20',
            'alamat'      => 'nullable|string',
            'link_maps'   => 'nullable|url|max:500',
            'status'      => 'required|in:aktif,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($lapak->foto) {
                Storage::disk('public')->delete($lapak->foto);
            }
            $validated['foto'] = $request->file('foto')->store('lapak/toko', 'public');
        }

        $lapak->update($validated);

        return redirect()->route('admin.lapak.index')
            ->with('success', 'Lapak berhasil diperbarui.');
    }

    public function destroy(Lapak $lapak) {
        if ($lapak->foto) {
            Storage::disk('public')->delete($lapak->foto);
        }

        // Hapus semua foto produk
        foreach ($lapak->produk as $produk) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
        }

        $lapak->delete();

        return redirect()->route('admin.lapak.index')
            ->with('success', 'Lapak berhasil dihapus.');
    }

    public function toggleStatus(Lapak $lapak) {
        $lapak->update([
            'status' => $lapak->status === 'aktif' ? 'nonaktif' : 'aktif'
        ]);

        return back()->with('success', 'Status lapak berhasil diubah.');
    }
}
