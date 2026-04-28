<?php

namespace App\Http\Controllers\Admin\LayananSurat;

use App\Http\Controllers\Controller;
use App\Models\PersyaratanSurat;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    public function index()
    {
        $persyaratan = PersyaratanSurat::latest()->get();
        return view('admin.layanan-surat.persyaratan.index', compact('persyaratan'));
    }

    public function create()
    {
        return view('admin.layanan-surat.persyaratan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        PersyaratanSurat::create($request->all());

        return redirect()->route('admin.layanan-surat.persyaratan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $persyaratan = PersyaratanSurat::findOrFail($id);
        return view('admin.layanan-surat.persyaratan.edit', compact('persyaratan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'nullable'
        ]);

        $persyaratan = PersyaratanSurat::findOrFail($id);
        $persyaratan->update($request->all());

        return redirect()->route('admin.layanan-surat.persyaratan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $persyaratan = PersyaratanSurat::findOrFail($id);
        $persyaratan->delete();

        return redirect()->route('admin.layanan-surat.persyaratan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}