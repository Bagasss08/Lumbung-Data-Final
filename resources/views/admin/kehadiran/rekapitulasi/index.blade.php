@extends('layouts.admin')

@section('title', 'Rekapitulasi Kehadiran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-500">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-white/30 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300">
                            </div>
                            <div
                                class="relative w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Rekapitulasi Kehadiran</h1>
                            <p class="text-teal-100 text-sm font-medium">Data gabungan kehadiran harian, bulanan &
                                tahunan pegawai</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.kehadiran.rekapitulasi.export.excel', request()->query()) }}"
                            class="group relative inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-5 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-green-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="relative">Excel</span>
                        </a>
                        <a href="{{ route('admin.kehadiran.rekapitulasi.export.pdf', request()->query()) }}"
                            class="group relative inline-flex items-center justify-center gap-2 bg-rose-600 text-white px-5 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-rose-700 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="relative">PDF</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="px-8 py-8 bg-gradient-to-br from-slate-50/50 to-white/50">
                <form method="GET" action="{{ route('admin.kehadiran.rekapitulasi.index') }}" id="formFilter">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">

                        <!-- Tab Tipe -->
                        <div class="lg:col-span-12">
                            <label class="block text-sm font-bold text-slate-700 mb-3">Tampilkan Data</label>
                            <div class="flex gap-2 flex-wrap">
                                <button type="button" onclick="setTipe('harian')"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-semibold text-sm transition-all duration-200 {{ $tipe === 'harian' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}"
                                    id="tab-harian">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Harian
                                </button>
                                <button type="button" onclick="setTipe('bulanan')"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-semibold text-sm transition-all duration-200 {{ $tipe === 'bulanan' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}"
                                    id="tab-bulanan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Bulanan
                                </button>
                                <button type="button" onclick="setTipe('tahunan')"
                                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl font-semibold text-sm transition-all duration-200 {{ $tipe === 'tahunan' ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}"
                                    id="tab-tahunan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Tahunan
                                </button>
                            </div>
                            <input type="hidden" name="tipe" id="inputTipe" value="{{ $tipe }}">
                        </div>

                        <!-- Filter HARIAN -->
                        <div class="lg:col-span-3" id="filterHarian"
                            style="{{ $tipe !== 'harian' ? 'display:none' : '' }}">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal</label>
                            <input type="date" name="tanggal"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 bg-white"
                                value="{{ $tanggal }}">
                        </div>

                        <!-- Filter BULANAN -->
                        <div class="lg:col-span-2" id="filterBulan"
                            style="{{ $tipe !== 'bulanan' ? 'display:none' : '' }}">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Bulan</label>
                            <select name="bulan"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 bg-white">
                                @foreach($namaBulan as $num => $nama)
                                <option value="{{ $num }}" {{ (int)$bulan===$num ? 'selected' : '' }}>{{ $nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter TAHUN (muncul di bulanan & tahunan) -->
                        <div class="lg:col-span-2" id="filterTahun"
                            style="{{ $tipe === 'harian' ? 'display:none' : '' }}">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun</label>
                            <select name="tahun"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 bg-white">
                                @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ (int)$tahun===$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Tombol -->
                        <div class="lg:col-span-5">
                            <div class="flex gap-3">
                                <button type="submit"
                                    class="group relative inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                    <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    <span class="relative">Filter</span>
                                </button>
                                <a href="{{ route('admin.kehadiran.rekapitulasi.index') }}"
                                    class="group relative inline-flex items-center justify-center gap-2 bg-white text-slate-600 px-6 py-3 rounded-xl font-semibold border border-slate-200 hover:bg-slate-50 transition-all duration-200 hover:scale-105">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ $tipe === 'harian' ? '6' : ($tipe === 'bulanan' ? '4' : '3') }} gap-6">
            @if($tipe === 'harian')
            <!-- Hadir -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Hadir</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['hadir'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Izin -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-emerald-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:shadow-xl group-hover:shadow-teal-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Izin</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['izin'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Sakit -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:shadow-xl group-hover:shadow-amber-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Sakit</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['sakit'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Alpha -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-red-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:shadow-xl group-hover:shadow-rose-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Alpha</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['alpha'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Cuti -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:shadow-xl group-hover:shadow-teal-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Cuti</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['cuti'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Dinas Luar -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-slate-500/5 to-gray-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-500 to-gray-600 flex items-center justify-center shadow-lg shadow-slate-500/30 group-hover:shadow-xl group-hover:shadow-slate-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Dinas Luar</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['dinas_luar'] }}</p>
                    </div>
                </div>
            </div>

            @elseif($tipe === 'bulanan')
            <!-- Total Hadir -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Total Hadir</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['hadir'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Izin -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-emerald-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30 group-hover:shadow-xl group-hover:shadow-teal-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Total Izin</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['izin'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Alpha -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-red-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:shadow-xl group-hover:shadow-rose-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 15.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Total Alpha</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['alpha'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Dinas Luar -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-slate-500/5 to-gray-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-slate-500 to-gray-600 flex items-center justify-center shadow-lg shadow-slate-500/30 group-hover:shadow-xl group-hover:shadow-slate-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0V8a2 2 0 01-2 2H8a2 2 0 01-2-2V6m8 0H8" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Dinas Luar</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['dinas_luar'] }}</p>
                    </div>
                </div>
            </div>

            @else
            <!-- Total Hadir -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Total Hadir</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['hadir'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Tidak Hadir -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-red-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:shadow-xl group-hover:shadow-rose-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 15.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Total Tidak Hadir</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $summary['alpha'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Pegawai Terdaftar -->
            <div
                class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div class="relative flex items-center gap-4">
                    <div
                        class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-purple-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 font-semibold mb-1">Pegawai Terdaftar</p>
                        <p class="text-3xl font-bold text-slate-900">{{ $rekapitulasi->count() }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <h6 class="text-lg font-bold text-slate-900">
                        @if($tipe === 'harian')
                        Data Kehadiran — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                        @elseif($tipe === 'bulanan')
                        Rekap Bulanan — {{ $namaBulan[(int)$bulan] }} {{ $tahun }}
                        @else
                        Rekap Tahunan — {{ $tahun }}
                        @endif
                    </h6>
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                        {{ $rekapitulasi->count() }} data
                    </span>
                </div>
            </div>
            <div class="overflow-x-auto">

                {{-- ==================== TABEL HARIAN ==================== --}}
                @if($tipe === 'harian')
                <table class="w-full">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nama Pegawai</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jabatan</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jam Masuk</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jam Pulang</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Metode Absen</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Lokasi</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rekapitulasi as $i => $row)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-sm font-bold text-slate-700 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                                    {{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative group/avatar">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity">
                                        </div>
                                        <div
                                            class="relative w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr(optional($row->pegawai)->nama_lengkap ?? 'N/A', 0, 2))
                                            }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-900">{{
                                            optional($row->pegawai)->nama_lengkap ?? '-' }}</span>
                                        <p class="text-xs text-slate-500">{{ optional($row->pegawai)->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ optional($row->pegawai)->jabatan ?? '-'
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($row->jam_masuk)
                                <span class="text-sm font-semibold text-slate-900">{{
                                    \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') }}</span>
                                @else
                                <span class="text-sm text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($row->jam_pulang)
                                <span class="text-sm text-slate-700">{{
                                    \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') }}</span>
                                @else
                                <span class="text-sm text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php $kode = optional($row->jenisKehadiran)->kode_kehadiran ?? ''; @endphp
                                @if($kode === 'H')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">Hadir</span>
                                @elseif($kode === 'I')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-teal-100 to-emerald-100 text-teal-700 border border-teal-200/50 shadow-sm">Izin</span>
                                @elseif($kode === 'S')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200/50 shadow-sm">Sakit</span>
                                @elseif($kode === 'A')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-rose-100 to-red-100 text-rose-700 border border-rose-200/50 shadow-sm">Alpha</span>
                                @elseif($kode === 'C')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-teal-100 to-teal-100 text-teal-700 border border-teal-200/50 shadow-sm">Cuti</span>
                                @elseif($kode === 'DL')
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-slate-100 to-gray-100 text-slate-700 border border-slate-200/50 shadow-sm">Dinas
                                    Luar</span>
                                @else
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200/50">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700 capitalize">{{ $row->metode_absen ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm text-slate-700">{{ $row->lokasi_absen ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm text-slate-700">{{ $row->keterangan ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-28 h-28 mb-6">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full blur-2xl opacity-50">
                                        </div>
                                        <div
                                            class="relative w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-14 h-14 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Data Kehadiran</h3>
                                    <p class="text-sm text-slate-500 max-w-md">Belum ada data kehadiran untuk tanggal
                                        ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- ==================== TABEL BULANAN ==================== --}}
                @elseif($tipe === 'bulanan')
                <table class="w-full">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nama Pegawai</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jabatan</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Hadir</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Izin</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Sakit</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Cuti</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Alpha</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Dinas Luar</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Hari Kerja</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Presentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rekapitulasi as $i => $row)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-sm font-bold text-slate-700 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                                    {{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative group/avatar">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity">
                                        </div>
                                        <div
                                            class="relative w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr(optional($row->pegawai)->nama_lengkap ?? 'N/A', 0, 2))
                                            }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-900">{{
                                            optional($row->pegawai)->nama_lengkap ?? '-' }}</span>
                                        <p class="text-xs text-slate-500">{{ optional($row->pegawai)->jabatan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ optional($row->pegawai)->unit_kerja ?? '-'
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">{{
                                    $row->jumlah_hadir ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-teal-100 to-emerald-100 text-teal-700 border border-teal-200/50 shadow-sm">{{
                                    $row->jumlah_izin ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200/50 shadow-sm">{{
                                    $row->jumlah_sakit ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-teal-100 to-teal-100 text-teal-700 border border-teal-200/50 shadow-sm">{{
                                    $row->jumlah_cuti ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-rose-100 to-red-100 text-rose-700 border border-rose-200/50 shadow-sm">{{
                                    $row->jumlah_alpha ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-slate-100 to-gray-100 text-slate-700 border border-slate-200/50 shadow-sm">{{
                                    $row->jumlah_dinas_luar ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span class="text-sm font-semibold text-slate-900">{{ $row->total_hari_kerja ?? 0
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php $pct = $row->presentase_kehadiran ?? 0; @endphp
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-slate-200 rounded-full h-2.5 overflow-hidden shadow-inner">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $pct >= 80 ? 'bg-gradient-to-r from-emerald-500 to-teal-600' : ($pct >= 60 ? 'bg-gradient-to-r from-amber-500 to-orange-600' : 'bg-gradient-to-r from-rose-500 to-red-600') }}"
                                            style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-900 min-w-[50px] text-right">{{
                                        number_format($pct, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-28 h-28 mb-6">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full blur-2xl opacity-50">
                                        </div>
                                        <div
                                            class="relative w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-14 h-14 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Data Rekap Bulanan</h3>
                                    <p class="text-sm text-slate-500 max-w-md">Belum ada data rekap bulanan untuk
                                        periode ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($rekapitulasi->count() > 0)
                    <tfoot>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-t-2 border-slate-200">
                            <td colspan="3" class="px-6 py-5 text-sm font-bold text-slate-900">Total</td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('jumlah_hadir')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('jumlah_izin')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('jumlah_sakit')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('jumlah_cuti')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('jumlah_alpha')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{
                                    $rekapitulasi->sum('jumlah_dinas_luar') }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('total_hari_kerja')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{
                                    number_format($rekapitulasi->avg('presentase_kehadiran'), 1) }}%</span>
                                <p class="text-xs text-slate-500">(rata-rata)</p>
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>

                {{-- ==================== TABEL TAHUNAN ==================== --}}
                @else
                <table class="w-full">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">No
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nama Pegawai</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jabatan / Unit</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Hari Kerja</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Total Hadir</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Tidak Hadir</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Presentase</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Catatan Evaluasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rekapitulasi as $i => $row)
                        <tr
                            class="group hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-sm font-bold text-slate-700 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                                    {{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative group/avatar">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity">
                                        </div>
                                        <div
                                            class="relative w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr(optional($row->pegawai)->nama_lengkap ?? 'N/A', 0, 2))
                                            }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-slate-900">{{
                                            optional($row->pegawai)->nama_lengkap ?? '-' }}</span>
                                        <p class="text-xs text-slate-500">{{ optional($row->pegawai)->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div>
                                    <span class="text-sm font-semibold text-slate-900">{{
                                        optional($row->pegawai)->jabatan ?? '-' }}</span>
                                    <p class="text-xs text-slate-500">{{ optional($row->pegawai)->unit_kerja }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span class="text-sm font-semibold text-slate-900">{{ $row->total_hari_kerja ?? 0
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">{{
                                    $row->total_hadir ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-rose-100 to-red-100 text-rose-700 border border-rose-200/50 shadow-sm">{{
                                    $row->total_tidak_hadir ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php $pct = $row->presentase_kehadiran ?? 0; @endphp
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-slate-200 rounded-full h-2.5 overflow-hidden shadow-inner">
                                        <div class="h-full rounded-full transition-all duration-300 {{ $pct >= 80 ? 'bg-gradient-to-r from-emerald-500 to-teal-600' : ($pct >= 60 ? 'bg-gradient-to-r from-amber-500 to-orange-600' : 'bg-gradient-to-r from-rose-500 to-red-600') }}"
                                            style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-slate-900 min-w-[50px] text-right">{{
                                        number_format($pct, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm text-slate-700">{{ $row->catatan_evaluasi ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-28 h-28 mb-6">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full blur-2xl opacity-50">
                                        </div>
                                        <div
                                            class="relative w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-14 h-14 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Data Rekap Tahunan</h3>
                                    <p class="text-sm text-slate-500 max-w-md">Belum ada data rekap tahunan untuk tahun
                                        {{ $tahun }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($rekapitulasi->count() > 0)
                    <tfoot>
                        <tr
                            class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-t-2 border-slate-200">
                            <td colspan="3" class="px-6 py-5 text-sm font-bold text-slate-900">Total</td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('total_hari_kerja')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ $rekapitulasi->sum('total_hadir')
                                    }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{
                                    $rekapitulasi->sum('total_tidak_hadir') }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-slate-900">{{
                                    number_format($rekapitulasi->avg('presentase_kehadiran'), 1) }}%</span>
                                <p class="text-xs text-slate-500">(rata-rata)</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm text-slate-700">-</span>
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>

@endsection

@push('scripts')
<script>
    function setTipe(tipe) {
        // Set hidden input value
        document.getElementById('inputTipe').value = tipe;

        // Update tab visual states
        ['harian','bulanan','tahunan'].forEach(t => {
            const btn = document.getElementById('tab-' + t);
            if (t === tipe) {
                btn.classList.add('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-lg');
                btn.classList.remove('bg-white', 'text-slate-600', 'hover:bg-slate-50', 'border', 'border-slate-200');
            } else {
                btn.classList.remove('bg-gradient-to-r', 'from-emerald-600', 'to-teal-600', 'text-white', 'shadow-lg');
                btn.classList.add('bg-white', 'text-slate-600', 'hover:bg-slate-50', 'border', 'border-slate-200');
            }
        });

        // Show/hide appropriate filter inputs
        const isHarian  = tipe === 'harian';
        const isBulanan = tipe === 'bulanan';
        const isTahunan = tipe === 'tahunan';

        const filterHarian = document.getElementById('filterHarian');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');

        if (filterHarian) filterHarian.style.display = isHarian  ? '' : 'none';
        if (filterBulan)  filterBulan.style.display  = isBulanan ? '' : 'none';
        if (filterTahun)  filterTahun.style.display  = isBulanan || isTahunan ? '' : 'none';
        
        // Auto submit form to fetch new data
        document.getElementById('formFilter').submit();
    }
</script>
@endpush
