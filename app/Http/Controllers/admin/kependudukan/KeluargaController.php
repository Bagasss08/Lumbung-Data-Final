<?php

namespace App\Http\Controllers\Admin\kependudukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Wilayah;

class KeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluarga::query()->with(['anggota', 'wilayah']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhereHas('anggota', function($q) use ($search) {
                      $q->where('nama', 'like', '%' . $search . '%')
                        ->wherePivot('hubungan_keluarga', 'kepala_keluarga');
                  });
            });
        }



        // Filter by klasifikasi ekonomi
        if ($request->has('klasifikasi_ekonomi') && !empty($request->klasifikasi_ekonomi)) {
            $query->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi);
        }

        $keluarga = $query->paginate(12)->appends($request->query());

        $total_keluarga = Keluarga::count();
        $keluarga_aktif = Keluarga::count(); // Since status was removed, all are considered active
        $keluarga_pindah = 0; // No pindah status anymore
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga', compact('keluarga', 'total_keluarga', 'keluarga_aktif', 'keluarga_pindah', 'penduduk', 'wilayah'));
    }

    public function create()
    {
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga-create', compact('penduduk', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:keluarga,no_kk',
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
        ]);

        $keluarga = Keluarga::create($validated);

        // Attach kepala keluarga via pivot table
        $keluarga->anggota()->attach($request->kepala_keluarga_id, ['hubungan_keluarga' => 'kepala_keluarga']);

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil ditambahkan.');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load(['anggota', 'wilayah']);
        return view('admin.keluarga-show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga-edit', compact('keluarga', 'penduduk', 'wilayah'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:keluarga,no_kk,' . $keluarga->id,
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
        ]);

        $keluarga->update($validated);

        // Update kepala keluarga via pivot table
        // First detach existing kepala keluarga
        $keluarga->anggota()->wherePivot('hubungan_keluarga', 'kepala_keluarga')->detach();

        // Attach new kepala keluarga
        $keluarga->anggota()->attach($request->kepala_keluarga_id, ['hubungan_keluarga' => 'kepala_keluarga']);

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil diperbarui.');
    }

    public function confirmDestroy(Keluarga $keluarga)
    {
        return view('admin.keluarga-delete', compact('keluarga'));
    }

    public function destroy(Keluarga $keluarga)
    {
        // Detach all anggota relationships from pivot table before deleting
        $keluarga->anggota()->detach();

        $keluarga->delete();

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil dihapus.');
    }
}
