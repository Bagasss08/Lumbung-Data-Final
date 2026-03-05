@extends('layouts.admin')

@section('title', 'Detail Peraturan Desa')

@section('content')

@include('admin.partials.modal-hapus')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.buku-administrasi.umum.index') }}" class="hover:text-emerald-600 transition-colors">Buku Administrasi Umum</a>
    <span>/</span>
    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="hover:text-emerald-600 transition-colors">Peraturan Desa</a>
    <span>/</span>
    <span class="text-emerald-600 font-medium">Detail</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Info Utama --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Card Utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100 flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $peraturan_desa->judul }}</h2>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $peraturan_desa->is_aktif ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                            {{ $peraturan_desa->is_aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">{{ $peraturan_desa->jenis_peraturan }} · Diinput {{ $peraturan_desa->created_at->translatedFormat('d F Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.edit', $peraturan_desa) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <button type="button" @click="$dispatch('buka-modal-hapus', {
                            action: '{{ route('admin.buku-administrasi.umum.peraturan-desa.destroy', $peraturan_desa) }}',
                            nama: '{{ addslashes($peraturan_desa->judul) }}'
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

            {{-- Detail Utama --}}
            <div class="px-6 py-5">
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nomor Peraturan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $peraturan_desa->nomor_ditetapkan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Jenis Peraturan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $peraturan_desa->jenis_peraturan }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Tanggal Ditetapkan</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $peraturan_desa->tanggal_ditetapkan ? $peraturan_desa->tanggal_ditetapkan->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Dimuat Pada</p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $peraturan_desa->dimuat_pada ? $peraturan_desa->dimuat_pada->translatedFormat('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Uraian Singkat --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Uraian Singkat</h4>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $peraturan_desa->uraian_singkat ?? 'Tidak ada uraian singkat.' }}
            </p>
        </div>

    </div>

    {{-- Kolom Kanan: Meta --}}
    <div class="space-y-5">

        {{-- Info Peraturan --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Peraturan</h4>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500 text-sm">Jenis</span>
                    <span class="text-gray-900 font-medium text-sm">{{ $peraturan_desa->jenis_peraturan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 text-sm">Status</span>
                    <span class="text-sm font-medium {{ $peraturan_desa->is_aktif ? 'text-emerald-600' : 'text-gray-500' }}">
                        {{ $peraturan_desa->is_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Timestamp --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-sm space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">Ditambahkan</span>
                <span class="text-gray-700 font-medium">{{ $peraturan_desa->created_at->translatedFormat('d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Terakhir diubah</span>
                <span class="text-gray-700 font-medium">{{ $peraturan_desa->updated_at->translatedFormat('d M Y') }}</span>
            </div>
        </div>

    </div>

</div>

@endsection

