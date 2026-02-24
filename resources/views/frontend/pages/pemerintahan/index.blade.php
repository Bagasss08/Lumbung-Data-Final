@extends('layouts.app')

@section('title', 'Struktur Pemerintahan')
@section('description', 'Struktur organisasi dan perangkat desa yang melayani dengan dedikasi')

@section('content')

<x-hero-section 
    title="Struktur Pemerintahan"
    subtitle="Mengenal jajaran perangkat desa dan lembaga yang bekerja sama membangun desa yang maju dan mandiri."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Pemerintahan', 'url' => '#']
    ]"
/>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        
        @php
            // Cek apakah ada setidaknya satu anggota di seluruh kategori
            $totalPerangkat = collect($pemerintahan['struktur'])->sum(function($kategori) {
                return count($kategori['anggota']);
            });
        @endphp

        @if($totalPerangkat > 0)
            {{-- JIKA ADA DATA: Tampilkan Loop Kategori --}}
            @foreach($pemerintahan['struktur'] as $kategori)
                @if(count($kategori['anggota']) > 0)
                    <div class="mb-20 last:mb-0">
                        <div class="flex items-center justify-center mb-12">
                            <div class="relative">
                                <h2 class="text-3xl font-bold text-gray-900 z-10 relative px-4">{{ $kategori['kategori'] }}</h2>
                                <div class="absolute inset-x-0 bottom-2 h-3 bg-emerald-100 -z-0"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">
                            @foreach($kategori['anggota'] as $perangkat)
                                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col h-full">
                                    <div class="relative h-72 overflow-hidden bg-gray-100">
                                        @if(isset($perangkat['foto']) && $perangkat['foto'])
                                            <img src="{{ $perangkat['foto'] }}" alt="{{ $perangkat['nama'] }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-emerald-50 to-teal-100 flex items-center justify-center text-emerald-300">
                                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            </div>
                                        @endif
                                        
                                        <div class="absolute top-4 right-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/90 text-emerald-600 shadow-sm backdrop-blur">
                                                {{ $perangkat['status'] ?? 'Aktif' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-6 text-center flex-1 flex flex-col justify-between relative bg-white">
                                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-1 bg-emerald-500 rounded-full"></div>
                                        
                                        <div>
                                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-2">{{ $perangkat['posisi'] }}</p>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-emerald-700 transition">{{ $perangkat['nama'] }}</h3>
                                            
                                            @if(isset($perangkat['nip']) && $perangkat['nip'] != '-' && $perangkat['nip'] != null)
                                                <div class="inline-flex items-center gap-2 text-gray-500 text-sm bg-gray-50 px-3 py-1 rounded-lg mt-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                                    <span class="font-mono">NIP: {{ $perangkat['nip'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

        @else
            {{-- JIKA DATA KOSONG: Tampilkan State Kosong yang Bagus --}}
            <div class="max-w-2xl mx-auto text-center py-16 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-sm mb-6 text-emerald-200">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Data Belum Tersedia</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">
                    Data struktur organisasi dan perangkat desa saat ini belum diinput ke dalam sistem. Silakan hubungi admin desa untuk pembaruan data.
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:underline">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        @endif

    </div>
</section>

@if(!empty($badan_permusyawaratan))
<section class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Badan Permusyawaratan Desa (BPD)" 
            subtitle="Mitra kerja pemerintah desa dalam menyalurkan aspirasi masyarakat."
            badge="Lembaga Desa"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($badan_permusyawaratan as $anggota)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg p-6 border border-gray-100 transition-all duration-300 group">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wide mb-1">{{ $anggota['posisi'] }}</p>
                            <h3 class="text-lg font-bold text-gray-900">{{ $anggota['nama'] }}</h3>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-600">
                        <span>Perwakilan Wilayah:</span>
                        <span class="font-semibold text-gray-800">{{ $anggota['wilayah'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-12 md:py-16 bg-transparent">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="relative bg-emerald-700 rounded-[2rem] shadow-2xl overflow-hidden">
            
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

            <div class="relative z-10 px-6 py-12 md:py-16 text-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
                    Ingin Mengurus Administrasi?
                </h2>
                <p class="text-emerald-100 text-lg mb-8 max-w-2xl mx-auto leading-relaxed">
                    Kunjungi kantor desa pada jam kerja atau gunakan layanan surat online untuk kemudahan Anda.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('kontak') }}" class="px-8 py-3.5 bg-white text-emerald-800 font-bold rounded-xl shadow-lg hover:bg-emerald-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Lihat Jam Pelayanan
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection