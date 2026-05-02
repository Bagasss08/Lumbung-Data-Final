@extends('layouts.admin')

@section('title', 'Tambah Surat Masuk')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Surat Masuk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Catat agenda surat masuk baru ke dalam buku administrasi</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Beranda</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.buku-administrasi.umum.agenda-surat-masuk.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Agenda Surat Masuk</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
    </nav>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Formulir Surat Masuk</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi data agenda surat masuk desa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.agenda-surat-masuk.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

        {{-- SECTION: Informasi Surat --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">1</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Informasi Surat</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Diterima <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_penerimaan" value="{{ old('tanggal_penerimaan') }}" required
                           class="w-full px-3 py-2.5 text-sm border @error('tanggal_penerimaan') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('tanggal_penerimaan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" required placeholder="Nomor surat masuk"
                           class="w-full px-3 py-2.5 text-sm border @error('nomor_surat') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('nomor_surat')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required
                           class="w-full px-3 py-2.5 text-sm border @error('tanggal_surat') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('tanggal_surat')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Pengirim (Dari Instansi/Orang) <span class="text-red-500">*</span></label>
                    <input type="text" name="pengirim" value="{{ old('pengirim') }}" required placeholder="Nama instansi / pengirim surat"
                           class="w-full px-3 py-2.5 text-sm border @error('pengirim') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    @error('pengirim')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- SECTION: Isi & Disposisi --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Isi & Disposisi</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Isi Singkat / Perihal <span class="text-red-500">*</span></label>
                    <textarea name="isi_singkat" rows="3" required placeholder="Tuliskan ringkasan isi surat..."
                              class="w-full px-3 py-2.5 text-sm border @error('isi_singkat') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('isi_singkat') }}</textarea>
                    @error('isi_singkat')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Disposisi (Instruksi/Diteruskan ke)</label>
                    <input type="text" name="disposisi" value="{{ old('disposisi') }}" placeholder="Contoh: Diteruskan ke Kasi Pemerintahan"
                           class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="2" placeholder="Keterangan tambahan (opsional)..."
                              class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.agenda-surat-masuk.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Surat
            </button>
        </div>
    </form>
</div>

@endsection