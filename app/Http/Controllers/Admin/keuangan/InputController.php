<?php

namespace App\Http\Controllers\Admin\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\AkunRekening;
use App\Models\AnggaranTahunan;
use App\Models\TransaksiKas;
use App\Models\KasDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use ZipArchive;
use Illuminate\Support\Facades\DB;

class InputController extends Controller {
    // ================================================================
    // FITUR LAMA: INPUT TRANSAKSI KAS
    // ================================================================
    public function inputData() {
        $recentTransactions = TransaksiKas::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')->limit(10)->get();

        $kasDesa = KasDesa::all();

        return view('admin.keuangan.input-data', compact('recentTransactions', 'kasDesa'));
    }

    public function store(Request $request) {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe'    => 'required|in:masuk,keluar',
            'jumlah'  => 'required|numeric|min:1',
            'kas_id'  => 'required|exists:kas_desa,id',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tipe.required'    => 'Jenis transaksi wajib dipilih',
            'jumlah.required'  => 'Jumlah wajib diisi',
            'jumlah.min'       => 'Jumlah minimal 1',
            'kas_id.required'  => 'Kas desa wajib dipilih',
            'kas_id.exists'    => 'Kas desa tidak valid',
        ]);

        try {
            TransaksiKas::create([
                'tanggal' => $request->tanggal,
                'tipe'    => $request->tipe,
                'jumlah'  => $request->jumlah,
                'kas_id'  => $request->kas_id,
            ]);

            return redirect()->route('admin.keuangan.input-data')
                ->with('success', 'Data transaksi berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->route('admin.keuangan.input-data')
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }


    // ================================================================
    // FITUR BARU: TABEL INPUT ANGGARAN & REALISASI (Template)
    // ================================================================
    public function index(Request $request) {
        $tahunDipilih = $request->get('tahun', 2026);
        $search       = $request->get('search');
        $filterKode   = $request->get('filter_kode');

        $availableYears = AnggaranTahunan::select('tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($availableYears->isEmpty()) {
            $availableYears = collect([2026]);
        }

        // ── Query KHUSUS DROPDOWN: selalu ambil semua, tanpa filter_kode ──
        $dataUntukDropdown = AnggaranTahunan::with('akunRekening')
            ->where('tahun', $tahunDipilih)
            ->get()
            ->sortBy(fn($item) => $item->akunRekening->kode_rekening)
            ->values();

        // ── Query UNTUK TABEL: terapkan filter_kode & search ──
        $query = AnggaranTahunan::with('akunRekening')->where('tahun', $tahunDipilih);

        if ($filterKode) {
            $query->whereHas('akunRekening', function ($q) use ($filterKode) {
                $q->where('kode_rekening', $filterKode)
                    ->orWhere('kode_rekening', 'like', $filterKode . '.%');
            });
        }

        if ($search) {
            $query->whereHas('akunRekening', function ($q) use ($search) {
                $q->where('uraian', 'like', "%{$search}%")
                    ->orWhere('kode_rekening', 'like', "%{$search}%");
            });
        }

        $data_anggaran = $query->get()
            ->sortBy(fn($item) => $item->akunRekening->kode_rekening)
            ->values();

        // ── Grouping untuk TABEL ──
        $groupedData = [];
        foreach ($data_anggaran as $item) {
            $kode   = $item->akunRekening->kode_rekening;
            $parts  = explode('.', $kode);
            $level1 = $parts[0];

            if (!isset($groupedData[$level1])) {
                $groupedData[$level1] = ['induk' => null, 'kelompok' => []];
            }

            if (count($parts) == 1) {
                $groupedData[$level1]['induk'] = $item;
            } else {
                $level2 = $parts[0] . '.' . $parts[1];
                if (!isset($groupedData[$level1]['kelompok'][$level2])) {
                    $groupedData[$level1]['kelompok'][$level2] = ['header' => null, 'items' => []];
                }
                if (count($parts) == 2) {
                    $groupedData[$level1]['kelompok'][$level2]['header'] = $item;
                } else {
                    $groupedData[$level1]['kelompok'][$level2]['items'][] = $item;
                }
            }
        }

        // ── Grouping KHUSUS DROPDOWN (dari data lengkap) ──
        $groupedDataDropdown = [];
        foreach ($dataUntukDropdown as $item) {
            $kode   = $item->akunRekening->kode_rekening;
            $parts  = explode('.', $kode);
            $level1 = $parts[0];

            if (!isset($groupedDataDropdown[$level1])) {
                $groupedDataDropdown[$level1] = ['induk' => null, 'kelompok' => []];
            }

            if (count($parts) == 1) {
                $groupedDataDropdown[$level1]['induk'] = $item;
            } else {
                $level2 = $parts[0] . '.' . $parts[1];
                if (!isset($groupedDataDropdown[$level1]['kelompok'][$level2])) {
                    $groupedDataDropdown[$level1]['kelompok'][$level2] = ['header' => null, 'items' => []];
                }
                if (count($parts) == 2) {
                    $groupedDataDropdown[$level1]['kelompok'][$level2]['header'] = $item;
                }
            }
        }

        return view('admin.keuangan.input-template', compact(
            'groupedData',
            'groupedDataDropdown', // ← variable baru untuk dropdown
            'availableYears',
            'tahunDipilih',
            'search',
            'data_anggaran'
        ));
    }

    public function tambahTemplate(Request $request) {
        $request->validate(['tahun_baru' => 'required|numeric|digits:4']);
        $tahunBaru = $request->tahun_baru;

        if (AnggaranTahunan::where('tahun', $tahunBaru)->exists()) {
            return redirect()->back()->with('error', "Template untuk tahun {$tahunBaru} sudah tersedia.");
        }

        DB::beginTransaction();
        try {
            $semuaAkun = AkunRekening::all();
            $dataInsert = [];

            foreach ($semuaAkun as $akun) {
                $dataInsert[] = [
                    'akun_rekening_id' => $akun->id,
                    'tahun'            => $tahunBaru,
                    'anggaran'         => 0,
                    'realisasi'        => 0,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ];
            }

            AnggaranTahunan::insert($dataInsert);
            DB::commit();

            return redirect()->route('admin.keuangan.input.index', ['tahun' => $tahunBaru])
                ->with('success', "Template Keuangan Tahun {$tahunBaru} berhasil dibuat.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }

    public function updateNominal(Request $request, $id) {
        $request->validate([
            'anggaran'  => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $anggaranTahunan = AnggaranTahunan::with('akunRekening')->findOrFail($id);

            // Cegah modifikasi manual pada akun induk
            if (!$anggaranTahunan->akunRekening->is_editable) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['message' => 'Akun Induk tidak dapat diubah nominalnya.'], 403);
                }
                return redirect()->back()->with('error', 'Akun Induk tidak dapat diubah nominalnya.');
            }

            // 1. Simpan update untuk akun anak/detail (contoh: 4.1.1)
            $anggaranTahunan->update([
                'anggaran'  => $request->anggaran,
                'realisasi' => $request->realisasi,
            ]);

            // 2. LOGIKA BACKEND: Auto-Sum ke Akun Parent (Contoh: 4.1 dan 4)
            $kode = $anggaranTahunan->akunRekening->kode_rekening;
            $tahun = $anggaranTahunan->tahun;

            $segments = explode('.', $kode);
            $parentKodes = [];
            $currentKode = '';

            // Membuat daftar parent. Jika kode = 4.1.1, maka array = ['4', '4.1']
            for ($i = 0; $i < count($segments) - 1; $i++) {
                $currentKode .= ($currentKode === '' ? '' : '.') . $segments[$i];
                $parentKodes[] = $currentKode;
            }

            foreach ($parentKodes as $pKode) {
                // Cari record AnggaranTahunan untuk akun induk ini pada tahun yang sama
                $parentRecord = AnggaranTahunan::where('tahun', $tahun)
                    ->whereHas('akunRekening', function ($q) use ($pKode) {
                        $q->where('kode_rekening', $pKode);
                    })->first();

                if ($parentRecord) {
                    // Hitung jumlah anggaran & realisasi dari semua anak "detail" nya
                    $sum = AnggaranTahunan::where('tahun', $tahun)
                        ->whereHas('akunRekening', function ($q) use ($pKode) {
                            $q->where('kode_rekening', 'like', $pKode . '.%')
                                ->where('is_editable', 1); // Wajib hanya menjumlahkan akun detail
                        })->selectRaw('SUM(anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
                        ->first();

                    // Update parent record dengan total terbaru
                    $parentRecord->update([
                        'anggaran'  => $sum->total_anggaran ?? 0,
                        'realisasi' => $sum->total_realisasi ?? 0,
                    ]);
                }
            }

            DB::commit();

            // Respons jika request dikirim via fetch JS (AJAX)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nominal berhasil diperbarui.'
                ]);
            }

            // Respons fallback jika request normal
            return redirect()->back()->with('success', 'Nominal anggaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    public function impor(Request $request) {
        $request->validate([
            'berkas_siskeudes' => 'required|file|mimes:zip|max:20480',
        ], [
            'berkas_siskeudes.required' => 'Berkas .zip wajib dipilih.',
            'berkas_siskeudes.mimes'    => 'Format berkas harus .zip.',
            'berkas_siskeudes.max'      => 'Ukuran berkas maksimal 20 MB.',
        ]);

        try {
            $file    = $request->file('berkas_siskeudes');
            $zipPath = $file->store('impor-tmp', 'local');

            // ✅ FIX: Gunakan Storage::disk()->path() bukan storage_path() manual
            $fullPath = \Illuminate\Support\Facades\Storage::disk('local')->path($zipPath);

            // Pastikan file benar-benar ada
            if (!file_exists($fullPath)) {
                return response()->json(['message' => 'File gagal disimpan di server.'], 500);
            }

            $zip = new \ZipArchive();
            $result = $zip->open($fullPath);

            if ($result !== true) {
                return response()->json([
                    'message' => 'Berkas ZIP tidak valid. Kode error: ' . $result
                ], 422);
            }

            $extractDir = \Illuminate\Support\Facades\Storage::disk('local')
                ->path('impor-tmp/extracted_' . time());

            $zip->extractTo($extractDir);
            $zip->close();

            // Cari CSV di dalam folder hasil ekstrak (termasuk subfolder)
            $csvFiles = glob($extractDir . '/*.csv');
            if (empty($csvFiles)) {
                $csvFiles = glob($extractDir . '/**/*.csv'); // cek subfolder
            }

            if (empty($csvFiles)) {
                return response()->json([
                    'message' => 'Tidak ada file .csv ditemukan di dalam berkas .zip.'
                ], 422);
            }

            DB::beginTransaction();

            $totalImport = 0;
            foreach ($csvFiles as $csvFile) {
                $handle = fopen($csvFile, 'r');
                $header = fgetcsv($handle); // baca header

                // Trim BOM & whitespace dari header
                $header = array_map(fn($h) => trim($h, "\xEF\xBB\xBF \t"), $header);

                while (($row = fgetcsv($handle)) !== false) {
                    if (count($row) < count($header)) continue;
                    $data = array_combine($header, $row);

                    $kode  = trim($data['kode_rekening'] ?? '');
                    $tahun = trim($data['tahun'] ?? '');

                    if (!$kode || !$tahun) continue;

                    $akun = AkunRekening::where('kode_rekening', $kode)->first();
                    if (!$akun) continue;

                    AnggaranTahunan::updateOrCreate(
                        ['akun_rekening_id' => $akun->id, 'tahun' => $tahun],
                        [
                            'anggaran'  => (float) ($data['anggaran']  ?? 0),
                            'realisasi' => (float) ($data['realisasi'] ?? 0),
                        ]
                    );
                    $totalImport++;
                }
                fclose($handle);
            }

            DB::commit();

            // Bersihkan file sementara
            \Illuminate\Support\Facades\Storage::disk('local')->deleteDirectory('impor-tmp');

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil mengimpor {$totalImport} rekening."
                ]);
            }

            return redirect()->route('admin.keuangan.input.index')
                ->with('success', "Data Siskeudes berhasil diimpor ({$totalImport} rekening).");
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Storage::disk('local')->deleteDirectory('impor-tmp');

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Gagal impor: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Gagal impor: ' . $e->getMessage());
        }
    }
}
