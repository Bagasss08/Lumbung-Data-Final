@extends('layouts.admin')

@section('title', 'Kartu Rumah Tangga')

@section('content')

    <style>
        /* ── Print reset ── */
        @media print {
            body * {
                visibility: hidden !important;
            }

            #rt-print-area,
            #rt-print-area * {
                visibility: visible !important;
            }

            #rt-print-area {
                position: fixed !important;
                inset: 0 !important;
                width: 100% !important;
                padding: 10mm 12mm !important;
                background: #fff !important;
            }

            .no-print {
                display: none !important;
            }

            .rt-doc {
                box-shadow: none !important;
                border: 1px solid #000 !important;
                page-break-after: always;
            }

            .rt-doc:last-child {
                page-break-after: avoid;
            }
        }

        /* ── RT document shell ── */
        .rt-doc {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #111;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, .08);
            margin-bottom: 40px;
        }

        /* ── RT header banner ── */
        .rt-header {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);
            color: #fff;
            padding: 14px 20px 12px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 14px;
            border-bottom: 3px solid #059669;
        }

        .rt-header-logo {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .rt-header-logo svg {
            width: 28px;
            height: 28px;
            opacity: .9;
        }

        .rt-header-center {
            text-align: center;
        }

        .rt-header-center h1 {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin: 0 0 2px;
        }

        .rt-header-center p {
            font-size: 11px;
            letter-spacing: .06em;
            margin: 0;
            opacity: .85;
        }

        .rt-header-center .rt-no {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .16em;
            margin-top: 4px;
            font-family: 'Courier New', monospace;
        }

        .rt-header-right {
            text-align: right;
            font-size: 10px;
            opacity: .8;
            line-height: 1.6;
        }

        /* ── Info grid ── */
        .rt-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-bottom: 1.5px solid #374151;
        }

        .rt-info-col {
            padding: 10px 16px;
        }

        .rt-info-col:first-child {
            border-right: 1px solid #d1d5db;
        }

        .rt-info-row {
            display: grid;
            grid-template-columns: 140px 10px 1fr;
            gap: 2px;
            margin-bottom: 4px;
            align-items: baseline;
            font-size: 11px;
        }

        .rt-info-row .label {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: .04em;
            color: #374151;
        }

        .rt-info-row .sep {
            color: #6b7280;
        }

        .rt-info-row .value {
            color: #111;
        }

        .rt-info-row .value.mono {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            letter-spacing: .04em;
        }

        /* ── Section title bar ── */
        .rt-section-title {
            background: #f3f4f6;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            padding: 5px 16px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rt-section-title .pill {
            background: #064e3b;
            color: #fff;
            font-size: 9px;
            padding: 1px 8px;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: .04em;
        }

        /* ── KK sub-section ── */
        .kk-subheader {
            background: #ecfdf5;
            border-top: 1px solid #a7f3d0;
            border-bottom: 1px solid #a7f3d0;
            padding: 4px 16px;
            font-size: 10.5px;
            font-weight: 700;
            color: #065f46;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
        }

        .kk-subheader .kk-no {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            letter-spacing: .06em;
        }

        /* ── Tables ── */
        .rt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .rt-table th {
            background: #064e3b;
            color: #fff;
            font-weight: 700;
            font-size: 9.5px;
            text-align: center;
            padding: 5px 6px;
            border: 1px solid #059669;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .rt-table td {
            padding: 4px 6px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            color: #111;
        }

        .rt-table tbody tr:nth-child(even) td {
            background: #f0fdf4;
        }

        .rt-table tbody tr:hover td {
            background: #dcfce7;
        }

        .rt-table td.no {
            text-align: center;
            font-weight: 700;
            width: 24px;
            color: #064e3b;
        }

        .rt-table td.nik {
            font-family: 'Courier New', monospace;
            font-size: 9.5px;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        .rt-table td.nama {
            font-weight: 600;
            color: #064e3b;
        }

        .rt-table td.center {
            text-align: center;
        }

        /* ── Badges ── */
        .badge-kepala-rt {
            display: inline-block;
            padding: 1px 6px;
            background: #b45309;
            color: #fff;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .badge-kepala-kk {
            display: inline-block;
            padding: 1px 6px;
            background: #064e3b;
            color: #fff;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .badge-program {
            display: inline-block;
            padding: 1px 8px;
            background: #0891b2;
            color: #fff;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* ── Footer ── */
        .rt-footer {
            padding: 16px 20px 20px;
            border-top: 1.5px solid #374151;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .rt-sign-box {
            text-align: center;
            font-size: 11px;
        }

        .rt-sign-box .sign-title {
            font-weight: 700;
            margin-bottom: 52px;
            font-size: 10.5px;
            text-transform: uppercase;
        }

        .rt-sign-box .sign-name {
            font-weight: 800;
            font-size: 11.5px;
            border-top: 1px solid #374151;
            padding-top: 4px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .rt-sign-box .sign-sub {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #4b5563;
        }

        .rt-sign-right {
            text-align: right;
        }

        .rt-sign-right .sign-place {
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 4px;
        }

        /* ── Watermark ── */
        .rt-watermark {
            position: relative;
        }

        .rt-watermark::before {
            content: 'RESMI';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 90px;
            font-weight: 900;
            color: rgba(5, 150, 105, .05);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            letter-spacing: .3em;
        }

        .rt-watermark > * {
            position: relative;
            z-index: 1;
        }

        /* ── Stat pills ── */
        .stat-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            padding: 8px 16px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 700;
            color: #064e3b;
        }

        /* ── Summary table ── */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }

        .summary-table th {
            background: #047857;
            color: #fff;
            font-weight: 700;
            font-size: 10px;
            text-align: center;
            padding: 5px 8px;
            border: 1px solid #059669;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .summary-table td {
            padding: 4px 8px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
        }

        .summary-table tbody tr:nth-child(even) td {
            background: #f0fdf4;
        }

        .summary-table td.no {
            text-align: center;
            font-weight: 700;
            color: #064e3b;
        }

        .summary-table td.mono {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            letter-spacing: .04em;
        }

        .summary-table td.bold {
            font-weight: 700;
            color: #064e3b;
        }

        .summary-table td.center {
            text-align: center;
        }
    </style>

    @php
        $identitas = \App\Models\IdentitasDesa::first();
        $kepalaDesaPerangkat = \App\Models\PerangkatDesa::with('jabatan')
            ->aktif()
            ->whereHas('jabatan', fn($q) => $q->where('nama', 'like', '%kepala desa%'))
            ->first();

        $shdkMap = [
            1 => 'Kepala Keluarga',
            2 => 'Suami / Istri',
            3 => 'Anak',
            4 => 'Menantu',
            5 => 'Cucu',
            6 => 'Orang Tua',
            7 => 'Mertua',
            8 => 'Famili Lain',
            9 => 'Pembantu',
            10 => 'Lainnya',
        ];
    @endphp

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-5 no-print">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Kartu Rumah Tangga</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                {{ $rumahTangga->count() }} rumah tangga ditemukan
            </p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.rumah-tangga.index') }}"
                class="text-gray-400 hover:text-emerald-600 transition-colors">Data Rumah Tangga</a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 font-medium">Kartu Rumah Tangga</span>
        </nav>
    </div>

    {{-- ── ACTION BUTTONS ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 mb-5 no-print">
        <div class="flex flex-wrap items-center gap-2 px-5 py-4">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak
            </button>
            <a href="{{ route('admin.rumah-tangga.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm group">
                <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>

            <div class="ml-auto flex items-center gap-3">
                <span class="stat-pill" style="font-size:12px; padding:4px 12px;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ $rumahTangga->count() }} Rumah Tangga
                </span>
                <span class="stat-pill" style="font-size:12px; padding:4px 12px;">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $rumahTangga->sum(fn($rt) => $rt->keluarga->sum(fn($kk) => $kk->anggota->count())) }} Anggota
                </span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         DOKUMEN KARTU RUMAH TANGGA (loop per RT)
    ════════════════════════════════════════════════════════ --}}
    <div id="rt-print-area" class="max-w-5xl mx-auto">

        @forelse($rumahTangga as $rt)
            @php
                $kepalaRt   = $rt->getKepalaRumahTangga();
                $totalKk    = $rt->keluarga->count();
                $totalAnggota = $rt->keluarga->sum(fn($kk) => $kk->anggota->count());
                $noUrut     = 0;
            @endphp

            <div class="rt-doc rt-watermark">

                {{-- ── HEADER ── --}}
                <div class="rt-header">
                    {{-- Ikon kiri --}}
                    <div class="rt-header-logo">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>

                    {{-- Judul tengah --}}
                    <div class="rt-header-center">
                        <h1>Kartu Rumah Tangga</h1>
                        <p>
                            {{ strtoupper($identitas?->nama_desa ?? 'Desa') }} —
                            Kec. {{ strtoupper($identitas?->kecamatan ?? '—') }}
                        </p>
                        <div class="rt-no">No. {{ $rt->no_rumah_tangga }}</div>
                    </div>

                    {{-- Info kanan --}}
                    <div class="rt-header-right">
                        <div>Dicetak: {{ now()->isoFormat('D MMM YYYY') }}</div>
                        <div>Pukul: {{ now()->format('H:i') }} WIB</div>
                        @if ($rt->tgl_terdaftar)
                            <div style="margin-top:4px;">
                                Terdaftar: {{ \Carbon\Carbon::parse($rt->tgl_terdaftar)->isoFormat('D MMM YYYY') }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ── STATISTIK RINGKAS ── --}}
                <div class="stat-row">
                    <span class="stat-pill">
                        🏠 {{ $totalKk }} Kartu Keluarga
                    </span>
                    <span class="stat-pill">
                        👥 {{ $totalAnggota }} Jiwa
                    </span>
                    @php
                        $laki   = $rt->keluarga->sum(fn($kk) => $kk->anggota->where('jenis_kelamin', 'L')->count());
                        $perempuan = $totalAnggota - $laki;
                    @endphp
                    <span class="stat-pill">♂ {{ $laki }} Laki-laki</span>
                    <span class="stat-pill">♀ {{ $perempuan }} Perempuan</span>
                    @if ($rt->jenis_bantuan_aktif)
                        <span class="badge-program">{{ $rt->jenis_bantuan_aktif }}</span>
                    @endif
                </div>

                {{-- ── INFO RUMAH TANGGA ── --}}
                <div class="rt-info">
                    {{-- Kolom Kiri --}}
                    <div class="rt-info-col">
                        <div class="rt-info-row">
                            <span class="label">No. Rumah Tangga</span>
                            <span class="sep">:</span>
                            <span class="value mono">{{ $rt->no_rumah_tangga }}</span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Kepala Rumah Tangga</span>
                            <span class="sep">:</span>
                            <span class="value" style="font-weight:700; color:#064e3b;">
                                {{ $kepalaRt ? strtoupper($kepalaRt->nama) : '—' }}
                            </span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">NIK Kepala RT</span>
                            <span class="sep">:</span>
                            <span class="value mono">{{ $kepalaRt?->nik ?? '—' }}</span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Alamat</span>
                            <span class="sep">:</span>
                            <span class="value">{{ $rt->alamat ?? '—' }}</span>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="rt-info-col">
                        <div class="rt-info-row">
                            <span class="label">RT / RW</span>
                            <span class="sep">:</span>
                            <span class="value">
                                {{ $rt->wilayah?->rt ?? '—' }} /
                                {{ $rt->wilayah?->rw ?? '—' }}
                            </span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Dusun</span>
                            <span class="sep">:</span>
                            <span class="value">{{ strtoupper($rt->wilayah?->dusun ?? '—') }}</span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Desa / Kelurahan</span>
                            <span class="sep">:</span>
                            <span class="value">{{ strtoupper($identitas?->nama_desa ?? '—') }}</span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Kecamatan</span>
                            <span class="sep">:</span>
                            <span class="value">{{ strtoupper($identitas?->kecamatan ?? '—') }}</span>
                        </div>
                        <div class="rt-info-row">
                            <span class="label">Kabupaten / Kota</span>
                            <span class="sep">:</span>
                            <span class="value">{{ strtoupper($identitas?->kabupaten ?? '—') }}</span>
                        </div>
                        @if ($rt->bdt)
                            <div class="rt-info-row">
                                <span class="label">BDT</span>
                                <span class="sep">:</span>
                                <span class="value mono">{{ $rt->bdt }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ── REKAPITULASI KK ── --}}
                <div class="rt-section-title">
                    Rekapitulasi Kartu Keluarga
                    <span class="pill">{{ $totalKk }} KK</span>
                </div>
                <div style="overflow-x:auto;">
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th style="width:28px;">No</th>
                                <th>No. KK</th>
                                <th>Kepala Keluarga</th>
                                <th>NIK Kepala KK</th>
                                <th style="width:36px; text-align:center;">Jml Anggota</th>
                                <th>Alamat / Wilayah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rt->keluarga->sortBy('no_kk') as $kkIdx => $kk)
                                <tr>
                                    <td class="no">{{ $kkIdx + 1 }}</td>
                                    <td class="mono">{{ $kk->no_kk }}</td>
                                    <td class="bold">{{ strtoupper($kk->kepalaKeluarga?->nama ?? '—') }}</td>
                                    <td class="mono">{{ $kk->kepalaKeluarga?->nik ?? '—' }}</td>
                                    <td class="center" style="font-weight:700; color:#065f46;">
                                        {{ $kk->anggota->count() }}
                                    </td>
                                    <td>
                                        @if ($kk->wilayah)
                                            RT {{ $kk->wilayah->rt ?? '—' }} / RW {{ $kk->wilayah->rw ?? '—' }}
                                            — Dusun {{ $kk->wilayah->dusun ?? '—' }}
                                        @elseif ($kk->alamat)
                                            {{ $kk->alamat }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ── DAFTAR ANGGOTA (semua KK, flat, dikelompokkan per KK) ── --}}
                <div class="rt-section-title" style="border-top: 1.5px solid #374151;">
                    Daftar Seluruh Anggota Rumah Tangga
                    <span class="pill">{{ $totalAnggota }} Jiwa</span>
                </div>

                @foreach ($rt->keluarga->sortBy('no_kk') as $kk)
                    {{-- Sub-header per KK --}}
                    <div class="kk-subheader">
                        <span>
                            Kartu Keluarga:
                            <span class="kk-no">{{ $kk->no_kk }}</span>
                            &mdash; {{ strtoupper($kk->kepalaKeluarga?->nama ?? 'Tanpa Kepala') }}
                        </span>
                        <span style="font-size:10px; color:#065f46; font-weight:600;">
                            {{ $kk->anggota->count() }} Jiwa
                        </span>
                    </div>

                    <div style="overflow-x:auto;">
                        <table class="rt-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>L/P</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Agama</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                    <th>Status Kawin</th>
                                    <th>Hubungan KK</th>
                                    <th>Hubungan RT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kk->anggota->sortBy('kk_level') as $anggota)
                                    @php
                                        $noUrut++;
                                        $isKepalaKk = $anggota->id === $kk->kepala_keluarga_id;
                                        $isKepalaRt = $kepalaRt && $anggota->id === $kepalaRt->id;
                                    @endphp
                                    <tr>
                                        <td class="no">{{ $noUrut }}</td>
                                        <td class="nama" style="min-width:130px;">
                                            {{ strtoupper($anggota->nama) }}
                                            @if ($isKepalaRt)
                                                <br><span class="badge-kepala-rt">Kepala RT</span>
                                            @endif
                                            @if ($isKepalaKk)
                                                <br><span class="badge-kepala-kk">Kepala KK</span>
                                            @endif
                                        </td>
                                        <td class="nik">{{ $anggota->nik ?? '—' }}</td>
                                        <td class="center">
                                            {{ $anggota->jenis_kelamin === 'L' ? 'L' : 'P' }}
                                        </td>
                                        <td style="white-space:nowrap;">
                                            {{ strtoupper($anggota->tempat_lahir ?? '—') }}
                                        </td>
                                        <td style="white-space:nowrap; text-align:center;">
                                            {{ $anggota->tanggal_lahir?->format('d-m-Y') ?? '—' }}
                                        </td>
                                        <td>{{ strtoupper($anggota->agama?->nama ?? '—') }}</td>
                                        <td style="white-space:nowrap;">
                                            {{ strtoupper($anggota->pendidikanKk?->nama ?? ($anggota->pendidikan?->nama ?? '—')) }}
                                        </td>
                                        <td>{{ strtoupper($anggota->pekerjaan?->nama ?? '—') }}</td>
                                        <td style="white-space:nowrap;">
                                            {{ strtoupper($anggota->statusKawin?->nama ?? '—') }}
                                        </td>
                                        <td style="white-space:nowrap;">
                                            {{ $shdkMap[$anggota->kk_level] ?? 'Lainnya' }}
                                        </td>
                                        <td style="white-space:nowrap; font-weight:{{ $isKepalaRt ? '700' : '400' }}; color:{{ $isKepalaRt ? '#b45309' : '#111' }};">
                                            {{ $isKepalaRt ? 'Kepala Rumah Tangga' : 'Anggota' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                {{-- ── REKAPITULASI STATISTIK ── --}}
                <div class="rt-section-title" style="border-top: 1.5px solid #374151;">
                    Rekapitulasi Statistik
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0; border-bottom:1px solid #d1d5db;">
                    @php
                        /* Agama */
                        $agamaStats = $rt->keluarga
                            ->flatMap(fn($kk) => $kk->anggota)
                            ->groupBy(fn($a) => $a->agama?->nama ?? 'Tidak Diketahui')
                            ->map->count()
                            ->sortDesc();

                        /* Status Kawin */
                        $kawinStats = $rt->keluarga
                            ->flatMap(fn($kk) => $kk->anggota)
                            ->groupBy(fn($a) => $a->statusKawin?->nama ?? 'Tidak Diketahui')
                            ->map->count()
                            ->sortDesc();
                    @endphp

                    {{-- Agama --}}
                    <div style="padding:10px 16px; border-right:1px solid #d1d5db;">
                        <p style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:#374151; margin-bottom:6px;">
                            Komposisi Agama
                        </p>
                        @foreach ($agamaStats as $namaAgama => $jumlah)
                            <div style="display:flex; justify-content:space-between; font-size:10.5px; margin-bottom:3px; padding-bottom:3px; border-bottom:1px dashed #e5e7eb;">
                                <span>{{ strtoupper($namaAgama) }}</span>
                                <span style="font-weight:700; color:#064e3b;">{{ $jumlah }} jiwa</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Status Kawin --}}
                    <div style="padding:10px 16px;">
                        <p style="font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:#374151; margin-bottom:6px;">
                            Status Perkawinan
                        </p>
                        @foreach ($kawinStats as $namaStatus => $jumlah)
                            <div style="display:flex; justify-content:space-between; font-size:10.5px; margin-bottom:3px; padding-bottom:3px; border-bottom:1px dashed #e5e7eb;">
                                <span>{{ strtoupper($namaStatus) }}</span>
                                <span style="font-weight:700; color:#064e3b;">{{ $jumlah }} jiwa</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ── FOOTER / TANDA TANGAN ── --}}
                <div class="rt-footer">

                    {{-- Kepala Rumah Tangga --}}
                    <div class="rt-sign-box">
                        <div class="sign-title">Kepala Rumah Tangga</div>
                        <div class="sign-name">
                            {{ strtoupper($kepalaRt?->nama ?? '—') }}
                        </div>
                        @if ($kepalaRt?->nik)
                            <div class="sign-sub">NIK: {{ $kepalaRt->nik }}</div>
                        @endif
                    </div>

                    {{-- Kepala Desa --}}
                    <div class="rt-sign-box rt-sign-right">
                        <div class="sign-place" style="font-size:11px;">
                            {{ $identitas?->nama_desa ?? '—' }},
                            {{ now()->isoFormat('D MMMM YYYY') }}
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
                <div style="background:#f9fafb; border-top:1px solid #e5e7eb; padding:7px 16px;">
                    <p style="font-size:9.5px; color:#6b7280; margin:0; text-align:center; letter-spacing:.02em;">
                        Dokumen ini dicetak secara elektronik dari Sistem Informasi Desa (SID) •
                        Dicetak pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} •
                        No. RT: <strong>{{ $rt->no_rumah_tangga }}</strong> •
                        Total {{ $totalKk }} KK | {{ $totalAnggota }} Jiwa
                    </p>
                </div>

            </div>{{-- /rt-doc --}}
        @empty
            <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p class="text-gray-400 text-sm">Tidak ada data rumah tangga yang ditemukan.</p>
                <a href="{{ route('admin.rumah-tangga.index') }}"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    Kembali ke Daftar
                </a>
            </div>
        @endforelse

    </div>{{-- /rt-print-area --}}

@endsection