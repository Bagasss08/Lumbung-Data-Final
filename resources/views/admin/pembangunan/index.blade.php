@extends('layouts.admin')

@section('title', 'Pembangunan')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-900">Data Kegiatan Pembangunan</h3>
        <p class="text-sm text-gray-500 mt-0.5">Monitoring kegiatan infrastruktur dan pembangunan desa</p>
    </div>
    <a href="{{ route('admin.pembangunan.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl shadow hover:shadow-md transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Kegiatan
    </a>
</div>

{{-- ── Statistik ── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 mb-1">Total Kegiatan</p>
        <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 mb-1">Sedang Berjalan</p>
        <p class="text-3xl font-bold text-blue-700">{{ $stats['berjalan'] }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 mb-1">Selesai (100%)</p>
        <p class="text-3xl font-bold text-emerald-700">{{ $stats['selesai'] }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 mb-1">Total Anggaran</p>
        <p class="text-lg font-bold text-amber-700">Rp {{ number_format($stats['total_anggaran'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- ── Filter ── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan..."
            class="flex-1 min-w-[180px] text-sm border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">

        <select name="tahun"
            class="text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $t)
            <option value="{{ $t }}" {{ request('tahun')==$t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>

        <select name="id_bidang"
            class="text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Bidang</option>
            @foreach($bidangs as $b)
            <option value="{{ $b->id }}" {{ request('id_bidang')==$b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
            @endforeach
        </select>

        <select name="id_sasaran"
            class="text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Sasaran</option>
            @foreach($sasarans as $s)
            <option value="{{ $s->id }}" {{ request('id_sasaran')==$s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
            @endforeach
        </select>

        <select name="id_sumber_dana"
            class="text-sm border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <option value="">Semua Sumber Dana</option>
            @foreach($sumberDana as $sd)
            <option value="{{ $sd->id }}" {{ request('id_sumber_dana')==$sd->id ? 'selected' : '' }}>{{ $sd->nama }}
            </option>
            @endforeach
        </select>

        <button type="submit"
            class="px-5 py-2 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Filter</button>
        @if(request()->hasAny(['search','tahun','id_bidang','id_sasaran','id_sumber_dana','status']))
        <a href="{{ route('admin.pembangunan.index') }}"
            class="px-5 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">Reset</a>
        @endif
    </form>
</div>

{{-- ── Tabel ── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">#
                    </th>
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        Kegiatan</th>
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-20">
                        Tahun</th>
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bidang
                    </th>
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">
                        Sasaran</th>
                    <th class="text-right px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-36">
                        Total Anggaran</th>
                    <th class="text-center px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">
                        Progres</th>
                    <th class="text-center px-5 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-28">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pembangunan as $item)
                @php
                $progres = $item->dokumentasis->isNotEmpty()
                ? $item->dokumentasis->last()->persentase
                : 0;
                $total = $item->total_anggaran;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 text-gray-400">{{ $pembangunan->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-4">
                        <a href="{{ route('admin.pembangunan.show', $item) }}"
                            class="font-medium text-gray-900 hover:text-emerald-700 transition-colors">
                            {{ $item->nama }}
                        </a>
                        @if($item->pelaksana)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->pelaksana }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4 font-medium text-gray-700">{{ $item->tahun_anggaran }}</td>
                    <td class="px-5 py-4 text-xs text-gray-600">{{ $item->bidang?->nama ?? '-' }}</td>
                    <td class="px-5 py-4">
                        @if($item->sasaran)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700">
                            {{ $item->sasaran->nama }}
                        </span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right font-semibold text-gray-900">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all
                                    {{ $progres >= 100 ? 'bg-emerald-500' : ($progres >= 50 ? 'bg-blue-500' : 'bg-amber-400') }}"
                                    style="width: {{ $progres }}%"></div>
                            </div>
                            <span
                                class="text-xs font-semibold {{ $progres >= 100 ? 'text-emerald-700' : 'text-gray-500' }}">
                                {{ $progres }}%
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.pembangunan.show', $item) }}"
                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.pembangunan.edit', $item) }}"
                                class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.pembangunan.destroy', $item) }}"
                                onsubmit="return confirm('Hapus kegiatan ini beserta semua dokumentasinya?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                    title="Hapus">
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
                    <td colspan="8" class="px-5 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <p class="font-medium text-gray-500">Belum ada data kegiatan pembangunan</p>
                            <a href="{{ route('admin.pembangunan.create') }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">+ Tambah Kegiatan
                                Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembangunan->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">{{ $pembangunan->links() }}</div>
    @endif
</div>

@endsection