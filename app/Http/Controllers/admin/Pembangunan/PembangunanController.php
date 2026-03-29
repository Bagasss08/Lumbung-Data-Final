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

        $perPage     = in_array(request('per_page'), [10, 25, 50, 100]) ? (int) request('per_page') : 15;
        $pembangunan = $query->latest()->paginate($perPage)->withQueryString();

        // Data untuk filter
        $tahunList  = Pembangunan::where('config_id', 1)
            ->selectRaw('DISTINCT tahun_anggaran')
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $bidangs    = RefPembangunanBidang::orderBy('id')->get();
        $sasarans   = RefPembangunanSasaran::orderBy('id')->get();
        $sumberDana = RefPembangunanSumberDana::orderBy('id')->get();

        // Statistik — hitung "selesai" berdasarkan dokumentasi TERBARU per kegiatan
        $selesai = Pembangunan::where('config_id', 1)
            ->whereHas('dokumentasis', function ($q) {
                $q->whereIn('id', function ($sub) {
                    $sub->select(DB::raw('MAX(id)'))
                        ->from('pembangunan_ref_dokumentasi')
                        ->groupBy('id_pembangunan');
                })->where('persentase', 100);
            })
            ->count();

        $stats = [
            'total'          => Pembangunan::where('config_id', 1)->count(),
            'total_anggaran' => Pembangunan::where('config_id', 1)
                ->selectRaw('SUM(dana_pemerintah + dana_provinsi + dana_kabkota + swadaya + sumber_lain) as total')
                ->value('total') ?? 0,
            'selesai'  => $selesai,
            'aktif'    => Pembangunan::where('config_id', 1)->where('status', 1)->count(),
            'nonaktif' => Pembangunan::where('config_id', 1)->where('status', 0)->count(),
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
        $wilayahs   = $this->getWilayahList();

        return view('admin.pembangunan.create', compact(
            'bidangs',
            'sasarans',
            'sumberDana',
            'wilayahs'
        ));
    }

    public function store(Request $request) {
        $validated              = $this->validatePembangunan($request);
        $validated['config_id'] = 1;

        // Kolom NOT NULL di DB: pastikan tidak null, default 0
        $numericCols = ['dana_pemerintah', 'dana_provinsi', 'dana_kabkota', 'swadaya', 'sumber_lain'];
        foreach ($numericCols as $col) {
            $validated[$col] = isset($validated[$col]) && $validated[$col] !== null && $validated[$col] !== ''
                ? (float) $validated[$col]
                : 0;
        }

        // Hitung pagu anggaran di server (jangan percaya hidden input dari client)
        $validated['pagu_anggaran'] = $validated['dana_pemerintah']
            + $validated['dana_provinsi']
            + $validated['dana_kabkota']
            + $validated['swadaya']
            + $validated['sumber_lain'];

        // Sumber dana multi-select: simpan yang pertama ke kolom id_sumber_dana
        if ($request->filled('id_sumber_dana') && is_array($request->id_sumber_dana)) {
            $validated['id_sumber_dana'] = $request->id_sumber_dana[0];
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('pembangunan/foto', 'public');
        }

        $item = Pembangunan::create($validated);

        return redirect()->route('admin.pembangunan-utama.show', $item)
            ->with('success', 'Data pembangunan berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────────────────
    // SHOW — Detail + Dokumentasi
    // ──────────────────────────────────────────────────────────

    public function show(Pembangunan $pembangunan) {
        $pembangunan->load(['bidang', 'sasaran', 'sumberDana', 'dokumentasis']);

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

        // Kolom NOT NULL di DB: default ke 0 jika kosong
        $numericCols = ['dana_pemerintah', 'dana_provinsi', 'dana_kabkota', 'swadaya', 'sumber_lain'];
        foreach ($numericCols as $col) {
            $validated[$col] = isset($validated[$col]) && $validated[$col] !== null && $validated[$col] !== ''
                ? (float) $validated[$col]
                : 0;
        }

        // Hitung ulang pagu anggaran di server
        $validated['pagu_anggaran'] = $validated['dana_pemerintah']
            + $validated['dana_provinsi']
            + $validated['dana_kabkota']
            + $validated['swadaya']
            + $validated['sumber_lain'];

        // Sumber dana multi-select
        if ($request->filled('id_sumber_dana') && is_array($request->id_sumber_dana)) {
            $validated['id_sumber_dana'] = $request->id_sumber_dana[0];
        }

        if ($request->hasFile('foto')) {
            if ($pembangunan->foto) {
                Storage::disk('public')->delete($pembangunan->foto);
            }
            $validated['foto'] = $request->file('foto')
                ->store('pembangunan/foto', 'public');
        }

        $pembangunan->update($validated);

        return redirect()->route('admin.pembangunan-utama.show', $pembangunan)
            ->with('success', 'Data pembangunan berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────────────────
    // DESTROY
    // ──────────────────────────────────────────────────────────

    public function destroy(Pembangunan $pembangunan) {
        // Hapus semua foto dokumentasi
        foreach ($pembangunan->dokumentasis as $dok) {
            if ($dok->foto) {
                Storage::disk('public')->delete($dok->foto);
            }
        }

        // Hapus foto utama
        if ($pembangunan->foto) {
            Storage::disk('public')->delete($pembangunan->foto);
        }

        $pembangunan->delete();

        return redirect()->route('admin.pembangunan-utama.index')
            ->with('success', 'Data pembangunan berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // TOGGLE STATUS — Aktif / Non-Aktif
    // ──────────────────────────────────────────────────────────

    public function toggleStatus(Pembangunan $pembangunan) {
        $newStatus = $pembangunan->status == 1 ? 0 : 1;

        $pembangunan->update(['status' => $newStatus]);

        $label = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.pembangunan-utama.index')
            ->with('success', "Kegiatan \"{$pembangunan->nama}\" berhasil {$label}.");
    }

    // ──────────────────────────────────────────────────────────
    // LOKASI — Halaman peta Leaflet / OpenStreetMap
    // ──────────────────────────────────────────────────────────

    /**
     * Tampilkan halaman peta untuk menentukan koordinat lokasi pembangunan.
     */
    public function lokasi(Pembangunan $pembangunan) {
        $pembangunan->load(['bidang', 'lokasi']); // eager load relasi yang dipakai di blade

        $lat = is_numeric($pembangunan->lat) ? $pembangunan->lat : null;
        $lng = is_numeric($pembangunan->lng) ? $pembangunan->lng : null;

        return view('admin.pembangunan.lokasi', compact('pembangunan', 'lat', 'lng'));
    }

    /**
     * Simpan koordinat lat/lng dari halaman peta.
     */
    public function lokasiUpdate(Request $request, Pembangunan $pembangunan) {
        $validated = $request->validate([
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
        ]);

        $pembangunan->update([
            'lat' => $validated['lat'] ?? null,
            'lng' => $validated['lng'] ?? null,
        ]);

        return redirect()->route('admin.pembangunan-utama.lokasi', $pembangunan)
            ->with('success', 'Koordinat lokasi berhasil disimpan.');
    }

    /**
     * Ekspor koordinat sebagai file GPX (GPS Exchange Format).
     * Kompatibel dengan Google Earth, aplikasi GPS, dll.
     */
    public function lokasiGpx(Pembangunan $pembangunan) {
        if (! $pembangunan->lat || ! $pembangunan->lng) {
            return redirect()->route('admin.pembangunan-utama.lokasi', $pembangunan)
                ->with('error', 'Koordinat belum tersedia untuk diekspor.');
        }

        $nama  = e($pembangunan->nama);
        $lat   = $pembangunan->lat;
        $lng   = $pembangunan->lng;
        $tahun = $pembangunan->tahun_anggaran;
        $waktu = now()->toIso8601String();

        $gpx = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Lumbung Data"
     xmlns="http://www.topografix.com/GPX/1/1"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="http://www.topografix.com/GPX/1/1
     http://www.topografix.com/GPX/1/1/gpx.xsd">
  <metadata>
    <name>Lokasi Pembangunan - {$nama}</name>
    <time>{$waktu}</time>
  </metadata>
  <wpt lat="{$lat}" lon="{$lng}">
    <name>{$nama}</name>
    <desc>Kegiatan Pembangunan Tahun {$tahun}</desc>
    <time>{$waktu}</time>
  </wpt>
</gpx>
XML;

        $filename = 'lokasi-pembangunan-' . $pembangunan->id . '.gpx';

        return response($gpx, 200, [
            'Content-Type'        => 'application/gpx+xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ──────────────────────────────────────────────────────────
    // DOKUMENTASI — Tambah / Hapus entri dokumentasi & persentase
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

        return redirect()->route('admin.pembangunan-utama.show', $pembangunan)
            ->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function destroyDokumentasi(Pembangunan $pembangunan, PembangunanRefDokumentasi $dokumentasi) {
        if ($dokumentasi->foto) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }

        $dokumentasi->delete();

        return redirect()->route('admin.pembangunan-utama.show', $pembangunan)
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }

    // ──────────────────────────────────────────────────────────
    // Helpers (private)
    // ──────────────────────────────────────────────────────────

    /**
     * Ambil daftar wilayah administratif (dusun/RW/RT).
     */
    private function getWilayahList(): \Illuminate\Support\Collection {
        try {
            return DB::table('wilayah')
                ->select('id', 'dusun', 'rw', 'rt')
                ->orderBy('dusun')
                ->orderBy('rw')
                ->orderBy('rt')
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Validasi input form pembangunan (dipakai store & update).
     */
    private function validatePembangunan(Request $request, ?int $id = null): array {
        $validated = $request->validate([
            'id_bidang'            => 'nullable|exists:ref_pembangunan_bidang,id',
            'id_sasaran'           => 'nullable|exists:ref_pembangunan_sasaran,id',
            'id_sumber_dana'       => 'nullable|array',
            'id_sumber_dana.*'     => 'integer|exists:ref_pembangunan_sumber_dana,id',
            'id_lokasi'            => 'required|integer',
            'tahun_anggaran'       => 'required|integer|min:2000|max:2099',
            'nama'                 => 'required|string|min:5|max:200',
            'pelaksana'            => 'required|string|max:200',
            'manfaat'              => 'required|string',
            'keterangan'           => 'required|string',
            'volume'               => 'required|numeric|min:0',
            'satuan'               => 'nullable|string|max:50',
            'waktu'                => 'required|integer|min:0',
            'satuan_waktu'         => 'nullable|in:Hari,Minggu,Bulan,Tahun',
            'mulai_pelaksanaan'    => 'nullable|date',
            'akhir_pelaksanaan'    => 'nullable|date|after_or_equal:mulai_pelaksanaan',
            'dana_pemerintah'      => 'required|numeric|min:0',
            'dana_provinsi'        => 'required|numeric|min:0',
            'dana_kabkota'         => 'required|numeric|min:0',
            'swadaya'              => 'required|numeric|min:0',
            'sumber_lain'          => 'required|numeric|min:0',
            'realisasi'            => 'nullable|numeric|min:0',
            'sifat_proyek'         => 'required|in:Baru,Lanjutan',
            'lat'                  => 'nullable|numeric|between:-90,90',
            'lng'                  => 'nullable|numeric|between:-180,180',
            'foto'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'dokumentasi'          => 'nullable|string',
            'status'               => 'nullable|in:0,1',
        ], [
            'nama.required'           => 'Nama kegiatan wajib diisi.',
            'nama.min'                => 'Nama kegiatan minimal :min karakter.',
            'nama.max'                => 'Nama kegiatan maksimal :max karakter.',
            'tahun_anggaran.required' => 'Tahun anggaran wajib dipilih.',
            'tahun_anggaran.integer'  => 'Tahun anggaran harus berupa angka.',
            'tahun_anggaran.min'      => 'Tahun anggaran tidak valid.',
            'tahun_anggaran.max'      => 'Tahun anggaran tidak valid.',
            'volume.required'         => 'Volume wajib diisi.',
            'volume.numeric'          => 'Volume harus berupa angka.',
            'volume.min'              => 'Volume tidak boleh negatif.',
            'waktu.required'          => 'Waktu pelaksanaan wajib diisi.',
            'waktu.integer'           => 'Waktu harus berupa angka bulat.',
            'waktu.min'               => 'Waktu tidak boleh negatif.',
            'dana_pemerintah.required' => 'Sumber biaya pemerintah wajib diisi.',
            'dana_pemerintah.numeric'  => 'Dana pemerintah harus berupa angka.',
            'dana_pemerintah.min'      => 'Dana pemerintah tidak boleh negatif.',
            'dana_provinsi.required'   => 'Sumber biaya provinsi wajib diisi.',
            'dana_provinsi.numeric'    => 'Dana provinsi harus berupa angka.',
            'dana_provinsi.min'        => 'Dana provinsi tidak boleh negatif.',
            'dana_kabkota.required'    => 'Sumber biaya kab/kota wajib diisi.',
            'dana_kabkota.numeric'     => 'Dana kab/kota harus berupa angka.',
            'dana_kabkota.min'         => 'Dana kab/kota tidak boleh negatif.',
            'swadaya.required'         => 'Sumber biaya swadaya wajib diisi.',
            'swadaya.numeric'          => 'Dana swadaya harus berupa angka.',
            'swadaya.min'              => 'Dana swadaya tidak boleh negatif.',
            'sumber_lain.required'     => 'SILPA wajib diisi.',
            'sumber_lain.numeric'      => 'SILPA harus berupa angka.',
            'sumber_lain.min'          => 'SILPA tidak boleh negatif.',
            'realisasi.numeric'        => 'Realisasi anggaran harus berupa angka.',
            'realisasi.min'            => 'Realisasi anggaran tidak boleh negatif.',
            'sifat_proyek.required'    => 'Sifat proyek wajib dipilih.',
            'sifat_proyek.in'          => 'Sifat proyek hanya boleh Baru atau Lanjutan.',
            'pelaksana.required'       => 'Pelaksana kegiatan wajib diisi.',
            'manfaat.required'         => 'Manfaat wajib diisi.',
            'keterangan.required'      => 'Keterangan wajib diisi.',
            'foto.image'               => 'File gambar tidak valid.',
            'foto.mimes'               => 'Format gambar harus JPG, PNG, atau WebP.',
            'foto.max'                 => 'Ukuran gambar maksimal 5 MB.',
            'id_lokasi.required'       => 'Lokasi pembangunan wajib dipilih.',
            'id_sumber_dana.*.exists'  => 'Sumber dana yang dipilih tidak valid.',
        ]);

        return $validated;
    }
}
