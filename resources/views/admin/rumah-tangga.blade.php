@extends('layouts.admin')

@section('title', 'Data Rumah Tangga')

@section('content')

    <div x-data="{
        selectedIds: [],
        selectAll: false,
        showTambah: false,
        perPage: {{ request('per_page', 10) }},
        searchQuery: '',
        kepalaResults: [],
        selectedId: '',
        selectedNama: '',
        searchLoading: false,
        searchTimer: null,
    
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
        },
    
        // SESUDAH
        searchKepala() {
            clearTimeout(this.searchTimer);
            const q = (this.searchQuery || '').trim();
            if (!q) {
                this.kepalaResults = [];
                this.searchLoading = false;
                return;
            }
            this.searchLoading = true;
            this.searchTimer = setTimeout(async () => {
                const res = await fetch('{{ url('admin/rumah-tangga/cari-penduduk') }}?q=' + encodeURIComponent(q));
                this.kepalaResults = await res.json();
                this.searchLoading = false;
            }, 300);
        },
        pilihKepala(item) {
            this.selectedId = item.id;
            this.selectedNama = item.text;
            this.searchQuery = '';
            this.kepalaResults = [];
        },
        resetModal() {
            this.searchQuery = '';
            this.kepalaResults = [];
            this.selectedId = '';
            this.selectedNama = '';
        }
    }">

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Rumah Tangga</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data rumah tangga desa</p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Data Rumah Tangga</span>
            </nav>
        </div>

        {{-- FLASH --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
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

        {{-- CARD UTAMA --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow: visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah — buka modal --}}
                <button type="button" @click="showTambah = true; resetModal()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>

                {{-- Hapus Bulk --}}
                <form method="POST" action="{{ route('admin.rumah-tangga.bulk-destroy') }}" id="form-bulk-hapus">
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
                        :class="selectedIds.length > 0 ? 'bg-red-500 hover:bg-red-600 cursor-pointer' :
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

                {{-- Impor --}}
                <button type="button" @click="$dispatch('buka-modal-impor')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Impor
                </button>

                {{-- Laporan --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan
                        <svg class="w-3.5 h-3.5" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1 w-40 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                        style="display:none">
                        <a href="{{ route('admin.rumah-tangga.cetak', request()->query()) }}" target="_blank"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </a>
                        <a href="{{ route('admin.rumah-tangga.unduh', request()->query()) }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── FILTER + TAMPILKAN + CARI ── --}}
            <div class="px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <form method="GET" action="{{ route('admin.rumah-tangga.index') }}" id="form-filter"
                    class="flex flex-wrap items-center justify-between gap-3">

                    <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">
                    <input type="hidden" name="dusun" id="val-dusun" value="{{ request('dusun') }}">
                    <input type="hidden" name="per_page" id="val-per-page-rt" value="{{ request('per_page', 10) }}">

                    <div class="flex flex-wrap items-center gap-2">

                        {{-- Status --}}
                        <div class="relative w-52" x-data="{
                            open: false,
                            selected: '{{ request('status') }}',
                            placeholder: 'Pilih Status',
                            options: [
                                { value: 'aktif', label: 'Aktif' },
                                { value: 'tidak_aktif', label: 'Tidak Aktif' },
                                { value: 'tanpa_kepala', label: 'Tanpa Kepala Keluarga' },
                            ],
                            get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                            choose(opt) {
                                this.selected = opt.value;
                                document.getElementById('val-status').value = opt.value;
                                this.open = false;
                                document.getElementById('form-filter').submit();
                            },
                            reset() {
                                this.selected = '';
                                document.getElementById('val-status').value = '';
                                this.open = false;
                                document.getElementById('form-filter').submit();
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
                                <ul class="py-1">
                                    <li @click="reset()"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === '' ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-400 dark:text-slate-500 italic'">
                                        Semua Status
                                    </li>
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

                        {{-- Pilih Jenis Kelamin --}}
                        <div class="relative w-44" x-data="{
                            open: false,
                            selected: '{{ request('jenis_kelamin') }}',
                            options: [
                                { value: '', label: 'Pilih Jenis Kelamin' },
                                { value: 'L', label: 'Laki-laki' },
                                { value: 'P', label: 'Perempuan' },
                            ],
                            get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Jenis Kelamin'; },
                            choose(opt) {
                                this.selected = opt.value;
                                this.open = false;
                                document.getElementById('form-filter').submit();
                            }
                        }" @click.away="open = false">
                            {{-- hidden input --}}
                            <input type="hidden" name="jenis_kelamin" :value="selected">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                                <span x-text="label"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <ul class="py-1">
                                    <template x-for="opt in options" :key="opt.value">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        {{-- Pilih Dusun --}}
                        <div class="relative w-44" x-data="{
                            open: false,
                            search: '',
                            selected: '{{ request('dusun') }}',
                            options: [
                                { value: '', label: 'Pilih Dusun' },
                                @foreach ($dusunList as $dusun)
                            { value: '{{ addslashes($dusun) }}', label: '{{ addslashes($dusun) }}' }, @endforeach
                            ],
                            get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Dusun'; },
                            get filtered() {
                                if (!this.search) return this.options;
                                return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            choose(opt) {
                                this.selected = opt.value;
                                document.getElementById('val-dusun').value = opt.value;
                                this.open = false;
                                this.search = '';
                                document.getElementById('form-filter').submit();
                            }
                        }" @click.away="open = false">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                                <span x-text="label"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-model="search" placeholder="Cari dusun..."
                                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.value">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div id="form-per-page-rt"
                            class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
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
                                    document.getElementById('val-per-page-rt').value = opt.value;
                                    this.open = false;
                                    document.getElementById('form-filter').submit();
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
                        </div>

                        @if (request()->hasAny(['status', 'dusun', 'search', 'jenis_kelamin']))
                            <a href="{{ route('admin.rumah-tangga.index') }}"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400 ml-auto">
                        <span>Cari:</span>
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="kata kunci pencarian" maxlength="50"
                                title="Masukkan kata kunci untuk mencari (maksimal 50 karakter)"
                                @input.debounce.400ms="$el.form.submit()"
                                class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-48">
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
                                NO</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-28">
                                AKSI</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">
                                FOTO</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NOMOR RUMAH TANGGA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                KEPALA RUMAH TANGGA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                DTKS</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JUMLAH KK</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JUMLAH ANGGOTA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                ALAMAT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                DUSUN</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                RW</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                RT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                TANGGAL TERDAFTAR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($rumahTangga as $index => $rt)
                            @php $kepala = $rt->getKepalaRumahTangga(); @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $rt->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $rt->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-sm">
                                    {{ $rumahTangga->firstItem() + $index }}
                                </td>

                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.rumah-tangga.show', $rt) }}" title="Lihat"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.rumah-tangga.edit', $rt) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                            action: '{{ route('admin.rumah-tangga.destroy', $rt) }}',
                                            nama: 'RT {{ addslashes($rt->no_rumah_tangga) }}'
                                        })"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-3 py-3 text-center">
                                    @php $foto = $kepala?->foto ?? null; @endphp
                                    @if ($foto && file_exists(public_path('storage/foto/' . $foto)))
                                        <img src="{{ asset('storage/foto/' . $foto) }}" alt="{{ $kepala->nama }}"
                                            class="w-8 h-8 rounded-full object-cover mx-auto border-2 border-gray-200 dark:border-slate-600">
                                    @else
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mx-auto">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                {{-- No. Rumah Tangga --}}
                                <td
                                    class="px-3 py-3 font-mono font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.rumah-tangga.show', $rt) }}" class="hover:underline">
                                        {{ $rt->no_rumah_tangga }}
                                    </a>
                                </td>

                                {{-- Kepala RT --}}
                                <td
                                    class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 text-sm whitespace-nowrap">
                                    {{ $kepala?->nama ?? '—' }}
                                </td>

                                {{-- NIK --}}
                                <td
                                    class="px-3 py-3 font-mono text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $kepala?->nik ?? '—' }}
                                </td>

                                {{-- DTKS --}}
                                <td class="px-3 py-3 text-center">
                                    @if ($rt->is_dtks)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Ya
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Jumlah KK --}}
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full text-sm font-semibold text-blue-700 dark:text-blue-300">
                                        {{ $rt->getTotalKk() }}
                                    </span>
                                </td>

                                {{-- Jumlah Anggota --}}
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-full text-sm font-semibold text-gray-700 dark:text-slate-300">
                                        {{ $rt->getTotalAnggota() }}
                                    </span>
                                </td>

                                <td
                                    class="px-3 py-3 text-sm text-gray-600 dark:text-slate-300 hidden lg:table-cell max-w-xs truncate">
                                    {{ $rt->alamat ?? '—' }}
                                </td>
                                <td
                                    class="px-3 py-3 text-sm text-gray-600 dark:text-slate-300 hidden lg:table-cell whitespace-nowrap">
                                    {{ $rt->wilayah?->dusun ?? '—' }}
                                </td>
                                <td
                                    class="px-3 py-3 text-sm text-center text-gray-600 dark:text-slate-300 hidden lg:table-cell">
                                    {{ $rt->wilayah?->rw ?? '—' }}
                                </td>
                                <td
                                    class="px-3 py-3 text-sm text-center text-gray-600 dark:text-slate-300 hidden lg:table-cell">
                                    {{ $rt->wilayah?->rt ?? '—' }}
                                </td>
                                <td
                                    class="px-3 py-3 text-sm text-gray-500 dark:text-slate-400 hidden xl:table-cell whitespace-nowrap">
                                    {{ $rt->tgl_terdaftar?->format('d/m/Y') ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang
                                            tersedia pada tabel ini</p>
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
                    @if ($rumahTangga->total() > 0)
                        Menampilkan {{ $rumahTangga->firstItem() }} sampai {{ $rumahTangga->lastItem() }} dari
                        {{ number_format($rumahTangga->total()) }} entri
                    @else
                        Menampilkan 0 sampai 0 dari 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($rumahTangga->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $rumahTangga->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif
                    @php
                        $cp = $rumahTangga->currentPage();
                        $lp = $rumahTangga->lastPage();
                    @endphp
                    @for ($p = max(1, $cp - 2); $p <= min($lp, $cp + 2); $p++)
                        @if ($p == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                        @else
                            <a href="{{ $rumahTangga->appends(request()->query())->url($p) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                        @endif
                    @endfor
                    @if ($rumahTangga->hasMorePages())
                        <a href="{{ $rumahTangga->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
         MODAL TAMBAH RUMAH TANGGA (mirip OpenSID)
    ══════════════════════════════════════════════════════════ --}}
        <div x-show="showTambah" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showTambah = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">

                {{-- Header --}}
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700 sticky top-0 bg-white dark:bg-slate-800 rounded-t-2xl z-10">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Tambah</h3>
                    <button @click="showTambah = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form action="{{ route('admin.rumah-tangga.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Nomor Rumah Tangga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Nomor Rumah Tangga
                        </label>
                        <input type="text" name="no_rumah_tangga" placeholder="Nomor Rumah Tangga"
                            value="{{ old('no_rumah_tangga') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        <p class="text-xs text-red-500 mt-1">Kosongkan untuk melanjutkan nomor rumah tangga terakhir</p>
                    </div>

                    {{-- Kepala Rumah Tangga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Kepala Rumah Tangga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{ openDrop: false }" @click.away="openDrop = false">
                            <div @click="openDrop = !openDrop; if (openDrop) { $nextTick(() => $refs.kepalaSearchInput?.focus()); }"
                                class="flex items-center justify-between w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 cursor-pointer transition-colors"
                                :class="openDrop ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                                <span x-text="selectedNama || '-- Silakan Cari NIK / Nama Kepala Keluarga --'"
                                    :class="selectedNama ? 'text-gray-800 dark:text-slate-200' :
                                        'text-gray-400 dark:text-slate-500'"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                    :class="openDrop ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <input type="hidden" name="kepala_penduduk_id" :value="selectedId">

                            {{-- Loading --}}
                            <div x-show="searchLoading" class="absolute right-3 top-2.5">
                                <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                            </div>

                            {{-- Dropdown pencarian kepala --}}
                            <div x-show="openDrop" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-ref="kepalaSearchInput" x-model="searchQuery"
                                        @input="searchKepala()" @keydown.escape="openDrop = false"
                                        placeholder="Cari NIK atau nama..." autocomplete="off"
                                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="item in kepalaResults" :key="item.id">
                                        <li @click="pilihKepala(item); openDrop = false"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="selectedId === item.id ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'">
                                            <span class="font-medium" x-text="item.nama"></span>
                                            <span class="text-xs font-mono ml-1 opacity-75" x-text="'(' + item.nik + ')'"></span>
                                        </li>
                                    </template>
                                    <li x-show="searchQuery.length > 0 && !searchLoading && kepalaResults.length === 0"
                                        class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                        Data tidak ditemukan
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Info box --}}
                        <div
                            class="mt-2 px-3 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg text-xs text-gray-500 dark:text-slate-400">
                            Silakan cari nama / NIK dari data penduduk yang sudah terinput.
                            Penduduk yang dipilih otomatis berstatus sebagai Kepala Rumah Tangga baru tersebut.
                        </div>
                    </div>

                    {{-- BDT --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">BDT</label>
                        <input type="text" name="bdt" placeholder="BDT" value="{{ old('bdt') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                    </div>

                    {{-- Terdaftar di DTKS --}}
                    <div class="flex items-center gap-2.5">
                        <input type="checkbox" name="is_dtks" value="1" id="is_dtks"
                            {{ old('is_dtks') ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        <label for="is_dtks"
                            class="text-sm text-gray-700 dark:text-slate-300 cursor-pointer select-none">
                            Terdaftar di DTKS
                        </label>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showTambah = false"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── MODAL IMPOR ── --}}
        <div x-data="{ show: false }" @buka-modal-impor.window="show = true" x-show="show" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">
            <div @click.outside="show = false"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-slate-100">Impor Pengelompokan Data Rumah Tangga
                        </h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">
                            Pengelompokan data penduduk berdasarkan nomor urut rumah tangga
                        </p>
                    </div>
                    <button @click="show = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <ol class="text-xs text-gray-500 dark:text-slate-400 space-y-1 list-decimal list-inside">
                        <li>Pastikan format data yang akan diimpor sudah sesuai dengan aturan impor data</li>
                        <li>Simpan (Save) file spreadsheet sebagai file .xlsx</li>
                        <li>Pastikan format Excel berekstensi .xlsx (format Excel versi 2007 ke atas)</li>
                    </ol>

                    <form action="{{ route('admin.rumah-tangga.impor') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                                    File .xlsx untuk diimpor:
                                </label>
                                <input type="file" name="file" accept=".xlsx,.xls" required
                                    class="w-full text-sm border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2
                                          bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                          file:mr-3 file:py-1 file:px-3 file:rounded file:border-0
                                          file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700
                                          hover:file:bg-emerald-100">
                                <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Data dengan NIK sama akan ditimpa
                                </p>
                            </div>

                            <a href="{{ route('admin.rumah-tangga.template-impor') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Contoh Format Impor Data Rumah Tangga
                            </a>

                            <div
                                class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-slate-700">
                                <button type="button" @click="show = false"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Impor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('admin.partials.modal-hapus')
    </div>

@endsection
