@extends('layouts.admin')

@section('title', isset($ppid) ? 'Edit Dokumen' : 'Tambah Dokumen')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                Daftar Dokumen
                <span class="text-sm font-normal text-gray-400 dark:text-slate-500 ml-2">
                    {{ isset($ppid) ? 'Ubah Data' : 'Tambah Data' }}
                </span>
            </h2>
        </div>
        <a href="{{ route('admin.ppid.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Kembali Ke Daftar Dokumen
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <form method="POST"
              action="{{ isset($ppid) ? route('admin.ppid.update', $ppid) : route('admin.ppid.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($ppid)) @method('PUT') @endif

            {{-- Jenis Dokumen --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Jenis Dokumen
                </label>
                <div class="flex-1">
                    <select name="ppid_jenis_dokumen_id"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none
                               @error('ppid_jenis_dokumen_id') border-red-400 @enderror">
                        <option value="">Pilih Jenis Dokumen</option>
                        @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ old('ppid_jenis_dokumen_id', $ppid->ppid_jenis_dokumen_id ?? '') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('ppid_jenis_dokumen_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Judul Dokumen --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Judul Dokumen <span class="text-red-500">*</span>
                </label>
                <div class="flex-1">
                    <input type="text" name="judul_dokumen"
                           value="{{ old('judul_dokumen', $ppid->judul_dokumen ?? '') }}"
                           placeholder="Judul Dokumen"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none
                                  @error('judul_dokumen') border-red-400 @enderror">
                    @error('judul_dokumen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Retensi Dokumen (angka + satuan) --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Retensi Dokumen
                </label>
                <div class="flex-1">
                    <div class="flex gap-3">
                        <input type="number" name="retensi_nilai"
                               value="{{ old('retensi_nilai', $ppid->retensi_nilai ?? 0) }}"
                               min="0" max="9999"
                               placeholder="0"
                               class="w-36 px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                      bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                      focus:ring-2 focus:ring-emerald-500 outline-none">
                        <select name="retensi_satuan"
                            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                   bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                   focus:ring-2 focus:ring-emerald-500 outline-none">
                            @php
                                $satuanList = ['Hari', 'Minggu', 'Bulan', 'Tahun', 'Permanen'];
                                $currentSatuan = old('retensi_satuan', $ppid->retensi_satuan ?? 'Hari');
                            @endphp
                            @foreach($satuanList as $satuan)
                                <option value="{{ $satuan }}" {{ $currentSatuan == $satuan ? 'selected' : '' }}>
                                    {{ $satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-red-500 mt-1.5">Isi 0 jika tidak digunakan.</p>
                </div>
            </div>

            {{-- Tipe Dokumen --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Tipe Dokumen
                </label>
                <div class="flex-1">
                    <select name="tipe_dokumen"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="file"  {{ old('tipe_dokumen', $ppid->tipe_dokumen ?? 'file') == 'file'  ? 'selected' : '' }}>File</option>
                        <option value="link"  {{ old('tipe_dokumen', $ppid->tipe_dokumen ?? '')       == 'link'  ? 'selected' : '' }}>Link</option>
                    </select>
                </div>
            </div>

            {{-- Upload / File --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Unggah Dokumen
                </label>
                <div class="flex-1">
                    @if(isset($ppid) && $ppid->file_path)
                        {{-- Preview file yang sudah ada --}}
                        <div class="mb-3 flex items-center gap-4">
                            <div class="w-14 h-14 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-slate-400">
                                <a href="{{ Storage::url($ppid->file_path) }}" target="_blank"
                                   class="text-emerald-600 hover:underline font-medium break-all">
                                    {{ basename($ppid->file_path) }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="flex gap-2">
                        <input type="text" id="file_name_display"
                               placeholder="Pilih file..."
                               readonly
                               class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                      bg-gray-50 dark:bg-slate-700/50 text-gray-600 dark:text-slate-400 text-sm outline-none cursor-default">
                        <label for="file_upload"
                               class="inline-flex items-center gap-2 px-4 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-lg cursor-pointer transition-colors whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Browse
                        </label>
                        <input id="file_upload" type="file" name="file_path"
                               accept=".pdf,.doc,.docx,.xls,.xlsx"
                               class="hidden"
                               onchange="document.getElementById('file_name_display').value = this.files[0]?.name ?? ''">
                    </div>
                    <p class="text-xs text-red-500 mt-1.5">
                        Batas maksimal pengunggahan file: 10 MB. Hanya mendukung format dokumen (.pdf, .doc, .docx, .xls, .xlsx).
                    </p>
                    @error('file_path')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Keterangan
                </label>
                <div class="flex-1">
                    <textarea name="keterangan" rows="3"
                              placeholder="Keterangan"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ old('keterangan', $ppid->keterangan ?? '') }}</textarea>
                </div>
            </div>

            {{-- Tanggal Terbit --}}
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5 flex-shrink-0">
                    Tanggal Terbit
                </label>
                <div class="flex-1">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="date" name="tanggal_terbit"
                               value="{{ old('tanggal_terbit', isset($ppid->tanggal_terbit) ? $ppid->tanggal_terbit->format('Y-m-d') : date('Y-m-d')) }}"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                      bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                      focus:ring-2 focus:ring-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            {{-- Status Terbit (Ya / Tidak toggle) --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
                <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 flex-shrink-0">
                    Status Terbit
                </label>
                <div class="flex-1">
                    <div x-data="{ status: '{{ old('status', $ppid->status ?? 'aktif') }}' }" class="flex rounded-lg overflow-hidden border border-gray-300 dark:border-slate-600 w-fit">
                        <input type="hidden" name="status" :value="status">
                        <button type="button"
                            @click="status = 'aktif'"
                            :class="status === 'aktif'
                                ? 'bg-cyan-500 text-white'
                                : 'bg-white dark:bg-slate-700 text-gray-500 dark:text-slate-400 hover:bg-gray-50'"
                            class="px-8 py-2.5 text-sm font-medium transition-colors focus:outline-none">
                            Ya
                        </button>
                        <button type="button"
                            @click="status = 'tidak_aktif'"
                            :class="status === 'tidak_aktif'
                                ? 'bg-cyan-500 text-white'
                                : 'bg-white dark:bg-slate-700 text-gray-500 dark:text-slate-400 hover:bg-gray-50'"
                            class="px-8 py-2.5 text-sm font-medium transition-colors border-l border-gray-300 dark:border-slate-600 focus:outline-none">
                            Tidak
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between mt-6 pt-2">
                <a href="{{ route('admin.ppid.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>

        </form>
    </div>

@endsection