@extends('layouts.admin')

@section('title', 'Detail Lembaga Desa')

@section('content')
    <div x-data="{
        selectedIds: [],
        selectAll: false,
        toggleAll() {
            if (this.selectAll) {
                this.selectedIds = Array.from(document.querySelectorAll('.anggota-row-checkbox')).map(el => el.value);
            } else {
                this.selectedIds = [];
            }
        },
        toggleOne() {
            const all = Array.from(document.querySelectorAll('.anggota-row-checkbox')).map(el => el.value);
            this.selectAll = all.every(id => this.selectedIds.includes(id));
        }
    }" class="space-y-6">

        {{-- ── Page Header with Breadcrumb ── --}}
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100">
                Data Lembaga Desa {{ $lembaga->nama }}
            </h2>
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
                <a href="{{ route('admin.lembaga-desa.index') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Daftar Lembaga Desa
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">{{ $lembaga->nama }}</span>
            </nav>
        </div>

        {{-- ── Action Buttons — sesuai gambar: Tambah | Hapus (bulk) | Cetak/Unduh | Daftar Lembaga ── --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- [1] Tambah Anggota (Dropdown) --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open" @click.outside="open = false"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 mt-1 w-56 bg-white dark:bg-slate-800 rounded-md shadow-lg border border-gray-200 dark:border-slate-700 z-30"
                    style="display:none">

                    {{-- Tambah Satu --}}
                    <a href="{{ route('admin.lembaga-desa.anggota.create', $lembaga->id) }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700
                   dark:hover:text-emerald-400 transition-colors rounded-t-md">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Tambah Satu Anggota Lembaga
                    </a>

                    <div class="border-t border-gray-100 dark:border-slate-700"></div>

                    {{-- Tambah Beberapa --}}
                    <a href="{{ route('admin.lembaga-desa.anggota.create-bulk', $lembaga->id) }}"
                        class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                   hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700
                   dark:hover:text-teal-400 transition-colors rounded-b-md">
                        <svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                           M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                           m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Tambah Beberapa Anggota Lembaga
                    </a>
                </div>
            </div>

            {{-- [2] Hapus Bulk Anggota --}}
            <form method="POST" action="{{ route('admin.lembaga-desa.anggota.bulk-destroy', $lembaga->id) }}"
                id="form-bulk-hapus-anggota">
                @csrf
                @method('DELETE')
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="button" :disabled="selectedIds.length === 0"
                    @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                    action: '{{ route('admin.lembaga-desa.anggota.bulk-destroy', $lembaga->id) }}',
                    nama: selectedIds.length + ' anggota yang dipilih',
                    formId: 'form-bulk-hapus-anggota'
                })"
                    :class="selectedIds.length > 0 ?
                        'bg-rose-600 hover:bg-rose-700 cursor-pointer' :
                        'bg-rose-300 dark:bg-rose-900/50 cursor-not-allowed opacity-60'"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                    <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                </button>
            </form>

            {{-- [3] Cetak / Unduh Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open" @click.outside="open = false"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak / Unduh
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 mt-1 w-40 bg-white dark:bg-slate-800 rounded-md shadow-lg border border-gray-200 dark:border-slate-700 z-30"
                    style="display:none">

                    <button type="button"
                        @click="open = false; document.getElementById('modal-cetak').classList.remove('hidden')"
                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700 dark:hover:text-teal-400 transition-colors rounded-t-md">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button>

                    <div class="border-t border-gray-100 dark:border-slate-700"></div>

                    <button type="button"
                        @click="open = false; document.getElementById('modal-unduh').classList.remove('hidden')"
                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-400 transition-colors rounded-b-md">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh
                    </button>
                </div>
            </div>

            {{-- [4] Daftar Lembaga --}}
            <a href="{{ route('admin.lembaga-desa.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Daftar Lembaga
            </a>
        </div>

        {{-- ── Modal Cetak ── --}}
        <div id="modal-cetak"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-5">Cetak</h3>

                <form method="GET" action="{{ route('admin.lembaga-desa.anggota.cetak', $lembaga->id) }}"
                    target="_blank">

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
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Laporan Ditandatangani
                        </label>
                        <input type="hidden" name="ditandatangani" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between focus-within:ring-2 focus-within:ring-emerald-500">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' :
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
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Laporan Diketahui
                        </label>
                        <input type="hidden" name="diketahui" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between focus-within:ring-2 focus-within:ring-emerald-500">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' :
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

                    <div class="flex justify-between">
                        <button type="button" onclick="document.getElementById('modal-cetak').classList.add('hidden')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-md transition-colors">
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


        {{-- ════════════════════════════════════════════════════════════
     GANTI seluruh blok "Modal Unduh" yang ada di show.blade.php
     ════════════════════════════════════════════════════════════ --}}

        {{-- ── Modal Unduh ── --}}
        <div id="modal-unduh"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-5">Unduh</h3>

                <form method="GET" action="{{ route('admin.lembaga-desa.anggota.unduh', $lembaga->id) }}">

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
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Laporan Ditandatangani
                        </label>
                        <input type="hidden" name="ditandatangani" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between focus-within:ring-2 focus-within:ring-emerald-500">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' :
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
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        }
                    }">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">
                            Laporan Diketahui
                        </label>
                        <input type="hidden" name="diketahui" :value="selected.id">
                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="w-full border border-gray-300 dark:border-slate-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between focus-within:ring-2 focus-within:ring-emerald-500">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' : ''"></span>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-1 w-full bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari staf..."
                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <template x-for="opt in filtered" :key="opt.id">
                                    <li @click="selected = opt; open = false; search = ''"
                                        class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                        :class="selected.id === opt.id ?
                                            'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' :
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

                    <div class="flex justify-between">
                        <button type="button" onclick="document.getElementById('modal-unduh').classList.add('hidden')"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-md transition-colors">
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

        {{-- ── Rincian Lembaga — tanpa tombol Edit di header (sesuai gambar) ── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide">Rincian Lembaga
                </h3>
            </div>
            <div class="p-5">
                <div class="flex flex-col md:flex-row gap-6">

                    {{-- Detail Fields --}}
                    <div class="flex-1 space-y-3">
                        @php
                            $ketuaRaw = $lembaga->ketua ?? '';
                            $ketuaNama = '-';
                            if ($ketuaRaw) {
                                $pos = strpos($ketuaRaw, '-');
                                $ketuaNama =
                                    $pos !== false
                                        ? str_replace('_', ' ', trim(substr($ketuaRaw, $pos + 1)))
                                        : str_replace('_', ' ', trim($ketuaRaw));
                            }

                            $fields = [
                                'Kode Lembaga' => $lembaga->kode ?? '-',
                                'Nama Lembaga' => $lembaga->nama ?? '-',
                                'Ketua Lembaga' => $ketuaNama,
                                'Kategori Lembaga' => $lembaga->kategori->nama ?? '-',
                                'Keterangan' => $lembaga->deskripsi ?? '-',
                            ];
                        @endphp
                        @foreach ($fields as $label => $value)
                            <div class="flex items-start gap-2">
                                <span
                                    class="w-44 shrink-0 text-sm text-gray-500 dark:text-slate-400">{{ $label }}</span>
                                <span class="text-sm text-gray-400 dark:text-slate-600">:</span>
                                <span class="text-sm text-gray-800 dark:text-slate-200">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Logo --}}
                    <div class="shrink-0">
                        <div
                            class="w-36 h-36 rounded-lg border border-gray-200 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-slate-700/50">
                            @if ($lembaga->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($lembaga->logo))
                                <img src="{{ asset('storage/' . $lembaga->logo) }}" alt="Logo Lembaga"
                                    class="w-full h-full object-contain p-2">
                            @else
                                <img src="{{ asset('images/lumbung-data-logo.png') }}" alt="Default Logo"
                                    class="w-full h-full object-contain p-2">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Anggota Lembaga ── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

            {{-- ── Filter Bar ── --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <h3
                        class="text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap mr-2">
                        Anggota Lembaga
                    </h3>

                    <form id="filter-anggota" method="GET"
                        action="{{ route('admin.lembaga-desa.show', $lembaga->id) }}"
                        class="flex flex-wrap items-center gap-3 w-full">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                        {{-- Filter Status Dasar --}}
                        <div class="relative" x-data="{
                            open: false,
                            search: '',
                            selected: {
                                id: '{{ request('status_dasar') }}',
                                label: '{{ collect([
                                    'hidup' => 'Hidup',
                                    'mati' => 'Mati',
                                    'pindah' => 'Pindah',
                                    'hilang' => 'Hilang',
                                    'pergi' => 'Pergi',
                                    'tidak_valid' => 'Tidak Valid',
                                ])->get(request('status_dasar'), 'Pilih Status Dasar') }}'
                            },
                            options: [
                                { id: '', label: 'Pilih Status Dasar' },
                                { id: 'hidup', label: 'Hidup' },
                                { id: 'mati', label: 'Mati' },
                                { id: 'pindah', label: 'Pindah' },
                                { id: 'hilang', label: 'Hilang' },
                                { id: 'pergi', label: 'Pergi' },
                                { id: 'tidak_valid', label: 'Tidak Valid' },
                            ],
                            get filtered() {
                                return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            choose(opt) {
                                this.selected = opt;
                                this.open = false;
                                this.search = '';
                                document.getElementById('input-status-dasar').value = opt.id;
                                document.getElementById('filter-anggota').submit();
                            }
                        }">
                            <input type="hidden" id="input-status-dasar" name="status_dasar"
                                value="{{ request('status_dasar') }}">
                            <div @click="open = !open" @click.outside="open = false; search = ''"
                                class="min-w-[180px] border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-800 cursor-pointer flex items-center justify-between gap-2 hover:border-emerald-400 transition-colors">
                                <span x-text="selected.label"
                                    :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' :
                                        'text-gray-700 dark:text-slate-200'"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 top-full mt-1 z-40 w-full min-w-[180px] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                    <input type="text" x-model="search" @click.stop placeholder="Cari status..."
                                        class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                        @keydown.escape="open = false; search = ''">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.id">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors"
                                            :class="selected.id === opt.id ?
                                                'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label">
                                        </li>
                                    </template>
                                    <li x-show="filtered.length === 0"
                                        class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">Tidak ditemukan
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="ml-auto flex items-center gap-2" x-data="{ showTip: false }">
                            <label class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Cari:</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="kata kunci pencarian" maxlength="50" @focus="showTip = true"
                                    @blur="showTip = false"
                                    class="border border-gray-300 dark:border-slate-600 rounded-md pl-3 pr-8 py-1.5 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors w-52">
                                <div class="absolute inset-y-0 right-2 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div x-show="showTip" x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute right-0 top-full mt-1.5 z-50 w-64 bg-gray-800 dark:bg-slate-900 text-white text-xs rounded-md px-3 py-2 shadow-lg pointer-events-none leading-relaxed"
                                    style="display:none">
                                    <div
                                        class="absolute -top-1.5 right-4 w-3 h-3 bg-gray-800 dark:bg-slate-900 rotate-45 rounded-sm">
                                    </div>
                                    Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Table Controls ── --}}
            <div
                class="px-4 py-2.5 flex items-center justify-between border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
                <form method="GET" action="{{ route('admin.lembaga-desa.show', $lembaga->id) }}"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    <input type="hidden" name="status_dasar" value="{{ request('status_dasar') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label>Tampilkan</label>
                    <select name="per_page" onchange="this.form.submit()"
                        class="border border-gray-300 dark:border-slate-600 rounded px-2 py-1 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 outline-none">
                        @foreach ([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                {{ $n }}</option>
                        @endforeach
                    </select>
                    <label>entri</label>
                </form>
            </div>

            {{-- ── Table ── --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-900/70 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            @foreach (['NO', 'AKSI', 'FOTO', 'NO. ANGGOTA', 'NIK', 'NAMA', 'TEMPAT / TANGGAL LAHIR', 'UMUR (TAHUN)', 'JENIS KELAMIN', 'STATUS', 'ALAMAT', 'JABATAN', 'NOMOR SK JABATAN', 'NOMOR SK PENGANGKATAN', 'TANGGAL SK PENGANGKATAN', 'NOMOR SK PEMBERHENTIAN', 'TANGGAL SK PEMBERHENTIAN', 'MASA JABATAN (USIA/PERIODE)', 'KETERANGAN'] as $th)
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                    {{ $th }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($anggota as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- Checkbox --}}
                                <td class="px-4 py-3">
                                    <input type="checkbox"
                                        class="anggota-row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $item->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- NO --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-center">
                                    {{ $anggota->firstItem() + $index }}
                                </td>

                                {{-- AKSI: Edit (orange) + Hapus (red) di dalam tabel, sesuai gambar --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.lembaga-desa.anggota.edit', [$lembaga->id, $item->id]) }}"
                                            title="Ubah Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-orange-500 hover:bg-orange-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                        action: '{{ route('admin.lembaga-desa.anggota.destroy', [$lembaga->id, $item->id]) }}',
                                        nama: '{{ addslashes($item->penduduk->nama ?? 'anggota ini') }}'
                                    })"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-rose-500 hover:bg-rose-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-4 py-3 text-center">
                                    @if ($item->penduduk->foto ?? null)
                                        <img src="{{ asset('storage/' . $item->penduduk->foto) }}" alt="Foto"
                                            class="w-9 h-9 rounded-full object-cover mx-auto ring-2 ring-gray-200 dark:ring-slate-600">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-200 dark:bg-slate-600 flex items-center justify-center mx-auto">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-slate-400" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                {{-- NO. ANGGOTA --}}
                                <td
                                    class="px-4 py-3 text-center font-mono text-gray-800 dark:text-slate-200 whitespace-nowrap">
                                    {{ $item->no_anggota ?? $loop->iteration }}
                                </td>

                                {{-- NIK --}}
                                <td class="px-4 py-3 font-mono text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->penduduk->nik ?? '-' }}
                                </td>

                                {{-- NAMA --}}
                                <td class="px-4 py-3 text-gray-800 dark:text-slate-200 font-medium whitespace-nowrap">
                                    {{ $item->penduduk->nama ?? '-' }}
                                </td>

                                {{-- TEMPAT / TGL LAHIR --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->penduduk->tempat_lahir ?? '-' }} /
                                    {{ isset($item->penduduk->tanggal_lahir)
                                        ? \Carbon\Carbon::parse($item->penduduk->tanggal_lahir)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                {{-- UMUR --}}
                                <td class="px-4 py-3 text-center text-gray-600 dark:text-slate-400">
                                    {{ isset($item->penduduk->tanggal_lahir) ? \Carbon\Carbon::parse($item->penduduk->tanggal_lahir)->age : '-' }}
                                </td>

                                {{-- JENIS KELAMIN --}}
                                <td class="px-4 py-3 text-center text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->penduduk->jenis_kelamin ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $statusDasar = strtolower((string) ($item->penduduk->status_dasar ?? ''));
                                        $statusMap = [
                                            'hidup' => [
                                                'label' => 'Hidup',
                                                'class' =>
                                                    'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                            ],
                                            'mati' => [
                                                'label' => 'Mati',
                                                'class' =>
                                                    'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-400',
                                            ],
                                            'pindah' => [
                                                'label' => 'Pindah',
                                                'class' =>
                                                    'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                            ],
                                            'hilang' => [
                                                'label' => 'Hilang',
                                                'class' =>
                                                    'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
                                            ],
                                            'pergi' => [
                                                'label' => 'Pergi',
                                                'class' =>
                                                    'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
                                            ],
                                            'tidak_valid' => [
                                                'label' => 'Tidak Valid',
                                                'class' =>
                                                    'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400',
                                            ],
                                        ];
                                    @endphp
                                    @if (isset($statusMap[$statusDasar]))
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusMap[$statusDasar]['class'] }}">
                                            {{ $statusMap[$statusDasar]['label'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-600">-</span>
                                    @endif
                                </td>

                                {{-- ALAMAT --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 max-w-[150px] truncate"
                                    title="{{ $item->penduduk->alamat ?? '-' }}">
                                    {{ $item->penduduk->alamat ?? '-' }}
                                </td>

                                {{-- JABATAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->jabatan ?? '-' }}
                                </td>

                                {{-- NOMOR SK JABATAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->no_sk_jabatan ?? '-' }}
                                </td>

                                {{-- NOMOR SK PENGANGKATAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->no_sk_pengangkatan ?? '-' }}
                                </td>

                                {{-- TANGGAL SK PENGANGKATAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ isset($item->tgl_sk_pengangkatan)
                                        ? \Carbon\Carbon::parse($item->tgl_sk_pengangkatan)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                {{-- NOMOR SK PEMBERHENTIAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->no_sk_pemberhentian ?? '-' }}
                                </td>

                                {{-- TANGGAL SK PEMBERHENTIAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ isset($item->tgl_sk_pemberhentian)
                                        ? \Carbon\Carbon::parse($item->tgl_sk_pemberhentian)->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                {{-- MASA JABATAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->masa_jabatan ?? '-' }}
                                </td>

                                {{-- KETERANGAN --}}
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 max-w-[150px] truncate"
                                    title="{{ $item->keterangan ?? '-' }}">
                                    {{ $item->keterangan ?? '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="20" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm font-medium">Tidak ada data anggota</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── Footer: Info + Pagination ── --}}
            <div
                class="px-4 py-3 border-t border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/40 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-sm text-gray-600 dark:text-slate-400">
                    Menampilkan
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $anggota->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $anggota->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $anggota->total() }}</span>
                    entri
                </p>

                <div class="flex items-center gap-1 text-sm">
                    @if ($anggota->onFirstPage())
                        <span
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $anggota->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            Sebelumnya
                        </a>
                    @endif

                    @foreach ($anggota->getUrlRange(max(1, $anggota->currentPage() - 2), min($anggota->lastPage(), $anggota->currentPage() + 2)) as $page => $url)
                        @if ($page == $anggota->currentPage())
                            <span
                                class="px-3 py-1.5 rounded border border-emerald-500 bg-emerald-500 text-white font-semibold select-none">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($anggota->hasMorePages())
                        <a href="{{ $anggota->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            Selanjutnya
                        </a>
                    @else
                        <span
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                            Selanjutnya
                        </span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Modal Hapus (single & bulk) --}}
    @include('admin.partials.modal-hapus')

@endsection
