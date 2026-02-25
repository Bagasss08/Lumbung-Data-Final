@extends('layouts.admin')

@section('title', 'Edit Data Suplemen')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.suplemen.index') }}" class="hover:text-emerald-600 transition-colors">Data Suplemen</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium">Edit: {{ $suplemen->nama }}</span>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- Main Form --}}
    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data Suplemen
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.suplemen.update', $suplemen) }}" method="POST"
                    enctype="multipart/form-data" id="formEdit">
                    @csrf @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Suplemen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $suplemen->nama) }}"
                            class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all
                                   {{ $errors->has('nama') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                        @error('nama')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Sasaran --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Sasaran <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="sasaran" value="1" class="peer sr-only" {{ old('sasaran',
                                    $suplemen->sasaran) == '1' ? 'checked' : '' }}>
                                <div
                                    class="flex items-center gap-3 p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all hover:border-gray-300">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Perorangan</p>
                                        <p class="text-xs text-gray-500">Berdasarkan NIK</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="sasaran" value="2" class="peer sr-only" {{ old('sasaran',
                                    $suplemen->sasaran) == '2' ? 'checked' : '' }}>
                                <div
                                    class="flex items-center gap-3 p-4 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all hover:border-gray-300">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Keluarga</p>
                                        <p class="text-xs text-gray-500">Berdasarkan No. KK</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Periode --}}
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                            <input type="date" name="tgl_mulai"
                                value="{{ old('tgl_mulai', $suplemen->tgl_mulai?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Selesai</label>
                            <input type="date" name="tgl_selesai"
                                value="{{ old('tgl_selesai', $suplemen->tgl_selesai?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all resize-none">{{ old('keterangan', $suplemen->keterangan) }}</textarea>
                    </div>

                    {{-- Status Aktif --}}
                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $suplemen->aktif) ?
                                'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-emerald-500 transition-colors">
                                </div>
                                <div
                                    class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all peer-checked:translate-x-5">
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Status Aktif</p>
                                <p class="text-xs text-gray-400">Suplemen ini akan terlihat dan bisa digunakan</p>
                            </div>
                        </label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Update Data
                        </button>
                        <a href="{{ route('admin.suplemen.index') }}"
                            class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Side: Upload Logo --}}
    <div class="xl:col-span-1 space-y-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Logo / Gambar
                </h3>
            </div>
            <div class="p-6">
                <div x-data="{ preview: '{{ $suplemen->logo ? Storage::url($suplemen->logo) : '' }}' }">
                    <div
                        class="relative aspect-square rounded-xl overflow-hidden border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center mb-4">
                        <img x-show="preview" :src="preview" class="w-full h-full object-cover absolute inset-0">
                        <div x-show="!preview" class="text-center p-4">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-gray-400">Belum ada gambar</p>
                        </div>
                    </div>
                    <label class="block cursor-pointer">
                        <input type="file" name="logo" form="formEdit" accept="image/*" class="sr-only"
                            @change="preview = URL.createObjectURL($event.target.files[0])">
                        <div
                            class="flex items-center justify-center gap-2 px-4 py-2.5 border-2 border-dashed border-emerald-200 hover:border-emerald-400 bg-emerald-50 hover:bg-emerald-100 rounded-xl transition-all text-emerald-600 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            {{ $suplemen->logo ? 'Ganti Gambar' : 'Pilih Gambar' }}
                        </div>
                    </label>
                    <p class="text-xs text-gray-400 text-center mt-2">JPG, PNG, GIF — Maks. 2MB</p>
                </div>
            </div>
        </div>

        {{-- Info box --}}
        <div class="bg-gray-50 rounded-2xl border border-gray-100 p-4">
            <p class="text-xs font-semibold text-gray-600 mb-2">Informasi</p>
            <div class="space-y-2 text-xs text-gray-500">
                <div class="flex justify-between">
                    <span>Dibuat</span>
                    <span class="font-medium text-gray-700">{{ $suplemen->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Diperbarui</span>
                    <span class="font-medium text-gray-700">{{ $suplemen->updated_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Terdata</span>
                    <span class="font-medium text-emerald-600">{{ $suplemen->terdata_count }} orang</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection