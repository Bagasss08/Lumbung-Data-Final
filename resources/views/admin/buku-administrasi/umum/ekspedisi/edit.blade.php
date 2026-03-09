@extends('layouts.admin')

@section('title', 'Kemaskini Data Ekspedisi')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.buku-administrasi.umum.ekspedisi.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-2 text-sm">
            &larr; Kembali ke Senarai
        </a>
        <h1 class="text-2xl font-semibold text-gray-800">Kemaskini Data Ekspedisi</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-4xl">
        <form action="{{ route('admin.buku-administrasi.umum.ekspedisi.update', $ekspedisi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarikh Penghantaran (Pengiriman) <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman', $ekspedisi->tanggal_pengiriman) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ditujukan Kepada <span class="text-red-500">*</span></label>
                    <input type="text" name="tujuan" value="{{ old('tujuan', $ekspedisi->tujuan) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarikh Surat <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $ekspedisi->tanggal_surat) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombor Surat <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $ekspedisi->nomor_surat) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Isi Ringkas Surat <span class="text-red-500">*</span></label>
                <textarea name="isi_singkat" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('isi_singkat', $ekspedisi->isi_singkat) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Pilihan)</label>
                <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500">{{ old('keterangan', $ekspedisi->keterangan) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.buku-administrasi.umum.ekspedisi.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">Kemaskini Data</button>
            </div>
        </form>
    </div>
@endsection