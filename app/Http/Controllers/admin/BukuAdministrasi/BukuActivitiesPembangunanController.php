<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Pembangunan;
use Illuminate\Http\Request;

/**
 * Controller untuk Buku Kegiatan Pembangunan
 * Hanya menggunakan method index (read-only)
 */
class BukuActivitiesPembangunanController extends Controller
{
    /**
     * Display a listing of the resource (with progress from dokumentasi).
     */
    public function index(Request $request)
    {
        $query = Pembangunan::query()
            ->with(['bidang', 'dokumentasis'])
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
        $tahunList = Pembangunan::selectRaw('DISTINCT tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');

        return view('admin.buku-administrasi.pembangunan.kegiatan.index', compact('pembangunan', 'tahunList'));
    }
}

