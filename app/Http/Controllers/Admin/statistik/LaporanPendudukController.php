<?php

namespace App\Http\Controllers\Admin\statistik;

use App\Http\Controllers\Controller;
use App\Models\LaporanPenduduk;
use Illuminate\Http\Request;

class LaporanPendudukController extends Controller {
    public function index(Request $request) {
        $tahun    = $request->get('tahun');
        $search   = $request->get('search');
        $perPage  = $request->get('per_page', 10);

        $laporan = LaporanPenduduk::query()
            ->when($tahun,  fn($q) => $q->where('tahun', $tahun))
            ->when($search, fn($q) => $q->where('judul', 'like', "%$search%"))
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate($perPage);

        $tahunList = LaporanPenduduk::distinct()->orderByDesc('tahun')->pluck('tahun');

        return view('admin.statistik.penduduk', compact('laporan', 'tahun', 'tahunList'));
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2099',
            'bulan' => 'required|integer|min:1|max:12',
            'file'  => 'required|file|mimes:pdf|max:32768',
        ]);

        $path = $request->file('file')->store('laporan-penduduk', 'public');

        LaporanPenduduk::create([
            'judul'      => $request->judul,
            'tahun'      => $request->tahun,
            'bulan'      => $request->bulan,
            'file'       => $path,
            'tgl_upload' => now(),
        ]);

        return back()->with('success', 'Laporan penduduk berhasil ditambahkan.');
    }

    public function update(Request $request, $id) {
        $laporan = LaporanPenduduk::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:2099',
            'bulan' => 'required|integer|min:1|max:12',
            'file'  => 'nullable|file|mimes:pdf|max:32768',
        ]);

        $laporan->judul = $request->judul;
        $laporan->tahun = $request->tahun;
        $laporan->bulan = $request->bulan;

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($laporan->file && \Storage::disk('public')->exists($laporan->file)) {
                \Storage::disk('public')->delete($laporan->file);
            }
            $laporan->file = $request->file('file')->store('laporan-penduduk', 'public');
            $laporan->tgl_upload = now();
        }

        $laporan->save();

        return back()->with('success', 'Laporan penduduk berhasil diperbarui.');
    }

    public function destroy($id) {
        $laporan = LaporanPenduduk::findOrFail($id);

        if ($laporan->file && \Storage::disk('public')->exists($laporan->file)) {
            \Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return back()->with('success', 'Laporan penduduk berhasil dihapus.');
    }

    public function bulkDestroy(Request $request) {
        $ids = $request->input('ids', []);

        $laporans = LaporanPenduduk::whereIn('id', $ids)->get();
        foreach ($laporans as $laporan) {
            if ($laporan->file && \Storage::disk('public')->exists($laporan->file)) {
                \Storage::disk('public')->delete($laporan->file);
            }
            $laporan->delete();
        }

        return back()->with('success', count($ids) . ' laporan berhasil dihapus.');
    }
}
