<?php

namespace App\Http\Controllers\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\InfoDesa\LembagaDesa;
use App\Models\InfoDesa\LembagaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LembagaDokumenController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        $query = LembagaDokumen::where('lembaga_id', $lembagaId);

        // Filter aktif
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortable = ['judul', 'tahun', 'aktif', 'created_at', 'status'];
        $sort = in_array($request->sort, $sortable) ? $request->sort : 'created_at';
        $dir  = $request->dir === 'asc' ? 'asc' : 'desc';
        $query->orderBy($sort, $dir);

        $perPage  = in_array($request->per_page, [10, 25, 50, 100]) ? $request->per_page : 10;
        $dokumen  = $query->paginate($perPage)->appends($request->query());

        return view('admin.info-desa.lembaga-desa.dokumen', compact('lembaga', 'dokumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        return view('admin.info-desa.lembaga-desa.dokumen-create', compact('lembaga'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $lembagaId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'tahun'       => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'aktif'       => 'boolean',
            'keterangan'  => 'nullable|string|max:500',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'status'      => 'nullable|string|max:50',
        ]);

        $validated['lembaga_id'] = $lembagaId;
        $validated['aktif']      = $request->boolean('aktif', true);
        $validated['status']     = $validated['aktif'] ? 'Aktif' : 'Nonaktif';

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('lembaga-dokumen', 'public');
        }

        LembagaDokumen::create($validated);

        return redirect()
            ->route('admin.lembaga-desa.dokumen.index', $lembagaId)
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($lembagaId, $dokumenId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);
        $dokumen = LembagaDokumen::where('lembaga_id', $lembagaId)->findOrFail($dokumenId);

        return view('admin.info-desa.lembaga-desa.dokumen-edit', compact('lembaga', 'dokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $lembagaId, $dokumenId) {
        $lembaga = LembagaDesa::findOrFail($lembagaId);
        $dokumen = LembagaDokumen::where('lembaga_id', $lembagaId)->findOrFail($dokumenId);

        $validated = $request->validate([
            'judul'       => 'required|string|max:255',
            'tahun'       => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'aktif'       => 'boolean',
            'keterangan'  => 'nullable|string|max:500',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'status'      => 'nullable|string|max:50',
        ]);

        $validated['aktif']  = $request->boolean('aktif', true);
        $validated['status'] = $validated['aktif'] ? 'Aktif' : 'Nonaktif';

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
                Storage::disk('public')->delete($dokumen->file);
            }
            $validated['file'] = $request->file('file')->store('lembaga-dokumen', 'public');
        }

        $dokumen->update($validated);

        return redirect()
            ->route('admin.lembaga-desa.dokumen.index', $lembagaId)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lembagaId, $dokumenId) {
        $dokumen = LembagaDokumen::where('lembaga_id', $lembagaId)->findOrFail($dokumenId);

        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        $dokumen->delete();

        return redirect()
            ->route('admin.lembaga-desa.dokumen.index', $lembagaId)
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Bulk delete.
     */
    public function bulkDestroy(Request $request, $lembagaId) {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()
                ->back()
                ->with('warning', 'Tidak ada dokumen yang dipilih.');
        }

        $dokumens = LembagaDokumen::where('lembaga_id', $lembagaId)->whereIn('id', $ids)->get();

        foreach ($dokumens as $d) {
            if ($d->file && Storage::disk('public')->exists($d->file)) {
                Storage::disk('public')->delete($d->file);
            }
            $d->delete();
        }

        return redirect()
            ->route('admin.lembaga-desa.dokumen.index', $lembagaId)
            ->with('success', count($dokumens) . ' dokumen berhasil dihapus.');
    }

    /**
     * Download the document file.
     */
    public function download($lembagaId, $dokumenId) {
        $dokumen = LembagaDokumen::where('lembaga_id', $lembagaId)->findOrFail($dokumenId);

        if (!$dokumen->file || !Storage::disk('public')->exists($dokumen->file)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($dokumen->file, $dokumen->judul);
    }
}
