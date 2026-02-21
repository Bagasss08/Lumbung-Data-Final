@extends('layouts.admin')

@section('title', 'Tambah Dinas Luar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-500">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-white/30 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300">
                            </div>
                            <div
                                class="relative w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Tambah Data Dinas Luar</h1>
                            <p class="text-teal-100 text-sm font-medium">Lengkapi formulir untuk menambahkan dinas luar
                                baru</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.dinas-luar.index') }}"
                        class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-5 py-3 rounded-xl font-semibold border border-white/30 shadow-lg hover:bg-white/30 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <form action="{{ route('admin.dinas-luar.store') }}" method="POST" class="p-8">
                @csrf

                <!-- Error Alert -->
                @if($errors->any())
                <div
                    class="mb-8 bg-gradient-to-r from-rose-50 to-red-50 border-l-4 border-rose-500 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-rose-900 font-bold text-lg mb-3">Terdapat Kesalahan Input</h4>
                            <ul class="space-y-2">
                                @foreach($errors->all() as $error)
                                <li class="flex items-start gap-2 text-rose-800 text-sm font-medium">
                                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $error }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Data Dasar Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Data Pegawai</h3>
                            <p class="text-sm text-slate-600 font-medium">Pilih pegawai yang melaksanakan dinas luar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Pegawai -->
                        <div class="group">
                            <label for="id_pegawai" class="block text-sm font-bold text-slate-700 mb-2">
                                Pegawai <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <select
                                    class="w-full pl-12 pr-10 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 font-medium appearance-none cursor-pointer @error('id_pegawai') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="id_pegawai" name="id_pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}" {{ old('id_pegawai')==$p->id ? 'selected' : '' }}>
                                        {{ $p->nama_lengkap }} - {{ $p->jabatan ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Kegiatan Section -->
                <div class="mb-10 pt-10 border-t-2 border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Data Kegiatan</h3>
                            <p class="text-sm text-slate-600 font-medium">Informasi kegiatan dinas luar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Kegiatan -->
                        <div class="md:col-span-2 group">
                            <label for="nama_kegiatan" class="block text-sm font-bold text-slate-700 mb-2">
                                Nama Kegiatan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 font-medium @error('nama_kegiatan') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                    placeholder="Masukkan nama kegiatan" required>
                            </div>
                        </div>

                        <!-- Lokasi Kegiatan -->
                        <div class="group">
                            <label for="lokasi_kegiatan" class="block text-sm font-bold text-slate-700 mb-2">
                                Lokasi Kegiatan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 font-medium @error('lokasi_kegiatan') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="lokasi_kegiatan" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}"
                                    placeholder="Masukkan lokasi kegiatan" required>
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="group">
                            <label for="tanggal_selesai" class="block text-sm font-bold text-slate-700 mb-2">
                                Tanggal Selesai <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-emerald-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="date"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 font-medium @error('tanggal_selesai') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Tambahan Section -->
                <div class="mb-10 pt-10 border-t-2 border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Detail Tambahan</h3>
                            <p class="text-sm text-slate-600 font-medium">Informasi pelengkap kegiatan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Instansi Tujuan -->
                        <div class="group">
                            <label for="instasi_tujuan" class="block text-sm font-bold text-slate-700 mb-2">
                                Instansi Tujuan <span class="text-slate-400 text-xs font-semibold">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-violet-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all duration-200 font-medium @error('instasi_tujuan') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="instasi_tujuan" name="instasi_tujuan" value="{{ old('instasi_tujuan') }}"
                                    placeholder="Masukkan instansi tujuan">
                            </div>
                        </div>

                        <!-- Surat Tugas -->
                        <div class="group">
                            <label for="surat_tugas" class="block text-sm font-bold text-slate-700 mb-2">
                                Surat Tugas <span class="text-slate-400 text-xs font-semibold">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-violet-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <input type="text"
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all duration-200 font-medium @error('surat_tugas') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="surat_tugas" name="surat_tugas" value="{{ old('surat_tugas') }}"
                                    placeholder="Masukkan nomor surat tugas">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="group">
                            <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-2">
                                Keterangan <span class="text-slate-400 text-xs font-semibold">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-violet-500 transition-colors duration-200"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <textarea
                                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-500/20 focus:border-violet-500 transition-all duration-200 resize-none font-medium @error('keterangan') border-rose-500 ring-4 ring-rose-500/20 @enderror"
                                    id="keterangan" name="keterangan" rows="4"
                                    placeholder="Masukkan keterangan tambahan">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-4 pt-8 border-t-2 border-slate-100">
                    <a href="{{ route('admin.dinas-luar.index') }}"
                        class="px-6 py-3.5 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all duration-200 border-2 border-slate-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="group relative px-8 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-teal-600 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-700 via-teal-700 to-teal-700 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <div class="relative flex items-center gap-2">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Data Dinas Luar
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection
