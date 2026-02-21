@extends('layouts.admin')

@section('title', 'Edit Keluarga')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="flex items-center justify-end">
        <a href="{{ route('admin.keluarga') }}"
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
            <h3 class="text-lg font-semibold text-gray-900">Edit Data Keluarga</h3>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi untuk <span class="font-medium text-gray-900">{{ $keluarga->no_kk }}</span></p>
        </div>

        <form action="{{ route('admin.keluarga.update', $keluarga) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Informasi Dasar -->
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <span class="text-emerald-700 text-xs font-bold">1</span>
                    </div>
                    Informasi Dasar
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- No KK -->
                    <div>
                        <label for="no_kk" class="block text-xs font-medium text-gray-700 mb-2">
                            No. KK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk', $keluarga->no_kk) }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('no_kk') border-red-500 @enderror"
                            placeholder="Masukkan nomor KK 16 digit" required maxlength="16">
                        @error('no_kk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kepala Keluarga -->
                    <div>
                        <label for="kepala_keluarga_id" class="block text-xs font-medium text-gray-700 mb-2">
                            Kepala Keluarga <span class="text-red-500">*</span>
                        </label>
                        <select id="kepala_keluarga_id" name="kepala_keluarga_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('kepala_keluarga_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih kepala keluarga</option>
                            @foreach($penduduk as $p)
                            <option value="{{ $p->id }}" {{ old('kepala_keluarga_id', $keluarga->getKepalaKeluarga()?->id) == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('kepala_keluarga_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Terdaftar -->
                    <div>
                        <label for="tgl_terdaftar" class="block text-xs font-medium text-gray-700 mb-2">
                            Tanggal Terdaftar <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tgl_terdaftar" name="tgl_terdaftar"
                            value="{{ old('tgl_terdaftar', $keluarga->tgl_terdaftar->format('Y-m-d')) }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('tgl_terdaftar') border-red-500 @enderror"
                            required>
                        @error('tgl_terdaftar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                </div>
            </div>

            <!-- Informasi Wilayah & Ekonomi -->
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="text-blue-700 text-xs font-bold">2</span>
                    </div>
                    Informasi Wilayah & Ekonomi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Wilayah -->
                    <div>
                        <label for="wilayah_id" class="block text-xs font-medium text-gray-700 mb-2">
                            Wilayah <span class="text-red-500">*</span>
                        </label>
                        <select id="wilayah_id" name="wilayah_id"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('wilayah_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih wilayah</option>
                            @foreach($wilayah as $w)
                            <option value="{{ $w->id }}" {{ old('wilayah_id', $keluarga->wilayah_id) == $w->id ? 'selected' : '' }}>
                                RT {{ $w->rt }} / RW {{ $w->rw }} - {{ $w->dusun }}
                            </option>
                            @endforeach
                        </select>
                        @error('wilayah_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Klasifikasi Ekonomi -->
                    <div>
                        <label for="klasifikasi_ekonomi" class="block text-xs font-medium text-gray-700 mb-2">
                            Klasifikasi Ekonomi
                        </label>
                        <select id="klasifikasi_ekonomi" name="klasifikasi_ekonomi"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Pilih klasifikasi</option>
                            <option value="miskin" {{ old('klasifikasi_ekonomi', $keluarga->klasifikasi_ekonomi) == 'miskin' ? 'selected' : '' }}>Miskin</option>
                            <option value="rentan" {{ old('klasifikasi_ekonomi', $keluarga->klasifikasi_ekonomi) == 'rentan' ? 'selected' : '' }}>Rentan</option>
                            <option value="mampu" {{ old('klasifikasi_ekonomi', $keluarga->klasifikasi_ekonomi) == 'mampu' ? 'selected' : '' }}>Mampu</option>
                        </select>
                        @error('klasifikasi_ekonomi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Bantuan Aktif -->
                    <div>
                        <label for="jenis_bantuan_aktif" class="block text-xs font-medium text-gray-700 mb-2">
                            Jenis Bantuan Aktif
                        </label>
                        <input type="text" id="jenis_bantuan_aktif" name="jenis_bantuan_aktif" value="{{ old('jenis_bantuan_aktif', $keluarga->jenis_bantuan_aktif) }}"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Contoh: PKH, BPNT">
                        @error('jenis_bantuan_aktif')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="mb-8">
                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <div class="w-6 h-6 bg-pink-100 rounded-lg flex items-center justify-center">
                        <span class="text-pink-700 text-xs font-bold">3</span>
                    </div>
                    Alamat Lengkap
                </h4>
                <div class="grid grid-cols-1 gap-4">
                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-xs font-medium text-gray-700 mb-2">
                            Alamat Lengkap
                        </label>
                        <textarea id="alamat" name="alamat" rows="3"
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Masukkan alamat lengkap">{{ old('alamat', $keluarga->alamat) }}</textarea>
                        @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.keluarga') }}"
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

@push('scripts')
<script>
    // Auto-format No KK input
    document.getElementById('no_kk')?.addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').substring(0, 16);
    });
</script>
@endpush

@endsection
