@extends('layouts.admin')
@section('title', 'Rincian C-Desa & Persil')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Rincian C-Desa #{{ $cdesa->nomor_cdesa }}</h1>
            <p class="text-sm text-gray-500 mt-1">Detail kepemilikan dan daftar bidang tanah (Persil)</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.pertanahan.c-desa.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-colors">
                Kembali
            </a>
            <button class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Buku
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-emerald-700 font-bold">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800">Identitas Kepemilikan</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nomor C-Desa</dt>
                            <dd class="text-lg font-bold text-emerald-600">{{ $cdesa->nomor_cdesa }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Tertera di Buku</dt>
                            <dd class="text-base font-medium text-gray-900">{{ $cdesa->nama_di_cdesa }}</dd>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pemilik Sah Saat Ini</dt>
                            <dd class="text-base font-medium text-gray-900">{{ $cdesa->nama_pemilik }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">NIK Pemilik</dt>
                            <dd class="text-sm text-gray-700">{{ $cdesa->nik_pemilik }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alamat / Domisili</dt>
                            <dd class="text-sm text-gray-700">{{ $cdesa->alamat_pemilik }}</dd>
                            @if($cdesa->jenis_pemilik == 'warga_luar')
                                <span class="mt-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-orange-100 text-orange-800">Data Warga Luar Desa</span>
                            @endif
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-semibold text-gray-800">Tambah Bidang Tanah (Persil)</h3>
                </div>
                <form action="{{ route('admin.pertanahan.c-desa.persil.store', $cdesa->id) }}" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">No. Persil <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_persil" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required placeholder="Cth: 001">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Kelas <span class="text-red-500">*</span></label>
                            <input type="text" name="kelas_tanah" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required placeholder="Cth: D-III">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Luas (M²) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="luas" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required placeholder="0">
                        </div>
                        <div class="md:col-span-1">
                            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-md text-sm font-medium shadow-sm transition">
                                + Simpan Persil
                            </button>
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Lokasi Detail (Blok/Dusun) <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" required placeholder="Cth: Blok Sawah Kidul RT 01 / RW 02">
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">Daftar Persil Tersimpan</h3>
                    <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $cdesa->persil->count() }} Bidang</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50/50 text-gray-500 text-xs font-semibold uppercase tracking-wider">
                            <tr>
                                <th class="py-3 px-6 border-b border-gray-100 text-center w-12">No</th>
                                <th class="py-3 px-6 border-b border-gray-100">No. Persil & Kelas</th>
                                <th class="py-3 px-6 border-b border-gray-100">Lokasi</th>
                                <th class="py-3 px-6 border-b border-gray-100 text-right">Luas (M²)</th>
                                <th class="py-3 px-6 border-b border-gray-100 text-center">Mutasi</th>
                                <th class="py-3 px-6 border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cdesa->persil as $key => $persil)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 px-6 text-center text-gray-500">{{ $key + 1 }}</td>
                                <td class="py-3 px-6">
                                    <p class="font-semibold text-gray-900">{{ $persil->nomor_persil }}</p>
                                    <p class="text-xs text-gray-500">Kelas: {{ $persil->kelas_tanah }}</p>
                                </td>
                                <td class="py-3 px-6 text-gray-700 text-xs">{{ $persil->lokasi }}</td>
                                <td class="py-3 px-6 text-right font-medium text-emerald-600">{{ number_format($persil->luas, 0, ',', '.') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="text-gray-600 font-semibold">{{ $persil->jumlah_mutasi }}x</span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <button class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1.5 rounded text-xs font-medium transition-colors" title="Mutasi Persil (Dalam Pengembangan)">
                                        Mutasi
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center">
                                    <p class="text-gray-500 text-sm">Belum ada persil tanah yang didaftarkan pada C-Desa ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
