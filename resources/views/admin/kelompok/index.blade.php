@extends('layouts.admin')

@section('title', 'Data Kelompok')

@section('content')

{{-- Alert --}}
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
@if(session('error'))
<div x-data="{ show: true }" x-show="show"
    class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('error') }}</span>
</div>
@endif

{{-- Header Actions --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-700">{{ $kelompok->total() }}</span>
            kelompok ditemukan</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.kelompok.master.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            Jenis Kelompok
        </a>
        <a href="{{ route('admin.kelompok.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kelompok
        </a>
    </div>
</div>

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" action="{{ route('admin.kelompok.index') }}" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama atau singkatan..."
                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
        </div>
        <select name="master"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Jenis</option>
            @foreach($masterList as $m)
            <option value="{{ $m->id }}" {{ request('master')==$m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
            @endforeach
        </select>
        <select name="aktif"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="1" {{ request('aktif')==='1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('aktif')==='0' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>
        <button type="submit"
            class="px-4 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition">
            Cari
        </button>
        @if(request()->hasAny(['search','master','aktif']))
        <a href="{{ route('admin.kelompok.index') }}"
            class="px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
            Reset
        </a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">No
                    </th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama
                        Kelompok</th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jenis
                    </th>
                    <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Ketua
                    </th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Anggota</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Status</th>
                    <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kelompok as $index => $item)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-4 text-gray-500">{{ $kelompok->firstItem() + $index }}</td>
                    <td class="px-5 py-4">
                        <div class="font-semibold text-gray-800">{{ $item->nama }}</div>
                        @if($item->singkatan)
                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->singkatan }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                            {{ optional($item->master)->nama ?? '-' }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-600">{{ $item->nama_ketua ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                            {{ $item->anggota_aktif_count }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        @if($item->aktif === '1')
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Tidak Aktif
                        </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.kelompok.show', $item) }}" title="Detail"
                                class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kelompok.anggota.index', $item) }}" title="Anggota"
                                class="p-1.5 rounded-lg text-emerald-600 hover:bg-emerald-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kelompok.edit', $item) }}" title="Edit"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.kelompok.destroy', $item) }}"
                                onsubmit="return confirm('Hapus kelompok {{ $item->nama }}?')">
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
                            <p class="font-medium">Belum ada data kelompok</p>
                            <a href="{{ route('admin.kelompok.create') }}"
                                class="text-sm text-emerald-600 hover:underline">Tambah kelompok pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kelompok->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $kelompok->links() }}
    </div>
    @endif
</div>

@endsection