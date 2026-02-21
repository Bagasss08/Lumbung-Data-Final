<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KehadiranBulanan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KehadiranBulananController extends Controller {
    public function index(Request $request) {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        // Ambil data kehadiran bulanan untuk bulan dan tahun tertentu
        $kehadiranData = KehadiranBulanan::with('pegawai')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        // Hitung summary
        $totalPegawai = $kehadiranData->count();
        $totalHadir = $kehadiranData->sum('jumlah_hadir');
        $totalTerlambat = 0; // Placeholder, field tidak ada di migration
        $totalTidakHadir = $kehadiranData->sum('jumlah_alpha');
        $totalIzin = $kehadiranData->sum('jumlah_izin');
        $totalSakit = 0; // Placeholder, field tidak ada di migration

        $summary = [
            'total_pegawai' => $totalPegawai,
            'total_hadir' => $totalHadir,
            'total_terlambat' => $totalTerlambat,
            'total_tidak_hadir' => $totalTidakHadir,
            'total_izin' => $totalIzin,
            'total_sakit' => $totalSakit,
        ];

        return view('admin.kehadiran.rekap-bulanan.index', compact('kehadiranData', 'summary', 'bulan', 'tahun'));
    }

    public function create() {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.kehadiran-bulanan.create', compact('pegawai'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'bulan' => 'required|max:20',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_izin' => 'required|integer|min:0',
            'jumlah_alpha' => 'required|integer|min:0',
            'jumlah_dinas_luar' => 'required|integer|min:0',
            'total_hari_kerja' => 'required|integer|min:0',
            'presentase_kehadiran' => 'required|numeric|min:0|max:100',
        ]);

        KehadiranBulanan::create($validated);

        return redirect()->route('admin.kehadiran-bulanan.index')
            ->with('success', 'Kehadiran bulanan berhasil ditambahkan');
    }

    public function show(KehadiranBulanan $kehadiranBulanan) {
        $kehadiranBulanan->load('pegawai');
        return view('admin.kehadiran.kehadiran-bulanan.show', compact('kehadiranBulanan'));
    }

    public function edit(KehadiranBulanan $kehadiranBulanan) {
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();
        return view('admin.kehadiran.kehadiran-bulanan.edit', compact('kehadiranBulanan', 'pegawai'));
    }

    public function update(Request $request, KehadiranBulanan $kehadiranBulanan) {
        $validated = $request->validate([
            'id_pegawai' => 'required|exists:pegawai,id',
            'bulan' => 'required|max:20',
            'tahun' => 'required|integer|min:2000|max:2100',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_izin' => 'required|integer|min:0',
            'jumlah_alpha' => 'required|integer|min:0',
            'jumlah_dinas_luar' => 'required|integer|min:0',
            'total_hari_kerja' => 'required|integer|min:0',
            'presentase_kehadiran' => 'required|numeric|min:0|max:100',
        ]);

        $kehadiranBulanan->update($validated);

        return redirect()->route('admin.kehadiran-bulanan.index')
            ->with('success', 'Kehadiran bulanan berhasil diupdate');
    }

    public function destroy(KehadiranBulanan $kehadiranBulanan) {
        $kehadiranBulanan->delete();

        return redirect()->route('admin.kehadiran-bulanan.index')
            ->with('success', 'Kehadiran bulanan berhasil dihapus');
    }

    public function rekap(Request $request) {
        $tahun = $request->get('tahun', now()->year);

        // Ambil data kehadiran bulanan untuk seluruh tahun
        $kehadiranBulanan = KehadiranBulanan::with('pegawai')
            ->where('tahun', $tahun)
            ->get()
            ->groupBy(['id_pegawai', 'bulan']);

        // Ambil semua pegawai aktif
        $pegawai = Pegawai::where('status_aktif', 'aktif')->get();

        // Siapkan data untuk tabel bulanan
        $bulananData = [];
        foreach ($pegawai as $peg) {
            $dataPegawai = [
                'pegawai' => $peg,
                'bulan' => []
            ];

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $dataBulan = $kehadiranBulanan->get($peg->id, collect())->get($bulan, null);
                $dataPegawai['bulan'][$bulan] = $dataBulan;
            }

            $bulananData[] = $dataPegawai;
        }

        // Hitung summary tahunan
        $totalPegawai = $pegawai->count();
        $totalHadir = KehadiranBulanan::where('tahun', $tahun)->sum('jumlah_hadir');
        $totalTerlambat = 0; // Placeholder, field tidak ada di migration
        $totalTidakHadir = KehadiranBulanan::where('tahun', $tahun)->sum('jumlah_alpha');
        $totalIzin = KehadiranBulanan::where('tahun', $tahun)->sum('jumlah_izin');
        $totalSakit = 0; // Placeholder, field tidak ada di migration

        $summaryTahunan = [
            'total_pegawai' => $totalPegawai,
            'total_hadir' => $totalHadir,
            'total_terlambat' => $totalTerlambat,
            'total_tidak_hadir' => $totalTidakHadir,
            'total_izin' => $totalIzin,
            'total_sakit' => $totalSakit,
        ];

        return view('admin.kehadiran.rekap-bulanan.index', compact('bulananData', 'summaryTahunan', 'tahun'));
    }
}
