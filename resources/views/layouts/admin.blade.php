<!DOCTYPE html>
<html lang="id" x-data x-bind:class="$store.theme.dark ? 'dark' : ''">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lumbung Data Admin</title>

    <script>
        // Cegah flash saat load: baca preferensi sebelum render
        (function() {
            const saved = localStorage.getItem('lumbung_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {}
            }
        }
    </script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Alpine: store theme + anti-FOUC digabung dalam satu listener --}}
    <script>
        document.addEventListener('alpine:init', () => {
            // Store dark mode
            Alpine.store('theme', {
                dark: document.documentElement.classList.contains('dark'),
                toggle() {
                    this.dark = !this.dark;
                    document.documentElement.classList.toggle('dark', this.dark);
                    localStorage.setItem('lumbung_theme', this.dark ? 'dark' : 'light');
                }
            });

            // Hilangkan alpine-loading setelah Alpine siap (anti-FOUC)
            document.body.classList.remove('alpine-loading');
        });
    </script>

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

        /* ── Scrollbar ── */
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

        /* Scrollbar dark mode untuk main content */
        .dark .main-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .dark .main-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
        }

        .main-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .main-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
        }

        /* ── Sidebar ── */
        .sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
            overflow-y: hidden;
        }

        /* Scrollbar khusus untuk sidebar content */
        .sidebar-content-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-content-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .sidebar-content-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* Hide desa name, district, regency text and search box when collapsed, keep logo */
        .sidebar.collapsed .sidebar-identity-text {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-search-box {
            display: none !important;
        }

        /* Remove border-bottom, margin, and padding on identity block when collapsed */
        .sidebar.collapsed .sidebar-identity {
            border-bottom: none !important;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        /* Show LD abbreviation when collapsed */
        .sidebar.collapsed .logo-abbr {
            display: block !important;
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

        /* ── Menu animations ── */
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

        .toggle-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-btn:hover {
            transform: scale(1.05);
        }

        /* ── Gradient text ── */
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Bell ring ── */
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

        /* ── Dark mode toggle animation ── */
        .theme-icon {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s;
        }

        .theme-icon-enter {
            transform: rotate(180deg) scale(0);
            opacity: 0;
        }

        .theme-icon-active {
            transform: rotate(0deg) scale(1);
            opacity: 1;
        }

        /* ── Dark mode: main content area ── */
        .dark body {
            background-color: #0f172a;
        }

        /* bg-gray-200 di light mode → slate-900 di dark */
        .dark .bg-gray-200 {
            background-color: #0f172a !important;
        }

        /* Update scrollbar track agar match bg-gray-200 */
        .main-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.08);
        }

        [x-cloak] {
            display: none !important;
        }

        /* ================================================================ */
        /* GLOBAL DARK MODE — otomatis berlaku di semua child views         */
        /*                                                                  */
        /* ⚠️  CATATAN MIGRASI: Blok ini pakai `!important` sebagai         */
        /*    shortcut agar child views (yang hanya pakai class Tailwind     */
        /*    default seperti `bg-white`) otomatis dapat dark mode.         */
        /*    Saat refactor tiap halaman, tambahkan dark: variant langsung  */
        /*    di komponen tersebut (contoh: `dark:bg-slate-800`), lalu      */
        /*    hapus rule terkait di sini. Jangan tambah rule baru ke sini   */
        /*    untuk halaman yang sudah di-refactor.                         */
        /* ================================================================ */

        /* ── Card / Panel putih ── */
        .dark .bg-white {
            background-color: #1e293b !important;
            /* slate-800 */
        }

        .dark .bg-gray-50 {
            background-color: #0f172a !important;
            /* slate-900 */
        }

        .dark .bg-gray-100 {
            background-color: #1e293b !important;
        }

        /* ── Border ── */
        .dark .border-gray-100,
        .dark .border-gray-200,
        .dark .border-gray-300 {
            border-color: #334155 !important;
            /* slate-700 */
        }

        /* ── Teks utama ── */
        .dark .text-gray-900,
        .dark .text-gray-800 {
            color: #f1f5f9 !important;
            /* slate-100 */
        }

        .dark .text-gray-700 {
            color: #cbd5e1 !important;
            /* slate-300 */
        }

        .dark .text-gray-600 {
            color: #94a3b8 !important;
            /* slate-400 */
        }

        .dark .text-gray-500,
        .dark .text-gray-400 {
            color: #64748b !important;
            /* slate-500 */
        }

        /* ── Tabel ── */
        .dark table thead tr,
        .dark .bg-gray-50 thead tr {
            background-color: #0f172a !important;
        }

        .dark table tbody tr:hover {
            background-color: #334155 !important;
        }

        .dark table tbody {
            background-color: #1e293b;
        }

        .dark .divide-y>* {
            border-color: #334155 !important;
        }

        .dark .divide-gray-100>*,
        .dark .divide-gray-200>* {
            border-color: #334155 !important;
        }

        /* ── Input / Select / Textarea ── */
        .dark input:not([type="checkbox"]):not([type="radio"]):not([type="range"]),
        .dark select,
        .dark textarea {
            background-color: #0f172a !important;
            border-color: #475569 !important;
            color: #f1f5f9 !important;
        }

        .dark input::placeholder,
        .dark textarea::placeholder {
            color: #64748b !important;
        }

        .dark input:focus,
        .dark select:focus,
        .dark textarea:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
        }

        .dark select option {
            background-color: #1e293b;
            color: #f1f5f9;
        }

        /* ── Label form ── */
        .dark label {
            color: #cbd5e1 !important;
        }

        /* ── Badge / Pill warna ── */
        .dark .bg-green-100 {
            background-color: rgba(16, 185, 129, 0.15) !important;
        }

        .dark .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.15) !important;
        }

        .dark .bg-red-100 {
            background-color: rgba(239, 68, 68, 0.15) !important;
        }

        .dark .bg-yellow-100,
        .dark .bg-amber-100 {
            background-color: rgba(245, 158, 11, 0.15) !important;
        }

        .dark .bg-purple-100 {
            background-color: rgba(168, 85, 247, 0.15) !important;
        }

        .dark .bg-cyan-100 {
            background-color: rgba(6, 182, 212, 0.15) !important;
        }

        .dark .bg-orange-100 {
            background-color: rgba(249, 115, 22, 0.15) !important;
        }

        .dark .bg-teal-100 {
            background-color: rgba(20, 184, 166, 0.15) !important;
        }

        .dark .bg-indigo-100 {
            background-color: rgba(99, 102, 241, 0.15) !important;
        }

        .dark .bg-pink-100 {
            background-color: rgba(236, 72, 153, 0.15) !important;
        }

        .dark .bg-slate-100 {
            background-color: rgba(100, 116, 139, 0.15) !important;
        }

        /* ── Alert / Notifikasi ── */
        .dark .bg-green-50 {
            background-color: rgba(16, 185, 129, 0.1) !important;
        }

        .dark .bg-red-50 {
            background-color: rgba(239, 68, 68, 0.1) !important;
        }

        .dark .bg-yellow-50,
        .dark .bg-amber-50 {
            background-color: rgba(245, 158, 11, 0.1) !important;
        }

        .dark .bg-blue-50 {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .dark .bg-emerald-50 {
            background-color: rgba(16, 185, 129, 0.1) !important;
        }

        /* ── Shadow card di dark mode ── */
        .dark .shadow,
        .dark .shadow-sm,
        .dark .shadow-md,
        .dark .shadow-lg {
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4) !important;
        }

        /* ── Hover bg tombol/link ── */
        .dark .hover\:bg-gray-50:hover {
            background-color: #334155 !important;
        }

        .dark .hover\:bg-gray-100:hover {
            background-color: #334155 !important;
        }

        .dark .hover\:bg-gray-200:hover {
            background-color: #475569 !important;
        }

        .dark .hover\:bg-red-50:hover {
            background-color: rgba(239, 68, 68, 0.15) !important;
        }

        .dark .hover\:bg-blue-50:hover {
            background-color: rgba(59, 130, 246, 0.15) !important;
        }

        .dark .hover\:bg-amber-50:hover {
            background-color: rgba(245, 158, 11, 0.15) !important;
        }

        .dark .hover\:bg-emerald-50:hover {
            background-color: rgba(16, 185, 129, 0.15) !important;
        }

        /* ── Modal ── */
        .dark .modal-content,
        .dark [role="dialog"] .bg-white {
            background-color: #1e293b !important;
        }

        /* ── Pagination ── */
        .dark nav[aria-label="Pagination"] span,
        .dark nav[aria-label="Pagination"] a,
        .dark .pagination a,
        .dark .pagination span {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        .dark .pagination .active span,
        .dark nav[aria-label="Pagination"] [aria-current="page"] span {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
            color: white !important;
        }

        /* ── Breadcrumb ── */
        .dark nav .text-gray-500 {
            color: #64748b !important;
        }

        .dark nav .text-gray-700 {
            color: #cbd5e1 !important;
        }

        /* ── Scrollbar di main content ── */
        .dark .main-scroll::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .dark .main-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }

        .dark .main-scroll::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* ── Sidebar search input: override global dark mode ── */
        .sidebar input[type="text"] {
            background-color: transparent !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: none !important;
        }

        .sidebar input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .sidebar input[type="text"]:focus {
            border-color: transparent !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* ── Anti-FOUC ── */
        body.alpine-loading {
            visibility: hidden;
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

<body
    class="alpine-loading bg-gray-200 dark:bg-slate-950 antialiased
             transition-colors duration-300 overflow-hidden"
    x-data="{ sidebarOpen: true, sidebarHovered: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ================================================================ -->
        <!-- SIDEBAR (warna tetap emerald — tampil konsisten di light & dark)  -->
        <!-- ================================================================ -->
        <aside
            class="sidebar bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 text-white flex-shrink-0 shadow-2xl flex flex-col"
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
                hubungWarga: {{ request()->is('admin/hubung-warga*') ? 'true' : 'false' }},
                layananMandiri: {{ request()->is('admin/layanan-mandiri*') ? 'true' : 'false' }},
                ppid: {{ request()->is('admin/ppid*') ? 'true' : 'false' }}
            }">

            <!-- BAGIAN PERTAMA: Header Brand (tidak scroll) -->
            <div class="flex-shrink-0 border-b border-white/10"
                :class="(sidebarOpen || sidebarHovered) ? 'px-6 py-5' : 'px-3 py-5'">
                <div class="logo-wrapper flex items-center justify-center">
                    <!-- Teks penuh (expanded) -->
                    <div class="logo-text text-center">
                        <h1 class="text-xl font-bold whitespace-nowrap leading-tight text-white">Lumbung Data</h1>
                    </div>
                    <!-- Singkatan (collapsed) — hanya muncul saat collapsed -->
                    <span class="logo-abbr text-xl font-bold text-white" style="display:none">LD</span>
                </div>
            </div>

            <!-- BAGIAN KEDUA: Konten (scrollable) -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden sidebar-content-scroll" x-data="sidebarSearch()"
                :class="(sidebarOpen || sidebarHovered) ? 'p-6' : 'py-6 px-3'">

                <!-- Identitas Desa + Pencarian -->
                <div class="sidebar-identity mb-6 pb-4 border-b border-white/10">
                    <!-- Identitas Desa -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 bg-white/10 p-1">
                            @if ($desa && !empty($desa->logo_desa) && file_exists(storage_path('app/public/logo-desa/' . $desa->logo_desa)))
                                <img src="{{ asset('storage/logo-desa/' . $desa->logo_desa) }}"
                                    alt="{{ $desa->nama_desa ?? 'Logo Desa' }}"
                                    class="w-full h-full object-contain mix-blend-screen">
                            @else
                                <img src="{{ asset('images/lumbung-data-logo.png') }}" alt="Lumbung Data"
                                    class="w-full h-full object-contain mix-blend-screen">
                            @endif
                        </div>
                        <div class="logo-text sidebar-identity-text">
                            <p class="text-sm font-bold whitespace-nowrap leading-tight">
                                {{ $desa->nama_desa ?? 'Nama Desa' }}
                            </p>
                            <p class="text-xs text-white/70 whitespace-nowrap">Kec.
                                {{ $desa->kecamatan ?? 'Kecamatan' }}
                            </p>
                            <p class="text-xs text-white/60 whitespace-nowrap">Kab.
                                {{ $desa->kabupaten ?? 'Kabupaten' }}
                            </p>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="logo-text sidebar-search-box">
                        <div class="flex items-center gap-2 bg-white/10 hover:bg-white/20 rounded-lg px-3 py-2 cursor-pointer transition-all"
                            @click="toggleSearch()">
                            <svg class="w-4 h-4 text-white/70 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>

                            <input x-ref="searchInput" x-model="query" @keydown.escape="closeSearch()"
                                @input="doSearch()" @click.stop type="text" placeholder="Cari menu..."
                                class="bg-transparent text-white text-sm outline-none w-full placeholder-white/50"
                                style="background:transparent!important;border:none!important;color:white!important;box-shadow:none!important;">
                        </div>

                        <!-- Hasil pencarian -->
                        <div x-show="searchOpen && results.length > 0"
                            class="absolute top-full left-0 right-0 mt-1 bg-emerald-800 rounded-lg shadow-xl z-50 overflow-hidden max-h-64 overflow-y-auto">
                            <template x-for="item in results" :key="item.url">
                                <a :href="item.url"
                                    class="flex items-center gap-2 px-3 py-2 text-sm text-white/90 hover:bg-white/10 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-white/50 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span x-text="item.label"></span>
                                </a>
                            </template>
                        </div>


                    </div>
                </div>

                <!-- Navigation - show individual items when sidebar is expanded/hovered -->
                <nav class="space-y-1">

                    <!-- Beranda -->
                    <a href="/admin/dashboard" data-tooltip="Beranda"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 shadow-sm' : '' }}"
                        x-show="flatVisible({label: 'Beranda'})">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Beranda</span>
                    </a>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"
                        x-show="(sidebarOpen || sidebarHovered)"></div>

                    <!-- INFO DESA -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='infoDesa'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': infoDesa || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='infoDesa')))
                            }">
                            <a href="/admin/identitas-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/identitas-desa*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Identitas Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Identitas Desa</span>
                            </a>
                            <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.info-desa.wilayah-administratif') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Wilayah Administratif'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Wilayah Administratif</span>
                            </a>
                            <a href="/admin/pemerintah-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pemerintah-desa*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pemerintah Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pemerintah Desa</span>
                            </a>
                            <a href="{{ route('admin.lembaga-desa.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/info-desa/lembaga-desa*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Lembaga Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Lembaga Desa</span>
                            </a>
                            {{-- <a href="/admin/info-desa/status-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/info-desa/status-desa*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Status Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Status Desa</span>
                            </a> --}}
                            {{-- <a href="{{ route('admin.layanan-pelanggan.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-pelanggan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Layanan Pelanggan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Layanan Pelanggan</span>
                            </a> --}}
                            {{-- <a href="{{ route('admin.kerjasama.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kerjasama*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pendaftaran Kerjasama'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendaftaran Kerjasama</span>
                            </a> --}}
                        </div>
                    </div>

                    <!-- KEPENDUDUKAN -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='kependudukan'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': kependudukan || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='kependudukan')))
                            }">
                            <a href="/admin/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/penduduk*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Penduduk'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Penduduk</span>
                            </a>
                            <a href="/admin/keluarga"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keluarga*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Keluarga'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Keluarga</span>
                            </a>
                            <a href="{{ route('admin.rumah-tangga.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/rumah-tangga*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Rumah Tangga'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rumah Tangga</span>
                            </a>
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Kelompok'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Kelompok</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Data Suplemen'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Data Suplemen</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Calon Pemilih'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Calon Pemilih</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>
                        </div>
                    </div>

                    <!-- STATISTIK -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='statistik'))">
                        <button @click="statistik = !statistik"
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': statistik || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='statistik')))
                            }">
                            <a href="/admin/statistik/kependudukan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/kependudukan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Statistik Kependudukan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Statistik Kependudukan</span>
                            </a>
                            <a href="/admin/statistik/laporan-bulanan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/laporan-bulanan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Laporan Bulanan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Bulanan</span>
                            </a>
                            <a href="/admin/statistik/kelompok-rentan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/kelompok-rentan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Laporan Kelompok Rentan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Kelompok Rentan</span>
                            </a>
                            <a href="/admin/statistik/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/statistik/penduduk*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Laporan Penduduk'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan Penduduk</span>
                            </a>
                        </div>
                    </div>

                    {{-- <!-- KESEHATAN -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='kesehatan'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{
                                'open': kesehatan || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='kesehatan')))
                            }">
                            <a href="/admin/kesehatan/pendataan/posyandu"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/pendataan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pendataan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendataan</span>
                            </a>
                            <a href="/admin/kesehatan/pemantauan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/pemantauan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pemantauan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pemantauan</span>
                            </a>
                            <a href="/admin/kesehatan/vaksin"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/vaksin*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Vaksin'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Vaksin</span>
                            </a>
                            <a href="/admin/kesehatan/stunting/posyandu"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kesehatan/stunting*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Stunting'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Stunting</span>
                            </a>
                        </div>
                    </div> --}}

                    {{-- <!-- KEHADIRAN -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='kehadiran'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{
                                'open': kehadiran || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='kehadiran')))
                            }">
                            <a href="{{ route('admin.kehadiran.jam-kerja.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/jam-kerja*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Jam Kerja'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Jam Kerja</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.hari-libur.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/hari-libur*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Hari Libur'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Hari Libur</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.rekapitulasi.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.kehadiran.rekapitulasi.*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Rekapitulasi'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Rekapitulasi</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.pengaduan-kehadiran.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/pengaduan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pengaduan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaduan</span>
                            </a>
                            <a href="{{ route('admin.kehadiran.input.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/kehadiran/input*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Input Kehadiran'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Input Kehadiran</span>
                            </a>
                        </div>
                    </div> --}}

                    <!-- LAYANAN SURAT -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='layananSurat'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': layananSurat || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='layananSurat')))
                            }">
                            <a href="/admin/layanan-surat/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/pengaturan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pengaturan Surat'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/cetak"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/cetak*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Cetak Surat'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Cetak Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/permohonan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/permohonan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Permohonan Surat'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Permohonan Surat</span>
                            </a>
                            <a href="/admin/layanan-surat/arsip"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/arsip*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Arsip Layanan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Arsip Layanan</span>
                            </a>
                            <a href="/admin/layanan-surat/daftar-persyaratan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-surat/daftar-persyaratan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Daftar Persyaratan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Daftar Persyaratan</span>
                            </a>
                        </div>
                    </div>

                    <!-- SEKRETARIAT -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='sekretariat'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': sekretariat || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='sekretariat')))
                            }">
                            <a href="/admin/sekretariat/informasi-publik"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/informasi-publik*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Informasi Publik'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Informasi Publik</span>
                            </a>
                            <a href="/admin/sekretariat/inventaris"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/inventaris*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Inventaris'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Inventaris</span>
                            </a>
                            <a href="/admin/sekretariat/klasifikasi-surat"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/sekretariat/klasifikasi-surat*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Klasifikasi Surat'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Klasifikasi Surat</span>
                            </a>
                        </div>
                    </div>

                    <!-- BUKU ADMINISTRASI -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='bukuAdministrasi'))">
                        <button @click="bukuAdministrasi = !bukuAdministrasi" data-tooltip="Buku Administrasi Desa"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{
                                'open': bukuAdministrasi || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='bukuAdministrasi')))
                            }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Buku Administrasi Desa</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': bukuAdministrasi || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='bukuAdministrasi')))
                            }">
                            <a href="/admin/buku-administrasi/umum"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.umum*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Administrasi Umum'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Administrasi Umum</span>
                            </a>
                            <a href="/admin/buku-administrasi/penduduk"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.penduduk*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Administrasi Penduduk'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Administrasi Penduduk</span>
                            </a>
                            <a href="/admin/buku-administrasi/pembangunan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.pembangunan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Administrasi Pembangunan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Administrasi Pembangunan</span>
                            </a>
                            <a href="/admin/buku-administrasi/arsip"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.buku-administrasi.arsip*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Arsip Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Arsip Desa</span>
                            </a>
                        </div>
                    </div>

                    <!-- KEUANGAN -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='keuangan'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': keuangan || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='keuangan')))
                            }">
                            <a href="{{ route('admin.keuangan.laporan-keuangan') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/laporan-keuangan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Laporan'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan</span>
                            </a>
                            <a href="{{ route('admin.keuangan.input.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/input*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Input Data'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Input Data</span>
                            </a>
                            <a href="{{ route('admin.keuangan.laporan-apbdes') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/keuangan/laporan-apbdes*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Laporan APBDes'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Laporan APBDes</span>
                            </a>
                        </div>
                    </div>

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <!-- Analisis -->
                    <div class="menu-item flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-white/40 cursor-not-allowed"
                        x-show="flatVisible({label: 'Analisis'})" title="Segera hadir">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="menu-text whitespace-nowrap">Analisis</span>
                        </div>
                        <span
                            class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                    </div>

                    <!-- Bantuan -->
                    <a href="/admin/bantuan" data-tooltip="Bantuan" x-show="flatVisible({label: 'Bantuan'})"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/bantuan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Bantuan</span>
                    </a>

                    <!-- MANAJEMEN ARTIKEL -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='artikelMenu'))">
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
                                        class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full sidebar-badge">{{ $pendingComments }}</span>
                                @endif
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': artikelMenu || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='artikelMenu')))
                            }">
                            <a href="{{ route('admin.artikel.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.artikel.*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Daftar Artikel'})">
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
                                        class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full sidebar-badge">{{ $pendingComments }}</span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- PERTANAHAN -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='pertanahan'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': pertanahan || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='pertanahan')))
                            }">
                            <a href="/admin/pertanahan/c-desa"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pertanahan/c-desa*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'C Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">C Desa</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pembangunan -->
                    <a href="/admin/pembangunan" data-tooltip="Pembangunan"
                        x-show="flatVisible({label: 'Pembangunan'})"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/pembangunan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pembangunan</span>
                    </a>

                    <!-- Lapak -->
                    <a href="/admin/lapak" data-tooltip="Lapak" x-show="flatVisible({label: 'Lapak'})"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/lapak*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Lapak</span>
                    </a>

                    <!-- Wisata -->
                    <a href="/admin/wisata" data-tooltip="Wisata" x-show="flatVisible({label: 'Wisata'})"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/wisata*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Wisata</span>
                    </a>

                    {{-- <!-- OPENDK -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='opendk'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1" :class="{
                                'open': opendk || (isSearching && groupVisible(menuGroups.find(gi=>gi.key==='opendk')))
                            }">
                            <a href="/admin/opendk/placeholder"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/opendk/placeholder*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Placeholder'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Placeholder</span>
                            </a>
                        </div>
                    </div> --}}

                    <!-- HUBUNG WARGA -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='hubungWarga'))">
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
                                        class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full sidebar-badge">{{ $unreadPesan }}</span>
                                @endif
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': hubungWarga || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='hubungWarga')))
                            }">
                            <a href="{{ route('admin.hubung-warga.inbox') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.hubung-warga.inbox') || request()->routeIs('admin.hubung-warga.create') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Kotak Masuk'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Kotak Masuk</span>
                            </a>
                            <a href="{{ route('admin.hubung-warga.sent') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.hubung-warga.sent') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pesan Terkirim'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pesan Terkirim</span>
                            </a>
                        </div>
                    </div>

                    <!-- LAYANAN MANDIRI -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='layananMandiri'))">
                        <button @click="layananMandiri = !layananMandiri" data-tooltip="Layanan Mandiri"
                            class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                            :class="{ 'open': layananMandiri, 'bg-white/15': layananMandiri }">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="menu-text whitespace-nowrap">Layanan Mandiri</span>
                            </div>
                            <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': layananMandiri || (isSearching &&
                                    groupVisible(menuGroups.find(gi=>gi.key==='layananMandiri')))
                            }">
                            {{-- Kotak Pesan - soon --}}
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Kotak Pesan'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Kotak Pesan</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>

                            <a href="/admin/layanan-mandiri/pendaftar"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-mandiri/pendaftar*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pendaftar Layanan Mandiri'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pendaftar Layanan Mandiri</span>
                            </a>
                            {{-- Gawai Layanan - soon --}}
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Gawai Layanan'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Gawai Layanan</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>
                            {{-- Pendapat - soon --}}
                            <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                x-show="itemVisible({label: 'Pendapat'})" title="Segera hadir">
                                <div class="flex items-center gap-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Pendapat</span>
                                </div>
                                <span
                                    class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                            </div>
                            <a href="/admin/layanan-mandiri/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/layanan-mandiri/pengaturan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pengaturan Layanan Mandiri'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pengaduan -->
                    <a href="/admin/pengaduan" data-tooltip="Pengaduan" x-show="flatVisible({label: 'Pengaduan'})"
                        class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 {{ request()->is('admin/pengaduan*') ? 'bg-white/15 shadow-sm' : '' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span class="menu-text whitespace-nowrap">Pengaduan</span>
                    </a>

                    @if (false)
                        <!-- PPID -->
                        <div x-show="groupVisible(menuGroups.find(g=>g.key==='ppid'))">
                            <button @click="ppid = !ppid" data-tooltip="PPID"
                                class="menu-header w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/10"
                                :class="{ 'open': ppid, 'bg-white/15': ppid }">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="menu-text whitespace-nowrap">PPID</span>
                                </div>
                                <svg class="w-4 h-4 chevron flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="submenu mt-1 ml-4 space-y-1"
                                :class="{
                                    'open': ppid || (isSearching && groupVisible(menuGroups.find(gi=>gi.key==='ppid')))
                                }">

                                {{-- Daftar Dokumen — sudah ada --}}
                                <a href="{{ route('admin.ppid.index') }}"
                                    class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/ppid') || request()->is('admin/ppid/tambah') || (request()->is('admin/ppid/*') && !request()->is('admin/ppid/jenis*')) ? 'bg-white/15 text-white' : '' }}"
                                    x-show="itemVisible({label: 'Daftar Dokumen'})">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Daftar Dokumen</span>
                                </a>

                                <a href="/admin/ppid/permohonan-informasi"
                                    class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/ppid/permohonan*') || request()->is('admin/ppid/permohonan-informasi*') ? 'bg-white/15 text-white' : '' }}"
                                    x-show="itemVisible({label: 'Permohonan Informasi'})">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Permohonan Informasi</span>
                                </a>

                                <a href="/admin/ppid/keberatan"
                                    class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/ppid/keberatan*') ? 'bg-white/15 text-white' : '' }}"
                                    x-show="itemVisible({label: 'Permohonan Keberatan'})">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Permohonan Keberatan</span>
                                </a>

                                {{-- Jenis Dokumen — sudah ada --}}
                                <a href="{{ route('admin.ppid.jenis.index') }}"
                                    class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/ppid/jenis*') ? 'bg-white/15 text-white' : '' }}"
                                    x-show="itemVisible({label: 'Jenis Dokumen'})">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Jenis Dokumen</span>
                                </a>

                                <a href="/admin/ppid/pengaturan"
                                    class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/ppid/pengaturan*') ? 'bg-white/15 text-white' : '' }}"
                                    x-show="itemVisible({label: 'Pengaturan PPID'})">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                    <span class="menu-text whitespace-nowrap">Pengaturan</span>
                                </a>

                                {{-- Menu — coming soon --}}
                                <div class="menu-item flex items-center justify-between px-3 py-2 rounded-lg text-sm text-white/40 cursor-not-allowed"
                                    x-show="itemVisible({label: 'Menu PPID'})" title="Segera hadir">
                                    <div class="flex items-center gap-3">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white/20 flex-shrink-0"></span>
                                        <span class="menu-text whitespace-nowrap">Menu</span>
                                    </div>
                                    <span
                                        class="menu-text text-xs font-semibold bg-white/10 text-white/50 px-1.5 py-0.5 rounded-full whitespace-nowrap">soon</span>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>

                    <!-- SISTEM -->
                    <div x-show="groupVisible(menuGroups.find(g=>g.key==='sistem'))">
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
                        <div class="submenu mt-1 ml-4 space-y-1"
                            :class="{
                                'open': sistem || (isSearching && groupVisible(menuGroups.find(gi=>gi.key==='sistem')))
                            }">
                            <a href="{{ route('admin.pengguna.index') }}"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pengguna*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pengguna'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengguna</span>
                            </a>
                            <a href="/admin/role"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/role*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Hak Akses'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Hak Akses</span>
                            </a>
                            <a href="/admin/pengaturan"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/pengaturan*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Pengaturan Desa'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Pengaturan Desa</span>
                            </a>
                            <a href="/admin/backup"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/backup*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Backup & Restore'})">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                                <span class="menu-text whitespace-nowrap">Backup & Restore</span>
                            </a>
                            <a href="/admin/log"
                                class="menu-item flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-white/80 hover:bg-white/10 hover:text-white {{ request()->is('admin/log*') ? 'bg-white/15 text-white' : '' }}"
                                x-show="itemVisible({label: 'Log Aktivitas'})">
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
                class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 px-4 py-2 flex items-center justify-between shadow-sm sticky top-0 z-50 transition-colors duration-300"
                x-data="topbarApp()">

                <!-- Kiri: Toggle -->
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="toggle-btn p-2 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Kanan: Action buttons -->
                <div class="flex items-center gap-1" x-data="{ pengaturanOpen: false }">

                    {{-- ★ PENGUMUMAN DARI SUPERADMIN ★ --}}
                    <div class="relative" x-data="pengumumanDropdown()">
                        <button @click="toggleOpen()"
                            class="relative p-2 rounded-lg transition-all text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700"
                            :class="open ? 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300' : ''">

                            <svg class="w-5 h-5" :class="{ 'animate-pulse text-amber-500': hasNew }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>

                            <span x-show="hasNew"
                                class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full shadow-sm border-2 border-white dark:border-slate-800"
                                style="display: none;"></span>
                        </button>

                        {{-- Dropdown Pengumuman --}}
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2" @click.away="open = false"
                            class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden z-[200]"
                            style="top: calc(100% + 6px); display:none" x-cloak>

                            <div class="px-4 py-3 border-b dark:border-slate-700 bg-amber-50 dark:bg-amber-900/20">
                                <h3 class="font-bold text-amber-800 dark:text-amber-500">Pengumuman Sistem</h3>
                            </div>

                            <div class="max-h-80 overflow-y-auto bg-white dark:bg-slate-800 p-2">
                                <template x-if="loading">
                                    <div class="p-4 text-center text-gray-500">Memuat...</div>
                                </template>
                                <template x-if="!loading && items.length === 0">
                                    <div class="p-6 text-center text-sm text-gray-500">Belum ada pengumuman.</div>
                                </template>
                                <template x-for="item in items" :key="item.id">
                                    <div
                                        class="p-3 mb-2 rounded-xl bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-slate-600">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-bold text-[13px] text-gray-800 dark:text-slate-100"
                                                x-text="item.judul"></h4>
                                            <span class="text-xs text-gray-400 whitespace-nowrap ml-2"
                                                x-text="item.waktu"></span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed"
                                            x-text="item.isi"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- ★ NOTIFIKASI BELL (Dropdowns) --}}
                    <div class="relative" x-data="notifDropdown()">
                        <button @click="toggleOpen()"
                            class="relative p-2 rounded-lg transition-all text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700"
                            :class="open ? 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300' : ''">
                            <svg class="w-5 h-5" :class="{ 'bell-ring': bellRinging }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span x-show="totalUnread > 0" x-text="totalUnread > 99 ? '99+' : totalUnread"
                                class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center px-1 shadow-sm"></span>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2" @click.away="open = false"
                            class="absolute right-0 mt-2 w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden z-[200]"
                            style="top: calc(100% + 6px); display:none" x-cloak>

                            {{-- Header --}}
                            <div
                                class="px-4 py-3 border-b dark:border-slate-700 flex items-center justify-between bg-gray-50 dark:bg-slate-900">
                                <h3 class="font-bold text-gray-800 dark:text-slate-100">Notifikasi</h3>
                            </div>

                            {{-- List --}}
                            <div class="max-h-80 overflow-y-auto">

                                {{-- Loading --}}
                                <template x-if="loading">
                                    <div class="p-8 text-center">
                                        <svg class="animate-spin h-8 w-8 text-emerald-500 mx-auto"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-500 mt-2">Memuat...</p>
                                    </div>
                                </template>

                                {{-- Kosong --}}
                                <template x-if="!loading && items.length === 0">
                                    <div class="p-8 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                {{-- ── SECTION "BARU" (unread) ── --}}
                                <template x-if="!loading && unreadItems.length > 0">
                                    <div class="flex items-center gap-2 px-4 pt-3 pb-1">
                                        <span
                                            class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Baru</span>
                                        <div class="flex-1 h-px bg-emerald-100 dark:bg-emerald-900/40"></div>
                                        <span
                                            class="text-[10px] font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 px-1.5 py-0.5 rounded-full"
                                            x-text="unreadItems.length"></span>
                                    </div>
                                </template>

                                <template x-for="item in unreadItems" :key="'u-' + item.id">
                                    <div class="px-4 py-3 border-b dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors cursor-pointer bg-emerald-50/60 dark:bg-emerald-900/10"
                                        @click="navigateToUrl(item.url)">
                                        <div class="flex items-start gap-3">
                                            {{-- Icon --}}
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                                :class="{
                                                    'bg-green-100 dark:bg-green-900/30': item.type === 'pesan',
                                                    'bg-blue-100 dark:bg-blue-900/30': item.type === 'komentar',
                                                    'bg-orange-100 dark:bg-orange-900/30': item.type === 'permohonan'
                                                }">
                                                <svg x-show="item.type === 'pesan'" class="w-5 h-5 text-green-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <svg x-show="item.type === 'komentar'" class="w-5 h-5 text-blue-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                <svg x-show="item.type === 'permohonan'"
                                                    class="w-5 h-5 text-orange-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>

                                            {{-- Konten --}}
                                            <div class="flex-1 min-w-0">
                                                {{-- Baris 1: judul + badge tipe --}}
                                                <div class="flex items-center gap-1.5 flex-wrap mb-0.5">
                                                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-100 leading-tight"
                                                        x-text="item.title"></p>
                                                    <span
                                                        class="text-[10px] font-medium px-1.5 py-0.5 rounded-full whitespace-nowrap"
                                                        :class="{
                                                            'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300': item
                                                                .type === 'permohonan',
                                                            'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300': item
                                                                .type === 'komentar',
                                                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300': item
                                                                .type === 'pesan'
                                                        }"
                                                        x-text="item.type === 'permohonan' ? 'Permohonan' : item.type === 'komentar' ? 'Komentar' : 'Pesan'">
                                                    </span>
                                                </div>
                                                {{-- Baris 2: deskripsi (siapa & apa) --}}
                                                <p class="text-xs text-gray-600 dark:text-slate-400 truncate"
                                                    x-text="item.message"></p>
                                                {{-- Baris 3: waktu --}}
                                                <p class="text-xs text-gray-400 mt-0.5" x-text="item.time"></p>
                                            </div>

                                            {{-- Tombol tandai dibaca + dot hijau --}}
                                            <div class="flex flex-col items-center gap-1.5 flex-shrink-0 pt-0.5">
                                                <button @click.stop="markOneRead(item.id, item.type)"
                                                    class="p-1 rounded-full hover:bg-emerald-100 dark:hover:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 transition-colors"
                                                    title="Tandai dibaca">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                {{-- ── SECTION "SEBELUMNYA" (read) ── --}}
                                <template x-if="!loading && readItems.length > 0">
                                    <div class="flex items-center gap-2 px-4 pt-3 pb-1">
                                        <span
                                            class="text-[10px] font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider">Sebelumnya</span>
                                        <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
                                    </div>
                                </template>

                                <template x-for="item in readItems" :key="'r-' + item.id">
                                    <div class="px-4 py-3 border-b dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors cursor-pointer opacity-70"
                                        @click="navigateToUrl(item.url)">
                                        <div class="flex items-start gap-3">
                                            {{-- Icon (abu-abu karena sudah dibaca) --}}
                                            <div
                                                class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center flex-shrink-0">
                                                <svg x-show="item.type === 'pesan'" class="w-5 h-5 text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <svg x-show="item.type === 'komentar'" class="w-5 h-5 text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                <svg x-show="item.type === 'permohonan'" class="w-5 h-5 text-gray-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>

                                            {{-- Konten --}}
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-1.5 flex-wrap mb-0.5">
                                                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-100 leading-tight"
                                                        x-text="item.title"></p>
                                                    <span
                                                        class="text-[10px] font-medium px-1.5 py-0.5 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 whitespace-nowrap"
                                                        x-text="item.type === 'permohonan' ? 'Permohonan' : item.type === 'komentar' ? 'Komentar' : 'Pesan'">
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 dark:text-slate-500 truncate"
                                                    x-text="item.message"></p>
                                                <p class="text-xs text-gray-400 mt-0.5" x-text="item.time"></p>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                            </div>

                            {{-- Footer --}}
                            <div
                                class="px-4 py-3 border-t dark:border-slate-700 bg-gray-50 dark:bg-slate-900 text-center">
                                <a href="{{ route('admin.notifikasi.index') }}"
                                    class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 font-medium">
                                    Selengkapnya...
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="h-8 w-px bg-gray-200 dark:bg-slate-700 mx-1"></div>

                    {{-- ★ DARK MODE TOGGLE ★ --}}
                    <button @click="$store.theme.toggle()" title="Toggle Dark Mode"
                        class="relative p-2 rounded-lg text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200 overflow-hidden">
                        {{-- Ikon Matahari (light mode) --}}
                        <svg x-show="!$store.theme.dark" x-transition:enter="transition duration-300"
                            x-transition:enter-start="opacity-0 rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            x-transition:leave="transition duration-200"
                            x-transition:leave-start="opacity-100 rotate-0 scale-100"
                            x-transition:leave-end="opacity-0 -rotate-90 scale-50" class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        {{-- Ikon Bulan (dark mode) --}}
                        <svg x-show="$store.theme.dark" x-transition:enter="transition duration-300"
                            x-transition:enter-start="opacity-0 -rotate-90 scale-50"
                            x-transition:enter-end="opacity-100 rotate-0 scale-100"
                            x-transition:leave="transition duration-200"
                            x-transition:leave-start="opacity-100 rotate-0 scale-100"
                            x-transition:leave-end="opacity-0 rotate-90 scale-50" class="w-5 h-5 text-amber-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-gray-200 dark:bg-slate-700 mx-1"></div>

                    {{-- ⑤ User / Profile Dropdown --}}
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen"
                            class="flex items-center gap-2.5 pl-1 pr-3 py-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-all focus:outline-none"
                            :class="{ 'bg-gray-100 dark:bg-slate-700': profileOpen }">
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
                                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 rounded-full ring-2 ring-white dark:ring-slate-800"></span>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-100 leading-tight">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
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
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden z-[200]"
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
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors group">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900 flex items-center justify-center transition-colors">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium">Profil Saya</span>
                                </a>
                            </div>

                            <div class="h-px bg-gray-100 dark:bg-slate-700 mx-3"></div>

                            <div class="py-2 px-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors group font-medium">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 group-hover:bg-red-200 dark:group-hover:bg-red-900/50 flex items-center justify-center transition-colors flex-shrink-0">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </div>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ⑥ Ikon Informasi & Bantuan --}}
                    <button @click="$dispatch('toggle-panel-info')" title="Informasi & Bantuan"
                        class="p-2 rounded-lg transition-all"
                        :class="panelInfoOpen
                            ?
                            'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' :
                            'text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>

                    {{-- ⑦ Ikon Pengaturan Beranda --}}
                    <button @click="pengaturanOpen = true" title="Pengaturan Beranda"
                        class="p-2 rounded-lg text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
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
                                @click="pengaturanOpen = false">
                            </div>
                            <div x-show="pengaturanOpen" x-transition
                                class="bg-white dark:bg-slate-800 rounded-lg shadow-2xl w-full max-w-md overflow-hidden relative">
                                <div
                                    class="px-6 py-4 border-b dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-900">
                                    <h3 class="font-bold text-gray-700 dark:text-slate-200">Pengaturan Beranda</h3>
                                    <button @click="pengaturanOpen = false"
                                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white text-xl leading-none">&times;</button>
                                </div>
                                <div class="p-6">
                                    <label
                                        class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Rentang
                                        Waktu Notifikasi Rilis</label>
                                    <input type="number"
                                        class="w-full border dark:border-slate-600 rounded px-3 py-2 focus:ring-2 focus:ring-emerald-500 outline-none bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100"
                                        value="235">
                                    <p class="text-xs text-red-500 mt-2 italic">Pengaturan rentang waktu
                                        notifikasi
                                        rilis dalam satuan hari.</p>
                                </div>
                                <div class="px-6 py-3 bg-gray-100 dark:bg-slate-900 flex justify-between">
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
            <section
                class="main-scroll flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 bg-gray-200 dark:bg-slate-900 transition-colors duration-300">

                @if (session('success'))
                    <div x-data="{
                        show: true,
                        progress: 100,
                        startTimer() {
                            const step = 100 / 40;
                            const id = setInterval(() => {
                                this.progress -= step;
                                if (this.progress <= 0) {
                                    clearInterval(id);
                                    this.show = false;
                                }
                            }, 100);
                        }
                    }" x-show="show" x-init="startTimer()"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-3 scale-98"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                        class="relative overflow-hidden flex items-start gap-3.5 p-4 mb-5
                       bg-emerald-50 dark:bg-emerald-900/20
                       border border-emerald-200 dark:border-emerald-700/60
                       rounded-xl shadow-sm">

                        {{-- Icon circle --}}
                        <div
                            class="flex-shrink-0 w-9 h-9 rounded-full bg-emerald-500 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="text-sm font-bold text-emerald-800 dark:text-emerald-300 leading-tight">
                                Berhasil!</p>
                            <p class="text-sm text-emerald-700 dark:text-emerald-400 mt-0.5 leading-relaxed">
                                {{ session('success') }}
                            </p>

                            @if (session('import_errors'))
                                <ul class="mt-2 space-y-0.5 border-t border-emerald-200 dark:border-emerald-700 pt-2">
                                    @foreach (session('import_errors') as $err)
                                        <li class="text-xs text-red-600 dark:text-red-400 flex items-start gap-1">
                                            <span class="flex-shrink-0 mt-0.5">•</span>
                                            <span>{{ $err }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- Close button --}}
                        <button @click="show = false"
                            class="flex-shrink-0 p-1.5 rounded-lg text-emerald-500 hover:bg-emerald-100 dark:hover:bg-emerald-800/50
                           transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- Progress bar --}}
                        <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-200 dark:bg-emerald-800">
                            <div class="h-full bg-emerald-500 dark:bg-emerald-400 transition-all duration-100 ease-linear rounded-r"
                                :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{
                        show: true,
                        progress: 100,
                        startTimer() {
                            const step = 100 / 40;
                            const id = setInterval(() => {
                                this.progress -= step;
                                if (this.progress <= 0) {
                                    clearInterval(id);
                                    this.show = false;
                                }
                            }, 100);
                        }
                    }" x-show="show" x-init="startTimer()"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-3 scale-98"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                        class="relative overflow-hidden flex items-start gap-3.5 p-4 mb-5
                       bg-red-50 dark:bg-red-900/20
                       border border-red-200 dark:border-red-700/60
                       rounded-xl shadow-sm">

                        <div
                            class="flex-shrink-0 w-9 h-9 rounded-full bg-red-500 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="text-sm font-bold text-red-800 dark:text-red-300 leading-tight">Gagal!</p>
                            <p class="text-sm text-red-700 dark:text-red-400 mt-0.5 leading-relaxed">
                                {{ session('error') }}
                            </p>
                        </div>

                        <button @click="show = false"
                            class="flex-shrink-0 p-1.5 rounded-lg text-red-500 hover:bg-red-100 dark:hover:bg-red-800/50
                           transition-colors focus:outline-none focus:ring-2 focus:ring-red-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="absolute bottom-0 left-0 w-full h-1 bg-red-200 dark:bg-red-800">
                            <div class="h-full bg-red-500 dark:bg-red-400 transition-all duration-100 ease-linear rounded-r"
                                :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div x-data="{
                        show: true,
                        progress: 100,
                        startTimer() {
                            const step = 100 / 40;
                            const id = setInterval(() => {
                                this.progress -= step;
                                if (this.progress <= 0) {
                                    clearInterval(id);
                                    this.show = false;
                                }
                            }, 100);
                        }
                    }" x-show="show" x-init="startTimer()"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-3 scale-98"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
                        class="relative overflow-hidden flex items-start gap-3.5 p-4 mb-5
                       bg-amber-50 dark:bg-amber-900/20
                       border border-amber-200 dark:border-amber-700/60
                       rounded-xl shadow-sm">

                        <div
                            class="flex-shrink-0 w-9 h-9 rounded-full bg-amber-500 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 min-w-0 pt-0.5">
                            <p class="text-sm font-bold text-amber-800 dark:text-amber-300 leading-tight">Perhatian!
                            </p>
                            <p class="text-sm text-amber-700 dark:text-amber-400 mt-0.5 leading-relaxed">
                                {{ session('warning') }}
                            </p>
                        </div>

                        <button @click="show = false"
                            class="flex-shrink-0 p-1.5 rounded-lg text-amber-500 hover:bg-amber-100 dark:hover:bg-amber-800/50
                           transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-200 dark:bg-amber-800">
                            <div class="h-full bg-amber-500 dark:bg-amber-400 transition-all duration-100 ease-linear rounded-r"
                                :style="`width: ${progress}%`"></div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </section>

        </main>
    </div>

    @include('admin.partials.modal-hapus')

    <!-- ================================================================ -->
    <!-- PANEL INFORMASI                                                   -->
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
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
            class="fixed top-0 right-0 h-full w-80 bg-white dark:bg-slate-800 shadow-2xl z-[901] flex flex-col overflow-hidden"
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
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
            <div
                class="px-5 py-3 bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-900/50 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Versi Aplikasi</p>
                        <p class="text-sm font-bold text-emerald-700 dark:text-emerald-400">Lumbung Data v1.0.0</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 text-xs font-semibold rounded-full">Aktif</span>
                </div>
            </div>

            {{-- Scrollable Content --}}
            <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-slate-700">

                {{-- Tentang --}}
                <div x-data="{ open: true }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">Tentang Lumbung
                                Data</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed">
                            Lumbung Data adalah aplikasi Sistem Informasi Desa (SID) yang dikembangkan menggunakan
                            framework Laravel. Dirancang untuk membantu pengelolaan data desa secara digital,
                            transparan, dan efisien.
                        </p>
                        <div class="mt-3 space-y-1.5">
                            @foreach (['Manajemen data kependudukan', 'Layanan surat digital', 'Statistik & laporan otomatis', 'Monitoring kesehatan warga'] as $fitur)
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-slate-400">
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
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">Catatan Rilis</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <div class="relative pl-4 border-l-2 border-emerald-300 dark:border-emerald-700">
                            <div class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-emerald-500"></div>
                            <p class="text-xs font-bold text-gray-700 dark:text-slate-200">v1.0.0 <span
                                    class="font-normal text-gray-400 dark:text-slate-500 ml-1">—
                                    {{ date('Y') }}</span></p>
                            <ul class="mt-1 space-y-0.5 text-xs text-gray-500 dark:text-slate-400">
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
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">Panduan
                                Penggunaan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4 space-y-2">
                        <a href="/admin/bantuan"
                            class="flex items-center gap-2 p-2.5 rounded-lg bg-gray-50 dark:bg-slate-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span
                                class="text-xs font-medium text-gray-700 dark:text-slate-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-400">Dokumentasi
                                Lengkap</span>
                            <svg class="w-3 h-3 ml-auto text-gray-300 dark:text-slate-600 group-hover:text-emerald-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Hak Cipta --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">Hak Cipta &
                                Ketentuan</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4">
                        <p class="text-xs text-gray-600 dark:text-slate-400 leading-relaxed">
                            Lumbung Data dikembangkan sebagai proyek PKL. Seluruh data yang tersimpan merupakan
                            milik desa yang menggunakan sistem ini. Penggunaan wajib mematuhi peraturan
                            perundang-undangan yang berlaku di Indonesia.
                        </p>
                    </div>
                </div>

                {{-- Kontak --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">Kontak &
                                Informasi</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-5 pb-4 space-y-2 text-xs text-gray-600 dark:text-slate-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400 dark:text-slate-500 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $desa->nama_desa ?? 'Nama Desa' }},
                                Kec. {{ $desa->kecamatan ?? 'Kecamatan' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-gray-400 dark:text-slate-500 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="d1b0b5bcb8bf91bda4bcb3a4bfb6b5b0a5b0ffb5b4a2b0ffb8b5">[email&#160;protected]</a></span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Panel --}}
            <div
                class="flex-shrink-0 px-5 py-3 bg-gray-50 dark:bg-slate-900 border-t border-gray-100 dark:border-slate-700 text-center">
                <p class="text-xs text-gray-400 dark:text-slate-500">
                    © {{ date('Y') }} Lumbung Data · Dikembangkan dengan ❤️ untuk desa
                </p>
            </div>
        </div>

        <!-- Bubble Chat -->
        <div x-data="bubbleChat()" class="fixed bottom-6 right-6 z-[9999] font-sans">

            <button @click="toggleChat()"
                class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white hover:shadow-xl hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 relative">

                <svg x-show="!chatOpen" x-transition.opacity class="w-6 h-6 absolute" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>

                <svg x-show="chatOpen" x-transition.opacity class="w-6 h-6 absolute" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div x-show="chatOpen" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-95" @click.away="chatOpen = false"
                class="absolute bottom-16 right-0 mb-4 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden flex flex-col"
                style="display: none; height: 450px;">

                <div
                    class="bg-gradient-to-r from-emerald-600 to-teal-700 p-4 flex items-center gap-3 flex-shrink-0 shadow-sm z-10">
                    <div
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold border-2 border-emerald-400">
                        SA
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-sm leading-tight">Superadmin</h3>
                        <p class="text-emerald-100 text-xs flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Selalu Siap
                            Membantu
                        </p>
                    </div>
                </div>

                <div id="chat-box"
                    class="flex-1 p-4 overflow-y-auto bg-slate-50 dark:bg-slate-900 space-y-4 main-scroll">

                    <div class="flex flex-col items-start max-w-[85%]">
                        <div
                            class="bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 text-gray-700 dark:text-slate-200 px-4 py-2.5 rounded-2xl rounded-tl-sm text-[13px] shadow-sm">
                            Halo, ada yang bisa dibantu mengenai sistem?
                        </div>
                        <span class="text-xs text-gray-400 mt-1 ml-1">Otomatis</span>
                    </div>

                    <div x-show="loading" class="text-center py-2">
                        <span
                            class="inline-block w-4 h-4 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin"></span>
                    </div>

                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex flex-col"
                            :class="msg.is_sender ? 'items-end pl-10' : 'items-start pr-10 max-w-[85%]'">
                            <div class="px-4 py-2.5 text-[13px] shadow-sm"
                                :class="msg.is_sender ?
                                    'bg-emerald-600 text-white rounded-2xl rounded-tr-sm' :
                                    'bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 text-gray-700 dark:text-slate-200 rounded-2xl rounded-tl-sm'">
                                <span x-text="msg.pesan"></span>
                            </div>
                            <span class="text-xs text-gray-400 mt-1" :class="msg.is_sender ? 'mr-1' : 'ml-1'"
                                x-text="msg.time"></span>
                        </div>
                    </template>
                </div>

                <div
                    class="p-3 bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700 flex-shrink-0">
                    <form @submit.prevent="sendMessage" class="relative flex items-center">
                        <input type="text" x-model="newMessage" placeholder="Ketik pesan..."
                            :disabled="isSending"
                            class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 text-[13px] rounded-full pl-4 pr-12 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors disabled:opacity-50">

                        <button type="submit" :disabled="isSending || newMessage.trim() === ''"
                            class="absolute right-1.5 p-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full transition-colors flex items-center justify-center disabled:bg-gray-400">
                            <svg class="w-4 h-4 translate-x-[1px] translate-y-[-1px]" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @yield('scripts')
        @stack('scripts')
    </div>

    <!-- @yield('scripts')
    @stack('scripts') -->

    <!-- ================================================================ -->
    <!-- TOPBAR ALPINE.JS COMPONENT                                        -->
    <!-- ================================================================ -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script>
        function topbarApp() {
            return {
                panelInfoOpen: false,
                pengaturanOpen: false,
                bellRinging: false, // ← property lokal (bukan $store)
                soundEnabled: true,
                _audio: null,
                _audioReady: false,
                _audioPlaying: false, // ← guard supaya tidak double play
                _initialized: false,
                _prevTotal: 0,

                init() {
                    const saved = localStorage.getItem('notif_sound');
                    this.soundEnabled = saved === null ? true : saved === 'true';

                    this._initAudio();

                    // Unlock audio saat user pertama kali klik apapun
                    const unlockAudio = () => {
                        if (!this._audio) return;
                        const tmp = this._audio.cloneNode();
                        tmp.volume = 0;
                        tmp.play().then(() => tmp.pause()).catch(() => {});
                        document.removeEventListener('click', unlockAudio);
                        document.removeEventListener('keydown', unlockAudio);
                    };
                    document.addEventListener('click', unlockAudio, {
                        once: true
                    });
                    document.addEventListener('keydown', unlockAudio, {
                        once: true
                    });

                    // Dengarkan event dari notifDropdown
                    // BARU — pakai prev dari event, bukan sessionStorage
                    window.addEventListener('notif-count-changed', (e) => {
                        const newTotal = e.detail?.total ?? 0;
                        const lastTotal = e.detail?.prev ?? 0; // ← ambil dari event saja

                        if (this._initialized && newTotal > lastTotal) {
                            this._triggerNew();
                        }
                        this._prevTotal = newTotal;
                        this._initialized = true;
                        // hapus sessionStorage.setItem — notifDropdown sudah urus ini
                    });
                    window.addEventListener('panel-info-state', (e) => {
                        this.panelInfoOpen = e.detail?.open ?? false;
                    });
                },

                _triggerNew() {
                    // Bell animation — pakai property lokal bukan $store
                    this.bellRinging = true;
                    setTimeout(() => {
                        this.bellRinging = false;
                    }, 1000);

                    // Suara — hanya sekali
                    this._playSound();
                },

                _initAudio() {
                    // Preload saja, tidak perlu track ready state
                    try {
                        this._audio = new Audio('/sounds/notif.mp3');
                        this._audio.preload = 'auto';
                        this._audio.volume = 0.6;
                        this._audio.load();
                    } catch (e) {}
                },

                _playSound() {
                    if (!this.soundEnabled) return;
                    if (this._audioPlaying) return;
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

                saveSoundPref() {
                    localStorage.setItem('notif_sound', this.soundEnabled);
                },
            };
        }
    </script>

    <script>
        function sidebarSearch() {
            return {
                searchOpen: false,
                query: '',

                get isSearching() {
                    return this.query.trim().length > 0;
                },

                menuGroups: [{
                        key: 'infoDesa',
                        label: 'Info Desa',
                        items: [{
                                label: 'Identitas Desa',
                                url: '/admin/identitas-desa'
                            },
                            {
                                label: 'Wilayah Administratif',
                                url: '/admin/info-desa/wilayah-administratif'
                            },
                            {
                                label: 'Pemerintah Desa',
                                url: '/admin/pemerintah-desa'
                            },
                            {
                                label: 'Lembaga Desa',
                                url: '/admin/lembaga'
                            },
                            {
                                label: 'Status Desa',
                                url: '/admin/info-desa/status-desa'
                            },
                            {
                                label: 'Layanan Pelanggan',
                                url: '/admin/layanan-pelanggan'
                            },
                            {
                                label: 'Pendaftaran Kerjasama',
                                url: '/admin/kerjasama'
                            },
                        ]
                    },
                    {
                        key: 'kependudukan',
                        label: 'Kependudukan',
                        items: [{
                                label: 'Penduduk',
                                url: '/admin/penduduk'
                            },
                            {
                                label: 'Keluarga',
                                url: '/admin/keluarga'
                            },
                            {
                                label: 'Rumah Tangga',
                                url: '/admin/rumah-tangga'
                            },
                            {
                                label: 'Kelompok',
                                url: '/admin/kelompok'
                            },
                            {
                                label: 'Data Suplemen',
                                url: '/admin/suplemen'
                            },
                            {
                                label: 'Calon Pemilih',
                                url: '/admin/calon-pemilih'
                            },
                        ]
                    },
                    {
                        key: 'statistik',
                        label: 'Statistik',
                        items: [{
                                label: 'Statistik Kependudukan',
                                url: '/admin/statistik/kependudukan'
                            },
                            {
                                label: 'Laporan Bulanan',
                                url: '/admin/statistik/laporan-bulanan'
                            },
                            {
                                label: 'Laporan Kelompok Rentan',
                                url: '/admin/statistik/kelompok-rentan'
                            },
                            {
                                label: 'Laporan Penduduk',
                                url: '/admin/statistik/penduduk'
                            },
                        ]
                    },
                    {
                        key: 'kesehatan',
                        label: 'Kesehatan',
                        items: [{
                                label: 'Pendataan',
                                url: '/admin/kesehatan/pendataan/posyandu'
                            },
                            {
                                label: 'Pemantauan',
                                url: '/admin/kesehatan/pemantauan'
                            },
                            {
                                label: 'Vaksin',
                                url: '/admin/kesehatan/vaksin'
                            },
                            {
                                label: 'Stunting',
                                url: '/admin/kesehatan/stunting/posyandu'
                            },
                        ]
                    },
                    {
                        key: 'kehadiran',
                        label: 'Kehadiran',
                        items: [{
                                label: 'Jam Kerja',
                                url: '/admin/kehadiran/jam-kerja'
                            },
                            {
                                label: 'Hari Libur',
                                url: '/admin/kehadiran/hari-libur'
                            },
                            {
                                label: 'Rekapitulasi',
                                url: '/admin/kehadiran/rekapitulasi'
                            },
                            {
                                label: 'Pengaduan Kehadiran',
                                url: '/admin/kehadiran/pengaduan-kehadiran'
                            },
                            {
                                label: 'Input Kehadiran',
                                url: '/admin/kehadiran/input'
                            },
                        ]
                    },
                    {
                        key: 'layananSurat',
                        label: 'Layanan Surat',
                        items: [{
                                label: 'Pengaturan Surat',
                                url: '/admin/layanan-surat/pengaturan'
                            },
                            {
                                label: 'Cetak Surat',
                                url: '/admin/layanan-surat/cetak'
                            },
                            {
                                label: 'Permohonan Surat',
                                url: '/admin/layanan-surat/permohonan'
                            },
                            {
                                label: 'Arsip Layanan',
                                url: '/admin/layanan-surat/arsip'
                            },
                            {
                                label: 'Daftar Persyaratan',
                                url: '/admin/layanan-surat/daftar-persyaratan'
                            },
                        ]
                    },
                    {
                        key: 'sekretariat',
                        label: 'Sekretariat',
                        items: [{
                                label: 'Informasi Publik',
                                url: '/admin/sekretariat/informasi-publik'
                            },
                            {
                                label: 'Inventaris',
                                url: '/admin/sekretariat/inventaris'
                            },
                            {
                                label: 'Klasifikasi Surat',
                                url: '/admin/sekretariat/klasifikasi-surat'
                            },
                        ]
                    },
                    {
                        key: 'bukuAdministrasi',
                        label: 'Buku Administrasi Desa',
                        items: [{
                                label: 'Administrasi Umum',
                                url: '/admin/buku-administrasi/umum'
                            },
                            {
                                label: 'Administrasi Penduduk',
                                url: '/admin/buku-administrasi/penduduk'
                            },
                            {
                                label: 'Administrasi Pembangunan',
                                url: '/admin/buku-administrasi/pembangunan'
                            },
                            {
                                label: 'Arsip Desa',
                                url: '/admin/buku-administrasi/arsip'
                            },
                        ]
                    },
                    {
                        key: 'keuangan',
                        label: 'Keuangan',
                        items: [{
                                label: 'Laporan',
                                url: '/admin/keuangan/laporan-keuangan'
                            },
                            {
                                label: 'Input Data',
                                url: '/admin/keuangan/input-template'
                            },
                            {
                                label: 'Laporan APBDes',
                                url: '/admin/keuangan/laporan-apbdes'
                            },
                        ]
                    },
                    {
                        key: 'artikelMenu',
                        label: 'Manajemen Artikel',
                        items: [{
                                label: 'Daftar Artikel',
                                url: '/admin/artikel'
                            },
                            {
                                label: 'Komentar Artikel',
                                url: '/admin/komentar'
                            },
                        ]
                    },
                    {
                        key: 'pertanahan',
                        label: 'Pertanahan',
                        items: [{
                            label: 'C Desa',
                            url: '/admin/pertanahan/c-desa'
                        }, ]
                    },
                    {
                        key: 'opendk',
                        label: 'OpenDK',
                        items: [{
                            label: 'Placeholder',
                            url: '/admin/opendk/placeholder'
                        }, ]
                    },
                    {
                        key: 'hubungWarga',
                        label: 'Hubung Warga',
                        items: [{
                                label: 'Kotak Masuk',
                                url: '/admin/hubung-warga/inbox'
                            },
                            {
                                label: 'Pesan Terkirim',
                                url: '/admin/hubung-warga/sent'
                            },
                        ]
                    },
                    {
                        key: 'layananMandiri',
                        label: 'Layanan Mandiri',
                        items: [{
                                label: 'Kotak Pesan',
                                url: '/admin/layanan-mandiri/kotak-pesan'
                            },
                            {
                                label: 'Pendaftar Layanan Mandiri',
                                url: '/admin/layanan-mandiri/pendaftar'
                            },
                            {
                                label: 'Gawai Layanan',
                                url: '/admin/layanan-mandiri/gawai'
                            },
                            {
                                label: 'Pendapat',
                                url: '/admin/layanan-mandiri/pendapat'
                            },
                            {
                                label: 'Pengaturan Layanan Mandiri',
                                url: '/admin/layanan-mandiri/pengaturan'
                            },
                        ]
                    },
                    {
                        key: 'ppid',
                        label: 'PPID',
                        items: [{
                                label: 'Daftar Dokumen',
                                url: '/admin/ppid'
                            },
                            {
                                label: 'Permohonan Informasi',
                                url: '/admin/ppid/permohonan-informasi'
                            },
                            {
                                label: 'Permohonan Keberatan',
                                url: '#'
                            },
                            {
                                label: 'Jenis Dokumen',
                                url: '/admin/ppid/jenis'
                            },
                            {
                                label: 'Pengaturan PPID',
                                url: '#'
                            },
                            {
                                label: 'Menu PPID',
                                url: '#'
                            },
                        ]
                    },
                    {
                        key: 'sistem',
                        label: 'Sistem',
                        items: [{
                                label: 'Pengguna',
                                url: '/admin/pengguna'
                            },
                            {
                                label: 'Hak Akses',
                                url: '/admin/role'
                            },
                            {
                                label: 'Pengaturan Desa',
                                url: '/admin/pengaturan'
                            },
                            {
                                label: 'Backup & Restore',
                                url: '/admin/backup'
                            },
                            {
                                label: 'Log Aktivitas',
                                url: '/admin/log'
                            },
                        ]
                    },
                ],

                flatMatches: [{
                        label: 'Beranda',
                        url: '/admin/dashboard'
                    },
                    {
                        label: 'Analisis',
                        url: '/admin/analisis'
                    },
                    {
                        label: 'Bantuan',
                        url: '/admin/bantuan'
                    },
                    {
                        label: 'Pembangunan',
                        url: '/admin/pembangunan'
                    },
                    {
                        label: 'Lapak',
                        url: '/admin/lapak'
                    },
                    {
                        label: 'Pengaduan',
                        url: '/admin/pengaduan'
                    },
                ],

                // ----------------------------------------------------------
                // Dropdown results: cocokkan label item DAN nama grup
                // Jika nama grup cocok → tampilkan semua item grup tsb
                // ----------------------------------------------------------
                get results() {
                    if (!this.isSearching) return [];
                    const q = this.query.trim().toLowerCase();
                    const res = [];
                    const seen = new Set();

                    const push = (item) => {
                        if (!seen.has(item.url)) {
                            seen.add(item.url);
                            res.push(item);
                        }
                    };

                    // Flat items (Beranda, Analisis, dst)
                    for (const item of this.flatMatches) {
                        if (item.label.toLowerCase().includes(q)) push(item);
                    }

                    // Grup items
                    for (const group of this.menuGroups) {
                        const groupMatches = group.label.toLowerCase().includes(q);
                        for (const item of group.items) {
                            // Tampil jika: nama item cocok, ATAU nama grupnya cocok
                            if (groupMatches || item.label.toLowerCase().includes(q)) {
                                push(item);
                            }
                        }
                    }

                    return res.slice(0, 10);
                },

                // ----------------------------------------------------------
                // Tampilkan grup di sidebar (filter nav in-place)
                // ----------------------------------------------------------
                groupVisible(group) {
                    if (!group) return true;
                    if (!this.isSearching) return true;
                    const q = this.query.trim().toLowerCase();
                    // Tampil jika nama grup cocok
                    if (group.label.toLowerCase().includes(q)) return true;
                    // Tampil jika ada item di dalamnya yang cocok
                    return group.items.some(i => i.label.toLowerCase().includes(q));
                },

                // ----------------------------------------------------------
                // Tampilkan item submenu di sidebar
                // Jika nama GRUP cocok → tampilkan SEMUA item-nya (seperti OpenSID)
                // ----------------------------------------------------------
                itemVisible(item) {
                    if (!this.isSearching) return true;
                    const q = this.query.trim().toLowerCase();
                    // Item langsung cocok
                    if (item.label.toLowerCase().includes(q)) return true;
                    // Cek apakah item ini ada di grup yang namanya cocok
                    for (const group of this.menuGroups) {
                        if (group.label.toLowerCase().includes(q)) {
                            if (group.items.some(i => i.label === item.label)) return true;
                        }
                    }
                    return false;
                },

                // ----------------------------------------------------------
                // Tampilkan flat item (Beranda, Analisis, dll)
                // ----------------------------------------------------------
                flatVisible(item) {
                    if (!this.isSearching) return true;
                    return item.label.toLowerCase().includes(this.query.trim().toLowerCase());
                },

                // ----------------------------------------------------------
                // Toggle search box
                // ----------------------------------------------------------
                toggleSearch() {
                    this.searchOpen = true;
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                },

                closeSearch() {
                    this.query = '';
                },

                doSearch() {
                    // query diupdate otomatis via x-model, getter reactive otomatis
                },
            }
        }

        function notifDropdown() {
            return {
                open: false,
                items: [],
                totalUnread: 0,
                loading: false,
                _pollInterval: null,

                init() {
                    this.fetchBadges();

                    this._pollInterval = setInterval(() => {
                        this.fetchBadges();
                    }, 30000);

                    window.addEventListener('notif-count-changed', (e) => {
                        this.totalUnread = e.detail?.total ?? 0;
                    });

                    document.addEventListener('visibilitychange', () => {
                        if (document.hidden) {
                            if (this._pollInterval) {
                                clearInterval(this._pollInterval);
                                this._pollInterval = null;
                            }
                        } else {
                            if (!this._pollInterval) {
                                this.fetchBadges();
                                this._pollInterval = setInterval(() => {
                                    this.fetchBadges();
                                }, 30000);
                            }
                        }
                    });
                },

                destroy() {
                    if (this._pollInterval) {
                        clearInterval(this._pollInterval);
                        this._pollInterval = null;
                    }
                },

                async fetchBadges() {
                    try {
                        const prev = parseInt(sessionStorage.getItem('_lastNotifTotal') || '0', 10);

                        const res = await fetch('/admin/notifikasi/badges', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            signal: AbortSignal.timeout(5000)
                        });
                        if (!res.ok) return;
                        const data = await res.json();

                        const total = (data.pending_komentar || 0) +
                            (data.unread_pesan || 0) +
                            (data.pending_permohonan || 0);

                        this.totalUnread = total;
                        sessionStorage.setItem('_lastNotifTotal', total.toString());

                        window.dispatchEvent(new CustomEvent('notif-count-changed', {
                            detail: {
                                total,
                                prev
                            }
                        }));
                    } catch (e) {}
                },

                get unreadItems() {
                    return this.items.filter(i => !i.is_read);
                },
                get readItems() {
                    return this.items.filter(i => i.is_read);
                },
                async fetchList() {
                    this.loading = true;
                    try {
                        const res = await fetch('/admin/notifikasi/list', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const data = await res.json();
                        this.items = (data.items || []).sort((a, b) => {
                            const da = a.raw_time ? new Date(a.raw_time) : new Date(0);
                            const db = b.raw_time ? new Date(b.raw_time) : new Date(0);
                            return db - da; // terbaru di atas
                        });
                    } catch (e) {
                        this.items = [];
                    } finally {
                        this.loading = false;
                    }
                },

                toggleOpen() {
                    this.open = !this.open;
                    if (this.open) this.fetchList();
                },

                navigateToUrl(url) {
                    if (url) window.location.href = url;
                },

                async markAllRead() {
                    try {
                        const res = await fetch('{{ route('admin.notifikasi.tandai-semua') }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });
                        if (res.ok) {
                            this.items = this.items.map(item => ({
                                ...item,
                                is_read: true
                            }));
                            this.totalUnread = 0;
                        }
                    } catch (e) {}
                },

                async markOneRead(id, type) {
                    try {
                        const res = await fetch('{{ route('admin.notifikasi.baca-satu') }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                id,
                                type
                            })
                        });
                        if (res.ok) {
                            const item = this.items.find(i => i.id === id);
                            if (item) item.is_read = true;
                            this.totalUnread = Math.max(0, this.totalUnread - 1);
                        }
                    } catch (e) {}
                }
            };
        }
    </script>
    <script>
        function bubbleChat() {
            return {
                chatOpen: false,
                messages: [],
                newMessage: '',
                loading: false,
                isSending: false,
                isFetched: false,

                toggleChat() {
                    this.chatOpen = !this.chatOpen;
                    if (this.chatOpen && !this.isFetched) {
                        this.fetchMessages();
                    } else if (this.chatOpen) {
                        this.scrollToBottom();
                    }
                },

                async fetchMessages() {
                    this.loading = true;
                    try {
                        const res = await fetch('{{ route('admin.chat.fetch') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        this.messages = data.messages || [];
                        this.isFetched = true;
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Gagal mengambil pesan', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    const tempMessage = this.newMessage;
                    this.isSending = true;

                    try {
                        const res = await fetch('{{ route('admin.chat.send') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                pesan: tempMessage
                            })
                        });

                        if (res.ok) {
                            const data = await res.json();
                            this.messages.push(data.message); // Tambah pesan baru ke UI
                            this.newMessage = ''; // Kosongkan input
                            this.scrollToBottom();
                        }
                    } catch (error) {
                        console.error('Gagal mengirim pesan', error);
                    } finally {
                        this.isSending = false;
                    }
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const box = document.getElementById('chat-box');
                        if (box) box.scrollTop = box.scrollHeight;
                    });
                }
            }
        }

        function pengumumanDropdown() {
            return {
                open: false,
                items: [],
                loading: false,
                hasNew: false, // Indikator ada pengumuman baru

                init() {
                    this.fetchPengumuman();
                    // Cek pengumuman baru secara otomatis tiap 1 menit
                    setInterval(() => this.fetchPengumuman(), 60000);
                },

                toggleOpen() {
                    this.open = !this.open;

                    // JIKA DIBUKA: Hilangkan titik merah & simpan ID terakhir yang dilihat
                    if (this.open) {
                        this.hasNew = false;
                        if (this.items.length > 0) {
                            localStorage.setItem('last_read_pengumuman', this.items[0].id);
                        }
                    }
                },

                async fetchPengumuman() {
                    this.loading = true;
                    try {
                        const res = await fetch('/admin/pengumuman/fetch', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (res.ok) {
                            const data = await res.json();
                            this.items = data.items;

                            // LOGIKA TITIK MERAH:
                            // Jika ada pengumuman, cek apakah ID pengumuman paling atas lebih besar
                            // dari ID yang terakhir kali diklik/dibaca oleh Admin
                            if (this.items.length > 0) {
                                const latestId = this.items[0].id;
                                const lastReadId = parseInt(localStorage.getItem('last_read_pengumuman')) || 0;

                                if (latestId > lastReadId) {
                                    this.hasNew = true; // Munculkan titik merah
                                }
                            }
                        }
                    } catch (e) {
                        console.error('Gagal mengambil pengumuman');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>


</body>

</html>
