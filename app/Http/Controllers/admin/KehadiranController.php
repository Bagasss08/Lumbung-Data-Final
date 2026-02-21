<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HariLibur;
use App\Models\PengaduanKehadiran;
use App\Models\JamKerja;
use App\Models\ShiftKerja;
use App\Models\AlasanKeluar;

class KehadiranController extends Controller
{
    /**
     * Display hari libur page
     */
    public function hariLibur()
    {
        $hariLibur = HariLibur::orderBy('tanggal', 'asc')->get();
        return view('admin.kehadiran.hari-libur', compact('hariLibur'));
    }

    /**
     * Display pengaduan page
     */
    public function pengaduan()
    {
        return view('admin.kehadiran.pengaduan');
    }

    /**
     * Display rekapitulasi page
     */
    public function rekapitulasi()
    {
        return view('admin.kehadiran.rekapitulasi');
    }

    /**
     * Display jam kerja page
     */
    public function jamKerja()
    {
        return view('admin.kehadiran.jam-kerja');
    }

    /**
     * Display alasan keluar page
     */
    public function alasanKeluar()
    {
        return view('admin.kehadiran.alasan-keluar');
    }

    // ============================================
    // HARI LIBUR METHODS
    // ============================================

    /**
     * Store new holiday
     */
    public function storeHariLibur(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_libur' => 'required|string|max:255',
            'jenis' => 'required|in:nasional,cuti_bersama,khusus',
            'keterangan' => 'nullable|string',
        ]);

        HariLibur::create($validated);

        return redirect()->route('admin.kehadiran.hari-libur')
            ->with('success', 'Hari libur berhasil ditambahkan');
    }

    /**
     * Update holiday
     */
    public function updateHariLibur(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_libur' => 'required|string|max:255',
            'jenis' => 'required|in:nasional,cuti_bersama,khusus',
            'keterangan' => 'nullable|string',
        ]);

        HariLibur::findOrFail($id)->update($validated);

        return redirect()->route('admin.kehadiran.hari-libur')
            ->with('success', 'Hari libur berhasil diperbarui');
    }

    /**
     * Delete holiday
     */
    public function destroyHariLibur($id)
    {
        HariLibur::findOrFail($id)->delete();

        return redirect()->route('admin.kehadiran.hari-libur')
            ->with('success', 'Hari libur berhasil dihapus');
    }

    // ============================================
    // PENGADUAN METHODS
    // ============================================

    /**
     * Store new complaint
     */
    public function storePengaduan(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_pegawai' => 'required|string|max:255',
            'jenis_pengaduan' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        // TODO: Simpan data pengaduan
        // Example: PengaduanKehadiran::create($validated);

        return redirect()->route('admin.kehadiran.pengaduan')
            ->with('success', 'Pengaduan berhasil diajukan');
    }

    /**
     * Process complaint
     */
    public function prosesPengaduan(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        // TODO: Update status pengaduan
        // Example: PengaduanKehadiran::findOrFail($id)->update($validated);

        return redirect()->route('admin.kehadiran.pengaduan')
            ->with('success', 'Pengaduan berhasil diproses');
    }

    // ============================================
    // REKAPITULASI METHODS
    // ============================================

    /**
     * Generate rekapitulasi report
     */
    public function generateRekapitulasi(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|in:bulan,tahun,custom',
            'bulan' => 'nullable|date',
            'unit_kerja' => 'nullable|string',
        ]);

        // TODO: Generate rekapitulasi berdasarkan filter
        // Example: $data = Kehadiran::whereMonth('tanggal', $bulan)->get();

        return redirect()->route('admin.kehadiran.rekapitulasi')
            ->with('success', 'Rekapitulasi berhasil dibuat');
    }

    /**
     * Export rekapitulasi to Excel
     */
    public function exportRekapitulasi(Request $request)
    {
        // TODO: Export data ke Excel
        // Example: return Excel::download(new RekapitulasiExport, 'rekapitulasi.xlsx');

        return redirect()->back()
            ->with('info', 'Fitur export dalam pengembangan');
    }

    /**
     * Print rekapitulasi to PDF
     */
    public function cetakRekapitulasi(Request $request)
    {
        // TODO: Generate PDF
        // Example: $pdf = PDF::loadView('admin.kehadiran.pdf-rekapitulasi');
        // return $pdf->download('rekapitulasi.pdf');

        return redirect()->back()
            ->with('info', 'Fitur cetak dalam pengembangan');
    }

    // ============================================
    // JAM KERJA METHODS
    // ============================================

    /**
     * Update jam kerja settings
     */
    public function updateJamKerja(Request $request)
    {
        $validated = $request->validate([
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'jam_istirahat' => 'required|integer|min:0',
            'toleransi_terlambat' => 'required|integer|min:0',
            'weekend_aktif' => 'nullable|boolean',
        ]);

        // TODO: Update pengaturan jam kerja
        // Example: Setting::where('key', 'jam_kerja')->update(['value' => json_encode($validated)]);

        return redirect()->route('admin.kehadiran.jam-kerja')
            ->with('success', 'Jam kerja berhasil diperbarui');
    }

    /**
     * Store new shift
     */
    public function storeShift(Request $request)
    {
        $validated = $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // TODO: Simpan data shift
        // Example: ShiftKerja::create($validated);

        return redirect()->route('admin.kehadiran.jam-kerja')
            ->with('success', 'Shift kerja berhasil ditambahkan');
    }

    /**
     * Update shift
     */
    public function updateShift(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // TODO: Update data shift
        // Example: ShiftKerja::findOrFail($id)->update($validated);

        return redirect()->route('admin.kehadiran.jam-kerja')
            ->with('success', 'Shift kerja berhasil diperbarui');
    }

    /**
     * Delete shift
     */
    public function destroyShift($id)
    {
        // TODO: Hapus data shift
        // Example: ShiftKerja::findOrFail($id)->delete();

        return redirect()->route('admin.kehadiran.jam-kerja')
            ->with('success', 'Shift kerja berhasil dihapus');
    }

    // ============================================
    // ALASAN KELUAR METHODS
    // ============================================

    /**
     * Store new exit permit
     */
    public function storeAlasanKeluar(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'waktu_keluar' => 'required|date_format:H:i',
            'waktu_kembali_estimasi' => 'nullable|date_format:H:i',
            'keperluan' => 'required|in:dinas,pribadi,kesehatan,lainnya',
            'keterangan' => 'required|string',
        ]);

        // TODO: Simpan data izin keluar
        // Example: AlasanKeluar::create(array_merge($validated, ['status' => 'keluar']));

        return redirect()->route('admin.kehadiran.alasan-keluar')
            ->with('success', 'Izin keluar berhasil dibuat');
    }

    /**
     * Check in from exit permit
     */
    public function checkInAlasanKeluar(Request $request, $id)
    {
        $validated = $request->validate([
            'waktu_kembali' => 'required|date_format:H:i',
        ]);

        // TODO: Update waktu kembali
        // Example: 
        // $alasan = AlasanKeluar::findOrFail($id);
        // $alasan->update(['waktu_kembali' => $validated['waktu_kembali'], 'status' => 'kembali']);

        return redirect()->route('admin.kehadiran.alasan-keluar')
            ->with('success', 'Check in berhasil dicatat');
    }

    /**
     * Update exit permit
     */
    public function updateAlasanKeluar(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'waktu_keluar' => 'required|date_format:H:i',
            'waktu_kembali' => 'nullable|date_format:H:i',
            'keperluan' => 'required|in:dinas,pribadi,kesehatan,lainnya',
            'keterangan' => 'required|string',
        ]);

        // TODO: Update data izin keluar
        // Example: AlasanKeluar::findOrFail($id)->update($validated);

        return redirect()->route('admin.kehadiran.alasan-keluar')
            ->with('success', 'Data izin keluar berhasil diperbarui');
    }

    // ============================================
    // EXPORT & PRINT METHODS
    // ============================================

    /**
     * Export data to Excel
     */
    public function export($type)
    {
        // TODO: Implement export functionality
        // Example: return Excel::download(new KehadiranExport($type), "kehadiran-{$type}.xlsx");

        return redirect()->back()
            ->with('info', 'Fitur export dalam pengembangan');
    }

    /**
     * Print report
     */
    public function print($type)
    {
        // TODO: Generate PDF report
        // Example:
        // $pdf = PDF::loadView("admin.kehadiran.print-{$type}");
        // return $pdf->stream("laporan-{$type}.pdf");

        return redirect()->back()
            ->with('info', 'Fitur cetak dalam pengembangan');
    }
}