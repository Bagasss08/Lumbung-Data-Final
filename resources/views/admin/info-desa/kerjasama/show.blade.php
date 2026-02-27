@extends('layouts.admin')

@section('title', 'Detail Kerjasama')

@section('content')

<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.kerjasama.index') }}" class="hover:text-emerald-600 transition-colors">Kerjasama</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-900 font-medium">Detail</span>
</nav>

@php
$statusColors = [
'aktif' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
'berakhir' => 'bg-gray-100 text-gray-600 border-gray-200',
'ditangguhkan' => 'bg-red-100 text-red-700 border-red-200',
];
$sc = $statusColors[$kerjasama->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
@endphp

<div class="max-w-3xl space-y-4">
    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between gap-4">
            <div>
                <h3 class="font-bold text-xl text-gray-900">{{ $kerjasama->nama_mitra }}</h3>
                @if($kerjasama->nomor_perjanjian)
                <p class="text-sm text-gray-500 mt-1">{{ $kerjasama->nomor_perjanjian }}</p>
                @endif
                <div class="flex flex-wrap gap-2 mt-2">
                    @if($kerjasama->jenis_mitra)
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">{{
                        $kerjasama->jenis_mitra }}</span>
                    @endif
                    @if($kerjasama->jenis_kerjasama)
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{
                        $kerjasama->jenis_kerjasama }}</span>
                    @endif
                </div>
            </div>
            <span class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-semibold border {{ $sc }}">
                {{ ucfirst($kerjasama->status) }}
            </span>
        </div>

        <div class="p-6 space-y-5">
            {{-- Info Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-3">
                    @if($kerjasama->alamat_mitra)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat</p>
                        <p class="text-sm text-gray-700 mt-0.5">{{ $kerjasama->alamat_mitra }}</p>
                    </div>
                    @endif
                    @if($kerjasama->kontak_mitra)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kontak</p>
                        <p class="text-sm text-gray-700 mt-0.5">{{ $kerjasama->kontak_mitra }}</p>
                    </div>
                    @endif
                </div>
                <div class="space-y-3">
                    @if($kerjasama->tanggal_mulai)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Masa Berlaku</p>
                        <p class="text-sm text-gray-700 mt-0.5">
                            {{ $kerjasama->tanggal_mulai->translatedFormat('d F Y') }}
                            @if($kerjasama->tanggal_berakhir)
                            <span class="text-gray-400"> — </span>
                            {{ $kerjasama->tanggal_berakhir->translatedFormat('d F Y') }}
                            @endif
                        </p>
                        @if($kerjasama->status === 'aktif' && $kerjasama->sisa_hari !== null)
                        <p
                            class="text-xs mt-1 {{ $kerjasama->sisa_hari <= 30 ? 'text-orange-500 font-semibold' : 'text-emerald-600' }}">
                            {{ $kerjasama->sisa_hari > 0 ? $kerjasama->sisa_hari . ' hari lagi' : 'Berakhir hari ini' }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            @if($kerjasama->ruang_lingkup)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Ruang Lingkup</p>
                <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4">{{ $kerjasama->ruang_lingkup
                    }}</p>
            </div>
            @endif

            @if($kerjasama->keterangan)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keterangan</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-xl p-4">{{ $kerjasama->keterangan }}</p>
            </div>
            @endif

            @if($kerjasama->dokumen)
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Dokumen</p>
                <a href="{{ Storage::url($kerjasama->dokumen) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors border border-emerald-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Unduh Dokumen
                </a>
            </div>
            @endif

            <div class="text-xs text-gray-400 pt-2 border-t border-gray-100">
                Ditambahkan: {{ $kerjasama->created_at->translatedFormat('d F Y, H:i') }}
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex gap-3">
            <a href="{{ route('admin.kerjasama.edit', $kerjasama) }}"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.kerjasama.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-white text-sm font-medium transition-colors">
                ← Kembali
            </a>
        </div>
    </div>
</div>

@endsection