@extends('layouts.admin')

@section('title', 'Tambah Perangkat Desa')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Perangkat Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Isi formulir di bawah untuk menambahkan data perangkat desa</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Pemerintah Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah Perangkat</span>
        </nav>
        <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

{{-- ============================================================ --}}
{{-- FORM CARD                                                    --}}
{{-- ============================================================ --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">

    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Tambah Perangkat Desa Baru</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi semua data untuk mendaftarkan perangkat</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.pemerintah.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Form Body --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Nama Lengkap --}}
            <div class="md:col-span-2">
                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap beserta gelar..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('nama') border-red-500 @enderror">
                @error('nama') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- NIK --}}
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nomor Induk Kependudukan (NIK)</label>
                <input type="number" name="nik" id="nik" value="{{ old('nik') }}" placeholder="16 digit NIK..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('nik') border-red-500 @enderror">
                @error('nik') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Jabatan --}}
            <div>
                <label for="jabatan_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Jabatan <span class="text-red-500">*</span></label>
                <select name="jabatan_id" id="jabatan_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('jabatan_id') border-red-500 @enderror">
                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                    {{-- Pastikan Anda mengirimkan $jabatans dari controller --}}
                    @if(isset($jabatans) && $jabatans->count() > 0)
                        @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->nama }} ({{ ucwords(str_replace('_', ' ', $jabatan->golongan)) }})
                            </option>
                        @endforeach
                    @else
                        <option value="" disabled>Data jabatan belum tersedia di database</option>
                    @endif
                </select>
                @error('jabatan_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- No SK --}}
            <div>
                <label for="no_sk" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nomor SK Pengangkatan</label>
                <input type="text" name="no_sk" id="no_sk" value="{{ old('no_sk') }}" placeholder="Contoh: 141/05/SK/2023"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('no_sk') border-red-500 @enderror">
                @error('no_sk') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Status Perangkat <span class="text-red-500">*</span></label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('status') border-red-500 @enderror">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Periode Mulai --}}
            <div>
                <label for="periode_mulai" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Mulai Menjabat</label>
                <input type="date" name="periode_mulai" id="periode_mulai" value="{{ old('periode_mulai') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('periode_mulai') border-red-500 @enderror">
                @error('periode_mulai') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Periode Selesai --}}
            <div>
                <label for="periode_selesai" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Tanggal Selesai Menjabat (Opsional)</label>
                <input type="date" name="periode_selesai" id="periode_selesai" value="{{ old('periode_selesai') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('periode_selesai') border-red-500 @enderror">
                @error('periode_selesai') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Foto Profile --}}
            <div class="md:col-span-2">
                <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Foto Perangkat (Opsional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-slate-600 border-dashed rounded-xl bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors cursor-pointer" onclick="document.getElementById('foto').click()">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 dark:text-slate-300 justify-center">
                            <span class="relative cursor-pointer bg-transparent rounded-md font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 focus-within:outline-none">
                                <span>Upload foto</span>
                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/*">
                            </span>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-slate-400">PNG, JPG, JPEG maksimal 2MB</p>
                    </div>
                </div>
                @error('foto') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>
            
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-slate-700/50 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.pemerintah.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 dark:hover:border-slate-500 transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl
                       hover:from-emerald-600 hover:to-teal-700 hover:shadow-lg hover:shadow-emerald-200 dark:hover:shadow-emerald-900/50 hover:-translate-y-0.5
                       active:translate-y-0 transition-all duration-150 shadow-md shadow-emerald-100 dark:shadow-none focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Data
            </button>
        </div>

    </form>
</div>

@endsection