@extends('layouts.admin')

@section('title', 'Daftar Program Bantuan')

@section('content')

    <div x-data="{ modalImpor: false }">

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Daftar Program Bantuan</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola program bantuan untuk masyarakat desa</p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Daftar Program Bantuan</span>
            </nav>
        </div>

        {{-- CARD TUNGGAL: Tombol Aksi + Filter + Tabel --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

            {{-- Baris Tombol Tambah, Impor, Bersihkan --}}
            <div class="flex items-center gap-2 px-5 pt-5 pb-4 flex-wrap">

                {{-- Tombol Tambah --}}
                <a href="{{ route('admin.bantuan.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-600 dark:hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </a>

                {{-- Tombol Impor (hitam) --}}
                <button type="button" @click="modalImpor = true"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 dark:bg-slate-900 dark:hover:bg-slate-700 text-white text-sm font-semibold rounded-lg transition-colors border border-gray-700 dark:border-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Impor
                </button>

                {{-- Tombol Bersihkan Peserta Tidak Valid (merah) --}}
                <a href="{{ route('admin.bantuan.bersihkan') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    {{-- Icon user dengan tanda silang --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                    </svg>
                    Bersihkan Peserta Tidak Valid
                </a>
            </div>

            {{-- Baris Filter --}}
            <div class="px-5 pb-4">
                <form method="GET" action="{{ route('admin.bantuan.index') }}" id="form-filter"
                    class="flex flex-wrap items-center gap-2">

                    {{-- Hidden inputs untuk nilai terpilih --}}
                    <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">
                    <input type="hidden" name="sasaran" id="val-sasaran" value="{{ request('sasaran') }}">

                    {{-- ── Custom Dropdown: Pilih Status ── --}}
                    <div class="relative w-48" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('status') }}',
                        label: '{{ request('status') === '1' ? 'Aktif' : (request('status') === '0' ? 'Tidak Aktif' : '') }}',
                        placeholder: 'Pilih Status',
                        options: [
                            { value: '', label: 'Semua Status' },
                            { value: '1', label: 'Aktif' },
                            { value: '0', label: 'Tidak Aktif' },
                        ],
                        get filtered() {
                            if (!this.search) return this.options;
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        choose(opt) {
                            this.selected = opt.value;
                            this.label = opt.value ? opt.label : '';
                            document.getElementById('val-status').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false" placeholder="Cari..."
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

                    {{-- ── Custom Dropdown: Pilih Sasaran ── --}}
                    <div class="relative w-48" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('sasaran') }}',
                        label: '{{ request('sasaran') === '1' ? 'Penduduk' : (request('sasaran') === '2' ? 'Keluarga' : (request('sasaran') === '3' ? 'Rumah Tangga' : (request('sasaran') === '4' ? 'Kelompok/Organisasi Kemasyarakatan' : ''))) }}',
                        placeholder: 'Pilih Sasaran',
                        options: [
                            { value: '', label: 'Semua Sasaran' },
                            { value: '1', label: 'Penduduk' },
                            { value: '2', label: 'Keluarga' },
                            { value: '3', label: 'Rumah Tangga' },
                            { value: '4', label: 'Kelompok/Organisasi Kemasyarakatan' },
                        ],
                        get filtered() {
                            if (!this.search) return this.options;
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        choose(opt) {
                            this.selected = opt.value;
                            this.label = opt.value ? opt.label : '';
                            document.getElementById('val-sasaran').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">

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
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari sasaran..."
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
                </form>
            </div>

            {{-- Toolbar atas tabel: Tampilkan X entri + Search --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-200 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.bantuan.index') }}"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <span>Tampilkan</span>
                    <select name="per_page" onchange="this.form.submit()"
                        class="px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg
                       bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                       focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                        @foreach ([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                {{ $n }}</option>
                        @endforeach
                    </select>
                    <span>entri</span>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.bantuan.index') }}" class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50"
                            title="Masukkan kata kunci untuk mencari (maksimal 50 karakter)"
                            @input.debounce.400ms="$el.form.submit()"
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

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">
                                NO</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-32">
                                AKSI</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                NAMA PROGRAM</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                ASAL DANA</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                JUMLAH PESERTA</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                MASA BERLAKU</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                SASARAN</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                STATUS</th>
                            <th
                                class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">
                                PUBLIKASI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">

                        @forelse($bantuan as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">
                                    {{ $bantuan->firstItem() + $loop->index }}
                                </td>

                                {{-- AKSI: Rincian, Edit, Hapus --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1">
                                        {{-- Rincian Data --}}
                                        <a href="{{ route('admin.bantuan.show', $item) }}" title="Rincian Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h10" />
                                            </svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.bantuan.edit', $item) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-700 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        {{-- Hapus --}}
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                        action: '{{ route('admin.bantuan.destroy', $item) }}',
                                        nama: '{{ addslashes($item->nama) }}'
                                    })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-slate-200 max-w-xs">
                                    <span class="line-clamp-2" title="{{ $item->nama }}">
                                        {{ $item->nama }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-slate-300">
                                    {{ $item->asal_dana ?? '-' }}
                                </td>

                                {{-- JUMLAH PESERTA: Link ke show dengan badge --}}
                                <td class="px-4 py-4">
                                    <a href="{{ route('admin.bantuan.show', $item) }}"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full
                                       bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                       hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                        {{ $item->peserta_count ?? 0 }}
                                    </a>
                                </td>

                                {{-- MASA BERLAKU: Format seperti OpenSID (d M Y, satu baris) --}}
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    @php
                                        $mulai = $item->tanggal_mulai
                                            ? \Carbon\Carbon::parse($item->tanggal_mulai)
                                            : null;
                                        $selesai = $item->tanggal_selesai
                                            ? \Carbon\Carbon::parse($item->tanggal_selesai)
                                            : null;
                                        $isExpired = $selesai && $selesai->isPast();
                                    @endphp
                                    @if ($selesai)
                                        <span class="text-gray-600 dark:text-slate-400">
                                            {{ $selesai->translatedFormat('d M Y') }}
                                        </span>
                                    @elseif ($mulai)
                                        <span class="text-gray-600 dark:text-slate-400">
                                            {{ $mulai->translatedFormat('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500">-</span>
                                    @endif
                                </td>

                                {{-- SASARAN: Badge (violet=Penduduk, orange=Keluarga) --}}
                                <td class="px-4 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full
    {{ $item->sasaran == 1
        ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400'
        : ($item->sasaran == 2
            ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400'
            : ($item->sasaran == 3
                ? 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400'
                : ($item->sasaran == 4
                    ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400'
                    : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-400'))) }}">
                                        {{ $item->sasaran == 1 ? 'Penduduk' : ($item->sasaran == 2 ? 'Keluarga' : ($item->sasaran == 3 ? 'Rumah Tangga' : ($item->sasaran == 4 ? 'Kelompok/Org. Kemasyarakatan' : '-'))) }}
                                    </span>
                                </td>

                                {{-- STATUS: Badge (hijau=Aktif, abu=Tidak Aktif) --}}
                                <td class="px-4 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ in_array($item->status, ['aktif', 'ya', '1', 1])
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                    : 'bg-gray-100 text-gray-500 dark:bg-slate-700 dark:text-slate-400' }}">
                                        {{ in_array($item->status, ['aktif', 'ya', '1', 1]) ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>

                                {{-- PUBLIKASI: Badge (hijau=Aktif, abu=Tidak Aktif) --}}
                                <td class="px-4 py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ in_array($item->publikasi, ['1', 1])
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                    : 'bg-gray-100 text-gray-500 dark:bg-slate-700 dark:text-slate-400' }}">
                                        {{ in_array($item->publikasi, ['1', 1]) ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang
                                            tersedia</p>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah program
                                            bantuan baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer: info entri + pagination --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($bantuan->total() > 0)
                        Menampilkan {{ $bantuan->firstItem() }}–{{ $bantuan->lastItem() }} dari {{ $bantuan->total() }}
                        entri
                        @if (request('search'))
                            (difilter dari total entri)
                        @endif
                    @else
                        Menampilkan 0 entri
                    @endif
                </p>

                <div class="flex items-center gap-1">
                    @if ($bantuan->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $bantuan->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Sebelumnya
                        </a>
                    @endif

                    @php
                        $currentPage = $bantuan->currentPage();
                        $lastPage = $bantuan->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $bantuan->appends(request()->query())->url(1) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">1</a>
                        @if ($start > 2)
                            <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $bantuan->appends(request()->query())->url($page) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-2 py-1.5 text-sm text-gray-400 dark:text-slate-500">…</span>
                        @endif
                        <a href="{{ $bantuan->appends(request()->query())->url($lastPage) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">{{ $lastPage }}</a>
                    @endif

                    @if ($bantuan->hasMorePages())
                        <a href="{{ $bantuan->appends(request()->query())->nextPageUrl() }}"
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

        {{-- ═══════════════════════════════════════════════════════
             MODAL IMPOR PROGRAM BANTUAN
        ════════════════════════════════════════════════════════ --}}
        <div x-show="modalImpor" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display:none">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 dark:bg-black/70 backdrop-blur-sm" @click="modalImpor = false"></div>

            {{-- Panel Modal --}}
            <div x-show="modalImpor" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                class="relative w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 overflow-hidden">

                {{-- Header Modal --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Impor Program Bantuan</h3>
                    <button type="button" @click="modalImpor = false"
                        class="flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body Modal --}}
                <form action="{{ route('admin.bantuan.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto">

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-200 mb-2">
                                File Program Bantuan
                            </label>
                            <div x-data="{ fileName: '' }" class="flex gap-2">
                                <div class="flex-1 relative">
                                    <input type="text" readonly :value="fileName || ''"
                                        placeholder="Pilih file Excel..."
                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg
                                               bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                               placeholder-gray-400 dark:placeholder-slate-500 cursor-default outline-none">
                                    <input type="file" name="file_impor" accept=".xls,.xlsx,.xlsm"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full"
                                        @change="fileName = $event.target.files[0]?.name || ''">
                                </div>
                                <button type="button"
                                    class="relative inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors overflow-hidden">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Browse
                                    <input type="file" name="file_impor_trigger" accept=".xls,.xlsx,.xlsm"
                                        class="absolute inset-0 opacity-0 cursor-pointer w-full">
                                </button>
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">
                                Format file yang didukung: .xls, .xlsx, .xlsm
                            </p>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                        {{-- Impor Program --}}
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3">Impor Program:</p>
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="ganti_program" value="1"
                                    class="mt-0.5 w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                           text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                                <div>
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        Ganti data lama jika data ditemukan sama
                                    </span>
                                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5 leading-relaxed">
                                        Centang jika ingin memperbarui data program bantuan lama yang memiliki nama/program
                                        sama
                                        dengan data yang diimpor. Jika tidak dicentang, data lama tidak diubah dan data baru
                                        dengan nama/program sama diabaikan.
                                    </p>
                                </div>
                            </label>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                        {{-- Opsi Impor Peserta --}}
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3">Opsi Impor Peserta:</p>
                            <div class="space-y-4">

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="kosongkan_peserta" value="1"
                                        class="mt-0.5 w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                               text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                                    <div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            Kosongkan data peserta sebelum impor
                                        </span>
                                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5 leading-relaxed">
                                            Centang jika ingin menghapus semua data peserta lama sebelum data baru diimpor
                                        </p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="ganti_nik_sama" value="1"
                                        class="mt-0.5 w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                               text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                                    <div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            Ganti data peserta lama jika NIK sama
                                        </span>
                                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5 leading-relaxed">
                                            Centang jika ingin memperbarui data peserta lama yang memiliki NIK sama
                                        </p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" name="acak_nomor_kartu" value="1"
                                        class="mt-0.5 w-4 h-4 rounded border-gray-300 dark:border-slate-600
                                               text-emerald-600 focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                                    <div>
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            Acak nomor kartu peserta jika kosong
                                        </span>
                                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5 leading-relaxed">
                                            Centang jika ingin sistem mengisi otomatis nomor kartu peserta secara acak
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Contoh Format --}}
                        <div class="flex justify-center pt-1">
                            <a href="{{ route('admin.bantuan.contoh-format') }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Contoh Format Impor Program Bantuan
                            </a>
                        </div>

                    </div>

                    {{-- Footer Modal --}}
                    <div
                        class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/80">
                        <button type="button" @click="modalImpor = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
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

        {{-- Modal Hapus (single) --}}
        @include('admin.partials.modal-hapus')

    </div>
@endsection
