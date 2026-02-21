@extends('layouts.app')

@section('title', 'Data Desa')
@section('description', 'Statistik dan data transparansi desa yang akuntabel')

@section('content')

<x-hero-section 
    title="Data & Statistik Desa"
    subtitle="Portal transparansi data kependudukan, pendidikan, sosial, dan anggaran desa yang akuntabel."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Data Desa', 'url' => '#']
    ]"
/>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Demografi Penduduk" 
            subtitle="Gambaran umum populasi penduduk desa saat ini."
            badge="Statistik Utama"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($statistikPenduduk as $stat)
                @php
                    $icon = match($stat['icon']) {
                        'users' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                        'user' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                        'home' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
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

<section class="py-20 bg-gray-50 border-y border-gray-100">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Tingkat Pendidikan</h3>
                </div>

                <div class="space-y-6">
                    @foreach($statistikPendidikan as $stat)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <span class="font-medium text-gray-700">{{ $stat['label'] }}</span>
                                <span class="text-sm font-bold text-blue-600">{{ $stat['value'] }} ({{ $stat['persen'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="bg-blue-500 h-3 rounded-full transition-all duration-1000 ease-out group-hover:bg-blue-600" style="width: {{ $stat['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Profesi Warga</h3>
                </div>

                <div class="space-y-6">
                    @foreach($statistikPekerjaan as $pekerjaan)
                        <div class="group">
                            <div class="flex justify-between items-end mb-2">
                                <span class="font-medium text-gray-700">{{ $pekerjaan['label'] }}</span>
                                <span class="text-sm font-bold text-amber-600">{{ $pekerjaan['value'] }} ({{ $pekerjaan['persen'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="bg-amber-500 h-3 rounded-full transition-all duration-1000 ease-out group-hover:bg-amber-600" style="width: {{ $pekerjaan['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Agama & Kepercayaan</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($statistikAgama as $agama)
                        <div class="bg-gray-50 rounded-xl p-4 text-center hover:bg-emerald-50 transition border border-gray-100">
                            <h4 class="font-bold text-gray-800">{{ $agama['label'] }}</h4>
                            <p class="text-2xl font-bold text-emerald-600 mt-2">{{ $agama['value'] }}</p>
                            <p class="text-xs text-gray-500">{{ $agama['persen'] }}%</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-emerald-700 relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Transparansi Anggaran {{ $anggaranDesa['tahun'] }}</h2>
            <p class="text-emerald-200">Laporan realisasi dan sumber pendapatan desa secara terbuka.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-2xl">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                
                <div class="lg:w-1/3 text-center lg:text-left">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Total APBDes</p>
                    <h3 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">{{ $anggaranDesa['total_anggaran'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Dana ini dialokasikan untuk pembangunan infrastruktur, pemberdayaan masyarakat, dan penyelenggaraan pemerintahan desa.
                    </p>
                </div>

                <div class="lg:w-2/3 w-full space-y-6">
                    @foreach($anggaranDesa['sumber_dana'] as $sumber)
                        <div class="relative">
                            <div class="flex justify-between items-end mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    <span class="font-bold text-gray-800">{{ $sumber['sumber'] }}</span>
                                </div>
                                <span class="font-mono font-bold text-gray-600">{{ $sumber['nilai'] }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-4 rounded-full" style="width: {{ $sumber['persentase'] }}%"></div>
                            </div>
                            <p class="text-right text-xs text-gray-400 mt-1">{{ $sumber['persentase'] }}% dari total anggaran</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <x-section-title 
            title="Inventaris Aset Desa" 
            subtitle="Daftar kekayaan milik desa yang dikelola untuk kepentingan masyarakat."
            badge="Aset Desa"
        />

        <div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-4">Nama Aset</th>
                        <th class="px-6 py-4">Deskripsi / Lokasi</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4 text-center">Tahun</th>
                        <th class="px-6 py-4 text-right">Nilai Aset</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($asetDesa as $aset)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $aset['nama'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $aset['deskripsi'] }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $bgStatus = match($aset['kondisi']) {
                                        'Baik' => 'bg-green-100 text-green-700',
                                        'Rusak Ringan' => 'bg-yellow-100 text-yellow-700',
                                        'Rusak Berat' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $bgStatus }}">
                                    {{ $aset['kondisi'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-gray-500">{{ $aset['tahun'] }}</td>
                            <td class="px-6 py-4 text-right font-bold text-gray-900">{{ $aset['nilai'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <p>Data aset desa belum tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection