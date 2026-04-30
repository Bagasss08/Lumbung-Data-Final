@extends('layouts.app')

@section('title', $config['label'] . ' - Buku Administrasi Desa')

@section('content')

@php
$colorMap = [
    'umum'        => ['bg'=>'bg-emerald-600','light'=>'bg-emerald-50','border'=>'border-emerald-200','text'=>'text-emerald-600','badge'=>'bg-emerald-100 text-emerald-700','hover'=>'hover:border-emerald-400 hover:shadow-emerald-100'],
    'penduduk'    => ['bg'=>'bg-blue-600',   'light'=>'bg-blue-50',   'border'=>'border-blue-200',   'text'=>'text-blue-600',   'badge'=>'bg-blue-100 text-blue-700',   'hover'=>'hover:border-blue-400 hover:shadow-blue-100'],
    'pembangunan' => ['bg'=>'bg-amber-500',  'light'=>'bg-amber-50',  'border'=>'border-amber-200',  'text'=>'text-amber-600',  'badge'=>'bg-amber-100 text-amber-700', 'hover'=>'hover:border-amber-400 hover:shadow-amber-100'],
];
$color = $colorMap[$kategori] ?? $colorMap['umum'];

$categoryIcons = [
    'umum'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
    'penduduk'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
    'pembangunan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
];
$icon = $categoryIcons[$kategori] ?? $categoryIcons['umum'];
@endphp

{{-- Header --}}
<x-hero-section
    :title="$config['label']"
    :subtitle="$config['deskripsi']"
    :breadcrumb="[
        ['label' => 'Beranda',           'url' => route('home')],
        ['label' => 'Informasi',         'url' => '#'],
        ['label' => 'Buku Administrasi', 'url' => route('buku-administrasi.index')],
        ['label' => $config['label'],    'url' => '#']
    ]"
/>

{{-- Subkategori Cards --}}
<div class="bg-gray-50 min-h-screen pb-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <p class="text-sm text-gray-500 mb-6">Pilih buku administrasi yang ingin Anda lihat datanya:</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($config['subkategori'] as $subKey => $sub)
            <a href="{{ route('buku-administrasi.show', ['kategori' => $kategori, 'subkategori' => $subKey]) }}"
               class="group bg-white rounded-xl border {{ $color['border'] }} p-6 {{ $color['hover'] }} hover:shadow-lg transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 {{ $color['light'] }} rounded-xl flex items-center justify-center flex-shrink-0 group-hover:{{ $color['bg'] }} transition-colors duration-300">
                        <svg class="w-6 h-6 {{ $color['text'] }} group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 group-hover:{{ $color['text'] }} transition-colors leading-snug">{{ $sub['label'] }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $sub['desc'] }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t {{ $color['border'] }} flex items-center justify-between">
                    <span class="{{ $color['badge'] }} text-xs font-semibold px-2 py-0.5 rounded-full">{{ ucfirst($kategori) }}</span>
                    <span class="text-xs font-semibold {{ $color['text'] }} flex items-center gap-1">
                        Lihat Data
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('buku-administrasi.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Semua Kategori
            </a>
        </div>
    </div>
</div>

@endsection
