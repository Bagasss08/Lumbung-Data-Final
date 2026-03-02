<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Terdata {{ $suplemen->nama }}</title>
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

        .sasaran-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8px;
            font-weight: 600;
        }

        .sasaran-1 {
            background: #d1fae5;
            color: #065f46;
        }

        .sasaran-2 {
            background: #dbeafe;
            color: #1e40af;
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
        <h1>Daftar Terdata Suplemen</h1>
        <h2>{{ strtoupper($suplemen->nama) }}</h2>
        <p>
            Sasaran: <span class="sasaran-badge sasaran-{{ $suplemen->sasaran }}">{{ $suplemen->sasaran_label }}</span>
            &nbsp;|&nbsp;
            Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
            &nbsp;|&nbsp;
            Total {{ number_format($stats['total']) }} terdata
        </p>
    </div>

    {{-- Stats hanya untuk sasaran perorangan (ada data JK) --}}
    @if($suplemen->sasaran == '1')
    <div class="stats">
        <div class="stat-box">
            <div class="val">{{ number_format($stats['total']) }}</div>
            <div class="lbl">Total Terdata</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#2563eb">{{ number_format($stats['laki_laki']) }}</div>
            <div class="lbl">Laki-laki</div>
        </div>
        <div class="stat-box">
            <div class="val" style="color:#db2777">{{ number_format($stats['perempuan']) }}</div>
            <div class="lbl">Perempuan</div>
        </div>
        @if($suplemen->tgl_mulai)
        <div class="stat-box">
            <div class="val" style="font-size:11px; color:#374151">{{ $suplemen->tgl_mulai->format('d/m/Y') }}</div>
            <div class="lbl">Tgl Mulai</div>
        </div>
        @endif
        @if($suplemen->tgl_selesai)
        <div class="stat-box">
            <div class="val" style="font-size:11px; color:#374151">{{ $suplemen->tgl_selesai->format('d/m/Y') }}</div>
            <div class="lbl">Tgl Selesai</div>
        </div>
        @endif
    </div>
    @endif

    {{-- Tabel Perorangan --}}
    @if($suplemen->sasaran == '1')
    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th style="width:110px">NIK</th>
                <th>Nama Lengkap</th>
                <th style="width:20px">JK</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Alamat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terdata as $i => $t)
            @php $p = $t->penduduk; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:monospace; font-size:7.5px">{{ $t->id_pend ?? '-' }}</td>
                <td><strong>{{ $p?->nama ?? '-' }}</strong></td>
                <td>
                    @if($p?->jenis_kelamin)
                    <span class="badge {{ $p->jenis_kelamin === 'L' ? 'badge-l' : 'badge-p' }}">
                        {{ $p->jenis_kelamin }}
                    </span>
                    @else -
                    @endif
                </td>
                <td>{{ $p?->tempat_lahir ?? '-' }},<br>{{ optional($p?->tanggal_lahir)->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $p?->alamat ?? '-' }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#6b7280">Tidak ada data terdata</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tabel Keluarga --}}
    @else
    <table>
        <thead>
            <tr>
                <th style="width:25px">No</th>
                <th style="width:120px">No. KK</th>
                <th>Kepala Keluarga</th>
                <th>Alamat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terdata as $i => $t)
            @php $kk = $t->keluarga; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:monospace; font-size:7.5px">{{ $t->no_kk ?? '-' }}</td>
                <td><strong>{{ $kk?->kepala_keluarga ?? '-' }}</strong></td>
                <td>{{ $kk?->alamat ?? '-' }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; padding:20px; color:#6b7280">Tidak ada data terdata</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endif

    <div class="doc-footer">
        <div class="footer-info">
            <p>Dokumen ini dicetak secara otomatis oleh sistem.</p>
            <p>Tanggal cetak: {{ now()->translatedFormat('d F Y') }}</p>
            @if($suplemen->keterangan)
            <p style="margin-top:3px">Keterangan suplemen: {{ $suplemen->keterangan }}</p>
            @endif
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