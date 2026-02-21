@extends('layouts.app')

@section('title', 'Berita & Artikel')
@section('description', 'Berita terbaru, pengumuman, dan artikel informatif dari Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Kabar Desa"
    subtitle="Pusat informasi terkini, agenda kegiatan, dan artikel inspiratif dari Desa Serayu Larangan."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Berita', 'url' => '#']
    ]"
/>

<section class="py-16 bg-gray-50 relative">
    <div class="container mx-auto px-4">
        
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-2/3">
                
                <div class="sticky top-20 z-30 bg-gray-50/95 backdrop-blur-md py-4 -mx-4 px-4 mb-8 border-b border-gray-200 transition-all duration-300">
                    
                    <div class="mb-4">
                        <form action="{{ route('berita') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita atau pengumuman..." 
                                   class="w-full pl-12 pr-28 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition outline-none text-sm shadow-sm bg-white">
                            <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 bg-emerald-600 text-white px-5 rounded-lg font-semibold text-sm hover:bg-emerald-700 transition shadow-sm">
                                Cari
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        @foreach($kategoriBlog as $key => $nama)
                            <a href="{{ request()->fullUrlWithQuery(['kategori' => $key]) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap border
                               {{ (request('kategori') == $key || ($key == 'semua' && !request('kategori'))) 
                                    ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' 
                                    : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-300 hover:text-emerald-600' }}">
                                {{ $nama }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($artikelList->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        @foreach($artikelList as $artikel)
                            <div class="h-full">
                                <x-article-card 
                                    :title="$artikel['title']"
                                    :excerpt="$artikel['excerpt']"
                                    :date="$artikel['date']"
                                    :category="$artikel['category']"
                                    :image="$artikel['image']"
                                    :link="route('artikel.show', ['id' => $artikel['id']])"
                                    :author="$artikel['author']"
                                />
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 flex justify-center pb-8">
                        {{-- Menggunakan pagination::tailwind bawaan Laravel --}}
                        {{ $artikels->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 mt-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-6 text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6">Maaf, artikel yang Anda cari tidak tersedia saat ini.</p>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('berita') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-emerald-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            <div class="lg:w-1/3 space-y-8">
                
                <div> <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Sedang Hangat</h3>
                        </div>
                        
                        <div class="space-y-6">
                            @foreach($artikelTerbaru as $artikel)
                                <a href="{{ route('artikel.show', ['id' => $artikel['id']]) }}" class="flex gap-4 group">
                                    <div class="w-20 h-20 flex-shrink-0 rounded-xl overflow-hidden relative shadow-sm border border-gray-100">
                                        <img src="{{ $artikel['image'] }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0 py-1">
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded mb-1.5 inline-block">
                                            {{ $artikel['category'] }}
                                        </span>
                                        <h4 class="text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition line-clamp-2 leading-snug mb-1">
                                            {{ $artikel['title'] }}
                                        </h4>
                                        <p class="text-xs text-gray-400 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($artikel['date'])->locale('id')->diffForHumans() }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 bg-gradient-to-br from-emerald-700 to-teal-800 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg group">
                        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-125 transition duration-700"></div>
                        <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-24 h-24 bg-teal-400 opacity-20 rounded-full blur-xl"></div>
                        
                        <div class="relative z-10 text-center">
                            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-5 backdrop-blur-sm border border-white/20 shadow-inner">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Punya Pertanyaan?</h3>
                            <p class="text-emerald-100 text-sm mb-6 leading-relaxed">
                                Jangan ragu untuk menghubungi perangkat desa jika Anda memiliki pertanyaan, saran, atau butuh bantuan layanan administrasi.
                            </p>
                            
                            <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center w-full px-4 py-3 bg-white text-emerald-800 font-bold rounded-xl text-sm hover:bg-emerald-50 transition shadow-lg transform hover:-translate-y-0.5 gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

@endsection