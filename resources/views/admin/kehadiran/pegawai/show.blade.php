@extends('layouts.admin')

@section('title', 'Detail Pegawai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-teal-600 via-teal-600 to-emerald-600">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-white/30 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300">
                            </div>
                            <div
                                class="relative w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Detail Data Pegawai</h1>
                            <p class="text-teal-100 text-sm font-medium">Informasi lengkap pegawai {{
                                $pegawai->nama_lengkap }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.pegawai.index') }}"
                        class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-5 py-3 rounded-xl font-semibold border border-white/30 shadow-lg hover:bg-white/30 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-50 via-teal-50 to-emerald-50 px-8 py-8 border-b-2 border-slate-100">
                <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8">
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-all duration-300">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-3xl bg-gradient-to-br from-teal-600 to-emerald-700 flex items-center justify-center text-white font-bold text-4xl shadow-2xl border-4 border-white">
                            {{ strtoupper(substr($pegawai->nama_lengkap, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-slate-900 mb-3">{{ $pegawai->nama_lengkap }}</h2>
                        <div class="flex flex-wrap gap-3">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ ucfirst($pegawai->status_kepegawaian) }}
                            </span>
                            @if($pegawai->status_aktif == 'aktif')
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Status Aktif
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-slate-100 to-gray-100 text-slate-700 border border-slate-200/50 shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Tidak Aktif
                            </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
                        class="group relative px-8 py-4 bg-gradient-to-r from-amber-600 via-orange-600 to-rose-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-amber-700 via-orange-700 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative flex items-center gap-2">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Data
                        </div>
                    </a>
                </div>
            </div>

            <!-- Detail Information -->
            <div class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Data Identitas -->
                    <div class="space-y-6">
                        <div
                            class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border-2 border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Data Identitas</h3>
                                    <p class="text-sm text-slate-600 font-medium">Informasi identitas pegawai</p>
                                </div>
                            </div>

                            <dl class="space-y-5">
                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        NIK
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->nik }}</dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                        NIP
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->nip ?? '-' }}</dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Nama Lengkap
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->nama_lengkap }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Data Kontak -->
                        <div
                            class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border-2 border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Data Kontak</h3>
                                    <p class="text-sm text-slate-600 font-medium">Informasi kontak pegawai</p>
                                </div>
                            </div>

                            <dl class="space-y-5">
                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        Nomor Telepon
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->nomor_telepon ?? '-' }}
                                    </dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Alamat Lengkap
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900 leading-relaxed">{{ $pegawai->alamat
                                        ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Right Column - Data Kepegawaian -->
                    <div class="space-y-6">
                        <div
                            class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border-2 border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Data Kepegawaian</h3>
                                    <p class="text-sm text-slate-600 font-medium">Informasi jabatan dan unit kerja</p>
                                </div>
                            </div>

                            <dl class="space-y-5">
                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Jabatan
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->jabatan ?? '-' }}</dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        Unit Kerja
                                    </dt>
                                    <dd class="text-base font-bold text-slate-900">{{ $pegawai->unit_kerja ?? '-' }}
                                    </dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Status Kepegawaian
                                    </dt>
                                    <dd>
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                            {{ ucfirst($pegawai->status_kepegawaian) }}
                                        </span>
                                    </dd>
                                </div>

                                <div
                                    class="group hover:bg-white hover:shadow-md rounded-xl p-4 transition-all duration-200 -mx-4">
                                    <dt class="text-sm font-bold text-slate-500 mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Status Aktif
                                    </dt>
                                    <dd>
                                        @if($pegawai->status_aktif == 'aktif')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Aktif
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-bold bg-gradient-to-r from-slate-100 to-gray-100 text-slate-700 border border-slate-200/50 shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Tidak Aktif
                                        </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Quick Actions -->
                        <div
                            class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 border-2 border-slate-100 shadow-sm">
                            <div class="flex items-center gap-4 mb-5">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Aksi Cepat</h3>
                                    <p class="text-sm text-slate-600 font-medium">Tindakan yang dapat dilakukan</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}"
                                    class="group flex items-center justify-between w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-xl hover:border-amber-500 hover:shadow-lg transition-all duration-200">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center group-hover:from-amber-200 group-hover:to-orange-200 transition-colors">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">Edit Data Pegawai</p>
                                            <p class="text-xs text-slate-500 font-medium">Ubah informasi pegawai</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.pegawai.index') }}"
                                    class="group flex items-center justify-between w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-xl hover:border-emerald-500 hover:shadow-lg transition-all duration-200">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center group-hover:from-emerald-200 group-hover:to-teal-200 transition-colors">
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 text-sm">Daftar Pegawai</p>
                                            <p class="text-xs text-slate-500 font-medium">Kembali ke halaman daftar</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection
