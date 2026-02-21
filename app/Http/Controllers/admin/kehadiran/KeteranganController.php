<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use App\Models\Keterangan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KeteranganController extends Controller {
    public function index() {
        $keterangan = Keterangan::with('pegawai')->latest()->paginate(10);
        return view('admin.kehadiran.keterangan.index', compact('keterangan'));
    }

    public function create() {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.keterangan.create', compact('pegawai'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'jenis_absensi' => 'required|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'nullable',
            'surat_pendukung' => 'nullable|max:255',
            'status_persetujuan' => 'required|in:pending,disetujui,ditolak',
            'pejabar_penyetuju' => 'nullable',
            'keterangan' => 'nullable|max:255',
        ]);

        Keterangan::create($validated);

        return redirect()->route('admin.keterangan.index')
            ->with('success', 'Keterangan berhasil ditambahkan');
    }

    public function show(Keterangan $keterangan) {
        $keterangan->load('pegawai');
        return view('admin.kehadiran.keterangan.show', compact('keterangan'));
    }

    public function edit(Keterangan $keterangan) {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.keterangan.edit', compact('keterangan', 'pegawai'));
    }

    public function update(Request $request, Keterangan $keterangan) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'jenis_absensi' => 'required|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'nullable',
            'surat_pendukung' => 'nullable|max:255',
            'status_persetujuan' => 'required|in:pending,disetujui,ditolak',
            'pejabar_penyetuju' => 'nullable',
            'keterangan' => 'nullable|max:255',
        ]);

        $keterangan->update($validated);

        return redirect()->route('admin.keterangan.index')
            ->with('success', 'Keterangan berhasil diupdate');
    }

    public function destroy(Keterangan $keterangan) {
        $keterangan->delete();

        return redirect()->route('admin.keterangan.index')
            ->with('success', 'Keterangan berhasil dihapus');
    }
}
