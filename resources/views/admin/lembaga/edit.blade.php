@extends('layouts.admin')

@section('title', 'Edit Lembaga')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="mb-6">
        <div class="text-sm text-gray-500 mb-1">
            Info Desa <span class="mx-1">&rsaquo;</span> 
            <a href="{{ route('admin.lembaga.index') }}" class="hover:text-emerald-600 transition">Master Lembaga</a> <span class="mx-1">&rsaquo;</span> 
            <span class="text-emerald-600 font-semibold">Edit: {{ $lembaga->singkatan ?? $lembaga->nama }}</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Perbarui Data Lembaga</h2>
        <p class="text-sm text-gray-500 mt-1">Lakukan perubahan pada data lembaga jika ada penyesuaian.</p>
    </div>
        
    <form action="{{ route('admin.lembaga.update', $lembaga->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 flex flex-col items-center justify-center text-center shadow-sm h-full min-h-[300px]">
                    <div class="w-32 h-32 bg-amber-50 border-2 border-dashed border-amber-200 rounded-2xl flex flex-col items-center justify-center text-amber-500 mb-4">
                        <span class="text-4xl font-black">{{ substr($lembaga->singkatan ?? $lembaga->nama, 0, 2) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 max-w-[200px]">Representasi visual lembaga secara default.</p>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-6 pb-3 border-b border-gray-100">IDENTITAS LEMBAGA</h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lembaga <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $lembaga->nama) }}" required class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                            @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Singkatan</label>
                                <input type="text" name="singkatan" value="{{ old('singkatan', $lembaga->singkatan) }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kategori Bidang</label>
                                <select name="jenis" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Sosial" {{ $lembaga->jenis == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                    <option value="Pendidikan" {{ $lembaga->jenis == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Ekonomi" {{ $lembaga->jenis == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                    <option value="Keagamaan" {{ $lembaga->jenis == 'Keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                                    <option value="Lainnya" {{ $lembaga->jenis == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Deskripsi / Keterangan</label>
                            <textarea name="keterangan" rows="4" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">{{ old('keterangan', $lembaga->keterangan) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.lembaga.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition shadow-sm">
                            Perbarui Data
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection