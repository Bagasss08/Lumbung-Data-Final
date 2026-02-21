@extends('layouts.admin')

@section('title', 'Identitas Desa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Identitas Desa</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola informasi identitas dan profil desa</p>
        </div>
        <a href="{{ route('admin.identitas-desa.edit') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/30 transition-all duration-200 hover:shadow-xl hover:shadow-emerald-500/40 hover:scale-105">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Data Desa
        </a>
    </div>

    <!-- Hero Card with Background Image -->
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 shadow-2xl">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')">
            </div>
        </div>

        <!-- Kantor Desa Image Overlay (if exists) -->
        @if($desa && $desa->gambar_kantor &&
        file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
            style="background-image: url('{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}')"></div>
        @endif

        <div class="relative px-8 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- Logo Desa -->
                <div class="flex-shrink-0">
                    <div
                        class="w-32 h-32 rounded-2xl bg-white/20 backdrop-blur-md border-4 border-white/30 shadow-2xl p-4 flex items-center justify-center overflow-hidden">
                        @if($desa && $desa->logo_desa &&
                        file_exists(storage_path('app/public/logo-desa/'.$desa->logo_desa)))
                        <img src="{{ asset('storage/logo-desa/'.$desa->logo_desa) }}"
                            class="w-full h-full object-contain" alt="Logo Desa">
                        @else
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        @endif
                    </div>
                </div>

                <!-- Desa Info -->
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-4xl font-bold text-white mb-2">
                        {{ $desa->nama_desa ?? 'Nama Desa Belum Diatur' }}
                    </h2>
                    <div
                        class="flex flex-wrap items-center justify-center md:justify-start gap-2 text-white/90 text-sm mb-4">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Kec. {{ $desa->kecamatan ?? '-' }}
                        </span>
                        <span class="text-white/60">•</span>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                            Kab. {{ $desa->kabupaten ?? '-' }}
                        </span>
                        <span class="text-white/60">•</span>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                            {{ $desa->provinsi ?? '-' }}
                        </span>
                    </div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium text-white">Kepala Desa: <span class="font-bold">{{
                                $desa->kepala_desa ?? '-' }}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Identitas Desa Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Identitas Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Desa</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->nama_desa ?? '-' }}</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kode Desa</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->kode_desa ?? '-' }}</dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kode BPS Desa</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->kode_bps_desa ?? '-' }}
                                </dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kode Pos</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->kode_pos ?? '-' }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Kepala Desa Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Kepala Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Kepala Desa
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->kepala_desa ?? '-' }}
                                </dd>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-2"></div>
                            <div class="flex-1">
                                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">NIP Kepala Desa
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $desa->nip_kepala_desa ?? '-' }}
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Wilayah Administratif -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kecamatan -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Kecamatan</h3>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Nama</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->kecamatan ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Kode</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->kode_kecamatan ?? '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Camat</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->nama_camat ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">NIP Camat</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->nip_camat ?? '-' }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Kabupaten -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center shadow-lg shadow-orange-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Kabupaten</h3>
                        </div>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Nama</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->kabupaten ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Kode</dt>
                            <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->kode_kabupaten ?? '-' }}
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Provinsi -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-600 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Provinsi</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <dt class="text-xs font-medium text-gray-500">Nama Provinsi</dt>
                        <dd class="mt-0.5 text-sm font-semibold text-gray-900">{{ $desa->provinsi ?? '-' }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Contact Info -->
        <div class="space-y-6">
            <!-- Kontak Desa Card -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Kontak Desa</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Alamat -->
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Alamat Kantor
                            </dt>
                            <dd class="text-sm font-medium text-gray-900 break-words">{{ $desa->alamat_kantor ?? '-' }}
                            </dd>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Email</dt>
                            <dd class="text-sm font-medium text-gray-900 break-all">{{ $desa->email_desa ?? '-' }}</dd>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Telepon</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $desa->telepon_desa ?? '-' }}</dd>
                        </div>
                    </div>

                    <!-- Ponsel -->
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Ponsel</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $desa->ponsel_desa ?? '-' }}</dd>
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div
                            class="flex-shrink-0 w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Website</dt>
                            <dd class="text-sm font-medium text-gray-900 break-all">{{ $desa->website_desa ?? '-' }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gambar Kantor Preview -->
            @if($desa && $desa->gambar_kantor &&
            file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-200">
                    <h3 class="text-sm font-bold text-gray-900">Kantor Desa</h3>
                </div>
                <div class="p-4">
                    <img src="{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}"
                        class="w-full rounded-xl object-cover shadow-lg" alt="Kantor Desa">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection