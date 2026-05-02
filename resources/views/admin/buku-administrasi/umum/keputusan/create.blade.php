@extends('layouts.admin')
@section('title', 'Tambah Keputusan Kepala Desa')
@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Keputusan Kepala Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Catat keputusan kepala desa baru</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Beranda</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.buku-administrasi.umum.keputusan.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Keputusan Kades</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
    </nav>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Formulir Keputusan Kepala Desa</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi data keputusan kepala desa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.keputusan.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

        {{-- SECTION 1: Informasi Keputusan --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">1</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Informasi Keputusan</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Nomor Keputusan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_keputusan" value="{{ old('nomor_keputusan') }}" required placeholder="Contoh: 01/KPTS/2026" class="w-full px-3 py-2.5 text-sm border @error('nomor_keputusan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('nomor_keputusan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Keputusan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_keputusan" value="{{ old('tanggal_keputusan') }}" required class="w-full px-3 py-2.5 text-sm border @error('tanggal_keputusan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('tanggal_keputusan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tentang <span class="text-red-500">*</span></label>
                <textarea name="tentang" rows="3" required placeholder="Perihal keputusan kepala desa..." class="w-full px-3 py-2.5 text-sm border @error('tentang') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('tentang') }}</textarea>
                @error('tentang')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mt-4">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Uraian Singkat</label>
                <textarea name="uraian_singkat" rows="3" placeholder="Uraian singkat keputusan (opsional)..." class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('uraian_singkat') }}</textarea>
            </div>
        </div>

        {{-- SECTION 2: Pelaporan --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-amber-700 dark:text-amber-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Pelaporan <span class="text-gray-400 font-normal">(Opsional)</span></h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Nomor Dilaporkan</label>
                    <input type="text" name="nomor_dilaporkan" value="{{ old('nomor_dilaporkan') }}" placeholder="Nomor pelaporan" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Dilaporkan</label>
                    <input type="date" name="tanggal_dilaporkan" value="{{ old('tanggal_dilaporkan') }}" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)..." class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('keterangan') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.keputusan.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection