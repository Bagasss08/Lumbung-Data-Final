@extends('layouts.app')

@section('title', 'Beranda')
@section('description', 'Portal informasi resmi Desa ' . ($desaInfo['nama_desa'] ?? ''))

@section('content')

{{-- ============================================================ --}}
{{-- HERO SECTION                                                  --}}
{{-- ============================================================ --}}
<div class="relative bg-emerald-900 overflow-hidden lg:min-h-[85vh] flex items-center pt-24 pb-24 lg:pt-32 lg:pb-32 group">
    
    @if(isset($desaInfo['gambar_kantor']))
        <div class="absolute inset-0 z-0">
            <img src="{{ $desaInfo['gambar_kantor'] }}" 
                alt="Background Desa" 
                class="w-full h-full object-cover opacity-60 scale-105 group-hover:scale-110 transition-transform duration-[3s]">
        </div>
    @endif

    <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/95 via-emerald-900/90 to-teal-900/80 z-0"></div>
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay z-0"></div>
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-emerald-500 rounded-full blur-[120px] opacity-20 animate-pulse z-0"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-teal-500 rounded-full blur-[100px] opacity-20 z-0"></div>

    <div class="container mx-auto px-4 relative z-10 h-full flex flex-col justify-center">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            
            <div class="lg:w-1/2 text-center lg:text-left">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-emerald-800/40 border border-emerald-700/50 text-emerald-100 text-xs font-semibold uppercase tracking-wider mb-6 animate-fade-in shadow-sm backdrop-blur-sm">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span>Website Resmi Pemerintah Desa</span>
                </div>

                <h1 class="text-4xl lg:text-6xl font-bold text-white leading-tight mb-6 tracking-tight drop-shadow-sm">
                    Membangun Desa <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200">
                        {{ $desaInfo['nama_desa'] ?? 'Maju & Mandiri' }}
                    </span>
                </h1>
                
                <p class="text-lg text-emerald-100/90 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-light">
                    {{ $desaInfo['deskripsi_singkat'] ?? 'Selamat datang di portal resmi transformasi digital Pemerintah Desa. Kami hadir untuk mendekatkan pelayanan publik melalui akses informasi yang transparan, layanan administrasi yang cepat dan efisien, serta keterbukaan data pembangunan desa.' }}
                </p>

                <div class="flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <a href="{{ route('identitas-desa') }}" class="group relative px-8 py-4 bg-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 hover:bg-emerald-400 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto flex justify-center">
                        <span class="flex items-center gap-2">
                            Jelajahi Profil
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                    </a>
                    <a href="{{ route('kontak') }}" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-semibold rounded-xl hover:bg-white/10 transition-all duration-300 hover:-translate-y-1 backdrop-blur-sm flex items-center justify-center gap-2 w-full sm:w-auto">
                        Hubungi Kami
                        <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 relative hidden lg:block">
                <div class="relative w-full aspect-[4/3] max-w-xl mx-auto transform hover:scale-[1.02] transition duration-700 ease-out">
                    <div class="absolute inset-0 rounded-[2rem] overflow-hidden shadow-2xl shadow-emerald-900/60 border border-white/10 z-10 bg-gray-800">
                        <img src="{{ $desaInfo['gambar_kantor'] }}" alt="Kantor Desa" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/90 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-emerald-500/20 backdrop-blur-md border border-emerald-500/30 rounded-xl">
                                    <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-emerald-300 uppercase tracking-widest mb-1">Kantor Kepala Desa</p>
                                    <p class="font-bold text-lg leading-tight text-white shadow-sm">{{ $desaInfo['alamat_kantor'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -top-6 -left-8 z-20 bg-white/95 backdrop-blur rounded-2xl p-4 shadow-xl shadow-emerald-900/20 border border-white/50 animate-float-slow max-w-[200px]">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Data Desa</p>
                                <p class="text-sm font-bold text-gray-900">Transparan</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-8 z-20 bg-white/95 backdrop-blur rounded-2xl p-4 shadow-xl shadow-emerald-900/20 border border-white/50 animate-float-delayed max-w-[200px]">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-emerald-50 rounded-xl text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Pelayanan</p>
                                <p class="text-sm font-bold text-gray-900">Digitalisasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STATS SECTION                                                 --}}
{{-- Dipisah total dari hero — tidak ada overlap/negative margin  --}}
{{-- Background putih dengan border bawah agar terasa terpisah    --}}
{{-- ============================================================ --}}
<div class="bg-white border-b border-gray-100 shadow-sm">
    <div class="container mx-auto px-4 py-10 sm:py-12 lg:py-14">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 bg-emerald-50 rounded-2xl border border-emerald-100 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 sm:w-13 sm:h-13 flex-shrink-0 bg-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-none">
                        {{ number_format($totalPenduduk ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs sm:text-sm text-emerald-700 font-semibold mt-0.5">Total Penduduk</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 bg-blue-50 rounded-2xl border border-blue-100 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 sm:w-13 sm:h-13 flex-shrink-0 bg-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-none">
                        {{ number_format($lakiLaki ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs sm:text-sm text-blue-700 font-semibold mt-0.5">Laki-laki</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 bg-amber-50 rounded-2xl border border-amber-100 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 sm:w-13 sm:h-13 flex-shrink-0 bg-amber-500 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-none">
                        {{ number_format($perempuan ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs sm:text-sm text-amber-700 font-semibold mt-0.5">Perempuan</p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 bg-purple-50 rounded-2xl border border-purple-100 hover:shadow-md transition-all duration-300">
                <div class="w-11 h-11 sm:w-13 sm:h-13 flex-shrink-0 bg-purple-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-none">
                        {{ number_format($totalKeluarga ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs sm:text-sm text-purple-700 font-semibold mt-0.5">Total Keluarga</p>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- TENTANG KAMI                                                  --}}
{{-- ============================================================ --}}
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">

            <div class="lg:w-1/2 relative w-full">
                <div class="relative overflow-hidden rounded-3xl">
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob pointer-events-none"></div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000 pointer-events-none"></div>
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ $desaInfo['gambar_kantor'] }}" alt="Kantor Desa" class="w-full h-64 sm:h-80 lg:h-[400px] object-cover hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6 text-white">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-emerald-600 rounded-lg flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-emerald-200 font-bold uppercase tracking-wider mb-1">Lokasi Kantor</p>
                                    <p class="font-semibold text-sm leading-snug break-words">{{ $desaInfo['alamat_kantor'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 w-full">
                <x-section-title 
                    title="Mengenal Desa Kami" 
                    subtitle="Komitmen kami untuk melayani masyarakat dengan integritas, transparansi, dan inovasi tiada henti."
                    :centered="false"
                    badge="Tentang Kami"
                />
                <p class="text-gray-600 leading-loose mb-8 text-base lg:text-lg">
                    {{ $desaInfo['deskripsi_singkat'] }}
                </p>
                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-emerald-300 transition group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-4 flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wide">Email Resmi</p>
                            <p class="text-gray-900 font-medium truncate">{{ $desaInfo['email_desa'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:border-emerald-300 transition group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 mr-4 flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wide">Layanan Telepon</p>
                            <p class="text-gray-900 font-medium truncate">{{ $desaInfo['telepon_desa'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- APARATUR DESA                                                 --}}
{{-- ============================================================ --}}
<section class="py-20 bg-emerald-50/30 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-200 to-transparent"></div>
    <div class="container mx-auto px-4 relative z-10">
        <x-section-title 
            title="Aparatur Desa" 
            subtitle="Mengenal jajaran perangkat desa yang siap melayani kebutuhan masyarakat." 
            badge="Pemerintahan"
        />
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8">
            @forelse($perangkatUtama as $perangkat)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="relative h-48 sm:h-60 lg:h-72 overflow-hidden bg-gray-100">
                        @if(isset($perangkat['foto']) && $perangkat['foto'])
                            <img src="{{ $perangkat['foto'] }}" alt="{{ $perangkat['nama'] }}" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-200">
                                <svg class="w-16 h-16 lg:w-24 lg:h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4 lg:p-6">
                            <p class="text-white font-bold text-sm lg:text-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">{{ $perangkat['nama'] ?? 'Nama' }}</p>
                            <p class="text-emerald-200 text-xs lg:text-sm transform translate-y-4 group-hover:translate-y-0 transition duration-300 delay-75">{{ $perangkat['posisi'] ?? 'Jabatan' }}</p>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 lg:p-5 text-center group-hover:bg-emerald-50 transition bg-white relative z-10">
                        <h3 class="text-sm sm:text-base lg:text-lg font-bold text-gray-900 mb-1 group-hover:text-emerald-700 truncate">{{ $perangkat['nama'] ?? 'Nama Pegawai' }}</h3>
                        <p class="text-xs sm:text-sm text-emerald-600 font-medium line-clamp-2">{{ $perangkat['posisi'] ?? 'Jabatan' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 lg:col-span-4 text-center py-12">
                    <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium">Data perangkat desa belum tersedia.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('pemerintahan') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-emerald-200 text-emerald-700 font-semibold hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all duration-300">
                Lihat Struktur Lengkap
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- TRANSPARANSI & AGENDA                                         --}}
{{-- ============================================================ --}}
<section class="py-16 lg:py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-12">
            <div class="lg:w-2/3 w-full">
                <x-section-title 
                    title="Transparansi Desa" 
                    subtitle="Laporan realisasi dan rencana anggaran pendapatan belanja desa tahun {{ $anggaranChart['tahun'] }}."
                    :centered="false"
                    badge="APBDes"
                />
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Total Anggaran</p>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-1">{{ $anggaranChart['total'] }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @forelse($anggaranChart['detail'] as $sumber)
                            @php 
                                $rawTotal = str_replace(['Rp ', '.'], '', $anggaranChart['total']);
                                $persen = $rawTotal > 0 ? ($sumber->total / $rawTotal) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between items-end mb-2 gap-2">
                                    <span class="font-semibold text-gray-800 text-sm sm:text-base leading-tight">{{ $sumber->nama_sumber }}</span>
                                    <span class="text-xs sm:text-sm font-bold text-gray-600 flex-shrink-0">Rp {{ number_format($sumber->total, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-3">
                                    <div class="bg-emerald-500 h-3 rounded-full" style="width: {{ $persen }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-gray-400 text-sm border-2 border-dashed border-gray-100 rounded-xl">
                                Belum ada data anggaran yang diinput.
                            </div>
                        @endforelse
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <a href="{{ route('apbd') }}" class="text-emerald-600 font-semibold text-sm hover:underline">Lihat Laporan Lengkap &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3 w-full">
                <div class="flex items-center justify-between mb-6 lg:mb-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Agenda Desa</h3>
                    <a href="#" class="text-sm font-semibold text-emerald-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($agendaTerbaru as $agenda)
                        <div class="flex gap-4 p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 bg-emerald-50 rounded-xl flex flex-col items-center justify-center text-emerald-700 border border-emerald-100">
                                <span class="text-lg sm:text-xl font-bold leading-none">{{ $agenda['tanggal'] }}</span>
                                <span class="text-[10px] uppercase font-bold mt-1">{{ $agenda['bulan'] }}</span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-gray-900 line-clamp-2 group-hover:text-emerald-600 transition text-sm sm:text-base">{{ $agenda['judul'] }}</h4>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate">{{ $agenda['lokasi'] }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-50 rounded-full mb-3 text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada agenda kegiatan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- KABAR DESA TERKINI                                            --}}
{{-- ============================================================ --}}
<section class="py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 lg:mb-12 gap-4">
            <x-section-title 
                title="Kabar Desa Terkini" 
                subtitle="Informasi terbaru seputar kegiatan dan pengumuman desa." 
                :centered="false" 
                badge="Berita" 
            />
            <a href="{{ route('berita') }}" class="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:text-emerald-700 transition group mb-0 md:mb-12 flex-shrink-0">
                Lihat Semua Berita
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($artikelTerbaru as $artikel)
                <x-article-card 
                    :title="$artikel['title']"
                    :excerpt="$artikel['excerpt']"
                    :date="$artikel['date']"
                    :category="$artikel['category']"
                    :image="$artikel['image']"
                    :link="route('artikel.show', $artikel['id'])"
                    :author="$artikel['author'] ?? 'Admin'"
                />
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 py-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <div class="inline-flex justify-center items-center w-12 h-12 rounded-full bg-gray-200 text-gray-400 mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <p class="text-gray-500">Belum ada berita terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- WISATA DESA                                                   --}}
{{-- Layout sama persis dengan section Berita (grid 1/2/3 col)   --}}
{{-- ============================================================ --}}
<section class="py-16 lg:py-20 bg-gray-50 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-emerald-200 to-transparent"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 lg:mb-12 gap-4">
            <x-section-title
                title="Wisata Desa"
                subtitle="Jelajahi keindahan dan potensi wisata yang ada di desa kami."
                :centered="false"
                badge="Destinasi"
            />
            <a href="{{ route('wisata') }}" class="inline-flex items-center gap-2 text-emerald-600 font-semibold hover:text-emerald-700 transition group mb-0 md:mb-12 flex-shrink-0">
                Lihat Semua Wisata
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($wisataTerbaru as $wisata)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:-translate-y-1 flex flex-col">
                    <div class="relative h-52 overflow-hidden bg-gray-100 flex-shrink-0">
                        <img src="{{ $wisata['gambar'] }}"
                             alt="{{ $wisata['nama'] }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-emerald-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ $wisata['kategori'] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-base font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition line-clamp-1">
                            {{ $wisata['nama'] }}
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2 flex-1">
                            {{ $wisata['deskripsi'] }}
                        </p>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-auto">
                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate max-w-[140px]">{{ $wisata['lokasi'] }}</span>
                            </div>
                            <a href="{{ route('wisata.show', $wisata['id']) }}"
                               class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 group/link flex-shrink-0">
                                Selengkapnya
                                <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                    <div class="flex flex-col items-center justify-center py-14 bg-white rounded-2xl border-2 border-dashed border-gray-200 text-center px-4">
                        <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 font-semibold">Belum ada data wisata.</p>
                        <p class="text-gray-400 text-sm mt-1">Potensi wisata desa akan segera hadir.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- CTA — LAYANAN SURAT & PENGADUAN                              --}}
{{-- ============================================================ --}}
<section class="py-12 md:py-16 bg-transparent">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-emerald-700 rounded-[2rem] shadow-2xl overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
            <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-emerald-800 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
            <div class="relative z-10 px-6 py-12 md:py-16 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">
                    Butuh Layanan Surat atau Pengaduan?
                </h2>
                <p class="text-emerald-100 text-base sm:text-lg mb-8 max-w-2xl mx-auto leading-relaxed">
                    Gunakan fitur layanan mandiri kami untuk mengurus administrasi secara online atau sampaikan aspirasi Anda demi kemajuan desa bersama.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('kontak') }}" class="px-8 py-3.5 bg-white text-emerald-800 font-bold rounded-xl shadow-lg hover:bg-emerald-50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Buat Surat Online
                    </a>
                    <a href="{{ route('kontak') }}" class="px-8 py-3.5 bg-emerald-800/80 backdrop-blur-sm border border-emerald-500 text-white font-bold rounded-xl hover:bg-emerald-800 hover:border-emerald-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Layanan Pengaduan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-float-slow { animation: float 6s ease-in-out infinite; }
    .animate-float-delayed { animation: float 6s ease-in-out infinite 3s; }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
</style>
@endsection