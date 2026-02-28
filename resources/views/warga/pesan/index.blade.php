@extends('layouts.app')

@section('title', 'Kotak Masuk')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kotak Masuk</h1>
            <p class="text-sm text-slate-500">Pesan dan Pemberitahuan dari Admin Desa.</p>
        </div>
        <a href="{{ route('warga.pesan.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 shadow-md">Tulis Pesan ke Admin</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <ul class="divide-y divide-slate-100">
            @forelse($pesan as $item)
                <li class="p-6 hover:bg-slate-50 transition cursor-pointer {{ $item->sudah_dibaca ? '' : 'bg-emerald-50/30' }}" onclick="window.location.href='{{ route('warga.pesan.show', $item->id) }}'">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold {{ $item->sudah_dibaca ? 'bg-slate-300' : 'bg-emerald-500 shadow-md shadow-emerald-200' }}">
                            {{ strtoupper(substr($item->pengirim->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-bold {{ $item->sudah_dibaca ? 'text-slate-700' : 'text-slate-900' }}">
                                    {{ $item->pengirim->name ?? 'Admin Desa' }}
                                </h3>
                                <span class="text-xs font-medium {{ $item->sudah_dibaca ? 'text-slate-400' : 'text-emerald-600' }}">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h4 class="text-sm font-semibold text-slate-800 mb-1">{{ $item->subjek }}</h4>
                            <p class="text-sm text-slate-500 line-clamp-1">{{ strip_tags($item->isi_pesan) }}</p>
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-12 text-center">
                    <svg class="w-16 h-16 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="text-lg font-bold text-slate-700">Kotak Masuk Kosong</h3>
                    <p class="text-sm text-slate-500">Anda belum menerima pesan apapun.</p>
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection