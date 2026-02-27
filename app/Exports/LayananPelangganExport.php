<?php

namespace App\Exports;

use App\Models\LayananPelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LayananPelangganExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize {
    private int $no = 0;

    public function collection() {
        return LayananPelanggan::urut()->get();
    }

    public function title(): string {
        return 'Layanan Pelanggan';
    }

    public function headings(): array {
        return [
            'No',
            'Kode',
            'Nama Layanan',
            'Jenis',
            'Status',
            'Penanggung Jawab',
            'Waktu Penyelesaian',
            'Biaya',
            'Dasar Hukum',
            'Persyaratan',
        ];
    }

    public function map($row): array {
        $this->no++;
        return [
            $this->no,
            $row->kode_layanan ?? '-',
            $row->nama_layanan,
            $row->jenis_layanan ?? '-',
            ucfirst($row->status),
            $row->penanggung_jawab ?? '-',
            $row->waktu_penyelesaian ?? '-',
            $row->biaya ?? 'Gratis',
            $row->dasar_hukum ?? '-',
            $row->persyaratan
                ? implode('; ', $row->persyaratan_array)
                : '-',
        ];
    }

    public function styles(Worksheet $sheet): array {
        $last = $sheet->getHighestRow();

        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '047857']]],
        ]);

        for ($i = 2; $i <= $last; $i++) {
            $color = $i % 2 === 0 ? 'F0FDF4' : 'FFFFFF';
            $sheet->getStyle("A{$i}:J{$i}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        // Wrap text di kolom persyaratan (J)
        $sheet->getStyle("J2:J{$last}")->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(1)->setRowHeight(30);

        return [];
    }
}
