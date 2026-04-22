<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pemerintah Desa') - Desa Resmi</title>
    <meta name="description" content="@yield('description', 'Portal Informasi Desa Resmi')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- TAMBAHKAN INI --}}
    @stack('styles')

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50">

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