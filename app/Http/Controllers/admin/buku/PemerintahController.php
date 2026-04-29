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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('golongan')) {
            $query->whereHas('jabatan', fn($q) => $q->where('golongan', $request->golongan));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('niap', 'like', "%{$search}%"); 
            });
        }

        $perangkat = $query->paginate(15)->withQueryString();
        $jabatanList = JabatanPerangkat::orderBy('urutan')->get()->groupBy('golongan');

        return view('admin.buku-administrasi.umum.pemerintah.index', compact('perangkat', 'jabatanList'));
    }

    // ── Create ──────────────────────────────────────────────────
    public function create() {
        $jabatans = JabatanPerangkat::orderBy('urutan')->get();
        $jabatanList = $jabatans->groupBy('golongan');

        return view('admin.buku-administrasi.umum.pemerintah.create', compact('jabatans', 'jabatanList'));
    }

    // ── Store ───────────────────────────────────────────────────
    public function store(Request $request) {
        $validated = $request->validate([
            'penduduk_id'      => 'nullable|integer', // Ditambahkan agar tertangkap
            'jabatan_id'       => 'required|exists:jabatan_perangkat,id',
            'nama'             => 'required|string|max:100',
            'nik'              => 'nullable|string|max:16|unique:perangkat_desa,nik', // Ubah ke string agar lebih luwes
            'niap'             => 'nullable|string|max:50',
            'nip'              => 'nullable|string|max:50|unique:perangkat_desa,nip',
            'jenis_kelamin'    => 'nullable|string|max:20',
            'tempat_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|string|max:50',
            'pangkat_golongan' => 'nullable|string|max:100',
            'pendidikan_terakhir'=> 'nullable|string|max:100',
            'nomor_keputusan_pemberhentian'   => 'nullable|string|max:100',
            'tanggal_keputusan_pemberhentian' => 'nullable|date',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_sk'            => 'nullable|string|max:100',
            'tanggal_sk'       => 'nullable|date',
            'periode_mulai'    => 'nullable|date',
            'periode_selesai'  => 'nullable|date', // Disederhanakan untuk mencegah bug validasi
            'status'           => 'required|in:1,2',
            'keterangan'       => 'nullable|string',
            'urutan'           => 'nullable|integer|min:0',
        ], [
            'jabatan_id.required' => 'Jabatan wajib dipilih.',
            'nama.required'       => 'Nama wajib diisi.',
            'nik.max'             => 'NIK maksimal 16 karakter.',
            'nik.unique'          => 'NIK sudah terdaftar.',
            'nip.unique'          => 'NIP sudah terdaftar.',
            'foto.image'          => 'File harus berupa gambar.',
            'foto.max'            => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        PerangkatDesa::create($validated);

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan.');
    }

    // ── Show ────────────────────────────────────────────────────
    public function show($id) {
        $pemerintah = PerangkatDesa::with('jabatan')->findOrFail($id);
        return view('admin.buku-administrasi.umum.pemerintah.show', compact('pemerintah'));
    }

    // ── Edit ────────────────────────────────────────────────────
    public function edit($id) {
        $pemerintah = PerangkatDesa::findOrFail($id);
        $jabatans = JabatanPerangkat::orderBy('urutan')->get();
        $jabatanList = $jabatans->groupBy('golongan');

        return view('admin.buku-administrasi.umum.pemerintah.edit', compact('pemerintah', 'jabatans', 'jabatanList'));
    }

    // ── Update ──────────────────────────────────────────────────
    public function update(Request $request, $id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);

        $validated = $request->validate([
            'penduduk_id'      => 'nullable|integer',
            'jabatan_id'       => 'required|exists:jabatan_perangkat,id',
            'nama'             => 'required|string|max:100',
            'nik'              => ['nullable', 'string', 'max:16', Rule::unique('perangkat_desa', 'nik')->ignore($pemerintahDesa->id)],
            'niap'             => 'nullable|string|max:50',
            'nip'              => ['nullable', 'string', 'max:50', Rule::unique('perangkat_desa', 'nip')->ignore($pemerintahDesa->id)],
            'jenis_kelamin'    => 'nullable|string|max:20',
            'tempat_lahir'     => 'nullable|string|max:100',
            'tanggal_lahir'    => 'nullable|date',
            'agama'            => 'nullable|string|max:50',
            'pangkat_golongan' => 'nullable|string|max:100',
            'pendidikan_terakhir'=> 'nullable|string|max:100',
            'nomor_keputusan_pemberhentian'   => 'nullable|string|max:100',
            'tanggal_keputusan_pemberhentian' => 'nullable|date',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_sk'            => 'nullable|string|max:100',
            'tanggal_sk'       => 'nullable|date',
            'periode_mulai'    => 'nullable|date',
            'periode_selesai'  => 'nullable|date',
            'status'           => 'required|in:1,2',
            'keterangan'       => 'nullable|string',
            'urutan'           => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {
            if ($pemerintahDesa->foto) {
                Storage::disk('public')->delete($pemerintahDesa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        $pemerintahDesa->update($validated);

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    // ── Destroy ─────────────────────────────────────────────────
    public function destroy($id) {
        $pemerintahDesa = PerangkatDesa::findOrFail($id);

        if ($pemerintahDesa->foto) {
            Storage::disk('public')->delete($pemerintahDesa->foto);
        }
        $pemerintahDesa->delete();

        return redirect()->route('admin.buku-administrasi.umum.pemerintah.index')
            ->with('success', 'Data perangkat desa berhasil dihapus.');
    }

    // ── Bulk Destroy ────────────────────────────────────────────
    public function bulkDestroy(Request $request) {
        $ids = $request->input('ids');

        if ($ids && is_array($ids) && count($ids) > 0) {
            try {
                $perangkats = PerangkatDesa::whereIn('id', $ids)->get();

                foreach ($perangkats as $perangkat) {
                    if ($perangkat->foto) {
                        Storage::disk('public')->delete($perangkat->foto);
                    }
                }

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

        // Sesuaikan dengan accessor model Anda, atau matikan baris di bawah jika tidak punya accessor label_status
        $label = $pemerintahDesa->status == '1' ? 'Aktif' : 'Non-Aktif';

        return response()->json([
            'success' => true,
            'message' => "Status berhasil diubah menjadi {$label}.",
            'status'  => $pemerintahDesa->fresh()->status,
        ]);
    }
}