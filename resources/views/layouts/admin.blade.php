<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lumbung Data Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Hover expand sidebar */
        .sidebar {
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .menu-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item:hover {
            transform: translateX(4px);
        }

        .menu-header .chevron {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-header.open .chevron {
            transform: rotate(180deg);
        }

        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .submenu.open {
            max-height: 2000px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Sidebar ── */
        .sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s, width 0.2s;
        }

        .sidebar.collapsed .chevron {
            display: none;
        }

        .sidebar.collapsed .submenu {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-badge {
            display: none;
        }

        .sidebar.collapsed .menu-item,
        .sidebar.collapsed .menu-header,
        .sidebar.collapsed .logo-wrapper,
        .sidebar.collapsed .menu-item>div,
        .sidebar.collapsed .menu-header>div {
            justify-content: center !important;
            padding-left: 0;
            padding-right: 0;
            gap: 0 !important;
        }

        .sidebar.collapsed .menu-item:hover {
            transform: scale(1.1);
        }

        .toggle-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-btn:hover {
            transform: scale(1.05);
        }

        .sidebar.collapsed [data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
            padding: 6px 12px;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 100;
            pointer-events: none;
        }

        .sidebar.collapsed .menu-item,
        .sidebar.collapsed .menu-header {
            position: relative;
        }

        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar.collapsed .logout-btn {
            padding: 0.75rem;
            justify-content: center;
            gap: 0 !important;
        }

        /* ── Bell ring animation ── */
        @keyframes ring {

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
            animation: ring 0.6s ease-in-out;
        }

        /* ── Panel Informasi ── */
        [x-cloak] {
            display: none !important;
        }
    </style>

    @php
        $desa = App\Models\IdentitasDesa::first();
        if (!$desa) {
            $desa = App\Models\IdentitasDesa::create([
                'nama_desa' => '',
                'kode_desa' => '',
                'kecamatan' => '',
                'kabupaten' => '',
                'provinsi' => '',
            ]);
        }
        $isDesaFilled =
            $desa &&
            !empty($desa->nama_desa) &&
            $desa->nama_desa !== 'Desa Belum Diatur' &&
            !empty($desa->kode_desa) &&
            $desa->kode_desa !== '000000';
    @endphp
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 antialiased" x-data="{ sidebarOpen: true, sidebarHovered: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ================================================================ -->
        <!-- SIDEBAR                                                           -->
        <!-- ================================================================ -->
        <aside
            class="sidebar bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 text-white flex-shrink-0 shadow-2xl"
            :class="(sidebarOpen || sidebarHovered) ? 'w-72' : 'w-[80px] collapsed'"
            @mouseenter="if (!sidebarOpen) sidebarHovered = true" @mouseleave="sidebarHovered = false"
            x-data="{
                infoDesa: {{ request()->is('admin/identitas-desa*') || request()->is('admin/info-desa/wilayah*') || request()->is('admin/pemerintah-desa*') || request()->is('admin/lembaga*') || request()->is('admin/status-desa*') || request()->is('admin/layanan-pelanggan*') || request()->is('admin/kerjasama*') ? 'true' : 'false' }},
                kependudukan: {{ request()->is('admin/penduduk*') || request()->is('admin/keluarga*') || request()->is('admin/rumah-tangga*') || request()->is('admin/kelompok*') || request()->is('admin/suplemen*') || request()->is('admin/calon-pemilih*') ? 'true' : 'false' }},
                statistik: {{ request()->is('admin/statistik*') ? 'true' : 'false' }},
                kesehatan: {{ request()->is('admin/kesehatan*') ? 'true' : 'false' }},
                kehadiran: {{ request()->is('admin/kehadiran*') ? 'true' : 'false' }},
                layananSurat: {{ request()->is('admin/layanan-surat*') ? 'true' : 'false' }},
                sekretariat: {{ request()->is('admin/sekretariat*') ? 'true' : 'false' }},
                suratDinas: {{ request()->is('admin/surat-dinas*') ? 'true' : 'false' }},
                bukuAdministrasi: {{ request()->is('admin/buku-administrasi*') ? 'true' : 'false' }},
                keuangan: {{ request()->is('admin/keuangan*') ? 'true' : 'false' }},
                pertanahan: {{ request()->is('admin/pertanahan*') ? 'true' : 'false' }},
                opendk: {{ request()->is('admin/opendk*') ? 'true' : 'false' }},
                sistem: {{ request()->is('admin/pengguna*') || request()->is('admin/role*') || request()->is('admin/pengaturan*') || request()->is('admin/backup*') || request()->is('admin/log*') ? 'true' : 'false' }},
                artikelMenu: {{ request()->is('admin/artikel*') || request()->is('admin/komentar*') ? 'true' : 'false' }},
                hubungWarga: {{ request()->is('admin/hubung-warga*') ? 'true' : 'false' }}
            }">

            <div :class="sidebarOpen ? 'p-6' : 'py-6 px-3'">

                <!-- Logo -->
                <div class="logo-wrapper flex items-center gap-3 mb-8 pb-6 border-b border-white/10 transition-all">
                    <div
                        class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center text-xl font-bold shadow-lg flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="logo-text">
                        <h1 class="text-xl font-bold whitespace-nowrap">Lumbung Data</h1>
                        <p class="text-xs text-white/70 whitespace-nowrap">Admin Panel</p>
                    </div>
                </div>

                <nav class="space-y-1">

                    <!-- Beranda -->
                    <a href="/admin/dashboard" data-tooltip="Beranda"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Beranda</span>
                    </a>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <!-- INFO DESA -->
                    <div>
                        <button @click="infoDesa = !infoDesa" data-tooltip="Info Desa"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': infoDesa, 'bg-white/15': infoDesa }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Info Desa</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': infoDesa }">
                            <a href="/admin/identitas-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/identitas-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Identitas Desa</span>
                            </a>
                            <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.info-desa.wilayah-administratif') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Wilayah Administratif</span>
                            </a>
                            <a href="/admin/pemerintah-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pemerintah-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pemerintah Desa</span>
                            </a>
                            <a href="/admin/lembaga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/lembaga*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Lembaga Desa</span>
                            </a>
                            <a href="{{ route('admin.status-desa.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/status-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Status Desa</span>
                            </a>
                            <a href="{{ route('admin.layanan-pelanggan.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-pelanggan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Layanan Pelanggan</span>
                            </a>
                            <a href="{{ route('admin.kerjasama.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kerjasama*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendaftaran Kerjasama</span>
                            </a>
                        </div>
                    </div>

                    <!-- KEPENDUDUKAN -->
                    <div>
                        <button @click="kependudukan = !kependudukan" data-tooltip="Kependudukan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kependudukan, 'bg-white/15': kependudukan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kependudukan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kependudukan }">
                            <a href="/admin/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/penduduk*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Penduduk</span>
                            </a>
                            <a href="/admin/keluarga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keluarga*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Keluarga</span>
                            </a>
                            <a href="{{ route('admin.rumah-tangga.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/rumah-tangga*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rumah Tangga</span>
                            </a>
                            <a href="/admin/kelompok"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kelompok*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kelompok</span>
                            </a>
                            <a href="/admin/suplemen"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/suplemen*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Data Suplemen</span>
                            </a>
                            <a href="/admin/calon-pemilih"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/calon-pemilih*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Calon Pemilih</span>
                            </a>
                        </div>
                    </div>

                    <!-- STATISTIK -->
                    <div>
                        <button @click="statistik = !statistik" data-tooltip="Statistik"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': statistik, 'bg-white/15': statistik }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Statistik</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': statistik }">
                            <a href="/admin/statistik/kependudukan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/kependudukan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Statistik Kependudukan</span>
                            </a>
                            <a href="/admin/statistik/laporan-bulanan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/laporan-bulanan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Bulanan</span>
                            </a>
                            <a href="/admin/statistik/kelompok-rentan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/kelompok-rentan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Kelompok Rentan</span>
                            </a>
                            <a href="/admin/statistik/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/penduduk*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Penduduk</span>
                            </a>
                        </div>
                    </div>

                    <!-- KESEHATAN -->
                    <div>
                        <button @click="kesehatan = !kesehatan" data-tooltip="Kesehatan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kesehatan, 'bg-white/15': kesehatan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kesehatan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kesehatan }">
                            <a href="/admin/kesehatan/pendataan/posyandu"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/pendataan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendataan</span>
                            </a>
                            <a href="/admin/kesehatan/pemantauan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/pemantauan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pemantauan</span>
                            </a>
                            <a href="/admin/kesehatan/vaksin"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/vaksin*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Vaksin</span>
                            </a>
                            <a href="/admin/kesehatan/stunting/posyandu"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/stunting*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Stunting</span>
                            </a>
                        </div>
                    </div>

                    <!-- KEHADIRAN -->
                    <div>
                        <button @click="kehadiran = !kehadiran" data-tooltip="Kehadiran"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kehadiran, 'bg-white/15': kehadiran }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kehadiran</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kehadiran }">
                            <a href="{{ route('admin.kehadiran.jam-kerja.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/jam-kerja*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Jam Kerja</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.hari-libur.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/hari-libur*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Hari Libur</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.rekapitulasi.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kehadiran.rekapitulasi.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rekapitulasi</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.pengaduan-kehadiran.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/pengaduan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaduan</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.input.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/input*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Input Kehadiran</span>
                            </a>
                        </div>
                    </div>

                    <!-- LAYANAN SURAT -->
                    <div>
                        <button @click="layananSurat = !layananSurat" data-tooltip="Layanan Surat"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': layananSurat, 'bg-white/15': layananSurat }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Layanan Surat</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': layananSurat }">
                            <a href="/admin/layanan-surat/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/pengaturan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/cetak"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/cetak*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Cetak Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/permohonan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/permohonan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Permohonan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/arsip"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/arsip*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Arsip Layanan</span>
                            </a>
                            <a href="/admin/layanan-surat/daftar-persyaratan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/daftar-persyaratan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Daftar Persyaratan</span>
                            </a>
                        </div>
                    </div>

                    <!-- SEKRETARIAT -->
                    <div>
                        <button @click="sekretariat = !sekretariat" data-tooltip="Sekretariat"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': sekretariat, 'bg-white/15': sekretariat }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Sekretariat</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': sekretariat }">
                            <a href="/admin/sekretariat/informasi-publik"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/informasi-publik*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Informasi Publik</span>
                            </a>
                            <a href="/admin/sekretariat/inventaris"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/inventaris*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Inventaris</span>
                            </a>
                            <a href="/admin/sekretariat/klasifikasi-surat"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/klasifikasi-surat*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Klasifikasi Surat</span>
                            </a>
                        </div>
                    </div>

                    <!-- BUKU ADMINISTRASI -->
                    <div>
    <button @click="bukuAdministrasi = !bukuAdministrasi" data-tooltip="Buku Administrasi"
        class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
        :class="{ 'open': bukuAdministrasi }">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span class="menu-text whitespace-nowrap">Buku Administrasi</span>
        </div>
        <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': bukuAdministrasi }">
        
        <a href="/admin/buku-administrasi/umum"
            class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.umum*') ? 'bg-white/15 text-white' : '' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
            <span class="menu-text whitespace-nowrap">Admin Umum</span>
        </a>

        <a href="/admin/buku-administrasi/penduduk"
            class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.penduduk*') ? 'bg-white/15 text-white' : '' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
            <span class="menu-text whitespace-nowrap">Admin Penduduk</span>
        </a>

        <a href="/admin/buku-administrasi/pembangunan"
            class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.pembangunan*') ? 'bg-white/15 text-white' : '' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
            <span class="menu-text whitespace-nowrap">Admin Pembangunan</span>
        </a>

        <a href="/admin/buku-administrasi/arsip"
            class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.arsip*') ? 'bg-white/15 text-white' : '' }}">
            <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
            <span class="menu-text whitespace-nowrap">Arsip</span>
        </a>

    </div>
</div>

                    <!-- KEUANGAN -->
                    <div>
                        <button @click="keuangan = !keuangan" data-tooltip="Keuangan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': keuangan, 'bg-white/15': keuangan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Keuangan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': keuangan }">
                            <a href="/admin/keuangan/kas-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/kas-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kas Desa</span>
                            </a>
                            <a href="/admin/keuangan/laporan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/laporan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan</span>
                            </a>
                            <a href="/admin/keuangan/input-data"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/input-data*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Input Data</span>
                            </a>
                            <a href="/admin/keuangan/laporan-apbdes"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/laporan-apbdes*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan APBDes</span>
                            </a>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <!-- Analisis -->
                    <a href="/admin/analisis" data-tooltip="Analisis"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/analisis*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Analisis</span>
                    </a>

                    <!-- Bantuan -->
                    <a href="/admin/bantuan" data-tooltip="Bantuan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/bantuan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Bantuan</span>
                    </a>

                    <!-- MANAJEMEN ARTIKEL -->
                    <div>
                        @php
                            $pendingComments = class_exists(\App\Models\KomentarArtikel::class)
                                ? \App\Models\KomentarArtikel::where('status', 'pending')->count()
                                : 0;
                        @endphp
                        <button @click="artikelMenu = !artikelMenu" data-tooltip="Manajemen Artikel"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': artikelMenu, 'bg-white/15': artikelMenu }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Manajemen Artikel</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($pendingComments > 0)
                                    <span
                                        class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full sidebar-badge">{{ $pendingComments }}</span>
                                @endif
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': artikelMenu }">
                            <a href="{{ route('admin.artikel.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.artikel.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Daftar Artikel</span>
                            </a>
                            <a href="{{ route('admin.komentar.index') }}"
                                class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.komentar.*') ? 'bg-white/15 text-white' : '' }}">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Komentar</span>
                                </div>
                                @if ($pendingComments > 0)
                                    <span
                                        class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full sidebar-badge">{{ $pendingComments }}</span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- PERTANAHAN -->
                    <div>
                        <button @click="pertanahan = !pertanahan" data-tooltip="Pertanahan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': pertanahan, 'bg-white/15': pertanahan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Pertanahan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': pertanahan }">
                            <a href="/admin/pertanahan/c-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pertanahan/c-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">C Desa</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pembangunan -->
                    <a href="/admin/pembangunan" data-tooltip="Pembangunan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/pembangunan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pembangunan</span>
                    </a>

                    <!-- Lapak -->
                    <a href="/admin/lapak" data-tooltip="Lapak"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/lapak*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Lapak</span>
                    </a>

                    <!-- OPENDK -->
                    <div>
                        <button @click="opendk = !opendk" data-tooltip="OpenDK"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': opendk, 'bg-white/15': opendk }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">OpenDK</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': opendk }">
                            <a href="/admin/opendk/placeholder"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/opendk/placeholder*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Placeholder</span>
                            </a>
                        </div>
                    </div>

                    <!-- HUBUNG WARGA -->
                    <div>
                        @php
                            $unreadPesan = class_exists(\App\Models\Pesan::class)
                                ? \App\Models\Pesan::where('penerima_id', Auth::id())
                                    ->where('sudah_dibaca', false)
                                    ->count()
                                : 0;
                        @endphp
                        <button @click="hubungWarga = !hubungWarga" data-tooltip="Hubung Warga"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': hubungWarga, 'bg-white/15': hubungWarga }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Hubung Warga</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($unreadPesan > 0)
                                    <span
                                        class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full sidebar-badge">{{ $unreadPesan }}</span>
                                @endif
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': hubungWarga }">
                            <a href="{{ route('admin.hubung-warga.inbox') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.hubung-warga.inbox') || request()->routeIs('admin.hubung-warga.create') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kotak Masuk</span>
                            </a>
                            <a href="{{ route('admin.hubung-warga.sent') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.hubung-warga.sent') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pesan Terkirim</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pengaduan -->
                    <a href="/admin/pengaduan" data-tooltip="Pengaduan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/pengaduan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pengaduan</span>
                    </a>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <!-- SISTEM -->
                    <div>
                        <button @click="sistem = !sistem" data-tooltip="Sistem"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': sistem, 'bg-white/15': sistem }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Sistem</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': sistem }">
                            <a href="{{ route('admin.pengguna.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pengguna*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengguna</span>
                            </a>
                            <a href="/admin/role"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/role*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Hak Akses</span>
                            </a>
                            <a href="/admin/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pengaturan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Desa</span>
                            </a>
                            <a href="/admin/backup"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/backup*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Backup & Restore</span>
                            </a>
                            <a href="/admin/log"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/log*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Log Aktivitas</span>
                            </a>
                        </div>
                    </div>

                </nav>

                <!-- Logout -->
                <div class="mt-8 pt-6 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" data-tooltip="Logout"
                            class="logout-btn w-full flex items-center justify-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm border border-white/20">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="menu-text whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ================================================================ -->
        <!-- MAIN CONTENT                                                      -->
        <!-- ================================================================ -->
        <main class="flex-1 flex flex-col overflow-hidden">

            <!-- ============================================================ -->
            <!-- TOPBAR                                                        -->
            <!-- ============================================================ -->
            <header
                class="bg-white border-b border-gray-200 px-6 py-3.5 flex items-center justify-between shadow-sm sticky top-0 z-50"
                x-data="topbarApp()" x-init="init()">

                <!-- Kiri: Toggle + Judul -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="toggle-btn p-2 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold gradient-text">@yield('title', 'Dashboard')</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Sistem Lumbung Data Desa</p>
                    </div>
                </div>

                <!-- Kanan: Action buttons -->
                <div class="flex items-center gap-1" x-data="{ pengaturanOpen: false }">

                    {{-- ① Cetak Surat --}}
                    <a href="/admin/layanan-surat/cetak" title="Cetak Surat"
                        class="p-2 rounded-lg transition-all {{ request()->is('admin/layanan-surat/cetak*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </a>

                    {{-- ② Komentar --}}
                    @php
                        $pendingKomentar = class_exists(\App\Models\KomentarArtikel::class)
                            ? \App\Models\KomentarArtikel::where('status', 'pending')->count()
                            : 0;
                    @endphp
                    <a href="{{ route('admin.komentar.index') }}?status=pending" title="Komentar Menunggu"
                        class="relative p-2 rounded-lg transition-all {{ request()->routeIs('admin.komentar.*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        <span x-show="pendingKomentar > 0" x-text="pendingKomentar > 99 ? '99+' : pendingKomentar"
                            class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm"
                            style="display:none"></span>
                        @if ($pendingKomentar > 0)
                            <noscript>
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm">
                                    {{ $pendingKomentar > 99 ? '99+' : $pendingKomentar }}
                                </span>
                            </noscript>
                        @endif
                    </a>

                    {{-- ③ Pesan Masuk --}}
                    @php
                        $unreadPesanTopbar = class_exists(\App\Models\Pesan::class)
                            ? \App\Models\Pesan::where('penerima_id', Auth::id())->where('sudah_dibaca', false)->count()
                            : 0;
                    @endphp
                    <a href="{{ route('admin.hubung-warga.inbox') }}" title="Pesan Masuk"
                        class="relative p-2 rounded-lg transition-all {{ request()->routeIs('admin.hubung-warga.inbox') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span x-show="unreadPesan > 0" x-text="unreadPesan > 99 ? '99+' : unreadPesan"
                            class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm"
                            style="display:none"></span>
                        @if ($unreadPesanTopbar > 0)
                            <noscript>
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm">
                                    {{ $unreadPesanTopbar > 99 ? '99+' : $unreadPesanTopbar }}
                                </span>
                            </noscript>
                        @endif
                    </a>

                    {{-- ④ Permohonan Surat — bell yang bergetar jika ada yang baru --}}
                    @php
                        $pendingPermohonan = class_exists(\App\Models\LayananSurat::class)
                            ? \App\Models\LayananSurat::where('status', 'menunggu')->count()
                            : 0;
                    @endphp
                   <a href="/admin/layanan-surat/permohonan" title="Permohonan Surat"
                        class="relative p-2 rounded-lg transition-all {{ request()->is('admin/layanan-surat/permohonan*') ? 'bg-emerald-50 text-emerald-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 transition-transform" :class="bellRinging ? 'bell-ring' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span x-show="pendingPermohonan > 0"
                            x-text="pendingPermohonan > 99 ? '99+' : pendingPermohonan"
                            class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm"
                            style="display:none"></span>
                        @if ($pendingPermohonan > 0)
                            <noscript>
                                <span
                                    class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm">
                                    {{ $pendingPermohonan > 99 ? '99+' : $pendingPermohonan }}
                                </span>
                            </noscript>
                        @endif
                    </a>

                    <div class="h-8 w-px bg-gray-200 mx-1"></div>

                    {{-- ⑤ User / Profile Dropdown --}}
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-2.5 pl-1 pr-3 py-1.5 rounded-xl hover:bg-gray-100 transition-all focus:outline-none"
                            :class="{ 'bg-gray-100': profileOpen }">
                            <div class="relative">
                                @if (Auth::user()->foto ?? false)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                        class="w-9 h-9 rounded-full object-cover ring-2 ring-emerald-500/30"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <div
                                        class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm ring-2 ring-emerald-500/30 shadow-sm">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'Ad', 0, 2)) }}
                                    </div>
                                @endif
                                <span
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 rounded-full ring-2 ring-white"></span>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-gray-800 leading-tight">
                                    {{ Auth::user()->name ?? 'Admin' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            @click.away="profileOpen = false"
                            class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[200]"
                            style="top: calc(100% + 6px); display:none">

                            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-5 py-5 text-center">
                                @if (Auth::user()->foto ?? false)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                                        class="w-16 h-16 rounded-full object-cover mx-auto ring-4 ring-white/30 shadow-lg mb-2"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-xl mx-auto ring-4 ring-white/30 shadow-lg mb-2">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'Ad', 0, 2)) }}
                                    </div>
                                @endif
                                <p class="text-white/70 text-xs mt-0.5">Anda Masuk Sebagai</p>
                                <p class="text-white font-bold text-sm">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('admin.profil') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-emerald-100 group-hover:bg-emerald-200 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Profil Saya</span>
                                </a>
                            </div>

                            <div class="h-px bg-gray-100 mx-3"></div>

                            <div class="py-2 px-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors group font-medium">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-red-100 group-hover:bg-red-200 flex items-center justify-center transition-colors flex-shrink-0">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </div>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ⑥ Ikon Informasi & Bantuan — membuka Panel Info --}}
                    <button @click="$dispatch('toggle-panel-info')" title="Informasi & Bantuan"
                        class="p-2 rounded-lg transition-all"
                        :class="panelInfoOpen ? 'bg-emerald-50 text-emerald-600' :
                            'text-gray-400 hover:text-gray-600 hover:bg-gray-100'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>

                    {{-- ⑦ Ikon Pengaturan Beranda --}}
                    <button @click="pengaturanOpen = true" title="Pengaturan Beranda"
                        class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    {{-- Modal Pengaturan Beranda --}}
                    <template x-teleport="body">
                        <div x-show="pengaturanOpen"
                            class="fixed inset-0 z-[9999] flex items-center justify-center p-4" x-cloak>
                            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                                @click="pengaturanOpen = false"></div>
                            <div x-show="pengaturanOpen" x-transition
                                class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden relative">
                                <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                                    <h3 class="font-bold text-gray-700">Pengaturan Beranda</h3>
                                    <button @click="pengaturanOpen = false"
                                        class="text-gray-400 hover:text-gray-900 text-xl leading-none">&times;</button>
                                </div>
                                <div class="p-6">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Rentang Waktu Notifikasi
                                        Rilis</label>
                                    <input type="number"
                                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none"
                                        value="235">
                                    <p class="text-[10px] text-red-500 mt-2 italic">Pengaturan rentang waktu notifikasi
                                        rilis dalam satuan hari.</p>
                                </div>
                                <div class="px-6 py-3 bg-gray-100 flex justify-between">
                                    <button @click="pengaturanOpen = false"
                                        class="px-4 py-1.5 bg-red-500 text-white rounded text-sm flex items-center gap-2">
                                        <span>✖</span> Batal
                                    </button>
                                    <button @click="pengaturanOpen = false"
                                        class="px-4 py-1.5 bg-cyan-500 text-white rounded text-sm flex items-center gap-2">
                                        <span>✔</span> Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </header>

            <!-- ============================================================ -->
            <!-- CONTENT AREA                                                  -->
            <!-- ============================================================ -->
            <section class="flex-1 overflow-y-auto p-8 bg-gray-50">

                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                        class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                        class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
                        class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-6">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('warning') }}</span>
                    </div>
                @endif

                @yield('content')
            </section>

        </main>
    </div>

    @include('admin.partials.modal-hapus')

    <!-- ================================================================ -->
    <!-- PANEL INFORMASI (klik ikon tanda tanya)                          -->
    <!-- ================================================================ -->
    <div x-data="{ open: false }" @toggle-panel-info.window="open = !open; $dispatch('panel-info-state', { open })"
        @keydown.escape.window="open = false">

        {{-- Overlay --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="open = false"
            class="fixed inset-0 bg-black/30 backdrop-blur-sm z-[900]" style="display:none"></div>

        {{-- Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-[901] flex flex-col overflow-hidden"
            style="display:none">

            {{-- Header Panel --}}
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 px-5 py-5 flex-shrink-0">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-base">Informasi & Bantuan</h3>
                    </div>
                    <button @click="open = false"
                        class="w-7 h-7 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <p class="text-white/70 text-xs leading-relaxed">
                    Lumbung Data adalah sistem informasi desa berbasis web yang dikembangkan menggunakan Laravel.
                </p>
            </div>

            {{-- Versi --}}
            <div class="px-5 py-3 bg-emerald-50 border-b border-emerald-100 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Versi Aplikasi</p>
                        <p class="text-sm font-bold text-emerald-700">Lumbung Data v1.0.0</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Aktif</span>
                </div>
            </div>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto divide-y divide-gray-100">

                {{-- Tentang --}}
                <div x-data="{ open: true }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Tentang Lumbung Data</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Lumbung Data adalah aplikasi Sistem Informasi Desa (SID) yang dikembangkan menggunakan
                            framework Laravel. Dirancang untuk membantu pengelolaan data desa secara digital,
                            transparan, dan efisien.
                        </p>
                        <div class="mt-3 space-y-1.5">
                            @foreach (['Manajemen data kependudukan', 'Layanan surat digital', 'Statistik & laporan otomatis', 'Monitoring kesehatan warga'] as $fitur)
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-emerald-500 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                    </svg>
                                    {{ $fitur }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Catatan Rilis --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Catatan Rilis</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <div class="relative pl-4 border-l-2 border-emerald-300">
                            <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-emerald-500"></div>
                            <p class="text-xs font-bold text-gray-700">v1.0.0 <span
                                    class="font-normal text-gray-400 ml-1">— {{ date('Y') }}</span></p>
                            <ul class="mt-1 space-y-0.5 text-xs text-gray-500">
                                <li>• Rilis perdana Lumbung Data</li>
                                <li>• Modul kependudukan & keluarga</li>
                                <li>• Layanan surat & arsip digital</li>
                                <li>• Dashboard statistik interaktif</li>
                                <li>• Sistem notifikasi real-time</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Panduan Penggunaan --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Panduan Penggunaan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4 space-y-2">
                        <a href="/admin/bantuan"
                            class="flex items-center gap-2 p-2.5 rounded-lg bg-gray-50 hover:bg-emerald-50 hover:text-emerald-700 transition-colors group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-xs font-medium">Dokumentasi Lengkap</span>
                            <svg class="w-3 h-3 ml-auto text-gray-300 group-hover:text-emerald-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Hak Cipta --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Hak Cipta & Ketentuan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Lumbung Data dikembangkan sebagai proyek PKL. Seluruh data yang tersimpan merupakan
                            milik desa yang menggunakan sistem ini. Penggunaan wajib mematuhi peraturan
                            perundang-undangan yang berlaku di Indonesia.
                        </p>
                    </div>
                </div>

                {{-- Kontak --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Kontak & Informasi</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4 space-y-2 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $desa->nama_desa ?? 'Nama Desa' }},
                                {{ $desa->kecamatan ?? 'Kecamatan' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>admin@lumbungdata.desa.id</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Panel --}}
            <div class="flex-shrink-0 px-5 py-3 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-[10px] text-gray-400">
                    © {{ date('Y') }} Lumbung Data · Dikembangkan dengan ❤️ untuk desa
                </p>
            </div>
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')

    <!-- ================================================================ -->
    <!-- TOPBAR ALPINE.JS COMPONENT                                        -->
    <!-- ================================================================ -->
    <script>
        function topbarApp() {
            return {
                // ── State badge ──────────────────────────────────────────────
                pendingKomentar: 0,
                unreadPesan: 0,
                pendingPermohonan: 0,

                // ── State animasi & suara ─────────────────────────────────────
                bellRinging: false,
                soundEnabled: true,
                panelInfoOpen: false,
                pengaturanOpen: false,

                // ── Audio internals ───────────────────────────────────────────
                _audio: null,
                _audioCtx: null,
                _audioReady: false,
                _initialized: false,

                // ── Snapshot untuk deteksi kenaikan ──────────────────────────
                _prevKomentar: 0,
                _prevPesan: 0,
                _prevPermohonan: 0,

                // ═════════════════════════════════════════════════════════════
                init() {
                    const saved = localStorage.getItem('notif_sound');
                    this.soundEnabled = saved === null ? true : saved === 'true';

                    // Unlock audio context saat user pertama kali klik di mana saja
                    const unlockAudio = () => {
                        if (this._audioCtx && this._audioCtx.state === 'suspended') {
                            this._audioCtx.resume();
                        }
                        if (this._audio) {
                            // Putar senyap lalu pause → "warm up" elemen audio
                            this._audio.volume = 0;
                            this._audio.play().then(() => {
                                this._audio.pause();
                                this._audio.currentTime = 0;
                                this._audio.volume = 0.6;
                            }).catch(() => {});
                        }
                        document.removeEventListener('click', unlockAudio);
                    };
                    document.addEventListener('click', unlockAudio);

                    this._initAudio();

                    this._fetchBadges(false).then(() => {
                        this._initialized = true;
                    });

                    setInterval(() => this._fetchBadges(true), 30000);

                    window.addEventListener('panel-info-state', (e) => {
                        this.panelInfoOpen = e.detail.open;
                    });
                },

                // ═════════════════════════════════════════════════════════════
                // Fetch badge counts dari endpoint JSON
                // ═════════════════════════════════════════════════════════════
                async _fetchBadges(playSound = false) {
                    try {
                        const res = await fetch('/admin/notifikasi/badges', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const data = await res.json();

                        const newKomentar = data.pending_komentar ?? 0;
                        const newPesan = data.unread_pesan ?? 0;
                        const newPermohonan = data.pending_permohonan ?? 0;

                        // Deteksi kenaikan
                        const naik = playSound && this._initialized && (
                            newKomentar > this._prevKomentar ||
                            newPesan > this._prevPesan ||
                            newPermohonan > this._prevPermohonan
                        );

                        // Update state
                        this.pendingKomentar = newKomentar;
                        this.unreadPesan = newPesan;
                        this.pendingPermohonan = newPermohonan;

                        // Simpan snapshot
                        this._prevKomentar = newKomentar;
                        this._prevPesan = newPesan;
                        this._prevPermohonan = newPermohonan;

                        if (naik) this._triggerNew();

                    } catch (e) {
                        // Endpoint belum ada → fallback: baca langsung dari DOM badge
                        // (badge sudah di-render server-side oleh Blade, tidak perlu JS)
                    }
                },

                // ═════════════════════════════════════════════════════════════
                // Animasi bell + bunyi saat ada notif baru
                // ═════════════════════════════════════════════════════════════
                _triggerNew() {
                    this.bellRinging = true;
                    setTimeout(() => {
                        this.bellRinging = false;
                    }, 700);
                    this._playSound();
                },

                // ═════════════════════════════════════════════════════════════
                // Audio
                // ═════════════════════════════════════════════════════════════
                _initAudio() {
                    const mp3 = new Audio('/sounds/notif.mp3');
                    mp3.volume = 0.6;
                    mp3.addEventListener('canplaythrough', () => {
                        this._audio = mp3;
                        this._audioReady = true;
                    });
                    mp3.addEventListener('error', () => {
                        // file tidak ada → fallback Web Audio API
                        this._audioReady = true;
                    });
                    mp3.load();
                },

                _playBeep() {
                    try {
                        if (!this._audioCtx) {
                            this._audioCtx = new(window.AudioContext || window.webkitAudioContext)();
                        }
                        const ctx = this._audioCtx;
                        if (ctx.state === 'suspended') ctx.resume();

                        const osc1 = ctx.createOscillator();
                        const osc2 = ctx.createOscillator();
                        const gain = ctx.createGain();

                        osc1.connect(gain);
                        osc2.connect(gain);
                        gain.connect(ctx.destination);

                        osc1.type = 'sine';
                        osc1.frequency.setValueAtTime(880, ctx.currentTime);
                        osc1.frequency.exponentialRampToValueAtTime(660, ctx.currentTime + 0.12);

                        osc2.type = 'sine';
                        osc2.frequency.setValueAtTime(1100, ctx.currentTime + 0.08);
                        osc2.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.22);

                        gain.gain.setValueAtTime(0, ctx.currentTime);
                        gain.gain.linearRampToValueAtTime(0.35, ctx.currentTime + 0.02);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.55);

                        osc1.start(ctx.currentTime);
                        osc1.stop(ctx.currentTime + 0.55);
                        osc2.start(ctx.currentTime + 0.08);
                        osc2.stop(ctx.currentTime + 0.55);
                    } catch (e) {
                        console.warn('Web Audio API error:', e);
                    }
                },

                _playSound() {
                    if (!this.soundEnabled || !this._audioReady) return;
                    if (this._audio) {
                        try {
                            this._audio.currentTime = 0;
                            const p = this._audio.play();
                            if (p !== undefined) p.catch(() => this._playBeep());
                            return;
                        } catch (e) {
                            /* fallthrough */
                        }
                    }
                    this._playBeep();
                },

                saveSoundPref() {
                    localStorage.setItem('notif_sound', this.soundEnabled);
                },
            };
        }
    </script>

</body>

</html>
