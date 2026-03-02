@extends('layouts.admin')

@section('title','Data Keluarga')

@section('content')
<div class="space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
        class="flex items-start gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 rounded-xl">
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
    <div class="flex items-center gap-3 p-4 mb-6 bg-red-50 border border-red-200 rounded-xl">
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
        @include('admin.partials.export-buttons', [
            'routeExcel' => 'admin.keluarga.export.excel',
            'routePdf' => 'admin.keluarga.export.pdf',
        ])
        <a href="{{ route('admin.keluarga.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Keluarga
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Total Keluarga -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Keluarga</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($total_keluarga) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Aktif -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($keluarga_aktif) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pindah -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pindah</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($keluarga_pindah) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Filter Data</h3>
            <form method="GET" action="{{ route('admin.keluarga') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama kepala keluarga atau No. KK..."
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>



                    <!-- Klasifikasi Ekonomi Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Klasifikasi Ekonomi</label>
                        <select name="klasifikasi_ekonomi"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="" {{ request('klasifikasi_ekonomi') == '' ? 'selected' : '' }}>Semua Klasifikasi</option>
                            <option value="miskin" {{ request('klasifikasi_ekonomi') == 'miskin' ? 'selected' : '' }}>Miskin</option>
                            <option value="rentan" {{ request('klasifikasi_ekonomi') == 'rentan' ? 'selected' : '' }}>Rentan</option>
                            <option value="mampu" {{ request('klasifikasi_ekonomi') == 'mampu' ? 'selected' : '' }}>Mampu</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('admin.keluarga') }}"
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
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No KK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kepala Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Wilayah</th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Klasifikasi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Anggota</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($keluarga as $index => $kk)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $keluarga->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kk->no_kk }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if($kk->getKepalaKeluarga())
                                {{ $kk->getKepalaKeluarga()->nama }}
                            @else
                                Belum ditentukan
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $kk->alamat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $kk->wilayah ? 'RT ' . $kk->wilayah->rt . ' / RW ' . $kk->wilayah->rw . ' - ' . $kk->wilayah->dusun : 'Tidak Ditemukan' }}</td>

                        <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($kk->klasifikasi_ekonomi ?? '-') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $kk->getTotalAnggota() }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.keluarga.show', $kk) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.keluarga.edit', $kk) }}"
                                    class="text-emerald-600 hover:text-emerald-800 font-medium transition-colors">
                                    Edit
                                </a>
                                <button type="button" @click="$dispatch('buka-modal-hapus', {
                                    action: '{{ route('admin.keluarga.destroy', $kk) }}',
                                    nama: '{{ addslashes($kk->no_kk) }}'
                                })" class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-sm font-medium text-gray-900">Tidak ada data keluarga</p>
                                <p class="text-sm text-gray-500 mt-1">Mulai dengan menambahkan data keluarga baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($keluarga->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($keluarga->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                        Sebelumnya
                    </span>
                    @else
                    <a href="{{ $keluarga->previousPageUrl() }}"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Sebelumnya
                    </a>
                    @endif

                    @if ($keluarga->hasMorePages())
                    <a href="{{ $keluarga->nextPageUrl() }}"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Selanjutnya
                    </a>
                    @else
                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                        Selanjutnya
                    </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $keluarga->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $keluarga->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $keluarga->total() }}</span>
                            data
                        </p>
                    </div>

                    <div>
                        <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                            @if ($keluarga->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @else
                            <a href="{{ $keluarga->previousPageUrl() }}"
                                class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif

                            @foreach ($keluarga->getUrlRange(1, $keluarga->lastPage()) as $page => $url)
                            @if ($page == $keluarga->currentPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-emerald-500 bg-emerald-50 text-sm font-medium text-emerald-600">
                                {{ $page }}
                            </span>
                            @else
                            <a href="{{ $url }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                {{ $page }}
                            </a>
                            @endif
                            @endforeach

                            @if ($keluarga->hasMorePages())
                            <a href="{{ $keluarga->nextPageUrl() }}"
                                class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @else
                            <span class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
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

    @include('admin.partials.modal-hapus')

</div>
@endsection
