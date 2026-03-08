@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb kanan (mirip OpenSID)        --}}
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
{{-- 8 STAT CARDS                                                 --}}
{{-- ============================================================ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    {{-- Card 1: Wilayah Desa --}}
    <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-emerald-50 dark:bg-emerald-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">Wilayah</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $wilayahCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Wilayah Desa</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-emerald-600 dark:text-emerald-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 2: Penduduk --}}
    <a href="/admin/penduduk"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-cyan-400 to-cyan-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-cyan-50 dark:bg-cyan-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-cyan-100 dark:bg-cyan-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-cyan-50 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 border border-cyan-100 dark:border-cyan-800">Jiwa</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $pendudukCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Penduduk</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-cyan-600 dark:text-cyan-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 3: Keluarga --}}
    <a href="/admin/keluarga"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-teal-400 to-teal-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-teal-50 dark:bg-teal-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 border border-teal-100 dark:border-teal-800">KK</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $keluargaCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Keluarga</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-teal-600 dark:text-teal-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 4: Surat Tercetak --}}
    <a href="/admin/layanan-surat/arsip"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-blue-400 to-blue-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-blue-50 dark:bg-blue-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800">Surat</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $suratCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Surat Tercetak</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-blue-600 dark:text-blue-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 5: Kelompok --}}
    <a href="/admin/kelompok"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-indigo-400 to-indigo-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-indigo-50 dark:bg-indigo-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800">Kelompok</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $kelompokCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Kelompok</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-indigo-600 dark:text-indigo-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 6: Rumah Tangga --}}
    <a href="{{ route('admin.rumah-tangga.index') }}"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-slate-400 to-slate-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-700/40 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600">Rumah</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $rumahTanggaCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Rumah Tangga</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-slate-600 dark:text-slate-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 7: Bantuan --}}
    <a href="/admin/bantuan"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-sky-400 to-sky-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-sky-50 dark:bg-sky-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-sky-100 dark:bg-sky-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 border border-sky-100 dark:border-sky-800">Sosial</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100 counter" data-target="{{ $bantuanCount ?? 0 }}">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Bantuan</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-sky-600 dark:text-sky-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Card 8: Verifikasi Layanan Mandiri --}}
    <a href="#"
        class="stat-card group relative bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 overflow-hidden hover:shadow-lg dark:hover:shadow-slate-900/50 transition-all duration-300 hover:-translate-y-1">
        <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-violet-400 to-violet-600 rounded-l-xl"></div>
        <div class="absolute -bottom-6 -right-6 w-24 h-24 rounded-full bg-violet-50 dark:bg-violet-900/20 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex items-start justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-violet-50 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 border border-violet-100 dark:border-violet-800">Mandiri</span>
            </div>
            <p class="text-3xl font-bold text-gray-800 dark:text-slate-100">0</p>
            <p class="text-xs font-medium text-gray-500 dark:text-slate-400 mt-0.5">Verifikasi Layanan Mandiri</p>
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-700 flex items-center gap-1 text-violet-600 dark:text-violet-400 text-sm font-medium">
                <span>Lihat Detail</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
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