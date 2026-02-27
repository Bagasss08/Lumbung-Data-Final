@extends('layouts.admin')
@section('title', 'Pendaftaran Kerjasama')

@section('content')

@include('admin.partials.modal-hapus')

{{-- Flash --}}
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="mb-4 flex items-center gap-3 px-5 py-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="mb-4 flex items-center gap-3 px-5 py-3.5 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ session('error') }}
</div>
@endif

{{-- Peringatan hampir berakhir --}}
@if($stats['hampir_berakhir'] > 0)
<div
    class="mb-5 flex items-start gap-3 px-5 py-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm">
    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
    </svg>
    <div>
        <p class="font-semibold">{{ $stats['hampir_berakhir'] }} kerjasama akan berakhir dalam 30 hari</p>
        <p class="text-amber-700 text-xs mt-0.5">Segera tinjau dan perbarui perjanjian yang mendekati masa berakhir.</p>
    </div>
</div>
@endif

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <p class="text-sm text-gray-500">Data perjanjian kerjasama dan kemitraan desa dengan berbagai pihak.</p>
    <div class="flex items-center gap-2">
        @include('admin.partials.export-buttons', [
        'routeExcel' => 'admin.kerjasama.export.excel',
        'routePdf' => 'admin.kerjasama.export.pdf',
        ])
        <a href="{{ route('admin.kerjasama.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kerjasama
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
    ['label'=>'Total', 'val'=>$stats['total'], 'color'=>'emerald','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10
    0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0
    019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
    ['label'=>'Aktif', 'val'=>$stats['aktif'], 'color'=>'blue', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118
    0z'],
    ['label'=>'Berakhir', 'val'=>$stats['berakhir'], 'color'=>'gray', 'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
    002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['label'=>'Hampir Berakhir','val'=>$stats['hampir_berakhir'],'color'=>'amber','icon'=>'M12 9v2m0 4h.01m-6.938
    4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732
    2.5z'],
    ] as $s)
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-{{ $s['color'] }}-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-{{ $s['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}" />
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $s['val'] }}</p>
                <p class="text-xs text-gray-500">{{ $s['label'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama mitra atau nomor perjanjian..."
            class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
        <select name="jenis_mitra"
            class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
            <option value="">Semua Jenis Mitra</option>
            @foreach(\App\Models\Kerjasama::daftarJenisMitra() as $j)
            <option value="{{ $j }}" {{ request('jenis_mitra')===$j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
        <select name="status"
            class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status')==='aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="berakhir" {{ request('status')==='berakhir' ? 'selected' : '' }}>Berakhir</option>
            <option value="ditangguhkan" {{ request('status')==='ditangguhkan' ? 'selected' : '' }}>Ditangguhkan
            </option>
        </select>
        <button type="submit"
            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition-colors">Cari</button>
        @if(request()->hasAny(['search','jenis_mitra','status']))
        <a href="{{ route('admin.kerjasama.index') }}"
            class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors">Reset</a>
        @endif
    </form>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    @if($kerjasama->isEmpty() && !request()->hasAny(['search','jenis_mitra','status']))
    {{-- Empty State --}}
    <div class="py-16 px-8 text-center">
        <div
            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-teal-50 to-emerald-50 flex items-center justify-center mx-auto mb-5 border-2 border-dashed border-teal-200">
            <svg class="w-10 h-10 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h4 class="font-semibold text-gray-800 text-base mb-2">Belum ada data kerjasama</h4>
        <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6 leading-relaxed">
            Dokumentasikan perjanjian kerjasama desa dengan instansi pemerintah, swasta, LSM, dan mitra lainnya.
        </p>
        <a href="{{ route('admin.kerjasama.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Daftarkan Kerjasama Pertama
        </a>
    </div>

    @elseif($kerjasama->isEmpty())
    <div class="py-12 text-center">
        <p class="text-gray-400 text-sm">Tidak ada kerjasama yang cocok dengan filter.</p>
        <a href="{{ route('admin.kerjasama.index') }}"
            class="text-emerald-600 text-sm hover:underline mt-2 inline-block">Reset filter</a>
    </div>

    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                    <th class="px-5 py-3 text-left font-semibold">Mitra</th>
                    <th class="px-5 py-3 text-left font-semibold">Jenis</th>
                    <th class="px-5 py-3 text-left font-semibold">Kerjasama</th>
                    <th class="px-5 py-3 text-left font-semibold">Masa Berlaku</th>
                    <th class="px-5 py-3 text-center font-semibold">Status</th>
                    <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($kerjasama as $item)
                <tr
                    class="hover:bg-gray-50/80 transition-colors {{ $item->is_hampir_berakhir ? 'bg-amber-50/40' : '' }}">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-gray-900">{{ $item->nama_mitra }}</p>
                        @if($item->nomor_perjanjian)
                        <p class="text-xs font-mono text-gray-400 mt-0.5">{{ $item->nomor_perjanjian }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($item->jenis_mitra)
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-700">{{
                            $item->jenis_mitra }}</span>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-600 text-sm max-w-48">
                        <p class="truncate">{{ $item->jenis_kerjasama ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-4">
                        @if($item->tanggal_mulai)
                        <div class="text-xs">
                            <p class="text-gray-600">{{ $item->tanggal_mulai->format('d/m/Y') }}</p>
                            @if($item->tanggal_berakhir)
                            <p class="text-gray-400">s/d {{ $item->tanggal_berakhir->format('d/m/Y') }}</p>
                            @if($item->is_hampir_berakhir)
                            <p class="text-amber-600 font-semibold flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $item->sisa_hari }} hari lagi
                            </p>
                            @endif
                            @endif
                        </div>
                        @else
                        <span class="text-gray-400 text-xs">Tidak ditentukan</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->badge_class }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.kerjasama.show', $item) }}"
                                class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors"
                                title="Detail">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.kerjasama.edit', $item) }}"
                                class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition-colors"
                                title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.kerjasama.destroy', $item) }}',
                                    nama: '{{ addslashes($item->nama_mitra) }}'
                                })" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition-colors"
                                title="Hapus">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    @if($kerjasama->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $kerjasama->links('vendor.pagination.tailwind') }}
    </div>
    @endif
    @endif
</div>

@endsection