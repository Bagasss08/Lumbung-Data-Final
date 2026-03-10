<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SuperAdmin</title>
    
    {{-- Tailwind CDN dengan Play CDN lebih ringan & hanya load class yang dipakai --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Google Fonts: Satu font saja = load lebih cepat --}}
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

        /* Scrollbar minimal */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 99px; }

        /* Sidebar */
        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
        }

        /* Logo glow */
        .logo-icon {
            background: var(--accent);
            box-shadow: 0 0 20px var(--accent-glow), 0 0 40px rgba(59,130,246,0.1);
        }

        /* Nav item base */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--text-secondary);
            font-size: 13.5px;
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

        .nav-item:hover .nav-icon {
            color: var(--accent);
        }

        /* Active state */
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
            width: 3px; height: 18px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 8px var(--accent-glow);
        }

        /* Nav icon */
        .nav-icon {
            width: 18px; height: 18px;
            flex-shrink: 0;
            color: var(--text-muted);
            transition: color 0.18s ease;
        }

        /* Section label */
        .section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 14px;
            margin: 20px 0 6px;
        }

        /* Submenu */
        .submenu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px 8px 38px;
            border-radius: 8px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .submenu-item:hover { color: #fff; background: var(--hover-bg); }

        .submenu-item.active {
            color: var(--accent);
            background: var(--accent-soft);
        }

        .submenu-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
            transition: background 0.15s;
        }

        /* Divider */
        .sidebar-divider {
            height: 1px;
            background: var(--sidebar-border);
            margin: 8px 0;
        }

        /* User card */
        .user-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--sidebar-border);
            border-radius: 12px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; color: #fff;
            flex-shrink: 0;
        }

        /* Logout button */
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 9px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(239,68,68,0.7);
            background: transparent;
            border: 1px solid rgba(239,68,68,0.15);
            transition: all 0.2s ease;
            cursor: pointer;
            margin-top: 10px;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border-color: rgba(239,68,68,0.3);
        }

        /* Header */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Page fade-in */
        main { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        /* Overlay mobile */
        .sidebar-overlay {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(2px);
        }

        /* Collapse animation */
        [x-cloak] { display: none !important; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accent: '#3b82f6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 antialiased" x-data="{ sidebarOpen: false }">

@php
    // Menghitung total pesan belum dibaca khusus untuk Superadmin
    $totalUnreadChat = \App\Models\Message::where('receiver_id', Auth::id())
                                          ->where('is_read', false)
                                          ->count();
@endphp

<div class="flex h-screen overflow-hidden">

    {{-- Overlay Mobile --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="sidebar-overlay fixed inset-0 z-20 lg:hidden"
         @click="sidebarOpen = false"
         x-cloak></div>

    {{-- SIDEBAR --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar fixed inset-y-0 left-0 z-30 w-60 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-[60px] border-b border-white/5">
            <div class="logo-icon w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-[14px] leading-tight tracking-wide">SuperAdmin</p>
                <p class="text-[10px]" style="color: var(--text-muted)">Sistem Informasi Desa</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

            {{-- Main --}}
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

            {{-- Divider --}}
            <div class="sidebar-divider"></div>

            {{-- Komunikasi --}}
            <p class="section-label">Komunikasi</p>

            {{-- Dropdown Komunikasi --}}
            <div x-data="{ open: {{ request()->routeIs('superadmin.livechat.*', 'superadmin.pengumuman.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="nav-item {{ request()->routeIs('superadmin.livechat.*', 'superadmin.pengumuman.*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="flex-1">Komunikasi</span>
                    <svg :class="open ? 'rotate-180' : ''"
                         class="w-3.5 h-3.5 transition-transform duration-200 flex-shrink-0"
                         style="color: var(--text-muted)"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak
                     class="mt-0.5 space-y-0.5">

                    <a href="{{ route('superadmin.livechat.index') }}"
                       class="submenu-item flex justify-between items-center pr-4 {{ request()->routeIs('superadmin.livechat.*') ? 'active' : '' }}">
                        <div class="flex items-center">
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

            {{-- Divider --}}
            <div class="sidebar-divider"></div>

            {{-- Sistem --}}
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
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                Log Sistem
            </a>

        </nav>

        {{-- User Card + Logout --}}
        <div class="px-3 pb-4">
            <div class="sidebar-divider mb-3"></div>
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-white text-[13px] font-semibold truncate">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                    <p class="text-[11px] truncate" style="color: var(--text-muted)">{{ Auth::user()->email ?? 'admin@desa.id' }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex flex-col flex-1 overflow-hidden">

        {{-- Topbar --}}
        <header class="topbar flex items-center justify-between px-6 h-[60px] flex-shrink-0">
            <div class="flex items-center gap-3">
                {{-- Toggle Mobile --}}
                <button @click="sidebarOpen = true"
                        class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors lg:hidden">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>

                {{-- Breadcrumb / Page Title --}}
                <div>
                    <h1 class="text-[15px] font-bold text-gray-800">@yield('header', 'Dashboard')</h1>
                    <p class="text-[11px] text-gray-400 hidden sm:block">@yield('subheader', 'Selamat datang di panel SuperAdmin')</p>
                </div>
            </div>

            {{-- Right: Notif + User --}}
            <div class="flex items-center gap-3">
                {{-- Notif bell --}}
                <button class="relative p-2 rounded-xl text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-blue-500 rounded-full ring-2 ring-white"></span>
                </button>

                {{-- User badge --}}
                <div class="flex items-center gap-2.5 pl-3 border-l border-gray-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-[13px] font-semibold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'Super Admin' }}</p>
                        <p class="text-[11px] text-blue-500 font-medium uppercase tracking-wider">{{ Auth::user()->role ?? 'superadmin' }}</p>
                    </div>
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-[13px] shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-5 md:p-7">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>