@extends('layouts.admin')

@section('title', 'Data Suplemen')

@section('content')

{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <p class="text-sm text-gray-500">Kelola data suplemen penduduk desa</p>
    </div>
    <a href="{{ route('admin.suplemen.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Suplemen
    </a>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Suplemen</p>
                <p class="text-xl font-bold text-gray-900">{{ $suplemen->total() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Sasaran Perorangan</p>
                <p class="text-xl font-bold text-gray-900">{{ $suplemen->getCollection()->where('sasaran','1')->count()
                    }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Sasaran Keluarga</p>
                <p class="text-xl font-bold text-gray-900">{{ $suplemen->getCollection()->where('sasaran','2')->count()
                    }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Aktif</p>
                <p class="text-xl font-bold text-gray-900">{{ $suplemen->getCollection()->where('aktif',true)->count()
                    }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama suplemen..."
                class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50">
        </div>
        <select name="sasaran"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 min-w-[160px]">
            <option value="">Semua Sasaran</option>
            <option value="1" {{ request('sasaran')=='1' ? 'selected' : '' }}>Perorangan</option>
            <option value="2" {{ request('sasaran')=='2' ? 'selected' : '' }}>Keluarga</option>
        </select>
        <select name="aktif"
            class="px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-gray-50 min-w-[140px]">
            <option value="">Semua Status</option>
            <option value="1" {{ request('aktif')=='1' ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ request('aktif')=='0' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <div class="flex gap-2">
            <button type="submit"
                class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-xl transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['q','sasaran','aktif']))
            <a href="{{ route('admin.suplemen.index') }}"
                class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                        #</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        Suplemen</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Sasaran</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Periode</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Terdata</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($suplemen as $s)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">
                        {{ $loop->iteration + ($suplemen->currentPage()-1) * $suplemen->perPage() }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($s->logo)
                            <img src="{{ Storage::url($s->logo) }}"
                                class="w-9 h-9 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                            @else
                            <div
                                class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $s->nama }}</p>
                                @if($s->keterangan)
                                <p class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $s->keterangan }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($s->sasaran == '1')
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                            Perorangan
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Keluarga
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-500 space-y-0.5">
                            @if($s->tgl_mulai || $s->tgl_selesai)
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $s->tgl_mulai?->format('d/m/Y') ?? '—' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <span>{{ $s->tgl_selesai?->format('d/m/Y') ?? '—' }}</span>
                            </div>
                            @else
                            <span class="text-gray-300">—</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.suplemen.terdata.index', $s) }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg transition-colors border border-emerald-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $s->terdata_count }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($s->aktif)
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Aktif
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Nonaktif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.suplemen.terdata.index', $s) }}" title="Lihat Terdata"
                                class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.suplemen.edit', $s) }}" title="Edit"
                                class="p-1.5 rounded-lg text-amber-500 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.suplemen.destroy', $s) }}" method="POST" x-data
                                @submit.prevent="if(confirm('Yakin hapus suplemen \'{{ addslashes($s->nama) }}\' beserta semua data terdata?')) $el.submit()">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition-colors">
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
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Belum ada data suplemen</p>
                                <p class="text-xs text-gray-400 mt-1">Klik tombol "Tambah Suplemen" untuk memulai</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($suplemen->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $suplemen->firstItem() }}–{{ $suplemen->lastItem() }} dari {{ $suplemen->total() }} data
            </p>
            {{ $suplemen->links() }}
        </div>
    </div>
    @endif
</div>

@endsection