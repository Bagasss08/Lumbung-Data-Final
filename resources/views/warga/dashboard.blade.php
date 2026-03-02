@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="text-emerald-100 text-lg">Di Sistem Layanan Mandiri Desa.</p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 transform skew-x-12"></div>
    </div>

    @php
        $unreadWargaPesan = class_exists(\App\Models\Pesan::class) 
            ? \App\Models\Pesan::where('penerima_id', Auth::id())->where('sudah_dibaca', false)->count() 
            : 0;
    @endphp
    @if($unreadWargaPesan > 0)
        <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-r-xl shadow-sm mb-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <p>Anda memiliki <strong>{{ $unreadWargaPesan }} pesan baru</strong> dari Admin Desa.</p>
            </div>
            <a href="{{ route('warga.pesan.index') }}" class="text-sm font-bold text-amber-700 hover:underline">Buka Kotak Masuk</a>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <a href="{{ route('warga.profil') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Profil Saya</h3>
            <p class="text-sm text-slate-500">Lihat dan cek biodata kependudukan Anda.</p>
        </a>

        <a href="{{ route('warga.surat.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Layanan Surat</h3>
            <p class="text-sm text-slate-500">Buat permohonan surat keterangan online.</p>
        </a>

        <a href="{{ route('warga.pesan.index') }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1 relative">
            @if($unreadWargaPesan > 0)
                <span class="absolute top-4 right-4 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
            @endif
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Kotak Masuk</h3>
            <p class="text-sm text-slate-500">Pemberitahuan dari Admin Desa.</p>
        </a>

        <a href="#" class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Pusat Bantuan</h3>
            <p class="text-sm text-slate-500">Hubungi perangkat desa jika ada kendala.</p>
        </a>

    </div>
</div>
@endsection