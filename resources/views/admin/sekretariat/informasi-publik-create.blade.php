@extends('layouts.admin')

@section('title', 'Tambah Informasi Publik')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Informasi Publik</h1>
                <p class="text-sm text-slate-500 mt-1">Tambahkan dokumen informasi publik baru untuk masyarakat</p>
            </div>
            <a href="{{ route('admin.sekretariat.informasi-publik.index') }}"
                class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Breadcrumb Info -->
    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border-l-4 border-cyan-500 px-6 py-4 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-cyan-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <a href="{{ route('admin.sekretariat.informasi-publik.index') }}"
                class="text-sm text-cyan-800 font-medium hover:text-cyan-900 transition-colors">
                ← Kembali Ke Daftar Informasi Publik Di Desa
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form method="POST" action="{{ route('admin.sekretariat.informasi-publik.store') }}"
            enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Dokumen -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Judul Dokumen <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul_dokumen" value="{{ old('judul_dokumen') }}"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('judul_dokumen') border-red-500 ring-2 ring-red-200 @enderror"
                    placeholder="Masukkan judul dokumen">
                @error('judul_dokumen')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Tipe Dokumen -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tipe Dokumen <span class="text-red-500">*</span>
                </label>
                <select name="tipe_dokumen" id="tipe_dokumen"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('tipe_dokumen') border-red-500 ring-2 ring-red-200 @enderror">
                    <option value="file" @selected(old('tipe_dokumen')=='file' )>File</option>
                    <option value="link" @selected(old('tipe_dokumen')=='link' )>Link</option>
                    <option value="teks" @selected(old('tipe_dokumen')=='teks' )>Teks</option>
                </select>
                @error('tipe_dokumen')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Unggah Dokumen -->
            <div id="unggah_container">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Unggah Dokumen <span class="text-red-500">*</span>
                </label>
                <div
                    class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-emerald-500 hover:bg-emerald-50/30 transition-all @error('unggah_dokumen') border-red-500 bg-red-50/30 @enderror">
                    <input type="file" name="unggah_dokumen" id="file-upload" class="hidden" accept=".pdf,.doc,.docx">
                    <label for="file-upload" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-slate-400 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700 mb-1">Klik untuk memilih file</span>
                            <span class="text-xs text-slate-500">PDF, DOC, DOCX (Maksimal 2MB)</span>
                        </div>
                    </label>
                    <div id="file-name" class="mt-3 text-sm font-medium text-emerald-600 hidden"></div>
                </div>
                @error('unggah_dokumen')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Retensi Dokumen -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Retensi Dokumen
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input type="number" name="retensi_dokumen" value="{{ old('retensi_dokumen', 0) }}" min="0" max="31"
                        class="px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('retensi_dokumen') border-red-500 ring-2 ring-red-200 @enderror">

                    <select name="satuan_retensi"
                        class="px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('satuan_retensi') border-red-500 ring-2 ring-red-200 @enderror">
                        <option value="hari" @selected(old('satuan_retensi')=='hari' )>Hari</option>
                        <option value="bulan" @selected(old('satuan_retensi')=='bulan' )>Bulan</option>
                        <option value="tahun" @selected(old('satuan_retensi')=='tahun' )>Tahun</option>
                    </select>
                </div>
                <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Nilai harus antara 0 hingga 31. Isi 0 jika tidak digunakan.
                </p>
                @error('retensi_dokumen')
                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Kategori Informasi Publik -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Kategori Informasi Publik
                </label>
                <select name="kategori_info_publik"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('kategori_info_publik') border-red-500 ring-2 ring-red-200 @enderror">
                    <option value="">Pilih Kategori Informasi Publik</option>
                    <option value="Informasi Berkala" @selected(old('kategori_info_publik')=='Informasi Berkala' )>
                        Informasi Berkala</option>
                    <option value="Informasi Serta Merta" @selected(old('kategori_info_publik')=='Informasi Serta Merta'
                        )>
                        Informasi Serta Merta</option>
                    <option value="Informasi Setiap Saat" @selected(old('kategori_info_publik')=='Informasi Setiap Saat'
                        )>
                        Informasi Setiap Saat</option>
                    <option value="Informasi Dikecualikan"
                        @selected(old('kategori_info_publik')=='Informasi Dikecualikan' )>
                        Informasi Dikecualikan</option>
                </select>
                @error('kategori_info_publik')
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
                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="4"
                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('keterangan') border-red-500 ring-2 ring-red-200 @enderror"
                    placeholder="Masukkan keterangan dokumen...">{{ old('keterangan') }}</textarea>
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

            <!-- Tahun & Tanggal Terbit -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tahun
                    </label>
                    <input type="text" name="tahun" value="{{ old('tahun', date('Y')) }}" placeholder="Contoh: 2019"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('tahun') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('tahun')
                    <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Tanggal Terbit -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Terbit <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all @error('tanggal_terbit') border-red-500 ring-2 ring-red-200 @enderror">
                    @error('tanggal_terbit')
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

            <!-- Status Terbit -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">
                    Status Terbit <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_terbit" value="ya" @checked(old('status_terbit', 'ya' )=='ya' )
                            class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 focus:ring-2">
                        <span class="text-sm text-slate-700 group-hover:text-slate-900 font-medium">Ya</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="radio" name="status_terbit" value="tidak" @checked(old('status_terbit')=='tidak' )
                            class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 focus:ring-2">
                        <span class="text-sm text-slate-700 group-hover:text-slate-900 font-medium">Tidak</span>
                    </label>
                </div>
                @error('status_terbit')
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
                <a href="{{ route('admin.sekretariat.informasi-publik.index') }}"
                    class="px-6 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Data
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');
        if (fileName) {
            fileNameDiv.innerHTML = '<svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>' + fileName;
            fileNameDiv.classList.remove('hidden');
        }
    });

    // Toggle unggah dokumen based on tipe dokumen
    document.getElementById('tipe_dokumen').addEventListener('change', function() {
        const unggahContainer = document.getElementById('unggah_container');
        if (this.value === 'file') {
            unggahContainer.style.display = 'block';
        } else {
            unggahContainer.style.display = 'none';
        }
    });
</script>
@endsection