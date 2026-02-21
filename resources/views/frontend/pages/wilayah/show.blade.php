@extends('layouts.app')

@section('title', $wilayah['nama'])
@section('description', 'Detail wilayah desa')

@section('content')
<!-- Hero Section -->
<x-hero-section 
    title="{{ $wilayah['nama'] }}"
    subtitle="Pembagian wilayah administrasi desa"
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Wilayah', 'url' => route('wilayah')],
        ['label' => $wilayah['nama'], 'url' => '#']
    ]"
/>

<!-- Detail Wilayah -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-16">
            <!-- Informasi Utama -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi Umum</h2>
                    
                    <p class="text-gray-700 leading-relaxed mb-8">
                        {{ $wilayah['deskripsi'] }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="border-l-4 border-emerald-600 pl-6">
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-2">Kepala Dusun</p>
                            <p class="text-lg font-bold text-gray-900">{{ $wilayah['kepala_dusun'] }}</p>
                            <p class="text-sm text-gray-600 mt-1">Periode: 2019 - Sekarang</p>
                        </div>

                        <div class="border-l-4 border-blue-600 pl-6">
                            <p class="text-sm font-semibold text-gray-500 uppercase mb-2">Luas Wilayah</p>
                            <p class="text-lg font-bold text-gray-900">{{ $wilayah['luas_wilayah'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik Wilayah -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-6 border border-emerald-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-emerald-700 uppercase mb-2">Jumlah Penduduk</p>
                                <p class="text-3xl font-bold text-emerald-900">{{ $wilayah['jumlah_penduduk'] }}</p>
                                <p class="text-xs text-emerald-600 mt-1">jiwa</p>
                            </div>
                            <span class="text-5xl">👥</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg p-6 border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-blue-700 uppercase mb-2">Kepala Keluarga</p>
                                <p class="text-3xl font-bold text-blue-900">{{ $wilayah['jumlah_kk'] }}</p>
                                <p class="text-xs text-blue-600 mt-1">KK</p>
                            </div>
                            <span class="text-5xl">🏠</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg p-6 border border-amber-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-amber-700 uppercase mb-2">RT / RW</p>
                                <p class="text-3xl font-bold text-amber-900">6 / 1</p>
                                <p class="text-xs text-amber-600 mt-1">unit</p>
                            </div>
                            <span class="text-5xl">📍</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20 space-y-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Wilayah</p>
                        <p class="text-lg font-bold text-gray-900">{{ $wilayah['nama'] }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Kepala Dusun</p>
                        <p class="text-lg font-bold text-gray-900 mb-2">{{ $wilayah['kepala_dusun'] }}</p>
                        <p class="text-sm text-gray-600">
                            Memimpin dusun ini dengan dedikasi untuk meningkatkan kesejahteraan masyarakat.
                        </p>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Struktur Wilayah</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">RW (Rukun Warga)</span>
                                <span class="font-bold text-emerald-600">1</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">RT (Rukun Tetangga)</span>
                                <span class="font-bold text-emerald-600">6</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('wilayah') }}" class="block w-full px-4 py-2 text-center bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">
                        Kembali ke Wilayah
                    </a>
                </div>
            </div>
        </div>

        <!-- Daftar RW/RT -->
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-8">Daftar RW dan RT</h2>

            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-emerald-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">RW</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">RT</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Ketua RT</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Alamat</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">KK</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Penduduk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($rwRt as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $item['nomor_rw'] }}</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">{{ $item['nomor_rt'] }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $item['ketua_rt'] }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $item['alamat_umum'] }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $item['jumlah_kk'] }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $item['jumlah_penduduk'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Informasi Tambahan -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Fasilitas -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Fasilitas Publik</h3>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <span class="text-2xl">🏫</span>
                        <span class="text-gray-700">Sekolah Dasar (SD)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-2xl">⛪</span>
                        <span class="text-gray-700">Rumah Ibadah</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-2xl">🏥</span>
                        <span class="text-gray-700">Pusat Kesehatan Masyarakat (Puskesmas)</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-2xl">📚</span>
                        <span class="text-gray-700">Perpustakaan Desa</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="text-2xl">⚽</span>
                        <span class="text-gray-700">Lapangan Olahraga</span>
                    </li>
                </ul>
            </div>

            <!-- Kegiatan Masyarakat -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Kegiatan Masyarakat</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="text-2xl">🌾</span>
                        <span class="text-gray-700"><strong>Pertanian Padi</strong> - Mayoritas mata pencaharian penduduk</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-2xl">🎨</span>
                        <span class="text-gray-700"><strong>Kerajinan Lokal</strong> - Pembuatan keramik dan produk kesenian</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-2xl">🤝</span>
                        <span class="text-gray-700"><strong>Kerjasama Ekonomi</strong> - Kelompok usaha bersama masyarakat</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-2xl">🎉</span>
                        <span class="text-gray-700"><strong>Acara Rutin</strong> - Perayaan budaya dan keagamaan</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 bg-emerald-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ingin Tahu Lebih Banyak?</h2>
        <p class="text-lg text-emerald-100 mb-8 max-w-2xl mx-auto">
            Hubungi kepala dusun atau kantor desa untuk informasi lebih lengkap tentang wilayah ini.
        </p>
        <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-emerald-600 font-bold rounded-lg hover:bg-emerald-50 transition">
            Hubungi Kami
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</section>
@endsection
