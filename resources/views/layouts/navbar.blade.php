@php
    // Ambil data identitas desa langsung di view agar selalu dinamis
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

            <div class="hidden xl:flex items-center justify-center gap-6 2xl:gap-8">
                
                <a href="{{ route('home') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Beranda
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('profil') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('profil') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Profil Desa
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('profil') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('pemerintahan') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('pemerintahan') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Pemerintahan
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('pemerintahan') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('data-desa') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('data-desa') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Data Desa
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('data-desa') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('wilayah') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('wilayah') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Wilayah
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('wilayah') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('berita') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('artikel*') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Berita
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('artikel*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                <a href="{{ route('kontak') }}" class="text-sm font-medium transition duration-300 relative group py-2 {{ request()->routeIs('kontak') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Kontak
                    <span class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('kontak') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

            </div>

            <div class="hidden xl:flex items-center gap-4">
                {{-- LOGIKA: Jika Pengunjung BELUM Login (Guest) --}}
                @guest
                    <!-- <a href="{{ route('aktivasi.index') }}" 
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-slate-100 text-slate-600 font-semibold rounded-2xl hover:bg-slate-200 transition">
                        Aktivasi Akun
                    </a> -->
                    <a href="{{ route('aktivasi.index') }}" 
                    class="text-sm font-semibold gap-2 w-full px-4 py-3 bg-slate-200 text-slate-600 rounded-2xl hover:bg-slate-200 hover:text-emerald-600 transition duration-300">
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

                {{-- LOGIKA: Jika Pengunjung SUDAH Login (Auth) --}}
                @auth
                    <div class="relative group z-50">
                        <button class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all duration-300">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }} </div>
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
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
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

        <div id="mobile-menu" class="hidden xl:hidden border-t border-slate-100 py-4 space-y-2 animate-fade-in-down bg-white/50">
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Beranda
            </a>

            <a href="{{ route('profil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('profil') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('profil') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Profil Desa
            </a>

            <a href="{{ route('pemerintahan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('pemerintahan') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('pemerintahan') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Pemerintahan
            </a>

            <a href="{{ route('data-desa') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition font-medium group {{ request()->routeIs('data-desa') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-600' }}">
                <svg class="w-5 h-5 transition {{ request()->routeIs('data-desa') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Data Desa
            </a>

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
                Kontak
            </a>
            
            <div class="pt-4 mt-2 border-t border-slate-100 px-2 space-y-3">
                
                {{-- LOGIKA 1: Jika Belum Login (Tamu) --}}
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

                {{-- LOGIKA 2: Jika Sudah Login (User/Admin) --}}
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-slate-100">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-semibold rounded-2xl hover:bg-red-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

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