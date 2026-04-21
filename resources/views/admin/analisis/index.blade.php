@extends('layouts.admin')

@section('title', 'Master Analisis')

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
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Master Analisis</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola master analisis data potensi/sumber daya
                    desa</p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Master Analisis</span>
            </nav>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 px-5 pt-5 pb-4 flex-wrap">

                {{-- Tambah Analisis Baru --}}
                <a href="{{ route('admin.analisis.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Analisis Baru
                </a>

                {{-- Hapus Bulk — form dengan hidden inputs ids[] dari Alpine --}}
                <form method="POST" action="{{ route('admin.analisis.destroy', '_bulk') }}" id="form-bulk-hapus">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && modalHapus.bukaJs(selectedIds.length + ' analisis yang dipilih', () => document.getElementById('form-bulk-hapus').submit())"
                        :class="selectedIds.length > 0 ? 'bg-red-500 hover:bg-red-600 cursor-pointer' :
                            'bg-red-300 dark:bg-red-900/50 cursor-not-allowed opacity-60'"
                        class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                        <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                    </button>
                </form>

                {{-- Impor Analisis --}}
                <button type="button" onclick="document.getElementById('modal-impor').classList.remove('hidden')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Impor Analisis
                </button>
            </div>

            {{-- Filter + Toolbar — satu form terpusat --}}
            <div class="px-5 pb-4">
                <form method="GET" action="{{ route('admin.analisis.index') }}" id="form-filter" class="space-y-3">

                    {{-- Hidden state semua parameter --}}
                    <input type="hidden" name="search" id="val-search" value="{{ request('search') }}">
                    <input type="hidden" name="per_page" id="val-per_page" value="{{ request('per_page', 10) }}">
                    <input type="hidden" name="subjek" id="val-subjek" value="{{ request('subjek') }}">
                    <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">

                    {{-- Baris filter: Subjek + Status + Reset --}}
                    <div class="flex flex-wrap items-center gap-2">

                        {{-- ── Custom Dropdown: Pilih Subjek ── --}}
                        <div class="relative w-52" x-data="{
                            open: false,
                            search: '',
                            selected: '{{ request('subjek') }}',
                            label: '{{ collect([
                                'PENDUDUK' => 'Penduduk',
                                'KELUARGA' => 'Keluarga / KK',
                                'RUMAH_TANGGA' => 'Rumah Tangga',
                                'KELOMPOK' => 'Kelompok',
                                'DESA' => 'Desa',
                                'DUSUN' => 'Dusun',
                                'RW' => 'Rukun Warga (RW)',
                                'RT' => 'Rukun Tetangga (RT)',
                            ])->get(request('subjek'), '') }}',
                            placeholder: 'Pilih Subjek',
                            options: [
                                { value: '', label: 'Semua Subjek' },
                                { value: 'PENDUDUK', label: 'Penduduk' },
                                { value: 'KELUARGA', label: 'Keluarga / KK' },
                                { value: 'RUMAH_TANGGA', label: 'Rumah Tangga' },
                                { value: 'KELOMPOK', label: 'Kelompok' },
                                { value: 'DESA', label: 'Desa' },
                                { value: 'DUSUN', label: 'Dusun' },
                                { value: 'RW', label: 'Rukun Warga (RW)' },
                                { value: 'RT', label: 'Rukun Tetangga (RT)' },
                            ],
                            get filtered() {
                                if (!this.search) return this.options;
                                return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            choose(opt) {
                                this.selected = opt.value;
                                this.label = opt.value ? opt.label : '';
                                document.getElementById('val-subjek').value = opt.value;
                                this.open = false;
                                this.search = '';
                                document.getElementById('form-filter').submit();
                            }
                        }" @click.away="open = false">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                                <span x-text="label || placeholder"
                                    :class="label ? '' : 'text-gray-400 dark:text-slate-500'"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-model="search" @keydown.escape="open = false"
                                        placeholder="Cari subjek..."
                                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                </div>
                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.value">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                            :class="selected === opt.value ?
                                                'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                'text-gray-700 dark:text-slate-200'"
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

                        {{-- ── Custom Dropdown: Pilih Status ── --}}
                        <div class="relative w-40" x-data="{
                            open: false,
                            selected: '{{ request('status') }}',
                            label: '{{ collect(['AKTIF' => 'Aktif', 'TIDAK_AKTIF' => 'Tidak Aktif'])->get(request('status'), '') }}',
                            placeholder: 'Pilih Status',
                            options: [
                                { value: '', label: 'Semua Status' },
                                { value: 'AKTIF', label: 'Aktif' },
                                { value: 'TIDAK_AKTIF', label: 'Tidak Aktif' },
                            ],
                            choose(opt) {
                                this.selected = opt.value;
                                this.label = opt.value ? opt.label : '';
                                document.getElementById('val-status').value = opt.value;
                                this.open = false;
                                document.getElementById('form-filter').submit();
                            }
                        }" @click.away="open = false">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                                <span x-text="label || placeholder"
                                    :class="label ? '' : 'text-gray-400 dark:text-slate-500'"></span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <ul class="py-1">
                                    <template x-for="opt in options" :key="opt.value">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                            :class="selected === opt.value ?
                                                'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label">
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        @if (request()->anyFilled(['subjek', 'status']))
                            <button type="button"
                                onclick="document.getElementById('val-subjek').value=''; document.getElementById('val-status').value=''; document.getElementById('form-filter').submit()"
                                class="px-3 py-2 text-sm text-gray-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 transition-colors">
                                Reset Filter
                            </button>
                        @endif
                    </div>

                    {{-- Baris toolbar: Tampilkan entri + Search --}}
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 dark:border-slate-700/50 pt-3">

                        {{-- ── Custom Dropdown: Tampilkan X entri ── --}}
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                            <span>Tampilkan</span>
                            <div class="relative w-20" x-data="{
                                open: false,
                                selected: '{{ request('per_page', 10) }}',
                                options: [
                                    { value: '10', label: '10' },
                                    { value: '25', label: '25' },
                                    { value: '50', label: '50' },
                                    { value: '100', label: '100' },
                                ],
                                choose(opt) {
                                    this.selected = opt.value;
                                    document.getElementById('val-per_page').value = opt.value;
                                    this.open = false;
                                    document.getElementById('form-filter').submit();
                                }
                            }" @click.away="open = false">
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
                                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                                    <span x-text="selected"></span>
                                    <svg class="w-3.5 h-3.5 text-gray-400 transition-transform"
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
                                    class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">
                                    <ul class="py-1">
                                        <template x-for="opt in options" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'"
                                                x-text="opt.label">
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <span>entri</span>
                        </div>

                        {{-- Search --}}
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                            <div class="relative group">
                                <input type="text" value="{{ request('search') }}" placeholder="kata kunci..."
                                    maxlength="10" title="Maksimal 10 karakter"
                                    @input.debounce.400ms="document.getElementById('val-search').value = $el.value; document.getElementById('form-filter').submit()"
                                    class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-40">
                                <div
                                    class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                                    <div
                                        class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                        Maksimal 10 karakter
                                        <div
                                            class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto border-t border-gray-200 dark:border-slate-700">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-4 py-4 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">
                                NO</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-44">
                                AKSI</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                NAMA ANALISIS</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                SUBJEK / UNIT ANALISIS</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                ID GOOGLE FORM</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                SINKRONISASI GOOGLE FORM</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($masters as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                <td class="px-4 py-4">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $item->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ $masters->firstItem() + $loop->index }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1">

                                        {{-- Detail --}}
                                        <a href="{{ route('admin.analisis.show', $item) }}" title="Detail"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.analisis.edit', $item) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        {{-- Toggle Nonaktifkan / Aktifkan --}}
                                        <form action="{{ route('admin.analisis.toggle-status', $item) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                title="{{ $item->status === 'AKTIF' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-colors text-white
                                            {{ $item->status === 'AKTIF' ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-gray-400 hover:bg-gray-500' }}">
                                                @if ($item->status === 'AKTIF')
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>

                                        {{-- Hapus --}}
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                        action: '{{ route('admin.analisis.destroy', $item) }}',
                                        nama: '{{ addslashes($item->nama) }}'
                                    })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                        {{-- Ekspor --}}
                                        <a href="{{ route('admin.analisis.export', $item) }}" title="Ekspor Analisis"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-600 hover:bg-slate-700 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                                <td class="px-4 py-4">
                                    <div class="font-medium text-sm text-gray-800 dark:text-slate-200">{{ $item->nama }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span
                                            class="text-xs font-mono bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 px-1.5 py-0.5 rounded">{{ $item->kode }}</span>
                                        @if ($item->periode)
                                            <span
                                                class="text-xs text-gray-400 dark:text-slate-500">{{ $item->periode }}</span>
                                        @endif
                                        @if ($item->lock)
                                            <span
                                                class="text-xs text-amber-600 dark:text-amber-400 flex items-center gap-0.5">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Dikunci
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                {{ match ($item->subjek) {
                                    'PENDUDUK' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'KELUARGA' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                    'RUMAH_TANGGA' => 'bg-orange-50 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                    'KELOMPOK' => 'bg-teal-50 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400',
                                    'DESA' => 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                    'DUSUN' => 'bg-lime-50 text-lime-700 dark:bg-lime-900/30 dark:text-lime-400',
                                    'RW' => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                    'RT' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400',
                                    default => 'bg-gray-50 text-gray-600 dark:bg-slate-700 dark:text-slate-400',
                                } }}">
                                        {{ $item->subjek_label }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-center">
                                    @if ($item->google_form_id)
                                        <span
                                            class="text-xs font-mono text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-700 px-2 py-0.5 rounded">
                                            {{ $item->google_form_id }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 text-sm">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-center">
                                    @if ($item->google_form_id)
                                        <form action="{{ route('admin.analisis.sinkronisasi', $item) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Sinkronisasi
                                            </button>
                                        </form>
                                        @if ($item->last_sync_at)
                                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">
                                                {{ $item->last_sync_at->diffForHumans() }}</p>
                                        @endif
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 text-sm">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                {{ $item->status === 'AKTIF'
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                    : 'bg-gray-100 text-gray-500 dark:bg-slate-700 dark:text-slate-400' }}">
                                        {{ $item->status === 'AKTIF' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang
                                            tersedia</p>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah analisis
                                            baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer: info + pagination --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($masters->total() > 0)
                        Menampilkan {{ $masters->firstItem() }}–{{ $masters->lastItem() }} dari {{ $masters->total() }}
                        entri
                        @if (request()->anyFilled(['search', 'subjek', 'status']))
                            (difilter)
                        @endif
                    @else
                        Menampilkan 0 entri
                    @endif
                </p>

                <div class="flex items-center gap-1">
                    @if ($masters->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $masters->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Sebelumnya</a>
                    @endif

                    @php
                        $currentPage = $masters->currentPage();
                        $lastPage = $masters->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $masters->appends(request()->query())->url(1) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                        @if ($start > 2)
                            <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $masters->appends(request()->query())->url($page) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                        @endif
                        <a href="{{ $masters->appends(request()->query())->url($lastPage) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lastPage }}</a>
                    @endif

                    @if ($masters->hasMorePages())
                        <a href="{{ $masters->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal Hapus (single & bulk) --}}
        @include('admin.partials.modal-hapus')

    </div>

    {{-- ══ MODAL: Impor Analisis ════════════════════════════════════════════ --}}
    <div id="modal-impor"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="font-bold text-gray-800 dark:text-slate-100">Impor Analisis</h3>
                <button onclick="document.getElementById('modal-impor').classList.add('hidden')"
                    class="p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.analisis.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-1.5">
                            File Master Analisis <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls" required
                            class="w-full text-sm text-gray-600 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 dark:border-slate-600 rounded-xl p-1">
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4 space-y-2 text-xs text-gray-500 dark:text-slate-400">
                        <p class="font-semibold text-gray-600 dark:text-slate-300">Aturan:</p>
                        <p>1. Data yang dibutuhkan untuk Impor harus memenuhi format yang ditentukan.</p>
                        <p>2. Format file Impor harus <strong>.xlsx</strong>, lakukan konversi jika belum sesuai.</p>
                        <p>3. Pastikan kolom sesuai dengan template yang tersedia.</p>
                    </div>
                </div>
                <div class="flex justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 gap-3">
                    <button type="button" onclick="document.getElementById('modal-impor').classList.add('hidden')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 text-white text-sm font-medium rounded-xl hover:bg-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Tutup
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 text-white text-sm font-semibold rounded-xl hover:bg-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('modal-impor').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>

@endsection
