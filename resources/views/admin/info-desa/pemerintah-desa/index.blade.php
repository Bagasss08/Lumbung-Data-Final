@extends('layouts.admin')

@section('title', 'Pemerintah Desa')

@section('content')

{{-- x-data wrapper agar $dispatch Alpine bekerja untuk modal hapus --}}
<div x-data>

{{-- ============================================================ --}}
{{-- + Breadcrumb + HEADER: Title kiri Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Pemerintah Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data perangkat dan BPD desa</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Pemerintah Desa</span>
        </nav>
        <a href="{{ route('admin.pemerintah-desa.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Perangkat
        </a>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STATS CARDS                                                  --}}
{{-- ============================================================ --}}
@php
$total = $perangkat->total();
$aktif = \App\Models\PerangkatDesa::where('status','1')->count();
$nonaktif = \App\Models\PerangkatDesa::where('status','2')->count();
$bpd = \App\Models\PerangkatDesa::whereHas('jabatan', function($q) { $q->where('golongan', 'bpd'); })->count();
@endphp
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    {{-- Total Perangkat --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Perangkat</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $total }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Aktif --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Aktif</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $aktif }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Non-Aktif --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Non-Aktif</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $nonaktif }}</p>
            </div>
            <div class="w-11 h-11 bg-red-50 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- BPD --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Anggota BPD</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $bpd }}</p>
            </div>
            <div class="w-11 h-11 bg-purple-50 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================ --}}
{{-- FILTER & SEARCH                                              --}}
{{-- ============================================================ --}}
<form method="GET" action="{{ route('admin.pemerintah-desa.index') }}"
    class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Search --}}
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-sm dark:bg-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
        </div>

        {{-- Filter Golongan --}}
        <select name="golongan"
            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-sm dark:bg-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
            <option value="">Semua Golongan</option>
            <option value="pemerintah_desa" {{ request('golongan')==='pemerintah_desa' ? 'selected' : '' }}>
                Pemerintah Desa</option>
            <option value="bpd" {{ request('golongan')==='bpd' ? 'selected' : '' }}>BPD</option>
        </select>

        {{-- Filter Status --}}
        <div class="flex gap-2">
            <select name="status"
                class="flex-1 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-sm dark:bg-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Aktif</option>
                <option value="2" {{ request('status')==='2' ? 'selected' : '' }}>Non-Aktif</option>
            </select>
            <button type="submit"
                class="px-4 py-2.5 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition">
                Filter
            </button>
            @if(request()->hasAny(['search','status','golongan']))
            <a href="{{ route('admin.pemerintah-desa.index') }}"
                class="px-3 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-slate-600 transition flex items-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            @endif
        </div>
    </div>
</form>

{{-- ============================================================ --}}
{{-- TABLE                                                        --}}
{{-- ============================================================ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
    @if($perangkat->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <p class="text-lg font-semibold text-gray-500 dark:text-slate-400">Belum ada data perangkat</p>
        <p class="text-sm mt-1 dark:text-slate-500">Klik tombol "Tambah Perangkat" untuk mulai menambahkan data.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Perangkat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Jabatan</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">No. SK</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Periode</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @foreach($perangkat as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                    {{-- No --}}
                    <td class="px-5 py-4 text-gray-400 dark:text-slate-500 font-medium">
                        {{ $perangkat->firstItem() + $index }}
                    </td>

                    {{-- Perangkat --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 bg-emerald-50 dark:bg-emerald-900/30">
                                @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div
                                    class="w-full h-full flex items-center justify-center text-emerald-500 dark:text-emerald-400 font-bold text-sm">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-slate-100">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">{{ $item->nik ?? '-' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Jabatan --}}
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-800 dark:text-slate-200">{{ $item->jabatan->nama ?? '-' }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $item->jabatan?->golongan === 'bpd'
                                ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' }}">
                            {{ $item->jabatan?->label_golongan ?? '-' }}
                        </span>
                    </td>

                    {{-- No SK --}}
                    <td class="px-5 py-4 text-gray-600 dark:text-slate-400">
                        {{ $item->no_sk ?? '-' }}
                    </td>

                    {{-- Periode --}}
                    <td class="px-5 py-4 text-gray-500 dark:text-slate-400 text-xs">
                        @if($item->periode_mulai)
                        {{ $item->periode_mulai->format('d/m/Y') }}
                        @if($item->periode_selesai)
                        <br>– {{ $item->periode_selesai->format('d/m/Y') }}
                        @endif
                        @else
                        -
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-4 text-center">
                        <button onclick="toggleStatus({{ $item->id }}, this)" data-status="{{ $item->status }}"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all {{ $item->badge_status }}">
                            {{ $item->label_status }}
                        </button>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            {{-- Detail --}}
                            <a href="{{ route('admin.pemerintah-desa.show', $item) }}"
                                title="Detail"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('admin.pemerintah-desa.edit', $item) }}"
                                title="Edit"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 border border-amber-100 dark:border-amber-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            {{-- Hapus — dispatch ke modal Alpine --}}
                            <button type="button"
                                title="Hapus"
                                @click="$dispatch('buka-modal-hapus', {
                                    action: '/admin/pemerintah-desa/{{ $item->id }}',
                                    nama: '{{ addslashes($item->nama) }}'
                                })"
                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-100 dark:border-red-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($perangkat->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 dark:border-slate-700">
        {{ $perangkat->links() }}
    </div>
    @endif
    @endif
</div>

{{-- Modal Hapus --}}
@include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection

@section('scripts')
<script>
    // ── Toggle Status ────────────────────────────────────────────
    function toggleStatus(id, btn) {
        fetch(`/admin/pemerintah-desa/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                || '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const isAktif = data.status === '1';
                btn.textContent  = isAktif ? 'Aktif' : 'Non-Aktif';
                btn.dataset.status = data.status;
                btn.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all '
                    + (isAktif ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400');
            }
        });
    }
</script>
@endsection

