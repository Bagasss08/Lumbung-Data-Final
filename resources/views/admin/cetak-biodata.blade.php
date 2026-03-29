<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Biodata Penduduk – {{ $penduduk->nama }}</title>
    <style>
        /* ── Reset & Base ─────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            background: #6b7280;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0 40px;
        }

        /* ── Floating Action Bar ──────────────────────── */
        #action-bar {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 999;
            display: flex;
            gap: 8px;
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 8px 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.25);
            backdrop-filter: blur(8px);
        }

        #action-bar button {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-family: 'Segoe UI', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s ease;
        }

        #btn-print {
            background: #047857;
            color: #fff;
        }
        #btn-print:hover { background: #065f46; }

        #btn-close {
            background: #fee2e2;
            color: #b91c1c;
        }
        #btn-close:hover { background: #fecaca; }

        /* Cetak button pojok kanan (mirip OpenSID) */
        #btn-cetak-side {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: #b91c1c;
            color: #fff;
            border: none;
            padding: 14px 10px;
            font-size: 13px;
            font-family: 'Segoe UI', sans-serif;
            font-weight: 700;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            cursor: pointer;
            border-radius: 8px 0 0 8px;
            letter-spacing: 1px;
            box-shadow: -3px 0 12px rgba(0,0,0,.2);
            z-index: 999;
        }
        #btn-cetak-side:hover { background: #991b1b; }

        /* ── Paper Sheet ──────────────────────────────── */
        #paper {
            width: 210mm;
            min-height: 297mm;
            background: #fff;
            padding: 18mm 20mm 20mm;
            box-shadow: 0 8px 40px rgba(0,0,0,.35);
            position: relative;
        }

        /* ── Header ───────────────────────────────────── */
        .header-meta {
            display: flex;
            justify-content: space-between;
            font-size: 10pt;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .header-meta table td { padding: 0 4px 0 0; }
        .header-meta table td:nth-child(2) { padding-right: 6px; }

        .header-logo {
            text-align: center;
            margin: 10px 0 8px;
        }

        .header-logo img {
            height: 90px;
            width: auto;
        }

        .header-logo .logo-placeholder {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px;
            height: 90px;
            margin: 0 auto;
        }

        .header-title {
            text-align: center;
            margin-bottom: 2px;
        }

        .header-title h1 {
            font-size: 14pt;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .header-title p {
            font-size: 10pt;
            margin-top: 2px;
        }

        .divider-bold {
            border: none;
            border-top: 2.5px solid #000;
            margin: 10px 0 0;
        }

        .divider-thin {
            border: none;
            border-top: 1px solid #000;
            margin: 2px 0 14px;
        }

        /* ── Section Heading ──────────────────────────── */
        .section-title {
            font-size: 11pt;
            font-weight: 700;
            margin: 14px 0 6px;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        /* ── Data Table ───────────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            line-height: 1.7;
        }

        .data-table td {
            vertical-align: top;
            padding: 1px 0;
        }

        .data-table td.label {
            width: 46%;
            padding-right: 4px;
            color: #000;
        }

        .data-table td.colon {
            width: 4%;
            text-align: center;
        }

        .data-table td.value {
            width: 50%;
        }

        /* ── Signature ────────────────────────────────── */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 36px;
        }

        .signature-block {
            text-align: center;
            width: 44%;
            font-size: 10.5pt;
        }

        .signature-block .sig-space {
            height: 56px;
        }

        .signature-block .sig-name {
            font-weight: 700;
            border-top: 1px solid #000;
            padding-top: 4px;
            display: inline-block;
            min-width: 180px;
        }

        /* ── Print Rules ──────────────────────────────── */
        @media print {
            body {
                background: #fff;
                padding: 0;
                display: block;
            }

            #action-bar,
            #btn-cetak-side { display: none !important; }

            #paper {
                width: 100%;
                min-height: auto;
                padding: 12mm 18mm 18mm;
                box-shadow: none;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    {{-- ── Floating Action Bar ── --}}
    <div id="action-bar">
        <button id="btn-print" onclick="window.print()">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </button>
        <button id="btn-close" onclick="window.close()">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Tutup
        </button>
    </div>

    {{-- ── Cetak Side Button ── --}}
    <button id="btn-cetak-side" onclick="window.print()">Cetak</button>

    {{-- ── Paper ── --}}
    <div id="paper">

        {{-- Header Meta: NIK & No.KK --}}
        <div class="header-meta">
            <table>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><strong>{{ $penduduk->nik }}</strong></td>
                </tr>
                <tr>
                    <td>No.KK</td>
                    <td>:</td>
                    <td><strong>{{ $penduduk->keluarga?->no_kk ?? '-' }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Logo --}}
        <div class="header-logo">
            @if (!empty($logoSrc))
                <img src="{{ $logoSrc }}" alt="Logo Desa">
            @else
                {{-- SVG placeholder mirip OpenSID (orang-orangan bulat warna-warni) --}}
                <div class="logo-placeholder">
                    <svg width="90" height="90" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Orang 1 - Merah muda (atas) -->
                        <circle cx="100" cy="52" r="14" fill="#EC4899"/>
                        <ellipse cx="100" cy="76" rx="11" ry="16" fill="#EC4899"/>
                        <!-- Orang 2 - Hijau (kanan atas) -->
                        <circle cx="148" cy="76" r="14" fill="#22C55E"/>
                        <ellipse cx="148" cy="100" rx="11" ry="16" fill="#22C55E"/>
                        <!-- Orang 3 - Kuning (kanan bawah) -->
                        <circle cx="148" cy="124" r="14" fill="#EAB308"/>
                        <ellipse cx="148" cy="148" rx="11" ry="16" fill="#EAB308"/>
                        <!-- Orang 4 - Merah (bawah) -->
                        <circle cx="100" cy="148" r="14" fill="#EF4444"/>
                        <ellipse cx="100" cy="172" rx="11" ry="16" fill="#EF4444"/>
                        <!-- Orang 5 - Jingga (kiri bawah) -->
                        <circle cx="52" cy="124" r="14" fill="#F97316"/>
                        <ellipse cx="52" cy="148" rx="11" ry="16" fill="#F97316"/>
                        <!-- Orang 6 - Biru (kiri atas) -->
                        <circle cx="52" cy="76" r="14" fill="#3B82F6"/>
                        <ellipse cx="52" cy="100" rx="11" ry="16" fill="#3B82F6"/>
                        <!-- Tengah ungu -->
                        <polygon points="100,85 118,115 82,115" fill="#8B5CF6"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Judul --}}
        <div class="header-title">
            <h1>BIODATA PENDUDUK WARGA NEGARA INDONESIA</h1>
            <p>
{{ $desaConfig?->kabupaten ? 'Kab. ' . $desaConfig->kabupaten : '-' }}
Kec. {{ $desaConfig?->kecamatan ?? 'Kecamatan' }}, 
                Desa {{ $desaConfig?->nama_desa ?? 'Desa' }}
            </p>
        </div>

        <hr class="divider-bold">
        <hr class="divider-thin">

        {{-- ════ DATA PERSONAL ════ --}}
        <div class="section-title">Data Personal</div>

        @php
            $keluarga  = $penduduk->keluarga;
            $wilayah   = $penduduk->wilayah;
            $tglLahir  = $penduduk->tanggal_lahir
                            ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d-m-Y')
                            : '-';
        @endphp

        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat Lahir</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->tempat_lahir ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Lahir</td>
                <td class="colon">:</td>
                <td class="value">{{ $tglLahir }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : ($penduduk->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                </td>
            </tr>
            <tr>
                <td class="label">Akta Lahir</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_akta_lahir ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Agama</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->agama?->nama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Pendidikan Terakhir</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->pendidikanKk?->nama ?? $penduduk->pendidikan_lama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->pekerjaan?->nama ?? $penduduk->pekerjaan_lama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Pekerja Migran</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->is_pekerja_migran ? 'Ya' : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Golongan Darah</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->golonganDarah?->nama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Disabilitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->disabilitas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Kawin</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->statusKawin?->nama ?? $penduduk->status_kawin_lama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Hubungan dalam Keluarga</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->shdk?->nama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Warga Negara</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->warganegara?->nama ?? 'WNI') }}</td>
            </tr>
            <tr>
                <td class="label">Suku/Etnis</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->suku_etnis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NIK Ayah</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->nik_ayah ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama Ayah</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->nama_ayah ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">NIK Ibu</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->nik_ibu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Nama Ibu</td>
                <td class="colon">:</td>
                <td class="value">{{ strtoupper($penduduk->nama_ibu ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Status Kependudukan</td>
                <td class="colon">:</td>
                <td class="value">
                    @php
                        $statusMap = ['1' => 'TETAP', '2' => 'TIDAK TETAP', '3' => 'PENDATANG'];
                    @endphp
                    {{ $statusMap[$penduduk->status] ?? strtoupper($penduduk->status ?? '-') }}
                </td>
            </tr>
            <tr>
                <td class="label">Nomor Telepon/HP</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Email</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->email ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="colon">:</td>
                <td class="value">
                    @if($wilayah)
                        RT. {{ str_pad($wilayah->rt, 3, '0', STR_PAD_LEFT) }}
                        RW. {{ str_pad($wilayah->rw, 3, '0', STR_PAD_LEFT) }}
                        @if($wilayah->dusun) – Dusun {{ strtoupper($wilayah->dusun) }}@endif
                    @elseif($penduduk->alamat)
                        {{ $penduduk->alamat }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        {{-- ════ DATA KEPEMILIKAN DOKUMEN ════ --}}
        <div class="section-title" style="margin-top:18px;">Data Kepemilikan Dokumen</div>

        <table class="data-table">
            <tr>
                <td class="label">Nomor Kartu Keluarga (No.KK)</td>
                <td class="colon">:</td>
                <td class="value">{{ $keluarga?->no_kk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dokumen Paspor</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_paspor ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dokumen Kitas</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_kitas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Akta Perkawinan</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_akta_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Perkawinan</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $penduduk->tanggal_perkawinan
                        ? \Carbon\Carbon::parse($penduduk->tanggal_perkawinan)->translatedFormat('d-m-Y')
                        : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Akta Perceraian</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_akta_perceraian ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Perceraian</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $penduduk->tanggal_perceraian
                        ? \Carbon\Carbon::parse($penduduk->tanggal_perceraian)->translatedFormat('d-m-Y')
                        : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Nomor BPJS Ketenagakerjaan</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->no_bpjs_ketenagakerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Kepesertaan Asuransi Kesehatan</td>
                <td class="colon">:</td>
                <td class="value">{{ $penduduk->asuransi_kesehatan ?? '-' }}</td>
            </tr>
        </table>

        {{-- ════ TANDA TANGAN ════ --}}
        <div class="signature-section">
            <div class="signature-block">
                <p>Yang Bersangkutan</p>
                <div class="sig-space"></div>
                <span class="sig-name">( {{ $penduduk->nama }} )</span>
            </div>

            <div class="signature-block">
                <p>
                    {{ $desaConfig?->nama_desa ?? 'Desa' }},
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </p>
                <p>Kepala Desa {{ $desaConfig?->nama_desa ?? '' }}</p>
                <div class="sig-space"></div>
                <span class="sig-name">( {{ $desaConfig?->kepala_desa ?? '.....................' }} )</span>
            </div>
        </div>

    </div>{{-- /#paper --}}

</body>
</html>