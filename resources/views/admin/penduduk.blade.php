@extends('layouts.admin')

@section('title', 'Data Penduduk')

@section('content')
{{-- x-data wrapper agar $dispatch Alpine bekerja untuk modal hapus --}}
<div x-data>

{{-- ============================================================ --}}
{{-- + Breadcrumb + HEADER: Title kiri Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Data Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data penduduk desa</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Penduduk</span>
        </nav>
    </div>
</div>

{{-- Flash Messages --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-end="opacity-0"
    class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-6">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
    <div>
        <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        @if(session('import_errors'))
        <ul class="mt-2 space-y-0.5">
            @foreach(session('import_errors') as $err)
            <li class="text-xs text-red-600 dark:text-red-400">• {{ $err }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-end="opacity-0"
    class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-6">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
    </svg>
    <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
</div>
@endif

<!-- Action Buttons Bar -->
<div class="flex items-center justify-end gap-2 mb-6">

    {{-- Import --}}
    <button type="button" @click="$dispatch('buka-modal-import')"
        title="Import Data"
        class="inline-flex items-center gap-2 px-3 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
        </svg>
        <span class="hidden sm:inline">Import</span>
    </button>

    {{-- Export dropdown --}}
    @include('admin.partials.export-buttons', [
        'routeExcel' => 'admin.penduduk.export.excel',
        'routePdf' => 'admin.penduduk.export.pdf',
        'routeTemplate' => 'admin.penduduk.template',
    ])

    {{-- Tambah Penduduk --}}
    <a href="{{ route('admin.penduduk.create') }}"
        title="Tambah Penduduk"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span class="hidden sm:inline">Tambah Penduduk</span>
    </a>
</div>

{{-- ============================================================ --}}
{{-- STATS CARDS                                                  --}}
{{-- ============================================================ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <!-- Total Penduduk -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Penduduk</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($total_penduduk) }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Laki-laki -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Laki-laki</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($laki_laki) }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Perempuan -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Perempuan</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($perempuan) }}</p>
            </div>
            <div class="w-11 h-11 bg-pink-50 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Keluarga (KK) -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Keluarga (KK)</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($keluarga) }}</p>
            </div>
            <div class="w-11 h-11 bg-green-50 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- FILTER & SEARCH                                              --}}
{{-- ============================================================ --}}
<form method="GET" action="{{ route('admin.penduduk') }}"
    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 mb-6">
    <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
        Filter Data
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <!-- Search Input -->
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Pencarian</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nama atau NIK..."
                    class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>
        </div>

        <!-- Gender Filter -->
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                <option value="Semua" {{ request('jenis_kelamin') == 'Semua' ? 'selected' : '' }}>Semua</option>
                <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <!-- Religion Filter -->
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Agama</label>
            <select name="agama"
                class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                <option value="Semua Agama" {{ request('agama') == 'Semua Agama' ? 'selected' : '' }}>Semua Agama</option>
                <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Budha" {{ request('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-end gap-2">
            <button type="submit"
                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filter
            </button>
            <a href="{{ route('admin.penduduk') }}"
                title="Reset Filter"
                class="inline-flex items-center justify-center px-3 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-sm font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </a>
        </div>
    </div>
</form>

{{-- ============================================================ --}}
{{-- TABLE                                                        --}}
{{-- ============================================================ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
    @if($penduduk->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <p class="text-lg font-semibold text-gray-500 dark:text-slate-400">Tidak ada data penduduk</p>
        <p class="text-sm mt-1 dark:text-slate-500">Mulai dengan menambahkan data penduduk baru</p>
        <a href="{{ route('admin.penduduk.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Penduduk
        </a>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NIK</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kelamin</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Tempat Lahir</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Tgl Lahir</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Agama</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">Keluarga</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">Rumah Tangga</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">Gol. Darah</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($penduduk as $index => $p)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                    <td class="px-5 py-4 text-gray-400 dark:text-slate-500 font-medium">
                        {{ $penduduk->firstItem() + $index }}
                    </td>
                    <td class="px-5 py-4 text-sm font-mono font-medium text-gray-800 dark:text-slate-200">{{ $p->nik }}</td>
                    <td class="px-5 py-4 text-sm font-medium text-gray-900 dark:text-slate-100">{{ $p->nama }}</td>
                    <td class="px-5 py-4 text-sm">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $p->jenis_kelamin == 'L' ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' : 'bg-pink-100 dark:bg-pink-900/40 text-pink-700 dark:text-pink-300' }}">
                            {{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400 hidden md:table-cell">{{ $p->tempat_lahir }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400 hidden md:table-cell">{{ $p->tanggal_lahir->format('d/m/Y') }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400 hidden lg:table-cell">{{ $p->agama }}</td>
                    <td class="px-5 py-4 text-sm hidden lg:table-cell">
                        @php $currentKeluarga = $p->keluargas()->withPivot('hubungan_keluarga')->first(); @endphp
                        @if($currentKeluarga)
                        <div class="text-gray-800 dark:text-slate-200 font-medium">{{ $currentKeluarga->no_kk }}</div>
                        <div class="text-xs text-gray-400 dark:text-slate-500">{{ ucfirst(str_replace('_', ' ', $currentKeluarga->pivot->hubungan_keluarga)) }}</div>
                        @else
                        <span class="text-gray-400 dark:text-slate-500">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm hidden xl:table-cell">
                        @php $currentRumahTangga = $p->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first(); @endphp
                        @if($currentRumahTangga)
                        <div class="text-gray-800 dark:text-slate-200 font-medium">{{ $currentRumahTangga->no_rumah_tangga }}</div>
                        <div class="text-xs text-gray-400 dark:text-slate-500">{{ ucfirst(str_replace('_', ' ', $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}</div>
                        @else
                        <span class="text-gray-400 dark:text-slate-500">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400 hidden xl:table-cell">
                        @if($p->golongan_darah)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300">{{ $p->golongan_darah }}</span>
                        @else
                        <span class="text-gray-400 dark:text-slate-500">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-1.5">
                            {{-- Lihat --}}
                            <a href="{{ route('admin.penduduk.show', $p) }}"
                                title="Lihat Detail"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('admin.penduduk.edit', $p) }}"
                                title="Edit Data"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 border border-amber-100 dark:border-amber-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            {{-- Hapus --}}
                            <button type="button"
                                title="Hapus Data"
                                @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.penduduk.destroy', $p) }}',
                                    nama: '{{ addslashes($p->nama) }}'
                                })"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-100 dark:border-red-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Tidak ada data penduduk</p>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Mulai dengan menambahkan data penduduk baru</p>
                            <a href="{{ route('admin.penduduk.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                Tambah Penduduk
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($penduduk->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700">
        {{ $penduduk->links() }}
    </div>
    @endif
    @endif
</div>

{{-- Partials Modal --}}
@include('admin.partials.modal-import-penduduk')
@include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection

