@extends('layouts.admin')

@section('title', 'Inventaris')

@section('content')
<div x-data="{ showDeleteModal: false, deleteId: null, deleteName: '' }">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Inventaris Desa</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola inventaris dan aset desa</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Inventaris Desa</span>
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
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Total Barang</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $stats['total'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Barang Baik</p>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['baik'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Perlu Perbaikan</p>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['perlu_perbaikan'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 flex items-center gap-4">
            <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Barang Rusak</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['rusak'] }}</p>
            </div>
        </div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700" style="overflow: visible">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.sekretariat.inventaris.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Barang
            </a>
        </div>

        {{-- ── FILTER ── --}}
        <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <form method="GET" action="{{ route('admin.sekretariat.inventaris') }}" id="form-filter-inventaris"
                class="flex flex-wrap items-center gap-2">

                <input type="hidden" name="kondisi"  id="val-inventaris-kondisi"  value="{{ request('kondisi') }}">
                <input type="hidden" name="kategori" id="val-inventaris-kategori" value="{{ request('kategori') }}">

                {{-- Dropdown Kategori --}}
                <div class="relative w-52" x-data="{
                    open: false,
                    search: '',
                    selected: '{{ request('kategori') }}',
                    placeholder: 'Pilih Kategori',
                    options: [
                        { value: 'elektronik', label: 'Elektronik' },
                        { value: 'furniture',  label: 'Furniture' },
                        { value: 'kendaraan',  label: 'Kendaraan' },
                        { value: 'peralatan',  label: 'Peralatan' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-inventaris-kategori').value = opt.value;
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-inventaris').submit();
                    },
                    reset() {
                        this.selected = '';
                        document.getElementById('val-inventaris-kategori').value = '';
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-inventaris').submit();
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
                                placeholder="Cari kategori..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <li @click="reset()"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === '' ?
                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                    'text-gray-400 dark:text-slate-500 italic'">
                                Semua Kategori
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

                {{-- Dropdown Kondisi --}}
                <div class="relative w-52" x-data="{
                    open: false,
                    search: '',
                    selected: '{{ request('kondisi') }}',
                    placeholder: 'Pilih Kondisi',
                    options: [
                        { value: 'baik',            label: 'Baik' },
                        { value: 'perlu_perbaikan', label: 'Perlu Perbaikan' },
                        { value: 'rusak',           label: 'Rusak' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-inventaris-kondisi').value = opt.value;
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-inventaris').submit();
                    },
                    reset() {
                        this.selected = '';
                        document.getElementById('val-inventaris-kondisi').value = '';
                        this.open = false; this.search = '';
                        document.getElementById('form-filter-inventaris').submit();
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
                                placeholder="Cari kondisi..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <li @click="reset()"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="selected === '' ?
                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                    'text-gray-400 dark:text-slate-500 italic'">
                                Semua Kondisi
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
                @if(request()->hasAny(['kondisi', 'kategori', 'search']))
                    <a href="{{ route('admin.sekretariat.inventaris') }}"
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
            <form method="GET" action="{{ route('admin.sekretariat.inventaris') }}" id="form-per-page-inventaris"
                class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                @foreach(request()->except('per_page', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <input type="hidden" name="per_page" id="val-per-page-inventaris" value="{{ request('per_page', 10) }}">

                <span>Tampilkan</span>

                <div class="relative w-24" x-data="{
                    open: false,
                    selected: '{{ request('per_page', 10) }}',
                    options: [
                        { value: '10',  label: '10' },
                        { value: '25',  label: '25' },
                        { value: '50',  label: '50' },
                        { value: '100', label: '100' },
                    ],
                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                    choose(opt) {
                        this.selected = opt.value;
                        document.getElementById('val-per-page-inventaris').value = opt.value;
                        this.open = false;
                        document.getElementById('form-per-page-inventaris').submit();
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
            <form method="GET" action="{{ route('admin.sekretariat.inventaris') }}" class="flex items-center gap-2">
                @foreach(request()->except('search', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="nama barang, lokasi..." maxlength="50"
                        class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-56">
                    <div class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                        <div class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                            Cari berdasarkan nama barang atau lokasi
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
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider" style="min-width:100px">AKSI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA BARANG</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">KATEGORI</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">JUMLAH</th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">KONDISI</th>
                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">LOKASI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($inventaris as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                        {{-- NO --}}
                        <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                            {{ $inventaris->firstItem() + $index }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-3 py-3">
                            <div class="flex items-center gap-1 flex-nowrap">

                                {{-- Edit (amber) --}}
                                <a href="{{ route('admin.sekretariat.inventaris.edit', $item->id) }}" title="Edit"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Hapus (red) --}}
                                <button type="button" title="Hapus"
                                    @click="deleteId = {{ $item->id }}; deleteName = '{{ addslashes($item->nama_barang) }}'; showDeleteModal = true"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.sekretariat.inventaris.destroy', $item->id) }}"
                                    method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>

                            </div>
                        </td>

                        {{-- NAMA BARANG --}}
                        <td class="px-3 py-3">
                            <p class="font-semibold text-gray-900 dark:text-slate-100 text-sm">{{ $item->nama_barang }}</p>
                            @if($item->deskripsi)
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                                {{ Str::limit($item->deskripsi, 50) }}
                            </p>
                            @endif
                        </td>

                        {{-- KATEGORI --}}
                        <td class="px-3 py-3 hidden md:table-cell">
                            <span class="inline-flex items-center px-2.5 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full capitalize">
                                {{ $item->kategori }}
                            </span>
                        </td>

                        {{-- JUMLAH --}}
                        <td class="px-3 py-3 text-center hidden md:table-cell">
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-300">{{ $item->jumlah }}</span>
                        </td>

                        {{-- KONDISI --}}
                        <td class="px-3 py-3 text-center">
                            @if($item->kondisi === 'baik')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Baik
                                </span>
                            @elseif($item->kondisi === 'rusak')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Rusak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Perlu Perbaikan
                                </span>
                            @endif
                        </td>

                        {{-- LOKASI --}}
                        <td class="px-3 py-3 text-sm text-gray-500 dark:text-slate-400 hidden lg:table-cell max-w-[180px] truncate">
                            {{ $item->lokasi ?? '—' }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p class="text-gray-500 dark:text-slate-400 font-medium">Belum ada data inventaris</p>
                                <a href="{{ route('admin.sekretariat.inventaris.create') }}"
                                    class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-medium">
                                    + Tambah barang pertama
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
                @if($inventaris->total() > 0)
                    Menampilkan {{ $inventaris->firstItem() }} sampai {{ $inventaris->lastItem() }} dari
                    {{ number_format($inventaris->total()) }} entri
                @else
                    Menampilkan 0 sampai 0 dari 0 entri
                @endif
            </p>
            <div class="flex items-center gap-1">

                @if($inventaris->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $inventaris->appends(request()->query())->previousPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                @endif

                @php
                    $cp    = $inventaris->currentPage();
                    $lp    = $inventaris->lastPage();
                    $start = max(1, $cp - 2);
                    $end   = min($lp, $cp + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $inventaris->appends(request()->query())->url(1) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                    @if($start > 2)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                @endif

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $cp)
                        <span class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                    @else
                        <a href="{{ $inventaris->appends(request()->query())->url($p) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                    @endif
                @endfor

                @if($end < $lp)
                    @if($end < $lp - 1)
                        <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                    @endif
                    <a href="{{ $inventaris->appends(request()->query())->url($lp) }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lp }}</a>
                @endif

                @if($inventaris->hasMorePages())
                    <a href="{{ $inventaris->appends(request()->query())->nextPageUrl() }}"
                        class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                @endif

            </div>
        </div>

    </div>

    {{-- ── DELETE MODAL ── --}}
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
            <h3 class="text-base font-bold text-gray-900 dark:text-slate-100 text-center mb-1">Hapus Barang?</h3>
            <p class="text-sm text-gray-500 dark:text-slate-400 text-center mb-1">
                Barang <span class="font-semibold text-gray-700 dark:text-slate-200" x-text="deleteName"></span>
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

</div>
@endsection