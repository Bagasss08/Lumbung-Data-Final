<?php

namespace App\Http\Controllers\Admin\kependudukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Keluarga;
use App\Models\RumahTangga;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PendudukController extends Controller {
    // ─── Kolom untuk import / export ─────────────────────────────────────────
    private array $exportColumns = [
        'nik'             => 'NIK',
        'nama'            => 'Nama Lengkap',
        'jenis_kelamin'   => 'Jenis Kelamin (L/P)',
        'tempat_lahir'    => 'Tempat Lahir',
        'tanggal_lahir'   => 'Tanggal Lahir (YYYY-MM-DD)',
        'golongan_darah'  => 'Golongan Darah',
        'agama'           => 'Agama',
        'pendidikan'      => 'Pendidikan',
        'pekerjaan'       => 'Pekerjaan',
        'status_kawin'    => 'Status Kawin',
        'kewarganegaraan' => 'Kewarganegaraan',
        'no_telp'         => 'No. Telepon',
        'email'           => 'Email',
        'alamat'          => 'Alamat',
    ];

    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request) {
        $query = Penduduk::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'Semua') {
            $query->where('jenis_kelamin', $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P');
        }

        if ($request->filled('agama') && $request->agama !== 'Semua Agama') {
            $query->where('agama', $request->agama);
        }

        $penduduk       = $query->paginate(10)->appends($request->query());
        $total_penduduk = Penduduk::count();
        $laki_laki      = Penduduk::where('jenis_kelamin', 'L')->count();
        $perempuan      = Penduduk::where('jenis_kelamin', 'P')->count();
        $keluarga       = Keluarga::count();
        $wilayah        = Wilayah::all();

        return view('admin.penduduk', compact(
            'penduduk',
            'total_penduduk',
            'laki_laki',
            'perempuan',
            'keluarga',
            'wilayah'
        ));
    }

    // ─── Create / Store ───────────────────────────────────────────────────────
    public function create() {
        $keluarga    = Keluarga::all();
        $rumahTangga = RumahTangga::all();
        $wilayah     = Wilayah::all();

        return view('admin.penduduk-create', compact('keluarga', 'rumahTangga', 'wilayah'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik'                   => 'required|string|max:16|unique:penduduk,nik',
            'nama'                  => 'required|string|max:255',
            'wilayah_id'            => 'nullable|exists:wilayah,id',
            'jenis_kelamin'         => 'required|in:L,P',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'golongan_darah'        => 'nullable|string|max:3',
            'agama'                 => 'required|string|max:255',
            'pendidikan'            => 'nullable|string|max:255',
            'pekerjaan'             => 'required|in:bekerja,tidak bekerja',
            'status_kawin'          => 'required|string|max:255',
            'status_hidup'          => 'nullable|in:hidup,meninggal',
            'kewarganegaraan'       => 'nullable|string|max:255',
            'no_telp'               => 'nullable|string|max:255',
            'email'                 => 'nullable|email|max:255',
            'alamat'                => 'nullable|string',
            'keluarga_id'           => 'nullable|exists:keluarga,id',
            'hubungan_keluarga'     => 'nullable|string|max:255',
            'rumah_tangga_id'       => 'nullable|exists:rumah_tangga,id',
            'hubungan_rumah_tangga' => 'nullable|string|max:255',
        ]);

        $penduduk = Penduduk::create($validated);

        if ($request->filled('keluarga_id') && $request->filled('hubungan_keluarga')) {
            $penduduk->keluargas()->attach($request->keluarga_id, [
                'hubungan_keluarga' => $request->hubungan_keluarga,
            ]);
        }

        if ($request->filled('rumah_tangga_id') && $request->filled('hubungan_rumah_tangga')) {
            $penduduk->rumahTanggas()->attach($request->rumah_tangga_id, [
                'hubungan_rumah_tangga' => $request->hubungan_rumah_tangga,
            ]);
        }

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil ditambahkan.');
    }

    // ─── Show / Edit / Update ─────────────────────────────────────────────────
    public function show(Penduduk $penduduk) {
        return view('admin.penduduk-show', compact('penduduk'));
    }

    public function edit(Penduduk $penduduk) {
        $keluarga         = Keluarga::all();
        $rumahTangga      = RumahTangga::all();
        $wilayah          = Wilayah::all();
        $currentKeluarga  = $penduduk->keluargas()->withPivot('hubungan_keluarga')->first();
        $currentRumahTangga = $penduduk->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();

        return view('admin.penduduk-edit', compact(
            'penduduk',
            'keluarga',
            'rumahTangga',
            'wilayah',
            'currentKeluarga',
            'currentRumahTangga'
        ));
    }

    public function update(Request $request, Penduduk $penduduk) {
        $validated = $request->validate([
            'nik'                   => 'required|string|max:16|unique:penduduk,nik,' . $penduduk->id,
            'nama'                  => 'required|string|max:255',
            'wilayah_id'            => 'nullable|exists:wilayah,id',
            'jenis_kelamin'         => 'required|in:L,P',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'golongan_darah'        => 'nullable|string|max:3',
            'agama'                 => 'required|string|max:255',
            'pendidikan'            => 'nullable|string|max:255',
            'pekerjaan'             => 'required|in:bekerja,tidak bekerja',
            'status_kawin'          => 'required|string|max:255',
            'status_hidup'          => 'nullable|in:hidup,meninggal',
            'kewarganegaraan'       => 'nullable|string|max:255',
            'no_telp'               => 'nullable|string|max:255',
            'email'                 => 'nullable|email|max:255',
            'alamat'                => 'nullable|string',
            'keluarga_id'           => 'nullable|exists:keluarga,id',
            'hubungan_keluarga'     => 'nullable|string|max:255',
            'rumah_tangga_id'       => 'nullable|exists:rumah_tangga,id',
            'hubungan_rumah_tangga' => 'nullable|string|max:255',
        ]);

        $penduduk->update($validated);

        if ($request->filled('keluarga_id') && $request->filled('hubungan_keluarga')) {
            $penduduk->keluargas()->sync([
                $request->keluarga_id => ['hubungan_keluarga' => $request->hubungan_keluarga],
            ]);
        } else {
            $penduduk->keluargas()->detach();
        }

        if ($request->filled('rumah_tangga_id') && $request->filled('hubungan_rumah_tangga')) {
            $penduduk->rumahTanggas()->sync([
                $request->rumah_tangga_id => ['hubungan_rumah_tangga' => $request->hubungan_rumah_tangga],
            ]);
        } else {
            $penduduk->rumahTanggas()->detach();
        }

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil diperbarui.');
    }

    // ─── Delete ───────────────────────────────────────────────────────────────
    public function confirmDestroy(Penduduk $penduduk) {
        return view('admin.penduduk-delete', compact('penduduk'));
    }

    public function destroy(Penduduk $penduduk) {
        $penduduk->keluargas()->detach();
        $penduduk->rumahTanggas()->detach();
        $penduduk->delete();

        return redirect()->route('admin.penduduk')->with('success', 'Penduduk berhasil dihapus.');
    }

    // ─── Download Template Import ─────────────────────────────────────────────
    public function downloadTemplate() {
        $spreadsheet = new Spreadsheet();

        // Sheet 1: Template
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Template');
        $col   = 'A';
        foreach ($this->exportColumns as $field => $label) {
            $sheet->setCellValue($col . '1', $label);
            $col++;
        }
        $lastCol = chr(ord('A') + count($this->exportColumns) - 1);
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Baris contoh
        $example = [
            '3302011234560001',
            'Budi Santoso',
            'L',
            'Purwokerto',
            '1990-05-15',
            'A',
            'Islam',
            'SMA',
            'bekerja',
            'Menikah',
            'WNI',
            '081234567890',
            'budi@email.com',
            'Jl. Merdeka No. 10 RT 01/02',
        ];
        $col = 'A';
        foreach ($example as $val) {
            $sheet->setCellValue($col . '2', $val);
            $col++;
        }
        $sheet->getStyle("A2:{$lastCol}2")->getFont()->setItalic(true)->getColor()->setRGB('6B7280');
        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // Sheet 2: Referensi nilai valid
        $refSheet = $spreadsheet->createSheet()->setTitle('Referensi');
        $refs = [
            'Jenis Kelamin'   => ['L', 'P'],
            'Agama'           => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'],
            'Golongan Darah'  => ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            'Status Kawin'    => ['Belum Kawin', 'Menikah', 'Cerai Hidup', 'Cerai Mati'],
            'Pekerjaan'       => ['bekerja', 'tidak bekerja'],
            'Pendidikan'      => ['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'],
            'Kewarganegaraan' => ['WNI', 'WNA'],
        ];
        $startCol = 'A';
        foreach ($refs as $kategori => $vals) {
            $refSheet->setCellValue($startCol . '1', $kategori);
            $refSheet->getStyle($startCol . '1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            ]);
            foreach ($vals as $i => $v) {
                $refSheet->setCellValue($startCol . ($i + 2), $v);
            }
            $refSheet->getColumnDimension($startCol)->setAutoSize(true);
            $startCol++;
        }

        $writer = new XlsxWriter($spreadsheet);
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'template_import_penduduk.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Import ───────────────────────────────────────────────────────────────
    public function import(Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xls,xlsx', 'max:10240'],
            'mode' => ['required', 'in:skip,overwrite'],
        ]);

        $spreadsheet  = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet        = $spreadsheet->getActiveSheet();
        $rows         = $sheet->toArray(null, true, true, true);
        $highestRow   = $sheet->getHighestRow();
        $highestCol   = $sheet->getHighestColumn();

        // Baris 1 = header, buat pemetaan kolom huruf → nama field
        $rawHeader = $rows[1] ?? [];
        // Label → field name
        $labelToField = array_flip(array_map('strtolower', $this->exportColumns));
        // Map huruf kolom → field DB
        $colMap = [];
        foreach ($rawHeader as $colLetter => $label) {
            $field = $labelToField[strtolower(trim((string) $label))] ?? null;
            if ($field) {
                $colMap[$colLetter] = $field;
            }
        }

        $imported     = 0;
        $skipped      = 0;
        $importErrors = [];

        DB::beginTransaction();
        try {
            for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
                $rawRow = $rows[$rowNum] ?? [];
                $data   = [];

                foreach ($colMap as $letter => $field) {
                    $data[$field] = trim((string) ($rawRow[$letter] ?? ''));
                }

                // Skip baris kosong
                if (empty($data['nik']) && empty($data['nama'])) {
                    continue;
                }

                // Validasi NIK 16 digit
                if (!preg_match('/^\d{16}$/', $data['nik'] ?? '')) {
                    $importErrors[] = "Baris {$rowNum}: NIK tidak valid — \"{$data['nik']}\"";
                    continue;
                }

                // Parse tanggal lahir (fleksibel)
                if (!empty($data['tanggal_lahir'])) {
                    try {
                        $data['tanggal_lahir'] = Carbon::parse($data['tanggal_lahir'])->format('Y-m-d');
                    } catch (\Exception) {
                        $importErrors[] = "Baris {$rowNum}: Format tanggal lahir tidak valid";
                        continue;
                    }
                }

                // Normalize jenis kelamin
                $jk = strtoupper($data['jenis_kelamin'] ?? '');
                $data['jenis_kelamin'] = in_array($jk, ['L', 'P']) ? $jk : 'L';

                // Hanya ambil kolom yang ada di fillable model
                $fillable = (new Penduduk)->getFillable();
                $data     = array_intersect_key($data, array_flip($fillable));

                $existing = Penduduk::where('nik', $data['nik'])->first();

                if ($existing) {
                    if ($request->mode === 'overwrite') {
                        $existing->update($data);
                        $imported++;
                    } else {
                        $skipped++;
                    }
                } else {
                    Penduduk::create($data);
                    $imported++;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }

        $msg = "{$imported} data berhasil diimport";
        if ($skipped)           $msg .= ", {$skipped} duplikat dilewati";
        if ($importErrors)      $msg .= ', ' . count($importErrors) . ' baris gagal (lihat detail di bawah)';

        return back()
            ->with('success', $msg)
            ->with('import_errors', $importErrors);
    }

    // ─── Export Excel ─────────────────────────────────────────────────────────
    public function exportExcel(Request $request) {
        $data = $this->buildExportQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Data Penduduk');

        // Header
        $headers = array_merge(['No'], array_values($this->exportColumns));
        $col     = 'A';
        foreach ($headers as $h) {
            $sheet->setCellValue($col . '1', $h);
            $col++;
        }
        $lastCol = chr(ord('A') + count($headers) - 1);
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->freezePane('A2');

        // Data rows
        foreach ($data as $i => $row) {
            $rowNum = $i + 2;
            $colIdx = 'A';
            $sheet->setCellValue($colIdx++ . $rowNum, $i + 1);
            foreach (array_keys($this->exportColumns) as $field) {
                $val = $field === 'tanggal_lahir'
                    ? optional($row->$field)->format('d/m/Y')
                    : ($row->$field ?? '-');
                $sheet->setCellValue($colIdx++ . $rowNum, $val);
            }
            // Alternating row color
            if ($i % 2 === 1) {
                $sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
        }

        if ($data->count() > 0) {
            $sheet->getStyle("A1:{$lastCol}" . ($data->count() + 1))->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }
        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer = new XlsxWriter($spreadsheet);
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, 'data_penduduk_' . now()->format('Ymd_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────
    public function exportPdf(Request $request) {
        $penduduk = $this->buildExportQuery($request)->get();
        $stats    = [
            'total'     => $penduduk->count(),
            'laki_laki' => $penduduk->where('jenis_kelamin', 'L')->count(),
            'perempuan' => $penduduk->where('jenis_kelamin', 'P')->count(),
        ];

        $pdf = Pdf::loadView('admin.penduduk-export-pdf', compact('penduduk', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        return $pdf->download('data_penduduk_' . now()->format('Ymd_His') . '.pdf');
    }

    // ─── Helper: query yang dipakai index & export ────────────────────────────
    private function buildExportQuery(Request $request) {
        return Penduduk::query()
            ->when(
                $request->filled('search'),
                fn($q) =>
                $q->where('nama', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%")
            )
            ->when(
                $request->filled('jenis_kelamin') && $request->jenis_kelamin !== 'Semua',
                fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P')
            )
            ->when(
                $request->filled('agama') && $request->agama !== 'Semua Agama',
                fn($q) => $q->where('agama', $request->agama)
            )
            ->orderBy('nama');
    }
}
