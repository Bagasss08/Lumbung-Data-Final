@extends('layouts.admin')

@section('title', 'Edit Dusun')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Edit Dusun</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Ubah informasi dusun sesuai data terbaru yang valid</p>
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
            <a href="{{ route('admin.info-desa.wilayah-administratif') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Wilayah Administratif
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Edit Dusun</span>
        </nav>
        <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Perbarui Data Dusun</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Ubah informasi dusun sesuai data terbaru yang valid</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.info-desa.wilayah-administratif.update', $wilayah['id']) }}">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">

            {{-- Info tip --}}
            <div class="flex items-center gap-2.5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
                    <line x1="12" y1="16" x2="12.01" y2="16" stroke-width="2"/>
                </svg>
                <p class="text-amber-700 text-xs">
                    Kolom bertanda <strong class="text-amber-600">*</strong> wajib diisi sebelum menyimpan data.
                </p>
            </div>

            {{-- Section: Identitas Wilayah --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 tracking-wide uppercase">
                        Identitas Wilayah
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama Dusun --}}
                    <div class="space-y-1.5">
                        <label for="nama" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700">
                            Nama Dusun <span class="text-red-500">*</span>
                            <span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-nama"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $wilayah['nama']) }}" required
                                placeholder="Contoh: Dusun Krajan" data-original="{{ $wilayah['nama'] }}"
                                class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white
                                       hover:border-gray-300 hover:bg-white transition-all duration-150
                                       @error('nama') border-red-300 bg-red-50 @enderror">
                        </div>
                        @error('nama')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Kepala Wilayah --}}
                    <div class="space-y-1.5">
                        <label for="kepala_wilayah" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700">
                            Kepala Wilayah <span class="text-red-500">*</span>
                            <span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-kepala_wilayah"></span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input type="text" name="kepala_wilayah" id="kepala_wilayah" value="{{ old('kepala_wilayah', $wilayah['kepala_wilayah']) }}" required
                                placeholder="Nama lengkap kepala wilayah" data-original="{{ $wilayah['kepala_wilayah'] }}"
                                class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-50 text-gray-900 placeholder-gray-400
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white
                                       hover:border-gray-300 hover:bg-white transition-all duration-150
                                       @error('kepala_wilayah') border-red-300 bg-red-50 @enderror">
                        </div>
                        @error('kepala_wilayah')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-200"></div>

            {{-- Section: Struktur RT/RW --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 tracking-wide uppercase">
                        Struktur RT / RW
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="rw" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700">Jumlah RW <span class="text-red-500">*</span><span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-rw"></span></label>
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-transparent focus-within:bg-white transition-all duration-150">
                            <button type="button" onclick="changeVal('rw', -1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−</button>
                            <input type="number" name="rw" id="rw" value="{{ old('rw', $wilayah['rw']) }}" min="1" required data-original="{{ $wilayah['rw'] }}" class="flex-1 text-center text-sm font-bold text-gray-900 bg-transparent border-none outline-none py-2.5 min-w-0" style="-moz-appearance:textfield">
                            <button type="button" onclick="changeVal('rw', 1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+</button>
                        </div>
                        @error('rw')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="rt" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700">Jumlah RT <span class="text-red-500">*</span><span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-rt"></span></label>
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-transparent focus-within:bg-white transition-all duration-150">
                            <button type="button" onclick="changeVal('rt', -1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−</button>
                            <input type="number" name="rt" id="rt" value="{{ old('rt', $wilayah['rt']) }}" min="1" required data-original="{{ $wilayah['rt'] }}" class="flex-1 text-center text-sm font-bold text-gray-900 bg-transparent border-none outline-none py-2.5 min-w-0" style="-moz-appearance:textfield">
                            <button type="button" onclick="changeVal('rt', 1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+</button>
                        </div>
                        @error('rt')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-200"></div>

            {{-- Section: Data Penduduk --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 tracking-wide uppercase">
                        Data Penduduk
                    </span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                <div class="space-y-1.5 mb-4">
                    <label for="kk" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700">Jumlah Kepala Keluarga (KK) <span class="text-red-500">*</span><span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-kk"></span></label>
                    <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-transparent focus-within:bg-white transition-all duration-150">
                        <button type="button" onclick="changeVal('kk', -10)" class="px-3 py-2.5 text-xs font-bold text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−10</button>
                        <button type="button" onclick="changeVal('kk', -1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−</button>
                        <input type="number" name="kk" id="kk" value="{{ old('kk', $wilayah['kk']) }}" min="0" required data-original="{{ $wilayah['kk'] }}" class="flex-1 text-center text-sm font-bold text-gray-900 bg-transparent border-none outline-none py-2.5 min-w-0" style="-moz-appearance:textfield">
                        <button type="button" onclick="changeVal('kk', 1)" class="px-3.5 py-2.5 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+</button>
                        <button type="button" onclick="changeVal('kk', 10)" class="px-3 py-2.5 text-xs font-bold text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+10</button>
                    </div>
                    @error('kk')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="space-y-1.5">
                        <label for="laki_laki" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700"><span class="text-blue-500 mr-1">♂</span> Jumlah Laki-laki <span class="text-red-500">*</span><span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-laki_laki"></span></label>
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-blue-400 focus-within:border-transparent focus-within:bg-white transition-all duration-150">
                            <button type="button" onclick="changeVal('laki_laki', -1)" class="px-3.5 py-2.5 text-gray-500 hover:text-blue-500 hover:bg-blue-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−</button>
                            <input type="number" name="laki_laki" id="laki_laki" value="{{ old('laki_laki', $wilayah['laki_laki']) }}" min="0" required data-original="{{ $wilayah['laki_laki'] }}" class="flex-1 text-center text-sm font-bold text-gray-900 bg-transparent border-none outline-none py-2.5 min-w-0" style="-moz-appearance:textfield">
                            <button type="button" onclick="changeVal('laki_laki', 1)" class="px-3.5 py-2.5 text-gray-500 hover:text-blue-500 hover:bg-blue-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+</button>
                        </div>
                        @error('laki_laki')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-1.5">
                        <label for="perempuan" class="flex items-center gap-1.5 text-sm font-semibold text-gray-700"><span class="text-pink-500 mr-1">♀</span> Jumlah Perempuan <span class="text-red-500">*</span><span class="changed-dot hidden w-2 h-2 bg-amber-400 rounded-full animate-pulse" id="dot-perempuan"></span></label>
                        <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 overflow-hidden focus-within:ring-2 focus-within:ring-pink-400 focus-within:border-transparent focus-within:bg-white transition-all duration-150">
                            <button type="button" onclick="changeVal('perempuan', -1)" class="px-3.5 py-2.5 text-gray-500 hover:text-pink-500 hover:bg-pink-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-r border-gray-200">−</button>
                            <input type="number" name="perempuan" id="perempuan" value="{{ old('perempuan', $wilayah['perempuan']) }}" min="0" required data-original="{{ $wilayah['perempuan'] }}" class="flex-1 text-center text-sm font-bold text-gray-900 bg-transparent border-none outline-none py-2.5 min-w-0" style="-moz-appearance:textfield">
                            <button type="button" onclick="changeVal('perempuan', 1)" class="px-3.5 py-2.5 text-gray-500 hover:text-pink-500 hover:bg-pink-50 font-bold text-base transition-colors duration-150 flex-shrink-0 border-l border-gray-200">+</button>
                        </div>
                        @error('perempuan')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <div class="flex-1 flex items-center gap-2.5 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                        <p class="text-sm text-emerald-700">Total penduduk: <strong id="total-num" class="font-bold">0</strong> jiwa</p>
                    </div>
                    {{-- Changed counter --}}
                    <div id="change-counter" class="hidden flex items-center gap-2.5 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <p class="text-sm text-amber-700"><span id="change-text" class="font-semibold">0 field</span> diubah</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Form Footer --}}
        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('admin.info-desa.wilayah-administratif') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl
                       hover:from-emerald-600 hover:to-teal-700 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-0.5
                       active:translate-y-0 transition-all duration-150 shadow-md shadow-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>
<script>
    function changeVal(id, delta) {
        const input = document.getElementById(id);
        const min = parseInt(input.min) || 0;
        input.value = Math.max(min, (parseInt(input.value) || 0) + delta);
        updateTotal();
    }

    function updateTotal() {
        const ll = parseInt(document.getElementById('laki_laki').value) || 0;
        const pr = parseInt(document.getElementById('perempuan').value) || 0;
        document.getElementById('total-num').textContent = (ll + pr).toLocaleString('id-ID');
    }

    // Change tracking for edit-specific feature
    function checkChanged(input) {
        const original = input.getAttribute('data-original');
        if (original === undefined || original === null) return;
        
        const fieldName = input.name;
        const dot = document.getElementById('dot-' + fieldName);
        if (dot) {
            if (String(input.value) !== String(original)) {
                dot.classList.remove('hidden');
            } else {
                dot.classList.add('hidden');
            }
        }
        updateChangedCount();
    }

    function updateChangedCount() {
        const inputs = document.querySelectorAll('[data-original]');
        let count = 0;
        inputs.forEach(input => {
            const original = input.getAttribute('data-original');
            if (original !== undefined && original !== null && String(input.value) !== String(original)) count++;
        });

        const counter = document.getElementById('change-counter');
        const text = document.getElementById('change-text');
        if (count > 0) {
            counter.classList.remove('hidden');
            counter.classList.add('flex');
            text.textContent = count + ' field';
        } else {
            counter.classList.add('hidden');
            counter.classList.remove('flex');
        }
    }

    // Initialize change tracking
    document.querySelectorAll('[data-original]').forEach(input => {
        input.addEventListener('input', function() {
            checkChanged(this);
            updateTotal();
        });
    });

    // Initial total calculation
    updateTotal();
</script>

@endsection

