@extends('layouts.admin')

@section('title', 'Buku Ekspedisi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Buku Ekspedisi</h1>
            <p class="text-sm text-gray-500">Merekod penghantaran (pengiriman) surat keluar</p>
        </div>
        <a href="{{ route('admin.buku-administrasi.umum.ekspedisi.create') }}" 
           class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
            + Tambah Data Ekspedisi
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
                        <th class="px-6 py-4">Tarikh Penghantaran</th>
                        <th class="px-6 py-4">Tarikh & No. Surat</th>
                        <th class="px-6 py-4">Ditujukan Kepada</th>
                        <th class="px-6 py-4">Isi Ringkas Surat</th>
                        <th class="px-6 py-4 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($ekspedisi as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-center">{{ $ekspedisi->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-emerald-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $item->nomor_surat }}</span><br>
                                <span class="text-xs text-gray-500">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $item->tujuan }}</td>
                            <td class="px-6 py-4 whitespace-normal min-w-[200px]">
                                {{ $item->isi_singkat }}<br>
                                @if($item->keterangan)
                                    <span class="text-xs text-gray-500 mt-1 block">Ket: {{ $item->keterangan }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.buku-administrasi.umum.ekspedisi.edit', $item->id) }}" class="text-amber-500 hover:text-amber-600 bg-amber-50 hover:bg-amber-100 p-2 rounded transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.buku-administrasi.umum.ekspedisi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Pasti mahu memadam data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 p-2 rounded transition-colors">
                                            Padam
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Data Buku Ekspedisi belum ada lagi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($ekspedisi->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $ekspedisi->links() }}
            </div>
        @endif
    </div>
@endsection