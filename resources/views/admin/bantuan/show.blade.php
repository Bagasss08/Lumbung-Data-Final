@extends('layouts.admin')

@section('title', 'Detail Program Bantuan')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition
    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
    <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('admin.bantuan.index') }}" class="hover:text-emerald-600 transition-colors font-medium">Program
        Bantuan</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-600 font-medium truncate">{{ $bantuan->nama }}</span>
</div>

{{-- Program Info --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">

    {{-- Header --}}
    <div class="px-6 py-5 border-b border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $bantuan->nama }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium
                            {{ $bantuan->status == 1 ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $bantuan->status == 1 ? 'bg-emerald-400' : 'bg-gray-400' }}"></span>
                            {{ $bantuan->status_label }}
                        </span>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium
                            {{ $bantuan->sasaran == 1 ? 'bg-violet-50 text-violet-700' : 'bg-orange-50 text-orange-700' }}">
                            {{ $bantuan->sasaran_label }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.bantuan.edit', $bantuan->id) }}"
                    class="inline-flex items-center gap-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.bantuan.index') }}"
                    class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Sumber Dana</p>
                <p class="text-sm font-bold text-gray-800">{{ $bantuan->sumber_dana ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Tahun</p>
                <p class="text-sm font-bold text-gray-800">{{ $bantuan->tahun ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Nominal</p>
                <p class="text-sm font-bold text-emerald-700">
                    {{ $bantuan->nominal ? 'Rp ' . number_format($bantuan->nominal, 0, ',', '.') : '-' }}
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Peserta</p>
                <p class="text-sm font-bold text-blue-700">{{ $peserta->total() }} orang</p>
            </div>
        </div>

        {{-- Periode --}}
        @if($bantuan->tanggal_mulai || $bantuan->tanggal_selesai)
        <div class="flex items-center gap-3 bg-blue-50 rounded-xl px-4 py-3 mb-4">
            <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-sm text-blue-700 font-medium">
                Periode:
                {{ optional($bantuan->tanggal_mulai)->format('d F Y') ?? '-' }}
                <span class="text-blue-400">s/d</span>
                {{ optional($bantuan->tanggal_selesai)->format('d F Y') ?? '-' }}
            </p>
        </div>
        @endif

        {{-- Syarat --}}
        @if($bantuan->syarat)
        <div class="mb-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Syarat / Kriteria</p>
            <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4 text-sm text-gray-700">{{ $bantuan->syarat
                }}</div>
        </div>
        @endif

        {{-- Keterangan --}}
        @if($bantuan->keterangan)
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Keterangan</p>
            <p class="text-sm text-gray-600">{{ $bantuan->keterangan }}</p>
        </div>
        @endif
    </div>
</div>

{{-- Peserta Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h4 class="font-bold text-gray-900">Daftar Peserta</h4>
            <p class="text-xs text-gray-400 mt-0.5">{{ $peserta->total() }} peserta terdaftar dalam program ini</p>
        </div>
        <a href="{{ route('admin.bantuan.peserta.create', $bantuan->id) }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Tambah Peserta
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">NIK</th>
                    <th class="px-6 py-3 text-left">Tempat / Tgl Lahir</th>
                    <th class="px-6 py-3 text-left">Alamat</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($peserta as $i => $p)
                <tr class="hover:bg-gray-50/70 transition-colors duration-150">
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $peserta->firstItem() + $i }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($p->kartu_nama ?? '?', 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ $p->kartu_nama ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $p->kartu_nik ?? $p->peserta }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $p->kartu_tempat_lahir ?? '-' }}
                        @if($p->kartu_tanggal_lahir)
                        / {{ $p->kartu_tanggal_lahir->format('d/m/Y') }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 max-w-[200px] truncate">{{ $p->kartu_alamat ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.bantuan.peserta.destroy', [$bantuan->id, $p->id]) }}"
                            method="POST" x-data
                            @submit.prevent="if(confirm('Hapus peserta ini dari program?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition-colors">
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
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-400">Belum ada peserta terdaftar</p>
                            <a href="{{ route('admin.bantuan.peserta.create', $bantuan->id) }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">+ Tambah Peserta
                                Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peserta->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $peserta->links() }}
    </div>
    @endif
</div>

@endsection