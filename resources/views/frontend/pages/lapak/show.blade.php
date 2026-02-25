@extends('layouts.app')

@section('title', $lapak->nama_toko)
@section('description', $lapak->deskripsi ?? 'Lihat produk dari ' . $lapak->nama_toko . ' di Lapak Warga Desa.')

@section('content')

<x-hero-section :title="$lapak->nama_toko"
    subtitle="Lapak milik warga desa kami. Hubungi langsung untuk informasi pembelian." :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Lapak', 'url' => route('lapak')],
        ['label' => $lapak->nama_toko, 'url' => '#']
    ]" />

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-12">

            {{-- KONTEN UTAMA - Produk --}}
            <div class="lg:w-2/3">

                {{-- Header Info Toko (Mobile) --}}
                <div class="lg:hidden bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        <img src="{{ $lapak->foto_url }}" alt="{{ $lapak->nama_toko }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $lapak->nama_toko }}</h2>
                        @if($lapak->deskripsi)
                        <p class="text-sm text-gray-500 mb-4">{{ $lapak->deskripsi }}</p>
                        @endif
                        <div class="flex flex-wrap gap-3">
                            @if($lapak->telepon)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lapak->telepon) }}" target="_blank"
                                class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-xl hover:bg-green-600 transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                Hubungi via WA
                            </a>
                            @endif
                            @if($lapak->link_maps)
                            <a href="{{ $lapak->link_maps }}" target="_blank"
                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lihat Lokasi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Judul Produk --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">
                        Produk Tersedia
                        <span class="ml-2 text-sm font-medium text-gray-400">({{ $produk->total() }})</span>
                    </h2>
                </div>

                {{-- Grid Produk --}}
                @if($produk->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-12">
                    @foreach($produk as $item)
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-100 transition-all duration-300">

                        {{-- Foto Produk --}}
                        <div class="relative aspect-square bg-gray-50 overflow-hidden">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            {{-- Badge status habis --}}
                            @if($item->status === 'habis')
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-bold rounded-full">
                                    Stok Habis
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Info Produk --}}
                        <div class="p-3">
                            <h3
                                class="text-sm font-semibold text-gray-800 line-clamp-2 mb-1 group-hover:text-emerald-600 transition">
                                {{ $item->nama_produk }}
                            </h3>
                            <p class="text-sm font-bold text-emerald-600 mb-2">{{ $item->harga_format }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-400">
                                    Stok: {{ $item->stok }} {{ $item->satuan }}
                                </span>
                            </div>

                            {{-- Tombol WA per produk --}}
                            @if($lapak->telepon && $item->status !== 'habis')
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lapak->telepon) }}?text={{ urlencode('Halo, saya tertarik dengan produk *' . $item->nama_produk . '* dari lapak *' . $lapak->nama_toko . '*. Apakah masih tersedia?') }}"
                                target="_blank"
                                class="mt-3 flex items-center justify-center gap-1.5 w-full py-2 bg-green-50 text-green-600 text-xs font-semibold rounded-lg hover:bg-green-500 hover:text-white transition-all duration-200">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                Pesan
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-4 flex justify-center pb-8">
                    {{ $produk->links('pagination::tailwind') }}
                </div>

                @else
                <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Produk</h3>
                    <p class="text-gray-500 text-sm">Lapak ini belum menambahkan produk.</p>
                </div>
                @endif
            </div>

            {{-- SIDEBAR - Info Toko --}}
            <div class="lg:w-1/3 space-y-6">

                {{-- Info Toko (Desktop) --}}
                <div
                    class="hidden lg:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">

                    {{-- Foto --}}
                    <div class="h-52 bg-gray-100 overflow-hidden">
                        <img src="{{ $lapak->foto_url }}" alt="{{ $lapak->nama_toko }}"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $lapak->nama_toko }}</h2>

                        @if($lapak->deskripsi)
                        <p class="text-sm text-gray-500 leading-relaxed mb-5">{{ $lapak->deskripsi }}</p>
                        @endif

                        {{-- Info Detail --}}
                        <div class="space-y-3 mb-5">
                            <div class="flex items-start gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Pemilik</p>
                                    <p class="font-medium text-gray-700">{{ $lapak->penduduk->nama ?? '-' }}</p>
                                </div>
                            </div>

                            @if($lapak->telepon)
                            <div class="flex items-start gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Telepon</p>
                                    <p class="font-medium text-gray-700">{{ $lapak->telepon }}</p>
                                </div>
                            </div>
                            @endif

                            @if($lapak->alamat)
                            <div class="flex items-start gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Alamat</p>
                                    <p class="font-medium text-gray-700">{{ $lapak->alamat }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-start gap-3 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Jumlah Produk</p>
                                    <p class="font-medium text-gray-700">{{ $produk->total() }} produk aktif</p>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="space-y-2.5">
                            @if($lapak->telepon)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lapak->telepon) }}?text={{ urlencode('Halo, saya ingin bertanya tentang produk di lapak ' . $lapak->nama_toko) }}"
                                target="_blank"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-green-500 text-white font-bold rounded-xl text-sm hover:bg-green-600 transition shadow-md">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                                Hubungi via WhatsApp
                            </a>
                            @endif

                            @if($lapak->link_maps)
                            <a href="{{ $lapak->link_maps }}" target="_blank"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl text-sm hover:bg-gray-200 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Lihat di Google Maps
                            </a>
                            @endif

                            <a href="{{ route('lapak') }}"
                                class="flex items-center justify-center gap-2 w-full px-4 py-3 border border-gray-200 text-gray-600 font-medium rounded-xl text-sm hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Lihat Lapak Lainnya
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection