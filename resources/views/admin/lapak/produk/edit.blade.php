@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.lapak.index') }}" class="hover:text-emerald-600 transition-colors">Lapak</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.lapak.produk.index', $lapak) }}" class="hover:text-emerald-600 transition-colors">{{
            $lapak->nama_toko }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">Edit: {{ $produk->nama_produk }}</span>
    </div>

    <form action="{{ route('admin.lapak.produk.update', [$lapak, $produk]) }}" method="POST"
        enctype="multipart/form-data" x-data="{ previewUrl: '{{ $produk->foto_url }}' }">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Foto --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Foto Produk</h3>
                    <div class="flex flex-col items-center gap-4">
                        <div
                            class="w-full aspect-square rounded-xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200">
                            <img :src="previewUrl" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <label class="w-full cursor-pointer">
                            <input type="file" name="foto" class="hidden" accept="image/*"
                                @change="previewUrl = URL.createObjectURL($event.target.files[0])">
                            <div
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Ganti Foto
                            </div>
                        </label>
                        <p class="text-xs text-gray-400 text-center">Kosongkan jika tidak ingin mengubah foto</p>
                        @error('foto')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Informasi Produk</h3>
                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
                                class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                {{ $errors->has('nama_produk') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('nama_produk')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">Rp</span>
                                    <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" min="0"
                                        step="100" class="w-full pl-9 pr-3 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                        {{ $errors->has('harga') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                </div>
                                @error('harga')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Stok <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                    {{ $errors->has('stok') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                @error('stok')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <select name="satuan"
                                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    @foreach(['pcs','kg','gram','liter','ml','lusin','karton','paket','buah','ikat','botol','dus']
                                    as $sat)
                                    <option value="{{ $sat }}" {{ old('satuan', $produk->satuan) == $sat ? 'selected' :
                                        '' }}>{{ $sat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-3">
                                @foreach([['aktif','Aktif','emerald'], ['habis','Stok Habis','amber'],
                                ['nonaktif','Nonaktif','gray']] as [$val, $label, $color])
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $val }}" class="sr-only peer" {{
                                        old('status', $produk->status) == $val ? 'checked' : '' }}>
                                    <div class="text-center px-3 py-2.5 rounded-xl border-2 text-sm font-medium transition-all
                                        peer-checked:border-{{ $color }}-500 peer-checked:bg-{{ $color }}-50 peer-checked:text-{{ $color }}-700
                                        border-gray-200 text-gray-500 hover:border-gray-300">
                                        {{ $label }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.lapak.produk.index', $lapak) }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Produk
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection