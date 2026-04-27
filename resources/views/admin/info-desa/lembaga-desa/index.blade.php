@extends('layouts.admin')

@section('title', 'Daftar Lembaga Desa')

@section('content')
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

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Daftar Lembaga Desa</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data lembaga desa</p>
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
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Daftar Lembaga Desa</span>
            </nav>
        </div>

        {{-- CARD UTAMA --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow: visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah --}}
                <a href="{{ route('admin.lembaga-desa.create') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </a>

                {{-- Hapus Bulk --}}
                <form method="POST" action="{{ route('admin.lembaga-desa.bulk-destroy') }}" id="form-bulk-hapus">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                            action: '{{ route('admin.lembaga-desa.bulk-destroy') }}',
                            nama: selectedIds.length + ' lembaga yang dipilih',
                            formId: 'form-bulk-hapus'
                        })"
                        :class="selectedIds.length > 0 ?
                            'bg-red-500 hover:bg-red-600 cursor-pointer' :
                            'bg-red-300 opacity-60 cursor-not-allowed'"
                        class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                        <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                    </button>
                </form>

                {{-- Cetak / Unduh Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak / Unduh
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1 w-40 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                        style="display:none">
                        <button type="button"
                            @click="open = false; document.getElementById('modal-cetak').classList.remove('hidden')"
                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                        <button type="button"
                            @click="open = false; document.getElementById('modal-unduh').classList.remove('hidden')"
                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </button>
                    </div>
                </div>

                {{-- Kategori --}}
                <a href="{{ route('admin.lembaga-kategori.index') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Kategori
                </a>

                {{-- Reset / Bersihkan --}}
                @if (request()->hasAny(['aktif', 'kategori_id', 'search']))
                    <a href="{{ route('admin.lembaga-desa.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @else
                    <a href="{{ route('admin.lembaga-desa.index') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Bersihkan
                    </a>
                @endif
            </div>

            {{-- ── FILTER ── --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <form method="GET" action="{{ route('admin.lembaga-desa.index') }}" id="filter-form"
                    class="flex flex-wrap items-center gap-2">

                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <input type="hidden" name="aktif" id="val-aktif" value="{{ request('aktif') }}">
                    <input type="hidden" name="kategori_id" id="val-kategori" value="{{ request('kategori_id') }}">

                    {{-- Filter Status --}}
                    <div class="relative w-44" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('aktif') }}',
                        placeholder: 'Semua Status',
                        options: [
                            { value: '1', label: 'Aktif' },
                            { value: '0', label: 'Nonaktif' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-aktif').value = opt.value;
                            this.open = false; this.search = '';
                            document.getElementById('filter-form').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-aktif').value = '';
                            this.open = false; this.search = '';
                            document.getElementById('filter-form').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                            <span x-text="label || placeholder"
                                :class="label ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari status..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
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

                    {{-- Filter Kategori --}}
                    <div class="relative w-56" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('kategori_id') }}',
                        placeholder: 'Pilih Kategori Lembaga',
                        options: [
                            @foreach ($kategoris as $kategori)
                                { value: '{{ $kategori->id }}', label: '{{ addslashes($kategori->nama) }}' }, @endforeach
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-kategori').value = opt.value;
                            this.open = false; this.search = '';
                            document.getElementById('filter-form').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-kategori').value = '';
                            this.open = false; this.search = '';
                            document.getElementById('filter-form').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                            <span x-text="label || placeholder"
                                :class="label ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
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
                                <li x-show="filtered.length === 0"
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                </form>
            </div>

            {{-- ── TOOLBAR: Tampilkan X entri + Search ── --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.lembaga-desa.index') }}" id="form-per-page"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page" value="{{ request('per_page', 10) }}">

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
                            document.getElementById('val-per-page').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-1"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
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
                <form method="GET" action="{{ route('admin.lembaga-desa.index') }}" class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                        <div
                            class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                            <div
                                class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                                <div
                                    class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700">
                                </div>
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
                            <th class="px-3 py-3 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                                NO
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider"
                                style="min-width:160px">
                                AKSI
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'kode', 'dir' => request('sort') === 'kode' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    KODE LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'kode' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'kode' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'dir' => request('sort') === 'nama' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    NAMA LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'nama' && request('dir') === 'asc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5 {{ request('sort') === 'nama' && request('dir') === 'desc' ? 'text-emerald-500' : '' }}"
                                            viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'ketua', 'dir' => request('sort') === 'ketua' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    KETUA LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'kategori', 'dir' => request('sort') === 'kategori' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    KATEGORI LEMBAGA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_anggota', 'dir' => request('sort') === 'jumlah_anggota' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    JUMLAH ANGGOTA
                                    <span class="flex flex-col gap-px opacity-50 group-hover:opacity-100">
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 0L10 6H0L5 0z" />
                                        </svg>
                                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 6" fill="currentColor">
                                            <path d="M5 6L0 0H10L5 6z" />
                                        </svg>
                                    </span>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($lembaga as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' : ''">

                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $item->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-sm">
                                    {{ $lembaga->firstItem() + $index }}
                                </td>

                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1 flex-nowrap">
                                        {{-- Rincian --}}
                                        <a href="{{ route('admin.lembaga-desa.show', $item->id) }}" title="Rincian Data"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h10" />
                                            </svg>
                                        </a>
                                        {{-- Dokumen --}}
                                        <a href="/admin/info-desa/lembaga-desa/{{ $item->id }}/dokumen"
                                            title="Dokumen"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-sky-500 hover:bg-sky-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.lembaga-desa.edit', $item->id) }}" title="Ubah Data"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Hapus --}}
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                                action: '{{ route('admin.lembaga-desa.destroy', $item->id) }}',
                                                nama: '{{ addslashes($item->nama) }}'
                                            })"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                <td class="px-3 py-3 font-mono font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap text-sm">
                                    {{ $item->kode }}
                                </td>

                                <td class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 text-sm whitespace-nowrap">
                                    {{ $item->nama }}
                                </td>

                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400">
                                    @if ($item->ketua)
                                        {{ str_replace('_', ' ', explode('-', $item->ketua)[1] ?? $item->ketua) }}
                                    @else
                                        <span class="text-gray-400 dark:text-slate-600">—</span>
                                    @endif
                                </td>

                                <td class="px-3 py-3">
                                    @if ($item->kategori)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                            {{ $item->kategori->nama }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-600">—</span>
                                    @endif
                                </td>

                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full text-sm font-semibold text-blue-700 dark:text-blue-300">
                                        {{ $item->anggota_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">
                                            Data lembaga tidak ditemukan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── PAGINATION ── --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($lembaga->total() > 0)
                        Menampilkan {{ $lembaga->firstItem() }} sampai {{ $lembaga->lastItem() }} dari
                        {{ number_format($lembaga->total()) }} entri
                    @else
                        Menampilkan 0 sampai 0 dari 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($lembaga->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $lembaga->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif

                    @php
                        $cp = $lembaga->currentPage();
                        $lp = $lembaga->lastPage();
                    @endphp
                    @for ($p = max(1, $cp - 2); $p <= min($lp, $cp + 2); $p++)
                        @if ($p == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                        @else
                            <a href="{{ $lembaga->appends(request()->query())->url($p) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                        @endif
                    @endfor

                    @if ($lembaga->hasMorePages())
                        <a href="{{ $lembaga->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── MODAL CETAK ── --}}
        <div id="modal-cetak"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-slate-100 mb-5">Cetak Laporan</h3>

                <form method="GET" action="{{ route('admin.lembaga-desa.cetak') }}" target="_blank">
                    <input type="hidden" name="aktif" value="{{ request('aktif') }}">

                    {{-- Ditandatangani --}}
                    <div class="relative mb-4" x-data="{
                        open: false,
                        search: '',
                        selected: { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                        options: [
                            { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                            @foreach ($perangkat as $p)
                                { id: '{{ $p->id }}', label: '{{ addslashes($p->nama) }}{{ optional($p->jabatan)->nama ? ' (' . addslashes($p->jabatan->nama) . ')' : '' }}' }, @endforeach
                        ],
                        get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Laporan Ditandatangani
                        </label>
                        <input type="hidden" name="ditandatangani" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'hover:border-emerald-400'">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0"
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Diketahui --}}
                    <div class="relative mb-6" x-data="{
                        open: false,
                        search: '',
                        selected: { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                        options: [
                            { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                            @foreach ($perangkat as $p)
                                { id: '{{ $p->id }}', label: '{{ addslashes($p->nama) }}{{ optional($p->jabatan)->nama ? ' (' . addslashes($p->jabatan->nama) . ')' : '' }}' }, @endforeach
                        ],
                        get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Laporan Diketahui
                        </label>
                        <input type="hidden" name="diketahui" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'hover:border-emerald-400'">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0"
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button"
                            onclick="document.getElementById('modal-cetak').classList.add('hidden')"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── MODAL UNDUH ── --}}
        <div id="modal-unduh"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-slate-100 mb-5">Unduh Laporan</h3>

                <form method="GET" action="{{ route('admin.lembaga-desa.unduh') }}">
                    <input type="hidden" name="aktif" value="{{ request('aktif') }}">

                    {{-- Ditandatangani --}}
                    <div class="relative mb-4" x-data="{
                        open: false,
                        search: '',
                        selected: { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                        options: [
                            { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                            @foreach ($perangkat as $p)
                                { id: '{{ $p->id }}', label: '{{ addslashes($p->nama) }}{{ optional($p->jabatan)->nama ? ' (' . addslashes($p->jabatan->nama) . ')' : '' }}' }, @endforeach
                        ],
                        get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Laporan Ditandatangani
                        </label>
                        <input type="hidden" name="ditandatangani" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'hover:border-emerald-400'">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0"
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Diketahui --}}
                    <div class="relative mb-6" x-data="{
                        open: false,
                        search: '',
                        selected: { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                        options: [
                            { id: '', label: '-- Pilih Staf Pemerintah Desa --' },
                            @foreach ($perangkat as $p)
                                { id: '{{ $p->id }}', label: '{{ addslashes($p->nama) }}{{ optional($p->jabatan)->nama ? ' (' . addslashes($p->jabatan->nama) . ')' : '' }}' }, @endforeach
                        ],
                        get filtered() { return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Laporan Diketahui
                        </label>
                        <input type="hidden" name="diketahui" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'hover:border-emerald-400'">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                                <li x-show="filtered.length === 0"
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button"
                            onclick="document.getElementById('modal-unduh').classList.add('hidden')"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-violet-500 hover:bg-violet-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Hapus (single & bulk) --}}
        @include('admin.partials.modal-hapus')

    </div>
@endsection