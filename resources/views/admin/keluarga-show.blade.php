@extends('layouts.admin')

@section('title', 'Rincian Keluarga ' . $keluarga->no_kk)

@section('content')

@php
$shdkMap = [
    1 => 'Kepala Keluarga',
    2 => 'Suami/Istri',
    3 => 'Anak',
    4 => 'Menantu',
    5 => 'Cucu',
    6 => 'Orang Tua',
    7 => 'Mertua',
    8 => 'Famili Lain',
    9 => 'Pembantu',
    10 => 'Lainnya',
];
@endphp

<div x-data="{}">

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Rincian Kartu Keluarga</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5 font-mono">{{ $keluarga->no_kk }}</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.keluarga') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">Data Keluarga</a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Rincian KK</span>
        </nav>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
             class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-5">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
             class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-5">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
    @endif

    {{-- ═══ AKSI UTAMA ═══ --}}
    <div class="flex flex-wrap items-center gap-2 mb-5">

        {{-- Tambah Anggota dropdown --}}
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Anggota
                <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-transition
                 class="absolute left-0 top-full mt-1.5 w-60 z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                 style="display:none">
                <a href="{{ route('admin.keluarga.anggota.create', ['keluarga' => $keluarga, 'jenis' => 'lahir']) }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-xs">Anggota Lahir</p>
                        <p class="text-xs text-gray-400 dark:text-slate-500">Bayi baru lahir dalam KK</p>
                    </div>
                </a>
                <div class="border-t border-gray-100 dark:border-slate-700"></div>
                <a href="{{ route('admin.keluarga.anggota.create', ['keluarga' => $keluarga, 'jenis' => 'masuk']) }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-xs">Masuk / Pindah Datang</p>
                        <p class="text-xs text-gray-400 dark:text-slate-500">Penduduk pindah masuk</p>
                    </div>
                </a>
                <div class="border-t border-gray-100 dark:border-slate-700"></div>
                <button type="button"
                    @click="open=false; $dispatch('buka-modal-dari-penduduk')"
                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-xs">Dari Penduduk Ada</p>
                        <p class="text-xs text-gray-400 dark:text-slate-500">Penduduk sudah terdaftar</p>
                    </div>
                </button>
            </div>
        </div>

        {{-- Cetak KK --}}
        <a href="#" target="_blank"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Kartu Keluarga
        </a>

        {{-- Ubah KK --}}
        <a href="{{ route('admin.keluarga.edit', $keluarga) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Ubah Data KK
        </a>

        {{-- Kembali --}}
        <a href="{{ route('admin.keluarga') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali Ke Daftar Keluarga
        </a>

        {{-- Hapus KK --}}
        <button type="button"
            @click="$dispatch('buka-modal-hapus', {
                action: '{{ route('admin.keluarga.destroy', $keluarga) }}',
                nama: 'KK {{ $keluarga->no_kk }}'
            })"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus KK
        </button>
    </div>

    {{-- ═══ RINCIAN KELUARGA ═══ --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 mb-5">
        <div class="px-6 py-3 border-b border-gray-100 dark:border-slate-700 bg-emerald-50 dark:bg-emerald-900/20">
            <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Rincian Keluarga</span>
        </div>

        <div class="divide-y divide-gray-100 dark:divide-slate-700">

            <div class="grid grid-cols-3 px-6 py-3 items-center">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Nomor Kartu Keluarga</p>
                <p class="col-span-2 text-sm font-mono font-semibold text-gray-800 dark:text-slate-200 flex items-center gap-2">
                    {{ $keluarga->no_kk }}
                    @if(str_starts_with($keluarga->no_kk, '0'))
                        <span class="px-2 py-0.5 text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 rounded-full">Sementara</span>
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-3 px-6 py-3 items-center">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Kepala Keluarga</p>
                <div class="col-span-2">
                    @if($keluarga->kepalaKeluarga)
                        <div class="flex items-center gap-2.5">
                            @if($keluarga->kepalaKeluarga->foto)
                                <img src="{{ asset('storage/' . $keluarga->kepalaKeluarga->foto) }}"
                                     class="w-8 h-8 rounded-full object-cover border-2 border-emerald-200 dark:border-emerald-700">
                            @else
                                <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('admin.penduduk.show', $keluarga->kepalaKeluarga) }}"
                                   class="text-sm font-semibold text-gray-900 dark:text-slate-100 hover:text-emerald-600 transition-colors">
                                    {{ $keluarga->kepalaKeluarga->nama }}
                                </a>
                                <p class="text-xs font-mono text-gray-400 dark:text-slate-500">{{ $keluarga->kepalaKeluarga->nik }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada kepala keluarga</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 px-6 py-3 items-start">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide pt-0.5">Alamat</p>
                <div class="col-span-2">
                    @if($keluarga->wilayah)
                        <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">
                            RT {{ $keluarga->wilayah->rt ?? '—' }} / RW {{ $keluarga->wilayah->rw ?? '—' }} — Dusun {{ $keluarga->wilayah->dusun ?? '—' }}
                        </p>
                    @endif
                    @if($keluarga->alamat)
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $keluarga->alamat }}</p>
                    @endif
                    @if(!$keluarga->wilayah && !$keluarga->alamat)
                        <p class="text-sm text-gray-400 italic">—</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 px-6 py-3 items-center">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Tgl. Terdaftar</p>
                <p class="col-span-2 text-sm text-gray-700 dark:text-slate-300">
                    {{ $keluarga->tgl_terdaftar?->isoFormat('D MMMM YYYY') ?? '—' }}
                </p>
            </div>

            @if($keluarga->rumahTangga)
            <div class="grid grid-cols-3 px-6 py-3 items-center">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Rumah Tangga</p>
                <p class="col-span-2 text-sm font-mono font-semibold text-emerald-600 dark:text-emerald-400">
                    {{ $keluarga->rumahTangga->no_rumah_tangga }}
                </p>
            </div>
            @endif

            @if(isset($keluarga->programBantuan) && $keluarga->programBantuan->count())
            <div class="grid grid-cols-3 px-6 py-3 items-center">
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Program Bantuan</p>
                <div class="col-span-2 flex flex-wrap gap-1.5">
                    @foreach($keluarga->programBantuan as $bantuan)
                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                            {{ $bantuan->nama ?? $bantuan }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- ═══ DAFTAR ANGGOTA KELUARGA ═══ --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-sm">Daftar Anggota Keluarga</h3>
                <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">{{ $keluarga->anggota->count() }} anggota terdaftar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-32">AKSI</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NAMA</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TANGGAL LAHIR</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">JENIS KELAMIN</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">HUBUNGAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($keluarga->anggota as $i => $anggota)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors
                                   {{ $anggota->id === $keluarga->kepala_keluarga_id ? 'bg-emerald-50/60 dark:bg-emerald-900/10' : '' }}">

                            <td class="px-4 py-3 text-center text-gray-400 dark:text-slate-500 tabular-nums text-xs">{{ $i + 1 }}</td>

                            {{-- AKSI --}}
                            <td class="px-4 py-3">
                                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                    <button @click="open = !open"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                        Aksi
                                        <svg class="w-3 h-3 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition
                                         class="absolute left-0 top-full mt-1 w-52 z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                                         style="display:none">

                                        <a href="{{ route('admin.penduduk.show', $anggota) }}"
                                           class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Data Penduduk
                                        </a>

                                        <a href="{{ route('admin.penduduk.edit', $anggota) }}"
                                           class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Ubah Data Penduduk
                                        </a>

                                        <div class="border-t border-gray-100 dark:border-slate-700"></div>

                                        <a href="{{ route('admin.keluarga.buat-kk-baru.form', [$keluarga, $anggota]) }}"
                                           class="flex items-center gap-2.5 px-3 py-2.5 text-xs text-gray-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                            </svg>
                                            Buat KK Baru (Pecah)
                                        </a>

                                        @if($anggota->id !== $keluarga->kepala_keluarga_id)
                                            <div class="border-t border-gray-100 dark:border-slate-700"></div>
                                            <form method="POST" action="{{ route('admin.keluarga.anggota.pecah', [$keluarga, $anggota]) }}"
                                                  @submit.prevent="if(confirm('Keluarkan {{ addslashes($anggota->nama) }} dari KK ini?')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-full flex items-center gap-2.5 px-3 py-2.5 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                                                    </svg>
                                                    Keluarkan dari KK
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- NIK --}}
                            <td class="px-4 py-3 font-mono text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                {{ $anggota->nik ?? '—' }}
                            </td>

                            {{-- NAMA --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if($anggota->foto)
                                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                                             class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-slate-600 flex-shrink-0">
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-gray-200 dark:bg-slate-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.penduduk.show', $anggota) }}"
                                           class="font-semibold text-gray-900 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors text-xs whitespace-nowrap">
                                            {{ $anggota->nama }}
                                        </a>
                                        @if($anggota->id === $keluarga->kepala_keluarga_id)
                                            <span class="ml-1 px-1.5 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 rounded-full">Kepala</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- TANGGAL LAHIR --}}
                            <td class="px-4 py-3 text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                {{ $anggota->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '—' }}
                            </td>

                            {{-- JENIS KELAMIN --}}
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                    {{ $anggota->jenis_kelamin === 'L'
                                        ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'
                                        : 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300' }}">
                                    {{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>

                            {{-- HUBUNGAN --}}
                            <td class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-slate-200 whitespace-nowrap uppercase tracking-wide">
                                {{ $shdkMap[$anggota->kk_level] ?? 'Lainnya' }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-gray-400 dark:text-slate-500 text-sm">Belum ada anggota keluarga</p>
                                    <a href="{{ route('admin.keluarga.anggota.create', ['keluarga' => $keluarga, 'jenis' => 'masuk']) }}"
                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                        Tambah Anggota Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══ MODAL: DARI PENDUDUK SUDAH ADA ═══ --}}
    <div x-data="{
             open: false,
             search: '',
             selectedId: null,
             selectedNama: '',
             selectedNik: '',
             pendudukList: {{ Js::from($pendudukLepas->map(fn($p) => ['id' => $p->id, 'nik' => $p->nik, 'nama' => $p->nama, 'jenis_kelamin' => $p->jenis_kelamin])) }},
             get filtered() {
                 if (!this.search.trim()) return this.pendudukList;
                 const q = this.search.toLowerCase();
                 return this.pendudukList.filter(p => p.nama.toLowerCase().includes(q) || p.nik.includes(q));
             },
             pilih(p) { this.selectedId = p.id; this.selectedNama = p.nama; this.selectedNik = p.nik; }
         }"
         @buka-modal-dari-penduduk.window="open = true">

        <div x-show="open"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click.self="open = false"
             style="display:none">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-slate-100">Tambah dari Penduduk Sudah Ada</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Pilih penduduk yang akan ditambahkan ke KK ini</p>
                    </div>
                    <button @click="open = false"
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.keluarga.anggota.store-dari-penduduk', $keluarga) }}">
                    @csrf
                    <div class="p-5 space-y-4">

                        <div x-show="selectedId"
                             class="flex items-center justify-between gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl">
                            <div>
                                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300" x-text="selectedNama"></p>
                                <p class="text-xs font-mono text-emerald-600 dark:text-emerald-400" x-text="selectedNik"></p>
                            </div>
                            <button type="button" @click="selectedId=null; selectedNama=''; selectedNik=''"
                                class="text-xs text-red-500 hover:text-red-700 font-semibold px-2 py-1 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                Ganti
                            </button>
                        </div>

                        <div x-show="!selectedId">
                            @if($pendudukLepas->isEmpty())
                                <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-sm text-amber-700 dark:text-amber-300">Tidak ada penduduk lepas tersedia.</p>
                                </div>
                            @else
                                <div class="border border-gray-200 dark:border-slate-600 rounded-xl overflow-hidden">
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                                        <input type="text" x-model="search" placeholder="Cari nama atau NIK..."
                                            class="w-full px-3 py-2 text-sm bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                    </div>
                                    <ul class="max-h-52 overflow-y-auto divide-y divide-gray-100 dark:divide-slate-700">
                                        <template x-for="p in filtered" :key="p.id">
                                            <li @click="pilih(p)"
                                                class="flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-slate-100 truncate" x-text="p.nama"></p>
                                                    <p class="text-xs font-mono text-gray-400" x-text="p.nik"></p>
                                                </div>
                                                <span class="text-xs font-semibold px-1.5 py-0.5 rounded-full flex-shrink-0"
                                                    :class="p.jenis_kelamin==='L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'"
                                                    x-text="p.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                                            </li>
                                        </template>
                                        <li x-show="filtered.length === 0" class="px-4 py-6 text-center text-sm text-gray-400">Tidak ada hasil</li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <input type="hidden" name="penduduk_id" :value="selectedId">

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Hubungan Dalam Keluarga <span class="text-red-500">*</span>
                            </label>
                            <select name="kk_level" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="">-- Pilih Hubungan --</option>
                                @foreach($shdkMap as $val => $label)
                                    @if($val !== 1)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="open = false"
                            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-50 rounded-lg font-semibold text-sm transition-all">
                            Batal
                        </button>
                        <button type="submit" :disabled="!selectedId"
                            :class="selectedId ? 'bg-emerald-500 hover:bg-emerald-600 cursor-pointer' : 'bg-emerald-200 dark:bg-emerald-900/30 cursor-not-allowed opacity-60'"
                            class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tambahkan ke KK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.partials.modal-hapus')

</div>
@endsection