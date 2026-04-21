@extends('layouts.admin')

@section('title', 'Salinan Kartu Keluarga ' . $keluarga->no_kk)

@section('content')

@php
    $shdkMap = [
        1  => 'KEPALA KELUARGA',
        2  => 'SUAMI/ISTRI',
        3  => 'ANAK',
        4  => 'MENANTU',
        5  => 'CUCU',
        6  => 'ORANG TUA',
        7  => 'MERTUA',
        8  => 'FAMILI LAIN',
        9  => 'PEMBANTU',
        10 => 'LAINNYA',
    ];

    $agamaMap = [
        1 => 'ISLAM',
        2 => 'KRISTEN',
        3 => 'KATOLIK',
        4 => 'HINDU',
        5 => 'BUDDHA',
        6 => 'KHONGHUCU',
    ];

    $pendidikanMap = [
        1  => 'TIDAK/BELUM SEKOLAH',
        2  => 'BELUM TAMAT SD/SEDERAJAT',
        3  => 'TAMAT SD/SEDERAJAT',
        4  => 'SLTP/SEDERAJAT',
        5  => 'SLTA/SEDERAJAT',
        6  => 'DIPLOMA I/II',
        7  => 'AKADEMI/DIPLOMA III/SARJANA MUDA',
        8  => 'DIPLOMA IV/STRATA I',
        9  => 'STRATA II',
        10 => 'STRATA III',
    ];

    $statusKawinMap = [
        1 => 'BELUM KAWIN',
        2 => 'KAWIN',
        3 => 'CERAI HIDUP',
        4 => 'CERAI MATI',
        5 => 'KAWIN BELUM TERCATAT',
    ];

    // Ambil data desa/setting jika tersedia
    $namaDesa     = $setting->nama_desa     ?? config('app.nama_desa',     '');
    $namaKecamatan= $setting->kecamatan     ?? config('app.kecamatan',     '');
    $namaKabupaten= $setting->kabupaten     ?? config('app.kabupaten',     '');
    $namaProvinsi = $setting->provinsi      ?? config('app.provinsi',      '');
    $kodePos      = $setting->kode_pos      ?? config('app.kode_pos',      '');
    $namaKepDesa  = $setting->nama_kepala_desa ?? config('app.nama_kepala_desa', '');
    $jabatanKepDesa = $setting->jabatan_kepala_desa ?? 'KEPALA DESA';

    // Fallback jika pakai helper setting()
    if (function_exists('setting')) {
        $namaDesa      = $namaDesa      ?: setting('nama_desa', '');
        $namaKecamatan = $namaKecamatan ?: setting('kecamatan', '');
        $namaKabupaten = $namaKabupaten ?: setting('kabupaten', '');
        $namaProvinsi  = $namaProvinsi  ?: setting('provinsi', '');
        $kodePos       = $kodePos       ?: setting('kode_pos', '');
        $namaKepDesa   = $namaKepDesa   ?: setting('nama_kepala_desa', '');
    }
@endphp

<style>
    @media print {
        .no-print { display: none !important; }
        .kk-wrapper { border: none !important; box-shadow: none !important; }
        body, html { background: white !important; }
        @page { margin: 1cm; size: A4 landscape; }
    }

    .kk-table { border-collapse: collapse; width: 100%; }
    .kk-table th, .kk-table td {
        border: 1px solid #374151;
        padding: 4px 6px;
        font-size: 10px;
        vertical-align: middle;
    }
    .kk-table thead th {
        background-color: #f3f4f6;
        font-weight: 700;
        text-align: center;
        font-size: 10px;
    }
    .kk-table td { text-align: left; }
    .kk-table td.center { text-align: center; }
</style>

{{-- ── PAGE HEADER ── --}}
<div class="flex items-center justify-between mb-5 no-print">
    <div>
        <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Salinan Kartu Keluarga</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5 font-mono">{{ $keluarga->no_kk }}</p>
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
        <a href="{{ route('admin.keluarga') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Data Keluarga</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.keluarga.show', $keluarga) }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Data Anggota Keluarga</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Kartu Keluarga</span>
    </nav>
</div>

{{-- ── TOMBOL AKSI ── --}}
<div class="flex flex-wrap items-center gap-2 mb-5 no-print">
    <button onclick="window.print()"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Cetak
    </button>

    <a href="{{ route('admin.keluarga.show', $keluarga) }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali Ke Daftar Anggota Keluarga
    </a>

    <a href="{{ route('admin.keluarga') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali Ke Daftar Keluarga
    </a>
</div>

{{-- ══════════════════════════
     DOKUMEN KARTU KELUARGA
══════════════════════════════ --}}
<div class="kk-wrapper bg-white rounded-xl border border-gray-200 shadow-sm p-8 max-w-6xl mx-auto">

    {{-- Judul --}}
    <div class="text-center mb-5">
        <h1 class="text-xl font-extrabold uppercase tracking-wide text-gray-900" style="letter-spacing: 0.05em;">
            SALINAN KARTU KELUARGA
        </h1>
        <p class="text-sm font-semibold text-gray-700 mt-1">No. {{ $keluarga->no_kk }}</p>
    </div>

    {{-- Info Alamat ── 2 kolom --}}
    <div class="grid grid-cols-2 gap-x-12 mb-5 text-xs text-gray-800">
        {{-- Kiri --}}
        <div class="space-y-1">
            <div class="flex">
                <span class="font-bold uppercase w-44 flex-shrink-0">ALAMAT</span>
                <span class="mr-2">:</span>
                <span>{{ strtoupper($keluarga->alamat ?? '—') }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-44 flex-shrink-0">RT/RW</span>
                <span class="mr-2">:</span>
                <span>{{ $keluarga->wilayah->rt ?? '—' }} / {{ $keluarga->wilayah->rw ?? '—' }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-44 flex-shrink-0">DESA / KELURAHAN</span>
                <span class="mr-2">:</span>
                <span>{{ strtoupper($namaDesa ?: ($keluarga->wilayah->desa ?? '—')) }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-44 flex-shrink-0">KECAMATAN</span>
                <span class="mr-2">:</span>
                <span>{{ strtoupper($namaKecamatan ?: '—') }}</span>
            </div>
        </div>
        {{-- Kanan --}}
        <div class="space-y-1">
            <div class="flex">
                <span class="font-bold uppercase w-36 flex-shrink-0">KABUPATEN</span>
                <span class="mr-2">:</span>
                <span>{{ strtoupper($namaKabupaten ?: '—') }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-36 flex-shrink-0">KODE POS</span>
                <span class="mr-2">:</span>
                <span>{{ $kodePos ?: '—' }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-36 flex-shrink-0">PROVINSI</span>
                <span class="mr-2">:</span>
                <span>{{ strtoupper($namaProvinsi ?: '—') }}</span>
            </div>
            <div class="flex">
                <span class="font-bold uppercase w-36 flex-shrink-0">JUMLAH ANGGOTA</span>
                <span class="mr-2">:</span>
                <span>{{ $keluarga->anggota->count() }}</span>
            </div>
        </div>
    </div>

    {{-- ══════ TABEL 1 — Data Pribadi ══════ --}}
    <div class="mb-4 overflow-x-auto">
        <table class="kk-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width:28px;">NO</th>
                    <th rowspan="2">NAMA LENGKAP</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">JENIS<br>KELAMIN</th>
                    <th rowspan="2">TEMPAT<br>LAHIR</th>
                    <th rowspan="2">TANGGAL<br>LAHIR</th>
                    <th rowspan="2">AGAMA</th>
                    <th rowspan="2">PENDIDIKAN</th>
                    <th rowspan="2">JENIS<br>PEKERJAAN</th>
                    <th rowspan="2">GOLONGAN<br>DARAH</th>
                </tr>
                <tr>{{-- merged baris 2 --}}</tr>
            </thead>
            <tbody>
                @forelse($keluarga->anggota as $i => $anggota)
                    @php
                        // Agama
                        $agamaVal = '—';
                        if (is_object($anggota->agama) && isset($anggota->agama->nama)) {
                            $agamaVal = strtoupper($anggota->agama->nama);
                        } elseif (isset($anggota->agama_id) && isset($agamaMap[$anggota->agama_id])) {
                            $agamaVal = $agamaMap[$anggota->agama_id];
                        } elseif (is_string($anggota->agama)) {
                            $agamaVal = strtoupper($anggota->agama);
                        }

                        // Pendidikan
                        $pendidikanVal = '—';
                        if (is_object($anggota->pendidikan) && isset($anggota->pendidikan->nama)) {
                            $pendidikanVal = strtoupper($anggota->pendidikan->nama);
                        } elseif (isset($anggota->pendidikan_id) && isset($pendidikanMap[$anggota->pendidikan_id])) {
                            $pendidikanVal = $pendidikanMap[$anggota->pendidikan_id];
                        } elseif (is_string($anggota->pendidikan)) {
                            $pendidikanVal = strtoupper($anggota->pendidikan);
                        }

                        // Pekerjaan
                        $pekerjaanVal = '—';
                        if (is_object($anggota->pekerjaan) && isset($anggota->pekerjaan->nama)) {
                            $pekerjaanVal = strtoupper($anggota->pekerjaan->nama);
                        } elseif (is_string($anggota->pekerjaan) && $anggota->pekerjaan) {
                            $pekerjaanVal = strtoupper($anggota->pekerjaan);
                        }

                        $golDarah = $anggota->golongan_darah ?? 'TIDAK TAHU';
                        if (is_numeric($golDarah) || strtolower($golDarah) === 'tidak tahu' || !$golDarah) {
                            $golDarah = 'TIDAK TAHU';
                        } else {
                            $golDarah = strtoupper($golDarah);
                        }
                    @endphp
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ strtoupper($anggota->nama) }}</td>
                        <td class="font-mono">{{ $anggota->nik ?? '—' }}</td>
                        <td class="center">{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ strtoupper($anggota->tempat_lahir ?? '—') }}</td>
                        <td class="center">{{ $anggota->tanggal_lahir?->format('d-m-Y') ?? '—' }}</td>
                        <td>{{ $agamaVal }}</td>
                        <td>{{ $pendidikanVal }}</td>
                        <td>{{ $pekerjaanVal }}</td>
                        <td class="center">{{ $golDarah }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="center" style="padding: 16px; color: #9ca3af; font-style: italic;">
                            Belum ada anggota keluarga
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ══════ TABEL 2 — Status Perkawinan & Hubungan ══════ --}}
    <div class="mb-8 overflow-x-auto">
        <table class="kk-table">
            <thead>
                <tr>
                    <th style="width:28px;">NO</th>
                    <th>STATUS<br>PERKAWINAN</th>
                    <th>TANGGAL<br>PERKAWINAN</th>
                    <th>STATUS HUBUNGAN<br>DALAM KELUARGA</th>
                    <th>KEWARGA-<br>NEGARAAN</th>
                    <th>NO.<br>PASPOR</th>
                    <th>NO. KITAS /<br>KITAP</th>
                    <th>NAMA AYAH</th>
                    <th>NAMA IBU</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keluarga->anggota as $i => $anggota)
                    @php
                        // Status Kawin
                        $statusKawinVal = '—';
                        if (is_object($anggota->statusKawin) && isset($anggota->statusKawin->nama)) {
                            $statusKawinVal = strtoupper($anggota->statusKawin->nama);
                        } elseif (isset($anggota->status_kawin_id) && isset($statusKawinMap[$anggota->status_kawin_id])) {
                            $statusKawinVal = $statusKawinMap[$anggota->status_kawin_id];
                        }

                        $tglKawin = null;
                        if (isset($anggota->tgl_perkawinan) && $anggota->tgl_perkawinan) {
                            try {
                                $tglKawin = is_string($anggota->tgl_perkawinan)
                                    ? \Carbon\Carbon::parse($anggota->tgl_perkawinan)->format('d-m-Y')
                                    : $anggota->tgl_perkawinan->format('d-m-Y');
                            } catch (\Exception $e) {
                                $tglKawin = null;
                            }
                        }

                        $wni = $anggota->kewarganegaraan ?? 'WNI';
                        if (!$wni) $wni = 'WNI';
                    @endphp
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ $statusKawinVal }}</td>
                        <td class="center">{{ $tglKawin ?? '-' }}</td>
                        <td>{{ $shdkMap[$anggota->kk_level] ?? 'LAINNYA' }}</td>
                        <td class="center">{{ strtoupper($wni) }}</td>
                        <td class="center">{{ $anggota->no_paspor ?? '-' }}</td>
                        <td class="center">{{ $anggota->no_kitas ?? ($anggota->no_kitap ?? '0') }}</td>
                        <td>{{ strtoupper($anggota->nama_ayah ?? '—') }}</td>
                        <td>{{ strtoupper($anggota->nama_ibu ?? '—') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="center" style="padding: 16px; color: #9ca3af; font-style: italic;">
                            Belum ada anggota keluarga
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Tanda Tangan ── --}}
    <div class="flex justify-between text-xs text-gray-800 mt-6">
        {{-- Kepala Keluarga --}}
        <div class="text-center" style="min-width: 180px;">
            <p class="font-bold uppercase">KEPALA KELUARGA</p>
            <div style="height: 72px;"></div>
            <p class="font-bold uppercase border-b border-gray-800 inline-block px-2">
                {{ $keluarga->kepalaKeluarga?->nama ?? '—' }}
            </p>
        </div>

        {{-- Tempat, Tanggal, Kepala Desa --}}
        <div class="text-center" style="min-width: 220px;">
            <p>{{ $namaDesa ? ucwords(strtolower($namaDesa)) : 'Desa' }},
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
            </p>
            <p class="font-bold uppercase mt-1">{{ strtoupper($jabatanKepDesa) }}
                {{ $namaDesa ? strtoupper($namaDesa) : '' }}</p>
            <div style="height: 72px;"></div>
            @if($namaKepDesa)
                <p class="font-bold uppercase border-b border-gray-800 inline-block px-2">
                    {{ strtoupper($namaKepDesa) }}
                </p>
            @else
                <p class="border-b border-gray-800 inline-block px-12">&nbsp;</p>
            @endif
        </div>
    </div>

</div>{{-- /kk-wrapper --}}

@endsection