@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.sekretariat.inventaris') }}"
                class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Barang Inventaris</h1>
                <p class="text-sm text-slate-500 mt-1">Tambahkan barang baru ke inventaris desa</p>
            </div>
        </div>
    </div>

    <!-- Breadcrumb Info -->
    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border-l-4 border-cyan-500 px-6 py-4 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-cyan-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <a href="{{ route('admin.sekretariat.inventaris') }}"
                class="text-sm text-cyan-800 font-medium hover:text-cyan-900 transition-colors">
                ← Kembali Ke Daftar Inventaris
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form method="POST" action="{{ route('admin.sekretariat.inventaris.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Barang -->
                <div>
                    <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('nama_barang') border-red-500 ring-2 ring-red-200 @enderror"
                        placeholder="Masukkan nama barang" required>
                    @error('nama_barang')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori" name="kategori"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('kategori') border-red-500 ring-2 ring-red-200 @enderror"
                        required>
                        <option value="">Pilih kategori</option>
                        <option value="elektronik" {{ old('kategori')=='elektronik' ? 'selected' : '' }}>Elektronik
                        </option>
                        <option value="furniture" {{ old('kategori')=='furniture' ? 'selected' : '' }}>Furniture
                        </option>
                        <option value="kendaraan" {{ old('kategori')=='kendaraan' ? 'selected' : '' }}>Kendaraan
                        </option>
                        <option value="peralatan" {{ old('kategori')=='peralatan' ? 'selected' : '' }}>Peralatan
                        </option>
                    </select>
                    @error('kategori')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('jumlah') border-red-500 ring-2 ring-red-200 @enderror"
                        required>
                    @error('jumlah')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div>
                    <label for="kondisi" class="block text-sm font-semibold text-slate-700 mb-2">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select id="kondisi" name="kondisi"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('kondisi') border-red-500 ring-2 ring-red-200 @enderror"
                        required>
                        <option value="">Pilih kondisi</option>
                        <option value="baik" {{ old('kondisi')=='baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('kondisi')=='rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="perlu_perbaikan" {{ old('kondisi')=='perlu_perbaikan' ? 'selected' : '' }}>Perlu
                            Perbaikan</option>
                    </select>
                    @error('kondisi')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-sm font-semibold text-slate-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('lokasi') border-red-500 ring-2 ring-red-200 @enderror"
                        placeholder="Masukkan lokasi penyimpanan" required>
                    @error('lokasi')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Harga Perolehan -->
                <div>
                    <label for="harga_perolehan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Harga Perolehan
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">Rp</span>
                        <input type="number" id="harga_perolehan" name="harga_perolehan"
                            value="{{ old('harga_perolehan') }}" min="0" step="0.01"
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('harga_perolehan') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="0.00">
                    </div>
                    @error('harga_perolehan')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Tanggal Perolehan -->
                <div>
                    <label for="tanggal_perolehan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Perolehan
                    </label>
                    <input type="date" id="tanggal_perolehan" name="tanggal_perolehan"
                        value="{{ old('tanggal_perolehan') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('tanggal_perolehan') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('tanggal_perolehan')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Sumber Perolehan -->
                <div>
                    <label for="sumber_perolehan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Sumber Perolehan
                    </label>
                    <input type="text" id="sumber_perolehan" name="sumber_perolehan"
                        value="{{ old('sumber_perolehan') }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('sumber_perolehan') border-red-500 ring-2 ring-red-200 @enderror"
                        placeholder="Contoh: APBDes, Hibah, Pembelian">
                    @error('sumber_perolehan')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('deskripsi') border-red-500 ring-2 ring-red-200 @enderror"
                    placeholder="Deskripsi detail barang">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-2">
                    Keterangan Tambahan
                </label>
                <textarea id="keterangan" name="keterangan" rows="2"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('keterangan') border-red-500 ring-2 ring-red-200 @enderror"
                    placeholder="Keterangan tambahan jika diperlukan">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.sekretariat.inventaris') }}"
                    class="px-6 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>

</div>
@endsection