<?php

namespace App\Http\Controllers\Admin\Kehadiran;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HariLiburController extends Controller {
    public function index(Request $request) {
        $tahun     = $request->integer('tahun', now()->year);
        $hariLiburs = HariLibur::tahun($tahun)->orderBy('tanggal')->get();
        $tahunList  = range(now()->year - 2, now()->year + 2);

        return view('admin.kehadiran.hari-libur.index', compact('hariLiburs', 'tahun', 'tahunList'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'            => 'required|string|max:150',
            'tanggal'         => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal',
            'jenis'           => 'required|in:nasional,lokal',
            'is_aktif'        => 'boolean',
            'keterangan'      => 'nullable|string|max:500',
        ]);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);
        HariLibur::create($validated);

        return redirect()
            ->route('admin.kehadiran.hari-libur.index', ['tahun' => date('Y', strtotime($validated['tanggal']))])
            ->with('success', 'Hari libur berhasil ditambahkan.');
    }

    public function update(Request $request, HariLibur $hariLibur) {
        $validated = $request->validate([
            'nama'            => 'required|string|max:150',
            'tanggal'         => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal',
            'jenis'           => 'required|in:nasional,lokal',
            'is_aktif'        => 'boolean',
            'keterangan'      => 'nullable|string|max:500',
        ]);
        $validated['is_aktif'] = $request->boolean('is_aktif', true);
        $hariLibur->update($validated);

        return redirect()
            ->route('admin.kehadiran.hari-libur.index', ['tahun' => $hariLibur->tanggal->year])
            ->with('success', 'Hari libur berhasil diperbarui.');
    }

    public function destroy(HariLibur $hariLibur) {
        $tahun = $hariLibur->tanggal->year;
        $hariLibur->delete();

        return redirect()
            ->route('admin.kehadiran.hari-libur.index', ['tahun' => $tahun])
            ->with('success', 'Hari libur berhasil dihapus.');
    }

    public function importNasional(Request $request) {
        $tahun   = $request->integer('tahun', now()->year);
        $apiData = $this->fetchFromApi($tahun);

        $imported = 0;
        $skipped  = 0;

        foreach ($apiData as $item) {
            $exists = HariLibur::where('tanggal', $item['tanggal'])->where('jenis', 'nasional')->exists();
            if ($exists) {
                $skipped++;
                continue;
            }

            HariLibur::create([
                'nama'       => $item['nama'],
                'tanggal'    => $item['tanggal'],
                'jenis'      => 'nasional',
                'is_aktif'   => true,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
            $imported++;
        }

        $msg = "{$imported} hari libur nasional berhasil diimpor.";
        if ($skipped > 0) $msg .= " {$skipped} data dilewati (sudah ada).";

        // Tandai apakah data berasal dari fallback statis
        $source = Cache::get("hari_libur_source_{$tahun}", 'API');
        if ($source === 'static') {
            $msg .= ' (menggunakan data bawaan — koneksi API tidak tersedia)';
        }

        return redirect()
            ->route('admin.kehadiran.hari-libur.index', ['tahun' => $tahun])
            ->with('success', $msg);
    }

    /**
     * AJAX endpoint untuk preview data sebelum import
     */
    public function previewNasional(Request $request) {
        $tahun   = $request->integer('tahun', now()->year);
        $apiData = $this->fetchFromApi($tahun);
        $source  = Cache::get("hari_libur_source_{$tahun}", 'API');

        $tanggalAda = HariLibur::where('jenis', 'nasional')
            ->whereYear('tanggal', $tahun)
            ->pluck('tanggal')
            ->map(fn($t) => \Carbon\Carbon::parse($t)->format('Y-m-d'))
            ->toArray();

        $preview = collect($apiData)->map(fn($item) => [
            'tanggal'    => $item['tanggal'],
            'nama'       => $item['nama'],
            'keterangan' => $item['keterangan'] ?? null,
            'sudah_ada'  => in_array($item['tanggal'], $tanggalAda),
        ])->values();

        return response()->json([
            'success'   => true,
            'tahun'     => $tahun,
            'source'    => $source,
            'total'     => $preview->count(),
            'baru'      => $preview->where('sudah_ada', false)->count(),
            'sudah_ada' => $preview->where('sudah_ada', true)->count(),
            'data'      => $preview,
        ]);
    }

    public function clearCache(Request $request) {
        $tahun = $request->integer('tahun', now()->year);
        Cache::forget("hari_libur_nasional_{$tahun}");
        Cache::forget("hari_libur_source_{$tahun}");

        return redirect()
            ->route('admin.kehadiran.hari-libur.index', ['tahun' => $tahun])
            ->with('success', "Cache hari libur {$tahun} dihapus. Data akan diambil ulang dari API.");
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Fetch dari API dengan 3 fallback + data statis jika semua offline.
     * Hasil di-cache 24 jam.
     */
    private function fetchFromApi(int $tahun): array {
        $cacheKey = "hari_libur_nasional_{$tahun}";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $sources = [
            [
                'url'    => "https://libur.workers.dev/api?year={$tahun}",
                'parser' => 'parseLiburWorkers',
                'label'  => 'libur.workers.dev',
            ],
            [
                'url'    => "https://dayoffapi.vercel.app/api?year={$tahun}",
                'parser' => 'parseDayoffApi',
                'label'  => 'dayoffapi.vercel.app',
            ],
            [
                'url'    => "https://api-harilibur.vercel.app/api?year={$tahun}",
                'parser' => 'parseHariLiburApi',
                'label'  => 'api-harilibur.vercel.app',
            ],
        ];

        foreach ($sources as $source) {
            try {
                $response = Http::timeout(8)
                    ->withHeaders(['Accept' => 'application/json', 'User-Agent' => 'LumbungData/1.0'])
                    ->get($source['url']);

                if ($response->successful()) {
                    $parsed = $this->{$source['parser']}($response->json() ?? [], $tahun);
                    if (count($parsed) >= 5) { // minimal 5 data = valid
                        Cache::put($cacheKey, $parsed, now()->addHours(24));
                        Cache::put("hari_libur_source_{$tahun}", $source['label'], now()->addHours(24));
                        Log::info("[HariLibur] Berhasil dari {$source['label']}: " . count($parsed) . " data");
                        return $parsed;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("[HariLibur] Gagal dari {$source['label']}: " . $e->getMessage());
            }
        }

        // Semua API gagal → gunakan data statis bawaan
        Log::warning("[HariLibur] Semua API gagal untuk {$tahun}, menggunakan data statis.");
        $static = $this->getDataStatis($tahun);
        Cache::put($cacheKey, $static, now()->addHours(6)); // cache lebih pendek untuk data statis
        Cache::put("hari_libur_source_{$tahun}", 'static', now()->addHours(6));
        return $static;
    }

    /**
     * Parser: libur.workers.dev
     * Format: [{"date": "2026-01-01", "name": "Tahun Baru ..."}]
     */
    private function parseLiburWorkers(array $data, int $tahun): array {
        $result = [];
        foreach ($data as $item) {
            if (!isset($item['date'], $item['name'])) continue;
            if (!str_starts_with($item['date'], (string) $tahun)) continue;
            $result[] = [
                'tanggal'    => $item['date'],
                'nama'       => $item['name'],
                'keterangan' => $item['description'] ?? null,
            ];
        }
        return $result;
    }

    /**
     * Parser: dayoffapi.vercel.app
     * Format: [{"tanggal": "01 Januari 2026", "keterangan": "..."}]
     */
    private function parseDayoffApi(array $data, int $tahun): array {
        $bulanMap = [
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12',
        ];
        $result = [];
        foreach ($data as $item) {
            if (!isset($item['tanggal'])) continue;
            $parts = explode(' ', trim($item['tanggal']));
            if (count($parts) < 3) continue;
            $bulan = $bulanMap[$parts[1]] ?? null;
            if (!$bulan || (int)$parts[2] !== $tahun) continue;
            $result[] = [
                'tanggal'    => "{$parts[2]}-{$bulan}-" . str_pad($parts[0], 2, '0', STR_PAD_LEFT),
                'nama'       => $item['keterangan'] ?? $item['name'] ?? 'Hari Libur Nasional',
                'keterangan' => null,
            ];
        }
        return $result;
    }

    /**
     * Parser: api-harilibur.vercel.app
     * Format: [{"holiday_date": "2026-01-01", "holiday_name": "...", "is_national_holiday": true}]
     */
    private function parseHariLiburApi(array $data, int $tahun): array {
        $result = [];
        foreach ($data as $item) {
            if (!isset($item['holiday_date'], $item['holiday_name'])) continue;
            if (!str_starts_with($item['holiday_date'], (string) $tahun)) continue;
            if (isset($item['is_national_holiday']) && !$item['is_national_holiday']) continue;
            $result[] = [
                'tanggal'    => $item['holiday_date'],
                'nama'       => $item['holiday_name'],
                'keterangan' => null,
            ];
        }
        return $result;
    }

    /**
     * Data statis fallback — diperbarui setiap tahun.
     * Mencakup hari libur tetap + perkiraan hari libur Islam (bisa meleset 1-2 hari).
     */
    private function getDataStatis(int $tahun): array {
        $data = [
            // Hari libur TETAP (tidak berubah setiap tahun)
            ['tanggal' => "{$tahun}-01-01", 'nama' => 'Tahun Baru Masehi'],
            ['tanggal' => "{$tahun}-05-01", 'nama' => 'Hari Buruh Internasional'],
            ['tanggal' => "{$tahun}-06-01", 'nama' => 'Hari Lahir Pancasila'],
            ['tanggal' => "{$tahun}-08-17", 'nama' => 'Hari Kemerdekaan Republik Indonesia'],
            ['tanggal' => "{$tahun}-12-25", 'nama' => 'Hari Raya Natal'],
            ['tanggal' => "{$tahun}-12-26", 'nama' => 'Cuti Bersama Natal'],
        ];

        // Hari libur bergerak — diisi per tahun yang diketahui
        $bergerak = [
            2024 => [
                ['tanggal' => '2024-02-08', 'nama' => 'Isra Miraj Nabi Muhammad SAW'],
                ['tanggal' => '2024-02-10', 'nama' => 'Tahun Baru Imlek 2575'],
                ['tanggal' => '2024-03-11', 'nama' => 'Hari Suci Nyepi Tahun Baru Saka 1946'],
                ['tanggal' => '2024-03-29', 'nama' => 'Wafat Isa Al Masih'],
                ['tanggal' => '2024-04-10', 'nama' => 'Hari Raya Idul Fitri 1445 H'],
                ['tanggal' => '2024-04-11', 'nama' => 'Hari Raya Idul Fitri 1445 H'],
                ['tanggal' => '2024-05-09', 'nama' => 'Kenaikan Isa Al Masih'],
                ['tanggal' => '2024-05-23', 'nama' => 'Hari Raya Waisak 2568 BE'],
                ['tanggal' => '2024-06-17', 'nama' => 'Hari Raya Idul Adha 1445 H'],
                ['tanggal' => '2024-07-07', 'nama' => 'Tahun Baru Islam 1446 H'],
                ['tanggal' => '2024-09-16', 'nama' => 'Maulid Nabi Muhammad SAW'],
            ],
            2025 => [
                ['tanggal' => '2025-01-27', 'nama' => 'Tahun Baru Imlek 2576'],
                ['tanggal' => '2025-01-28', 'nama' => 'Cuti Bersama Tahun Baru Imlek'],
                ['tanggal' => '2025-03-28', 'nama' => 'Hari Suci Nyepi Tahun Baru Saka 1947'],
                ['tanggal' => '2025-03-29', 'nama' => 'Cuti Bersama Nyepi'],
                ['tanggal' => '2025-03-30', 'nama' => 'Idul Fitri 1446 H'],
                ['tanggal' => '2025-03-31', 'nama' => 'Idul Fitri 1446 H'],
                ['tanggal' => '2025-04-01', 'nama' => 'Cuti Bersama Idul Fitri'],
                ['tanggal' => '2025-04-02', 'nama' => 'Cuti Bersama Idul Fitri'],
                ['tanggal' => '2025-04-03', 'nama' => 'Cuti Bersama Idul Fitri'],
                ['tanggal' => '2025-04-04', 'nama' => 'Cuti Bersama Idul Fitri'],
                ['tanggal' => '2025-04-18', 'nama' => 'Wafat Isa Al Masih'],
                ['tanggal' => '2025-05-12', 'nama' => 'Hari Raya Waisak 2569 BE'],
                ['tanggal' => '2025-05-13', 'nama' => 'Cuti Bersama Waisak'],
                ['tanggal' => '2025-05-29', 'nama' => 'Kenaikan Isa Al Masih'],
                ['tanggal' => '2025-06-06', 'nama' => 'Idul Adha 1446 H'],
                ['tanggal' => '2025-06-27', 'nama' => 'Tahun Baru Islam 1447 H'],
                ['tanggal' => '2025-08-25', 'nama' => 'Isra Miraj Nabi Muhammad SAW'],
                ['tanggal' => '2025-09-05', 'nama' => 'Maulid Nabi Muhammad SAW'],
            ],
            2026 => [
                ['tanggal' => '2026-01-16', 'nama' => 'Tahun Baru Islam 1448 H'],
                ['tanggal' => '2026-02-17', 'nama' => 'Tahun Baru Imlek 2577'],
                ['tanggal' => '2026-03-03', 'nama' => 'Isra Miraj Nabi Muhammad SAW'],
                ['tanggal' => '2026-03-19', 'nama' => 'Hari Suci Nyepi Tahun Baru Saka 1948'],
                ['tanggal' => '2026-04-02', 'nama' => 'Wafat Isa Al Masih'],
                ['tanggal' => '2026-03-20', 'nama' => 'Hari Raya Idul Fitri 1447 H'],
                ['tanggal' => '2026-03-21', 'nama' => 'Hari Raya Idul Fitri 1447 H'],
                ['tanggal' => '2026-05-14', 'nama' => 'Kenaikan Isa Al Masih'],
                ['tanggal' => '2026-05-27', 'nama' => 'Maulid Nabi Muhammad SAW'],
                ['tanggal' => '2026-05-31', 'nama' => 'Hari Raya Waisak 2570 BE'],
                ['tanggal' => '2026-05-27', 'nama' => 'Hari Raya Idul Adha 1447 H'],
            ],
        ];

        $result = $data;
        if (isset($bergerak[$tahun])) {
            $result = array_merge($result, $bergerak[$tahun]);
        }

        // Urutkan berdasarkan tanggal
        usort($result, fn($a, $b) => strcmp($a['tanggal'], $b['tanggal']));

        // Tambahkan keterangan statis
        foreach ($result as &$item) {
            $item['keterangan'] = $item['keterangan'] ?? null;
        }

        return $result;
    }
}
