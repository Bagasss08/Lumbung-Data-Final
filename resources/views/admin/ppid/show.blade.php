@extends('layouts.admin')

@section('title', 'Detail Dokumen PPID')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Dokumen</h2>
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
                <a href="{{ route('admin.ppid.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    Daftar Dokumen
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Detail</span>
            </nav>
            <a href="{{ route('admin.ppid.edit', $ppid) }}"
               class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.ppid.index') }}"
               class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
            <h3 class="font-semibold text-gray-800 dark:text-slate-200">{{ $ppid->judul_dokumen }}</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Jenis Dokumen</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">{{ $ppid->jenisDokumen?->nama ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Status</dt>
                    <dd>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $ppid->status_badge }}">
                            {{ $ppid->status_label }}
                        </span>
                    </dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Tahun</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">{{ $ppid->tahun ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Bulan</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">{{ $ppid->nama_bulan ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Waktu Retensi</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">{{ $ppid->waktu_retensi ?? '-' }}</dd>
                </div>

                <div>
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Tanggal Terbit</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">
                        {{ $ppid->tanggal_terbit ? $ppid->tanggal_terbit->format('d F Y') : '-' }}
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">Keterangan</dt>
                    <dd class="text-sm text-gray-800 dark:text-slate-200">{{ $ppid->keterangan ?? '-' }}</dd>
                </div>

                @if($ppid->file_path)
                <div class="sm:col-span-2">
                    <dt class="text-xs font-semibold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-1">File Dokumen</dt>
                    <dd>
                        <a href="{{ Storage::url($ppid->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-lg hover:bg-emerald-100 transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download File
                        </a>
                    </dd>
                </div>
                @endif

            </dl>
        </div>
    </div>

@endsection

