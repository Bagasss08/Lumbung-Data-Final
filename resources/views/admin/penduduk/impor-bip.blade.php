@extends('layouts.admin')

@section('title', 'Impor BIP')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Impor Data Kependudukan (BIP)</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Import Buku Induk Penduduk dari Disdukcapil</p>
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
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.penduduk') }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                Data Penduduk
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Impor BIP</span>
        </nav>
    </div>

    {{-- MODAL PERINGATAN (Alpine JS) --}}
    <div x-data="{ showWarning: false }" @keydown.escape.window="showWarning = false">

        {{-- Overlay --}}
        <div x-show="showWarning"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
            @click="showWarning = false"
            style="display:none"></div>

        {{-- Dialog Peringatan --}}
        <div x-show="showWarning"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[201] flex items-center justify-center p-4"
            style="display:none">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md text-center px-8 py-8" @click.stop>
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 rounded-full border-4 border-amber-400 flex items-center justify-center">
                        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-slate-100 mb-3">Peringatan</h3>
                <p class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed mb-6">
                    Impor BIP hanya bisa dilakukan ketika data penduduk belum ada. Proses ini akan menimpa seluruh data yang ada. Pastikan Anda sudah membuat backup data sebelum melanjutkan.
                </p>
                <div class="flex items-center justify-center gap-3">
                    <button type="button" @click="showWarning = false"
                        class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                        @click="showWarning = false; $nextTick(() => document.getElementById('form-impor-bip').submit())"
                        class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        {{-- CARD UTAMA --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

            {{-- Tombol Kembali --}}
            <div class="px-6 pt-6 pb-4 border-b border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.penduduk') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Ke Data Penduduk
                </a>
            </div>

            <div class="px-6 py-6 space-y-5">

                {{-- Peringatan Khusus BIP --}}
                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700 rounded-lg">
                    <p class="text-sm font-bold text-amber-800 dark:text-amber-300">
                        ⚠️ Penting: Impor BIP hanya bisa dilakukan ketika data penduduk belum ada
                    </p>
                </div>

                {{-- Deskripsi --}}
                <div class="text-sm text-gray-600 dark:text-slate-300 space-y-2">
                    <p>Proses ini untuk mengimpor data Buku Induk Penduduk (BIP) yang diperoleh dari Disdukcapil dalam format Excel.</p>
                    <p>BIP yang dapat dibaca proses ini adalah yang tersusun berdasarkan keluarga, seperti contoh yang dapat dilihat pada tautan berikut :</p>
                </div>

                {{-- Tombol Contoh BIP --}}
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.penduduk.impor-bip.contoh', 'bip2012') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Contoh BIP 2012
                    </a>
                    <a href="{{ route('admin.penduduk.impor-bip.contoh', 'bip2016') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Contoh BIP 2016
                    </a>
                    <a href="{{ route('admin.penduduk.impor-bip.contoh', 'bip-ektp') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Contoh BIP eKTP
                    </a>
                    <a href="{{ route('admin.penduduk.impor-bip.contoh', 'bip2016-luwu-timur') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Contoh BIP 2016 Luwu Timur
                    </a>
                    <a href="{{ route('admin.penduduk.impor-bip.contoh', 'data-siak') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Contoh Data SIAK
                    </a>
                </div>

                {{-- Info Tambahan --}}
                <p class="text-sm text-gray-600 dark:text-slate-300">
                    Proses ini mengimpor data keluarga di semua worksheet di berkas BIP. Misalnya, apabila data BIP tersusun menjadi satu worksheet per dusun, proses ini akan mengimpor data semua dusun.
                </p>

                {{-- Syarat Format --}}
                <div class="space-y-2">
                    <div class="flex items-start gap-2 text-sm">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">Pastikan berkas BIP format Excel 2003, ber-ekstensi .xls</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                        </svg>
                        <span class="text-red-600 dark:text-red-400 font-medium">Sebelum di-impor ganti semua format tanggal (seperti tanggal lahir) menjadi dd/mm/yyyy (misalnya 26/07/1964).</span>
                    </div>
                </div>

                {{-- Batas & Info Proses --}}
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg text-sm text-gray-600 dark:text-slate-300 space-y-1">
                    <p>Batas maksimal pengunggahan berkas <strong>2 MB</strong></p>
                    <p>Proses ini akan membutuhkan waktu beberapa menit, menyesuaikan dengan spesifikasi komputer server SID, banyaknya data dan sambungan internet yang tersedia.</p>
                </div>

                {{-- Form Upload --}}
                <form id="form-impor-bip"
                    method="POST"
                    action="{{ route('admin.penduduk.impor-bip.proses') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-slate-200 whitespace-nowrap">
                            Pilih File .xls:
                        </label>

                        <div class="flex items-center" x-data="{ fileName: '' }">
                            <input type="text" readonly
                                :value="fileName || ''"
                                placeholder="Belum ada file dipilih"
                                class="w-64 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-l-lg bg-gray-50 dark:bg-slate-700 text-sm text-gray-600 dark:text-slate-300 cursor-default">
                            <label class="inline-flex items-center gap-1.5 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-r-lg cursor-pointer transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Browse
                                <input type="file" name="file_bip" accept=".xls,.xlsx" class="sr-only"
                                    @change="fileName = $event.target.files[0]?.name ?? ''">
                            </label>
                        </div>

                        <button type="button" @click="showWarning = true"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Impor Data Penduduk
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>{{-- /x-data peringatan --}}

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="mt-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg text-sm text-emerald-700 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg text-sm text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

@endsection