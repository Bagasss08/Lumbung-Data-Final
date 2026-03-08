@extends('layouts.admin')

@section('title', 'Tambah Penduduk')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Penduduk</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Isi formulir di bawah untuk menambahkan data penduduk</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.penduduk') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Penduduk
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
        </nav>
        <a href="{{ route('admin.penduduk') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

{{-- ============================================================ --}}
{{-- FORM CARD                                                   --}}
{{-- ============================================================ --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Data Penduduk Baru</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi semua data untuk mendaftarkan penduduk</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.penduduk.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

        <!-- SECTION 1: Informasi Dasar -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">1</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Informasi Dasar</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors font-mono
                        {{ $errors->has('nik') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        placeholder="16 digit NIK" required maxlength="16">
                    @error('nik')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('nama') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        placeholder="Nama lengkap sesuai KTP" required>
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('jenis_kelamin') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('tempat_lahir') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        placeholder="Contoh: Jakarta" required>
                    @error('tempat_lahir')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('tanggal_lahir') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        required>
                    @error('tanggal_lahir')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Golongan Darah -->
                <div>
                    <label for="golongan_darah" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Golongan Darah</label>
                    <select id="golongan_darah" name="golongan_darah"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih golongan darah</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <!-- Agama -->
                <div>
                    <label for="agama" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Agama <span class="text-red-500">*</span>
                    </label>
                    <select id="agama" name="agama" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('agama') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih agama</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                    @error('agama')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kewarganegaraan -->
                <div>
                    <label for="kewarganegaraan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Kewarganegaraan</label>
                    <select id="kewarganegaraan" name="kewarganegaraan"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Informasi Keluarga & Wilayah -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Informasi Keluarga & Wilayah</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Keluarga -->
                <div>
                    <label for="keluarga_id" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keluarga</label>
                    <select id="keluarga_id" name="keluarga_id"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih keluarga (opsional)</option>
                        @foreach($keluarga as $k)
                        <option value="{{ $k->id }}" {{ old('keluarga_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->no_kk }} – {{ $k->kepalaKeluarga->nama ?? 'N/A' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div>
                    <label for="hubungan_keluarga" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Hubungan Keluarga</label>
                    <select id="hubungan_keluarga" name="hubungan_keluarga"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih hubungan (opsional)</option>
                        <option value="kepala_keluarga" {{ old('hubungan_keluarga') == 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="istri" {{ old('hubungan_keluarga') == 'istri' ? 'selected' : '' }}>Istri</option>
                        <option value="anak" {{ old('hubungan_keluarga') == 'anak' ? 'selected' : '' }}>Anak</option>
                        <option value="orang_tua" {{ old('hubungan_keluarga') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="saudara" {{ old('hubungan_keluarga') == 'saudara' ? 'selected' : '' }}>Saudara</option>
                        <option value="lainnya" {{ old('hubungan_keluarga') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Rumah Tangga -->
                <div>
                    <label for="rumah_tangga_id" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Rumah Tangga</label>
                    <select id="rumah_tangga_id" name="rumah_tangga_id"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih rumah tangga (opsional)</option>
                        @foreach($rumahTangga as $rt)
                        <option value="{{ $rt->id }}" {{ old('rumah_tangga_id') == $rt->id ? 'selected' : '' }}>
                            {{ $rt->nama_kepala_rumah_tangga ?? 'N/A' }} – {{ $rt->alamat }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hubungan Rumah Tangga -->
                <div>
                    <label for="hubungan_rumah_tangga" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Hubungan Rumah Tangga</label>
                    <select id="hubungan_rumah_tangga" name="hubungan_rumah_tangga"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih hubungan (opsional)</option>
                        <option value="kepala_rumah_tangga" {{ old('hubungan_rumah_tangga') == 'kepala_rumah_tangga' ? 'selected' : '' }}>Kepala Rumah Tangga</option>
                        <option value="istri" {{ old('hubungan_rumah_tangga') == 'istri' ? 'selected' : '' }}>Istri</option>
                        <option value="anak" {{ old('hubungan_rumah_tangga') == 'anak' ? 'selected' : '' }}>Anak</option>
                        <option value="orang_tua" {{ old('hubungan_rumah_tangga') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="saudara" {{ old('hubungan_rumah_tangga') == 'saudara' ? 'selected' : '' }}>Saudara</option>
                        <option value="lainnya" {{ old('hubungan_rumah_tangga') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Wilayah -->
                <div class="md:col-span-2">
                    <label for="wilayah_id" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Wilayah</label>
                    <select id="wilayah_id" name="wilayah_id"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih wilayah (opsional)</option>
                        @foreach($wilayah as $w)
                        <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>
                            RT {{ $w->rt }} / RW {{ $w->rw }} – {{ $w->dusun }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Status & Pendidikan -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-purple-100 dark:bg-purple-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-purple-700 dark:text-purple-400 text-xs font-bold">3</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Status & Pendidikan</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Status Hidup -->
                <div>
                    <label for="status_hidup" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Status Hidup</label>
                    <select id="status_hidup" name="status_hidup"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="hidup" {{ old('status_hidup', 'hidup') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                        <option value="meninggal" {{ old('status_hidup') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </div>

                <!-- Status Kawin -->
                <div>
                    <label for="status_kawin" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Status Kawin <span class="text-red-500">*</span>
                    </label>
                    <select id="status_kawin" name="status_kawin" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('status_kawin') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih status</option>
                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)
                        <option value="{{ $status }}" {{ old('status_kawin') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status_kawin')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pendidikan -->
                <div>
                    <label for="pendidikan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Pendidikan Terakhir</label>
                    <select id="pendidikan" name="pendidikan"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih pendidikan</option>
                        @foreach(['Tidak Sekolah','SD','SMP','SMA','D1','D2','D3','S1','S2','S3'] as $pend)
                        <option value="{{ $pend }}" {{ old('pendidikan') == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="pekerjaan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Pekerjaan <span class="text-red-500">*</span>
                    </label>
                    <select id="pekerjaan" name="pekerjaan" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('pekerjaan') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih pekerjaan</option>
                        <option value="bekerja" {{ old('pekerjaan') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                        <option value="tidak bekerja" {{ old('pekerjaan') == 'tidak bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                    </select>
                    @error('pekerjaan')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 4: Kontak & Alamat -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-pink-100 dark:bg-pink-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-pink-700 dark:text-pink-400 text-xs font-bold">4</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Kontak & Alamat</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- No. Telepon -->
                <div>
                    <label for="no_telp" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">No. Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <input type="text" id="no_telp" name="no_telp" value="{{ old('no_telp') }}"
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                            placeholder="08123456789">
                    </div>
                    @error('no_telp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-9 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                            placeholder="contoh@email.com">
                    </div>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-5002 focus:ring-emerald-400 focus:ring- focus:border-transparent transition-colors resize-none"
                        placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.penduduk') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl
                       hover:from-emerald-600 hover:to-teal-700 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5
                       active:translate-y-0 transition-all duration-150 shadow-md shadow-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('nik')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 16);
    });
    document.getElementById('no_telp')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
</script>
@endpush

@endsection

