<?php

namespace App\Http\Controllers\Admin\Kehadiran;

use App\Http\Controllers\Controller;
use App\Models\JamKerja;
use Illuminate\Http\Request;

class JamKerjaController extends Controller {
    public function index() {
        $jamKerjas = JamKerja::orderBy('jam_masuk')->get();
        return view('admin.kehadiran.jam-kerja.index', compact('jamKerjas'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_shift'             => 'required|string|max:100',
            'jam_masuk'              => 'required|date_format:H:i',
            'jam_keluar'             => 'required|date_format:H:i|after:jam_masuk',
            'jam_istirahat_mulai'    => 'nullable|date_format:H:i',
            'jam_istirahat_selesai'  => 'nullable|date_format:H:i|after:jam_istirahat_mulai',
            'toleransi_menit'        => 'required|integer|min:0|max:120',
            'is_aktif'               => 'boolean',
            'keterangan'             => 'nullable|string|max:500',
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        JamKerja::create($validated);

        return redirect()->route('admin.kehadiran.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil ditambahkan.');
    }

    public function update(Request $request, JamKerja $jamKerja) {
        $validated = $request->validate([
            'nama_shift'             => 'required|string|max:100',
            'jam_masuk'              => 'required|date_format:H:i',
            'jam_keluar'             => 'required|date_format:H:i|after:jam_masuk',
            'jam_istirahat_mulai'    => 'nullable|date_format:H:i',
            'jam_istirahat_selesai'  => 'nullable|date_format:H:i|after:jam_istirahat_mulai',
            'toleransi_menit'        => 'required|integer|min:0|max:120',
            'is_aktif'               => 'boolean',
            'keterangan'             => 'nullable|string|max:500',
        ]);

        $validated['is_aktif'] = $request->boolean('is_aktif', true);

        $jamKerja->update($validated);

        return redirect()->route('admin.kehadiran.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil diperbarui.');
    }

    public function destroy(JamKerja $jamKerja) {
        // Cek apakah sedang dipakai
        if ($jamKerja->kehadiranPegawai()->exists()) {
            return back()->with('error', 'Jam kerja tidak dapat dihapus karena sedang digunakan.');
        }

        $jamKerja->delete();

        return redirect()->route('admin.kehadiran.jam-kerja.index')
            ->with('success', 'Jam kerja berhasil dihapus.');
    }

    public function toggleStatus(JamKerja $jamKerja) {
        $jamKerja->update(['is_aktif' => !$jamKerja->is_aktif]);

        $status = $jamKerja->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Jam kerja berhasil {$status}.");
    }
}
