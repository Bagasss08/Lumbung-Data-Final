@php
    $identitas_nav = \App\Models\IdentitasDesa::first();
    $pengaturan_nav = \App\Models\LayananMandiriPengaturan::first();
    $lm_aktif = optional($pengaturan_nav)->aktif !== 'Tidak';
    $lm_ektp = optional($pengaturan_nav)->tampilkan_ektp === 'Ya';
    $lm_daftar = optional($pengaturan_nav)->tampilkan_pendaftaran === 'Ya';
@endphp

{{-- ── Animasi bell + Modal Login ── --}}
<style>
    @keyframes bell-ring {

        0%,
        100% {
            transform: rotate(0deg);
        }

        15% {
            transform: rotate(15deg);
        }

        30% {
            transform: rotate(-12deg);
        }

        45% {
            transform: rotate(10deg);
        }

        60% {
            transform: rotate(-8deg);
        }

        75% {
            transform: rotate(5deg);
        }

        90% {
            transform: rotate(-3deg);
        }
    }

    .bell-ring {
        animation: bell-ring 0.6s ease-in-out;
    }

    .notif-bell-wrap {
        position: relative;
        display: inline-block;
    }

    .notif-badge {
        position: absolute !important;
        top: -4px !important;
        right: -4px !important;
        z-index: 50;
        min-width: 18px;
        height: 18px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        border-radius: 9999px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .2);
        outline: 2px solid #fff;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .notif-badge.hidden-badge {
        opacity: 0;
    }

    .notif-item-right {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .notif-unread-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 9999px;
        flex-shrink: 0;
    }

    .notif-check-btn {
        width: 22px;
        height: 22px;
        border-radius: 9999px;
        border: 1.5px solid #d1d5db;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: border-color 0.15s, background 0.15s;
        padding: 0;
    }

    .notif-check-btn:hover {
        border-color: #10b981;
        background: #ecfdf5;
    }

    .notif-check-btn svg {
        width: 11px;
        height: 11px;
        stroke: #9ca3af;
        transition: stroke 0.15s;
    }

    .notif-check-btn:hover svg {
        stroke: #10b981;
    }

    @keyframes check-pop {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        60% {
            transform: scale(1.25);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .notif-check-btn.marking {
        border-color: #10b981 !important;
        background: #ecfdf5 !important;
        pointer-events: none;
    }

    .notif-check-btn.marking svg {
        stroke: #10b981 !important;
        animation: check-pop 0.25s ease-out forwards;
    }
</style>

{{-- ============================================================ --}}
{{-- NAVBAR                                                        --}}
{{-- ============================================================ --}}
<nav
    class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-100 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- ── Logo ── --}}
            <div class="flex-shrink-0 flex items-center gap-3">
                @if (
                    $identitas_nav &&
                        $identitas_nav->logo_desa &&
                        file_exists(storage_path('app/public/logo-desa/' . $identitas_nav->logo_desa)))
                    <img src="{{ asset('storage/logo-desa/' . $identitas_nav->logo_desa) }}" alt="Logo Desa"
                        class="h-10 w-10 object-contain drop-shadow-sm">
                @else
                    <div
                        class="h-10 w-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-emerald-600/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
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

            {{-- ── Menu Desktop ── --}}
            <div class="hidden xl:flex items-center justify-center gap-6 2xl:gap-8 h-full">

                <a href="{{ route('home') }}"
                    class="h-full flex items-center text-sm font-medium transition duration-300 relative group {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Beranda
                    <span
                        class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

                {{-- Profil Desa --}}
                <div class="relative group h-full">
                    <button
                        class="flex items-center h-full gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300">
                        Profil Desa
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 w-64 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] transform origin-top translate-y-2 group-hover:translate-y-0">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('identitas-desa') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                </svg>
                                Identitas Desa
                            </a>
                            <a href="{{ route('pemerintahan') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Pemerintahan
                            </a>
                            <a href="{{ route('bpd') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Badan Permusyawaratan Desa
                            </a>
                            <a href="{{ route('kemasyarakatan') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Lembaga Kemasyarakatan
                            </a>
                            <a href="{{ route('data-desa') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                Demografi & Statistik
                            </a>
                            <a href="{{ route('wilayah') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Peta Desa
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Layanan Publik --}}
                <div class="relative group h-full">
                    <button
                        class="flex items-center h-full gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300">
                        Layanan Publik
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 w-56 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] transform origin-top translate-y-2 group-hover:translate-y-0">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('lapak') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Lapak UMKM
                            </a>
                            <a href="{{ route('kontak') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Pengaduan Warga
                            </a>
                            <a href="{{ route('warga.surat.index') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Surat Online
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Informasi --}}
                <div class="relative group h-full">
                    <button
                        class="flex items-center h-full gap-1 text-sm font-medium text-slate-600 group-hover:text-emerald-600 transition duration-300">
                        Informasi
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="absolute top-full left-0 w-56 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[100] transform origin-top translate-y-2 group-hover:translate-y-0">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden py-2">
                            <a href="{{ route('apbd') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                APBD
                            </a><a href="{{ route('berita') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                Berita Pengumuman
                            </a>

                            <a href="{{ route('wisata') }}"
                                class="group flex items-center gap-3 px-5 py-2.5 text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Wisata
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('kontak') }}"
                    class="h-full flex items-center text-sm font-medium transition duration-300 relative group {{ request()->routeIs('kontak') ? 'text-emerald-600' : 'text-slate-600 hover:text-emerald-600' }}">
                    Kontak
                    <span
                        class="absolute bottom-0 left-0 h-0.5 bg-emerald-600 transition-all duration-300 {{ request()->routeIs('kontak') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>

            </div>

            {{-- ── Kanan: Auth Buttons (Desktop) ── --}}
            <div class="hidden xl:flex items-center gap-4">
                @guest
                    {{-- Tombol Masuk Desktop — Langsung ke Layanan Mandiri --}}
                    <a href="{{ route('layanan-mandiri') }}"
                    class="group flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/40 transition-all duration-300">
                        <span>Masuk</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                    </a>
                @endguest

                @auth
                    @if (Auth::user()->role == 'warga')
                        {{-- ════════════════ BELL NOTIFIKASI WARGA ════════════════ --}}
                        <div x-data="wargaNotifApp()" x-init="init()" class="notif-bell-wrap">

                            <button @click="toggleDropdown()" class="p-2 rounded-lg transition-all"
                                :class="dropdownOpen ? 'bg-emerald-50 text-emerald-600' :
                                    'text-slate-400 hover:text-emerald-600 hover:bg-emerald-50'">
                                <svg class="w-6 h-6" :class="bellRinging ? 'bell-ring' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="notif-badge" :class="totalNotif <= 0 ? 'hidden-badge' : ''"
                                    x-text="totalNotif > 99 ? '99+' : totalNotif"></span>
                            </button>

                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                @click.away="dropdownOpen = false"
                                class="absolute right-0 w-80 max-w-[90vw] md:w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-[200] flex flex-col overflow-hidden"
                                style="top: calc(100% + 8px); display:none; max-height:420px; min-width: 300px;">

                                <div
                                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 flex-shrink-0">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <span class="text-white font-semibold text-sm truncate">Notifikasi</span>
                                    </div>
                                    <span x-show="totalNotif > 0" x-text="totalNotif + ' baru'"
                                        class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full font-semibold flex-shrink-0 ml-2"
                                        style="display:none"></span>
                                </div>

                                <div class="flex-1 overflow-y-auto divide-y divide-slate-50 min-h-0">
                                    <div x-show="loading" class="flex items-center justify-center py-8">
                                        <svg class="animate-spin w-5 h-5 text-emerald-500" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                    <div x-show="!loading && notifItems.length === 0" class="py-10 text-center">
                                        <svg class="w-10 h-10 text-slate-200 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <p class="text-xs text-slate-400">Tidak ada notifikasi</p>
                                    </div>
                                    <template x-for="item in notifItems" :key="item.id">
                                        <div class="notif-item-row flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors"
                                            :class="!item.dibaca ? 'bg-emerald-50/40' : ''">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                                :class="{ 'bg-purple-100': item.tipe==='pesan', 'bg-emerald-100': item.tipe==='success', 'bg-red-100': item.tipe==='danger', 'bg-blue-100': item.tipe==='info' }">
                                                <svg x-show="item.tipe==='pesan'" class="w-4 h-4 text-purple-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <svg x-show="item.tipe==='success'" class="w-4 h-4 text-emerald-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <svg x-show="item.tipe==='danger'" class="w-4 h-4 text-red-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <svg x-show="item.tipe==='info'" class="w-4 h-4 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <a :href="item.url" class="flex-1 min-w-0 block">
                                                <p class="text-xs font-semibold text-slate-700 truncate"
                                                    x-text="item.title"></p>
                                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2"
                                                    x-text="item.message"></p>
                                                <p class="text-[10px] text-slate-400 mt-1" x-text="item.time"></p>
                                            </a>
                                            <div x-show="!item.dibaca" class="notif-item-right">
                                                <button @click.stop="markOneRead(item, $event)" class="notif-check-btn"
                                                    title="Tandai sudah dibaca">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <span class="notif-unread-dot"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div
                                    class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex justify-center items-center flex-shrink-0">
                                    <a href="{{ route('warga.notifikasi.index') }}"
                                        class="text-xs text-emerald-600 font-semibold hover:underline flex items-center gap-1 whitespace-nowrap">
                                        Selengkapnya...
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- ════════════════ END BELL NOTIFIKASI ════════════════ --}}
                    @endif

                    {{-- Profile Dropdown --}}
                    <div class="relative group z-50">
                        <button
                            class="flex items-center gap-3 px-4 py-2 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all duration-300">
                            <div
                                class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left hidden md:block">
                                <p class="text-xs text-slate-500 font-medium">Halo,</p>
                                <p class="text-sm font-semibold text-slate-700 max-w-[100px] truncate">
                                    {{ Auth::user()->name }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:rotate-180"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            class="absolute top-full right-0 pt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right z-[100]">
                            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-2">
                                @if (Auth::user()->role == 'warga')
                                    <a href="{{ route('warga.dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard Warga
                                    </a>
                                    <a href="{{ route('warga.pesan.index') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Kotak Masuk
                                    </a>
                                    <a href="{{ route('warga.aktivitas') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Aktivitas Saya
                                    </a>
                                    <a href="{{ route('warga.profil') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-slate-600 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        Dashboard Admin
                                    </a>
                                @endif
                                <hr class="my-2 border-slate-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- ── Hamburger + Bell Mobile ── --}}
            <div class="flex items-center gap-1 xl:hidden">

                @auth
                    @if (Auth::user()->role == 'warga')
                        <div x-data="wargaNotifApp()" x-init="init()" class="notif-bell-wrap">
                            <button @click="toggleDropdown()" class="p-2 rounded-lg transition-all"
                                :class="dropdownOpen ? 'bg-emerald-50 text-emerald-600' :
                                    'text-slate-400 hover:text-emerald-600 hover:bg-emerald-50'">
                                <svg class="w-6 h-6" :class="bellRinging ? 'bell-ring' : ''" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="notif-badge" :class="totalNotif <= 0 ? 'hidden-badge' : ''"
                                    x-text="totalNotif > 99 ? '99+' : totalNotif"></span>
                            </button>

                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                @click.away="dropdownOpen = false"
                                class="fixed bg-white rounded-2xl shadow-2xl border border-slate-100 z-[200] flex flex-col overflow-hidden"
                                style="top: 72px; left: 1rem; right: 1rem; display:none; max-height:70vh;">

                                <div
                                    class="flex-shrink-0 flex items-center justify-between px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <span class="text-white font-semibold text-sm truncate">Notifikasi</span>
                                    </div>
                                    <span x-show="totalNotif > 0" x-text="totalNotif + ' baru'"
                                        class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full font-semibold flex-shrink-0 ml-2"
                                        style="display:none"></span>
                                </div>

                                <div class="flex-1 overflow-y-auto divide-y divide-slate-50 min-h-0">
                                    <div x-show="loading" class="flex items-center justify-center py-8">
                                        <svg class="animate-spin w-5 h-5 text-emerald-500" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                    <div x-show="!loading && notifItems.length === 0" class="py-10 text-center">
                                        <p class="text-xs text-slate-400">Tidak ada notifikasi</p>
                                    </div>
                                    <template x-for="item in notifItems" :key="item.id">
                                        <div class="notif-item-row flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors"
                                            :class="!item.dibaca ? 'bg-emerald-50/40' : ''">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                                                :class="{ 'bg-purple-100': item.tipe==='pesan', 'bg-emerald-100': item.tipe==='success', 'bg-red-100': item.tipe==='danger', 'bg-blue-100': item.tipe==='info' }">
                                                <svg x-show="item.tipe==='pesan'" class="w-4 h-4 text-purple-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <svg x-show="item.tipe==='success'" class="w-4 h-4 text-emerald-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <svg x-show="item.tipe==='danger'" class="w-4 h-4 text-red-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <svg x-show="item.tipe==='info'" class="w-4 h-4 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <a :href="item.url" class="flex-1 min-w-0 block">
                                                <p class="text-xs font-semibold text-slate-700 truncate"
                                                    x-text="item.title"></p>
                                                <p class="text-xs text-slate-500 mt-0.5 line-clamp-2"
                                                    x-text="item.message"></p>
                                                <p class="text-[10px] text-slate-400 mt-1" x-text="item.time"></p>
                                            </a>
                                            <div x-show="!item.dibaca" class="notif-item-right">
                                                <button @click.stop="markOneRead(item, $event)" class="notif-check-btn"
                                                    title="Tandai sudah dibaca">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <span class="notif-unread-dot"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div
                                    class="flex-shrink-0 px-4 py-2.5 bg-slate-50 border-t border-slate-100 flex justify-center items-center">
                                    <a href="{{ route('warga.notifikasi.index') }}"
                                        class="text-xs text-emerald-600 font-semibold hover:underline flex items-center gap-1 whitespace-nowrap">
                                        Selengkapnya...
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                <button id="mobile-menu-btn"
                    class="p-2 rounded-lg text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 focus:outline-none transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- ── Mobile Menu ── --}}
        <div id="mobile-menu"
            class="hidden xl:hidden border-t border-slate-100 py-4 space-y-2 animate-fade-in-down bg-white max-h-[80vh] overflow-y-auto">

            <a href="{{ route('home') }}"
                class="block px-4 py-3 rounded-xl transition font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600">Beranda</a>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary
                    class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Profil Desa
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('identitas-desa') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Identitas
                        Desa</a>
                    <a href="{{ route('pemerintahan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Pemerintahan</a>
                    <a href="{{ route('bpd') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Badan
                        Permusyawaratan Desa</a>
                    <a href="{{ route('kemasyarakatan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Lembaga
                        Kemasyarakatan</a>
                    <a href="{{ route('data-desa') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Demografi
                        & Statistik</a>
                    <a href="{{ route('wilayah') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Peta
                        Desa</a>
                </div>
            </details>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary
                    class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Layanan Publik
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('lapak') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Lapak
                        UMKM</a>
                    <a href="{{ route('kontak') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Pengaduan
                        Warga</a>
                    <a href="{{ route('warga.surat.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Surat
                        Online</a>
                </div>
            </details>

            <details class="group [&::-webkit-details-marker]:hidden">
                <summary
                    class="flex items-center justify-between px-4 py-3 rounded-xl font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 cursor-pointer list-none transition">
                    Informasi
                    <svg class="w-5 h-5 transition-transform group-open:rotate-180 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </summary>
                <div class="px-3 py-2 ml-2 border-l-2 border-emerald-100 space-y-1 mt-1">
                    <a href="{{ route('apbd') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">APBD</a>
                    <a href="{{ route('berita') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Berita
                        Pengumuman</a>
                    <a href="{{ route('wisata') }}"
                        class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors">Wisata</a>
                </div>
            </details>

            <a href="{{ route('kontak') }}"
                class="block px-4 py-3 rounded-xl transition font-medium text-slate-600 hover:bg-emerald-50 hover:text-emerald-600">Kontak</a>

            <div class="pt-4 mt-2 border-t border-slate-100 px-2 space-y-3">
                @guest
                    {{-- Tombol Masuk Mobile — Langsung ke Layanan Mandiri --}}
                    <a href="{{ route('layanan-mandiri') }}"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-emerald-600 text-white font-semibold rounded-2xl hover:bg-emerald-700 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk
                    </a>
                @endguest

                @auth
                    <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl">
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Halo,</p>
                            <p class="font-bold text-slate-700 truncate">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    @if (Auth::user()->role == 'warga')
                        @php
                            $unreadMobile = \App\Models\Pesan::where('penerima_id', Auth::id())
                                ->where('sudah_dibaca', false)
                                ->count();
                        @endphp
                        <a href="{{ route('warga.pesan.index') }}"
                            class="flex items-center justify-between px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                Notifikasi
                            </div>
                            @if ($unreadMobile > 0)
                                <span
                                    class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadMobile }}</span>
                            @endif
                        </a>
                        <a href="{{ route('warga.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard Warga
                        </a>
                        <a href="{{ route('warga.aktivitas') }}"
                            class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Aktivitas Saya
                        </a>
                        <a href="{{ route('warga.profil') }}"
                            class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil Saya
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-slate-100">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-semibold rounded-2xl hover:bg-red-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    details>summary {
        list-style: none;
    }

    details>summary::-webkit-details-marker {
        display: none;
    }
</style>

<script>
    // ── Mobile menu toggle ──
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    }

    // ── Navbar shadow on scroll ──
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('nav');
        if (!nav) return;
        nav.classList.toggle('shadow-md', window.scrollY > 10);
        nav.classList.toggle('shadow-sm', window.scrollY <= 10);
    });

    // ════════════════════════════════════════════════════════════
    // WARGA NOTIFIKASI — Alpine.js component
    // ════════════════════════════════════════════════════════════
    function wargaNotifApp() {
        return {
            dropdownOpen: false,
            loading: false,
            notifItems: [],
            totalNotif: 0,
            bellRinging: false,
            soundEnabled: true,
            _initialized: false,
            _prevTotal: 0,
            _audioPlaying: false,

            init() {
                const saved = localStorage.getItem('notif_sound');
                this.soundEnabled = saved === null ? true : saved === 'true';
                this._fetchBadges(false).then(() => {
                    this._initialized = true;
                });
                setInterval(() => this._fetchBadges(true), 30000);

                window.addEventListener('warga-notif-badge-changed', (e) => {
                    const total = e.detail?.total ?? 0;
                    const naik = this._initialized && total > this._prevTotal;
                    this.totalNotif = total;
                    this._prevTotal = total;
                    if (naik) this._triggerNew();
                });
            },

            async toggleDropdown() {
                this.dropdownOpen = !this.dropdownOpen;
                if (this.dropdownOpen) await this._fetchList();
            },

            async _fetchBadges(playSound) {
                try {
                    const res = await fetch('/warga/notifikasi/badges', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();
                    const newTotal = (data.unread_pesan ?? 0) + (data.update_surat ?? 0);
                    const naik = playSound && this._initialized && newTotal > this._prevTotal;
                    this.totalNotif = newTotal;
                    this._prevTotal = newTotal;
                    if (naik) this._triggerNew();
                } catch (e) {}
            },

            async _fetchList() {
                this.loading = true;
                try {
                    const res = await fetch('/warga/notifikasi/list', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    const data = await res.json();
                    this.notifItems = (data.items ?? []).map(item => ({
                        ...item,
                        dibaca: item.is_read ?? item.dibaca ?? false,
                        tipe: item.type ?? item.tipe ?? 'pesan',
                        title: item.title ?? item.judul ?? '',
                        message: item.message ?? item.pesan ?? '',
                        time: item.time ?? item.waktu ?? '',
                    }));
                } catch (e) {
                    this.notifItems = [];
                } finally {
                    this.loading = false;
                }
            },

            async markOneRead(item, event) {
                if (item.dibaca) return;
                const btn = event?.currentTarget;
                const row = btn?.closest('.notif-item-row');
                if (btn) btn.classList.add('marking');
                if (row) row.classList.add('marked');
                try {
                    await fetch('/warga/notifikasi/baca-satu', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? ''
                        },
                        body: JSON.stringify({
                            id: item.id,
                            tipe: item.tipe
                        })
                    });
                    setTimeout(() => {
                        item.dibaca = true;
                        if (this.totalNotif > 0) {
                            this.totalNotif--;
                            this._prevTotal = this.totalNotif;
                        }
                    }, 300);
                } catch (e) {
                    if (btn) btn.classList.remove('marking');
                    if (row) row.classList.remove('marked');
                }
            },

            _triggerNew() {
                this.bellRinging = true;
                setTimeout(() => {
                    this.bellRinging = false;
                }, 1000);
                this._playSound();
            },

            _playSound() {
                if (!this.soundEnabled || this._audioPlaying) return;
                this._audioPlaying = true;
                try {
                    const snd = new Audio('/sounds/notif.mp3');
                    snd.volume = 0.6;
                    snd.play()
                        .then(() => {
                            snd.addEventListener('ended', () => {
                                this._audioPlaying = false;
                            }, {
                                once: true
                            });
                        })
                        .catch(() => {
                            this._audioPlaying = false;
                            this._playBeep();
                        });
                } catch (e) {
                    this._audioPlaying = false;
                }
            },

            _playBeep() {
                if (this._audioPlaying) return;
                this._audioPlaying = true;
                try {
                    const ctx = new(window.AudioContext || window.webkitAudioContext)();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(660, ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.001, ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0.3, ctx.currentTime + 0.01);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.4);
                    osc.addEventListener('ended', () => {
                        ctx.close();
                        this._audioPlaying = false;
                    });
                } catch (e) {
                    this._audioPlaying = false;
                }
            },
        };
    }
</script>
