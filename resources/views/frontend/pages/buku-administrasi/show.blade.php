@extends('layouts.app')

@section('title', $subConfig['label'] . ' - Buku Administrasi Desa')
@section('description', $subConfig['desc'])

@section('content')

@php
$colorMap = [
    'umum'        => ['bg'=>'bg-emerald-600','light'=>'bg-emerald-50','border'=>'border-emerald-200','text'=>'text-emerald-600','ring'=>'focus:ring-emerald-500 focus:border-emerald-500','btn'=>'bg-emerald-600 hover:bg-emerald-700','badge_ok'=>'bg-emerald-100 text-emerald-800','hover_row'=>'hover:bg-emerald-50'],
    'penduduk'    => ['bg'=>'bg-blue-600',   'light'=>'bg-blue-50',   'border'=>'border-blue-200',   'text'=>'text-blue-600',   'ring'=>'focus:ring-blue-500 focus:border-blue-500',   'btn'=>'bg-blue-600 hover:bg-blue-700',   'badge_ok'=>'bg-blue-100 text-blue-800',   'hover_row'=>'hover:bg-blue-50'],
    'pembangunan' => ['bg'=>'bg-amber-500',  'light'=>'bg-amber-50',  'border'=>'border-amber-200',  'text'=>'text-amber-600',  'ring'=>'focus:ring-amber-500 focus:border-amber-500',  'btn'=>'bg-amber-500 hover:bg-amber-600',  'badge_ok'=>'bg-amber-100 text-amber-800',  'hover_row'=>'hover:bg-amber-50'],
];
$c = $colorMap[$kategori] ?? $colorMap['umum'];

$categoryIcons = [
    'umum'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
    'penduduk'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
    'pembangunan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
];
$icon = $categoryIcons[$kategori] ?? $categoryIcons['umum'];
@endphp

{{-- ── Header Section — pakai komponen standar ── --}}
<x-hero-section
    :title="$subConfig['label']"
    :subtitle="$subConfig['desc']"
    :breadcrumb="[
        ['label' => 'Beranda',                   'url' => route('home')],
        ['label' => 'Informasi',                 'url' => '#'],
        ['label' => 'Buku Administrasi',          'url' => route('buku-administrasi.index')],
        ['label' => $kategoriConfig['label'],     'url' => route('buku-administrasi.kategori', $kategori)],
        ['label' => $subConfig['label'],          'url' => '#']
    ]"
/>

{{-- ── Content ── --}}
<div class="bg-gray-50 min-h-screen pb-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Search & Info Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <form action="{{ route('buku-administrasi.show', ['kategori' => $kategori, 'subkategori' => $subkategori]) }}"
                      method="GET"
                      class="flex gap-2 w-full sm:w-auto">
                    <div class="relative flex-grow sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="cari" value="{{ $cari }}"
                               placeholder="Cari data..."
                               class="pl-9 pr-4 py-2 w-full text-sm border border-gray-300 rounded-lg {{ $c['ring'] }} transition-colors">
                    </div>
                    <button type="submit"
                            class="{{ $c['btn'] }} text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex-shrink-0">
                        Cari
                    </button>
                    @if($cari)
                    <a href="{{ route('buku-administrasi.show', ['kategori' => $kategori, 'subkategori' => $subkategori]) }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors flex-shrink-0">
                        Reset
                    </a>
                    @endif
                </form>

                <div class="flex items-center gap-4 text-sm text-gray-500 flex-shrink-0">
                    @if($cari)
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                        Filter: <span class="font-semibold text-gray-700">"{{ $cari }}"</span>
                    </span>
                    @endif
                    <span>
                        Total: <span class="font-bold text-gray-900">{{ $data->total() }}</span> data
                    </span>
                </div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                            @foreach($columns as $header => $field)
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                {{ $header }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($data as $index => $item)
                        <tr class="{{ $c['hover_row'] }} transition-colors duration-150">
                            <td class="px-5 py-4 text-sm text-gray-400 font-medium">
                                {{ $data->firstItem() + $index }}
                            </td>
                            @foreach($columns as $header => $field)
                            <td class="px-5 py-4 text-sm text-gray-700">
                                @php
                                    $val = $item->{$field} ?? null;
                                @endphp

                                {{-- Boolean / aktif --}}
                                @if($field === 'is_aktif' || $field === 'status')
                                    @if($val === true || $val === 'Aktif' || $val === 1)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @elseif($val === false || $val === 'Tidak Aktif' || $val === 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Tidak Aktif
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif

                                {{-- Jenis Mutasi --}}
                                @elseif($field === 'jenis_mutasi')
                                    @if($val === 'pindah_masuk')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                            Masuk
                                        </span>
                                    @elseif($val === 'pindah_keluar')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                            Keluar
                                        </span>
                                    @else
                                        {{ $val ?? '-' }}
                                    @endif

                                {{-- Status Hidup --}}
                                @elseif($field === 'status_hidup')
                                    @php
                                        $statusLabel = [
                                            'hidup'       => ['label'=>'Hidup',      'class'=>'bg-emerald-100 text-emerald-800'],
                                            'mati'        => ['label'=>'Meninggal',  'class'=>'bg-gray-100 text-gray-600'],
                                            'pindah'      => ['label'=>'Pindah',     'class'=>'bg-blue-100 text-blue-800'],
                                            'tidak_valid' => ['label'=>'Tdk Valid',  'class'=>'bg-red-100 text-red-700'],
                                        ];
                                        $sl = $statusLabel[$val] ?? ['label'=>ucfirst($val??'-'), 'class'=>'bg-gray-100 text-gray-600'];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $sl['class'] }}">{{ $sl['label'] }}</span>

                                {{-- Jenis Kelamin --}}
                                @elseif($field === 'jenis_kelamin')
                                    @if($val === 'L')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            Laki-laki
                                        </span>
                                    @elseif($val === 'P')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-800">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            Perempuan
                                        </span>
                                    @else
                                        {{ $val ?? '-' }}
                                    @endif

                                {{-- Kondisi Inventaris --}}
                                @elseif($field === 'kondisi')
                                    @php
                                        $kondisiClass = match($val) {
                                            'Baik'         => 'bg-emerald-100 text-emerald-800',
                                            'Rusak Ringan' => 'bg-amber-100 text-amber-800',
                                            'Rusak Berat'  => 'bg-red-100 text-red-800',
                                            default        => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $kondisiClass }}">{{ $val ?? '-' }}</span>

                                {{-- Tanggal --}}
                                @elseif(str_contains($field, 'tanggal') || str_contains($field, 'tgl') || str_contains($field, 'tahun_aktif'))
                                    {{ $val ? \Carbon\Carbon::parse($val)->isoFormat('D MMM YYYY') : '-' }}

                                {{-- Tahun Anggaran --}}
                                @elseif($field === 'tahun_anggaran' || $field === 'tahun_pengadaan' || $field === 'tahun_aktif')
                                    {{ $val ?? '-' }}

                                {{-- Teks panjang --}}
                                @elseif(in_array($field, ['tentang','isi_singkat','uraian_singkat','sasaran','keterangan','disposisi','alamat','desc']))
                                    <span class="line-clamp-2 max-w-xs" title="{{ $val ?? '' }}">{{ $val ?? '-' }}</span>

                                {{-- NIK — sensor sebagian untuk privasi --}}
                                @elseif($field === 'nik')
                                    @if($val)
                                        <span class="font-mono text-xs tracking-wider">{{ substr($val, 0, 6) }}••••••••••</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif

                                {{-- Default --}}
                                @else
                                    {{ $val ?? '-' }}
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 {{ $c['light'] }} rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 {{ $c['text'] }} opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-gray-700 mb-1">Belum ada data</p>
                                    <p class="text-sm text-gray-400">
                                        @if($cari)
                                            Tidak ditemukan data untuk pencarian "<span class="font-medium">{{ $cari }}</span>"
                                        @else
                                            Data {{ $subConfig['label'] }} belum tersedia.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($data->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                {{ $data->appends(['cari' => $cari])->links() }}
            </div>
            @endif
        </div>

        {{-- Navigation --}}
        <div class="mt-6 flex items-center justify-between text-sm">
            <a href="{{ route('buku-administrasi.kategori', $kategori) }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:{{ $c['text'] }} transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke {{ $kategoriConfig['label'] }}
            </a>
            <a href="{{ route('buku-administrasi.index') }}"
               class="inline-flex items-center gap-2 text-gray-500 hover:{{ $c['text'] }} transition-colors">
                Semua Kategori
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</div>

@endsection
