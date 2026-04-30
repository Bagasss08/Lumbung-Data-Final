@extends('layouts.app')

@section('title', 'Dokumen Publik')
@section('description', 'Halaman pusat dokumen publik desa untuk semua warga, memudahkan akses data, laporan, dan aturan yang transparan.')

@push('styles')
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Class utility untuk animasi */
    .scroll-anim {
        opacity: 0;
        transform: translateY(24px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: opacity, transform;
    }
    .scroll-anim.is-visible {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }

    /* Staggered delays */
    .delay-1 { transition-delay: 100ms; }
    .delay-2 { transition-delay: 200ms; }
    .delay-3 { transition-delay: 300ms; }
</style>
@endpush

@section('content')

<x-hero-section
    title="Dokumen Publik"
    subtitle="Akses semua dokumen publik desa dengan mudah: laporan, peraturan, informasi berkala, dan bahan transparansi resmi."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Informasi', 'url' => '#'],
        ['label' => 'Dokumen Publik', 'url' => '#']
    ]"
/>

<section class="py-16 bg-gray-50 relative">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-12">

            {{-- KOLOM UTAMA: LIST DOKUMEN --}}
            <div class="lg:w-2/3">

                {{-- Search & Filter --}}
                <div class="scroll-anim sticky top-20 z-30 bg-gray-50/95 backdrop-blur-md py-4 -mx-4 px-4 mb-8 border-b border-gray-200 transition-all duration-300">
                    <div class="mb-4">
                        <form action="{{ route('dokumen-publik') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari dokumen publik..."
                                   class="w-full pl-12 pr-28 py-3 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition outline-none text-sm shadow-sm bg-white">
                            <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 bg-emerald-600 text-white px-5 rounded-lg font-semibold text-sm hover:bg-emerald-700 transition shadow-sm">
                                Cari
                            </button>
                        </form>
                    </div>

                    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                        <a href="{{ route('dokumen-publik') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap border
                           {{ !request('kategori')
                                ? 'bg-emerald-600 text-white border-emerald-600 shadow-md'
                                : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-300 hover:text-emerald-600' }}">
                            Semua
                        </a>
                        @foreach($availableCategories as $category)
                            <a href="{{ request()->fullUrlWithQuery(['kategori' => $category]) }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 whitespace-nowrap border
                               {{ request('kategori') == $category
                                    ? 'bg-emerald-600 text-white border-emerald-600 shadow-md'
                                    : 'bg-white text-gray-600 border-gray-200 hover:border-emerald-300 hover:text-emerald-600' }}">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($publishedDocs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        @foreach($publishedDocs as $index => $item)
                            <article class="scroll-anim delay-{{ ($index % 3) + 1 }} group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col">
                                <div class="p-6 flex flex-col flex-1">
                                    <div class="flex items-start justify-between gap-3 mb-4">
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">
                                            {{ $item->kategori_info_publik ?: 'Umum' }}
                                        </span>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                            {{ $item->tahun ?: '–' }}
                                        </span>
                                    </div>

                                    <h3 class="text-base font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition line-clamp-2">
                                        {{ $item->judul_dokumen }}
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed mb-4 line-clamp-3 flex-1">
                                        {{ $item->keterangan ?: 'Dokumen resmi desa yang dapat diunduh atau dibuka langsung oleh masyarakat.' }}
                                    </p>

                                    <div class="space-y-2 mb-4 text-sm text-gray-600">
                                        @if($item->tipe_dokumen)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span>{{ ucfirst($item->tipe_dokumen) }}</span>
                                            </div>
                                        @endif
                                        @if($item->tanggal_terbit)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ optional($item->tanggal_terbit)->format('d M Y') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-4 border-t border-gray-100 mt-auto">
                                        @if($item->unggah_dokumen)
                                            <a href="{{ asset('storage/' . $item->unggah_dokumen) }}" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center w-full gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Unduh / Buka
                                            </a>
                                        @else
                                            <span class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-lg bg-gray-100 text-gray-700 text-xs font-semibold">
                                                Dokumen tersedia di server
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="scroll-anim mt-12 flex justify-center pb-8">
                        {{ $publishedDocs->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="scroll-anim text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 mt-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-6 text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ditemukan</h3>
                        <p class="text-gray-500 mb-6">Maaf, dokumen yang Anda cari tidak tersedia saat ini.</p>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('dokumen-publik') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-emerald-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            <div class="lg:w-1/3 space-y-8">

                {{-- Widget: Dokumen Unggulan --}}
                <div class="scroll-anim delay-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Dokumen Terbit</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="text-center pb-4 border-b border-gray-100">
                                <p class="text-4xl font-bold text-emerald-600">{{ number_format($publishedDocs->total(), 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500 mt-2">Total dokumen publik yang dipublikasikan</p>
                            </div>

                            <div class="space-y-2">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori Utama</p>
                                @foreach($availableCategories as $category)
                                    <a href="{{ request()->fullUrlWithQuery(['kategori' => $category]) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-emerald-50 transition group">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-600">{{ $category }}</span>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition">{{ $categoryCounts[$category] ?? 0 }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Widget: Panduan & Tips --}}
                <div class="scroll-anim delay-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Panduan Singkat</h3>
                        </div>

                        <ul class="space-y-4 text-sm text-gray-600">
                            <li class="flex gap-3">
                                <span class="font-bold text-emerald-600 flex-shrink-0 mt-1">1</span>
                                <span>Gunakan kotak pencarian untuk menemukan dokumen berdasarkan judul atau kata kunci.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-emerald-600 flex-shrink-0 mt-1">2</span>
                                <span>Filter dokumen berdasarkan kategori dan tahun penerbitan untuk hasil yang lebih spesifik.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-emerald-600 flex-shrink-0 mt-1">3</span>
                                <span>Klik tombol "Unduh/Buka" untuk mengakses dokumen secara langsung.</span>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-emerald-600 flex-shrink-0 mt-1">4</span>
                                <span>Butuh dokumen khusus? Hubungi perangkat desa melalui halaman kontak.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Widget: CTA Kontak --}}
                <div class="scroll-anim delay-3 bg-gradient-to-br from-emerald-700 to-teal-800 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg group">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-125 transition duration-700"></div>
                    <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-24 h-24 bg-teal-400 opacity-20 rounded-full blur-xl"></div>

                    <div class="relative z-10 text-center">
                        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-5 backdrop-blur-sm border border-white/20 shadow-inner">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Dokumen Tidak Lengkap?</h3>
                        <p class="text-emerald-100 text-sm mb-6 leading-relaxed">
                            Hubungi perangkat desa untuk permintaan dokumen atau informasi tambahan yang Anda butuhkan.
                        </p>

                        <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center w-full px-4 py-3 bg-white text-emerald-800 font-bold rounded-xl text-sm hover:bg-emerald-50 transition shadow-lg transform hover:-translate-y-0.5 gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

            </div>
            {{-- END Sidebar --}}

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-anim').forEach(el => observer.observe(el));
    });
</script>
@endpush
