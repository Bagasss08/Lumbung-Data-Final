@extends('layouts.app')

@section('title', 'Badan Permusyawaratan Desa')
@section('description', 'Susunan pengurus dan anggota Badan Permusyawaratan Desa (BPD)')

@section('content')

<x-hero-section 
    title="Badan Permusyawaratan Desa"
    subtitle="Lembaga yang melaksanakan fungsi pemerintahan yang anggotanya merupakan wakil dari penduduk desa berdasarkan keterwakilan wilayah."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Profil Desa', 'url' => '#'],
        ['label' => 'BPD', 'url' => '#']
    ]"
/>

<section class="py-20 bg-gray-50/50 relative overflow-hidden">
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <div class="text-center mb-16">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm mb-2 block">Lembaga Pengawasan</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Struktur Pimpinan BPD</h2>
            <div class="w-20 h-1.5 bg-emerald-500 rounded-full mx-auto mt-4"></div>
        </div>

        <div class="flex flex-col items-center relative pb-10 border-b border-gray-200">
            @if($ketuaBpd)
            <div class="z-10 bg-white border-[3px] border-emerald-500 rounded-3xl p-6 w-72 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative">
                <div class="absolute -top-4 -right-4 w-12 h-12 bg-emerald-100 rounded-full mix-blend-multiply blur-md"></div>
                <div class="w-28 h-28 mx-auto rounded-full p-1 border-2 border-emerald-200 mb-4 overflow-hidden bg-gray-50">
                    <img src="{{ $ketuaBpd->foto ? asset('storage/'.$ketuaBpd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($ketuaBpd->nama).'&background=10b981&color=fff' }}" 
                         alt="{{ $ketuaBpd->nama }}" class="w-full h-full object-cover rounded-full">
                </div>
                <h3 class="font-bold text-gray-900 text-lg leading-tight mb-1">{{ $ketuaBpd->nama }}</h3>
                <p class="text-emerald-600 font-bold text-sm bg-emerald-50 inline-block px-3 py-1 rounded-full mb-2">{{ $ketuaBpd->jabatan->nama ?? 'Ketua BPD' }}</p>
                @if($ketuaBpd->no_sk) <p class="text-xs text-gray-500 font-mono">NIP/SK: {{ $ketuaBpd->no_sk }}</p> @endif
            </div>
            @endif

            @if($wakilKetuaBpd || $sekretarisBpd)
                <div class="w-0.5 h-10 bg-emerald-300 hidden md:block relative">
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-emerald-300" style="width: 320px;"></div>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-center gap-8 md:gap-16 mt-8 md:mt-0 relative w-full px-4">
                
                @if($wakilKetuaBpd)
                <div class="relative flex flex-col items-center group">
                    <div class="absolute -top-10 left-1/2 w-0.5 h-10 bg-emerald-300 hidden md:block"></div>
                    <div class="bg-white border border-blue-200 rounded-2xl p-5 w-64 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative z-10">
                        <div class="w-20 h-20 mx-auto rounded-full p-1 border-2 border-blue-100 mb-3 overflow-hidden bg-gray-50">
                            <img src="{{ $wakilKetuaBpd->foto ? asset('storage/'.$wakilKetuaBpd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($wakilKetuaBpd->nama).'&background=3b82f6&color=fff' }}" 
                                 alt="{{ $wakilKetuaBpd->nama }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        <h3 class="font-bold text-gray-900 text-base leading-tight mb-1">{{ $wakilKetuaBpd->nama }}</h3>
                        <p class="text-blue-600 font-semibold text-xs bg-blue-50 inline-block px-2 py-0.5 rounded-full">{{ $wakilKetuaBpd->jabatan->nama ?? 'Wakil Ketua BPD' }}</p>
                    </div>
                </div>
                @endif

                @if($sekretarisBpd)
                <div class="relative flex flex-col items-center group">
                    <div class="absolute -top-10 left-1/2 w-0.5 h-10 bg-emerald-300 hidden md:block"></div>
                    <div class="bg-white border border-blue-200 rounded-2xl p-5 w-64 text-center shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative z-10">
                        <div class="w-20 h-20 mx-auto rounded-full p-1 border-2 border-blue-100 mb-3 overflow-hidden bg-gray-50">
                            <img src="{{ $sekretarisBpd->foto ? asset('storage/'.$sekretarisBpd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($sekretarisBpd->nama).'&background=3b82f6&color=fff' }}" 
                                 alt="{{ $sekretarisBpd->nama }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        <h3 class="font-bold text-gray-900 text-base leading-tight mb-1">{{ $sekretarisBpd->nama }}</h3>
                        <p class="text-blue-600 font-semibold text-xs bg-blue-50 inline-block px-2 py-0.5 rounded-full">{{ $sekretarisBpd->jabatan->nama ?? 'Sekretaris BPD' }}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-white relative">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="bg-white border border-gray-100 rounded-3xl p-8 lg:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8 pb-6 border-b border-gray-100">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Tugas & Fungsi BPD</h3>
                    <p class="text-gray-500 text-sm mt-1">Sesuai dengan peraturan perundang-undangan yang berlaku</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                @foreach($tugasFungsi as $index => $tugas)
                <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-emerald-50/50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-700 text-sm font-bold flex-shrink-0 shadow-sm">
                        {{ $index + 1 }}
                    </div>
                    <p class="text-gray-700 text-base leading-relaxed pt-1">{{ $tugas }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@if(count($anggotaBpd) > 0)
<section class="py-20 bg-slate-50 relative border-t border-slate-200">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-800">Anggota BPD Lainnya</h2>
            <p class="text-gray-500 mt-2">Daftar anggota Badan Permusyawaratan Desa dari setiap perwakilan wilayah.</p>
            <div class="w-16 h-1 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($anggotaBpd as $anggota)
            <div class="bg-white rounded-2xl p-6 text-center border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group hover:-translate-y-1">
                <div class="w-20 h-20 mx-auto rounded-full overflow-hidden border-2 border-gray-100 mb-4 group-hover:border-emerald-300 transition-colors duration-300">
                    <img src="{{ $anggota->foto ? asset('storage/'.$anggota->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggota->nama).'&background=f1f5f9&color=334155' }}" 
                         alt="{{ $anggota->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <h4 class="font-bold text-slate-900 mb-1 leading-snug">{{ $anggota->nama }}</h4>
                <p class="text-xs text-emerald-600 font-semibold bg-emerald-50 inline-block px-2 py-0.5 rounded-full">{{ $anggota->jabatan->nama ?? 'Anggota BPD' }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection