@extends('layouts.app')

@section('title', 'Kebijakan Privasi')
@section('description', 'Kebijakan privasi dan perlindungan data pengguna website Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Kebijakan Privasi"
    subtitle="Komitmen kami dalam melindungi data pribadi dan privasi pengguna layanan digital desa secara transparan dan aman."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Kebijakan Privasi', 'url' => '#']
    ]"
/>

<section class="py-12 lg:py-20 bg-gray-50 relative">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <div class="lg:w-1/4">
                <div class="sticky top-24 z-30">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        
                        <div class="p-4 lg:p-6 border-b border-gray-100 flex justify-between items-center cursor-pointer lg:cursor-default" onclick="toggleTocMobile()">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                Daftar Isi
                            </h3>
                            <svg id="toc-arrow" class="w-5 h-5 text-gray-400 lg:hidden transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        <nav id="toc-menu" class="hidden lg:block bg-white max-h-[60vh] overflow-y-auto lg:max-h-none lg:overflow-visible">
                            <div class="p-4 lg:p-6 space-y-1">
                                <a href="#pendahuluan" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="pendahuluan">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Pendahuluan
                                </a>
                                <a href="#informasi-dikumpulkan" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="informasi-dikumpulkan">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Informasi Data
                                </a>
                                <a href="#penggunaan-informasi" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="penggunaan-informasi">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Penggunaan Data
                                </a>
                                <a href="#keamanan" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="keamanan">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Keamanan
                                </a>
                                <a href="#cookies" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="cookies">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Cookies
                                </a>
                                <a href="#kontak" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="kontak">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Hubungi Kami
                                </a>
                            </div>
                            
                            <div class="p-4 lg:p-6 border-t border-gray-100 bg-gray-50">
                                <p class="text-xs text-gray-400 mb-1">Terakhir Diperbarui:</p>
                                <p class="text-sm font-bold text-gray-700 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $lastUpdated ?? date('d M Y') }}
                                </p>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="lg:w-3/4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:p-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-16 -mt-16 pointer-events-none"></div>

                    <section id="pendahuluan" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            Pendahuluan
                        </h2>
                        <div class="prose prose-emerald text-gray-600 leading-relaxed text-justify max-w-none">
                            <p class="mb-4">
                                Selamat datang di Website Resmi Pemerintah Desa <strong>{{ config('app.village_name', 'Serayu Larangan') }}</strong>. Kami sangat menghargai privasi Anda dan berkomitmen penuh untuk melindungi data pribadi serta informasi sensitif yang Anda bagikan saat menggunakan layanan digital kami.
                            </p>
                            <p>
                                Kebijakan Privasi ini dibuat untuk menjelaskan secara transparan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi Anda. Dengan mengakses dan menggunakan website ini, Anda dianggap telah membaca, memahami, dan menyetujui seluruh ketentuan yang tertulis di sini.
                            </p>
                        </div>
                    </section>

                    <section id="informasi-dikumpulkan" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            Informasi yang Kami Kumpulkan
                        </h2>
                        <p class="text-gray-600 mb-6">Untuk memberikan layanan terbaik, kami dapat mengumpulkan beberapa jenis informasi berikut:</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:border-emerald-200 transition duration-300">
                                <div class="flex-shrink-0 mt-1 w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm mb-1">Informasi Pribadi</h4>
                                    <p class="text-sm text-gray-600 leading-snug">Nama lengkap, NIK (untuk layanan surat), alamat email, nomor telepon, dan alamat domisili yang Anda berikan secara sukarela.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:border-emerald-200 transition duration-300">
                                <div class="flex-shrink-0 mt-1 w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm mb-1">Data Teknis</h4>
                                    <p class="text-sm text-gray-600 leading-snug">Alamat IP, jenis browser, perangkat akses, dan data log sistem untuk keperluan keamanan dan analisis statistik.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="penggunaan-informasi" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            Penggunaan Informasi
                        </h2>
                        <div class="bg-amber-50/50 rounded-2xl p-6 border border-amber-100">
                            <p class="text-gray-700 font-medium mb-3">Data Anda digunakan semata-mata untuk:</p>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-sm text-gray-600">Memproses layanan administrasi desa (surat pengantar, surat keterangan, dll).</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-sm text-gray-600">Menindaklanjuti pengaduan atau aspirasi yang Anda sampaikan.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-sm text-gray-600">Penyampaian informasi publik dan pengumuman penting desa.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-sm text-gray-600">Kepatuhan terhadap regulasi dan hukum yang berlaku di Indonesia.</span>
                                </li>
                            </ul>
                        </div>
                    </section>

                    <section id="keamanan" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            Keamanan Data
                        </h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Kami menerapkan protokol keamanan standar industri (SSL/TLS) dan pembatasan akses data secara ketat untuk mencegah akses yang tidak sah, kebocoran, atau penyalahgunaan data Anda.
                        </p>
                        <div class="flex items-start gap-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl">
                            <svg class="w-6 h-6 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="text-sm text-emerald-800">
                                <strong>Komitmen Kami:</strong> Kami tidak akan pernah menjual, menyewakan, atau menyebarkan data pribadi Anda kepada pihak ketiga untuk tujuan komersial tanpa persetujuan Anda.
                            </div>
                        </div>
                    </section>

                    <section id="cookies" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            Kebijakan Cookies
                        </h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Website ini menggunakan teknologi "cookies" (file teks kecil) untuk meningkatkan pengalaman pengguna, mengingat preferensi Anda, dan menganalisis trafik kunjungan.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm">Cookies Esensial</h5>
                                <p class="text-xs text-gray-500">Wajib agar fitur dasar website (seperti formulir) dapat berfungsi.</p>
                            </div>
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm">Cookies Analitik</h5>
                                <p class="text-xs text-gray-500">Membantu kami memahami halaman mana yang paling bermanfaat bagi warga.</p>
                            </div>
                        </div>
                    </section>

                    <section id="kontak" class="scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            Kontak Privasi
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Jika Anda memiliki pertanyaan mengenai kebijakan ini atau ingin mengajukan permohonan penghapusan data, silakan hubungi tim IT desa kami:
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="{{ route('kontak') }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-emerald-500 hover:bg-emerald-50 transition group bg-white">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Email Resmi</p>
                                    <p class="text-gray-900 font-semibold break-all">{{ config('app.email', 'admin@desa.go.id') }}</p>
                                </div>
                            </a>

                            <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 bg-gray-50">
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Kantor Desa</p>
                                    <p class="text-gray-900 font-semibold">Kec. {{ config('app.district', 'Kecamatan') }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    html {
        scroll-behavior: smooth;
    }
    .scroll-mt-32 {
        scroll-margin-top: 8rem; /* Jarak scroll agar tidak tertutup header */
    }
    
    /* Styling state aktif di sidebar */
    .toc-link.active {
        background-color: #ecfdf5; /* bg-emerald-50 */
        color: #047857; /* text-emerald-700 */
        font-weight: 600;
    }
    .toc-link.active .indicator {
        background-color: #10b981; /* bg-emerald-500 */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle Mobile Menu
        window.toggleTocMobile = function() {
            const menu = document.getElementById('toc-menu');
            const arrow = document.getElementById('toc-arrow');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        };

        // Intersection Observer untuk Active State
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -60% 0px', // Aktif saat elemen berada di tengah-tengah layar
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    
                    // Reset semua link
                    document.querySelectorAll('.toc-link').forEach(link => {
                        link.classList.remove('active');
                    });

                    // Set aktif pada link yang sesuai
                    const activeLink = document.querySelector(`.toc-link[data-target="${id}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                }
            });
        }, observerOptions);

        // Mulai observe semua section
        document.querySelectorAll('.observer-section').forEach(section => {
            observer.observe(section);
        });
    });
</script>

@endsection