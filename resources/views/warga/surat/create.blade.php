@extends('layouts.app')

@section('title', 'Buat Permohonan Surat')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <div class="mb-6">
        <a href="{{ route('warga.surat.index') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 transition font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Riwayat
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            
            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                <h1 class="text-xl font-bold text-slate-800">Formulir Pengajuan Surat</h1>
                <p class="text-slate-500 text-sm mt-1">Silakan lengkapi data di bawah ini untuk mengajukan surat.</p>
            </div>

            <form action="{{ route('warga.surat.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-4">
                    <div class="mt-1">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-blue-800">Data Pemohon</h3>
                        <div class="mt-1 text-sm text-blue-700 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-1">
                            <p><span class="font-medium">Nama:</span> {{ Auth::user()->penduduk->nama ?? Auth::user()->name }}</p>
                            <p><span class="font-medium">NIK:</span> {{ Auth::user()->penduduk->nik ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    
                    <div>
                        <label for="jenis_surat" class="block text-sm font-bold text-slate-700 mb-2">Jenis Surat</label>
                        <select name="jenis_surat" id="jenis_surat" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                            <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu (SKTM)</option>
                            <option value="Surat Pengantar Nikah">Surat Pengantar Nikah (N1-N4)</option>
                            <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                            <option value="Surat Keterangan Kelakuan Baik">Surat Pengantar SKCK</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="keperluan" class="block text-sm font-bold text-slate-700 mb-2">Keperluan / Keterangan</label>
                        <textarea name="keperluan" id="keperluan" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none" placeholder="Contoh: Untuk persyaratan melamar pekerjaan di PT..." required></textarea>
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Dokumen Pendukung (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <label for="file_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                    <span>Upload file</span>
                                    <input id="file_upload" name="file" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">atau tarik file ke sini</p>
                            </div>
                            <p class="text-xs text-slate-500">
                                PNG, JPG, PDF hingga 2MB (KTP/KK/Pengantar RT)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('warga.surat.index') }}" class="px-6 py-2.5 rounded-xl text-slate-600 font-medium hover:bg-slate-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 hover:shadow-emerald-600/40 transition transform hover:-translate-y-0.5">
                        Kirim Permohonan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection