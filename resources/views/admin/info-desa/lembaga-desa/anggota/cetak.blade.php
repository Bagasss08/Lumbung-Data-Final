<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota {{ $lembaga->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            background: #525659;
            min-height: 100vh;
            padding: 20px;
        }

        /* Tombol aksi icon-only */
        .btn-actions {
            text-align: center;
            margin-bottom: 12px;
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-actions button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            background: #fff;
            color: #333;
            padding: 0;
        }

        .btn-actions button:hover { background: #f0f0f0; }

        .btn-actions button svg {
            width: 18px;
            height: 18px;
        }

        /* Halaman A4 */
        .page {
            width: 297mm;       /* landscape A4 agar tabel lebar muat */
            min-height: 210mm;
            margin: 0 auto;
            padding: 12mm 15mm;
            background: #fff;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
        }

        /* Kop surat */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 14px;
            text-align: center;
        }

        .header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .header-text .instansi {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.6;
        }

        /* Judul */
        .judul {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        /* Info lembaga */
        .info-lembaga {
            margin-bottom: 14px;
            font-size: 11px;
        }

        .info-lembaga table {
            border: none;
            margin: 0;
        }

        .info-lembaga td {
            border: none;
            padding: 2px 4px;
            vertical-align: top;
        }

        .info-lembaga .label { width: 130px; }
        .info-lembaga .sep   { width: 12px; text-align: center; }

        /* Tabel utama */
        table.main {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        table.main th,
        table.main td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        table.main th {
            background: #f0f0f0;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            white-space: nowrap;
        }

        table.main td.center { text-align: center; }
        table.main td.nowrap { white-space: nowrap; }

        /* Tanda tangan */
        .ttd {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        .ttd-blok {
            text-align: center;
            width: 45%;
        }

        .ttd-blok .jabatan {
            font-size: 11px;
            margin-bottom: 60px;
            line-height: 1.6;
        }

        .ttd-blok .nama {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-blok .nip { font-size: 11px; }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .no-print { display: none; }
            .page {
                padding: 10mm 12mm;
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- Tombol aksi (hilang saat cetak) --}}
    <div class="no-print btn-actions">
        <button onclick="window.print()" title="Cetak">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
        </button>
        <button onclick="window.close()" title="Tutup">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="page">

        {{-- ── Kop Surat ── --}}
        @php
            $identitas = \App\Models\IdentitasDesa::first(); // sesuaikan dengan model identitas desa Anda

            $logoBase64 = null;
            if ($identitas && $identitas->logo_desa) {
                $logoPath = storage_path('app/public/logo-desa/' . $identitas->logo_desa);
                if (file_exists($logoPath)) {
                    $ext  = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
                    $mime = match($ext) {
                        'png'        => 'image/png',
                        'jpg','jpeg' => 'image/jpeg',
                        'gif'        => 'image/gif',
                        'svg'        => 'image/svg+xml',
                        'webp'       => 'image/webp',
                        default      => 'image/png',
                    };
                    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
                }
            }
        @endphp

        <div class="header">
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Logo Desa">
            @else
                <div style="width:70px;height:70px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;border:1px solid #d1d5db;border-radius:4px;margin-bottom:8px;">
                    <svg width="32" height="32" fill="none" stroke="#9ca3af" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
            @endif

            <div class="header-text">
                <div class="instansi">
                    PEMERINTAH KABUPATEN {{ strtoupper($identitas->kabupaten ?? '') }}<br>
                    KECAMATAN {{ strtoupper($identitas->kecamatan ?? '') }}<br>
                    DESA {{ strtoupper($identitas->nama_desa ?? '') }}
                </div>
                @if ($identitas && $identitas->alamat_kantor)
                    <div style="font-size:11px; margin-top:4px;">{{ $identitas->alamat_kantor }}</div>
                @endif
            </div>
        </div>

        {{-- ── Judul ── --}}
        <div class="judul">Daftar Anggota {{ $lembaga->nama }}</div>

        {{-- ── Info Lembaga ── --}}
        <div class="info-lembaga">
            <table>
                @php
                    $ketuaNama = '-';
                    if ($lembaga->ketua) {
                        $pos = strpos($lembaga->ketua, '-');
                        $ketuaNama = $pos !== false
                            ? str_replace('_', ' ', trim(substr($lembaga->ketua, $pos + 1)))
                            : str_replace('_', ' ', trim($lembaga->ketua));
                    }
                @endphp
                <tr>
                    <td class="label">Nama Lembaga</td>
                    <td class="sep">:</td>
                    <td>{{ $lembaga->nama }}</td>
                </tr>
                <tr>
                    <td class="label">Ketua Lembaga</td>
                    <td class="sep">:</td>
                    <td>{{ $ketuaNama }}</td>
                </tr>
                <tr>
                    <td class="label">Kategori Lembaga</td>
                    <td class="sep">:</td>
                    <td>{{ optional($lembaga->kategori)->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Keterangan</td>
                    <td class="sep">:</td>
                    <td>{{ $lembaga->deskripsi ?? '-' }}</td>
                </tr>
            </table>
        </div>

        {{-- ── Tabel Anggota ── --}}
        <table class="main">
            <thead>
                <tr>
                    <th rowspan="2" style="width:3%;">NO</th>
                    <th rowspan="2" style="width:5%;">NO.<br>ANGGOTA</th>
                    <th rowspan="2" style="width:13%;">NIK</th>
                    <th rowspan="2" style="width:12%;">NAMA<br>LENGKAP</th>
                    <th rowspan="2" style="width:6%;">JENIS<br>KELAMIN</th>
                    <th rowspan="2" style="width:10%;">TEMPAT /<br>TANGGAL LAHIR</th>
                    <th rowspan="2" style="width:6%;">AGAMA</th>
                    <th rowspan="2" style="width:8%;">JABATAN</th>
                    <th rowspan="2" style="width:10%;">PENDIDIKAN<br>TERAKHIR</th>
                    <th colspan="2" style="width:20%;">NOMOR DAN TANGGAL KEPUTUSAN</th>
                    <th rowspan="2" style="width:7%;">KET</th>
                </tr>
                <tr>
                    <th>PENGANGKATAN</th>
                    <th>PEMBERHENTIAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $index => $item)
                    @php
                        $p = $item->penduduk;
                    @endphp
                    <tr>
                        {{-- NO --}}
                        <td class="center">{{ $index + 1 }}</td>

                        {{-- NO. ANGGOTA --}}
                        <td class="center">{{ $item->no_anggota ?? $index + 1 }}</td>

                        {{-- NIK --}}
                        <td class="nowrap">{{ $p->nik ?? '-' }}</td>

                        {{-- NAMA --}}
                        <td>{{ $p->nama ?? '-' }}</td>

                        {{-- JENIS KELAMIN --}}
                        <td class="center">{{ $p->jenis_kelamin ?? '-' }}</td>

                        {{-- TEMPAT / TGL LAHIR --}}
                        <td class="center">
                            {{ $p->tempat_lahir ?? '-' }} /
                            {{ isset($p->tanggal_lahir)
                                ? \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d F Y')
                                : '-' }}
                        </td>

                        {{-- AGAMA --}}
                        <td class="center">{{ $p->agama ?? '-' }}</td>

                        {{-- JABATAN --}}
                        <td>{{ $item->jabatan ?? '-' }}</td>

                        {{-- PENDIDIKAN --}}
                        <td>{{ $p->pendidikan_terakhir ?? $p->pendidikan ?? '-' }}</td>

                        {{-- SK PENGANGKATAN --}}
                        <td>
                            {{ $item->no_sk_pengangkatan ?? '-' }} /
                            {{ isset($item->tgl_sk_pengangkatan)
                                ? \Carbon\Carbon::parse($item->tgl_sk_pengangkatan)->translatedFormat('d F Y')
                                : '-' }}
                        </td>

                        {{-- SK PEMBERHENTIAN --}}
                        <td>
                            {{ $item->no_sk_pemberhentian ?? '-' }} /
                            {{ isset($item->tgl_sk_pemberhentian)
                                ? \Carbon\Carbon::parse($item->tgl_sk_pemberhentian)->translatedFormat('d F Y')
                                : '-' }}
                        </td>

                        {{-- KETERANGAN --}}
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="center" style="padding:20px; color:#999;">
                            Tidak ada data anggota
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ── Tanda Tangan ── --}}
        <div class="ttd">

            {{-- Kiri: Mengetahui --}}
            <div class="ttd-blok">
                <div class="jabatan">
                    MENGETAHUI<br>
                    @if ($diketahui)
                        {{ strtoupper(optional($diketahui->jabatan)->nama ?? 'KEPALA DESA ' . ($identitas->nama_desa ?? '')) }}
                    @endif
                </div>
                @if ($diketahui)
                    <div class="nama">{{ $diketahui->nama }}</div>
                    @if (!empty($diketahui->nik))
                        <div class="nip">NIP : {{ $diketahui->nik }}</div>
                    @endif
                @endif
            </div>

            {{-- Kanan: Ditandatangani --}}
            <div class="ttd-blok">
                <div class="jabatan">
                    {{ strtoupper($identitas->nama_desa ?? '') }},
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    @if ($ditandatangani)
                        {{ strtoupper(optional($ditandatangani->jabatan)->nama ?? 'SEKRETARIS DESA ' . ($identitas->nama_desa ?? '')) }}
                    @endif
                </div>
                @if ($ditandatangani)
                    <div class="nama">{{ $ditandatangani->nama }}</div>
                    @if (!empty($ditandatangani->nik))
                        <div class="nip">NIP : {{ $ditandatangani->nik }}</div>
                    @endif
                @endif
            </div>

        </div>

    </div>
</body>

</html>