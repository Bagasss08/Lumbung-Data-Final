@extends('layouts.admin')

@section('title', 'Konfirmasi Hapus Wilayah')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Konfirmasi Hapus Wilayah</h2>
            <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus wilayah ini?</p>
        </div>
        <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
           class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Warning Card -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-medium text-red-800 mb-2">Peringatan!</h3>
                <p class="text-sm text-red-700 mb-4">
                    Tindakan ini tidak dapat dibatalkan. Data wilayah yang dihapus akan hilang secara permanen.
                </p>
                @if($relatedPenduduk > 0 || $relatedKeluarga > 0 || $relatedRumahTangga > 0)
                <div class="bg-red-100 border border-red-300 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-red-800 mb-2">Data Terkait yang Akan Terpengaruh:</h4>
                    <ul class="text-sm text-red-700 space-y-1">
                        @if($relatedPenduduk > 0)
                        <li>• {{ $relatedPenduduk }} penduduk akan kehilangan data wilayah</li>
                        @endif
                        @if($relatedKeluarga > 0)
                        <li>• {{ $relatedKeluarga }} keluarga akan kehilangan data wilayah</li>
                        @endif
                        @if($relatedRumahTangga > 0)
                        <li>• {{ $relatedRumahTangga }} rumah tangga akan kehilangan data wilayah</li>
                        @endif
                    </ul>
                    <p class="text-sm text-red-700 mt-2 font-medium">
                        Hapus data terkait terlebih dahulu sebelum menghapus wilayah ini.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Wilayah</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nama Dusun -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Dusun</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $wilayah->dusun }}</p>
            </div>

            <!-- RW -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">RW</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $wilayah->rw }}</p>
            </div>

            <!-- RT -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">RT</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $wilayah->rt }}</p>
            </div>

            <!-- Ketua RW -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Ketua RW</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $wilayah->ketua_rw }}</p>
            </div>

            <!-- Ketua RT -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Ketua RT</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $wilayah->ketua_rt ?? '-' }}</p>
            </div>

            <!-- Jumlah KK -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah KK</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ number_format($wilayah->jumlah_kk) }}</p>
            </div>

            <!-- Laki-laki -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Laki-laki</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ number_format($wilayah->laki_laki) }}</p>
            </div>

            <!-- Perempuan -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Perempuan</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ number_format($wilayah->perempuan) }}</p>
            </div>

            <!-- Total Penduduk -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Total Penduduk</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ number_format($wilayah->jumlah_penduduk) }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
               class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 transition duration-200">
                Batal
            </a>
            @if($relatedPenduduk == 0 && $relatedKeluarga == 0 && $relatedRumahTangga == 0)
            <form action="{{ route('admin.info-desa.wilayah-administratif.destroy', $wilayah) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200">
                    Ya, Hapus Wilayah
                </button>
            </form>
            @else
            <button disabled
                    class="px-6 py-2 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed">
                Hapus Data Terkait Terlebih Dahulu
            </button>
            @endif
        </div>
    </div>
</div>
@endsection
