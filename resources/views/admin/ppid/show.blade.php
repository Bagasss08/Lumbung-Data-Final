@extends('layouts.admin')

@section('title', 'Detail Dokumen PPID')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                Daftar Dokumen
                <span class="text-sm font-normal text-gray-400 dark:text-slate-500 ml-2">Lihat Data</span>
            </h2>
        </div>
        <div class="flex items-center gap-2">
            <nav class="flex items-center gap-1.5 text-sm mr-2">
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
                <a href="{{ route('admin.ppid.index') }}"
                   class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Daftar Dokumen
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Lihat Data</span>
            </nav>
            <a href="{{ route('admin.ppid.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-medium text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Kembali Ke Daftar Dokumen
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">

        {{-- Jenis Dokumen --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Jenis Dokumen</span>
            <span class="flex-1 text-sm text-gray-800 dark:text-slate-200">
                {{ $ppid->jenisDokumen?->nama ?? '-' }}
            </span>
        </div>

        {{-- Judul Dokumen --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Judul Dokumen</span>
            <span class="flex-1 text-sm text-gray-800 dark:text-slate-200 font-medium">
                {{ $ppid->judul_dokumen }}
            </span>
        </div>

        {{-- Retensi Dokumen --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Retensi Dokumen</span>
            <div class="flex-1">
                <div class="flex gap-3">
                    <div class="w-36 px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 text-sm text-gray-700 dark:text-slate-300">
                        {{ $ppid->retensi_nilai ?? ($ppid->waktu_retensi ? '' : '0') }}
                    </div>
                    <div class="flex-1 px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 text-sm text-gray-700 dark:text-slate-300">
                        @if($ppid->retensi_satuan)
                            {{ $ppid->retensi_satuan }}
                        @elseif($ppid->waktu_retensi)
                            {{ $ppid->waktu_retensi }}
                        @else
                            Hari
                        @endif
                    </div>
                </div>
                <p class="text-xs text-red-500 mt-1.5">Isi 0 jika tidak digunakan.</p>
            </div>
        </div>

        {{-- Tipe Dokumen --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Tipe Dokumen</span>
            <div class="flex-1 px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-sm text-gray-700 dark:text-slate-300 w-full sm:w-auto">
                {{ ucfirst($ppid->tipe_dokumen ?? 'File') }}
            </div>
        </div>

        {{-- Dokumen (preview) --}}
        @if($ppid->file_path)
        <div class="flex flex-col sm:flex-row sm:items-start gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0 pt-1">Dokumen</span>
            <div class="flex-1">
                <div class="w-14 h-14 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Unggah Dokumen (nama file) --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Unggah Dokumen</span>
            <div class="flex-1 flex gap-2 items-center">
                <div class="flex-1 px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 text-sm text-gray-600 dark:text-slate-400 break-all">
                    {{ basename($ppid->file_path) }}
                </div>
                <a href="{{ Storage::url($ppid->file_path) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lihat
                </a>
            </div>
        </div>
        @endif

        {{-- Keterangan --}}
        <div class="flex flex-col sm:flex-row sm:items-start gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0 pt-2">Keterangan</span>
            <div class="flex-1 px-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 text-sm text-gray-700 dark:text-slate-300 min-h-[72px]">
                {{ $ppid->keterangan ?? '-' }}
            </div>
        </div>

        {{-- Tanggal Terbit --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Tanggal Terbit</span>
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </span>
                <div class="pl-10 pr-4 py-2 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 text-sm text-gray-700 dark:text-slate-300">
                    {{ $ppid->tanggal_terbit ? $ppid->tanggal_terbit->format('d-m-Y') : '-' }}
                </div>
            </div>
        </div>

        {{-- Status Terbit --}}
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-6 py-4">
            <span class="sm:w-48 text-sm font-medium text-gray-500 dark:text-slate-400 flex-shrink-0">Status Terbit</span>
            <div class="flex rounded-lg overflow-hidden border border-gray-300 dark:border-slate-600 w-fit">
                @php $isAktif = in_array($ppid->status, ['aktif','terbit','ya','1',1]); @endphp
                <div class="{{ $isAktif ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-slate-700 text-gray-400' }} px-8 py-2.5 text-sm font-medium">
                    Ya
                </div>
                <div class="{{ !$isAktif ? 'bg-cyan-500 text-white' : 'bg-gray-100 dark:bg-slate-700 text-gray-400' }} px-8 py-2.5 text-sm font-medium border-l border-gray-300 dark:border-slate-600">
                    Tidak
                </div>
            </div>
        </div>

    </div>

@endsection