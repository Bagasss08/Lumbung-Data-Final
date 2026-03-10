@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Tambah Inventaris</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Isi formulir di bawah untuk menambahkan data inventaris desa</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah</span>
        </nav>
        <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}"
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
                <h2 class="text-white font-semibold text-base">Data Inventaris Baru</h2>
                <p class="text-emerald-100 text-xs mt-0.5">Lengkapi semua data untuk mendaftarkan inventaris desa</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.store') }}" method="POST" class="p-6 space-y-8">
        @csrf

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
                    <input type="text" id="kode_barang" name="kode_barang" value="{{ old('kode_barang', $kodeOtomatis) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors font-mono
                        {{ $errors->has('kode_barang') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                    @error('kode_barang')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Kode otomatis, dapat diubah</p>
                </div>

                {{-- Nama Barang --}}
                <div>
                    <label for="nama_barang" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('nama_barang') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        placeholder="Contoh: Kursi Kantor, Tanah Kas Desa">
                    @error('nama_barang')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="md:col-span-2">
                    <label for="kategori" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="kategori" name="kategori"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('kategori') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori') == $kat)>{{ $kat }}</option>
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
                {{-- Jumlah --}}
                <div>
                    <label for="jumlah" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('jumlah') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}"
                        min="0" step="0.01">
                    @error('jumlah')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Satuan --}}
                <div>
                    <label for="satuan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select id="satuan" name="satuan"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('satuan') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="">-- Pilih --</option>
                        @foreach($satuanList as $sat)
                            <option value="{{ $sat }}" @selected(old('satuan') == $sat)>{{ $sat }}</option>
                        @endforeach
                    </select>
                    @error('satuan')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Harga Satuan --}}
                <div>
                    <label for="harga_satuan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Harga Satuan (Rp)</label>
                    <input type="number" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', 0) }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                        min="0" step="1000" placeholder="0">
                </div>

                {{-- Preview Harga Total --}}
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
                {{-- Tahun Pengadaan --}}
                <div>
                    <label for="tahun_pengadaan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Tahun Pengadaan</label>
                    <input type="number" id="tahun_pengadaan" name="tahun_pengadaan" value="{{ old('tahun_pengadaan', date('Y')) }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                        min="1900" max="{{ date('Y') }}">
                </div>

                {{-- Asal Usul --}}
                <div>
                    <label for="asal_usul" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Asal Usul / Sumber</label>
                    <select id="asal_usul" name="asal_usul"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors">
                        <option value="">-- Pilih --</option>
                        @foreach($asalUsulList as $asal)
                            <option value="{{ $asal }}" @selected(old('asal_usul') == $asal)>{{ $asal }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kondisi --}}
                <div>
                    <label for="kondisi" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">
                        Kondisi <span class="text-red-500">*</span>
                    </label>
                    <select id="kondisi" name="kondisi"
                        class="w-full px-3 py-2.5 text-sm border rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors
                        {{ $errors->has('kondisi') ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-slate-600' }}">
                        <option value="Baik" @selected(old('kondisi', 'Baik') == 'Baik')>Baik</option>
                        <option value="Rusak Ringan" @selected(old('kondisi') == 'Rusak Ringan')>Rusak Ringan</option>
                        <option value="Rusak Berat" @selected(old('kondisi') == 'Rusak Berat')>Rusak Berat</option>
                    </select>
                    @error('kondisi')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="md:col-span-3">
                    <label for="lokasi" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Lokasi / Tempat</label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors"
                        placeholder="Contoh: Kantor Desa, Balai Desa, Gudang...">
                </div>

                {{-- Keterangan --}}
                <div class="md:col-span-3">
                    <label for="keterangan" class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1.5">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="w-full px-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 rounded-xl bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-colors resize-none"
                        placeholder="Keterangan tambahan (opsional)...">{{ old('keterangan') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700">
            <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-400 text-sm font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-gray-300 dark:hover:border-slate-500 transition-all duration-150 shadow-sm">
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
    // Hitung harga total otomatis
    function hitungTotal() {
        const jumlah  = parseFloat(document.getElementById('jumlah').value) || 0;
        const harga   = parseFloat(document.getElementById('harga_satuan').value) || 0;
        const total   = jumlah * harga;
        document.getElementById('preview_total').textContent =
            'Rp ' + total.toLocaleString('id-ID');
    }

    document.getElementById('jumlah').addEventListener('input', hitungTotal);
    document.getElementById('harga_satuan').addEventListener('input', hitungTotal);
    hitungTotal(); // run on load
</script>
@endpush

@endsection

