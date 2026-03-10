<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pemerintah Desa') - Desa Resmi</title>
    <meta name="description" content="@yield('description', 'Portal Informasi Desa Resmi')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Alpine.js — wajib untuk notifikasi bell warga --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- 
        ── Dark Mode Script ──
        Diletakkan di <head> SEBELUM render apapun supaya tidak ada flash putih/gelap.
        Script ini berjalan sinkron (tanpa defer/async).
    --}}
    <script>
        (function () {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // Pakai preferensi user jika ada, kalau tidak ikuti sistem OS
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-slate-900 transition-colors duration-300">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>