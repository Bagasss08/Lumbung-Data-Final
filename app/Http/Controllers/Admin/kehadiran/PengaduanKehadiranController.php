<?php

namespace App\Http\Controllers\Admin\Kehadiran;

use App\Http\Controllers\Controller;
use App\Models\PengaduanKehadiran;
use App\Models\KehadiranPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanKehadiranController extends Controller {
    public function index(Request $request) {
        $status = $request->get('status', 'pending');

        $pengaduans = PengaduanKehadiran::with('perangkat')
            ->when($status !== 'semua', fn($q) => $q->where('status', $status))
            ->orderByRaw("FIELD(status, 'pending', 'disetujui', 'ditolak')")
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $totalPending = PengaduanKehadiran::pending()->count();

        return view('admin.kehadiran.pengaduan-kehadiran.index', compact(
            'pengaduans',
            'status',
            'totalPending'
        ));
    }

    public function show(PengaduanKehadiran $pengaduanKehadiran) {
        $pengaduanKehadiran->load('perangkat', 'pemroses');

        // Ambil data kehadiran asli di tanggal tersebut
        $kehadiranAsli = KehadiranPegawai::where('perangkat_id', $pengaduanKehadiran->perangkat_id)
            ->whereDate('tanggal', $pengaduanKehadiran->tanggal_kehadiran)
            ->with('jamKerja')
            ->first();

        return view('admin.kehadiran.pengaduan-kehadiran.show', compact(
            'pengaduanKehadiran',
            'kehadiranAsli'
        ));
    }

    public function approve(Request $request, PengaduanKehadiran $pengaduanKehadiran) {
        if ($pengaduanKehadiran->status !== 'pending') {
            return back()->with('error', 'Pengaduan ini sudah diproses.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        // Update data kehadiran asli sesuai pengaduan
        $kehadiran = KehadiranPegawai::where('perangkat_id', $pengaduanKehadiran->perangkat_id)
            ->whereDate('tanggal', $pengaduanKehadiran->tanggal_kehadiran)
            ->first();

        if ($kehadiran) {
            $kehadiran->update([
                'jam_masuk_aktual'  => $pengaduanKehadiran->jam_masuk_diajukan  ?? $kehadiran->jam_masuk_aktual,
                'jam_keluar_aktual' => $pengaduanKehadiran->jam_keluar_diajukan ?? $kehadiran->jam_keluar_aktual,
                'status'            => $pengaduanKehadiran->status_diajukan      ?? $kehadiran->status,
                'keterangan'        => 'Dikoreksi via pengaduan #' . $pengaduanKehadiran->id,
            ]);
        }

        $pengaduanKehadiran->update([
            'status'        => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
        ]);

        return redirect()->route('admin.kehadiran.pengaduan-kehadiran.index')
            ->with('success', 'Pengaduan disetujui dan data kehadiran telah diperbarui.');
    }

    public function reject(Request $request, PengaduanKehadiran $pengaduanKehadiran) {
        if ($pengaduanKehadiran->status !== 'pending') {
            return back()->with('error', 'Pengaduan ini sudah diproses.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);

        $pengaduanKehadiran->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
            'diproses_oleh' => Auth::id(),
            'diproses_pada' => now(),
        ]);

        return redirect()->route('admin.kehadiran.pengaduan-kehadiran.index')
            ->with('success', 'Pengaduan telah ditolak.');
    }

    public function destroy(PengaduanKehadiran $pengaduanKehadiran) {
        if ($pengaduanKehadiran->bukti_file) {
            Storage::delete($pengaduanKehadiran->bukti_file);
        }

        $pengaduanKehadiran->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus.');
    }
}
