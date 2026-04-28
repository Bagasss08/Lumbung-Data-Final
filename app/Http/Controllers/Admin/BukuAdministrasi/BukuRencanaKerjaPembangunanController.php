<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Pembangunan;
use Illuminate\Http\Request;

class BukuRencanaKerjaPembangunanController extends Controller {
    /**
     * Terapkan filter ke query (tanpa eager load).
     * Dipakai untuk hitung totals agar tidak terganggu with().
     */
    private function applyFilters($query, Request $request) {
        if ($request->filled('tahun')) {
            $query->where('tahun_anggaran', $request->tahun);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        return $query;
    }

    /**
     * Hitung total per sumber dana.
     * Query TANPA with() supaya selectRaw tidak dikacaukan eager load.
     */
    private function getTotals(Request $request): object {
        $query = Pembangunan::query();
        $this->applyFilters($query, $request);

        return $query->selectRaw('
            COALESCE(SUM(dana_pemerintah), 0) as total_dana_pemerintah,
            COALESCE(SUM(dana_provinsi),   0) as total_dana_provinsi,
            COALESCE(SUM(dana_kabkota),    0) as total_dana_kabkota,
            COALESCE(SUM(swadaya),         0) as total_swadaya,
            COALESCE(SUM(sumber_lain),     0) as total_sumber_lain,
            COALESCE(SUM(dana_pemerintah + dana_provinsi + dana_kabkota + swadaya + sumber_lain), 0) as total_anggaran
        ')->first();
    }

    /**
     * Halaman daftar (dengan paginasi)
     */
    public function index(Request $request) {
        // Query data tabel — dengan eager load untuk relasi
        $query = Pembangunan::query()
            ->with(['bidang', 'sumberDana', 'lokasi'])
            ->orderBy('tahun_anggaran', 'desc')
            ->orderBy('created_at', 'desc');

        $this->applyFilters($query, $request);

        $perPage     = in_array((int) $request->per_page, [10, 25, 50, 100]) ? (int) $request->per_page : 10;
        $pembangunan = $query->paginate($perPage)->withQueryString();

        // Totals — query terpisah tanpa with()
        $totals = $this->getTotals($request);

        // Dropdown tahun dari semua data (tidak ikut filter)
        $tahunList = Pembangunan::selectRaw('DISTINCT tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');

        return view('admin.buku-administrasi.pembangunan.rencana-kerja.index', [
            'pembangunan'         => $pembangunan,
            'tahunList'           => $tahunList,
            'totalDanaPemerintah' => $totals->total_dana_pemerintah,
            'totalDanaProvinsi'   => $totals->total_dana_provinsi,
            'totalDanaKabkota'    => $totals->total_dana_kabkota,
            'totalSwadaya'        => $totals->total_swadaya,
            'totalSumberLain'     => $totals->total_sumber_lain,
            'totalAnggaran'       => $totals->total_anggaran,
        ]);
    }

    /**
     * Halaman cetak (semua data sesuai filter, tanpa paginasi)
     */
    public function cetak(Request $request) {
        // Query data — dengan eager load
        $query = Pembangunan::query()
            ->with(['bidang', 'sumberDana', 'lokasi'])
            ->orderBy('tahun_anggaran', 'desc')
            ->orderBy('created_at', 'desc');

        $this->applyFilters($query, $request);

        $pembangunan = $query->get();

        // Totals — query terpisah tanpa with()
        $totals = $this->getTotals($request);

        return view('admin.buku-administrasi.pembangunan.rencana-kerja.cetak', [
            'pembangunan'         => $pembangunan,
            'filterTahun'         => $request->tahun  ?? null,
            'filterSearch'        => $request->search ?? null,
            'totalDanaPemerintah' => $totals->total_dana_pemerintah,
            'totalDanaProvinsi'   => $totals->total_dana_provinsi,
            'totalDanaKabkota'    => $totals->total_dana_kabkota,
            'totalSwadaya'        => $totals->total_swadaya,
            'totalSumberLain'     => $totals->total_sumber_lain,
            'totalAnggaran'       => $totals->total_anggaran,
        ]);
    }
}
