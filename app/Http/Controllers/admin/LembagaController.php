<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelompokMaster;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        // Mengambil semua data lembaga master
        $lembaga = KelompokMaster::orderBy('created_at', 'desc')->get();
        return view('admin.lembaga.index', compact('lembaga'));
    }

    public function create()
    {
        return view('admin.lembaga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'singkatan' => 'nullable|string|max:20',
            'jenis' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        KelompokMaster::create($request->all());

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Data Master Lembaga berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lembaga = KelompokMaster::findOrFail($id);
        return view('admin.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'singkatan' => 'nullable|string|max:20',
            'jenis' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string'
        ]);

        $lembaga = KelompokMaster::findOrFail($id);
        $lembaga->update($request->all());

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Data Master Lembaga berhasil diperbarui!');
    }

    public function show($id)
    {
        $lembaga = \App\Models\KelompokMaster::findOrFail($id);
        return view('admin.lembaga.show', compact('lembaga'));
    }
    
    public function destroy($id)
    {
        $lembaga = KelompokMaster::findOrFail($id);
        $lembaga->delete();

        return redirect()->route('admin.lembaga.index')
            ->with('success', 'Data Master Lembaga berhasil dihapus!');
    }
}
