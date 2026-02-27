@extends('layouts.app')

@section('title', 'Demografi & Statistik Desa')
@section('description', 'Data kependudukan dan statistik desa yang diperbarui secara berkala.')

@section('content')

<x-hero-section 
    title="Demografi & Statistik"
    subtitle="Data kependudukan dan statistik desa yang diperbarui secara berkala untuk transparansi informasi publik."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Profil Desa', 'url' => '#'],
        ['label' => 'Demografi & Statistik', 'url' => '#']
    ]"
/>

<section class="pt-24 pb-12 bg-slate-50 relative min-h-screen z-10">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-gradient-to-br from-[#059669] to-[#047857] rounded-3xl p-6 text-white shadow-md transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-emerald-50 text-sm font-semibold uppercase tracking-wider mb-2">Total Penduduk</p>
                        <h3 class="text-4xl lg:text-5xl font-extrabold mb-1">{{ number_format($totalPenduduk, 0, ',', '.') }}</h3>
                        <p class="text-emerald-100 text-xs">Jiwa (Laki & Perempuan)</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#3b82f6] to-[#2563eb] rounded-3xl p-6 text-white shadow-md transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider mb-2">Kepala Keluarga</p>
                        <h3 class="text-4xl lg:text-5xl font-extrabold mb-1">{{ number_format($totalKeluarga, 0, ',', '.') }}</h3>
                        <p class="text-blue-100 text-xs">Total KK Terdaftar</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#8b5cf6] to-[#6366f1] rounded-3xl p-6 text-white shadow-md transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-semibold uppercase tracking-wider mb-2">Luas Wilayah</p>
                        <h3 class="text-4xl lg:text-5xl font-extrabold mb-1">{{ $luasWilayah }} <span class="text-2xl font-bold">Ha</span></h3>
                        <p class="text-indigo-100 text-xs">Total Area Desa</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#f59e0b] to-[#d97706] rounded-3xl p-6 text-white shadow-md transform hover:-translate-y-1 transition duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-semibold uppercase tracking-wider mb-2">Kepadatan</p>
                        <h3 class="text-4xl lg:text-5xl font-extrabold mb-1">{{ $luasWilayah > 0 ? round($totalPenduduk / $luasWilayah, 1) : 0 }}</h3>
                        <p class="text-amber-100 text-xs">Jiwa / Hektar</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 mb-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Komposisi Jenis Kelamin</h3>
            </div>

            <div class="flex flex-col md:flex-row justify-between mb-4 px-4 lg:px-12">
                <div class="flex items-center gap-5 mb-6 md:mb-0">
                    <div class="w-16 h-16 bg-[#0ea5e9] text-white rounded-2xl flex items-center justify-center shadow-md shadow-sky-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-3xl font-extrabold text-slate-800">{{ number_format($lakiLaki, 0, ',', '.') }}</h4>
                        <p class="text-[#0ea5e9] font-bold text-sm tracking-wide">Laki-laki ({{ $persenLaki }}%)</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-5 md:flex-row-reverse md:text-right">
                    <div class="w-16 h-16 bg-[#f43f5e] text-white rounded-2xl flex items-center justify-center shadow-md shadow-rose-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-3xl font-extrabold text-slate-800">{{ number_format($perempuan, 0, ',', '.') }}</h4>
                        <p class="text-[#f43f5e] font-bold text-sm tracking-wide">Perempuan ({{ $persenPerempuan }}%)</p>
                    </div>
                </div>
            </div>

            <div class="w-full h-4 rounded-full flex overflow-hidden shadow-inner bg-slate-100 mx-auto mt-6">
                <div class="bg-[#0ea5e9] h-full transition-all duration-1000 relative" style="width: {{ $persenLaki }}%"></div>
                <div class="bg-[#f43f5e] h-full transition-all duration-1000 relative" style="width: {{ $persenPerempuan }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[420px]">
                <div class="bg-[#a855f7] px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border border-white/30 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Distribusi Usia</h3>
                        <p class="text-purple-100 text-xs">Berdasarkan kelompok umur</p>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-center space-y-6">
                    @foreach($usiaData as $item)
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="font-bold text-slate-700 text-sm">{{ $item['label'] }}</span>
                                <span class="text-sm font-bold text-slate-800">{{ number_format($item['total'], 0, ',', '.') }} Jiwa <span class="text-xs text-slate-400 font-normal ml-1">({{ $item['persen'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-[#a855f7] h-2 rounded-full" style="width: {{ $item['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[420px]">
                <div class="bg-[#10b981] px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border border-white/30 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Tingkat Pendidikan</h3>
                        <p class="text-emerald-100 text-xs">Pendidikan terakhir warga</p>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-start space-y-5 overflow-y-auto custom-scrollbar">
                    @foreach($pendidikanData as $item)
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="font-bold text-slate-700 text-sm truncate pr-2">{{ $item['label'] }}</span>
                                <span class="text-sm font-bold text-slate-800 whitespace-nowrap">{{ number_format($item['total'], 0, ',', '.') }} Jiwa <span class="text-xs text-slate-400 font-normal ml-1">({{ $item['persen'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-[#10b981] h-2 rounded-full" style="width: {{ $item['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-[#f97316] px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border border-white/30 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Mata Pencaharian</h3>
                        <p class="text-orange-100 text-xs">Jenis pekerjaan penduduk</p>
                    </div>
                </div>
                <div class="p-6 bg-slate-50/50 flex-1 flex flex-col justify-center">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(array_slice($pekerjaanData, 0, 6) as $index => $item)
                            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                <p class="text-3xl font-extrabold text-[#f97316] mb-1">{{ $item['persen'] }}<span class="text-lg">%</span></p>
                                <p class="font-bold text-slate-800 text-sm leading-tight mb-2 h-10 line-clamp-2">{{ $item['label'] }}</p>
                                <p class="text-xs text-slate-500 font-semibold">{{ number_format($item['total'], 0, ',', '.') }} Jiwa</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="bg-slate-700 px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center border border-white/30 text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Agama</h3>
                        <p class="text-slate-300 text-xs">Komposisi berdasarkan agama</p>
                    </div>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-center space-y-6">
                    @php $colors = ['bg-[#10b981]', 'bg-[#3b82f6]', 'bg-[#f59e0b]', 'bg-[#8b5cf6]', 'bg-[#f43f5e]', 'bg-[#64748b]']; @endphp
                    @foreach($agamaData as $index => $item)
                        @php $color = $colors[$index % count($colors)]; @endphp
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-3.5 h-3.5 rounded-full {{ $color }}"></div>
                                    <span class="font-bold text-slate-700">{{ $item['label'] }}</span>
                                </div>
                                <span class="font-bold text-slate-800">{{ number_format($item['total'], 0, ',', '.') }} Jiwa <span class="text-xs text-slate-400 font-normal ml-1">({{ $item['persen'] }}%)</span></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 ml-6.5" style="width: calc(100% - 1.625rem);">
                                <div class="{{ $color }} h-1.5 rounded-full" style="width: {{ $item['persen'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        
    </div>
</section>

<style>
    /* Styling for Scrollbar to keep it clean */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1; 
    }
</style>

@endsection