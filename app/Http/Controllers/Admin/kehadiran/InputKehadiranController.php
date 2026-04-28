<?php

namespace App\Http\Controllers\Admin\Kehadiran;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use App\Models\JamKerja;
use App\Models\KehadiranPegawai;
use App\Models\PerangkatDesa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InputKehadiranController extends Controller {
    // =========================================================================
    // HALAMAN UTAMA - Tab Manual & Import Fingerprint
    // =========================================================================

    public function index(Request $request) {
        $tanggal   = $request->input('tanggal', now()->toDateString());
        $jamKerjas = JamKerja::aktif()->orderBy('nama_shift')->get();
        $jamKerjaId = $request->input('jam_kerja_id', $jamKerjas->first()?->id);
        $jamKerja  = $jamKerjas->find($jamKerjaId);

        // Ambil semua perangkat aktif beserta jabatan
        $perangkats = PerangkatDesa::with('jabatan')
            ->where('status', 1)
            ->orderBy('nama')
            ->get();

        // Ambil data kehadiran yang sudah ada untuk tanggal ini
        $kehadiranAda = KehadiranPegawai::where('tanggal', $tanggal)
            ->get()
            ->keyBy('perangkat_id');

        // Cek apakah hari ini hari libur
        $hariLibur = HariLibur::where('is_aktif', true)
            ->where('tanggal', '<=', $tanggal)
            ->where(function ($q) use ($tanggal) {
                $q->whereNull('tanggal_selesai')
                    ->orWhere('tanggal_selesai', '>=', $tanggal);
            })
            ->where('tanggal', $tanggal)
            ->first();

        $isWeekend = Carbon::parse($tanggal)->isWeekend();

        return view('admin.kehadiran.input.index', compact(
            'tanggal',
            'jamKerjas',
            'jamKerja',
            'jamKerjaId',
            'perangkats',
            'kehadiranAda',
            'hariLibur',
            'isWeekend'
        ));
    }

    // =========================================================================
    // SIMPAN INPUT MANUAL (Bulk)
    // =========================================================================

    public function simpanManual(Request $request) {
        $request->validate([
            'tanggal'       => 'required|date',
            'jam_kerja_id'  => 'nullable|exists:kehadiran_jam_kerja,id',
            'kehadiran'     => 'required|array',
            'kehadiran.*.perangkat_id' => 'required|exists:perangkat_desa,id',
            'kehadiran.*.status'       => 'required|in:hadir,terlambat,izin,sakit,alpa,dinas_luar,cuti,libur',
        ]);

        $tanggal    = $request->input('tanggal');
        $jamKerjaId = $request->input('jam_kerja_id');
        $jamKerja   = $jamKerjaId ? JamKerja::find($jamKerjaId) : null;
        $userId     = Auth::id();

        DB::transaction(function () use ($request, $tanggal, $jamKerja, $jamKerjaId, $userId) {
            foreach ($request->input('kehadiran') as $row) {
                $perangkatId = $row['perangkat_id'];
                $status      = $row['status'];
                $jamMasuk    = !empty($row['jam_masuk']) ? $row['jam_masuk'] : null;
                $jamKeluar   = !empty($row['jam_keluar']) ? $row['jam_keluar'] : null;
                $keterangan  = $row['keterangan'] ?? null;

                // Hitung keterlambatan otomatis
                $menitTerlambat = 0;
                if ($jamMasuk && $jamKerja) {
                    $batasMasuk = Carbon::parse($jamKerja->jam_masuk)
                        ->addMinutes($jamKerja->toleransi_menit);
                    $aktual = Carbon::parse($jamMasuk);
                    $menitTerlambat = max(0, $batasMasuk->diffInMinutes($aktual, false));

                    // Auto set status terlambat jika menit > 0
                    if ($menitTerlambat > 0 && $status === 'hadir') {
                        $status = 'terlambat';
                    }
                }

                KehadiranPegawai::updateOrCreate(
                    ['perangkat_id' => $perangkatId, 'tanggal' => $tanggal],
                    [
                        'jam_kerja_id'     => $jamKerjaId,
                        'jam_masuk_aktual' => $jamMasuk,
                        'jam_keluar_aktual' => $jamKeluar,
                        'status'           => $status,
                        'menit_terlambat'  => $menitTerlambat,
                        'metode_masuk'     => 'manual',
                        'metode_keluar'    => $jamKeluar ? 'manual' : null,
                        'keterangan'       => $keterangan,
                        'dicatat_oleh'     => $userId,
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.kehadiran.input.index', ['tanggal' => $tanggal, 'jam_kerja_id' => $jamKerjaId])
            ->with('success', 'Data kehadiran tanggal ' . Carbon::parse($tanggal)->translatedFormat('d F Y') . ' berhasil disimpan.');
    }

    // =========================================================================
    // PREVIEW IMPORT FINGERPRINT (AJAX)
    // =========================================================================

    public function previewFingerprint(Request $request) {
        $request->validate([
            'file' => 'required|file|max:5120',
            'jam_kerja_id'  => 'nullable|exists:kehadiran_jam_kerja,id',
        ]);

        try {
            $file     = $request->file('file');
            $jamKerja = $request->input('jam_kerja_id')
                ? JamKerja::find($request->input('jam_kerja_id'))
                : null;

            $rows    = $this->parseFingerprintFile($file);
            $preview = $this->processRows($rows, $jamKerja);

            return response()->json([
                'success'   => true,
                'total'     => count($preview),
                'matched'   => collect($preview)->where('status_mapping', 'found')->count(),
                'unmatched' => collect($preview)->where('status_mapping', 'not_found')->count(),
                'data'      => $preview,
            ]);
        } catch (\Throwable $e) {
            Log::error('[Fingerprint Preview] ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file: ' . $e->getMessage(),
            ], 422);
        }
    }

    // =========================================================================
    // SIMPAN IMPORT FINGERPRINT
    // =========================================================================

    public function simpanFingerprint(Request $request) {
        $request->validate([
            'file'         => 'required|file|mimes:csv,txt,xls,xlsx|max:5120',
            'jam_kerja_id' => 'nullable|exists:kehadiran_jam_kerja,id',
            'tanggal'      => 'required|date',
        ]);

        try {
            $file     = $request->file('file');
            $jamKerja = $request->input('jam_kerja_id')
                ? JamKerja::find($request->input('jam_kerja_id'))
                : null;
            $userId   = Auth::id();

            $rows    = $this->parseFingerprintFile($file);
            $preview = $this->processRows($rows, $jamKerja);

            $imported  = 0;
            $skipped   = 0;
            $gagal     = 0;

            DB::transaction(function () use ($preview, $request, $jamKerja, $userId, &$imported, &$skipped, &$gagal) {
                foreach ($preview as $row) {
                    if ($row['status_mapping'] !== 'found') {
                        $gagal++;
                        continue;
                    }

                    $tanggal     = $row['tanggal'];
                    $perangkatId = $row['perangkat_id'];
                    $status      = $row['status_hasil'];
                    $jamMasuk    = $row['jam_masuk'] ?? null;
                    $jamKeluar   = $row['jam_keluar'] ?? null;

                    // Skip jika sudah ada data (tidak timpa)
                    $sudahAda = KehadiranPegawai::where('perangkat_id', $perangkatId)
                        ->where('tanggal', $tanggal)
                        ->exists();
                    if ($sudahAda) {
                        $skipped++;
                        continue;
                    }

                    $menitTerlambat = 0;
                    if ($jamMasuk && $jamKerja) {
                        $batas = Carbon::parse($jamKerja->jam_masuk)->addMinutes($jamKerja->toleransi_menit);
                        $menitTerlambat = max(0, $batas->diffInMinutes(Carbon::parse($jamMasuk), false));
                    }

                    KehadiranPegawai::create([
                        'perangkat_id'     => $perangkatId,
                        'tanggal'          => $tanggal,
                        'jam_kerja_id'     => $jamKerja?->id,
                        'jam_masuk_aktual' => $jamMasuk,
                        'jam_keluar_aktual' => $jamKeluar,
                        'status'           => $status,
                        'menit_terlambat'  => $menitTerlambat,
                        'metode_masuk'     => 'fingerprint',
                        'metode_keluar'    => $jamKeluar ? 'fingerprint' : null,
                        'dicatat_oleh'     => $userId,
                    ]);
                    $imported++;
                }
            });

            $msg = "{$imported} data berhasil diimport.";
            if ($skipped) $msg .= " {$skipped} dilewati (sudah ada).";
            if ($gagal)   $msg .= " {$gagal} tidak dikenali (NIK tidak cocok).";

            return redirect()
                ->route('admin.kehadiran.input.index', ['tanggal' => $request->input('tanggal')])
                ->with('success', $msg);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // HAPUS DATA SATU HARI (untuk reset/koreksi)
    // =========================================================================

    public function hapusKehadiran(Request $request) {
        $request->validate([
            'perangkat_id' => 'required|exists:perangkat_desa,id',
            'tanggal'      => 'required|date',
        ]);

        KehadiranPegawai::where('perangkat_id', $request->perangkat_id)
            ->where('tanggal', $request->tanggal)
            ->delete();

        return response()->json(['success' => true]);
    }

    // =========================================================================
    // PRIVATE: Parser File Fingerprint
    // =========================================================================

    /**
     * Parse file fingerprint — support format:
     * 1. CSV/TXT ZKTeco  : "NIK,Nama,Tanggal,Jam,Status"
     * 2. CSV/TXT Fingerspot: "ID\tTanggal\tJam\tStatus"
     * 3. CSV umum        : auto-detect kolom
     */
    private function parseFingerprintFile($file): array {
        $ext      = strtolower($file->getClientOriginalExtension());
        $content  = file_get_contents($file->getRealPath());
        $encoding = mb_detect_encoding($content, ['UTF-8', 'UTF-16', 'Windows-1252', 'ISO-8859-1'], true);

        if ($encoding && $encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
        }

        // Deteksi delimiter: tab atau koma
        $lines     = explode("\n", trim($content));
        $firstLine = $lines[0] ?? '';
        $delimiter = str_contains($firstLine, "\t") ? "\t" : ',';

        $rows    = [];
        $headers = [];

        foreach ($lines as $i => $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $cols = str_getcsv($line, $delimiter);

            // Baris pertama — deteksi header atau langsung data
            if ($i === 0) {
                $lower = array_map('strtolower', array_map('trim', $cols));
                // Jika ada kata kunci header
                $hasHeader = count(array_intersect($lower, ['nik', 'id', 'nama', 'name', 'tanggal', 'date', 'jam', 'time', 'check', 'no'])) > 0;
                if ($hasHeader) {
                    $headers = $lower;
                    continue;
                }
            }

            $rows[] = $this->mapRow($cols, $headers);
        }

        return array_filter($rows, fn($r) => !empty($r['raw_id']) || !empty($r['tanggal']));
    }

    /**
     * Map satu baris CSV ke array standar
     */
    private function mapRow(array $cols, array $headers): array {
        if (!empty($headers)) {
            $mapped = array_combine($headers, array_pad($cols, count($headers), ''));
        } else {
            // Tanpa header: kolom 0=NIK/ID, 1=Tanggal, 2=Jam Masuk, 3=Jam Keluar (opsional)
            $mapped = [
                'nik'    => $cols[0] ?? '',
                'tanggal' => $cols[1] ?? '',
                'jam'    => $cols[2] ?? '',
                'jam2'   => $cols[3] ?? '',
            ];
        }

        // Normalisasi field nama yang beragam
        $id      = $mapped['nik'] ?? $mapped['id'] ?? $mapped['no'] ?? $mapped['user_id'] ?? $cols[0] ?? '';
        $tgl     = $mapped['tanggal'] ?? $mapped['date'] ?? $mapped['tgl'] ?? '';
        $jamIn   = $mapped['jam_masuk'] ?? $mapped['time_in'] ?? $mapped['check_in'] ?? $mapped['jam'] ?? $mapped['time'] ?? '';
        $jamOut  = $mapped['jam_keluar'] ?? $mapped['time_out'] ?? $mapped['check_out'] ?? $mapped['jam2'] ?? '';
        $stat    = $mapped['status'] ?? $mapped['state'] ?? '';
        $nama    = $mapped['nama'] ?? $mapped['name'] ?? '';

        // Normalisasi tanggal ke Y-m-d
        $tanggalNormal = $this->normalizeTanggal($tgl);
        $jamInNormal   = $this->normalizeJam($jamIn);
        $jamOutNormal  = $this->normalizeJam($jamOut);

        return [
            'raw_id'     => trim($id),
            'nama_file'  => trim($nama),
            'tanggal'    => $tanggalNormal,
            'jam_masuk'  => $jamInNormal,
            'jam_keluar' => $jamOutNormal,
            'raw_status' => trim($stat),
        ];
    }

    /**
     * Proses rows: mapping NIK → perangkat, hitung status
     */
    private function processRows(array $rows, ?JamKerja $jamKerja): array {
        // Load semua perangkat aktif untuk mapping NIK
        $perangkats = PerangkatDesa::where('status', 1)
            ->whereNotNull('nik')
            ->get()
            ->keyBy(fn($p) => trim($p->nik));

        $preview = [];
        foreach ($rows as $row) {
            $nik       = $row['raw_id'];
            $perangkat = $perangkats[$nik] ?? null;

            // Hitung status dari jam masuk + jam kerja
            $statusHasil    = 'hadir';
            $menitTerlambat = 0;

            if ($perangkat && $row['jam_masuk'] && $jamKerja) {
                $batas = Carbon::parse($jamKerja->jam_masuk)
                    ->addMinutes($jamKerja->toleransi_menit);
                $aktual = Carbon::parse($row['jam_masuk']);
                $menitTerlambat = max(0, $batas->diffInMinutes($aktual, false));
                $statusHasil = $menitTerlambat > 0 ? 'terlambat' : 'hadir';
            }

            // Cek status dari file jika ada
            if (!empty($row['raw_status'])) {
                $statusMap = [
                    'in' => 'hadir',
                    'out' => 'hadir',
                    'check in' => 'hadir',
                    'leave' => 'izin',
                    'sick' => 'sakit',
                    'absent' => 'alpa',
                    'hadir' => 'hadir',
                    'terlambat' => 'terlambat',
                    'izin' => 'izin',
                    'sakit' => 'sakit',
                    'alpa' => 'alpa',
                ];
                $statusLower = strtolower($row['raw_status']);
                $statusHasil = $statusMap[$statusLower] ?? $statusHasil;
            }

            $preview[] = [
                'nik'            => $nik,
                'nama_file'      => $row['nama_file'],
                'nama_perangkat' => $perangkat?->nama ?? '-',
                'jabatan'        => $perangkat?->jabatan?->nama ?? '-',
                'perangkat_id'   => $perangkat?->id,
                'tanggal'        => $row['tanggal'],
                'jam_masuk'      => $row['jam_masuk'],
                'jam_keluar'     => $row['jam_keluar'],
                'status_hasil'   => $statusHasil,
                'menit_terlambat' => $menitTerlambat,
                'status_mapping' => $perangkat ? 'found' : 'not_found',
            ];
        }

        return $preview;
    }

    private function normalizeTanggal(string $tgl): ?string {
        if (empty(trim($tgl))) return null;
        $tgl = trim($tgl);

        // Coba berbagai format
        $formats = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d', 'd.m.Y', 'Ymd'];
        foreach ($formats as $fmt) {
            try {
                $dt = Carbon::createFromFormat($fmt, $tgl);
                if ($dt) return $dt->format('Y-m-d');
            } catch (\Throwable $e) {
            }
        }

        // Fallback
        try {
            return Carbon::parse($tgl)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function normalizeJam(string $jam): ?string {
        if (empty(trim($jam))) return null;
        $jam = trim($jam);

        $formats = ['H:i:s', 'H:i', 'h:i A', 'h:i:s A', 'Hi', 'G:i'];
        foreach ($formats as $fmt) {
            try {
                $dt = Carbon::createFromFormat($fmt, $jam);
                if ($dt) return $dt->format('H:i');
            } catch (\Throwable $e) {
            }
        }
        return null;
    }
}