<?php

namespace App\Http\Controllers\Admin\BukuAdministrasi;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class BukuIndukPendudukController extends Controller {
    public function index(Request $request) {
        $query = Penduduk::with(['keluargas', 'rumahTanggas'])
            ->orderBy('nama', 'asc');

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'Semua') {
            $map = ['Laki-laki' => 'L', 'Perempuan' => 'P'];
            $query->where('jenis_kelamin', $map[$request->jenis_kelamin] ?? $request->jenis_kelamin);
        }

        // Filter agama
        if ($request->filled('agama') && $request->agama !== 'Semua Agama') {
            $query->where('agama', $request->agama);
        }

        // Filter status perkawinan
        if ($request->filled('status_perkawinan') && $request->status_perkawinan !== 'Semua') {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        $penduduk = $query->paginate(15)->withQueryString();

        // Stats
        $total       = Penduduk::count();
        $laki        = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan   = Penduduk::where('jenis_kelamin', 'P')->count();

        return view('admin.buku-administrasi.penduduk.induk-penduduk.index', compact(
            'penduduk',
            'total',
            'laki',
            'perempuan',
        ));
    }

    public function exportExcel(Request $request) {
        // Implementasi export Excel (opsional, bisa pakai Maatwebsite Excel)
        // return Excel::download(new BukuIndukPendudukExport, 'buku-induk-penduduk.xlsx');
        return back()->with('error', 'Fitur export Excel belum diimplementasikan.');
    }

    public function exportPdf(Request $request) {
        // Implementasi export PDF (opsional, bisa pakai DomPDF / Snappy)
        return back()->with('error', 'Fitur export PDF belum diimplementasikan.');
    }
}
