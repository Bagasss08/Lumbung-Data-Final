@extends('layouts.admin')

@section('title', $tab === 'sdgs' ? 'Status SDGS Desa' : 'Status IDM Desa')

@section('content')

{{-- ── Breadcrumb ────────────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-5">
    <h4 class="text-xl font-bold text-gray-800 dark:text-gray-100">
        {{ $tab === 'sdgs' ? 'Status SDGS Desa' : 'Status IDM Desa' }}
    </h4>
    <nav class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Beranda</a>
        <span>&rsaquo;</span>
        <span class="text-gray-700 dark:text-gray-300">
            {{ $tab === 'sdgs' ? 'Status SDGS Desa' : 'Status IDM Desa' }}
        </span>
    </nav>
</div>

{{-- ── Flash Alert ──────────────────────────────────────────────────── --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show"
         class="flex items-start gap-3 bg-green-50 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg px-4 py-3 mb-4 text-sm">
        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="flex-1">{{ session('success') }}</span>
        <button @click="show=false" class="text-green-600 hover:text-green-800 dark:text-green-400 text-lg leading-none">&times;</button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show"
         class="flex items-start gap-3 bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg px-4 py-3 mb-4 text-sm">
        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <span class="flex-1">{{ session('error') }}</span>
        <button @click="show=false" class="text-red-600 hover:text-red-800 dark:text-red-400 text-lg leading-none">&times;</button>
    </div>
@endif

{{-- ── Tab IDM / SDGS ────────────────────────────────────────────────── --}}
<div class="flex rounded-xl overflow-hidden mb-5 shadow-sm border border-gray-200 dark:border-gray-700">
    <a href="{{ route('admin.info-desa.status-desa.index', ['tab' => 'idm', 'tahun' => $tahun]) }}"
       class="flex items-center gap-3 px-8 py-4 text-white font-bold text-base tracking-wide transition-all flex-1 justify-center
              {{ $tab === 'idm' ? 'bg-blue-700' : 'bg-blue-500 hover:bg-blue-600' }}">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-4a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zm6-3a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
        </svg>
        IDM
    </a>
    <a href="{{ route('admin.info-desa.status-desa.index', ['tab' => 'sdgs', 'tahun' => $tahun]) }}"
       class="flex items-center gap-3 px-8 py-4 text-white font-bold text-base tracking-wide transition-all flex-1 justify-center
              {{ $tab === 'sdgs' ? 'bg-green-700' : 'bg-green-500 hover:bg-green-600' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        SDGS
    </a>
</div>

{{-- ════════════════════════════════════════════════════════════════════ --}}
{{-- TAB IDM                                                             --}}
{{-- ════════════════════════════════════════════════════════════════════ --}}
@if($tab === 'idm')

    {{-- ── Filter Tahun + Tombol Aksi ────────────────────────────────── --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-5 py-3 mb-5 flex flex-wrap items-center gap-3 shadow-sm">

        {{-- Dropdown tahun --}}
        <form method="GET" action="{{ route('admin.info-desa.status-desa.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="tab" value="idm">
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">IDM Tahun</label>
            <select name="tahun" onchange="this.form.submit()"
                    class="text-sm rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                           text-gray-800 dark:text-gray-100 px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
                @if(!$tahunList->contains(date('Y')))
                    <option value="{{ date('Y') }}" {{ date('Y') == $tahun ? 'selected' : '' }}>{{ date('Y') }}</option>
                @endif
            </select>
        </form>

        {{-- Perbarui Skor --}}
        <form method="POST" action="{{ route('admin.info-desa.status-desa.perbarui') }}">
            @csrf
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-medium px-4 py-1.5 rounded-lg
                           border border-blue-500 text-blue-600 dark:text-blue-400 dark:border-blue-400
                           hover:bg-blue-50 dark:hover:bg-blue-900/30 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Perbarui
            </button>
        </form>

        {{-- Simpan Indikator --}}
        <button type="submit" form="form-indikator"
                class="inline-flex items-center gap-2 text-sm font-medium px-4 py-1.5 rounded-lg
                       bg-green-600 hover:bg-green-700 text-white transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan
        </button>

        {{-- Salin dari tahun sebelumnya (hanya jika belum ada data) --}}
        @if(!$indikator->count())
            <form method="POST" action="{{ route('admin.info-desa.status-desa.salin') }}">
                @csrf
                <input type="hidden" name="tahun_baru" value="{{ $tahun }}">
                <button type="submit"
                        class="inline-flex items-center gap-2 text-sm font-medium px-4 py-1.5 rounded-lg
                               border border-yellow-500 text-yellow-700 dark:text-yellow-400 dark:border-yellow-400
                               hover:bg-yellow-50 dark:hover:bg-yellow-900/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Salin dari {{ $tahun - 1 }}
                </button>
            </form>
        @endif
    </div>

    {{-- ── 4 Kartu Skor + Pie Chart ────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-5">

        {{-- Kiri: 2×2 kartu skor --}}
        <div class="lg:col-span-2 grid grid-cols-2 gap-4">

            {{-- Skor IDM Saat Ini --}}
            <div class="rounded-2xl bg-gradient-to-br from-blue-700 to-blue-900 text-white p-5 shadow-lg flex flex-col justify-between min-h-[130px] relative overflow-hidden">
                <div>
                    <div class="text-3xl font-extrabold leading-tight">
                        {{ $rekap ? number_format($rekap->skor_idm, 4) : '0.0000' }}
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest opacity-80 mt-1">Skor IDM Saat Ini</div>
                </div>
                <svg class="w-14 h-14 opacity-20 absolute bottom-2 right-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-4a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zm6-3a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>

            {{-- Status IDM --}}
            <div class="rounded-2xl bg-gradient-to-br from-orange-500 to-orange-700 text-white p-5 shadow-lg flex flex-col justify-between min-h-[130px] relative overflow-hidden">
                <div>
                    <div class="text-2xl font-extrabold leading-tight">
                        {{ $rekap->status_idm ?? '-' }}
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest opacity-80 mt-1">Status IDM</div>
                </div>
                <svg class="w-14 h-14 opacity-20 absolute bottom-2 right-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>

            {{-- Skor IDM Minimal --}}
            <div class="rounded-2xl bg-gradient-to-br from-red-700 to-red-900 text-white p-5 shadow-lg flex flex-col justify-between min-h-[130px] relative overflow-hidden">
                <div>
                    <div class="text-3xl font-extrabold leading-tight">
                        {{ $rekap ? number_format($rekap->skor_idm_minimal, 4) : '0.0000' }}
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest opacity-80 mt-1">Skor IDM Minimal</div>
                </div>
                <svg class="w-14 h-14 opacity-20 absolute bottom-2 right-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                </svg>
            </div>

            {{-- Target Status --}}
            <div class="rounded-2xl bg-gradient-to-br from-green-600 to-green-800 text-white p-5 shadow-lg flex flex-col justify-between min-h-[130px] relative overflow-hidden">
                <div>
                    <div class="text-2xl font-extrabold leading-tight">
                        {{ $rekap->target_status ?? '-' }}
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest opacity-80 mt-1">Target Status</div>
                </div>
                <svg class="w-14 h-14 opacity-20 absolute bottom-2 right-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>

        {{-- Kanan: Pie / Donut Chart --}}
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 flex flex-col items-center justify-center">
            <h6 class="font-semibold text-gray-700 dark:text-gray-200 text-center mb-0.5">
                Indeks Desa Membangun (IDM) {{ $tahun }}
            </h6>
            <p class="text-xs text-gray-400 dark:text-gray-500 text-center mb-3">SKOR : IKS, IKE, IKL</p>
            <div class="w-full max-w-sm">
                <canvas id="pieIdm" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- ── Info Lokasi Desa ────────────────────────────────────────────── --}}
    @if($rekap)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 mb-5 shadow-sm">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide mb-0.5">Provinsi</span>
                <div class="font-bold text-gray-800 dark:text-gray-100">{{ config('desa.provinsi', 'Sulawesi Tengah') }}</div>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide mb-0.5">Kabupaten</span>
                <div class="font-bold text-gray-800 dark:text-gray-100">{{ config('desa.kabupaten', 'Banggai') }}</div>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide mb-0.5">Kecamatan</span>
                <div class="font-bold text-gray-800 dark:text-gray-100">{{ config('desa.kecamatan', 'Masama') }}</div>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide mb-0.5">Desa</span>
                <div class="font-bold text-gray-800 dark:text-gray-100">{{ config('desa.nama', 'Kembang Merta') }}</div>
            </div>
        </div>
    </div>

    {{-- Sub-Indeks IKS / IKE / IKL --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 mb-5 shadow-sm">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide">Skor IKS</span>
                <div class="font-bold text-blue-700 dark:text-blue-400 text-lg">{{ number_format($rekap->skor_iks, 4) }}</div>
                <span class="text-xs text-gray-400">Indeks Ketahanan Sosial</span>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide">Skor IKE</span>
                <div class="font-bold text-green-700 dark:text-green-400 text-lg">{{ number_format($rekap->skor_ike, 4) }}</div>
                <span class="text-xs text-gray-400">Indeks Ketahanan Ekonomi</span>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide">Skor IKL</span>
                <div class="font-bold text-yellow-600 dark:text-yellow-400 text-lg">{{ number_format($rekap->skor_ikl, 4) }}</div>
                <span class="text-xs text-gray-400">Indeks Ketahanan Lingkungan</span>
            </div>
            <div>
                <span class="block text-gray-500 dark:text-gray-400 font-medium uppercase text-xs tracking-wide">Tahun Data</span>
                <div class="font-bold text-gray-800 dark:text-gray-100 text-lg">{{ $tahun }}</div>
                <span class="text-xs text-gray-400">Periode IDM</span>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Tabel Indikator IDM ─────────────────────────────────────────── --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
            <h6 class="font-bold text-gray-800 dark:text-gray-100 text-base">Detail Indikator IDM {{ $tahun }}</h6>
        </div>

        @if($indikator->isEmpty())
            <div class="text-center py-16 text-gray-400 dark:text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-base mb-4">Belum ada data indikator untuk tahun {{ $tahun }}.</p>
                @if($tahunList->isNotEmpty())
                    <form method="POST" action="{{ route('admin.info-desa.status-desa.salin') }}">
                        @csrf
                        <input type="hidden" name="tahun_baru" value="{{ $tahun }}">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-lg border border-blue-500 text-blue-600 dark:text-blue-400
                                       hover:bg-blue-50 dark:hover:bg-blue-900/20 text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Salin dari tahun {{ $tahun - 1 }}
                        </button>
                    </form>
                @endif
            </div>
        @else
            <form id="form-indikator" method="POST" action="{{ route('admin.info-desa.status-desa.simpan') }}">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        {{-- THEAD --}}
                        <thead>
                            <tr class="bg-gray-900 dark:bg-gray-950 text-white">
                                <th rowspan="2" class="px-3 py-3 text-center align-middle border border-gray-700 w-10">NO</th>
                                <th rowspan="2" class="px-3 py-3 text-left align-middle border border-gray-700 min-w-[160px]">INDIKATOR IDM</th>
                                <th rowspan="2" class="px-3 py-3 text-center align-middle border border-gray-700 w-16">SKOR</th>
                                <th rowspan="2" class="px-3 py-3 text-left align-middle border border-gray-700 min-w-[200px]">KETERANGAN</th>
                                <th rowspan="2" class="px-3 py-3 text-left align-middle border border-gray-700 min-w-[190px]">KEGIATAN YANG DAPAT DILAKUKAN</th>
                                <th rowspan="2" class="px-3 py-3 text-center align-middle border border-gray-700 w-24">+NILAI</th>
                                <th colspan="6" class="px-3 py-2 text-center border border-gray-700">YANG DAPAT MELAKSANAKAN KEGIATAN</th>
                            </tr>
                            <tr class="bg-gray-800 dark:bg-gray-900 text-gray-200">
                                <th class="px-3 py-2 text-center border border-gray-700 w-20">PUSAT</th>
                                <th class="px-3 py-2 text-center border border-gray-700 w-20">PROVINSI</th>
                                <th class="px-3 py-2 text-center border border-gray-700 w-24">KABUPATEN</th>
                                <th class="px-3 py-2 text-center border border-gray-700 w-20">DESA</th>
                                <th class="px-3 py-2 text-center border border-gray-700 w-16">CSR</th>
                                <th class="px-3 py-2 text-center border border-gray-700 w-20">LAINNYA</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @php
                                $dimensiSebelumnya = '';
                                $labelDimensi = [
                                    'IKS' => 'Indeks Ketahanan Sosial (IKS)',
                                    'IKE' => 'Indeks Ketahanan Ekonomi (IKE)',
                                    'IKL' => 'Indeks Ketahanan Lingkungan (IKL)',
                                ];
                                $bgDimensi = [
                                    'IKS' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-200',
                                    'IKE' => 'bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200',
                                    'IKL' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-200',
                                ];
                            @endphp

                            @foreach($indikator as $ind)
                                {{-- Header kelompok dimensi --}}
                                @if($ind->dimensi !== $dimensiSebelumnya)
                                    @php $dimensiSebelumnya = $ind->dimensi; @endphp
                                    <tr class="{{ $bgDimensi[$ind->dimensi] ?? '' }}">
                                        <td colspan="12" class="px-4 py-2 font-bold text-xs tracking-wide border border-gray-200 dark:border-gray-600">
                                            {{ $labelDimensi[$ind->dimensi] ?? $ind->dimensi }}
                                        </td>
                                    </tr>
                                @endif

                                @php
                                    $rowBg = '';
                                    if ($ind->skor == 0)     $rowBg = 'bg-red-50 dark:bg-red-900/20';
                                    elseif ($ind->skor <= 2) $rowBg = 'bg-yellow-50 dark:bg-yellow-900/20';
                                    else                     $rowBg = 'bg-white dark:bg-gray-800';
                                @endphp

                                <tr class="{{ $rowBg }} hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-3 py-2 text-center border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $ind->no_urut }}
                                    </td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 font-medium">
                                        {{ $ind->nama_indikator }}
                                    </td>
                                    <td class="px-2 py-2 text-center border border-gray-200 dark:border-gray-700">
                                        <select name="skor[{{ $ind->id }}]"
                                                class="w-16 text-center text-xs rounded-md border border-gray-300 dark:border-gray-600
                                                       bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 py-1
                                                       focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                            @for($s = 0; $s <= 5; $s++)
                                                <option value="{{ $s }}" {{ $ind->skor == $s ? 'selected' : '' }}>{{ $s }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $ind->keterangan }}
                                    </td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 {{ $ind->skor < 5 ? 'text-sky-600 dark:text-sky-400' : 'text-gray-400' }}">
                                        {{ $ind->skor < 5 ? $ind->kegiatan_dilakukan : '-' }}
                                    </td>
                                    <td class="px-3 py-2 text-center border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-mono">
                                        {{ $ind->nilai_tambah ? number_format($ind->nilai_tambah, 8) : '0' }}
                                    </td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $ind->pelaksana_pusat }}</td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $ind->pelaksana_provinsi }}</td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $ind->pelaksana_kabupaten }}</td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">{{ $ind->pelaksana_desa }}</td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">{{ $ind->pelaksana_csr }}</td>
                                    <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 italic">{{ $ind->pelaksana_lainnya }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Legend warna --}}
                <div class="flex flex-wrap gap-4 px-5 py-3 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-red-200 dark:bg-red-800"></span> Skor 0 (Kritis)
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-yellow-200 dark:bg-yellow-800"></span> Skor 1–2 (Perlu perhatian)
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="inline-block w-3 h-3 rounded-sm bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600"></span> Skor 3–5 (Baik)
                    </span>
                </div>
            </form>
        @endif
    </div>

{{-- ════════════════════════════════════════════════════════════════════ --}}
{{-- TAB SDGS                                                            --}}
{{-- ════════════════════════════════════════════════════════════════════ --}}
@elseif($tab === 'sdgs')

    {{-- Tombol Perbarui SDGs --}}
    <div class="mb-5">
        <form method="POST" action="{{ route('admin.info-desa.status-desa.sdgs.perbarui') }}">
            @csrf
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <button type="submit"
                    class="inline-flex items-center gap-2 text-sm font-medium px-4 py-1.5 rounded-lg
                           border border-blue-500 text-blue-600 dark:text-blue-400 dark:border-blue-400
                           hover:bg-blue-50 dark:hover:bg-blue-900/30 bg-white dark:bg-gray-800 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Perbarui
            </button>
        </form>
    </div>

    {{-- Skor Total SDGs --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm p-8 mb-5 text-center">
        <div class="text-5xl font-extrabold text-gray-800 dark:text-gray-100 mb-1">
            {{ $sdgsRekap ? number_format($sdgsRekap->skor_sdgs, 2) : '0.00' }}
        </div>
        <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">Skor SDGs Desa</div>
    </div>

    {{-- Grid 18 Kartu Tujuan SDGs --}}
    @php
        $warnaTujuan = [
            1  => '#E5243B', 2  => '#DDA63A', 3  => '#4C9F38',
            4  => '#C5192D', 5  => '#FF3A21', 6  => '#26BDE2',
            7  => '#FCC30B', 8  => '#A21942', 9  => '#FD6925',
            10 => '#DD1367', 11 => '#FD9D24', 12 => '#BF8B2E',
            13 => '#3F7E44', 14 => '#0A97D9', 15 => '#56C02B',
            16 => '#00689D', 17 => '#19486A', 18 => '#56C02B',
        ];
        $namaShort = [
            1  => 'DESA TANPA KEMISKINAN',
            2  => 'DESA TANPA KELAPARAN',
            3  => 'DESA SEHAT DAN SEJAHTERA',
            4  => 'PENDIDIKAN DESA BERKUALITAS',
            5  => 'KETERLIBATAN PEREMPUAN DESA',
            6  => 'DESA LAYAK AIR BERSIH DAN SANITASI',
            7  => 'DESA BERENERGI BERSIH DAN TERBARUKAN',
            8  => 'PERTUMBUHAN EKONOMI DESA MERATA',
            9  => 'INFRASTRUKTUR DAN INOVASI DESA SESUAI KEBUTUHAN',
            10 => 'DESA TANPA KESENJANGAN',
            11 => 'KAWASAN PERMUKIMAN DESA AMAN DAN NYAMAN',
            12 => 'KONSUMSI DAN PRODUKSI DESA SADAR LINGKUNGAN',
            13 => 'DESA TANGGAP PERUBAHAN IKLIM',
            14 => 'DESA PEDULI LINGKUNGAN LAUT',
            15 => 'DESA PEDULI LINGKUNGAN DARAT',
            16 => 'DESA DAMAI BERKEADILAN',
            17 => 'KEMITRAAN UNTUK PEMBANGUNAN DESA',
            18 => 'KELEMBAGAAN DESA DINAMIS DAN BUDAYA DESA ADAPTIF',
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($sdgsTujuan as $tujuan)
            @php
                $no     = $tujuan->no_tujuan;
                $warna  = $warnaTujuan[$no] ?? '#4B5563';
                $nama   = $namaShort[$no] ?? $tujuan->nama_tujuan;
                $nilai  = number_format($tujuan->nilai, 2);
            @endphp
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden flex items-center gap-0 hover:shadow-md transition-shadow">
                {{-- Icon kiri --}}
                <div class="flex-shrink-0 w-28 h-full flex flex-col items-center justify-center p-3 min-h-[100px]"
                     style="background-color: {{ $warna }};">
                    <span class="text-white font-black text-xl leading-none">{{ $no }}</span>
                    <span class="text-white text-[9px] font-bold text-center leading-tight mt-1 uppercase">
                        {{ Str::limit($nama, 40) }}
                    </span>
                </div>
                {{-- Nilai kanan --}}
                <div class="flex-1 px-5 py-4">
                    <div class="text-3xl font-extrabold text-gray-800 dark:text-gray-100">{{ $nilai }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mt-0.5">Nilai</div>
                </div>
            </div>
        @endforeach
    </div>

@endif

@endsection

@push('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@if($tab === 'idm')
<script>
(function () {
    const ctx = document.getElementById('pieIdm');
    if (!ctx) return;

    const iks   = {{ $pieData['iks'] ?? 0 }};
    const ike   = {{ $pieData['ike'] ?? 0 }};
    const ikl   = {{ $pieData['ikl'] ?? 0 }};
    const total = iks + ike + ikl;

    const pct = (v) => total > 0 ? ((v / total) * 100).toFixed(1) : 0;

    const isDark    = document.documentElement.classList.contains('dark');
    const labelColor = isDark ? '#d1d5db' : '#374151';

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                `IKS: ${iks.toFixed(4)} / ${pct(iks)}%`,
                `IKE: ${ike.toFixed(4)} / ${pct(ike)}%`,
                `IKL: ${ikl.toFixed(4)} / ${pct(ikl)}%`,
            ],
            datasets: [{
                data: [iks, ike, ikl],
                backgroundColor:      ['#1d4ed8', '#16a34a', '#ca8a04'],
                hoverBackgroundColor: ['#2563eb', '#22c55e', '#eab308'],
                borderWidth:  3,
                borderColor:  isDark ? '#1f2937' : '#ffffff',
                hoverOffset:  8,
            }]
        },
        options: {
            responsive: true,
            cutout: '55%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color:           labelColor,
                        padding:         16,
                        font:            { size: 12, family: 'Inter, sans-serif' },
                        usePointStyle:   true,
                        pointStyleWidth: 10,
                    }
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` ${ctx.label}`,
                    }
                }
            }
        }
    });
})();
</script>
@endif

@endpush