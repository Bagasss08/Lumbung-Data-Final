{{--
File ini digunakan untuk BOTH create dan edit.
Jika $calonPemilih ada = edit mode
Jika tidak ada = create mode
--}}
@extends('layouts.admin')

@section('title', isset($calonPemilih) ? 'Edit Calon Pemilih' : 'Tambah Calon Pemilih')

@section('content')

@php
$isEdit = isset($calonPemilih);
$action = $isEdit
? route('admin.calon-pemilih.update', $calonPemilih)
: route('admin.calon-pemilih.store');
@endphp

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.calon-pemilih.index') }}" class="hover:text-emerald-600 transition-colors">Calon
        Pemilih</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium">{{ $isEdit ? 'Edit: ' . $calonPemilih->nama : 'Tambah Calon Pemilih'
        }}</span>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Form Header --}}
        <div
            class="px-6 py-4 border-b border-gray-100 {{ $isEdit ? 'bg-gradient-to-r from-amber-50 to-orange-50' : 'bg-gradient-to-r from-emerald-50 to-teal-50' }}">
            <div class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-lg {{ $isEdit ? 'bg-amber-100' : 'bg-emerald-100' }} flex items-center justify-center">
                    @if($isEdit)
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    @else
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    @endif
                </div>
                <h3 class="text-sm font-semibold text-gray-700">
                    {{ $isEdit ? 'Edit Data Calon Pemilih' : 'Tambah Calon Pemilih Baru' }}
                </h3>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($isEdit) @method('PUT') @endif

                {{-- Section: Identitas Dasar --}}
                <div class="mb-6">
                    <h4
                        class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Identitas Dasar
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- NIK --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                NIK <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" maxlength="16"
                                value="{{ old('nik', $calonPemilih->nik ?? '') }}" placeholder="16 digit NIK"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all font-mono tracking-wider
                                       {{ $errors->has('nik') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                            @error('nik')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        {{-- No. KK --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Kartu Keluarga</label>
                            <input type="text" name="no_kk" maxlength="16"
                                value="{{ old('no_kk', $calonPemilih->no_kk ?? '') }}" placeholder="16 digit No. KK"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all font-mono tracking-wider">
                        </div>
                        {{-- Nama --}}
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', $calonPemilih->nama ?? '') }}"
                                placeholder="Nama sesuai KTP"
                                class="w-full px-4 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all
                                       {{ $errors->has('nama') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                            @error('nama')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        {{-- Tempat Lahir --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $calonPemilih->tempat_lahir ?? '') }}"
                                placeholder="Kota/kabupaten"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        {{-- Tgl Lahir --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', isset($calonPemilih) ? $calonPemilih->tanggal_lahir?->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="1" class="peer sr-only" {{
                                        old('jenis_kelamin', $calonPemilih->jenis_kelamin ?? '') == '1' ? 'checked' : ''
                                    }}>
                                    <div
                                        class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all text-sm text-gray-600 peer-checked:text-blue-700 font-medium">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                                        </svg>
                                        L
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="jenis_kelamin" value="2" class="peer sr-only" {{
                                        old('jenis_kelamin', $calonPemilih->jenis_kelamin ?? '') == '2' ? 'checked' : ''
                                    }}>
                                    <div
                                        class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl border-2 border-gray-200 peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all text-sm text-gray-600 peer-checked:text-pink-600 font-medium">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                                        </svg>
                                        P
                                    </div>
                                </label>
                            </div>
                        </div>
                        {{-- Status Perkawinan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status Perkawinan</label>
                            <select name="status_perkawinan"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                <option value="">-- Pilih --</option>
                                @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $s)
                                <option value="{{ $s }}" {{ old('status_perkawinan', $calonPemilih->status_perkawinan ??
                                    '') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Section: Alamat --}}
                <div class="mb-6">
                    <h4
                        class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Alamat
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $calonPemilih->alamat ?? '') }}"
                                placeholder="Jalan / Gang / No. Rumah"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">RT</label>
                                <input type="text" name="rt" maxlength="4"
                                    value="{{ old('rt', $calonPemilih->rt ?? '') }}" placeholder="001"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-center font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">RW</label>
                                <input type="text" name="rw" maxlength="4"
                                    value="{{ old('rw', $calonPemilih->rw ?? '') }}" placeholder="001"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-center font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dusun</label>
                                <input type="text" name="dusun" value="{{ old('dusun', $calonPemilih->dusun ?? '') }}"
                                    placeholder="Nama dusun"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section: Keterangan & Status --}}
                <div class="mb-6">
                    <h4
                        class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-100">
                        Keterangan & Status
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                            <input type="text" name="keterangan"
                                value="{{ old('keterangan', $calonPemilih->keterangan ?? '') }}"
                                placeholder="Catatan tambahan (opsional)"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <div class="relative">
                                <input type="checkbox" name="aktif" value="1" class="sr-only peer" {{ old('aktif',
                                    $calonPemilih->aktif ?? true) ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-emerald-500 transition-colors">
                                </div>
                                <div
                                    class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all peer-checked:translate-x-5">
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Aktif sebagai calon pemilih</p>
                                <p class="text-xs text-gray-400">Akan masuk dalam rekap data DPT</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200
                               {{ $isEdit ? 'bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600' : 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $isEdit ? 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12' : 'M5 13l4 4L19 7' }}" />
                        </svg>
                        {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
                    </button>
                    <a href="{{ route('admin.calon-pemilih.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </a>
                    @if($isEdit)
                    <a href="{{ route('admin.calon-pemilih.show', $calonPemilih) }}"
                        class="ml-auto px-4 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Lihat Detail
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

@endsection