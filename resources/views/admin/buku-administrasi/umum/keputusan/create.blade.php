@extends('layouts.admin')

@section('title', 'Tambah Keputusan Kepala Desa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.keputusan.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Keputusan Kepala Desa</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-4xl">
        <form action="{{ route('admin.buku-administrasi.umum.keputusan.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Keputusan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_keputusan" value="{{ old('nomor_keputusan') }}" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    @error('nomor_keputusan') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Keputusan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_keputusan" value="{{ old('tanggal_keputusan') }}" required 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    @error('tanggal_keputusan') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tentang <span class="text-red-500">*</span></label>
                <textarea name="tentang" rows="3" required 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('tentang') }}</textarea>
                @error('tentang') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Uraian Singkat</label>
                <textarea name="uraian_singkat" rows="3" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('uraian_singkat') }}</textarea>
            </div>

            <hr class="my-6 border-gray-200">
            <p class="text-sm font-semibold text-gray-600 mb-4">Pelaporan (Opsional)</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Dilaporkan</label>
                    <input type="text" name="nomor_dilaporkan" value="{{ old('nomor_dilaporkan') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dilaporkan</label>
                    <input type="date" name="tanggal_dilaporkan" value="{{ old('tanggal_dilaporkan') }}" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" 
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Reset</button>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Simpan Data</button>
            </div>
        </form>
    </div>
@endsection