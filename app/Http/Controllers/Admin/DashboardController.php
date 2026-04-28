<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RumahTangga;
use App\Models\Surat;
use App\Models\Users;
use App\Models\Wilayah;
use App\Models\Kelompok;
use App\Models\Program;

class DashboardController extends Controller {
    public function index() {
        $wilayahCount           = 0;
        $pendudukCount          = 0;
        $keluargaCount          = 0;
        $rumahTanggaCount       = 0;
        $suratCount             = 0;
        $kelompokCount          = 0;
        $bantuanCount           = 0;
        $verifikasiLayananCount = 0; // belum ada fiturnya
        $totalUsers             = 0;
        $recentPenduduk         = collect();

        try {
            $wilayahCount     = Wilayah::count();
        } catch (\Exception $e) {
        }
        try {
            $pendudukCount    = Penduduk::count();
        } catch (\Exception $e) {
        }
        try {
            $keluargaCount    = Keluarga::count();
        } catch (\Exception $e) {
        }
        try {
            $rumahTanggaCount = RumahTangga::count();
        } catch (\Exception $e) {
        }
        try {
            $suratCount       = Surat::count();
        } catch (\Exception $e) {
        }
        try {
            $kelompokCount    = Kelompok::count();
        } catch (\Exception $e) {
        }
        try {
            $bantuanCount     = Program::count();
        } catch (\Exception $e) {
        }
        try {
            $totalUsers       = Users::count();
        } catch (\Exception $e) {
        }
        try {
            $recentPenduduk   = Penduduk::latest()->take(5)->get();
        } catch (\Exception $e) {
        }

        return view('admin.dashboard', compact(
            'wilayahCount',
            'pendudukCount',
            'keluargaCount',
            'rumahTanggaCount',
            'suratCount',
            'kelompokCount',
            'bantuanCount',
            'verifikasiLayananCount',
            'totalUsers',
            'recentPenduduk'
        ));
    }
}
