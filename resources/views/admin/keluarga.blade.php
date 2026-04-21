@extends('layouts.admin')

@section('title', 'Data Keluarga')

@section('content')

    {{-- ══════════════════════════════════════════════════════════════
         STYLE: dropdown portal (posisi fixed, keluar dari tabel)
    ══════════════════════════════════════════════════════════════ --}}
    <style>
        /* Dropdown Portal — dirender di body, posisi fixed */
        .aksi-dropdown-portal {
            display: none;
            position: fixed;
            z-index: 9999;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.13), 0 2px 8px rgba(0, 0, 0, 0.07);
            min-width: 224px;
            overflow: hidden;
            animation: aksiDropIn 0.12s ease-out;
        }

        .dark .aksi-dropdown-portal {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
        }

        @keyframes aksiDropIn {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Item menu dalam dropdown */
        .aksi-dropdown-portal a,
        .aksi-dropdown-portal button.aksi-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 500;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: #374151;
            text-decoration: none;
            transition: background 0.1s, color 0.1s;
            white-space: nowrap;
        }

        .dark .aksi-dropdown-portal a,
        .dark .aksi-dropdown-portal button.aksi-item {
            color: #cbd5e1;
        }

        .aksi-dropdown-portal a:hover,
        .aksi-dropdown-portal button.aksi-item:hover {
            background: #f0fdf4;
            color: #065f46;
        }

        .dark .aksi-dropdown-portal a:hover,
        .dark .aksi-dropdown-portal button.aksi-item:hover {
            background: rgba(16, 185, 129, 0.12);
            color: #6ee7b7;
        }

        .aksi-dropdown-portal .aksi-item-amber:hover {
            background: #fffbeb;
            color: #92400e;
        }

        .aksi-dropdown-portal .aksi-item-blue:hover {
            background: #eff6ff;
            color: #1e40af;
        }

        .aksi-dropdown-portal .aksi-item-indigo:hover {
            background: #eef2ff;
            color: #3730a3;
        }

        .aksi-dropdown-portal .aksi-item-red {
            color: #dc2626 !important;
        }

        .aksi-dropdown-portal .aksi-item-red:hover {
            background: #fef2f2 !important;
            color: #991b1b !important;
        }

        .dark .aksi-dropdown-portal .aksi-item-amber:hover {
            background: rgba(245, 158, 11, .12);
            color: #fcd34d;
        }

        .dark .aksi-dropdown-portal .aksi-item-blue:hover {
            background: rgba(59, 130, 246, .12);
            color: #93c5fd;
        }

        .dark .aksi-dropdown-portal .aksi-item-indigo:hover {
            background: rgba(99, 102, 241, .12);
            color: #a5b4fc;
        }

        .dark .aksi-dropdown-portal .aksi-item-red {
            color: #f87171 !important;
        }

        .dark .aksi-dropdown-portal .aksi-item-red:hover {
            background: rgba(239, 68, 68, .12) !important;
            color: #fca5a5 !important;
        }

        .aksi-dropdown-portal .aksi-item-disabled {
            color: #d1d5db !important;
            cursor: not-allowed !important;
            pointer-events: none;
        }

        .dark .aksi-dropdown-portal .aksi-item-disabled {
            color: #475569 !important;
        }

        .aksi-dropdown-portal .aksi-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 2px 0;
        }

        .dark .aksi-dropdown-portal .aksi-divider {
            background: #334155;
        }

        /* Tombol Pilih Aksi di tabel */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #059669;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
        }

        .btn-aksi:hover {
            background-color: #d1fae5;
            border-color: #6ee7b7;
            color: #047857;
        }

        .btn-aksi.active {
            background-color: #10b981;
            border-color: #10b981;
            color: #ffffff;
        }

        .dark .btn-aksi {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .dark .btn-aksi:hover {
            background-color: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .dark .btn-aksi.active {
            background-color: #10b981;
            color: #ffffff;
        }
    </style>

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

        {{-- FLASH ERROR --}}
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

        {{-- CARD --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

            {{-- ════ BARIS TOMBOL AKSI ════ --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- 1. Tambah KK Baru --}}
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
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
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

                {{-- 2. Aksi Data Terpilih --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 7a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
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

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-64 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">

                        {{-- Cetak Data Terpilih --}}
                        <button type="button"
                            @click="selectedIds.length > 0 ? (open = false, $dispatch('buka-modal-cetak-keluarga', { selectedIds: selectedIds })) : null"
                            :class="selectedIds.length > 0 ?
                                'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 cursor-pointer' :
                                'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                            {{-- PERBAIKAN: hapus text-emerald-500 / text-red-500 dari semua SVG di sini agar inherit warna teks parent --}}
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Data Terpilih
                        </button>

                        {{-- Unduh Data Terpilih --}}
                        <button type="button"
                            @click="selectedIds.length > 0 ? (open = false, $dispatch('buka-modal-unduh-keluarga', { selectedIds: selectedIds })) : null"
                            :class="selectedIds.length > 0 ?
                                'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 cursor-pointer' :
                                'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh Data Terpilih
                        </button>

                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                        {{-- Hapus Data Terpilih --}}
                        <form method="POST" action="{{ route('admin.keluarga.bulk-destroy') }}" id="form-bulk-hapus-kk">
                            @csrf
                            @method('DELETE')
                            <template x-for="id in selectedIds" :key="'bulk-hapus-' + id">
                                <input type="hidden" name="ids[]" :value="id">
                            </template>
                            <button type="button"
                                @click="selectedIds.length > 0 ? (open = false, $dispatch('buka-modal-hapus', { bulkCount: selectedIds.length, onConfirm: () => document.getElementById('form-bulk-hapus-kk').submit() })) : null"
                                :class="selectedIds.length > 0 ?
                                    'text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 cursor-pointer' :
                                    'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Data Terpilih
                            </button>
                        </form>

                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                        {{-- Tambah Rumah Tangga Kolektif --}}
                        {{-- PERBAIKAN: ganti slate → emerald supaya konsisten dengan menu lain --}}
                        <button type="button"
                            @click="selectedIds.length > 0 ? (open = false, $dispatch('buka-modal-rumah-tangga-kolektif')) : null"
                            :class="selectedIds.length > 0 ?
                                'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 cursor-pointer' :
                                'text-gray-300 dark:text-slate-600 cursor-not-allowed'"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tambah Rumah Tangga Kolektif
                        </button>

                        {{-- Pindah Wilayah Kolektif (submenu) --}}
                        {{-- PERBAIKAN: ganti slate → emerald supaya konsisten dengan menu lain --}}
                        <div x-data="{ subOpen: false }" @click.away="subOpen = false" class="relative">
                            <button @click="selectedIds.length > 0 ? (subOpen = !subOpen) : null"
                                :class="selectedIds.length > 0 ?
                                    'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 cursor-pointer' :
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

                {{-- 3. Pilih Aksi Lainnya --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 7a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Pilih Aksi Lainnya
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-64 z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                        style="display:none">
                        <button type="button" @click="open = false; $dispatch('buka-modal-cetak-keluarga')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                        <button type="button" @click="open = false; $dispatch('buka-modal-unduh-keluarga')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </button>
                        <button type="button" @click="open = false; $dispatch('open-program-bantuan-kk')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zm-5 0H9m2-3v6" />
                            </svg>
                            Pencarian Program Bantuan
                        </button>
                        <button type="button" @click="open = false; $dispatch('open-kumpulan-kk')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                            Pilihan Kumpulan KK
                        </button>
                        @php $isNoKkSementara = request()->boolean('no_kk_sementara'); @endphp
                        <a @click="open = false"
                            href="{{ route('admin.keluarga', array_merge(request()->except('no_kk_sementara', 'page'), $isNoKkSementara ? [] : ['no_kk_sementara' => 1])) }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors {{ $isNoKkSementara ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 font-semibold' : 'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700' }}">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            No KK Sementara
                            @if ($isNoKkSementara)
                                <span
                                    class="ml-auto text-[10px] bg-emerald-500 text-white px-1.5 py-0.5 rounded-full">Aktif</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>

            {{-- ════ BARIS FILTER ════ --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <form method="GET" action="{{ route('admin.keluarga') }}" id="form-filter"
                    class="flex flex-wrap items-center gap-2">

                    <input type="hidden" name="status_kk" id="val-status_kk" value="{{ request('status_kk') }}">
                    <input type="hidden" name="jenis_kelamin" id="val-jenis_kelamin"
                        value="{{ request('jenis_kelamin') }}">
                    <input type="hidden" name="dusun" id="val-dusun" value="{{ request('dusun') }}">

                    {{-- 1. Status KK --}}
                    <div class="relative w-52" x-data="{
                        open: false,
                        selected: '{{ request('status_kk') }}',
                        placeholder: 'Pilih Status KK',
                        options: [
                            { value: 'aktif', label: 'KK Aktif' },
                            { value: 'nonaktif', label: 'KK Hilang/Pindah/Mati' },
                            { value: 'kosong', label: 'KK Kosong' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-status_kk').value = opt.value;
                            this.open = false;
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-status_kk').value = '';
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

                    {{-- 2. Jenis Kelamin --}}
                    <div class="relative w-48" x-data="{
                        open: false,
                        selected: '{{ request('jenis_kelamin') }}',
                        placeholder: 'Pilih Jenis Kelamin',
                        options: [
                            { value: 'L', label: 'Laki-laki' },
                            { value: 'P', label: 'Perempuan' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-jenis_kelamin').value = opt.value;
                            this.open = false;
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-jenis_kelamin').value = '';
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
                                    Semua
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

                    {{-- 3. Dusun --}}
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

                    {{-- Reset --}}
                    @if (request()->hasAny(['status_kk', 'jenis_kelamin', 'dusun', 'search']))
                        <a href="{{ route('admin.keluarga') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors border border-red-200 dark:border-red-800">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- ════ TOOLBAR: Tampilkan X entri + Search ════ --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.keluarga') }}" id="form-per-page-kk"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page-kk" value="{{ request('per_page', 10) }}">

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
                            document.getElementById('val-per-page-kk').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page-kk').submit();
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
                <form method="GET" action="{{ route('admin.keluarga') }}" class="flex items-center gap-2">
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

            {{-- ════ TABEL ════ --}}
            <div style="overflow-x: auto; overflow-y: visible;">
                <table class="w-full text-sm" style="min-width: 1400px;">
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
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-36">
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

                                {{-- Checkbox --}}
                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $kk->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- Nomor --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                    {{ $keluarga->firstItem() + $index }}
                                </td>

                                {{-- ════ AKSI — tombol trigger portal dropdown ════ --}}
                                <td class="px-3 py-3">
                                    <button class="btn-aksi" data-kk-id="{{ $kk->id }}"
                                        onclick="toggleKkDropdown(this, event)" type="button">
                                        <svg style="width:13px;height:13px;flex-shrink:0;" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pilih Aksi
                                        <svg style="width:10px;height:10px;" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
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
                                        class="font-mono font-semibold hover:underline text-xs {{ str_starts_with($kk->no_kk, '0') ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }}">
                                        {{ $kk->no_kk }}
                                    </a>
                                    @if (str_starts_with($kk->no_kk, '0'))
                                        <span class="ml-1 text-xs text-red-400">(sementara)</span>
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

            {{-- ════ PAGINATION ════ --}}
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
                    @if ($s > 1)
                        <a href="{{ $keluarga->appends(request()->query())->url(1) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                        @if ($s > 2)
                            <span class="px-1 text-gray-400">…</span>
                        @endif
                    @endif
                    @for ($pg = $s; $pg <= $e; $pg++)
                        @if ($pg == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $pg }}</span>
                        @else
                            <a href="{{ $keluarga->appends(request()->query())->url($pg) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $pg }}</a>
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
        @include('admin.partials.modal-cetak-unduh-keluarga')
        @include('admin.partials.modal-dari-penduduk-row')

        {{-- ════ MODAL TAMBAH RUMAH TANGGA KOLEKTIF ════ --}}
        <div x-data="{ show: false }" @buka-modal-rumah-tangga-kolektif.window="show = true" x-show="show"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50" style="display:none">

            <div @click.away="show = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-md mx-4">

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

                <div class="px-5 py-4">
                    <div class="bg-emerald-500 dark:bg-emerald-600 rounded-lg px-4 py-3">
                        <p class="text-white text-sm font-medium">
                            Apakah Anda yakin ingin menambahkan data keluarga ke rumah tangga?
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 px-5 py-4 border-t border-gray-100 dark:border-slate-700">
                    <button @click="show = false"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg transition-colors">
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

        {{-- MODAL: PENCARIAN PROGRAM BANTUAN --}}
        <div x-data="{ show: false }" @open-program-bantuan-kk.window="show = true"
            @keydown.escape.window="show && (show = false)">
            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="show = false" style="display:none"></div>

            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pencarian Program Bantuan</h3>
                        <button @click="show = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form method="GET" action="{{ route('admin.keluarga') }}">
                        @foreach (request()->except('program_bantuan', 'page') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <div class="px-6 py-5 space-y-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Program
                                Bantuan</label>
                            <select name="program_bantuan"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="">Semua Penerima Bantuan</option>
                                <option value="bukan" @selected(request('program_bantuan') === 'bukan')>Bukan Penerima Bantuan</option>
                                @foreach ($programBantuanList as $program)
                                    <option value="{{ $program }}" @selected(request('program_bantuan') === $program)>{{ $program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div
                            class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                            <button type="button" @click="show = false"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </button>
                            <button type="submit" @click="show = false"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL: PILIHAN KUMPULAN KK --}}
        <div x-data="{
            show: false,
            search: '',
            selectedKk: [],
            openDrop: false,
            kkData: [
                @foreach ($keluarga ?? [] as $kk)
                    { no_kk: '{{ $kk->no_kk }}', kepala: '{{ addslashes($kk->kepalaKeluarga?->nama ?? '-') }}' }, @endforeach
            ],
            get filteredKk() {
                return !this.search ? this.kkData :
                    this.kkData.filter(k =>
                        k.no_kk.toLowerCase().includes(this.search.toLowerCase()) ||
                        k.kepala.toLowerCase().includes(this.search.toLowerCase())
                    );
            },
            addKk(noKk) {
                if (!this.selectedKk.includes(noKk)) this.selectedKk.push(noKk);
            },
            removeKk(noKk) {
                this.selectedKk = this.selectedKk.filter(n => n !== noKk);
            },
            submitForm() {
                document.getElementById('hidden-kumpulan-kk').value = this.selectedKk.join(',');
                document.getElementById('form-kumpulan-kk').submit();
            }
        }" @open-kumpulan-kk.window="show = true"
            @keydown.escape.window="show && (show = false)">
            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="show = false" style="display:none"></div>

            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pilihan Kumpulan KK</h3>
                        <button @click="show = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form method="GET" action="{{ route('admin.keluarga') }}" id="form-kumpulan-kk">
                        @foreach (request()->except('kumpulan_kk', 'page') as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <input type="hidden" id="hidden-kumpulan-kk" name="kumpulan_kk">

                        <div class="px-6 py-5 space-y-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300">Kumpulan
                                KK</label>
                            <div class="relative mb-2" @click.away="openDrop = false">
                                <button type="button" @click="openDrop = !openDrop"
                                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                    :class="openDrop ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                    <span class="text-gray-400 dark:text-slate-500"
                                        x-text="openDrop ? 'Ketik untuk mencari...' : 'Cari No. KK / Kepala Keluarga...'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform"
                                        :class="openDrop ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div x-show="openDrop"
                                    class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" placeholder="Cari No. KK atau nama..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                    </div>
                                    <ul class="max-h-40 overflow-y-auto py-1">
                                        <template x-for="opt in filteredKk" :key="opt.no_kk">
                                            <li @click="addKk(opt.no_kk); search=''; openDrop=false"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 text-gray-700 dark:text-slate-200"
                                                x-text="opt.no_kk + ' - ' + opt.kepala"></li>
                                        </template>
                                        <li x-show="filteredKk.length === 0"
                                            class="px-3 py-2 text-xs text-gray-400 italic">Tidak ada data</li>
                                    </ul>
                                </div>
                            </div>

                            <div
                                class="p-3 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg min-h-10">
                                <template x-if="selectedKk.length === 0">
                                    <p class="text-xs text-gray-400 dark:text-slate-500 italic">Belum ada No. KK dipilih.
                                    </p>
                                </template>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="noKk in selectedKk" :key="noKk">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 rounded-full">
                                            <span x-text="noKk"></span>
                                            <button type="button" @click="removeKk(noKk)" class="hover:text-red-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                            <button type="button" @click="show = false"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                            <button type="button" @click="submitForm(); show = false"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>{{-- /x-data --}}

    {{-- ══════════════════════════════════════════════════════════════
         DROPDOWN PORTAL — dirender di luar tabel, posisi fixed
    ══════════════════════════════════════════════════════════════ --}}
    <div id="kk-aksi-dropdown-portal" class="aksi-dropdown-portal">
        {{-- Isinya di-inject oleh JS saat tombol diklik --}}
    </div>

    {{-- Data aksi per baris (JSON) — dibaca oleh JS --}}
    <script>
        var kkAksiMap = {
            @foreach ($keluarga as $kk)
                "{{ $kk->id }}": {
                    noKk: "{{ addslashes($kk->no_kk) }}",
                    urlRincian: "{{ route('admin.keluarga.show', $kk) }}",

                    urlLahir: "{{ route('admin.keluarga.anggota.create', ['keluarga' => $kk->id, 'jenis' => 'lahir']) }}",
                    urlMasuk: "{{ route('admin.keluarga.anggota.create', ['keluarga' => $kk->id, 'jenis' => 'masuk']) }}",

                    urlEdit: "{{ route('admin.keluarga.edit', $kk) }}",
                    urlLokasi: @if ($kk->kepalaKeluarga)
                        "{{ route('admin.penduduk.lokasi', $kk->kepalaKeluarga) }}"
                    @else
                        null
                    @endif ,
                    urlHapus: "{{ route('admin.keluarga.destroy', $kk) }}",

                    anggota: [
                        @foreach ($kk->anggota as $ang)
                            {
                                nik: "{{ $ang->nik }}",
                                nama: "{{ addslashes($ang->nama) }}",
                                hubungan: "{{ addslashes($ang->shdk?->nama ?? 'Kepala Keluarga') }}"
                            },
                        @endforeach
                    ],
                },
            @endforeach
        };
    </script>

    {{-- ══════════════════════════════════════════════════════════════
         JAVASCRIPT — Dropdown Portal Engine (KK)
    ══════════════════════════════════════════════════════════════ --}}
    <script>
        (function() {
            'use strict';

            var portal = document.getElementById('kk-aksi-dropdown-portal');
            var activeBtn = null;

            /* ─── Build HTML isi dropdown ─── */
            function buildDropdownHtml(data, kkId) {
                var html = '';

                // Rincian Anggota Keluarga
                html += '<a href="' + data.urlRincian + '" class="aksi-item">' +
                    icon('M4 6h16M4 10h16M4 14h16M4 18h16', '#10b981') +
                    'Rincian Anggota Keluarga (KK)</a>';

                // Anggota Lahir → ke form tambah
                html += '<a href="' + data.urlLahir + '" class="aksi-item">' +
                    icon('M12 4v16m8-8H4', '#10b981') +
                    'Anggota Keluarga Lahir</a>';

                // Anggota Masuk → ke form tambah
                html += '<a href="' + data.urlMasuk + '" class="aksi-item">' +
                    icon('M12 4v16m8-8H4', '#10b981') +
                    'Anggota Keluarga Masuk</a>';

                // Dari Penduduk Sudah Ada → buka modal
                html += '<button type="button" class="aksi-item"' +
                    ' onclick="triggerDariPendudukRow(\'' + kkId + '\')">' +
                    icon(
                        'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                        '#10b981') +
                    'Dari Penduduk Sudah Ada</button>';

                html += '<div class="aksi-divider"></div>';

                // Ubah Data
                html += '<a href="' + data.urlEdit + '" class="aksi-item aksi-item-amber">' +
                    icon(
                        'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                        '#f59e0b') +
                    'Ubah Data</a>';

                // Lokasi Tempat Tinggal
                if (data.urlLokasi) {
                    html += '<a href="' + data.urlLokasi + '" class="aksi-item aksi-item-blue">' +
                        icon(
                            'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
                            '#3b82f6') +
                        'Lokasi Tempat Tinggal</a>';
                } else {
                    html += '<span class="aksi-item aksi-item-disabled">' +
                        icon(
                            'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
                            '#d1d5db') +
                        'Lokasi Tempat Tinggal</span>';
                }

                html += '<div class="aksi-divider"></div>';

                // Hapus
                html += '<button type="button" class="aksi-item aksi-item-red"' +
                    ' data-hapus-action="' + data.urlHapus + '"' +
                    ' data-hapus-nama="KK ' + escHtml(data.noKk) + '"' +
                    ' onclick="triggerKkHapus(this)">' +
                    icon(
                        'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                        '#ef4444') +
                    'Hapus/Keluar Dari Daftar Keluarga</button>';

                return html;
            }

            function icon(path, color) {
                return '<svg style="width:13px;height:13px;flex-shrink:0;color:' + color +
                    ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + path + '"/></svg>';
            }

            function escHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
                    .replace(/</g, '&lt;').replace(/>/g, '&gt;');
            }

            /* ─── Posisikan portal ─── */
            function positionPortal(btn) {
                var rect = btn.getBoundingClientRect();
                var vpW = window.innerWidth;
                var vpH = window.innerHeight;

                portal.style.visibility = 'hidden';
                portal.style.display = 'block';

                var ddW = portal.offsetWidth;
                var ddH = portal.offsetHeight;
                var top = rect.bottom + 4;
                var left = rect.left;

                if (left + ddW > vpW - 8) left = rect.right - ddW;
                if (top + ddH > vpH - 8) top = rect.top - ddH - 4;
                if (left < 4) left = 4;

                portal.style.top = top + 'px';
                portal.style.left = left + 'px';
                portal.style.visibility = 'visible';
            }

            /* ─── Toggle dropdown ─── */
            window.toggleKkDropdown = function(btn, event) {
                event.stopPropagation();

                if (activeBtn === btn && portal.style.display === 'block') {
                    closePortal();
                    return;
                }

                var kkId = btn.dataset.kkId;
                var data = kkAksiMap[kkId];
                if (!data) return;

                portal.innerHTML = buildDropdownHtml(data, kkId);

                if (activeBtn) activeBtn.classList.remove('active');
                activeBtn = btn;
                btn.classList.add('active');

                positionPortal(btn);
            };

            /* ─── Trigger modal Dari Penduduk Sudah Ada ─── */
            window.triggerDariPendudukRow = function(kkId) {
                var data = kkAksiMap[kkId];
                if (!data) return;
                closePortal();
                window.dispatchEvent(new CustomEvent('buka-modal-dari-penduduk-row', {
                    detail: {
                        kkId: kkId,
                        noKk: data.noKk,
                        anggota: data.anggota || [],
                    }
                }));
            };

            /* ─── Trigger modal hapus ─── */
            window.triggerKkHapus = function(btnEl) {
                var action = btnEl.dataset.hapusAction;
                var nama = btnEl.dataset.hapusNama;
                closePortal();
                window.dispatchEvent(new CustomEvent('buka-modal-hapus', {
                    detail: {
                        action: action,
                        nama: nama
                    }
                }));
            };

            /* ─── Tutup portal ─── */
            function closePortal() {
                portal.style.display = 'none';
                if (activeBtn) {
                    activeBtn.classList.remove('active');
                    activeBtn = null;
                }
            }

            document.addEventListener('click', function(e) {
                if (!portal.contains(e.target)) closePortal();
            });
            window.addEventListener('scroll', closePortal, true);
            window.addEventListener('resize', closePortal);
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closePortal();
            });
        })();
    </script>

@endsection