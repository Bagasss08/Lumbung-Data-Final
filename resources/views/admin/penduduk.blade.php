@extends('layouts.admin')

@section('title', 'Data Penduduk')

@section('content')

{{-- ══════════════════════════════════════════════════════════════
     STYLE: dropdown portal (posisi fixed, keluar dari tabel)
══════════════════════════════════════════════════════════════ --}}
<style>
    /* Dropdown Portal — dirender di body, posisi fixed */
    .aksi-dropdown-portal {
        display: none;
        position: fixed;
        z-index: 9999;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 12px 32px rgba(0,0,0,0.13), 0 2px 8px rgba(0,0,0,0.07);
        min-width: 224px;
        overflow: hidden;
        animation: aksiDropIn 0.12s ease-out;
    }
    .dark .aksi-dropdown-portal {
        background: #1e293b;
        border-color: #334155;
        box-shadow: 0 12px 32px rgba(0,0,0,0.4);
    }
    @keyframes aksiDropIn {
        from { opacity: 0; transform: translateY(-6px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    /* Item menu dalam dropdown */
    .aksi-dropdown-portal a,
    .aksi-dropdown-portal button.aksi-item {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 500;
        text-align: left;
        background: none;
        border: none;
        cursor: pointer;
        color: #374151;
        text-decoration: none;
        transition: background 0.1s, color 0.1s;
        white-space: nowrap;
    }
    .dark .aksi-dropdown-portal a,
    .dark .aksi-dropdown-portal button.aksi-item {
        color: #cbd5e1;
    }
    .aksi-dropdown-portal a:hover,
    .aksi-dropdown-portal button.aksi-item:hover {
        background: #f0fdf4;
        color: #065f46;
    }
    .dark .aksi-dropdown-portal a:hover,
    .dark .aksi-dropdown-portal button.aksi-item:hover {
        background: rgba(16,185,129,0.12);
        color: #6ee7b7;
    }
    .aksi-dropdown-portal .aksi-item-amber:hover  { background: #fffbeb; color: #92400e; }
    .aksi-dropdown-portal .aksi-item-teal:hover   { background: #f0fdfa; color: #134e4a; }
    .aksi-dropdown-portal .aksi-item-orange:hover { background: #fff7ed; color: #9a3412; }
    .aksi-dropdown-portal .aksi-item-blue:hover   { background: #eff6ff; color: #1e40af; }
    .aksi-dropdown-portal .aksi-item-indigo:hover { background: #eef2ff; color: #3730a3; }
    .aksi-dropdown-portal .aksi-item-red          { color: #dc2626 !important; }
    .aksi-dropdown-portal .aksi-item-red:hover    { background: #fef2f2 !important; color: #991b1b !important; }
    .dark .aksi-dropdown-portal .aksi-item-amber:hover  { background: rgba(245,158,11,0.12); color: #fcd34d; }
    .dark .aksi-dropdown-portal .aksi-item-teal:hover   { background: rgba(20,184,166,0.12); color: #5eead4; }
    .dark .aksi-dropdown-portal .aksi-item-orange:hover { background: rgba(249,115,22,0.12); color: #fdba74; }
    .dark .aksi-dropdown-portal .aksi-item-blue:hover   { background: rgba(59,130,246,0.12); color: #93c5fd; }
    .dark .aksi-dropdown-portal .aksi-item-indigo:hover { background: rgba(99,102,241,0.12); color: #a5b4fc; }
    .dark .aksi-dropdown-portal .aksi-item-red          { color: #f87171 !important; }
    .dark .aksi-dropdown-portal .aksi-item-red:hover    { background: rgba(239,68,68,0.12) !important; color: #fca5a5 !important; }

    .aksi-dropdown-portal .aksi-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 2px 0;
    }
    .dark .aksi-dropdown-portal .aksi-divider {
        background: #334155;
    }

    /* Tombol Pilih Aksi di tabel */
    .btn-aksi {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        background: #10b981;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s, transform 0.1s;
        user-select: none;
    }
    .btn-aksi:hover { background: #059669; transform: translateY(-1px); }
    .btn-aksi:active { transform: translateY(0); }
    .btn-aksi.active { background: #065f46; }
</style>

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
        this.selectAll = all.every(id => this.selectedIds.includes(id));
    }
}">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Penduduk</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data penduduk desa</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Data Penduduk</span>
        </nav>
    </div>

    {{-- ── FLASH MESSAGES ── --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0"
            class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-5">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
                @if (session('import_errors'))
                    <ul class="mt-2 space-y-0.5">
                        @foreach (session('import_errors') as $err)
                            <li class="text-xs text-red-600 dark:text-red-400">• {{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
            class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-5">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ── CARD UTAMA ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

        {{-- ════ BARIS TOMBOL AKSI ════ --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

            {{-- 1. Tambah Penduduk --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Penduduk
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 top-full mt-1 w-52 z-[100] bg-white dark:bg-slate-800
                           border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                    style="display:none">
                    <a href="{{ route('admin.penduduk.create', ['jenis' => 'lahir']) }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Penduduk Lahir
                    </a>
                    <div class="border-t border-gray-100 dark:border-slate-700"></div>
                    <a href="{{ route('admin.penduduk.create', ['jenis' => 'masuk']) }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 transition-colors">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Penduduk Masuk
                    </a>
                </div>
            </div>

            {{-- 2. Hapus Terpilih --}}
            <form method="POST" action="{{ route('admin.penduduk.bulk-destroy') }}" id="form-bulk-hapus">
                @csrf
                @method('DELETE')
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button" :disabled="selectedIds.length === 0"
                    @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                        bulkCount: selectedIds.length,
                        onConfirm: () => document.getElementById('form-bulk-hapus').submit()
                    })"
                    :class="selectedIds.length > 0 ?
                        'bg-red-500 hover:bg-red-600 cursor-pointer' :
                        'bg-red-300 dark:bg-red-900/50 cursor-not-allowed opacity-60'"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Data Terpilih
                    <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                </button>
            </form>

            {{-- 3. Pilih Aksi Lainnya --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 7a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    Pilih Aksi Lainnya
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 top-full mt-1 w-64 z-[100] bg-white dark:bg-slate-800
                           border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                    style="display:none">

                    <button type="button" @click="open = false; $dispatch('open-pencarian-spesifik')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                        Pencarian Spesifik
                    </button>

                    <button type="button" @click="open = false; $dispatch('open-program-bantuan')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zm-5 0H9m2-3v6" />
                        </svg>
                        Pencarian Program Bantuan
                    </button>

                    <button type="button" @click="open = false; $dispatch('open-kumpulan-nik')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h10M4 18h6" />
                        </svg>
                        Pilihan Kumpulan NIK
                    </button>

                    @php $isNikSementara = request()->boolean('nik_sementara'); @endphp
                    <a href="{{ route('admin.penduduk', array_merge(request()->except('nik_sementara', 'page'), $isNikSementara ? [] : ['nik_sementara' => 1])) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                               {{ $isNikSementara
                                   ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 font-semibold'
                                   : 'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700' }}">
                        <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 9l-6 6m0-6l6 6M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                        NIK Sementara
                        @if ($isNikSementara)
                            <span class="ml-auto text-[10px] bg-emerald-500 text-white px-1.5 py-0.5 rounded-full">Aktif</span>
                        @endif
                    </a>

                    <button type="button" @click="open = false; $dispatch('buka-modal-cetak')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button>

                    <button type="button" @click="open = false; $dispatch('buka-modal-unduh')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh
                    </button>
                </div>
            </div>

            {{-- 4. Impor / Ekspor --}}
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-700 hover:bg-slate-800 dark:bg-slate-600 dark:hover:bg-slate-500 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Impor / Ekspor
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute left-0 top-full mt-1 w-60 z-[100] bg-white dark:bg-slate-800
                           border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                    style="display:none">
                    <button type="button" @click="open = false; $dispatch('buka-modal-import')"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Impor Penduduk
                    </button>
                    <div class="border-t border-gray-100 dark:border-slate-700"></div>
                    <a href="{{ route('admin.penduduk.import-bip', request()->query()) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Impor BIP
                    </a>
                    <a href="{{ route('admin.penduduk.export.excel', request()->query()) }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Ekspor Penduduk
                    </a>
                    <a href="/admin/penduduk/eksport-huruf{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                        class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Ekspor Penduduk Huruf
                    </a>
                </div>
            </div>

        </div>

        {{-- ════ BARIS FILTER ════ --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <form method="GET" action="{{ route('admin.penduduk') }}" id="form-filter"
                class="flex flex-wrap items-center gap-2">

                <input type="hidden" name="status"        id="val-status"        value="{{ request('status') }}">
                <input type="hidden" name="status_dasar"  id="val-status_dasar"  value="{{ request('status_dasar') }}">
                <input type="hidden" name="jenis_kelamin" id="val-jenis_kelamin" value="{{ request('jenis_kelamin') }}">
                <input type="hidden" name="dusun"         id="val-dusun"         value="{{ request('dusun') }}">

                {{-- 1. Status Penduduk --}}
                <div class="relative w-52" x-data="{
                    open: false, search: '',
                    selected: '{{ request('status') }}',
                    options: [
                        { value: '', label: 'Pilih Status Penduduk' },
                        { value: '1', label: 'Tetap' },
                        { value: '2', label: 'Tidak Tetap' },
                        { value: '3', label: 'Pendatang' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Status Penduduk'; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) { this.selected = opt.value; document.getElementById('val-status').value = opt.value; this.open = false; this.search = ''; document.getElementById('form-filter').submit(); }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                        :class="[open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : '', selected ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500']">
                        <span x-text="label" class="text-sm"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden" style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false" placeholder="Cari status..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)" class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                {{-- 2. Status Dasar --}}
                <div class="relative w-52" x-data="{
                    open: false, search: '',
                    selected: '{{ request('status_dasar') }}',
                    options: [
                        { value: '', label: 'Pilih Status Dasar' },
                        { value: 'hidup', label: 'Hidup' },
                        { value: 'mati', label: 'Mati' },
                        { value: 'pindah', label: 'Pindah' },
                        { value: 'hilang', label: 'Hilang' },
                        { value: 'pergi', label: 'Pergi' },
                        { value: 'tidak_valid', label: 'Tidak Valid' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Status Dasar'; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) { this.selected = opt.value; document.getElementById('val-status_dasar').value = opt.value; this.open = false; this.search = ''; document.getElementById('form-filter').submit(); }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                        :class="[open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : '', selected ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500']">
                        <span x-text="label" class="text-sm"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden" style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false" placeholder="Cari status dasar..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)" class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                {{-- 3. Jenis Kelamin --}}
                <div class="relative w-44" x-data="{
                    open: false, search: '',
                    selected: '{{ request('jenis_kelamin') }}',
                    options: [
                        { value: '', label: 'Pilih Jenis Kelamin' },
                        { value: 'L', label: 'Laki-laki' },
                        { value: 'P', label: 'Perempuan' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Jenis Kelamin'; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) { this.selected = opt.value; document.getElementById('val-jenis_kelamin').value = opt.value; this.open = false; this.search = ''; document.getElementById('form-filter').submit(); }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                        :class="[open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : '', selected ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500']">
                        <span x-text="label" class="text-sm"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden" style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false" placeholder="Cari jenis kelamin..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)" class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                {{-- 4. Dusun --}}
                <div class="relative w-44" x-data="{
                    open: false, search: '',
                    selected: '{{ request('dusun') }}',
                    options: [
                        { value: '', label: 'Pilih Dusun' },
                        @foreach ($dusunList as $dusun)
                            { value: '{{ addslashes($dusun) }}', label: '{{ addslashes($dusun) }}' },
                        @endforeach
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Dusun'; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) { this.selected = opt.value; document.getElementById('val-dusun').value = opt.value; this.open = false; this.search = ''; document.getElementById('form-filter').submit(); }
                }" @click.away="open = false">
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                        :class="[open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : '', selected ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500']">
                        <span x-text="label" class="text-sm"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden" style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false" placeholder="Cari dusun..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)" class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                        </ul>
                    </div>
                </div>

                {{-- Badge NIK Sementara --}}
                @if (request()->boolean('nik_sementara'))
                    <a href="{{ route('admin.penduduk', request()->except('nik_sementara', 'page')) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm
                               bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300
                               rounded-lg border border-sky-300 dark:border-sky-700 hover:bg-sky-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        NIK Sementara
                    </a>
                @endif

                {{-- Reset Filter --}}
                @if (request()->hasAny(['status','status_dasar','jenis_kelamin','dusun','search','nik_sementara','umur_dari','umur_sampai','pekerjaan_id','status_kawin_id','agama_id','pendidikan_kk_id','golongan_darah_id','program_bantuan_id','kumpulan_nik']))
                    <a href="{{ route('admin.penduduk') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400
                               hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors
                               border border-red-200 dark:border-red-800">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ════ TOOLBAR: Tampilkan + Search ════ --}}
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">
            <form method="GET" action="{{ route('admin.penduduk') }}" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                @foreach (request()->except('per_page', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <span>Tampilkan</span>
                <select name="per_page" onchange="this.form.submit()"
                    class="px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                    @foreach ([10, 25, 50, 100] as $n)
                        <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                    @endforeach
                </select>
                <span>entri</span>
            </form>

            <form method="GET" action="{{ route('admin.penduduk') }}" class="flex items-center gap-2">
                @foreach (request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="kata kunci pencarian" maxlength="50"
                        @input.debounce.400ms="$el.form.submit()"
                        class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                </div>
            </form>
        </div>

        {{-- ════ TABEL DATA ════ --}}
        {{-- overflow-x: auto TAPI overflow-y: visible → dropdown bisa keluar --}}
        <div style="overflow-x: auto; overflow-y: visible;">
            <table class="w-full text-sm" style="min-width: 1600px;">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-3 py-3 w-10 text-center">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">NO</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-36">AKSI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">FOTO</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NIK</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TAG ID CARD</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NO. KK</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">SHDK</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA AYAH</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA IBU</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NO. RUMAH TANGGA</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">JK</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">ALAMAT</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">DUSUN</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">RW</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">RT</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">PENDIDIKAN</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">UMUR</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">PEKERJAAN</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">KAWIN</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">STATUS</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TGL PERISTIWA</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TGL TERDAFTAR</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($penduduk as $index => $p)
                        @php
                            $keluargaP    = $p->keluarga;
                            $rumahTanggaP = $keluargaP?->rumahTangga;
                            $wilayahP     = $p->wilayah;
                            $fotoSrc      = $p->foto_url ?? ($p->foto ? asset('storage/' . $p->foto) : null);
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                            :class="selectedIds.includes('{{ $p->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' : ''">

                            {{-- Checkbox --}}
                            <td class="px-3 py-3 text-center">
                                <input type="checkbox"
                                    class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                    value="{{ $p->id }}" x-model="selectedIds" @change="toggleOne()">
                            </td>

                            {{-- Nomor --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                {{ $penduduk->firstItem() + $index }}
                            </td>

                            {{-- ════ AKSI — tombol trigger portal dropdown ════ --}}
                            <td class="px-3 py-3">
                                <button
                                    class="btn-aksi"
                                    data-penduduk-id="{{ $p->id }}"
                                    onclick="toggleAksiDropdown(this, event)"
                                    type="button">
                                    <svg style="width:13px;height:13px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Pilih Aksi
                                    <svg style="width:10px;height:10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </td>

                            {{-- FOTO --}}
                            <td class="px-3 py-3">
                                @if ($fotoSrc)
                                    <img src="{{ $fotoSrc }}" alt="{{ $p->nama }}"
                                        class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 dark:border-slate-600"
                                        onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 200 200%27%3E%3Crect width=%27200%27 height=%27200%27 fill=%27%23f1f5f9%27/%3E%3Ccircle cx=%27100%27 cy=%2778%27 r=%2740%27 fill=%27%23cbd5e1%27/%3E%3Cellipse cx=%27100%27 cy=%27178%27 rx=%2764%27 ry=%2750%27 fill=%27%23cbd5e1%27/%3E%3C/svg%3E'">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gray-100 dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            {{-- NIK --}}
                            <td class="px-3 py-3 font-mono font-semibold whitespace-nowrap">
                                <a href="{{ route('admin.penduduk.show', $p) }}"
                                    class="{{ $p->is_nik_sementara ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }} hover:underline">
                                    {{ $p->nik }}
                                </a>
                                @if ($p->is_nik_sementara)
                                    <span class="ml-1 text-xs text-red-400">(sementara)</span>
                                @endif
                            </td>

                            {{-- TAG ID CARD --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400">{{ $p->tag_id_card ?: '-' }}</td>

                            {{-- NAMA --}}
                            <td class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 whitespace-nowrap">{{ $p->nama }}</td>

                            {{-- NO. KK --}}
                            <td class="px-3 py-3 font-mono text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                @if ($keluargaP)
                                    <a href="{{ route('admin.keluarga.show', $keluargaP) }}"
                                        class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                        {{ $keluargaP->no_kk }}
                                    </a>
                                @else
                                    <span class="text-gray-400 dark:text-slate-500">-</span>
                                @endif
                            </td>

                            {{-- SHDK --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">{{ $p->shdk?->nama ?? '-' }}</td>

                            {{-- NAMA AYAH --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">{{ $p->nama_ayah ?: '-' }}</td>

                            {{-- NAMA IBU --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">{{ $p->nama_ibu ?: '-' }}</td>

                            {{-- NO. RUMAH TANGGA --}}
                            <td class="px-3 py-3 font-mono text-gray-600 dark:text-slate-300 whitespace-nowrap">{{ $rumahTanggaP?->no_rumah_tangga ?? '-' }}</td>

                            {{-- JK --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                            </td>

                            {{-- ALAMAT --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400 max-w-[200px] truncate" title="{{ $p->alamat }}">{{ $p->alamat ?: '-' }}</td>

                            {{-- DUSUN --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">{{ $wilayahP?->dusun ?? '-' }}</td>

                            {{-- RW --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">{{ $wilayahP?->rw ?? '-' }}</td>

                            {{-- RT --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">{{ $wilayahP?->rt ?? '-' }}</td>

                            {{-- PENDIDIKAN --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">{{ $p->pendidikanKk?->nama ?? ($p->pendidikan_lama ?? '-') }}</td>

                            {{-- UMUR --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">{{ $p->umur ?? '-' }}</td>

                            {{-- PEKERJAAN --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">{{ $p->pekerjaan?->nama ?? ($p->pekerjaan_lama ?? '-') }}</td>

                            {{-- STATUS KAWIN --}}
                            <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">{{ $p->statusKawin?->nama ?? ($p->status_kawin_lama ?? '-') }}</td>

                            {{-- STATUS DASAR --}}
                            <td class="px-3 py-3 whitespace-nowrap">
                                @php
                                    $statusColor = match ($p->status_dasar) {
                                        'hidup'  => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'mati'   => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                        'pindah' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'hilang' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                        default  => 'bg-gray-100 text-gray-500',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ $p->label_status_dasar }}
                                </span>
                            </td>

                            {{-- TGL PERISTIWA --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400 whitespace-nowrap">{{ $p->tgl_peristiwa?->format('d M Y') ?? '-' }}</td>

                            {{-- TGL TERDAFTAR --}}
                            <td class="px-3 py-3 text-gray-500 dark:text-slate-400 whitespace-nowrap">{{ $p->tgl_terdaftar?->format('d M Y') ?? $p->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="24" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia</p>
                                    <p class="text-gray-400 dark:text-slate-500 text-sm">Silakan tambah data penduduk baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ════ PAGINATION ════ --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                @if ($penduduk->total() > 0)
                    Menampilkan {{ $penduduk->firstItem() }}–{{ $penduduk->lastItem() }} dari {{ number_format($penduduk->total()) }} entri
                @else
                    Menampilkan 0 entri
                @endif
            </p>
            <div class="flex items-center gap-1">
                @if ($penduduk->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $penduduk->appends(request()->query())->previousPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                @endif

                @php
                    $currentPage = $penduduk->currentPage();
                    $lastPage    = $penduduk->lastPage();
                    $start       = max(1, $currentPage - 2);
                    $end         = min($lastPage, $currentPage + 2);
                @endphp
                @if ($start > 1)
                    <a href="{{ $penduduk->appends(request()->query())->url(1) }}" class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                    @if ($start > 2)<span class="px-1 text-gray-400 dark:text-slate-500">…</span>@endif
                @endif
                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $currentPage)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $penduduk->appends(request()->query())->url($page) }}" class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $page }}</a>
                    @endif
                @endfor
                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)<span class="px-1 text-gray-400 dark:text-slate-500">…</span>@endif
                    <a href="{{ $penduduk->appends(request()->query())->url($lastPage) }}" class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lastPage }}</a>
                @endif

                @if ($penduduk->hasMorePages())
                    <a href="{{ $penduduk->appends(request()->query())->nextPageUrl() }}" class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>

    @include('admin.partials.modal-import-penduduk')
    @include('admin.partials.modal-hapus')
    @include('admin.partials.modal-cetak-unduh-penduduk')

    {{-- ══════════════════════════════════════════════════════════════
         DROPDOWN PORTAL — dirender di luar tabel, posisi fixed
         Satu elemen per penduduk, di-populate saat tombol diklik
    ══════════════════════════════════════════════════════════════ --}}
    <div id="aksi-dropdown-portal" class="aksi-dropdown-portal">
        {{-- Isinya di-inject oleh JS saat tombol diklik --}}
    </div>

    {{-- Data aksi per baris (JSON) — dibaca oleh JS --}}
    <script>
    // Map penduduk_id → URL-URL aksi
    var pendudukAksiMap = {
        @foreach($penduduk as $p)
        "{{ $p->id }}": {
            urlDetail   : "{{ route('admin.penduduk.show', $p) }}",
            urlEdit     : "{{ route('admin.penduduk.edit', $p) }}",
            urlLokasi   : "{{ route('admin.penduduk.lokasi', $p) }}",
            urlUbahStatus: @if($p->status_dasar === 'hidup') "{{ route('admin.penduduk.show', $p) }}#ubah-status" @else null @endif,
            urlCetak    : "{{ route('admin.penduduk.cetak-biodata', $p) }}",
            urlDokumen  : "{{ route('admin.penduduk.dokumen', $p) }}",
            urlHapus    : "{{ route('admin.penduduk.destroy', $p) }}",
            nama        : "{{ addslashes($p->nama) }}",
            statusHidup : {{ $p->status_dasar === 'hidup' ? 'true' : 'false' }},
        },
        @endforeach
    };
    </script>

    {{-- ══════════════════════════════════════════════════════════════
         MODAL: PENCARIAN SPESIFIK
    ══════════════════════════════════════════════════════════════ --}}
    <div x-data="{ show: false }" @open-pencarian-spesifik.window="show = true" @keydown.escape.window="show && (show = false)">
        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
            @click="show = false" style="display:none"></div>

        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[201] flex items-center justify-center p-4 overflow-y-auto" style="display:none">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl" @click.stop>

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pencarian Spesifik</h3>
                    <button @click="show = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="GET" action="{{ route('admin.penduduk') }}" id="form-pencarian-spesifik">
                    @foreach (request()->only(['per_page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach

                    <div class="px-6 py-4 max-h-[65vh] overflow-y-auto space-y-4">
                        {{-- Umur --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Umur</label>
                            <div class="flex gap-2">
                                <input type="number" name="umur_dari" value="{{ request('umur_dari') }}" placeholder="Dari" min="0" max="150"
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <input type="number" name="umur_sampai" value="{{ request('umur_sampai') }}" placeholder="Sampai" min="0" max="150"
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <select name="umur_satuan"
                                    class="w-28 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <option value="tahun" {{ request('umur_satuan', 'tahun') === 'tahun' ? 'selected' : '' }}>Tahun</option>
                                    <option value="bulan" {{ request('umur_satuan') === 'bulan' ? 'selected' : '' }}>Bulan</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" value="{{ request('tanggal_lahir') }}" placeholder="YYYY-MM-DD atau MM-DD"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <p class="mt-1 text-xs text-emerald-600 dark:text-emerald-400">Format: YYYY-MM-DD (lengkap) atau MM-DD (bulan & hari saja)</p>
                        </div>

                        {{-- Grid 2 kolom --}}
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $selectFields = [
                                    ['name' => 'pekerjaan_id',         'label' => 'Pekerjaan',                       'ref' => $refPekerjaan ?? []],
                                    ['name' => 'status_kawin_id',      'label' => 'Status Perkawinan',               'ref' => $refStatusKawin ?? []],
                                    ['name' => 'agama_id',             'label' => 'Agama',                           'ref' => $refAgama ?? []],
                                    ['name' => 'pendidikan_kk_id',     'label' => 'Pendidikan Dalam KK',             'ref' => $refPendidikan ?? []],
                                    ['name' => 'golongan_darah_id',    'label' => 'Golongan Darah',                  'ref' => $refGolDarah ?? []],
                                    ['name' => 'cara_kb_id',           'label' => 'Cara KB',                        'ref' => $refCaraKb ?? []],
                                    ['name' => 'warganegara_id',       'label' => 'Warga Negara',                   'ref' => $refWarganegara ?? []],
                                ];
                                $plainSelects = [
                                    ['name' => 'jenis_kelamin',        'label' => 'Jenis Kelamin',        'opts' => ['L' => 'Laki-laki', 'P' => 'Perempuan']],
                                    ['name' => 'status_dasar',         'label' => 'Status Dasar',         'opts' => ['hidup' => 'Hidup', 'mati' => 'Mati', 'pindah' => 'Pindah', 'hilang' => 'Hilang', 'pergi' => 'Pergi', 'tidak_valid' => 'Tidak Valid']],
                                    ['name' => 'status',               'label' => 'Status Penduduk',      'opts' => ['1' => 'Tetap', '2' => 'Tidak Tetap', '3' => 'Pendatang']],
                                    ['name' => 'disabilitas',          'label' => 'Disabilitas',           'opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'asuransi',             'label' => 'Asuransi',              'opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'bpjs_ketenagakerjaan', 'label' => 'BPJS Ketenagakerjaan', 'opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'sakit_menahun',        'label' => 'Sakit Menahun',        'opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'has_tag_id_card',      'label' => 'Kepemilikan Tag ID Card','opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'has_kk',               'label' => 'Kepemilikan KK',        'opts' => ['ya' => 'Ya', 'tidak' => 'Tidak']],
                                    ['name' => 'status_ktp',           'label' => 'Status KTP',            'opts' => ['punya' => 'Punya KTP', 'belum' => 'Belum Punya']],
                                ];
                            @endphp

                            @foreach ($selectFields as $sf)
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">{{ $sf['label'] }}</label>
                                    <select name="{{ $sf['name'] }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                        <option value="">--</option>
                                        @foreach ($sf['ref'] as $ref)
                                            <option value="{{ $ref->id }}" {{ request($sf['name']) == $ref->id ? 'selected' : '' }}>{{ $ref->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                            @foreach ($plainSelects as $ps)
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">{{ $ps['label'] }}</label>
                                    <select name="{{ $ps['name'] }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                        <option value="">--</option>
                                        @foreach ($ps['opts'] as $val => $lbl)
                                            <option value="{{ $val }}" {{ request($ps['name']) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                            {{-- Input teks --}}
                            @foreach ([['name' => 'adat', 'label' => 'Adat'], ['name' => 'suku_etnis', 'label' => 'Suku / Etnis'], ['name' => 'marga', 'label' => 'Marga']] as $tf)
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">{{ $tf['label'] }}</label>
                                    <input type="text" name="{{ $tf['name'] }}" value="{{ request($tf['name']) }}" placeholder="--"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="button" @click="show = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MODAL: PENCARIAN PROGRAM BANTUAN
    ══════════════════════════════════════════════════════════════ --}}
    <div x-data="{ show: false }" @open-program-bantuan.window="show = true" @keydown.escape.window="show && (show = false)">
        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
            @click="show = false" style="display:none"></div>

        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pencarian Program Bantuan</h3>
                    <button @click="show = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('admin.penduduk') }}">
                    @foreach (request()->only(['per_page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <div class="px-6 py-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Program Bantuan</label>
                        <select name="program_bantuan_id" class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="">Penduduk Penerima Bantuan (Semua)</option>
                            @foreach ($programBantuanList ?? [] as $program)
                                <option value="{{ $program->id }}" {{ request('program_bantuan_id') == $program->id ? 'selected' : '' }}>{{ $program->nama }}</option>
                            @endforeach
                        </select>
                        @if (empty($programBantuanList))
                            <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">Belum ada data program bantuan.</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="button" @click="show = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MODAL: PILIHAN KUMPULAN NIK
    ══════════════════════════════════════════════════════════════ --}}
    <div x-data="{ show: false }" @open-kumpulan-nik.window="show = true" @keydown.escape.window="show && (show = false)">
        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
            @click="show = false" style="display:none"></div>

        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pilihan Kumpulan NIK</h3>
                    <button @click="show = false" class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('admin.penduduk') }}">
                    @foreach (request()->only(['per_page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <div class="px-6 py-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kumpulan NIK</label>
                        <textarea name="kumpulan_nik" rows="6"
                            placeholder="-- Masukkan NIK, pisahkan dengan enter, koma, atau spasi --"
                            class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ request('kumpulan_nik') }}</textarea>
                        <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">Masukkan satu NIK per baris, atau pisahkan dengan koma/spasi</p>
                    </div>
                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                        <button type="button" @click="show = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>{{-- /x-data --}}

{{-- ══════════════════════════════════════════════════════════════
     JAVASCRIPT — Dropdown Portal Engine
══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    var portal      = document.getElementById('aksi-dropdown-portal');
    var activeBtn   = null;   // tombol yang sedang aktif
    var hapusAction = null;   // menyimpan action hapus sementara

    /* ─── Build HTML isi dropdown berdasarkan data penduduk ─── */
    function buildDropdownHtml(data) {
        var html = '';

        // Lihat Detail
        html += '<a href="' + data.urlDetail + '" class="aksi-item">'
            + svgIcon('M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', '#10b981')
            + 'Lihat Detail Biodata</a>';

        // Ubah Biodata
        html += '<a href="' + data.urlEdit + '" class="aksi-item aksi-item-amber">'
            + svgIcon('M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', '#f59e0b')
            + 'Ubah Biodata Penduduk</a>';

        // Lihat Lokasi
        html += '<a href="' + data.urlLokasi + '" class="aksi-item aksi-item-teal">'
            + svgIcon('M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', '#14b8a6')
            + 'Lihat Lokasi Tempat Tinggal</a>';

        // Ubah Status (hanya jika hidup)
        if (data.statusHidup && data.urlUbahStatus) {
            html += '<a href="' + data.urlUbahStatus + '" class="aksi-item aksi-item-orange">'
                + svgIcon('M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', '#f97316')
                + 'Ubah Status Dasar</a>';
        }

        html += '<div class="aksi-divider"></div>';

        // Cetak Biodata
        html += '<a href="' + data.urlCetak + '" target="_blank" class="aksi-item aksi-item-blue">'
            + svgIcon('M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z', '#3b82f6')
            + 'Cetak Biodata Penduduk</a>';

        // Upload Dokumen
        html += '<a href="' + data.urlDokumen + '" class="aksi-item aksi-item-indigo">'
            + svgIcon('M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12', '#6366f1')
            + 'Upload Dokumen Penduduk</a>';

        html += '<div class="aksi-divider"></div>';

        // Hapus
        html += '<button type="button" class="aksi-item aksi-item-red" data-hapus-action="' + data.urlHapus + '" data-hapus-nama="' + escHtml(data.nama) + '" onclick="triggerHapus(this)">'
            + svgIcon('M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16', '#ef4444')
            + 'Hapus</button>';

        return html;
    }

    function svgIcon(path, color) {
        return '<svg style="width:13px;height:13px;flex-shrink:0;color:' + color + ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">'
            + '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + path + '"/></svg>';
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* ─── Posisikan portal di bawah / atas tombol ─── */
    function positionPortal(btn) {
        var rect  = btn.getBoundingClientRect();
        var vpW   = window.innerWidth;
        var vpH   = window.innerHeight;

        // Tampil sementara (hidden) agar bisa ukur
        portal.style.visibility = 'hidden';
        portal.style.display    = 'block';

        var ddW = portal.offsetWidth;
        var ddH = portal.offsetHeight;

        var top  = rect.bottom + 4;
        var left = rect.left;

        // Overflow kanan → geser kiri
        if (left + ddW > vpW - 8) left = rect.right - ddW;
        // Overflow bawah → muncul di atas
        if (top + ddH > vpH - 8) top = rect.top - ddH - 4;
        // Jangan lebih kiri dari 4px
        if (left < 4) left = 4;

        portal.style.top        = top  + 'px';
        portal.style.left       = left + 'px';
        portal.style.visibility = 'visible';
    }

    /* ─── Toggle dropdown ─── */
    window.toggleAksiDropdown = function (btn, event) {
        event.stopPropagation();

        // Tutup jika klik tombol yang sama
        if (activeBtn === btn && portal.style.display === 'block') {
            closePortal();
            return;
        }

        var pid  = btn.dataset.pendudukId;
        var data = pendudukAksiMap[pid];
        if (!data) return;

        // Isi konten
        portal.innerHTML = buildDropdownHtml(data);

        // Tandai tombol aktif
        if (activeBtn) activeBtn.classList.remove('active');
        activeBtn = btn;
        btn.classList.add('active');

        // Posisikan dan tampilkan
        positionPortal(btn);
    };

    /* ─── Trigger modal hapus (dipanggil dari dalam portal) ─── */
    window.triggerHapus = function (btnEl) {
        var action = btnEl.dataset.hapusAction;
        var nama   = btnEl.dataset.hapusNama;
        closePortal();

        // Dispatch event Alpine modal-hapus (sesuai partial modal-hapus.blade.php)
        window.dispatchEvent(new CustomEvent('buka-modal-hapus', {
            detail: { action: action, nama: nama }
        }));
    };

    /* ─── Tutup portal ─── */
    function closePortal() {
        portal.style.display = 'none';
        if (activeBtn) { activeBtn.classList.remove('active'); activeBtn = null; }
    }

    // Klik di luar → tutup
    document.addEventListener('click', function (e) {
        if (!portal.contains(e.target)) closePortal();
    });

    // Scroll/resize → tutup
    window.addEventListener('scroll', closePortal, true);
    window.addEventListener('resize', closePortal);

    // Escape → tutup
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePortal();
    });

})();
</script>

@endsection