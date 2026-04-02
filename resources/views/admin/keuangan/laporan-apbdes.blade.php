{{-- resources/views/admin/keuangan/laporan-apbdes.blade.php --}}
@extends('layouts.admin')

@section('title', 'Laporan APBDes')

@section('content')
    <div x-data="{
        selectedIds: [],
        selectAll: false,
        showTambah: false,
        showEdit: false,
        editId: null,
        editJudul: '',
        editTahun: '',
        editSemester: '1',
        fileNameTambah: '',
        fileNameEdit: '',
    
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
        openEdit(id, judul, tahun, semester) {
            this.editId = id;
            this.editJudul = judul;
            this.editTahun = tahun;
            this.editSemester = String(semester);
            this.fileNameEdit = '';
            this.showEdit = true;
        },
    }">

        {{-- ── PAGE HEADER ── --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Laporan APBDes</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola dokumen laporan Anggaran Pendapatan dan
                    Belanja Desa</p>
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
                <span class="text-gray-400 dark:text-slate-400">Keuangan</span>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Laporan APBDes</span>
            </nav>
        </div>

        {{-- ── FLASH MESSAGE ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                class="flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl mb-4">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="flex items-start gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl mb-4">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── CARD UTAMA ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

            {{-- Baris Tombol Aksi --}}
            <div class="flex items-center gap-2 px-5 pt-5 pb-4">

                {{-- Tambah --}}
                <button @click="showTambah = true"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>

                {{-- Hapus Bulk --}}
                <form method="POST" action="{{ route('admin.keuangan.laporan-apbdes.bulk-destroy') }}"
                    id="form-bulk-hapus">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && modalHapus.bukaJs(selectedIds.length + ' laporan yang dipilih', () => document.getElementById('form-bulk-hapus').submit())"
                        :class="selectedIds.length > 0 ?
                            'bg-red-500 hover:bg-red-600 cursor-pointer' :
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

                {{-- Kirim ke OpenDK — disabled, Api key belum ditentukan --}}
                <div class="relative group">
                    <button type="button" disabled
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-300 dark:bg-sky-900/50 text-white text-sm font-semibold rounded-lg cursor-not-allowed opacity-70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim Ke OpenDK
                    </button>
                    {{-- Tooltip --}}
                    <div class="absolute left-0 top-full mt-2 hidden group-hover:block z-50 pointer-events-none">
                        <div
                            class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                            Api key OpenDK belum ditentukan
                            <div
                                class="absolute bottom-full left-4 border-4 border-transparent border-b-gray-800 dark:border-b-slate-700">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Baris Filter Tahun --}}
            <div class="px-5 pb-4">
                <form method="GET" action="{{ route('admin.keuangan.laporan-apbdes') }}"
                    class="flex flex-wrap items-center gap-2">
                    <div class="relative w-40" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ $tahun }}',
                        label: '{{ $tahun ?: '' }}',
                        placeholder: 'Pilih Tahun',
                        options: [
                            { value: '', label: 'Pilih Tahun' },
                            @foreach ($tahunList as $t)
            { value: '{{ $t }}', label: '{{ $t }}' }, @endforeach
                        ],
                        get filtered() {
                            if (!this.search) return this.options;
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        choose(opt) {
                            this.selected = opt.value;
                            this.label = opt.value ? opt.label : '';
                            this.open = false;
                            this.search = '';
                            document.getElementById('filter-tahun-val').value = opt.value;
                            document.getElementById('form-filter-tahun').submit();
                        }
                    }" @click.away="open = false">
                        <input type="hidden" name="tahun" id="filter-tahun-val" value="{{ $tahun }}">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
               bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
               border-gray-300 dark:border-slate-600
               hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
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
                            class="absolute left-0 top-full mt-1 w-full z-50
               bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
               rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            {{-- Input pencarian --}}
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
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
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
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
                    <form id="form-filter-tahun" method="GET" action="{{ route('admin.keuangan.laporan-apbdes') }}"
                        class="hidden">
                        <input type="hidden" name="tahun" id="filter-tahun-val-hidden">
                    </form>
                </form>
            </div>

            {{-- Toolbar: Tampilkan X entri + Search --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-200 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.keuangan.laporan-apbdes') }}" id="form-per-page-apbdes"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @if ($tahun)
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                    @endif
                    <input type="hidden" name="per_page" id="val-per-page-apbdes"
                        value="{{ request('per_page', 10) }}">

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
                        get label() {
                            return this.options.find(o => o.value === this.selected)?.label ?? '10';
                        },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-per-page-apbdes').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page-apbdes').submit();
                        }
                    }" @click.away="open = false">

                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer
                   bg-white dark:bg-slate-700 border-gray-300 dark:border-slate-600
                   hover:border-emerald-400 transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute left-0 top-full mt-1 w-full z-[100]
                   bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                   rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <ul class="py-1">
                                <template x-for="opt in options" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                        :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <span>entri</span>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.keuangan.laporan-apbdes') }}"
                    class="flex items-center gap-2">
                    @if ($tahun)
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                    @endif
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50"
                            title="Masukkan kata kunci untuk mencari (maksimal 50 karakter)"
                            @input.debounce.400ms="$el.form.submit()"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                   focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
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
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-4 py-4 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                       text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">
                                NO</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-28">
                                AKSI</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                JUDUL</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-24">
                                SEMESTER</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-20">
                                TAHUN</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-44">
                                TANGGAL UPLOAD</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-44">
                                TANGGAL KIRIM</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($laporan as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- Checkbox --}}
                                <td class="px-4 py-4">
                                    <input type="checkbox" value="{{ $item->id }}"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                       text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- No --}}
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ ($laporan->currentPage() - 1) * $laporan->perPage() + $loop->iteration }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1">
                                        {{-- Edit --}}
                                        <button type="button"
                                            @click="openEdit({{ $item->id }}, '{{ addslashes($item->judul) }}', {{ $item->tahun }}, {{ $item->semester }})"
                                            title="Edit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Download --}}
                                        @if ($item->file)
                                            <a href="{{ asset('storage/' . $item->file) }}" download title="Download PDF"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        @else
                                            <span title="Tidak ada file"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-200 dark:bg-slate-600 text-gray-400 cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </span>
                                        @endif

                                        {{-- Hapus --}}
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                        action: '{{ url('admin/keuangan/laporan-apbdes') }}/{{ $item->id }}',
                                        nama: '{{ addslashes($item->judul) }}'
                                    })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                {{-- Judul --}}
                                <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-slate-200">
                                    {{ $item->judul }}
                                </td>

                                {{-- Semester --}}
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $item->semester == 1
                                    ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
                                    : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                        Sem {{ $item->semester }}
                                    </span>
                                </td>

                                {{-- Tahun --}}
                                <td class="px-4 py-4 text-center text-sm text-gray-600 dark:text-slate-400 font-medium">
                                    {{ $item->tahun }}
                                </td>

                                {{-- Tgl Upload --}}
                                <td
                                    class="px-4 py-4 text-center text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->tgl_upload ? $item->tgl_upload->format('d M Y H:i') : '-' }}
                                </td>

                                {{-- Tgl Kirim --}}
                                <td class="px-4 py-4 text-center text-xs whitespace-nowrap">
                                    @if ($item->tgl_kirim)
                                        <span
                                            class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $item->tgl_kirim->format('d M Y H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 italic">Belum dikirim</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data laporan
                                            APBDes</p>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah laporan
                                            baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── Footer: info entri + paginasi ── --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($laporan->total() > 0)
                        Menampilkan {{ $laporan->firstItem() }}–{{ $laporan->lastItem() }} dari {{ $laporan->total() }}
                        entri
                    @else
                        Menampilkan 0 entri
                    @endif
                </p>

                <div class="flex items-center gap-1">
                    @if ($laporan->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $laporan->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Sebelumnya
                        </a>
                    @endif

                    @php
                        $currentPage = $laporan->currentPage();
                        $lastPage = $laporan->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $laporan->appends(request()->query())->url(1) }}"
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
                            <a href="{{ $laporan->appends(request()->query())->url($page) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                        @endif
                        <a href="{{ $laporan->appends(request()->query())->url($lastPage) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lastPage }}</a>
                    @endif

                    @if ($laporan->hasMorePages())
                        <a href="{{ $laporan->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Selanjutnya
                        </a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">
                            Selanjutnya
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- MODAL TAMBAH                               --}}
        {{-- ══════════════════════════════════════════ --}}
        <div x-show="showTambah" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="showTambah = false" style="display:none">
            <div x-show="showTambah" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Tambah Laporan APBDes</h3>
                    <button @click="showTambah = false"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.keuangan.laporan-apbdes.store') }}"
                    enctype="multipart/form-data" class="px-6 py-5 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            placeholder="Masukkan judul laporan"
                            class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="2000"
                                max="2099"
                                class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                                Semester <span class="text-red-500">*</span>
                            </label>
                            <select name="semester"
                                class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="1" {{ old('semester', '1') == '1' ? 'selected' : '' }}>1</option>
                                <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>2</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            File <span class="text-gray-400 font-normal">(.pdf)</span> <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="file" accept=".pdf"
                                @change="fileNameTambah = $event.target.files[0]?.name || ''"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div
                                class="flex items-center border border-gray-200 dark:border-slate-600 rounded-lg overflow-hidden">
                                <span x-text="fileNameTambah || 'Pilih file PDF...'"
                                    :class="fileNameTambah ? 'text-gray-700 dark:text-slate-200' :
                                        'text-gray-400 dark:text-slate-500'"
                                    class="flex-1 px-3 py-2.5 text-sm truncate bg-white dark:bg-slate-700"></span>
                                <span
                                    class="shrink-0 px-3 py-2.5 bg-emerald-500 border-l border-emerald-500 text-sm text-white font-medium hover:bg-emerald-600 transition cursor-pointer">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-red-400">Ukuran maksimal <strong>32 MB</strong>. Format: PDF.</p>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showTambah = false"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600
           text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600
                               text-white text-sm font-semibold rounded-lg transition-colors">
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

        {{-- ══════════════════════════════════════════ --}}
        {{-- MODAL EDIT                                 --}}
        {{-- ══════════════════════════════════════════ --}}
        <div x-show="showEdit" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="showEdit = false"
            style="display:none">
            <div x-show="showEdit" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-100 dark:border-slate-700">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Ubah Laporan APBDes</h3>
                    <button @click="showEdit = false"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="'{{ url('admin/keuangan/laporan-apbdes') }}/' + editId" method="POST"
                    enctype="multipart/form-data" class="px-6 py-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" x-model="editJudul"
                            class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                                Tahun <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="tahun" x-model="editTahun" min="2000" max="2099"
                                class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                                Semester <span class="text-red-500">*</span>
                            </label>
                            <select name="semester" x-model="editSemester"
                                class="w-full border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2.5 text-sm
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            Ganti File <span class="text-gray-400 font-normal">(.pdf, opsional)</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="file" accept=".pdf"
                                @change="fileNameEdit = $event.target.files[0]?.name || ''"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div
                                class="flex items-center border border-gray-200 dark:border-slate-600 rounded-lg overflow-hidden">
                                <span x-text="fileNameEdit || 'Kosongkan jika tidak ingin mengubah'"
                                    :class="fileNameEdit ? 'text-gray-700 dark:text-slate-200' :
                                        'text-gray-400 dark:text-slate-500'"
                                    class="flex-1 px-3 py-2.5 text-sm truncate bg-white dark:bg-slate-700"></span>
                                <span
                                    class="shrink-0 px-3 py-2.5 bg-emerald-500 border-l border-emerald-500 text-sm text-white font-medium hover:bg-emerald-600 transition cursor-pointer">
                                    Browse
                                </span>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">
                            Kosongkan jika tidak ingin mengubah. Ukuran maksimal <strong class="text-red-400">32
                                MB</strong>.
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showEdit = false"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600
           text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600
                               text-white text-sm font-semibold rounded-lg transition-colors">
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

        {{-- Modal Hapus (shared partial) --}}
        @include('admin.partials.modal-hapus')

    </div>
@endsection
