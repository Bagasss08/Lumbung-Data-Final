@extends('layouts.admin')
@section('title', 'Detail Posyandu')

@section('content')

{{-- Sub-tab Pendataan --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-emerald-100 text-emerald-700">
        Posyandu
    </a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors text-gray-600 hover:bg-gray-100">
        Kesehatan Ibu &amp; Anak (KIA)
    </a>
</div>

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.pendataan.posyandu') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h3 class="text-base font-semibold text-gray-900">{{ $posyandu->nama_posyandu }}</h3>
        <p class="text-sm text-gray-500">Detail posyandu</p>
    </div>
    <div class="ml-auto flex gap-2">
        <a href="{{ route('admin.kesehatan.pendataan.posyandu.edit', $posyandu) }}"
            class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Info Card --}}
    <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-5">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $posyandu->nama_posyandu }}</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold mt-2
                {{ $posyandu->status_posyandu === 'aktif' ? 'bg-white/20 text-white' : 'bg-white/10 text-white/70' }}">
                {{ $posyandu->status_posyandu === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
            </span>
        </div>
        <div class="p-6 space-y-4">
            @php
            $details = [
            ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'label' =>
            'Dusun', 'value' => $posyandu->dusun ?? '-'],
            ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0
            001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Alamat', 'value' => $posyandu->alamat
            ?? '-'],
            ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label'
            => 'Hari Kegiatan', 'value' => $posyandu->hari_kegiatan ?? '-'],
            ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Jam Kegiatan', 'value' =>
            ($posyandu->jam_mulai && $posyandu->jam_selesai) ? substr($posyandu->jam_mulai,0,5).' -
            '.substr($posyandu->jam_selesai,0,5) : '-'],
            ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Penanggung
            Jawab', 'value' => $posyandu->penanggung_jawab ?? '-'],
            ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0
            015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016
            0z', 'label' => 'Jumlah Kader', 'value' => $posyandu->jumlah_kader . ' orang'],
            ];
            @endphp
            @foreach($details as $d)
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $d['icon'] }}" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">{{ $d['label'] }}</p>
                    <p class="text-sm font-medium text-gray-700">{{ $d['value'] }}</p>
                </div>
            </div>
            @endforeach
            @if($posyandu->keterangan)
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400 mb-1">Keterangan</p>
                <p class="text-sm text-gray-600">{{ $posyandu->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- KIA Terdaftar --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h4 class="text-sm font-semibold text-gray-900">KIA Terdaftar</h4>
                <p class="text-xs text-gray-500 mt-0.5">{{ $posyandu->kia->count() }} data</p>
            </div>
            <a href="{{ route('admin.kesehatan.pendataan.kia.create') }}?posyandu_id={{ $posyandu->id }}"
                class="text-xs font-medium text-emerald-600 hover:underline">+ Tambah KIA</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Ibu</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nama Anak</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">HPL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($posyandu->kia as $k)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.kesehatan.pendataan.kia.show', $k) }}"
                                class="text-sm font-medium text-emerald-600 hover:underline">{{ $k->nama_ibu }}</a>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $k->nama_anak ?? '-' }}</td>
                        <td class="px-6 py-3 text-center">
                            @php $badges = ['hamil'=>'bg-blue-50 text-blue-700','melahirkan'=>'bg-emerald-50
                            text-emerald-700','selesai'=>'bg-gray-100 text-gray-500']; @endphp
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badges[$k->status_kehamilan] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst($k->status_kehamilan) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $k->taksiran_lahir ?
                            $k->taksiran_lahir->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400">Belum ada data KIA di
                            posyandu ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection