@extends('layouts.admin')

@section('title', 'Data Rumah Tangga')

@section('content')

    <div x-data="{
        selectedIds: [],
        selectAll: false,
        showTambah: false,
        searchQuery: '',
        kepalaResults: [],
        selectedId: '',
        selectedNama: '',
        selectedAnggota: [],
        searchLoading: false,
        searchTimer: null,
    
        showEdit: false,
        editId: '',
        editNoRumahTangga: '',
        editBdt: '',
        editIsDtks: false,
        editAction: '',
    
        openEdit(id, noRt, bdt, isDtks, action) {
            this.editId = id;
            this.editNoRumahTangga = noRt;
            this.editBdt = bdt;
            this.editIsDtks = isDtks;
            this.editAction = action;
            this.showEdit = true;
        },
    
        showTambahAnggota: false,
        tambahAnggotaRtId: '',
        tambahAnggotaAction: '',
        tambahAnggotaQuery: '',
        tambahAnggotaResults: [],
        tambahAnggotaLoading: false,
        tambahAnggotaTimer: null,
        tambahAnggotaSelectedId: '',
        tambahAnggotaSelectedNama: '',
        tambahAnggotaSelectedKeluargaId: '',
    
        openTambahAnggota(rtId, action) {
            this.tambahAnggotaRtId = rtId;
            this.tambahAnggotaAction = action;
            this.tambahAnggotaQuery = '';
            this.tambahAnggotaResults = [];
            this.tambahAnggotaSelectedId = '';
            this.tambahAnggotaSelectedNama = '';
            this.showTambahAnggota = true;
        },
        searchAnggota() {
            clearTimeout(this.tambahAnggotaTimer);
            const q = (this.tambahAnggotaQuery || '').trim();
            this.tambahAnggotaLoading = true;
            this.tambahAnggotaTimer = setTimeout(async () => {
                const res = await fetch('{{ url('admin/rumah-tangga/cari-penduduk') }}?q=' + encodeURIComponent(q));
                this.tambahAnggotaResults = await res.json();
                this.tambahAnggotaLoading = false;
            }, q ? 300 : 0);
        },
        pilihAnggota(item) {
            this.tambahAnggotaSelectedId = item.id;
            this.tambahAnggotaSelectedKeluargaId = item.keluarga_id; // <-- tambah ini
            this.tambahAnggotaSelectedNama = item.nama;
            this.tambahAnggotaQuery = item.nama + ' (' + item.nik + ')';
            this.tambahAnggotaResults = [];
        },
        clearAnggota() {
            this.tambahAnggotaSelectedId = '';
            this.tambahAnggotaSelectedKeluargaId = ''; // <-- tambah ini
            this.tambahAnggotaSelectedNama = '';
            this.tambahAnggotaQuery = '';
            this.tambahAnggotaResults = [];
        },
    
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
    
        searchKepala() {
            clearTimeout(this.searchTimer);
            const q = (this.searchQuery || '').trim();
            this.searchLoading = true;
            this.searchTimer = setTimeout(async () => {
                const res = await fetch('{{ url('admin/rumah-tangga/cari-penduduk') }}?q=' + encodeURIComponent(q));
                this.kepalaResults = await res.json();
                this.searchLoading = false;
            }, q ? 300 : 0);
        },
        pilihKepala(item) {
            this.selectedId = item.id;
            this.selectedNama = item.text;
            this.selectedAnggota = Array.isArray(item.anggota) ? item.anggota : [];
            this.searchQuery = '';
            this.kepalaResults = [];
        },
        resetModal() {
            this.searchQuery = '';
            this.kepalaResults = [];
            this.selectedId = '';
            this.selectedNama = '';
            this.selectedAnggota = [];
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

        {{-- CARD UTAMA --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow: visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah --}}
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

                {{-- Impor --}}
                <button type="button" @click="$dispatch('buka-modal-impor')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors">
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
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
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

            {{-- ── FILTER ── --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <form method="GET" action="{{ route('admin.rumah-tangga.index') }}" id="form-filter"
                    class="flex flex-wrap items-center gap-2">

                    <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">
                    <input type="hidden" name="dusun" id="val-dusun" value="{{ request('dusun') }}">
                    <input type="hidden" name="jenis_kelamin" id="val-jenis_kelamin"
                        value="{{ request('jenis_kelamin') }}">

                    {{-- Status --}}
                    <div class="relative w-52" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('status') }}',
                        placeholder: 'Pilih Status',
                        options: [
                            { value: 'aktif', label: 'Aktif' },
                            { value: 'tidak_aktif', label: 'Tidak Aktif' },
                            { value: 'tanpa_kepala', label: 'Tanpa Kepala Keluarga' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-status').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-status').value = '';
                            this.open = false;
                            this.search = '';
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

                    {{-- Jenis Kelamin --}}
                    <div class="relative w-44" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('jenis_kelamin') }}',
                        placeholder: 'Pilih Jenis Kelamin',
                        options: [
                            { value: 'L', label: 'Laki-laki' },
                            { value: 'P', label: 'Perempuan' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-jenis_kelamin').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-jenis_kelamin').value = '';
                            this.open = false;
                            this.search = '';
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
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari jenis kelamin..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua
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

                    {{-- Dusun --}}
                    <div class="relative w-44" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('dusun') }}',
                        placeholder: 'Pilih Dusun',
                        options: [
                            @foreach ($dusunList as $dusun)
                                { value: '{{ addslashes($dusun) }}', label: '{{ addslashes($dusun) }}' }, @endforeach
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-dusun').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-dusun').value = '';
                            this.open = false;
                            this.search = '';
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
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari dusun..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua Dusun
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

                </form>
            </div>

            {{-- ── TOOLBAR: Tampilkan X entri + Search ── --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.rumah-tangga.index') }}" id="form-per-page"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page-rt" value="{{ request('per_page', 10) }}">

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
                <form method="GET" action="{{ route('admin.rumah-tangga.index') }}" class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50" @input.debounce.400ms="$el.form.submit()"
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
                            <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider"
                                style="min-width:200px">
                                AKSI
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">
                                FOTO
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NOMOR RUMAH TANGGA
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                KEPALA RUMAH TANGGA
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                DTKS
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JUMLAH KK
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JUMLAH ANGGOTA
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                ALAMAT
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                DUSUN
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                RW
                            </th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                RT
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                TANGGAL TERDAFTAR
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($rumahTangga as $index => $rt)
                            @php $kepala = $rt->getKepalaRumahTangga(); @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $rt->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- CHECKBOX --}}
                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $rt->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- NO --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-sm">
                                    {{ $rumahTangga->firstItem() + $index }}
                                </td>

                                {{-- AKSI — 5 tombol --}}
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1 flex-nowrap">

                                        {{-- 1. Rincian Anggota (indigo) --}}
                                        <a href="{{ route('admin.rumah-tangga.show', $rt) }}"
                                            title="Rincian Anggota Rumah Tangga"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h10" />
                                            </svg>
                                        </a>

                                        {{-- 2. Tambah Anggota (emerald) --}}
                                        <button type="button" title="Tambah Anggota Rumah Tangga"
                                            @click="openTambahAnggota(
        '{{ $rt->id }}',
        '{{ route('admin.rumah-tangga.tambah-kk', $rt) }}'
    )"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </button>

                                        {{-- 3. Edit (amber) --}}
                                        <button type="button" title="Ubah Data Rumah Tangga"
                                            @click="openEdit(
        '{{ $rt->id }}',
        '{{ addslashes($rt->no_rumah_tangga) }}',
        '{{ addslashes($rt->bdt ?? '') }}',
        {{ $rt->is_dtks ? 'true' : 'false' }},
        '{{ route('admin.rumah-tangga.update', $rt) }}'
    )"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- 4. Lokasi (teal) --}}
                                        @if ($kepala)
                                            <a href="{{ route('admin.penduduk.lokasi', $kepala) }}"
                                                title="Lokasi Tempat Tinggal"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-teal-500 hover:bg-teal-600 text-white transition-colors">
                                            @else
                                                <span title="Tidak ada kepala rumah tangga"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-teal-200 dark:bg-teal-900/30 cursor-not-allowed opacity-50">
                                        @endif
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        @if ($kepala)
                                            </a>
                                        @else
                                            </span>
                                        @endif

                                        {{-- 5. Hapus (red) --}}
                                        <button type="button" title="Hapus Data Rumah Tangga"
                                            @click="$dispatch('buka-modal-hapus', {
                                                action: '{{ route('admin.rumah-tangga.destroy', $rt) }}',
                                                nama: 'Rumah Tangga {{ addslashes($rt->no_rumah_tangga) }}'
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

                                {{-- FOTO --}}
                                <td class="px-3 py-3">
                                    @php $foto = $kepala?->foto ?? null; @endphp
                                    @if ($foto)
                                        <img src="{{ asset('storage/foto/' . $foto) }}" alt="{{ $kepala->nama ?? '' }}"
                                            class="w-9 h-9 rounded-full object-cover border-2 border-gray-200 dark:border-slate-600"
                                            onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 200 200%27%3E%3Crect width=%27200%27 height=%27200%27 fill=%27%23f1f5f9%27/%3E%3Ccircle cx=%27100%27 cy=%2778%27 r=%2740%27 fill=%27%23cbd5e1%27/%3E%3Cellipse cx=%27100%27 cy=%27178%27 rx=%2764%27 ry=%2750%27 fill=%27%23cbd5e1%27/%3E%3C/svg%3E'">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-100 dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                {{-- NOMOR RUMAH TANGGA --}}
                                <td
                                    class="px-3 py-3 font-mono font-semibold text-emerald-600 dark:text-emerald-400 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.rumah-tangga.show', $rt) }}" class="hover:underline">
                                        {{ $rt->no_rumah_tangga }}
                                    </a>
                                </td>

                                {{-- KEPALA RT --}}
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

                                {{-- JUMLAH KK --}}
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full text-sm font-semibold text-blue-700 dark:text-blue-300">
                                        {{ $rt->getTotalKk() }}
                                    </span>
                                </td>

                                {{-- JUMLAH ANGGOTA --}}
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-full text-sm font-semibold text-gray-700 dark:text-slate-300">
                                        {{ $rt->getTotalAnggota() }}
                                    </span>
                                </td>

                                {{-- ALAMAT --}}
                                <td
                                    class="px-3 py-3 text-sm text-gray-600 dark:text-slate-300 hidden lg:table-cell max-w-xs truncate">
                                    {{ $rt->alamat ?? '—' }}
                                </td>

                                {{-- DUSUN --}}
                                <td
                                    class="px-3 py-3 text-sm text-gray-600 dark:text-slate-300 hidden lg:table-cell whitespace-nowrap">
                                    {{ $rt->wilayah?->dusun ?? '—' }}
                                </td>

                                {{-- RW --}}
                                <td
                                    class="px-3 py-3 text-sm text-center text-gray-600 dark:text-slate-300 hidden lg:table-cell">
                                    {{ $rt->wilayah?->rw ?? '—' }}
                                </td>

                                {{-- RT --}}
                                <td
                                    class="px-3 py-3 text-sm text-center text-gray-600 dark:text-slate-300 hidden lg:table-cell">
                                    {{ $rt->wilayah?->rt ?? '—' }}
                                </td>

                                {{-- TANGGAL TERDAFTAR --}}
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
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">
                                            Tidak ada data yang tersedia pada tabel ini
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

        {{-- ── MODAL TAMBAH RUMAH TANGGA ── --}}
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
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Tambah Rumah Tangga</h3>
                    <button @click="showTambah = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form action="{{ route('admin.rumah-tangga.store') }}" method="POST" class="p-6 space-y-5"
                    x-data="{ kepalaError: false }"
                    @submit.prevent="
                        if (!selectedId) {
                            kepalaError = true;
                            $refs.kepalaWrapper?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            return;
                        }
                        kepalaError = false;
                        $el.submit();
                    ">
                    @csrf

                    {{-- Nomor Rumah Tangga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Nomor Rumah Tangga
                        </label>
                        <input type="text" name="no_rumah_tangga" placeholder="Nomor Rumah Tangga"
                            value="{{ old('no_rumah_tangga') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">
                            Kosongkan untuk melanjutkan nomor terakhir secara otomatis
                        </p>
                    </div>

                    {{-- Kepala Rumah Tangga --}}
                    <div x-ref="kepalaWrapper">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Kepala Rumah Tangga <span class="text-red-500">*</span>
                        </label>

                        <div class="relative" x-data="{ openDrop: false }" @click.away="openDrop = false">
                            <div @click="
                                    openDrop = !openDrop;
                                    if (openDrop) {
                                        $nextTick(() => $refs.kepalaSearchInput?.focus());
                                        if (kepalaResults.length === 0) searchKepala();
                                    }
                                "
                                class="flex items-center justify-between w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 cursor-pointer transition-colors"
                                :class="kepalaError
                                    ?
                                    'border-red-400 ring-2 ring-red-400/20' :
                                    openDrop ?
                                    'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                                <span x-text="selectedNama || '-- Silakan Cari NIK / Nama Kepala Keluarga --'"
                                    :class="selectedNama ? 'text-gray-800 dark:text-slate-200' :
                                        'text-gray-400 dark:text-slate-500'">
                                </span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                    :class="openDrop ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>

                            <input type="hidden" name="kepala_penduduk_id" :value="selectedId">

                            <div x-show="searchLoading" class="absolute right-9 top-2.5 pointer-events-none">
                                <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                            </div>

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

                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-if="searchLoading && kepalaResults.length === 0">
                                        <li class="px-3 py-3 text-sm text-gray-400 dark:text-slate-500 text-center">
                                            <svg class="w-4 h-4 animate-spin inline mr-1 text-emerald-500" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4" />
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                            </svg>
                                            Memuat data...
                                        </li>
                                    </template>
                                    <template x-for="item in kepalaResults" :key="item.id">
                                        <li @click="pilihKepala(item); openDrop = false; kepalaError = false;"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="selectedId === item.id ? 'bg-emerald-500 text-white' :
                                                'text-gray-700 dark:text-slate-200'">
                                            <span class="font-medium" x-text="item.nama"></span>
                                            <span class="text-xs font-mono ml-1 opacity-75"
                                                x-text="'(' + item.nik + ')'"></span>
                                        </li>
                                    </template>
                                    <template x-if="!searchLoading && kepalaResults.length === 0">
                                        <li class="px-3 py-3 text-sm text-gray-400 dark:text-slate-500 text-center italic">
                                            Data tidak ditemukan
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <p x-show="kepalaError" x-transition class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kepala Rumah Tangga wajib dipilih
                        </p>

                        <div
                            class="mt-2 px-3 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg text-xs text-gray-500 dark:text-slate-400">
                            Pilih dari data penduduk yang sudah terinput. Alamat dan wilayah akan otomatis mengikuti
                            data KK dari penduduk yang dipilih.
                        </div>
                    </div>

                    {{-- Preview Anggota --}}
                    <div x-show="selectedId" x-transition>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Anggota Rumah Tangga
                        </label>
                        <div class="border border-gray-200 dark:border-slate-600 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-xs">
                                    <thead class="bg-gray-50 dark:bg-slate-700/60">
                                        <tr>
                                            <th
                                                class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-slate-300 uppercase">
                                                No</th>
                                            <th
                                                class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-slate-300 uppercase">
                                                NIK</th>
                                            <th
                                                class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-slate-300 uppercase">
                                                Nama</th>
                                            <th
                                                class="px-3 py-2 text-left font-semibold text-gray-500 dark:text-slate-300 uppercase">
                                                Hubungan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                        <template x-if="selectedAnggota.length === 0">
                                            <tr>
                                                <td colspan="4"
                                                    class="px-3 py-3 text-center text-gray-400 dark:text-slate-500 italic">
                                                    Belum ada anggota keluarga yang bisa ditampilkan.
                                                </td>
                                            </tr>
                                        </template>
                                        <template x-for="(anggota, idx) in selectedAnggota" :key="anggota.id">
                                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30">
                                                <td class="px-3 py-2 text-gray-500 dark:text-slate-400" x-text="idx + 1">
                                                </td>
                                                <td class="px-3 py-2 font-mono text-gray-600 dark:text-slate-300"
                                                    x-text="anggota.nik"></td>
                                                <td class="px-3 py-2 text-gray-800 dark:text-slate-200"
                                                    x-text="anggota.nama"></td>
                                                <td class="px-3 py-2 text-gray-600 dark:text-slate-300"
                                                    x-text="anggota.hubungan"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">
                            Daftar anggota mengikuti data KK dari penduduk yang dipilih.
                        </p>
                    </div>

                    {{-- BDT --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            BDT
                            <span class="text-xs font-normal text-gray-400 dark:text-slate-500">(Basis Data Terpadu)</span>
                        </label>
                        <input type="text" name="bdt" placeholder="Nomor BDT jika ada"
                            value="{{ old('bdt') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                    </div>

                    {{-- DTKS --}}
                    <div class="flex items-start gap-2.5">
                        <input type="checkbox" name="is_dtks" value="1" id="is_dtks"
                            {{ old('is_dtks') ? 'checked' : '' }}
                            class="w-4 h-4 mt-0.5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                        <label for="is_dtks"
                            class="text-sm text-gray-700 dark:text-slate-300 cursor-pointer select-none leading-snug">
                            Terdaftar di DTKS
                            <span class="block text-xs text-gray-400 dark:text-slate-500 font-normal mt-0.5">
                                Data Terpadu Kesejahteraan Sosial — penerima bansos (PKH, BPNT, dll)
                            </span>
                        </label>
                    </div>

                    {{-- Footer --}}
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

        {{-- ── MODAL EDIT RUMAH TANGGA ── --}}
        <div x-show="showEdit" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showEdit = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Ubah Rumah Tangga</h3>
                    <button @click="showEdit = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form method="POST" :action="editAction" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nomor Rumah Tangga --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Nomor Rumah Tangga
                        </label>
                        <input type="text" name="no_rumah_tangga" x-model="editNoRumahTangga"
                            placeholder="Nomor Rumah Tangga"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">
                            Kosongkan untuk melanjutkan nomor terakhir secara otomatis
                        </p>
                    </div>

                    {{-- BDT --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            BDT
                            <span class="text-xs font-normal text-gray-400 dark:text-slate-500">(Basis Data Terpadu)</span>
                        </label>
                        <input type="text" name="bdt" x-model="editBdt" placeholder="Nomor BDT jika ada"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                    </div>

                    {{-- DTKS --}}
                    <div class="flex items-start gap-2.5">
                        <input type="checkbox" name="is_dtks" value="1" id="edit_is_dtks" x-model="editIsDtks"
                            class="w-4 h-4 mt-0.5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                        <label for="edit_is_dtks"
                            class="text-sm text-gray-700 dark:text-slate-300 cursor-pointer select-none leading-snug">
                            Terdaftar di DTKS
                            <span class="block text-xs text-gray-400 dark:text-slate-500 font-normal mt-0.5">
                                Data Terpadu Kesejahteraan Sosial — penerima bansos (PKH, BPNT, dll)
                            </span>
                        </label>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showEdit = false"
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

        {{-- ── MODAL TAMBAH ANGGOTA RUMAH TANGGA ── --}}
        <div x-show="showTambahAnggota" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showTambahAnggota = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Tambah Anggota Rumah Tangga</h3>
                    <button @click="showTambahAnggota = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form method="POST" :action="tambahAnggotaAction" class="p-6 space-y-5" x-data="{ anggotaError: false }"
                    @submit.prevent="
                if (!tambahAnggotaSelectedId || !tambahAnggotaSelectedKeluargaId) {
    anggotaError = true;
    return;
}
                anggotaError = false;
                $el.submit();
            ">
                    @csrf

                    <input type="hidden" name="keluarga_id" :value="tambahAnggotaSelectedKeluargaId">

                    {{-- NIK / Nama Penduduk --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            NIK / Nama Penduduk <span class="text-red-500">*</span>
                        </label>

                        <div class="relative" x-data="{ openDropAnggota: false }" @click.away="openDropAnggota = false">
                            {{-- Input dengan tombol clear dan chevron --}}
                            <div class="flex items-center w-full border rounded-lg bg-white dark:bg-slate-700 transition-colors overflow-hidden"
                                :class="anggotaError
                                    ?
                                    'border-red-400 ring-2 ring-red-400/20' :
                                    openDropAnggota ?
                                    'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                                <input type="text" x-model="tambahAnggotaQuery"
                                    @focus="openDropAnggota = true; if (tambahAnggotaResults.length === 0) searchAnggota();"
                                    @input="openDropAnggota = true; searchAnggota(); anggotaError = false;"
                                    @keydown.escape="openDropAnggota = false"
                                    placeholder="-- Silakan Cari NIK / Nama Penduduk --" autocomplete="off"
                                    class="flex-1 px-3 py-2 text-sm bg-transparent text-gray-800 dark:text-slate-200 placeholder-gray-400 dark:placeholder-slate-500 outline-none">

                                {{-- Clear button (X) --}}
                                <button type="button" x-show="tambahAnggotaQuery" @click="clearAnggota()"
                                    class="px-2 text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                {{-- Loading spinner --}}
                                <div x-show="tambahAnggotaLoading" class="px-2">
                                    <svg class="w-4 h-4 animate-spin text-emerald-500" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4" />
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                    </svg>
                                </div>

                                {{-- Chevron --}}
                                <button type="button" @click="openDropAnggota = !openDropAnggota"
                                    class="px-2 text-gray-400 hover:text-gray-600 dark:hover:text-slate-200 transition-colors">
                                    <svg class="w-4 h-4 transition-transform" :class="openDropAnggota ? 'rotate-180' : ''"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Dropdown hasil pencarian --}}
                            <div x-show="openDropAnggota && (tambahAnggotaResults.length > 0 || tambahAnggotaLoading)"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-if="tambahAnggotaLoading && tambahAnggotaResults.length === 0">
                                        <li class="px-3 py-3 text-sm text-gray-400 dark:text-slate-500 text-center">
                                            <svg class="w-4 h-4 animate-spin inline mr-1 text-emerald-500" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4" />
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                            </svg>
                                            Memuat data...
                                        </li>
                                    </template>
                                    <template x-for="item in tambahAnggotaResults" :key="item.id">
                                        <li @click="pilihAnggota(item); openDropAnggota = false; anggotaError = false;"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="tambahAnggotaSelectedId === item.id ?
                                                'bg-emerald-500 text-white' :
                                                'text-gray-700 dark:text-slate-200'">
                                            <span class="font-medium" x-text="item.nama"></span>
                                            <span class="text-xs font-mono ml-1 opacity-75"
                                                x-text="'(' + item.nik + ')'"></span>
                                        </li>
                                    </template>
                                    <template
                                        x-if="!tambahAnggotaLoading && tambahAnggotaResults.length === 0 && tambahAnggotaQuery.length > 0">
                                        <li class="px-3 py-3 text-sm text-gray-400 dark:text-slate-500 text-center italic">
                                            Data tidak ditemukan
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <p x-show="anggotaError" x-transition class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            NIK / Nama Penduduk wajib dipilih
                        </p>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showTambahAnggota = false"
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
