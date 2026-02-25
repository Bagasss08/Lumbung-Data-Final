@extends('layouts.admin')

@section('title', 'Anggota: ' . $kelompok->nama)

@section('content')

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

{{-- Breadcrumb --}}
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.kelompok.index') }}" class="hover:text-emerald-600 transition">Data Kelompok</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.kelompok.show', $kelompok) }}" class="hover:text-emerald-600 transition">{{
            $kelompok->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Anggota</span>
    </nav>
    <a href="{{ route('admin.kelompok.anggota.create', $kelompok) }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
        Tambah Anggota
    </a>
</div>

{{-- Info kelompok mini --}}
<div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white mb-6 shadow-md">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-lg font-bold">
            {{ strtoupper(substr($kelompok->nama, 0, 1)) }}
        </div>
        <div>
            <h3 class="font-bold text-lg">{{ $kelompok->nama }}</h3>
            <p class="text-white/80 text-sm">{{ optional($kelompok->master)->nama }} · {{
                $kelompok->anggota->where('aktif','1')->count() }} anggota aktif</p>
        </div>
    </div>
</div>

{{-- Tabel anggota --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">No
                    </th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">NIK
                    </th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama
                    </th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Jabatan</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Tgl
                        Masuk</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Status</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kelompok->anggota->sortBy(fn($a) => $a->aktif === '0') as $i => $a)
                <tr class="hover:bg-gray-50/50 transition-colors {{ $a->aktif === '0' ? 'opacity-50' : '' }}">
                    <td class="px-5 py-4 text-gray-500">{{ $i + 1 }}</td>
                    <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ $a->nik }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr(optional($a->penduduk)->nama ?? $a->nik, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ optional($a->penduduk)->nama ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if($a->jabatan)
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium">
                            {{ $a->jabatan }}
                        </span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        {{ $a->tgl_masuk ? $a->tgl_masuk->format('d/m/Y') : '-' }}
                    </td>
                    <td class="px-5 py-4 text-center">
                        @if($a->aktif === '1')
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-50 text-gray-500 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1">
                            @if($a->aktif === '1')
                            <form method="POST" action="{{ route('admin.kelompok.anggota.nonaktif', [$kelompok, $a]) }}"
                                onsubmit="return confirm('Keluarkan anggota ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" title="Nonaktifkan"
                                    class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition text-xs font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.kelompok.anggota.destroy', [$kelompok, $a]) }}"
                                onsubmit="return confirm('Hapus permanen data anggota ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-gray-400">
                            <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="font-medium">Belum ada anggota</p>
                            <a href="{{ route('admin.kelompok.anggota.create', $kelompok) }}"
                                class="text-sm text-emerald-600 hover:underline">Tambah anggota pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection