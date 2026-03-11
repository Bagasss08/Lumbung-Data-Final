@extends('layouts.admin')

@section('title', isset($jenis) ? 'Edit Jenis Dokumen' : 'Tambah Jenis Dokumen')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                {{ isset($jenis) ? 'Edit Jenis Dokumen' : 'Tambah Jenis Dokumen' }}
            </h2>
        </div>
        <a href="{{ route('admin.ppid.jenis.index') }}"
           class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="max-w-lg bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <form method="POST"
              action="{{ isset($jenis) ? route('admin.ppid.jenis.update', $jenis) : route('admin.ppid.jenis.store') }}">
            @csrf
            @if(isset($jenis)) @method('PUT') @endif

            <div class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                        Nama Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $jenis->nama ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none
                                  @error('nama') border-red-400 @enderror"
                           placeholder="Contoh: Informasi Berkala, Informasi Serta Merta">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-emerald-500 outline-none resize-none"
                              placeholder="Deskripsi singkat jenis dokumen ini...">{{ old('keterangan', $jenis->keterangan ?? '') }}</textarea>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.ppid.jenis.index') }}"
                   class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 font-medium text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($jenis) ? 'Simpan Perubahan' : 'Tambah Jenis' }}
                </button>
            </div>
        </form>
    </div>

@endsection

