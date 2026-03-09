@extends('layouts.admin')

@section('title', 'Tambah Tanah Kas Desa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.tanah-kas-desa.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Tanah Kas Desa</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-5xl">
        <form action="{{ route('admin.buku-administrasi.umum.tanah-kas-desa.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Asal Tanah Kas Desa <span class="text-red-500">*</span></label>
                    <input type="text" name="asal_tanah_kas_desa" value="{{ old('asal_tanah_kas_desa') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Sertifikat / Buku C / Persil</label>
                    <input type="text" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Luas (m²) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="luas" value="{{ old('luas') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Tanah</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Asal Perolehan <span class="text-red-500">*</span></label>
                    <input type="text" name="asal_perolehan" value="{{ old('asal_perolehan') }}" placeholder="Asli milik desa, Bantuan, dll" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Perolehan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_perolehan" value="{{ old('tanggal_perolehan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Tanah <span class="text-red-500">*</span></label>
                    <input type="text" name="jenis_tanah" value="{{ old('jenis_tanah') }}" placeholder="Sawah, Tegal, dll" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Patok Batas <span class="text-red-500">*</span></label>
                    <select name="status_patok" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                        <option value="Tidak Ada" {{ old('status_patok') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        <option value="Ada" {{ old('status_patok') == 'Ada' ? 'selected' : '' }}>Ada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Papan Nama <span class="text-red-500">*</span></label>
                    <select name="status_papan_nama" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                        <option value="Tidak Ada" {{ old('status_papan_nama') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        <option value="Ada" {{ old('status_papan_nama') == 'Ada' ? 'selected' : '' }}>Ada</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Peruntukan</label>
                    <input type="text" name="peruntukan" value="{{ old('peruntukan') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mutasi</label>
                    <input type="text" name="mutasi" value="{{ old('mutasi') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
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