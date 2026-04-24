@extends('layouts.app')

@section('title', 'Aktivitas Saya')

@section('content')
<div class="min-h-screen bg-slate-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        {{-- ── Header ── --}}
        <div class="mb-8" data-aos="fade-right" data-aos-duration="800">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Aktivitas Saya</h1>
                    <p class="text-sm text-slate-500">Riwayat seluruh aktivitas akun Anda</p>
                </div>
            </div>
        </div>

        {{-- ── Statistik Ringkas ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

            {{-- Total Surat --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Total Surat</span>
                </div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['total_surat'] }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-amber-600">{{ $stats['surat_proses'] }} diproses</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-xs text-emerald-600">{{ $stats['surat_selesai'] }} selesai</span>
                </div>
            </div>

            {{-- Surat Selesai --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Surat Selesai</span>
                </div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['surat_selesai'] }}</p>
                <p class="text-xs text-emerald-600 mt-1">sudah selesai diproses</p>
            </div>

            {{-- Pesan Masuk --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-slate-500">Pesan Masuk</span>
                </div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['total_pesan'] }}</p>
                @if($stats['pesan_belum_dibaca'] > 0)
                    <p class="text-xs text-red-500 mt-1">{{ $stats['pesan_belum_dibaca'] }} belum dibaca</p>
                @else
                    <p class="text-xs text-slate-400 mt-1">semua sudah dibaca</p>
                @endif
            </div>

        </div>

        {{-- ── Filter ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-6" data-aos="fade-down" data-aos-delay="400">
            <form method="GET" action="{{ route('warga.aktivitas') }}"
                  class="flex flex-wrap items-center gap-3">

                {{-- Filter Periode --}}
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-slate-500 whitespace-nowrap">Periode:</label>
                    <select name="tanggal"
                        class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50">
                        <option value="semua"    {{ $filterTanggal === 'semua'    ? 'selected' : '' }}>Semua</option>
                        <option value="hari_ini" {{ $filterTanggal === 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="7_hari"   {{ $filterTanggal === '7_hari'   ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="30_hari"  {{ $filterTanggal === '30_hari'  ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>
                </div>

                {{-- Filter Tipe --}}
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-slate-500 whitespace-nowrap">Tipe:</label>
                    <select name="tipe"
                        class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50">
                        <option value="semua" {{ $filterTipe === 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="surat" {{ $filterTipe === 'surat' ? 'selected' : '' }}>Surat Online</option>
                        <option value="pesan" {{ $filterTipe === 'pesan' ? 'selected' : '' }}>Pesan</option>
                    </select>
                </div>

                <button type="submit"
                    class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    Filter
                </button>

                @if($filterTanggal !== 'semua' || $filterTipe !== 'semua')
                    <a href="{{ route('warga.aktivitas') }}"
                        class="text-sm text-slate-400 hover:text-red-500 transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ── Timeline Aktivitas ── --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="500">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-semibold text-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Aktivitas
                </h2>
                <span class="text-xs text-slate-400">{{ $aktivitas->total() }} aktivitas ditemukan</span>
            </div>

            {{-- List --}}
            @if($aktivitas->isEmpty())
                <div class="py-16 text-center">
                    <svg class="w-12 h-12 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-sm text-slate-400 font-medium">Belum ada aktivitas</p>
                    <p class="text-xs text-slate-300 mt-1">Aktivitas Anda akan muncul di sini</p>
                </div>
            @else
                <ul class="divide-y divide-slate-50">
                    @foreach($aktivitas as $index => $item)
                        {{-- Setiap item list muncul dengan delay staggered --}}
                        <li class="flex items-start gap-4 px-6 py-4 hover:bg-slate-50 transition-colors"
                            data-aos="fade-up"
                            data-aos-delay="{{ 100 * ($index % 5) }}">

                            {{-- Icon tipe --}}
                            <div class="flex-shrink-0 mt-0.5">
                                @if($item['tipe'] === 'surat')
                                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-9 h-9 bg-purple-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Konten --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 flex-wrap">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700">{{ $item['label'] }}</p>
                                        <p class="text-sm text-slate-500 mt-0.5 truncate max-w-xs sm:max-w-md">
                                            {{ $item['deskripsi'] }}
                                        </p>
                                    </div>

                                    {{-- Badge status --}}
                                    <span class="flex-shrink-0 text-[11px] font-semibold px-2.5 py-1 rounded-full
                                        @if(in_array($item['status'], ['selesai', 'disetujui', 'dibaca', 'diterima']))
                                            bg-emerald-100 text-emerald-700
                                        @elseif(in_array($item['status'], ['menunggu', 'diajukan', 'diproses', 'belum_dibaca']))
                                            bg-amber-100 text-amber-700
                                        @elseif(in_array($item['status'], ['ditolak', 'batal']))
                                            bg-red-100 text-red-700
                                        @else
                                            bg-slate-100 text-slate-600
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $item['status'] ?? '-')) }}
                                    </span>
                                </div>

                                {{-- Waktu & Link --}}
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item['waktu_human'] }}
                                        &bull;
                                        {{ \Carbon\Carbon::parse($item['waktu'])->format('d M Y, H:i') }}
                                    </span>

                                    <a href="{{ $item['url'] }}"
                                        class="text-[11px] font-semibold text-emerald-600 hover:underline flex items-center gap-0.5">
                                        Lihat
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Paginasi --}}
                @if($aktivitas->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $aktivitas->withQueryString()->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
