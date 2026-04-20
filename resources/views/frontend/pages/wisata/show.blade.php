@extends('layouts.app')

@section('title', ($wisata->nama ?? 'Detail Wisata') . ' - Wisata Desa')
@section('description', \Illuminate\Support\Str::limit($wisata->deskripsi ?? '', 150))

@section('content')

{{-- PAGE HERO --}}
<div class="relative bg-emerald-900 overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-20">
    @if($wisata->gambar)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/wisata/' . $wisata->gambar) }}"
                 alt="{{ $wisata->nama }}"
                 class="w-full h-full object-cover opacity-40">
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/95 via-emerald-900/90 to-teal-900/80 z-0"></div>
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 z-0"></div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <span class="inline-flex px-3 py-1 bg-emerald-700/60 border border-emerald-600/50 text-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider mb-4">
            {{ $wisata->kategori ?? 'Wisata Desa' }}
        </span>
        <h1 class="text-3xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight">{{ $wisata->nama }}</h1>
        @if($wisata->lokasi)
            <p class="text-emerald-200 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $wisata->lokasi }}
            </p>
        @endif
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-gray-100">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition">Beranda</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('wisata') }}" class="hover:text-emerald-600 transition">Wisata Desa</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $wisata->nama }}</span>
        </nav>
    </div>
</div>

{{-- KONTEN UTAMA --}}
<section class="py-12 lg:py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-12 items-start">

            {{-- KIRI: KONTEN UTAMA --}}
            <div class="lg:w-2/3 w-full">

                {{-- Gambar Utama --}}
                @if($wisata->gambar)
                    <div class="rounded-2xl overflow-hidden shadow-md mb-8 aspect-video bg-gray-100">
                        <img src="{{ asset('storage/wisata/' . $wisata->gambar) }}"
                             alt="{{ $wisata->nama }}"
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="rounded-2xl bg-emerald-50 border-2 border-dashed border-emerald-200 mb-8 aspect-video flex items-center justify-center">
                        <svg class="w-20 h-20 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                {{-- Deskripsi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-emerald-500 rounded-full inline-block"></span>
                        Tentang Wisata Ini
                    </h2>
                    <div class="prose prose-emerald max-w-none text-gray-600 leading-loose">
                        {!! nl2br(e($wisata->deskripsi ?? 'Deskripsi belum tersedia.')) !!}
                    </div>
                </div>

                {{-- Fasilitas --}}
                @if($wisata->fasilitas)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-6 bg-emerald-500 rounded-full inline-block"></span>
                            Fasilitas
                        </h2>
                        @php
                            $fasilitasList = is_array($wisata->fasilitas)
                                ? $wisata->fasilitas
                                : array_filter(array_map('trim', explode(',', $wisata->fasilitas)));
                        @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($fasilitasList as $fasilitas)
                                <div class="flex items-center gap-2.5 p-3 bg-emerald-50 rounded-xl">
                                    <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ trim($fasilitas) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Tombol Kembali --}}
                <a href="{{ route('wisata') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-emerald-300 hover:text-emerald-700 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Wisata
                </a>

            </div>

            {{-- KANAN: INFO BOX --}}
            <div class="lg:w-1/3 w-full">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-900 mb-5 pb-4 border-b border-gray-100">
                        Informasi Wisata
                    </h3>

                    <div class="space-y-4">

                        {{-- Kategori --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Kategori</p>
                                <p class="text-gray-800 font-semibold text-sm">{{ $wisata->kategori ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        @if($wisata->lokasi)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Lokasi</p>
                                    <p class="text-gray-800 font-semibold text-sm">{{ $wisata->lokasi }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Jam Buka --}}
                        @if($wisata->jam_buka)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0 text-amber-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Jam Buka</p>
                                    <p class="text-gray-800 font-semibold text-sm">{{ $wisata->jam_buka }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Harga Tiket --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0 text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Harga Tiket</p>
                                <p class="text-emerald-600 font-bold text-base">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                            </div>
                        </div>

                    </div>

                    {{-- Divider --}}
                    <div class="my-5 border-t border-gray-100"></div>

                    {{-- CTA --}}
                    <a href="{{ route('kontak') }}"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-500 transition-all duration-200 text-sm shadow-sm shadow-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>

                {{-- Wisata Lain --}}
                @if(isset($wisataLain) && $wisataLain->count() > 0)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Wisata Lainnya</h3>
                        <div class="space-y-3">
                            @foreach($wisataLain as $lain)
                                <a href="{{ route('wisata.show', $lain->id) }}"
                                   class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition group">
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                                        @if($lain->gambar)
                                            <img src="{{ asset('storage/wisata/' . $lain->gambar) }}"
                                                 alt="{{ $lain->nama }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-emerald-600 transition line-clamp-1">{{ $lain->nama }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $lain->kategori }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection