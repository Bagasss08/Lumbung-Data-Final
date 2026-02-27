<?php

namespace App\Exports;

use App\Models\Kerjasama;
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

class KerjasamaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize {
    private int $no = 0;

    public function collection() {
        return Kerjasama::orderByDesc('tanggal_mulai')->get();
    }

    public function title(): string {
        return 'Kerjasama';
    }

    public function headings(): array {
        return [
            'No',
            'Nomor Perjanjian',
            'Nama Mitra',
            'Jenis Mitra',
            'Jenis Kerjasama',
            'Alamat',
            'Kontak',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Status',
            'Ruang Lingkup',
        ];
    }

    public function map($row): array {
        $this->no++;
        return [
            $this->no,
            $row->nomor_perjanjian ?? '-',
            $row->nama_mitra,
            $row->jenis_mitra ?? '-',
            $row->jenis_kerjasama ?? '-',
            $row->alamat_mitra ?? '-',
            $row->kontak_mitra ?? '-',
            $row->tanggal_mulai?->format('d/m/Y') ?? '-',
            $row->tanggal_berakhir?->format('d/m/Y') ?? '-',
            ucfirst($row->status),
            $row->ruang_lingkup ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array {
        $last = $sheet->getHighestRow();

        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '047857']]],
        ]);

        for ($i = 2; $i <= $last; $i++) {
            $color = $i % 2 === 0 ? 'F0FDF4' : 'FFFFFF';
            $sheet->getStyle("A{$i}:K{$i}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        $sheet->getRowDimension(1)->setRowHeight(30);
        return [];
    }
}
