@extends('layouts.app')
@section('title', 'Baca Pesan')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    
    <a href="{{ route('warga.pesan.index') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 font-medium mb-6">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Kotak Masuk
    </a>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100">
            <h1 class="text-2xl font-bold text-slate-800 mb-4">{{ $pesan->subjek }}</h1>
            
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($pesan->pengirim->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-800">{{ $pesan->pengirim->name ?? 'Admin Desa' }}</p>
                    <p class="text-xs text-slate-500">{{ $pesan->created_at->translatedFormat('l, d F Y - H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="p-8 text-slate-700 leading-relaxed min-h-[200px] whitespace-pre-wrap">
            {{ $pesan->isi_pesan }}
        </div>

        <div class="p-6 bg-slate-50 border-t border-slate-100">
            <a href="{{ route('warga.pesan.create', ['subject' => 'Re: ' . $pesan->subjek]) }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-medium hover:text-emerald-600 hover:border-emerald-300 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Balas Pesan Ini
            </a>
        </div>
    </div>
</div>
@endsection
    