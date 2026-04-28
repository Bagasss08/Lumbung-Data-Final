<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\RumahTangga;
use App\Models\Wilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

class RumahTanggaController extends Controller {
    // =========================================================================
    // INDEX
    // =========================================================================
    public function index(Request $request) {
        $query = RumahTangga::with([
            'wilayah',
            'keluarga' => fn($q) => $q->oldest()->with('kepalaKeluarga:id,nama,nik'),
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_rumah_tangga', 'like', "%{$search}%")
                    ->orWhereHas(
                        'keluarga.kepalaKeluarga',
                        fn($q2) =>
                        $q2->where('nama', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%")
                    );
            });
        }

        if ($request->filled('klasifikasi_ekonomi')) {
            $query->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi);
        }

        if ($request->filled('dusun')) {
            $query->whereHas('wilayah', fn($q) => $q->where('dusun', $request->dusun));
        }

        // Filter status
        if ($request->filled('status')) {
            match ($request->status) {
                'aktif'         => $query->whereHas('keluarga'),
                'tidak_aktif'   => $query->whereDoesntHave('keluarga'),
                'tanpa_kepala'  => $query->whereDoesntHave('keluarga.kepalaKeluarga'),
                default         => null,
            };
        }

        // Filter jenis kelamin kepala RT
        if ($request->filled('jenis_kelamin')) {
            $query->whereHas(
                'keluarga.kepalaKeluarga',
                fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin)
            );
        }

        $perPage     = (int) $request->get('per_page', 10);
        $rumahTangga = $query->orderBy('no_rumah_tangga')
            ->paginate($perPage)
            ->appends($request->query());

        $total_rumah_tangga = RumahTangga::count();
        $wilayahList        = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();
        $dusunList          = $wilayahList->pluck('dusun')->filter()->unique()->values();

        return view('admin.rumah-tangga', compact(
            'rumahTangga',
            'total_rumah_tangga',
            'wilayahList',
            'dusunList',
        ));
    }

    // =========================================================================
    // AJAX — cari penduduk untuk modal Tambah / Edit
    // GET /admin/rumah-tangga/cari-penduduk?q=nama_atau_nik
    // =========================================================================
    public function cariPenduduk(Request $request) {
        $q = $request->get('q', '');

        $results = Penduduk::whereNotNull('keluarga_id')
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%");
            })
            ->with([
                'keluarga:id,no_kk,alamat,wilayah_id',
                'keluarga.wilayah:id,dusun,rw,rt',
                'keluarga.anggota' => fn($q) => $q
                    ->select('id', 'keluarga_id', 'nik', 'nama', 'kk_level')
                    ->with('shdk:id,nama')
                    ->orderBy('kk_level')
                    ->orderBy('nama'),
            ])
            ->select('id', 'nama', 'nik', 'keluarga_id')
            ->limit(15)
            ->get()
            ->map(fn($p) => [
                'id'          => $p->id,
                'text'        => "{$p->nama} ({$p->nik})",
                'nama'        => $p->nama,
                'nik'         => $p->nik,
                'keluarga_id' => $p->keluarga_id,
                // Kirim info wilayah & alamat dari KK penduduk untuk ditampilkan di modal
                'alamat'      => $p->keluarga?->alamat ?? null,
                'wilayah_id'  => $p->keluarga?->wilayah_id ?? null,
                'wilayah_label' => $p->keluarga?->wilayah
                    ? ($p->keluarga->wilayah->dusun . ' / RW ' . $p->keluarga->wilayah->rw . ' / RT ' . $p->keluarga->wilayah->rt)
                    : null,
                'anggota'     => $p->keluarga
                    ? $p->keluarga->anggota->map(fn($a) => [
                        'id'        => $a->id,
                        'nik'       => $a->nik,
                        'nama'      => $a->nama,
                        'kk_level'  => $a->kk_level,
                        'hubungan'  => $a->kk_level == Penduduk::SHDK_KEPALA_KELUARGA
                            ? 'Kepala Keluarga'
                            : ($a->shdk->nama ?? '-'),
                    ])->values()
                    : collect([[
                        'id'       => $p->id,
                        'nik'      => $p->nik,
                        'nama'     => $p->nama,
                        'kk_level' => Penduduk::SHDK_KEPALA_KELUARGA,
                        'hubungan' => 'Kepala Keluarga',
                    ]]),
            ]);

        return response()->json($results);
    }

    // =========================================================================
    // CREATE — tidak dipakai (pakai modal di index)
    // =========================================================================
    public function create() {
        return redirect()->route('admin.rumah-tangga.index');
    }

    // =========================================================================
    // STORE — dipanggil dari modal Tambah
    // =========================================================================
    public function store(Request $request) {
        $validated = $request->validate([
            'no_rumah_tangga'     => 'nullable|string|max:20|unique:rumah_tangga,no_rumah_tangga,NULL,id,deleted_at,NULL',
            'kepala_penduduk_id'  => 'required|exists:penduduk,id',
            'bdt'                 => 'nullable|string|max:50',
            'is_dtks'             => 'nullable|boolean',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'tgl_terdaftar'       => 'nullable|date',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
        ]);

        $manualNoRumahTangga = !empty($validated['no_rumah_tangga']);

        // Ambil penduduk beserta keluarga & wilayahnya
        $penduduk = Penduduk::with([
            'keluarga:id,alamat,wilayah_id,rumah_tangga_id',
            'keluarga.wilayah:id,dusun,rw,rt',
            'wilayah:id,dusun,rw,rt',   // wilayah langsung di penduduk (beberapa sistem)
        ])->findOrFail($validated['kepala_penduduk_id']);

        $keluarga  = $penduduk->keluarga;

        // Ambil alamat & wilayah — prioritas dari KK, fallback dari penduduk langsung
        $alamat    = $keluarga?->alamat    ?? $penduduk->alamat    ?? null;
        $wilayahId = $keluarga?->wilayah_id ?? $penduduk->wilayah_id ?? null;

        $payload = [
            'alamat'              => $alamat,
            'wilayah_id'          => $wilayahId,
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'] ?? null,
            'tgl_terdaftar'       => $validated['tgl_terdaftar'] ?? now(),
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'] ?? null,
        ];

        if (Schema::hasColumn('rumah_tangga', 'bdt')) {
            $payload['bdt'] = $validated['bdt'] ?? null;
        }
        if (Schema::hasColumn('rumah_tangga', 'is_dtks')) {
            $payload['is_dtks'] = !empty($validated['is_dtks']);
        }
        // Simpan referensi langsung ke kepala penduduk (jika kolom tersedia)
        // Ini memastikan getKepalaRumahTangga() punya fallback
        if (Schema::hasColumn('rumah_tangga', 'kepala_penduduk_id')) {
            $payload['kepala_penduduk_id'] = $penduduk->id;
        }

        $rumahTangga = null;
        for ($attempt = 0; $attempt < 3; $attempt++) {
            if ($manualNoRumahTangga) {
                $payload['no_rumah_tangga'] = $validated['no_rumah_tangga'];
            } else {
                $last = RumahTangga::withTrashed()->orderByDesc('no_rumah_tangga')->value('no_rumah_tangga');
                $next = (int) preg_replace('/\D/', '', $last ?? '0') + 1;
                $payload['no_rumah_tangga'] = 'RT' . str_pad($next, 3, '0', STR_PAD_LEFT);
            }

            try {
                $rumahTangga = RumahTangga::create($payload);
                break;
            } catch (QueryException $e) {
                if ($manualNoRumahTangga || !str_contains($e->getMessage(), '1062')) {
                    throw $e;
                }
            }
        }

        if (!$rumahTangga) {
            return back()
                ->withInput()
                ->withErrors(['no_rumah_tangga' => 'Gagal membuat nomor rumah tangga otomatis. Silakan coba lagi.']);
        }

        // Kaitkan KK ke RT
        if ($keluarga) {
            $keluarga->update(['rumah_tangga_id' => $rumahTangga->id]);
        }

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', "Rumah tangga {$rumahTangga->no_rumah_tangga} berhasil ditambahkan.");
    }

    // =========================================================================
    // SHOW — Rincian anggota rumah tangga
    // =========================================================================
    public function show(RumahTangga $rumahTangga) {
        $rumahTangga->load([
            'wilayah',
            'keluarga' => fn($q) => $q
                ->with([
                    'kepalaKeluarga:id,nama,nik',
                    'anggota' => fn($q2) => $q2->orderBy('kk_level')->orderBy('nama'),
                ])
                ->orderBy('no_kk'),
        ]);

        // KK yang belum masuk rumah tangga manapun (untuk modal tambah KK)
        $kkTersedia = Keluarga::aktif()
            ->whereNull('rumah_tangga_id')
            ->with('kepalaKeluarga:id,nama,nik')
            ->select('id', 'no_kk', 'kepala_keluarga_id')
            ->orderBy('no_kk')
            ->get();

        return view('admin.rumah-tangga-show', compact('rumahTangga', 'kkTersedia'));
    }

    // =========================================================================
    // TAMBAH KK — Masukkan KK yang belum ber-RT ke RT ini
    // POST /admin/rumah-tangga/{rumahTangga}/tambah-kk
    // =========================================================================
    public function tambahKk(Request $request, RumahTangga $rumahTangga) {
        $request->validate([
            'keluarga_id' => 'required|exists:keluarga,id',
        ]);

        $kk = Keluarga::findOrFail($request->keluarga_id);

        if ($kk->rumah_tangga_id) {
            return back()->with('error', "KK {$kk->no_kk} sudah terdaftar di rumah tangga lain.");
        }

        $kk->update(['rumah_tangga_id' => $rumahTangga->id]);

        return back()->with('success', "KK {$kk->no_kk} berhasil ditambahkan ke rumah tangga {$rumahTangga->no_rumah_tangga}.");
    }

    // =========================================================================
    // LEPAS KK — Copot KK dari RT ini (tanpa menghapus KK atau anggotanya)
    // DELETE /admin/rumah-tangga/{rumahTangga}/lepas-kk/{keluarga}
    // =========================================================================
    public function lepasKk(RumahTangga $rumahTangga, Keluarga $keluarga) {
        if ((int) $keluarga->rumah_tangga_id !== $rumahTangga->id) {
            return back()->with('error', 'KK tersebut tidak terdaftar dalam rumah tangga ini.');
        }

        $keluarga->update(['rumah_tangga_id' => null]);

        return back()->with('success', "KK {$keluarga->no_kk} berhasil dilepas dari rumah tangga {$rumahTangga->no_rumah_tangga}.");
    }

    // ── LOKASI — Tampilkan peta lokasi rumah tangga ───────────────────────────
    public function lokasi(RumahTangga $rumahTangga) {
        $rumahTangga->load(['wilayah', 'keluarga.kepalaKeluarga']);

        $kepala = $rumahTangga->getKepalaRumahTangga();

        // Ambil koordinat: prioritas kolom lat/lng di tabel rumah_tangga,
        // lalu fallback ke kepala penduduk, lalu ke wilayah
        $lat = null;
        $lng = null;

        if (Schema::hasColumn('rumah_tangga', 'lat') && Schema::hasColumn('rumah_tangga', 'lng')) {
            $lat = $rumahTangga->lat ?? null;
            $lng = $rumahTangga->lng ?? null;
        }

        // Fallback ke koordinat kepala penduduk
        if ((!$lat || !$lng) && $kepala) {
            $lat = $kepala->lat ?? null;
            $lng = $kepala->lng ?? null;
        }

        return view('admin.rumah-tangga-lokasi', compact('rumahTangga', 'kepala', 'lat', 'lng'));
    }

    // ── LOKASI STORE — Simpan koordinat rumah tangga ─────────────────────────
    public function lokasiStore(Request $request, RumahTangga $rumahTangga) {
        $validated = $request->validate([
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Simpan ke kolom lat/lng rumah_tangga jika kolom ada
        if (Schema::hasColumn('rumah_tangga', 'lat') && Schema::hasColumn('rumah_tangga', 'lng')) {
            $rumahTangga->update([
                'lat' => $validated['latitude']  ?: null,
                'lng' => $validated['longitude'] ?: null,
            ]);
        } else {
            // Fallback: simpan ke penduduk kepala rumah tangga
            $kepala = $rumahTangga->getKepalaRumahTangga();
            if ($kepala && Schema::hasColumn('penduduk', 'lat') && Schema::hasColumn('penduduk', 'lng')) {
                $kepala->update([
                    'lat' => $validated['latitude']  ?: null,
                    'lng' => $validated['longitude'] ?: null,
                ]);
            }
        }

        return back()->with(
            'success',
            "Lokasi rumah tangga {$rumahTangga->no_rumah_tangga} berhasil disimpan."
        );
    }


    // =========================================================================
    // EDIT
    // =========================================================================
    public function edit(RumahTangga $rumahTangga) {
        $kkSaatIni = $rumahTangga->keluarga()
            ->with('kepalaKeluarga:id,nama,nik')
            ->select('id', 'no_kk', 'kepala_keluarga_id', 'alamat', 'rumah_tangga_id')
            ->get();

        $kkTersedia = Keluarga::aktif()
            ->whereNull('rumah_tangga_id')
            ->with('kepalaKeluarga:id,nama,nik')
            ->select('id', 'no_kk', 'kepala_keluarga_id', 'alamat')
            ->orderBy('no_kk')
            ->get();

        $wilayah = Wilayah::orderBy('dusun')->orderBy('rw')->orderBy('rt')->get();

        return view('admin.rumah-tangga-edit', compact(
            'rumahTangga',
            'kkSaatIni',
            'kkTersedia',
            'wilayah',
        ));
    }

    // =========================================================================
    // UPDATE
    // =========================================================================
    public function update(Request $request, RumahTangga $rumahTangga) {
        $validated = $request->validate([
            'no_rumah_tangga'     => 'required|string|max:20|unique:rumah_tangga,no_rumah_tangga,' . $rumahTangga->id,
            'alamat'              => 'nullable|string',
            'wilayah_id'          => 'required|exists:wilayah,id',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'tgl_terdaftar'       => 'required|date',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            'bdt'                 => 'nullable|string|max:50',
            'is_dtks'             => 'nullable|boolean',
            'keluarga_ids'        => 'required|array|min:1',
            'keluarga_ids.*'      => 'exists:keluarga,id',
        ]);

        $payload = [
            'no_rumah_tangga'     => $validated['no_rumah_tangga'],
            'alamat'              => $validated['alamat'],
            'wilayah_id'          => $validated['wilayah_id'],
            'klasifikasi_ekonomi' => $validated['klasifikasi_ekonomi'] ?? null,
            'tgl_terdaftar'       => $validated['tgl_terdaftar'],
            'jenis_bantuan_aktif' => $validated['jenis_bantuan_aktif'] ?? null,
        ];

        if (Schema::hasColumn('rumah_tangga', 'bdt')) {
            $payload['bdt'] = $validated['bdt'] ?? null;
        }
        if (Schema::hasColumn('rumah_tangga', 'is_dtks')) {
            $payload['is_dtks'] = !empty($validated['is_dtks']);
        }

        $rumahTangga->update($payload);

        // Sinkronisasi KK — copot yang dihapus, tambah yang baru
        $kkLamaIds = $rumahTangga->keluarga()->pluck('id')->toArray();

        $kkDicopot = array_diff($kkLamaIds, $validated['keluarga_ids']);
        if (!empty($kkDicopot)) {
            Keluarga::whereIn('id', $kkDicopot)
                ->where('rumah_tangga_id', $rumahTangga->id)
                ->update(['rumah_tangga_id' => null]);
        }

        $kkBaru = array_diff($validated['keluarga_ids'], $kkLamaIds);
        if (!empty($kkBaru)) {
            Keluarga::whereIn('id', $kkBaru)
                ->update(['rumah_tangga_id' => $rumahTangga->id]);
        }

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', "Rumah tangga {$rumahTangga->no_rumah_tangga} berhasil diperbarui.");
    }

    // =========================================================================
    // DESTROY — Hapus satu RT
    // =========================================================================
    public function destroy(RumahTangga $rumahTangga) {
        $jumlahKk = $rumahTangga->keluarga()->count();
        if ($jumlahKk > 0) {
            return back()->with(
                'error',
                "RT {$rumahTangga->no_rumah_tangga} tidak bisa dihapus karena masih memiliki {$jumlahKk} KK."
            );
        }

        $no = $rumahTangga->no_rumah_tangga;
        $rumahTangga->delete();

        return redirect()->route('admin.rumah-tangga.index')
            ->with('success', "Rumah tangga {$no} berhasil dihapus.");
    }

    // =========================================================================
    // BULK DESTROY
    // =========================================================================
    public function bulkDestroy(Request $request) {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $gagal    = 0;
        $berhasil = 0;

        foreach ($ids as $id) {
            $rt = RumahTangga::find($id);
            if (!$rt) {
                continue;
            }
            if ($rt->keluarga()->count() > 0) {
                $gagal++;
                continue;
            }
            $rt->delete();
            $berhasil++;
        }

        $msg = "{$berhasil} rumah tangga berhasil dihapus.";
        if ($gagal > 0) {
            $msg .= " {$gagal} tidak bisa dihapus karena masih memiliki KK.";
        }

        return redirect()->route('admin.rumah-tangga.index')
            ->with($gagal > 0 && $berhasil === 0 ? 'error' : 'success', $msg);
    }

    public function confirmDestroy(RumahTangga $rumahTangga) {
        $rumahTangga->load('keluarga:id,no_kk,rumah_tangga_id');
        return view('admin.rumah-tangga-delete', compact('rumahTangga'));
    }

    // =========================================================================
    // IMPOR
    // =========================================================================
    public function impor(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        // TODO: implementasi dengan maatwebsite/excel

        return back()->with('success', 'Impor data rumah tangga berhasil.');
    }

    public function templateImpor() {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Template');

        foreach (['A' => 'no_rumah_tangga', 'B' => 'nik'] as $col => $header) {
            $sheet->setCellValue("{$col}1", $header);
        }
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D1FAE5']],
        ]);
        $sheet->setCellValue('A2', 'RT001');
        $sheet->setCellValue('B2', '3302xxxxxxxxxx');
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = new XlsxWriter($spreadsheet);
        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            'format-impor-rtm.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    // =========================================================================
    // CETAK — Kartu Rumah Tangga
    // =========================================================================
    public function cetak(Request $request) {
        $rumahTangga = RumahTangga::with([
            'wilayah',
            'keluarga' => fn($q) => $q->orderBy('no_kk')->with([
                'kepalaKeluarga:id,nama,nik',
                'anggota' => fn($q2) => $q2
                    ->orderBy('kk_level')
                    ->orderBy('nama')
                    ->with([
                        'agama:id,nama',
                        'pekerjaan:id,nama',
                        'statusKawin:id,nama',
                        'pendidikanKk:id,nama',
                        'golonganDarah:id,nama',
                        'warganegara:id,nama',
                    ]),
            ]),
        ])
            ->when(
                $request->filled('search'),
                fn($q) => $q->where(
                    fn($q2) => $q2
                        ->where('no_rumah_tangga', 'like', "%{$request->search}%")
                        ->orWhereHas(
                            'keluarga.kepalaKeluarga',
                            fn($q3) => $q3->where('nama', 'like', "%{$request->search}%")
                        )
                )
            )
            ->when(
                $request->filled('dusun'),
                fn($q) => $q->whereHas('wilayah', fn($q2) => $q2->where('dusun', $request->dusun))
            )
            ->orderBy('no_rumah_tangga')
            ->get();

        return view('admin.rumah-tangga-cetak', compact('rumahTangga'));
    }

    public function unduh(Request $request) {
        return $this->exportExcel($request);
    }

    public function exportExcel(Request $request) {
        $data = $this->buildExportQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Data Rumah Tangga');

        $headers = [
            'No',
            'No. Rumah Tangga',
            'Kepala RT',
            'NIK Kepala',
            'Jml KK',
            'Jml Anggota',
            'Alamat',
            'Dusun',
            'RW',
            'RT',
            'DTKS',
            'BDT',
            'Klasifikasi',
            'Tgl Terdaftar',
        ];

        $col = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col++ . '1', $h);
        }
        $lastCol = chr(ord('A') + count($headers) - 1);

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->freezePane('A2');

        foreach ($data as $i => $row) {
            $r      = $i + 2;
            $c      = 'A';
            $kepala = $row->getKepalaRumahTangga();
            $sheet->setCellValue($c++ . $r, $i + 1);
            $sheet->setCellValue($c++ . $r, $row->no_rumah_tangga);
            $sheet->setCellValue($c++ . $r, $kepala?->nama ?? '-');
            $sheet->setCellValue($c++ . $r, $kepala?->nik ?? '-');
            $sheet->setCellValue($c++ . $r, $row->getTotalKk());
            $sheet->setCellValue($c++ . $r, $row->getTotalAnggota());
            $sheet->setCellValue($c++ . $r, $row->alamat ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->dusun ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->rw ?? '-');
            $sheet->setCellValue($c++ . $r, $row->wilayah?->rt ?? '-');
            $sheet->setCellValue($c++ . $r, $row->is_dtks ? 'Ya' : 'Tidak');
            $sheet->setCellValue($c++ . $r, $row->bdt ?? '-');
            $sheet->setCellValue($c++ . $r, $row->klasifikasi_ekonomi ?? '-');
            $sheet->setCellValue($c++ . $r, $row->tgl_terdaftar?->format('d/m/Y') ?? '-');
        }

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new XlsxWriter($spreadsheet);
        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            'data_rumah_tangga_' . now()->format('Ymd_His') . '.xlsx',
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    public function exportPdf(Request $request) {
        $rumahTangga = $this->buildExportQuery($request)->get();
        $stats       = ['total' => $rumahTangga->count()];

        $pdf = Pdf::loadView('admin.rumah-tangga-export-pdf', compact('rumahTangga', 'stats'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data_rumah_tangga_' . now()->format('Ymd_His') . '.pdf');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================
    private function buildExportQuery(Request $request) {
        return RumahTangga::with(['wilayah', 'keluarga.kepalaKeluarga:id,nama,nik'])
            ->when(
                $request->filled('search'),
                fn($q) =>
                $q->where(
                    fn($q2) =>
                    $q2->where('no_rumah_tangga', 'like', "%{$request->search}%")
                        ->orWhereHas(
                            'keluarga.kepalaKeluarga',
                            fn($q3) =>
                            $q3->where('nama', 'like', "%{$request->search}%")
                        )
                )
            )
            ->when(
                $request->filled('klasifikasi_ekonomi'),
                fn($q) =>
                $q->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi)
            )
            ->when(
                $request->filled('dusun'),
                fn($q) =>
                $q->whereHas('wilayah', fn($q2) => $q2->where('dusun', $request->dusun))
            )
            ->orderBy('no_rumah_tangga');
    }
}
