<?php

namespace App\Exports;

use App\Models\KehadiranPegawai;
use App\Models\PerangkatDesa;
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
use Carbon\Carbon;

class RekapitulasiKehadiranExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    protected int $bulan;
    protected int $tahun;
    protected ?int $perangkatId;
    protected int $jumlahHariKerja;

    public function __construct(int $bulan, int $tahun, ?int $perangkatId = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->perangkatId = $perangkatId;
        $this->jumlahHariKerja = $this->hitungHariKerja($bulan, $tahun);
    }

    public function collection()
    {
        $perangkats = PerangkatDesa::orderBy('nama')->get();

        if ($this->perangkatId) {
            $perangkats = $perangkats->where('id', $this->perangkatId);
        }

        $kehadiranList = KehadiranPegawai::with(['perangkat', 'jamKerja'])
            ->bulan($this->bulan, $this->tahun)
            ->orderBy('tanggal')
            ->get();

        $data = [];
        $no = 0;

        foreach ($perangkats as $perangkat) {
            $kehadiran = $kehadiranList->where('perangkat_id', $perangkat->id);

            $hadir = $kehadiran->where('status', 'hadir')->count();
            $terlambat = $kehadiran->where('status', 'terlambat')->count();
            $izin = $kehadiran->where('status', 'izin')->count();
            $sakit = $kehadiran->where('status', 'sakit')->count();
            $alpa = $kehadiran->where('status', 'alpa')->count();
            $dinasLuar = $kehadiran->where('status', 'dinas_luar')->count();
            $cuti = $kehadiran->where('status', 'cuti')->count();

            $persen = $this->jumlahHariKerja > 0
                ? round(($hadir + $terlambat) / $this->jumlahHariKerja * 100)
                : 0;

            $data[] = (object) [
                'no' => ++$no,
                'nama' => $perangkat->nama,
                'jabatan' => $perangkat->jabatan?->nama ?? '-',
                'hadir' => $hadir,
                'terlambat' => $terlambat,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'dinas_luar' => $dinasLuar,
                'cuti' => $cuti,
                'persen' => $persen,
            ];
        }

        return collect($data);
    }

    public function title(): string
    {
        $namaBulan = Carbon::create($this->tahun, $this->bulan, 1)->translatedFormat('F');
        return "Rekap {$namaBulan} {$this->tahun}";
    }

    public function headings(): array
    {
        $namaBulan = Carbon::create($this->tahun, $this->bulan, 1)->translatedFormat('F');
        return [
            'REKAPITULASI KEHADIRAN PERANGKAT DESA',
            "Periode: {$namaBulan} {$this->tahun}",
            '',
            'No',
            'Nama Perangkat',
            'Jabatan',
            'Hadir',
            'Terlambat',
            'Izin',
            'Sakit',
            'Alpa',
            'Dinas Luar',
            'Cuti',
            '% Hadir',
        ];
    }

    public function map($row): array
    {
        return [
            '',
            '',
            '',
            $row->no,
            $row->nama,
            $row->jabatan,
            $row->hadir,
            $row->terlambat,
            $row->izin,
            $row->sakit,
            $row->alpa,
            $row->dinas_luar,
            $row->cuti,
            $row->persen . '%',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Merge cells for title
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');

        // Title style
        $sheet->getStyle('A1:A2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Header row (row 4)
        $sheet->getStyle('A4:N4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '047857']]],
        ]);

        // Data rows
        $highestRow = $sheet->getHighestRow();
        for ($i = 5; $i <= $highestRow; $i++) {
            $color = $i % 2 === 0 ? 'F0FDF4' : 'FFFFFF';
            $sheet->getStyle("A{$i}:N{$i}")->applyFromArray([
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
        }

        // Column alignment
        $sheet->getStyle('A5:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D5:N' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Row height
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(30);

        return [];
    }

    private function hitungHariKerja(int $bulan, int $tahun): int
    {
        $start = Carbon::create($tahun, $bulan, 1);
        $end = $start->copy()->endOfMonth();
        $count = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isWeekday()) {
                $count++;
            }
        }

        return $count;
    }
}
