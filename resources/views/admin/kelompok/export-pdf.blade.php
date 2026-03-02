<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Anggota {{ $kelompok->nama }}</title>
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
            font-size: 13px;
            font-weight: 800;
            color: #064e3b;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .doc-header h2 {
            font-size: 11px;
            font-weight: 700;
            color: #059669;
            margin-top: 2px;
        }

        .doc-header p {
            font-size: 8px;
            color: #6b7280;
            margin-top: 3px;
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
        <h1>DAFTAR ANGGOTA</h1>
        <h2>{{ strtoupper($kelompok->nama) }}</h2>
        <p>
            Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
            &nbsp;|&nbsp;
            Total {{ number_format($anggota->count()) }} anggota
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th style="width:110px">NIK</th>
                <th>Nama</th>
                <th style="width:20px">JK</th>
                <th>Jabatan</th>
                <th style="width:80px">Tgl Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggota as $i => $a)
            @php $p = $a->penduduk; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:monospace; font-size:7.5px">{{ $a->nik ?? '-' }}</td>
                <td><strong>{{ $p?->nama ?? '-' }}</strong></td>
                <td>
                    @if($p?->jenis_kelamin)
                    <span class="badge {{ $p->jenis_kelamin === 'L' ? 'badge-l' : 'badge-p' }}">
                        {{ $p->jenis_kelamin }}
                    </span>
                    @else
                    -
                    @endif
                </td>
                <td>{{ $a->jabatan ?? '-' }}</td>
                <td>{{ optional($a->tgl_masuk)->format('d/m/Y') ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:20px; color:#6b7280">Tidak ada data anggota</td>
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
