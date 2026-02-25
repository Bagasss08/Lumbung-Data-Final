@extends('layouts.app')

@section('title', 'Lapak Warga')
@section('description', 'Temukan produk dan usaha warga desa kami. Dukung ekonomi lokal dengan berbelanja dari lapak
warga.')

@section('content')

<x-hero-section title="Lapak Warga"
    subtitle="Temukan produk unggulan dan usaha kreatif warga desa. Dukung ekonomi lokal, belanja dari tetangga sendiri."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Lapak', 'url' => '#']
    ]" />

<section class="py-16 bg-gray-50 relative">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-12">

            {{-- KONTEN UTAMA --}}
            <div class="lg:w-2/3">

                {{-- Search Bar --}}
                <div
                    class="sticky top-20 z-30 bg-gray-50/95 backdrop-blur-md py-4 -mx-4 px-4 mb-8 border-b border-gray-200">
                    <form action="{{ route('lapak') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama toko atau produk..."
                            class="w-full pl-12 pr-28 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition outline-none text-sm shadow-sm bg-white">
                        <button type="submit"
                            class="absolute right-1.5 top-1.5 bottom-1.5 bg-emerald-600 text-white px-5 rounded-lg font-semibold text-sm hover:bg-emerald-700 transition shadow-sm">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Grid Lapak --}}
                @if($lapakList->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    @foreach($lapakList as $lapak)
                    <a href="{{ route('lapak.show', $lapak->slug) }}"
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-100 transition-all duration-300">

                        {{-- Foto Toko --}}
                        <div class="relative h-44 bg-gray-100 overflow-hidden">
                            <img src="{{ $lapak->foto_url }}" alt="{{ $lapak->nama_toko }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            {{-- Badge jumlah produk --}}
                            <div class="absolute top-3 right-3">
                                <span
                                    class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold rounded-full shadow-sm border border-emerald-100">
                                    {{ $lapak->produk_aktif_count }} produk
                                </span>
                            </div>
                        </div>

                        {{-- Info Toko --}}
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 text-lg group-hover:text-emerald-600 transition mb-1">
                                {{ $lapak->nama_toko }}
                            </h3>

                            {{-- Pemilik --}}
                            <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $lapak->penduduk->nama ?? '-' }}</span>
                            </div>

                            {{-- Alamat --}}
                            @if($lapak->alamat)
                            <div class="flex items-start gap-1.5 text-sm text-gray-500 mb-3">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="line-clamp-1">{{ $lapak->alamat }}</span>
                            </div>
                            @endif

                            {{-- Deskripsi --}}
                            @if($lapak->deskripsi)
                            <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $lapak->deskripsi }}</p>
                            @endif

                            {{-- CTA --}}
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                @if($lapak->telepon)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lapak->telepon) }}"
                                    target="_blank" onclick="event.stopPropagation()"
                                    class="flex items-center gap-1.5 text-xs font-medium text-green-600 hover:text-green-700 transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                    </svg>
                                    WhatsApp
                                </a>
                                @else
                                <span></span>
                                @endif

                                <span
                                    class="text-xs font-semibold text-emerald-600 group-hover:gap-2 flex items-center gap-1 transition-all">
                                    Lihat Produk
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4 flex justify-center pb-8">
                    {{ $lapakList->appends(request()->query())->links('pagination::tailwind') }}
                </div>

                @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 mt-8">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-6 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Lapak</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search'))
                        Lapak dengan kata kunci <strong>"{{ request('search') }}"</strong> tidak ditemukan.
                        @else
                        Belum ada lapak yang terdaftar saat ini.
                        @endif
                    </p>
                    @if(request('search'))
                    <a href="{{ route('lapak') }}"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-emerald-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Lihat Semua Lapak
                    </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <div class="lg:w-1/3 space-y-8">

                {{-- Info Card --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Tentang Lapak Warga</h3>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Lapak Warga adalah platform untuk mempromosikan usaha dan produk warga desa.
                        Dengan berbelanja di sini, Anda turut mendukung perekonomian lokal.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Produk asli dari warga desa
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-7 h-7 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Hubungi langsung via WhatsApp
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <div class="w-7 h-7 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Dukung UMKM lokal
                        </div>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Statistik Lapak</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-emerald-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-emerald-600">{{ $lapakList->total() }}</p>
                            <p class="text-xs text-emerald-600 mt-1">Total Lapak</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $lapakList->sum('produk_aktif_count') }}</p>
                            <p class="text-xs text-blue-600 mt-1">Total Produk</p>
                        </div>
                    </div>
                </div>

                {{-- CTA Daftarkan Lapak --}}
                <div
                    class="bg-gradient-to-br from-emerald-700 to-teal-800 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg group">
                    <div
                        class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-125 transition duration-700">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -mb-6 -ml-6 w-24 h-24 bg-teal-400 opacity-20 rounded-full blur-xl">
                    </div>
                    <div class="relative z-10 text-center">
                        <div
                            class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-5 backdrop-blur-sm border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Punya Usaha?</h3>
                        <p class="text-emerald-100 text-sm mb-6 leading-relaxed">
                            Daftarkan usaha Anda ke lapak desa dan jangkau lebih banyak pembeli dari seluruh warga.
                        </p>
                        <a href="{{ route('kontak') }}"
                            class="inline-flex items-center justify-center w-full px-4 py-3 bg-white text-emerald-800 font-bold rounded-xl text-sm hover:bg-emerald-50 transition shadow-lg transform hover:-translate-y-0.5 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Daftarkan Lapak
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection