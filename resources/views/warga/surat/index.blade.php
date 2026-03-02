@extends('layouts.app')

@section('title', 'Riwayat Surat Warga')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Layanan Surat Online</h1>
        <a href="{{ route('warga.surat.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-md inline-flex items-center gap-2">
            <span>+</span> Buat Permohonan Baru
        </a>
    </div>

    @if($riwayatSurat->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-slate-600">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Jenis Surat</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Keperluan</th>
                            <th class="py-4 px-6 font-semibold text-slate-600 text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-slate-600">Catatan Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($riwayatSurat as $surat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6 text-slate-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d M Y') }}<br>
                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($surat->created_at)->format('H:i') }} WIB</span>
                            </td>
                            <td class="py-4 px-6 text-slate-800 font-medium">
                                {{ $surat->jenisSurat->nama_jenis_surat ?? 'Lainnya' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs truncate" title="{{ $surat->keperluan }}">
                                {{ $surat->keperluan }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $bg = 'bg-slate-100'; $text = 'text-slate-700';
                                    if($surat->status == 'belum lengkap') { $bg = 'bg-red-100'; $text = 'text-red-700'; }
                                    elseif($surat->status == 'sedang diperiksa') { $bg = 'bg-yellow-100'; $text = 'text-yellow-700'; }
                                    elseif($surat->status == 'menunggu tandatangan') { $bg = 'bg-blue-100'; $text = 'text-blue-700'; }
                                    elseif($surat->status == 'siap diambil') { $bg = 'bg-emerald-100'; $text = 'text-emerald-700'; }
                                    elseif($surat->status == 'sudah diambil') { $bg = 'bg-green-100'; $text = 'text-green-700'; }
                                    elseif($surat->status == 'dibatalkan') { $bg = 'bg-rose-100'; $text = 'text-rose-700'; }
                                @endphp
                                <span class="px-3 py-1 {{ $bg }} {{ $text }} rounded-full text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                                    {{ $surat->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-500 italic">
                                {{ $surat->catatan_petugas ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Riwayat Surat</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Anda belum pernah mengajukan permohonan surat apapun. Silakan buat permohonan baru jika diperlukan.
            </p>
        </div>
    @endif
</div>
@endsection
