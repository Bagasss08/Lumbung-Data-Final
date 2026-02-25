<?php

namespace App\Http\Controllers\Admin\Pembangunan;

use App\Http\Controllers\Controller;
use App\Models\Pembangunan;
use App\Models\PembangunanRefDokumentasi;
use App\Models\RefPembangunanBidang;
use App\Models\RefPembangunanSasaran;
use App\Models\RefPembangunanSumberDana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PembangunanController extends Controller {
    // ──────────────────────────────────────────────────────────
    // INDEX — Daftar kegiatan pembangunan
    // ──────────────────────────────────────────────────────────

    public function index(Request $request) {
        $query = Pembangunan::with(['bidang', 'sasaran', 'sumberDana', 'dokumentasis'])
            ->where('config_id', 1);

        if ($request->filled('tahun')) {
            $query->where('tahun_anggaran', $request->tahun);
        }
        if ($request->filled('id_bidang')) {
            $query->where('id_bidang', $request->id_bidang);
        }
        if ($request->filled('id_sasaran')) {
            $query->where('id_sasaran', $request->id_sasaran);
        }
        if ($request->filled('id_sumber_dana')) {
            $query->where('id_sumber_dana', $request->id_sumber_dana);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $pembangunan = $query->latest()->paginate(15)->withQueryString();

        // Data untuk filter
        $tahunList  = Pembangunan::where('config_id', 1)
            ->selectRaw('DISTINCT tahun_anggaran')
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $bidangs    = RefPembangunanBidang::orderBy('id')->get();
        $sasarans   = RefPembangunanSasaran::orderBy('id')->get();
        $sumberDana = RefPembangunanSumberDana::orderBy('id')->get();

        // Statistik ringkas
        $stats = [
            'total'           => Pembangunan::where('config_id', 1)->count(),
            'total_anggaran'  => Pembangunan::where('config_id', 1)
                ->selectRaw('SUM(dana_pemerintah + dana_provinsi + dana_kabkota + swadaya + sumber_lain) as total')
                ->value('total') ?? 0,
            'selesai'         => Pembangunan::where('config_id', 1)
                ->whereHas('dokumentasis', fn($q) => $q->where('persentase', 100))
                ->count(),
        ];
        $stats['berjalan'] = $stats['total'] - $stats['selesai'];

        return view('admin.pembangunan.index', compact(
            'pembangunan',
            'tahunList',
            'bidangs',
            'sasarans',
            'sumberDana',
            'stats'
        ));
    }

    // ──────────────────────────────────────────────────────────
    // CREATE / STORE
    // ──────────────────────────────────────────────────────────

    public function create() {
        $bidangs    = RefPembangunanBidang::orderBy('id')->get();
        $sasarans   = RefPembangunanSasaran::orderBy('id')->get();
        $sumberDana = RefPembangunanSumberDana::orderBy('id')->get();

        // Wilayah administratif (dusun/RW/RT)
        // Sesuai OpenSID: lokasi dari tweb_wil_clusterdesa
        $wilayahs = $this->getWilayahList();

        return view('admin.pembangunan.create', compact(
            'bidangs',
            'sasarans',
            'sumberDana',
            'wilayahs'
        ));
    }

    public function store(Request $request) {
        $validated = $this->validatePembangunan($request);
        $validated['config_id'] = 1;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('pembangunan/foto', 'public');
        }

        $item = Pembangunan::create($validated);

        return redirect()->route('admin.pembangunan.show', $item)
            ->with('success', 'Data pembangunan berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────────────
    // SHOW — Detail + Dokumentasi
    // ──────────────────────────────────────────────────────────

    public function show(Pembangunan $pembangunan) {
        $pembangunan->load(['bidang', 'sasaran', 'sumberDana', 'lokasi', 'dokumentasis']);
        return view('admin.pembangunan.show', compact('pembangunan'));
    }

    // ──────────────────────────────────────────────────────────
    // EDIT / UPDATE
    // ──────────────────────────────────────────────────────────

    public function edit(Pembangunan $pembangunan) {
        $bidangs    = RefPembangunanBidang::orderBy('id')->get();
        $sasarans   = RefPembangunanSasaran::orderBy('id')->get();
        $sumberDana = RefPembangunanSumberDana::orderBy('id')->get();
        $wilayahs   = $this->getWilayahList();

        return view('admin.pembangunan.edit', compact(
            'pembangunan',
            'bidangs',
            'sasarans',
            'sumberDana',
            'wilayahs'
        ));
    }

    public function update(Request $request, Pembangunan $pembangunan) {
        $validated = $this->validatePembangunan($request, $pembangunan->id);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pembangunan->foto) {
                Storage::disk('public')->delete($pembangunan->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('pembangunan/foto', 'public');
        }

        $pembangunan->update($validated);

        return redirect()->route('admin.pembangunan.show', $pembangunan)
            ->with('success', 'Data pembangunan berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────────────
    // DESTROY
    // ──────────────────────────────────────────────────────────

    public function destroy(Pembangunan $pembangunan) {
        // Hapus semua foto dokumentasi
        foreach ($pembangunan->dokumentasis as $dok) {
            if ($dok->foto) Storage::disk('public')->delete($dok->foto);
        }
        // Hapus foto utama
        if ($pembangunan->foto) {
            Storage::disk('public')->delete($pembangunan->foto);
        }

        $pembangunan->delete();

        return redirect()->route('admin.pembangunan.index')
            ->with('success', 'Data pembangunan berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // DOKUMENTASI — Tambah entri dokumentasi & persentase
    // Sesuai OpenSID: progres disimpan di pembangunan_ref_dokumentasi.persentase
    // ──────────────────────────────────────────────────────────

    public function storeDokumentasi(Request $request, Pembangunan $pembangunan) {
        $request->validate([
            'judul'      => 'required|string|max:200',
            'persentase' => 'required|integer|min:0|max:100',
            'tanggal'    => 'required|date',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'uraian'     => 'nullable|string',
        ]);

        $data = $request->only(['judul', 'persentase', 'tanggal', 'uraian']);
        $data['id_pembangunan'] = $pembangunan->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('pembangunan/dokumentasi', 'public');
        }

        PembangunanRefDokumentasi::create($data);

        return redirect()->route('admin.pembangunan.show', $pembangunan)
            ->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function destroyDokumentasi(Pembangunan $pembangunan, PembangunanRefDokumentasi $dokumentasi) {
        if ($dokumentasi->foto) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }
        $dokumentasi->delete();

        return redirect()->route('admin.pembangunan.show', $pembangunan)
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────────────────

    /**
     * Ambil daftar wilayah administratif.
     * Menggunakan tabel wilayah (dusun/RW/RT) yang sudah ada di database.
     */
    private function getWilayahList(): \Illuminate\Support\Collection {
        try {
            // Ambil dari tabel wilayah
            return DB::table('wilayah')
                ->select('id', 'dusun', 'rw', 'rt')
                ->orderBy('dusun')->orderBy('rw')->orderBy('rt')
                ->get();
        } catch (\Exception $e) {
            // Fallback ke collection kosong jika tabel belum ada
            return collect();
        }
    }

    private function validatePembangunan(Request $request, ?int $id = null): array {
        return $request->validate([
            'id_bidang'         => 'nullable|exists:ref_pembangunan_bidang,id',
            'id_sasaran'        => 'nullable|exists:ref_pembangunan_sasaran,id',
            'id_sumber_dana'    => 'nullable|exists:ref_pembangunan_sumber_dana,id',
            'id_lokasi'         => 'nullable|integer',
            'tahun_anggaran'    => 'required|integer|min:2000|max:2099',
            'nama'              => 'required|string|max:200',
            'pelaksana'         => 'nullable|string|max:200',
            'volume'            => 'nullable|numeric|min:0',
            'satuan'            => 'nullable|string|max:50',
            'waktu'             => 'nullable|integer|min:0',
            'mulai_pelaksanaan' => 'nullable|date',
            'akhir_pelaksanaan' => 'nullable|date|after_or_equal:mulai_pelaksanaan',
            'dana_pemerintah'   => 'nullable|numeric|min:0',
            'dana_provinsi'     => 'nullable|numeric|min:0',
            'dana_kabkota'      => 'nullable|numeric|min:0',
            'swadaya'           => 'nullable|numeric|min:0',
            'sumber_lain'       => 'nullable|numeric|min:0',
            'lat'               => 'nullable|numeric|between:-90,90',
            'lng'               => 'nullable|numeric|between:-180,180',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'dokumentasi'       => 'nullable|string',
            'status'            => 'nullable|boolean',
        ]);
    }
}
