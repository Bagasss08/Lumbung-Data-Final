@extends('layouts.admin')

@section('title', 'Tambah Peserta Bantuan')

@section('content')

{{-- Breadcrumb --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('admin.bantuan.index') }}" class="hover:text-emerald-600 transition-colors font-medium">Program
        Bantuan</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <a href="{{ route('admin.bantuan.show', $bantuan->id) }}"
        class="hover:text-emerald-600 transition-colors font-medium truncate max-w-[200px]">
        {{ $bantuan->nama }}
    </a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-600 font-medium">Tambah Peserta</span>
</div>

{{-- Program Info Banner --}}
<div class="flex items-center gap-4 bg-emerald-50 border border-emerald-100 rounded-2xl px-5 py-4 mb-6">
    <div
        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </div>
    <div>
        <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wide">Program</p>
        <p class="text-sm font-bold text-gray-900">{{ $bantuan->nama }}</p>
        <p class="text-xs text-gray-500 mt-0.5">
            {{ $bantuan->sasaran_label }}
            @if($bantuan->nominal) · Rp {{ number_format($bantuan->nominal, 0, ',', '.') }} @endif
            @if($bantuan->tahun) · Tahun {{ $bantuan->tahun }} @endif
        </p>
    </div>
</div>

{{-- Main Form Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{
        nikInput: '{{ old('peserta', '') }}',
        searching: false,
        found: false,
        notFound: false,
        pendudukData: null,

        async cariNIK() {
            if (this.nikInput.length < 16) {
                this.found = false;
                this.notFound = false;
                return;
            }
            this.searching = true;
            this.found = false;
            this.notFound = false;
            try {
                const res = await fetch(`/admin/bantuan/cari-penduduk?nik=${this.nikInput}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                if (data.found) {
                    this.pendudukData = data.penduduk;
                    this.found = true;
                } else {
                    this.notFound = true;
                }
            } catch(e) {
                this.notFound = true;
            } finally {
                this.searching = false;
            }
        }
     }">

    {{-- Card Header --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-900">Tambah Peserta Baru</h3>
                <p class="text-xs text-gray-500 mt-0.5">Masukkan NIK untuk mencari data penduduk secara otomatis</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.bantuan.peserta.store', $bantuan->id) }}" method="POST">
            @csrf

            {{-- STEP 1: Input NIK --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    NIK Penduduk <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" name="peserta" x-model="nikInput"
                            @input="if(nikInput.length < 16) { found = false; notFound = false; }" class="w-full px-4 py-2.5 rounded-xl border font-mono text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all
                                {{ $errors->has('peserta') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}"
                            placeholder="Masukkan 16 digit NIK..." maxlength="16" value="{{ old('peserta') }}" required>
                        {{-- Loading spinner --}}
                        <div x-show="searching" class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="animate-spin w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="button" @click="cariNIK()"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                </div>
                @error('peserta')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- HASIL: Penduduk ditemukan --}}
            <div x-show="found" x-transition class="mb-6">
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0"
                            x-text="pendudukData ? pendudukData.nama.charAt(0).toUpperCase() : ''">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-semibold text-emerald-600 uppercase tracking-wide">Penduduk
                                    Ditemukan</span>
                            </div>
                            <p class="font-bold text-gray-900 text-base" x-text="pendudukData?.nama"></p>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 mt-2">
                                <p class="text-xs text-gray-500">NIK: <span class="font-mono font-medium text-gray-700"
                                        x-text="pendudukData?.nik"></span></p>
                                <p class="text-xs text-gray-500">L/P: <span class="font-medium text-gray-700"
                                        x-text="pendudukData?.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                                </p>
                                <p class="text-xs text-gray-500">Tgl Lahir: <span class="font-medium text-gray-700"
                                        x-text="pendudukData?.tanggal_lahir"></span></p>
                                <p class="text-xs text-gray-500 col-span-2">Alamat: <span
                                        class="font-medium text-gray-700" x-text="pendudukData?.alamat ?? '-'"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-emerald-600 mt-3 font-medium">
                        ✓ Data akan otomatis tersimpan. Klik <strong>Simpan Peserta</strong> untuk melanjutkan.
                    </p>
                </div>
            </div>

            {{-- HASIL: Tidak ditemukan — form manual --}}
            <div x-show="notFound" x-transition class="mb-6">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <p class="text-sm font-semibold text-amber-700">NIK tidak ditemukan di database penduduk</p>
                    </div>
                    <p class="text-xs text-amber-600 mt-1 ml-6">Penduduk mungkin dari luar desa. Silakan isi data secara
                        manual di bawah.</p>
                </div>

                {{-- Form Manual --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kartu_nama"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('kartu_nama') ? 'border-red-400 bg-red-50' : 'border-gray-200' }} text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            placeholder="Nama sesuai KTP" value="{{ old('kartu_nama') }}">
                        @error('kartu_nama')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">NIK di Kartu</label>
                        <input type="text" name="kartu_nik"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            placeholder="16 digit NIK" maxlength="16" value="{{ old('kartu_nik') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor ID / Kode Kartu</label>
                        <input type="text" name="kartu_no_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            placeholder="Nomor kartu bantuan (jika ada)" value="{{ old('kartu_no_id') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tempat Lahir</label>
                        <input type="text" name="kartu_tempat_lahir"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            placeholder="Kota / Kabupaten" value="{{ old('kartu_tempat_lahir') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                        <input type="date" name="kartu_tanggal_lahir"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            value="{{ old('kartu_tanggal_lahir') }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Lengkap</label>
                        <input type="text" name="kartu_alamat"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all"
                            placeholder="Jl. ... Desa ... Kec. ..." value="{{ old('kartu_alamat') }}">
                    </div>
                </div>
            </div>

            {{-- Error dari server (misal: sudah terdaftar) --}}
            @if(session('error'))
            <div
                class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Peserta
                </button>
                <a href="{{ route('admin.bantuan.show', $bantuan->id) }}"
                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-6 py-2.5 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection