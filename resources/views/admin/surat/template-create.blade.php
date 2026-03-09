@extends('layouts.admin')

@section('title', 'Tambah Template Surat')

@section('content')
<style>
    .tox-tinymce {
        border-radius: 0.75rem !important;
        border: 1px solid #e5e7eb !important;
    }
    /* Sembunyikan promo banner TinyMCE dan branding */
    .tox .tox-promotion, .tox-statusbar__branding {
        display: none !important;
    }
</style>

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Tambah Template Surat</h3>
            <p class="text-sm text-gray-500 mt-1">Buat format template dokumen baru untuk sistem persuratan desa.</p>
        </div>
        <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form method="POST" action="{{ route('admin.layanan-surat.template-surat.store') }}" class="p-6 sm:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Template <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Surat Keterangan Usaha" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm @error('judul') border-red-500 @enderror">
                    @error('judul') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lampiran</label>
                    <input type="text" name="lampiran" value="{{ old('lampiran') }}" placeholder="Contoh: 1 (Satu) Berkas"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm @error('lampiran') border-red-500 @enderror">
                    @error('lampiran') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Klasifikasi <span class="text-red-500">*</span></label>
                    <select name="kode_klasifikasi" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm @error('kode_klasifikasi') border-red-500 @enderror">
                        <option value="">-- Pilih Klasifikasi Surat --</option>
                        @if(isset($klasifikasis))
                            @foreach($klasifikasis as $klasifikasi)
                                <option value="{{ $klasifikasi->kode }}" {{ old('kode_klasifikasi') == $klasifikasi->kode ? 'selected' : '' }}>
                                    {{ $klasifikasi->nama_klasifikasi }} ({{ $klasifikasi->kode }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('kode_klasifikasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm">
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>🟢 Aktif</option>
                        <option value="noaktif" {{ old('status') == 'noaktif' ? 'selected' : '' }}>🔴 Noaktif</option>
                    </select>
                </div>
            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mb-8">
                <label class="block text-sm font-bold text-gray-800 mb-1">Persyaratan Surat</label>
                <p class="text-xs text-gray-500 mb-4">Centang dokumen yang wajib dibawa warga saat mengurus surat ini.</p>

                @if(isset($persyaratans) && $persyaratans->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach ($persyaratans as $item)
                            <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-emerald-500 cursor-pointer transition-colors group shadow-sm">
                                <input type="checkbox" name="persyaratan[]" value="{{ $item->id }}"
                                    class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer"
                                    {{ in_array($item->id, old('persyaratan', [])) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-700 select-none">{{ $item->nama }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center gap-2 text-sm text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        Data persyaratan masih kosong. Silakan isi master persyaratan terlebih dahulu.
                    </div>
                @endif
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-800 mb-2">Isi Template Surat</label>
                <div class="relative z-0">
                    <textarea id="editor" name="konten_template">{{ old('konten_template') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <div class="flex items-center justify-end gap-3 pt-6 w-full">
                    <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="px-5 py-2.5 text-sm font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 focus:ring-4 focus:ring-red-500/20 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg shadow-md hover:from-emerald-700 hover:to-teal-700 focus:ring-4 focus:ring-emerald-500/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Template
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#editor',
            height: 600,
            license_key: 'gpl', // Tambahkan ini jika menggunakan versi self-hosted v7+
            menubar: 'file edit view insert format tools table',
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic textcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'table code removeformat | fullscreen preview',
            branding: false,
            promotion: false,
            content_style: `
                body { 
                    font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif; 
                    font-size: 14px; 
                    line-height: 1.6; 
                    color: #374151; 
                    padding: 1rem; 
                } 
                table { border-collapse: collapse; width: 100%; } 
                table td, table th { border: 1px solid #d1d5db; padding: 0.5rem; }
            `,
            setup: function (editor) {
                editor.on('init', function () {
                    const container = editor.getContainer();
                    if (container) {
                        container.style.overflow = 'visible';
                    }
                });
            }
        });
    });
</script>
@endsection