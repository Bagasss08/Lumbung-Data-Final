<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\JenisKehadiran;
use Illuminate\Http\Request;

class JenisKehadiranController extends Controller {
    public function index() {
        $jenisKehadiran = JenisKehadiran::latest()->paginate(10);
        return view('admin.kehadiran.jenis-kehadiran.index', compact('jenisKehadiran'));
    }

    public function create() {
        return view('admin.kehadiran.jenis-kehadiran.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'kode_kehadiran' => 'required|unique:jenis_kehadiran,kode_kehadiran|max:10',
            'nama_kehadiran' => 'required|max:100',
            'keterangan' => 'nullable',
        ]);

        JenisKehadiran::create($validated);

        return redirect()->route('admin.jenis-kehadiran.index')
            ->with('success', 'Jenis kehadiran berhasil ditambahkan');
    }

    public function show(JenisKehadiran $jenisKehadiran) {
        return view('admin.kehadiran.jenis-kehadiran.show', compact('jenisKehadiran'));
    }

    public function edit(JenisKehadiran $jenisKehadiran) {
        return view('admin.kehadiran.jenis-kehadiran.edit', compact('jenisKehadiran'));
    }

    public function update(Request $request, JenisKehadiran $jenisKehadiran) {
        $validated = $request->validate([
            'kode_kehadiran' => 'required|max:10|unique:jenis_kehadiran,kode_kehadiran,' . $jenisKehadiran->id,
            'nama_kehadiran' => 'required|max:100',
            'keterangan' => 'nullable',
        ]);

        $jenisKehadiran->update($validated);

        return redirect()->route('admin.jenis-kehadiran.index')
            ->with('success', 'Jenis kehadiran berhasil diupdate');
    }

    public function destroy(JenisKehadiran $jenisKehadiran) {
        $jenisKehadiran->delete();

        return redirect()->route('admin.jenis-kehadiran.index')
            ->with('success', 'Jenis kehadiran berhasil dihapus');
    }
}
