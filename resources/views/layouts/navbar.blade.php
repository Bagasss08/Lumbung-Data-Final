@php
    $identitas_nav = \App\Models\IdentitasDesa::first();
@endphp

<nav class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-100 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <div class="flex-shrink-0 flex items-center gap-3">
                @if($identitas_nav && $identitas_nav->logo_desa && file_exists(storage_path('app/public/logo-desa/'.$identitas_nav->logo_desa)))
                    <img src="{{ asset('storage/logo-desa/'.$identitas_nav->logo_desa) }}" alt="Logo Desa" class="h-10 w-10 object-contain drop-shadow-sm">
                @else
                    <div class="h-10 w-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-emerald-600/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                @endif
                
                <div class="flex flex-col">
                    <h1 class="text-lg font-bold text-slate-800 leading-tight tracking-tight">
                        {{ $identitas_nav->nama_desa ?? config('app.name', 'Pemerintah Desa') }}
                    </h1>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">
                        Kec. {{ $identitas_nav->kecamatan ?? 'Kecamatan' }}
                    </span>
                </div>
            </div>

            <div class="hidden xl:flex items-center justify-center gap-6 2xl:gap-8 h-full">
                
                <a href="{{ route('home') }}" class="h-full flex items-center text-sm font-medium transition duration-300 relative group {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Beranda
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <div class="relative group h-full flex items-center">
                    <button class="flex items-center gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300 h-full">
                        Profil Desa
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute top-full left-0 pt-2 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('identitas-desa') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"/></svg>
                                Identitas Desa
                            </a>
                            <a href="{{ route('pemerintahan') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Pemerintahan
                            </a>
                            <a href="{{ route('bpd') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Badan Permusyawaratan Desa
                            </a>
                            <a href="{{ route('kemasyarakatan') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                Lembaga Kemasyarakatan
                            </a>
                            <a href="{{ route('data-desa') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                                Demografi & Statistik
                            </a>
                            <a href="{{ route('wilayah') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                Peta Desa
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative group h-full flex items-center">
                    <button class="flex items-center gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300 h-full">
                        Layanan Publik
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute top-full left-0 pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('lapak') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Lapak UMKM
                            </a>
                            <a href="{{ route('kontak') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Pengaduan Warga
                            </a>
                            <a href="{{ route('warga.surat.index') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Surat Online
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative group h-full flex items-center">
                    <button class="flex items-center gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300 h-full">
                        Informasi
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute top-full left-0 pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('berita') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                Berita Pengumuman
                            </a>
                            <a href="{{ route('apbd') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                APBD
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('kontak') }}" class="h-full flex items-center text-sm font-medium transition duration-300 relative group {{ request()->routeIs('kontak') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Kontak
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('kontak') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

            </div>

            <div class="hidden xl:flex items-center gap-4">
                @guest
                    <a href="{{ route('aktivasi.index') }}" 
                    class="text-sm font-semibold gap-2 w-full px-4 py-3 bg-slate-200 text-slate-600 rounded-2xl hover:bg-slate-300 hover:text-emerald-700 transition duration-300">
                        Aktivasi Akun
                    </a>

                    <a href="{{ route('login') }}" 
                    class="group flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/40 transition-all duration-300">
                        <span>Masuk</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </a>
                @endguest

                @auth
                    <div class="relative group z-50">
                        <button class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all duration-300">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }} 
                            </div>
                            <div class="text-left hidden md:block">
                                <p class="text-xs text-slate-500 font-medium">Halo,</p>
                                <p class="text-sm font-semibold text-slate-700 max-w-[100px] truncate">{{ Auth::user()->name }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right">
                            <div class="p-2">
                                @if(Auth::user()->role == 'warga')
                                    <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                        Dashboard Warga
                                    </a>
                                    <a href="{{ route('warga.profil') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Profil Saya
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                        Dashboard Admin
                                    </a>
                                @endif
                                
                                <hr class="my-2 border-slate-100">

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <button id="mobile-menu-btn" class="xl:hidden p-2 rounded-lg text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden xl:hidden border-t border-slate-100 py-4 space-y-2 animate-fade-in-down bg-white max-h-[80vh] overflow-y-auto">
            
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl transition font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600">
                Beranda
            </a>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Profil Desa
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('identitas-desa') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        Identitas Desa
                    </a>
                    <a href="{{ route('pemerintahan') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Pemerintahan
                    </a>
                    <a href="{{ route('bpd') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Badan Permusyawaratan Desa
                    </a>
                    <a href="{{ route('kemasyarakatan') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        Lembaga Kemasyarakatan
                    </a>
                    <a href="{{ route('data-desa') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        Demografi & Statistik
                    </a>
                    <a href="{{ route('wilayah') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Peta Desa
                    </a>
                </div>
            </details>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Layanan Publik
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('lapak') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Lapak UMKM
                    </a>
                    <a href="{{ route('kontak') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        Pengaduan Warga
                    </a>
                    <a href="{{ route('warga.surat.index') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Surat Online
                    </a>
                </div>
            </details>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Informasi
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('berita') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        Berita Pengumuman
                    </a>
                    <a href="{{ route('apbd') }}" class="group flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        APBD
                    </a>
                </div>
            </details>

            <a href="{{ route('wilayah') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('wilayah') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('wilayah') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                Wilayah
            </a>

            <a href="{{ route('admin.artikel.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('admin.artikel.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('admin.artikel.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                Berita
            </a>

            <a href="{{ route('kontak') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('kontak') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('kontak') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            <a href="{{ route('kontak') }}" class="block px-4 py-3 rounded-xl transition font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600">
                Kontak
            </a>
            
            <div class="pt-4 mt-2 border-t border-slate-100 px-2 space-y-3">
                @guest
                    <a href="{{ route('aktivasi.index') }}" 
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-slate-100 text-slate-600 font-semibold rounded-2xl hover:bg-slate-200 transition">
                        Aktivasi Akun
                    </a>

                    <a href="{{ route('login') }}" 
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-emerald-600 text-white font-semibold rounded-2xl hover:bg-emerald-700 transition shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Masuk
                    </a>
                @endguest

                @auth
                    <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl mb-2">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-slate-500">Halo,</p>
                            <p class="font-bold text-slate-700 truncate">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->role == 'warga')
                        <a href="{{ route('warga.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard Warga
                        </a>
                        <a href="{{ route('warga.profil') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Profil Saya
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-slate-100">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-semibold rounded-2xl hover:bg-red-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    /* Styling for mobile accordion without JS */
    details > summary {
        list-style: none;
    }
    details > summary::-webkit-details-marker {
        display: none;
    }
</style>

<script>
    // Script Toggle dengan Animasi yang lebih halus
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');

    if(btn && menu) {
        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });
    }

    // Shadow logic
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav');
        if (window.scrollY > 10) {
            nav.classList.add('shadow-md');
            nav.classList.remove('shadow-sm');
        } else {
            nav.classList.remove('shadow-md');
            nav.classList.add('shadow-sm');
        }
    });
</script>
