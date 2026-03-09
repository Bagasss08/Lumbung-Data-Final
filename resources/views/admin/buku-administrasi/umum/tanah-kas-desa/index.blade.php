@extends('layouts.admin')

@section('title', 'Buku Tanah Kas Desa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Buku Tanah Kas Desa</h1>
            <p class="text-sm text-gray-500">Kelola daftar inventaris tanah kas milik desa</p>
        </div>
        <a href="{{ route('admin.buku-administrasi.umum.tanah-kas-desa.create') }}" 
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
                        <th class="px-6 py-4">Asal Tanah & Perolehan</th>
                        <th class="px-6 py-4">No. Sertifikat & Luas</th>
                        <th class="px-6 py-4">Lokasi & Jenis</th>
                        <th class="px-6 py-4 text-center">Patok & Papan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($tanahKas as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $tanahKas->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $item->asal_tanah_kas_desa }}</span><br>
                                <span class="text-xs text-gray-500">{{ $item->asal_perolehan }} ({{ \Carbon\Carbon::parse($item->tanggal_perolehan)->translatedFormat('d M Y') }})</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $item->nomor_sertifikat ?? 'Belum ada SK' }}</span><br>
                                <span class="text-xs text-gray-500">Luas: {{ number_format($item->luas, 0, ',', '.') }} m² | Kelas: {{ $item->kelas ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $item->lokasi }}<br>
                                <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">{{ $item->jenis_tanah }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs {{ $item->status_patok == 'Ada' ? 'text-green-600' : 'text-red-500' }}">Patok: {{ $item->status_patok }}</span><br>
                                <span class="text-xs {{ $item->status_papan_nama == 'Ada' ? 'text-green-600' : 'text-red-500' }}">Papan: {{ $item->status_papan_nama }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buku-administrasi.umum.tanah-kas-desa.edit', $item->id) }}" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.buku-administrasi.umum.tanah-kas-desa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                                Data Buku Tanah Kas Desa belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tanahKas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tanahKas->links() }}
            </div>
        @endif
    </div>
@endsection