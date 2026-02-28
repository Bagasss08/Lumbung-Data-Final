@extends('layouts.admin')
@section('title', 'Baca Pesan')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="mb-6">
        @php
            $isKotakMasuk = $pesan->penerima_id === Auth::id();
            $backRoute = $isKotakMasuk ? route('admin.hubung-warga.inbox') : route('admin.hubung-warga.sent');
            $backLabel = $isKotakMasuk ? 'Kembali ke Kotak Masuk' : 'Kembali ke Pesan Terkirim';
        @endphp
        <a href="{{ $backRoute }}" class="inline-flex items-center text-gray-500 hover:text-emerald-600 font-medium text-sm transition-colors bg-white px-4 py-2 border border-gray-200 rounded-lg shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            {{ $backLabel }}
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-4">
                <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $pesan->subjek ?? '(Tanpa Subjek)' }}</h1>
                <div class="text-xs text-gray-500 font-medium whitespace-nowrap bg-gray-100 px-3 py-1.5 rounded-full">
                    {{ $pesan->created_at->translatedFormat('d F Y, H:i') }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-inner {{ $isKotakMasuk ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : 'bg-gradient-to-br from-emerald-500 to-teal-600' }}">
                    {{ strtoupper(substr($isKotakMasuk ? ($pesan->pengirim->name ?? 'U') : ($pesan->penerima->name ?? 'U'), 0, 1)) }}
                </div>
                
                <div class="flex-1">
                    @if($isKotakMasuk)
                        <p class="text-sm text-gray-600">Dari: <span class="font-bold text-gray-900">{{ $pesan->pengirim->name ?? 'Sistem' }}</span></p>
                        <p class="text-xs text-gray-400 mt-0.5">Kepada: Anda (Admin)</p>
                    @else
                        <p class="text-sm text-gray-600">Dari: <span class="font-bold text-gray-900">Anda (Admin)</span></p>
                        <p class="text-xs text-gray-400 mt-0.5">Kepada: <span class="text-gray-700 font-medium">{{ $pesan->penerima->name ?? 'Pengguna Dihapus' }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-8 text-gray-800 leading-relaxed whitespace-pre-wrap min-h-[250px] text-[15px]">
            {{ $pesan->isi_pesan }}
        </div>

        @if($isKotakMasuk && $pesan->pengirim_id)
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('admin.hubung-warga.create', ['reply_to' => $pesan->pengirim_id, 'subject' => 'Re: ' . $pesan->subjek]) }}" 
               class="inline-flex items-center justify-center px-6 py-2.5 bg-white border border-gray-300 text-gray-700 hover:text-emerald-600 hover:border-emerald-300 text-sm font-bold rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                Balas Pesan Ini
            </a>
        </div>
        @endif

    </div>
</div>
@endsection