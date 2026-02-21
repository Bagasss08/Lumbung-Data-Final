@extends('layouts.admin')

@section('title', 'Inventaris')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Inventaris Desa</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola inventaris dan aset desa</p>
            </div>
            <a href="{{ route('admin.sekretariat.inventaris.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Barang
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Barang -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Barang</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Baik -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Barang Baik</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $stats['baik'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Perlu Perbaikan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Perlu Perbaikan</p>
                    <p class="text-3xl font-bold text-amber-600">{{ $stats['perlu_perbaikan'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-amber-100 to-amber-200 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Barang Rusak -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Barang Rusak</p>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['rusak'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form method="GET" action="{{ route('admin.sekretariat.inventaris') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cari Barang</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari inventaris..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>

                <!-- Kategori Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="kategori"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        <option value="">Semua Kategori</option>
                        <option value="elektronik" {{ request('kategori')=='elektronik' ? 'selected' : '' }}>Elektronik
                        </option>
                        <option value="furniture" {{ request('kategori')=='furniture' ? 'selected' : '' }}>Furniture
                        </option>
                        <option value="kendaraan" {{ request('kategori')=='kendaraan' ? 'selected' : '' }}>Kendaraan
                        </option>
                        <option value="peralatan" {{ request('kategori')=='peralatan' ? 'selected' : '' }}>Peralatan
                        </option>
                    </select>
                </div>

                <!-- Kondisi Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kondisi</label>
                    <select name="kondisi"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" {{ request('kondisi')=='baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ request('kondisi')=='rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="perlu_perbaikan" {{ request('kondisi')=='perlu_perbaikan' ? 'selected' : '' }}>
                            Perlu Perbaikan</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.sekretariat.inventaris') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-all">
                    Reset
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all shadow-sm hover:shadow-md">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Nama Barang
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kondisi
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Lokasi
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($inventaris as $item)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $item->nama_barang }}</div>
                            @if($item->deskripsi)
                            <div class="text-sm text-slate-500 mt-1">{{ Str::limit($item->deskripsi, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full capitalize">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-900">{{ $item->jumlah }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->kondisi == 'baik')
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full">
                                Baik
                            </span>
                            @elseif($item->kondisi == 'rusak')
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                Rusak
                            </span>
                            @else
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-700 rounded-full">
                                Perlu Perbaikan
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $item->lokasi }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.sekretariat.inventaris.edit', $item->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST"
                                    action="{{ route('admin.sekretariat.inventaris.destroy', $item->id) }}"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p class="text-slate-600 font-medium mb-2">Belum ada data inventaris</p>
                                <p class="text-sm text-slate-400 mb-4">Klik tombol "Tambah Barang" untuk menambahkan
                                    data baru</p>
                                <a href="{{ route('admin.sekretariat.inventaris.create') }}"
                                    class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah barang pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($inventaris->hasPages())
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-slate-700">
                    Menampilkan <span class="font-medium">{{ $inventaris->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $inventaris->lastItem() }}</span>
                    dari <span class="font-medium">{{ $inventaris->total() }}</span> hasil
                </div>
                <div>
                    {{ $inventaris->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection