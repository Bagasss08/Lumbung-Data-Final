<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\DataSuplemen;
use App\Models\SuplemenTerdata;
use App\Models\Penduduk;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DataSuplemenController extends Controller {
    // ─── Master Suplemen ─────────────────────────────────────────────────────

    public function index(Request $request) {
        $query = DataSuplemen::withCount('terdata');

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('sasaran')) {
            $query->where('sasaran', $request->sasaran);
        }
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $suplemen = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.suplemen.index', compact('suplemen'));
    }

    public function create() {
        return view('admin.suplemen.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'sasaran'     => 'required|in:1,2',
            'keterangan'  => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'tgl_mulai'   => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('suplemen', 'public');
        }

        DataSuplemen::create($validated);

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil ditambahkan.');
    }

    public function show(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()->with('penduduk', 'keluarga')->paginate(20);
        return view('admin.suplemen.show', compact('suplemen', 'terdata'));
    }

    public function edit(DataSuplemen $suplemen) {
        return view('admin.suplemen.edit', compact('suplemen'));
    }

    public function update(Request $request, DataSuplemen $suplemen) {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'sasaran'     => 'required|in:1,2',
            'keterangan'  => 'nullable|string',
            'logo'        => 'nullable|image|max:2048',
            'tgl_mulai'   => 'nullable|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        $validated['aktif'] = $request->has('aktif') ? 1 : 0;

        if ($request->hasFile('logo')) {
            if ($suplemen->logo) {
                Storage::disk('public')->delete($suplemen->logo);
            }
            $validated['logo'] = $request->file('logo')->store('suplemen', 'public');
        }

        $suplemen->update($validated);

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil diperbarui.');
    }

    public function destroy(DataSuplemen $suplemen) {
        if ($suplemen->logo) {
            Storage::disk('public')->delete($suplemen->logo);
        }
        $suplemen->delete();

        return redirect()->route('admin.suplemen.index')
            ->with('success', 'Data suplemen berhasil dihapus.');
    }

    // ─── Anggota Terdata ─────────────────────────────────────────────────────

    public function terdataIndex(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()
            ->with(['penduduk', 'keluarga'])
            ->paginate(20);

        return view('admin.suplemen.terdata.index', compact('suplemen', 'terdata'));
    }

    public function terdataCreate(DataSuplemen $suplemen) {
        if ($suplemen->sasaran == '1') {
            $sudahTerdata = $suplemen->terdata()->pluck('id_pend');
            $penduduk     = Penduduk::whereNotIn('nik', $sudahTerdata)
                ->where('status_hidup', 'hidup')
                ->select('nik', 'nama')
                ->orderBy('nama')
                ->get();
        } else {
            $sudahTerdata = $suplemen->terdata()->pluck('no_kk');
            $penduduk     = collect();
        }

        return view('admin.suplemen.terdata.create', compact('suplemen', 'penduduk'));
    }

    public function terdataStore(Request $request, DataSuplemen $suplemen) {
        if ($suplemen->sasaran == '1') {
            $request->validate([
                'id_pend'    => 'required|string|max:16|exists:penduduk,nik',
                'keterangan' => 'nullable|string|max:255',
            ]);

            $sudahAda = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                ->where('id_pend', $request->id_pend)
                ->exists();

            if ($sudahAda) {
                return back()->with('error', 'Penduduk ini sudah terdaftar di suplemen ini.');
            }

            SuplemenTerdata::create([
                'id_suplemen' => $suplemen->id,
                'id_pend'     => $request->id_pend,
                'keterangan'  => $request->keterangan,
            ]);
        } else {
            $request->validate([
                'no_kk'      => 'required|string|max:16',
                'keterangan' => 'nullable|string|max:255',
            ]);

            $sudahAda = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                ->where('no_kk', $request->no_kk)
                ->exists();

            if ($sudahAda) {
                return back()->with('error', 'No. KK ini sudah terdaftar di suplemen ini.');
            }

            SuplemenTerdata::create([
                'id_suplemen' => $suplemen->id,
                'no_kk'       => $request->no_kk,
                'keterangan'  => $request->keterangan,
            ]);
        }

        return redirect()->route('admin.suplemen.terdata.index', $suplemen)
            ->with('success', 'Anggota terdata berhasil ditambahkan.');
    }

    public function terdataDestroy(DataSuplemen $suplemen, SuplemenTerdata $terdata) {
        $terdata->delete();

        return redirect()->route('admin.suplemen.terdata.index', $suplemen)
            ->with('success', 'Anggota terdata berhasil dihapus.');
    }

    // ─── Download Template Import ─────────────────────────────────────────────

    public function downloadTemplate(DataSuplemen $suplemen) {
        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Template ──
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Template');

        if ($suplemen->sasaran == '1') {
            // Perorangan — kolom NIK + Keterangan
            $headers = ['NIK (16 digit)', 'Keterangan'];
        } else {
            // Keluarga — kolom No. KK + Keterangan
            $headers = ['No. KK (16 digit)', 'Keterangan'];
        }

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
        if ($suplemen->sasaran == '1') {
            $sheet->setCellValue('A2', '3302011234560001');
            $sheet->setCellValue('B2', 'Keterangan opsional');
        } else {
            $sheet->setCellValue('A2', '3302011234560001');
            $sheet->setCellValue('B2', 'Keterangan opsional');
        }
        $sheet->getStyle("A2:B2")->getFont()->setItalic(true)->getColor()->setRGB('6B7280');

        foreach (['A', 'B'] as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // ── Sheet 2: Referensi (daftar penduduk/KK yang bisa dimasukkan) ──
        $refSheet = $spreadsheet->createSheet()->setTitle('Referensi');

        if ($suplemen->sasaran == '1') {
            // Daftar penduduk hidup yang belum terdata
            $sudahTerdata = $suplemen->terdata()->pluck('id_pend');
            $pendudukList = Penduduk::where('status_hidup', 'hidup')
                ->whereNotIn('nik', $sudahTerdata)
                ->select('nik', 'nama', 'jenis_kelamin')
                ->orderBy('nama')
                ->get();

            $refSheet->setCellValue('A1', 'NIK');
            $refSheet->setCellValue('B1', 'Nama');
            $refSheet->setCellValue('C1', 'JK');
            $refSheet->getStyle('A1:C1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            ]);
            foreach ($pendudukList as $i => $p) {
                $refSheet->setCellValue('A' . ($i + 2), $p->nik);
                $refSheet->setCellValue('B' . ($i + 2), $p->nama);
                $refSheet->setCellValue('C' . ($i + 2), $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
            }
            foreach (['A', 'B', 'C'] as $c) {
                $refSheet->getColumnDimension($c)->setAutoSize(true);
            }
        } else {
            // Daftar No. KK
            $sudahTerdata = $suplemen->terdata()->pluck('no_kk');
            $kkList       = Keluarga::whereNotIn('no_kk', $sudahTerdata)
                ->select('no_kk', 'kepala_keluarga')
                ->orderBy('no_kk')
                ->get();

            $refSheet->setCellValue('A1', 'No. KK');
            $refSheet->setCellValue('B1', 'Kepala Keluarga');
            $refSheet->getStyle('A1:B1')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
            ]);
            foreach ($kkList as $i => $kk) {
                $refSheet->setCellValue('A' . ($i + 2), $kk->no_kk);
                $refSheet->setCellValue('B' . ($i + 2), $kk->kepala_keluarga ?? '-');
            }
            foreach (['A', 'B'] as $c) {
                $refSheet->getColumnDimension($c)->setAutoSize(true);
            }
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($suplemen->nama);
        $filename = "template_terdata_{$slug}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Import ───────────────────────────────────────────────────────────────

    public function import(Request $request, DataSuplemen $suplemen) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xls,xlsx', 'max:10240'],
            'mode' => ['required', 'in:skip,overwrite'],
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);
        $highestRow  = $sheet->getHighestRow();

        // Deteksi kolom dari header baris 1
        $header      = $rows[1] ?? [];
        $nikCol      = null;
        $ketCol      = null;

        foreach ($header as $colLetter => $label) {
            $label = strtolower(trim((string) $label));
            if (str_contains($label, 'nik') || str_contains($label, 'no. kk') || str_contains($label, 'no kk')) {
                $nikCol = $colLetter;
            }
            if (str_contains($label, 'keterangan')) {
                $ketCol = $colLetter;
            }
        }

        if (!$nikCol) {
            return back()->with('error', 'Kolom NIK / No. KK tidak ditemukan di file. Pastikan menggunakan template yang disediakan.');
        }

        $imported     = 0;
        $skipped      = 0;
        $importErrors = [];

        DB::beginTransaction();
        try {
            for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
                $raw = $rows[$rowNum] ?? [];
                $id  = trim((string) ($raw[$nikCol] ?? ''));
                $ket = trim((string) ($raw[$ketCol] ?? ''));

                // Skip baris kosong
                if (empty($id)) continue;

                // Validasi format 16 digit
                if (!preg_match('/^\d{16}$/', $id)) {
                    $importErrors[] = "Baris {$rowNum}: Format tidak valid — \"{$id}\" (harus 16 digit)";
                    continue;
                }

                if ($suplemen->sasaran == '1') {
                    // ── Perorangan: cek NIK ada di tabel penduduk ──
                    $penduduk = Penduduk::where('nik', $id)->where('status_hidup', 'hidup')->first();
                    if (!$penduduk) {
                        $importErrors[] = "Baris {$rowNum}: NIK {$id} tidak ditemukan atau sudah meninggal";
                        continue;
                    }

                    $existing = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                        ->where('id_pend', $id)
                        ->first();

                    if ($existing) {
                        if ($request->mode === 'overwrite') {
                            $existing->update(['keterangan' => $ket ?: null]);
                            $imported++;
                        } else {
                            $skipped++;
                        }
                    } else {
                        SuplemenTerdata::create([
                            'id_suplemen' => $suplemen->id,
                            'id_pend'     => $id,
                            'keterangan'  => $ket ?: null,
                        ]);
                        $imported++;
                    }
                } else {
                    // ── Keluarga: cek No. KK ada di tabel keluarga ──
                    $kk = Keluarga::where('no_kk', $id)->first();
                    if (!$kk) {
                        $importErrors[] = "Baris {$rowNum}: No. KK {$id} tidak ditemukan";
                        continue;
                    }

                    $existing = SuplemenTerdata::where('id_suplemen', $suplemen->id)
                        ->where('no_kk', $id)
                        ->first();

                    if ($existing) {
                        if ($request->mode === 'overwrite') {
                            $existing->update(['keterangan' => $ket ?: null]);
                            $imported++;
                        } else {
                            $skipped++;
                        }
                    } else {
                        SuplemenTerdata::create([
                            'id_suplemen' => $suplemen->id,
                            'no_kk'       => $id,
                            'keterangan'  => $ket ?: null,
                        ]);
                        $imported++;
                    }
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

    public function exportExcel(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()->with('penduduk', 'keluarga')->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Terdata');

        // Header
        if ($suplemen->sasaran == '1') {
            $headers = ['No', 'NIK', 'Nama', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'Keterangan'];
        } else {
            $headers = ['No', 'No. KK', 'Kepala Keluarga', 'Alamat', 'Keterangan'];
        }

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
        $sheet->freezePane('A2');

        // Data rows
        foreach ($terdata as $i => $t) {
            $rowNum = $i + 2;
            if ($suplemen->sasaran == '1') {
                $p = $t->penduduk;
                $sheet->setCellValue('A' . $rowNum, $i + 1);
                $sheet->setCellValue('B' . $rowNum, $t->id_pend ?? '-');
                $sheet->setCellValue('C' . $rowNum, $p?->nama ?? '-');
                $sheet->setCellValue('D' . $rowNum, $p?->jenis_kelamin === 'L' ? 'Laki-laki' : ($p?->jenis_kelamin === 'P' ? 'Perempuan' : '-'));
                $sheet->setCellValue('E' . $rowNum, $p?->tempat_lahir ?? '-');
                $sheet->setCellValue('F' . $rowNum, optional($p?->tanggal_lahir)->format('d/m/Y') ?? '-');
                $sheet->setCellValue('G' . $rowNum, $p?->alamat ?? '-');
                $sheet->setCellValue('H' . $rowNum, $t->keterangan ?? '-');
            } else {
                $kk = $t->keluarga;
                $sheet->setCellValue('A' . $rowNum, $i + 1);
                $sheet->setCellValue('B' . $rowNum, $t->no_kk ?? '-');
                $sheet->setCellValue('C' . $rowNum, $kk?->kepala_keluarga ?? '-');
                $sheet->setCellValue('D' . $rowNum, $kk?->alamat ?? '-');
                $sheet->setCellValue('E' . $rowNum, $t->keterangan ?? '-');
            }

            // Alternating row
            if ($i % 2 === 1) {
                $sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
        }

        if ($terdata->count() > 0) {
            $sheet->getStyle("A1:{$lastCol}" . ($terdata->count() + 1))->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($suplemen->nama);
        $filename = "terdata_{$slug}_" . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────

    public function exportPdf(DataSuplemen $suplemen) {
        $terdata = $suplemen->terdata()->with('penduduk', 'keluarga')->get();

        $stats = [
            'total'     => $terdata->count(),
            'laki_laki' => $terdata->filter(fn($t) => $t->penduduk?->jenis_kelamin === 'L')->count(),
            'perempuan' => $terdata->filter(fn($t) => $t->penduduk?->jenis_kelamin === 'P')->count(),
        ];

        $pdf = Pdf::loadView('admin.suplemen.export-pdf', compact('suplemen', 'terdata', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        $slug     = \Illuminate\Support\Str::slug($suplemen->nama);
        $filename = "terdata_{$slug}_" . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }
}
