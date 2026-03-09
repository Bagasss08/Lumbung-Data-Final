@extends('layouts.admin')

@section('title', 'Tambah Tanah di Desa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.tanah-desa.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Tanah di Desa</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-4xl">
        <form action="{{ route('admin.buku-administrasi.umum.tanah-desa.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik / Badan Hukum <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Luas Tanah (m²) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="luas_tanah" value="{{ old('luas_tanah') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Hak Tanah <span class="text-red-500">*</span></label>
                    <input type="text" name="status_hak_tanah" value="{{ old('status_hak_tanah') }}" placeholder="Contoh: SHM, HGB, Leter C" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penggunaan Tanah <span class="text-red-500">*</span></label>
                    <input type="text" name="penggunaan_tanah" value="{{ old('penggunaan_tanah') }}" placeholder="Contoh: Pertanian, Perumahan" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Letak Tanah (Blok / Alamat) <span class="text-red-500">*</span></label>
                <textarea name="letak_tanah" rows="2" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('letak_tanah') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="reset" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Reset</button>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Simpan Data</button>
            </div>
        </form>
    </div>
@endsection