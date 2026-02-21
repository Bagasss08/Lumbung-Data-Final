@extends('layouts.admin')

@section('title', 'Detail Lapak')

@section('content')
<div>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.lapak.index') }}" class="hover:text-emerald-600 transition-colors">Lapak</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">{{ $lapak->nama_toko }}</span>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-xs font-medium rounded-full
                {{ $lapak->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $lapak->status === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.lapak.produk.index', $lapak) }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Kelola Produk
            </a>
            <a href="{{ route('admin.lapak.edit', $lapak) }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.lapak.index') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Info Card --}}
        <div class="lg:col-span-1 space-y-5">
            {{-- Foto & Info Singkat --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="aspect-video bg-gray-50">
                    <img src="{{ $lapak->foto_url }}" alt="{{ $lapak->nama_toko }}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $lapak->nama_toko }}</h2>
                    @if($lapak->deskripsi)
                    <p class="text-sm text-gray-500 mb-4">{{ $lapak->deskripsi }}</p>
                    @endif

                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-400">Pemilik</p>
                                <p class="font-medium text-gray-700">{{ $lapak->penduduk->nama ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-400">Telepon</p>
                                <p class="font-medium text-gray-700">{{ $lapak->telepon ?? '-' }}</p>
                            </div>
                        </div>
                        @if($lapak->alamat)
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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
                    </div>

                    @if($lapak->link_maps)
                    <a href="{{ $lapak->link_maps }}" target="_blank"
                        class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Lihat di Google Maps
                    </a>
                    @endif
                </div>
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Statistik</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-blue-50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $lapak->produk->count() }}</p>
                        <p class="text-xs text-blue-500 mt-0.5">Total Produk</p>
                    </div>
                    <div class="bg-emerald-50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-emerald-600">{{ $lapak->produk->where('status',
                            'aktif')->count() }}</p>
                        <p class="text-xs text-emerald-500 mt-0.5">Produk Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Produk Section --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">Daftar Produk</h3>
                    <a href="{{ route('admin.lapak.produk.index', $lapak) }}"
                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                        Lihat semua →
                    </a>
                </div>
                <div class="p-6">
                    @if($lapak->produk->isEmpty())
                    <div class="text-center py-10">
                        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="text-sm text-gray-400">Belum ada produk</p>
                        <a href="{{ route('admin.lapak.produk.create', $lapak) }}"
                            class="inline-block mt-2 text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                            + Tambah produk pertama
                        </a>
                    </div>
                    @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($lapak->produk->take(6) as $produk)
                        <div
                            class="group border border-gray-100 rounded-xl overflow-hidden hover:shadow-md hover:border-emerald-100 transition-all duration-200">
                            <div class="aspect-square bg-gray-50 overflow-hidden">
                                <img src="{{ $produk->foto_url }}" alt="{{ $produk->nama_produk }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-3">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ $produk->nama_produk }}</p>
                                <p class="text-xs font-bold text-emerald-600 mt-0.5">{{ $produk->harga_format }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-400">Stok: {{ $produk->stok }} {{ $produk->satuan
                                        }}</span>
                                    <span
                                        class="text-xs px-1.5 py-0.5 rounded-md
                                        {{ $produk->status === 'aktif' ? 'bg-emerald-100 text-emerald-600' :
                                           ($produk->status === 'habis' ? 'bg-amber-100 text-amber-600' : 'bg-gray-100 text-gray-500') }}">
                                        {{ ucfirst($produk->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($lapak->produk->count() > 6)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.lapak.produk.index', $lapak) }}"
                            class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            + {{ $lapak->produk->count() - 6 }} produk lainnya
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection