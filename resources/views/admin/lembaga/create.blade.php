@extends('layouts.admin')

@section('title', 'Tambah Lembaga')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="mb-6">
        <div class="text-sm text-gray-500 mb-1">
            Info Desa <span class="mx-1">&rsaquo;</span> 
            <a href="{{ route('admin.lembaga.index') }}" class="hover:text-emerald-600 transition">Master Lembaga</a> <span class="mx-1">&rsaquo;</span> 
            <span class="text-emerald-600 font-semibold">Tambah Lembaga</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Data Lembaga</h2>
        <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah ini untuk menambahkan data master lembaga baru.</p>
    </div>
        
    <form action="{{ route('admin.lembaga.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 flex flex-col items-center justify-center text-center shadow-sm h-full min-h-[300px]">
                    <div class="w-32 h-32 bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-2xl flex flex-col items-center justify-center text-emerald-500 mb-4">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-xs font-semibold">Ikon Lembaga</span>
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
                            <input type="text" name="nama" required placeholder="Masukkan nama lembaga..." class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                            @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Singkatan</label>
                                <input type="text" name="singkatan" placeholder="Contoh: PKK" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kategori Bidang</label>
                                <select name="jenis" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Sosial">Sosial</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Ekonomi">Ekonomi</option>
                                    <option value="Keagamaan">Keagamaan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Deskripsi / Keterangan</label>
                            <textarea name="keterangan" rows="4" placeholder="Tuliskan deskripsi lembaga..." class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm py-2.5"></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.lembaga.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Batal</a>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg transition shadow-sm">
                            Simpan Data
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection