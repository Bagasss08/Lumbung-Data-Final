@extends('layouts.admin')

@section('title', 'Produk Lapak')

@section('content')
<div x-data="{ showDeleteModal: false, deleteId: null }">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.lapak.index') }}" class="hover:text-emerald-600 transition-colors">Lapak</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.lapak.show', $lapak) }}" class="hover:text-emerald-600 transition-colors">{{
            $lapak->nama_toko }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">Produk</span>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <img src="{{ $lapak->foto_url }}" alt="{{ $lapak->nama_toko }}"
                class="w-10 h-10 rounded-xl object-cover border border-gray-100 shadow-sm">
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $lapak->nama_toko }}</p>
                <p class="text-xs text-gray-400">{{ $lapak->penduduk->nama ?? '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.lapak.produk.create', $lapak) }}"
                class="flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
            <a href="{{ route('admin.lapak.show', $lapak) }}"
                class="px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl">
        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
        <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-700">
                Daftar Produk
                <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-full font-medium">
                    {{ $produk->total() }} total
                </span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-10">
                            #</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-16">
                            Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama
                            Produk</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Harga</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Stok</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Satuan</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($produk as $item)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-4 py-3.5 text-gray-400 text-xs">
                            {{ $loop->iteration + ($produk->currentPage() - 1) * $produk->perPage() }}
                        </td>
                        <td class="px-4 py-3.5">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->nama_produk }}"
                                class="w-12 h-12 rounded-xl object-cover shadow-sm border border-gray-100">
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="font-semibold text-gray-800">{{ $item->nama_produk }}</p>
                            @if($item->deskripsi)
                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($item->deskripsi, 50) }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <span class="font-bold text-emerald-600">{{ $item->harga_format }}</span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="{{ $item->stok == 0 ? 'text-red-500 font-bold' : 'text-gray-600' }}">
                                {{ $item->stok }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center text-gray-500">{{ $item->satuan }}</td>
                        <td class="px-4 py-3.5 text-center">
                            <span
                                class="px-2.5 py-1 text-xs font-medium rounded-full
                                {{ $item->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' :
                                   ($item->status === 'habis' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-500') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.lapak.produk.edit', [$lapak, $item]) }}" title="Edit"
                                    class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button @click="deleteId = {{ $item->id }}; showDeleteModal = true" title="Hapus"
                                    class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <form id="delete-form-produk-{{ $item->id }}"
                                    action="{{ route('admin.lapak.produk.destroy', [$lapak, $item]) }}" method="POST"
                                    class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <p class="text-sm text-gray-400 font-medium">Belum ada produk</p>
                            <a href="{{ route('admin.lapak.produk.create', $lapak) }}"
                                class="text-xs text-emerald-600 hover:text-emerald-700 font-medium mt-1 inline-block">
                                + Tambah produk pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($produk->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $produk->firstItem() }}–{{ $produk->lastItem() }} dari {{ $produk->total() }} produk
            </p>
            <div class="text-sm">{{ $produk->links() }}</div>
        </div>
        @endif
    </div>

    {{-- Delete Modal --}}
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center"
        x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showDeleteModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-gray-900 text-center mb-1">Hapus Produk?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">Produk ini akan dihapus permanen dan tidak bisa
                dikembalikan.</p>
            <div class="flex gap-3">
                <button @click="showDeleteModal = false"
                    class="flex-1 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button @click="document.getElementById('delete-form-produk-' + deleteId).submit()"
                    class="flex-1 py-2.5 text-sm font-medium text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

</div>
@endsection