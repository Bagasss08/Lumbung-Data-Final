@extends('layouts.admin')

@section('title', 'Edit Anggota Rumah Tangga')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.rumah-tangga-anggota.index', $rumahTangga) }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Edit Anggota Rumah Tangga</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui hubungan untuk {{ $anggota->penduduk->nama }}</p>
        </div>

        <form action="{{ route('admin.rumah-tangga-anggota.update', [$rumahTangga, $anggota]) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Informasi Anggota -->
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <span class="text-emerald-700 text-xs font-bold">1</span>
                    </div>
                    Informasi Anggota
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- NIK -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">NIK</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $anggota->penduduk->nik }}</p>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $anggota->penduduk->nama }}</p>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                            {{ $anggota->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                            {{ $anggota->penduduk->tanggal_lahir->format('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hubungan -->
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-blue-700 text-xs font-bold">2</span>
                    </div>
                    Hubungan Keluarga
                </h4>
                <div class="grid grid-cols-1 gap-4">
                    <!-- Hubungan -->
                    <div>
                        <label for="hubungan" class="block text-xs font-medium text-gray-700 mb-2">
                            Hubungan dengan Kepala Rumah Tangga <span class="text-red-500">*</span>
                        </label>
                        <select id="hubungan" name="hubungan"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('hubungan') border-red-500 @enderror"
                            required>
                            <option value="">Pilih hubungan</option>
                            <option value="kepala_rumah_tangga" {{ old('hubungan', $anggota->hubungan) == 'kepala_rumah_tangga' ? 'selected' : '' }}>Kepala Rumah Tangga</option>
                            <option value="istri" {{ old('hubungan', $anggota->hubungan) == 'istri' ? 'selected' : '' }}>Istri</option>
                            <option value="suami" {{ old('hubungan', $anggota->hubungan) == 'suami' ? 'selected' : '' }}>Suami</option>
                            <option value="anak" {{ old('hubungan', $anggota->hubungan) == 'anak' ? 'selected' : '' }}>Anak</option>
                            <option value="orang_tua" {{ old('hubungan', $anggota->hubungan) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="saudara" {{ old('hubungan', $anggota->hubungan) == 'saudara' ? 'selected' : '' }}>Saudara</option>
                            <option value="lainnya" {{ old('hubungan', $anggota->hubungan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('hubungan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.rumah-tangga-anggota.index', $rumahTangga) }}"
                    class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
