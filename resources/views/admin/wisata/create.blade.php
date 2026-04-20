@extends('layouts.admin')

@section('title', 'Tambah Wisata | Panel Administrasi')

@section('content')
<div x-data="wisataFormHandler()" class="pb-24">
    
    {{-- LOGIKA JAVASCRIPT --}}
    <script>
        function wisataFormHandler() {
            return {
                // State dasar sesuai Model
                nama: '{{ old("nama") }}',
                slug: '',
                status: '{{ old("status", "aktif") }}',
                previewUrl: null,
                fasilitas: @json(old('fasilitas', [''])),

                // Inisialisasi
                init() {
                    if(this.nama) this.generateSlug();
                },

                // Generate Slug (Sync dengan logic backend)
                generateSlug() {
                    this.slug = this.nama
                        .toLowerCase()
                        .replace(/[^\w ]+/g, '')
                        .replace(/ +/g, '-');
                },

                // Handle Preview Gambar
                handleImagePreview(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Validasi tipe file sederhana
                    if (!file.type.match('image.*')) {
                        alert('Silakan pilih file gambar!');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                // Hapus Gambar
                clearImage() {
                    this.previewUrl = null;
                    document.getElementById('gambar').value = '';
                },

                // Logika Fasilitas (Array Cast)
                addFasilitas() {
                    this.fasilitas.push('');
                },

                removeFasilitas(index) {
                    if (this.fasilitas.length > 1) {
                        this.fasilitas.splice(index, 1);
                    } else {
                        this.fasilitas = [''];
                    }
                }
            }
        }
    </script>

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.wisata.index') }}" class="hover:text-emerald-600 transition-colors">Daftar Wisata</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-900 font-medium">Tambah Baru</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Entri Destinasi Wisata</h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.wisata.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
                Batalkan
            </a>
            <button type="submit" form="formWisata" class="px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-100 transition-all">
                Simpan Destinasi
            </button>
        </div>
    </div>

    {{-- Alert Error --}}
    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-xl shadow-sm">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span class="text-red-800 font-bold">Terjadi Kesalahan Validasi</span>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 ml-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.wisata.store') }}" method="POST" enctype="multipart/form-data" id="formWisata">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- KOLOM KIRI: SETTINGS & MEDIA (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Card Status (PENTING: Menjawab Error Anda) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Status Publikasi</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="aktif" x-model="status" class="peer hidden">
                            <div class="flex items-center justify-center p-3 border-2 rounded-xl transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-gray-400 peer-checked:text-emerald-700 border-gray-100 bg-gray-50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-sm font-semibold">Aktif</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="nonaktif" x-model="status" class="peer hidden">
                            <div class="flex items-center justify-center p-3 border-2 rounded-xl transition-all peer-checked:border-red-500 peer-checked:bg-red-50 text-gray-400 peer-checked:text-red-700 border-gray-100 bg-gray-50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-sm font-semibold">Nonaktif</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Card Image Upload --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <label class="block text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Gambar Utama</label>
                    <div class="relative group">
                        <div class="w-full aspect-[4/3] rounded-2xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-200 flex items-center justify-center">
                            <template x-if="previewUrl">
                                <div class="relative w-full h-full">
                                    <img :src="previewUrl" class="w-full h-full object-cover">
                                    <button @click="clearImage()" type="button" class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="!previewUrl">
                                <div class="text-center p-4">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <p class="text-xs text-gray-400 font-medium">PNG, JPG atau WEBP (Maks. 2MB)</p>
                                </div>
                            </template>
                        </div>
                        <input type="file" name="gambar" id="gambar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer" @change="handleImagePreview">
                    </div>
                </div>

                {{-- Card Fasilitas (Cast Array di Model) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Fasilitas</label>
                        <button type="button" @click="addFasilitas()" class="text-emerald-600 hover:text-emerald-700 font-bold text-xs flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            TAMBAH
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(item, index) in fasilitas" :key="index">
                            <div class="flex gap-2">
                                <div class="relative flex-grow">
                                    <span class="absolute left-3 top-2.5 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </span>
                                    <input type="text" :name="'fasilitas[' + index + ']'" x-model="fasilitas[index]" placeholder="Contoh: Toilet" class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                                </div>
                                <button type="button" @click="removeFasilitas(index)" class="p-2 text-red-400 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: KONTEN UTAMA (8 Kolom) --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- Detail Informasi --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Destinasi <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" x-model="nama" @input="generateSlug()" placeholder="Masukan nama wisata" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all text-lg font-medium">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Slug (URL)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-400 text-sm">/</span>
                                    <input type="text" name="slug" x-model="slug" readonly class="w-full pl-7 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-500 text-sm font-mono">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                <select name="kategori" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none appearance-none bg-no-repeat bg-[right_1rem_center] bg-[length:1em_1em]">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="8" placeholder="Ceritakan keunikan destinasi ini..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none resize-none leading-relaxed">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Informasi Operasional & Lokasi --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Lokasi & Harga
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat / Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Jl. Raya Desa No. 10" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Operasional</label>
                            <input type="text" name="jam_buka" value="{{ old('jam_buka') }}" placeholder="Contoh: 08:00 - 17:00" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Tiket</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-400 font-bold text-sm">Rp</span>
                                <input type="text" name="harga_tiket" value="{{ old('harga_tiket') }}" placeholder="Contoh: 15.000" class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    /* Custom Styling untuk Select Arrow */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }
</style>
@endsection