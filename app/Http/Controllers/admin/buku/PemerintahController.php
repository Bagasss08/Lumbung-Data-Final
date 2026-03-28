<?php

namespace App\Http\Controllers\Admin\Buku;

use App\Http\Controllers\Controller;
use App\Models\JabatanPerangkat;
use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PemerintahController extends Controller {
    // ── Index ───────────────────────────────────────────────────
    public function index(Request $request) {
        $query = PerangkatDesa::with('jabatan')->orderBy('urutan', 'asc')->orderBy('id', 'asc');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter golongan jabatan
        if ($request->filled('golongan')) {
            $query->whereHas('jabatan', fn($q) => $q->where('golongan', $request->golongan));
        }

        // Search nama / NIK (atau NIAP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%"); 
            });
        }

        $perangkat = $query->paginate(15)->withQueryString();
        $jabatanList = JabatanPerangkat::orderBy('urutan')->get()->groupBy('golongan');

        // BENAR: Mengarah ke view buku-administrasi
        return view('admin.buku-administrasi.umum.pemerintah.index', compact('perangkat', 'jabatanList'));
    }

    // ── Create ──────────────────────────────────────────────────
    public function create() {
        // Mengirimkan $jabatans (list biasa) agar mudah dibaca oleh dropdown di form create
        $jabatans = JabatanPerangkat::orderBy('urutan')->get();
        $jabatanList = $jabatans->groupBy('golongan'); // Jika masih butuh format group

        // BENAR: Mengarah ke view buku-administrasi
        return view('admin.buku-administrasi.umum.pemerintah.create', compact('jabatans', 'jabatanList'));
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
            'jabatan_id.required'            => 'Jabatan wajib dipilih.',
            'nama.required'                  => 'Nama wajib diisi.',
            'nik.digits'                     => 'NIK harus 16 digit.',
            'nik.unique'                     => 'NIK sudah terdaftar.',
            'foto.image'                     => 'File harus berupa gambar.',
            'foto.max'                       => 'Ukuran foto maksimal 2MB.',
            'periode_selesai.after_or_equal' => 'Periode selesai harus setelah atau sama dengan periode mulai.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        PerangkatDesa::create($validated);

        // BENAR: Redirect ke route buku-administrasi
        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan.');
    }

    // ── Show ────────────────────────────────────────────────────
    public function show($id) {
        // Menggunakan findOrFail karena di route menggunakan {id}
        $pemerintah = PerangkatDesa::with('jabatan')->findOrFail($id);

        // BENAR: Mengarah ke view buku-administrasi
        return view('admin.buku-administrasi.umum.pemerintah.show', compact('pemerintah'));
    }

    // ── Edit ────────────────────────────────────────────────────
    public function edit($id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);
        $jabatans = JabatanPerangkat::orderBy('urutan')->get();
        $jabatanList = $jabatans->groupBy('golongan');

        // BENAR: Mengarah ke view buku-administrasi
        return view('admin.buku-administrasi.umum.pemerintah.edit', compact('pemerintahDesa', 'jabatans', 'jabatanList'));
    }

    // ── Update ──────────────────────────────────────────────────
    public function update(Request $request, $id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);

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

        // BENAR: Redirect ke route buku-administrasi
        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    // ── Destroy (Hapus Satuan) ──────────────────────────────────
    public function destroy($id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);

        if ($pemerintahDesa->foto) {
            Storage::disk('public')->delete($pemerintahDesa->foto);
        }
        $pemerintahDesa->delete();

        // BENAR: Redirect ke route buku-administrasi
        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil dihapus.');
    }

    // ── Bulk Destroy (Hapus Massal) ─────────────────────────────
    // FUNGSI INI BARU DITAMBAHKAN
    public function bulkDestroy(Request $request) {
        // Tangkap id dari request (baik dari query string maupun form input)
        $ids = $request->input('ids');

        if ($ids && is_array($ids) && count($ids) > 0) {
            try {
                // Ambil semua data perangkat yang dipilih
                $perangkats = PerangkatDesa::whereIn('id', $ids)->get();

                // Hapus file foto dari storage terlebih dahulu (jika ada)
                foreach ($perangkats as $perangkat) {
                    if ($perangkat->foto) {
                        Storage::disk('public')->delete($perangkat->foto);
                    }
                }

                // Hapus data dari database
                PerangkatDesa::whereIn('id', $ids)->delete();

                return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
                    ->with('success', count($ids) . ' data perangkat berhasil dihapus secara massal.');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
    }

    // ── Toggle Status ───────────────────────────────────────────
    public function toggleStatus($id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);

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