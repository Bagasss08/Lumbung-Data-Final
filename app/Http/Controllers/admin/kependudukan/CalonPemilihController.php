<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\CalonPemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class CalonPemilihController extends Controller {
    public function index(Request $request) {
        $query = CalonPemilih::query();

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('nik', 'like', '%' . $request->q . '%');
            });
        }
        if ($request->filled('dusun')) {
            $query->where('dusun', $request->dusun);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $calonPemilih = $query->orderBy('nama')->paginate(20)->withQueryString();

        $dusunList = CalonPemilih::select('dusun')->distinct()->whereNotNull('dusun')->pluck('dusun');
        $totalLaki    = CalonPemilih::where('aktif', 1)->where('jenis_kelamin', 1)->count();
        $totalPerempuan = CalonPemilih::where('aktif', 1)->where('jenis_kelamin', 2)->count();

        return view('admin.calon-pemilih.index', compact(
            'calonPemilih',
            'dusunList',
            'totalLaki',
            'totalPerempuan'
        ));
    }

    public function create() {
        return view('admin.calon-pemilih.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nik'               => 'required|string|max:16|unique:tweb_calon_pemilih,nik',
            'nama'              => 'required|string|max:100',
            'tempat_lahir'      => 'nullable|string|max:50',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|in:1,2',
            'alamat'            => 'nullable|string|max:255',
            'rt'                => 'nullable|string|max:4',
            'rw'                => 'nullable|string|max:4',
            'dusun'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'no_kk'             => 'nullable|string|max:16',
            'keterangan'        => 'nullable|string|max:255',
            'aktif'             => 'boolean',
        ]);

        CalonPemilih::create($validated);

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Calon pemilih berhasil ditambahkan.');
    }

    public function show(CalonPemilih $calonPemilih) {
        return view('admin.calon-pemilih.show', compact('calonPemilih'));
    }

    public function edit(CalonPemilih $calonPemilih) {
        return view('admin.calon-pemilih.edit', compact('calonPemilih'));
    }

    public function update(Request $request, CalonPemilih $calonPemilih) {
        $validated = $request->validate([
            'nik'               => 'required|string|max:16|unique:tweb_calon_pemilih,nik,' . $calonPemilih->id,
            'nama'              => 'required|string|max:100',
            'tempat_lahir'      => 'nullable|string|max:50',
            'tanggal_lahir'     => 'nullable|date',
            'jenis_kelamin'     => 'nullable|in:1,2',
            'alamat'            => 'nullable|string|max:255',
            'rt'                => 'nullable|string|max:4',
            'rw'                => 'nullable|string|max:4',
            'dusun'             => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'no_kk'             => 'nullable|string|max:16',
            'keterangan'        => 'nullable|string|max:255',
            'aktif'             => 'boolean',
        ]);

        $calonPemilih->update($validated);

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Data calon pemilih berhasil diperbarui.');
    }

    public function destroy(CalonPemilih $calonPemilih) {
        $calonPemilih->delete();

        return redirect()->route('admin.calon-pemilih.index')
            ->with('success', 'Calon pemilih berhasil dihapus.');
    }

    public function toggleAktif(CalonPemilih $calonPemilih) {
        $calonPemilih->update(['aktif' => !$calonPemilih->aktif]);

        return back()->with('success', 'Status berhasil diubah.');
    }

    // ─── Download Template Import ─────────────────────────────────────────────
    public function downloadTemplate() {
        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Template ──
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Template');
        $headers = ['NIK (16 digit)', 'Nama', 'Jenis Kelamin (L/P)', 'Tempat Lahir', 'Tanggal Lahir (YYYY-MM-DD)', 'Alamat'];

        // Header row
        $col = 'A';
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

        // Baris contoh
        $sheet->setCellValue('A2', '3302011234560001');
        $sheet->setCellValue('B2', 'Budi Santoso');
        $sheet->setCellValue('C2', 'L');
        $sheet->setCellValue('D2', 'Purwokerto');
        $sheet->setCellValue('E2', '1990-05-15');
        $sheet->setCellValue('F2', 'Jl. Merdeka No. 10');
        $sheet->getStyle("A2:F2")->getFont()->setItalic(true)->getColor()->setRGB('6B7280');

        foreach (range('A', 'F') as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // ── Sheet 2: Referensi ──
        $refSheet = $spreadsheet->createSheet()->setTitle('Referensi');
        $refSheet->setCellValue('A1', 'Jenis Kelamin');
        $refSheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
        ]);
        $refSheet->setCellValue('A2', 'L');
        $refSheet->setCellValue('A3', 'P');
        $refSheet->getColumnDimension('A')->setAutoSize(true);

        $writer   = new XlsxWriter($spreadsheet);
        $filename = "template_calon_pemilih.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Import ───────────────────────────────────────────────────────────────
    public function import(Request $request) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xls,xlsx', 'max:10240'],
            'mode' => ['required', 'in:skip,overwrite'],
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);
        $highestRow  = $sheet->getHighestRow();

        // Deteksi kolom dari header baris 1
        $header = $rows[1] ?? [];
        $colMap = [];
        foreach ($header as $colLetter => $label) {
            $label = strtolower(trim((string) $label));
            if (str_contains($label, 'nik')) $colMap['nik'] = $colLetter;
            if (str_contains($label, 'nama')) $colMap['nama'] = $colLetter;
            if (str_contains($label, 'jenis') && str_contains($label, 'kelamin')) $colMap['jenis_kelamin'] = $colLetter;
            if (str_contains($label, 'tempat') && str_contains($label, 'lahir')) $colMap['tempat_lahir'] = $colLetter;
            if (str_contains($label, 'tanggal') && str_contains($label, 'lahir')) $colMap['tanggal_lahir'] = $colLetter;
            if (str_contains($label, 'alamat')) $colMap['alamat'] = $colLetter;
        }

        if (!isset($colMap['nik'])) {
            return back()->with('error', 'Kolom NIK tidak ditemukan di file. Pastikan menggunakan template yang disediakan.');
        }

        $imported     = 0;
        $skipped      = 0;
        $importErrors = [];

        DB::beginTransaction();
        try {
            for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
                $raw = $rows[$rowNum] ?? [];
                $nik = trim((string) ($raw[$colMap['nik']] ?? ''));
                $nama = trim((string) ($raw[$colMap['nama']] ?? ''));
                $jk = trim((string) ($raw[$colMap['jenis_kelamin']] ?? ''));
                $tempatLahir = trim((string) ($raw[$colMap['tempat_lahir']] ?? ''));
                $tanggalLahir = trim((string) ($raw[$colMap['tanggal_lahir']] ?? ''));
                $alamat = trim((string) ($raw[$colMap['alamat']] ?? ''));

                // Skip baris kosong
                if (empty($nik) && empty($nama)) continue;

                // Validasi format 16 digit
                if (!preg_match('/^\d{16}$/', $nik)) {
                    $importErrors[] = "Baris {$rowNum}: Format NIK tidak valid — \"{$nik}\" (harus 16 digit)";
                    continue;
                }

                // Normalize jenis kelamin
                $jkUpper = strtoupper($jk);
                if (in_array($jkUpper, ['L', 'LAKI-LAKI', 'LAKI LAKI'])) {
                    $jkValue = 1;
                } elseif (in_array($jkUpper, ['P', 'PEREMPUAN'])) {
                    $jkValue = 2;
                } else {
                    $importErrors[] = "Baris {$rowNum}: Jenis kelamin tidak valid — \"{$jk}\" (harus L atau P)";
                    continue;
                }

                // Flexible date parsing
                $tanggalLahirValue = null;
                if (!empty($tanggalLahir)) {
                    try {
                        // Try YYYY-MM-DD first
                        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalLahir)) {
                            $tanggalLahirValue = Carbon::createFromFormat('Y-m-d', $tanggalLahir)->format('Y-m-d');
                        } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $tanggalLahir)) {
                            // Try DD/MM/YYYY
                            $tanggalLahirValue = Carbon::createFromFormat('d/m/Y', $tanggalLahir)->format('Y-m-d');
                        } else {
                            $tanggalLahirValue = Carbon::parse($tanggalLahir)->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        $importErrors[] = "Baris {$rowNum}: Format tanggal lahir tidak valid — \"{$tanggalLahir}\"";
                        continue;
                    }
                }

                $existing = CalonPemilih::where('nik', $nik)->first();

                $data = [
                    'nik'          => $nik,
                    'nama'         => $nama,
                    'jenis_kelamin' => $jkValue,
                    'tempat_lahir' => $tempatLahir ?: null,
                    'tanggal_lahir' => $tanggalLahirValue,
                    'alamat'       => $alamat ?: null,
                    'aktif'        => true,
                ];

                if ($existing) {
                    if ($request->mode === 'overwrite') {
                        $existing->update($data);
                        $imported++;
                    } else {
                        $skipped++;
                    }
                } else {
                    CalonPemilih::create($data);
                    $imported++;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }

        $msg = "{$imported} data berhasil diimport";
        if ($skipped)      $msg .= ", {$skipped} duplikat dilewati";
        if ($importErrors) $msg .= ', ' . count($importErrors) . ' baris gagal';

        return back()
            ->with('success', $msg)
            ->with('import_errors', $importErrors);
    }

    // ─── Export Excel ─────────────────────────────────────────────────────────
    public function exportExcel(Request $request) {
        $data = $this->buildExportQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Data Calon Pemilih');

        // Header
        $headers = ['No', 'NIK', 'Nama', 'JK', 'Tempat Lahir', 'Tgl Lahir', 'Alamat', 'Status Aktif'];
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
            $sheet->setCellValue($colIdx++ . $rowNum, $row->nik ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->nama ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->jenis_kelamin == 1 ? 'Laki-laki' : ($row->jenis_kelamin == 2 ? 'Perempuan' : '-'));
            $sheet->setCellValue($colIdx++ . $rowNum, $row->tempat_lahir ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, optional($row->tanggal_lahir)->format('d/m/Y') ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->alamat ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->aktif ? 'Aktif' : 'Nonaktif');

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
        }, 'data_calon_pemilih_' . now()->format('Ymd_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────
    public function exportPdf(Request $request) {
        $calonPemilih = $this->buildExportQuery($request)->get();
        $stats        = [
            'total'     => $calonPemilih->count(),
            'laki_laki' => $calonPemilih->where('jenis_kelamin', 1)->count(),
            'perempuan' => $calonPemilih->where('jenis_kelamin', 2)->count(),
            'aktif'     => $calonPemilih->where('aktif', true)->count(),
        ];

        $pdf = Pdf::loadView('admin.calon-pemilih-export-pdf', compact('calonPemilih', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        return $pdf->download('data_calon_pemilih_' . now()->format('Ymd_His') . '.pdf');
    }

    // ─── Helper: query yang dipakai index & export ────────────────────────────
    private function buildExportQuery(Request $request) {
        return CalonPemilih::query()
            ->when(
                $request->filled('q'),
                fn($q) => $q->where(function ($query) use ($request) {
                    $query->where('nama', 'like', '%' . $request->q . '%')
                        ->orWhere('nik', 'like', '%' . $request->q . '%');
                })
            )
            ->when(
                $request->filled('dusun'),
                fn($q) => $q->where('dusun', $request->dusun)
            )
            ->when(
                $request->filled('jenis_kelamin'),
                fn($q) => $q->where('jenis_kelamin', $request->jenis_kelamin)
            )
            ->when(
                $request->filled('aktif'),
                fn($q) => $q->where('aktif', $request->aktif)
            )
            ->orderBy('nama');
    }
}
