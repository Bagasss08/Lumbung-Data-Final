<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\JamKerja;
use Illuminate\Http\Request;

class JamKerjaController extends Controller {
    public function index() {
        $jamKerja = JamKerja::latest()->paginate(10);
        return view('admin.kehadiran.jam-kerja.index', compact('jamKerja'));
    }

    public function create() {
        return view('admin.kehadiran.jam-kerja.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'hari' => 'required|max:20',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'toleransi_terlambat' => 'required|integer|min:0',
            'keterangan' => 'nullable|max:255',
        ]);

        JamKerja::create($validated);

        return redirect()->route('admin.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil ditambahkan');
    }

    public function show(JamKerja $jamKerja) {
        return view('admin.kehadiran.jam-kerja.show', compact('jamKerja'));
    }

    public function edit(JamKerja $jamKerja) {
        return view('admin.kehadiran.jam-kerja.edit', compact('jamKerja'));
    }

    public function update(Request $request, JamKerja $jamKerja) {
        $validated = $request->validate([
            'hari' => 'required|max:20',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'toleransi_terlambat' => 'required|integer|min:0',
            'keterangan' => 'nullable|max:255',
        ]);

        $jamKerja->update($validated);

        return redirect()->route('admin.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil diupdate');
    }

    public function destroy(JamKerja $jamKerja) {
        $jamKerja->delete();

        return redirect()->route('admin.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil dihapus');
    }
}
