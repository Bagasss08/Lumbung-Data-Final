<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            font-size: 11px;
            color: #1a1a1a;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #059669;
            padding-bottom: 12px;
        }

        .header h1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #065f46;
        }

        .header h2 {
            font-size: 12px;
            margin-top: 4px;
            color: #374151;
        }

        .header p {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        thead tr {
            background-color: #059669;
            color: white;
        }

        thead th {
            padding: 8px 6px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }

        thead th:first-child,
        thead th:nth-child(2),
        thead th:nth-child(3) {
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f0fdf4;
        }

        tbody td {
            padding: 7px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }

        tbody td.center {
            text-align: center;
        }

        tfoot tr {
            background-color: #d1fae5;
            font-weight: bold;
            border-top: 2px solid #059669;
        }

        tfoot td {
            padding: 7px 6px;
            font-size: 10px;
        }

        .legend {
            margin-top: 20px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .legend-item {
            font-size: 9px;
            color: #6b7280;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }

        .badge-hadir {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-terlambat {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-alpa {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Rekapitulasi Kehadiran Perangkat Desa</h1>
        <h2>Periode: {{ $namaBulan }} {{ $tahun }}</h2>
        <p>Jumlah Hari Kerja: {{ $jumlahHariKerja }} Hari &nbsp;|&nbsp; Dicetak: {{ now()->translatedFormat('d F Y,
            H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Perangkat</th>
                <th>Jabatan</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>Dinas Luar</th>
                <th>Cuti</th>
                <th>% Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapData as $i => $rekap)
            @php
            $persen = $jumlahHariKerja > 0
            ? round(($rekap['hadir'] + $rekap['terlambat']) / $jumlahHariKerja * 100)
            : 0;
            @endphp
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td><strong>{{ $rekap['nama'] }}</strong></td>
                <td>{{ $rekap['jabatan'] }}</td>
                <td class="center">{{ $rekap['hadir'] }}</td>
                <td class="center">{{ $rekap['terlambat'] }}</td>
                <td class="center">{{ $rekap['izin'] }}</td>
                <td class="center">{{ $rekap['sakit'] }}</td>
                <td class="center">{{ $rekap['alpa'] }}</td>
                <td class="center">{{ $rekap['dinas_luar'] }}</td>
                <td class="center">{{ $rekap['cuti'] }}</td>
                <td class="center"><strong>{{ $persen }}%</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">TOTAL</td>
                <td class="center">{{ collect($rekapData)->sum('hadir') }}</td>
                <td class="center">{{ collect($rekapData)->sum('terlambat') }}</td>
                <td class="center">{{ collect($rekapData)->sum('izin') }}</td>
                <td class="center">{{ collect($rekapData)->sum('sakit') }}</td>
                <td class="center">{{ collect($rekapData)->sum('alpa') }}</td>
                <td class="center">{{ collect($rekapData)->sum('dinas_luar') }}</td>
                <td class="center">{{ collect($rekapData)->sum('cuti') }}</td>
                <td class="center">—</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh Sistem Lumbung Data Desa</p>
    </div>
</body>

</html>