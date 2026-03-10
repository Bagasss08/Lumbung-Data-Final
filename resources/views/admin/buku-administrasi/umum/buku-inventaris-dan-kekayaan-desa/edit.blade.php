@extends('layouts.admin')

@section('title', 'Edit Inventaris')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Edit Inventaris</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Perbarui data inventaris desa</p>
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
            <a href="{{ route('admin.buku-administrasi.umum.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Buku Administrasi Umum
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Inventaris Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Edit</span>
        </nav>
        <div class="flex gap-2">
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.show', $item) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Detail
            </a>
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- FORM CARD                                                   --}}
{{-- ============================================================ --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Card Header --}}
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-white font-semibold text-base">Edit Data Inventaris</h2>
                <p class="text-white/80 text-xs mt-0.5">
                    Memperbarui: <span class="font-semibold text-white">{{ $item->nama_barang }}</span>
                    <span class="font-mono text-white/70 ml-1">· {{ $item->kode_barang }}</span>
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.update', $item) }}" method="POST" class="p-6 space-y-8">
        @csrf
        @method('PUT')

        <!-- SECTION 1: Identitas Barang -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">1</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Identitas Barang</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Kode Barang --}}
                <div>
                    <label for="kode_barang" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Kode Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $item->kode_barang) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors font-mono
                        {{ $errors->has('kode_barang') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                    @error('kode_barang')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Nama Barang --}
                <div>
                    <label for="nama_barang" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $item->nama_barang) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('nama_barang') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                    @error('nama_barang')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Kategori --}
                <div class="md:col-span-2">
                    <label for="kategori" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori" name="kategori"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('kategori') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori', $item->kategori) == $kat)>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: Jumlah & Harga -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-amber-700 dark:text-amber-400 text-xs font-bold">2</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Jumlah & Harga</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Jumlah --}
                <div>
                    <label for="jumlah" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $item->jumlah) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('jumlah') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        min="0" step="0.01">
                    @error('jumlah')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Satuan --}
                <div>
                    <label for="satuan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select id="satuan" name="satuan"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('satuan') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">-- Pilih --</option>
                        @foreach($satuanList as $sat)
                            <option value="{{ $sat }}" @selected(old('satuan', $item->satuan) == $sat)>{{ $sat }}</option>
                        @endforeach
                    </select>
                    @error('satuan')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Harga Satuan --}
                <div>
                    <label for="harga_satuan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Harga Satuan (Rp)</label>
                    <input type="number" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', $item->harga_satuan) }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                        min="0" step="1000" placeholder="0">
                </div>

                {{-- Preview Harga Total --}
                <div class="md:col-span-3">
                    <div class="flex items-center gap-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl px-4 py-3">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 7h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2z"/>
                        </svg>
                        <p class="text-sm text-amber-700 dark:text-amber-300">
                            Harga Total: <span id="preview_total" class="font-bold">Rp 0</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Detail Pengadaan & Kondisi -->
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-7 h-7 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="text-blue-700 dark:text-blue-400 text-xs font-bold">3</span>
                </div>
                <h4 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Detail Pengadaan & Kondisi</h4>
                <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Tahun Pengadaan --}
                <div>
                    <label for="tahun_pengadaan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tahun Pengadaan</label>
                    <input type="number" id="tahun_pengadaan" name="tahun_pengadaan" value="{{ old('tahun_pengadaan', $item->tahun_pengadaan) }}"
                        class="w-full px
