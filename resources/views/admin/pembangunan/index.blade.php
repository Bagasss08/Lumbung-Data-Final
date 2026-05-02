@extends('layouts.admin')

@section('title', 'Pembangunan')

@section('content')

<div>

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Pembangunan</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data kegiatan pembangunan desa</p>
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
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Pembangunan</span>
        </nav>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="flex items-center gap-3 px-4 py-3 mb-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-sm">
            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span><strong>Berhasil</strong> — {{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl text-sm">
            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- CARD UTAMA --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700" style="overflow: visible">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.pembangunan-utama.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </a>
        </div>

        {{-- ── FILTER ── --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <form method="GET" id="form-filter-pembangunan" class="flex flex-wrap items-center gap-2">

                <input type="hidden" name="tahun" id="val-tahun" value="{{ request('tahun') }}">

                {{-- Dropdown Tahun --}}
                <div class="relative w-40" x-data="{
                    open: false,
                    search: '',
                    selected: '{{ request('tahun') }}',
                    placeholder: 'Pilih Tahun',
                    options: [
                        @foreach($tahunList as $t)
                            { value: '{{ $t }}', label: '{{ $t }}' },
                        @endforeach
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-tahun').value = opt.value;
                        this.open = false;
                        this.search = '';
                        document.getElementById('form-filter-pembangunan').submit();
                    },
                    reset() {
                        this.selected = '';
                        document.getElementById('val-tahun').value = '';
                        this.open = false;
                        this.search = '';
                        document.getElementById('form-filter-pembangunan').submit();
                    }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                        <span x-text="label || placeholder"
                            :class="label ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                        style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false"
                                placeholder="Cari tahun..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <li @click="reset()"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === '' ?
                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                    'text-gray-400 dark:text-slate-500 italic'">
                                Semua Tahun
                            </li>
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === opt.value ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                        'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                {{-- Reset Filter --}}
                @if(request()->hasAny(['tahun', 'search']))
                    <a href="{{ route('admin.pembangunan-utama.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @endif

            </form>
        </div>

        {{-- ── TOOLBAR: Tampilkan X entri + Search ── --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

            {{-- Tampilkan X entri --}}
            <form method="GET" action="{{ route('admin.pembangunan-utama.index') }}" id="form-per-page-pembangunan"
                class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                @foreach(request()->except('per_page', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="hidden" name="per_page" id="val-per-page-pembangunan" value="{{ request('per_page', 10) }}">

                <span>Tampilkan</span>

                <div class="relative w-24" x-data="{
                    open: false,
                    selected: '{{ request('per_page', 10) }}',
                    options: [
                        { value: '10', label: '10' },
                        { value: '25', label: '25' },
                        { value: '50', label: '50' },
                        { value: '100', label: '100' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-per-page-pembangunan').value = opt.value;
                        this.open = false;
                        document.getElementById('form-per-page-pembangunan').submit();
                    }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                        <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-1"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                        style="display:none">
                        <ul class="py-1">
                            <template x-for="opt in options" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === opt.value ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                        'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                <span>entri</span>
            </form>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.pembangunan-utama.index') }}" class="flex items-center gap-2">
                @foreach(request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="kata kunci pencarian" maxlength="50"
                        @input.debounce.400ms="$el.form.submit()"
                        class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                    <div class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                        <div class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                            Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                            <div class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700"></div>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        {{-- ── TABEL ── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">NO</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider" style="min-width:220px">AKSI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA KEGIATAN</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">SUMBER DANA</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">PAGU ANGGARAN</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">PERSENTASE</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">VOLUME</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">TAHUN</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">PELAKSANA</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">LOKASI</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-20">GAMBAR</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">

                    @forelse($pembangunan as $index => $item)
                        @php
                            $progres   = $item->dokumentasis->isNotEmpty()
                                ? (int) $item->dokumentasis->first()->persentase
                                : 0;
                            $total     = $item->total_anggaran;
                            $hasLokasi = $item->lat && $item->lng;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors {{ $item->status == 0 ? 'opacity-60' : '' }}">

                            {{-- NO --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                {{ $pembangunan->firstItem() + $index }}
                            </td>

                            {{-- AKSI --}}
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-1 flex-nowrap">

                                    {{-- 1. Edit (amber) --}}
                                    <a href="{{ route('admin.pembangunan-utama.edit', $item) }}" title="Ubah"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    {{-- 2. Lokasi (emerald) --}}
                                    <a href="{{ route('admin.pembangunan-utama.lokasi', $item) }}"
                                        title="{{ $hasLokasi ? 'Lihat/Ubah Lokasi' : 'Tentukan Lokasi' }}"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-white transition-colors
                                            {{ $hasLokasi ? 'bg-teal-500 hover:bg-teal-600' : 'bg-teal-400 hover:bg-teal-500' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>

                                    {{-- 3. Rincian / Dokumentasi (indigo) --}}
                                    <a href="{{ route('admin.pembangunan-utama.show', $item) }}" title="Rincian &amp; Dokumentasi"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </a>

                                    {{-- 4. Toggle Aktif/Non-Aktif (slate) --}}
                                    <form method="POST" action="{{ route('admin.pembangunan-utama.toggle-status', $item) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            title="{{ $item->status == 1 ? 'Non-Aktifkan' : 'Aktifkan' }}"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-white transition-colors
                                                {{ $item->status == 1 ? 'bg-slate-600 hover:bg-slate-700' : 'bg-gray-400 hover:bg-gray-500' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- 5. Hapus (red) --}}
                                    <form method="POST" action="{{ route('admin.pembangunan-utama.destroy', $item) }}" class="inline"
                                        onsubmit="return confirm('Hapus kegiatan \'{{ addslashes($item->nama) }}\' beserta semua dokumentasinya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- 6. Preview publik (sky) --}}
                                    @if(\Illuminate\Support\Facades\Route::has('pembangunan.show'))
                                        <a href="{{ route('pembangunan.show', $item) }}" target="_blank"
                                            title="Lihat di Website Publik"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-sky-400 hover:bg-sky-500 text-white transition-colors">
                                    @else
                                        <span title="Halaman publik belum tersedia"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-sky-200 dark:bg-sky-900/30 text-sky-400 cursor-not-allowed opacity-50">
                                    @endif
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                    @if(\Illuminate\Support\Facades\Route::has('pembangunan.show'))
                                        </a>
                                    @else
                                        </span>
                                    @endif

                                </div>
                            </td>

                            {{-- NAMA KEGIATAN --}}
                            <td class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 max-w-xs">
                                <span class="line-clamp-2 text-sm" title="{{ $item->nama }}">{{ $item->nama }}</span>
                            </td>

                            {{-- SUMBER DANA --}}
                            <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 hidden lg:table-cell whitespace-nowrap">
                                {{ $item->sumberDana?->nama ?? '—' }}
                            </td>

                            {{-- PAGU ANGGARAN --}}
                            <td class="px-3 py-3 text-sm text-gray-700 dark:text-slate-300 hidden lg:table-cell whitespace-nowrap">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>

                            {{-- PERSENTASE --}}
                            <td class="px-3 py-3 hidden xl:table-cell">
                                @if($progres > 0)
                                    <div class="flex items-center gap-2 min-w-[100px]">
                                        <div class="flex-1 h-1.5 bg-gray-200 dark:bg-slate-600 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full
                                                {{ $progres >= 100 ? 'bg-emerald-500' : ($progres >= 50 ? 'bg-blue-500' : 'bg-amber-400') }}"
                                                style="width:{{ $progres }}%">
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-600 dark:text-slate-400 whitespace-nowrap">{{ $progres }}%</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-slate-500">belum ada progres</span>
                                @endif
                            </td>

                            {{-- VOLUME --}}
                            <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 hidden xl:table-cell whitespace-nowrap">
                                @if($item->volume)
                                    {{ rtrim(rtrim(number_format((float)$item->volume, 2, ',', '.'), '0'), ',') }}
                                    {{ $item->satuan ?? '' }}
                                @else
                                    —
                                @endif
                            </td>

                            {{-- TAHUN --}}
                            <td class="px-3 py-3 text-sm text-center text-gray-700 dark:text-slate-300 hidden lg:table-cell">
                                {{ $item->tahun_anggaran }}
                            </td>

                            {{-- PELAKSANA --}}
                            <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 hidden xl:table-cell">
                                {{ $item->pelaksana ?? '—' }}
                            </td>

                            {{-- LOKASI --}}
                            <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 hidden xl:table-cell">
                                @if($item->lokasi)
                                    {{ $item->lokasi->dusun ?? '' }}
                                    @if($item->lokasi->rw) / RW {{ $item->lokasi->rw }} @endif
                                    @if($item->lokasi->rt) RT {{ $item->lokasi->rt }} @endif
                                @elseif($item->lat && $item->lng)
                                    <span class="font-mono text-gray-400 dark:text-slate-500 text-xs">
                                        {{ number_format((float)$item->lat, 5) }},
                                        {{ number_format((float)$item->lng, 5) }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>

                            {{-- GAMBAR --}}
                            <td class="px-3 py-3 text-center">
                                @if($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $item->foto) }}"
                                            alt="{{ $item->nama }}"
                                            class="w-11 h-9 object-cover rounded-lg border border-gray-200 dark:border-slate-600 mx-auto hover:opacity-80 transition-opacity">
                                    </a>
                                @else
                                    <span class="text-gray-300 dark:text-slate-600 text-xs">—</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia pada tabel ini</p>
                                    <p class="text-gray-400 dark:text-slate-500 text-sm">Silakan tambah kegiatan pembangunan baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                @if($pembangunan->total() > 0)
                    Menampilkan {{ $pembangunan->firstItem() }} sampai {{ $pembangunan->lastItem() }} dari
                    {{ number_format($pembangunan->total()) }} entri
                    @if(request()->hasAny(['search', 'tahun']))
                        <span class="text-gray-400 dark:text-slate-500">(difilter)</span>
                    @endif
                @else
                    Menampilkan 0 sampai 0 dari 0 entri
                @endif
            </p>
            <div class="flex items-center gap-1">

                @if($pembangunan->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $pembangunan->appends(request()->query())->previousPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                @endif

                @php
                    $cp    = $pembangunan->currentPage();
                    $lp    = $pembangunan->lastPage();
                    $start = max(1, $cp - 2);
                    $end   = min($lp, $cp + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $pembangunan->appends(request()->query())->url(1) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                    @if($start > 2)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                @endif

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $cp)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                    @else
                        <a href="{{ $pembangunan->appends(request()->query())->url($p) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                    @endif
                @endfor

                @if($end < $lp)
                    @if($end < $lp - 1)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                    <a href="{{ $pembangunan->appends(request()->query())->url($lp) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lp }}</a>
                @endif

                @if($pembangunan->hasMorePages())
                    <a href="{{ $pembangunan->appends(request()->query())->nextPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                @endif

            </div>
        </div>

    </div>{{-- /.card --}}

</div>

@endsection