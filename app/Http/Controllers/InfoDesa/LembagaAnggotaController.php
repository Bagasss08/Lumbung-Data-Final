<?php

namespace App\Http\Controllers\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\InfoDesa\LembagaAnggota;
use App\Models\InfoDesa\LembagaDesa;
use App\Models\Penduduk;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LembagaAnggotaController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        $query = LembagaAnggota::where('lembaga_id', $lembagaId)
            ->with('penduduk');

        // Filter status_dasar penduduk
        if ($request->filled('status_dasar')) {
            $query->whereHas('penduduk', fn($p) => $p->where('status_dasar', $request->status_dasar));
        }

        // Search nama or nik
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas(
                'penduduk',
                fn($p) =>
                $p->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
            );
        }

        $perPage = (int) $request->get('per_page', 10);
        $anggota = $query->orderBy('no_anggota', 'asc')->paginate($perPage)->withQueryString();

        return view('admin.info-desa.lembaga-desa.anggota.index', compact('lembaga', 'anggota'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);
        $penduduk = Penduduk::where('status_dasar', 'hidup')->orderBy('nama')->get();

        return view('admin.info-desa.lembaga-desa.anggota.create', compact('lembaga', 'penduduk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        $validated = $request->validate([
            'penduduk_id'              => 'required|exists:penduduk,id',
            'no_anggota'               => 'nullable|string|max:50',
            'jabatan'                  => 'required|string|max:255',
            'nomor_sk_jabatan'         => 'nullable|string|max:255',
            'nomor_sk_pengangkatan'    => 'nullable|string|max:255',
            'tanggal_sk_pengangkatan'  => 'nullable|date',
            'nomor_sk_pemberhentian'   => 'nullable|string|max:255',
            'tanggal_sk_pemberhentian' => 'nullable|date',
            'masa_jabatan'             => 'nullable|string|max:255',
            'keterangan'               => 'nullable|string',
        ]);

        $validated['lembaga_id'] = $lembagaId;

        // Auto-generate no_anggota if empty
        if (empty($validated['no_anggota'])) {
            $count = LembagaAnggota::where('lembaga_id', $lembagaId)->count();
            $validated['no_anggota'] = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        }

        LembagaAnggota::create($validated);

        return redirect()
            ->route('admin.lembaga-desa.anggota.index', $lembagaId)
            ->with('success', 'Anggota lembaga berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lembagaId, $anggotaId) {
        $lembaga  = LembagaDesa::findOrFail($lembagaId);
        $anggota  = LembagaAnggota::where('lembaga_id', $lembagaId)->findOrFail($anggotaId);
        $penduduk = Penduduk::where('status_dasar', 'hidup')->orderBy('nama')->get();

        return view('admin.info-desa.lembaga-desa.anggota.edit', compact('lembaga', 'anggota', 'penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lembagaId, $anggotaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);
        $anggota = LembagaAnggota::where('lembaga_id', $lembagaId)->findOrFail($anggotaId);

        $validated = $request->validate([
            'penduduk_id'              => 'required|exists:penduduk,id',
            'no_anggota'               => 'nullable|string|max:50',
            'jabatan'                  => 'required|string|max:255',
            'nomor_sk_jabatan'         => 'nullable|string|max:255',
            'nomor_sk_pengangkatan'    => 'nullable|string|max:255',
            'tanggal_sk_pengangkatan'  => 'nullable|date',
            'nomor_sk_pemberhentian'   => 'nullable|string|max:255',
            'tanggal_sk_pemberhentian' => 'nullable|date',
            'masa_jabatan'             => 'nullable|string|max:255',
            'keterangan'               => 'nullable|string',
        ]);

        $anggota->update($validated);

        return redirect()
            ->route('admin.lembaga-desa.anggota.index', $lembagaId)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lembagaId, $anggotaId) {
        $anggota = LembagaAnggota::where('lembaga_id', $lembagaId)->findOrFail($anggotaId);
        $anggota->delete();

        return redirect()
            ->route('admin.lembaga-desa.anggota.index', $lembagaId)
            ->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Bulk delete.
     */
    public function bulkDestroy(Request $request, $lembagaId) {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()
                ->back()
                ->with('warning', 'Tidak ada anggota yang dipilih.');
        }

        LembagaAnggota::where('lembaga_id', $lembagaId)
            ->whereIn('id', $ids)
            ->delete();

        return redirect()
            ->route('admin.lembaga-desa.anggota.index', $lembagaId)
            ->with('success', count($ids) . ' anggota berhasil dihapus.');
    }

    /**
     * Print / cetak.
     */
    public function cetak(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::with('kategori')->findOrFail($lembagaId);

        $anggota = LembagaAnggota::where('lembaga_id', $lembagaId)
            ->with('penduduk')
            ->orderBy('no_anggota')
            ->get();

        $ditandatangani = $request->filled('ditandatangani')
            ? Perangkat::with('jabatan')->find($request->ditandatangani)
            : null;

        $diketahui = $request->filled('diketahui')
            ? Perangkat::with('jabatan')->find($request->diketahui)
            : null;

        return view(
            'admin.info-desa.lembaga-desa.anggota.cetak',
            compact('lembaga', 'anggota', 'ditandatangani', 'diketahui')
        );
    }

    /**
     * Download HTML.
     */
    public function unduh(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::with('kategori')->findOrFail($lembagaId);

        $anggota = LembagaAnggota::where('lembaga_id', $lembagaId)
            ->with('penduduk')
            ->orderBy('no_anggota')
            ->get();

        $ditandatangani = $request->filled('ditandatangani')
            ? Perangkat::with('jabatan')->find($request->ditandatangani)
            : null;

        $diketahui = $request->filled('diketahui')
            ? Perangkat::with('jabatan')->find($request->diketahui)
            : null;

        $html = view(
            'admin.info-desa.lembaga-desa.anggota.cetak',
            compact('lembaga', 'anggota', 'ditandatangani', 'diketahui')
        )->render();

        return response($html, 200, [
            'Content-Type'        => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="anggota-lembaga-desa-' . $lembaga->kode . '.html"',
        ]);
    }

    /**
     * Show form to add multiple members at once.
     */
    public function createBulk($lembagaId) {
        $lembaga  = LembagaDesa::findOrFail($lembagaId);
        $penduduk = Penduduk::where('status_dasar', 'hidup')->orderBy('nama')->get();

        return view(
            'admin.info-desa.lembaga-desa.anggota.create-bulk',
            compact('lembaga', 'penduduk')
        );
    }

    /**
     * Store multiple members at once.
     */
    public function storeBulk(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        $request->validate([
            'anggota'                           => 'required|array|min:1',
            'anggota.*.penduduk_id'             => 'required|exists:penduduk,id',
            'anggota.*.jabatan'                 => 'required|string|max:255',
            'anggota.*.no_anggota'              => 'nullable|string|max:50',
            'anggota.*.nomor_sk_jabatan'        => 'nullable|string|max:255',
            'anggota.*.nomor_sk_pengangkatan'   => 'nullable|string|max:255',
            'anggota.*.tanggal_sk_pengangkatan' => 'nullable|date',
            'anggota.*.nomor_sk_pemberhentian'  => 'nullable|string|max:255',
            'anggota.*.tanggal_sk_pemberhentian' => 'nullable|date',
            'anggota.*.masa_jabatan'            => 'nullable|string|max:255',
            'anggota.*.keterangan'              => 'nullable|string',
        ]);

        $existingCount = LembagaAnggota::where('lembaga_id', $lembagaId)->count();

        $rows = [];
        foreach ($request->anggota as $i => $data) {
            $noAnggota = !empty($data['no_anggota'])
                ? $data['no_anggota']
                : str_pad($existingCount + $i + 1, 3, '0', STR_PAD_LEFT);

            $rows[] = [
                'lembaga_id'          => $lembagaId,
                'penduduk_id'         => $data['penduduk_id'],
                'no_anggota'          => $noAnggota,
                'jabatan'             => $data['jabatan'],
                'no_sk_jabatan'       => $data['nomor_sk_jabatan']         ?? null,
                'no_sk_pengangkatan'  => $data['nomor_sk_pengangkatan']    ?? null,
                'tgl_sk_pengangkatan' => $data['tanggal_sk_pengangkatan']  ?? null,
                'no_sk_pemberhentian' => $data['nomor_sk_pemberhentian']   ?? null,
                'tgl_sk_pemberhentian' => $data['tanggal_sk_pemberhentian'] ?? null,
                'masa_jabatan'        => $data['masa_jabatan']             ?? null,
                'keterangan'          => $data['keterangan']               ?? null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        LembagaAnggota::insert($rows);

        return redirect()
            ->route('admin.lembaga-desa.show', $lembagaId)
            ->with('success', count($rows) . ' anggota berhasil ditambahkan.');
    }
}
