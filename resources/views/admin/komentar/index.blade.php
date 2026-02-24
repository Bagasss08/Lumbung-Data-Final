@extends('layouts.admin')

@section('title', 'Moderasi Komentar')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Moderasi Komentar</h1>
            <p class="mt-1 text-sm text-gray-500">Pilih komentar mana yang boleh tampil di halaman publik</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Komentar Masuk</h3>
        </div>

        <div class="overflow-x-auto">
            @if($komentars->count() > 0)
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Komentar & Artikel</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($komentars as $komentar)
                    <tr class="hover:bg-gray-50 {{ $komentar->status === 'pending' ? 'bg-yellow-50/30' : '' }}">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $komentar->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $komentar->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800 mb-1">"{{ $komentar->isi_komentar }}"</div>
                            <div class="text-xs text-emerald-600 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                {{ Str::limit($komentar->artikel->nama ?? 'Artikel telah dihapus', 40) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @if($komentar->status === 'pending')
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full border border-yellow-200">Menunggu</span>
                            @elseif($komentar->status === 'approved')
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full border border-green-200">Disetujui</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full border border-red-200">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-500">
                            {{ $komentar->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center justify-center gap-2">
                                @if($komentar->status !== 'approved')
                                <form action="{{ route('admin.komentar.approve', $komentar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Setujui agar tampil" class="text-green-600 hover:text-green-900 p-1.5 rounded-md hover:bg-green-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                                @endif

                                @if($komentar->status !== 'rejected')
                                <form action="{{ route('admin.komentar.reject', $komentar->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Tolak / Sembunyikan" class="text-amber-600 hover:text-amber-900 p-1.5 rounded-md hover:bg-amber-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.komentar.destroy', $komentar->id) }}" method="POST" onsubmit="return confirm('Hapus komentar ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" title="Hapus Permanen" class="text-red-600 hover:text-red-900 p-1.5 rounded-md hover:bg-red-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada komentar</h3>
                <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada komentar dari pengunjung.</p>
            </div>
            @endif
        </div>

        @if($komentars->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $komentars->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
