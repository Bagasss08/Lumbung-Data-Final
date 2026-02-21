@extends('layouts.admin')
@section('title', 'Pemantauan Kesehatan')

@section('content')

@if(session('success'))
<div
    class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Dashboard Real-time --}}
<div class="mb-6">
    <h4 class="text-sm font-semibold text-gray-700 mb-3">Data Real-time</h4>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        @php
        $realtime = [
        ['label'=>'Ibu Hamil', 'value'=> $realtimeData['ibu_hamil'], 'color'=>'blue'],
        ['label'=>'Balita (0-5 thn)', 'value'=> $realtimeData['balita'], 'color'=>'emerald'],
        ['label'=>'Kasus Stunting', 'value'=> $realtimeData['stunting'], 'color'=>'red'],
        ['label'=>'Posyandu Aktif', 'value'=> $realtimeData['posyandu'], 'color'=>'teal'],
        ['label'=>'Sudah Vaksin', 'value'=> $realtimeData['vaksin'], 'color'=>'purple'],
        ];
        $colors = [
        'blue' =>'bg-blue-50 border-blue-100 text-blue-700',
        'emerald'=>'bg-emerald-50 border-emerald-100 text-emerald-700',
        'red' =>'bg-red-50 border-red-100 text-red-600',
        'teal' =>'bg-teal-50 border-teal-100 text-teal-700',
        'purple'=>'bg-purple-50 border-purple-100 text-purple-700',
        ];
        @endphp
        @foreach($realtime as $r)
        <div class="rounded-2xl border p-5 {{ $colors[$r['color']] ?? 'bg-white border-gray-200 text-gray-700' }}">
            <p class="text-xs font-medium opacity-70 mb-1">{{ $r['label'] }}</p>
            <p class="text-2xl font-bold">{{ number_format($r['value']) }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- Tabel Rekap Tahunan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div>
            <h3 class="text-base font-semibold text-gray-900">Rekap Kesehatan Tahunan</h3>
            <p class="text-sm text-gray-500 mt-0.5">Laporan tahunan kesehatan masyarakat</p>
        </div>
        <a href="{{ route('admin.kesehatan.pemantauan.rekap.create') }}"
            class="flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-md transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Rekap
        </a>
    </div>

    @if($rekap->count())
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th
                        class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase sticky left-0 bg-white">
                        Tahun</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Puskesmas</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Posyandu</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Dokter</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Bidan</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Ibu Hamil</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Balita</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">% Stunting</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">% Imunisasi</th>
                    <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($rekap as $r)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 sticky left-0 bg-white">
                        <span class="text-sm font-bold text-gray-900">{{ $r->tahun }}</span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_puskesmas ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_posyandu ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_dokter ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_bidan ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_ibu_hamil ?? '-' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 text-center">{{ $r->jumlah_balita ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        @if($r->prevalensi_stunting !== null)
                        <span
                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $r->prevalensi_stunting > 20 ? 'bg-red-50 text-red-700' : ($r->prevalensi_stunting > 10 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700') }}">
                            {{ $r->prevalensi_stunting }}%
                        </span>
                        @else <span class="text-sm text-gray-400">-</span> @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        @if($r->cakupan_imunisasi_dasar !== null)
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-16 bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full bg-emerald-500"
                                    style="width:{{ min($r->cakupan_imunisasi_dasar, 100) }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-700">{{ $r->cakupan_imunisasi_dasar }}%</span>
                        </div>
                        @else <span class="text-sm text-gray-400">-</span> @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.kesehatan.pemantauan.rekap.edit', $r) }}"
                                class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.kesehatan.pemantauan.rekap.destroy', $r) }}"
                                class="inline" onsubmit="return confirm('Hapus rekap tahun {{ $r->tahun }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="py-16 text-center">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-sm text-gray-400 font-medium">Belum ada rekap kesehatan tahunan</p>
        <a href="{{ route('admin.kesehatan.pemantauan.rekap.create') }}"
            class="mt-2 text-sm text-emerald-600 hover:underline inline-block">Tambah rekap pertama</a>
    </div>
    @endif
</div>
@endsection