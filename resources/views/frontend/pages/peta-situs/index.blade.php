@extends('layouts.app')

@section('title', 'Peta Situs')
@section('description', 'Struktur navigasi dan peta situs website Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Peta Situs"
    subtitle="Navigasi visual lengkap seluruh layanan dan informasi di website resmi Pemerintah Desa."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Peta Situs', 'url' => '#']
    ]"
/>

<section class="py-20 bg-gray-50 overflow-hidden relative">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/graphy.png')] opacity-5 pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        
        <div class="flex justify-center mb-16">
            <a href="{{ route('home') }}" class="group relative z-10">
                <div class="w-24 h-24 bg-emerald-600 rounded-full flex items-center justify-center shadow-xl border-4 border-white group-hover:scale-110 transition duration-500 relative z-20">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <div class="absolute inset-0 bg-emerald-400 rounded-full blur-xl opacity-30 group-hover:opacity-60 transition duration-500"></div>
                <div class="mt-4 text-center">
                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-emerald-600 transition">Beranda</h3>
                    <p class="text-xs text-gray-500">Halaman Utama</p>
                </div>
                
                <div class="absolute left-1/2 top-24 w-1 h-16 bg-gradient-to-b from-emerald-600 to-gray-300 -translate-x-1/2 -z-10"></div>
            </a>
        </div>

        <div class="relative max-w-5xl mx-auto mb-12 hidden lg:block">
            <div class="absolute top-0 left-16 right-16 h-1 bg-gray-300 rounded-full"></div>
            <div class="absolute top-0 left-1/4 -mt-1.5 w-4 h-4 bg-white border-4 border-emerald-500 rounded-full"></div>
            <div class="absolute top-0 left-1/2 -mt-1.5 w-4 h-4 bg-white border-4 border-blue-500 rounded-full -translate-x-1/2"></div>
            <div class="absolute top-0 right-1/4 -mt-1.5 w-4 h-4 bg-white border-4 border-amber-500 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-6xl mx-auto">

            <div class="flex flex-col items-center">
                <div class="lg:hidden h-8 w-1 bg-gray-300 mb-4"></div>

                <div class="bg-white rounded-2xl shadow-lg border-t-4 border-emerald-500 p-6 w-full relative group hover:-translate-y-2 transition duration-300">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="text-center font-bold text-lg text-gray-900 mt-6 mb-6">Profil & Pemerintahan</h4>
                    
                    <div class="space-y-4">
                        <a href="{{ route('profil') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover/item:scale-110 transition">1</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-emerald-700">Profil Desa</span>
                        </a>
                        <a href="{{ route('pemerintahan') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover/item:scale-110 transition">2</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-emerald-700">Struktur Pemerintahan</span>
                        </a>
                        <a href="{{ route('wilayah') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm group-hover/item:scale-110 transition">3</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-emerald-700">Wilayah Administratif</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <div class="lg:hidden h-8 w-1 bg-gray-300 mb-4"></div>

                <div class="bg-white rounded-2xl shadow-lg border-t-4 border-blue-500 p-6 w-full relative group hover:-translate-y-2 transition duration-300">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <h4 class="text-center font-bold text-lg text-gray-900 mt-6 mb-6">Informasi & Layanan</h4>
                    
                    <div class="space-y-4">
                        <a href="{{ route('data-desa') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition">1</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-blue-700">Data Statistik</span>
                        </a>
                        <a href="{{ route('berita') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition">2</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-blue-700">Kabar Desa</span>
                        </a>
                        <a href="{{ route('kontak') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-blue-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-500 shadow-sm group-hover/item:scale-110 transition">3</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-blue-700">Kontak & Pengaduan</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <div class="lg:hidden h-8 w-1 bg-gray-300 mb-4"></div>

                <div class="bg-white rounded-2xl shadow-lg border-t-4 border-amber-500 p-6 w-full relative group hover:-translate-y-2 transition duration-300">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="text-center font-bold text-lg text-gray-900 mt-6 mb-6">Legal & Sistem</h4>
                    
                    <div class="space-y-4">
                        <a href="{{ route('kebijakan-privasi') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-amber-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-amber-500 shadow-sm group-hover/item:scale-110 transition">1</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-amber-700">Kebijakan Privasi</span>
                        </a>
                        <a href="{{ route('syarat-ketentuan') }}" class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-amber-50 hover:shadow-sm transition group/item">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-amber-500 shadow-sm group-hover/item:scale-110 transition">2</div>
                            <span class="font-medium text-gray-700 group-hover/item:text-amber-700">Syarat & Ketentuan</span>
                        </a>
                        <a href="{{ route('setup') }}" class="flex items-center gap-4 p-3 rounded-xl bg-slate-800 hover:bg-slate-900 hover:shadow-md transition group/item text-white">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white shadow-sm group-hover/item:scale-110 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            </div>
                            <span class="font-medium">Login Admin</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<section class="py-16 bg-white border-t border-gray-100">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Masih Bingung?</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">Gunakan fitur pencarian untuk menemukan informasi spesifik yang Anda butuhkan di website desa.</p>
        
        <div class="max-w-md mx-auto relative group">
            <div class="absolute inset-0 bg-emerald-400 rounded-full blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
            <form action="{{ route('berita') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Cari layanan, berita, atau informasi..." class="w-full pl-6 pr-14 py-4 rounded-full border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition shadow-lg bg-white text-gray-700">
                <button type="submit" class="absolute right-2 top-2 p-2.5 bg-emerald-600 rounded-full text-white hover:bg-emerald-700 transition shadow-md transform hover:scale-105 active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
    </div>
</section>

@endsection