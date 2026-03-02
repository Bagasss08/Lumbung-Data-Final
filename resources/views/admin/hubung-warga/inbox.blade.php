@extends('layouts.admin')
@section('title', 'Kotak Masuk')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kotak Masuk</h1>
            <p class="text-sm text-gray-500 mt-1">Pesan dari warga dan instansi eksternal</p>
        </div>
        <a href="{{ route('admin.hubung-warga.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Tulis Pesan Baru
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="py-4 px-6 w-12 text-center">Status</th>
                        <th class="py-4 px-6 w-1/4">Pengirim</th>
                        <th class="py-4 px-6">Subjek & Cuplikan Pesan</th>
                        <th class="py-4 px-6 text-right w-48">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesan as $item)
                    <tr onclick="window.location='{{ route('admin.hubung-warga.show', $item->id) }}'" 
                        class="cursor-pointer transition-colors {{ $item->sudah_dibaca ? 'bg-white hover:bg-gray-50' : 'bg-emerald-50/40 hover:bg-emerald-50/80' }}">
                        
                        <td class="py-4 px-6 text-center align-middle">
                            @if(!$item->sudah_dibaca)
                                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full mx-auto shadow-sm shadow-emerald-200"></div>
                            @else
                                <svg class="w-4 h-4 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                            @endif
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <p class="font-semibold {{ $item->sudah_dibaca ? 'text-gray-700' : 'text-gray-900' }}">
                                {{ $item->pengirim->name ?? 'Pengguna Dihapus' }}
                            </p>
                            @if($item->pengirim && $item->pengirim->role == 'warga')
                                <span class="text-[10px] font-medium bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full mt-1 inline-block">Warga Desa</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <p class="text-sm">
                                <span class="font-semibold {{ $item->sudah_dibaca ? 'text-gray-800' : 'text-gray-900' }}">{{ $item->subjek ?? 'Tanpa Subjek' }}</span>
                                <span class="text-gray-400 mx-1">-</span>
                                <span class="text-gray-500 truncate inline-block align-bottom max-w-md">{{ strip_tags($item->isi_pesan) }}</span>
                            </p>
                        </td>
                        <td class="py-4 px-6 text-right align-middle text-xs {{ $item->sudah_dibaca ? 'text-gray-500' : 'text-emerald-700 font-semibold' }}">
                            {{ $item->created_at->diffForHumans() }}
                            <div class="text-[10px] text-gray-400 font-normal mt-0.5">{{ $item->created_at->format('d M Y, H:i') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Kotak masuk Anda kosong.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pesan->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $pesan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection