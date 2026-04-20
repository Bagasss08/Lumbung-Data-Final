@extends('layouts.admin')

@section('title', 'Dokumen / Kelengkapan — ' . $penduduk->nama)

@section('content')
@php
    /**
     * URL dasar untuk update dokumen — dipakai Alpine x-bind:action
     * Teknik: generate route dengan dummy ID "0", lalu strip angka-nya
     * sehingga Alpine bisa append editDokumen.id secara dinamis.
     */
    $dokumenUpdateBase = rtrim(
        preg_replace('/\/0$/', '', route('admin.penduduk.dokumen.update', [$penduduk, 0])),
        '/'
    );
@endphp

<div x-data="{
    showModalTambah: false,
    showModalEdit:   false,
    editDokumen:     { id: null, nama_dokumen: '', jenis_dokumen: '' },
    selectedIds:     [],

    toggleAll(checked) {
        this.selectedIds = checked
            ? [...document.querySelectorAll('.row-check')].map(el => el.value)
            : [];
        document.querySelector('#check-all').indeterminate = false;
    },
    toggleOne(val, checked) {
        if (checked) { this.selectedIds.push(String(val)); }
        else          { this.selectedIds = this.selectedIds.filter(v => v !== String(val)); }
        const all   = document.querySelectorAll('.row-check');
        const total = all.length;
        const cnt   = this.selectedIds.length;
        const chk   = document.querySelector('#check-all');
        if (chk) {
            chk.checked       = cnt === total && total > 0;
            chk.indeterminate = cnt > 0 && cnt < total;
        }
    },
    openEdit(id, nama, jenis) {
        this.editDokumen = { id: String(id), nama_dokumen: nama, jenis_dokumen: jenis };
        this.showModalEdit = true;
    },
    get editFormAction() {
        return '{{ $dokumenUpdateBase }}/' + this.editDokumen.id;
    }
}">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Dokumen / Kelengkapan Penduduk</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Upload dan kelola dokumen pendukung penduduk</p>
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
            <a href="{{ route('admin.penduduk') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">
                Data Penduduk
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Dokumen / Kelengkapan</span>
        </nav>
    </div>

    {{-- ── FLASH MESSAGES (satu sumber saja — jika layout sudah ada, hapus blok ini) ── --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-end="opacity-0 -translate-y-1"
             class="flex items-center gap-3 p-4 mb-5 bg-emerald-50 dark:bg-emerald-900/20
                    border border-emerald-200 dark:border-emerald-800 rounded-xl">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
            <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-end="opacity-0 -translate-y-1"
             class="flex items-center gap-3 p-4 mb-5 bg-red-50 dark:bg-red-900/20
                    border border-red-200 dark:border-red-800 rounded-xl">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold text-red-700 dark:text-red-300">{{ session('error') }}</p>
            <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- ── MAIN CARD ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

            {{-- Tambah --}}
            <button type="button" @click="showModalTambah = true"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600
                       text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </button>

            {{-- Hapus Bulk — hanya muncul saat ada yang dicentang --}}
            <button type="button"
                x-show="selectedIds.length > 0"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click="if(confirm('Hapus ' + selectedIds.length + ' dokumen yang dipilih? Tindakan ini tidak bisa dibatalkan.')) {
                    document.getElementById('form-bulk-destroy').submit();
                }"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-500 hover:bg-red-600
                       text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus (<span x-text="selectedIds.length"></span>)
            </button>

            {{-- Kembali ke Biodata --}}
            <a href="{{ route('admin.penduduk.show', $penduduk) }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-sky-500 hover:bg-sky-600
                       text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali Ke Biodata Penduduk
            </a>
        </div>

        {{-- ── INFO PENDUDUK ── --}}
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20">
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-y-2 gap-x-6 text-sm">
                <div class="flex gap-2">
                    <dt class="text-gray-500 dark:text-slate-400 w-36 flex-shrink-0">Nama Penduduk</dt>
                    <dd class="font-semibold text-gray-800 dark:text-slate-200">: {{ $penduduk->nama }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-gray-500 dark:text-slate-400 w-10 flex-shrink-0">NIK</dt>
                    <dd class="font-mono text-gray-800 dark:text-slate-200">: {{ $penduduk->nik }}</dd>
                </div>
                <div class="flex gap-2">
                    <dt class="text-gray-500 dark:text-slate-400 w-16 flex-shrink-0">Alamat</dt>
                    <dd class="text-gray-700 dark:text-slate-300">:
                        @if($penduduk->wilayah)
                            RT/RW : {{ $penduduk->wilayah->rt }}/{{ $penduduk->wilayah->rw }}
                            DUSUN : {{ $penduduk->wilayah->dusun }}
                        @else
                            {{ $penduduk->alamat ?: '-' }}
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- ── TOOLBAR 2: per_page + search ── --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

            {{-- Per-page (custom dropdown dengan Alpine agar konsisten) --}}
            <div x-data="{
                    open: false,
                    selected: {{ request('per_page', 10) }},
                    options: [10, 25, 50],
                    choose(n) {
                        this.selected = n;
                        this.open = false;
                        window.location = '{{ route('admin.penduduk.dokumen', $penduduk) }}?per_page=' + n;
                    }
                }" @click.away="open = false"
                class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                <span>Tampilkan</span>
                <div class="relative">
                    <button type="button" @click="open = !open"
                        class="flex items-center gap-1.5 px-3 py-1.5 border border-gray-300 dark:border-slate-600
                               rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm
                               hover:border-emerald-400 focus:outline-none transition-colors"
                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                        <span x-text="selected"></span>
                        <svg class="w-3.5 h-3.5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 top-full mt-1 w-20 z-50 bg-white dark:bg-slate-800
                                border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg py-1"
                         style="display:none">
                        <template x-for="n in options" :key="n">
                            <div @click="choose(n)"
                                 class="px-3 py-1.5 text-sm cursor-pointer transition-colors
                                        hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700"
                                 :class="selected === n
                                     ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white'
                                     : 'text-gray-700 dark:text-slate-200'"
                                 x-text="n">
                            </div>
                        </template>
                    </div>
                </div>
                <span>entri</span>
            </div>

            {{-- Search — maks 50 karakter --}}
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                <label for="search-dokumen">Cari:</label>
                <div class="relative">
                    <input type="text" id="search-dokumen"
                        placeholder="kata kunci pencarian"
                        maxlength="50"
                        class="pl-8 pr-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52 transition-colors">
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- ── FORM BULK DESTROY (hidden) ── --}}
        <form id="form-bulk-destroy"
              method="POST"
              action="{{ route('admin.penduduk.dokumen.bulk-destroy', $penduduk) }}">
            @csrf
            @method('DELETE')
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
        </form>

        {{-- ── TABEL ── --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="tabel-dokumen">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-4 py-3 text-center w-10">
                            <input type="checkbox" id="check-all"
                                @change="toggleAll($event.target.checked)"
                                class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-36">AKSI</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                            NAMA DOKUMEN
                            <svg class="w-3.5 h-3.5 inline ml-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">JENIS DOKUMEN</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TANGGAL UPLOAD</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($dokumen as $dok)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                            {{-- Checkbox --}}
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox"
                                    value="{{ $dok->id }}"
                                    :checked="selectedIds.includes('{{ $dok->id }}')"
                                    @change="toggleOne('{{ $dok->id }}', $event.target.checked)"
                                    class="row-check w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </td>

                            {{-- No urut — pakai $loop agar aman untuk collection maupun paginator --}}
                            <td class="px-4 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                @if(method_exists($dokumen, 'firstItem'))
                                    {{ $dokumen->firstItem() + $loop->index }}
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">

                                    {{-- Edit --}}
                                    <button type="button"
                                        @click="openEdit(
                                            '{{ $dok->id }}',
                                            '{{ addslashes($dok->nama_dokumen) }}',
                                            '{{ addslashes($dok->jenis_dokumen ?? '') }}'
                                        )"
                                        class="p-1.5 rounded-lg bg-amber-400 hover:bg-amber-500 text-white transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    {{-- Hapus satu --}}
                                    <form method="POST"
                                          action="{{ route('admin.penduduk.dokumen.destroy', [$penduduk, $dok->id]) }}"
                                          onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- Download / Lihat --}}
                                    <a href="{{ asset('storage/' . $dok->file_path) }}"
                                       target="_blank" download
                                       class="p-1.5 rounded-lg bg-sky-500 hover:bg-sky-600 text-white transition-colors"
                                       title="Download / Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-slate-200">{{ $dok->nama_dokumen }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-slate-300">
                                @if($dok->jenis_dokumen)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                                 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400
                                                 border border-emerald-200 dark:border-emerald-800">
                                        {{ $dok->jenis_dokumen }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-xs">
                                {{ $dok->created_at?->format('d M Y H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-14 h-14 text-gray-200 dark:text-slate-700" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia pada tabel ini</p>
                                    <button type="button" @click="showModalTambah = true"
                                        class="inline-flex items-center gap-1.5 text-sm text-emerald-600 dark:text-emerald-400
                                               hover:text-emerald-800 dark:hover:text-emerald-300 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Upload dokumen pertama
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── PAGINATION ── --}}
        @if(method_exists($dokumen, 'total'))
        <div class="px-5 py-4 border-t border-gray-200 dark:border-slate-700
                    flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                @if($dokumen->total() > 0)
                    Menampilkan {{ $dokumen->firstItem() }} sampai {{ $dokumen->lastItem() }}
                    dari {{ $dokumen->total() }} entri
                @else
                    Menampilkan 0 entri
                @endif
            </p>
            <div class="flex items-center gap-1">
                {{-- Prev --}}
                @if($dokumen->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600
                                 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed select-none">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $dokumen->previousPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200
                               dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">
                        Sebelumnya
                    </a>
                @endif

                {{-- Nomor halaman --}}
                @foreach($dokumen->getUrlRange(
                    max(1, $dokumen->currentPage() - 2),
                    min($dokumen->lastPage(), $dokumen->currentPage() + 2)
                ) as $page => $url)
                    @if($page == $dokumen->currentPage())
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-500
                                     border border-emerald-500 rounded-lg select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200
                                   dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800
                                   hover:bg-gray-50 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($dokumen->hasMorePages())
                    <a href="{{ $dokumen->nextPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200
                               dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">
                        Selanjutnya
                    </a>
                @else
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600
                                 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed select-none">
                        Selanjutnya
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>{{-- /main card --}}


    {{-- ════════════════════════════════════════════════════════════════
         MODAL: TAMBAH DOKUMEN
    ════════════════════════════════════════════════════════════════ --}}
    {{-- Overlay --}}
    <div x-show="showModalTambah"
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="showModalTambah = false"
         class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
         style="display:none"></div>

    {{-- Panel --}}
    <div x-show="showModalTambah"
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[201] flex items-center justify-center p-4"
         style="display:none">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md" @click.stop>

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Tambah Dokumen
                </h3>
                <button @click="showModalTambah = false"
                    class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST"
                  action="{{ route('admin.penduduk.dokumen.store', $penduduk) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="px-6 py-5 space-y-4">

                    {{-- Nama Dokumen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            Nama Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_dokumen" required
                            placeholder="contoh: KTP, Akta Lahir, Ijazah"
                            maxlength="100"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                    </div>

                    {{-- Jenis Dokumen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            Jenis Dokumen
                        </label>
                        <select name="jenis_dokumen"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                            @include('admin.partials._jenis_dokumen_options')
                        </select>
                    </div>

                    {{-- File --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            File <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full text-sm text-gray-700 dark:text-slate-200
                                   file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700
                                   hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400
                                   cursor-pointer">
                        <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">
                            Format: PDF, JPG, PNG — Maksimal 5 MB
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="button" @click="showModalTambah = false"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200
                               dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-300
                               text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600
                               text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ════════════════════════════════════════════════════════════════
         MODAL: EDIT DOKUMEN
         Bug fix: form action di-bind dinamis via x-bind:action
    ════════════════════════════════════════════════════════════════ --}}
    {{-- Overlay --}}
    <div x-show="showModalEdit"
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="showModalEdit = false"
         class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
         style="display:none"></div>

    {{-- Panel --}}
    <div x-show="showModalEdit"
         x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[201] flex items-center justify-center p-4"
         style="display:none">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md" @click.stop>

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Dokumen
                </h3>
                <button @click="showModalEdit = false"
                    class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- x-bind:action = kunci fix bug action yang salah di versi lama --}}
            <form method="POST"
                  x-bind:action="editFormAction"
                  enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="px-6 py-5 space-y-4">

                    {{-- Nama Dokumen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            Nama Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_dokumen" required
                            x-model="editDokumen.nama_dokumen"
                            maxlength="100"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                    </div>

                    {{-- Jenis Dokumen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            Jenis Dokumen
                        </label>
                        <select name="jenis_dokumen"
                            x-model="editDokumen.jenis_dokumen"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                            @include('admin.partials._jenis_dokumen_options')
                        </select>
                    </div>

                    {{-- Ganti File (opsional) --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            Ganti File
                            <span class="text-gray-400 dark:text-slate-500 font-normal">(opsional)</span>
                        </label>
                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full text-sm text-gray-700 dark:text-slate-200
                                   file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700
                                   hover:file:bg-amber-100 dark:file:bg-amber-900/20 dark:file:text-amber-400
                                   cursor-pointer">
                        <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">
                            Biarkan kosong jika tidak ingin mengganti file. Format: PDF, JPG, PNG — Maks 5 MB
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="button" @click="showModalEdit = false"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200
                               dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-300
                               text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600
                               text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>{{-- /x-data --}}
@endsection

@push('scripts')
<script>
// ── Client-side search filter ─────────────────────────────────────────────
document.getElementById('search-dokumen')?.addEventListener('input', function () {
    const val = this.value.toLowerCase().trim();
    document.querySelectorAll('#tabel-dokumen tbody tr').forEach(row => {
        // Abaikan baris empty-state
        if (row.querySelector('td[colspan]')) return;
        row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
    });
});
</script>
@endpush