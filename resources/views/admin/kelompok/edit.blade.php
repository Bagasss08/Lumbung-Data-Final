@extends('layouts.admin')

@section('title', 'Edit Kelompok')

@section('content')

<div class="mb-6">
    <nav class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.kelompok.index') }}" class="hover:text-emerald-600 transition">Data Kelompok</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.kelompok.show', $kelompok) }}" class="hover:text-emerald-600 transition">{{
            $kelompok->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Edit</span>
    </nav>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-semibold text-gray-800">Edit Data Kelompok</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $kelompok->nama }}</p>
        </div>

        <form method="POST" action="{{ route('admin.kelompok.update', $kelompok) }}" class="p-6 space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenis Kelompok <span
                            class="text-red-500">*</span></label>
                    <select name="id_kelompok_master" required
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">-- Pilih Jenis Kelompok --</option>
                        @foreach($masterList as $m)
                        <option value="{{ $m->id }}" {{ old('id_kelompok_master', $kelompok->id_kelompok_master) ==
                            $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kelompok <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $kelompok->nama) }}" required
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Singkatan</label>
                    <input type="text" name="singkatan" value="{{ old('singkatan', $kelompok->singkatan) }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Terbentuk</label>
                    <input type="date" name="tgl_terbentuk"
                        value="{{ old('tgl_terbentuk', optional($kelompok->tgl_terbentuk)->format('Y-m-d')) }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <select name="aktif"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="1" {{ old('aktif', $kelompok->aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('aktif', $kelompok->aktif) == '0' ? 'selected' : '' }}>Tidak Aktif
                        </option>
                    </select>
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Surat Keputusan (SK)</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. SK Desa</label>
                        <input type="text" name="sk_desa" value="{{ old('sk_desa', $kelompok->sk_desa) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal SK Desa</label>
                        <input type="date" name="tgl_sk_desa"
                            value="{{ old('tgl_sk_desa', optional($kelompok->tgl_sk_desa)->format('Y-m-d')) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. SK Kabupaten</label>
                        <input type="text" name="sk_kabupaten"
                            value="{{ old('sk_kabupaten', $kelompok->sk_kabupaten) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal SK Kabupaten</label>
                        <input type="date" name="tgl_sk_kabupaten"
                            value="{{ old('tgl_sk_kabupaten', optional($kelompok->tgl_sk_kabupaten)->format('Y-m-d')) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Ketua & Kontak</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">NIK Ketua</label>
                        <input type="text" name="nik_ketua" value="{{ old('nik_ketua', $kelompok->nik_ketua) }}"
                            maxlength="16"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Ketua</label>
                        <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $kelompok->nama_ketua) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $kelompok->telepon) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Sekretariat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $kelompok->alamat) }}"
                            class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('keterangan', $kelompok->keterangan) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:shadow-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Perbarui
                </button>
                <a href="{{ route('admin.kelompok.show', $kelompok) }}"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection