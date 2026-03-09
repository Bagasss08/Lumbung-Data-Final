@extends('layouts.admin')

@section('title', 'Edit Data Lembaran Desa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Edit Data Lembaran/Berita Desa</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-5xl">
        <form action="{{ route('admin.buku-administrasi.umum.lembaran-desa.update', $lembaran->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informasi Peraturan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Peraturan <span class="text-red-500">*</span></label>
                    <select name="jenis_peraturan" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                        <option value="Peraturan Desa" {{ old('jenis_peraturan', $lembaran->jenis_peraturan) == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                        <option value="Peraturan Kepala Desa" {{ old('jenis_peraturan', $lembaran->jenis_peraturan) == 'Peraturan Kepala Desa' ? 'selected' : '' }}>Peraturan Kepala Desa</option>
                        <option value="Peraturan Bersama Kepala Desa" {{ old('jenis_peraturan', $lembaran->jenis_peraturan) == 'Peraturan Bersama Kepala Desa' ? 'selected' : '' }}>Peraturan Bersama Kepala Desa</option>
                    </select>
                </div>
                <div></div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Ditetapkan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_ditetapkan" value="{{ old('nomor_ditetapkan', $lembaran->nomor_ditetapkan) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ditetapkan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan', $lembaran->tanggal_ditetapkan) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tentang (Judul Peraturan) <span class="text-red-500">*</span></label>
                <textarea name="tentang" rows="2" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('tentang', $lembaran->tentang) }}</textarea>
            </div>

            <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2 mt-8">Diundangkan Dalam</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="font-medium text-gray-700 mb-3">Lembaran Desa</p>
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Diundangkan</label>
                        <input type="date" name="tanggal_diundangkan_lembaran" value="{{ old('tanggal_diundangkan_lembaran', $lembaran->tanggal_diundangkan_lembaran) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Diundangkan</label>
                        <input type="text" name="nomor_diundangkan_lembaran" value="{{ old('nomor_diundangkan_lembaran', $lembaran->nomor_diundangkan_lembaran) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 text-sm">
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="font-medium text-gray-700 mb-3">Berita Desa</p>
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Diundangkan</label>
                        <input type="date" name="tanggal_diundangkan_berita" value="{{ old('tanggal_diundangkan_berita', $lembaran->tanggal_diundangkan_berita) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Diundangkan</label>
                        <input type="text" name="nomor_diundangkan_berita" value="{{ old('nomor_diundangkan_berita', $lembaran->nomor_diundangkan_berita) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 text-sm">
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('keterangan', $lembaran->keterangan) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Perbarui Data</button>
            </div>
        </form>
    </div>
@endsection