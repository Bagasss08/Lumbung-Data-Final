@extends('layouts.admin')

@section('title', 'Konfirmasi Hapus Keluarga')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Konfirmasi Hapus Keluarga</h2>
            <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus keluarga ini?</p>
        </div>
        <a href="{{ route('admin.keluarga') }}"
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
                    Tindakan ini tidak dapat dibatalkan. Data keluarga yang dihapus akan hilang secara permanen.
                </p>
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Keluarga</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- No KK -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">No KK</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->no_kk }}</p>
            </div>

            <!-- Kepala Keluarga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kepala Keluarga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->kepalaKeluarga->nama ?? 'Tidak Ditemukan' }}</p>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->alamat }}</p>
            </div>

            <!-- Wilayah -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Wilayah</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->wilayah->nama ?? 'Tidak Ditemukan' }}</p>
            </div>

            <!-- Tanggal Terdaftar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Terdaftar</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->tgl_terdaftar->format('d/m/Y') }}</p>
            </div>



            <!-- Klasifikasi Ekonomi -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Klasifikasi Ekonomi</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->klasifikasi_ekonomi }}</p>
            </div>

            <!-- Jenis Bantuan Aktif -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Bantuan Aktif</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->jenis_bantuan_aktif }}</p>
            </div>

            <!-- Total Anggota -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Total Anggota</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $keluarga->getTotalAnggota() }}</p>
            </div>
        </div>

        <!-- Anggota Keluarga Section -->
        <div class="mt-6">
            <h4 class="text-md font-semibold text-slate-800 mb-4">Anggota Keluarga</h4>
            <div class="bg-slate-50 rounded-lg p-4">
                @if($keluarga->anggota->count() > 0)
                    <div class="space-y-2">
                        @foreach($keluarga->anggota as $anggota)
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-slate-200">
                            <div>
                                <p class="text-sm font-medium text-slate-900">{{ $anggota->nama }}</p>
                                <p class="text-xs text-slate-600">NIK: {{ $anggota->nik }}</p>
                            </div>
                            <span class="text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $anggota->pivot->hubungan_keluarga)) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500">Tidak ada anggota keluarga</p>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.keluarga') }}"
               class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 transition duration-200">
                Batal
            </a>
            <form action="{{ route('admin.keluarga.destroy', $keluarga) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200">
                    Ya, Hapus Keluarga
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
