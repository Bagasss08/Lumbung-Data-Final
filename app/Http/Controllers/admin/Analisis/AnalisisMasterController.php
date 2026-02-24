<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use App\Models\AnalisisPeriode;
use App\Models\AnalisisKlasifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalisisMasterController extends Controller {
    public function index(Request $request) {
        $query = AnalisisMaster::withCount('responden')->withCount('indikator');

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('kode', 'like', '%' . $request->search . '%');
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->subjek) {
            $query->where('subjek', $request->subjek);
        }

        $masters = $query->latest()->paginate(10)->withQueryString();

        return view('admin.analisis.index', compact('masters'));
    }

    public function create() {
        return view('admin.analisis.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'nullable|string|max:20|unique:analisis_master,kode',
            'deskripsi' => 'nullable|string',
            'subjek'    => 'required|in:PENDUDUK,KELUARGA,RUMAH_TANGGA,KELOMPOK',
            'status'    => 'required|in:AKTIF,TIDAK_AKTIF',
            'periode'   => 'nullable|integer|min:2000|max:2100',
        ]);

        if (empty($validated['kode'])) {
            $validated['kode'] = strtoupper(Str::slug($validated['nama'], '_'));
        }

        $master = AnalisisMaster::create($validated);

        return redirect()
            ->route('admin.analisis.show', $master)
            ->with('success', 'Analisis berhasil dibuat!');
    }

    public function show(AnalisisMaster $analisi) {
        $analisi->load(['indikator.jawaban', 'periodeList', 'klasifikasi']);

        $totalResponden = $analisi->responden()->count();
        $distribusiKlasifikasi = $analisi->responden()
            ->selectRaw('kategori_hasil, count(*) as jumlah')
            ->groupBy('kategori_hasil')
            ->pluck('jumlah', 'kategori_hasil')
            ->toArray();

        $rerataSkor = $analisi->responden()->avg('total_skor') ?? 0;

        return view('admin.analisis.show', compact(
            'analisi',
            'totalResponden',
            'distribusiKlasifikasi',
            'rerataSkor'
        ));
    }

    public function edit(AnalisisMaster $analisi) {
        return view('admin.analisis.edit', compact('analisi'));
    }

    public function update(Request $request, AnalisisMaster $analisi) {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'nullable|string|max:20|unique:analisis_master,kode,' . $analisi->id,
            'deskripsi' => 'nullable|string',
            'subjek'    => 'required|in:PENDUDUK,KELUARGA,RUMAH_TANGGA,KELOMPOK',
            'status'    => 'required|in:AKTIF,TIDAK_AKTIF',
            'periode'   => 'nullable|integer|min:2000|max:2100',
        ]);

        $analisi->update($validated);

        return redirect()
            ->route('admin.analisis.show', $analisi)
            ->with('success', 'Analisis berhasil diperbarui!');
    }

    public function destroy(AnalisisMaster $analisi) {
        $analisi->delete();
        return redirect()->route('admin.analisis.index')
            ->with('success', 'Analisis berhasil dihapus!');
    }

    public function toggleStatus(AnalisisMaster $analisi) {
        $analisi->update([
            'status' => $analisi->status === 'AKTIF' ? 'TIDAK_AKTIF' : 'AKTIF'
        ]);
        return back()->with('success', 'Status berhasil diubah!');
    }

    public function toggleLock(AnalisisMaster $analisi) {
        $analisi->update(['lock' => !$analisi->lock]);
        return back()->with('success', 'Status kunci berhasil diubah!');
    }
}
