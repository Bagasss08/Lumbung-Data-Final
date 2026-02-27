<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Layanan Pelanggan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #111827;
        }

        .kop {
            padding-bottom: 10px;
            border-bottom: 3px solid #059669;
            margin-bottom: 14px;
        }

        .kop h1 {
            font-size: 15px;
            font-weight: 700;
            color: #059669;
        }

        .kop h2 {
            font-size: 12px;
            font-weight: 600;
            margin-top: 2px;
        }

        .kop p {
            font-size: 9px;
            color: #6b7280;
            margin-top: 2px;
        }

        .doc-title {
            text-align: center;
            margin-bottom: 14px;
        }

        .doc-title h3 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .doc-title p {
            font-size: 9px;
            color: #6b7280;
            margin-top: 3px;
        }

        .summary {
            display: flex;
            gap: 10px;
            margin-bottom: 14px;
        }

        .summary-item {
            flex: 1;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 5px;
            padding: 8px 12px;
            text-align: center;
        }

        .summary-item .val {
            font-size: 16px;
            font-weight: 700;
            color: #059669;
        }

        .summary-item .lbl {
            font-size: 8px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        thead tr {
            background-color: #059669;
            color: #fff;
        }

        thead th {
            padding: 7px 8px;
            font-weight: 700;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background: #f0fdf4;
        }

        tbody td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 9px;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 700;
        }

        .badge-aktif {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-nonaktif {
            background: #f3f4f6;
            color: #374151;
        }

        .badge-jenis {
            background: #dbeafe;
            color: #1e40af;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
        }

        .footer-left {
            font-size: 8px;
            color: #9ca3af;
        }

        .ttd {
            text-align: center;
            font-size: 9px;
        }

        .ttd .gap {
            height: 55px;
        }

        .ttd .nama {
            font-weight: 700;
            border-top: 1px solid #111;
            padding-top: 3px;
        }
    </style>
</head>

<body>

    <div class="kop">
        <h1>LUMBUNG DATA DESA</h1>
        <h2>Katalog Layanan Pelanggan</h2>
        <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;·&nbsp; Oleh: {{ auth()->user()->name }}</p>
    </div>

    <div class="doc-title">
        <h3>Daftar Layanan Publik Desa</h3>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="val">{{ $layanan->count() }}</div>
            <div class="lbl">Total Layanan</div>
        </div>
        <div class="summary-item">
            <div class="val">{{ $layanan->where('status', 'aktif')->count() }}</div>
            <div class="lbl">Aktif</div>
        </div>
        <div class="summary-item">
            <div class="val">{{ $layanan->where('status', 'nonaktif')->count() }}</div>
            <div class="lbl">Nonaktif</div>
        </div>
        <div class="summary-item">
            <div class="val">{{ $layanan->whereNotNull('surat_format_id')->count() }}</div>
            <div class="lbl">Terhubung Surat</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:8%">Kode</th>
                <th style="width:20%">Nama Layanan</th>
                <th style="width:13%">Jenis</th>
                <th style="width:8%">Status</th>
                <th style="width:12%">Penanggung Jawab</th>
                <th style="width:10%">Waktu</th>
                <th style="width:8%">Biaya</th>
                <th>Persyaratan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($layanan as $i => $item)
            <tr>
                <td style="text-align:center">{{ $i + 1 }}</td>
                <td style="font-family: monospace; font-size:8px">{{ $item->kode_layanan ?? '-' }}</td>
                <td><strong>{{ $item->nama_layanan }}</strong></td>
                <td>
                    @if($item->jenis_layanan)
                    <span class="badge badge-jenis">{{ $item->jenis_layanan }}</span>
                    @else - @endif
                </td>
                <td style="text-align:center">
                    <span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                </td>
                <td>{{ $item->penanggung_jawab ?? '-' }}</td>
                <td>{{ $item->waktu_penyelesaian ?? '-' }}</td>
                <td>{{ $item->biaya ?? 'Gratis' }}</td>
                <td style="font-size:8px">
                    @if($item->persyaratan_array)
                    @foreach($item->persyaratan_array as $j => $syarat)
                    {{ ($j+1) }}. {{ $syarat }}<br>
                    @endforeach
                    @else - @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; padding:16px; color:#9ca3af">Belum ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-left">
            <p>Digenerate otomatis · Sistem Lumbung Data &copy; {{ date('Y') }}</p>
        </div>
        <div class="ttd">
            <p>{{ now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Desa</p>
            <div class="gap"></div>
            <p class="nama">( ________________________________ )</p>
        </div>
    </div>

</body>

</html>