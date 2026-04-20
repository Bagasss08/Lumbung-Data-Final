<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    /**
     * Tampilkan daftar destinasi wisata dengan fitur filter dan search.
     * * @param Request $request
     */
    public function index(Request $request)
    {
        $query = Wisata::query();

        // Fitur Pencarian (Nama, Lokasi, Kategori)
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                  ->orWhere('lokasi', 'like', '%' . $keyword . '%')
                  ->orWhere('kategori', 'like', '%' . $keyword . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $wisatas = $query->latest()->paginate(10)->withQueryString();

        $kategoriList = [
            'Wisata Alam',
            'Wisata Budaya',
            'Wisata Kuliner',
            'Wisata Edukasi',
            'Wisata Religi',
        ];

        // Statistik untuk Dashboard Mini
        $stats = [
            'total'    => Wisata::count(),
            'aktif'    => Wisata::where('status', 'aktif')->count(),
            'nonaktif' => Wisata::where('status', 'nonaktif')->count(),
        ];

        return view('admin.wisata.index', compact('wisatas', 'kategoriList', 'stats'));
    }

    /**
     * Tampilkan form tambah wisata.
     */
    public function create()
    {
        $kategoriList = [
            'Wisata Alam',
            'Wisata Budaya',
            'Wisata Kuliner',
            'Wisata Edukasi',
            'Wisata Religi',
        ];

        return view('admin.wisata.create', compact('kategoriList'));
    }

    /**
     * Simpan data wisata baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lokasi'       => 'nullable|string|max:255',
            'jam_buka'     => 'nullable|string|max:100',
            'harga_tiket'  => 'nullable|string|max:100',
            'fasilitas'    => 'nullable|array',
            'fasilitas.*'  => 'nullable|string|max:100',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        // Proses Upload Gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/wisata
            $file->storeAs('wisata', $filename, 'public');
            $validated['gambar'] = $filename;
        }

        // Pembersihan Array Fasilitas (Menghapus inputan kosong)
        if (!empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(array_filter($validated['fasilitas'], function($value) {
                return !is_null($value) && $value !== '';
            }));
        }

        // Membuat data menggunakan Mass Assignment
        Wisata::create($validated);

        // Perbaikan: Redirect ke 'admin.wisata.index' (Bukan 'wisata.index')
        return redirect()->route('admin.wisata.index')
            ->with('success', 'Destinasi wisata "' . $request->nama . '" berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu wisata.
     */
    public function show(Wisata $wisata)
    {
        return view('admin.wisata.show', compact('wisata'));
    }

    /**
     * Tampilkan halaman edit wisata.
     */
    public function edit(Wisata $wisata)
    {
        $kategoriList = [
            'Wisata Alam',
            'Wisata Budaya',
            'Wisata Kuliner',
            'Wisata Edukasi',
            'Wisata Religi',
        ];

        return view('admin.wisata.edit', compact('wisata', 'kategoriList'));
    }

    /**
     * Update data wisata di database.
     */
    public function update(Request $request, Wisata $wisata)
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'lokasi'       => 'nullable|string|max:255',
            'jam_buka'     => 'nullable|string|max:100',
            'harga_tiket'  => 'nullable|string|max:100',
            'fasilitas'    => 'nullable|array',
            'fasilitas.*'  => 'nullable|string|max:100',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        // Logika Update Gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($wisata->gambar) {
                Storage::delete('public/wisata/' . $wisata->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('wisata', $filename, 'public');
            $validated['gambar'] = $filename;
        } else {
            // Jika tidak upload, jangan timpa field gambar dengan null
            unset($validated['gambar']);
        }

        // Fitur opsional: Hapus gambar secara manual melalui checkbox
        if ($request->boolean('hapus_gambar') && $wisata->gambar) {
            Storage::delete('public/wisata/' . $wisata->gambar);
            $validated['gambar'] = null;
        }

        // Pembersihan Array Fasilitas
        if (!empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(array_filter($validated['fasilitas'], function($value) {
                return !is_null($value) && $value !== '';
            }));
        } else {
            $validated['fasilitas'] = [];
        }

        $wisata->update($validated);

        // Perbaikan: Redirect ke 'admin.wisata.index'
        return redirect()->route('admin.wisata.index')
            ->with('success', 'Data wisata berhasil diperbarui.');
    }

    /**
     * Hapus data wisata dan file gambarnya.
     */
    public function destroy(Wisata $wisata)
    {
        // Hapus file fisik gambar agar storage tidak penuh
        if ($wisata->gambar) {
            Storage::delete('public/wisata/' . $wisata->gambar);
        }

        $wisata->delete();

        // Perbaikan: Redirect ke 'admin.wisata.index'
        return redirect()->route('admin.wisata.index')
            ->with('success', 'Destinasi wisata telah berhasil dihapus selamanya.');
    }

    /**
     * Ubah status aktif/nonaktif secara instan.
     */
    public function toggleStatus(Wisata $wisata)
    {
        $newStatus = ($wisata->status === 'aktif' ? 'nonaktif' : 'aktif');
        
        $wisata->update([
            'status' => $newStatus,
        ]);

        return redirect()->back()
            ->with('success', 'Status wisata "' . $wisata->nama . '" sekarang ' . $newStatus . '.');
    }
}