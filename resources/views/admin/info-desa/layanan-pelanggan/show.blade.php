@extends('layouts.admin')
@section('title', $layananPelanggan->nama_layanan)

@section('content')

@include('admin.partials.modal-hapus')

<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.layanan-pelanggan.index') }}" class="hover:text-emerald-600 transition-colors">Layanan
        Pelanggan</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900 truncate max-w-xs">{{ $layananPelanggan->nama_layanan }}</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 flex-wrap mb-2">
                            <h2 class="text-xl font-bold text-gray-900">{{ $layananPelanggan->nama_layanan }}</h2>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $layananPelanggan->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $layananPelanggan->status === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ ucfirst($layananPelanggan->status) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            @if($layananPelanggan->kode_layanan)
                            <span class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">{{
                                $layananPelanggan->kode_layanan }}</span>
                            @endif
                            @if($layananPelanggan->jenis_layanan)
                            <span class="text-xs text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full font-medium">{{
                                $layananPelanggan->jenis_layanan }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.layanan-pelanggan.edit', $layananPelanggan) }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-xl text-sm font-medium transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" @click="$dispatch('buka-modal-hapus', {
                                action: '{{ route('admin.layanan-pelanggan.destroy', $layananPelanggan) }}',
                                nama: '{{ addslashes($layananPelanggan->nama_layanan) }}'
                            })"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 hover:border-red-300 hover:bg-red-50 text-gray-600 hover:text-red-600 rounded-xl text-sm font-medium transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($layananPelanggan->deskripsi)
            <div class="px-6 py-5 border-b border-gray-50">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</h4>
                <p class="text-sm text-gray-700 leading-relaxed">{{ $layananPelanggan->deskripsi }}</p>
            </div>
            @endif

            {{-- Info Grid --}}
            <div class="px-6 py-5 grid grid-cols-2 gap-4">
                @foreach([
                ['label'=>'Penanggung Jawab', 'val'=>$layananPelanggan->penanggung_jawab],
                ['label'=>'Waktu Penyelesaian','val'=>$layananPelanggan->waktu_penyelesaian],
                ['label'=>'Biaya','val'=>$layananPelanggan->biaya ?? 'Gratis'],
                ['label'=>'Dasar Hukum','val'=>$layananPelanggan->dasar_hukum],
                ] as $info)
                <div>
                    <p class="text-xs text-gray-400 font-medium mb-1">{{ $info['label'] }}</p>
                    <p class="text-sm text-gray-800 font-medium">{{ $info['val'] ?? '-' }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Persyaratan --}}
        @if($layananPelanggan->persyaratan)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Persyaratan
            </h4>
            <ol class="space-y-2">
                @foreach($layananPelanggan->persyaratan_array as $i => $syarat)
                <li class="flex items-start gap-3">
                    <span
                        class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">{{
                        $i + 1 }}</span>
                    <span class="text-sm text-gray-700 pt-0.5">{{ $syarat }}</span>
                </li>
                @endforeach
            </ol>
        </div>
        @endif

    </div>

    {{-- Kolom Kanan --}}
    <div class="space-y-5">

        {{-- Relasi Surat --}}
        @if($layananPelanggan->membutuhkan_surat)
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-purple-100">
            <h4 class="text-sm font-semibold text-purple-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Terhubung ke Surat
            </h4>
            @if($layananPelanggan->suratFormat)
            <p class="text-sm text-purple-700 font-medium">{{ $layananPelanggan->suratFormat->nama }}</p>
            @else
            <p class="text-sm text-gray-400">Surat ID #{{ $layananPelanggan->surat_format_id }}</p>
            @endif
        </div>
        @endif

        {{-- Meta --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Urutan</span>
                <span class="font-medium text-gray-800">{{ $layananPelanggan->urutan }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Dibuat</span>
                <span class="font-medium text-gray-800">{{ $layananPelanggan->created_at->translatedFormat('d M Y')
                    }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Diperbarui</span>
                <span class="font-medium text-gray-800">{{ $layananPelanggan->updated_at->translatedFormat('d M Y')
                    }}</span>
            </div>
        </div>

    </div>
</div>

@endsection