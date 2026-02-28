@extends('layouts.admin')
@section('title', 'Daftar C-Desa')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar C-Desa</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola data buku C-Desa dan persil tanah warga</p>
        </div>
        <a href="{{ route('admin.pertanahan.c-desa.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-emerald-700 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total C-Desa</p>
                <p class="text-3xl font-bold text-gray-900">{{ $cdesa->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pemilik Warga Desa</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CDesa::where('jenis_pemilik', 'warga_desa')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pemilik Luar Desa</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\CDesa::where('jenis_pemilik', 'warga_luar')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center text-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-gray-800">Semua Data C-Desa</h2>
            
            <form action="{{ route('admin.pertanahan.c-desa.index') }}" method="GET" class="flex gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Cari No. C / Nama / NIK...">
                </div>
                <select name="per_page" class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 baris</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 baris</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 baris</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="bg-gray-50/50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="py-4 px-6 border-b border-gray-100 w-12 text-center">#</th>
                        <th class="py-4 px-6 border-b border-gray-100">No. C-Desa</th>
                        <th class="py-4 px-6 border-b border-gray-100">Nama di C-Desa</th>
                        <th class="py-4 px-6 border-b border-gray-100">Pemilik Asli</th>
                        <th class="py-4 px-6 border-b border-gray-100">NIK</th>
                        <th class="py-4 px-6 border-b border-gray-100 text-center">Jml Persil</th>
                        <th class="py-4 px-6 border-b border-gray-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($cdesa as $key => $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 text-center text-gray-500">{{ $cdesa->firstItem() + $key }}</td>
                        <td class="py-4 px-6 font-semibold text-gray-900">{{ $item->nomor_cdesa }}</td>
                        <td class="py-4 px-6 text-gray-700">{{ $item->nama_di_cdesa }}</td>
                        <td class="py-4 px-6 text-gray-700">
                            {{ $item->nama_pemilik }}
                            @if($item->jenis_pemilik == 'warga_luar')
                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-orange-100 text-orange-800">Luar Desa</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-gray-500">{{ $item->nik_pemilik }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->persil_count > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->persil_count }} Bidang
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.pertanahan.c-desa.show', $item->id) }}" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Detail & Persil</a>
                                
                                <form action="{{ route('admin.pertanahan.c-desa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus permanen data C-Desa beserta seluruh persilnya?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada data C-Desa</p>
                                <a href="{{ route('admin.pertanahan.c-desa.create') }}" class="mt-2 text-sm text-emerald-600 hover:text-emerald-700 font-medium">+ Tambah Data Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($cdesa->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $cdesa->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
