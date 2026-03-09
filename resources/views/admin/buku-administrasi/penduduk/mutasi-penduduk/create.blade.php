@extends('layouts.admin')
@section('title', 'Tambah Mutasi Penduduk')
@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Mutasi Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Tambah data pindah masuk atau keluar</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Beranda</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Mutasi Penduduk</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
    </nav>
</div>

<form method="POST" action="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.store') }}"
      class="space-y-6">
    @csrf

    {{-- PILIH PENDUDUK (Opsional) --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">
            Tautkan ke Data Penduduk <span class="text-gray-400 font-normal">(opsional)</span>
        </h3>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Pilih Penduduk</label>
            <select name="penduduk_id" id="penduduk_id"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                <option value="">-- Isi manual di bawah --</option>
                @foreach($pendudukList as $p)
                <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->nama }} — {{ $p->nik }}
                </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400 mt-1">Jika dipilih, NIK & Nama di bawah akan diabaikan. Kosongkan jika penduduk belum terdaftar.</p>
        </div>
    </div>

    {{-- DATA DIRI --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">Data Diri</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">NIK <span class="text-red-500">*</span></label>
                <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" placeholder="16 digit NIK"
                       class="w-full px-3 py-2.5 text-sm border @error('nik') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                @error('nik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap"
                       class="w-full px-3 py-2.5 text-sm border @error('nama') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">No. KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16" placeholder="16 digit No. KK"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota tempat lahir"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Agama</label>
                <select name="agama" class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    <option value="">-- Pilih --</option>
                    @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $agama)
                    <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- DATA MUTASI --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4 pb-3 border-b border-gray-100 dark:border-slate-700">Data Mutasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Mutasi <span class="text-red-500">*</span></label>
                <select name="jenis_mutasi" x-data x-model="jenisMutasi" class="w-full px-3 py-2.5 text-sm border @error('jenis_mutasi') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                    <option value="pindah_masuk" {{ old('jenis_mutasi', 'pindah_masuk') == 'pindah_masuk' ? 'selected' : '' }}>Pindah Masuk</option>
                    <option value="pindah_keluar" {{ old('jenis_mutasi') == 'pindah_keluar' ? 'selected' : '' }}>Pindah Keluar</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tanggal Mutasi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_mutasi" value="{{ old('tanggal_mutasi') }}"
                       class="w-full px-3 py-2.5 text-sm border @error('tanggal_mutasi') border-red-400 @else border-gray-200 dark:border-slate-600 @enderror rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                @error('tanggal_mutasi')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Asal (untuk pindah masuk)</label>
                <input type="text" name="asal" value="{{ old('asal') }}" placeholder="Desa/kota asal"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tujuan (untuk pindah keluar)</label>
                <input type="text" name="tujuan" value="{{ old('tujuan') }}" placeholder="Desa/kota tujuan"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">No. Surat</label>
                <input type="text" name="no_surat" value="{{ old('no_surat') }}" placeholder="Nomor surat keterangan"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Alasan</label>
                <input type="text" name="alasan" value="{{ old('alasan') }}" placeholder="Alasan pindah"
                       class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Keterangan tambahan..."
                          class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none">{{ old('keterangan') }}</textarea>
            </div>
        </div>
    </div>

    {{-- TOMBOL --}}
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.index') }}"
           class="px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            Batal
        </a>
        <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all hover:-translate-y-0.5">
            Simpan Data
        </button>
    </div>
</form>

@endsection