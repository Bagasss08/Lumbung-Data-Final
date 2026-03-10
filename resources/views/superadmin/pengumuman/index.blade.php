@extends('superadmin.layout.superadmin')

@section('title', 'Pengumuman Sistem')
@section('header', 'Daftar Pengumuman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden">
    <div class="p-5 md:px-8 md:py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Riwayat Pengumuman</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar broadcast yang telah dikirim ke pengguna.</p>
        </div>
        <a href="{{ route('superadmin.pengumuman.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors shadow-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Pengumuman
        </a>
    </div>

    @if(session('success'))
        <div class="mx-8 mt-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 text-sm font-bold rounded-r-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white text-gray-400 text-[11px] font-bold uppercase tracking-widest border-b border-gray-100">
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Judul Pengumuman</th>
                    <th class="px-8 py-4">Target Audiens</th>
                    <th class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-[14px]">
                @forelse($pengumumans as $p)
                <tr class="hover:bg-emerald-50/30 transition-colors">
                    <td class="px-8 py-5 text-gray-500">
                        {{ $p->created_at->format('d M Y') }}
                        <div class="text-xs text-gray-400">{{ $p->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="font-bold text-gray-800 mb-1">{{ $p->judul }}</div>
                        <div class="text-gray-500 text-xs truncate max-w-xs">{{ $p->isi }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold uppercase rounded-md">
                            {{ $p->target_role }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <form action="{{ route('superadmin.pengumuman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-12 text-center text-gray-400 font-medium">Belum ada pengumuman yang disebarkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pengumumans->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/30">{{ $pengumumans->links() }}</div>
    @endif
</div>
@endsection