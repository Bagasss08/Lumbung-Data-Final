@extends('layouts.app')

@section('title', 'Struktur Pemerintahan')
@section('description', 'Struktur organisasi dan perangkat desa yang melayani dengan dedikasi')

@section('content')

<x-hero-section 
    title="Struktur Pemerintahan"
    subtitle="Susunan perangkat desa yang bertugas melayani masyarakat dengan penuh dedikasi dan integritas."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Pemerintahan', 'url' => '#']
    ]"
/>

<section class="py-20 bg-gray-50/50 relative overflow-hidden">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-16">
            <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm mb-2 block">Pemerintah Desa</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">Struktur Organisasi</h2>
            <div class="w-20 h-1.5 bg-emerald-500 rounded-full mx-auto mt-4"></div>
        </div>

        <div class="flex flex-col items-center relative">
            @if($kades)
            <div class="z-10 bg-white border-[3px] border-emerald-500 rounded-3xl p-6 w-72 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 relative">
                <div class="absolute -top-4 -right-4 w-12 h-12 bg-emerald-100 rounded-full mix-blend-multiply blur-md"></div>
                <div class="w-28 h-28 mx-auto rounded-full p-1 border-2 border-emerald-200 mb-4 overflow-hidden bg-gray-50">
                    <img src="{{ $kades->foto ? asset('storage/'.$kades->foto) : 'https://ui-avatars.com/api/?name='.urlencode($kades->nama).'&background=10b981&color=fff' }}" 
                         alt="{{ $kades->nama }}" class="w-full h-full object-cover rounded-full">
                </div>
                <h3 class="font-bold text-gray-900 text-lg leading-tight mb-1">{{ $kades->nama }}</h3>
                <p class="text-emerald-600 font-bold text-sm bg-emerald-50 inline-block px-3 py-1 rounded-full mb-2">{{ $kades->jabatan->nama ?? 'Kepala Desa' }}</p>
                @if($kades->no_sk) <p class="text-xs text-gray-500 font-mono">NIP/SK: {{ $kades->no_sk }}</p> @endif
            </div>
            @endif

            <div class="w-0.5 h-8 bg-emerald-300 hidden md:block"></div>

            @if($sekdes)
            <div class="z-10 bg-white border border-blue-200 rounded-2xl p-5 w-64 text-center shadow-lg hover:shadow-xl transition-all duration-300 relative">
                <div class="w-20 h-20 mx-auto rounded-full p-1 border-2 border-blue-100 mb-3 overflow-hidden bg-gray-50">
                    <img src="{{ $sekdes->foto ? asset('storage/'.$sekdes->foto) : 'https://ui-avatars.com/api/?name='.urlencode($sekdes->nama).'&background=3b82f6&color=fff' }}" 
                         alt="{{ $sekdes->nama }}" class="w-full h-full object-cover rounded-full">
                </div>
                <h3 class="font-bold text-gray-900 text-base leading-tight mb-1">{{ $sekdes->nama }}</h3>
                <p class="text-blue-600 font-semibold text-xs bg-blue-50 inline-block px-2 py-0.5 rounded-full">{{ $sekdes->jabatan->nama ?? 'Sekretaris Desa' }}</p>
            </div>
            @endif

            @if(count($kasiKaur) > 0)
            <div class="w-0.5 h-8 bg-emerald-300 hidden md:block relative">
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 bg-emerald-300" style="width: min(100vw - 4rem, {{ count($kasiKaur) * 220 }}px);"></div>
            </div>

            <div class="flex flex-wrap justify-center gap-4 md:gap-6 mt-8 md:mt-0 relative w-full px-4">
                @foreach($kasiKaur as $perangkat)
                <div class="relative flex flex-col items-center w-[45%] md:w-52 group">
                    <div class="absolute -top-8 left-1/2 w-0.5 h-8 bg-emerald-300 hidden md:block"></div>
                    
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 w-full text-center shadow-sm hover:shadow-lg transition-all duration-300 h-full flex flex-col items-center hover:-translate-y-1">
                        <div class="w-16 h-16 mx-auto rounded-full p-1 border border-gray-200 mb-3 overflow-hidden bg-gray-50 group-hover:border-emerald-300 transition-colors">
                            <img src="{{ $perangkat->foto ? asset('storage/'.$perangkat->foto) : 'https://ui-avatars.com/api/?name='.urlencode($perangkat->nama).'&background=0ea5e9&color=fff' }}" 
                                 alt="{{ $perangkat->nama }}" class="w-full h-full object-cover rounded-full">
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 leading-snug">{{ $perangkat->nama }}</h4>
                        <p class="text-xs text-gray-500 font-medium px-2">{{ $perangkat->jabatan->nama }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>

@if(count($kadus) > 0)
<section class="py-16 bg-white border-t border-gray-100">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-10">
            <h3 class="text-2xl font-bold text-slate-800">Pelaksana Kewilayahan (Kepala Dusun)</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">
            @foreach($kadus as $dusun)
            <div class="flex items-center gap-4 bg-gray-50 border border-gray-100 p-4 rounded-2xl hover:bg-emerald-50 transition-colors group">
                <img src="{{ $dusun->foto ? asset('storage/'.$dusun->foto) : 'https://ui-avatars.com/api/?name='.urlencode($dusun->nama).'&background=f59e0b&color=fff' }}" 
                     alt="{{ $dusun->nama }}" class="w-14 h-14 rounded-xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">{{ $dusun->nama }}</h4>
                    <p class="text-xs font-semibold text-amber-600 mt-0.5">{{ $dusun->jabatan->nama ?? 'Kepala Dusun' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(count($wilayahRw) > 0)
<section class="py-20 bg-slate-50 border-t border-gray-200 relative">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-bold tracking-wider uppercase text-sm mb-2 block">Pemerintahan Wilayah</span>
            <h2 class="text-3xl font-bold text-slate-800">Ketua RW & Ketua RT</h2>
            <p class="text-gray-500 mt-3 max-w-2xl mx-auto">Struktur pemerintahan tingkat RW dan RT yang melayani warga secara langsung di setiap wilayah.</p>
        </div>

        <div class="space-y-8">
            @php 
                // Daftar warna gradient untuk memberi kesan dinamis pada setiap card RW
                $gradients = [
                    'from-purple-600 to-indigo-600',
                    'from-blue-600 to-cyan-600',
                    'from-emerald-600 to-teal-600',
                    'from-orange-500 to-red-500',
                    'from-pink-500 to-rose-600'
                ];
                $bgColors = ['bg-purple-50', 'bg-blue-50', 'bg-emerald-50', 'bg-orange-50', 'bg-pink-50'];
                $textColors = ['text-purple-700', 'text-blue-700', 'text-emerald-700', 'text-orange-700', 'text-pink-700'];
            @endphp

            @foreach($wilayahRw as $rw => $rts)
                @php 
                    $colorIndex = $loop->index % count($gradients); 
                    $gradient = $gradients[$colorIndex];
                    $bgLight = $bgColors[$colorIndex];
                    $textDark = $textColors[$colorIndex];
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-gradient-to-r {{ $gradient }} px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-white">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center font-bold text-xl border border-white/30">
                                {{ str_pad($rw, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">Ketua: {{ $rts->first()->ketua_rw ?? 'Belum Diatur' }}</h3>
                                <p class="text-sm opacity-90">Wilayah: Dusun {{ $rts->first()->dusun ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="bg-white/20 px-4 py-1.5 rounded-full text-xs font-semibold backdrop-blur-sm whitespace-nowrap self-start sm:self-auto border border-white/30 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            {{ count($rts) }} RT
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach($rts as $rt)
                                <div class="border border-gray-100 {{ $bgLight }} rounded-xl p-5 hover:scale-[1.02] transition-transform duration-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <span class="text-xs font-black {{ $textDark }} bg-white px-2 py-1 rounded shadow-sm border border-gray-100">
                                            RT {{ str_pad($rt->rt, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                    <p class="font-bold text-gray-900 text-sm mb-4">{{ $rt->ketua_rt ?? 'Belum Diatur' }}</p>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500 border-t border-gray-200/60 pt-3 mt-auto">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800 text-sm">{{ $rt->jumlah_kk ?? 0 }}</span>
                                            <span>Keluarga</span>
                                        </div>
                                        <div class="w-px h-8 bg-gray-200/60"></div>
                                        <div class="flex flex-col text-right">
                                            <span class="font-bold text-gray-800 text-sm">{{ $rt->jumlah_penduduk ?? 0 }}</span>
                                            <span>Warga</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
