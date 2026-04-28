<?php

namespace App\Http\Controllers\Admin\Kependudukan;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\KelompokAnggota;
use App\Models\KelompokMaster;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Barryvdh\DomPDF\Facade\Pdf;

class KelompokController extends Controller {
    // =========================================================
    // KELOMPOK MASTER (Jenis Kelompok)
    // =========================================================

    public function masterIndex() {
        $data = KelompokMaster::withCount('kelompok')->orderBy('nama')->get();
        return view('admin.kelompok.master.index', compact('data'));
    }

    public function masterStore(Request $request) {
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kelompok_master,nama',
            'singkatan' => 'nullable|string|max:20',
            'jenis'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        KelompokMaster::create($request->only('nama', 'singkatan', 'jenis', 'keterangan'));

        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil ditambahkan.');
    }

    public function masterUpdate(Request $request, KelompokMaster $master) {
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kelompok_master,nama,' . $master->id,
            'singkatan' => 'nullable|string|max:20',
            'jenis'     => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $master->update($request->only('nama', 'singkatan', 'jenis', 'keterangan'));

        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil diperbarui.');
    }

    public function masterDestroy(KelompokMaster $master) {
        if ($master->kelompok()->count() > 0) {
            return redirect()->route('admin.kelompok.master.index')
                ->with('error', 'Tidak dapat menghapus jenis kelompok yang masih memiliki data kelompok.');
        }
        $master->delete();
        return redirect()->route('admin.kelompok.master.index')
            ->with('success', 'Jenis kelompok berhasil dihapus.');
    }

    // =========================================================
    // KELOMPOK
    // =========================================================

    public function index(Request $request) {
        $query = Kelompok::with('master')
            ->withCount('anggotaAktif');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('singkatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('master')) {
            $query->where('id_kelompok_master', $request->master);
        }

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $kelompok = $query->orderBy('nama')->paginate(15)->withQueryString();
        $masterList = KelompokMaster::orderBy('nama')->get();

        return view('admin.kelompok.index', compact('kelompok', 'masterList'));
    }

    public function create() {
        $masterList = KelompokMaster::orderBy('nama')->get();
        return view('admin.kelompok.create', compact('masterList'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_kelompok_master' => 'required|exists:kelompok_master,id',
            'nama'               => 'required|string|max:100',
            'singkatan'          => 'nullable|string|max:20',
            'tgl_terbentuk'      => 'nullable|date',
            'sk_desa'            => 'nullable|string|max:100',
            'tgl_sk_desa'        => 'nullable|date',
            'sk_kabupaten'       => 'nullable|string|max:100',
            'tgl_sk_kabupaten'   => 'nullable|date',
            'nik_ketua'          => 'nullable|string|max:16',
            'nama_ketua'         => 'nullable|string|max:100',
            'telepon'            => 'nullable|string|max:20',
            'alamat'             => 'nullable|string',
            'aktif'              => 'required|in:1,0',
            'keterangan'         => 'nullable|string',
        ]);

        Kelompok::create($request->all());

        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok berhasil ditambahkan.');
    }

    public function show(Kelompok $kelompok) {
        $kelompok->load(['master', 'anggota.penduduk']);
        return view('admin.kelompok.show', compact('kelompok'));
    }

    public function edit(Kelompok $kelompok) {
        $masterList = KelompokMaster::orderBy('nama')->get();
        return view('admin.kelompok.edit', compact('kelompok', 'masterList'));
    }

    public function update(Request $request, Kelompok $kelompok) {
        $request->validate([
            'id_kelompok_master' => 'required|exists:kelompok_master,id',
            'nama'               => 'required|string|max:100',
            'singkatan'          => 'nullable|string|max:20',
            'tgl_terbentuk'      => 'nullable|date',
            'sk_desa'            => 'nullable|string|max:100',
            'tgl_sk_desa'        => 'nullable|date',
            'sk_kabupaten'       => 'nullable|string|max:100',
            'tgl_sk_kabupaten'   => 'nullable|date',
            'nik_ketua'          => 'nullable|string|max:16',
            'nama_ketua'         => 'nullable|string|max:100',
            'telepon'            => 'nullable|string|max:20',
            'alamat'             => 'nullable|string',
            'aktif'              => 'required|in:1,0',
            'keterangan'         => 'nullable|string',
        ]);

        $kelompok->update($request->all());

        return redirect()->route('admin.kelompok.show', $kelompok)
            ->with('success', 'Kelompok berhasil diperbarui.');
    }

    public function destroy(Kelompok $kelompok) {
        $kelompok->delete();
        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok berhasil dihapus.');
    }

    // =========================================================
    // ANGGOTA KELOMPOK
    // =========================================================

    public function anggotaIndex(Kelompok $kelompok) {
        $kelompok->load(['master', 'anggota.penduduk']);
        return view('admin.kelompok.anggota.index', compact('kelompok'));
    }

    public function anggotaCreate(Kelompok $kelompok) {
        // Ambil NIK yang sudah menjadi anggota aktif agar tidak dobel
        $nikSudahAnggota = $kelompok->anggotaAktif()->pluck('nik')->toArray();

        // Penduduk hidup yang belum jadi anggota aktif di kelompok ini
        $pendudukList = Penduduk::whereNotIn('nik', $nikSudahAnggota)
            ->where('status_hidup', '!=', 'meninggal')  // filter penduduk aktif
            ->orderBy('nama')
            ->get(['nik', 'nama', 'jenis_kelamin', 'alamat']);

        return view('admin.kelompok.anggota.create', compact('kelompok', 'pendudukList'));
    }

    public function anggotaStore(Request $request, Kelompok $kelompok) {
        $request->validate([
            'nik'       => 'required|string|max:16',
            'jabatan'   => 'nullable|string|max:50',
            'tgl_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Cek apakah sudah menjadi anggota aktif
        $existing = KelompokAnggota::where('id_kelompok', $kelompok->id)
            ->where('nik', $request->nik)
            ->where('aktif', '1')
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'Penduduk ini sudah menjadi anggota aktif kelompok.')
                ->withInput();
        }

        KelompokAnggota::create([
            'id_kelompok' => $kelompok->id,
            'nik'         => $request->nik,
            'jabatan'     => $request->jabatan,
            'tgl_masuk'   => $request->tgl_masuk,
            'aktif'       => '1',
            'keterangan'  => $request->keterangan,
        ]);

        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function anggotaDestroy(Kelompok $kelompok, KelompokAnggota $anggota) {
        $anggota->update(['aktif' => '0', 'tgl_keluar' => now()]);
        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Anggota berhasil dikeluarkan dari kelompok.');
    }

    public function anggotaDestroySoft(Kelompok $kelompok, KelompokAnggota $anggota) {
        $anggota->delete();
        return redirect()->route('admin.kelompok.anggota.index', $kelompok)
            ->with('success', 'Data anggota berhasil dihapus.');
    }

    // ─── Download Template Import ─────────────────────────────────────────────
    public function downloadTemplate(Kelompok $kelompok) {
        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Template ──
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Template');
        $headers = ['NIK (16 digit)', 'Jabatan', 'Keterangan'];

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
        $sheet->setCellValue('B2', 'Anggota');
        $sheet->setCellValue('C2', 'Keterangan opsional');
        $sheet->getStyle("A2:C2")->getFont()->setItalic(true)->getColor()->setRGB('6B7280');

        foreach (['A', 'B', 'C'] as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        // ── Sheet 2: Referensi (daftar penduduk hidup yang belum jadi anggota) ──
        $refSheet = $spreadsheet->createSheet()->setTitle('Referensi');
        $nikSudahAnggota = $kelompok->anggotaAktif()->pluck('nik')->toArray();
        $pendudukList = Penduduk::where('status_hidup', 'hidup')
            ->whereNotIn('nik', $nikSudahAnggota)
            ->select('nik', 'nama')
            ->orderBy('nama')
            ->get();

        $refSheet->setCellValue('A1', 'NIK');
        $refSheet->setCellValue('B1', 'Nama');
        $refSheet->getStyle('A1:B1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
        ]);
        foreach ($pendudukList as $i => $p) {
            $refSheet->setCellValue('A' . ($i + 2), $p->nik);
            $refSheet->setCellValue('B' . ($i + 2), $p->nama);
        }
        foreach (['A', 'B'] as $c) {
            $refSheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($kelompok->nama);
        $filename = "template_anggota_{$slug}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Import ───────────────────────────────────────────────────────────────
    public function import(Request $request, Kelompok $kelompok) {
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
        $nikCol = null;
        $jabatanCol = null;
        $ketCol = null;

        foreach ($header as $colLetter => $label) {
            $label = strtolower(trim((string) $label));
            if (str_contains($label, 'nik')) {
                $nikCol = $colLetter;
            }
            if (str_contains($label, 'jabatan')) {
                $jabatanCol = $colLetter;
            }
            if (str_contains($label, 'keterangan')) {
                $ketCol = $colLetter;
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
                $jabatan = trim((string) ($raw[$jabatanCol] ?? ''));
                $ket = trim((string) ($raw[$ketCol] ?? ''));

                // Skip baris kosong
                if (empty($nik)) continue;

                // Validasi format 16 digit
                if (!preg_match('/^\d{16}$/', $nik)) {
                    $importErrors[] = "Baris {$rowNum}: Format NIK tidak valid — \"{$nik}\" (harus 16 digit)";
                    continue;
                }

                // Cek NIK ada di tabel penduduk + status_hidup=hidup
                $penduduk = Penduduk::where('nik', $nik)->where('status_hidup', 'hidup')->first();
                if (!$penduduk) {
                    $importErrors[] = "Baris {$rowNum}: NIK {$nik} tidak ditemukan atau sudah meninggal";
                    continue;
                }

                $existing = KelompokAnggota::where('id_kelompok', $kelompok->id)
                    ->where('nik', $nik)
                    ->first();

                if ($existing) {
                    if ($request->mode === 'overwrite') {
                        $existing->update([
                            'jabatan' => $jabatan ?: null,
                            'keterangan' => $ket ?: null,
                            'aktif' => '1',
                        ]);
                        $imported++;
                    } else {
                        $skipped++;
                    }
                } else {
                    KelompokAnggota::create([
                        'id_kelompok' => $kelompok->id,
                        'nik'         => $nik,
                        'jabatan'     => $jabatan ?: null,
                        'aktif'       => '1',
                        'keterangan'  => $ket ?: null,
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
    public function exportExcel(Kelompok $kelompok) {
        $anggota = $kelompok->anggotaAktif()->with('penduduk')->get();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet()->setTitle('Anggota');

        // Header
        $headers = ['No', 'NIK', 'Nama', 'JK', 'Jabatan', 'Tgl Bergabung'];
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
        foreach ($anggota as $i => $a) {
            $rowNum = $i + 2;
            $p = $a->penduduk;
            $sheet->setCellValue('A' . $rowNum, $i + 1);
            $sheet->setCellValue('B' . $rowNum, $a->nik ?? '-');
            $sheet->setCellValue('C' . $rowNum, $p?->nama ?? '-');
            $sheet->setCellValue('D' . $rowNum, $p?->jenis_kelamin === 'L' ? 'Laki-laki' : ($p?->jenis_kelamin === 'P' ? 'Perempuan' : '-'));
            $sheet->setCellValue('E' . $rowNum, $a->jabatan ?? '-');
            $sheet->setCellValue('F' . $rowNum, optional($a->tgl_masuk)->format('d/m/Y') ?? '-');

            // Alternating row
            if ($i % 2 === 1) {
                $sheet->getStyle("A{$rowNum}:{$lastCol}{$rowNum}")
                    ->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F9FAFB');
            }
        }

        if ($anggota->count() > 0) {
            $sheet->getStyle("A1:{$lastCol}" . ($anggota->count() + 1))->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        foreach (range('A', $lastCol) as $c) {
            $sheet->getColumnDimension($c)->setAutoSize(true);
        }

        $writer   = new XlsxWriter($spreadsheet);
        $slug     = \Illuminate\Support\Str::slug($kelompok->nama);
        $filename = "anggota_{$slug}_" . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ─── Export PDF ───────────────────────────────────────────────────────────
    public function exportPdf(Kelompok $kelompok) {
        $anggota = $kelompok->anggotaAktif()->with('penduduk')->get();

        $pdf = Pdf::loadView('admin.kelompok.export-pdf', compact('kelompok', 'anggota'))
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 110, 'defaultFont' => 'sans-serif']);

        $slug     = \Illuminate\Support\Str::slug($kelompok->nama);
        $filename = "anggota_{$slug}_" . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

    // =========================================================
    // SEARCH PENDUDUK (AJAX)
    // =========================================================

    public function searchPenduduk(Request $request) {
        $term = $request->get('q', '');
        $results = Penduduk::where(function ($q) use ($term) {
            $q->where('nik', 'like', "%$term%")
                ->orWhere('nama', 'like', "%$term%");
        })
            ->where('status_hidup', '!=', 'meninggal')
            ->orderBy('nama')
            ->limit(20)
            ->get(['nik', 'nama', 'alamat'])
            ->map(fn($p) => [
                'id'      => $p->nik,
                'text'    => "{$p->nik} — {$p->nama}",
                'alamat'  => $p->alamat ?? '',
            ]);

        return response()->json(['results' => $results]);
    }
}
