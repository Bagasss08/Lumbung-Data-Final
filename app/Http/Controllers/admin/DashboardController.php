<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdentitasDesa;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RumahTangga;
use App\Models\Surat;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\Artikel;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize variables with default values
        $wilayahCount = 0;
        $pendudukCount = 0;
        $keluargaCount = 0;
        $rumahTanggaCount = 0;
        $suratCount = 0;
        $bantuanCount = 0;
        $verifikasiLayananCount = 0;
        $totalUsers = 0;
        $recentPenduduk = collect();
        $totalAnggaran = 0;

        // Fetch counts from database with error handling
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('identitas_desa')) {
                $wilayahCount = IdentitasDesa::count();
            }
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        try {
            $pendudukCount = Penduduk::count();
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        try {
            $keluargaCount = Keluarga::count();
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        try {
            $rumahTanggaCount = RumahTangga::count();
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        try {
            $suratCount = Surat::count();
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        // $bantuanCount remains 0 as placeholder

        try {
            $verifikasiLayananCount = Surat::where('status', 'verified')->count(); // Assuming verified surat for Verifikasi Layanan
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        // Additional data for statistics
        try {
            $totalUsers = User::count();
        } catch (\Exception $e) {
            // Keep default value of 0
        }

        try {
            $recentPenduduk = Penduduk::latest()->take(5)->get(); // Recent penduduk for activities
        } catch (\Exception $e) {
            // Keep default empty collection
        }

        // $totalAnggaran remains 0 as placeholder

        return view('admin.dashboard', [
            'wilayahCount' => $wilayahCount,
            'pendudukCount' => $pendudukCount,
            'keluargaCount' => $keluargaCount,
            'rumahTanggaCount' => $rumahTanggaCount,
            'suratCount' => $suratCount,
            'bantuanCount' => $bantuanCount,
            'verifikasiLayananCount' => $verifikasiLayananCount,
            'totalUsers' => $totalUsers,
            'recentPenduduk' => $recentPenduduk,
            'totalAnggaran' => $totalAnggaran
        ]);
    }
}
