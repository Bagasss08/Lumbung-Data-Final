@extends('layouts.admin')

@section('title', 'Daftar Dokumen PPID')

@section('content')

{{-- x-data wrapper agar $dispatch Alpine bekerja untuk modal hapus --}}
<div x-data>

{{-- PAGE HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Daftar Dokumen</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola dokumen informasi publik desa</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Daftar Dokumen</span>
        </nav>
        <a href="{{ route('admin.ppid.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
    </div>
</div>

{{-- Alert --}}
@if (session('success'))
    <div class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-400 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="flex items-center gap-3 p-4 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- TOOLBAR --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 mb-6">
    <div class="flex flex-wrap items-end gap-4">

        <form method="GET" action="{{ route('admin.ppid.index') }}" class="flex flex-wrap gap-3 flex-1">

            {{-- Filter Tahun --}}
            <div class="min-w-[140px]">
                <select name="tahun" onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                           focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                    <option value="">Pilih Tahun</option>
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Bulan --}}
            <div class="min-w-[140px]">
                <select name="bulan" onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                           focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                    <option value="">Pilih Bulan</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                        <option value="{{ $i+1 }}" {{ request('bulan') == $i+1 ? 'selected' : '' }}>
                            {{ $bln }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Jenis Dokumen --}}
            <div class="min-w-[200px] flex-1">
                <select name="jenis_dokumen" onchange="this.form.submit()"
                    class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                           focus:ring-2 focus:ring-emerald-500 outline-none text-sm cursor-pointer">
                    <option value="">Pilih Jenis Dokumen</option>
                    @foreach($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis_dokumen') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(request()->hasAny(['tahun','bulan','jenis_dokumen']))
                <a href="{{ route('admin.ppid.index') }}"
                   class="px-3 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg hover:bg-gray-200 text-sm transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-32">AKSI</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">JENIS DOKUMEN</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">JUDUL DOKUMEN</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">WAKTU RETENSI</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">TANGGAL TERBIT</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">KETERANGAN</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">STATUS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">

                @forelse($dokumen as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">
                            {{ $dokumen->firstItem() + $loop->index }}
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5">
                                {{-- Detail --}}
                                <a href="{{ route('admin.ppid.show', $item) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.ppid.edit', $item) }}"
                                   class="p-1.5 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                {{-- Download --}}
                                @if($item->file_path)
                                    <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                       class="p-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg transition-colors" title="Download">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                @endif
                                {{-- Hapus --}}
                                <button type="button" title="Hapus" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.ppid.destroy', $item) }}',
                                    nama: '{{ addslashes($item->judul_dokumen) }}'
                                })" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700 dark:text-slate-300">
                            {{ $item->jenisDokumen?->nama ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-slate-200 max-w-xs">
                            <span class="line-clamp-2" title="{{ $item->judul_dokumen }}">
                                {{ $item->judul_dokumen }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400">
                            {{ $item->waktu_retensi ?? '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400">
                            {{ $item->tanggal_terbit ? $item->tanggal_terbit->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400 max-w-xs">
                            <span class="line-clamp-2">{{ $item->keterangan ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $item->status_badge }}">
                                {{ $item->status_label }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-slate-400 font-medium">Tidak ada data yang tersedia pada tabel ini</p>
                                <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah dokumen PPID baru</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($dokumen->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                Menampilkan {{ $dokumen->firstItem() }}–{{ $dokumen->lastItem() }} dari {{ $dokumen->total() }} data
            </p>
            {{ $dokumen->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>

{{-- Modal Hapus --}}
@include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection

