@extends('layouts.admin')
@section('title', 'Buku Rekapitulasi Jumlah Penduduk')
@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Buku Rekapitulasi Jumlah Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Statistik dan rekapitulasi data kependudukan desa</p>
    </div>
    <div class="flex items-center gap-2">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1 text-gray-400 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.buku-administrasi.penduduk.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Administrasi Penduduk</a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Rekapitulasi</span>
        </nav>
        <button onclick="window.print()"
            class="inline-flex items-center gap-2 px-3 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-medium text-gray-700 dark:text-slate-300 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span class="hidden sm:inline">Cetak</span>
        </button>
    </div>
</div>

{{-- LABEL BUKU --}}
<div class="flex items-center gap-2.5 mb-6">
    <div class="w-9 h-9 rounded-lg bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
    </div>
    <div>
        <p class="text-xs font-semibold text-gray-700 dark:text-slate-200">Buku III</p>
        <p class="text-xs text-gray-400 dark:text-slate-500">Rekapitulasi Jumlah Penduduk</p>
    </div>
</div>

{{-- STATS UTAMA --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Penduduk</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($totalPenduduk) }}</p>
                <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">jiwa</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Laki-laki</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($totalLaki) }}</p>
                @if($totalPenduduk > 0)
                <p class="text-xs text-emerald-500 mt-1">{{ number_format($totalLaki / $totalPenduduk * 100, 1) }}%</p>
                @endif
            </div>
            <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Perempuan</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($totalPerempuan) }}</p>
                @if($totalPenduduk > 0)
                <p class="text-xs text-pink-500 mt-1">{{ number_format($totalPerempuan / $totalPenduduk * 100, 1) }}%</p>
                @endif
            </div>
            <div class="w-12 h-12 bg-pink-50 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- GRID REKAPITULASI --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Per Agama --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Menurut Agama</h3>
        </div>
        <div class="p-5">
            @forelse($perAgama as $item)
            @php $pct = $totalPenduduk > 0 ? ($item->jumlah / $totalPenduduk * 100) : 0; @endphp
            <div class="mb-3 last:mb-0">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700 dark:text-slate-300">{{ $item->agama ?? 'Tidak Diisi' }}</span>
                    <span class="text-gray-500 dark:text-slate-400">{{ number_format($item->jumlah) }} <span class="text-xs text-gray-400">({{ number_format($pct, 1) }}%)</span></span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                    <div class="bg-amber-400 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada data</p>
            @endforelse
        </div>
    </div>

    {{-- Per Status Perkawinan --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Menurut Status Perkawinan</h3>
        </div>
        <div class="p-5">
            @php
                $statusColors = [
                    'Kawin'       => 'bg-emerald-400',
                    'Belum Kawin' => 'bg-blue-400',
                    'Cerai Hidup' => 'bg-amber-400',
                    'Cerai Mati'  => 'bg-red-400',
                ];
            @endphp
            @forelse($perStatusKawin as $item)
            @php
                $pct = $totalPenduduk > 0 ? ($item->jumlah / $totalPenduduk * 100) : 0;
                $color = $statusColors[$item->status_perkawinan] ?? 'bg-gray-400';
            @endphp
            <div class="mb-3 last:mb-0">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700 dark:text-slate-300">{{ $item->status_perkawinan ?? 'Tidak Diisi' }}</span>
                    <span class="text-gray-500 dark:text-slate-400">{{ number_format($item->jumlah) }} <span class="text-xs text-gray-400">({{ number_format($pct, 1) }}%)</span></span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                    <div class="{{ $color }} h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada data</p>
            @endforelse
        </div>
    </div>

    {{-- Per Pendidikan --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Menurut Pendidikan</h3>
        </div>
        <div class="p-5">
            @forelse($perPendidikan as $item)
            @php $pct = $totalPenduduk > 0 ? ($item->jumlah / $totalPenduduk * 100) : 0; @endphp
            <div class="mb-3 last:mb-0">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700 dark:text-slate-300">{{ $item->pendidikan ?? 'Tidak Diisi' }}</span>
                    <span class="text-gray-500 dark:text-slate-400">{{ number_format($item->jumlah) }} <span class="text-xs text-gray-400">({{ number_format($pct, 1) }}%)</span></span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                    <div class="bg-blue-400 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada data</p>
            @endforelse
        </div>
    </div>

    {{-- Per Pekerjaan --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Menurut Pekerjaan</h3>
        </div>
        <div class="p-5">
            @forelse($perPekerjaan as $item)
            @php $pct = $totalPenduduk > 0 ? ($item->jumlah / $totalPenduduk * 100) : 0; @endphp
            <div class="mb-3 last:mb-0">
                <div class="flex items-center justify-between text-sm mb-1">
                    <span class="font-medium text-gray-700 dark:text-slate-300">{{ $item->pekerjaan ?? 'Tidak Diisi' }}</span>
                    <span class="text-gray-500 dark:text-slate-400">{{ number_format($item->jumlah) }} <span class="text-xs text-gray-400">({{ number_format($pct, 1) }}%)</span></span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                    <div class="bg-purple-400 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada data</p>
            @endforelse
        </div>
    </div>
</div>

{{-- KELOMPOK UMUR --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
        <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        </div>
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Menurut Kelompok Umur</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-100 dark:border-slate-700">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kelompok Umur</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Jumlah</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Proporsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @php $maxUmur = max(array_values($kelompokUmur) ?: [1]); @endphp
                @foreach($kelompokUmur as $rentang => $jumlah)
                @php $pct = $totalPenduduk > 0 ? ($jumlah / $totalPenduduk * 100) : 0; @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                    <td class="px-5 py-3 font-medium text-gray-700 dark:text-slate-300">{{ $rentang }} tahun</td>
                    <td class="px-5 py-3 text-right font-semibold text-gray-900 dark:text-slate-100">{{ number_format($jumlah) }}</td>
                    <td class="px-5 py-3 w-48">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-emerald-400 h-2 rounded-full" style="width: {{ $maxUmur > 0 ? ($jumlah / $maxUmur * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-xs text-gray-400 w-10 text-right">{{ number_format($pct, 1) }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-t-2 border-gray-200 dark:border-slate-600">
                    <td class="px-5 py-3 font-bold text-gray-900 dark:text-slate-100">Total</td>
                    <td class="px-5 py-3 text-right font-bold text-gray-900 dark:text-slate-100">{{ number_format($totalPenduduk) }}</td>
                    <td class="px-5 py-3 text-xs text-gray-400">100%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection