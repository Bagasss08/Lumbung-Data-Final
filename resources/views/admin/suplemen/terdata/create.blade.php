@extends('layouts.admin')

@section('title', 'Tambah Terdata')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-500 mb-6 flex-wrap">
    <a href="{{ route('admin.suplemen.index') }}" class="hover:text-emerald-600 transition-colors">Data Suplemen</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <a href="{{ route('admin.suplemen.terdata.index', $suplemen) }}"
        class="hover:text-emerald-600 transition-colors truncate max-w-xs">{{ $suplemen->nama }}</a>
    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700 font-medium">Tambah Terdata</span>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700">Tambah Anggota Terdata</h3>
                    <p class="text-xs text-gray-500">Suplemen: <span class="font-medium text-emerald-600">{{
                            $suplemen->nama }}</span> · {{ $suplemen->sasaran_label }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.suplemen.terdata.store', $suplemen) }}" method="POST">
                @csrf

                @if($suplemen->sasaran == '1')
                {{-- Perorangan: pilih penduduk --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Penduduk (NIK / Nama) <span class="text-red-500">*</span>
                    </label>
                    <select name="id_pend" class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all
                                   {{ $errors->has('id_pend') ? 'border-red-300' : '' }}">
                        <option value="">-- Pilih Penduduk --</option>
                        @foreach($penduduk as $p)
                        <option value="{{ $p->nik }}" {{ old('id_pend')==$p->nik ? 'selected' : '' }}>
                            {{ $p->nik }} — {{ $p->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_pend')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    @if($penduduk->isEmpty())
                    <p class="mt-1.5 text-xs text-amber-600 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Semua penduduk sudah terdaftar di suplemen ini
                    </p>
                    @else
                    <p class="mt-1 text-xs text-gray-400">{{ $penduduk->count() }} penduduk tersedia</p>
                    @endif
                </div>
                @else
                {{-- Keluarga: input No. KK --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        No. Kartu Keluarga <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_kk" value="{{ old('no_kk') }}" maxlength="16"
                        placeholder="16 digit nomor KK" class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all font-mono tracking-wider
                                   {{ $errors->has('no_kk') ? 'border-red-300' : '' }}">
                    @error('no_kk')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                @endif

                {{-- Keterangan --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                        placeholder="Keterangan tambahan (opsional)"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-gray-50 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Tambahkan
                    </button>
                    <a href="{{ route('admin.suplemen.terdata.index', $suplemen) }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection