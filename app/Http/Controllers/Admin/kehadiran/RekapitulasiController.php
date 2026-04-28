<?php

namespace App\Http\Controllers\Admin\Kehadiran;

use App\Http\Controllers\Controller;
use App\Models\KehadiranPegawai;
use App\Models\PerangkatDesa;
use App\Models\JamKerja;
use App\Exports\RekapitulasiKehadiranExport;
use App\Traits\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapitulasiController extends Controller 
{
    use ActivityLogger;

    public function index(Request $request) {
        $bulan     = $request->integer('bulan', now()->month);
        $tahun     = $request->integer('tahun', now()->year);
        $perangkatId = $request->integer('perangkat_id');

        // Daftar semua perangkat
        $perangkats = PerangkatDesa::orderBy('nama')->get();

        // Query utama
        $query = KehadiranPegawai::with(['perangkat', 'jamKerja'])
            ->bulan($bulan, $tahun)
            ->orderBy('tanggal');

        if ($perangkatId) {
            $query->perangkat($perangkatId);
        }

        $kehadiranList = $query->get();

        // Rekapitulasi per perangkat
        $rekapData = $this->buildRekap($kehadiranList, $bulan, $tahun, $perangkats, $perangkatId);

        // Hitung jumlah hari kerja di bulan ini (senin-jumat, di luar libur)
        $jumlahHariKerja = $this->hitungHariKerja($bulan, $tahun);

        $namaBulan = Carbon::create($tahun, $bulan, 1)->translatedFormat('F');

        return view('admin.kehadiran.rekapitulasi.index', compact(
            'rekapData',
            'perangkats',
            'bulan',
            'tahun',
            'namaBulan',
            'perangkatId',
            'jumlahHariKerja',
            'kehadiranList'
        ));
    }

    public function exportPdf(Request $request) {
        $bulan       = $request->integer('bulan', now()->month);
        $tahun       = $request->integer('tahun', now()->year);
        $perangkatId = $request->integer('perangkat_id');
        $perangkats  = PerangkatDesa::orderBy('nama')->get();

        $query = KehadiranPegawai::with(['perangkat', 'jamKerja'])
            ->bulan($bulan, $tahun)
            ->orderBy('tanggal');

        if ($perangkatId) {
            $query->perangkat($perangkatId);
        }

        $kehadiranList   = $query->get();
        $rekapData       = $this->buildRekap($kehadiranList, $bulan, $tahun, $perangkats, $perangkatId);
        $jumlahHariKerja = $this->hitungHariKerja($bulan, $tahun);
        $namaBulan       = Carbon::create($tahun, $bulan, 1)->translatedFormat('F');

        $pdf = Pdf::loadView('admin.kehadiran.rekapitulasi.pdf', compact(
            'rekapData',
            'bulan',
            'tahun',
            'namaBulan',
            'jumlahHariKerja'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("rekap-kehadiran-{$namaBulan}-{$tahun}.pdf");
    }

    public function exportExcel(Request $request) {
        $bulan       = $request->integer('bulan', now()->month);
        $tahun       = $request->integer('tahun', now()->year);
        $perangkatId = $request->integer('perangkat_id');

        $namaBulan = Carbon::create($tahun, $bulan, 1)->translatedFormat('F');

        $this->catat('kehadiran', "Export Excel rekapitulasi kehadiran {$namaBulan} {$tahun}");

        return Excel::download(
            new RekapitulasiKehadiranExport($bulan, $tahun, $perangkatId),
            "rekap-kehadiran-{$namaBulan}-{$tahun}.xlsx"
        );
    }

    // -------------------------------------------------------------------------
    // Helper Methods
    // -------------------------------------------------------------------------

    private function buildRekap($kehadiranList, int $bulan, int $tahun, $perangkats, int $perangkatId = 0): array {
        $data = [];

        $filtered = $perangkatId
            ? $perangkats->where('id', $perangkatId)
            : $perangkats;

        foreach ($filtered as $perangkat) {
            $kehadiran = $kehadiranList->where('perangkat_id', $perangkat->id);

            $data[] = [
                'perangkat_id' => $perangkat->id,
                'nama'         => $perangkat->nama,
                'jabatan' => $perangkat->jabatan?->nama ?? '-',
                'hadir'        => $kehadiran->where('status', 'hadir')->count(),
                'terlambat'    => $kehadiran->where('status', 'terlambat')->count(),
                'izin'         => $kehadiran->where('status', 'izin')->count(),
                'sakit'        => $kehadiran->where('status', 'sakit')->count(),
                'alpa'         => $kehadiran->where('status', 'alpa')->count(),
                'dinas_luar'   => $kehadiran->where('status', 'dinas_luar')->count(),
                'cuti'         => $kehadiran->where('status', 'cuti')->count(),
                'total'        => $kehadiran->count(),
            ];
        }

        return $data;
    }

    private function hitungHariKerja(int $bulan, int $tahun): int {
        $start  = Carbon::create($tahun, $bulan, 1);
        $end    = $start->copy()->endOfMonth();
        $count  = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            // Senin - Jumat saja
            if ($date->isWeekday()) {
                $count++;
            }
        }

        return $count;
    }
}
