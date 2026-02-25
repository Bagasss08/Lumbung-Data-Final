@extends('layouts.admin')

@section('title', $kelompok->nama)

@section('content')

{{-- Alert --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

{{-- Breadcrumb --}}
<div class="mb-6 flex items-center justify-between">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.kelompok.index') }}" class="hover:text-emerald-600 transition">Data Kelompok</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">{{ $kelompok->nama }}</span>
    </nav>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.kelompok.edit', $kelompok) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white text-sm font-medium rounded-xl hover:bg-amber-600 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit
        </a>
        <a href="{{ route('admin.kelompok.anggota.index', $kelompok) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Kelola Anggota
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Info Utama --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Identitas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800">Identitas Kelompok</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Nama</dt>
                        <dd class="font-semibold text-gray-800">{{ $kelompok->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Singkatan</dt>
                        <dd class="text-gray-700">{{ $kelompok->singkatan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Jenis Kelompok</dt>
                        <dd>
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                                {{ optional($kelompok->master)->nama ?? '-' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Tanggal Terbentuk
                        </dt>
                        <dd class="text-gray-700">{{ $kelompok->tgl_terbentuk ?
                            $kelompok->tgl_terbentuk->translatedFormat('d F Y') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Telepon</dt>
                        <dd class="text-gray-700">{{ $kelompok->telepon ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Status</dt>
                        <dd>
                            @if($kelompok->aktif === '1')
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-700 text-xs font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Tidak Aktif
                            </span>
                            @endif
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Alamat Sekretariat
                        </dt>
                        <dd class="text-gray-700">{{ $kelompok->alamat ?? '-' }}</dd>
                    </div>
                    @if($kelompok->keterangan)
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Keterangan</dt>
                        <dd class="text-gray-700">{{ $kelompok->keterangan }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- SK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800">Surat Keputusan</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">No. SK Desa</dt>
                        <dd class="text-gray-700">{{ $kelompok->sk_desa ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Tanggal SK Desa</dt>
                        <dd class="text-gray-700">{{ $kelompok->tgl_sk_desa ?
                            $kelompok->tgl_sk_desa->translatedFormat('d F Y') : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">No. SK Kabupaten</dt>
                        <dd class="text-gray-700">{{ $kelompok->sk_kabupaten ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Tanggal SK Kabupaten
                        </dt>
                        <dd class="text-gray-700">{{ $kelompok->tgl_sk_kabupaten ?
                            $kelompok->tgl_sk_kabupaten->translatedFormat('d F Y') : '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>

    {{-- Sidebar kanan --}}
    <div class="space-y-6">

        {{-- Ketua --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Ketua Kelompok</h3>
            </div>
            <div class="p-6 flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xl font-bold shadow-md">
                    {{ strtoupper(substr($kelompok->nama_ketua ?? 'K', 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ $kelompok->nama_ketua ?? 'Belum Diatur' }}</p>
                    @if($kelompok->nik_ketua)
                    <p class="text-xs text-gray-400 mt-0.5">NIK: {{ $kelompok->nik_ketua }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Statistik</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Anggota</span>
                    <span class="font-bold text-xl text-emerald-600">{{ $kelompok->anggota->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Anggota Aktif</span>
                    <span class="font-semibold text-gray-800">{{ $kelompok->anggota->where('aktif','1')->count()
                        }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Tidak Aktif</span>
                    <span class="font-semibold text-gray-500">{{ $kelompok->anggota->where('aktif','0')->count()
                        }}</span>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-md">
            <p class="text-sm font-semibold mb-3">Aksi Cepat</p>
            <div class="space-y-2">
                <a href="{{ route('admin.kelompok.anggota.create', $kelompok) }}"
                    class="flex items-center gap-2 text-sm bg-white/20 hover:bg-white/30 rounded-xl px-3 py-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Anggota
                </a>
                <a href="{{ route('admin.kelompok.edit', $kelompok) }}"
                    class="flex items-center gap-2 text-sm bg-white/20 hover:bg-white/30 rounded-xl px-3 py-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Kelompok
                </a>
            </div>
        </div>

    </div>
</div>

{{-- Anggota Preview --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Anggota Aktif</h3>
        <a href="{{ route('admin.kelompok.anggota.index', $kelompok) }}"
            class="text-sm text-emerald-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="p-6">
        @php $anggotaAktif = $kelompok->anggota->where('aktif', '1')->take(6); @endphp
        @if($anggotaAktif->isEmpty())
        <p class="text-sm text-gray-400 text-center py-4">Belum ada anggota aktif.</p>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($anggotaAktif as $a)
            <div class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gray-50 hover:bg-emerald-50 transition">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-sm font-semibold">
                    {{ strtoupper(substr(optional($a->penduduk)->nama ?? $a->nik, 0, 1)) }}
                </div>
                <p class="text-xs text-center font-medium text-gray-700 leading-tight line-clamp-2">{{
                    optional($a->penduduk)->nama ?? $a->nik }}</p>
                @if($a->jabatan)
                <span class="text-xs text-emerald-600 font-medium">{{ $a->jabatan }}</span>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection