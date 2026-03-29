<!-- penduduk-cetak.blade.php - OpenSID style -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Penduduk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 11px; background: #d1d5db; color: #000; }

        /* Toolbar */
        #toolbar {
            position: fixed; top: 12px; left: 50%; transform: translateX(-50%);
            z-index: 9999; display: flex; gap: 10px;
            background: rgba(255,255,255,.95); padding: 8px 16px;
            border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,.2);
        }
        #toolbar button {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 6px; padding: 5px 14px; border: 1px solid #ccc;
            border-radius: 4px; cursor: pointer; font-size: 12px;
            background: #f9f9f9; color: #333;
        }
        .btn-cetak { background: #fff; border-color: #aaa; }
        .btn-cetak:hover { background: #f0f0f0; }
        .btn-tutup { background: #fff; border-color: #aaa; }
        .btn-tutup:hover { background: #f0f0f0; }

        /* Halaman */
        #halaman {
            width: 277mm; background: #fff;
            margin: 68px auto 32px; padding: 10mm 10mm 12mm;
            box-shadow: 0 2px 12px rgba(0,0,0,.15);
        }

        /* Kop */
        .kop { text-align: center; margin-bottom: 6px; }
        .kop-desa { font-size: 11px; margin-bottom: 3px; }
        .kop-judul { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
        .garis { border: none; border-top: 2px solid #000; margin: 4px 0 6px; }
        .garis-bawah { border: none; border-top: 1px solid #000; margin: 0; }

        /* Filter */
        .filter-row { font-size: 9.5px; color: #444; margin-bottom: 5px; }
        .fbadge { background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 3px; padding: 1px 5px; font-size: 9px; }

        /* Tabel - OpenSID style */
        .wrap-tabel { overflow: hidden; }
        table {
            width: 100%; border-collapse: collapse;
            font-size: 8px; table-layout: fixed;
        }

        col.c-no     { width: 14px; }
        col.c-kk     { width: 60px; }
        col.c-nik    { width: 60px; }
        col.c-tag    { width: 26px; }
        col.c-nama   { width: 64px; }
        col.c-alamat { width: 70px; }
        col.c-dusun  { width: 44px; }
        col.c-rw     { width: 13px; }
        col.c-rt     { width: 13px; }
        col.c-jk     { width: 36px; }
        col.c-tl     { width: 42px; }
        col.c-tgl    { width: 36px; }
        col.c-umur   { width: 16px; }
        col.c-agama  { width: 28px; }
        col.c-pddk   { width: 52px; }
        col.c-kerja  { width: 52px; }
        col.c-kawin  { width: 48px; }
        col.c-shdk   { width: 40px; }
        col.c-ayah   { width: 50px; }
        col.c-ibu    { width: 50px; }
        col.c-status { width: 30px; }

        /* Header OpenSID: putih, tebal, border hitam */
        thead th {
            background: #fff;
            color: #000;
            font-weight: 700;
            text-align: center;
            padding: 4px 2px;
            border: 1px solid #000;
            font-size: 7.5px;
            text-transform: uppercase;
            line-height: 1.3;
            white-space: normal;
            word-break: break-word;
            vertical-align: middle;
        }

        /* Body: border hitam tipis, padding lebih lega */
        tbody td {
            padding: 3px 2px;
            border: 1px solid #000;
            vertical-align: middle;
            white-space: normal;
            word-break: break-word;
            line-height: 1.3;
        }
        tbody tr:nth-child(even) td { background: #f5f5f5; }
        td.tc { text-align: center; }
        td.mono { font-family: 'Courier New', monospace; font-size: 7px; }

        /* Status: teks biasa seperti OpenSID */
        .st-hidup  { color: #166534; }
        .st-mati   { color: #374151; }
        .st-pindah { color: #1e40af; }
        .st-hilang { color: #9a3412; }

        /* Footer */
        .footer { margin-top: 8px; font-size: 10px; }
        .footer-left { line-height: 1.8; }

        /* Print time */
        .print-time {
            font-size: 10px; color: #666; margin-bottom: 4px;
            display: none;
        }

        /* PRINT */
        @media print {
            @page { size: A4 landscape; margin: 6mm 6mm 8mm; }
            html, body { background: #fff !important; }
            #toolbar { display: none !important; }
            #halaman {
                width: 100% !important; margin: 0 !important;
                padding: 0 !important; box-shadow: none !important;
            }
            .wrap-tabel { overflow: hidden !important; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .print-time { display: block !important; }
        }
    </style>
</head>
<body>

<div id="toolbar">
    <button class="btn-cetak" onclick="window.print()" title="Cetak">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Cetak
    </button>
    <button class="btn-tutup" onclick="window.close()" title="Tutup">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        Tutup
    </button>
</div>

<div id="halaman">
    <div class="print-time">{{ now()->format('n/j/y, g:i A') }}</div>

    {{-- ── KOP ─────────────────────────────────────────────────────────────── --}}
    @php
        $namaDesa      = $desaConfig?->nama_desa
                      ?? $desaConfig?->desa
                      ?? $desaConfig?->nama
                      ?? '-';

        $namaKecamatan = $desaConfig?->nama_kecamatan
                      ?? $desaConfig?->kecamatan
                      ?? '-';

        $namaKabupaten = $desaConfig?->nama_kabupaten
                      ?? $desaConfig?->kabupaten
                      ?? $desaConfig?->nama_kabupaten_kota
                      ?? '-';
    @endphp

    <div class="kop">
        @if ($desaConfig)
            <div class="kop-desa">
                Desa : <strong>{{ $namaDesa }}</strong>
                &nbsp; Kec. : <strong>{{ $namaKecamatan }}</strong>
                &nbsp; Kab : <strong>{{ $namaKabupaten }}</strong>
            </div>
        @endif
        <div class="kop-judul">Data Penduduk</div>
    </div>
    <hr class="garis">

    {{-- ── FILTER BADGE ─────────────────────────────────────────────────────── --}}
    @php
        $fl = [];
        if (request('status')) {
            $sm = ['1' => 'Tetap', '2' => 'Tidak Tetap', '3' => 'Pendatang'];
            $fl[] = 'Status: ' . ($sm[request('status')] ?? request('status'));
        }
        if (request('status_dasar') && request('status_dasar') !== 'semua')
            $fl[] = 'Status Dasar: ' . ucfirst(request('status_dasar'));
        if (request('jenis_kelamin'))
            $fl[] = 'JK: ' . (request('jenis_kelamin') == 'L' ? 'Laki-laki' : 'Perempuan');
        if (request('dusun'))
            $fl[] = 'Dusun: ' . request('dusun');
        if (request('search'))
            $fl[] = 'Cari: "' . request('search') . '"';
    @endphp
    @if(count($fl))
        <div class="filter-row">
            <strong>Filter:</strong>
            @foreach($fl as $f)<span class="fbadge">{{ $f }}</span>&nbsp;@endforeach
        </div>
    @endif

    {{-- ── TABEL ────────────────────────────────────────────────────────────── --}}
    <div class="wrap-tabel">
    <table>
        <colgroup>
            <col class="c-no"><col class="c-kk"><col class="c-nik"><col class="c-tag">
            <col class="c-nama"><col class="c-alamat"><col class="c-dusun">
            <col class="c-rw"><col class="c-rt"><col class="c-jk">
            <col class="c-tl"><col class="c-tgl"><col class="c-umur"><col class="c-agama">
            <col class="c-pddk"><col class="c-kerja"><col class="c-kawin">
            <col class="c-shdk"><col class="c-ayah"><col class="c-ibu"><col class="c-status">
        </colgroup>
        <thead>
            <tr>
                <th>NO</th>
                <th>NO. KK</th>
                <th>NIK</th>
                <th>TAG ID CARD</th>
                <th>NAMA</th>
                <th>ALAMAT</th>
                <th>DUSUN</th>
                <th>RW</th>
                <th>RT</th>
                <th>JENIS KELAMIN</th>
                <th>TEMPAT LAHIR</th>
                <th>TGL LAHIR</th>
                <th>UMUR</th>
                <th>AGAMA</th>
                <th>PENDIDIKAN (KK)</th>
                <th>PEKERJAAN</th>
                <th>STATUS KAWIN</th>
                <th>SHDK</th>
                <th>NAMA AYAH</th>
                <th>NAMA IBU</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penduduk as $i => $p)
                @php
                    $kel  = $p->keluarga;
                    $wil  = $p->wilayah;
                    $noKk = $kel?->no_kk ?? '-';
                    $nik  = $p->nik ?? '-';
                    if ($sensorNik) {
                        $noKk = substr($noKk, 0, 4) . str_repeat('X', max(0, strlen($noKk) - 4));
                        $nik  = substr($nik,  0, 4) . str_repeat('X', max(0, strlen($nik)  - 4));
                    }
                    $sc = match($p->status_dasar ?? 'hidup') {
                        'hidup'  => 'st-hidup',
                        'mati'   => 'st-mati',
                        'pindah' => 'st-pindah',
                        'hilang' => 'st-hilang',
                        default  => 'st-mati',
                    };
                @endphp
                <tr>
                    <td class="tc">{{ $i + 1 }}</td>
                    <td class="mono">{{ $noKk }}</td>
                    <td class="mono">{{ $nik }}</td>
                    <td>{{ $p->tag_id_card ?? '-' }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->alamat ?? '-' }}</td>
                    <td>{{ $wil?->dusun ?? '-' }}</td>
                    <td class="tc">{{ $wil?->rw ?? '-' }}</td>
                    <td class="tc">{{ $wil?->rt ?? '-' }}</td>
                    <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                    <td>{{ $p->tempat_lahir ?? '-' }}</td>
                    <td class="tc">{{ $p->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                    <td class="tc">{{ $p->umur ?? '-' }}</td>
                    <td>{{ $p->agama?->nama ?? '-' }}</td>
                    <td>{{ $p->pendidikanKk?->nama ?? '-' }}</td>
                    <td>{{ $p->pekerjaan?->nama ?? '-' }}</td>
                    <td>{{ $p->statusKawin?->nama ?? '-' }}</td>
                    <td>{{ $p->shdk?->nama ?? '-' }}</td>
                    <td>{{ $p->nama_ayah ?? '-' }}</td>
                    <td>{{ $p->nama_ibu ?? '-' }}</td>
                    <td class="tc {{ $sc }}">{{ ucfirst($p->status_dasar ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="21" class="tc" style="padding:12px;color:#6b7280;font-style:italic;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    {{-- ── FOOTER ───────────────────────────────────────────────────────────── --}}
    <div class="footer">
        <div class="footer-left">
            <div>Tanggal cetak &nbsp;: &nbsp;<strong>{{ now()->translatedFormat('d F Y') }}</strong></div>
        </div>
    </div>

</div>
</body>
</html>