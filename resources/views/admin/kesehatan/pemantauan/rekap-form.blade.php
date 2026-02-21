@extends('layouts.admin')
@section('title', isset($rekap) ? 'Edit Rekap Kesehatan ' . $rekap->tahun : 'Tambah Rekap Kesehatan')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.kesehatan.pemantauan') }}"
        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <h3 class="text-base font-semibold text-gray-900">{{ isset($rekap) ? 'Edit Rekap Tahun '.$rekap->tahun : 'Tambah
        Rekap Kesehatan Tahunan' }}</h3>
</div>

@if($errors->any())
<div class="p-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
    <p class="font-semibold mb-1">Perbaiki kesalahan berikut:</p>
    <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form method="POST"
    action="{{ isset($rekap) ? route('admin.kesehatan.pemantauan.rekap.update', $rekap) : route('admin.kesehatan.pemantauan.rekap.store') }}">
    @csrf
    @if(isset($rekap)) @method('PUT') @endif

    <div class="space-y-6">

        {{-- Tahun --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="max-w-xs">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun <span
                        class="text-red-500">*</span></label>
                <input type="number" name="tahun" required min="2000" max="2100"
                    value="{{ old('tahun', $rekap->tahun ?? date('Y')) }}"
                    class="w-full px-4 py-2.5 text-sm border @error('tahun') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                @error('tahun')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Fasilitas Kesehatan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Fasilitas Kesehatan</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach([
                ['jumlah_puskesmas','Puskesmas'],
                ['jumlah_pustu','Puskesmas Pembantu'],
                ['jumlah_posyandu','Posyandu'],
                ['jumlah_polindes','Polindes'],
                ] as [$name,$label])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
                    <input type="number" name="{{ $name }}" min="0" value="{{ old($name, $rekap->{$name} ?? 0) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Tenaga Kesehatan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Tenaga Kesehatan</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach([
                ['jumlah_dokter','Dokter'],
                ['jumlah_bidan','Bidan'],
                ['jumlah_perawat','Perawat'],
                ['jumlah_kader_aktif','Kader Aktif'],
                ] as [$name,$label])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
                    <input type="number" name="{{ $name }}" min="0" value="{{ old($name, $rekap->{$name} ?? 0) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Sasaran Populasi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Sasaran Populasi</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                @foreach([
                ['jumlah_ibu_hamil','Ibu Hamil'],
                ['jumlah_balita','Balita (0-5 thn)'],
                ['jumlah_bayi','Bayi (0-11 bln)'],
                ['jumlah_anak_pra_sekolah','Anak Pra Sekolah'],
                ['jumlah_lansia','Lansia (>60 thn)'],
                ] as [$name,$label])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
                    <input type="number" name="{{ $name }}" min="0" value="{{ old($name, $rekap->{$name} ?? 0) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Kasus Penyakit --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-5">Kasus Penyakit</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-5">
                @foreach([
                ['kasus_diare','Diare'],
                ['kasus_ispa','ISPA'],
                ['kasus_dbd','DBD'],
                ['kasus_tb','TB Paru'],
                ['kasus_malaria','Malaria'],
                ['kasus_hipertensi','Hipertensi'],
                ['kasus_diabetes','Diabetes'],
                ] as [$name,$label])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
                    <input type="number" name="{{ $name }}" min="0" value="{{ old($name, $rekap->{$name} ?? 0) }}"
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Cakupan Program --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Cakupan Program (%)</h4>
            <p class="text-xs text-gray-400 mb-5">Isi dalam persen (0-100)</p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                @foreach([
                ['cakupan_imunisasi_dasar','Imunisasi Dasar'],
                ['cakupan_asi_eksklusif','ASI Eksklusif'],
                ['cakupan_kia','Cakupan KIA'],
                ['prevalensi_stunting','Prevalensi Stunting'],
                ['prevalensi_gizi_buruk','Gizi Buruk'],
                ] as [$name,$label])
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ $label }}</label>
                    <div class="relative">
                        <input type="number" name="{{ $name }}" step="0.1" min="0" max="100"
                            value="{{ old($name, $rekap->{$name} ?? '') }}"
                            class="w-full px-4 py-2.5 pr-8 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($rekap) ? 'Simpan Perubahan' : 'Tambah Rekap' }}
            </button>
            <a href="{{ route('admin.kesehatan.pemantauan') }}"
                class="px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
        </div>
    </div>
</form>
@endsection