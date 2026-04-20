@extends('layouts.admin')

@section('title', 'Detail Wisata')

@section('content')
<div>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.wisata.index') }}" class="hover:text-emerald-600 transition-colors">Wisata</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">{{ $wisata->nama }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri --}}
        <div class="lg:col-span-1 space-y-5">

            {{-- Gambar --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ $wisata->gambar_url }}" alt="{{ $wisata->nama }}"
                    class="w-full aspect-square object-cover">
                <div class="p-4">
                    <span class="px-3 py-1 text-xs font-bold rounded-full
                        {{ $wisata->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $wisata->status === 'aktif' ? '● Aktif' : '○ Nonaktif' }}
                    </span>
                </div>
            </div>

            {{-- Fasilitas --}}
            @if($wisata->fasilitas && count($wisata->fasilitas) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Fasilitas
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($wisata->fasilitas as $fas)
                    @if($fas)
                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-lg">
                        {{ $fas }}
                    </span>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Aksi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-2">
                <a href="{{ route('admin.wisata.edit', $wisata) }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Wisata
                </a>
                <form action="{{ route('admin.wisata.toggle-status', $wisata) }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border text-sm font-medium rounded-xl transition-all
                        {{ $wisata->status === 'aktif'
                            ? 'border-gray-200 text-gray-600 hover:bg-gray-50'
                            : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }}">
                        {{ $wisata->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <a href="{{ route('admin.wisata.index') }}"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Info Utama --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $wisata->nama }}</h2>
                        <span class="inline-block mt-1 px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full">
                            {{ $wisata->kategori }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Lokasi
                        </p>
                        <p class="text-sm font-semibold text-gray-700">{{ $wisata->lokasi ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Jam Buka
                        </p>
                        <p class="text-sm font-semibold text-gray-700">{{ $wisata->jam_buka ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Harga Tiket
                        </p>
                        <p class="text-sm font-semibold text-gray-700">{{ $wisata->harga_tiket ?? 'Gratis' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Ditambahkan
                        </p>
                        <p class="text-sm font-semibold text-gray-700">
                            {{ $wisata->created_at->locale('id')->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                {{-- Slug --}}
                <div class="p-3 bg-gray-50 rounded-xl flex items-center gap-2 text-xs text-gray-500 mb-4">
                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <span class="font-mono">{{ $wisata->slug }}</span>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Deskripsi</h4>
                    <div class="text-sm text-gray-600 leading-relaxed bg-gray-50 rounded-xl p-4">
                        {!! nl2br(e($wisata->deskripsi ?? 'Belum ada deskripsi.')) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection