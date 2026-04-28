<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Pembangunan;
use Illuminate\Http\Request;

/**
 * Controller untuk Buku Inventaris Hasil Pembangunan
 * Hanya menggunakan method index (read-only)
 */
class BukuInventarisPembangunanController extends Controller
{
    /**
     * Display a listing of the resource (yang aktif/sudah selesai).
     */
    public function index(Request $request)
    {
        // Filter hanya yang aktif (status = 1)
        $query = Pembangunan::query()
            ->with(['bidang', 'sumberDana'])
            ->where('status', 1)
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

        // Data untuk dropdown tahun
        $tahunList = Pembangunan::where('status', 1)
            ->selectRaw('DISTINCT tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');

        return view('admin.buku-administrasi.pembangunan.inventaris.index', compact('pembangunan', 'tahunList'));
    }
}

