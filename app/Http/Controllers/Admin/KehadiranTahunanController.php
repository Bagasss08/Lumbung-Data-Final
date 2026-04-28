<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranTahunan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranTahunanController extends Controller {
    public function index(Request $request) {
        $tahun = $request->get('tahun', date('Y'));
        $kehadiranTahunan = KehadiranTahunan::with('pegawai')
            ->where('tahun', $tahun)
            ->latest('tahun')
            ->paginate(10);
        return view('admin.kehadiran.kehadiran-tahunan.index', compact('kehadiranTahunan', 'tahun'));
    }

    public function create() {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.kehadiran-tahunan.create', compact('pegawai'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tahun' => 'required|integer|min:2000|max:2100',
            'total_hari_kerja' => 'required|integer|min:0',
            'total_hadir' => 'required|integer|min:0',
            'total_tidak_hadir' => 'required|integer|min:0',
            'presentase_kehadiran' => 'required|numeric|min:0|max:100',
            'catatan_evaluasi' => 'nullable',
        ]);

        KehadiranTahunan::create($validated);

        return redirect()->route('admin.kehadiran-tahunan.index')
            ->with('success', 'Kehadiran tahunan berhasil ditambahkan');
    }

    public function show(KehadiranTahunan $kehadiranTahunan) {
        $kehadiranTahunan->load('pegawai');
        return view('kehadiran-tahunan.show', compact('kehadiranTahunan'));
    }

    public function edit(KehadiranTahunan $kehadiranTahunan) {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('kehadiran-tahunan.edit', compact('kehadiranTahunan', 'pegawai'));
    }

    public function update(Request $request, KehadiranTahunan $kehadiranTahunan) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tahun' => 'required|integer|min:2000|max:2100',
            'total_hari_kerja' => 'required|integer|min:0',
            'total_hadir' => 'required|integer|min:0',
            'total_tidak_hadir' => 'required|integer|min:0',
            'presentase_kehadiran' => 'required|numeric|min:0|max:100',
            'catatan_evaluasi' => 'nullable',
        ]);

        $kehadiranTahunan->update($validated);

        return redirect()->route('admin.kehadiran-tahunan.index')
            ->with('success', 'Kehadiran tahunan berhasil diupdate');
    }

    public function destroy(KehadiranTahunan $kehadiranTahunan) {
        $kehadiranTahunan->delete();

        return redirect()->route('admin.kehadiran-tahunan.index')
            ->with('success', 'Kehadiran tahunan berhasil dihapus');
    }
}
