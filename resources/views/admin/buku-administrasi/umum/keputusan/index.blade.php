@extends('layouts.admin')

@section('title', 'Buku Keputusan Kepala Desa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Buku Keputusan Kepala Desa</h1>
            <p class="text-sm text-gray-500">Daftar administrasi keputusan kepala desa</p>
        </div>
        <a href="{{ route('admin.buku-administrasi.umum.keputusan.create') }}" 
           class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
            + Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm text-gray-600">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">No</th>
                        <th class="px-6 py-4">Nomor & Tgl Keputusan</th>
                        <th class="px-6 py-4">Tentang</th>
                        <th class="px-6 py-4">Uraian Singkat</th>
                        <th class="px-6 py-4">Dilaporkan (No & Tgl)</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($keputusan as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $keputusan->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $item->nomor_keputusan }}</span><br>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_keputusan)->translatedFormat('d F Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-normal min-w-[200px]">{{ $item->tentang }}</td>
                            <td class="px-6 py-4 whitespace-normal min-w-[200px]">{{ $item->uraian_singkat ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($item->nomor_dilaporkan)
                                    <span class="font-semibold text-gray-800">{{ $item->nomor_dilaporkan }}</span><br>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_dilaporkan)->translatedFormat('d F Y') }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-normal min-w-[150px]">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buku-administrasi.umum.keputusan.edit', $item->id) }}" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded transition-colors">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.buku-administrasi.umum.keputusan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Data Keputusan Kepala Desa belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($keputusan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $keputusan->links() }}
            </div>
        @endif
    </div>
@endsection