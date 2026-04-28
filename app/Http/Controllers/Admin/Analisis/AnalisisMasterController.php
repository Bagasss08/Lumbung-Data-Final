<?php

namespace App\Http\Controllers\Admin\Analisis;

use App\Http\Controllers\Controller;
use App\Models\AnalisisMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalisisMasterExport;

class AnalisisMasterController extends Controller {

    // ── Daftar subjek valid (sinkron dengan model) ───────────
    private const VALID_SUBJEK = [
        'PENDUDUK',
        'KELUARGA',
        'RUMAH_TANGGA',
        'KELOMPOK',
        'DESA',
        'DUSUN',
        'RW',
        'RT',
    ];

    public function index(Request $request) {
        $query = AnalisisMaster::query();

        // Cari berdasarkan nama atau kode
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subjek')) {
            $query->where('subjek', $request->subjek);
        }

        $perPage = in_array($request->per_page, [10, 25, 50, 100])
            ? (int) $request->per_page
            : 10;

        $masters = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.analisis.index', compact('masters'));
    }

    public function create() {
        return view('admin.analisis.create', [
            'subjekOptions' => AnalisisMaster::SUBJEK_OPTIONS,
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'nullable|string|max:20|unique:analisis_master,kode',
            'deskripsi' => 'nullable|string',
            'subjek'    => 'required|in:' . implode(',', self::VALID_SUBJEK),
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

        $totalResponden        = $analisi->responden()->count();
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
            'rerataSkor',
        ));
    }

    public function edit(AnalisisMaster $analisi) {
        return view('admin.analisis.edit', [
            'analisi'       => $analisi,
            'subjekOptions' => AnalisisMaster::SUBJEK_OPTIONS,
        ]);
    }

    public function update(Request $request, AnalisisMaster $analisi) {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'nullable|string|max:20|unique:analisis_master,kode,' . $analisi->id,
            'deskripsi' => 'nullable|string',
            'subjek'    => 'required|in:' . implode(',', self::VALID_SUBJEK),
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
        return redirect()
            ->route('admin.analisis.index')
            ->with('success', 'Analisis berhasil dihapus!');
    }

    public function toggleStatus(AnalisisMaster $analisi) {
        $analisi->update([
            'status' => $analisi->status === 'AKTIF' ? 'TIDAK_AKTIF' : 'AKTIF',
        ]);
        return back()->with('success', 'Status berhasil diubah!');
    }

    public function toggleLock(AnalisisMaster $analisi) {
        $analisi->update(['lock' => ! $analisi->lock]);
        return back()->with('success', 'Status kunci berhasil diubah!');
    }

    // ── Ekspor Analisis ──────────────────────────────────────

    public function export(AnalisisMaster $analisi) {
        $filename = 'analisis-' . Str::slug($analisi->nama) . '-' . now()->format('Ymd') . '.xlsx';

        // Pastikan class App\Exports\AnalisisMasterExport sudah dibuat
        return Excel::download(new AnalisisMasterExport($analisi), $filename);
    }

    // ── Sinkronisasi Google Form ─────────────────────────────

    public function sinkronisasi(AnalisisMaster $analisi) {
        if (! $analisi->google_form_id) {
            return back()->with('error', 'ID Google Form belum diatur untuk analisis ini.');
        }

        // TODO: Implement Google Form sync logic
        // Contoh: ambil response dari Google Forms API,
        // lalu simpan ke tabel analisis_responden.

        $analisi->update(['last_sync_at' => now()]);

        return back()->with('success', 'Sinkronisasi Google Form berhasil dilakukan.');
    }

    // ── Impor dari file Excel ────────────────────────────────

    public function import(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        // TODO: Implement import logic dengan Laravel Excel
        // Excel::import(new AnalisisMasterImport, $request->file('file'));

        return back()->with('success', 'Impor analisis berhasil!');
    }
}
