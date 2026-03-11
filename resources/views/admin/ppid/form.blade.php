@extends('layouts.admin')

@section('title', isset($ppid) ? 'Edit Dokumen' : 'Tambah Dokumen')

@section('content')

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">
                {{ isset($ppid) ? 'Edit Dokumen' : 'Tambah Dokumen' }}
            </h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                {{ isset($ppid) ? 'Perbarui data dokumen PPID' : 'Tambah dokumen informasi publik baru' }}
            </p>
        </div>
        <a href="{{ route('admin.ppid.index') }}"
           class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <form method="POST"
              action="{{ isset($ppid) ? route('admin.ppid.update', $ppid) : route('admin.ppid.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($ppid)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Judul Dokumen --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                        Judul Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul_dokumen"
                           value="{{ old('judul_dokumen', $ppid->judul_dokumen ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none
                                  @error('judul_dokumen') border-red-400 @enderror"
                           placeholder="Contoh: Peraturan Desa tentang Dana Desa 2025">
                    @error('judul_dokumen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Dokumen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                        Jenis Dokumen
                    </label>
                    <select name="ppid_jenis_dokumen_id"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none
                               @error('ppid_jenis_dokumen_id') border-red-400 @enderror">
                        <option value="">-- Pilih Jenis --</option>
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

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="aktif" {{ old('status', $ppid->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $ppid->status ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- Tahun --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Tahun</label>
                    <input type="number" name="tahun"
                           value="{{ old('tahun', $ppid->tahun ?? date('Y')) }}"
                           min="2000" max="2099"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none"
                           placeholder="{{ date('Y') }}">
                </div>

                {{-- Bulan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Bulan</label>
                    <select name="bulan"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                            <option value="{{ $i+1 }}"
                                {{ old('bulan', $ppid->bulan ?? '') == $i+1 ? 'selected' : '' }}>
                                {{ $bln }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Waktu Retensi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Waktu Retensi</label>
                    <input type="text" name="waktu_retensi"
                           value="{{ old('waktu_retensi', $ppid->waktu_retensi ?? '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none"
                           placeholder="Contoh: 2 Tahun, Permanen">
                </div>

                {{-- Tanggal Terbit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit"
                           value="{{ old('tanggal_terbit', isset($ppid->tanggal_terbit) ? $ppid->tanggal_terbit->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                {{-- File Upload --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Upload File</label>
                    @if(isset($ppid) && $ppid->file_path)
                        <div class="mb-3 flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-emerald-700 dark:text-emerald-400">File sudah ada.</span>
                            <a href="{{ Storage::url($ppid->file_path) }}" target="_blank"
                               class="text-sm text-emerald-600 hover:underline font-medium">Lihat file</a>
                            <span class="text-gray-400 text-xs">| Upload baru untuk mengganti</span>
                        </div>
                    @endif
                    <input type="file" name="file_path"
                           accept=".pdf,.doc,.docx,.jpg,.png"
                           class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-500 outline-none text-sm
                                  file:mr-4 file:py-1 file:px-3 file:rounded file:border-0
                                  file:text-sm file:font-medium file:bg-emerald-50 file:text-emerald-700
                                  hover:file:bg-emerald-100 cursor-pointer">
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-1.5">PDF, DOC, DOCX, JPG, PNG — maks. 10 MB</p>
                    @error('file_path')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-emerald-500 outline-none resize-none"
                              placeholder="Keterangan tambahan...">{{ old('keterangan', $ppid->keterangan ?? '') }}</textarea>
                </div>

            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.ppid.index') }}"
                   class="px-5 py-2.5 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-200 font-medium text-sm transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-medium text-sm transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ isset($ppid) ? 'Simpan Perubahan' : 'Tambah Dokumen' }}
                </button>
            </div>
        </form>
    </div>

@endsection

