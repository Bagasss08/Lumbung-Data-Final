@extends('layouts.app')

@section('title', 'Lembaga Kemasyarakatan Desa')
@section('description', 'Informasi lembaga dan organisasi kemasyarakatan yang menjadi mitra pemerintah desa')

@section('content')

<x-hero-section 
    title="Lembaga Kemasyarakatan"
    subtitle="Wadah partisipasi masyarakat yang ikut serta merencanakan, melaksanakan, dan mengawasi pembangunan desa."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Profil Desa', 'url' => '#'],
        ['label' => 'Lembaga Masyarakat', 'url' => '#']
    ]"
/>

<section class="py-20 bg-slate-50 relative min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="text-center mb-16">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm mb-2 block">Mitra Pemerintah Desa</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Daftar Lembaga Masyarakat</h2>
            <div class="w-16 h-1.5 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">Lembaga Kemasyarakatan Desa (LKD) bertugas menampung dan menyalurkan aspirasi serta kebutuhan masyarakat di berbagai bidang.</p>
        </div>

        @if($kategoriLembaga->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($kategoriLembaga as $master)
                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden group">
                        
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-700"></div>

                        <div class="flex items-start gap-5 mb-6 relative z-10">
                            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 leading-tight mb-1">{{ $master->nama }}</h3>
                                @if($master->singkatan)
                                    <span class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">{{ $master->singkatan }}</span>
                                @endif
                                @if($master->jenis)
                                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full ml-1">Bidang {{ ucfirst($master->jenis) }}</span>
                                @endif
                            </div>
                        </div>

                        <p class="text-gray-600 text-sm mb-8 leading-relaxed relative z-10">
                            {{ $master->keterangan ?? 'Lembaga kemasyarakatan yang menjadi mitra pemerintah desa dalam pemberdayaan masyarakat.' }}
                        </p>

                        <div class="relative z-10">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Kepengurusan:</p>
                            
                            @if(isset($dataKelompok[$master->id]) && count($dataKelompok[$master->id]) > 0)
                                <div class="space-y-3">
                                    @foreach($dataKelompok[$master->id] as $kel)
                                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-emerald-50/50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 flex-shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-800 text-sm">{{ $kel->nama }}</h4>
                                                    <p class="text-xs text-emerald-600 font-medium">Ketua: <span class="font-bold text-slate-700">{{ $kel->nama_ketua ?? 'Belum Diatur' }}</span></p>
                                                </div>
                                            </div>
                                            
                                            @if($kel->sk_desa)
                                                <div class="sm:text-right bg-white px-3 py-1.5 rounded-lg border border-slate-200 self-start sm:self-auto">
                                                    <p class="text-[10px] text-slate-500 font-bold uppercase mb-0.5">Nomor SK Desa</p>
                                                    <p class="text-xs font-mono text-slate-800 font-semibold">{{ $kel->sk_desa }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-xl p-6 text-center border border-dashed border-gray-200">
                                    <p class="text-sm text-gray-500 italic">Susunan pengurus belum ditambahkan ke dalam sistem.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200 shadow-sm">
                <div class="inline-flex justify-center items-center w-20 h-20 rounded-full bg-slate-50 text-slate-400 mb-6 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Lembaga</h3>
                <p class="text-gray-500 max-w-md mx-auto">Data master Lembaga Kemasyarakatan Desa (PKK, Karang Taruna, dll) belum ditambahkan oleh Admin.</p>
            </div>
        @endif

    </div>
</section>

@endsection