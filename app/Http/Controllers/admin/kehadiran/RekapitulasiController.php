<?php

namespace App\Http\Controllers\Admin\kehadiran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\KehadiranHarian;
use App\Models\KehadiranBulanan;
use App\Models\KehadiranTahunan;
use App\Models\Pegawai;

class RekapitulasiController extends Controller {
    public function index(Request $request) {
        $tipe    = $request->get('tipe', 'harian');
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());
        $hari    = Carbon::parse($tanggal)->day;
        $bulan   = $request->get('bulan', Carbon::now()->month);
        $tahun   = $request->get('tahun', Carbon::now()->year);

        $rekapitulasi = collect();

        // ✅ FIX: Ganti semua 'total_' jadi tanpa prefix
        $summary = [
            'hadir'      => 0,
            'izin'       => 0,
            'sakit'      => 0,
            'alpha'      => 0,
            'cuti'       => 0,
            'dinas_luar' => 0,
        ];
        $namaBulan = $this->getNamaBulan();

        // ── HARIAN ──────────────────────────────────────
        if ($tipe === 'harian') {
            $rekapitulasi = KehadiranHarian::with(['pegawai', 'jenisKehadiran'])
                ->whereDate('tanggal', $tanggal)
                ->orderBy('jam_masuk')
                ->get();

            foreach ($rekapitulasi as $row) {
                $kode = optional($row->jenisKehadiran)->kode_kehadiran ?? '';
                if ($kode === 'H')       $summary['hadir']++;
                elseif ($kode === 'I')   $summary['izin']++;
                elseif ($kode === 'S')   $summary['sakit']++;
                elseif ($kode === 'A')   $summary['alpha']++;
                elseif ($kode === 'C')   $summary['cuti']++;
                elseif ($kode === 'DL')  $summary['dinas_luar']++;
            }
        }

        // ── BULANAN ─────────────────────────────────────
        elseif ($tipe === 'bulanan') {
            $rekapitulasi = KehadiranBulanan::with('pegawai')
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->orderBy('id_pegawai')
                ->get();

            $summary['hadir']      = $rekapitulasi->sum('jumlah_hadir');
            $summary['izin']       = $rekapitulasi->sum('jumlah_izin');
            $summary['alpha']      = $rekapitulasi->sum('jumlah_alpha');
            $summary['dinas_luar'] = $rekapitulasi->sum('jumlah_dinas_luar');
        }

        // ── TAHUNAN ─────────────────────────────────────
        else {
            $rekapitulasi = KehadiranTahunan::with('pegawai')
                ->where('tahun', $tahun)
                ->orderBy('id_pegawai')
                ->get();

            $summary['hadir'] = $rekapitulasi->sum('total_hadir');
            $summary['alpha'] = $rekapitulasi->sum('total_tidak_hadir');
        }

        $totalPegawai = Pegawai::where('status_aktif', 1)->count();

        return view('admin.kehadiran.rekapitulasi.index', compact(
            'tipe',
            'tanggal',
            'hari',
            'bulan',
            'tahun',
            'rekapitulasi',
            'summary',
            'namaBulan',
            'totalPegawai'
        ));
    }

    public function exportExcel(Request $request) {
        return back()->with('info', 'Fitur export Excel belum dikonfigurasi.');
    }

    public function exportPdf(Request $request) {
        return back()->with('info', 'Fitur export PDF belum dikonfigurasi.');
    }

    private function getNamaBulan(): array {
        return [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }
}
