<?php

namespace App\Http\Controllers\Admin\LayananMandiri;

use App\Http\Controllers\Controller;
use App\Models\LayananMandiri;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendaftarController extends Controller {
    /**
     * Tampilkan daftar pendaftar layanan mandiri.
     */
    public function index(Request $request) {
        $perPage = (int) $request->get('per_page', 10);
        if (! in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = LayananMandiri::with('penduduk')
            ->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->whereHas('penduduk', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $pendaftar = $query->paginate($perPage)->withQueryString();

        $pendudukList = Penduduk::whereDoesntHave('layananMandiri')
            ->select('id', 'nik', 'nama')
            ->orderBy('nama')
            ->get();

        return view('admin.layanan-mandiri.pendaftar', compact('pendaftar', 'pendudukList'));
    }

    /**
     * Simpan pendaftar baru.
     */
    public function store(Request $request) {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'pin'         => 'nullable|digits:6',
        ], [
            'penduduk_id.required' => 'NIK / Nama Penduduk wajib dipilih.',
            'penduduk_id.exists'   => 'Penduduk tidak ditemukan.',
            'pin.digits'           => 'PIN harus tepat 6 digit angka.',
        ]);

        $exists = LayananMandiri::where('penduduk_id', $request->penduduk_id)->first();
        if ($exists) {
            return back()->with('error', 'Penduduk ini sudah terdaftar di Layanan Mandiri.');
        }

        $pin = $request->filled('pin')
            ? $request->pin
            : str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $layanan = LayananMandiri::create([
            'penduduk_id' => $request->penduduk_id,
            'pin'         => Hash::make($pin),
        ]);

        $layanan->load('penduduk');

        return back()->with('pin_result', [
            'pin'        => $pin,
            'nama'       => $layanan->penduduk?->nama ?? '',
            'nik'        => $layanan->penduduk?->nik ?? '',
            'no_telepon' => $layanan->no_telepon ?? '',
        ]);
    }

    /**
     * Simpan / update nomor telepon warga.
     */
    public function simpanTelepon(Request $request, LayananMandiri $pendaftar) {
        $request->validate([
            'no_telepon' => 'required|string|max:20',
        ], [
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.max'      => 'Nomor telepon maksimal 20 karakter.',
        ]);

        $pendaftar->update([
            'no_telepon' => $request->no_telepon,
        ]);

        return back()->with('success', 'Nomor telepon berhasil disimpan.');
    }

    /**
     * Reset PIN warga.
     */
    public function resetPin(Request $request, LayananMandiri $pendaftar) {
        $request->validate([
            'pin' => 'nullable|digits:6',
        ], [
            'pin.digits' => 'PIN harus tepat 6 digit angka.',
        ]);

        $pin = $request->filled('pin')
            ? $request->pin
            : str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $pendaftar->update([
            'pin' => Hash::make($pin),
        ]);

        return back()->with('pin_result', [
            'pin'        => $pin,
            'nama'       => $pendaftar->penduduk?->nama ?? '',
            'nik'        => $pendaftar->penduduk?->nik ?? '',
            'no_telepon' => $pendaftar->no_telepon ?? '',
        ]);
    }

    /**
     * Hapus satu pendaftar.
     */
    public function destroy(LayananMandiri $pendaftar) {
        $pendaftar->delete();

        return back()->with('success', 'Data pendaftar berhasil dihapus.');
    }

    /**
     * AJAX: Cari penduduk untuk dropdown (belum terdaftar).
     */
    public function cariPenduduk(Request $request) {
        $q = $request->get('q', '');

        $results = Penduduk::query()
            ->when(
                $q,
                fn($query) => $query
                    ->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%")
            )
            ->whereDoesntHave('layananMandiri')
            ->select('id', 'nik', 'nama')
            ->orderBy('nama')
            ->limit(20)
            ->get()
            ->map(fn($p) => [
                'id'   => $p->id,
                'nik'  => $p->nik,
                'nama' => $p->nama,
                'text' => "{$p->nama} ({$p->nik})",
            ]);

        return response()->json($results);
    }
}
