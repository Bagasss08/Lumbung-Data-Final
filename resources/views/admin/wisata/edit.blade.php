@extends('layouts.admin')

@section('title', 'Edit Wisata')

@section('content')
<div x-data="{
    previewUrl: '{{ $wisata->gambar_url }}',
    namaFile: '',
    hapusGambar: false,
    fasilitas: @json(old('fasilitas', $wisata->fasilitas ?? [''])),
    addFasilitas() { this.fasilitas.push('') },
    removeFasilitas(i) { this.fasilitas.splice(i, 1) }
}">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.wisata.index') }}" class="hover:text-emerald-600 transition-colors">Wisata</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-700 font-medium">Edit: {{ $wisata->nama }}</span>
    </div>

    @if($errors->any())
    <div class="flex items-start gap-3 p-4 mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
        </svg>
        <ul class="text-sm space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.wisata.update', $wisata) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input type="hidden" name="hapus_gambar" :value="hapusGambar ? '1' : '0'">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri - Gambar --}}
            <div class="lg:col-span-1 space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Foto Wisata</h3>
                    <div class="flex flex-col items-center gap-4">

                        {{-- Preview Area --}}
                        <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-gray-50 border-2 border-dashed border-gray-200 cursor-pointer group"
                             @click="$refs.inputGambar.click()">

                            {{-- Gambar (existing atau preview baru) --}}
                            <img x-show="previewUrl && !hapusGambar"
                                 :src="previewUrl"
                                 alt="Preview"
                                 class="absolute inset-0 w-full h-full object-cover">

                            {{-- State: gambar dihapus / belum ada --}}
                            <div x-show="!previewUrl || hapusGambar"
                                 class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-gray-300 group-hover:text-emerald-400 transition-colors">
                                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs font-medium">Klik untuk pilih foto</p>
                            </div>

                            {{-- Overlay hover --}}
                            <div x-show="previewUrl && !hapusGambar"
                                 class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <div class="flex flex-col items-center gap-1 text-white">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs font-semibold">Ganti Foto</span>
                                </div>
                            </div>
                        </div>

                        {{-- Input file (tersembunyi) --}}
                        <input type="file"
                               name="gambar"
                               x-ref="inputGambar"
                               class="hidden"
                               accept="image/jpeg,image/png,image/webp"
                               @change="
                                   const file = $event.target.files[0];
                                   if (!file) return;
                                   if (file.size > 2 * 1024 * 1024) {
                                       alert('Ukuran file maksimal 2MB!');
                                       $event.target.value = '';
                                       return;
                                   }
                                   previewUrl = URL.createObjectURL(file);
                                   namaFile = file.name;
                                   hapusGambar = false;
                               ">

                        {{-- Tombol Pilih / Ganti Foto (selalu tampil) --}}
                        <button type="button"
                                @click="$refs.inputGambar.click()"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 hover:bg-gray-50 hover:border-emerald-300 transition-all">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span x-text="previewUrl && !hapusGambar ? 'Ganti Foto' : 'Pilih Foto'"></span>
                        </button>

                        {{-- Info file baru dipilih --}}
                        <div x-show="namaFile" class="w-full flex items-center gap-2 px-3 py-2 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-text="namaFile" class="text-xs text-emerald-700 font-medium truncate flex-1"></span>
                            <button type="button"
                                    @click="previewUrl = '{{ $wisata->gambar_url }}'; namaFile = ''; hapusGambar = false; $refs.inputGambar.value = ''"
                                    class="text-emerald-400 hover:text-red-500 transition-colors flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Tombol hapus foto (jika ada foto existing & belum dihapus) --}}
                        @if($wisata->gambar)
                        <button type="button"
                                x-show="!hapusGambar && !namaFile"
                                @click="hapusGambar = true; $refs.inputGambar.value = ''"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2 text-xs font-medium text-red-500 border border-red-200 rounded-xl hover:bg-red-50 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Foto
                        </button>

                        {{-- Notif: foto akan dihapus --}}
                        <div x-show="hapusGambar"
                             class="w-full flex items-center gap-2 px-3 py-2 bg-red-50 border border-red-200 rounded-xl">
                            <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span class="text-xs text-red-600 font-medium flex-1">Foto akan dihapus saat disimpan</span>
                            <button type="button"
                                    @click="hapusGambar = false; previewUrl = '{{ $wisata->gambar_url }}'"
                                    class="text-red-400 hover:text-red-600 transition-colors flex-shrink-0 text-xs font-semibold underline">
                                Batal
                            </button>
                        </div>
                        @endif

                        <p class="text-xs text-gray-400 text-center">JPG, PNG, WebP. Maks 2MB</p>

                        @error('gambar')
                        <p class="text-xs text-red-500 w-full text-center">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Fasilitas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Fasilitas</h3>
                        <button type="button" @click="addFasilitas()"
                            class="flex items-center gap-1 px-2.5 py-1 text-xs font-medium text-emerald-600 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah
                        </button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(item, index) in fasilitas" :key="index">
                            <div class="flex items-center gap-2">
                                <input type="text" :name="'fasilitas[' + index + ']'" x-model="fasilitas[index]"
                                    placeholder="Contoh: Toilet, Parkir..."
                                    class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                <button type="button" @click="removeFasilitas(index)"
                                    x-show="fasilitas.length > 1"
                                    class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan - Form --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-5">Informasi Wisata</h3>
                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Wisata <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama', $wisata->nama) }}"
                                class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                {{ $errors->has('nama') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                            @error('nama')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori" class="w-full px-3.5 py-2.5 text-sm border rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                    {{ $errors->has('kategori') ? 'border-red-300 bg-red-50' : 'border-gray-200' }}">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori', $wisata->kategori) === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                                @error('kategori')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="aktif" {{ old('status', $wisata->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status', $wisata->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none">{{ old('deskripsi', $wisata->deskripsi) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $wisata->lokasi) }}"
                                class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Buka</label>
                                <input type="text" name="jam_buka" value="{{ old('jam_buka', $wisata->jam_buka) }}"
                                    placeholder="Contoh: 08.00 – 17.00 WIB"
                                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Tiket</label>
                                <input type="text" name="harga_tiket" value="{{ old('harga_tiket', $wisata->harga_tiket) }}"
                                    placeholder="Contoh: Rp5.000 / Gratis"
                                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.wisata.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Wisata
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection