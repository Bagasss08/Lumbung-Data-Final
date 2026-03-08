@extends('layouts.admin')

@section('title', 'Detail Perangkat Desa')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Perangkat Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Informasi lengkap perangkat desa</p>
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
            <a href="{{ route('admin.pemerintah-desa.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Pemerintah Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Detail</span>
        </nav>
        <div class="flex gap-2">
            <a href="{{ route('admin.pemerintah-desa.edit', $pemerintahDesa) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.pemerintah-desa.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kartu Profil ──────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 flex flex-col items-center text-center gap-4">

        {{-- Foto --}}
        <div class="w-32 h-32 rounded-2xl overflow-hidden bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-100 dark:border-emerald-800">
            @if($pemerintahDesa->foto)
            <img src="{{ asset('storage/' . $pemerintahDesa->foto) }}" alt="{{ $pemerintahDesa->nama }}"
                class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-emerald-400">
                {{ strtoupper(substr($pemerintahDesa->nama, 0, 2)) }}
            </div>
            @endif
        </div>

        {{-- Nama & Jabatan --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ $pemerintahDesa->nama }}</h2>
            <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium mt-0.5">{{ $pemerintahDesa->jabatan->nama ?? '-' }}</p>
            <span
                class="inline-block mt-2 text-xs px-3 py-1 rounded-full
                {{ $pemerintahDesa->jabatan?->golongan === 'bpd' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' }}">
                {{ $pemerintahDesa->jabatan?->label_golongan ?? '-' }}
            </span>
        </div>

        {{-- Status Badge --}}
        <span class="px-4 py-1.5 rounded-full text-sm font-semibold {{ $pemerintahDesa->badge_status }}">
            {{ $pemerintahDesa->label_status }}
        </span>

    </div>

    {{-- ── Detail Info ────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Identitas --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">
                Identitas
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">NIK</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $pemerintahDesa->nik ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Urutan Tampil</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $pemerintahDesa->urutan }}</dd>
                </div>
            </dl>
        </div>

        {{-- Data SK --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">
                Surat Keputusan
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Nomor SK</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $pemerintahDesa->no_sk ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Tanggal SK</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        {{ $pemerintahDesa->tanggal_sk ? $pemerintahDesa->tanggal_sk->format('d F Y') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Periode</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $pemerintahDesa->periode }}</dd>
                </div>
                @if($pemerintahDesa->keterangan)
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Keterangan</dt>
                    <dd class="text-sm text-gray-700 dark:text-slate-300 mt-0.5 bg-gray-50 dark:bg-slate-700 rounded-xl p-3">
                        {{ $pemerintahDesa->keterangan }}
                    </dd>
                </div>
                @endif
            </dl>
        </div>

    </div>
</div>

@endsection

