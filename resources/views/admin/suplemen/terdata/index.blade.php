@extends('layouts.admin')

@section('title', 'Terdata: ' . $suplemen->nama)

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6 flex-wrap">
    <a href="{{ route('admin.suplemen.index') }}" class="hover:text-emerald-600 transition-colors">Data Suplemen</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium truncate max-w-xs">{{ $suplemen->nama }}</span>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium">Data Terdata</span>
</div>

{{-- Header Info Card --}}
<div class="bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 rounded-2xl p-6 mb-6 text-white shadow-lg">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            @if($suplemen->logo)
            <img src="{{ Storage::url($suplemen->logo) }}"
                class="w-14 h-14 rounded-xl object-cover border-2 border-white/30 flex-shrink-0">
            @else
            <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            @endif
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-xl font-bold">{{ $suplemen->nama }}</h3>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-white/20 backdrop-blur">
                        {{ $suplemen->sasaran_label }}
                    </span>
                </div>
                @if($suplemen->keterangan)
                <p class="text-white/70 text-sm">{{ $suplemen->keterangan }}</p>
                @endif
                @if($suplemen->tgl_mulai || $suplemen->tgl_selesai)
                <p class="text-white/60 text-xs mt-1">
                    {{ $suplemen->tgl_mulai?->format('d M Y') ?? '—' }} — {{ $suplemen->tgl_selesai?->format('d M Y') ??
                    'Sekarang' }}
                </p>
                @endif
            </div>
        </div>
        <div class="flex flex-col sm:items-end gap-3">
            <div class="text-center sm:text-right">
                <p class="text-4xl font-bold">{{ $terdata->total() }}</p>
                <p class="text-white/70 text-sm">Total Terdata</p>
            </div>
            <a href="{{ route('admin.suplemen.terdata.create', $suplemen) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-emerald-700 hover:bg-emerald-50 text-sm font-semibold rounded-xl transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Tambah Terdata
            </a>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-700">Daftar Anggota Terdata</h3>
        <span class="text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full">
            {{ $terdata->total() }} data
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
                        #</th>
                    @if($suplemen->sasaran == '1')
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIK
                    </th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        Penduduk</th>
                    @else
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">No.
                        KK</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Kepala Keluarga</th>
                    @endif
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Keterangan</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Ditambahkan</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($terdata as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">
                        {{ $loop->iteration + ($terdata->currentPage()-1) * $terdata->perPage() }}
                    </td>
                    @if($suplemen->sasaran == '1')
                    <td class="px-6 py-4">
                        <code
                            class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">{{ $t->id_pend ?? '—' }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($t->penduduk?->nama ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ $t->penduduk?->nama ?? '—' }}</span>
                        </div>
                    </td>
                    @else
                    <td class="px-6 py-4">
                        <code
                            class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-lg">{{ $t->no_kk ?? '—' }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">—</span>
                    </td>
                    @endif
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-500">{{ $t->keterangan ?? '—' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs text-gray-400">{{ $t->created_at->format('d M Y') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.suplemen.terdata.destroy', [$suplemen, $t]) }}" method="POST"
                            x-data @submit.prevent="if(confirm('Hapus anggota ini dari daftar terdata?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Belum ada anggota terdata</p>
                                <p class="text-xs text-gray-400 mt-1">Klik "Tambah Terdata" untuk menambahkan anggota
                                </p>
                            </div>
                            <a href="{{ route('admin.suplemen.terdata.create', $suplemen) }}"
                                class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-xl transition-colors border border-emerald-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Terdata
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($terdata->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $terdata->firstItem() }}–{{ $terdata->lastItem() }} dari {{ $terdata->total() }} data
            </p>
            {{ $terdata->links() }}
        </div>
    </div>
    @endif
</div>

@endsection