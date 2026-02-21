@extends('layouts.admin')

@section('title', 'Edit Rumah Tangga')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">Edit Rumah Tangga</h1>
    <p class="text-slate-600">Perbarui data rumah tangga</p>
</div>

{{-- Breadcrumb --}}
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.rumah-tangga.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-emerald-600">
                    <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2A1 1 0 0 0 1 10h2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8h2a1 1 0 0 0 .707-1.707Z"/>
                    </svg>
                    Data Rumah Tangga
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

{{-- Form --}}
<div class="bg-white rounded-xl border shadow-sm">
    <div class="p-6">
        <form method="POST" action="{{ route('admin.rumah-tangga.update', $rumahTangga) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- No Rumah Tangga --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Rumah Tangga</label>
                    <input type="text" name="no_rumah_tangga" value="{{ old('no_rumah_tangga', $rumahTangga->no_rumah_tangga) }}"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('no_rumah_tangga') border-red-500 @enderror"
                        placeholder="RT001" required>
                    @error('no_rumah_tangga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kepala Rumah Tangga --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kepala Rumah Tangga</label>
                    <select name="kepala_rumah_tangga"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('kepala_rumah_tangga') border-red-500 @enderror" required>
                        <option value="">Pilih Kepala Rumah Tangga</option>
                        @foreach($penduduk as $p)
                            <option value="{{ $p->id }}" {{ old('kepala_rumah_tangga', $rumahTangga->kepala_rumah_tangga) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kepala_rumah_tangga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Tinggal</label>
                    <textarea name="alamat" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('alamat') border-red-500 @enderror"
                        placeholder="Jl. Contoh No. 123">{{ old('alamat', $rumahTangga->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Wilayah --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Wilayah</label>
                    <select name="wilayah_id"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('wilayah_id') border-red-500 @enderror" required>
                        <option value="">Pilih Wilayah</option>
                        @foreach($wilayah as $w)
                            <option value="{{ $w->id }}" {{ old('wilayah_id', $rumahTangga->wilayah_id) == $w->id ? 'selected' : '' }}>
                                RT {{ $w->rt }} / RW {{ $w->rw }} - {{ $w->dusun }}
                            </option>
                        @endforeach
                    </select>
                    @error('wilayah_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah Anggota --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Anggota</label>
                    <input type="number" name="jumlah_anggota" value="{{ old('jumlah_anggota', $rumahTangga->jumlah_anggota) }}" min="1"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('jumlah_anggota') border-red-500 @enderror" required>
                    @error('jumlah_anggota')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Klasifikasi Ekonomi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Klasifikasi Ekonomi</label>
                    <select name="klasifikasi_ekonomi"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('klasifikasi_ekonomi') border-red-500 @enderror">
                        <option value="">Pilih Klasifikasi</option>
                        <option value="miskin" {{ old('klasifikasi_ekonomi', $rumahTangga->klasifikasi_ekonomi) == 'miskin' ? 'selected' : '' }}>Miskin</option>
                        <option value="rentan" {{ old('klasifikasi_ekonomi', $rumahTangga->klasifikasi_ekonomi) == 'rentan' ? 'selected' : '' }}>Rentan</option>
                        <option value="mampu" {{ old('klasifikasi_ekonomi', $rumahTangga->klasifikasi_ekonomi) == 'mampu' ? 'selected' : '' }}>Mampu</option>
                    </select>
                    @error('klasifikasi_ekonomi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>



                {{-- Tanggal Terdaftar --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Terdaftar</label>
                    <input type="date" name="tgl_terdaftar" value="{{ old('tgl_terdaftar', $rumahTangga->tgl_terdaftar ? $rumahTangga->tgl_terdaftar->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('tgl_terdaftar') border-red-500 @enderror" required>
                    @error('tgl_terdaftar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Bantuan Aktif --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Bantuan Aktif</label>
                    <input type="text" name="jenis_bantuan_aktif" value="{{ old('jenis_bantuan_aktif', $rumahTangga->jenis_bantuan_aktif) }}"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-emerald-500 @error('jenis_bantuan_aktif') border-red-500 @enderror"
                        placeholder="PKH, BPNT, dll">
                    @error('jenis_bantuan_aktif')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                <a href="{{ route('admin.rumah-tangga.index') }}"
                    class="px-4 py-2 border text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
