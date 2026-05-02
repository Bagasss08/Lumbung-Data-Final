@extends('layouts.admin')

@section('title', 'Klasifikasi Surat')

@section('content')
<div x-data="{
    showDeleteModal: false,
    deleteId: null,
    deleteName: '',
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

    {{-- PAGE HEADER --}}
    <div class="flex items-start justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Klasifikasi Surat</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola klasifikasi dan kodefikasi surat desa</p>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">
                Sesuai Permendagri No. 83 Tahun 2022 —
                <a href="https://peraturan.bpk.go.id/Details/247841/Permendagri%20No.%2083%20Tahun%202022"
                    target="_blank"
                    class="text-emerald-600 dark:text-emerald-400 hover:underline font-medium">
                    Cek referensi
                </a>
            </p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm shrink-0">
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Klasifikasi Surat</span>
        </nav>
    </div>

    {{-- Alert Success --}}
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

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Total Klasifikasi</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Aktif Digunakan</p>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['aktif'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-gray-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Tidak Aktif</p>
                <p class="text-2xl font-bold text-gray-600 dark:text-slate-300">{{ $stats['tidak_aktif'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700" style="overflow: visible">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

            {{-- Tambah --}}
            <a href="{{ route('admin.sekretariat.klasifikasi-surat.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Klasifikasi
            </a>

            {{-- Hapus Bulk --}}
            <form method="POST" action="{{ route('admin.sekretariat.klasifikasi-surat.bulk-destroy') }}" id="form-bulk-hapus">
                @csrf
                @method('DELETE')
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button"
                    :disabled="selectedIds.length === 0"
                    @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', { bulkCount: selectedIds.length, onConfirm: () => document.getElementById('form-bulk-hapus').submit() })"
                    :class="selectedIds.length > 0
                        ? 'bg-red-500 hover:bg-red-600 cursor-pointer'
                        : 'bg-red-300 dark:bg-red-900/40 cursor-not-allowed opacity-60'"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                    <span x-show="selectedIds.length > 0" class="bg-white/20 rounded px-1 text-xs font-bold" x-text="'(' + selectedIds.length + ')'"></span>
                </button>
            </form>

        </div>

        {{-- ── FILTER ── --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <form method="GET" action="{{ route('admin.sekretariat.klasifikasi-surat') }}" id="form-filter-klasifikasi"
                class="flex flex-wrap items-center gap-2">

                <input type="hidden" name="status" id="val-klasifikasi-status" value="{{ request('status') }}">

                {{-- Dropdown Status --}}
                <div class="relative w-48" x-data="{
                    open: false,
                    search: '',
                    selected: '{{ request('status') }}',
                    placeholder: 'Pilih Status',
                    options: [
                        { value: '1', label: 'Aktif' },
                        { value: '0', label: 'Tidak Aktif' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-klasifikasi-status').value = opt.value;
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-klasifikasi').submit();
                    },
                    reset() {
                        this.selected = '';
                        document.getElementById('val-klasifikasi-status').value = '';
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-klasifikasi').submit();
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
                        <ul class="py-1">
                            <li @click="reset()"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === '' ?
                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                    'text-gray-400 dark:text-slate-500 italic'">
                                Semua Status
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
                @if(request()->hasAny(['status', 'search']))
                    <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
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
            <form method="GET" action="{{ route('admin.sekretariat.klasifikasi-surat') }}" id="form-per-page-klasifikasi"
                class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                @foreach(request()->except('per_page', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="hidden" name="per_page" id="val-per-page-klasifikasi" value="{{ request('per_page', 10) }}">

                <span>Tampilkan</span>

                <div class="relative w-24" x-data="{
                    open: false,
                    selected: '{{ request('per_page', 10) }}',
                    options: [
                        { value: '10',  label: '10' },
                        { value: '20',  label: '20' },
                        { value: '30',  label: '30' },
                        { value: '50',  label: '50' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-per-page-klasifikasi').value = opt.value;
                        this.open = false;
                        document.getElementById('form-per-page-klasifikasi').submit();
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
            <form method="GET" action="{{ route('admin.sekretariat.klasifikasi-surat') }}" class="flex items-center gap-2">
                @foreach(request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="kode, nama, klasifikasi..." maxlength="50"
                        class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-56">
                    <div class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                        <div class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                            Cari berdasarkan kode, nama, atau klasifikasi
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
                        <th class="px-4 py-3 w-10">
                            <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                class="w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">NO</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider" style="min-width:120px">AKSI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-28">KODE</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA KLASIFIKASI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">NAMA</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse ($klasifikasiSurat as $index => $klasifikasi)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                        :class="selectedIds.includes('{{ $klasifikasi->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' : ''">

                        {{-- Checkbox --}}
                        <td class="px-4 py-3">
                            <input type="checkbox"
                                class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                value="{{ $klasifikasi->id }}"
                                x-model="selectedIds"
                                @change="toggleOne()">
                        </td>

                        {{-- NO --}}
                        <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                            {{ $klasifikasiSurat->firstItem() + $index }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-3 py-3">
                            <div class="flex items-center gap-1 flex-nowrap">

                                {{-- Detail (indigo) --}}
                                <a href="{{ route('admin.sekretariat.klasifikasi-surat.show', $klasifikasi->id) }}"
                                    title="Lihat Detail"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                {{-- Edit (amber) --}}
                                <a href="{{ route('admin.sekretariat.klasifikasi-surat.edit', $klasifikasi->id) }}"
                                    title="Edit"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Hapus (red) --}}
                                <button type="button" title="Hapus"
                                    @click="deleteId = {{ $klasifikasi->id }}; deleteName = '{{ addslashes($klasifikasi->nama_klasifikasi) }}'; showDeleteModal = true"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $klasifikasi->id }}"
                                    action="{{ route('admin.sekretariat.klasifikasi-surat.destroy', $klasifikasi->id) }}"
                                    method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>

                            </div>
                        </td>

                        {{-- KODE --}}
                        <td class="px-3 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-lg font-mono tracking-wide">
                                {{ $klasifikasi->kode }}
                            </span>
                        </td>

                        {{-- NAMA KLASIFIKASI --}}
                        <td class="px-3 py-3">
                            <p class="font-semibold text-gray-900 dark:text-slate-100 text-sm">{{ $klasifikasi->nama_klasifikasi }}</p>
                            @if($klasifikasi->keterangan)
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5 line-clamp-1">
                                {{ Str::limit($klasifikasi->keterangan, 80) }}
                            </p>
                            @endif
                        </td>

                        {{-- NAMA --}}
                        <td class="px-3 py-3 hidden lg:table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded-full">
                                {{ $klasifikasi->nama }}
                            </span>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-3 py-3 text-center">
                            @if($klasifikasi->status)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span class="text-gray-400 dark:text-slate-500 text-xs">○ Tidak Aktif</span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data klasifikasi surat</p>
                                <a href="{{ route('admin.sekretariat.klasifikasi-surat.create') }}"
                                    class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-medium">
                                    + Tambah klasifikasi pertama
                                </a>
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
                @if($klasifikasiSurat->total() > 0)
                    Menampilkan {{ $klasifikasiSurat->firstItem() }} sampai {{ $klasifikasiSurat->lastItem() }} dari
                    {{ number_format($klasifikasiSurat->total()) }} entri
                @else
                    Menampilkan 0 sampai 0 dari 0 entri
                @endif
            </p>
            <div class="flex items-center gap-1">

                @if($klasifikasiSurat->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $klasifikasiSurat->appends(request()->query())->previousPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                @endif

                @php
                    $cp    = $klasifikasiSurat->currentPage();
                    $lp    = $klasifikasiSurat->lastPage();
                    $start = max(1, $cp - 2);
                    $end   = min($lp, $cp + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $klasifikasiSurat->appends(request()->query())->url(1) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                    @if($start > 2)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                @endif

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $cp)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                    @else
                        <a href="{{ $klasifikasiSurat->appends(request()->query())->url($p) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                    @endif
                @endfor

                @if($end < $lp)
                    @if($end < $lp - 1)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                    <a href="{{ $klasifikasiSurat->appends(request()->query())->url($lp) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lp }}</a>
                @endif

                @if($klasifikasiSurat->hasMorePages())
                    <a href="{{ $klasifikasiSurat->appends(request()->query())->nextPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                @endif

            </div>
        </div>

    </div>

    {{-- ── DELETE MODAL (single) ── --}}
    <div x-show="showDeleteModal"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div @click.outside="showDeleteModal = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 p-6 w-full max-w-sm mx-4">
            <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-slate-100 text-center mb-1">Hapus Klasifikasi?</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-1">
                Klasifikasi <span class="font-semibold text-gray-700 dark:text-slate-200" x-text="deleteName"></span>
            </p>
            <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-6">
                Data ini akan dihapus permanen dan tidak dapat dikembalikan.
            </p>
            <div class="flex gap-3">
                <button @click="showDeleteModal = false"
                    class="flex-1 py-2.5 text-sm font-semibold text-gray-700 dark:text-slate-200 bg-gray-100 dark:bg-slate-700 rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                    Batal
                </button>
                <button @click="document.getElementById('delete-form-' + deleteId).submit()"
                    class="flex-1 py-2.5 text-sm font-semibold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Bulk (partial existing) --}}
    @includeIf('admin.partials.modal-hapus')

</div>
@endsection