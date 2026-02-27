@extends('layouts.admin') 
@section('title', 'Kelola Master Lembaga')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="text-sm text-gray-500 mb-1">Info Desa <span class="mx-1">&rsaquo;</span> <span class="text-emerald-600 font-semibold">Master Lembaga</span></div>
            <h2 class="text-2xl font-bold text-gray-800">Kelola Data Lembaga Masyarakat</h2>
        </div>
        <a href="{{ route('admin.lembaga.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center gap-2 transition duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Lembaga
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @php
        $totalLembaga = \App\Models\KelompokMaster::count();
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">TOTAL LEMBAGA</p>
            <h3 class="text-4xl font-black text-gray-800">{{ $totalLembaga }}</h3>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider mb-2">AKTIF</p>
            <h3 class="text-4xl font-black text-emerald-600">{{ $totalLembaga }}</h3>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col justify-center">
            <p class="text-xs font-bold text-rose-500 uppercase tracking-wider mb-2">NON-AKTIF</p>
            <h3 class="text-4xl font-black text-rose-600">0</h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Cari nama lembaga..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <div class="flex gap-4">
                <select class="border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block py-2.5 px-4 outline-none">
                    <option value="">Semua Kategori</option>
                    <option value="Sosial">Sosial</option>
                    <option value="Pendidikan">Pendidikan</option>
                </select>
                <button class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 px-6 rounded-lg text-sm transition">
                    Filter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Lembaga</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($lembaga as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm border border-emerald-100">
                                        {{ substr($item->singkatan ?? $item->nama, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->singkatan ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-semibold border border-blue-100">
                                    {{ $item->jenis ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.lembaga.show', $item->id) }}" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.lembaga.edit', $item->id) }}" class="text-amber-500 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 p-2 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.lembaga.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data lembaga ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Belum ada data lembaga. Klik "Tambah Lembaga" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
