@extends('layouts.app')

@section('title', 'Transparansi APBDes')
@section('description', 'Laporan keuangan dan realisasi Anggaran Pendapatan dan Belanja Desa (APBDes).')

@section('content')

<x-hero-section 
    title="Transparansi APBDes"
    subtitle="Laporan keuangan desa yang dapat diakses oleh seluruh lapisan masyarakat sebagai wujud tata kelola yang baik."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Informasi', 'url' => '#'],
        ['label' => 'APBDes', 'url' => '#']
    ]"
/>

<section class="pt-24 pb-12 bg-slate-50 relative min-h-screen z-10">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-8 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">Tahun Anggaran {{ $tahun }}</h3>
                    <p class="text-xs text-slate-500">Menampilkan data APBDes tahun berjalan</p>
                </div>
            </div>

            <form action="{{ route('apbd') }}" method="GET" class="flex items-center gap-2">
                <select name="tahun" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 outline-none font-semibold cursor-pointer hover:bg-white transition-colors">
                    @foreach($daftarTahun as $t)
                        <option value="{{ $t }}" {{ $t == $tahun ? 'selected' : '' }}>Tahun {{ $t }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-[#059669] to-[#047857] rounded-3xl p-6 text-white shadow-lg shadow-emerald-600/20 transform hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                
                <div class="relative z-10 flex justify-between items-start mb-4">
                    <p class="text-emerald-50 text-sm font-semibold uppercase tracking-wider">Total Anggaran Belanja</p>
                    <svg class="w-6 h-6 text-emerald-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="relative z-10 text-3xl lg:text-4xl font-extrabold mb-1">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
                <div class="relative z-10 flex items-center gap-1.5 mt-4 text-xs font-medium text-emerald-100 bg-black/10 w-fit px-3 py-1 rounded-full border border-white/10">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Telah Disetujui BPD
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between group hover:border-blue-300 transition">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Realisasi Berjalan</p>
                        <svg class="w-6 h-6 text-blue-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-800">Rp {{ number_format($realisasiBelanja, 0, ',', '.') }}</h3>
                </div>
                
                <div class="mt-4">
                    <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                        <span>Progress Serapan</span>
                        <span class="text-blue-600">{{ $progressPersen }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden shadow-inner">
                        <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $progressPersen }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between group hover:border-amber-300 transition">
                <div>
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-slate-500 text-sm font-semibold uppercase tracking-wider">Sisa Anggaran</p>
                        <svg class="w-6 h-6 text-amber-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-extrabold text-slate-800">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</h3>
                </div>
                
                <div class="mt-4">
                    <div class="flex items-center gap-2 text-xs font-bold text-amber-600 bg-amber-50 w-fit px-3 py-1.5 rounded-lg border border-amber-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Menunggu Realisasi
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[520px]">
                <div class="bg-[#059669] px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center border border-white/30 text-white shadow-inner">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Sumber Pendapatan</h3>
                        <p class="text-emerald-100 text-xs">Total: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                <div class="p-6 flex-1 flex flex-col justify-start space-y-6 overflow-y-auto custom-scrollbar">
                    @php $colors = ['bg-[#10b981]', 'bg-[#3b82f6]', 'bg-[#f59e0b]', 'bg-[#8b5cf6]', 'bg-[#ef4444]', 'bg-[#14b8a6]']; @endphp
                    @forelse($sumberPendapatan as $index => $item)
                        @php $color = $colors[$index % count($colors)]; @endphp
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-3.5 h-3.5 rounded-full {{ $color }} shadow-sm"></div>
                                    <span class="font-bold text-slate-700 text-sm max-w-[200px] truncate" title="{{ $item->nama_sumber }}">{{ $item->nama_sumber }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold rounded ml-2 min-w-[36px]">{{ $item->persen }}%</span>
                                </div>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 ml-6.5 overflow-hidden shadow-inner" style="width: calc(100% - 1.625rem);">
                                <div class="{{ $color }} h-2 rounded-full transition-all duration-1000" style="width: {{ $item->persen }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-center py-10 text-slate-400">
                            <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="font-medium text-sm">Data pendapatan belum diinput.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col h-[520px]">
                <div class="bg-[#1e293b] px-6 py-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center border border-white/20 text-white shadow-inner">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg leading-tight">Alokasi Belanja</h3>
                        <p class="text-slate-400 text-xs">Distribusi anggaran per sektor</p>
                    </div>
                </div>
                
                <div class="p-6 bg-slate-50/50 flex-1 overflow-y-auto custom-scrollbar">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @php 
                            $cardColors = [
                                ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'border' => 'border-emerald-100', 'icon' => 'bg-emerald-100 text-emerald-600'],
                                ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'border' => 'border-blue-100', 'icon' => 'bg-blue-100 text-blue-600'],
                                ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'border' => 'border-purple-100', 'icon' => 'bg-purple-100 text-purple-600'],
                                ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'border' => 'border-amber-100', 'icon' => 'bg-amber-100 text-amber-600'],
                                ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'border' => 'border-rose-100', 'icon' => 'bg-rose-100 text-rose-600']
                            ]; 
                        @endphp
                        
                        @forelse($alokasiBelanja as $index => $item)
                            @php $style = $cardColors[$index % count($cardColors)]; @endphp
                            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $style['icon'] }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <p class="text-2xl font-black {{ $style['text'] }}">{{ $item->persen }}%</p>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm leading-snug mb-2 line-clamp-2 min-h-[2.5rem]" title="{{ $item->nama_bidang }}">{{ str_replace('Bidang ', '', $item->nama_bidang) }}</h4>
                                <p class="text-xs font-semibold text-slate-500 tracking-wide">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </p>
                            </div>
                        @empty
                            <div class="col-span-2 h-full flex flex-col items-center justify-center text-center py-10 text-slate-400">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="font-medium text-sm">Data belanja belum diinput.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-emerald-800">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-emerald-500 flex-shrink-0">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold">Keterbukaan Informasi Publik</h4>
                    <p class="text-sm">Data APBDes ini diperbarui secara berkala sesuai realisasi anggaran berjalan. Update terakhir: <span class="font-bold">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span></p>
                </div>
            </div>
            
            <button onclick="alert('Fitur download laporan PDF sedang dalam pengembangan.')" class="px-5 py-2.5 bg-white text-emerald-600 font-bold text-sm rounded-xl border border-emerald-200 hover:bg-emerald-600 hover:text-white transition-colors shadow-sm flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download Laporan PDF
            </button>
        </div>
        
    </div>
</section>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

@endsection