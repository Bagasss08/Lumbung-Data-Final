@extends('layouts.app')

@section('title', 'Profil Kepala Desa')
@section('description', 'Profil lengkap Kepala Desa Serayu Larangan')

@section('content')
<!-- Hero Section -->
<x-hero-section 
    title="Profil Kepala Desa"
    subtitle="Pemimpin desa yang berdedikasi untuk kemajuan bersama"
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Profil', 'url' => route('profil')],
        ['label' => 'Kepala Desa', 'url' => '#']
    ]"
/>

<!-- Profil Detail -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Foto & Info Singkat -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-20">
                    <div class="h-64 bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                        <svg class="w-40 h-40 text-emerald-100" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $kepalaDesa['nama'] }}</h2>
                        <p class="text-emerald-600 font-semibold mb-4">Kepala Desa Serayu Larangan</p>
                        
                        <div class="space-y-4 pt-4 border-t border-gray-200">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">NIP</p>
                                <p class="text-sm font-mono text-gray-900">{{ $kepalaDesa['nip'] }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Tempat, Tanggal Lahir</p>
                                <p class="text-sm text-gray-900">
                                    {{ $kepalaDesa['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($kepalaDesa['tanggal_lahir'])->isoFormat('D MMMM YYYY', locale: 'id') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Agama</p>
                                <p class="text-sm text-gray-900">{{ $kepalaDesa['agama'] }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Pendidikan Terakhir</p>
                                <p class="text-sm text-gray-900">{{ $kepalaDesa['pendidikan'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Detail -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Biografi -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Biografi</h3>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        {{ $kepalaDesa['nama'] }} lahir di {{ $kepalaDesa['tempat_lahir'] }} pada tanggal {{ \Carbon\Carbon::parse($kepalaDesa['tanggal_lahir'])->isoFormat('D MMMM YYYY', locale: 'id') }}. Beliau adalah seorang pemimpin yang berdedikasi tinggi untuk kemajuan dan kesejahteraan masyarakat Desa Serayu Larangan.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Dengan pengalaman panjang di dunia pemerintahan desa, Kepala Desa {{ $kepalaDesa['nama'] }} memiliki visi jelas untuk membawa Desa Serayu Larangan menjadi desa yang lebih maju, mandiri, dan sejahtera bagi seluruh masyarakatnya.
                    </p>
                </div>

                <!-- Pengalaman Kerja -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Pengalaman Kerja</h3>
                    <p class="text-gray-700 mb-6">{{ $kepalaDesa['pengalaman_kerja'] }}</p>
                    
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900">Riwayat Jabatan</h4>
                        @foreach($kepalaDesa['riwayat_jabatan'] as $jabatan)
                            <div class="flex items-start gap-4 pb-4 border-b border-gray-200 last:border-0">
                                <div class="w-2 h-2 bg-emerald-600 rounded-full mt-2 flex-shrink-0"></div>
                                <p class="text-gray-700">{{ $jabatan }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Program Unggulan -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-lg p-8 border border-emerald-200">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Program Unggulan</h3>
                    <p class="text-gray-700 mb-6">
                        Selama memimpin, Kepala Desa {{ $kepalaDesa['nama'] }} telah meluncurkan berbagai program unggulan untuk memberdayakan masyarakat dan meningkatkan kualitas hidup mereka:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($program_unggulan as $program)
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">🎯</span>
                                <span class="text-gray-800 font-medium">{{ $program }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Visi & Misi</h3>
                    
                    <div class="space-y-6">
                        <div class="border-l-4 border-emerald-600 pl-6">
                            <h4 class="font-bold text-emerald-700 mb-2">VISI</h4>
                            <p class="text-gray-700">
                                Serayu Larangan yang Maju, Mandiri, dan Sejahtera dengan Pelayanan Publik Terbaik
                            </p>
                        </div>

                        <div class="border-l-4 border-blue-600 pl-6">
                            <h4 class="font-bold text-blue-700 mb-3">MISI</h4>
                            <ul class="space-y-2 text-gray-700">
                                <li class="flex items-start gap-3">
                                    <span class="text-blue-600 font-bold mt-1">✓</span>
                                    <span>Meningkatkan kesejahteraan masyarakat melalui pemberdayaan ekonomi</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-blue-600 font-bold mt-1">✓</span>
                                    <span>Menyediakan layanan publik yang transparan dan akuntabel</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-blue-600 font-bold mt-1">✓</span>
                                    <span>Memperkuat partisipasi masyarakat dalam pembangunan desa</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-blue-600 font-bold mt-1">✓</span>
                                    <span>Menjaga kelestarian lingkungan dan budaya lokal</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Hubungi Kepala Desa</h3>
                    <p class="text-gray-700 mb-6">
                        Jika Anda ingin berkonsultasi atau menyampaikan masukan langsung kepada Kepala Desa, silakan datang ke kantor desa pada jam kerja atau hubungi melalui kontak berikut:
                    </p>
                    <div class="space-y-4">
                        <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition">
                            Hubungi Kepala Desa
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
