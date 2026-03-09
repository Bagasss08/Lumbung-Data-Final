<?php
// app/Http/Controllers/Admin/BukuAdministrasi/BukuRekapitulasiPendudukController.php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class BukuRekapitulasiPendudukController extends Controller {
    public function index(Request $request) {
        $tahun = $request->get('tahun', now()->year);

        // Rekapitulasi per jenis kelamin
        $totalLaki     = Penduduk::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Penduduk::where('jenis_kelamin', 'P')->count();
        $totalPenduduk = $totalLaki + $totalPerempuan;

        // Rekapitulasi per agama
        $perAgama = Penduduk::selectRaw('agama, COUNT(*) as jumlah')
            ->groupBy('agama')
            ->orderByDesc('jumlah')
            ->get();

        // Rekapitulasi per status perkawinan
        $perStatusKawin = Penduduk::selectRaw('status_kawin, COUNT(*) as jumlah')
            ->groupBy('status_kawin')->orderByDesc('jumlah')->get();

        $perPendidikan = Penduduk::selectRaw('pendidikan, COUNT(*) as jumlah')
            ->groupBy('pendidikan')->orderByDesc('jumlah')->get();

        $perPekerjaan = Penduduk::selectRaw('pekerjaan, COUNT(*) as jumlah')
            ->groupBy('pekerjaan')->orderByDesc('jumlah')->get();

        // Rekapitulasi per kelompok umur
        $kelompokUmur = [
            '0-4'   => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 4')->count(),
            '5-9'   => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 9')->count(),
            '10-14' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 10 AND 14')->count(),
            '15-19' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 19')->count(),
            '20-24' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 20 AND 24')->count(),
            '25-29' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 25 AND 29')->count(),
            '30-34' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 30 AND 34')->count(),
            '35-39' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 35 AND 39')->count(),
            '40-44' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 40 AND 44')->count(),
            '45-49' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 45 AND 49')->count(),
            '50-54' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 50 AND 54')->count(),
            '55-59' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 55 AND 59')->count(),
            '60-64' => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 60 AND 64')->count(),
            '65+'   => Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 65')->count(),
        ];

        return view('admin.buku-administrasi.penduduk.rekapitulasi.index', compact(
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'perAgama',
            'perStatusKawin',
            'perPendidikan',
            'perPekerjaan',
            'kelompokUmur',
            'tahun'
        ));
    }
}