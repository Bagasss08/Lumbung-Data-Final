@extends('layouts.admin')

@section('title', 'Detail Program Bantuan')

@section('content')

{{-- Flash Messages --}}
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
        <div class="flex items-center gap-2">
            <button type="button" @click="$dispatch('buka-modal-import-bantuan')"
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
                    <a href="{{ route('admin.bantuan.peserta.export.excel', $bantuan) }}"
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
                    <a href="{{ route('admin.bantuan.peserta.export.pdf', $bantuan) }}"
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
            <a href="{{ route('admin.bantuan.peserta.create', $bantuan->id) }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Tambah Peserta
            </a>
        </div>
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
                        <button type="button" @click="$dispatch('buka-modal-hapus', {
                            action: '{{ route('admin.bantuan.peserta.destroy', [$bantuan->id, $p->id]) }}',
                            nama: '{{ addslashes($p->kartu_nama ?? $p->peserta) }}'
                        })"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
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

@include('admin.partials.modal-import-bantuan', ['bantuan' => $bantuan])
@include('admin.partials.modal-hapus')

@endsection