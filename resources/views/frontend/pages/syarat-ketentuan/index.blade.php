@extends('layouts.app')

@section('title', 'Syarat & Ketentuan')
@section('description', 'Syarat dan ketentuan penggunaan layanan website Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Syarat & Ketentuan"
    subtitle="Ketentuan penggunaan layanan digital dan akses informasi pada website resmi Pemerintah Desa."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Syarat & Ketentuan', 'url' => '#']
    ]"
/>

<section class="py-12 lg:py-20 bg-gray-50 relative">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <div class="lg:w-1/4">
                <div class="sticky top-28 z-30">
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
                                <a href="#penggunaan" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="penggunaan">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Penggunaan Layanan
                                </a>
                                <a href="#hak-cipta" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="hak-cipta">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Hak Kekayaan Intelektual
                                </a>
                                <a href="#tanggung-jawab" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="tanggung-jawab">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Batasan Tanggung Jawab
                                </a>
                                <a href="#perubahan" class="toc-link flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition group text-gray-600 hover:bg-emerald-50 hover:text-emerald-700" data-target="perubahan">
                                    <span class="indicator w-1.5 h-1.5 rounded-full bg-gray-300 group-hover:bg-emerald-500 transition"></span>
                                    Perubahan Ketentuan
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
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            Pendahuluan
                        </h2>
                        <div class="prose prose-emerald text-gray-600 leading-relaxed text-justify max-w-none">
                            <p class="mb-4">
                                Selamat datang di Website Resmi Pemerintah Desa <strong>{{ config('app.village_name', 'Serayu Larangan') }}</strong>. Halaman ini memuat Syarat dan Ketentuan yang mengatur akses serta penggunaan Anda terhadap seluruh layanan dan konten yang tersedia di website ini.
                            </p>
                            <p>
                                Dengan mengakses atau menggunakan website ini, Anda dianggap telah membaca, memahami, dan menyetujui untuk terikat oleh Syarat dan Ketentuan ini. Jika Anda tidak setuju dengan bagian apapun dari ketentuan ini, mohon untuk tidak melanjutkan penggunaan website.
                            </p>
                        </div>
                    </section>

                    <section id="penggunaan" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            Penggunaan Layanan
                        </h2>
                        
                        <div class="grid gap-4">
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs mt-0.5">1</span>
                                <p class="text-sm text-gray-600 leading-relaxed">Website ini disediakan untuk tujuan informasi publik, pelayanan administrasi desa (surat menyurat online), dan transparansi pemerintahan.</p>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs mt-0.5">2</span>
                                <p class="text-sm text-gray-600 leading-relaxed">Anda setuju untuk menggunakan website ini hanya untuk tujuan yang sah dan tidak melanggar hukum atau peraturan yang berlaku.</p>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs mt-0.5">3</span>
                                <p class="text-sm text-gray-600 leading-relaxed">Dilarang keras melakukan upaya peretasan, penyebaran virus, atau tindakan lain yang dapat mengganggu kinerja atau keamanan sistem website desa.</p>
                            </div>
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs mt-0.5">4</span>
                                <p class="text-sm text-gray-600 leading-relaxed">Untuk layanan yang membutuhkan data pribadi (seperti permohonan surat), Anda wajib memberikan data yang <strong>benar, akurat, dan terbaru</strong>.</p>
                            </div>
                        </div>
                    </section>

                    <section id="hak-cipta" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            Hak Kekayaan Intelektual
                        </h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Seluruh konten yang terdapat dalam website ini, termasuk namun tidak terbatas pada teks, grafik, logo, ikon, gambar, klip audio, unduhan digital, dan kompilasi data, adalah milik <strong>Pemerintah Desa {{ config('app.village_name') }}</strong> atau penyedia kontennya dan dilindungi oleh undang-undang hak cipta Indonesia.
                        </p>
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                            <p class="text-sm text-amber-800 flex gap-2">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Anda diperbolehkan mengunduh atau mencetak materi dari website ini untuk penggunaan pribadi dan non-komersial, dengan syarat tidak mengubah atau menghapus pemberitahuan hak cipta.</span>
                            </p>
                        </div>
                    </section>

                    <section id="tanggung-jawab" class="mb-16 scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            Batasan Tanggung Jawab
                        </h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Meskipun kami berupaya keras untuk memastikan keakuratan informasi di website ini, Pemerintah Desa tidak bertanggung jawab atas:
                        </p>
                        <ul class="space-y-3 pl-2">
                            <li class="flex items-start gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Kesalahan atau ketidakakuratan konten yang tidak disengaja.
                            </li>
                            <li class="flex items-start gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Kerugian langsung maupun tidak langsung yang timbul akibat penggunaan website ini.
                            </li>
                            <li class="flex items-start gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Gangguan teknis sementara yang menyebabkan website tidak dapat diakses.
                            </li>
                            <li class="flex items-start gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-rose-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Isi dari website pihak ketiga yang mungkin tertaut dari website desa ini.
                            </li>
                        </ul>
                    </section>

                    <section id="perubahan" class="scroll-mt-32 relative z-10 observer-section">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3 pb-4 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 shadow-sm shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            </div>
                            Perubahan Ketentuan
                        </h2>
                        <div class="bg-purple-50 rounded-2xl p-6 border border-purple-100 text-sm text-gray-600 leading-relaxed">
                            Pemerintah Desa berhak untuk mengubah, memodifikasi, menambah, atau menghapus bagian dari Syarat dan Ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Perubahan akan berlaku efektif segera setelah diposting di halaman ini. Kami menyarankan Anda untuk memeriksa halaman ini secara berkala.
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