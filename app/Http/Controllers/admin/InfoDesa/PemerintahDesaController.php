<?php

namespace App\Http\Controllers\Admin\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\JabatanPerangkat;
use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PemerintahDesaController extends Controller {
    // ── Index ───────────────────────────────────────────────────
    public function index(Request $request) {
        $query = PerangkatDesa::with('jabatan')
            ->orderedByUrutan();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter golongan jabatan
        if ($request->filled('golongan')) {
            $query->whereHas('jabatan', fn($q) => $q->where('golongan', $request->golongan));
        }

        // Search nama / NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $perangkat = $query->paginate(15)->withQueryString();

        $jabatanList = JabatanPerangkat::orderBy('urutan')->get()->groupBy('golongan');

        return view('admin.info-desa.pemerintah-desa.index', compact('perangkat', 'jabatanList'));
    }

    // ── Create ──────────────────────────────────────────────────
    public function create() {
        $jabatanList = JabatanPerangkat::orderBy('urutan')->get()->groupBy('golongan');
        return view('admin.info-desa.pemerintah-desa.create', compact('jabatanList'));
    }

    // ── Store ───────────────────────────────────────────────────
    public function store(Request $request) {
        $validated = $request->validate([
            'jabatan_id'      => 'required|exists:jabatan_perangkat,id',
            'nama'            => 'required|string|max:100',
            'nik'             => 'nullable|digits:16|unique:perangkat_desa,nik',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_sk'           => 'nullable|string|max:100',
            'tanggal_sk'      => 'nullable|date',
            'periode_mulai'   => 'nullable|date',
            'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
            'status'          => 'required|in:1,2',
            'keterangan'      => 'nullable|string',
            'urutan'          => 'nullable|integer|min:0',
        ], [
            'jabatan_id.required'    => 'Jabatan wajib dipilih.',
            'nama.required'          => 'Nama wajib diisi.',
            'nik.digits'             => 'NIK harus 16 digit.',
            'nik.unique'             => 'NIK sudah terdaftar.',
            'foto.image'             => 'File harus berupa gambar.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
            'periode_selesai.after_or_equal' => 'Periode selesai harus setelah atau sama dengan periode mulai.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        PerangkatDesa::create($validated);

        return redirect()->route('admin.pemerintah-desa.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan.');
    }

    // ── Show ────────────────────────────────────────────────────
    public function show(PerangkatDesa $pemerintahDesa) {
        $pemerintahDesa->load('jabatan');
        return view('admin.info-desa.pemerintah-desa.show', compact('pemerintahDesa'));
    }

    // ── Edit ────────────────────────────────────────────────────
    public function edit(PerangkatDesa $pemerintahDesa) {
        $jabatanList = JabatanPerangkat::orderBy('urutan')->get()->groupBy('golongan');
        return view('admin.info-desa.pemerintah-desa.edit', compact('pemerintahDesa', 'jabatanList'));
    }

    // ── Update ──────────────────────────────────────────────────
    public function update(Request $request, PerangkatDesa $pemerintahDesa) {
        $validated = $request->validate([
            'jabatan_id'      => 'required|exists:jabatan_perangkat,id',
            'nama'            => 'required|string|max:100',
            'nik'             => ['nullable', 'digits:16', Rule::unique('perangkat_desa', 'nik')->ignore($pemerintahDesa->id)],
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_sk'           => 'nullable|string|max:100',
            'tanggal_sk'      => 'nullable|date',
            'periode_mulai'   => 'nullable|date',
            'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
            'status'          => 'required|in:1,2',
            'keterangan'      => 'nullable|string',
            'urutan'          => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pemerintahDesa->foto) {
                Storage::disk('public')->delete($pemerintahDesa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        $pemerintahDesa->update($validated);

        return redirect()->route('admin.pemerintah-desa.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    // ── Destroy ─────────────────────────────────────────────────
    public function destroy(PerangkatDesa $pemerintahDesa) {
        if ($pemerintahDesa->foto) {
            Storage::disk('public')->delete($pemerintahDesa->foto);
        }
        $pemerintahDesa->delete();

        return redirect()->route('admin.pemerintah-desa.index')
            ->with('success', 'Data perangkat desa berhasil dihapus.');
    }

    // ── Toggle Status ───────────────────────────────────────────
    public function toggleStatus(PerangkatDesa $pemerintahDesa) {
        $pemerintahDesa->update([
            'status' => $pemerintahDesa->status === PerangkatDesa::STATUS_AKTIF
                ? PerangkatDesa::STATUS_NONAKTIF
                : PerangkatDesa::STATUS_AKTIF,
        ]);

        $label = $pemerintahDesa->fresh()->label_status;

        return response()->json([
            'success' => true,
            'message' => "Status berhasil diubah menjadi {$label}.",
            'status'  => $pemerintahDesa->fresh()->status,
        ]);
    }
}
