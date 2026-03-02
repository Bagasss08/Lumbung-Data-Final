<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Penduduk</title>
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

        /* Header */
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
        }

        .doc-header p {
            font-size: 8.5px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* Stats */
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

        /* Table */
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

        tbody tr:hover {
            background: #f0fdf4;
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

        /* Footer */
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
        <h1>DAFTAR DATA PENDUDUK</h1>
        <p>Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;|&nbsp; Total {{
            number_format($stats['total']) }} jiwa</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="val">{{ number_format($stats['total']) }}</div>
            <div class="lbl">Total Penduduk</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#2563eb">{{ number_format($stats['laki_laki']) }}</div>
            <div class="lbl">Laki-laki</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#db2777">{{ number_format($stats['perempuan']) }}</div>
            <div class="lbl">Perempuan</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Agama</th>
                <th>Pekerjaan</th>
                <th>Status Kawin</th>
                <th>Gol. Darah</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penduduk as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family: monospace; font-size:7.5px">{{ $p->nik }}</td>
                <td><strong>{{ $p->nama }}</strong></td>
                <td>
                    <span class="badge {{ $p->jenis_kelamin === 'L' ? 'badge-l' : 'badge-p' }}">
                        {{ $p->jenis_kelamin === 'L' ? 'L' : 'P' }}
                    </span>
                </td>
                <td>{{ $p->tempat_lahir }},<br>{{ optional($p->tanggal_lahir)->format('d/m/Y') }}</td>
                <td>{{ $p->agama ?? '-' }}</td>
                <td>{{ $p->pekerjaan ?? '-' }}</td>
                <td>{{ $p->status_kawin ?? '-' }}</td>
                <td style="text-align:center">{{ $p->golongan_darah ?? '-' }}</td>
                <td>{{ $p->alamat ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding: 20px; color:#6b7280">Tidak ada data</td>
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