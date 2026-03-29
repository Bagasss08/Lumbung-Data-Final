<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Http\Request;

class PendudukExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents {
    protected Request $request;
    protected bool    $sensorNik;
    protected bool    $semuaData;
    protected ?object $desa;
    protected int     $rowNum = 0;

    protected ?string $desaInfo;
    protected ?string $namaKepala;

    // Kolom terakhir (30 kolom: A–AD)
    const LAST_COL  = 'AD';
    const HEAD_ROW  = 6;
    const DATA_START = 7;

    public function __construct(Request $request) {
        $this->request   = $request;
        $this->sensorNik = $request->boolean('sensor_nik');
        $this->semuaData = $request->boolean('semua');

        $this->desa = null;
        if (class_exists(\App\Models\IdentitasDesa::class)) {
            $this->desa = \App\Models\IdentitasDesa::first();
        }

        $this->desaInfo = $this->desa
            ? 'Desa : ' . ($this->desa->nama_desa ?? '')
            . '  Kec. : ' . ($this->desa->kecamatan ?? '')
            . '  Kab : '  . ($this->desa->kabupaten ?? '')
            : null;

        $this->namaKepala = $this->desa?->kepala_desa ?? null;
    }

    // =========================================================================
    // QUERY
    // =========================================================================
    public function query() {
        $q = Penduduk::with([
            'keluarga',
            'wilayah',
            'shdk',
            'agama',
            'pekerjaan',
            'statusKawin',
            'pendidikanKk',
            'golonganDarah',
            'warganegara',
        ])
            ->when(
                $this->request->filled('status'),
                fn($q) => $q->where('status', $this->request->status)
            )
            ->when(
                $this->request->filled('status_dasar'),
                fn($q) => $q->where('status_dasar', $this->request->status_dasar)
            )
            ->when(
                $this->request->filled('jenis_kelamin'),
                fn($q) => $q->where('jenis_kelamin', $this->request->jenis_kelamin)
            )
            ->when(
                $this->request->filled('dusun'),
                fn($q) => $q->whereHas('wilayah', fn($w) => $w->where('dusun', $this->request->dusun))
            )
            ->when(
                $this->request->filled('search'),
                fn($q) => $q->where(
                    fn($s) => $s->where('nama', 'like', '%' . $this->request->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->request->search . '%')
                )
            )
            ->when(
                $this->request->boolean('nik_sementara'),
                fn($q) => $q->where('is_nik_sementara', true)
            );

        if (! $this->semuaData) {
            $perPage = (int) $this->request->get('per_page', 10);
            $page    = (int) $this->request->get('page', 1);
            $q->skip(($page - 1) * $perPage)->take($perPage);
        }

        return $q->orderBy('nama');
    }

    // =========================================================================
    // HEADINGS  (akan muncul di baris 6 setelah insertNewRowBefore)
    // =========================================================================
    public function headings(): array {
        return [
            'No',
            'No. KK',
            'NIK',
            'Tag Id Card',
            'Nama',
            'Alamat',
            'Dusun',
            'Kecamatan',
            'Kabupaten',
            'RW',
            'RT',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Agama',
            'Pendidikan (dlm KK)',
            'Pekerjaan',
            'Kawin',
            'SHDK',
            'Nama Ayah',
            'Nama Ibu',
            'No. Telp',
            'Email',
            'Kewarganegaraan',
            'Golongan Darah',
            'Status Dasar',
            'Status Penduduk',
            'Tgl Peristiwa',
            'Tgl Terdaftar',
        ];
    }

    // =========================================================================
    // MAPPING
    // =========================================================================
    public function map($p): array {
        $this->rowNum++;

        $sensor    = fn(string $val) => $this->sensorNik
            ? substr($val, 0, 4) . str_repeat('X', max(0, strlen($val) - 4))
            : $val;

        $statusMap = ['1' => 'Tetap', '2' => 'Tidak Tetap', '3' => 'Pendatang'];

        return [
            $this->rowNum,
            "'" . $sensor($p->keluarga?->no_kk ?? ''),
            "'" . $sensor($p->nik ?? ''),
            $p->tag_id_card ?? '',
            $p->nama,
            $p->alamat ?? '',
            $p->wilayah?->dusun ?? '',
            $this->desa?->kecamatan ?? '',
            $this->desa?->kabupaten ?? '',
            $p->wilayah?->rw ?? '',
            $p->wilayah?->rt ?? '',
            $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : ''),
            $p->tempat_lahir ?? '',
            $p->tanggal_lahir?->format('d F Y') ?? '',
            $p->umur ?? '',
            $p->agama?->nama          ?? '',
            $p->pendidikanKk?->nama   ?? '',
            $p->pekerjaan?->nama      ?? '',
            $p->statusKawin?->nama    ?? '',
            $p->shdk?->nama           ?? '',
            $p->nama_ayah ?? '',
            $p->nama_ibu  ?? '',
            $p->no_telp   ?? '',
            $p->email     ?? '',
            $p->warganegara?->nama    ?? '',
            $p->golonganDarah?->nama  ?? '',
            ucfirst(str_replace('_', ' ', $p->status_dasar ?? '')),
            $statusMap[$p->status ?? ''] ?? '',
            $p->tgl_peristiwa?->format('d F Y') ?? '',
            optional($p->tgl_terdaftar ?? $p->created_at)?->format('d F Y') ?? '',
        ];
    }

    // =========================================================================
    // COLUMN WIDTHS  (A–AD, 30 kolom — tanpa duplikat key)
    // =========================================================================
    public function columnWidths(): array {
        return [
            'A'  =>  5,   // No
            'B'  => 22,   // No. KK
            'C'  => 22,   // NIK
            'D'  => 14,   // Tag Id Card
            'E'  => 28,   // Nama
            'F'  => 34,   // Alamat
            'G'  => 16,   // Dusun
            'H'  => 18,   // Kecamatan
            'I'  => 18,   // Kabupaten
            'J'  =>  6,   // RW
            'K'  =>  6,   // RT
            'L'  => 12,   // Jenis Kelamin
            'M'  => 16,   // Tempat Lahir
            'N'  => 16,   // Tanggal Lahir
            'O'  =>  7,   // Umur
            'P'  => 12,   // Agama
            'Q'  => 24,   // Pendidikan
            'R'  => 26,   // Pekerjaan
            'S'  => 22,   // Kawin
            'T'  => 20,   // SHDK
            'U'  => 22,   // Nama Ayah
            'V'  => 22,   // Nama Ibu
            'W'  => 14,   // No. Telp
            'X'  => 22,   // Email
            'Y'  => 16,   // Kewarganegaraan
            'Z'  => 14,   // Golongan Darah
            'AA' => 14,   // Status Dasar
            'AB' => 14,   // Status Penduduk
            'AC' => 16,   // Tgl Peristiwa
            'AD' => 16,   // Tgl Terdaftar
        ];
    }

    // =========================================================================
    // STYLES — kosong, semua styling di AfterSheet
    // =========================================================================
    public function styles(Worksheet $sheet): array {
        return [];
    }

    // =========================================================================
    // EVENTS
    // =========================================================================
    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet    = $event->sheet->getDelegate();
                $lastCol  = self::LAST_COL;
                $headRow  = self::HEAD_ROW;
                $dataStart = self::DATA_START;
                $lastRow  = $headRow + $this->rowNum;

                // ── 1. Sisipkan 5 baris header di atas ─────────────────────
                $sheet->insertNewRowBefore(1, 5);

                // ── 2. Isi baris header ─────────────────────────────────────
                // Baris 1: Info desa
                $sheet->setCellValue('A1', $this->desaInfo ?? '');
                // Baris 2–3: kosong
                $sheet->setCellValue('A2', '');
                $sheet->setCellValue('A3', '');
                // Baris 4: Judul
                $sheet->setCellValue('A4', 'DATA PENDUDUK');
                // Baris 5: spacer (kosong)

                // ── 3. Merge & style baris info desa (baris 1) ─────────────
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['name' => 'Arial', 'bold' => true, 'size' => 10],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(16);

                // Merge baris 2 & 3
                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->mergeCells("A3:{$lastCol}3");
                $sheet->getRowDimension(2)->setRowHeight(4);
                $sheet->getRowDimension(3)->setRowHeight(4);

                // ── 4. Merge & style baris judul (baris 4) ─────────────────
                $sheet->mergeCells("A4:{$lastCol}4");
                $sheet->getStyle('A4')->applyFromArray([
                    'font'      => ['name' => 'Arial', 'bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(28);

                // ── 5. Spacer baris 5 ───────────────────────────────────────
                $sheet->mergeCells("A5:{$lastCol}5");
                $sheet->getRowDimension(5)->setRowHeight(4);

                // ── 6. Style heading kolom (baris 6) — OpenSID style ───────
                //       Putih + teks hitam tebal + border hitam
                $sheet->getStyle("A{$headRow}:{$lastCol}{$headRow}")->applyFromArray([
                    'font'      => [
                        'name'  => 'Arial',
                        'bold'  => true,
                        'size'  => 9,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill'      => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders'   => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '000000'],
                        ],
                    ],
                ]);
                $sheet->getRowDimension($headRow)->setRowHeight(32);

                // ── 7. Style baris data ─────────────────────────────────────
                if ($lastRow >= $dataStart) {

                    // Border hitam tipis + font Arial 9
                    $sheet->getStyle("A{$dataStart}:{$lastCol}{$lastRow}")->applyFromArray([
                        'font'      => ['name' => 'Arial', 'size' => 9],
                        'borders'   => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => '000000'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => false,
                        ],
                    ]);

                    // Center: No, RW, RT, Umur, Jenis Kelamin
                    foreach (['A', 'J', 'K', 'O', 'L'] as $col) {
                        $sheet->getStyle("{$col}{$dataStart}:{$col}{$lastRow}")
                            ->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Zebra striping — baris genap abu-abu sangat muda
                    for ($row = $dataStart; $row <= $lastRow; $row++) {
                        if ($row % 2 === 0) {
                            $sheet->getStyle("A{$row}:{$lastCol}{$row}")
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()->setRGB('F2F2F2');
                        }
                    }

                    // Tinggi baris data
                    for ($row = $dataStart; $row <= $lastRow; $row++) {
                        $sheet->getRowDimension($row)->setRowHeight(16);
                    }
                }

                // ── 8. Freeze pane ──────────────────────────────────────────
                $sheet->freezePane("A{$dataStart}");

                // ── 9. Footer ───────────────────────────────────────────────
                $footerRow = $lastRow + 2;

                $sheet->setCellValue(
                    "A{$footerRow}",
                    'Tanggal cetak : ' . now()->translatedFormat('d F Y')
                );
                $sheet->getStyle("A{$footerRow}")->applyFromArray([
                    'font' => ['name' => 'Arial', 'size' => 9],
                ]);

                if ($this->namaKepala) {
                    $ttdCol = 'AB';
                    $sheet->setCellValue("{$ttdCol}{$footerRow}",       'Kepala Desa,');
                    $sheet->setCellValue("{$ttdCol}" . ($footerRow + 4), $this->namaKepala);
                    $sheet->getStyle("{$ttdCol}{$footerRow}:{$ttdCol}" . ($footerRow + 4))
                        ->applyFromArray([
                            'font'      => ['name' => 'Arial', 'size' => 9],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                        ]);
                }
            },
        ];
    }

    // =========================================================================
    // TITLE
    // =========================================================================
    public function title(): string {
        return 'Data Penduduk';
    }
}
