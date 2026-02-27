@extends('layouts.app')

@section('title', 'Pembagian Wilayah')
@section('description', 'Peta dan data pembagian wilayah administratif desa.')

@section('content')

<x-hero-section 
    title="Wilayah Administrasi"
    subtitle="Jelajahi pembagian wilayah administratif Dusun, RW, dan RT secara lengkap dan transparan."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Wilayah', 'url' => '#']
    ]"
/>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <x-section-title 
            title="Ringkasan Wilayah" 
            subtitle="Data kuantitatif pembagian wilayah administratif desa saat ini."
            badge="Data Statistik"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($statistik as $stat)
                @php
                    $icon = match($stat['icon']) {
                        'map' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 003 16.382V5.618a1 1 0 011.553-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.553-.894L15 9m0 13V9m0 0H9"></path></svg>',
                        'users' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                        'home' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
                        'user' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                        default => ''
                    };
                @endphp
                
                <x-stat-card 
                    :label="$stat['label']"
                    :value="$stat['value']"
                    :color="$stat['color']"
                    :icon="$icon"
                />
            @endforeach
        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-12 text-center">Hierarki Administratif Desa</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-100 -z-10 -translate-y-1/2 rounded-full"></div>

            <div class="relative p-8 bg-white rounded-2xl shadow-md border-b-4 border-emerald-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center text-emerald-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Dusun</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">Unit wilayah terbesar dalam desa yang dipimpin oleh Kepala Dusun (Kadus).</p>
            </div>

            <div class="relative p-8 bg-white rounded-2xl shadow-md border-b-4 border-blue-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Rukun Warga (RW)</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">Bagian dari dusun yang mengoordinasikan beberapa Rukun Tetangga (RT).</p>
            </div>

            <div class="relative p-8 bg-white rounded-2xl shadow-md border-b-4 border-amber-500 hover:-translate-y-2 transition duration-300">
                <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6 mx-auto shadow-sm">
                    <span class="text-2xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Rukun Tetangga (RT)</h3>
                <p class="text-gray-600 text-sm leading-relaxed text-center">Unit terkecil yang langsung bersentuhan dengan pelayanan warga sehari-hari.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50 border-y border-gray-200">
    <div class="container mx-auto px-4 max-w-6xl">
        <x-section-title 
            title="Daftar Dusun & RT/RW" 
            subtitle="Rincian lengkap pembagian wilayah dan kepengurusan di setiap tingkat."
            badge="Detail Wilayah"
        />

        @if(count($wilayahList) > 0)
            <div class="space-y-6">
                @foreach($wilayahList as $wilayah)
                    <details class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                        
                        <summary class="flex flex-col sm:flex-row items-center justify-between p-6 lg:p-8 cursor-pointer list-none hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-6 w-full sm:w-auto mb-4 sm:mb-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-inner flex-shrink-0">
                                    {{ substr($wilayah['nama_dusun'], 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-1">Dusun {{ $wilayah['nama_dusun'] }}</h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-500 font-medium">
                                        <span>{{ $wilayah['jumlah_rw'] }} RW</span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span>{{ $wilayah['jumlah_rt'] }} RT</span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300 hidden sm:block"></span>
                                        <span class="hidden sm:block">{{ number_format($wilayah['jumlah_penduduk'], 0, ',', '.') }} Jiwa</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-emerald-600 font-semibold w-full sm:w-auto justify-between sm:justify-end">
                                <span class="group-open:hidden">Lihat Detail</span>
                                <span class="hidden group-open:block">Tutup Detail</span>
                                <svg class="w-6 h-6 transform transition-transform duration-300 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </summary>

                        <div class="p-6 lg:p-8 bg-slate-50 border-t border-slate-100">
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                                
                                @foreach($wilayah['data_rw'] as $rw)
                                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                                        <div class="bg-slate-100 px-5 py-4 border-b border-slate-200 flex justify-between items-center">
                                            <div>
                                                <h4 class="font-bold text-slate-800 text-lg">RW {{ str_pad($rw['nama_rw'], 2, '0', STR_PAD_LEFT) }}</h4>
                                                <p class="text-xs text-slate-500 font-medium">Ketua: <span class="text-emerald-600">{{ $rw['ketua_rw'] ?? 'Belum Diatur' }}</span></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-bold text-slate-700">{{ number_format($rw['jumlah_penduduk'], 0, ',', '.') }} Jiwa</p>
                                                <p class="text-xs text-slate-500">{{ number_format($rw['jumlah_kk'], 0, ',', '.') }} KK</p>
                                            </div>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="w-full text-left text-sm whitespace-nowrap">
                                                <thead class="bg-white text-slate-500 border-b border-slate-100">
                                                    <tr>
                                                        <th class="px-5 py-3 font-semibold">RT</th>
                                                        <th class="px-5 py-3 font-semibold">Ketua RT</th>
                                                        <th class="px-5 py-3 font-semibold text-center">KK</th>
                                                        <th class="px-5 py-3 font-semibold text-center">Jiwa</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-50">
                                                    @foreach($rw['rt_list'] as $rt)
                                                        <tr class="hover:bg-slate-50 transition-colors">
                                                            <td class="px-5 py-3 font-bold text-emerald-600">{{ str_pad($rt->rt, 2, '0', STR_PAD_LEFT) }}</td>
                                                            <td class="px-5 py-3 text-slate-700 font-medium">{{ $rt->ketua_rt ?? '-' }}</td>
                                                            <td class="px-5 py-3 text-slate-600 text-center">{{ $rt->jumlah_kk }}</td>
                                                            <td class="px-5 py-3 text-slate-600 text-center font-semibold">{{ $rt->jumlah_penduduk }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </details>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Belum Ada Data Wilayah</h3>
                <p class="text-gray-500">Data pembagian wilayah dusun belum tersedia di database.</p>
            </div>
        @endif
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <x-section-title 
            title="Peta Digital Wilayah" 
            badge="Geografis"
        />

        <div class="bg-white p-3 rounded-3xl shadow-xl border border-gray-200">
            <div class="bg-slate-100 rounded-2xl h-[500px] flex items-center justify-center w-full overflow-hidden relative group">
                <div class="text-center z-10 transform group-hover:scale-105 transition duration-500">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg animate-bounce-slow">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Peta Interaktif Segera Hadir</h3>
                    <p class="text-slate-500 max-w-md mx-auto">Kami sedang mempersiapkan peta digital yang memuat batas wilayah RT/RW dan lokasi fasilitas umum.</p>
                </div>
                
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cartographer.png')] opacity-10"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-200/50 to-transparent pointer-events-none"></div>
            </div>
        </div>
    </div>
</section>

<style>
    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }
</style>

@endsection