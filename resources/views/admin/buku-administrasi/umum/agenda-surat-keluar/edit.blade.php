@extends('layouts.admin')

@section('title', 'Edit Surat Keluar')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.agenda-surat-keluar.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Edit Surat Keluar</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-4xl">
        <form action="{{ route('admin.buku-administrasi.umum.agenda-surat-keluar.update', $suratKeluar->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengiriman <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman', $suratKeluar->tanggal_pengiriman) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $suratKeluar->nomor_surat) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $suratKeluar->tanggal_surat) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ditujukan Kepada <span class="text-red-500">*</span></label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', $suratKeluar->tujuan) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Singkat / Perihal <span class="text-red-500">*</span></label>
                <textarea name="isi_singkat" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('isi_singkat', $suratKeluar->isi_singkat) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('keterangan', $suratKeluar->keterangan) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.buku-administrasi.umum.agenda-surat-keluar.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Perbarui Surat</button>
            </div>
        </form>
    </div>
@endsection