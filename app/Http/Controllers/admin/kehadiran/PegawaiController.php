<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller {
    public function index() {
        $pegawai = Pegawai::latest()->paginate(10);
        return view('admin.kehadiran.pegawai.index', compact('pegawai'));
    }

    public function create() {
        return view('admin.kehadiran.pegawai.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik' => 'required|unique:pegawai,nik|max:16',
            'nip' => 'nullable|max:18',
            'nama_lengkap' => 'required|max:100',
            'jabatan' => 'nullable|max:100',
            'unit_kerja' => 'nullable|max:100',
            'status_kepegawaian' => 'required|in:PNS,honorer,perangkat desa',
            'alamat' => 'nullable',
            'nomor_telepon' => 'nullable|max:15',
            'status_aktif' => 'required|in:aktif,tidak aktif',
        ]);

        Pegawai::create($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function show(Pegawai $pegawai) {
        return view('admin.kehadiran.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai) {
        return view('admin.kehadiran.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai) {
        $validated = $request->validate([
            'nik' => 'required|max:16|unique:pegawai,nik,' . $pegawai->id,
            'nip' => 'nullable|max:18',
            'nama_lengkap' => 'required|max:100',
            'jabatan' => 'nullable|max:100',
            'unit_kerja' => 'nullable|max:100',
            'status_kepegawaian' => 'required|in:PNS,honorer,perangkat desa',
            'alamat' => 'nullable',
            'nomor_telepon' => 'nullable|max:15',
            'status_aktif' => 'required|in:aktif,tidak aktif',
        ]);

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    public function destroy(Pegawai $pegawai) {
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus');
    }
}
