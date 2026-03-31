@extends('layouts.admin')

@section('title', 'Data Keluarga')

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
    },
    toggleOne() {
        const all = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
        this.selectAll = all.every(id => this.selectedIds.includes(id));
    }
    }">

        {{-- PAGE HEADER --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Keluarga</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data kartu keluarga desa</p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Data Keluarga</span>
            </nav>
        </div>

        {{-- FLASH --}}
        @if (session('success'))
        @endif

        @if (session('error'))
        @endif

        {{-- 🔥 TAMBAHKAN KODE INI DI SINI 🔥 --}}
        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show"
                class="flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-sm font-bold text-red-700 dark:text-red-300 mb-1">Gagal menyimpan data:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
        {{-- 🔥 AKHIR TAMBAHAN 🔥 --}}

        {{-- CARD --}}


        {{-- CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow:visible">

            {{-- TOMBOL AKSI --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah KK Baru --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah KK Baru
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1 w-60 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">
                        <a href="{{ route('admin.keluarga.create.masuk') }}"
                            class="flex items-center gap-2.5 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Tambah Penduduk Masuk
                        </a>
                        <div class="border-t border-gray-100 dark:border-slate-700"></div>
                        <button type="button" @click="open = false; $dispatch('buka-modal-dari-penduduk')"
                            class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Dari Penduduk Sudah Ada
                        </button>
                    </div>
                </div>

                {{-- ✅ REVISI: Aksi Data Terpilih - tombol selalu aktif, ISI yang di-disable --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z" />
                        </svg>
                        Aksi Data Terpilih
                        <span x-show="selectedIds.length > 0"
                            class="bg-white/20 text-white text-xs font-bold px-1.5 py-0.5 rounded-full"
                            x-text="selectedIds.length"></span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1 w-64 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">

                        {{-- Cetak Kartu Keluarga --}}
                        <template x-if="selectedIds.length > 0">
                            <a href="{{ route('admin.keluarga.export.pdf', request()->query()) }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak Kartu Keluarga
                            </a>
                        </template>
                        <template x-if="selectedIds.length === 0">
                            <span
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-300 dark:text-slate-600 cursor-not-allowed select-none">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak Kartu Keluarga
                            </span>
                        </template>

                        {{-- Unduh Kartu Keluarga --}}
                        <template x-if="selectedIds.length > 0">
                            <a href="{{ route('admin.keluarga.export.excel', request()->query()) }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Kartu Keluarga
                            </a>
                        </template>
                        <template x-if="selectedIds.length === 0">
                            <span
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-300 dark:text-slate-600 cursor-not-allowed select-none">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Kartu Keluarga
                            </span>
                        </template>

                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                        {{-- ✅ REVISI: Tambah Rumah Tangga Kolektif - trigger modal --}}
                        <button type="button"
                            @click="selectedIds.length > 0 ? (open = false, $dispatch('buka-modal-rumah-tangga-kolektif')) : null"
                            :class="selectedIds.length > 0 ?
                                'text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer' :
                                'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tambah Rumah Tangga Kolektif
                        </button>

                        {{-- Pindah Wilayah Kolektif (submenu) --}}
                        <div x-data="{ subOpen: false }" @click.away="subOpen = false" class="relative">
                            <button @click="selectedIds.length > 0 ? (subOpen = !subOpen) : null"
                                :class="selectedIds.length > 0 ?
                                    'text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 cursor-pointer' :
                                    'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                Pindah Wilayah Kolektif
                            </button>
                            <div x-show="subOpen" x-transition
                                class="absolute left-full top-0 ml-1 w-64 z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl p-4"
                                style="display:none">
                                <form method="POST" action="{{ route('admin.keluarga.pindah-wilayah-kolektif') }}"
                                    @submit.prevent="
                                    $el.querySelectorAll('input[name=\'ids[]\']').forEach(el => el.remove());
                                    selectedIds.forEach(id => {
                                        const inp = document.createElement('input');
                                        inp.type='hidden'; inp.name='ids[]'; inp.value=id;
                                        $el.appendChild(inp);
                                    });
                                    $el.submit();">
                                    @csrf
                                    <p class="text-xs font-semibold text-gray-600 dark:text-slate-300 mb-3">
                                        Pindah <span x-text="selectedIds.length"></span> KK ke wilayah:
                                    </p>
                                    <select name="wilayah_id" required
                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 outline-none mb-3">
                                        <option value="">-- Pilih Wilayah --</option>
                                        @foreach ($wilayahList as $w)
                                            <option value="{{ $w->id }}">{{ $w->dusun }} RT {{ $w->rt }}
                                                / RW {{ $w->rw }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="w-full px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                        Pindahkan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pilih Aksi Lainnya --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                        Pilih Aksi Lainnya
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1 w-56 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">
                        <a href="#"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Pencarian Program Bantuan
                        </a>
                        <a href="#"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Pilihan Kumpulan KK
                        </a>
                        <a href="{{ route('admin.keluarga.generate.no-kk-sementara') }}"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            No KK Sementara
                        </a>
                        <div class="border-t border-gray-100 dark:border-slate-700"></div>
                        <a href="{{ route('admin.keluarga.export.pdf', request()->query()) }}"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </a>
                        <a href="{{ route('admin.keluarga.export.excel', request()->query()) }}"
                            class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                    </div>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <form method="GET" action="{{ route('admin.keluarga') }}" id="form-filter"
                    class="flex flex-wrap items-center gap-2">

                    <input type="hidden" name="status_kk" id="val-status_kk" value="{{ request('status_kk') }}">
                    <input type="hidden" name="jenis_kelamin" id="val-jenis_kelamin"
                        value="{{ request('jenis_kelamin') }}">
                    <input type="hidden" name="dusun" id="val-dusun" value="{{ request('dusun') }}">

                    {{-- Status KK --}}
                    <div class="relative w-52" x-data="{
                        open: false,
                        selected: '{{ request('status_kk') }}',
                        options: [
                            { value: '', label: 'Pilih Status' },
                            { value: 'aktif', label: 'KK Aktif' },
                            { value: 'nonaktif', label: 'KK Hilang/Pindah/Mati' },
                            { value: 'kosong', label: 'KK Kosong' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? 'Pilih Status'; },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-status_kk').value = opt.value;
                            this.open = false;
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
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

                    {{-- Jenis Kelamin --}}
                    <div class="relative w-48" x-data="{
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
                            document.getElementById('val-jenis_kelamin').value = opt.value;
                            this.open = false;
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
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

                    {{-- Dusun --}}
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
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-dusun').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 border-gray-300 dark:border-slate-600 hover:border-emerald-400 transition-colors"
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
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari dusun..."
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

                    @if (request()->hasAny(['status_kk', 'jenis_kelamin', 'dusun', 'search']))
                        <a href="{{ route('admin.keluarga') }}"
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

            {{-- TOOLBAR --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <form method="GET" action="{{ route('admin.keluarga') }}"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <span>Tampilkan</span>
                    <select name="per_page" onchange="this.form.submit()"
                        class="px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                        @foreach ([10, 25, 50, 100] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>
                                {{ $n }}</option>
                        @endforeach
                    </select>
                    <span>entri</span>
                </form>

                <form method="GET" action="{{ route('admin.keluarga') }}" class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50" @input.debounce.400ms="$el.form.submit()"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                    </div>
                </form>
            </div>

            {{-- TABEL --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-3 py-3 w-10 text-center">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                                NO</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-32">
                                AKSI</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-12">
                                FOTO</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NOMOR KK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                KEPALA KELUARGA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                TAG ID CARD</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JML ANGGOTA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JENIS KELAMIN</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                ALAMAT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                DUSUN</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                RW</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                RT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">
                                TGL DAFTAR</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">
                                TGL CETAK KK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($keluarga as $index => $kk)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $kk->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $kk->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                    {{ $keluarga->firstItem() + $index }}</td>

                                {{-- AKSI --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <div x-data="{
                                        open: false,
                                        top: 0,
                                        left: 0,
                                        toggle() {
                                            const rect = $refs.btn.getBoundingClientRect();
                                            this.top = rect.bottom + 4;
                                            this.left = rect.left;
                                            this.open = !this.open;
                                        }
                                    }" @click.away="open = false">

                                        <button x-ref="btn" @click="toggle()"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Pilih Aksi
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        {{-- Dropdown pakai teleport ke body supaya tidak terpotong overflow --}}
                                        <template x-teleport="body">
                                            <div x-show="open" x-transition
                                                :style="`position: fixed; top: ${top}px; left: ${left}px; z-index: 99999;`"
                                                class="w-56 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                                                style="display:none">

                                                <a href="{{ route('admin.keluarga.show', $kk) }}"
                                                    class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                    </svg>
                                                    Rincian Anggota Keluarga (KK)
                                                </a>

                                                <a href="{{ route('admin.keluarga.show', $kk) }}#tambah-lahir"
                                                    class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Anggota Keluarga Lahir
                                                </a>

                                                <a href="{{ route('admin.keluarga.show', $kk) }}#tambah-masuk"
                                                    class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Anggota Keluarga Masuk
                                                </a>

                                                <a href="{{ route('admin.keluarga.show', $kk) }}#tambah-dari-penduduk"
                                                    class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Dari Penduduk Sudah Ada
                                                </a>

                                                <div class="border-t border-gray-100 dark:border-slate-700"></div>

                                                <a href="{{ route('admin.keluarga.edit', $kk) }}"
                                                    class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                    <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Ubah Data
                                                </a>

                                                @if ($kk->kepalaKeluarga)
                                                    <a href="{{ route('admin.penduduk.lokasi', $kk->kepalaKeluarga) }}"
                                                        class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                                        <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        Lokasi Tempat Tinggal
                                                    </a>
                                                @else
                                                    <span
                                                        class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-300 dark:text-slate-600 cursor-not-allowed">
                                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        Lokasi Tempat Tinggal
                                                    </span>
                                                @endif

                                                <div class="border-t border-gray-100 dark:border-slate-700"></div>

                                                <button type="button"
                                                    @click="open = false; $dispatch('buka-modal-hapus', { action: '{{ route('admin.keluarga.destroy', $kk) }}', nama: 'KK {{ addslashes($kk->no_kk) }}' })"
                                                    class="w-full flex items-center gap-2.5 px-3 py-2.5 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus/Keluar Dari Daftar Keluarga
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </td>

                                {{-- FOTO --}}
                                <td class="px-3 py-3">
                                    @if ($kk->kepalaKeluarga?->foto)
                                        <img src="{{ asset('storage/' . $kk->kepalaKeluarga->foto) }}"
                                            class="w-9 h-9 rounded-full object-cover border border-gray-200 dark:border-slate-600">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-200 dark:bg-slate-600 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400 dark:text-slate-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>

                                {{-- NOMOR KK --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.keluarga.show', $kk) }}"
                                        class="font-mono font-semibold text-emerald-600 dark:text-emerald-400 hover:underline text-xs">
                                        {{ $kk->no_kk }}
                                    </a>
                                    @if (str_starts_with($kk->no_kk, '0'))
                                        <span
                                            class="block mt-0.5 px-1.5 py-0.5 text-[10px] font-semibold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 rounded w-fit">Sementara</span>
                                    @endif
                                </td>

                                {{-- KEPALA KELUARGA --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if ($kk->kepalaKeluarga)
                                        <a href="{{ route('admin.penduduk.show', $kk->kepalaKeluarga) }}"
                                            class="font-medium text-gray-900 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors text-xs">
                                            {{ $kk->kepalaKeluarga->nama }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 italic text-xs">—</span>
                                    @endif
                                </td>

                                {{-- NIK --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if ($kk->nik_kepala)
                                        <span
                                            class="font-mono text-xs text-gray-600 dark:text-slate-300">{{ $kk->nik_kepala }}</span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500">—</span>
                                    @endif
                                </td>

                                {{-- TAG ID CARD --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span class="text-xs text-gray-500 dark:text-slate-400">
                                        {{ $kk->kepalaKeluarga?->tag_id_card ?? '—' }}
                                    </span>
                                </td>

                                {{-- JUMLAH ANGGOTA --}}
                                <td class="px-3 py-3 text-center">
                                    <a href="{{ route('admin.keluarga.show', $kk) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 dark:bg-slate-700 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-full text-sm font-bold text-gray-700 dark:text-slate-300 hover:text-emerald-700 transition-colors">
                                        {{ $kk->anggota_count ?? $kk->anggota()->count() }}
                                    </a>
                                </td>

                                {{-- JENIS KELAMIN --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-600 dark:text-slate-300">
                                    @if ($kk->kepalaKeluarga)
                                        {{ $kk->kepalaKeluarga->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                {{-- ALAMAT --}}
                                <td class="px-3 py-3 text-xs text-gray-600 dark:text-slate-300 max-w-[160px] truncate">
                                    {{ $kk->alamat ?? '—' }}
                                </td>

                                {{-- DUSUN --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-600 dark:text-slate-300">
                                    {{ $kk->wilayah?->dusun ?? '—' }}
                                </td>

                                {{-- RW --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-600 dark:text-slate-300">
                                    {{ $kk->wilayah?->rw ?? '—' }}
                                </td>

                                {{-- RT --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-600 dark:text-slate-300">
                                    {{ $kk->wilayah?->rt ?? '—' }}
                                </td>

                                {{-- TANGGAL DAFTAR --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-slate-400">
                                    {{ $kk->tgl_terdaftar?->format('d M Y') ?? '—' }}
                                </td>

                                {{-- TANGGAL CETAK KK --}}
                                <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-500 dark:text-slate-400">
                                    {{ $kk->tgl_cetak_kk?->format('d M Y') ?? '-' }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="16" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data keluarga
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($keluarga->total() > 0)
                        Menampilkan {{ $keluarga->firstItem() }}–{{ $keluarga->lastItem() }} dari
                        {{ number_format($keluarga->total()) }} entri
                    @else
                        Menampilkan 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($keluarga->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $keluarga->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif
                    @php
                        $cp = $keluarga->currentPage();
                        $lp = $keluarga->lastPage();
                        $s = max(1, $cp - 2);
                        $e = min($lp, $cp + 2);
                    @endphp
                    @if ($s > 1)<a
                            href="{{ $keluarga->appends(request()->query())->url(1) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                        @if ($s > 2)
                            <span class="px-1 text-gray-400">…</span>
                        @endif
                    @endif
                    @for ($p = $s; $p <= $e; $p++)
                        @if ($p == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                        @else<a href="{{ $keluarga->appends(request()->query())->url($p) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                        @endif
                    @endfor
                    @if ($e < $lp)
                        @if ($e < $lp - 1)
                            <span class="px-1 text-gray-400">…</span>
                        @endif
                        <a href="{{ $keluarga->appends(request()->query())->url($lp) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lp }}</a>
                    @endif
                    @if ($keluarga->hasMorePages())
                        <a href="{{ $keluarga->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>

        @include('admin.partials.modal-hapus')
        @include('admin.partials.keluarga-dari-penduduk-modal')

        {{-- ✅ MODAL TAMBAH RUMAH TANGGA KOLEKTIF --}}
        <div x-data="{ show: false }" @buka-modal-rumah-tangga-kolektif.window="show = true" x-show="show"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50" style="display:none">

            <div @click.away="show = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md mx-4">

                {{-- Header modal --}}
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Konfirmasi
                    </h3>
                    <button @click="show = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 transition-colors rounded-lg p-1 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body modal --}}
                <div class="px-5 py-4">
                    <div class="bg-cyan-400 dark:bg-cyan-600 rounded-lg px-4 py-3">
                        <p class="text-white text-sm font-medium">
                            Apakah Anda yakin ingin menambahkan data keluarga ke rumah tangga?
                        </p>
                    </div>
                </div>

                {{-- Footer modal --}}
                <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-100 dark:border-slate-700">
                    <button @click="show = false"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Tutup
                    </button>

                    <form method="POST" action="{{ route('admin.keluarga.tambah-rumah-tangga-kolektif') }}"
                        @submit.prevent="
                        $el.querySelectorAll('input[name=\'ids[]\']').forEach(el => el.remove());
                        selectedIds.forEach(id => {
                            const inp = document.createElement('input');
                            inp.type='hidden'; inp.name='ids[]'; inp.value=id;
                            $el.appendChild(inp);
                        });
                        $el.submit();">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
