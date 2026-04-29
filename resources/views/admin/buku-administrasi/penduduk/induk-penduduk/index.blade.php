@extends('layouts.admin')

@section('title', 'Buku Induk Penduduk')

@section('content')
    <div x-data>

        {{-- ============================================================ --}}
        {{-- HEADER                                                       --}}
        {{-- ============================================================ --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Buku Induk Penduduk</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Data induk kependudukan desa</p>
            </div>
            <div class="flex items-center gap-1.5">
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
                    <a href="{{ route('admin.buku-administrasi.penduduk.index') }}" ...>
                        Administrasi Penduduk
                    </a>
                    <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-600 dark:text-slate-300 font-medium">Buku Induk</span>
                </nav>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-6">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ============================================================ --}}
        {{-- ACTION BUTTONS                                               --}}
        {{-- ============================================================ --}}
        <div class="flex items-center justify-between gap-2 mb-6">

            {{-- Label Buku --}}
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-700 dark:text-slate-200">Buku I</p>
                    <p class="text-xs text-gray-400 dark:text-slate-500">Induk Penduduk</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Export Excel --}}
                <a href="{{ route('admin.buku-administrasi.penduduk.induk-penduduk.export.excel') }}" title="Export Excel"
                    class="inline-flex items-center gap-2 px-3 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Excel</span>
                </a>

                {{-- Export PDF --}}
                <a href="{{ route('admin.buku-administrasi.penduduk.induk-penduduk.export.pdf') }}" title="Export PDF"
                    class="inline-flex items-center gap-2 px-3 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="hidden sm:inline">PDF</span>
                </a>

                {{-- Cetak --}}
                <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-3 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span class="hidden sm:inline">Cetak</span>
                </button>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- STATS CARDS                                                  --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-3 gap-4 mb-6">

            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Penduduk</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($total) }}</p>
                    </div>
                    <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Laki-laki</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($laki) }}</p>
                    </div>
                    <div
                        class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Perempuan</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">
                            {{ number_format($perempuan) }}</p>
                    </div>
                    <div class="w-11 h-11 bg-pink-50 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- FILTER                                                       --}}
        {{-- ============================================================ --}}
        <form method="GET" action="{{ route('admin.buku-administrasi.penduduk.induk-penduduk.index') }}"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 mb-6">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filter Data
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

                {{-- Search --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nama atau NIK..."
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="Semua" {{ request('jenis_kelamin', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua
                        </option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>

                {{-- Agama --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Agama</label>
                    <select name="agama"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="Semua Agama"
                            {{ request('agama', 'Semua Agama') == 'Semua Agama' ? 'selected' : '' }}>Semua Agama</option>
                        <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ request('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                    </select>
                </div>

                {{-- Status Perkawinan --}}
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Status
                        Perkawinan</label>
                    <select name="status_perkawinan"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="Semua" {{ request('status_perkawinan', 'Semua') == 'Semua' ? 'selected' : '' }}>
                            Semua</option>
                        <option value="Belum Kawin" {{ request('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>
                            Belum Kawin</option>
                        <option value="Kawin" {{ request('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin
                        </option>
                        <option value="Cerai Hidup" {{ request('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>
                            Cerai Hidup</option>
                        <option value="Cerai Mati" {{ request('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>
                            Cerai Mati</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.buku-administrasi.penduduk.induk-penduduk.index') }}" title="Reset Filter"
                        class="inline-flex items-center justify-center px-3 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400 text-sm rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </a>
                </div>
            </div>
        </form>

        {{-- ============================================================ --}}
        {{-- TABLE                                                        --}}
        {{-- ============================================================ --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

            @if ($penduduk->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-lg font-semibold text-gray-500 dark:text-slate-400">Tidak ada data ditemukan</p>
                    <p class="text-sm mt-1 dark:text-slate-500">Coba ubah filter pencarian Anda</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                                    No</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NIK</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    Nama Lengkap</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    L/P</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">
                                    Tempat, Tgl Lahir</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                    Agama</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                    Status Kawin</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                    Pendidikan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                    Pekerjaan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                    No. KK</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @foreach ($penduduk as $index => $p)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">

                                    {{-- No --}}
                                    <td class="px-4 py-4 text-gray-400 dark:text-slate-500 font-medium text-xs">
                                        {{ $penduduk->firstItem() + $index }}
                                    </td>

                                    {{-- NIK --}}
                                    <td
                                        class="px-4 py-4 font-mono font-medium text-gray-800 dark:text-slate-200 text-xs whitespace-nowrap">
                                        {{ $p->nik }}
                                    </td>

                                    {{-- Nama --}}
                                    <td
                                        class="px-4 py-4 font-semibold text-gray-900 dark:text-slate-100 whitespace-nowrap">
                                        {{ $p->nama }}
                                    </td>

                                    {{-- Jenis Kelamin --}}
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $p->jenis_kelamin == 'L'
                                ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300'
                                : 'bg-pink-100 dark:bg-pink-900/40 text-pink-700 dark:text-pink-300' }}">
                                            {{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                        </span>
                                    </td>

                                    {{-- Tempat & Tanggal Lahir --}}
                                    <td
                                        class="px-4 py-4 text-gray-600 dark:text-slate-400 hidden md:table-cell whitespace-nowrap">
                                        <span>{{ $p->tempat_lahir }},</span>
                                        <span
                                            class="block text-xs text-gray-400 dark:text-slate-500">{{ $p->tanggal_lahir->format('d/m/Y') }}</span>
                                    </td>

                                    {{-- Agama --}}
                                    <td class="px-4 py-4 text-gray-600 dark:text-slate-400 hidden lg:table-cell">
                                        {{ $p->agama ?? '—' }}
                                    </td>

                                    {{-- Status Perkawinan --}}
                                    <td class="px-4 py-4 hidden lg:table-cell">
                                        @php
                                            $statusColor = match ($p->status_perkawinan ?? '') {
                                                'Kawin'
                                                    => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                                                'Belum Kawin'
                                                    => 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400',
                                                'Cerai Hidup'
                                                    => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300',
                                                'Cerai Mati'
                                                    => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300',
                                                default => 'bg-gray-100 dark:bg-slate-700 text-gray-500',
                                            };
                                        @endphp
                                        @if ($p->status_perkawinan)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $p->status_perkawinan }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 dark:text-slate-500">—</span>
                                        @endif
                                    </td>

                                    {{-- Pendidikan --}}
                                    <td class="px-4 py-4 text-gray-600 dark:text-slate-400 hidden xl:table-cell text-xs">
                                        {{ $p->pendidikan ?? '—' }}
                                    </td>

                                    {{-- Pekerjaan --}}
                                    <td class="px-4 py-4 text-gray-600 dark:text-slate-400 hidden xl:table-cell text-xs">
                                        {{ $p->pekerjaan ?? '—' }}
                                    </td>

                                    {{-- No KK --}}
                                    <td class="px-4 py-4 hidden xl:table-cell">
                                        @php $kk = $p->keluarga; @endphp
                                        @if ($kk)
                                            <div class="font-mono text-xs font-medium text-gray-800 dark:text-slate-200">
                                                {{ $kk->no_kk }}</div>
                                            <div class="text-xs text-gray-400 dark:text-slate-500">
                                                {{ $p->label_shdk }}</div>
                                        @else
                                            <span class="text-gray-400 dark:text-slate-500">—</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.penduduk.show', $p) }}" title="Lihat Detail"
                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all hover:scale-110">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($penduduk->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700">
                        {{ $penduduk->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
@endsection
