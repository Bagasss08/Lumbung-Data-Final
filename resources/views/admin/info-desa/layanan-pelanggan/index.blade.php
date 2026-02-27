@extends('layouts.admin')
@section('title', 'Layanan Pelanggan')

@section('content')

@include('admin.partials.modal-hapus')

{{-- Flash message --}}
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

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <p class="text-sm text-gray-500">Katalog layanan publik yang tersedia di desa untuk warga.</p>
    <div class="flex items-center gap-2">
        @include('admin.partials.export-buttons', [
        'routeExcel' => 'admin.layanan-pelanggan.export.excel',
        'routePdf' => 'admin.layanan-pelanggan.export.pdf',
        ])
        <a href="{{ route('admin.layanan-pelanggan.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Layanan
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
    ['label'=>'Total Layanan', 'val'=>$stats['total'], 'color'=>'emerald', 'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0
    01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7
    7h10'],
    ['label'=>'Aktif', 'val'=>$stats['aktif'], 'color'=>'blue', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118
    0z'],
    ['label'=>'Nonaktif', 'val'=>$stats['nonaktif'], 'color'=>'gray', 'icon'=>'M18.364 18.364A9 9 0 005.636 5.636m12.728
    12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
    ['label'=>'Terhubung Surat', 'val'=>$stats['dengan_surat'], 'color'=>'purple', 'icon'=>'M3 8l7.89 5.26a2 2 0 002.22
    0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
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
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau kode layanan..."
            class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
        <select name="jenis"
            class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
            <option value="">Semua Jenis</option>
            @foreach(\App\Models\LayananPelanggan::daftarJenis() as $j)
            <option value="{{ $j }}" {{ request('jenis')===$j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
        </select>
        <select name="status"
            class="px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm bg-white">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status')==='aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status')==='nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        <button type="submit"
            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition-colors">Cari</button>
        @if(request()->hasAny(['search','jenis','status']))
        <a href="{{ route('admin.layanan-pelanggan.index') }}"
            class="px-5 py-2.5 border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-xl text-sm font-medium transition-colors">Reset</a>
        @endif
    </form>
</div>

{{-- Tabel / Empty State --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    @if($layanan->isEmpty() && !request()->hasAny(['search','jenis','status']))
    {{-- Empty State Pertama Kali --}}
    <div class="py-16 px-8 text-center">
        <div
            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center mx-auto mb-5 border-2 border-dashed border-blue-200">
            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <h4 class="font-semibold text-gray-800 text-base mb-2">Belum ada layanan publik</h4>
        <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6 leading-relaxed">
            Daftarkan layanan-layanan yang tersedia di desa agar warga tahu cara mengaksesnya.
        </p>
        <a href="{{ route('admin.layanan-pelanggan.create') }}"
            class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Layanan Pertama
        </a>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto text-left">
            @foreach([
            ['no'=>'1','judul'=>'Identifikasi Layanan','desc'=>'Catat semua jenis pelayanan yang diberikan desa'],
            ['no'=>'2','judul'=>'Lengkapi Persyaratan','desc'=>'Isi persyaratan agar warga bisa mempersiapkan dokumen'],
            ['no'=>'3','judul'=>'Hubungkan ke Surat','desc'=>'Optionally link layanan ke template surat yang
            digunakan'],
            ] as $step)
            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                <span
                    class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">{{
                    $step['no'] }}</span>
                <div>
                    <p class="font-medium text-gray-800 text-xs">{{ $step['judul'] }}</p>
                    <p class="text-gray-500 text-xs mt-0.5">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @elseif($layanan->isEmpty())
    {{-- Tidak ada hasil filter --}}
    <div class="py-12 text-center">
        <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <p class="text-gray-500 text-sm">Tidak ada layanan yang cocok dengan filter yang dipilih.</p>
        <a href="{{ route('admin.layanan-pelanggan.index') }}"
            class="text-emerald-600 text-sm hover:underline mt-2 inline-block">Lihat semua layanan</a>
    </div>

    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                    <th class="px-5 py-3 text-left font-semibold w-8">#</th>
                    <th class="px-5 py-3 text-left font-semibold">Layanan</th>
                    <th class="px-5 py-3 text-left font-semibold">Jenis</th>
                    <th class="px-5 py-3 text-left font-semibold">Penanggung Jawab</th>
                    <th class="px-5 py-3 text-left font-semibold">Waktu</th>
                    <th class="px-5 py-3 text-center font-semibold">Status</th>
                    <th class="px-5 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($layanan as $item)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $layanan->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-4">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $item->nama_layanan }}</p>
                            @if($item->kode_layanan)
                            <span class="text-xs text-gray-400 font-mono">{{ $item->kode_layanan }}</span>
                            @endif
                            @if($item->membutuhkan_surat)
                            <span
                                class="ml-1 inline-flex items-center gap-1 text-xs text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded-md">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                                ada surat
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if($item->jenis_layanan)
                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">{{
                            $item->jenis_layanan }}</span>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-600 text-sm">{{ $item->penanggung_jawab ?? '-' }}</td>
                    <td class="px-5 py-4 text-gray-600 text-sm">{{ $item->waktu_penyelesaian ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                            <span
                                class="w-1.5 h-1.5 rounded-full {{ $item->status === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.layanan-pelanggan.show', $item) }}"
                                class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition-colors"
                                title="Detail">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.layanan-pelanggan.edit', $item) }}"
                                class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition-colors"
                                title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button type="button" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.layanan-pelanggan.destroy', $item) }}',
                                    nama: '{{ addslashes($item->nama_layanan) }}'
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
    @if($layanan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $layanan->links('vendor.pagination.tailwind') }}
    </div>
    @endif
    @endif
</div>

@endsection