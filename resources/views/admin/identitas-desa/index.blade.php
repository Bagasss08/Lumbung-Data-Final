@extends('layouts.admin')

@section('title', 'Identitas Desa')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Identitas Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola informasi identitas dan profil desa</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Identitas Desa</span>
        </nav>
        <a href="{{ route('admin.identitas-desa.edit') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Data Desa
        </a>
    </div>
</div>

<!-- Hero Card -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 shadow-2xl mb-6">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')">
        </div>
    </div>
    @if($desa && $desa->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
    <div class="absolute inset-0 bg-cover bg-center opacity-20"
        style="background-image: url('{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}')"></div>
    @endif
    <div class="relative px-8 py-10">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                <div class="w-28 h-28 rounded-2xl bg-white/20 backdrop-blur-md border-4 border-white/30 shadow-2xl p-3 flex items-center justify-center overflow-hidden">
                    @if($desa && $desa->logo_desa && file_exists(storage_path('app/public/logo-desa/'.$desa->logo_desa)))
                    <img src="{{ asset('storage/logo-desa/'.$desa->logo_desa) }}" class="w-full h-full object-contain" alt="Logo Desa">
                    @else
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    @endif
                </div>
            </div>
            <div class="flex-1 text-center md:text-left">
                <p class="text-emerald-200 text-xs font-medium uppercase tracking-widest mb-1">Sistem Informasi Desa</p>
                <h2 class="text-3xl font-bold text-white mb-3">{{ $desa->nama_desa ?? 'Nama Desa Belum Diatur' }}</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 text-white/90 text-sm mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Kec. {{ $desa->kecamatan ?? '-' }}
                    </span>
                    <span class="text-white/60">•</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">Kab. {{ $desa->kabupaten ?? '-' }}</span>
                    <span class="text-white/60">•</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">{{ $desa->provinsi ?? '-' }}</span>
                </div>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium text-white">Kepala Desa: <span class="font-bold">{{ $desa->kepala_desa ?? '-' }}</span></span>
                    </div>
                    {{-- Social Media Badge di Hero --}}
                    <div class="flex items-center gap-2">
                        @if($desa && $desa->facebook)
                            <a href="{{ $desa->facebook }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-blue-500/80 flex items-center justify-center transition-all" title="Facebook">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if($desa && $desa->instagram)
                            <a href="{{ $desa->instagram }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-pink-500/80 flex items-center justify-center transition-all" title="Instagram">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.665-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($desa && $desa->youtube)
                            <a href="{{ $desa->youtube }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-red-500/80 flex items-center justify-center transition-all" title="YouTube">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @if($desa && $desa->kode_desa)
            <div class="hidden md:flex flex-col items-end gap-1">
                <p class="text-emerald-200 text-xs">Kode Desa</p>
                <p class="text-white font-bold text-2xl tracking-widest">{{ $desa->kode_desa }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Identitas Desa Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Identitas Desa</h3>
                </div>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Nama Desa</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->nama_desa ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Kode Desa</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_desa ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Kode BPS Desa</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_bps_desa ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Kode Pos</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_pos ?? '-' }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Kepala Desa Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Kepala Desa</h3>
                </div>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">Nama Kepala Desa</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kepala_desa ?? '-' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500 mt-2 flex-shrink-0"></div>
                        <div class="flex-1">
                            <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide">NIP Kepala Desa</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->nip_kepala_desa ?? '-' }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Wilayah Administratif -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kecamatan -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kecamatan</h3>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Nama</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kecamatan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Kode</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_kecamatan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Camat</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->nama_camat ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">NIP Camat</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->nip_camat ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Kabupaten -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center shadow-lg shadow-orange-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kabupaten</h3>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Nama</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kabupaten ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Kode</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_kabupaten ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Provinsi -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/30 dark:to-blue-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-600 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Provinsi</h3>
                    </div>
                </div>
                <div class="p-4 space-y-3">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Nama Provinsi</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->provinsi ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400">Kode Provinsi</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900 dark:text-slate-100">{{ $desa->kode_provinsi ?? '-' }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- SOCIAL MEDIA CARD (BARU)                                      -->
        <!-- ============================================================ -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/30 dark:to-purple-900/30 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-600 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Media Sosial</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Facebook --}}
                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0 shadow">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">Facebook</p>
                            @if($desa && $desa->facebook)
                                <a href="{{ $desa->facebook }}" target="_blank" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline truncate block">{{ $desa->facebook }}</a>
                            @else
                                <span class="text-sm text-gray-400 dark:text-slate-500 italic">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center flex-shrink-0 shadow">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.665-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">Instagram</p>
                            @if($desa && $desa->instagram)
                                <a href="{{ $desa->instagram }}" target="_blank" class="text-sm font-semibold text-pink-600 dark:text-pink-400 hover:underline truncate block">{{ $desa->instagram }}</a>
                            @else
                                <span class="text-sm text-gray-400 dark:text-slate-500 italic">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    {{-- YouTube --}}
                    <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center flex-shrink-0 shadow">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">YouTube</p>
                            @if($desa && $desa->youtube)
                                <a href="{{ $desa->youtube }}" target="_blank" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:underline truncate block">{{ $desa->youtube }}</a>
                            @else
                                <span class="text-sm text-gray-400 dark:text-slate-500 italic">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Kontak Desa -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 dark:from-teal-900/30 dark:to-emerald-900/30 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Kontak Desa</h3>
                </div>
            </div>
            <div class="p-6 space-y-3">
                @php
                    $kontakItems = [
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Alamat Kantor', 'value' => $desa->alamat_kantor ?? '-'],
                        ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'label' => 'Email', 'value' => $desa->email_desa ?? '-'],
                        ['icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'label' => 'Telepon', 'value' => $desa->telepon_desa ?? '-'],
                        ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'label' => 'Ponsel', 'value' => $desa->ponsel_desa ?? '-'],
                        ['icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', 'label' => 'Website', 'value' => $desa->website_desa ?? '-'],
                    ];
                @endphp
                @foreach($kontakItems as $item)
                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-white dark:bg-slate-600 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-gray-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1">{{ $item['label'] }}</dt>
                        <dd class="text-sm font-medium text-gray-900 dark:text-slate-100 break-words">{{ $item['value'] }}</dd>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Peta Wilayah -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-slate-700/50 dark:to-slate-700/30 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-600 to-gray-600 flex items-center justify-center shadow-lg shadow-slate-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Peta Wilayah Desa</h3>
                </div>
            </div>
            <div class="p-4">
                @if($desa && $desa->link_peta)
                    <div class="w-full h-96 rounded-xl overflow-hidden shadow-inner border border-gray-100 dark:border-slate-700">
                        <iframe src="{{ $desa->link_peta }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                @else
                    <div class="w-full h-48 rounded-xl bg-gray-50 dark:bg-slate-700/50 border-2 border-dashed border-gray-200 dark:border-slate-600 flex flex-col items-center justify-center gap-2">
                        <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-400 dark:text-slate-500">Link Peta belum ditambahkan</p>
                        <a href="{{ route('admin.identitas-desa.edit') }}" class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">+ Tambah Sekarang</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Gambar Kantor -->
        @if($desa && $desa->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-slate-700/50 dark:to-slate-700/30 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kantor Desa</h3>
            </div>
            <div class="p-4">
                <img src="{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}" class="w-full rounded-xl object-cover shadow-lg" alt="Kantor Desa">
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
