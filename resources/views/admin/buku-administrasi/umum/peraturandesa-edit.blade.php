@extends('layouts.admin')

@section('title', 'Edit Data Peraturan Desa')

@section('content')

    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.buku-administrasi.umum.index') }}" class="hover:text-emerald-600 transition-colors">Buku Administrasi Umum</a>
        <span>/</span>
        <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="hover:text-emerald-600 transition-colors">Peraturan Desa</a>
        <span>/</span>
        <span class="text-emerald-600 font-medium">Edit Data</span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-lg font-semibold text-gray-700 mb-1">Edit Data Peraturan Desa</p>
            <p class="text-sm text-gray-400">Lengkapi formulir di bawah ini untuk mengubah data peraturan desa</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.buku-administrasi.umum.peraturan-desa.update', $peraturan_desa->id) }}" method="POST" id="formPeraturan">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                <!-- Row 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Peraturan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nomor_ditetapkan" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('nomor_ditetapkan') border-red-500 @enderror" 
                               placeholder="Contoh: 001/PERDES/2026"
                               value="{{ old('nomor_ditetapkan', $peraturan_desa->nomor_ditetapkan) }}"
                               required>
                        @error('nomor_ditetapkan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Format: XXX/PERDES/TAHUN</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Peraturan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_peraturan" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('jenis_peraturan') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Jenis Peraturan</option>
                            <option value="Peraturan Desa" {{ old('jenis_peraturan', $peraturan_desa->jenis_peraturan) == 'Peraturan Desa' ? 'selected' : '' }}>
                                Peraturan Desa (PERDES)
                            </option>
                            <option value="Peraturan Kepala Desa" {{ old('jenis_peraturan', $peraturan_desa->jenis_peraturan) == 'Peraturan Kepala Desa' ? 'selected' : '' }}>
                                Peraturan Kepala Desa (PERKADES)
                            </option>
                        </select>
                        @error('jenis_peraturan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Peraturan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('judul') border-red-500 @enderror" 
                           placeholder="Contoh: Anggaran Pendapatan dan Belanja Desa Tahun 2026"
                           value="{{ old('judul', $peraturan_desa->judul) }}"
                           maxlength="255"
                           required>
                    @error('judul')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @endif
                    <p class="mt-1 text-xs text-gray-500"><span id="judulCount">{{ strlen(old('judul', $peraturan_desa->judul)) }}</span> / 255 karakter</p>
                </div>

                <!-- Uraian -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Uraian Singkat
                    </label>
                    <textarea name="uraian_singkat" 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm @error('uraian_singkat') border-red-500 @enderror" 
                              placeholder="Tuliskan uraian singkat tentang peraturan ini..."
                              rows="4"
                              maxlength="500">{{ old('uraian_singkat', $peraturan_desa->uraian_singkat) }}</textarea>
                    @error('uraian_singkat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @endif
                    <p class="mt-1 text-xs text-gray-500"><span id="uraianCount">{{ strlen(old('uraian_singkat', $peraturan_desa->uraian_singkat ?? '')) }}</span> / 500 karakter</p>
                </div>

                <!-- Divider -->
                <hr class="border-gray-200">

                <!-- Tanggal Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Ditetapkan
                        </label>
                        <input type="date" 
                               name="tanggal_ditetapkan" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                               value="{{ old('tanggal_ditetapkan', $peraturan_desa->tanggal_ditetapkan ? $peraturan_desa->tanggal_ditetapkan->format('Y-m-d') : '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Dimuat Pada Tanggal
                        </label>
                        <input type="date" 
                               name="dimuat_pada" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                               value="{{ old('dimuat_pada', $peraturan_desa->dimuat_pada ? $peraturan_desa->dimuat_pada->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <!-- Status Toggle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Peraturan
                    </label>
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="is_aktif" 
                                   value="1" 
                                   {{ old('is_aktif', $peraturan_desa->is_aktif) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        </label>
                        <span id="statusText" class="text-sm font-medium {{ old('is_aktif', $peraturan_desa->is_aktif) ? 'text-emerald-600' : 'text-gray-500' }}">
                            {{ old('is_aktif', $peraturan_desa->is_aktif) ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Status aktif menunjukkan peraturan masih berlaku</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" 
                   class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-50 transition-colors">
                    Kembali
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg font-medium text-sm hover:bg-emerald-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Data
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character Counter for Judul
            const judulInput = document.querySelector('input[name="judul"]');
            const judulCount = document.getElementById('judulCount');
            
            if (judulInput && judulCount) {
                judulInput.addEventListener('input', function() {
                    judulCount.textContent = this.value.length;
                });
                judulCount.textContent = judulInput.value.length;
            }

            // Character Counter for Uraian
            const uraianInput = document.querySelector('textarea[name="uraian_singkat"]');
            const uraianCount = document.getElementById('uraianCount');
            
            if (uraianInput && uraianCount) {
                uraianInput.addEventListener('input', function() {
                    uraianCount.textContent = this.value.length;
                });
                uraianCount.textContent = uraianInput.value.length;
            }

            // Status Toggle Text Update
            const statusToggle = document.querySelector('input[name="is_aktif"]');
            const statusText = document.getElementById('statusText');
            
            if (statusToggle && statusText) {
                statusToggle.addEventListener('change', function() {
                    if (this.checked) {
                        statusText.textContent = 'Aktif';
                        statusText.className = 'text-sm font-medium text-emerald-600';
                    } else {
                        statusText.textContent = 'Tidak Aktif';
                        statusText.className = 'text-sm font-medium text-gray-500';
                    }
                });
            }
        });
    </script>

@endsection

