@extends('layouts.admin')

@section('title', 'Wilayah Administratif')

@section('content')

{{-- x-data wrapper agar $dispatch Alpine bekerja untuk modal hapus --}}
<div x-data>

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Wilayah Administratif</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Data dusun, RW, dan RT dalam wilayah desa</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Wilayah Administratif</span>
        </nav>
        <a href="{{ route('admin.info-desa.wilayah-administratif.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Dusun
        </a>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STATS CARDS                                                  --}}
{{-- ============================================================ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    {{-- Total Dusun --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Dusun</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $data['total_dusun'] }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total RW --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total RW</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $data['total_rw'] }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total RT --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total RT</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $data['total_rt'] }}</p>
            </div>
            <div class="w-11 h-11 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Total Penduduk --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Penduduk</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ number_format($data['total_penduduk']) }}</p>
            </div>
            <div class="w-11 h-11 bg-orange-50 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- TABLE                                                        --}}
{{-- ============================================================ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama Dusun</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kepala Wilayah</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">RW</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">RT</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">KK</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Laki-laki</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Perempuan</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($data['wilayah'] as $index => $wilayah)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                    <td class="px-5 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-5 py-4">
                        <span class="text-sm font-semibold text-gray-800 dark:text-slate-100">{{ $wilayah['nama'] }}</span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600 dark:text-slate-300">{{ $wilayah['kepala_wilayah'] }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-800">
                            RW {{ str_pad($wilayah['rw'], 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800">
                            RT {{ str_pad($wilayah['rt'], 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-center font-medium text-gray-700 dark:text-slate-300">
                        {{ number_format($wilayah['kk']) }}
                    </td>
                    <td class="px-5 py-4 text-sm text-center font-medium text-blue-600 dark:text-blue-400">
                        {{ number_format($wilayah['laki_laki']) }}
                    </td>
                    <td class="px-5 py-4 text-sm text-center font-medium text-pink-600 dark:text-pink-400">
                        {{ number_format($wilayah['perempuan']) }}
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300">
                            {{ number_format($wilayah['laki_laki'] + $wilayah['perempuan']) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            {{-- Edit --}}
                            <a href="{{ route('admin.info-desa.wilayah-administratif.edit', $wilayah['id'] ?? 1) }}"
                                title="Edit"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Hapus — dispatch ke modal Alpine --}}
                            <button type="button"
                                title="Hapus"
                                @click="$dispatch('buka-modal-hapus', {
                                    action: '/admin/info-desa/wilayah-administratif/{{ $wilayah['id'] ?? 1 }}',
                                    nama: '{{ addslashes($wilayah['nama']) }}'
                                })"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-100 dark:border-red-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-slate-300">Tidak ada data wilayah</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Mulai dengan menambahkan data wilayah baru</p>
                            </div>
                            <a href="{{ route('admin.info-desa.wilayah-administratif.create') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Dusun
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Hapus --}}
@include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection