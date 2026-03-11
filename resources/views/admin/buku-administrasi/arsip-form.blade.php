@extends('layouts.admin')

@section('title', isset($arsip) ? 'Edit Arsip Desa' : 'Tambah Arsip Desa')

@section('content')

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ isset($arsip) ? 'Edit Dokumen Arsip' : 'Tambah Dokumen Arsip' }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ isset($arsip) ? 'Perbarui data dokumen arsip desa' : 'Catat dokumen arsip desa baru' }}
                </p>
            </div>
            <a href="{{ route('admin.buku-administrasi.arsip.index') }}"
               class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300
                      rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors
                      font-medium text-sm flex items-center gap-2 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 max-w-3xl">

        <form method="POST"
              action="{{ isset($arsip)
                ? route('admin.buku-administrasi.arsip.update', $arsip->id)
                : route('admin.buku-administrasi.arsip.store') }}">
            @csrf
            @if(isset($arsip)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Dokumen (full width) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_dokumen"
                           value="{{ old('nama_dokumen', $arsip->nama_dokumen ?? '') }}"
                           placeholder="Contoh: SK Pengangkatan RT 001/2025"
                           class="w-full px-4 py-2.5 border rounded-lg outline-none transition-colors
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  {{ $errors->has('nama_dokumen')
                                      ? 'border-red-400 focus:ring-2 focus:ring-red-300'
                                      : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500' }}">
                    @error('nama_dokumen')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Jenis Dokumen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Jenis Dokumen <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_dokumen"
                            class="w-full px-4 py-2.5 border rounded-lg outline-none transition-colors
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                   {{ $errors->has('jenis_dokumen')
                                       ? 'border-red-400 focus:ring-2 focus:ring-red-300'
                                       : 'border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500' }}">
                        <option value="">-- Pilih Jenis Dokumen --</option>
                        @foreach($daftarJenis as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('jenis_dokumen', $arsip->jenis_dokumen ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_dokumen')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor Dokumen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nomor Dokumen
                        <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <input type="text" name="nomor_dokumen"
                           value="{{ old('nomor_dokumen', $arsip->nomor_dokumen ?? '') }}"
                           placeholder="Contoh: 001/SK-KADES/2025"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg outline-none
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>

                {{-- Tanggal Dokumen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tanggal Dokumen
                        <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <input type="date" name="tanggal_dokumen"
                           value="{{ old('tanggal_dokumen', isset($arsip->tanggal_dokumen) ? $arsip->tanggal_dokumen->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg outline-none
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>

                {{-- Lokasi Arsip --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Lokasi Arsip Fisik
                        <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <input type="text" name="lokasi_arsip"
                           value="{{ old('lokasi_arsip', $arsip->lokasi_arsip ?? '') }}"
                           placeholder="Contoh: Lemari A, Box 2"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg outline-none
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                  placeholder-gray-400 dark:placeholder-gray-500
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    <p class="text-xs text-gray-400 mt-1">Tempat penyimpanan dokumen fisik/hardcopy</p>
                </div>

                {{-- Keterangan (full width) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Keterangan
                        <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <textarea name="keterangan" rows="3"
                              placeholder="Keterangan tambahan mengenai dokumen ini..."
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg outline-none
                                     bg-white dark:bg-gray-700 text-gray-800 dark:text-white
                                     placeholder-gray-400 dark:placeholder-gray-500
                                     focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none">{{ old('keterangan', $arsip->keterangan ?? '') }}</textarea>
                </div>

            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.buku-administrasi.arsip.index') }}"
                   class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300
                          rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium text-sm transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700
                               font-medium text-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($arsip) ? 'Simpan Perubahan' : 'Tambah Arsip' }}
                </button>
            </div>

        </form>
    </div>

@endsection