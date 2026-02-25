@extends('layouts.admin')

@section('title', 'Tambah Analisis')

@section('content')
<div class="max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.analisis.index') }}"
            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h3 class="text-lg font-bold text-gray-800">Tambah Analisis Baru</h3>
            <p class="text-sm text-gray-500">Buat kategori analisis data penduduk</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.analisis.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama Analisis <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Analisis Kemiskinan 2024"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent @error('nama') border-red-400 @enderror">
                @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Analisis</label>
                <input type="text" name="kode" value="{{ old('kode') }}" placeholder="Auto-generate jika kosong"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 font-mono @error('kode') border-red-400 @enderror">
                @error('kode')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Subjek Data <span class="text-red-500">*</span>
                    </label>
                    <select name="subjek"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 @error('subjek') border-red-400 @enderror">
                        <option value="">-- Pilih Subjek --</option>
                        <option value="PENDUDUK" {{ old('subjek')==='PENDUDUK' ? 'selected' : '' }}>Penduduk</option>
                        <option value="KELUARGA" {{ old('subjek')==='KELUARGA' ? 'selected' : '' }}>Keluarga</option>
                        <option value="RUMAH_TANGGA" {{ old('subjek')==='RUMAH_TANGGA' ? 'selected' : '' }}>Rumah Tangga
                        </option>
                        <option value="KELOMPOK" {{ old('subjek')==='KELOMPOK' ? 'selected' : '' }}>Kelompok</option>
                    </select>
                    @error('subjek')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                        <option value="AKTIF" {{ old('status', 'AKTIF' )==='AKTIF' ? 'selected' : '' }}>Aktif</option>
                        <option value="TIDAK_AKTIF" {{ old('status')==='TIDAK_AKTIF' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Periode</label>
                <input type="number" name="periode" value="{{ old('periode', date('Y')) }}" min="2000" max="2100"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat tentang analisis ini..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.analisis.index') }}"
                    class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl
                               shadow hover:shadow-md transition-all hover:-translate-y-0.5">
                    Simpan Analisis
                </button>
            </div>
        </form>
    </div>

</div>
@endsection