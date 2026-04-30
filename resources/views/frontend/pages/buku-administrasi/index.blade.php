@extends('layouts.app')

@section('title', 'Buku Administrasi Desa')
@section('description', 'Informasi buku-buku administrasi desa yang dapat diakses oleh masyarakat secara transparan.')

@section('content')

{{-- ── Header — pakai komponen standar seperti halaman frontend lainnya ── --}}
<x-hero-section
    title="Buku Administrasi Desa"
    subtitle="Informasi buku-buku administrasi desa yang terbuka dan dapat diakses oleh seluruh masyarakat secara transparan."
    :breadcrumb="[
        ['label' => 'Beranda',           'url' => route('home')],
        ['label' => 'Informasi',         'url' => '#'],
        ['label' => 'Buku Administrasi', 'url' => '#']
    ]"
/>

{{-- ── Kategori Grid ── --}}
<div class="bg-gray-50 min-h-screen pb-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @php
        $categoryIcons = [
            'umum'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
            'penduduk'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
            'pembangunan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        ];
        $categoryColors = [
            'umum'        => ['bg' => 'bg-emerald-600', 'light' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-600', 'hover' => 'hover:border-emerald-400 hover:shadow-emerald-100'],
            'penduduk'    => ['bg' => 'bg-blue-600',    'light' => 'bg-blue-50',    'border' => 'border-blue-200',    'text' => 'text-blue-600',    'hover' => 'hover:border-blue-400 hover:shadow-blue-100'],
            'pembangunan' => ['bg' => 'bg-amber-500',   'light' => 'bg-amber-50',   'border' => 'border-amber-200',   'text' => 'text-amber-600',   'hover' => 'hover:border-amber-400 hover:shadow-amber-100'],
        ];
        @endphp

        <div class="space-y-12">
            @foreach($kategoriList as $key => $kategori)
            @php
                $color = $categoryColors[$key] ?? $categoryColors['umum'];
                $icon  = $categoryIcons[$key]  ?? $categoryIcons['umum'];
            @endphp

            <div>
                {{-- Kategori Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 {{ $color['bg'] }} rounded-xl flex items-center justify-center shadow-sm flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $kategori['label'] }}</h2>
                            <p class="text-sm text-gray-500">{{ $kategori['deskripsi'] }}</p>
                        </div>
                    </div>
                    <a href="{{ route('buku-administrasi.kategori', $key) }}"
                       class="hidden sm:flex items-center gap-1 text-sm font-semibold {{ $color['text'] }} hover:underline flex-shrink-0">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Subkategori Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($kategori['subkategori'] as $subKey => $sub)
                    <a href="{{ route('buku-administrasi.show', ['kategori' => $key, 'subkategori' => $subKey]) }}"
                       class="group bg-white rounded-xl border {{ $color['border'] }} p-5 {{ $color['hover'] }} hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 {{ $color['light'] }} rounded-lg flex items-center justify-center flex-shrink-0 group-hover:{{ $color['bg'] }} transition-colors duration-300">
                                <svg class="w-5 h-5 {{ $color['text'] }} group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-800 group-hover:{{ $color['text'] }} transition-colors text-sm leading-tight">{{ $sub['label'] }}</h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $sub['desc'] }}</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t {{ $color['border'] }} flex items-center justify-end">
                            <span class="text-xs font-semibold {{ $color['text'] }} flex items-center gap-1">
                                Lihat Data
                                <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Mobile: Lihat Semua --}}
                <div class="sm:hidden mt-4 text-center">
                    <a href="{{ route('buku-administrasi.kategori', $key) }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold {{ $color['text'] }}">
                        Lihat Semua {{ $kategori['label'] }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            @if(!$loop->last)
            <hr class="border-gray-200">
            @endif
            @endforeach
        </div>

    </div>
</div>

@endsection
