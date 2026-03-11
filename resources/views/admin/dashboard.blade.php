@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER                                                       --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tentang Lumbung Data</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Ringkasan data kependudukan dan layanan desa</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tentang Lumbung Data</span>
    </nav>
</div>

{{-- ============================================================ --}}
{{-- 8 STAT CARDS - OpenSID Style                                 --}}
{{-- ============================================================ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    {{-- Card 1: Wilayah Desa --}}
    <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-purple-500 hover:bg-purple-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $wilayahCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Wilayah Desa</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 2: Penduduk --}}
    <a href="/admin/penduduk"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-cyan-500 hover:bg-cyan-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $pendudukCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Penduduk</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 3: Keluarga --}}
    <a href="/admin/keluarga"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-emerald-500 hover:bg-emerald-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $keluargaCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Keluarga</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 4: Surat Tercetak --}}
    <a href="/admin/layanan-surat/arsip"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-blue-500 hover:bg-blue-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $suratCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Surat Tercetak</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM9 13h6v1.5H9V13zm0 3h6v1.5H9V16zm1-6h1.5v1.5H10V10z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 5: Kelompok --}}
    <a href="/admin/kelompok"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-red-500 hover:bg-red-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $kelompokCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Kelompok</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 6: Rumah Tangga --}}
    <a href="{{ route('admin.rumah-tangga.index') }}"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-gray-400 hover:bg-gray-500">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $rumahTanggaCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Rumah Tangga</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 7: Bantuan --}}
    <a href="/admin/bantuan"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-amber-500 hover:bg-amber-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none counter" data-target="{{ $bantuanCount ?? 0 }}">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Bantuan</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

    {{-- Card 8: Verifikasi Layanan Mandiri --}}
    <a href="#"
        class="stat-card group rounded-xl overflow-hidden flex flex-col transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 bg-teal-500 hover:bg-teal-600">
        <div class="flex items-center justify-between px-5 py-5 flex-1">
            <div class="relative z-10">
                <p class="text-4xl font-bold text-white leading-none">0</p>
                <p class="text-sm font-semibold text-white/90 mt-2">Verifikasi Layanan Mandiri</p>
            </div>
            <div class="relative z-10 opacity-25 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                </svg>
            </div>
        </div>
        <div class="bg-black/20 px-5 py-2.5 flex items-center justify-center gap-2 text-white/90 text-sm font-medium">
            <span>Lihat Detail</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </a>

</div>

@push('scripts')
<script>
    // Animated counters
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                entry.target.dataset.animated = true;
                const target = parseInt(entry.target.dataset.target) || 0;
                if (target === 0) return;
                const steps = Math.floor(1200 / 16);
                let current = 0;
                const increment = target / steps;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        entry.target.textContent = target.toLocaleString('id-ID');
                        clearInterval(timer);
                    } else {
                        entry.target.textContent = Math.floor(current).toLocaleString('id-ID');
                    }
                }, 16);
            }
        });
    }, { threshold: 0.5 });
    document.querySelectorAll('.counter').forEach(el => observer.observe(el));

    // Staggered entrance animation
    document.querySelectorAll('.stat-card').forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(16px)';
        card.style.transition = `opacity 0.35s ease ${i * 55}ms, transform 0.35s ease ${i * 55}ms`;
        requestAnimationFrame(() => setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 80 + i * 55));
    });
</script>
@endpush

@endsection