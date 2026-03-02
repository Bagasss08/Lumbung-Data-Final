@extends('layouts.admin')

@section('title', 'Data Penduduk')

@section('content')
<div class="space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
        class="flex items-start gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
        <div>
            <p class="text-sm font-semibold text-emerald-800">{{ session('success') }}</p>
            @if(session('import_errors'))
            <ul class="mt-2 space-y-0.5">
                @foreach(session('import_errors') as $err)
                <li class="text-xs text-red-600">• {{ $err }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
        </svg>
        <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    <!-- Action Buttons Bar -->
    <div class="flex items-center justify-end gap-3">

        {{-- Import --}}
        <button type="button" @click="$dispatch('buka-modal-import')"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            Import Data
        </button>

        {{-- Export dropdown --}}
        @include('admin.partials.export-buttons', [
        'routeExcel' => 'admin.penduduk.export.excel',
        'routePdf' => 'admin.penduduk.export.pdf',
        'routeTemplate' => 'admin.penduduk.template',
        ])

        {{-- Tambah Penduduk --}}
        <a href="{{ route('admin.penduduk.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Penduduk
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Penduduk -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Penduduk</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($total_penduduk) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Laki-laki -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Laki-laki</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($laki_laki) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Perempuan -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Perempuan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($perempuan) }}</p>
                </div>
                <div class="w-12 h-12 bg-pink-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Keluarga (KK) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Keluarga (KK)</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($keluarga) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Filter Data</h3>
            <form method="GET" action="{{ route('admin.penduduk') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NIK..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>

                    <!-- Gender Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="Semua" {{ request('jenis_kelamin')=='Semua' ? 'selected' : '' }}>Semua
                            </option>
                            <option value="Laki-laki" {{ request('jenis_kelamin')=='Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ request('jenis_kelamin')=='Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                    </div>

                    <!-- Religion Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Agama</label>
                        <select name="agama"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="Semua Agama" {{ request('agama')=='Semua Agama' ? 'selected' : '' }}>Semua
                                Agama</option>
                            <option value="Islam" {{ request('agama')=='Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ request('agama')=='Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ request('agama')=='Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ request('agama')=='Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ request('agama')=='Budha' ? 'selected' : '' }}>Budha</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('admin.penduduk') }}"
                            class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIK
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tempat Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Agama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Rumah Tangga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Gol. Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($penduduk as $index => $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $penduduk->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->nik }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $p->nama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->tempat_lahir }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->tanggal_lahir->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->agama }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @php
                            $currentKeluarga = $p->keluargas()->withPivot('hubungan_keluarga')->first();
                            @endphp
                            @if($currentKeluarga)
                            {{ $currentKeluarga->no_kk }}
                            <br>
                            <small class="text-gray-500">{{ ucfirst(str_replace('_', ' ',
                                $currentKeluarga->pivot->hubungan_keluarga)) }}</small>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            @php
                            $currentRumahTangga = $p->rumahTanggas()->withPivot('hubungan_rumah_tangga')->first();
                            @endphp
                            @if($currentRumahTangga)
                            {{ $currentRumahTangga->no_rumah_tangga }}
                            <br>
                            <small class="text-gray-500">{{ ucfirst(str_replace('_', ' ',
                                $currentRumahTangga->pivot->hubungan_rumah_tangga)) }}</small>
                            @else
                            -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $p->golongan_darah ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.penduduk.show', $p) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.penduduk.edit', $p) }}"
                                    class="text-emerald-600 hover:text-emerald-800 font-medium transition-colors">
                                    Edit
                                </a>
                                <button type="button" @click="$dispatch('buka-modal-hapus', {
                                        action: '{{ route('admin.penduduk.destroy', $p) }}',
                                        nama: '{{ addslashes($p->nama) }}'
                                    })" class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm font-medium text-gray-900">Tidak ada data penduduk</p>
                                <p class="text-sm text-gray-500 mt-1">Mulai dengan menambahkan data penduduk baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($penduduk->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($penduduk->onFirstPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                        Sebelumnya
                    </span>
                    @else
                    <a href="{{ $penduduk->previousPageUrl() }}"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Sebelumnya
                    </a>
                    @endif

                    @if ($penduduk->hasMorePages())
                    <a href="{{ $penduduk->nextPageUrl() }}"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Selanjutnya
                    </a>
                    @else
                    <span
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                        Selanjutnya
                    </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $penduduk->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $penduduk->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $penduduk->total() }}</span>
                            data
                        </p>
                    </div>

                    <div>
                        <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                            @if ($penduduk->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            @else
                            <a href="{{ $penduduk->previousPageUrl() }}"
                                class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif

                            @foreach ($penduduk->getUrlRange(1, $penduduk->lastPage()) as $page => $url)
                            @if ($page == $penduduk->currentPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-emerald-500 bg-emerald-50 text-sm font-medium text-emerald-600">
                                {{ $page }}
                            </span>
                            @else
                            <a href="{{ $url }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ $page }}
                            </a>
                            @endif
                            @endforeach

                            @if ($penduduk->hasMorePages())
                            <a href="{{ $penduduk->nextPageUrl() }}"
                                class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            @else
                            <span
                                class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

{{-- Partials Modal --}}
@include('admin.partials.modal-import-penduduk')
@include('admin.partials.modal-hapus')

@endsection