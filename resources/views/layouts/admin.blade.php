<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumbung Data Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
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

        /* Sidebar collapse styles */
        .sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
            overflow-y: auto; 
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* Hide text when collapsed */
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

        /* Hide submenu in collapsed mode */
        .sidebar.collapsed .submenu {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-badge {
            display: none;
        }

        /* FIX: Center icons when collapsed and remove gap */
        .sidebar.collapsed .menu-item,
        .sidebar.collapsed .menu-header,
        .sidebar.collapsed .logo-wrapper,
        .sidebar.collapsed .menu-item > div,
        .sidebar.collapsed .menu-header > div {
            justify-content: center !important;
            padding-left: 0;
            padding-right: 0;
            gap: 0 !important; 
        }

        .sidebar.collapsed .menu-item:hover {
            transform: scale(1.1);
        }

        /* Toggle button */
        .toggle-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-btn:hover {
            transform: scale(1.05);
        }

        /* Tooltip */
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

        /* Logout button collapsed */
        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar.collapsed .logout-btn {
            padding: 0.75rem;
            justify-content: center;
            gap: 0 !important;
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
    $isDesaFilled = $desa &&
    !empty($desa->nama_desa) && $desa->nama_desa !== 'Desa Belum Diatur' &&
    !empty($desa->kode_desa) && $desa->kode_desa !== '000000';
    @endphp
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 antialiased" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        <aside
            class="sidebar bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 text-white flex-shrink-0 shadow-2xl"
            :class="sidebarOpen ? 'w-72' : 'w-[80px] collapsed'" x-data="{
                infoDesa: {{ request()->is('admin/identitas-desa*') || request()->is('admin/wilayah*') || request()->is('admin/pemerintah-desa*') || request()->is('admin/lembaga*') || request()->is('admin/status-desa*') || request()->is('admin/layanan-pelanggan*') || request()->is('admin/kerjasama*') ? 'true' : 'false' }},
                kependudukan: {{ request()->is('admin/penduduk*') || request()->is('admin/keluarga*') || request()->is('admin/rumah-tangga*') || request()->is('admin/kelompok*') || request()->is('admin/data-suplemen*') || request()->is('admin/calon-pemilih*') ? 'true' : 'false' }},
                statistik: {{ request()->is('admin/statistik*') ? 'true' : 'false' }},
                kesehatan: {{ request()->is('admin/kesehatan*') ? 'true' : 'false' }},
                kehadiran: {{ request()->is('admin/pegawai*') || request()->is('admin/jenis-kehadiran*') || request()->is('admin/kehadiran-harian*') || request()->is('admin/jam-kerja*') || request()->is('admin/keterangan*') || request()->is('admin/dinas-luar*') || request()->is('admin/kehadiran/rekapitulasi*') || request()->routeIs('kehadiran.rekapitulasi.*') || request()->routeIs('kehadiran.rekap') ? 'true' : 'false' }},
                layananSurat: {{ request()->is('admin/layanan-surat*') ? 'true' : 'false' }},
                sekretariat: {{ request()->is('admin/sekretariat*') ? 'true' : 'false' }},
                suratDinas: {{ request()->is('admin/surat-dinas*') ? 'true' : 'false' }},
                bukuAdministrasi: {{ request()->is('admin/buku-administrasi*') ? 'true' : 'false' }},
                keuangan: {{ request()->is('admin/keuangan*') ? 'true' : 'false' }},
                pertanahan: {{ request()->is('admin/pertanahan*') ? 'true' : 'false' }},
                opendk: {{ request()->is('admin/opendk*') ? 'true' : 'false' }},
                sistem: {{ request()->is('admin/pengguna*') || request()->is('admin/role*') || request()->is('admin/pengaturan*') || request()->is('admin/backup*') || request()->is('admin/log*') ? 'true' : 'false' }},
                artikelMenu: {{ request()->is('admin/artikel*') || request()->is('admin/komentar*') ? 'true' : 'false' }}
            }">

            <div :class="sidebarOpen ? 'p-6' : 'py-6 px-3'">
                
                <div class="logo-wrapper flex items-center gap-3 mb-8 pb-6 border-b border-white/10 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center text-xl font-bold shadow-lg flex-shrink-0">
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
                    <a href="/admin/dashboard" data-tooltip="Beranda"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Beranda</span>
                    </a>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <div>
                        <button @click="infoDesa = !infoDesa" data-tooltip="Info Desa"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': infoDesa, 'bg-white/15': infoDesa }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Info Desa</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': infoDesa }">
                            <a href="/admin/identitas-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.identitas-desa') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Identitas Desa</span>
                            </a>
                            <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.info-desa.wilayah-administratif') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Wilayah Administratif</span>
                            </a>
                            <a href="/admin/pemerintah-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.pemerintah-desa') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pemerintah Desa</span>
                            </a>
                            <a href="/admin/lembaga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.lembaga') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Lembaga Desa</span>
                            </a>
                            <a href="/admin/status-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.status-desa') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Status Desa</span>
                            </a>
                            <a href="/admin/layanan-pelanggan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-pelanggan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Layanan Pelanggan</span>
                            </a>
                            <a href="/admin/kerjasama"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kerjasama') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendaftaran Kerjasama</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="kependudukan = !kependudukan" data-tooltip="Kependudukan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kependudukan, 'bg-white/15': kependudukan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kependudukan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kependudukan }">
                            <a href="/admin/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.penduduk') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Penduduk</span>
                            </a>
                            <a href="/admin/keluarga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.keluarga') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Keluarga</span>
                            </a>
                            <a href="{{ route('admin.rumah-tangga.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.rumah-tangga.index') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rumah Tangga</span>
                            </a>
                            <a href="/admin/kelompok"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kelompok') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kelompok</span>
                            </a>
                            <a href="/admin/data-suplemen"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.data-suplemen') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Data Suplemen</span>
                            </a>
                            <a href="/admin/calon-pemilih"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.calon-pemilih') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Calon Pemilih</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="statistik = !statistik" data-tooltip="Statistik"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': statistik }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Statistik</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': statistik }">
                            <a href="/admin/statistik/kependudukan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.statistik.kependudukan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Statistik Kependudukan</span>
                            </a>
                            <a href="/admin/statistik/laporan-bulanan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.statistik.laporan-bulanan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Bulanan</span>
                            </a>
                            <a href="/admin/statistik/kelompok-rentan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.statistik.kelompok-rentan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Kelompok Rentan</span>
                            </a>
                            <a href="/admin/statistik/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.statistik.penduduk') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Penduduk</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="kesehatan = !kesehatan" data-tooltip="Kesehatan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kesehatan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kesehatan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kesehatan }">
                            <a href="/admin/kesehatan/pendataan/posyandu"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/pendataan*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendataan</span>
                            </a>
                            <a href="/admin/kesehatan/pemantauan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kesehatan.pemantauan') ? 'bg-white/15 text-white' : '' }}">
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

                    <div>
                        <button @click="kehadiran = !kehadiran" data-tooltip="Kehadiran"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': kehadiran }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Kehadiran</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': kehadiran }">
                            <a href="{{ route('admin.pegawai.index') }}" @click="kehadiran = false"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.pegawai.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Data Pegawai</span>
                            </a>
                            <a href="{{ route('admin.jenis-kehadiran.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.jenis-kehadiran.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Jenis Kehadiran</span>
                            </a>
                            <a href="{{ route('admin.jam-kerja.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.jam-kerja.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Jam Kerja</span>
                            </a>
                            <a href="{{ route('admin.kehadiran-harian.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kehadiran-harian.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kehadiran Harian</span>
                            </a>
                            <a href="{{ route('admin.keterangan.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.keterangan.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Izin & Cuti</span>
                            </a>
                            <a href="{{ route('admin.dinas-luar.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dinas-luar.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Dinas Luar</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.rekapitulasi.index') }}" class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80        
                                      hover:bg-white/10 hover:text-white 
                                      {{ request()->routeIs('admin.kehadiran.rekapitulasi.*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rekapitulasi Kehadiran</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="layananSurat = !layananSurat" data-tooltip="Layanan Surat"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': layananSurat }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Layanan Surat</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': layananSurat }">
                            <a href="/admin/layanan-surat/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-surat.pengaturan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/cetak"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-surat.cetak') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Cetak Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/permohonan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-surat.permohonan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Permohonan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/arsip"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-surat.arsip') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Arsip Layanan</span>
                            </a>
                            <a href="/admin/layanan-surat/daftar-persyaratan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.layanan-surat.daftar-persyaratan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Daftar Persyaratan</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="sekretariat = !sekretariat" data-tooltip="Sekretariat"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': sekretariat }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Sekretariat</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': sekretariat }">
                            <a href="/admin/sekretariat/informasi-publik"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.sekretariat.informasi-publik.index') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Informasi Publik</span>
                            </a>
                            <a href="/admin/sekretariat/inventaris"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.sekretariat.inventaris') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Inventaris</span>
                            </a>
                            <a href="/admin/sekretariat/klasifikasi-surat"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.sekretariat.klasifikasi-surat') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Klasifikasi Surat</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="suratDinas = !suratDinas" data-tooltip="Surat Dinas"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': suratDinas }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Surat Dinas</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': suratDinas }">
                            <a href="/admin/surat-dinas/keluar"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.surat-dinas.keluar') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Surat Keluar</span>
                            </a>
                            <a href="/admin/surat-dinas/masuk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.surat-dinas.masuk') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Surat Masuk</span>
                            </a>
                            <a href="/admin/surat-dinas/arsip"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.surat-dinas.arsip') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Arsip Surat</span>
                            </a>
                            <a href="/admin/surat-dinas/klasifikasi"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.surat-dinas.klasifikasi') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Klasifikasi</span>
                            </a>
                        </div>
                    </div>

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
                            <a href="/admin/buku-administrasi/kependudukan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.kependudukan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Kependudukan</span>
                            </a>
                            <a href="/admin/buku-administrasi/keluarga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.keluarga') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Keluarga</span>
                            </a>
                            <a href="/admin/buku-administrasi/tanah"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.tanah') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Tanah</span>
                            </a>
                            <a href="/admin/buku-administrasi/inventaris"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.inventaris') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Inventaris</span>
                            </a>
                            <a href="/admin/buku-administrasi/keuangan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.keuangan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Keuangan</span>
                            </a>
                            <a href="/admin/buku-administrasi/pembangunan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.pembangunan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Buku Pembangunan</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="keuangan = !keuangan" data-tooltip="Keuangan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': keuangan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Keuangan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': keuangan }">
                            <a href="/admin/keuangan/kas-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/kas-desa*') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kas Desa</span>
                            </a>
                            <a href="/admin/keuangan/laporan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan</span>
                            </a>
                            <a href="/admin/keuangan/input-data"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Input Data</span>
                            </a>
                            <a href="/admin/keuangan/laporan-apbdes"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan APBDes</span>
                            </a>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <a href="/admin/analisis" data-tooltip="Analisis"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.analisis') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Analisis</span>
                    </a>

                    <a href="/admin/bantuan" data-tooltip="Bantuan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.bantuan') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Bantuan</span>
                    </a>

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
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Manajemen Artikel</span>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                @if($pendingComments > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full sidebar-badge">
                                        {{ $pendingComments }}
                                    </span>
                                @endif
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                @if($pendingComments > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full sidebar-badge">
                                        {{ $pendingComments }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <div>
                        <button @click="pertanahan = !pertanahan" data-tooltip="Pertanahan"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': pertanahan }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Pertanahan</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': pertanahan }">
                            <a href="/admin/pertanahan/c-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.pertanahan.c-desa') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">C Desa</span>
                            </a>
                        </div>
                    </div>

                    <a href="/admin/pembangunan" data-tooltip="Pembangunan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.pembangunan') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pembangunan</span>
                    </a>

                    <a href="/admin/lapak" data-tooltip="Lapak"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.lapak') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Lapak</span>
                    </a>

                    <div>
                        <button @click="opendk = !opendk" data-tooltip="OpenDK"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': opendk }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">OpenDK</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': opendk }">
                            <a href="/admin/opendk/placeholder"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.opendk.placeholder') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Placeholder</span>
                            </a>
                        </div>
                    </div>

                    <a href="/admin/pengaduan" data-tooltip="Pengaduan"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.pengaduan.index') || request()->routeIs('admin.pengaduan.show') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pengaduan</span>
                    </a>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <div>
                        <button @click="sistem = !sistem" data-tooltip="Sistem"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': sistem }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Sistem</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{ 'open': sistem }">
                            <a href="{{ route('admin.pengguna.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.pengguna.index') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengguna</span>
                            </a>
                            <a href="/admin/role"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.role') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Hak Akses</span>
                            </a>
                            <a href="/admin/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.pengaturan') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Desa</span>
                            </a>
                            <a href="/admin/backup"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.backup') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Backup & Restore</span>
                            </a>
                            <a href="/admin/log"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.log') ? 'bg-white/15 text-white' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Log Aktivitas</span>
                            </a>
                        </div>
                    </div>

                </nav>

                <div class="mt-8 pt-6 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" data-tooltip="Logout"
                            class="logout-btn w-full flex items-center justify-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm border border-white/20">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="menu-text whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-white border-b border-gray-200 px-8 py-5 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="toggle-btn p-2 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h2 class="text-2xl font-bold gradient-text">
                            @yield('title', 'Dashboard')
                        </h2>
                        <p class="text-sm text-gray-500 mt-0.5">Sistem Lumbung Data Desa</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                        {{ strtoupper(substr(Auth::user()->name ?? 'Ad', 0, 2)) }}
                    </div>
                </div>
            </header>

            <section class="flex-1 overflow-y-auto p-8 bg-gray-50">
                @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif
                @if(session('warning'))
                <div class="bg-yellow-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
                @endif
                @yield('content')
            </section>

        </main>

    </div>

    @yield('scripts')

</body>

</html>