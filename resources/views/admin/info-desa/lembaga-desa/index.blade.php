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
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Daftar Lembaga Desa</span>
            </nav>
        </div>

        {{-- ── Action Buttons ── --}}
        <div class="flex flex-wrap items-center gap-2 mb-4">

            {{-- Tambah --}}
            <a href="{{ route('admin.lembaga-desa.create') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </a>

            {{-- Hapus (bulk) --}}
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

            {{-- ── Cetak / Unduh Dropdown ── --}}
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

            {{-- ── Modal Cetak ── --}}
            <div id="modal-cetak"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-5">Cetak</h3>

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
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
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
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
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
                            <button type="button"
                                onclick="document.getElementById('modal-cetak').classList.add('hidden')"
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

            {{-- ── Modal Unduh ── --}}
            <div id="modal-unduh"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-5">Unduh</h3>

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
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
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
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
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
                            <button type="button"
                                onclick="document.getElementById('modal-unduh').classList.add('hidden')"
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

            {{-- Kategori --}}
            <a href="{{ route('admin.lembaga-kategori.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Kategori
            </a>

            {{-- Bersihkan --}}
            <a href="{{ route('admin.lembaga-desa.index') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Bersihkan
            </a>
        </div>

        {{-- ── Main Card ── --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">

            {{-- ── Filter Bar ── --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <form id="filter-form" method="GET" class="flex flex-wrap items-center gap-3">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                    {{-- ── Filter Status (custom searchable dropdown) ── --}}
                    <div class="relative" x-data="{
                        open: false,
                        search: '',
                        selected: {
                            id: '{{ request('aktif') }}',
                            label: '{{ request('aktif') === '1' ? 'Aktif' : (request('aktif') === '0' ? 'Nonaktif' : 'Semua Status') }}'
                        },
                        options: [
                            { id: '', label: 'Semua Status' },
                            { id: '1', label: 'Aktif' },
                            { id: '0', label: 'Nonaktif' },
                        ],
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        choose(opt) {
                            this.selected = opt;
                            this.open = false;
                            this.search = '';
                            document.getElementById('input-aktif').value = opt.id;
                            document.getElementById('filter-form').submit();
                        }
                    }">
                        <input type="hidden" id="input-aktif" name="aktif" value="{{ request('aktif') }}">

                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="min-w-[160px] border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 cursor-pointer flex items-center justify-between gap-2 focus-within:ring-2 focus-within:ring-emerald-500 hover:border-emerald-400 transition-colors">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' :
                                    'text-gray-700 dark:text-slate-200'">
                            </span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200"
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
                            class="absolute left-0 top-full mt-1 z-40 w-full min-w-[160px] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari status..."
                                    class="w-full px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-500 rounded bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none"
                                    @keydown.escape="open = false; search = ''">
                            </div>
                            <ul class="max-h-40 overflow-y-auto py-1">
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
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- ── Filter Kategori (custom searchable dropdown) ── --}}
                    <div class="relative" x-data="{
                        open: false,
                        search: '',
                        selected: {
                            id: '{{ request('kategori_id') }}',
                            label: '{{ request('kategori_id') ? optional($kategoris->firstWhere('id', request('kategori_id')))->nama ?? 'Pilih Kategori Lembaga' : 'Pilih Kategori Lembaga' }}'
                        },
                        options: [
                            { id: '', label: 'Pilih Kategori Lembaga' },
                            @foreach ($kategoris as $kategori)
                                { id: '{{ $kategori->id }}', label: '{{ addslashes($kategori->nama) }}' }, @endforeach
                        ],
                        get filtered() {
                            return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        choose(opt) {
                            this.selected = opt;
                            this.open = false;
                            this.search = '';
                            document.getElementById('input-kategori').value = opt.id;
                            document.getElementById('filter-form').submit();
                        }
                    }">
                        <input type="hidden" id="input-kategori" name="kategori_id"
                            value="{{ request('kategori_id') }}">

                        <div @click="open = !open" @click.outside="open = false; search = ''"
                            class="min-w-[220px] border border-gray-300 dark:border-slate-600 rounded-md px-3 py-1.5 text-sm bg-white dark:bg-slate-800 cursor-pointer flex items-center justify-between gap-2 focus-within:ring-2 focus-within:ring-emerald-500 hover:border-emerald-400 transition-colors">
                            <span x-text="selected.label"
                                :class="selected.id === '' ? 'text-gray-400 dark:text-slate-500' :
                                    'text-gray-700 dark:text-slate-200'">
                            </span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform duration-200"
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
                            class="absolute left-0 top-full mt-1 z-40 w-full min-w-[220px] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-md shadow-lg"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-600">
                                <input type="text" x-model="search" @click.stop placeholder="Cari kategori..."
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
                                    class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 italic">
                                    Tidak ditemukan
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Search keyword --}}
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

            {{-- ── Table Controls ── --}}
            <div
                class="px-4 py-2.5 flex items-center justify-between border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
                <form method="GET" class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    <input type="hidden" name="aktif" value="{{ request('aktif') }}">
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <label>Tampilkan</label>
                    <select name="per_page" onchange="this.form.submit()"
                        class="border border-gray-300 dark:border-slate-600 rounded px-2 py-1 text-sm bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 outline-none">
                        @foreach ([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                {{ $n }}
                            </option>
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
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap w-14">
                                NO
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                AKSI
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
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
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
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
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
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
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
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
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide whitespace-nowrap">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'jumlah_anggota', 'dir' => request('sort') === 'jumlah_anggota' && request('dir') === 'asc' ? 'desc' : 'asc']) }}"
                                    class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                                    JUMLAH ANGGOTA LEMBAGA
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
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors group"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">
                                <td class="px-4 py-3">
                                    <input type="checkbox"
                                        class="lembaga-row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $item->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-center">
                                    {{ $lembaga->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.lembaga-desa.show', $item->id) }}" title="Rincian Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h10" />
                                            </svg>
                                        </a>
                                        <a href="/admin/info-desa/lembaga-desa/{{ $item->id }}/dokumen"
                                            title="Dokumen"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-sky-500 hover:bg-sky-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.lembaga-desa.edit', $item->id) }}" title="Ubah Data"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded bg-orange-500 hover:bg-orange-600 text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button type="button" title="Hapus"
                                            @click="$dispatch('buka-modal-hapus', {
                                                action: '{{ route('admin.lembaga-desa.destroy', $item->id) }}',
                                                nama: '{{ addslashes($item->nama) }}'
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
                                <td class="px-4 py-3 font-mono text-gray-800 dark:text-slate-200 font-medium">
                                    {{ $item->kode }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 dark:text-slate-200 font-medium">
                                    {{ $item->nama }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-slate-400">
                                    @if ($item->ketua)
                                        {{ str_replace('_', ' ', explode('-', $item->ketua)[1] ?? $item->ketua) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if ($item->kategori)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                                            {{ $item->kategori->nama }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center min-w-[2rem] px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                        {{ $item->anggota_count }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p class="text-sm font-medium">Data lembaga tidak ditemukan.</p>
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
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $lembaga->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $lembaga->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold text-gray-800 dark:text-slate-200">{{ $lembaga->total() }}</span>
                    entri
                </p>

                <div class="flex items-center gap-1 text-sm">
                    @if ($lembaga->onFirstPage())
                        <span
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-400 dark:text-slate-600 bg-white dark:bg-slate-800 cursor-not-allowed select-none">
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $lembaga->previousPageUrl() }}"
                            class="px-3 py-1.5 rounded border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">
                            Sebelumnya
                        </a>
                    @endif

                    @foreach ($lembaga->getUrlRange(max(1, $lembaga->currentPage() - 2), min($lembaga->lastPage(), $lembaga->currentPage() + 2)) as $page => $url)
                        @if ($page == $lembaga->currentPage())
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

                    @if ($lembaga->hasMorePages())
                        <a href="{{ $lembaga->nextPageUrl() }}"
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
