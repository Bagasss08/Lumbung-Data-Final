@extends('layouts.admin')

@section('title', 'Detail Inventaris')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Detail Inventaris</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Informasi lengkap data inventaris desa</p>
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
            <a href="{{ route('admin.buku-administrasi.umum.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Buku Administrasi Umum
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Inventaris Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Detail</span>
        </nav>
        <div class="flex gap-2">
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.edit', $item) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Kartu Profil ──────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 flex flex-col items-center text-center gap-4">

        {{-- Avatar / Icon --}}
        <div class="w-32 h-32 rounded-2xl overflow-hidden bg-amber-50 dark:bg-amber-900/30 border-2 border-amber-100 dark:border-amber-800 flex items-center justify-center">
            <svg class="w-16 h-16 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
        </div>

        {{-- Nama & Info --}}
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-slate-100">{{ $item->nama_barang }}</h2>
            <p class="text-sm text-gray-500 dark:text-slate-400 font-mono mt-0.5">{{ $item->kode_barang }}</p>
            <div class="flex flex-wrap items-center justify-center gap-2 mt-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->kondisi_badge }}">
                    {{ $item->kondisi }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300">
                    {{ $item->kategori }}
                </span>
            </div>
        </div>

        {{-- Nilai Aset Highlight --}}
        <div class="w-full mt-4 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
            <p class="text-xs text-amber-600 dark:text-amber-400 font-medium mb-1">Total Nilai Aset</p>
            <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $item->harga_total_format }}</p>
            <p class="text-xs text-amber-500 dark:text-amber-500 mt-1">
                {{ rtrim(rtrim(number_format($item->jumlah, 2, ',', '.'), '0'), ',') }} {{ $item->satuan }}
                × {{ $item->harga_satuan_format }}
            </p>
        </div>

    </div>

    {{-- ── Detail Info ────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Identitas Barang --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-amber-100 dark:bg-amber-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                Identitas Barang
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Kode Barang</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5 font-mono">{{ $item->kode_barang }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Nama Barang</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->nama_barang }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Kategori</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->kategori }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Kondisi</dt>
                    <dd class="mt-0.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->kondisi_badge }}">
                            {{ $item->kondisi }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        {{-- Jumlah & Harga --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-emerald-100 dark:bg-emerald-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                Jumlah & Harga
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Jumlah</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">
                        {{ rtrim(rtrim(number_format($item->jumlah, 2, ',', '.'), '0'), ',') }} {{ $item->satuan }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Harga Satuan</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->harga_satuan_format }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Harga Total</dt>
                    <dd class="text-sm font-bold text-amber-600 dark:text-amber-400 mt-0.5">{{ $item->harga_total_format }}</dd>
                </div>
            </dl>
        </div>

        {{-- Detail Pengadaan & Lokasi --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-blue-100 dark:bg-blue-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                Detail Pengadaan & Lokasi
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Tahun Pengadaan</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->tahun_pengadaan ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Asal Usul</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->asal_usul ?? '-' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-gray-400 dark:text-slate-500 font-medium uppercase tracking-wider">Lokasi</dt>
                    <dd class="text-sm font-semibold text-gray-800 dark:text-slate-200 mt-0.5">{{ $item->lokasi ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Keterangan --}}
        @if($item->keterangan)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h3 class="text-sm font-bold text-gray-700 dark:text-slate-200 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100 dark:border-slate-700 flex items-center gap-2">
                <div class="w-5 h-5 bg-purple-100 dark:bg-purple-900/40 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                Keterangan
            </h3>
            <p class="text-sm text-gray-600 dark:text-slate-400 whitespace-pre-line">{{ $item->keterangan }}</p>
        </div>
        @endif

        {{-- Metadata --}}
        <div class="pt-4 border-t border-gray-100 dark:border-slate-700 flex flex-wrap items-center gap-4 text-xs text-gray-400 dark:text-slate-500">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dibuat: {{ $item->created_at->format('d M Y H:i') }}
            </div>
            @if($item->updated_at != $item->created_at)
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Diperbarui: {{ $item->updated_at->format('d M Y H:i') }}
            </div>
            @endif
        </div>

    </div>
</div>

@include('admin.partials.modal-hapus')
@endsection

