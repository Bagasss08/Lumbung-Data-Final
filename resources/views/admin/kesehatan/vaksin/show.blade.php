@extends('layouts.admin')
@section('title', 'Detail Vaksin')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.vaksin.index') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h3 class="text-base font-semibold text-gray-900">{{ $vaksin->nama_penerima }}</h3>
        <p class="text-sm text-gray-500">Detail vaksinasi</p>
    </div>
    <div class="ml-auto">
        <a href="{{ route('admin.kesehatan.vaksin.edit', $vaksin) }}"
            class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium bg-amber-100 text-amber-700 rounded-xl hover:bg-amber-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Data Penerima --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 px-6 py-5">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $vaksin->nama_penerima }}</h3>
            <p class="text-white/70 text-sm mt-0.5">{{ $vaksin->nik ?? 'NIK tidak tercatat' }}</p>
        </div>
        <div class="p-6 space-y-3">
            @foreach([
            ['Jenis Kelamin', $vaksin->jenis_kelamin === 'L' ? 'Laki-laki' : ($vaksin->jenis_kelamin === 'P' ?
            'Perempuan' : '-')],
            ['Tanggal Lahir', $vaksin->tgl_lahir ? $vaksin->tgl_lahir->format('d M Y') : '-'],
            ['Umur', $vaksin->umur ? $vaksin->umur . ' tahun' : '-'],
            ['Dusun', $vaksin->dusun ?? '-'],
            ['Alamat', $vaksin->alamat ?? '-'],
            ] as [$label, $value])
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500 flex-shrink-0">{{ $label }}</dt>
                <dd class="text-sm font-medium text-gray-800 text-right">{{ $value }}</dd>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Data Vaksinasi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-6 py-5">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $vaksin->jenis_vaksin }}</h3>
            @php $sb=['sudah'=>'bg-white/20 text-white','belum'=>'bg-red-200/30 text-white','tunda'=>'bg-amber-200/30
            text-white']; @endphp
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold mt-2 {{ $sb[$vaksin->status] ?? 'bg-white/20 text-white' }}">
                {{ $vaksin->status_label }}
            </span>
        </div>
        <div class="p-6 space-y-3">
            @foreach([
            ['Kategori', $vaksin->kategori_vaksin ?? '-'],
            ['Dosis', $vaksin->dosi_label],
            ['Tanggal Vaksin', $vaksin->tanggal_vaksin->format('d M Y')],
            ['Tempat Pelayanan', $vaksin->tempat_pelayanan ?? '-'],
            ['Petugas', $vaksin->petugas ?? '-'],
            ['Nomor Batch', $vaksin->batch_vaksin ?? '-'],
            ['No. Sertifikat', $vaksin->no_sertifikat ?? '-'],
            ] as [$label, $value])
            <div class="flex justify-between gap-4">
                <dt class="text-xs text-gray-500 flex-shrink-0">{{ $label }}</dt>
                <dd class="text-sm font-medium text-gray-800 text-right">{{ $value }}</dd>
            </div>
            @endforeach
            @if($vaksin->keterangan)
            <div class="pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400 mb-1">Keterangan</p>
                <p class="text-sm text-gray-600">{{ $vaksin->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection