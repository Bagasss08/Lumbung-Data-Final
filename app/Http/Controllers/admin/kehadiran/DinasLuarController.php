<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\DinasLuar;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DinasLuarController extends Controller {
    public function index() {
        $dinasLuar = DinasLuar::with('pegawai')->latest()->paginate(10);
        return view('admin.kehadiran.dinas-luar.index', compact('dinasLuar'));
    }

    public function create() {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.dinas-luar.create', compact('pegawai'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'nama_kegiatan' => 'required|max:255',
            'lokasi_kegiatan' => 'required|max:255',
            'tanggal_selesai' => 'required|date',
            'instasi_tujuan' => 'nullable',
            'surat_tugas' => 'nullable|max:255',
            'keterangan' => 'nullable|max:255',
        ]);

        DinasLuar::create($validated);

        return redirect()->route('admin.dinas-luar.index')
            ->with('success', 'Dinas luar berhasil ditambahkan');
    }

    public function show(DinasLuar $dinasLuar) {
        $dinasLuar->load('pegawai');
        return view('admin.kehadiran.dinas-luar.show', compact('dinasLuar'));
    }

    public function edit(DinasLuar $dinasLuar) {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.dinas-luar.edit', compact('dinasLuar', 'pegawai'));
    }

    public function update(Request $request, DinasLuar $dinasLuar) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'nama_kegiatan' => 'required|max:255',
            'lokasi_kegiatan' => 'required|max:255',
            'tanggal_selesai' => 'required|date',
            'instasi_tujuan' => 'nullable',
            'surat_tugas' => 'nullable|max:255',
            'keterangan' => 'nullable|max:255',
        ]);

        $dinasLuar->update($validated);

        return redirect()->route('admin.dinas-luar.index')
            ->with('success', 'Dinas luar berhasil diupdate');
    }

    public function destroy(DinasLuar $dinasLuar) {
        $dinasLuar->delete();

        return redirect()->route('admin.dinas-luar.index')
            ->with('success', 'Dinas luar berhasil dihapus');
    }
}
