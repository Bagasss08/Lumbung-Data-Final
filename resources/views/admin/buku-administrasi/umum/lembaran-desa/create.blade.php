@extends('layouts.admin')
@section('title', 'Tambah Data Lembaran Desa')
@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Data Lembaran/Berita Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Catat data lembaran atau berita desa baru</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Beranda</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Lembaran Desa</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
    </nav>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Formulir Lembaran/Berita Desa</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi data peraturan yang diundangkan</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.lembaran-desa.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

        {{-- SECTION 1: Informasi Peraturan --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">1</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Informasi Peraturan</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Peraturan <span class="text-red-500">*</span></label>
                    <select name="jenis_peraturan" required class="w-full px-3 py-2.5 text-sm border @error('jenis_peraturan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">-- Pilih Jenis Peraturan --</option>
                        <option value="Peraturan Desa" {{ old('jenis_peraturan') == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                        <option value="Peraturan Kepala Desa" {{ old('jenis_peraturan') == 'Peraturan Kepala Desa' ? 'selected' : '' }}>Peraturan Kepala Desa</option>
                        <option value="Peraturan Bersama Kepala Desa" {{ old('jenis_peraturan') == 'Peraturan Bersama Kepala Desa' ? 'selected' : '' }}>Peraturan Bersama Kepala Desa</option>
                    </select>
                    @error('jenis_peraturan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div></div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Nomor Ditetapkan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_ditetapkan" value="{{ old('nomor_ditetapkan') }}" required placeholder="Nomor penetapan" class="w-full px-3 py-2.5 text-sm border @error('nomor_ditetapkan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('nomor_ditetapkan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Ditetapkan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_ditetapkan" value="{{ old('tanggal_ditetapkan') }}" required class="w-full px-3 py-2.5 text-sm border @error('tanggal_ditetapkan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('tanggal_ditetapkan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tentang (Judul Peraturan) <span class="text-red-500">*</span></label>
                <textarea name="tentang" rows="2" required placeholder="Judul atau perihal peraturan..." class="w-full px-3 py-2.5 text-sm border @error('tentang') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('tentang') }}</textarea>
                @error('tentang')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- SECTION 2: Diundangkan Dalam --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Diundangkan Dalam <span class="text-gray-400 font-normal">(Pilih Salah Satu/Keduanya)</span></h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-xl border border-gray-200 dark:border-slate-600">
                    <p class="font-medium text-sm text-gray-700 dark:text-slate-300 mb-3">Lembaran Desa</p>
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1.5">Tanggal Diundangkan</label>
                        <input type="date" name="tanggal_diundangkan_lembaran" value="{{ old('tanggal_diundangkan_lembaran') }}" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1.5">Nomor Diundangkan</label>
                        <input type="text" name="nomor_diundangkan_lembaran" value="{{ old('nomor_diundangkan_lembaran') }}" placeholder="Nomor lembaran desa" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-slate-700/50 p-4 rounded-xl border border-gray-200 dark:border-slate-600">
                    <p class="font-medium text-sm text-gray-700 dark:text-slate-300 mb-3">Berita Desa</p>
                    <div class="mb-3">
                        <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1.5">Tanggal Diundangkan</label>
                        <input type="date" name="tanggal_diundangkan_berita" value="{{ old('tanggal_diundangkan_berita') }}" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1.5">Nomor Diundangkan</label>
                        <input type="text" name="nomor_diundangkan_berita" value="{{ old('nomor_diundangkan_berita') }}" placeholder="Nomor berita desa" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-800 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)..." class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('keterangan') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.lembaran-desa.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection