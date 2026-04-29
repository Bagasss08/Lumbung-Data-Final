@extends('layouts.app')

@section('title', 'Dokumen Publik')
@section('description', 'Halaman pusat dokumen publik desa untuk semua warga, memudahkan akses data, laporan, dan aturan yang transparan.')

@push('styles')
<style>
    .reveal-on-scroll {
        opacity: 0;
        transform: translateY(24px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .reveal-on-scroll.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .document-card:hover {
        transform: translateY(-3px);
    }
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

<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start mb-12">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm reveal-on-scroll">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold uppercase tracking-[0.18em]">Layanan Informasi</span>
                    <h2 class="mt-5 text-3xl md:text-4xl font-bold text-slate-900">Transparansi dokumen untuk semua warga desa.</h2>
                    <p class="mt-4 text-slate-600 leading-relaxed text-base md:text-lg">Halaman ini menampilkan dokumen resmi yang dipublikasikan oleh Pemerintah Desa. Gunakan filter di samping untuk menemukan laporan, pengumuman, atau informasi yang Anda butuhkan.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm reveal-on-scroll">
                        <span class="text-xs uppercase tracking-[0.2em] text-slate-400">Dokumen Terbit</span>
                        <p class="mt-4 text-4xl font-bold text-emerald-600">{{ number_format($publishedDocs->total(), 0, ',', '.') }}</p>
                        <p class="mt-2 text-slate-500">Dokumen publik yang dapat diakses langsung oleh masyarakat.</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm reveal-on-scroll">
                        <span class="text-xs uppercase tracking-[0.2em] text-slate-400">Kategori Utama</span>
                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            @foreach($availableCategories as $category)
                                <div class="flex items-center justify-between gap-3">
                                    <span>{{ $category }}</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">{{ $categoryCounts[$category] ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm reveal-on-scroll">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">Filter Dokumen</h3>
                    <form action="{{ route('dokumen-publik') }}" method="GET" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Cari judul</label>
                            <input type="search" name="search" value="{{ $search ?? '' }}" placeholder="Cari dokumen..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                            <select name="kategori" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition">
                                <option value="">Semua Kategori</option>
                                @foreach($availableCategories as $category)
                                    <option value="{{ $category }}" {{ ($kategoriFilter ?? '') === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                            <select name="tahun" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none transition">
                                <option value="">Semua Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ ($tahunFilter ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="inline-flex items-center justify-center w-full py-3 rounded-2xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">Terapkan Filter</button>
                            <a href="{{ route('dokumen-publik') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-2xl border border-slate-200 text-slate-700 hover:bg-slate-100 transition">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm reveal-on-scroll">
                    <h3 class="text-xl font-semibold text-slate-900 mb-4">Panduan Singkat</h3>
                    <ul class="space-y-3 text-slate-600 text-sm">
                        <li class="flex gap-3"><span class="font-semibold text-emerald-600">1.</span> Pilih kategori untuk mempersempit jenis dokumen publik.</li>
                        <li class="flex gap-3"><span class="font-semibold text-emerald-600">2.</span> Dokumen dengan status terbit dapat diunduh atau dibuka langsung.</li>
                        <li class="flex gap-3"><span class="font-semibold text-emerald-600">3.</span> Jika butuh dokumen tambahan, gunakan halaman Kontak atau layanan desa.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Menampilkan <span class="font-semibold text-slate-900">{{ $publishedDocs->count() }}</span> dari <span class="font-semibold text-slate-900">{{ $publishedDocs->total() }}</span> dokumen terbit.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if($kategoriFilter)
                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-4 py-2 text-xs font-semibold">Kategori: {{ $kategoriFilter }}</span>
                    @endif
                    @if($tahunFilter)
                        <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-700 px-4 py-2 text-xs font-semibold">Tahun: {{ $tahunFilter }}</span>
                    @endif
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($publishedDocs as $item)
                    <article class="document-card group overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:shadow-lg reveal-on-scroll">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em]">{{ $item->kategori_info_publik ?: 'Umum' }}</span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-700 px-3 py-1 text-xs font-semibold">{{ $item->tahun ?: '–' }}</span>
                        </div>

                        <h3 class="text-xl font-semibold text-slate-900 mb-3">{{ $item->judul_dokumen }}</h3>
                        <p class="text-sm leading-6 text-slate-600 mb-5">{{ $item->keterangan ?: 'Dokumen resmi desa yang dapat diunduh atau dibuka langsung oleh masyarakat.' }}</p>

                        <div class="grid gap-3 sm:grid-cols-2 mb-6 text-sm text-slate-600">
                            <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                <span class="font-semibold">Jenis</span>
                                <p class="mt-1">{{ ucfirst($item->tipe_dokumen) }}</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                <span class="font-semibold">Terbit</span>
                                <p class="mt-1">{{ optional($item->tanggal_terbit)->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            @if($item->unggah_dokumen)
                                <a href="{{ asset('storage/' . $item->unggah_dokumen) }}" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700 transition">Buka / Unduh Dokumen</a>
                            @else
                                <span class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700">Dokumen tersedia di server desa</span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-600 shadow-sm">
                        <p class="text-lg font-semibold mb-2">Belum ada dokumen yang cocok.</p>
                        <p class="text-sm">Coba gunakan filter lain atau kembali ke daftar lengkap dokumen publik.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $publishedDocs->links() }}
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal-on-scroll').forEach((el) => observer.observe(el));
    });
</script>
@endpush
