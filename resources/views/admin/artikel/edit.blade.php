@extends('layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text">Edit Artikel</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui artikel "{{ $artikel->nama }}"</p>
        </div>
        <a href="{{ route('admin.artikel.index') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.artikel.update', $artikel) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Article Content -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Konten Artikel</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $artikel->nama) }}" required
                                class="w-full px-4 py-3 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white"
                                placeholder="Masukkan judul artikel...">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Artikel <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="12" required
                                class="w-full px-4 py-3 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white resize-none"
                                placeholder="Tulis isi artikel di sini...">{{ old('deskripsi', $artikel->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Pengaturan Publikasi</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Publish Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                            <input type="datetime-local" name="publish_at" value="{{ old('publish_at', $artikel->publish_at ? (\is_string($artikel->publish_at) ? $artikel->publish_at : $artikel->publish_at->format('Y-m-d\TH:i')) : '') }}"
                                class="w-full px-4 py-3 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 hover:bg-white">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan untuk menyimpan sebagai draft</p>
                            @error('publish_at')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Preview -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-2">
                                @if($artikel->publish_at)
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-700">Dipublikasikan</span>
                                @else
                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                <span class="text-sm font-medium text-yellow-700">Draft</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Utama</h3>
                    </div>
                    <div class="p-6">
                        <!-- Current Image Preview -->
                        @if($artikel->gambar)
                        <div class="mb-4">
                            <div class="w-full h-48 bg-gray-100 rounded-xl border border-gray-300 overflow-hidden">
                                <img src="{{ asset('storage/artikel/' . $artikel->gambar) }}" alt="Gambar Artikel" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-gray-500 text-center mt-2">Gambar saat ini</p>
                        </div>
                        @endif

                        <!-- File Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Gambar Baru</label>
                            <input type="file" name="gambar" accept="image/*"
                                class="w-full px-4 py-3 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar</p>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.artikel.index') }}"
                class="px-6 py-3 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:scale-105">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Artikel
                </span>
            </button>
        </div>
    </form>
</div>
@endsection
