<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Status Desa</title>
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
            letter-spacing: 0.3px;
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
            margin-top: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9.5px;
        }

        thead tr {
            background-color: #059669;
            color: #fff;
        }

        thead th {
            padding: 7px 8px;
            font-weight: 700;
            text-align: center;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        thead th:first-child,
        thead th:nth-child(2) {
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background: #f0fdf4;
        }

        tbody td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 700;
        }

        .badge-Mandiri {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-Maju {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-Berkembang {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-Tertinggal {
            background: #ffedd5;
            color: #9a3412;
        }

        .badge-Sangat-Tertinggal {
            background: #fee2e2;
            color: #991b1b;
        }

        .mono {
            font-family: 'Courier New', monospace;
            font-size: 9px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
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
        <h2>Data Indeks Desa Membangun (IDM)</h2>
        <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;·&nbsp; Oleh: {{ auth()->user()->name }}</p>
    </div>

    <div class="doc-title">
        <h3>Laporan Status Desa (IDM)</h3>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="val">{{ $statusDesa->count() }}</div>
            <div class="lbl">Total Entri</div>
        </div>
        @if($statusDesa->first())
        <div class="summary-item">
            <div class="val">{{ $statusDesa->first()->tahun }}</div>
            <div class="lbl">Tahun Terbaru</div>
        </div>
        <div class="summary-item">
            <div class="val">{{ number_format($statusDesa->first()->nilai, 4) }}</div>
            <div class="lbl">Nilai IDM Terbaru</div>
        </div>
        <div class="summary-item">
            <div class="val" style="font-size:12px">{{ $statusDesa->first()->status ?? '-' }}</div>
            <div class="lbl">Status Terkini</div>
        </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">No</th>
                <th style="width:7%">Tahun</th>
                <th style="width:15%">Nama Status</th>
                <th style="width:9%">Nilai IDM</th>
                <th style="width:9%">IKS</th>
                <th style="width:9%">IKE</th>
                <th style="width:9%">IKL</th>
                <th style="width:12%">Status</th>
                <th style="width:12%">Target</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($statusDesa as $i => $item)
            @php $badgeClass = 'badge-' . str_replace(' ', '-', $item->status ?? ''); @endphp
            <tr>
                <td style="text-align:center">{{ $i + 1 }}</td>
                <td style="text-align:center; font-weight:700">{{ $item->tahun }}</td>
                <td>{{ $item->nama_status }}</td>
                <td style="text-align:center; font-weight:700; color:#059669" class="mono">{{
                    number_format($item->nilai, 4) }}</td>
                <td style="text-align:center" class="mono">{{ number_format($item->skor_ketahanan_sosial, 4) }}</td>
                <td style="text-align:center" class="mono">{{ number_format($item->skor_ketahanan_ekonomi, 4) }}</td>
                <td style="text-align:center" class="mono">{{ number_format($item->skor_ketahanan_ekologi, 4) }}</td>
                <td style="text-align:center">
                    @if($item->status)
                    <span class="badge {{ $badgeClass }}">{{ $item->status }}</span>
                    @else - @endif
                </td>
                <td style="text-align:center; font-size:8px">
                    @if($item->status_target)
                    <span class="badge">{{ $item->status_target }}</span>
                    @if($item->nilai_target) <br><span class="mono">{{ number_format($item->nilai_target, 4) }}</span>
                    @endif
                    @else - @endif
                </td>
                <td style="color:#4b5563; font-size:8px">{{ \Str::limit($item->keterangan, 60) ?: '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding:16px; color:#9ca3af">Belum ada data</td>
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