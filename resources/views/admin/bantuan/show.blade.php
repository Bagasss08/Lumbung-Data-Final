@extends('layouts.admin')

@section('title', 'Detail Program Bantuan')

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
        },
    
        {{-- TAMBAHKAN INI --}}
        editOpen: false,
        editLoading: false,
        editData: {},
        async openEdit(pesertaId) {
            this.editOpen = true;
            this.editLoading = true;
            const res = await fetch(`{{ url('admin/bantuan/' . $bantuan->id . '/peserta') }}/${pesertaId}/json`);
            this.editData = await res.json();
            this.editLoading = false;
        },
    }">


        {{-- ══════════════════════════════════════════
             Page Header  ←  DIPERBAIKI
             ══════════════════════════════════════════ --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                    Program Bantuan {{ $bantuan->nama }}
                </h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                    Detail dan daftar peserta program bantuan
                </p>
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
                <a href="{{ route('admin.bantuan.index') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Daftar Program Bantuan
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium truncate max-w-[180px]">
                    Program Bantuan {{ $bantuan->nama }}
                </span>
            </nav>
        </div>

        {{-- ── MAIN CARD ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah --}}
                <a href="{{ route('admin.bantuan.peserta.create', $bantuan) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </a>

                {{-- Hapus Bulk --}}
                <form method="POST" action="{{ route('admin.bantuan.peserta.bulk-destroy', $bantuan->id) }}"
                    id="form-bulk-hapus-bantuan">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                            bulkCount: selectedIds.length,
                            onConfirm: () => document.getElementById('form-bulk-hapus-bantuan').submit()
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

                {{-- Cetak/Unduh (Disabled) --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-300 dark:bg-indigo-400/40 text-white text-sm font-semibold rounded-lg cursor-not-allowed select-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak/Unduh
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute left-0 top-full mt-1 w-52 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                        style="display:none">

                        {{-- Banner info --}}
                        <div
                            class="flex items-start gap-2 px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-800/30">
                            <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs text-amber-700 dark:text-amber-400 leading-snug">
                                Fitur ini belum tersedia saat ini
                            </p>
                        </div>

                        {{-- Cetak (disabled) --}}
                        <div
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </div>

                        <div class="h-px bg-gray-100 dark:bg-slate-700 mx-3"></div>

                        {{-- Unduh (disabled) --}}
                        <div
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </div>

                    </div>
                </div>

                {{-- Kembali --}}
                <a href="{{ route('admin.bantuan.index') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Program Bantuan
                </a>

            </div>

            {{-- ── RINCIAN PROGRAM ── --}}
            <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3">Rincian Program</h3>
                <table class="w-full text-sm">
                    <tbody>
                        <tr>
                            <td class="py-1.5 pr-4 w-40 text-gray-500 dark:text-slate-400">Nama Program</td>
                            <td class="py-1.5 pr-3 text-gray-400 w-4">:</td>
                            <td class="py-1.5 text-gray-800 dark:text-slate-200 font-medium">{{ $bantuan->nama }}</td>
                        </tr>
                        <tr>
                            <td class="py-1.5 pr-4 text-gray-500 dark:text-slate-400">Sasaran Peserta</td>
                            <td class="py-1.5 pr-3 text-gray-400">:</td>
                            <td class="py-1.5">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $bantuan->sasaran == 1
                                        ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400'
                                        : ($bantuan->sasaran == 2
                                            ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400'
                                            : ($bantuan->sasaran == 3
                                                ? 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400'
                                                : ($bantuan->sasaran == 4
                                                    ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400'
                                                    : 'bg-gray-100 text-gray-500'))) }}">
                                    {{ $bantuan->sasaran_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1.5 pr-4 text-gray-500 dark:text-slate-400">Masa Berlaku</td>
                            <td class="py-1.5 pr-3 text-gray-400">:</td>
                            <td class="py-1.5 text-gray-800 dark:text-slate-200">
                                @if ($bantuan->tanggal_mulai || $bantuan->tanggal_selesai)
                                    {{ optional($bantuan->tanggal_mulai)->format('d M Y') ?? '-' }}
                                    <span class="text-gray-400 mx-1">s/d</span>
                                    {{ optional($bantuan->tanggal_selesai)->format('d M Y') ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @if ($bantuan->keterangan)
                            <tr>
                                <td class="py-1.5 pr-4 text-gray-500 dark:text-slate-400">Keterangan</td>
                                <td class="py-1.5 pr-3 text-gray-400">:</td>
                                <td class="py-1.5 text-gray-800 dark:text-slate-200">{{ $bantuan->keterangan }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- ── DAFTAR PESERTA: HEADER ── --}}
            <div class="px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-200">Daftar Peserta</h3>
            </div>

            {{-- ── TOOLBAR: Tampilkan X entri + Search ── --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.bantuan.show', $bantuan) }}" id="form-per-page-bantuan"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page-bantuan"
                        value="{{ request('per_page', 10) }}">

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
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-per-page-bantuan').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page-bantuan').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
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
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <span>entri</span>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.bantuan.show', $bantuan) }}"
                    class="flex items-center gap-2">
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

            {{-- ── TABEL PESERTA ── --}}
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
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-20">
                                AKSI</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NO. KK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NAMA PENDUDUK</th>
                            <th colspan="7"
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider border-l border-gray-200 dark:border-slate-600">
                                IDENTITAS DI KARTU PESERTA
                            </th>
                        </tr>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th colspan="6"></th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider border-l border-gray-200 dark:border-slate-600">
                                NO. KARTU PESERTA</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                NAMA</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                TEMPAT LAHIR</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                TANGGAL LAHIR</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                ALAMAT</th>
                            <th
                                class="px-3 py-2 text-left text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($peserta as $i => $p)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $p->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- CHECKBOX --}}
                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $p->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- NO --}}
                                <td class="px-3 py-3 text-sm text-gray-500 dark:text-slate-400 tabular-nums">
                                    {{ $peserta->firstItem() + $i }}
                                </td>

                                {{-- AKSI --}}
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1">
                                        <button type="button" @click="openEdit({{ $p->id }})" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                                action: '{{ route('admin.bantuan.peserta.destroy', [$bantuan->id, $p->id]) }}',
                                                nama: '{{ addslashes($p->kartu_nama ?? $p->peserta) }}'
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

                                {{-- NIK --}}
                                <td
                                    class="px-3 py-3 text-sm text-emerald-600 dark:text-emerald-400 font-mono hover:underline cursor-pointer">
                                    {{ $p->kartu_nik ?? ($p->peserta ?? '-') }}
                                </td>

                                {{-- NO. KK --}}
                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 font-mono">
                                    {{ $p->penduduk?->keluarga?->no_kk ?? '-' }}
                                </td>

                                {{-- NAMA PENDUDUK --}}
                                <td
                                    class="px-3 py-3 text-sm font-medium text-gray-800 dark:text-slate-200 whitespace-nowrap">
                                    {{ $p->penduduk?->nama ?? ($p->kartu_nama ?? '-') }}
                                </td>

                                {{-- IDENTITAS KARTU --}}
                                <td
                                    class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 border-l border-gray-100 dark:border-slate-700">
                                    {{ $p->kartu_no_id ?? '-' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 font-mono">
                                    {{ $p->kartu_nik ?? '-' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-800 dark:text-slate-200 whitespace-nowrap">
                                    {{ $p->kartu_nama ?? '-' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $p->kartu_tempat_lahir ?? '-' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $p->kartu_tanggal_lahir ? $p->kartu_tanggal_lahir->format('d-m-Y') : '-' }}
                                </td>
                                <td class="px-3 py-3 text-sm text-gray-600 dark:text-slate-400 max-w-[150px] truncate">
                                    {{ $p->kartu_alamat ?? '-' }}
                                </td>
                                <td class="px-3 py-3">
                                    @php $statusHidup = $p->penduduk?->status_hidup; @endphp
                                    @if ($statusHidup)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
            @switch($statusHidup)
                @case('hidup')    bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 @break
                @case('mati')     bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 @break
                @case('pindah')   bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400 @break
                @case('hilang')   bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 @break
                @case('pergi')    bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 @break
                @default          bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400
            @endswitch">
                                            {{ \App\Models\Penduduk::STATUS_DASAR_LABEL[$statusHidup] ?? $statusHidup }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Belum ada peserta
                                            terdaftar</p>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm">Silakan tambah peserta baru
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
                    @if ($peserta->total() > 0)
                        Menampilkan {{ $peserta->firstItem() }} sampai {{ $peserta->lastItem() }} dari
                        {{ number_format($peserta->total()) }} entri
                    @else
                        Menampilkan 0 sampai 0 dari 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($peserta->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $peserta->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif

                    @php
                        $cp = $peserta->currentPage();
                        $lp = $peserta->lastPage();
                    @endphp
                    @for ($pg = max(1, $cp - 2); $pg <= min($lp, $cp + 2); $pg++)
                        @if ($pg == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $pg }}</span>
                        @else
                            <a href="{{ $peserta->appends(request()->query())->url($pg) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $pg }}</a>
                        @endif
                    @endfor

                    @if ($peserta->hasMorePages())
                        <a href="{{ $peserta->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>

        </div>{{-- end main card --}}


    @include('admin.partials.modal-import-bantuan', ['bantuan' => $bantuan])
    @include('admin.partials.modal-hapus')
    {{-- ── MODAL EDIT PESERTA ── --}}
    <div x-show="editOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="editOpen = false"></div>

        {{-- Panel --}}
        <div class="relative w-full max-w-xl bg-white dark:bg-slate-800 rounded-2xl shadow-2xl overflow-hidden"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Ubah Data Peserta</h3>
                <button @click="editOpen = false"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Loading --}}
            <div x-show="editLoading" class="flex items-center justify-center py-16">
                <svg class="w-8 h-8 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                </svg>
            </div>

            {{-- Form --}}
            <div x-show="!editLoading">
                <form method="POST" :action="`/admin/bantuan/{{ $bantuan->id }}/peserta/${editData.id}`"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-4 space-y-5 max-h-[70vh] overflow-y-auto">

                        {{-- Rincian Program --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3">Rincian Program</h4>
                            <table class="w-full text-sm">
                                <tr>
                                    <td class="py-1 pr-3 text-gray-500 dark:text-slate-400 w-36">NIK</td>
                                    <td class="py-1 pr-2 text-gray-400 w-4">:</td>
                                    <td class="py-1 text-gray-800 dark:text-slate-200 font-mono"
                                        x-text="editData.kartu_nik ?? '-'"></td>
                                </tr>
                                <tr>
                                    <td class="py-1 pr-3 text-gray-500 dark:text-slate-400">Nama Penduduk</td>
                                    <td class="py-1 pr-2 text-gray-400">:</td>
                                    <td class="py-1 text-gray-800 dark:text-slate-200"
                                        x-text="editData.nama_penduduk ?? '-'"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="h-px bg-gray-100 dark:bg-slate-700"></div>

                        {{-- Identitas Kartu --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3">Identitas Pada Kartu
                                Peserta</h4>
                            <div class="space-y-3">

                                {{-- No Kartu --}}
                                <div class="flex items-center gap-3">
                                    <label class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0">
                                        Nomor Kartu Peserta
                                    </label>
                                    <input type="text" name="kartu_no_id" :value="editData.kartu_no_id"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>

                                {{-- Gambar Kartu --}}
                                <div class="flex items-start gap-3">
                                    <label class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0 pt-2">
                                        Gambar Kartu Peserta
                                    </label>
                                    <div class="flex-1">
                                        <input type="file" name="gambar_kartu" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar
                                        </p>
                                    </div>
                                </div>

                                {{-- NIK Kartu --}}
                                <div class="flex items-center gap-3">
                                    <label class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0">NIK</label>
                                    <input type="text" name="kartu_nik" :value="editData.kartu_nik"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm font-mono focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>

                                {{-- Nama --}}
                                <div class="flex items-center gap-3">
                                    <label
                                        class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0">Nama</label>
                                    <input type="text" name="kartu_nama" :value="editData.kartu_nama"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>

                                {{-- Tempat Lahir --}}
                                <div class="flex items-center gap-3">
                                    <label class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0">Tempat
                                        Lahir</label>
                                    <input type="text" name="kartu_tempat_lahir" :value="editData.kartu_tempat_lahir"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="flex items-center gap-3">
                                    <label class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0">Tanggal
                                        Lahir</label>
                                    <input type="date" name="kartu_tanggal_lahir"
                                        :value="editData.kartu_tanggal_lahir"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>

                                {{-- Alamat --}}
                                <div class="flex items-start gap-3">
                                    <label
                                        class="w-40 text-sm text-gray-600 dark:text-slate-400 flex-shrink-0 pt-2">Alamat</label>
                                    <textarea name="kartu_alamat" rows="2" x-text="editData.kartu_alamat"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-emerald-500 outline-none resize-none"></textarea>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div
                        class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <button type="button" @click="editOpen = false"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
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
    </div>

     </div>{{-- end x-data --}}

@endsection
