@extends('layouts.admin')
@section('title', 'Pesan Terkirim')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesan Terkirim</h1>
            <p class="text-sm text-gray-500 mt-1">Riwayat pesan yang telah Anda kirimkan ke warga</p>
        </div>
        <a href="{{ route('admin.hubung-warga.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            Tulis Pesan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-emerald-700 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="py-4 px-6 w-1/4">Kepada (Penerima)</th>
                        <th class="py-4 px-6">Subjek & Cuplikan Pesan</th>
                        <th class="py-4 px-6 text-center w-32">Status Baca</th>
                        <th class="py-4 px-6 text-right w-48">Waktu Dikirim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pesan as $item)
                    <tr onclick="window.location='{{ route('admin.hubung-warga.show', $item->id) }}'" 
                        class="cursor-pointer hover:bg-gray-50 transition-colors bg-white">
                        
                        <td class="py-4 px-6 align-middle">
                            <p class="font-semibold text-gray-800">
                                {{ $item->penerima->name ?? 'Penerima Dihapus' }}
                            </p>
                            <span class="text-[10px] font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full mt-1 inline-block">Warga Desa</span>
                        </td>
                        <td class="py-4 px-6 align-middle">
                            <p class="text-sm">
                                <span class="font-semibold text-gray-800">{{ $item->subjek ?? 'Tanpa Subjek' }}</span>
                                <span class="text-gray-400 mx-1">-</span>
                                <span class="text-gray-500 truncate inline-block align-bottom max-w-md">{{ Str::limit(strip_tags($item->isi_pesan), 60) }}</span>
                            </p>
                        </td>
                        <td class="py-4 px-6 text-center align-middle">
                            @if($item->sudah_dibaca)
                                <span class="inline-flex items-center gap-1 text-emerald-600 text-xs font-semibold bg-emerald-50 px-2 py-1 rounded-md">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Dibaca
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-gray-500 text-xs font-medium bg-gray-100 px-2 py-1 rounded-md">
                                    Terkirim
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right align-middle text-xs text-gray-500">
                            {{ $item->created_at->diffForHumans() }}
                            <div class="text-[10px] text-gray-400 mt-0.5">{{ $item->created_at->format('d M Y, H:i') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada pesan yang Anda kirim.</p>
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