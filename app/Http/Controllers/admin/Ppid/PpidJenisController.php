<?php

namespace App\Http\Controllers\Admin\Ppid;

use App\Http\Controllers\Controller;
use App\Models\PpidJenisDokumen;
use Illuminate\Http\Request;

class PpidJenisController extends Controller {
    /**
     * 4 jenis dokumen bawaan sistem (tidak bisa dihapus).
     */
    protected array $protected = [
        'Secara Berkala',
        'Serta Merta',
        'Tersedia Setiap Saat',
        'Dikecualikan',
    ];

    // ──────────────────────────────────────────────────────────────
    // INDEX
    // ──────────────────────────────────────────────────────────────
    public function index() {
        $jenis = PpidJenisDokumen::withCount('dokumen')
            ->orderBy('id')  // ← ascending: lama di atas, baru di bawah
            ->paginate(15);
        return view('admin.ppid.jenis.index', compact('jenis'));
    }

    // ──────────────────────────────────────────────────────────────
    // STORE
    // ──────────────────────────────────────────────────────────────
    public function store(Request $request) {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255|unique:ppid_jenis_dokumen,nama',
            'keterangan'       => 'nullable|string',
            'icon'             => 'nullable|string|max:100',
            'warna_background' => 'nullable|string|max:20',
            'status'           => 'nullable|in:aktif,tidak_aktif',
        ]);

        $jenis = PpidJenisDokumen::create([
            'nama'             => $validated['nama'],
            'keterangan'       => $validated['keterangan'] ?? null,
            'icon'             => $validated['icon'] ?? null,
            'warna_background' => $validated['warna_background'] ?? '#3b82f6',
            'status'           => $validated['status'] ?? 'aktif',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Jenis dokumen berhasil ditambahkan.',
                'data'    => $jenis,
            ], 201);
        }

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil ditambahkan!');
    }

    // ──────────────────────────────────────────────────────────────
    // UPDATE
    // ──────────────────────────────────────────────────────────────
    public function update(Request $request, PpidJenisDokumen $jeni) {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255|unique:ppid_jenis_dokumen,nama,' . $jeni->id,
            'keterangan'       => 'nullable|string',
            'icon'             => 'nullable|string|max:100',
            'warna_background' => 'nullable|string|max:20',
            'status'           => 'nullable|in:aktif,tidak_aktif',
        ]);

        $jeni->update([
            'nama'             => $validated['nama'],
            'keterangan'       => $validated['keterangan'] ?? null,
            'icon'             => $validated['icon'] ?? null,
            'warna_background' => $validated['warna_background'] ?? $jeni->warna_background,
            'status'           => $validated['status'] ?? 'aktif',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Jenis dokumen berhasil diperbarui.',
                'data'    => $jeni->fresh(),
            ]);
        }

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil diperbarui!');
    }

    // ──────────────────────────────────────────────────────────────
    // DESTROY
    // ──────────────────────────────────────────────────────────────
    public function destroy(Request $request, PpidJenisDokumen $jeni) {
        if (in_array($jeni->nama, $this->protected)) {
            $msg = 'Jenis dokumen bawaan sistem tidak dapat dihapus.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $msg], 403);
            }

            return redirect()->route('admin.ppid.jenis.index')
                ->with('error', $msg);
        }

        if ($jeni->dokumen()->count() > 0) {
            $msg = 'Jenis dokumen tidak dapat dihapus karena masih digunakan!';

            if ($request->expectsJson()) {
                return response()->json(['message' => $msg], 422);
            }

            return redirect()->route('admin.ppid.jenis.index')
                ->with('error', $msg);
        }

        $jeni->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Jenis dokumen berhasil dihapus.']);
        }

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Jenis dokumen berhasil dihapus!');
    }

    // ──────────────────────────────────────────────────────────────
    // BULK DESTROY
    // ──────────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request) {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['message' => 'Tidak ada item yang dipilih.'], 422);
        }

        $deleted = PpidJenisDokumen::whereIn('id', $ids)
            ->whereNotIn('nama', $this->protected)
            ->delete();

        return response()->json([
            'message' => $deleted . ' data berhasil dihapus.',
            'deleted' => $deleted,
        ]);
    }

    // ──────────────────────────────────────────────────────────────
    // TOGGLE STATUS
    // ──────────────────────────────────────────────────────────────
    public function toggleStatus(Request $request, PpidJenisDokumen $jeni) {
        $request->validate([
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $jeni->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Status berhasil diubah.',
                'status'  => $jeni->status,
            ]);
        }

        return redirect()->route('admin.ppid.jenis.index')
            ->with('success', 'Status berhasil diubah.');
    }
}
