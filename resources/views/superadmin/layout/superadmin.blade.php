<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SuperAdmin</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        :root {
            --sidebar-bg: #0a0f1e;
            --sidebar-border: rgba(255,255,255,0.06);
            --accent: #3b82f6;
            --accent-glow: rgba(59,130,246,0.25);
            --accent-soft: rgba(59,130,246,0.1);
            --text-muted: rgba(255,255,255,0.4);
            --text-secondary: rgba(255,255,255,0.65);
            --hover-bg: rgba(255,255,255,0.05);
            --active-bg: rgba(59,130,246,0.15);
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 99px; }

        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
        }

        /* Logo box diperbesar agar gambar jelas */
        .logo-box {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            flex-shrink: 0;
            box-shadow: 0 0 15px rgba(59,130,246,0.2);
        }

        /* Nav item ditingkatkan font-nya ke 15px agar tidak kekecilan */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-secondary);
            font-size: 15px; 
            font-weight: 500;
            transition: all 0.18s ease;
            position: relative;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .nav-item:hover {
            background: var(--hover-bg);
            color: #fff;
        }

        .nav-item:hover .nav-icon { color: var(--accent); }

        .nav-item.active {
            background: var(--active-bg);
            color: #fff;
            border: 1px solid rgba(59,130,246,0.2);
        }

        .nav-item.active .nav-icon { color: var(--accent); }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 4px; height: 20px;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px; height: 20px;
            flex-shrink: 0;
            color: var(--text-muted);
            transition: color 0.18s ease;
        }

        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 16px;
            margin: 24px 0 8px;
        }

        .submenu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px 10px 42px;
            border-radius: 8px;
            color: var(--text-muted);
            font-size: 14.5px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .submenu-item:hover { color: #fff; background: var(--hover-bg); }
        .submenu-item.active { color: var(--accent); background: var(--accent-soft); }

        .submenu-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--sidebar-border);
            margin: 10px 0;
        }

        .user-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--sidebar-border);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 15px; color: #fff;
            flex-shrink: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(239,68,68,0.85);
            background: transparent;
            border: 1px solid rgba(239,68,68,0.15);
            transition: all 0.2s ease;
            cursor: pointer;
            margin-top: 12px;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border-color: rgba(239,68,68,0.3);
        }

        .topbar { background: #fff; border-bottom: 1px solid #f0f0f0; }

        main { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 antialiased" x-data="{ sidebarOpen: false }">

@php
    // Ambil identitas desa untuk logo & nama
    try {
        $identitasDesa = \Illuminate\Support\Facades\DB::table('identitas_desa')->first();
    } catch (\Exception $e) {
        $identitasDesa = null;
    }

    // Menghitung total pesan belum dibaca khusus untuk Superadmin
    $totalUnreadChat = \App\Models\Message::where('receiver_id', Auth::id())
                                          ->where('is_read', false)
                                          ->count();
@endphp

<div class="flex h-screen overflow-hidden">

    {{-- Overlay Mobile --}}
    <div x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 z-20 bg-black/50 backdrop-blur-sm lg:hidden"
         x-cloak></div>

    {{-- SIDEBAR --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

        {{-- Logo Section --}}
        <div class="flex items-center gap-3 px-5 h-[80px] border-b border-white/5">
            <div class="logo-box">
                @if($identitasDesa && $identitasDesa->logo_desa && file_exists(public_path('storage/logo-desa/'.$identitasDesa->logo_desa)))
                    <img src="{{ asset('storage/logo-desa/'.$identitasDesa->logo_desa) }}" class="w-full h-full object-contain" alt="Logo Desa">
                @else
                    {{-- Fallback icon kalau gambar ga ada --}}
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-white font-bold text-[16px] leading-tight truncate">
                    {{ $identitasDesa->nama_desa ?? 'SuperAdmin' }}
                </p>
                <p class="text-[11px] font-medium" style="color: var(--text-muted)">Sistem Informasi Desa</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-6 overflow-y-auto space-y-1">

            <p class="section-label">Utama</p>

            <a href="{{ route('superadmin.dashboard') }}"
               class="nav-item {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('superadmin.users.index') }}"
               class="nav-item {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Manajemen User
            </a>

            <div class="sidebar-divider"></div>

            <p class="section-label">Komunikasi</p>

            <div x-data="{ open: {{ request()->routeIs('superadmin.livechat.*', 'superadmin.pengumuman.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="nav-item {{ request()->routeIs('superadmin.livechat.*', 'superadmin.pengumuman.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="flex-1">Komunikasi</span>
                    <svg :class="open ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div x-show="open" x-transition x-cloak class="mt-1 space-y-1">
                    <a href="{{ route('superadmin.livechat.index') }}"
                       class="submenu-item flex justify-between {{ request()->routeIs('superadmin.livechat.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-2">
                            <span class="submenu-dot"></span>
                            Live Chat
                        </div>
                        @if($totalUnreadChat > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                                {{ $totalUnreadChat }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('superadmin.pengumuman.index') }}"
                       class="submenu-item {{ request()->routeIs('superadmin.pengumuman.*') ? 'active' : '' }}">
                        <span class="submenu-dot"></span>
                        Pengumuman
                    </a>
                </div>
            </div>

            <div class="sidebar-divider"></div>

            <p class="section-label">Sistem</p>

            <a href="{{ route('superadmin.settings.index') }}"
               class="nav-item {{ request()->routeIs('superadmin.settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Pengaturan
            </a>

            <a href="{{ route('superadmin.logs.index') }}"
               class="nav-item {{ request()->routeIs('superadmin.logs.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Log Sistem
            </a>
        </nav>

        {{-- Footer User --}}
        <div class="px-3 pb-6">
            <div class="sidebar-divider mb-4"></div>
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-[14px] font-semibold truncate">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                    <p class="text-[11px] truncate text-white/50">{{ Auth::user()->email ?? 'admin@desa.id' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    Keluar Aplikasi
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex flex-col flex-1 overflow-hidden">
        {{-- Topbar --}}
        <header class="topbar flex items-center justify-between px-6 h-[70px] flex-shrink-0">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 lg:hidden">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div>
                    <h1 class="text-[18px] font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <p class="text-[12px] text-gray-400 hidden sm:block">@yield('subheader', 'Selamat datang di panel SuperAdmin')</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative p-2.5 rounded-xl text-gray-400 hover:bg-gray-50 transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-blue-500 rounded-full ring-2 ring-white"></span>
                </button>

                <div class="flex items-center gap-3 pl-4 border-l">
                    <div class="text-right hidden sm:block">
                        <p class="text-[14px] font-bold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-blue-500 font-bold uppercase tracking-wider">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-[14px] shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8 bg-gray-50/50">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>