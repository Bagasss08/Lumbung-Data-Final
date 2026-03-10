@extends('layouts.admin')
@section('title', 'Detail Mutasi Penduduk')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Mutasi Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">{{ $mutasiPenduduk->nama }}</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.edit', $mutasiPenduduk) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 text-sm font-medium rounded-xl hover:bg-amber-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <a href="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-slate-400 border border-gray-300 dark:border-slate-600 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- DATA DIRI --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">Data Diri</h3>
        <dl class="space-y-3">
            @foreach([
                ['NIK', $mutasiPenduduk->nik],
                ['Nama', $mutasiPenduduk->nama],
                ['Jenis Kelamin', $mutasiPenduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'],
                ['No. KK', $mutasiPenduduk->no_kk ?? '—'],
                ['Tempat Lahir', $mutasiPenduduk->tempat_lahir ?? '—'],
                ['Tanggal Lahir', $mutasiPenduduk->tanggal_lahir?->format('d/m/Y') ?? '—'],
                ['Agama', $mutasiPenduduk->agama ?? '—'],
            ] as [$label, $value])
            <div class="flex items-start justify-between gap-4">
                <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 w-32 flex-shrink-0">{{ $label }}</dt>
                <dd class="text-sm text-gray-900 dark:text-slate-100 text-right">{{ $value }}</dd>
            </div>
            @endforeach
        </dl>
    </div>

    {{-- DATA MUTASI --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">Data Mutasi</h3>
        <dl class="space-y-3">
            <div class="flex items-start justify-between gap-4">
                <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 w-32 flex-shrink-0">Jenis Mutasi</dt>
                <dd>
                    @if($mutasiPenduduk->jenis_mutasi == 'pindah_masuk')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Pindah Masuk</span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">Pindah Keluar</span>
                    @endif
                </dd>
            </div>
            @foreach([
                ['Tanggal Mutasi', $mutasiPenduduk->tanggal_mutasi->format('d/m/Y')],
                ['Asal', $mutasiPenduduk->asal ?? '—'],
                ['Tujuan', $mutasiPenduduk->tujuan ?? '—'],
                ['No. Surat', $mutasiPenduduk->no_surat ?? '—'],
                ['Alasan', $mutasiPenduduk->alasan ?? '—'],
                ['Keterangan', $mutasiPenduduk->keterangan ?? '—'],
            ] as [$label, $value])
            <div class="flex items-start justify-between gap-4">
                <dt class="text-xs font-medium text-gray-500 dark:text-slate-400 w-32 flex-shrink-0">{{ $label }}</dt>
                <dd class="text-sm text-gray-900 dark:text-slate-100 text-right">{{ $value }}</dd>
            </div>
            @endforeach
        </dl>
    </div>
</div>

@endsection