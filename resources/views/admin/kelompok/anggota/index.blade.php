@extends('layouts.admin')

@section('title', 'Anggota: ' . $kelompok->nama)

@section('content')

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
    class="flex items-start gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 rounded-xl">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd" />
    </svg>
    <div>
        <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
        @if(session('import_errors'))
        <ul class="mt-2 space-y-0.5">
            @foreach(session('import_errors') as $err)
            <li class="text-xs text-red-600">• {{ $err }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endif

@if(session('error'))
<div class="flex items-center gap-3 p-4 mb-6 bg-red-50 border border-red-200 rounded-xl">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd" />
    </svg>
    <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
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
    <div class="flex items-center gap-2">
        <button type="button" @click="$dispatch('buka-modal-import-kelompok')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Import
        </button>
        <div x-data="{ open: false }" @click.away="open = false" class="relative">
            <button type="button" @click="open = !open"
                class="inline-flex items-center gap-2 border border-gray-200 hover:border-emerald-400 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-700 px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
                <svg class="w-3 h-3 transition-transform duration-150" :class="open && 'rotate-180'" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-30"
                style="display:none">
                <a href="{{ route('admin.kelompok.anggota.export.excel', $kelompok) }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-xs">Excel (.xlsx)</p>
                        <p class="text-xs text-gray-400">Semua data</p>
                    </div>
                </a>
                <div class="h-px bg-gray-100 mx-3"></div>
                <a href="{{ route('admin.kelompok.anggota.export.pdf', $kelompok) }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-xs">PDF</p>
                        <p class="text-xs text-gray-400">Siap cetak + TTD</p>
                    </div>
                </a>
            </div>
        </div>
        <a href="{{ route('admin.kelompok.anggota.create', $kelompok) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Tambah Anggota
        </a>
    </div>
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
                            <button type="button" @click="$dispatch('buka-modal-hapus', {
                                action: '{{ route('admin.kelompok.anggota.destroy', [$kelompok, $a]) }}',
                                nama: '{{ addslashes($a->penduduk?->nama ?? $a->nik) }}'
                            })" title="Hapus"
                                class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
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

@include('admin.partials.modal-import-kelompok', ['kelompok' => $kelompok])
@include('admin.partials.modal-hapus')

@endsection