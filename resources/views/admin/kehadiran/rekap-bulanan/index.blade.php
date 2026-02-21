@extends('layouts.admin')

@section('title', 'Rekap Tahunan Kehadiran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-500">
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
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Rekap Bulanan Kehadiran</h1>
                            <p class="text-blue-100 text-sm font-medium">Laporan rekapitulasi kehadiran pegawai tahun {{ $tahun }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="GET" class="flex items-center gap-3">
                            <select name="tahun" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="group relative inline-flex items-center gap-2 bg-white text-indigo-600 px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-r from-white to-blue-50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span class="relative">Filter</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-8 py-8 bg-gradient-to-br from-slate-50/50 to-white/50">
                <!-- Total Pegawai -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-blue-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-xl group-hover:shadow-indigo-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Total Pegawai</p>
                            <p class="text-3xl font-bold text-slate-900">{{ $summaryTahunan['total_pegawai'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Hadir -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:shadow-xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Total Hadir</p>
                            <p class="text-3xl font-bold text-slate-900">{{ number_format($summaryTahunan['total_hadir']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Izin -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-orange-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30 group-hover:shadow-xl group-hover:shadow-amber-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Total Izin</p>
                            <p class="text-3xl font-bold text-slate-900">{{ number_format($summaryTahunan['total_izin']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Alpha -->
                <div class="group relative bg-white rounded-2xl p-6 border border-slate-200/60 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-red-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:shadow-xl group-hover:shadow-rose-500/40 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-600 font-semibold mb-1">Total Alpha</p>
                            <p class="text-3xl font-bold text-slate-900">{{ number_format($summaryTahunan['total_tidak_hadir']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="bg-white rounded-2xl border-l-4 border-emerald-500 p-5 shadow-lg backdrop-blur-sm animate-slideIn">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-slate-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-100 via-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Pegawai</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Jabatan</th>
                            @for($bulan = 1; $bulan <= 12; $bulan++)
                            <th class="px-6 py-5 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('M') }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bulananData as $index => $dataPegawai)
                        <tr class="group hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-blue-50/50 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-sm font-bold text-slate-700 group-hover:bg-indigo-100 group-hover:text-indigo-700 transition-colors">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="relative group/avatar">
                                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity"></div>
                                        <div class="relative w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                            {{ strtoupper(substr($dataPegawai['pegawai']->nama_lengkap, 0, 2)) }}
                                        </div>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">{{ $dataPegawai['pegawai']->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-600">{{ $dataPegawai['pegawai']->nip ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-sm text-slate-700">{{ $dataPegawai['pegawai']->jabatan ?? '-' }}</span>
                            </td>
                            @for($bulan = 1; $bulan <= 12; $bulan++)
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @if($dataPegawai['bulan'][$bulan])
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 font-bold text-xs">
                                            {{ $dataPegawai['bulan'][$bulan]->jumlah_hadir }}
                                        </span>
                                        <span class="text-xs text-slate-500">{{ number_format($dataPegawai['bulan'][$bulan]->presentase_kehadiran, 1) }}%</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-400 font-bold text-xs">-</span>
                                @endif
                            </td>
                            @endfor
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="relative w-28 h-28 mb-6">
                                        <div class="absolute inset-0 bg-gradient-to-br from-slate-200 to-slate-300 rounded-full blur-2xl opacity-50"></div>
                                        <div class="relative w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center shadow-xl">
                                            <svg class="w-14 h-14 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Data Kehadiran</h3>
                                    <p class="text-sm text-slate-500 mb-8 max-w-md">Belum ada data kehadiran untuk tahun {{ $tahun }}</p>
                                    <a href="{{ route('admin.kehadiran-bulanan.index') }}" class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 text-white px-8 py-4 rounded-xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-700 via-blue-700 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        <svg class="relative w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span class="relative">Kembali ke Data Kehadiran</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
