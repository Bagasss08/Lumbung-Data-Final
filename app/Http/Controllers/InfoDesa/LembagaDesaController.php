<?php

namespace App\Http\Controllers\InfoDesa;

use App\Http\Controllers\Controller;
use App\Models\IdentitasDesa;
use App\Models\InfoDesa\LembagaAnggota;
use App\Models\InfoDesa\LembagaDesa;
use App\Models\InfoDesa\LembagaKategori;
use App\Models\PerangkatDesa;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class LembagaDesaController extends Controller {

    public function index(Request $request) {
        $query = LembagaDesa::with('kategori')->withCount('anggota');

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $lembaga   = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();
        $kategoris = LembagaKategori::orderBy('nama')->get();
        $perangkat = PerangkatDesa::with('jabatan')->orderBy('urutan')->get();

        return view('admin.info-desa.lembaga-desa.index', compact('lembaga', 'kategoris', 'perangkat'));
    }

    public function create() {
        $kategoris = LembagaKategori::orderBy('nama')->get();
        $penduduk  = Penduduk::where('status_dasar', 'hidup')->orderBy('nama')->get();

        if ($kategoris->isEmpty()) {
            return redirect()->route('admin.lembaga-kategori.index')
                ->with('warning', 'Silakan tambah kategori lembaga terlebih dahulu.');
        }

        return view('admin.info-desa.lembaga-desa.create', compact('kategoris', 'penduduk'));
    }

    public function store(Request $request) {
        $request->validate([
            'kategori_id'    => 'required|exists:lembaga_kategoris,id',
            'nama'           => 'required|string|max:255',
            'kode'           => 'required|string|max:255|unique:lembaga_desas,kode',
            'no_sk'          => 'nullable|string|max:255',
            'ketua'          => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'deskripsi'      => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'aktif'          => 'required|in:0,1',
        ]);

        $data = $request->only([
            'kategori_id',
            'nama',
            'kode',
            'no_sk',
            'ketua',
            'jumlah_anggota',
            'deskripsi',
            'aktif',
        ]);
        $data['jumlah_anggota'] = $data['jumlah_anggota'] ?? 0;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('lembaga-desa', 'public');
        }

        $lembaga = LembagaDesa::create($data);
        $this->syncKetua($lembaga, $request->ketua);

        return redirect()->route('admin.lembaga-desa.index')
            ->with('success', 'Lembaga desa berhasil ditambahkan.');
    }

    public function show(Request $request, $id) {
        $lembaga = LembagaDesa::with('kategori')->findOrFail($id);
        $perPage = (int) $request->get('per_page', 10);

        try {
            $query = $lembaga->anggota()->with('penduduk');

            if ($request->filled('status_dasar')) {
                $query->whereHas('penduduk', fn($p) => $p->where('status_dasar', $request->status_dasar));
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas(
                    'penduduk',
                    fn($p) =>
                    $p->where('nama', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                );
            }

            $anggota = $query->paginate($perPage)->withQueryString();
        } catch (\Exception $e) {
            $anggota = new LengthAwarePaginator([], 0, $perPage, 1, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);
        }

        $perangkat = PerangkatDesa::with('jabatan')->orderBy('urutan')->get();
        return view('admin.info-desa.lembaga-desa.show', compact('lembaga', 'anggota', 'perangkat'));
    }

    public function edit($id) {
        $lembaga   = LembagaDesa::findOrFail($id);
        $kategoris = LembagaKategori::orderBy('nama')->get();
        $penduduk  = Penduduk::where('status_dasar', 'hidup')->orderBy('nama')->get();

        return view('admin.info-desa.lembaga-desa.edit', compact('lembaga', 'kategoris', 'penduduk'));
    }

    public function update(Request $request, $id) {
        $lembaga = LembagaDesa::findOrFail($id);

        $request->validate([
            'kategori_id'    => 'required|exists:lembaga_kategoris,id',
            'nama'           => 'required|string|max:255',
            'kode'           => 'required|string|max:255|unique:lembaga_desas,kode,' . $lembaga->id,
            'no_sk'          => 'nullable|string|max:255',
            'ketua'          => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'deskripsi'      => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'aktif'          => 'required|in:0,1',
        ]);

        $data = $request->only([
            'kategori_id',
            'nama',
            'kode',
            'no_sk',
            'ketua',
            'jumlah_anggota',
            'deskripsi',
            'aktif',
        ]);
        $data['jumlah_anggota'] = $data['jumlah_anggota'] ?? 0;

        if ($request->hasFile('logo')) {
            if ($lembaga->logo && Storage::disk('public')->exists($lembaga->logo)) {
                Storage::disk('public')->delete($lembaga->logo);
            }
            $data['logo'] = $request->file('logo')->store('lembaga-desa', 'public');
        }

        $ketuaLama = $lembaga->ketua;
        $lembaga->update($data);

        if ($ketuaLama !== $request->ketua) {
            $nikLama = explode('-', $ketuaLama ?? '')[0] ?? null;
            if ($nikLama) {
                $pendudukLama = Penduduk::where('nik', $nikLama)->first();
                if ($pendudukLama) {
                    LembagaAnggota::where('lembaga_id', $lembaga->id)
                        ->where('penduduk_id', $pendudukLama->id)
                        ->where('jabatan', 'Ketua')
                        ->delete();
                }
            }
        }

        $this->syncKetua($lembaga, $request->ketua);

        return redirect()->route('admin.lembaga-desa.index')
            ->with('success', 'Data lembaga desa berhasil diperbarui.');
    }

    public function destroy(Request $request, $id = null) {
        $ids = $request->input('ids', []);
        if ($id) $ids = array_merge($ids, [$id]);

        if (empty($ids)) {
            return back()->with('error', 'Tidak ada lembaga yang dipilih untuk dihapus.');
        }

        foreach ($ids as $lembagaId) {
            $lembaga = LembagaDesa::find($lembagaId);
            if (!$lembaga) continue;

            if ($lembaga->logo && Storage::disk('public')->exists($lembaga->logo)) {
                Storage::disk('public')->delete($lembaga->logo);
            }

            $lembaga->delete();
        }

        return redirect()->route('admin.lembaga-desa.index')
            ->with('success', 'Data lembaga desa berhasil dihapus.');
    }

    // ── Cetak ──
    public function cetak(Request $request) {
        $lembaga        = $this->queryLembagaUntukLaporan($request);
        $identitas      = IdentitasDesa::first();
        $ditandatangani = PerangkatDesa::with('jabatan')->find($request->ditandatangani);
        $diketahui      = PerangkatDesa::with('jabatan')->find($request->diketahui);

        return view('admin.info-desa.lembaga-desa.cetak', compact(
            'lembaga',
            'identitas',
            'ditandatangani',
            'diketahui'
        ));
    }

    // ── Unduh ──
    public function unduh(Request $request) {
        $lembaga        = $this->queryLembagaUntukLaporan($request);
        $identitas      = IdentitasDesa::first();
        $ditandatangani = PerangkatDesa::with('jabatan')->find($request->ditandatangani);
        $diketahui      = PerangkatDesa::with('jabatan')->find($request->diketahui);

        $html = view('admin.info-desa.lembaga-desa.cetak', compact(
            'lembaga',
            'identitas',
            'ditandatangani',
            'diketahui'
        ))->render();

        return response($html, 200, [
            'Content-Type'        => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data-lembaga-desa.html"',
        ]);
    }

    // ── Helpers ──
    private function queryLembagaUntukLaporan(Request $request) {
        $query = LembagaDesa::with('kategori')->withCount('anggota');

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        return $query->orderBy('nama')->get();
    }

    private function syncKetua(LembagaDesa $lembaga, ?string $ketuaString): void {
        if (!$ketuaString) return;

        $nik = explode('-', $ketuaString)[0] ?? null;
        if (!$nik) return;

        $penduduk = Penduduk::where('nik', $nik)->first();
        if (!$penduduk) return;

        LembagaAnggota::firstOrCreate(
            ['lembaga_id'  => $lembaga->id, 'penduduk_id' => $penduduk->id],
            ['jabatan'     => 'Ketua', 'no_anggota'  => '1']
        );
    }
}
