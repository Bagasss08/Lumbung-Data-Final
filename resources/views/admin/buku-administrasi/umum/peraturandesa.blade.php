@extends('layouts.admin')

@section('title', 'Buku Peraturan di Desa')

@section('content')
<div x-data>

@include('admin.partials.modal-hapus')

{{-- PAGE HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Buku Peraturan di Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola dan pantau peraturan desa dengan mudah</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.buku-administrasi.umum.index') }}"
           class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            Buku Administrasi Umum
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Peraturan Desa</span>
    </nav>
</div>

{{-- CARD TUNGGAL: Tombol Aksi + Filter + Tabel --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

    {{-- Baris Tombol Aksi --}}
    <div class="flex items-center gap-2 px-5 pt-5 pb-4">
        <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
    </div>

    {{-- Baris Filter --}}
    <div class="px-5 pb-4">
        <form method="GET" action="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" id="form-filter"
              class="flex flex-wrap items-center gap-2">

            <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">
            <input type="hidden" name="jenis"  id="val-jenis"  value="{{ request('jenis') }}">
            <input type="hidden" name="tahun"  id="val-tahun"  value="{{ request('tahun') }}">

            {{-- ── Custom Dropdown: Status ── --}}
            <div class="relative w-40"
                 x-data="{
                    open: false,
                    selected: '{{ request('status') }}',
                    label: '{{ request('status') === '1' ? 'Aktif' : (request('status') === '0' ? 'Tidak Aktif' : '') }}',
                    placeholder: 'Status',
                    options: [
                        { value: '',  label: 'Semua Status'  },
                        { value: '1', label: 'Aktif'         },
                        { value: '0', label: 'Tidak Aktif'   },
                    ],
                    choose(opt) {
                        this.selected = opt.value;
                        this.label    = opt.value !== '' ? opt.label : '';
                        document.getElementById('val-status').value = opt.value;
                        this.open = false;
                        document.getElementById('form-filter').submit();
                    }
                 }"
                 @click.away="open = false">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                           bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                           border-gray-300 dark:border-slate-600
                           hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                    <span x-text="label || placeholder" :class="label ? '' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="absolute left-0 top-full mt-1 w-full z-50
                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                            rounded-lg shadow-lg overflow-hidden"
                     style="display:none">
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in options" :key="opt.value">
                            <li @click="choose(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === opt.value
                                    ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white'
                                    : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            {{-- ── Custom Dropdown: Jenis Peraturan ── --}}
            <div class="relative w-52"
                 x-data="{
                    open: false,
                    selected: '{{ request('jenis') }}',
                    label: '{{ request('jenis') ?: '' }}',
                    placeholder: 'Jenis Peraturan',
                    options: [
                        { value: '',                      label: 'Semua Jenis'             },
                        { value: 'Peraturan Desa',        label: 'Peraturan Desa'          },
                        { value: 'Peraturan Kepala Desa', label: 'Peraturan Kepala Desa'   },
                    ],
                    choose(opt) {
                        this.selected = opt.value;
                        this.label    = opt.value ? opt.label : '';
                        document.getElementById('val-jenis').value = opt.value;
                        this.open = false;
                        document.getElementById('form-filter').submit();
                    }
                 }"
                 @click.away="open = false">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                           bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                           border-gray-300 dark:border-slate-600
                           hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                    <span x-text="label || placeholder" :class="label ? '' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="absolute left-0 top-full mt-1 w-full z-50
                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                            rounded-lg shadow-lg overflow-hidden"
                     style="display:none">
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in options" :key="opt.value">
                            <li @click="choose(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === opt.value
                                    ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white'
                                    : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            {{-- ── Custom Dropdown: Tahun ── --}}
            <div class="relative w-36"
                 x-data="{
                    open: false,
                    search: '',
                    selected: '{{ request('tahun') }}',
                    label: '{{ request('tahun') ?: '' }}',
                    placeholder: 'Tahun',
                    options: [
                        { value: '', label: 'Semua Tahun' },
                        @for ($year = date('Y'); $year >= 2020; $year--)
                        { value: '{{ $year }}', label: '{{ $year }}' },
                        @endfor
                    ],
                    get filtered() {
                        if (!this.search) return this.options;
                        return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    choose(opt) {
                        this.selected = opt.value;
                        this.label    = opt.value ? opt.label : '';
                        document.getElementById('val-tahun').value = opt.value;
                        this.open   = false;
                        this.search = '';
                        document.getElementById('form-filter').submit();
                    }
                 }"
                 @click.away="open = false">
                <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                           bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                           border-gray-300 dark:border-slate-600
                           hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                    <span x-text="label || placeholder" :class="label ? '' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="absolute left-0 top-full mt-1 w-full z-50
                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                            rounded-lg shadow-lg overflow-hidden"
                     style="display:none">
                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                        <input type="text" x-model="search"
                               @keydown.escape="open = false"
                               placeholder="Cari tahun..."
                               class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                      border border-gray-200 dark:border-slate-600 rounded
                                      text-gray-700 dark:text-slate-200 outline-none
                                      focus:border-emerald-500">
                    </div>
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in filtered" :key="opt.value">
                            <li @click="choose(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === opt.value
                                    ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white'
                                    : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                        <li x-show="filtered.length === 0"
                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center">
                            Tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Reset Filter --}}
            @if(request()->hasAny(['status', 'jenis', 'tahun', 'search', 'per_page']))
            <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}"
               class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-600 dark:text-slate-400 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </a>
            @endif

        </form>
    </div>

    {{-- Toolbar atas tabel: Tampilkan X entri + Search --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-200 dark:border-slate-700">

        {{-- Tampilkan X entri --}}
        <form method="GET" action="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
            @foreach(request()->except('per_page', 'page') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <span>Tampilkan</span>
            <select name="per_page" onchange="this.form.submit()"
                class="px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                       bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                       focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                @foreach([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
            <span>entri</span>
        </form>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="flex items-center gap-2">
            @foreach(request()->except('search', 'page') as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endforeach
            <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Judul atau nomor peraturan..."
                   class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                          bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                          focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-60">
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-32">AKSI</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">JUDUL</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">JENIS PERATURAN</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">NO. & TGL DITETAPKAN</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">URAIAN SINGKAT</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">STATUS</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">DIMUAT PADA</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($data_peraturan as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">
                        {{ $data_peraturan->firstItem() + $index }}
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.show', $item->id) }}" title="Lihat"
                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.edit', $item->id) }}" title="Edit"
                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button" title="Hapus"
                                @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.buku-administrasi.umum.peraturan-desa.destroy', $item->id) }}',
                                    nama: '{{ addslashes($item->judul) }}'
                                })"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-slate-100">
                        {{ $item->judul }}
                    </td>

                    <td class="px-4 py-4 text-sm hidden md:table-cell">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                            bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                            {{ $item->jenis_peraturan }}
                        </span>
                    </td>

                    <td class="px-4 py-4 text-sm hidden md:table-cell">
                        <div class="font-medium text-gray-800 dark:text-slate-200">{{ $item->nomor_ditetapkan }}</div>
                        <div class="text-xs text-gray-400 dark:text-slate-500">
                            {{ $item->tanggal_ditetapkan ? $item->tanggal_ditetapkan->format('d M Y') : '—' }}
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400 hidden lg:table-cell max-w-xs">
                        {{ Str::limit($item->uraian_singkat, 60) }}
                    </td>

                    <td class="px-4 py-4 text-sm text-center hidden lg:table-cell">
                        @if($item->is_aktif)
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                Aktif
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400 hidden lg:table-cell">
                        {{ $item->dimuat_pada ? $item->dimuat_pada->format('d M Y') : '—' }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia</p>
                            <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah data peraturan desa baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer: info entri + pagination --}}
    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
        <p class="text-sm text-gray-500 dark:text-slate-400">
            @if($data_peraturan->total() > 0)
                Menampilkan {{ $data_peraturan->firstItem() }}–{{ $data_peraturan->lastItem() }} dari {{ $data_peraturan->total() }} entri
                @if(request('search'))
                    (difilter dari total entri)
                @endif
            @else
                Menampilkan 0 entri
            @endif
        </p>

        <div class="flex items-center gap-1">
            @if($data_peraturan->onFirstPage())
                <span class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
            @else
                <a href="{{ $data_peraturan->appends(request()->query())->previousPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Sebelumnya</a>
            @endif

            @php
                $currentPage = $data_peraturan->currentPage();
                $lastPage    = $data_peraturan->lastPage();
                $start       = max(1, $currentPage - 2);
                $end         = min($lastPage, $currentPage + 2);
            @endphp

            @if($start > 1)
                <a href="{{ $data_peraturan->appends(request()->query())->url(1) }}"
                   class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">1</a>
                @if($start > 2)
                    <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                @endif
            @endif

            @for($page = $start; $page <= $end; $page++)
                @if($page == $currentPage)
                    <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $data_peraturan->appends(request()->query())->url($page) }}"
                       class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                @endif
                <a href="{{ $data_peraturan->appends(request()->query())->url($lastPage) }}"
                   class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $lastPage }}</a>
            @endif

            @if($data_peraturan->hasMorePages())
                <a href="{{ $data_peraturan->appends(request()->query())->nextPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Selanjutnya</a>
            @else
                <span class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
            @endif
        </div>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection