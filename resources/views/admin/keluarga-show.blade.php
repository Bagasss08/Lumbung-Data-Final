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

        $statusDasarOptions = [
            2 => 'Meninggal',
            3 => 'Pindah',
            4 => 'Hilang',
            5 => 'Pergi',
        ];

        $statusKawinOptions = [
            1 => 'Belum Kawin',
            2 => 'Kawin',
            3 => 'Cerai Hidup',
            4 => 'Cerai Mati',
        ];
    @endphp

    {{-- ROOT WRAPPER — Alpine event hub --}}
    <div x-data="kkShow()" x-init="init()">

        {{-- ── PAGE HEADER ── --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Anggota Keluarga</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5 font-mono">{{ $keluarga->no_kk }}</p>
            </div>
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('admin.keluarga') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">Data Keluarga</a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Data Anggota Keluarga</span>
            </nav>
        </div>

        {{-- ── FLASH MESSAGES ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ═══════════════════════════════════════════
         SINGLE CARD — Buttons + Rincian + Daftar Anggota
        ════════════════════════════════════════════════ --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

            {{-- ── TOMBOL AKSI ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah Anggota --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Anggota
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="absolute left-0 top-full mt-1.5 w-60 z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">
                        <a href="{{ route('admin.keluarga.anggota.create', ['keluarga' => $keluarga, 'jenis' => 'lahir']) }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                            <div
                                class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
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
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-xs">Masuk / Pindah Datang</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">Penduduk pindah masuk</p>
                            </div>
                        </a>
                        <div class="border-t border-gray-100 dark:border-slate-700"></div>
                        <button type="button"
                            @click="open = false; $dispatch('buka-modal-dari-penduduk-row', {
    kkId: {{ $keluarga->id }},
    noKk: '{{ $keluarga->no_kk }}',
    anggota: {{ Js::from(
        $keluarga->anggota->map(
            fn($a) => [
                'nik' => $a->nik,
                'nama' => $a->nama,
                'hubungan' => $shdkMap[$a->kk_level] ?? 'Lainnya',
            ],
        ),
    ) }}
})"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                            <div
                                class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-xs">Dari Penduduk Ada</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">Penduduk sudah terdaftar</p>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- Kartu Keluarga --}}
                <a href="{{ route('admin.keluarga.cetak-kk', $keluarga) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Kartu Keluarga
                </a>

                {{-- Kembali --}}
                <a href="{{ route('admin.keluarga') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-all shadow-sm group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Keluarga
                </a>
            </div>

            {{-- ═══ RINCIAN KELUARGA ═══ --}}
            <div class="border-b border-gray-100 dark:border-slate-700">
                <div class="px-6 py-3 border-b border-gray-100 dark:border-slate-700">
                    <span class="text-sm font-bold text-gray-700 dark:text-slate-200">Rincian Keluarga</span>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-slate-700">

                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Nomor Kartu Keluarga (KK)</p>
                        <p
                            class="col-span-2 text-sm font-mono font-semibold text-gray-800 dark:text-slate-200 flex items-center gap-2">
                            <span>:</span>
                            {{ $keluarga->no_kk }}
                            @if (str_starts_with($keluarga->no_kk, '0'))
                                <span
                                    class="px-2 py-0.5 text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 rounded-full">Sementara</span>
                            @endif
                        </p>
                    </div>

                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Kepala Keluarga</p>
                        <div class="col-span-2 flex items-center gap-1.5">
                            <span class="text-sm text-gray-500">:</span>
                            @if ($keluarga->kepalaKeluarga)
                                <div class="flex items-center gap-2.5">
                                    @if ($keluarga->kepalaKeluarga->foto)
                                        <img src="{{ asset('storage/' . $keluarga->kepalaKeluarga->foto) }}"
                                            class="w-8 h-8 rounded-full object-cover border-2 border-emerald-200 dark:border-emerald-700">
                                    @else
                                        <div
                                            class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.penduduk.show', $keluarga->kepalaKeluarga) }}"
                                            class="text-sm font-semibold text-gray-900 dark:text-slate-100 hover:text-emerald-600 transition-colors">
                                            {{ $keluarga->kepalaKeluarga->nama }}
                                        </a>
                                        <p class="text-xs font-mono text-gray-400 dark:text-slate-500">
                                            {{ $keluarga->kepalaKeluarga->nik }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum ada kepala keluarga</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-3 px-6 py-3 items-start">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 pt-0.5">Alamat</p>
                        <div class="col-span-2 flex gap-1.5">
                            <span class="text-sm text-gray-500">:</span>
                            <div>
                                @if ($keluarga->wilayah)
                                    <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">
                                        RT {{ $keluarga->wilayah->rt ?? '—' }} / RW {{ $keluarga->wilayah->rw ?? '—' }} —
                                        Dusun {{ $keluarga->wilayah->dusun ?? '—' }}
                                    </p>
                                @endif
                                @if ($keluarga->alamat)
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $keluarga->alamat }}
                                    </p>
                                @endif
                                @if (!$keluarga->wilayah && !$keluarga->alamat)
                                    <p class="text-sm text-gray-400 italic">—</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        $programList = $keluarga->programPeserta ?? collect();
                        if ($programList->isEmpty() && isset($keluarga->programBantuan)) {
                            $programList = $keluarga->programBantuan;
                        }
                    @endphp
                    @if ($programList->isNotEmpty())
                        <div class="grid grid-cols-3 px-6 py-3 items-center">
                            <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Program Bantuan</p>
                            <div class="col-span-2 flex items-center gap-1.5">
                                <span class="text-sm text-gray-500">:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($programList as $program)
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded bg-teal-500 text-white">
                                            {{ $program->nama ?? ($program->program->nama ?? $program) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ═══ DAFTAR ANGGOTA KELUARGA ═══ --}}
            <div>
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-sm">Daftar Anggota Keluarga</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-12">
                                    NO</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    AKSI</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NIK</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NAMA</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    TANGGAL LAHIR</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    JENIS KELAMIN</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    HUBUNGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($keluarga->anggota as $i => $anggota)
                                @php
                                    $isKepala = $anggota->id === $keluarga->kepala_keluarga_id;
                                @endphp
                                <tr
                                    class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors {{ $isKepala ? 'bg-emerald-50/60 dark:bg-emerald-900/10' : '' }}">

                                    <td
                                        class="px-4 py-3 text-center text-gray-400 dark:text-slate-500 tabular-nums text-xs">
                                        {{ $i + 1 }}</td>

                                    {{-- AKSI --}}
                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center gap-1">
                                            {{-- 1. Lihat detail --}}
                                            <a href="{{ route('admin.penduduk.show', $anggota) }}"
                                                title="Lihat Detail Biodata"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-blue-500 hover:bg-blue-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>

                                            {{-- 2. Ubah biodata --}}
                                            <a href="{{ route('admin.penduduk.edit', $anggota) }}"
                                                title="Ubah Biodata Penduduk"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            {{-- 3. Manajemen dokumen --}}
                                            <a href="{{ route('admin.penduduk.dokumen', $anggota) }}"
                                                title="Manajemen Dokumen"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>

                                            {{-- 4. Ubah status dasar --}}
                                            <button type="button" title="Ubah Status Dasar"
                                                @click="bukaUbahStatusDasar({
                                                    id: {{ $anggota->id }},
                                                    nama: '{{ addslashes($anggota->nama) }}',
                                                    isKepala: {{ $isKepala ? 'true' : 'false' }},
                                                    action: '{{ route('admin.penduduk.ubah-status-dasar', $anggota) }}'
                                                })"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-teal-500 hover:bg-teal-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>

                                            {{-- 5. Pecah KK (khusus kepala) --}}
                                            @if ($isKepala)
                                                <button type="button" title="Pecah Kartu Keluarga"
                                                    @click="bukaPecahKk({
                                                        action: '{{ route('admin.keluarga.pecah-kk', [$keluarga, $anggota]) }}'
                                                    })"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded bg-orange-500 hover:bg-orange-600 text-white transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </button>
                                            @endif

                                            {{-- 6. Buat KK Baru --}}
                                            <button type="button" title="Buat KK Baru"
                                                @click="bukaBuatKkBaru({
                                                    pendudukId: {{ $anggota->id }},
                                                    nama: '{{ addslashes($anggota->nama) }}',
                                                    nik: '{{ $anggota->nik }}',
                                                    action: '{{ route('admin.keluarga.buat-kk-baru.store', [$keluarga, $anggota]) }}'
                                                })"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-purple-500 hover:bg-purple-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>

                                            @if (!$isKepala)
                                                {{-- 7. Ubah hubungan keluarga --}}
                                                <button type="button" title="Ubah Hubungan Keluarga"
                                                    @click="bukaUbahHubungan({
                                                        id: {{ $anggota->id }},
                                                        nik: '{{ $anggota->nik }}',
                                                        nama: '{{ addslashes($anggota->nama) }}',
                                                        kkLevel: {{ $anggota->kk_level ?? 3 }},
                                                        action: '{{ route('admin.keluarga.anggota.ubah-hubungan', [$keluarga, $anggota]) }}'
                                                    })"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded bg-slate-600 hover:bg-slate-700 text-white transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                </button>

                                                {{-- 8. Bukan anggota keluarga ini --}}
                                                <button type="button" title="Bukan Anggota Keluarga Ini"
                                                    @click="bukaBukanAnggota({
                                                        nama: '{{ addslashes($anggota->nama) }}',
                                                        action: '{{ route('admin.keluarga.anggota.pecah', [$keluarga, $anggota]) }}'
                                                    })"
                                                    class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-500 hover:bg-red-600 text-white transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- NIK --}}
                                    <td
                                        class="px-4 py-3 font-mono text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                        {{ $anggota->nik ?? '—' }}
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            @if ($anggota->foto)
                                                <img src="{{ asset('storage/' . $anggota->foto) }}"
                                                    class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-slate-600 flex-shrink-0">
                                            @else
                                                <div
                                                    class="w-7 h-7 rounded-full bg-gray-200 dark:bg-slate-600 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.penduduk.show', $anggota) }}"
                                                    class="font-semibold text-gray-900 dark:text-slate-100 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors text-xs whitespace-nowrap">
                                                    {{ $anggota->nama }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- TANGGAL LAHIR --}}
                                    <td class="px-4 py-3 text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                        {{ $anggota->tanggal_lahir?->isoFormat('D MMMM YYYY') ?? '—' }}
                                    </td>

                                    {{-- JENIS KELAMIN --}}
                                    <td class="px-4 py-3 text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap">
                                        {{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>

                                    {{-- HUBUNGAN --}}
                                    <td
                                        class="px-4 py-3 text-xs font-semibold text-gray-700 dark:text-slate-200 whitespace-nowrap">
                                        {{ $shdkMap[$anggota->kk_level] ?? 'Lainnya' }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <p class="text-gray-400 dark:text-slate-500 text-sm">Belum ada anggota keluarga
                                            </p>
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

        </div>{{-- /single card --}}

        {{-- ══════════════════════════════════════════════════════════
         MODAL 2 — UBAH STATUS DASAR
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalStatusDasar.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalStatusDasar.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Ubah Status Dasar</h3>
                    <button @click="modalStatusDasar.open = false"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div
                    class="mx-5 mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-xl">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="text-xs text-amber-800 dark:text-amber-300 space-y-1">
                            <p class="font-bold">Catatan!</p>
                            <p>• Jika kepala keluarga meninggal, harap melakukan pemecahan Kartu Keluarga (KK) terlebih
                                dahulu.</p>
                            <p>• Jika terdapat keterangan lain terkait perubahan status dasar, harap diisi pada kolom
                                catatan peristiwa.</p>
                        </div>
                    </div>
                </div>

                <form method="POST" :action="modalStatusDasar.action">
                    @csrf
                    @method('PATCH')
                    <div class="p-5 space-y-4">

                        {{-- ── Custom Dropdown: Status Dasar ── --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Dasar Baru <span class="text-red-500">*</span>
                            </label>
                            <div x-data="{
                                open: false,
                                search: '',
                                selected: '',
                                options: [
                                    @foreach ($statusDasarOptions as $val => $label)
                                        { value: '{{ $val }}', label: '{{ $label }}' }, @endforeach
                                ],
                                get labelText() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false" class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors focus:outline-none"
                                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                    <span x-text="labelText || 'Pilih Status Dasar'"
                                        :class="labelText ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari status..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500 text-gray-700 dark:text-slate-200">
                                    </div>
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'"
                                                x-text="opt.label"></li>
                                        </template>
                                        <li x-show="filtered.length === 0"
                                            class="px-3 py-4 text-center text-sm text-gray-400 dark:text-slate-500">Tidak
                                            ada hasil</li>
                                    </ul>
                                </div>
                                <input type="hidden" name="status_dasar" :value="selected" required>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Peristiwa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tgl_peristiwa" required :value="modalStatusDasar.today"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Lapor
                            </label>
                            <input type="date" name="tgl_lapor" :value="modalStatusDasar.today"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Catatan Peristiwa
                            </label>
                            <textarea name="keterangan" rows="3" placeholder="Catatan"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none resize-none"></textarea>
                        </div>
                    </div>

                    <div
                        class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalStatusDasar.open = false"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════════════════════
         MODAL 3 — PECAH KK (Konfirmasi)
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalPecahKk.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalPecahKk.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden">

                <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Konfirmasi</h3>
                </div>

                <div class="p-5">
                    <div class="p-4 bg-emerald-500 rounded-xl text-white text-sm space-y-2">
                        <p>Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
                        <p>KK yang dipecah oleh Kepala Keluarga <strong>tidak dapat digunakan kembali serta semua anggota
                                keluarga akan ikut dipecah</strong>.</p>
                        <p>Apakah Anda yakin ingin melanjutkan proses ini?</p>
                    </div>
                </div>

                <div
                    class="flex justify-end gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                    <button type="button" @click="modalPecahKk.open = false"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 9l3 3m0 0l-3 3m3-3H8" />
                        </svg>
                        Tutup
                    </button>
                    <form method="POST" :action="modalPecahKk.action" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- ══════════════════════════════════════════════════════════
         MODAL 4 — BUAT KK BARU
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalBuatKk.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalBuatKk.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-2xl mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Buat KK Baru</h3>
                    <button @click="modalBuatKk.open = false"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="modalBuatKk.action">
                    @csrf
                    <div class="p-5 space-y-4">

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nomor Kartu Keluarga (KK) Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_kk" required maxlength="16" placeholder="Nomor KK"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Terdaftar <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tgl_terdaftar" required :value="modalBuatKk.today"
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>

                        {{-- Tabel anggota --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Anggota yang Ikut ke KK Baru
                            </label>
                            <div class="border border-gray-200 dark:border-slate-600 rounded-xl overflow-hidden">
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-slate-700/50">
                                            <th class="px-3 py-2.5 text-center w-10">PILIH</th>
                                            <th class="px-3 py-2.5 text-left">NIK</th>
                                            <th class="px-3 py-2.5 text-left">NAMA</th>
                                            <th class="px-3 py-2.5 text-left">HUBUNGAN</th>
                                            <th class="px-3 py-2.5 text-left">STATUS KAWIN</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                        @foreach ($keluarga->anggota as $anggota)
                                            @php $isKepalaRow = $anggota->id === $keluarga->kepala_keluarga_id; @endphp
                                            <tr
                                                class="hover:bg-gray-50 dark:hover:bg-slate-700/30 {{ $isKepalaRow ? 'bg-emerald-50/60 dark:bg-emerald-900/10' : '' }}">
                                                <td class="px-3 py-2 text-center">
                                                    <input type="checkbox" name="anggota_ids[]"
                                                        value="{{ $anggota->id }}"
                                                        {{ $isKepalaRow ? 'checked disabled' : '' }}
                                                        class="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500">
                                                </td>
                                                <td class="px-3 py-2 font-mono text-gray-500">{{ $anggota->nik }}</td>
                                                <td class="px-3 py-2 font-semibold text-gray-700 dark:text-slate-200">
                                                    {{ $anggota->nama }}
                                                    @if ($isKepalaRow)
                                                        <span
                                                            class="ml-1 px-1.5 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700 rounded-full">Kepala</span>
                                                    @endif
                                                </td>

                                                {{-- HUBUNGAN — Kepala KK dikunci, anggota lain pakai custom dropdown --}}
                                                <td class="px-3 py-2">
                                                    @if ($isKepalaRow)
                                                        {{-- Kepala Keluarga: locked, tidak bisa diubah --}}
                                                        <div
                                                            class="px-2 py-1 text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-700 rounded font-semibold">
                                                            Kepala Keluarga
                                                        </div>
                                                        <input type="hidden" name="kk_level[{{ $anggota->id }}]"
                                                            value="1">
                                                    @else
                                                        <div x-data="{
                                                            open: false,
                                                            search: '',
                                                            selected: '{{ $anggota->kk_level }}',
                                                            options: [
                                                                @foreach ($shdkMap as $v => $l)
                                                                    @if ($v !== 1)
                                                                        { value: '{{ $v }}', label: '{{ $l }}' },
                                                                    @endif @endforeach
                                                            ],
                                                            get labelText() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                                            get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                                                            choose(opt) {
                                                                this.selected = opt.value;
                                                                this.open = false;
                                                                this.search = '';
                                                            }
                                                        }" @click.away="open = false"
                                                            class="relative">
                                                            <button type="button" @click="open = !open"
                                                                class="w-full flex items-center justify-between px-2 py-1 border rounded text-xs bg-white dark:bg-slate-700 transition-colors focus:outline-none"
                                                                :class="open ? 'border-emerald-500 ring-1 ring-emerald-500/20' :
                                                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                                                <span x-text="labelText || '--'"
                                                                    class="text-gray-700 dark:text-slate-200"></span>
                                                                <svg class="w-3 h-3 text-gray-400 flex-shrink-0 transition-transform ml-1"
                                                                    :class="open ? 'rotate-180' : ''" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                            <div x-show="open"
                                                                class="absolute left-0 top-full mt-1 w-48 z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                                                style="display:none">
                                                                <div
                                                                    class="p-1.5 border-b border-gray-100 dark:border-slate-700">
                                                                    <input type="text" x-model="search"
                                                                        @keydown.escape="open = false"
                                                                        placeholder="Cari hubungan..."
                                                                        class="w-full px-2 py-1 text-xs bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500 text-gray-700 dark:text-slate-200">
                                                                </div>
                                                                <ul class="max-h-48 overflow-y-auto py-1">
                                                                    <template x-for="opt in filtered"
                                                                        :key="opt.value">
                                                                        <li @click="choose(opt)"
                                                                            class="px-3 py-2 text-xs cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700"
                                                                            :class="selected === opt.value ?
                                                                                'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                                                'text-gray-700 dark:text-slate-200'"
                                                                            x-text="opt.label"></li>
                                                                    </template>
                                                                    <li x-show="filtered.length === 0"
                                                                        class="px-3 py-3 text-center text-xs text-gray-400">
                                                                        Tidak ada hasil</li>
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" name="kk_level[{{ $anggota->id }}]"
                                                                :value="selected">
                                                        </div>
                                                    @endif
                                                </td>

                                                {{-- STATUS KAWIN — custom dropdown --}}
                                                <td class="px-3 py-2">
                                                    <div x-data="{
                                                        open: false,
                                                        search: '',
                                                        selected: '{{ $anggota->statusKawin->id ?? $anggota->status_kawin_id }}',
                                                        options: [
                                                            @foreach ($statusKawinOptions as $v => $l)
                                                                { value: '{{ $v }}', label: '{{ $l }}' }, @endforeach
                                                        ],
                                                        get labelText() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                                                        choose(opt) {
                                                            this.selected = opt.value;
                                                            this.open = false;
                                                            this.search = '';
                                                        }
                                                    }" @click.away="open = false"
                                                        class="relative">
                                                        <button type="button" @click="open = !open"
                                                            class="w-full flex items-center justify-between px-2 py-1 border rounded text-xs bg-white dark:bg-slate-700 transition-colors focus:outline-none"
                                                            :class="open ? 'border-emerald-500 ring-1 ring-emerald-500/20' :
                                                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                                            <span x-text="labelText || '--'"
                                                                class="text-gray-700 dark:text-slate-200"></span>
                                                            <svg class="w-3 h-3 text-gray-400 flex-shrink-0 transition-transform ml-1"
                                                                :class="open ? 'rotate-180' : ''" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>
                                                        <div x-show="open"
                                                            class="absolute left-0 top-full mt-1 w-44 z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                                            style="display:none">
                                                            <div
                                                                class="p-1.5 border-b border-gray-100 dark:border-slate-700">
                                                                <input type="text" x-model="search"
                                                                    @keydown.escape="open = false"
                                                                    placeholder="Cari status..."
                                                                    class="w-full px-2 py-1 text-xs bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500 text-gray-700 dark:text-slate-200">
                                                            </div>
                                                            <ul class="py-1">
                                                                <template x-for="opt in filtered" :key="opt.value">
                                                                    <li @click="choose(opt)"
                                                                        class="px-3 py-2 text-xs cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700"
                                                                        :class="selected === opt.value ?
                                                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                                            'text-gray-700 dark:text-slate-200'"
                                                                        x-text="opt.label"></li>
                                                                </template>
                                                                <li x-show="filtered.length === 0"
                                                                    class="px-3 py-3 text-center text-xs text-gray-400">
                                                                    Tidak ada hasil</li>
                                                            </ul>
                                                        </div>
                                                        <input type="hidden" name="status_kawin[{{ $anggota->id }}]"
                                                            :value="selected">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div
                        class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalBuatKk.open = false"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════════════════════
         MODAL 5 — UBAH HUBUNGAN KELUARGA
         (Tombol ini hanya muncul untuk non-kepala, jadi kepala tidak bisa mengubah hubungan)
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalHubungan.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalHubungan.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Ubah Hubungan Keluarga</h3>
                    <button @click="modalHubungan.open = false"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="modalHubungan.action">
                    @csrf
                    @method('PATCH')
                    <div class="p-5 space-y-4">

                        <div
                            class="divide-y divide-gray-100 dark:divide-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl overflow-hidden">
                            <div class="grid grid-cols-3 px-4 py-3 items-center">
                                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">NIK</p>
                                <p class="col-span-2 text-sm font-mono text-gray-700 dark:text-slate-200 flex gap-2">
                                    <span>:</span>
                                    <span x-text="modalHubungan.nik"></span>
                                </p>
                            </div>
                            <div class="grid grid-cols-3 px-4 py-3 items-center">
                                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Nama Penduduk</p>
                                <p class="col-span-2 text-sm font-semibold text-gray-700 dark:text-slate-200 flex gap-2">
                                    <span>:</span>
                                    <span x-text="modalHubungan.nama"></span>
                                </p>
                            </div>
                            <div class="grid grid-cols-3 px-4 py-3 items-center">
                                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Hubungan Keluarga</p>
                                <div class="col-span-2 flex items-center gap-2">
                                    <span class="text-sm text-gray-500">:</span>

                                    {{-- ── Custom Dropdown: Hubungan Keluarga ── --}}
                                    <div x-data="{
                                        open: false,
                                        search: '',
                                        selected: String(modalHubungan.kkLevel),
                                        options: [
                                            @foreach ($shdkMap as $val => $label)
                                                @if ($val !== 1)
                                                    { value: '{{ $val }}', label: '{{ $label }}' },
                                                @endif @endforeach
                                        ],
                                        get labelText() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                                        choose(opt) {
                                            this.selected = opt.value;
                                            this.open = false;
                                            this.search = '';
                                        }
                                    }" x-init="$watch('modalHubungan.kkLevel', val => { selected = String(val); })" @click.away="open = false"
                                        class="relative flex-1">
                                        <button type="button" @click="open = !open"
                                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors focus:outline-none"
                                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                            <span x-text="labelText || '-- Pilih --'"
                                                :class="labelText ? 'text-gray-800 dark:text-slate-200' :
                                                    'text-gray-400 dark:text-slate-500'"></span>
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 -translate-y-1"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 -translate-y-1"
                                            class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                            style="display:none">
                                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                                <input type="text" x-model="search" @keydown.escape="open = false"
                                                    placeholder="Cari hubungan..."
                                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500 text-gray-700 dark:text-slate-200">
                                            </div>
                                            <ul class="max-h-48 overflow-y-auto py-1">
                                                <template x-for="opt in filtered" :key="opt.value">
                                                    <li @click="choose(opt)"
                                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                        :class="selected === opt.value ?
                                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                            'text-gray-700 dark:text-slate-200'"
                                                        x-text="opt.label"></li>
                                                </template>
                                                <li x-show="filtered.length === 0"
                                                    class="px-3 py-4 text-center text-sm text-gray-400 dark:text-slate-500">
                                                    Tidak ada hasil</li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="kk_level" :value="selected" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div
                        class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalHubungan.open = false"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 9l3 3m0 0l-3 3m3-3H8" />
                            </svg>
                            Tutup
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════════════════════
         MODAL 6 — BUKAN ANGGOTA KELUARGA INI (Konfirmasi)
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalBukanAnggota.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalBukanAnggota.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">

                <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Konfirmasi</h3>
                </div>

                <div class="p-5">
                    <div class="p-4 bg-emerald-500 rounded-xl text-white text-sm">
                        <p>Apakah yakin akan dikeluarkan dari keluarga ini?</p>
                    </div>
                </div>

                <div
                    class="flex justify-end gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                    <button type="button" @click="modalBukanAnggota.open = false"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 9l3 3m0 0l-3 3m3-3H8" />
                        </svg>
                        Tutup
                    </button>
                    <form method="POST" :action="modalBukanAnggota.action" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Partial: Tambah Anggota dari Penduduk Sudah Ada --}}
        @include('admin.partials.modal-dari-penduduk-row')
    </div>{{-- end root x-data --}}


    {{-- ══════════════════════════════════════════════════════════════
     ALPINE JS — Centralized state & handlers
    ═══════════════════════════════════════════════════════════════════ --}}
    <script>
        window.shdkList = [
            @foreach ($shdkMap as $val => $label)
                {
                    id: {{ $val }},
                    nama: "{{ $label }}"
                },
            @endforeach
        ];

        window.pendudukLepas =
            {{ Js::from(
                $pendudukLepas->map(
                    fn($p) => [
                        'id' => $p->id,
                        'nik' => $p->nik,
                        'nama' => $p->nama,
                    ],
                ),
            ) }};

        function kkShow() {
            const today = new Date().toISOString().split('T')[0];

            return {
                // ── Modal: Ubah Status Dasar ─────────────────────
                modalStatusDasar: {
                    open: false,
                    action: '',
                    today: today,
                    nama: '',
                },
                bukaUbahStatusDasar({
                    id,
                    nama,
                    isKepala,
                    action
                }) {
                    this.modalStatusDasar.action = action;
                    this.modalStatusDasar.nama = nama;
                    this.modalStatusDasar.open = true;
                },

                // ── Modal: Pecah KK ──────────────────────────────
                modalPecahKk: {
                    open: false,
                    action: ''
                },
                bukaPecahKk({
                    action
                }) {
                    this.modalPecahKk.action = action;
                    this.modalPecahKk.open = true;
                },

                // ── Modal: Buat KK Baru ──────────────────────────
                modalBuatKk: {
                    open: false,
                    action: '',
                    pendudukId: null,
                    nama: '',
                    nik: '',
                    today: today
                },
                bukaBuatKkBaru({
                    pendudukId,
                    nama,
                    nik,
                    action
                }) {
                    this.modalBuatKk.pendudukId = pendudukId;
                    this.modalBuatKk.nama = nama;
                    this.modalBuatKk.nik = nik;
                    this.modalBuatKk.action = action;
                    this.modalBuatKk.open = true;
                },

                // ── Modal: Ubah Hubungan Keluarga ────────────────
                modalHubungan: {
                    open: false,
                    action: '',
                    id: null,
                    nik: '',
                    nama: '',
                    kkLevel: 3
                },
                bukaUbahHubungan({
                    id,
                    nik,
                    nama,
                    kkLevel,
                    action
                }) {
                    this.modalHubungan.id = id;
                    this.modalHubungan.nik = nik;
                    this.modalHubungan.nama = nama;
                    this.modalHubungan.kkLevel = kkLevel;
                    this.modalHubungan.action = action;
                    this.modalHubungan.open = true;
                },

                // ── Modal: Bukan Anggota ─────────────────────────
                modalBukanAnggota: {
                    open: false,
                    action: '',
                    nama: ''
                },
                bukaBukanAnggota({
                    nama,
                    action
                }) {
                    this.modalBukanAnggota.nama = nama;
                    this.modalBukanAnggota.action = action;
                    this.modalBukanAnggota.open = true;
                },

                // ── Init ─────────────────────────────────────────
                init() {},
            };
        }
    </script>

@endsection
