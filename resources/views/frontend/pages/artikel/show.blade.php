@extends('layouts.app')

@section('title', $artikel->title)
@section('description', $artikel->excerpt)

@section('content')
<x-hero-section 
    title="{{ $artikel->title }}"
    subtitle=""
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Berita', 'url' => route('artikel')],
        ['label' => Str::limit($artikel->title, 30), 'url' => '#']
    ]"
/>

<section class="py-16">
    <div class="container mx-auto px-4">
        
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-8 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 flex items-center gap-3">
                <svg class="w-6 h-6 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-7xl mx-auto">
            <div class="lg:col-span-2">
                <img src="{{ $artikel->image }}" alt="{{ $artikel->title }}" class="w-full rounded-2xl shadow-lg mb-8 h-auto max-h-[500px] object-cover">

                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 107.753-1 4.5 4.5 0 1-3.384 6.98z"/>
                        </svg>
                        <span>{{ $artikel->author }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($artikel->date)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                        {{ $artikel->category }}
                    </span>
                    <div class="flex items-center gap-2 text-gray-600 ml-auto">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ count($komentars) }} Komentar</span>
                    </div>
                </div>

                <div class="prose prose-lg max-w-none mb-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">{{ $artikel->title }}</h1>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">{!! $artikel->content !!}</div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-sm font-semibold text-gray-900 mb-4">Bagikan Artikel Ini:</p>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="p-2.5 bg-[#1877F2] text-white rounded-lg hover:opacity-90 transition shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($artikel->title . ' - ' . request()->fullUrl()) }}" target="_blank" class="p-2.5 bg-[#25D366] text-white rounded-lg hover:opacity-90 transition shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="mt-16 pt-12 border-t-8 border-gray-100" id="komentar">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Komentar Pembaca ({{ count($komentars) }})</h2>
                    
                    <div class="space-y-6 mb-12">
                        @forelse($komentars as $komentar)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0">
                                        {{ strtoupper(substr($komentar->nama, 0, 1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $komentar->nama }}</h4>
                                                <p class="text-xs text-gray-500">{{ $komentar->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $komentar->isi_komentar }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Belum ada komentar. Jadilah yang pertama memberikan tanggapan!
                            </div>
                        @endforelse
                    </div>

                    <div class="bg-emerald-50 rounded-3xl p-8 border border-emerald-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tinggalkan Komentar</h3>
                        <p class="text-gray-600 mb-6 text-sm">Komentar Anda akan dimoderasi oleh admin sebelum ditampilkan.</p>
                        
                        <form action="{{ route('artikel.komentar.store', $artikel->id) }}" method="POST" class="space-y-5">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-white" placeholder="Masukkan nama" required>
                                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-white" placeholder="Masukkan email (tidak dipublikasikan)" required>
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan Komentar <span class="text-red-500">*</span></label>
                                <textarea name="isi_komentar" rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition shadow-sm bg-white resize-none" placeholder="Tuliskan tanggapan Anda di sini..." required>{{ old('isi_komentar') }}</textarea>
                                @error('isi_komentar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Komentar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-4 border-b border-gray-200">Ditulis Oleh</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-lg">{{ $artikel->author }}</p>
                            <p class="text-sm text-emerald-600 font-medium">Pemerintah Desa</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Akun resmi media informasi Pemerintah Desa. Bertugas menyampaikan berita, kegiatan, dan transparansi publik kepada masyarakat.
                    </p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Baca Juga
                    </h3>
                    <div class="space-y-5">
                        @foreach($artikelTerkait as $terkait)
                            <a href="{{ route('artikel.show', $terkait['id']) }}" class="flex gap-4 group">
                                <div class="w-24 h-20 rounded-xl overflow-hidden flex-shrink-0 relative">
                                    <img src="{{ $terkait['image'] }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2 group-hover:text-emerald-600 transition mb-1.5">
                                        {{ $terkait['title'] }}
                                    </h4>
                                    <p class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($terkait['date'])->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
