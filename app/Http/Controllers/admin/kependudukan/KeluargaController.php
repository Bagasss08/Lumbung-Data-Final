<?php

namespace App\Http\Controllers\Admin\kependudukan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga;
use App\Models\Penduduk;
use App\Models\Wilayah;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Barryvdh\DomPDF\Facade\Pdf;

class KeluargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Keluarga::query()->with(['anggota', 'wilayah']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhereHas('anggota', function($q) use ($search) {
                      $q->where('nama', 'like', '%' . $search . '%')
                        ->wherePivot('hubungan_keluarga', 'kepala_keluarga');
                  });
            });
        }



        // Filter by klasifikasi ekonomi
        if ($request->has('klasifikasi_ekonomi') && !empty($request->klasifikasi_ekonomi)) {
            $query->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi);
        }

        $keluarga = $query->paginate(12)->appends($request->query());

        $total_keluarga = Keluarga::count();
        $keluarga_aktif = Keluarga::count(); // Since status was removed, all are considered active
        $keluarga_pindah = 0; // No pindah status anymore
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga', compact('keluarga', 'total_keluarga', 'keluarga_aktif', 'keluarga_pindah', 'penduduk', 'wilayah'));
    }

    public function create()
    {
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga-create', compact('penduduk', 'wilayah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:keluarga,no_kk',
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
        ]);

        $keluarga = Keluarga::create($validated);

        // Attach kepala keluarga via pivot table
        $keluarga->anggota()->attach($request->kepala_keluarga_id, ['hubungan_keluarga' => 'kepala_keluarga']);

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil ditambahkan.');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load(['anggota', 'wilayah']);
        return view('admin.keluarga-show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        $penduduk = Penduduk::all();
        $wilayah = Wilayah::all();

        return view('admin.keluarga-edit', compact('keluarga', 'penduduk', 'wilayah'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:keluarga,no_kk,' . $keluarga->id,
            'alamat' => 'nullable|string',
            'wilayah_id' => 'required|exists:wilayah,id',
            'tgl_terdaftar' => 'required|date',
            'klasifikasi_ekonomi' => 'nullable|in:miskin,rentan,mampu',
            'jenis_bantuan_aktif' => 'nullable|string|max:255',
            'kepala_keluarga_id' => 'required|exists:penduduk,id',
        ]);

        $keluarga->update($validated);

        // Update kepala keluarga via pivot table
        // First detach existing kepala keluarga
        $keluarga->anggota()->wherePivot('hubungan_keluarga', 'kepala_keluarga')->detach();

        // Attach new kepala keluarga
        $keluarga->anggota()->attach($request->kepala_keluarga_id, ['hubungan_keluarga' => 'kepala_keluarga']);

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil diperbarui.');
    }

    public function confirmDestroy(Keluarga $keluarga)
    {
        return view('admin.keluarga-delete', compact('keluarga'));
    }

    public function destroy(Keluarga $keluarga)
    {
        // Detach all anggota relationships from pivot table before deleting
        $keluarga->anggota()->detach();

        $keluarga->delete();

        return redirect()->route('admin.keluarga')->with('success', 'Keluarga berhasil dihapus.');
    }

    // ─── Export Excel ─────────────────────────────────────────────────────────
    public function exportExcel(Request $request)
    {
        $data = $this->buildExportQuery($request)->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Data Keluarga');

        // Header
        $headers = ['No', 'No. KK', 'Kepala Keluarga', 'Alamat', 'Jumlah Anggota', 'Wilayah'];
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
            $sheet->setCellValue($colIdx++ . $rowNum, $row->no_kk ?? '-');
            
            $kepala = $row->getKepalaKeluarga();
            $sheet->setCellValue($colIdx++ . $rowNum, $kepala ? $kepala->nama : '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->alamat ?? '-');
            $sheet->setCellValue($colIdx++ . $rowNum, $row->getTotalAnggota());
            
            $wilayah = $row->wilayah;
            $wilayahText = $wilayah ? 'RT ' . $wilayah->rt . ' / RW ' . $wilayah->rw . ' - ' . $wilayah->dusun : '-';
            $sheet->setCellValue($colIdx++ . $rowNum, $wilayahText);

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
        }, 'data_keluarga_' . now()->format('Ymd_His') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────
    public function exportPdf(Request $request)
    {
        $keluarga = $this->buildExportQuery($request)->get();
        $stats    = [
            'total' => $keluarga->count(),
        ];

        $pdf = Pdf::loadView('admin.keluarga-export-pdf', compact('keluarga', 'stats'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        return $pdf->download('data_keluarga_' . now()->format('Ymd_His') . '.pdf');
    }

    // ─── Helper: query yang dipakai index & export ────────────────────────────
    private function buildExportQuery(Request $request)
    {
        return Keluarga::query()
            ->with(['anggota', 'wilayah'])
            ->when(
                $request->filled('search'),
                fn($q) => $q->where(function($query) use ($request) {
                    $query->where('no_kk', 'like', '%' . $request->search . '%')
                        ->orWhereHas('anggota', function($q) use ($request) {
                            $q->where('nama', 'like', '%' . $request->search . '%')
                                ->wherePivot('hubungan_keluarga', 'kepala_keluarga');
                        });
                })
            )
            ->when(
                $request->filled('wilayah_id'),
                fn($q) => $q->where('wilayah_id', $request->wilayah_id)
            )
            ->when(
                $request->filled('klasifikasi_ekonomi') && $request->klasifikasi_ekonomi !== '',
                fn($q) => $q->where('klasifikasi_ekonomi', $request->klasifikasi_ekonomi)
            )
            ->orderBy('no_kk');
    }
}
