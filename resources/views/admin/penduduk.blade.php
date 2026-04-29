@extends('layouts.admin')

@section('title', 'Data Penduduk')

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
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            min-width: 240px;
            /* Diperlebar agar teks muat */
            overflow: hidden;
            animation: aksiDropIn 0.12s ease-out;
            padding: 0.5rem 0;
            /* Memberi ruang di atas dan bawah list */
        }

        .dark .aksi-dropdown-portal {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }

        /* ─── KODE BARU: Layout Item di Dalam Dropdown ─── */
        .aksi-dropdown-portal .aksi-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            /* Jarak antara icon dan teks */
            padding: 0.625rem 1rem;
            /* Jarak atas/bawah dan kiri/kanan */
            font-size: 0.875rem;
            /* Ukuran font 14px */
            font-weight: 500;
            color: #4b5563;
            /* text-gray-600 */
            text-decoration: none;
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
        }

        .dark .aksi-dropdown-portal .aksi-item {
            color: #cbd5e1;
            /* text-slate-300 */
        }

        /* Hover Efek Default */
        .aksi-dropdown-portal .aksi-item:hover {
            background-color: #f3f4f6;
            /* bg-gray-100 */
            color: #111827;
            /* text-gray-900 */
        }

        .dark .aksi-dropdown-portal .aksi-item:hover {
            background-color: #334155;
            /* bg-slate-700 */
            color: #f8fafc;
            /* text-slate-50 */
        }

        /* ─── KODE BARU: Garis Pemisah (Divider) ─── */
        .aksi-dropdown-portal .aksi-divider {
            height: 1px;
            background-color: #e5e7eb;
            /* border-gray-200 */
            margin: 0.375rem 0;
            /* Spasi luar margin */
        }

        .dark .aksi-dropdown-portal .aksi-divider {
            background-color: #475569;
            /* border-slate-600 */
        }

        /* ─── KODE BARU: Hover Effects Berwarna (Opsional) ─── */
        /* Menyesuaikan warna background saat di-hover dengan warna icon */
        .aksi-item-amber:hover {
            background-color: #fef3c7 !important;
            color: #d97706 !important;
        }

        .aksi-item-teal:hover {
            background-color: #ccfbf1 !important;
            color: #0f766e !important;
        }

        .aksi-item-orange:hover {
            background-color: #ffedd5 !important;
            color: #c2410c !important;
        }

        .aksi-item-blue:hover {
            background-color: #dbeafe !important;
            color: #1d4ed8 !important;
        }

        .aksi-item-indigo:hover {
            background-color: #e0e7ff !important;
            color: #4338ca !important;
        }

        .aksi-item-red:hover {
            background-color: #fee2e2 !important;
            color: #b91c1c !important;
        }

        /* Dark mode hover effects berwarna */
        .dark .aksi-item-amber:hover {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
        }

        .dark .aksi-item-teal:hover {
            background-color: rgba(20, 184, 166, 0.15) !important;
            color: #2dd4bf !important;
        }

        .dark .aksi-item-orange:hover {
            background-color: rgba(249, 115, 22, 0.15) !important;
            color: #fb923c !important;
        }

        .dark .aksi-item-blue:hover {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60a5fa !important;
        }

        .dark .aksi-item-indigo:hover {
            background-color: rgba(99, 102, 241, 0.15) !important;
            color: #818cf8 !important;
        }

        .dark .aksi-item-red:hover {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #f87171 !important;
        }

        @keyframes aksiDropIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-5px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ─── KODE BARU: Styling Tombol "Pilih Aksi" di Tabel ─── */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            /* Jarak antara icon gear, teks, dan panah bawah */
            padding: 0.375rem 0.75rem;
            /* Spasi dalam tombol */
            font-size: 0.75rem;
            /* Ukuran font 12px */
            font-weight: 600;
            color: #059669;
            /* Warna teks hijau (emerald-600) */
            background-color: #ecfdf5;
            /* Warna latar hijau sangat muda (emerald-50) */
            border: 1px solid #a7f3d0;
            /* Border hijau muda (emerald-200) */
            border-radius: 0.375rem;
            /* Sudut membulat */
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            white-space: nowrap;
            /* Mencegah teks turun ke baris baru */
        }

        /* Efek saat cursor mouse berada di atas tombol */
        .btn-aksi:hover {
            background-color: #d1fae5;
            border-color: #6ee7b7;
            color: #047857;
        }

        /* Efek saat dropdown sedang terbuka (Class .active dari Javascript) */
        .btn-aksi.active {
            background-color: #10b981;
            /* Background hijau penuh */
            border-color: #10b981;
            color: #ffffff;
            /* Teks putih */
        }

        /* ─── Dark Mode untuk Tombol Aksi ─── */
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

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Penduduk</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data penduduk desa</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Data Penduduk</span>
        </nav>
    </div>

    {{-- Wrapper state component Alpine JS untuk bulk action & checkbox --}}
    <div x-data="{
        selectedIds: [],
        selectAll: false,
        toggleAll() {
            if (this.selectAll) {
                this.selectedIds = Array.from(document.querySelectorAll('.row-checkbox')).map(cb => cb.value);
            } else {
                this.selectedIds = [];
            }
        },
        toggleOne() {
            const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
            this.selectAll = totalCheckboxes > 0 && this.selectedIds.length === totalCheckboxes;
        }
    }">

        {{-- ── CARD UTAMA ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

            {{-- ════ BARIS TOMBOL AKSI ════ --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- 1. Tambah Penduduk --}}
                <a href="{{ route('admin.penduduk.create') }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Penduduk
                </a>

                {{-- 2. Hapus Terpilih --}}
                <form method="POST" action="{{ route('admin.penduduk.bulk-destroy') }}" id="form-bulk-hapus">
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
                            'bg-red-300 dark:bg-red-900/50 cursor-not-allowed opacity-60'"
                        class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Data Terpilih
                        <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                    </button>
                </form>

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
                        class="absolute left-0 top-full mt-1 w-64 z-[100] bg-white dark:bg-slate-800
                           border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
                        style="display:none">

                        <button type="button" @click="open = false; $dispatch('buka-modal-cetak')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>

                        <button type="button" @click="open = false; $dispatch('buka-modal-unduh')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </button>

                        <button type="button" @click="open = false; $dispatch('open-pencarian-spesifik')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                            Pencarian Spesifik
                        </button>

                        <button type="button" @click="open = false; $dispatch('open-program-bantuan')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zm-5 0H9m2-3v6" />
                            </svg>
                            Pencarian Program Bantuan
                        </button>

                        <button type="button" @click="open = false; $dispatch('open-kumpulan-nik')"
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                            Pilihan Kumpulan NIK
                        </button>

                        @php $isNikSementara = request()->boolean('nik_sementara'); @endphp
                        <a @click="open = false"
                            href="{{ route('admin.penduduk', array_merge(request()->except('nik_sementara', 'page'), $isNikSementara ? [] : ['nik_sementara' => 1])) }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
       {{ $isNikSementara
           ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400 font-semibold'
           : 'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700' }}">
                            <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                            NIK Sementara
                            @if ($isNikSementara)
                                <span
                                    class="ml-auto text-[10px] bg-emerald-500 text-white px-1.5 py-0.5 rounded-full">Aktif</span>
                            @endif
                        </a>
                    </div>
                </div>

             {{-- 4. Impor / Ekspor --}}
<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open"
        class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-700 hover:bg-slate-800 dark:bg-slate-600 dark:hover:bg-slate-500 text-white text-sm font-semibold rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
        </svg>
        Impor / Ekspor
        <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="absolute left-0 top-full mt-1 w-60 z-[100] bg-white dark:bg-slate-800
           border border-gray-200 dark:border-slate-600 rounded-xl shadow-lg overflow-hidden"
        style="display:none">
 
        {{-- Impor Penduduk → pindah halaman --}}
        <a href="{{ route('admin.penduduk.impor') }}" @click="open = false"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Impor Penduduk
        </a>
 
        <div class="border-t border-gray-100 dark:border-slate-700"></div>
 
        {{-- Impor BIP → pindah halaman --}}
        <a href="{{ route('admin.penduduk.impor-bip') }}" @click="open = false"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            Impor BIP
        </a>
 
        {{-- Ekspor Penduduk → langsung download --}}
        <a href="{{ route('admin.penduduk.export.excel', request()->query()) }}"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Ekspor Penduduk
        </a>
 
        {{-- Ekspor Penduduk Huruf → langsung download --}}
        <a href="/admin/penduduk/eksport-huruf{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-200
               hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Ekspor Penduduk Huruf
        </a>
    </div>
</div>

            </div>

            {{-- ════ BARIS FILTER ════ --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <form method="GET" action="{{ route('admin.penduduk') }}" id="form-filter"
                    class="flex flex-wrap items-center gap-2">

                    <input type="hidden" name="status" id="val-status" value="{{ request('status') }}">
                    <input type="hidden" name="status_hidup" id="val-status_hidup"
                        value="{{ request('status_hidup') }}">
                    <input type="hidden" name="jenis_kelamin" id="val-jenis_kelamin"
                        value="{{ request('jenis_kelamin') }}">
                    <input type="hidden" name="dusun" id="val-dusun" value="{{ request('dusun') }}">

                    {{-- 1. Status Penduduk --}}
                    <div class="relative w-52" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('status') }}',
                        placeholder: 'Pilih Status Penduduk',
                        options: [
                            { value: '1', label: 'Tetap' },
                            { value: '2', label: 'Tidak Tetap' },
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
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                       bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="[
                                open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                            ]">
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
                            class="absolute left-0 top-full mt-1 w-full z-[100]
                        bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                        rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari status..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200
                                  dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none
                                  focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua Status
                                </li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors
                                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                   hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- 2. Status Dasar --}}
                    <div class="relative w-52" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('status_hidup') }}',
                        placeholder: 'Pilih Status Dasar',
                        options: [
                            { value: 'hidup', label: 'Hidup' },
                            { value: 'mati', label: 'Mati' },
                            { value: 'pindah', label: 'Pindah' },
                            { value: 'hilang', label: 'Hilang' },
                            { value: 'pergi', label: 'Pergi' },
                            { value: 'tidak_valid', label: 'Tidak Valid' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-status_hidup').value = opt.value; // ← BENAR
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-status_hidup').value = ''; // ← BENAR
                            this.open = false;
                            this.search = '';
                            document.getElementById('form-filter').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                       bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="[
                                open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                            ]">
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
                            class="absolute left-0 top-full mt-1 w-full z-[100]
                        bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                        rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari status dasar..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200
                                  dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none
                                  focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua Status Dasar
                                </li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors
                                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                   hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- 3. Jenis Kelamin --}}
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
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
       bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="[
                                open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                            ]">
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
                            class="absolute left-0 top-full mt-1 w-full z-[100]
    bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
    rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari jenis kelamin..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200
              dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none
              focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors
           hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua
                                </li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors
               hover:bg-emerald-50 dark:hover:bg-emerald-900/20
               hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- 4. Dusun --}}
                    <div class="relative w-44" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('dusun') }}',
                        placeholder: 'Pilih Dusun',
                        options: [
                            @foreach ($dusunList ?? [] as $dusun)
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
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer
                       bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="[
                                open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                            ]">
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
                            class="absolute left-0 top-full mt-1 w-full z-[100]
                        bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                        rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari dusun..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200
                                  dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none
                                  focus:border-emerald-500">
                            </div>
                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === '' ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-400 dark:text-slate-500 italic'">
                                    Semua Dusun
                                </li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors
                                   hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                   hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- Badge NIK Sementara --}}
                    @if (request()->boolean('nik_sementara'))
                        <a href="{{ route('admin.penduduk', request()->except('nik_sementara', 'page')) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm
                               bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300
                               rounded-lg border border-sky-300 dark:border-sky-700 hover:bg-sky-200 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            NIK Sementara
                        </a>
                    @endif

                    {{-- Reset Filter --}}
                    @if (request()->hasAny([
                            'status',
                            'status_hidup',
                            'jenis_kelamin',
                            'dusun',
                            'search',
                            'nik_sementara',
                            'umur_dari',
                            'umur_sampai',
                            'pekerjaan_id',
                            'status_kawin_id',
                            'agama_id',
                            'pendidikan_kk_id',
                            'golongan_darah_id',
                            'program_bantuan_id',
                            'kumpulan_nik',
                        ]))
                        <a href="{{ route('admin.penduduk') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-2 text-sm text-red-600 dark:text-red-400
                               hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors
                               border border-red-200 dark:border-red-800">
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

                {{-- Tampilkan X entri — custom Alpine dropdown --}}
                <form method="GET" action="{{ route('admin.penduduk') }}" id="form-per-page"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page" value="{{ request('per_page', 10) }}">

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
                            document.getElementById('val-per-page').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer
               bg-white dark:bg-slate-700 focus:outline-none transition-colors"
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
                            class="absolute left-0 top-full mt-1 w-full z-[100]
                bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <ul class="py-1">
                                <template x-for="opt in options" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors
                           hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                           hover:text-emerald-700 dark:hover:text-emerald-400"
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
                <form method="GET" action="{{ route('admin.penduduk') }}" class="flex items-center gap-2">
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

            {{-- ════ TABEL DATA ════ --}}
            {{-- overflow-x: auto TAPI overflow-y: visible → dropdown bisa keluar --}}
            <div style="overflow-x: auto; overflow-y: visible;">
                <table class="w-full text-sm" style="min-width: 1600px;">
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
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">
                                FOTO</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                TAG ID CARD</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NAMA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NO. KK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                SHDK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NAMA AYAH</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NAMA IBU</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NO. RUMAH TANGGA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                JK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                ALAMAT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                DUSUN</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                RW</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                RT</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                PENDIDIKAN</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                UMUR</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                PEKERJAAN</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                KAWIN</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                STATUS</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                TGL PERISTIWA</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                TGL TERDAFTAR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($penduduk as $index => $p)
                            @php
                                $keluargaP = $p->keluarga;
                                $rumahTanggaP = $keluargaP?->rumahTangga;
                                $wilayahP = $p->wilayah;
                                $fotoSrc = $p->foto_url ?? ($p->foto ? asset('storage/' . $p->foto) : null);
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $p->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- Checkbox --}}
                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $p->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- Nomor --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums">
                                    {{ $penduduk->firstItem() + $index }}
                                </td>

                                {{-- ════ AKSI — tombol trigger portal dropdown ════ --}}
                                <td class="px-3 py-3">
                                    <button class="btn-aksi" data-penduduk-id="{{ $p->id }}"
                                        onclick="toggleAksiDropdown(this, event)" type="button">
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
                                    @if ($fotoSrc)
                                        <img src="{{ $fotoSrc }}" alt="{{ $p->nama }}"
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

                                {{-- NIK --}}
                                <td class="px-3 py-3 font-mono font-semibold whitespace-nowrap">
                                    <a href="{{ route('admin.penduduk.show', $p) }}"
                                        class="{{ $p->is_nik_sementara ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400' }} hover:underline">
                                        {{ $p->nik }}
                                    </a>
                                    @if ($p->is_nik_sementara)
                                        <span class="ml-1 text-xs text-red-400">(sementara)</span>
                                    @endif
                                </td>

                                {{-- TAG ID CARD --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400">{{ $p->tag_id_card ?: '-' }}</td>

                                {{-- NAMA --}}
                                <td class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 whitespace-nowrap">
                                    {{ $p->nama }}</td>

                                {{-- NO. KK --}}
                                <td class="px-3 py-3 font-mono text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    @if ($keluargaP)
                                        <a href="{{ route('admin.keluarga.show', $keluargaP) }}"
                                            class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            {{ $keluargaP->no_kk }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500">-</span>
                                    @endif
                                </td>

                                {{-- SHDK --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">
                                    {{ $p->shdk?->nama ?? '-' }}</td>

                                {{-- NAMA AYAH --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $p->nama_ayah ?: '-' }}</td>

                                {{-- NAMA IBU --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $p->nama_ibu ?: '-' }}</td>

                                {{-- NO. RUMAH TANGGA --}}
                                <td class="px-3 py-3 font-mono text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $rumahTanggaP?->no_rumah_tangga ?? '-' }}</td>

                                {{-- JK --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                </td>

                                {{-- ALAMAT --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 max-w-[200px] truncate"
                                    title="{{ $p->alamat }}">{{ $p->alamat ?: '-' }}</td>

                                {{-- DUSUN --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $wilayahP?->dusun ?? '-' }}</td>

                                {{-- RW --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">
                                    {{ $wilayahP?->rw ?? '-' }}</td>

                                {{-- RT --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">
                                    {{ $wilayahP?->rt ?? '-' }}</td>

                                {{-- PENDIDIKAN --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">
                                    {{ $p->pendidikanKk?->nama ?? ($p->pendidikan_lama ?? '-') }}</td>

                                {{-- UMUR --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 text-center">{{ $p->umur ?? '-' }}
                                </td>

                                {{-- PEKERJAAN --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">
                                    {{ $p->pekerjaan?->nama ?? ($p->pekerjaan_lama ?? '-') }}</td>

                                {{-- STATUS KAWIN --}}
                                <td class="px-3 py-3 text-gray-600 dark:text-slate-300 whitespace-nowrap text-xs">
                                    {{ $p->statusKawin?->nama ?? ($p->status_kawin_lama ?? '-') }}</td>

                                {{-- STATUS DASAR --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @php
                                        $statusColor = match ($p->status_hidup) {
                                            'hidup'
                                                => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                            'mati' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                            'pindah'
                                                => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'hilang'
                                                => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                            default => 'bg-gray-100 text-gray-500',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                        {{ $p->label_status_dasar }}
                                    </span>
                                </td>

                                {{-- TGL PERISTIWA --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $p->tgl_peristiwa?->format('d M Y') ?? '-' }}</td>

                                {{-- TGL TERDAFTAR --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $p->tgl_terdaftar?->format('d M Y') ?? $p->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="24" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang
                                            tersedia</p>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm">Silakan tambah data penduduk
                                            baru</p>
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
                    @if ($penduduk->total() > 0)
                        Menampilkan {{ $penduduk->firstItem() }}–{{ $penduduk->lastItem() }} dari
                        {{ number_format($penduduk->total()) }} entri
                    @else
                        Menampilkan 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($penduduk->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $penduduk->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif

                    @php
                        $currentPage = $penduduk->currentPage();
                        $lastPage = $penduduk->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                    @endphp
                    @if ($start > 1)
                        <a href="{{ $penduduk->appends(request()->query())->url(1) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">1</a>
                        @if ($start > 2)
                            <span class="px-1 text-gray-400 dark:text-slate-500">…</span>
                        @endif
                    @endif
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $penduduk->appends(request()->query())->url($page) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $page }}</a>
                        @endif
                    @endfor
                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="px-1 text-gray-400 dark:text-slate-500">…</span>
                        @endif
                        <a href="{{ $penduduk->appends(request()->query())->url($lastPage) }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $lastPage }}</a>
                    @endif

                    @if ($penduduk->hasMorePages())
                        <a href="{{ $penduduk->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 dark:text-slate-500 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>

        @include('admin.partials.modal-hapus')
        @include('admin.partials.modal-cetak-unduh-penduduk')

        {{-- ══════════════════════════════════════════════════════════════
         DROPDOWN PORTAL — dirender di luar tabel, posisi fixed
         Satu elemen per penduduk, di-populate saat tombol diklik
    ══════════════════════════════════════════════════════════════ --}}
        <div id="aksi-dropdown-portal" class="aksi-dropdown-portal">
            {{-- Isinya di-inject oleh JS saat tombol diklik --}}
        </div>

        {{-- Data aksi per baris (JSON) — dibaca oleh JS --}}
        <script>
            // Map penduduk_id → URL-URL aksi
            var pendudukAksiMap = {
                @foreach ($penduduk as $p)
                    "{{ $p->id }}": {
                        urlDetail: "{{ route('admin.penduduk.show', $p) }}",
                        urlEdit: "{{ route('admin.penduduk.edit', $p) }}",
                        urlLokasi: "{{ route('admin.penduduk.lokasi', $p) }}",
                        urlUbahStatus: @if ($p->status_hidup === 'hidup')
                            "{{ route('admin.penduduk.show', $p) }}#ubah-status"
                        @else
                            null
                        @endif ,
                        urlCetak: "{{ route('admin.penduduk.cetak-biodata', $p) }}",
                        urlDokumen: "{{ route('admin.penduduk.dokumen', $p) }}",
                        urlHapus: "{{ route('admin.penduduk.destroy', $p) }}",
                        nama: "{{ addslashes($p->nama) }}",
                        statusHidup: {{ $p->status_hidup === 'hidup' ? 'true' : 'false' }},
                    },
                @endforeach
            };
        </script>

        {{-- ══════════════════════════════════════════════════════════════
         MODAL: PENCARIAN SPESIFIK
    ══════════════════════════════════════════════════════════════ --}}
        <div x-data="{
            show: false,
            openDrops: {},
            searches: {},
            initField(name) {
                if (!this.openDrops[name]) this.openDrops[name] = false;
                if (!this.searches[name]) this.searches[name] = '';
            },
            toggleDrop(name) {
                this.initField(name);
                this.openDrops[name] = !this.openDrops[name];
            },
            closeDrop(name) {
                this.openDrops[name] = false;
                this.searches[name] = '';
            }
        }" @open-pencarian-spesifik.window="show = true"
            @keydown.escape.window="show && (show = false)">
            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="show = false" style="display:none"></div>

            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[201] flex items-center justify-center p-4 overflow-y-auto" style="display:none">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl my-4" @click.stop>

                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pencarian Spesifik</h3>
                        <button @click="show = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form method="GET" action="{{ route('admin.penduduk') }}" id="form-pencarian-spesifik">
                        @foreach (request()->only(['per_page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach

                        <div class="px-6 py-4 max-h-[65vh] overflow-y-auto space-y-4">

                            {{-- Full Width: Nomor KK Sebelumnya --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Nomor
                                    KK Sebelumnya</label>
                                <input type="text" name="no_kk_sebelumnya" value="{{ request('no_kk_sebelumnya') }}"
                                    placeholder="Masukkan nomor KK sebelumnya"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>

                            {{-- Full Width: Umur --}}
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Umur</label>
                                <div class="flex gap-2">
                                    <input type="number" name="umur_dari" value="{{ request('umur_dari') }}"
                                        placeholder="Dari" min="0" max="150"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <input type="number" name="umur_sampai" value="{{ request('umur_sampai') }}"
                                        placeholder="Sampai" min="0" max="150"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">

                                    {{-- Custom Dropdown: Satuan Umur --}}
                                    <div class="relative w-28" x-data="{
                                        open: false,
                                        search: '',
                                        selected: '{{ request('umur_satuan', 'tahun') }}',
                                        options: [
                                            { value: 'tahun', label: 'Tahun' },
                                            { value: 'bulan', label: 'Bulan' }
                                        ],
                                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                        get filtered() {
                                            return !this.search ? this.options :
                                                this.options.filter(o =>
                                                    o.label.toLowerCase().includes(this.search.toLowerCase())
                                                );
                                        },
                                        choose(opt) {
                                            this.selected = opt.value;
                                            this.open = false;
                                            this.search = '';
                                        }
                                    }" @click.away="open = false">
                                        <button type="button" @click="open=!open" @keydown.escape="open=false"
                                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                                            <svg class="w-3 h-3 text-gray-400 transition-transform"
                                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open"
                                            class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                            style="display:none">
                                            <ul class="py-1">
                                                <template x-for="opt in filtered" :key="opt.value">
                                                    <li @click="choose(opt)" x-text="opt.label"
                                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                        :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                            'text-gray-700 dark:text-slate-200'">
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="umur_satuan" :value="selected">
                                    </div>
                                </div>
                            </div>

                            {{-- Full Width: Tanggal Lahir --}}
                            @once
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                            @endonce

                            <div x-data="{
                                useYear: {{ request('tanggal_lahir') && preg_match('/^\d{2}-\d{2}-\d{4}$/', request('tanggal_lahir')) ? 'true' : 'false' }},
                                fp: null,
                                init() { this.$nextTick(() => this.initPicker()); },
                                initPicker() {
                                    if (this.fp) { this.fp.destroy();
                                        this.fp = null; }
                                    this.fp = flatpickr(this.$refs.tglInput, {
                                        dateFormat: this.useYear ? 'd-m-Y' : 'd-m',
                                        allowInput: true,
                                        disableMobile: true,
                                    });
                                }
                            }">
                                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Tanggal
                                    Lahir</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" x-ref="tglInput" name="tanggal_lahir"
                                        value="{{ request('tanggal_lahir') }}"
                                        :placeholder="useYear ? 'DD-MM-YYYY' : 'DD-MM'"
                                        class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                   focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <input id="tanggal_lahir_use_year" type="checkbox" x-model="useYear"
                                            @change="$refs.tglInput.value = ''; initPicker();"
                                            class="border-gray-300 dark:border-slate-600 rounded text-emerald-600 focus:ring-emerald-500">
                                        <label for="tanggal_lahir_use_year"
                                            class="text-xs text-gray-600 dark:text-slate-400 whitespace-nowrap cursor-pointer">Tahun</label>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    Klik input untuk memilih hari &amp; bulan. Centang "Tahun" untuk memilih tanggal
                                    lengkap.
                                </p>
                            </div>

                            {{-- Grid 2 Kolom --}}
                            <div class="grid grid-cols-2 gap-4">

                                {{-- Pekerjaan --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('pekerjaan_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refPekerjaan ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Pekerjaan</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="pekerjaan_id" :value="selected">
                                </div>

                                {{-- Status Perkawinan --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('status_kawin_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refStatusKawin ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Status
                                        Perkawinan</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="status_kawin_id" :value="selected">
                                </div>

                                {{-- Hubungan Keluarga (SHDK) --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('shdk_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refShdk ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Hubungan
                                        Keluarga (SHDK)</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="shdk_id" :value="selected">
                                </div>

                                {{-- Agama --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('agama_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refAgama ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Agama</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="agama_id" :value="selected">
                                </div>

                                {{-- Pendidikan Dalam KK --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('pendidikan_kk_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refPendidikan ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Pendidikan
                                        Dalam KK</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="pendidikan_kk_id" :value="selected">
                                </div>

                                {{-- Status Penduduk --}}
                                <div x-data="{
                                    open: false,
                                    selected: '{{ request('status') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        { value: '1', label: 'Tetap' },
                                        { value: '2', label: 'Tidak Tetap' },
                                        { value: '3', label: 'Pendatang' }
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Status
                                        Penduduk</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in options" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="status" :value="selected">
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div x-data="{
                                    open: false,
                                    selected: '{{ request('jenis_kelamin') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        { value: 'L', label: 'Laki-laki' },
                                        { value: 'P', label: 'Perempuan' }
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Jenis
                                        Kelamin</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in options" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="jenis_kelamin" :value="selected">
                                </div>

                                {{-- Status Dasar / Status Hidup --}}
                                <div x-data="{
                                    open: false,
                                    selected: '{{ request('status_hidup') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        { value: 'hidup', label: 'Hidup' },
                                        { value: 'mati', label: 'Mati' },
                                        { value: 'pindah', label: 'Pindah' },
                                        { value: 'hilang', label: 'Hilang' },
                                        { value: 'pergi', label: 'Pergi' },
                                        { value: 'tidak_valid', label: 'Tidak Valid' }
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Status
                                        Dasar</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in options" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="status_hidup" :value="selected">
                                </div>

                                {{-- Warga Negara --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('warganegara_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refWarganegara ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Warga
                                        Negara</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="warganegara_id" :value="selected">
                                </div>

                                {{-- Golongan Darah --}}
                                <div x-data="{
                                    open: false,
                                    search: '',
                                    selected: '{{ request('golongan_darah_id') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        @foreach ($refGolDarah ?? [] as $ref)
                                            { value: '{{ $ref->id }}', label: '{{ addslashes($ref->nama) }}' }, @endforeach
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    get filtered() {
                                        return !this.search ? this.options :
                                            this.options.filter(o =>
                                                o.label.toLowerCase().includes(this.search.toLowerCase())
                                            );
                                    },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                        this.search = '';
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Golongan
                                        Darah</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                            <input type="text" x-model="search" placeholder="Cari..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filtered" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="golongan_darah_id" :value="selected">
                                </div>

                                {{-- Kepemilikan Tag ID Card --}}
                                <div x-data="{
                                    open: false,
                                    selected: '{{ request('has_tag_id_card') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        { value: '1', label: 'Ya' },
                                        { value: '0', label: 'Tidak' }
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Kepemilikan
                                        Tag ID Card</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in options" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="has_tag_id_card" :value="selected">
                                </div>

                                {{-- Kepemilikan KK --}}
                                <div x-data="{
                                    open: false,
                                    selected: '{{ request('has_kk') }}',
                                    options: [
                                        { value: '', label: '--' },
                                        { value: '1', label: 'Ya' },
                                        { value: '0', label: 'Tidak' }
                                    ],
                                    get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                    choose(opt) {
                                        this.selected = opt.value;
                                        this.open = false;
                                    }
                                }" @click.away="open = false" class="relative">
                                    <label
                                        class="block text-xs font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Kepemilikan
                                        KK</label>
                                    <button type="button" @click="open=!open" @keydown.escape="open=false"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span x-text="label || '--'"
                                            :class="label ? 'text-gray-700 dark:text-slate-200' :
                                                'text-gray-400 dark:text-slate-500'"></span>
                                        <svg class="w-3 h-3 text-gray-400 transition-transform"
                                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                        style="display:none">
                                        <ul class="py-1">
                                            <template x-for="opt in options" :key="opt.value">
                                                <li @click="choose(opt)" x-text="opt.label"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                                    :class="selected === opt.value ? 'bg-emerald-500 text-white' :
                                                        'text-gray-700 dark:text-slate-200'">
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="has_kk" :value="selected">
                                </div>
                            </div>
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

        {{-- ══════════════════════════════════════════════════════════════
         MODAL: PENCARIAN PROGRAM BANTUAN
    ══════════════════════════════════════════════════════════════ --}}
        <div x-data="{
            show: false,
            open: false,
            search: '',
            selected: '{{ request('program_bantuan_id') }}',
            options: [
                { value: '', label: 'Penduduk Penerima Bantuan' },
                { value: 'bukan', label: 'Penduduk Bukan Penerima Bantuan' },
                @foreach ($programBantuanList ?? [] as $p)
                    { value: '{{ $p->id }}', label: '{{ addslashes($p->nama) }}' }, @endforeach
            ],
            get label() {
                return this.options.find(o => o.value === this.selected)?.label ?? '';
            },
            get filtered() {
                return !this.search ? this.options :
                    this.options.filter(o =>
                        o.label.toLowerCase().includes(this.search.toLowerCase())
                    );
            },
            choose(opt) {
                this.selected = opt.value;
                this.open = false;
                this.search = '';
            }
        }" @open-program-bantuan.window="show = true"
            @keydown.escape.window="show && (show = false)">
            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="show = false" style="display:none"></div>

            <div x-show="show" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
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
                    <form method="GET" action="{{ route('admin.penduduk') }}">
                        @foreach (request()->only(['per_page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <div class="px-6 py-5">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Program
                                Bantuan</label>

                            {{-- Custom Alpine Dropdown --}}
                            <div class="relative w-full" @click.away="open = false">
                                <button type="button" @click="open=!open" @keydown.escape="open=false"
                                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                    <span x-text="label || 'Pilih Program Bantuan'"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                </button>
                                <div x-show="open"
                                    class="absolute z-[300] top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" placeholder="Cari program..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                    </div>
                                    <ul class="max-h-40 overflow-y-auto py-1">
                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)" x-text="opt.label"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-500' :
                                                    'text-gray-700 dark:text-slate-200'">
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            <input type="hidden" name="program_bantuan_id" :value="selected">
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

        {{-- ══════════════════════════════════════════════════════════════
         MODAL: PILIHAN KUMPULAN NIK
    ══════════════════════════════════════════════════════════════ --}}
        <div x-data="{
            show: false,
            search: '',
            selectedNiks: [],
            openDrop: false,
            niksData: [
                @foreach ($penduduk ?? [] as $p)
                    { nik: '{{ $p->nik }}', nama: '{{ addslashes($p->nama) }}' }, @endforeach
            ],
            get filteredNiks() {
                return !this.search ? this.niksData :
                    this.niksData.filter(n =>
                        n.nik.toLowerCase().includes(this.search.toLowerCase()) ||
                        n.nama.toLowerCase().includes(this.search.toLowerCase())
                    );
            },
            addNik(nik) {
                if (!this.selectedNiks.includes(nik)) {
                    this.selectedNiks.push(nik);
                }
            },
            removeNik(nik) {
                this.selectedNiks = this.selectedNiks.filter(n => n !== nik);
            },
            submitForm() {
                document.getElementById('hidden-kumpulan').value = this.selectedNiks.join(',');
                document.getElementById('form-kumpulan-nik').submit();
            }
        }" @open-kumpulan-nik.window="show = true"
            @keydown.escape.window="show && (show = false)">
            <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
                x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
                @click="show = false" style="display:none"></div>

            <div x-show="show" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                        <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Pilihan Kumpulan NIK</h3>
                        <button @click="show = false"
                            class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form method="GET" action="{{ route('admin.penduduk') }}" id="form-kumpulan-nik">
                        @foreach (request()->only(['per_page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <input type="hidden" id="hidden-kumpulan" name="kumpulan_nik">

                        <div class="px-6 py-5 space-y-4">
                            {{-- Mode: Pilih dari Daftar (Hanya Mode Dropdown) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kumpulan
                                    NIK</label>

                                {{-- Custom Dropdown --}}
                                <div class="relative mb-3" @click.away="openDrop = false">
                                    <button type="button" @click="openDrop=!openDrop"
                                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                                        :class="openDrop ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                        <span class="text-gray-400 dark:text-slate-500"
                                            x-text="openDrop ? 'Ketik untuk mencari...' : 'Cari NIK atau nama...'"></span>
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
                                            <input type="text" x-model="search" placeholder="Cari NIK atau nama..."
                                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500">
                                        </div>
                                        <ul class="max-h-40 overflow-y-auto py-1">
                                            <template x-for="opt in filteredNiks" :key="opt.nik">
                                                <li @click="addNik(opt.nik); search=''; openDrop=false"
                                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 text-gray-700 dark:text-slate-200"
                                                    x-text="opt.nik + ' - ' + opt.nama"></li>
                                            </template>
                                            <li x-show="filteredNiks.length === 0"
                                                class="px-3 py-2 text-xs text-gray-400 italic">Tidak ada data</li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Selected NIKs as Tags --}}
                                <div
                                    class="p-3 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg min-h-10">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="nik in selectedNiks" :key="nik">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-500 text-white text-xs font-semibold rounded-full">
                                                <span x-text="nik"></span>
                                                <button type="button" @click="removeNik(nik)"
                                                    class="hover:text-emerald-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>
                                        <span x-show="selectedNiks.length === 0"
                                            class="text-xs text-gray-400 italic">Belum ada NIK yang dipilih</span>
                                    </div>
                                </div>
                            </div>
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
                            <button type="button" @click="submitForm()"
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

    </div>{{-- /x-data penutup wrapper alpine utama --}}

    {{-- ══════════════════════════════════════════════════════════════
     JAVASCRIPT — Dropdown Portal Engine
    ══════════════════════════════════════════════════════════════ --}}
    <script>
        (function() {
            'use strict';

            var portal = document.getElementById('aksi-dropdown-portal');
            var activeBtn = null; // tombol yang sedang aktif
            var hapusAction = null; // menyimpan action hapus sementara

            /* ─── Build HTML isi dropdown berdasarkan data penduduk ─── */
            function buildDropdownHtml(data) {
                var html = '';

                // Lihat Detail
                html += '<a href="' + data.urlDetail + '" class="aksi-item">' +
                    svgIcon(
                        'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
                        '#10b981') +
                    'Lihat Detail Biodata Penduduk</a>';

                // Ubah Biodata
                html += '<a href="' + data.urlEdit + '" class="aksi-item aksi-item-amber">' +
                    svgIcon(
                        'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                        '#f59e0b') +
                    'Ubah Biodata Penduduk</a>';

                // Lihat Lokasi
                html += '<a href="' + data.urlLokasi + '" class="aksi-item aksi-item-teal">' +
                    svgIcon(
                        'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
                        '#14b8a6') +
                    'Lihat Lokasi Tempat Tinggal</a>';

                // Ubah Status (hanya jika hidup)
                if (data.statusHidup && data.urlUbahStatus) {
                    html += '<a href="' + data.urlUbahStatus + '" class="aksi-item aksi-item-orange">' +
                        svgIcon('M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4', '#f97316') +
                        'Ubah Status Dasar</a>';
                }

                html += '<div class="aksi-divider"></div>';

                // Cetak Biodata
                html += '<a href="' + data.urlCetak + '" target="_blank" class="aksi-item aksi-item-blue">' +
                    svgIcon(
                        'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z',
                        '#3b82f6') +
                    'Cetak Biodata Penduduk</a>';

                // Upload Dokumen
                html += '<a href="' + data.urlDokumen + '" class="aksi-item aksi-item-indigo">' +
                    svgIcon('M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12',
                        '#6366f1') +
                    'Upload Dokumen Penduduk</a>';

                html += '<div class="aksi-divider"></div>';

                // Hapus
                html += '<button type="button" class="aksi-item aksi-item-red" data-hapus-action="' + data.urlHapus +
                    '" data-hapus-nama="' + escHtml(data.nama) + '" onclick="triggerHapus(this)">' +
                    svgIcon(
                        'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                        '#ef4444') +
                    'Hapus</button>';

                return html;
            }

            function svgIcon(path, color) {
                return '<svg style="width:13px;height:13px;flex-shrink:0;color:' + color +
                    ';" fill="none" stroke="currentColor" viewBox="0 0 24 24">' +
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' + path + '"/></svg>';
            }

            function escHtml(str) {
                return String(str).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g,
                    '&gt;');
            }

            /* ─── Posisikan portal dengan Smart Flip (Otomatis Atas/Bawah) ─── */
            function positionPortal(btn) {
                var rect = btn.getBoundingClientRect();
                var vpW = window.innerWidth;
                var vpH = window.innerHeight;

                // Tampil sementara (hidden) agar bisa mengukur dimensi asli
                portal.style.visibility = 'hidden';
                portal.style.display = 'block';

                // Reset styling dari perhitungan sebelumnya
                portal.style.maxHeight = 'none';
                portal.style.overflowY = 'hidden';

                var ddW = portal.offsetWidth;
                var ddH = portal.offsetHeight;

                // --- 1. Hitung Posisi Horizontal (Kiri/Kanan) ---
                var left = rect.left;
                if (left + ddW > vpW - 8) {
                    left = rect.right - ddW; // Jika mentok kanan, sejajarkan kanan dengan tombol
                }
                if (left < 4) left = 4; // Batas aman kiri

                // --- 2. Hitung Posisi Vertikal (Atas/Bawah) dengan Smart Flip ---
                var top = rect.bottom + 4; // Default: Buka ke bawah
                var spaceBelow = vpH - rect.bottom - 8; // Sisa ruang di bawah tombol
                var spaceAbove = rect.top - 8; // Sisa ruang di atas tombol

                // Jika tinggi menu lebih besar dari sisa ruang di bawah layar (Artinya mentok bawah)
                if (ddH > spaceBelow) {
                    // Cek apakah ruang di ATAS lebih besar daripada di BAWAH
                    if (spaceAbove > spaceBelow) {
                        // Buka ke ATAS tombol
                        top = rect.top - ddH - 4;

                        // Jika ternyata ruang di atas juga nggak muat semua, kasih batas max-height & scroll
                        if (ddH > spaceAbove) {
                            portal.style.maxHeight = spaceAbove + 'px';
                            portal.style.overflowY = 'auto';
                        }
                    } else {
                        // Jika ruang di bawah masih lebih besar dari atas (misal layar super sempit), 
                        // tetap di bawah tapi dibatasi dan kasih scroll
                        portal.style.maxHeight = spaceBelow + 'px';
                        portal.style.overflowY = 'auto';
                    }
                }

                // --- 3. Terapkan Posisi ---
                portal.style.top = top + 'px';
                portal.style.left = left + 'px';
                portal.style.visibility = 'visible';
            }

            /* ─── Toggle dropdown ─── */
            window.toggleAksiDropdown = function(btn, event) {
                event.stopPropagation();

                // Tutup jika klik tombol yang sama
                if (activeBtn === btn && portal.style.display === 'block') {
                    closePortal();
                    return;
                }

                var pid = btn.dataset.pendudukId;
                var data = pendudukAksiMap[pid];
                if (!data) return;

                // Isi konten
                portal.innerHTML = buildDropdownHtml(data);

                // Tandai tombol aktif
                if (activeBtn) activeBtn.classList.remove('active');
                activeBtn = btn;
                btn.classList.add('active');

                // Posisikan dan tampilkan
                positionPortal(btn);
            };

            /* ─── Trigger modal hapus (dipanggil dari dalam portal) ─── */
            window.triggerHapus = function(btnEl) {
                var action = btnEl.dataset.hapusAction;
                var nama = btnEl.dataset.hapusNama;
                closePortal();

                // Dispatch event Alpine modal-hapus (sesuai partial modal-hapus.blade.php)
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

            // Klik di luar → tutup
            document.addEventListener('click', function(e) {
                if (!portal.contains(e.target)) closePortal();
            });

            // Scroll/resize → tutup
            window.addEventListener('scroll', closePortal, true);
            window.addEventListener('resize', closePortal);

            // Escape → tutup
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closePortal();
            });

        })();
    </script>

@endsection
