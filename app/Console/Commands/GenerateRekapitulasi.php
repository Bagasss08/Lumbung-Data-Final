<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KehadiranHarian;
use App\Models\KehadiranBulanan;
use App\Models\KehadiranTahunan;
use Carbon\Carbon;

class GenerateRekapitulasi extends Command {
    protected $signature = 'rekapitulasi:generate {--bulan=} {--tahun=}';
    protected $description = 'Generate rekapitulasi bulanan & tahunan dari data harian';

    public function handle() {
        $bulan = $this->option('bulan') ?? Carbon::now()->month;
        $tahun = $this->option('tahun') ?? Carbon::now()->year;

        $this->info("Generating rekapitulasi untuk bulan $bulan tahun $tahun...");

        $pegawaiIds = KehadiranHarian::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->distinct()
            ->pluck('id_pegawai');

        foreach ($pegawaiIds as $idPegawai) {
            // BULANAN
            $dataBulanan = KehadiranHarian::where('id_pegawai', $idPegawai)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->with('jenisKehadiran')
                ->get();

            $jumlahHadir = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'H')->count();
            $jumlahIzin = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'I')->count();
            $jumlahSakit = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'S')->count();
            $jumlahAlpha = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'A')->count();
            $jumlahCuti = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'C')->count();
            $jumlahDinasLuar = $dataBulanan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'DL')->count();

            // Hitung hari kerja di bulan ini (asumsi Senin-Jumat)
            $totalHariKerja = Carbon::parse("$tahun-$bulan-01")->daysInMonth();
            $presentase = $totalHariKerja > 0 ? ($jumlahHadir / $totalHariKerja) * 100 : 0;

            KehadiranBulanan::updateOrCreate(
                ['id_pegawai' => $idPegawai, 'bulan' => $bulan, 'tahun' => $tahun],
                [
                    'jumlah_hadir' => $jumlahHadir,
                    'jumlah_izin' => $jumlahIzin,
                    'jumlah_sakit' => $jumlahSakit,
                    'jumlah_cuti' => $jumlahCuti,
                    'jumlah_alpha' => $jumlahAlpha,
                    'jumlah_dinas_luar' => $jumlahDinasLuar,
                    'total_hari_kerja' => $totalHariKerja,
                    'presentase_kehadiran' => $presentase,
                ]
            );

            // TAHUNAN
            $dataTahunan = KehadiranHarian::where('id_pegawai', $idPegawai)
                ->whereYear('tanggal', $tahun)
                ->with('jenisKehadiran')
                ->get();

            $totalHadir = $dataTahunan->filter(fn($d) => $d->jenisKehadiran?->kode_kehadiran === 'H')->count();
            $totalTidakHadir = $dataTahunan->filter(fn($d) => in_array($d->jenisKehadiran?->kode_kehadiran, ['A', 'DL']))->count();
            $totalHariKerjaTahun = 365; // atau bisa dihitung dinamis
            $presentaseTahun = $totalHariKerjaTahun > 0 ? ($totalHadir / $totalHariKerjaTahun) * 100 : 0;

            KehadiranTahunan::updateOrCreate(
                ['id_pegawai' => $idPegawai, 'tahun' => $tahun],
                [
                    'total_hari_kerja' => $totalHariKerjaTahun,
                    'total_hadir' => $totalHadir,
                    'total_tidak_hadir' => $totalTidakHadir,
                    'presentase_kehadiran' => $presentaseTahun,
                ]
            );
        }

        $this->info('✅ Rekapitulasi berhasil digenerate!');
    }
}
