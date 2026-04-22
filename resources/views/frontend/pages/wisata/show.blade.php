@extends('layouts.app')

@section('title', ($wisata->nama ?? 'Detail Wisata') . ' - Wisata Desa')
@section('description', \Illuminate\Support\Str::limit($wisata->deskripsi ?? '', 150))

@section('content')

    {{-- PAGE HERO (style seperti halaman Berita: left-aligned, breadcrumb dalam hero) --}}
    <div class="relative bg-emerald-900 overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-20">

        {{-- Background image --}}
        @if($wisata->gambar)
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('storage/wisata/' . $wisata->gambar) }}" alt="{{ $wisata->nama }}"
                    class="w-full h-full object-cover opacity-40">
            </div>
        @endif

        {{-- Overlay gelap --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/95 via-emerald-900/85 to-teal-900/75 z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 z-0"></div>

        <div class="container mx-auto px-4 relative z-10">

            {{-- Breadcrumb dalam hero --}}
            <nav class="flex items-center gap-2 text-sm mb-6">
                <a href="{{ route('home') }}"
                    class="text-emerald-200 hover:text-white transition font-medium">Beranda</a>
                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('wisata') }}"
                    class="px-2.5 py-0.5 bg-emerald-700/70 border border-emerald-600/50 text-emerald-100 text-xs font-bold rounded uppercase tracking-wider hover:bg-emerald-600/70 transition">
                    WISATA
                </a>
            </nav>

            {{-- Judul --}}
            <h1 class="text-3xl lg:text-5xl font-extrabold text-white mb-5 tracking-tight max-w-3xl leading-tight">
                {{ $wisata->nama }}
            </h1>

            {{-- Subtitle dengan left border (seperti screenshot) --}}
            <div class="border-l-4 border-emerald-400 pl-4 max-w-xl">
                <p class="text-emerald-100 text-sm lg:text-base leading-relaxed">
                    @if($wisata->lokasi)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $wisata->lokasi }}
                            @if($wisata->kategori)
                                &nbsp;·&nbsp; {{ $wisata->kategori }}
                            @endif
                        </span>
                    @elseif($wisata->kategori)
                        {{ $wisata->kategori }}
                    @else
                        Wisata Desa
                    @endif
                </p>
            </div>

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
                            <img src="{{ asset('storage/wisata/' . $wisata->gambar) }}" alt="{{ $wisata->nama }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="rounded-2xl bg-emerald-50 border-2 border-dashed border-emerald-200 mb-8 aspect-video flex items-center justify-center">
                            <svg class="w-20 h-20 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    {{-- ⭐ RATING RATA-RATA --}}
                    @if($avgRating)
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path
                                            fill="{{ $i <= round($avgRating) ? '#FBBF24' : 'none' }}"
                                            stroke="{{ $i <= round($avgRating) ? '#FBBF24' : '#D1D5DB' }}"
                                            stroke-width="1.5"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26h6.588c.969 0 1.371 1.24.588 1.81l-5.329 3.87 2.036 6.26c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.332 3.868c-.783.57-1.838-.197-1.538-1.118l2.036-6.26-5.329-3.87c-.783-.57-.38-1.81.588-1.81h6.588l2.036-6.26z"
                                        />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">
                                {{ number_format($avgRating, 1) }} / 5
                                <span class="text-gray-400">({{ $ulasan->count() }} ulasan)</span>
                            </span>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 mb-4">Belum ada rating</p>
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

                    {{-- ULASAN --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-6 bg-emerald-500 rounded-full inline-block"></span>
                            Ulasan Pengunjung
                        </h2>

                        @forelse($ulasan as $item)
                            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-semibold text-gray-800">{{ $item->nama }}</p>
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                                <path
                                                    fill="{{ $i <= (int)($item->rating ?? 0) ? '#FBBF24' : 'none' }}"
                                                    stroke="{{ $i <= (int)($item->rating ?? 0) ? '#FBBF24' : '#D1D5DB' }}"
                                                    stroke-width="1.5"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26h6.588c.969 0 1.371 1.24.588 1.81l-5.329 3.87 2.036 6.26c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.332 3.868c-.783.57-1.838-.197-1.538-1.118l2.036-6.26-5.329-3.87c-.783-.57-.38-1.81.588-1.81h6.588l2.036-6.26z"
                                                />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm">{{ $item->komentar }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</p>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm">Belum ada ulasan. Jadilah yang pertama memberi ulasan!</p>
                        @endforelse
                    </div>

                    {{-- FORM TULIS ULASAN & RATING --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <span class="w-1 h-6 bg-yellow-400 rounded-full inline-block"></span>
                            Tulis Ulasan
                        </h2>

                        @if(session('success'))
                            <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('wisata.ulasan.store', $wisata->id) }}" method="POST" class="space-y-5">
                            @csrf

                            {{-- Nama --}}
                            <div>
                                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Nama Anda <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                    placeholder="Masukkan nama Anda"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition @error('nama') border-red-400 @enderror"
                                    required>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Pilih Bintang --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Rating <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-1" id="star-rating-container">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" data-value="{{ $i }}"
                                            class="star-btn w-9 h-9 transition-transform hover:scale-110 focus:outline-none"
                                            aria-label="Beri {{ $i }} bintang">
                                            <svg viewBox="0 0 24 24" class="w-full h-full">
                                                <path
                                                    fill="none"
                                                    stroke="#D1D5DB"
                                                    stroke-width="1.5"
                                                    class="star-path"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26h6.588c.969 0 1.371 1.24.588 1.81l-5.329 3.87 2.036 6.26c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.332 3.868c-.783.57-1.838-.197-1.538-1.118l2.036-6.26-5.329-3.87c-.783-.57-.38-1.81.588-1.81h6.588l2.036-6.26z"
                                                />
                                            </svg>
                                        </button>
                                    @endfor
                                    <span id="rating-label" class="text-sm text-gray-500 ml-2">Pilih rating</span>
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="{{ old('rating', 0) }}" required>
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Komentar --}}
                            <div>
                                <label for="komentar" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Komentar <span class="text-red-500">*</span>
                                </label>
                                <textarea id="komentar" name="komentar" rows="4"
                                    placeholder="Ceritakan pengalaman Anda mengunjungi tempat ini..."
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition resize-none @error('komentar') border-red-400 @enderror"
                                    required>{{ old('komentar') }}</textarea>
                                @error('komentar')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="flex items-center gap-3 pt-1">
                                <button type="submit" id="submit-ulasan-btn"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-500 transition-all duration-200 text-sm shadow-sm shadow-emerald-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Ulasan
                                </button>
                                <span id="rating-required-msg" class="text-xs text-red-500 hidden">
                                    Silakan pilih rating bintang terlebih dahulu.
                                </span>
                            </div>
                        </form>
                    </div>

                    {{-- ✅ Fasilitas — FIX: support JSON array string & comma-separated string --}}
                    @if($wisata->fasilitas)
                        @php
                            if (is_array($wisata->fasilitas)) {
                                $fasilitasList = $wisata->fasilitas;
                            } else {
                                $decoded = json_decode($wisata->fasilitas, true);
                                $fasilitasList = is_array($decoded)
                                    ? $decoded
                                    : array_filter(array_map('trim', explode(',', $wisata->fasilitas)));
                            }
                        @endphp

                        @if(!empty($fasilitasList))
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 mb-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                                    <span class="w-1 h-6 bg-emerald-500 rounded-full inline-block"></span>
                                    Fasilitas
                                </h2>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($fasilitasList as $fasilitas)
                                        <div class="flex items-center gap-2.5 p-3 bg-emerald-50 rounded-xl">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ trim($fasilitas) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('wisata') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:border-emerald-300 hover:text-emerald-700 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Harga Tiket</p>
                                    <p class="text-emerald-600 font-bold text-base">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                                </div>
                            </div>

                            {{-- Rating Ringkasan --}}
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path
                                            fill="#FBBF24"
                                            stroke="#FBBF24"
                                            stroke-width="1"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26h6.588c.969 0 1.371 1.24.588 1.81l-5.329 3.87 2.036 6.26c.3.921-.755 1.688-1.538 1.118L12 18.347l-5.332 3.868c-.783.57-1.838-.197-1.538-1.118l2.036-6.26-5.329-3.87c-.783-.57-.38-1.81.588-1.81h6.588l2.036-6.26z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wide mb-0.5">Rating</p>
                                    @if($avgRating)
                                        <p class="font-bold text-base" style="color: #F59E0B;">
                                            {{ number_format($avgRating, 1) }}
                                            <span class="text-gray-400 font-normal text-sm">/ 5</span>
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $ulasan->count() }} ulasan</p>
                                    @else
                                        <p class="text-gray-400 font-medium text-sm">Belum ada rating</p>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="my-5 border-t border-gray-100"></div>

                        {{-- CTA --}}
                        <a href="{{ route('kontak') }}"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-500 transition-all duration-200 text-sm shadow-sm shadow-emerald-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
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
                                                <img src="{{ asset('storage/wisata/' . $lain->gambar) }}" alt="{{ $lain->nama }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 group-hover:text-emerald-600 transition line-clamp-1">
                                                {{ $lain->nama }}</p>
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

    {{-- ⭐ JAVASCRIPT: Interactive Star Rating --}}
    <script>
        (function () {
            const container   = document.getElementById('star-rating-container');
            const hiddenInput = document.getElementById('rating-value');
            const label       = document.getElementById('rating-label');
            const requiredMsg = document.getElementById('rating-required-msg');

            if (!container) return;

            const starBtns = container.querySelectorAll('.star-btn');
            const labels   = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Bagus', 'Sangat Bagus'];

            let currentRating = parseInt(hiddenInput.value) || 0;

            if (currentRating > 0) setRating(currentRating);

            starBtns.forEach(function (btn) {
                btn.addEventListener('mouseenter', function () {
                    const val = parseInt(btn.dataset.value);
                    highlightStars(val);
                    label.textContent = labels[val];
                });
                btn.addEventListener('mouseleave', function () {
                    highlightStars(currentRating);
                    label.textContent = currentRating > 0 ? labels[currentRating] : 'Pilih rating';
                });
                btn.addEventListener('click', function () {
                    const val = parseInt(btn.dataset.value);
                    currentRating = val;
                    hiddenInput.value = val;
                    setRating(val);
                    requiredMsg.classList.add('hidden');
                });
            });

            const form = container.closest('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    if (!currentRating || currentRating < 1) {
                        e.preventDefault();
                        requiredMsg.classList.remove('hidden');
                        container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }

            function setRating(val) {
                highlightStars(val);
                label.textContent = labels[val] || 'Pilih rating';
            }

            function highlightStars(val) {
                starBtns.forEach(function (btn) {
                    const path   = btn.querySelector('.star-path');
                    const btnVal = parseInt(btn.dataset.value);
                    if (btnVal <= val) {
                        path.setAttribute('fill', '#FBBF24');
                        path.setAttribute('stroke', '#FBBF24');
                    } else {
                        path.setAttribute('fill', 'none');
                        path.setAttribute('stroke', '#D1D5DB');
                    }
                });
            }
        })();
    </script>

@endsection