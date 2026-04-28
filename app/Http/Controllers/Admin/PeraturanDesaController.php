<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Pastikan kamu sudah membuat model PeraturanDesa (php artisan make:model PeraturanDesa)
use App\Models\PeraturanDesa; 

class PeraturanDesaController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap request untuk filter dan pencarian
        $query = PeraturanDesa::query();

        // Pencarian berdasarkan keyword
        if ($request->has('cari') && $request->cari != '') {
            $query->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('uraian_singkat', 'like', '%' . $request->cari . '%');
        }

        // Filter Jenis Peraturan
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_peraturan', $request->jenis);
        }

        // Filter Status (is_aktif)
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_aktif', $request->status);
        }

        // Filter Tahun (berdasarkan tanggal_ditetapkan)
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_ditetapkan', $request->tahun);
        }

        // Pagination sesuai dropdown "Tampilkan X entri"
        $perPage = $request->get('per_page', 10);
        
        $data_peraturan = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.buku-administrasi.umum.peraturandesa', compact('data_peraturan'));
    }
    public function create()
    {
        // Ini akan mengarahkan ke halaman form tambah data.
        // Ganti 'peraturandesa-create' dengan nama file blade form kamu nanti jika berbeda.
        return view('admin.buku-administrasi.umum.peraturandesa-create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'uraian_singkat' => 'required',
            'jenis_peraturan' => 'required',
            'tanggal_ditetapkan' => 'nullable|date',
            'dimuat_pada' => 'nullable|date',
            'is_aktif' => 'required|boolean',
        ]);

        PeraturanDesa::create($request->all());

        return redirect()
            ->route('admin.buku-administrasi.umum.peraturan-desa.index')
            ->with('success', 'Data Peraturan Desa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peraturan_desa = PeraturanDesa::findOrFail($id);
        return view('admin.buku-administrasi.umum.peraturandesa-edit', compact('peraturan_desa'));
    }

    public function show($id)
    {
        $peraturan_desa = PeraturanDesa::findOrFail($id);
        return view('admin.buku-administrasi.umum.peraturandesa-show', compact('peraturan_desa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'uraian_singkat' => 'required',
            'jenis_peraturan' => 'required',
            'tanggal_ditetapkan' => 'nullable|date',
            'dimuat_pada' => 'nullable|date',
            'is_aktif' => 'required|boolean',
        ]);

        $peraturan_desa = PeraturanDesa::findOrFail($id);
        $peraturan_desa->update($request->all());

        return redirect()
            ->route('admin.buku-administrasi.umum.peraturan-desa.index')
            ->with('success', 'Data Peraturan Desa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $peraturan_desa = PeraturanDesa::findOrFail($id);
        $peraturan_desa->delete();

        return redirect()
            ->route('admin.buku-administrasi.umum.peraturan-desa.index')
            ->with('success', 'Data Peraturan Desa berhasil dihapus.');
    }

}
