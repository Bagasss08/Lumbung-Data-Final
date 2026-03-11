<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Pembangunan;
use Illuminate\Http\Request;

/**
 * Controller untuk Buku Rencana Kerja Pembangunan
 * Hanya menggunakan method index (read-only)
 */
class BukuRencanaKerjaPembangunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembangunan::query()
            ->with(['bidang', 'sumberDana'])
            ->orderBy('tahun_anggaran', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter tahun anggaran
        if ($request->filled('tahun')) {
            $query->where('tahun_anggaran', $request->tahun);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        $pembangunan = $query->paginate(10)->withQueryString();

        // Data untuk dropdown <t></t>ahun
        $tahunList = Pembangunan::selectRaw('DISTINCT tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');

        // Hitung total anggaran (dana_pemerintah + dana_provinsi + dana_kabkota + swadaya + sumber_lain)
        $totalAnggaran = Pembangunan::selectRaw(
            'COALESCE(SUM(dana_pemerintah), 0) + COALESCE(SUM(dana_provinsi), 0) + COALESCE(SUM(dana_kabkota), 0) + COALESCE(SUM(swadaya), 0) + COALESCE(SUM(sumber_lain), 0) as total'
        )->value('total');

        return view('admin.buku-administrasi.pembangunan.rencana-kerja.index', compact('pembangunan', 'tahunList', 'totalAnggaran'));
    }
}

