@extends('layouts.admin')

@section('title', 'Detail Perangkat Desa')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center justify-between">
        <div>
            <nav class="text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.pemerintah-desa.index') }}" class="hover:text-emerald-600">Pemerintah Desa</a>
                <span class="mx-1">›</span>
                <span class="text-emerald-600 font-medium">Detail</span>
            </nav>
            <p class="text-sm text-gray-500">Informasi lengkap perangkat desa</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pemerintah-desa.edit', $pemerintahDesa) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white text-sm font-semibold rounded-xl hover:bg-amber-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.pemerintah-desa.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Kartu Profil ──────────────────────────────────── --}}
        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center text-center gap-4">

            {{-- Foto --}}
            <div class="w-32 h-32 rounded-2xl overflow-hidden bg-emerald-50 border-2 border-emerald-100">
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
                <h2 class="text-xl font-bold text-gray-900">{{ $pemerintahDesa->nama }}</h2>
                <p class="text-sm text-emerald-600 font-medium mt-0.5">{{ $pemerintahDesa->jabatan->nama ?? '-' }}</p>
                <span
                    class="inline-block mt-2 text-xs px-3 py-1 rounded-full
                    {{ $pemerintahDesa->jabatan?->golongan === 'bpd' ? 'bg-blue-100 text-blue-600' : 'bg-emerald-100 text-emerald-700' }}">
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100">
                    Identitas
                </h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">NIK</dt>
                        <dd class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pemerintahDesa->nik ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Urutan Tampil</dt>
                        <dd class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pemerintahDesa->urutan }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Data SK --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 pb-3 border-b border-gray-100">
                    Surat Keputusan
                </h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Nomor SK</dt>
                        <dd class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pemerintahDesa->no_sk ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Tanggal SK</dt>
                        <dd class="text-sm font-semibold text-gray-800 mt-0.5">
                            {{ $pemerintahDesa->tanggal_sk ? $pemerintahDesa->tanggal_sk->format('d F Y') : '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Periode</dt>
                        <dd class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pemerintahDesa->periode }}</dd>
                    </div>
                    @if($pemerintahDesa->keterangan)
                    <div class="sm:col-span-2">
                        <dt class="text-xs text-gray-400 font-medium uppercase tracking-wider">Keterangan</dt>
                        <dd class="text-sm text-gray-700 mt-0.5 bg-gray-50 rounded-xl p-3">
                            {{ $pemerintahDesa->keterangan }}
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

        </div>
    </div>

</div>
@endsection