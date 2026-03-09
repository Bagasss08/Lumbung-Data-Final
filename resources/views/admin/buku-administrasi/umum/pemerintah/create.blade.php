@extends('layouts.admin')

@section('title', 'Tambah Aparatur Pemerintah Desa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Tambah Data Aparatur Desa</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-5xl">
        <form action="{{ route('admin.buku-administrasi.umum.pemerintah.store') }}" method="POST">
            @csrf
            
            <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2">Data Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                    <input type="text" name="agama" value="{{ old('agama') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-800 mb-4 border-b pb-2 mt-8">Data Kepegawaian</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIAP (Nomor Induk Aparatur)</label>
                    <input type="text" name="niap" value="{{ old('niap') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP (Jika PNS)</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat/Golongan</label>
                    <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SK Pengangkatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_keputusan_pengangkatan" value="{{ old('nomor_keputusan_pengangkatan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal SK Pengangkatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_keputusan_pengangkatan" value="{{ old('tanggal_keputusan_pengangkatan') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SK Pemberhentian</label>
                    <input type="text" name="nomor_keputusan_pemberhentian" value="{{ old('nomor_keputusan_pemberhentian') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal SK Pemberhentian</label>
                    <input type="date" name="tanggal_keputusan_pemberhentian" value="{{ old('tanggal_keputusan_pemberhentian') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
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