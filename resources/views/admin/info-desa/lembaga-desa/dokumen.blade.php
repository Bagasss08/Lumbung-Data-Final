@extends('layouts.admin')

@section('title', 'Data Dokumen Lembaga')

@section('content')
<div x-data="{ perPage: {{ request('per_page', 10) }} }">

    {{-- ── Page Header with Breadcrumb ── --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100">Data Dokumen Lembaga</h2>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.lembaga-desa.index') }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                Data Lembaga
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Data Dokumen Lembaga</span>
        </nav>
    </div>

    {{-- ── Lembaga Info Banner ── --}}
    <div class="mb-4 px-4 py-3 bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 rounded-lg flex items-center gap-3">
        <svg class="w-5 h-5 text-sky-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <div class="text-sm">
            <span class="text-sky-600 dark:text-sky-400 font-medium">Lembaga: </span>
            <span class="text-gray-700 dark:text-slate-300 font-semibold">{{ $lembaga->nama ?? '-' }}</span>
            @if($lembaga->kode ?? null)
                <span class="ml-2 font-mono text-xs text-gray-500 dark:text-slate-500 bg-gray-100 dark:bg-slate-700 px-1.5 py-0.5 rounded">
                    {{ $lembaga->kode }}
                </span>
            @endif
        </div>
    </div>

    {{-- ── Action Buttons ── --}}
    <div class="flex flex-wrap items-center gap-2 mb-4">
        {{-- Tambah --}}
        <a href="{{ route('admin.lembaga-desa.dokumen.create', $lembaga->id) }}"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah
        </a>

        {{-- Hapus (bulk) --}}
        <button type="submit" form="bulk-delete-form"
            onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus
        </button>

        {{-- Kembali --}}
        <a href="{{ route('admin.lembaga-desa.index') }}"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- ── Main Card ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

        {{-- ── Filter Bar ── --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <form id="filter-form" method="GET" class="flex flex-wrap items-center gap-3">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                {{-- Status Aktif --}}
                <select name="aktif" onchange="document.getElementById('filter-form').submit()"
                    class="border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors min-w-[140px]">
                    <option value="">Pilih Status</option>
                    <option value="1" {{ request('aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                {{-- Search --}}
                <div class="ml-auto flex items-center gap-2" x-data="{ showTip: false }">
                    <label class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Cari:</label>
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="kata kunci pencarian"
                            maxlength="50"
                            @focus="showTip = true"
                            @blur="showTip = false"
                            class="border border-gray-300 dark:border-slate-600 rounded-md pl-3 pr-8 py-1.5 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors w-52">
                        <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div
                            x-show="showTip"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute right-0 top-full mt-1.5 z-50 w-64 bg-gray-800 dark:bg-slate-900 text-white text-xs rounded-md px-3 py-2 shadow-lg pointer-events-none leading-relaxed"
                            style="display:none">
                            <div class="absolute -top-1.5 right-4 w-3 h-3 bg-gray-800 dark:bg-slate-900 rotate-45 rounded-sm"></div>
                            Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── Table Controls: Tampilkan X entri ── --}}
        <div class="px-4 py-2.5 flex items-center justify-between border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
            <form method="GET" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                <input type="hidden" name="aktif" value="{{ request('aktif') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <label>Tampilkan</label>
                <select name="per_page" onchange="this.form.submit()"
                    class="border border-gray-300 dark:border-slate-600 rounded px-2 py-1 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 outline-none">
                    @foreach ([10, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
                <label>entri</label>
            </form>
        </div>

        {{-- ── Table ── --}}
        <form id="bulk-delete-form" action="{{ route('admin.lembaga-desa.dokumen.bulk-destroy', $lembaga->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-900/70 border-b border-gray-200 dark:border-slate-700">
                            {{-- Checkbox all --}}
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" id="dokumen-check-all"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>

                            {{-- NO --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap w-14">
                                NO
                            </th>

                            {{-- AKSI --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                AKSI
                            </th>

                            {{-- JUDUL --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'judul', 'dir' => request('sort') === 'judul' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    JUDUL
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'judul' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 0L10 6H0L5 0z"/></svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'judul' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 6L0 0H10L5 6z"/></svg>
                                    </span>
                                </a>
                            </th>

                            {{-- TAHUN --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tahun', 'dir' => request('sort') === 'tahun' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    TAHUN
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'tahun' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 0L10 6H0L5 0z"/></svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'tahun' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 6L0 0H10L5 6z"/></svg>
                                    </span>
                                </a>
                            </th>

                            {{-- AKTIF --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'aktif', 'dir' => request('sort') === 'aktif' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    AKTIF
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor"><path d="M5 0L10 6H0L5 0z"/></svg>
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor"><path d="M5 6L0 0H10L5 6z"/></svg>
                                    </span>
                                </a>
                            </th>

                            {{-- DIMUAT PADA --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'dir' => request('sort') === 'created_at' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    DIMUAT PADA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'created_at' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 0L10 6H0L5 0z"/></svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'created_at' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}" viewBox="0 0 10 6" fill="currentColor"><path d="M5 6L0 0H10L5 6z"/></svg>
                                    </span>
                                </a>
                            </th>

                            {{-- KETERANGAN --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                KETERANGAN
                            </th>

                            {{-- STATUS --}}
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'dir' => request('sort') === 'status' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    STATUS
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor"><path d="M5 0L10 6H0L5 0z"/></svg>
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor"><path d="M5 6L0 0H10L5 6z"/></svg>
                                    </span>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($dokumen as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors group">
                                {{-- Checkbox --}}
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                        class="dokumen-row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                </td>

                                {{-- No --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-center">
                                    {{ $dokumen->firstItem() + $index }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        {{-- Ubah Data --}}
                                        <a href="{{ route('admin.lembaga-desa.dokumen.edit', [$lembaga->id, $item->id]) }}"
                                            title="Ubah Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-orange-500 hover:bg-orange-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        {{-- Lihat / Preview --}}
                                        @if($item->file ?? null)
                                            <a href="{{ asset('storage/' . $item->file) }}"
                                                target="_blank"
                                                title="Lihat Dokumen"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Unduh --}}
                                        @if($item->file ?? null)
                                            <a href="{{ route('admin.lembaga-desa.dokumen.download', [$lembaga->id, $item->id]) }}"
                                                title="Unduh Dokumen"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded bg-teal-600 hover:bg-teal-700 text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                            </a>
                                        @endif

                                        {{-- Hapus --}}
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('admin.lembaga-desa.dokumen.destroy', [$lembaga->id, $item->id]) }}')"
                                            title="Hapus Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-rose-500 hover:bg-rose-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                {{-- Judul --}}
                                <td class="px-4 py-3 text-gray-800 dark:text-slate-200 font-medium max-w-xs">
                                    <div class="flex items-center gap-2">
                                        {{-- File type icon --}}
                                        @php
                                            $ext = $item->file ? strtolower(pathinfo($item->file, PATHINFO_EXTENSION)) : '';
                                        @endphp
                                        @if(in_array($ext, ['pdf']))
                                            <svg class="w-4 h-4 text-rose-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8.5 17.5h-1v-5h1.75c.97 0 1.75.78 1.75 1.75S10.22 16 9.25 16H8.5v1.5zm4.5 0h-1.5v-5H13c1.38 0 2.5 1.12 2.5 2.5S14.38 17.5 13 17.5zm4.5-3.5h-1v1h1v1h-1v1.5h-1v-5H18v1.5z"/>
                                            </svg>
                                        @elseif(in_array($ext, ['doc', 'docx']))
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @elseif(in_array($ext, ['xls', 'xlsx']))
                                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                        <span class="truncate">{{ $item->judul }}</span>
                                    </div>
                                </td>

                                {{-- Tahun --}}
                                <td class="px-4 py-3 text-gray-700 dark:text-slate-300 font-mono text-center">
                                    {{ $item->tahun ?? '-' }}
                                </td>

                                {{-- Aktif --}}
                                <td class="px-4 py-3 text-center">
                                    @if($item->aktif)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Ya
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Tidak
                                        </span>
                                    @endif
                                </td>

                                {{-- Dimuat Pada --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap text-xs">
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d F Y H:i:s') : '-' }}
                                </td>

                                {{-- Keterangan --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 max-w-xs">
                                    <span class="line-clamp-2">{{ $item->keterangan ?? '-' }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3">
                                    @if(($item->status ?? '') === 'Aktif' || $item->aktif)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-emerald-500 text-white">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-gray-400 dark:bg-slate-600 text-white">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium">Dokumen lembaga tidak ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        {{-- ── Footer: Info + Pagination ── --}}
        <div class="px-4 py-3 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/40 flex flex-col sm:flex-row items-center justify-between gap-3">
            {{-- Info entri --}}
            <p class="text-sm text-gray-600 dark:text-slate-400">
                Menampilkan
                <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $dokumen->firstItem() ?? 0 }}</span>
                sampai
                <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $dokumen->lastItem() ?? 0 }}</span>
                dari
                <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $dokumen->total() }}</span>
                entri
            </p>

            {{-- Pagination --}}
            <div class="flex items-center gap-1 text-sm">
                {{-- Sebelumnya --}}
                @if($dokumen->onFirstPage())
                    <span class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $dokumen->previousPageUrl() }}"
                        class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                        Sebelumnya
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($dokumen->getUrlRange(max(1, $dokumen->currentPage() - 2), min($dokumen->lastPage(), $dokumen->currentPage() + 2)) as $page => $url)
                    @if($page == $dokumen->currentPage())
                        <span class="px-3 py-1.5 rounded border border-emerald-500 bg-emerald-500 text-white font-semibold select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Selanjutnya --}}
                @if($dokumen->hasMorePages())
                    <a href="{{ $dokumen->nextPageUrl() }}"
                        class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                        Selanjutnya
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                        Selanjutnya
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Checkbox: select all
    document.getElementById('dokumen-check-all')?.addEventListener('change', function (e) {
        document.querySelectorAll('.dokumen-row-checkbox').forEach(cb => cb.checked = e.target.checked);
    });

    // Update check-all state when individual checkboxes change
    document.querySelectorAll('.dokumen-row-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const all = document.querySelectorAll('.dokumen-row-checkbox');
            const checked = document.querySelectorAll('.dokumen-row-checkbox:checked');
            const checkAll = document.getElementById('dokumen-check-all');
            if (checkAll) {
                checkAll.indeterminate = checked.length > 0 && checked.length < all.length;
                checkAll.checked = checked.length === all.length;
            }
        });
    });

    // Single delete confirm helper
    function confirmDelete(actionUrl) {
        if (!confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = actionUrl;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endpush

@endsectionw