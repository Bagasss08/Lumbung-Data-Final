@extends('layouts.app')

@section('title', 'Pembagian Wilayah')
@section('description', 'Peta dan data pembagian wilayah administratif Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Wilayah Administrasi"
    subtitle="Jelajahi pembagian wilayah administratif Dusun, RW, dan RT di Desa Serayu Larangan secara lengkap dan transparan."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Wilayah', 'url' => '#']
    ]"
/>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Ringkasan Wilayah" 
            subtitle="Data kuantitatif pembagian wilayah administratif desa saat ini."
            badge="Data Statistik"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($statistik as $stat)
                @php
                    // Mapping Icon SVG
                    $icon = match($stat['icon']) {
                        'map' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.553-.894L15 9m0 13V9m0 0H9"></path></svg>',
                        'users' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                        'home' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                        'user' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                        default => ''
                    };
                @endphp
                
                <x-stat-card 
                    :label="$stat['label']"
                    :value="$stat['value']"
                    :color="$stat['color']"
                    :icon="$icon"
                />
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50 border-y border-gray-100">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Daftar Dusun" 
            subtitle="Wilayah administratif tingkat pertama di bawah desa yang menjadi pusat kegiatan warga."
            badge="Dusun"
        />

        @if(count($wilayahList) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($wilayahList as $wilayah)
                    <a href="{{ route('wilayah.show', $wilayah['id']) }}" class="group h-full block">
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden h-full flex flex-col transform hover:-translate-y-1">
                            <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative overflow-hidden flex items-center justify-center">
                                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                                
                                <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-inner group-hover:scale-110 transition-transform duration-500">
                                    {{ substr($wilayah['nama'], 0, 1) }}
                                </div>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="mb-4">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition mb-1">
                                        {{ $wilayah['nama'] }}
                                    </h3>
                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Kepala Dusun: <span class="font-medium text-gray-800">{{ $wilayah['kepala_dusun'] }}</span>
                                    </p>
                                </div>

                                <p class="text-gray-600 text-sm mb-6 line-clamp-2 leading-relaxed">
                                    {{ $wilayah['deskripsi'] }}
                                </p>

                                <div class="mt-auto grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 text-center">
                                    <div class="bg-gray-50 rounded-xl p-2 group-hover:bg-emerald-50 transition">
                                        <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">RW</span>
                                        <span class="text-lg font-bold text-emerald-600">{{ $wilayah['jumlah_rw'] }}</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-2 group-hover:bg-blue-50 transition">
                                        <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">RT</span>
                                        <span class="text-lg font-bold text-blue-600">{{ $wilayah['jumlah_rt'] }}</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-2 group-hover:bg-amber-50 transition">
                                        <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-1">Warga</span>
                                        <span class="text-lg font-bold text-amber-600">{{ $wilayah['jumlah_penduduk'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Data Wilayah</h3>
                <p class="text-gray-500">Data pembagian wilayah dusun belum tersedia di database.</p>
            </div>
        @endif
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-12 text-center">Hierarki Administratif Desa</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-100 -z-10 -translate-y-1/2 rounded-full"></div>

            <div class="relative p-8 bg-white rounded-2xl shadow-lg border-b-4 border-emerald-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Dusun</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">
                    Unit wilayah terbesar dalam desa yang dipimpin oleh Kepala Dusun (Kadus).
                </p>
            </div>

            <div class="relative p-8 bg-white rounded-2xl shadow-lg border-b-4 border-blue-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Rukun Warga (RW)</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">
                    Bagian dari dusun yang mengoordinasikan beberapa Rukun Tetangga (RT).
                </p>
            </div>

            <div class="relative p-8 bg-white rounded-2xl shadow-lg border-b-4 border-amber-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Rukun Tetangga (RT)</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">
                    Unit terkecil yang langsung bersentuhan dengan pelayanan warga sehari-hari.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Peta Digital Wilayah" 
            badge="Geografis"
        />

        <div class="bg-white p-3 rounded-3xl shadow-xl border border-gray-200">
            <div class="bg-slate-100 rounded-2xl h-[500px] flex items-center justify-center w-full overflow-hidden relative group">
                <div class="text-center z-10 transform group-hover:scale-105 transition duration-500">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg animate-bounce-slow">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Peta Interaktif Segera Hadir</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Kami sedang mempersiapkan peta digital yang memuat batas wilayah RT/RW dan lokasi fasilitas umum.</p>
                </div>
                
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cartographer.png')] opacity-10"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-200/50 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>

<style>
    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }
</style>

@endsection