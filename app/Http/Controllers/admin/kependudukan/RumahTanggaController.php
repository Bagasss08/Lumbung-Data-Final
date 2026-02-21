<?php

namespace App\Http\Controllers\Admin\kependudukan;

use App\Http\Controllers\Controller;
use App\Models\RumahTangga;
use Illuminate\Http\Request;

class RumahTanggaController extends Controller
{
    public function index(Request $request)
    {
        $query = RumahTangga::with(['anggota', 'wilayah']);

        // Filter by search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('anggota', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->wherePivot('hubungan_rumah_tangga', 'kepala_rumah_tangga');
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by klasifikasi ekonomi
        if ($request->has('klasifikasi') && !empty($request->klasifikasi)) {
            $query->where('klasifikasi_ekonomi', $request->klasifikasi);
        }

        $rumahTangga = $query->paginate(15);

        // Statistics
        $total_rumah_tangga = RumahTangga::count();
        $rumah_tangga_aktif = $total_rumah_tangga; // Since status is removed, all are considered active
        $rumah_tangga_pindah = 0; // No status field anymore

        return view('admin.rumah-tangga', compact(
            'rumahTangga',
            'total_rumah_tangga',
            'rumah_tangga_aktif',
            'rumah_tangga_pindah'
        ));
    }

    public function create()
    {
        $penduduk = \App\Models\Penduduk::orderBy('nama')->get();
        $wilayah = \App\Models\Wilayah::orderBy('dusun')->orderBy('rt')->orderBy('rw')->get();

        return view('admin.rumah-tangga-create', compact('penduduk', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rumah_tangga' => 'required|string|max:20|unique:rumah_tangga,no_rumah_tangga',
            'kepala_rumah_tangga' => 'required|exists:penduduk,id',
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'jumlah_anggota' => 'required|integer|min:1',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'tgl_terdaftar' => 'required|date',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
        ]);

        $rumahTangga = \App\Models\RumahTangga::create([
            'no_rumah_tangga' => $validated['no_rumah_tangga'],
            'alamat' => $validated['alamat'],
            'wilayah_id' => $validated['wilayah_id'],
            'jumlah_anggota' => $validated['jumlah_anggota'],
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'],
            'tgl_terdaftar' => $validated['tgl_terdaftar'],
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'],
        ]);

        // Attach kepala rumah tangga via pivot table
        $rumahTangga->anggota()->attach($validated['kepala_rumah_tangga'], [
            'hubungan_rumah_tangga' => 'kepala_rumah_tangga'
        ]);

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', 'Rumah tangga berhasil ditambahkan');
    }

    public function show(RumahTangga $rumahTangga)
    {
        $rumahTangga->load(['anggota', 'wilayah']);
        return view('admin.rumah-tangga-show', compact('rumahTangga'));
    }

    public function confirmDestroy(RumahTangga $rumahTangga)
    {
        return view('admin.rumah-tangga-delete', compact('rumahTangga'));
    }

    public function edit(RumahTangga $rumahTangga)
    {
        $penduduk = \App\Models\Penduduk::orderBy('nama')->get();
        $wilayah = \App\Models\Wilayah::orderBy('dusun')->orderBy('rt')->orderBy('rw')->get();

        return view('admin.rumah-tangga-edit', compact('rumahTangga', 'penduduk', 'wilayah'));
    }

    public function update(Request $request, RumahTangga $rumahTangga)
    {
        $validated = $request->validate([
            'no_rumah_tangga' => 'required|string|max:20|unique:rumah_tangga,no_rumah_tangga,' . $rumahTangga->id,
            'kepala_rumah_tangga' => 'required|exists:penduduk,id',
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'jumlah_anggota' => 'required|integer|min:1',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'tgl_terdaftar' => 'required|date',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
        ]);

        $rumahTangga->update([
            'no_rumah_tangga' => $validated['no_rumah_tangga'],
            'alamat' => $validated['alamat'],
            'wilayah_id' => $validated['wilayah_id'],
            'jumlah_anggota' => $validated['jumlah_anggota'],
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'],
            'tgl_terdaftar' => $validated['tgl_terdaftar'],
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'],
        ]);

        // Handle kepala rumah tangga change
        $currentKepalaId = $rumahTangga->kepalaRumahTangga()?->id;
        if ($currentKepalaId && $currentKepalaId != $validated['kepala_rumah_tangga']) {
            // Detach old kepala rumah tangga
            $rumahTangga->anggota()->detach($currentKepalaId);
        }

        // Attach new kepala rumah tangga if not already attached
        if (!$rumahTangga->anggota()->where('penduduk_id', $validated['kepala_rumah_tangga'])->exists()) {
            $rumahTangga->anggota()->attach($validated['kepala_rumah_tangga'], [
                'hubungan_rumah_tangga' => 'kepala_rumah_tangga'
            ]);
        }

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', 'Rumah tangga berhasil diperbarui');
    }

    public function destroy(RumahTangga $rumahTangga)
    {
        // Detach all anggota relationships from pivot table before deleting
        $rumahTangga->anggota()->detach();

        $rumahTangga->delete();

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', 'Rumah tangga berhasil dihapus');
    }
}
