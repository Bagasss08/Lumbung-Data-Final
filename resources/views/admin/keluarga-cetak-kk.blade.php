@extends('layouts.admin')

@section('title', 'Salinan Kartu Keluarga — ' . $keluarga->no_kk)

@section('content')

    {{-- CSS diletakkan langsung di sini agar pasti ter-render --}}
    <style>
        /* ── Print reset ── */
        @media print {
            body * {
                visibility: hidden !important;
            }

            #kk-print-area,
            #kk-print-area * {
                visibility: visible !important;
            }

            #kk-print-area {
                position: fixed !important;
                inset: 0 !important;
                width: 100% !important;
                padding: 12mm 14mm !important;
                background: #fff !important;
            }

            .no-print {
                display: none !important;
            }

            .kk-doc {
                box-shadow: none !important;
                border: 1px solid #000 !important;
            }
        }

        /* ── KK document shell ── */
        .kk-doc {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #111;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, .08);
        }

        /* ── KK header banner ── */
        .kk-header {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);
            color: #fff;
            padding: 14px 20px 10px;
            text-align: center;
            border-bottom: 3px solid #059669;
        }

        .kk-header h1 {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin: 0 0 2px;
        }

        .kk-header p {
            font-size: 12px;
            letter-spacing: .08em;
            margin: 0;
            opacity: .9;
        }

        .kk-header .kk-no {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .14em;
            margin-top: 4px;
            font-family: 'Courier New', monospace;
        }

        /* ── Address grid ── */
        .kk-address {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-bottom: 1.5px solid #374151;
        }

        .kk-address-col {
            padding: 10px 16px;
        }

        .kk-address-col:first-child {
            border-right: 1px solid #d1d5db;
        }

        .kk-address-row {
            display: grid;
            grid-template-columns: 130px 10px 1fr;
            gap: 2px;
            margin-bottom: 4px;
            align-items: baseline;
            font-size: 11px;
        }

        .kk-address-row .label {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: .04em;
            color: #374151;
        }

        .kk-address-row .sep {
            color: #6b7280;
        }

        .kk-address-row .value {
            color: #111;
        }

        /* ── Section title bar ── */
        .kk-section-title {
            background: #f3f4f6;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            padding: 5px 16px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #374151;
        }

        /* ── Tables ── */
        .kk-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        .kk-table th {
            background: #064e3b;
            color: #fff;
            font-weight: 700;
            font-size: 10px;
            text-align: center;
            padding: 5px 6px;
            border: 1px solid #059669;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .kk-table td {
            padding: 5px 7px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            color: #111;
        }

        .kk-table tbody tr:nth-child(even) td {
            background: #f0fdf4;
        }

        .kk-table tbody tr:hover td {
            background: #dcfce7;
        }

        .kk-table td.no {
            text-align: center;
            font-weight: 700;
            width: 28px;
            color: #064e3b;
        }

        .kk-table td.nik {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            letter-spacing: .04em;
        }

        .kk-table td.nama {
            font-weight: 600;
            color: #064e3b;
        }

        /* ── Footer signature ── */
        .kk-footer {
            padding: 16px 20px 20px;
            border-top: 1.5px solid #374151;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .kk-sign-box {
            text-align: center;
            font-size: 11px;
        }

        .kk-sign-box .sign-title {
            font-weight: 700;
            margin-bottom: 52px;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .kk-sign-box .sign-name {
            font-weight: 800;
            font-size: 11.5px;
            border-top: 1px solid #374151;
            padding-top: 4px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .kk-sign-box .sign-nik {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #4b5563;
        }

        .kk-sign-right {
            text-align: right;
        }

        .kk-sign-right .sign-place {
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 4px;
        }

        /* ── Watermark ── */
        .kk-watermark {
            position: relative;
        }

        .kk-watermark::before {
            content: 'SALINAN';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            font-weight: 900;
            color: rgba(5, 150, 105, .06);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            letter-spacing: .2em;
        }

        .kk-watermark > * {
            position: relative;
            z-index: 1;
        }

        /* ── Badge hubungan ── */
        .badge-kepala {
            display: inline-block;
            padding: 1px 6px;
            background: #064e3b;
            color: #fff;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* ── Stat pill ── */
        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            color: #064e3b;
        }
    </style>

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-5 no-print">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Salinan Kartu Keluarga</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5 font-mono">{{ $keluarga->no_kk }}</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.keluarga') }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">Data Keluarga</a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.keluarga.show', $keluarga) }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">Anggota Keluarga</a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Salinan KK</span>
        </nav>
    </div>

    {{-- ── ACTION BUTTONS ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 mb-5 no-print">
        <div class="flex flex-wrap items-center gap-2 px-5 py-4">

            {{-- Tambah Anggota --}}
            <a href="{{ route('admin.keluarga.show', $keluarga) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Tambah Anggota
            </a>

            {{-- Cetak --}}
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak
            </button>

            {{-- Unduh --}}
            <a href="{{ route('admin.keluarga.cetak-kk', $keluarga) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh
            </a>

            {{-- Kembali ke Daftar Anggota Keluarga --}}
            <a href="{{ route('admin.keluarga.show', $keluarga) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-all shadow-sm group">
                <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Anggota Keluarga
            </a>

            {{-- Stats pill --}}
            <div class="ml-auto flex items-center gap-3">
                <span class="stat-pill">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $keluarga->anggota->count() }} Anggota
                </span>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         DOKUMEN KARTU KELUARGA
    ════════════════════════════════════════════════ --}}
    <div id="kk-print-area" class="max-w-5xl mx-auto">
        <div class="kk-doc kk-watermark">

            {{-- ── HEADER ── --}}
            <div class="kk-header">
                <h1>Salinan Kartu Keluarga</h1>
                <div class="kk-no">No. {{ $keluarga->no_kk }}</div>
            </div>

            {{-- ── ALAMAT ── --}}
            <div class="kk-address">
                {{-- Kolom Kiri --}}
                <div class="kk-address-col">
                    <div class="kk-address-row">
                        <span class="label">Alamat</span>
                        <span class="sep">:</span>
                        <span class="value">{{ $keluarga->alamat ?? '—' }}</span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">RT / RW</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ $keluarga->wilayah->rt ?? '—' }} /
                            {{ $keluarga->wilayah->rw ?? '—' }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Desa / Kelurahan</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ strtoupper($identitas?->nama_desa ?? '—') }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Kecamatan</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ strtoupper($identitas?->kecamatan ?? '—') }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Dusun</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ strtoupper($keluarga->wilayah->dusun ?? '—') }}
                        </span>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="kk-address-col">
                    <div class="kk-address-row">
                        <span class="label">Kabupaten / Kota</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ strtoupper($identitas?->kabupaten ?? '—') }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Kode Pos</span>
                        <span class="sep">:</span>
                        <span class="value">{{ $identitas?->kode_pos ?? '—' }}</span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Provinsi</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ strtoupper($identitas?->provinsi ?? '—') }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Tanggal Terdaftar</span>
                        <span class="sep">:</span>
                        <span class="value">
                            {{ $keluarga->tgl_terdaftar ? \Carbon\Carbon::parse($keluarga->tgl_terdaftar)->isoFormat('D MMMM YYYY') : '—' }}
                        </span>
                    </div>
                    <div class="kk-address-row">
                        <span class="label">Jumlah Anggota</span>
                        <span class="sep">:</span>
                        <span class="value" style="font-weight:700; color:#065f46;">{{ $keluarga->anggota->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- ── TABEL 1 : DATA UTAMA ANGGOTA ── --}}
            <div class="kk-section-title">Data Anggota Keluarga</div>
            <div style="overflow-x:auto;">
                <table class="kk-table">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Nama Lengkap</th>
                            <th rowspan="2">NIK</th>
                            <th rowspan="2">Jenis Kelamin</th>
                            <th rowspan="2">Tempat Lahir</th>
                            <th rowspan="2">Tanggal Lahir</th>
                            <th rowspan="2">Agama</th>
                            <th rowspan="2">Pendidikan</th>
                            <th rowspan="2">Jenis Pekerjaan</th>
                            <th rowspan="2">Golongan Darah</th>
                        </tr>
                        <tr></tr>
                    </thead>
                    <tbody>
                        @forelse($keluarga->anggota as $i => $anggota)
                            @php $isKepala = $anggota->id === $keluarga->kepala_keluarga_id; @endphp
                            <tr>
                                <td class="no">{{ $i + 1 }}</td>
                                <td class="nama" style="min-width:140px;">
                                    {{ strtoupper($anggota->nama) }}
                                    @if ($isKepala)
                                        <br><span class="badge-kepala">Kepala Keluarga</span>
                                    @endif
                                </td>
                                <td class="nik" style="white-space:nowrap;">{{ $anggota->nik ?? '—' }}</td>
                                <td style="text-align:center;">
                                    {{ $anggota->jenis_kelamin === 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                </td>
                                <td>{{ strtoupper($anggota->tempat_lahir ?? '—') }}</td>
                                <td style="white-space:nowrap;">
                                    {{ $anggota->tanggal_lahir?->format('d-m-Y') ?? '—' }}
                                </td>
                                <td>{{ strtoupper($anggota->agama->nama ?? '—') }}</td>
                                <td>{{ strtoupper($anggota->pendidikanKk->nama ?? ($anggota->pendidikan->nama ?? '—')) }}</td>
                                <td>{{ strtoupper($anggota->pekerjaan->nama ?? '—') }}</td>
                                <td style="text-align:center;">
                                    {{ strtoupper($anggota->golonganDarah->nama ?? 'TIDAK TAHU') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10"
                                    style="text-align:center; padding:20px; color:#6b7280; font-style:italic;">
                                    Belum ada anggota keluarga
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── TABEL 2 : DATA TAMBAHAN ANGGOTA ── --}}
            <div class="kk-section-title" style="margin-top:0; border-top:1.5px solid #374151;">
                Data Tambahan Anggota
            </div>
            <div style="overflow-x:auto;">
                <table class="kk-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status Perkawinan</th>
                            <th>Tanggal Perkawinan</th>
                            <th>Status Hub. Dlm Keluarga</th>
                            <th>Kewarganegaraan</th>
                            <th>No. Paspor</th>
                            <th>No. KITAS / KITAP</th>
                            <th>Nama Ayah</th>
                            <th>Nama Ibu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $shdkMap = [
                                1 => 'KEPALA KELUARGA',
                                2 => 'SUAMI / ISTRI',
                                3 => 'ANAK',
                                4 => 'MENANTU',
                                5 => 'CUCU',
                                6 => 'ORANG TUA',
                                7 => 'MERTUA',
                                8 => 'FAMILI LAIN',
                                9 => 'PEMBANTU',
                                10 => 'LAINNYA',
                            ];
                        @endphp
                        @forelse($keluarga->anggota as $i => $anggota)
                            <tr>
                                <td class="no">{{ $i + 1 }}</td>
                                <td>{{ strtoupper($anggota->statusKawin->nama ?? '—') }}</td>
                                <td style="white-space:nowrap; text-align:center;">
                                    {{ $anggota->tanggal_perkawinan ? \Carbon\Carbon::parse($anggota->tanggal_perkawinan)->format('d-m-Y') : '.' }}
                                </td>
                                <td>{{ $shdkMap[$anggota->kk_level] ?? 'LAINNYA' }}</td>
                                <td style="text-align:center;">
                                    {{ strtoupper($anggota->warganegara->nama ?? 'WNI') }}
                                </td>
                                <td style="text-align:center; font-family:'Courier New',monospace; font-size:10px;">
                                    {{ $anggota->dokumen_pasport ?: '—' }}
                                </td>
                                <td style="text-align:center; font-family:'Courier New',monospace; font-size:10px;">
                                    {{ $anggota->dokumen_kitas ?: '0' }}
                                </td>
                                <td>{{ strtoupper($anggota->nama_ayah ?? '—') }}</td>
                                <td>{{ strtoupper($anggota->nama_ibu ?? '—') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9"
                                    style="text-align:center; padding:20px; color:#6b7280; font-style:italic;">
                                    Belum ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── FOOTER / TANDA TANGAN ── --}}
            <div class="kk-footer">

                {{-- Kepala Keluarga --}}
                <div class="kk-sign-box">
                    <div class="sign-title">Kepala Keluarga</div>
                    <div class="sign-name">
                        {{ strtoupper($keluarga->kepalaKeluarga?->nama ?? '—') }}
                    </div>
                    @if ($keluarga->kepalaKeluarga?->nik)
                        <div class="sign-nik">NIK: {{ $keluarga->kepalaKeluarga->nik }}</div>
                    @endif
                </div>

                {{-- Kepala Desa --}}
                <div class="kk-sign-box kk-sign-right">
                    <div class="sign-place" style="font-size:11px;">
                        {{ $identitas?->nama_desa ?? '—' }},
                        @if ($keluarga->tgl_terdaftar)
                            {{ \Carbon\Carbon::parse($keluarga->tgl_terdaftar)->isoFormat('D MMMM YYYY') }}
                        @else
                            {{ now()->isoFormat('D MMMM YYYY') }}
                        @endif
                    </div>
                    <div class="sign-title">
                        {{ $kepalaDesaPerangkat?->jabatan?->nama ?? 'Kepala Desa' }}
                        {{ $identitas?->nama_desa ?? '' }}
                    </div>
                    <div class="sign-name">
                        {{ strtoupper($kepalaDesaPerangkat?->nama ?? ($identitas?->kepala_desa ?? '—')) }}
                    </div>
                </div>

            </div>

            {{-- ── CATATAN KAKI ── --}}
            <div style="background:#f9fafb; border-top:1px solid #e5e7eb; padding:8px 16px;">
                <p style="font-size:9.5px; color:#6b7280; margin:0; text-align:center; letter-spacing:.02em;">
                    Dokumen ini dicetak secara elektronik dari Sistem Informasi Desa (SID) •
                    Dicetak pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} •
                    KK Nomor: <strong>{{ $keluarga->no_kk }}</strong>
                </p>
            </div>

        </div>{{-- /kk-doc --}}
    </div>

@endsection