@extends('layouts.app')

@section('title', $artikel['title'])
@section('description', $artikel['excerpt'])

@section('content')
<!-- Hero Section -->
<x-hero-section 
    title="{{ $artikel['title'] }}"
    subtitle=""
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Berita', 'url' => route('artikel')],
        ['label' => $artikel['title'], 'url' => '#']
    ]"
/>

<!-- Artikel Detail -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Featured Image -->
                <img src="{{ $artikel['image'] }}" alt="{{ $artikel['title'] }}" class="w-full rounded-lg shadow-lg mb-8 h-96 object-cover">

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 107.753-1 4.5 4.5 0 1-3.384 6.98z"/>
                        </svg>
                        <span>{{ $artikel['author'] }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($artikel['date'])->isoFormat('D MMMM YYYY', locale: 'id') }}</span>
                    </div>
                    <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                        {{ $artikel['category'] }}
                    </span>
                    <div class="flex items-center gap-2 text-gray-600 ml-auto">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $artikel['views'] }} views</span>
                    </div>
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $artikel['title'] }}</h1>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">
                        {{ $artikel['content'] }}
                    </div>
                </div>

                <!-- Tags -->
                @if($artikel['tags'])
                    <div class="pt-8 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-900 mb-3">Tag:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($artikel['tags'] as $tag)
                                <a href="#" class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-full hover:bg-emerald-100 hover:text-emerald-700 transition">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-sm font-semibold text-gray-900 mb-4">Bagikan Artikel:</p>
                    <div class="flex gap-3">
                        <a href="#" class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="p-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7z"/>
                            </svg>
                        </a>
                        <a href="#" class="p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.6915026,13.4744748 L17.6915026,20.2599618 L13.5908396,20.2599618 L13.5908396,14.0151496 C13.5908396,12.6562407 13.1347434,11.7181839 11.8932517,11.7181839 C10.9915771,11.7181839 10.3918575,12.3620231 10.1258175,12.9868151 C10.028633,13.2349881 10.0031761,13.5748019 10.0031761,13.9146156 L10.0031761,20.2599618 L5.90157374,20.2599618 C5.90157374,20.2599618 5.95158106,9.13233197 5.90157374,8.10637026 L10.0031761,8.10637026 L10.0031761,9.67178367 C10.0287325,9.63886446 10.0614464,9.60594526 10.0840507,9.57302605 L10.0031761,9.57302605 L10.0031761,9.67178367 C10.3599841,9.07590936 11.1099839,8.20372624 13.1093106,8.20372624 C15.6325167,8.20372624 17.6915026,9.84659979 17.6915026,13.4744748 Z M3.50491503,6.99001513 C2.5853934,6.99001513 1.9357322,6.3398631 1.9357322,5.38348177 C1.9357322,4.42710043 2.5853934,3.77695829 3.50491503,3.77695829 C4.41443667,3.77695829 5.06409535,4.42710043 5.06409535,5.38348177 C5.06409535,6.3398631 4.41443667,6.99001513 3.50491503,6.99001513 Z M4.81328452,20.2599618 L2.20115228,20.2599618 L2.20115228,8.10637026 L4.81328452,8.10637026 L4.81328452,20.2599618 Z M18.8076639,0.556220839 C18.4915502,0.370174908 18.2751365,0.302434034 17.9915026,0.302434034 C16.5228872,0.302434034 15.3409086,1.48041119 15.3409086,2.94903157 C15.3409086,4.41765194 16.5228872,5.59562811 17.9915026,5.59562811 C19.4601179,5.59562811 20.6420965,4.41765194 20.6420965,2.94903157 C20.6420965,1.48041119 19.4601179,0.302434034 17.9915026,0.302434034 Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- About Author -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tentang Penulis</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $artikel['author'] }}</p>
                            <p class="text-sm text-gray-600">Admin Pemerintah Desa</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700">
                        Penulis konten resmi dari Pemerintah Desa Serayu Larangan yang bertugas menyebarluaskan informasi publik.
                    </p>
                </div>

                <!-- Artikel Terkait -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Artikel Terkait</h3>
                    <div class="space-y-4">
                        @foreach($artikelTerkait as $terkait)
                            <a href="{{ route('artikel.show', $terkait['slug']) }}" class="block group">
                                <div class="rounded-lg overflow-hidden mb-2">
                                    <img src="{{ $terkait['image'] }}" alt="" class="w-full h-32 object-cover group-hover:scale-105 transition duration-300">
                                </div>
                                <h4 class="font-semibold text-gray-900 text-sm line-clamp-2 group-hover:text-emerald-600 transition">
                                    {{ $terkait['title'] }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Newsletter CTA -->
                <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 text-white rounded-lg p-6 text-center">
                    <h3 class="text-lg font-bold mb-2">Dapatkan Update Terbaru</h3>
                    <p class="text-sm text-emerald-100 mb-4">
                        Berlangganan newsletter kami untuk mendapat kabar terbaru dari desa.
                    </p>
                    <form class="space-y-3">
                        <input 
                            type="email" 
                            placeholder="Email Anda" 
                            class="w-full px-3 py-2 rounded-lg text-gray-900 placeholder-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400"
                            required
                        >
                        <button 
                            type="submit"
                            class="w-full px-3 py-2 bg-white text-emerald-600 font-bold rounded-lg hover:bg-emerald-50 transition text-sm"
                        >
                            Berlangganan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comments Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Komentar</h2>
            
            <!-- Comment Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Tulis Komentar</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Nama</label>
                        <input type="text" placeholder="Nama Anda" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Email</label>
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-2">Komentar</label>
                        <textarea rows="4" placeholder="Tulis komentar Anda..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" required></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-2 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition">
                        Kirim Komentar
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Budi Santoso</p>
                            <p class="text-sm text-gray-500">5 hari yang lalu</p>
                        </div>
                    </div>
                    <p class="text-gray-700">
                        Berita yang bagus! Semoga pemerintah desa terus melanjutkan program-program yang menguntungkan masyarakat. Sukses untuk Bapak Kepala Desa dan jajarannya.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
