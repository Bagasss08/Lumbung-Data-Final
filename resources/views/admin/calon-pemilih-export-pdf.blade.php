<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Calon Pemilih</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 9px;
            color: #1f2937;
            background: #fff;
        }

        .doc-header {
            text-align: center;
            padding: 12px 0 10px;
            border-bottom: 2px solid #059669;
            margin-bottom: 12px;
        }

        .doc-header h1 {
            font-size: 14px;
            font-weight: 800;
            color: #064e3b;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .doc-header p {
            font-size: 8.5px;
            color: #6b7280;
            margin-top: 2px;
        }

        .stats {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }

        .stat-box {
            flex: 1;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 10px;
            text-align: center;
        }

        .stat-box .val {
            font-size: 16px;
            font-weight: 800;
            color: #059669;
        }

        .stat-box .lbl {
            font-size: 7.5px;
            color: #6b7280;
            margin-top: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        thead tr {
            background: #059669;
        }

        thead th {
            color: #fff;
            padding: 6px 5px;
            text-align: left;
            font-weight: 700;
            font-size: 8px;
            white-space: nowrap;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody td {
            padding: 5px 5px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 20px;
            font-size: 7.5px;
            font-weight: 600;
        }

        .badge-l {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-p {
            background: #fce7f3;
            color: #9d174d;
        }

        .badge-aktif {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-nonaktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .doc-footer {
            margin-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer-info {
            font-size: 7.5px;
            color: #9ca3af;
        }

        .ttd-box {
            text-align: center;
        }

        .ttd-box .ttd-title {
            font-size: 8px;
            font-weight: 600;
            color: #374151;
        }

        .ttd-box .ttd-space {
            height: 50px;
            border-bottom: 1px solid #374151;
            width: 150px;
            margin: 6px auto 4px;
        }

        .ttd-box .ttd-name {
            font-size: 8px;
            color: #374151;
            font-weight: 700;
        }

        .ttd-box .ttd-role {
            font-size: 7.5px;
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="doc-header">
        <h1>DAFTAR CALON PEMILIH</h1>
        <p>Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;|&nbsp; Total {{ number_format($stats['total']) }} calon pemilih</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="val">{{ number_format($stats['total']) }}</div>
            <div class="lbl">Total</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#2563eb">{{ number_format($stats['laki_laki']) }}</div>
            <div class="lbl">Laki-laki</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#db2777">{{ number_format($stats['perempuan']) }}</div>
            <div class="lbl">Perempuan</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#059669">{{ number_format($stats['aktif']) }}</div>
            <div class="lbl">Aktif</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th style="width:110px">NIK</th>
                <th>Nama</th>
                <th style="width:20px">JK</th>
                <th>Tempat/Tgl Lahir</th>
                <th>Alamat</th>
                <th style="width:50px">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($calonPemilih as $i => $cp)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:monospace; font-size:7.5px">{{ $cp->nik ?? '-' }}</td>
                <td><strong>{{ $cp->nama ?? '-' }}</strong></td>
                <td>
                    @if($cp->jenis_kelamin == 1)
                    <span class="badge badge-l">L</span>
                    @elseif($cp->jenis_kelamin == 2)
                    <span class="badge badge-p">P</span>
                    @else
                    -
                    @endif
                </td>
                <td>
                    {{ $cp->tempat_lahir ?? '-' }}
                    @if($cp->tanggal_lahir)
                    / {{ $cp->tanggal_lahir->format('d/m/Y') }}
                    @endif
                </td>
                <td>{{ $cp->alamat ?? '-' }}</td>
                <td>
                    @if($cp->aktif)
                    <span class="badge badge-aktif">Aktif</span>
                    @else
                    <span class="badge badge-nonaktif">Nonaktif</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px; color:#6b7280">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="doc-footer">
        <div class="footer-info">
            <p>Dokumen ini dicetak secara otomatis oleh sistem.</p>
            <p>Tanggal cetak: {{ now()->translatedFormat('d F Y') }}</p>
        </div>
        <div class="ttd-box">
            <p class="ttd-title">Kepala Desa / Kelurahan</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">( _________________________ )</p>
            <p class="ttd-role">NIP. ______________________</p>
        </div>
    </div>

</body>

</html>
