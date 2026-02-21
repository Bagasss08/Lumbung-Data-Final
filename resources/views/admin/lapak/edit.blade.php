@extends('layouts.admin')

@section('title', 'Edit Lapak')

@section('content')
<div>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.lapak.index') }}" class="hover:text-emerald-600 transition-colors">Lapak</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">Edit: {{ $lapak->nama_toko }}</span>
    </div>

    <form action="{{ route('admin.lapak.update', $lapak) }}" method="POST" enctype="multipart/form-data"
        x-data="{ previewUrl: '{{ $lapak->foto_url }}' }">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri - Foto --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Foto Toko</h3>
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

            {{-- Kolom Kanan - Form --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Informasi Lapak</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Pemilik Lapak <span class="text-red-500">*</span>
                            </label>
                            <select name="penduduk_id" class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                {{ $errors->has('penduduk_id') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                <option value="">-- Pilih Penduduk --</option>
                                @foreach($penduduk as $p)
                                <option value="{{ $p->id }}" {{ old('penduduk_id', $lapak->penduduk_id) == $p->id ?
                                    'selected' : '' }}>
                                    {{ $p->nama }}{{ isset($p->nik) ? ' — ' . $p->nik : '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('penduduk_id')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko', $lapak->nama_toko) }}" class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                {{ $errors->has('nama_toko') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('nama_toko')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('deskripsi', $lapak->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon', $lapak->telepon) }}"
                                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status"
                                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="aktif" {{ old('status', $lapak->status) == 'aktif' ? 'selected' : ''
                                        }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status', $lapak->status) == 'nonaktif' ? 'selected'
                                        : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                            <textarea name="alamat" rows="2"
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('alamat', $lapak->alamat) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Link Google Maps
                                <span class="text-xs text-gray-400 font-normal ml-1">(opsional)</span>
                            </label>
                            <div class="relative">
                                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <input type="url" name="link_maps" value="{{ old('link_maps', $lapak->link_maps) }}"
                                    placeholder="https://maps.google.com/..." class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                    {{ $errors->has('link_maps') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            </div>
                            @error('link_maps')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.lapak.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Lapak
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection