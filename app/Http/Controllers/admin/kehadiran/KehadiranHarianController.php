<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\KehadiranHarian;
use App\Models\Pegawai;
use App\Models\JenisKehadiran;
use Illuminate\Http\Request;

class KehadiranHarianController extends Controller {
    public function index() {
        $kehadiran = KehadiranHarian::with(['pegawai', 'jenisKehadiran'])
            ->latest('tanggal')
            ->paginate(10);
        return view('admin.kehadiran.kehadiran-harian.index', compact('kehadiran'));
    }

    public function create() {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        $jenisKehadiran = JenisKehadiran::all();
        return view('admin.kehadiran.kehadiran-harian.create', compact('pegawai', 'jenisKehadiran'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tanggal' => 'required|date',
            'hari' => 'required|max:20',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'id_jenis_kehadiran' => 'required|exists:jenis_kehadiran,id',
            'lokasi_absen' => 'nullable|max:255',
            'metode_absen' => 'required|in:manual,fingerprint,qr',
            'keterangan' => 'nullable|max:255',
        ]);

        KehadiranHarian::create($validated);

        return redirect()->route('admin.kehadiran-harian.index')
            ->with('success', 'Kehadiran berhasil dicatat');
    }

    public function show(KehadiranHarian $kehadiranHarian) {
        $kehadiranHarian->load(['pegawai', 'jenisKehadiran']);
        return view('admin.kehadiran.kehadiran-harian.show', compact('kehadiranHarian'));
    }

    public function edit(KehadiranHarian $kehadiranHarian) {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        $jenisKehadiran = JenisKehadiran::all();
        return view('admin.kehadiran.kehadiran-harian.edit', compact('kehadiranHarian', 'pegawai', 'jenisKehadiran'));
    }

    public function update(Request $request, KehadiranHarian $kehadiranHarian) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'tanggal' => 'required|date',
            'hari' => 'required|max:20',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'id_jenis_kehadiran' => 'required|exists:jenis_kehadiran,id',
            'lokasi_absen' => 'nullable|max:255',
            'metode_absen' => 'required|in:manual,fingerprint,qr',
            'keterangan' => 'nullable|max:255',
        ]);

        $kehadiranHarian->update($validated);

        return redirect()->route('admin.kehadiran-harian.index')
            ->with('success', 'Kehadiran berhasil diupdate');
    }

    public function destroy(KehadiranHarian $kehadiranHarian) {
        $kehadiranHarian->delete();

        return redirect()->route('admin.kehadiran-harian.index')
            ->with('success', 'Kehadiran berhasil dihapus');
    }
}
