@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')

    <p class="text-lg font-semibold text-gray-700 dark:text-slate-200 mb-1">Tentang Desa</p>
    <p class="text-sm text-gray-400 dark:text-slate-500 mb-6">Ringkasan data kependudukan dan layanan desa</p>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        {{-- Card 1: Wilayah Desa --}}
        <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Wilayah Desa</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($wilayahCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 2: Penduduk --}}
        <a href="/admin/penduduk"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Penduduk</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($pendudukCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-cyan-100 dark:bg-cyan-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-cyan-600 dark:text-cyan-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 3: Keluarga --}}
        <a href="/admin/keluarga"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Keluarga</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($keluargaCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-teal-600 dark:text-teal-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 4: Surat Tercetak --}}
        <a href="/admin/layanan-surat/cetak"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Surat Tercetak</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($suratCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-blue-600 dark:text-blue-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 5: Kelompok --}}
        <a href="/admin/kelompok"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Kelompok</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($kelompokCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 6: Rumah Tangga --}}
        <a href="{{ route('admin.rumah-tangga.index') }}"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Rumah Tangga</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($rumahTanggaCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-slate-600 dark:text-slate-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 7: Bantuan --}}
        <a href="/admin/bantuan"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Bantuan</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($bantuanCount ?? 0) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-sky-100 dark:bg-sky-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-sky-600 dark:text-sky-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

        {{-- Card 8: Verifikasi Layanan Mandiri --}}
        <a href="#"
            class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Verifikasi Layanan Mandiri</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">0</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700">
                <span class="text-sm text-violet-600 dark:text-violet-400 font-medium flex items-center gap-1">
                    Lihat Detail
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </a>

    </div>

@endsection