@extends('layouts.admin')

@section('title', 'Detail Calon Pemilih')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.calon-pemilih.index') }}" class="hover:text-emerald-600 transition-colors">Calon
        Pemilih</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium">{{ $calonPemilih->nama }}</span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Profile Card --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Cover --}}
            <div class="h-20 bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700"></div>
            {{-- Avatar --}}
            <div class="px-6 pb-6 -mt-10">
                <div
                    class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg mb-4 border-4 border-white
                    {{ $calonPemilih->jenis_kelamin == 1 ? 'bg-gradient-to-br from-blue-400 to-blue-600' : 'bg-gradient-to-br from-pink-400 to-pink-600' }}">
                    {{ strtoupper(substr($calonPemilih->nama, 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold text-gray-900">{{ $calonPemilih->nama }}</h3>
                <p class="text-sm text-gray-500 mt-0.5">{{ $calonPemilih->jenis_kelamin_label }}</p>

                <div class="mt-4 space-y-2">
                    <div class="flex items-center gap-2">
                        @if($calonPemilih->aktif)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Aktif sebagai pemilih
                        </span>
                        @else
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Tidak aktif
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2">
                    <a href="{{ route('admin.calon-pemilih.edit', $calonPemilih) }}"
                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold rounded-xl transition-colors border border-amber-100">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.calon-pemilih.toggle-aktif', $calonPemilih) }}" method="POST"
                        class="flex-1">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-1.5 py-2 text-xs font-semibold rounded-xl transition-colors border
                                {{ $calonPemilih->aktif ? 'bg-red-50 hover:bg-red-100 text-red-600 border-red-100' : 'bg-green-50 hover:bg-green-100 text-green-700 border-green-100' }}">
                            {{ $calonPemilih->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Info --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Identitas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    Identitas
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                    $fields = [
                    ['label' => 'NIK', 'value' => $calonPemilih->nik, 'mono' => true],
                    ['label' => 'No. KK', 'value' => $calonPemilih->no_kk, 'mono' => true],
                    ['label' => 'Tempat Lahir', 'value' => $calonPemilih->tempat_lahir],
                    ['label' => 'Tanggal Lahir', 'value' => $calonPemilih->tanggal_lahir?->format('d F Y') .
                    ($calonPemilih->tanggal_lahir ? ' (' . $calonPemilih->umur . ' tahun)' : '')],
                    ['label' => 'Jenis Kelamin', 'value' => $calonPemilih->jenis_kelamin_label],
                    ['label' => 'Status Perkawinan', 'value' => $calonPemilih->status_perkawinan],
                    ];
                    @endphp
                    @foreach($fields as $f)
                    <div class="bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">{{ $f['label'] }}</p>
                        <p
                            class="text-sm font-medium text-gray-800 {{ isset($f['mono']) && $f['mono'] ? 'font-mono' : '' }}">
                            {{ $f['value'] ?? '—' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Alamat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Alamat
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-3 bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Alamat</p>
                        <p class="text-sm font-medium text-gray-800">{{ $calonPemilih->alamat ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-center">
                        <p class="text-xs text-gray-400 mb-1">RT</p>
                        <p class="text-lg font-bold text-gray-800 font-mono">{{ $calonPemilih->rt ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-center">
                        <p class="text-xs text-gray-400 mb-1">RW</p>
                        <p class="text-lg font-bold text-gray-800 font-mono">{{ $calonPemilih->rw ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-center">
                        <p class="text-xs text-gray-400 mb-1">Dusun</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $calonPemilih->dusun ?? '—' }}</p>
                    </div>
                </div>
                @if($calonPemilih->keterangan)
                <div class="mt-4 bg-blue-50 rounded-xl px-4 py-3 border border-blue-100">
                    <p class="text-xs text-blue-500 mb-1">Keterangan</p>
                    <p class="text-sm text-blue-800">{{ $calonPemilih->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection