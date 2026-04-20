@extends('layouts.app')

@section('title', 'Wisata Desa')
@section('description', 'Jelajahi destinasi wisata unggulan yang ada di desa kami')

@section('content')

{{-- Ganti blok PAGE HERO yang lama dengan ini --}}
<x-hero-section 
    title="Wisata Desa"
    subtitle="Temukan keindahan alam, budaya, dan potensi wisata unggulan yang ada di desa kami."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Wisata Desa', 'url' => '#']
    ]"
/>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Beranda</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 font-medium">Wisata Desa</span>
        </nav>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<section class="py-16 bg-gray-50 relative">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-12">

            {{-- KOLOM KIRI: Main Content --}}
            <div class="lg:w-2/3">

                {{-- Sticky Filter + Search --}}
                <div class="sticky top-20 z-30 bg-gray-50/95 backdrop-blur-md py-4 -mx-4 px-4 mb-8 border-b border-gray-200 transition-all duration-300">

                    {{-- Search --}}
                    <div class="mb-4">
                        <form action="{{ route('wisata') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari destinasi wisata..."
                                   class="w-full pl-12 pr-28 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition outline-none text-sm shadow-sm bg-white">
                            <button type="submit"
                                    class="absolute right-1.5 top-1.5 bottom-1.5 bg-emerald-600 text-white px-5 rounded-lg font-semibold text-sm hover:bg-emerald-700 transition shadow-sm">
                                Cari
                            </button>
                        </form>
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        @php
                            $kategoriList = [
                                'Semua'          => 'Semua',
                                'Wisata Alam'    => 'Wisata Alam',
                                'Wisata Budaya'  => 'Wisata Budaya',
                                'Wisata Kuliner' => 'Wisata Kuliner',
                                'Wisata Edukasi' => 'Wisata Edukasi',
                                'Wisata Religi'  => 'Wisata Religi',
                            ];
                            $aktifKategori = request('kategori', 'Semua');
                        @endphp
                        @foreach($kategoriList as $key => $label)
                            <a href="{{ route('wisata', array_filter(['kategori' => $key !== 'Semua' ? $key : null, 'search' => request('search')])) }}"
                               class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap border
                               {{ ($aktifKategori === $key || ($key === 'Semua' && !request('kategori')))
                                   ? 'bg-emerald-600 text-white border-emerald-600 shadow-md'
                                   : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-300 hover:text-emerald-600' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($wisataList->count() > 0)

                    {{-- Grid Wisata --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        @foreach($wisataList as $wisata)
                            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:-translate-y-1 flex flex-col">

                                {{-- Gambar --}}
                                <div class="relative h-52 overflow-hidden bg-gray-100 flex-shrink-0">
                                    @if($wisata->gambar)
                                        <img src="{{ asset('storage/wisata/' . $wisata->gambar) }}"
                                             alt="{{ $wisata->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-emerald-50">
                                            <svg class="w-16 h-16 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                                    {{-- Badge Kategori --}}
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-emerald-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                            {{ $wisata->kategori }}
                                        </span>
                                    </div>

                                    {{-- Badge Harga --}}
                                    <div class="absolute bottom-3 right-3">
                                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold rounded-full">
                                            {{ $wisata->harga_tiket ?? 'Gratis' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Konten --}}
                                <div class="p-5 flex flex-col flex-1">
                                    <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition line-clamp-1">
                                        {{ $wisata->nama }}
                                    </h3>
                                    <p class="text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2 flex-1">
                                        {{ \Illuminate\Support\Str::limit($wisata->deskripsi ?? '', 100) }}
                                    </p>

                                    <div class="space-y-1.5 mb-4">
                                        @if($wisata->lokasi)
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="truncate">{{ $wisata->lokasi }}</span>
                                            </div>
                                        @endif
                                        @if($wisata->jam_buka)
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <svg class="w-3.5 h-3.5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span>{{ $wisata->jam_buka }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-3 border-t border-gray-100">
                                        <a href="{{ route('wisata.show', $wisata->id) }}"
                                           class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-50 text-emerald-700 font-semibold text-sm rounded-xl hover:bg-emerald-600 hover:text-white transition-all duration-200 group/btn">
                                            Lihat Detail
                                            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12 flex justify-center pb-8">
                        {{ $wisataList->appends(request()->query())->links('pagination::tailwind') }}
                    </div>

                @else

                    {{-- Empty State --}}
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 mt-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-6 text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6 text-sm">
                            @if(request('search') || request('kategori'))
                                Tidak ada wisata yang cocok dengan pencarian Anda.
                            @else
                                Destinasi wisata desa akan segera hadir. Pantau terus website kami.
                            @endif
                        </p>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('wisata') }}"
                               class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-emerald-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset Filter
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-500 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Kembali ke Beranda
                            </a>
                        @endif
                    </div>

                @endif
            </div>

            {{-- KOLOM KANAN: Sidebar --}}
            <div class="lg:w-1/3 space-y-8">

                {{-- Widget: Wisata Unggulan --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Wisata Unggulan</h3>
                    </div>

                    <div class="space-y-6">
                        @forelse($wisataUnggulan ?? [] as $item)
                            <a href="{{ route('wisata.show', $item->id) }}" class="flex gap-4 group">
                                <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden relative shadow-sm border border-gray-100">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/wisata/' . $item->gambar) }}"
                                             alt="{{ $item->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @else
                                        <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 py-1">
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded mb-1.5 inline-block">
                                        {{ $item->kategori }}
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition line-clamp-2 leading-snug mb-1">
                                        {{ $item->nama }}
                                    </h4>
                                    @if($item->lokasi)
                                        <p class="text-xs text-gray-400 flex items-center gap-1 truncate">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $item->lokasi }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-400 text-center py-4">Belum ada wisata unggulan.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Widget: Kategori Wisata --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-teal-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Kategori</h3>
                    </div>

                    <div class="space-y-2">
                        @php
                            $kategoriSidebar = [
                                ['key' => 'Wisata Alam',    'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
                                ['key' => 'Wisata Budaya',  'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                                ['key' => 'Wisata Kuliner', 'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'],
                                ['key' => 'Wisata Edukasi', 'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222'],
                                ['key' => 'Wisata Religi',  'icon' => 'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
                            ];
                        @endphp
                        @foreach($kategoriSidebar as $kat)
                            <a href="{{ route('wisata', ['kategori' => $kat['key']]) }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
                               {{ request('kategori') === $kat['key']
                                   ? 'bg-emerald-50 text-emerald-700'
                                   : 'hover:bg-gray-50 text-gray-600 hover:text-emerald-600' }}">
                                <svg class="w-4 h-4 flex-shrink-0 {{ request('kategori') === $kat['key'] ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kat['icon'] }}"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $kat['key'] }}</span>
                                <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Widget: CTA Hubungi --}}
                <div class="bg-gradient-to-br from-emerald-700 to-teal-800 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg group">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-125 transition duration-700"></div>
                    <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-24 h-24 bg-teal-400 opacity-20 rounded-full blur-xl"></div>

                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-5 backdrop-blur-sm border border-white/20 shadow-inner">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Ingin Berwisata?</h3>
                        <p class="text-emerald-100 text-sm mb-6 leading-relaxed">
                            Hubungi perangkat desa untuk informasi lebih lanjut mengenai paket wisata dan jadwal kunjungan.
                        </p>
                        <a href="{{ route('kontak') }}"
                           class="inline-flex items-center justify-center w-full px-4 py-3 bg-white text-emerald-800 font-bold rounded-xl text-sm hover:bg-emerald-50 transition shadow-lg transform hover:-translate-y-0.5 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

            </div>
            {{-- END Sidebar --}}

        </div>
    </div>
</section>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection