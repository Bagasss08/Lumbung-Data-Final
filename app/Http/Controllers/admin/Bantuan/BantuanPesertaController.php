<?php

namespace App\Http\Controllers\Admin\Bantuan;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Program;
use App\Models\ProgramPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;

class BantuanPesertaController extends Controller {

    public function create(Program $bantuan) {
        $sudahPeserta = $bantuan->peserta()->pluck('penduduk_id');

        $penduduk = Penduduk::where('status_hidup', 'hidup')
            ->whereNotIn('id', $sudahPeserta)
            ->get()
            ->map(fn($p) => [
                'id'               => $p->id,
                'nik'              => $p->nik,
                'nama'             => $p->nama,
                'tempat_lahir'     => $p->tempat_lahir,
                'tanggal_lahir'    => optional($p->tanggal_lahir)->format('d M Y'),
                'tanggal_lahir_iso' => optional($p->tanggal_lahir)->format('Y-m-d'),
                'jenis_kelamin'    => $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                // FIX: cast ke int supaya tidak desimal
                'umur'             => $p->tanggal_lahir ? (int) $p->tanggal_lahir->diffInYears(now()) : null,
                'pendidikan'       => $p->pendidikan,
                // FIX: paksa jadi string — agama bisa jadi relasi/object
                'agama'            => $p->getRawOriginal('agama') ?? (is_string($p->agama) ? $p->agama : ($p->agama->nama ?? '-')),
                'alamat'           => $p->alamat,
                'warga_negara'     => 'WNI',
                'bantuan_aktif'    => [],
            ]);

        return view('admin.bantuan.peserta.create', compact('bantuan', 'penduduk'));
    }

    public function edit(Program $bantuan, ProgramPeserta $peserta) {
        return view('admin.bantuan.peserta.edit', compact('bantuan', 'peserta'));
    }

    public function update(Request $request, Program $bantuan, ProgramPeserta $peserta) {
        $request->validate([
            'kartu_no_id'            => 'nullable|string|max:100',
            'kartu_nik'           => 'required|string|max:20',
            'kartu_nama'          => 'required|string|max:255',
            'kartu_tempat_lahir'  => 'nullable|string|max:100',
            'kartu_tanggal_lahir' => 'nullable|date',
            'kartu_alamat'        => 'nullable|string',
            'gambar_kartu'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'kartu_no_id',
            'kartu_nik',
            'kartu_nama',
            'kartu_tempat_lahir',
            'kartu_tanggal_lahir',
            'kartu_alamat',
        ]);

        if ($request->hasFile('gambar_kartu')) {
            $data['gambar_kartu'] = $request->file('gambar_kartu')
                ->store('bantuan/kartu', 'public');
        }

        $peserta->update($data);

        return redirect()->route('admin.bantuan.show', $bantuan)
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function search(Request $request, Program $bantuan) {
        $q = $request->query('q', '');

        $sudahPeserta = $bantuan->peserta()
            ->whereNotNull('penduduk_id')
            ->pluck('penduduk_id');

        $results = Penduduk::where('status_hidup', 'hidup')
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('nik', 'like', "%{$q}%");
            })
            ->select(
                'id',
                'nama',
                'nik',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'pendidikan',
                'agama',
                'alamat'
            )
            ->limit(20)
            ->get()
            ->map(fn($p) => [
                'id'               => $p->id,
                'nik'              => $p->nik,
                'nama'             => $p->nama,
                'tempat_lahir'     => $p->tempat_lahir,
                'tanggal_lahir'    => optional($p->tanggal_lahir)->format('d M Y'),
                'tanggal_lahir_iso' => optional($p->tanggal_lahir)->format('Y-m-d'),
                'jenis_kelamin'    => $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                // FIX: cast ke int
                'umur'             => $p->tanggal_lahir ? (int) $p->tanggal_lahir->diffInYears(now()) : null,
                'pendidikan'       => $p->pendidikan,
                // FIX: paksa jadi string
                'agama'            => $p->getRawOriginal('agama') ?? (is_string($p->agama) ? $p->agama : ($p->agama->nama ?? '-')),
                'alamat'           => $p->alamat,
                'warga_negara'     => 'WNI',
                'sudah_terdaftar'  => $sudahPeserta->contains($p->id),
                'bantuan_aktif'    => \App\Models\ProgramPeserta::where('penduduk_id', $p->id)
                    ->with('program:id,nama')
                    ->get()->pluck('program.nama')->filter()->values(),
            ]);

        return response()->json($results);
    }

    public function store(Request $request, Program $bantuan) {
        $request->validate([
            'penduduk_id'         => 'required|exists:penduduk,id',
            'kartu_no_id'            => 'nullable|string|max:100',
            'kartu_nik'           => 'required|string|max:20',
            'kartu_nama'          => 'required|string|max:255',
            'kartu_tempat_lahir'  => 'nullable|string|max:100',
            'kartu_tanggal_lahir' => 'nullable|date',
            'kartu_alamat'        => 'nullable|string',
            'gambar_kartu'        => 'nullable|image|max:2048',
        ]);

        $sudahAda = $bantuan->peserta()
            ->where('penduduk_id', $request->penduduk_id)
            ->exists();

        if ($sudahAda) {
            return back()->withInput()
                ->with('error', 'Penduduk ini sudah terdaftar di program bantuan ini.');
        }

        $data = $request->only([
            'penduduk_id',
            'kartu_no_id',
            'kartu_nik',
            'kartu_nama',
            'kartu_tempat_lahir',
            'kartu_tanggal_lahir',
            'kartu_alamat',
        ]);
        $data['peserta'] = $request->kartu_nik;

        if ($request->hasFile('gambar_kartu')) {
            $data['gambar_kartu'] = $request->file('gambar_kartu')
                ->store('bantuan/kartu', 'public');
        }

        $bantuan->peserta()->create($data);

        return redirect()->route('admin.bantuan.show', $bantuan)
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function destroy(Program $bantuan, ProgramPeserta $peserta) {
        $peserta->delete();
        return redirect()->route('admin.bantuan.show', $bantuan->id)
            ->with('success', 'Peserta berhasil dihapus.');
    }

    public function bulkDestroy(Request $request, Program $bantuan) {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('admin.bantuan.show', $bantuan)
                ->with('error', 'Tidak ada peserta yang dipilih.');
        }

        $bantuan->peserta()->whereIn('id', $ids)->delete();

        return redirect()->route('admin.bantuan.show', $bantuan)
            ->with('success', count($ids) . ' peserta berhasil dihapus.');
    }

    // ─── Download Template Import ─────────────────────────────────────────────
    public function downloadTemplate(Program $bantuan) {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet()->setTitle('Template');
        $headers = ['NIK (16 digit)'];

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

        $sheet->setCellValue('A2', '3302011234560001');
        $sheet->getStyle("A2:A2")->getFont()->setItalic(true)->getColor()->setRGB('6B7280');
        $sheet->getColumnDimension('A')->setAutoSize(true);

        $refSheet = $spreadsheet->createSheet()->setTitle('Referensi');
        $sudahPeserta = $bantuan->peserta()->whereNotNull('penduduk_id')->pluck('penduduk_id');
        $pendudukList = Penduduk::where('status_hidup', 'hidup')
            ->whereNotIn('id', $sudahPeserta)
            ->select('nik', 'nama', 'alamat')
            ->orderBy('nama')
            ->get();

        $refSheet->setCellValue('A1', 'NIK');
        $refSheet->setCellValue('B1', 'Nama');
        $refSheet->setCellValue('C1', 'Alamat');
        $refSheet->getStyle('A1:C1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
        ]);
        foreach ($pendudukList as $i => $p) {
            $refSheet->setCellValue('A' . ($i + 2), $p->nik);
            $refSheet->setCellValue('B' . ($i + 2), $p->nama);
            $refSheet->setCellValue('C' . ($i + 2), $p->alamat ?? '-');
        }
        foreach (['A', 'B', 'C'] as $c) {
            $refSheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($bantuan->nama);
        $filename = "template_peserta_{$slug}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Import ───────────────────────────────────────────────────────────────
    public function import(Request $request, Program $bantuan) {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,xls,xlsx', 'max:10240'],
            'mode' => ['required', 'in:skip,overwrite'],
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);
        $highestRow  = $sheet->getHighestRow();

        $header = $rows[1] ?? [];
        $nikCol = null;

        foreach ($header as $colLetter => $label) {
            $label = strtolower(trim((string) $label));
            if (str_contains($label, 'nik')) {
                $nikCol = $colLetter;
            }
        }

        if (!$nikCol) {
            return back()->with('error', 'Kolom NIK tidak ditemukan di file. Pastikan menggunakan template yang disediakan.');
        }

        $imported     = 0;
        $skipped      = 0;
        $importErrors = [];

        DB::beginTransaction();
        try {
            for ($rowNum = 2; $rowNum <= $highestRow; $rowNum++) {
                $raw = $rows[$rowNum] ?? [];
                $nik = trim((string) ($raw[$nikCol] ?? ''));

                if (empty($nik)) continue;

                if (!preg_match('/^\d{16}$/', $nik)) {
                    $importErrors[] = "Baris {$rowNum}: Format NIK tidak valid — \"{$nik}\" (harus 16 digit)";
                    continue;
                }

                $penduduk = Penduduk::where('nik', $nik)->where('status_hidup', 'hidup')->first();
                if (!$penduduk) {
                    $importErrors[] = "Baris {$rowNum}: NIK {$nik} tidak ditemukan atau sudah meninggal";
                    continue;
                }

                $existing = ProgramPeserta::where('program_id', $bantuan->id)
                    ->where('penduduk_id', $penduduk->id)
                    ->first();

                if ($existing) {
                    if ($request->mode === 'overwrite') {
                        $imported++;
                    } else {
                        $skipped++;
                    }
                } else {
                    ProgramPeserta::create([
                        'program_id'          => $bantuan->id,
                        'penduduk_id'         => $penduduk->id,
                        'peserta'             => $penduduk->nik,
                        'kartu_nama'          => $penduduk->nama,
                        'kartu_nik'           => $penduduk->nik,
                        'kartu_tempat_lahir'  => $penduduk->tempat_lahir,
                        'kartu_tanggal_lahir' => $penduduk->tanggal_lahir,
                        'kartu_alamat'        => $penduduk->alamat,
                    ]);
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
    public function exportExcel(Program $bantuan) {
        $peserta = $bantuan->peserta()->with('penduduk')->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Peserta');

        $headers = ['No', 'NIK', 'Nama', 'JK', 'Tempat/Tgl Lahir', 'Alamat'];
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

        foreach ($peserta as $i => $p) {
            $rowNum = $i + 2;
            $penduduk = $p->penduduk;
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue('B' . $rowNum, $p->kartu_nik ?? $p->peserta ?? '-');
            $sheet->setCellValue('C' . $rowNum, $p->kartu_nama ?? '-');
            $sheet->setCellValue('D' . $rowNum, $penduduk?->jenis_kelamin === 'L' ? 'Laki-laki' : ($penduduk?->jenis_kelamin === 'P' ? 'Perempuan' : '-'));
            $tempatTgl = ($p->kartu_tempat_lahir ?? '-') . ' / ' . (optional($p->kartu_tanggal_lahir)->format('d/m/Y') ?? '-');
            $sheet->setCellValue('E' . $rowNum, $tempatTgl);
            $sheet->setCellValue('F' . $rowNum, $p->kartu_alamat ?? '-');

            if ($i % 2 === 1) {
                $sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
        }

        if ($peserta->count() > 0) {
            $sheet->getStyle("A1:{$lastCol}" . ($peserta->count() + 1))->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($bantuan->nama);
        $filename = "peserta_{$slug}_" . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────
    public function exportPdf(Program $bantuan) {
        $peserta = $bantuan->peserta()->with('penduduk')->get();

        $stats = [
            'total'     => $peserta->count(),
            'laki_laki' => $peserta->filter(fn($p) => $p->penduduk?->jenis_kelamin === 'L')->count(),
            'perempuan' => $peserta->filter(fn($p) => $p->penduduk?->jenis_kelamin === 'P')->count(),
        ];

        $pdf = Pdf::loadView('admin.bantuan.export-pdf', compact('bantuan', 'peserta', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        $slug     = \Illuminate\Support\Str::slug($bantuan->nama);
        $filename = "peserta_{$slug}_" . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    public function json(Program $bantuan, ProgramPeserta $peserta): JsonResponse {
        return response()->json([
            'id'                  => $peserta->id,
            'kartu_no_id'            => $peserta->kartu_no_id,
            'kartu_nik'           => $peserta->kartu_nik,
            'kartu_nama'          => $peserta->kartu_nama,
            'kartu_tempat_lahir'  => $peserta->kartu_tempat_lahir,
            'kartu_tanggal_lahir' => $peserta->kartu_tanggal_lahir?->format('Y-m-d'),
            'kartu_alamat'        => $peserta->kartu_alamat,
            'nama_penduduk'       => $peserta->penduduk?->nama ?? $peserta->kartu_nama,
        ]);
    }
}
