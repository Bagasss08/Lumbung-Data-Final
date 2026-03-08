@extends('layouts.admin')

@section('title', 'Tambah Keluarga')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Keluarga</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Isi formulir di bawah untuk menambahkan data keluarga</p>
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
            <a href="{{ route('admin.keluarga') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Keluarga
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
        </nav>
        <a href="{{ route('admin.keluarga') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

{{-- ============================================================ --}}
{{-- FORM CARD                                                    --}}
{{-- ============================================================ --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Data Keluarga Baru</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi semua data untuk mendaftarkan keluarga</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.keluarga.store') }}" method="POST" class="p-6 space-y-8">
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

                <!-- No KK -->
                <div>
                    <label for="no_kk" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        No. KK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="no_kk" name="no_kk" value="{{ old('no_kk') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors font-mono
                        {{ $errors->has('no_kk') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        placeholder="16 digit No. KK" required maxlength="16">
                    @error('no_kk')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Kepala Keluarga -->
                <div>
                    <label for="kepala_keluarga_id" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Kepala Keluarga <span class="text-red-500">*</span>
                    </label>
                    <select id="kepala_keluarga_id" name="kepala_keluarga_id" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('kepala_keluarga_id') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih kepala keluarga</option>
                        @foreach($penduduk as $p)
                        <option value="{{ $p->id }}" {{ old('kepala_keluarga_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Tanggal Terdaftar -->
                <div>
                    <label for="tgl_terdaftar" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Tanggal Terdaftar <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tgl_terdaftar" name="tgl_terdaftar" value="{{ old('tgl_terdaftar', date('Y-m-d')) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('tgl_terdaftar') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        required>
                    @error('tgl_terdaftar')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: Wilayah & Ekonomi -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Wilayah &amp; Ekonomi</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Wilayah -->
                <div>
                    <label for="wilayah_id" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Wilayah <span class="text-red-500">*</span>
                    </label>
                    <select id="wilayah_id" name="wilayah_id" required
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('wilayah_id') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">Pilih wilayah</option>
                        @foreach($wilayah as $w)
                        <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>
                            RT {{ $w->rt }} / RW {{ $w->rw }} – {{ $w->dusun }}
                        </option>
                        @endforeach
                    </select>
                    @error('wilayah_id')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Klasifikasi Ekonomi -->
                <div>
                    <label for="klasifikasi_ekonomi" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Klasifikasi Ekonomi</label>
                    <select id="klasifikasi_ekonomi" name="klasifikasi_ekonomi"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">Pilih klasifikasi</option>
                        <option value="miskin" {{ old('klasifikasi_ekonomi') == 'miskin' ? 'selected' : '' }}>Miskin</option>
                        <option value="rentan" {{ old('klasifikasi_ekonomi') == 'rentan' ? 'selected' : '' }}>Rentan</option>
                        <option value="mampu" {{ old('klasifikasi_ekonomi') == 'mampu' ? 'selected' : '' }}>Mampu</option>
                    </select>
                    @error('klasifikasi_ekonomi')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Jenis Bantuan Aktif -->
                <div>
                    <label for="jenis_bantuan_aktif" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Jenis Bantuan Aktif</label>
                    <input type="text" id="jenis_bantuan_aktif" name="jenis_bantuan_aktif" value="{{ old('jenis_bantuan_aktif') }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                        placeholder="Contoh: PKH, BPNT">
                    @error('jenis_bantuan_aktif')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 3: Alamat -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-pink-100 dark:bg-pink-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-pink-700 dark:text-pink-400 text-xs font-bold">3</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Alamat Lengkap</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div>
                <label for="alamat" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" rows="3"
                    class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none"
                    placeholder="Masukkan alamat lengkap...">{{ old('alamat') }}</textarea>
                @error('alamat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.keluarga') }}"
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
    document.getElementById('no_kk')?.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').substring(0, 16);
    });
</script>
@endpush

@endsection