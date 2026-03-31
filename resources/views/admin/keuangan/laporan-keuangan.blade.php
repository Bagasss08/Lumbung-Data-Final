@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
   <div class="p-6 bg-white dark:bg-slate-900 text-gray-800 dark:text-slate-200"> 

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                @if ($jenis === 'grafik')
                    <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Grafik Pelaksanaan APBDes</h2>
                    <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Visualisasi realisasi anggaran pendapatan dan
                        belanja desa dalam bentuk grafik batang.</p>
                @elseif($jenis === 'tabel-bidang')
                    <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tabel Laporan Belanja Per Bidang</h2>
                    <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Rincian realisasi belanja desa yang
                        dikelompokkan berdasarkan bidang kegiatan.</p>
                @else
                    <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Laporan Pelaksanaan APBDes Manual</h2>
                    <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Laporan realisasi anggaran pendapatan,
                        belanja, pembiayaan, dan SILPA desa secara lengkap.</p>
                @endif
            </div>
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
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
                <span class="text-gray-400 dark:text-slate-400">Keuangan</span>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">
                    @if ($jenis === 'grafik')
                        Grafik Pelaksanaan APBDes
                    @elseif($jenis === 'tabel-bidang')
                        Tabel Laporan Belanja Per Bidang
                    @else
                        Laporan Pelaksanaan APBDes Manual
                    @endif
                </span>
            </nav>
        </div>  

        {{-- SESSION MESSAGES --}}
        @if (session('warning'))
            <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg px-4 py-3 text-sm">
                ⚠️ {{ session('warning') }}
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-lg px-4 py-3 text-sm">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- FILTER TAHUN --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm p-4 mb-6 flex items-center gap-4">
            <label class="text-sm font-medium text-gray-600 dark:text-slate-300 whitespace-nowrap">Tahun Anggaran:</label>
            <form method="GET" action="{{ route('admin.keuangan.laporan-keuangan') }}" id="formTahun">
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <select name="tahun" onchange="document.getElementById('formTahun').submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    @foreach ($tahunList as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- LAYOUT: SIDEBAR KIRI + KONTEN KANAN --}}
        <div class="flex gap-6 items-start">

            {{-- ==================== SIDEBAR KIRI ==================== --}}
            <div class="w-64 flex-shrink-0">
                <div
                    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

                    {{-- Header Grafik --}}
                    <div class="px-4 pt-4 pb-2">
                        <p class="text-xs uppercase font-semibold text-gray-500 tracking-wide">Grafik Laporan Keuangan</p>
                    </div>

                    {{-- Grafik Pelaksanaan APBDes --}}
                    <div class="px-2 pb-1">
                        <a href="{{ route('admin.keuangan.laporan-keuangan', ['tahun' => $tahun, 'jenis' => 'grafik']) }}"
                            class="block rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ $jenis === 'grafik' ? 'bg-emerald-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Grafik Pelaksanaan APBDes
                        </a>
                    </div>

                    <div class="border-t border-gray-100 my-2"></div>

                    {{-- Tabel Laporan Per Bidang --}}
                    <div class="px-4 py-3">
                        <p class="text-xs font-semibold text-gray-500 tracking-wide">Tabel Laporan (Belanja Per Bidang)</p>
                    </div>

                    <div class="border-t border-gray-100 my-2"></div>

                    {{-- Laporan Manual --}}
                    <div class="px-2 pb-4">
                        <a href="{{ route('admin.keuangan.laporan-keuangan', ['tahun' => $tahun, 'jenis' => 'laporan-manual']) }}"
                            class="block rounded-lg px-3 py-2 text-sm font-medium transition
                            {{ $jenis === 'laporan-manual' ? 'bg-emerald-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                            Laporan Pelaksanaan APBDes Manual
                        </a>
                    </div>
                </div>
            </div>

            {{-- ==================== KONTEN KANAN ==================== --}}
            <div class="flex-1 min-w-0">

                {{-- ================================================ --}}
                {{-- SUB MENU: GRAFIK                                  --}}
                {{-- ================================================ --}}
                @if ($jenis === 'grafik')
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                        {{-- Kolom 1: APBDes Pelaksanaan (Level 1) --}}
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                            <div
                                class="bg-gray-50 dark:bg-slate-900 border-b border-gray-200 dark:border-slate-700 px-4 py-3">
                                <h3 class="font-semibold text-gray-800 text-sm text-center">APBDes {{ $tahun }}
                                    Pelaksanaan</h3>
                                <p class="text-xs text-gray-500 text-center mt-1">Realisasi | Anggaran</p>
                            </div>
                            <div class="p-4 space-y-4">
                                @php
                                    $level1Items = $allData->filter(
                                        fn($item) => substr_count($item->akunRekening->kode_rekening, '.') === 0 &&
                                            in_array($item->akunRekening->kode_rekening, ['4', '5', '6']),
                                    );
                                @endphp
                                @foreach ($level1Items as $item)
                                    @php
                                        $persen =
                                            $item->anggaran > 0
                                                ? min(100, round(($item->realisasi / $item->anggaran) * 100, 2))
                                                : 0;
                                    @endphp
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">{{ $item->akunRekening->uraian }}
                                        </p>
                                        <p class="text-xs text-gray-500 mb-2">
                                            Rp {{ number_format($item->realisasi, 2, ',', '.') }}
                                            | Rp {{ number_format($item->anggaran, 2, ',', '.') }}
                                        </p>
                                        <div class="relative w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $persen }}%">
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-1">
                                            <span
                                                class="text-xs bg-red-100 text-red-700 rounded px-1.5 py-0.5">{{ $persen }}
                                                %</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Kolom 2: APBDes Pendapatan (Level 2 starts with 4.) --}}
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                            <div
                                class="bg-gray-50 dark:bg-slate-900 border-b border-gray-200 dark:border-slate-700 px-4 py-3">
                                <h3 class="font-semibold text-gray-800 text-sm text-center">APBDes {{ $tahun }}
                                    Pendapatan</h3>
                                <p class="text-xs text-gray-500 text-center mt-1">Realisasi | Anggaran</p>
                            </div>
                            <div class="p-4 space-y-4">
                                @php
                                    $pendapatanLevel2 = $pendapatan->filter(
                                        fn($item) => substr_count($item->akunRekening->kode_rekening, '.') === 1,
                                    );
                                @endphp
                                @foreach ($pendapatanLevel2 as $item)
                                    @php
                                        $persen =
                                            $item->anggaran > 0
                                                ? min(100, round(($item->realisasi / $item->anggaran) * 100, 2))
                                                : 0;
                                    @endphp
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">{{ $item->akunRekening->uraian }}
                                        </p>
                                        <p class="text-xs text-gray-500 mb-2">
                                            Rp {{ number_format($item->realisasi, 2, ',', '.') }}
                                            | Rp {{ number_format($item->anggaran, 2, ',', '.') }}
                                        </p>
                                        <div class="relative w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $persen }}%">
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-1">
                                            <span
                                                class="text-xs bg-red-100 text-red-700 rounded px-1.5 py-0.5">{{ $persen }}
                                                %</span>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($pendapatanLevel2->isEmpty())
                                    <p class="text-xs text-gray-400 text-center py-4">Tidak ada data pendapatan</p>
                                @endif
                            </div>
                        </div>

                        {{-- Kolom 3: APBDes Pembelanjaan (Level 2 starts with 5.) --}}
                        <div
                            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                            <div
                                class="bg-gray-50 dark:bg-slate-900 border-b border-gray-200 dark:border-slate-700 px-4 py-3">
                                <h3 class="font-semibold text-gray-800 text-sm text-center">APBDes {{ $tahun }}
                                    Pembelanjaan</h3>
                                <p class="text-xs text-gray-500 text-center mt-1">Realisasi | Anggaran</p>
                            </div>
                            <div class="p-4 space-y-4">
                                @php
                                    $belanjaLevel2 = $belanja->filter(
                                        fn($item) => substr_count($item->akunRekening->kode_rekening, '.') === 1,
                                    );
                                @endphp
                                @foreach ($belanjaLevel2 as $item)
                                    @php
                                        $persen =
                                            $item->anggaran > 0
                                                ? min(100, round(($item->realisasi / $item->anggaran) * 100, 2))
                                                : 0;
                                    @endphp
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">{{ $item->akunRekening->uraian }}
                                        </p>
                                        <p class="text-xs text-gray-500 mb-2">
                                            Rp {{ number_format($item->realisasi, 2, ',', '.') }}
                                            | Rp {{ number_format($item->anggaran, 2, ',', '.') }}
                                        </p>
                                        <div class="relative w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $persen }}%">
                                            </div>
                                        </div>
                                        <div class="flex justify-end mt-1">
                                            <span
                                                class="text-xs bg-red-100 text-red-700 rounded px-1.5 py-0.5">{{ $persen }}
                                                %</span>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($belanjaLevel2->isEmpty())
                                    <p class="text-xs text-gray-400 text-center py-4">Tidak ada data belanja</p>
                                @endif
                            </div>
                        </div>

                    </div>
                    {{-- END GRAFIK --}}


                    {{-- ================================================ --}}
                    {{-- SUB MENU: LAPORAN MANUAL (DEFAULT)               --}}
                    {{-- ================================================ --}}
                @else
                    <div
                        class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

                        {{-- Header Laporan --}}
                        <div class="py-6 text-center border-b border-gray-200 dark:border-slate-700">
                            <p class="font-bold text-gray-800 text-sm uppercase tracking-wide">LAPORAN REALISASI
                                PELAKSANAAN</p>
                            <p class="font-bold text-gray-800 text-sm uppercase tracking-wide">ANGGARAN PENDAPATAN DAN
                                BELANJA DESA</p>
                            <p class="font-bold text-gray-800 text-sm uppercase tracking-wide mt-1">
                                PEMERINTAH
                                @php
                                    $namaDesa = 'DESA';
                                    try {
                                        $identitas = \DB::table('identitas_desa')->first();
                                        if ($identitas && isset($identitas->nama_desa)) {
                                            $namaDesa = 'DESA ' . strtoupper($identitas->nama_desa);
                                        }
                                    } catch (\Exception $e) {
                                    }
                                @endphp
                                {{ $namaDesa }}
                            </p>
                            <p class="font-bold text-gray-800 text-sm uppercase tracking-wide">TAHUN ANGGARAN
                                {{ $tahun }}</p>
                        </div>

                        {{-- Tabel Hierarkis --}}
                        <div class="overflow-x-auto">
                            <table class="text-sm w-full border-collapse">
                                <thead>
                                    <tr class="bg-emerald-600 text-white">
                                        <th class="border border-emerald-500 px-3 py-2 text-center w-20" colspan="2">
                                            Uraian</th>
                                        <th class="border border-emerald-500 px-3 py-2 text-right min-w-32">Anggaran (Rp)
                                        </th>
                                        <th class="border border-emerald-500 px-3 py-2 text-right min-w-32">Realisasi (Rp)
                                        </th>
                                        <th class="border border-emerald-500 px-3 py-2 text-right min-w-32">Lebih/(Kurang)
                                            (Rp)</th>
                                        <th class="border border-emerald-500 px-3 py-2 text-right w-24">Persentase (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $item)
                                        @php
                                            $kode = $item->akunRekening->kode_rekening;
                                            $uraian = $item->akunRekening->uraian;
                                            $dots = substr_count($kode, '.');
                                            $lebihKurang = $item->anggaran - $item->realisasi;
                                            $persen =
                                                $item->anggaran > 0
                                                    ? round(($item->realisasi / $item->anggaran) * 100, 2)
                                                    : 0;
                                        @endphp

                                        {{-- LEVEL 1 (kode: 4, 5, 6) --}}
                                        @if ($dots === 0)
                                            <tr class="bg-gray-300 dark:bg-slate-700">
                                                <td
                                                    class="border border-gray-400 dark:border-slate-600 px-3 py-2 text-center font-bold w-10">
                                                    {{ $kode }}</td>
                                                <td class="border border-gray-400 px-3 py-2 font-bold uppercase">
                                                    {{ $uraian }}</td>
                                                <td class="border border-gray-400 px-3 py-2"></td>
                                                <td class="border border-gray-400 px-3 py-2"></td>
                                                <td class="border border-gray-400 px-3 py-2"></td>
                                                <td class="border border-gray-400 px-3 py-2"></td>
                                            </tr>

                                            {{-- LEVEL 2 (kode: 4.1, 5.1, dst) --}}
                                        @elseif($dots === 1)
                                            <tr class="bg-gray-100 dark:bg-slate-700">
                                                <td
                                                    class="border border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-xs text-gray-600 dark:text-slate-300">
                                                    {{ $kode }}</td>
                                                <td class="border border-gray-300 px-3 py-2 font-bold">{{ $uraian }}
                                                </td>
                                                <td class="border border-gray-300 px-3 py-2 text-right font-bold">
                                                    {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                                                <td class="border border-gray-300 px-3 py-2 text-right font-bold">
                                                    {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                                                <td
                                                    class="border border-gray-300 px-3 py-2 text-right font-bold {{ $lebihKurang < 0 ? 'text-red-600' : '' }}">
                                                    {{ number_format($lebihKurang, 2, ',', '.') }}
                                                </td>
                                                <td class="border border-gray-300 px-3 py-2 text-right font-bold">
                                                    {{ number_format($persen, 2, ',', '.') }}</td>
                                            </tr>

                                            {{-- LEVEL 3+ (kode: 4.1.1, 5.1.1, dst) --}}
                                        @else
                                            <tr
                                                class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700">
                                                <td
                                                    class="border border-gray-200 px-3 py-1.5 text-center text-xs text-gray-500">
                                                    {{ $kode }}</td>
                                                <td class="border border-gray-200 px-3 py-1.5 pl-8">{{ $uraian }}
                                                </td>
                                                <td class="border border-gray-200 px-3 py-1.5 text-right">
                                                    {{ number_format($item->anggaran, 2, ',', '.') }}</td>
                                                <td class="border border-gray-200 px-3 py-1.5 text-right">
                                                    {{ number_format($item->realisasi, 2, ',', '.') }}</td>
                                                <td
                                                    class="border border-gray-200 px-3 py-1.5 text-right {{ $lebihKurang < 0 ? 'text-red-600' : '' }}">
                                                    {{ number_format($lebihKurang, 2, ',', '.') }}
                                                </td>
                                                <td class="border border-gray-200 px-3 py-1.5 text-right">
                                                    {{ number_format($persen, 2, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                                {{-- BARIS RINGKASAN DI BAWAH --}}
                                <tfoot>
                                    @php
                                        $selisihPendapatan = $totalPendapatan - $realisasiPendapatan;
                                        $persenPendapatan =
                                            $totalPendapatan > 0
                                                ? round(($realisasiPendapatan / $totalPendapatan) * 100, 2)
                                                : 0;
                                        $selisihBelanja = $totalBelanja - $realisasiBelanja;
                                        $persenBelanja =
                                            $totalBelanja > 0 ? round(($realisasiBelanja / $totalBelanja) * 100, 2) : 0;
                                    @endphp

                                    {{-- 1. JUMLAH PENDAPATAN --}}
                                    <tr class="bg-yellow-300 font-bold">
                                        <td colspan="2"
                                            class="border border-yellow-400 px-3 py-2 text-center uppercase">
                                            JUMLAH PENDAPATAN
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($totalPendapatan, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($realisasiPendapatan, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($selisihPendapatan, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($persenPendapatan, 2, ',', '.') }}
                                        </td>
                                    </tr>

                                    {{-- 2. JUMLAH BELANJA --}}
                                    <tr class="bg-yellow-300 font-bold">
                                        <td colspan="2"
                                            class="border border-yellow-400 px-3 py-2 text-center uppercase">
                                            JUMLAH BELANJA
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($totalBelanja, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($realisasiBelanja, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($selisihBelanja, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($persenBelanja, 2, ',', '.') }}
                                        </td>
                                    </tr>

                                    {{-- 3. SURPLUS / DEFISIT --}}
                                    <tr class="bg-yellow-300 font-bold">
                                        <td colspan="2"
                                            class="border border-yellow-400 px-3 py-2 text-center uppercase">
                                            SURPLUS / (DEFISIT)
                                        </td>
                                        <td
                                            class="border border-yellow-400 px-3 py-2 text-right {{ $surplusDefisit < 0 ? 'text-red-700' : '' }}">
                                            {{ number_format($surplusDefisit, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                    </tr>

                                    {{-- 4. Pemisah kosong --}}
                                    <tr class="bg-gray-300 dark:bg-slate-700">
                                        <td colspan="6" class="border border-gray-400 dark:border-slate-600 px-3 py-1">
                                        </td>
                                    </tr>

                                    {{-- 5. PEMBIAYAAN NETTO --}}
                                    <tr class="bg-yellow-300 font-bold">
                                        <td colspan="2"
                                            class="border border-yellow-400 px-3 py-2 text-center uppercase">
                                            PEMBIAYAAN NETTO
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($totalPembiayaanNetto, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                    </tr>

                                    {{-- 6. SILPA --}}
                                    <tr class="bg-yellow-300 font-bold">
                                        <td colspan="2"
                                            class="border border-yellow-400 px-3 py-2 text-center uppercase">
                                            SILPA / SILPA TAHUN BERJALAN
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-right">
                                            {{ number_format($silpa, 2, ',', '.') }}
                                        </td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                        <td class="border border-yellow-400 px-3 py-2 text-center text-gray-500">-</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{-- END LAPORAN MANUAL --}}

                @endif
                {{-- END KONTEN --}}

            </div>
            {{-- END KONTEN KANAN --}}

        </div>
        {{-- END LAYOUT --}}

    </div>
@endsection
