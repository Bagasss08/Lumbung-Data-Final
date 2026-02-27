<?php

namespace App\Exports;

use App\Models\StatusDesa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StatusDesaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    private int $no = 0;

    public function collection()
    {
        return StatusDesa::terbaru()->get();
    }

    public function title(): string
    {
        return 'Status Desa';
    }

    public function headings(): array
    {
        return [
            'No',
            'Tahun',
            'Nama Status',
            'Nilai IDM',
            'IKS (Ketahanan Sosial)',
            'IKE (Ketahanan Ekonomi)',
            'IKL (Ketahanan Ekologi)',
            'Status',
            'Status Target',
            'Nilai Target',
            'Keterangan',
            'Tanggal Input',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            $row->tahun,
            $row->nama_status,
            number_format($row->nilai, 4),
            number_format($row->skor_ketahanan_sosial, 4),
            number_format($row->skor_ketahanan_ekonomi, 4),
            number_format($row->skor_ketahanan_ekologi, 4),
            $row->status ?? '-',
            $row->status_target ?? '-',
            $row->nilai_target ? number_format($row->nilai_target, 4) : '-',
            $row->keterangan ?? '-',
            $row->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Header styling
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '059669'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '047857']],
            ],
        ]);

        // Row zebra stripe
        $highestRow = $sheet->getHighestRow();
        for ($i = 2; $i <= $highestRow; $i++) {
            $color = $i % 2 === 0 ? 'F0FDF4' : 'FFFFFF';
            $sheet->getStyle("A{$i}:L{$i}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        // Kolom angka center
        $sheet->getStyle("A2:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:J{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Tinggi header
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }
}