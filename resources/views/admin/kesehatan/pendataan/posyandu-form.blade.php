@extends('layouts.admin')
@section('title', isset($posyandu) ? 'Edit Posyandu' : 'Tambah Posyandu')

@section('content')

{{-- Sub-tab Pendataan --}}
<div class="flex gap-2 mb-6">
    <a href="/admin/kesehatan/pendataan/posyandu"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-emerald-100 text-emerald-700">
        Posyandu
    </a>
    <a href="/admin/kesehatan/pendataan/kia"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors text-gray-600 hover:bg-gray-100">
        Kesehatan Ibu &amp; Anak (KIA)
    </a>
</div>

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.pendataan.posyandu') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h3 class="text-base font-semibold text-gray-900">{{ isset($posyandu) ? 'Edit Posyandu: ' .
            $posyandu->nama_posyandu : 'Tambah Posyandu Baru' }}</h3>
        <p class="text-sm text-gray-500">Data posyandu desa</p>
    </div>
</div>

@if($errors->any())
<div class="p-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    <p class="font-semibold mb-1">Terdapat kesalahan input:</p>
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST"
    action="{{ isset($posyandu) ? route('admin.kesehatan.pendataan.posyandu.update', $posyandu) : route('admin.kesehatan.pendataan.posyandu.store') }}">
    @csrf
    @if(isset($posyandu)) @method('PUT') @endif

    <div class="space-y-6">

        {{-- Informasi Dasar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-5">Informasi Dasar</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Posyandu <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_posyandu" required
                        value="{{ old('nama_posyandu', $posyandu->nama_posyandu ?? '') }}"
                        placeholder="Contoh: Posyandu Melati I"
                        class="w-full px-4 py-2.5 text-sm border @error('nama_posyandu') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                    @error('nama_posyandu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span
                            class="text-red-500">*</span></label>
                    <select name="status_posyandu" required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="aktif" {{ old('status_posyandu', $posyandu->status_posyandu ?? 'aktif') ===
                            'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status_posyandu', $posyandu->status_posyandu ?? '') ===
                            'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $posyandu->alamat ?? '') }}"
                        placeholder="Alamat lengkap posyandu"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Dusun</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $posyandu->dusun ?? '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">RT</label>
                    <input type="text" name="rt" maxlength="5" value="{{ old('rt', $posyandu->rt ?? '') }}"
                        placeholder="001"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">RW</label>
                    <input type="text" name="rw" maxlength="5" value="{{ old('rw', $posyandu->rw ?? '') }}"
                        placeholder="001"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>
        </div>

        {{-- Kegiatan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-5">Jadwal Kegiatan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Hari Kegiatan</label>
                    <select name="hari_kegiatan"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-white">
                        <option value="">-- Pilih Hari --</option>
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                        <option value="{{ $hari }}" {{ old('hari_kegiatan', $posyandu->hari_kegiatan ?? '') === $hari ?
                            'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Mulai</label>
                    <input type="time" name="jam_mulai"
                        value="{{ old('jam_mulai', isset($posyandu) ? substr($posyandu->jam_mulai ?? '', 0, 5) : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Selesai</label>
                    <input type="time" name="jam_selesai"
                        value="{{ old('jam_selesai', isset($posyandu) ? substr($posyandu->jam_selesai ?? '', 0, 5) : '') }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Kader</label>
                    <input type="number" name="jumlah_kader" min="0"
                        value="{{ old('jumlah_kader', $posyandu->jumlah_kader ?? 0) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab"
                        value="{{ old('penanggung_jawab', $posyandu->penanggung_jawab ?? '') }}"
                        placeholder="Nama bidan / petugas"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div class="md:col-span-2 lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Keterangan tambahan..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition resize-none">{{ old('keterangan', $posyandu->keterangan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($posyandu) ? 'Simpan Perubahan' : 'Tambah Posyandu' }}
            </button>
            <a href="{{ route('admin.kesehatan.pendataan.posyandu') }}"
                class="px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                Batal
            </a>
        </div>
    </div>
</form>
@endsection