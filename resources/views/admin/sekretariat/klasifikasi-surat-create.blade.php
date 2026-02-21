@extends('layouts.admin')

@section('title', 'Tambah Klasifikasi Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1
                    class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                    Tambah Klasifikasi Surat
                </h1>
                <p class="text-sm text-gray-500 mt-1">Tambahkan klasifikasi surat baru untuk sistem</p>
            </div>
            <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
                class="text-gray-600 hover:text-gray-800 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Info Alert -->
    <div
        class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 px-4 py-3 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-cyan-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div class="flex-1">
            <p class="text-cyan-800 font-medium text-sm">
                Pastikan kode klasifikasi unik dan sesuai dengan standar administrasi desa
            </p>
        </div>
        <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
            class="text-cyan-700 hover:text-cyan-900 font-medium text-sm hover:underline whitespace-nowrap">
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <form method="POST" action="{{ route('admin.sekretariat.klasifikasi-surat.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kode Klasifikasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kode Klasifikasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <input type="text" name="kode" value="{{ old('kode') }}"
                            class="w-full pl-10 pr-4 py-3 border @error('kode') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="Contoh: 001">
                    </div>
                    @error('kode')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Format: 3 digit angka (001-999)</p>
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="kategori"
                            class="w-full px-4 py-3 border @error('kategori') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all appearance-none bg-white">
                            <option value="">Pilih Kategori</option>
                            <option value="administrasi" @selected(old('kategori')=='administrasi' )>Administrasi
                            </option>
                            <option value="kependudukan" @selected(old('kategori')=='kependudukan' )>Kependudukan
                            </option>
                            <option value="pembangunan" @selected(old('kategori')=='pembangunan' )>Pembangunan</option>
                            <option value="keuangan" @selected(old('kategori')=='keuangan' )>Keuangan</option>
                            <option value="kesehatan" @selected(old('kategori')=='kesehatan' )>Kesehatan</option>
                            <option value="pendidikan" @selected(old('kategori')=='pendidikan' )>Pendidikan</option>
                            <option value="pertanian" @selected(old('kategori')=='pertanian' )>Pertanian</option>
                            <option value="lainnya" @selected(old('kategori')=='lainnya' )>Lainnya</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    @error('kategori')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

            </div>

            <!-- Nama Klasifikasi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Klasifikasi <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <input type="text" name="nama_klasifikasi" value="{{ old('nama_klasifikasi') }}"
                        class="w-full pl-10 pr-4 py-3 border @error('nama_klasifikasi') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Masukkan nama klasifikasi surat">
                </div>
                @error('nama_klasifikasi')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Retensi Aktif -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Retensi Aktif (Tahun) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="number" name="retensi_aktif" value="{{ old('retensi_aktif', 5) }}" min="1"
                            class="w-full pl-10 pr-4 py-3 border @error('retensi_aktif') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="5">
                    </div>
                    @error('retensi_aktif')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Periode penyimpanan di arsip aktif</p>
                </div>

                <!-- Retensi Inaktif -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Retensi Inaktif (Tahun) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="number" name="retensi_inaktif" value="{{ old('retensi_inaktif', 10) }}" min="1"
                            class="w-full pl-10 pr-4 py-3 border @error('retensi_inaktif') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="10">
                    </div>
                    @error('retensi_inaktif')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Periode penyimpanan di arsip inaktif</p>
                </div>

            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Keterangan
                </label>
                <textarea name="keterangan" rows="4"
                    class="w-full px-4 py-3 border @error('keterangan') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all resize-none"
                    placeholder="Tambahkan keterangan atau deskripsi klasifikasi (opsional)">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="status" value="1" @checked(old('status', '1' )=='1' )
                                class="w-5 h-5 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-600 transition-colors">
                            Aktif
                        </span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="radio" name="status" value="0" @checked(old('status')=='0' )
                                class="w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300">
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-red-600 transition-colors">
                            Tidak Aktif
                        </span>
                    </label>
                </div>
                @error('status')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Klasifikasi
                </button>
            </div>

        </form>
    </div>

</div>
@endsection