@extends('layouts.admin')

@section('title', 'Pemerintah Desa')

@section('content')

{{-- x-data wrapper untuk checkbox, modal, dan filter --}}
<div x-data="{
    selectedIds: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedIds = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
        } else {
            this.selectedIds = [];
        }
    },
    toggleOne() {
        const all = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
        this.selectAll = all.length > 0 && all.every(id => this.selectedIds.includes(id));
    }
}">

    {{-- ============================================================ --}}
    {{-- PAGE HEADER & BREADCRUMB                                     --}}
    {{-- ============================================================ --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Pemerintah Desa</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data perangkat dan BPD desa</p>
        </div>
        
        <div class="flex items-center gap-3">
            <nav class="flex items-center gap-1.5 text-sm hidden md:flex mr-2">
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
                <a href="{{ route('admin.buku-administrasi.umum.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                    Buku Umum
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Pemerintah Desa</span>
            </nav>

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.buku-administrasi.umum.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-300 text-xs font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CARD TUNGGAL: Tombol Aksi + Filter + Tabel + Pagination      --}}
    {{-- ============================================================ --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

        {{-- 1. Baris Tombol Aksi --}}
        <div class="flex items-center gap-2 px-5 pt-5 pb-4">
            {{-- Tambah --}}
            <a href="{{ route('admin.buku-administrasi.umum.pemerintah.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-lg shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Perangkat
            </a>

            {{-- Hapus Bulk --}}
            <button type="button"
                :disabled="selectedIds.length === 0"
                @click="
                    let query = selectedIds.map(id => 'ids[]=' + id).join('&');
                    $dispatch('buka-modal-hapus', { 
                        action: '/admin/buku-administrasi/umum/pemerintah/bulk-destroy?' + query, 
                        nama: selectedIds.length + ' data terpilih' 
                    })
                "
                :class="selectedIds.length > 0
                    ? 'bg-red-500 hover:bg-red-600 cursor-pointer shadow-md shadow-red-500/20'
                    : 'bg-red-300 dark:bg-red-900/50 cursor-not-allowed opacity-60'"
                class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Terpilih
                <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
            </button>
        </div>

        {{-- 2. Baris Filter Custom --}}
        <div class="px-5 pb-4">
            <form method="GET" action="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" id="form-filter"
                  class="flex flex-wrap items-center gap-2">

                <input type="hidden" name="golongan" id="val-golongan" value="{{ request('golongan') }}">
                <input type="hidden" name="status"   id="val-status"   value="{{ request('status') }}">

                {{-- Dropdown: Golongan --}}
                <div class="relative w-48"
                     x-data="{
                        open: false,
                        selected: '{{ request('golongan') }}',
                        label: '{{ request('golongan') === 'pemerintah_desa' ? 'Pemerintah Desa' : (request('golongan') === 'bpd' ? 'BPD' : '') }}',
                        placeholder: 'Semua Golongan',
                        options: [
                            { value: '', label: 'Semua Golongan' },
                            { value: 'pemerintah_desa', label: 'Pemerintah Desa' },
                            { value: 'bpd', label: 'BPD' }
                        ],
                        choose(opt) {
                            this.selected = opt.value;
                            this.label = opt.value ? opt.label : '';
                            document.getElementById('val-golongan').value = opt.value;
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

                {{-- Dropdown: Status --}}
                <div class="relative w-40"
                     x-data="{
                        open: false,
                        selected: '{{ request('status') }}',
                        label: '{{ request('status') === '1' ? 'Aktif' : (request('status') === '2' ? 'Non-Aktif' : '') }}',
                        placeholder: 'Semua Status',
                        options: [
                            { value: '', label: 'Semua Status' },
                            { value: '1', label: 'Aktif' },
                            { value: '2', label: 'Non-Aktif' }
                        ],
                        choose(opt) {
                            this.selected = opt.value;
                            this.label = opt.value ? opt.label : '';
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

                {{-- Reset Filter Button --}}
                @if(request()->hasAny(['search','status','golongan']))
                <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}"
                    class="px-3 py-2 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg text-sm border border-gray-200 dark:border-slate-600 hover:bg-gray-200 dark:hover:bg-slate-600 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset
                </a>
                @endif
            </form>
        </div>

        {{-- 3. Toolbar Atas Tabel (Tampilkan X entri & Search) --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50">
            
            {{-- Tampilkan X entri --}}
            <form method="GET" action="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
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
            <form method="GET" action="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" class="flex items-center gap-2">
                @foreach(request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama atau NIK..."
                           class="pl-3 pr-8 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                    @if(request('search'))
                        <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index', request()->except('search', 'page')) }}" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- 4. Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-5 py-4 w-12">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                   class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-10">NO</th>
                        
                        {{-- KOLOM AKSI --}}
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-32">AKSI</th>
                        
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">PERANGKAT</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">JABATAN</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">NO. SK</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">PERIODE</th>
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($perangkat as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                        :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' : ''">
                        
                        {{-- Checkbox --}}
                        <td class="px-5 py-4">
                            <input type="checkbox"
                                   class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                   value="{{ $item->id }}"
                                   x-model="selectedIds"
                                   @change="toggleOne()">
                        </td>

                        {{-- NO --}}
                        <td class="px-5 py-4 text-sm text-gray-500 dark:text-slate-400">
                            {{ $perangkat->firstItem() + $index }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.buku-administrasi.umum.pemerintah.show', $item->id) }}" title="Detail"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.buku-administrasi.umum.pemerintah.edit', $item->id) }}" title="Edit"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button type="button" title="Hapus"
                                    @click="$dispatch('buka-modal-hapus', {
                                        action: '/admin/buku-administrasi/umum/pemerintah/{{ $item->id }}',
                                        nama: '{{ addslashes($item->nama) }}'
                                    })"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>

                        {{-- Perangkat (Foto, Nama, NIK) --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-emerald-50 dark:bg-emerald-900/30">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-500 dark:text-emerald-400 font-bold text-sm">
                                        {{ strtoupper(substr($item->nama, 0, 2)) }}
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900 dark:text-slate-100">{{ $item->nama }}</p>
                                    <p class="text-xs font-mono text-gray-400 dark:text-slate-500">{{ $item->nik ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Jabatan --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-800 dark:text-slate-200">{{ $item->jabatan->nama ?? '-' }}</p>
                            <span class="text-xs px-2 py-0.5 mt-1 inline-block rounded-full font-semibold
                                {{ $item->jabatan?->golongan === 'bpd' 
                                    ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' 
                                    : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' }}">
                                {{ $item->jabatan?->label_golongan ?? '-' }}
                            </span>
                        </td>

                        {{-- No SK --}}
                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-400">
                            {{ $item->no_sk ?? '-' }}
                        </td>

                        {{-- Periode --}}
                        <td class="px-5 py-4 text-gray-500 dark:text-slate-400 text-xs">
                            @if($item->periode_mulai)
                                {{ \Carbon\Carbon::parse($item->periode_mulai)->format('d/m/Y') }}
                                @if($item->periode_selesai)
                                    <br>– {{ \Carbon\Carbon::parse($item->periode_selesai)->format('d/m/Y') }}
                                @endif
                            @else
                                -
                            @endif
                        </td>

                        {{-- Status Toggle --}}
                        <td class="px-5 py-4 text-center">
                            <button onclick="toggleStatus({{ $item->id }}, this)" data-status="{{ $item->status }}"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all {{ $item->badge_status }}">
                                {{ $item->label_status }}
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-slate-400 font-medium">Belum ada data perangkat</p>
                                <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan klik "Tambah Perangkat" untuk menambahkan data</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 5. Footer Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                @if($perangkat->total() > 0)
                    Menampilkan {{ $perangkat->firstItem() }}–{{ $perangkat->lastItem() }} dari {{ $perangkat->total() }} entri
                    @if(request()->hasAny(['search','status','golongan']))
                        (difilter dari total entri)
                    @endif
                @else
                    Menampilkan 0 entri
                @endif
            </p>

            <div class="flex items-center gap-1">
                @if($perangkat->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $perangkat->appends(request()->query())->previousPageUrl() }}"
                       class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Sebelumnya</a>
                @endif

                @php
                    $currentPage = $perangkat->currentPage();
                    $lastPage    = $perangkat->lastPage();
                    $start       = max(1, $currentPage - 2);
                    $end         = min($lastPage, $currentPage + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $perangkat->appends(request()->query())->url(1) }}"
                       class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">1</a>
                    @if($start > 2)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                @endif

                @for($page = $start; $page <= $end; $page++)
                    @if($page == $currentPage)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $perangkat->appends(request()->query())->url($page) }}"
                           class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                    @endif
                @endfor

                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                    <a href="{{ $perangkat->appends(request()->query())->url($lastPage) }}"
                       class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $lastPage }}</a>
                @endif

                @if($perangkat->hasMorePages())
                    <a href="{{ $perangkat->appends(request()->query())->nextPageUrl() }}"
                       class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Selanjutnya</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Hapus Component --}}
    @include('admin.partials.modal-hapus')

</div> {{-- end x-data wrapper --}}
@endsection

@section('scripts')
<script>
    // ── Toggle Status JS ────────────────────────────────────────────
    function toggleStatus(id, btn) {
        fetch(`/admin/buku-administrasi/umum/pemerintah/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const isAktif = data.status === '1';
                btn.textContent  = isAktif ? 'Aktif' : 'Non-Aktif';
                btn.dataset.status = data.status;
                btn.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all '
                    + (isAktif ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400');
            }
        })
        .catch(err => console.error('Error:', err));
    }
</script>
@endsection