@extends('layouts.admin')

@section('title', 'Buku Lembaran Desa dan Berita Desa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Lembaran Desa & Berita Desa</h1>
            <p class="text-sm text-gray-500">Pencatatan peraturan desa yang telah diundangkan</p>
        </div>
        <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.create') }}" 
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
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Jenis & Tentang Peraturan</th>
                        <th class="px-6 py-4">Ditetapkan (No & Tgl)</th>
                        <th class="px-6 py-4 text-center">Lembaran Desa</th>
                        <th class="px-6 py-4 text-center">Berita Desa</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($lembaran as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $lembaran->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-normal min-w-[250px]">
                                <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">{{ $item->jenis_peraturan }}</span><br>
                                <span class="font-medium text-gray-800 mt-1 block">{{ $item->tentang }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $item->nomor_ditetapkan }}</span><br>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_ditetapkan)->translatedFormat('d F Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->nomor_diundangkan_lembaran)
                                    <span class="font-semibold text-gray-800">{{ $item->nomor_diundangkan_lembaran }}</span><br>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_diundangkan_lembaran)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->nomor_diundangkan_berita)
                                    <span class="font-semibold text-gray-800">{{ $item->nomor_diundangkan_berita }}</span><br>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_diundangkan_berita)->translatedFormat('d M Y') }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.edit', $item->id) }}" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.buku-administrasi.umum.lembaran-desa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Data Buku Lembaran dan Berita Desa belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lembaran->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $lembaran->links() }}
            </div>
        @endif
    </div>
@endsection