@extends('layouts.admin')

@section('title', 'Edit Identitas Desa')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Identitas Desa</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi identitas dan profil desa</p>
        </div>
        <a href="{{ route('admin.identitas-desa.index') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.identitas-desa.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Left Sidebar - Logo & Images -->
            <div class="space-y-6">
                <!-- Logo Desa Card -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Logo Desa</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Preview Logo -->
                        <div class="mb-4 flex justify-center">
                            <div
                                class="w-32 h-32 rounded-2xl bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 flex items-center justify-center overflow-hidden shadow-inner">
                                @if($desa->logo_desa &&
                                file_exists(storage_path('app/public/logo-desa/'.$desa->logo_desa)))
                                <img src="{{ asset('storage/logo-desa/'.$desa->logo_desa) }}"
                                    class="w-full h-full object-contain p-2" alt="Logo Desa">
                                @else
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Dimensi Logo -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Dimensi Logo (px)</label>
                                <input type="text" name="dimensi_logo" placeholder="Contoh: 512"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-gray-400 bg-gray-50 hover:bg-white">
                                <p class="mt-1 text-xs text-gray-500">Kosongkan untuk dimensi otomatis</p>
                            </div>

                            <!-- Upload Logo -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Upload Logo Baru</label>
                                <label
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="text-xs text-gray-500 font-medium">Klik untuk upload</p>
                                        <p class="text-xs text-gray-400">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input type="file" name="logo_desa" accept="image/*" class="hidden">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gambar Kantor Card -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900">Kantor Desa</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Preview Kantor -->
                        <div class="mb-4">
                            <div
                                class="w-full h-40 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 flex items-center justify-center overflow-hidden shadow-inner">
                                @if($desa->gambar_kantor &&
                                file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
                                <img src="{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}"
                                    class="w-full h-full object-cover" alt="Kantor Desa">
                                @else
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                @endif
                            </div>
                        </div>

                        <!-- Upload Kantor -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Upload Gambar Baru</label>
                            <label
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-gray-500 font-medium">Klik untuk upload</p>
                                    <p class="text-xs text-gray-400">PNG, JPG (MAX. 5MB)</p>
                                </div>
                                <input type="file" name="gambar_kantor" accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Form - 3 columns -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Identitas Desa -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Identitas Desa</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Desa <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Desa</label>
                                <input type="text" name="kode_desa" value="{{ old('kode_desa', $desa->kode_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode BPS Desa</label>
                                <input type="text" name="kode_bps_desa"
                                    value="{{ old('kode_bps_desa', $desa->kode_bps_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $desa->kode_pos) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kepala Desa -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Kepala Desa</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kepala Desa</label>
                                <input type="text" name="kepala_desa"
                                    value="{{ old('kepala_desa', $desa->kepala_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIP Kepala Desa</label>
                                <input type="text" name="nip_kepala_desa"
                                    value="{{ old('nip_kepala_desa', $desa->nip_kepala_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak Desa -->
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Kontak Desa</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Kantor Desa</label>
                                <textarea name="alamat_kantor" rows="3"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 hover:bg-white resize-none">{{ old('alamat_kantor', $desa->alamat_kantor) }}</textarea>
                            </div>
                            <div class="mb-6">
                                <label for="link_peta" class="block text-sm font-bold text-slate-700 mb-2">Link Embed Google Maps (Iframe URL)</label>
                                <textarea name="link_peta" id="link_peta" rows="3" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" 
                                    placeholder="Contoh: https://www.google.com/maps/embed?pb=...">{{ old('link_peta', $desa->link_peta) }}</textarea>
                                <p class="text-xs text-slate-500 mt-1">Buka Google Maps > Cari Desa > Klik Bagikan > Pilih 'Sematkan Peta' > Salin hanya bagian URL di dalam src="..."</p>
                            </div>  
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Desa</label>
                                    <input type="email" name="email_desa"
                                        value="{{ old('email_desa', $desa->email_desa) }}"
                                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 hover:bg-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon Desa</label>
                                    <input type="text" name="telepon_desa"
                                        value="{{ old('telepon_desa', $desa->telepon_desa) }}"
                                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 hover:bg-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ponsel Desa</label>
                                    <input type="text" name="ponsel_desa"
                                        value="{{ old('ponsel_desa', $desa->ponsel_desa) }}"
                                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 hover:bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Website Desa</label>
                                <input type="text" name="website_desa"
                                    value="{{ old('website_desa', $desa->website_desa) }}"
                                    class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 hover:bg-white"
                                    placeholder="https://desa.example.com">
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Wilayah Administratif -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Kecamatan -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Kecamatan</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Nama Kecamatan</label>
                                <input type="text" name="kecamatan" value="{{ old('kecamatan', $desa->kecamatan) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Kode Kecamatan</label>
                                <input type="text" name="kode_kecamatan"
                                    value="{{ old('kode_kecamatan', $desa->kode_kecamatan) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Nama Camat</label>
                                <input type="text" name="nama_camat" value="{{ old('nama_camat', $desa->nama_camat) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">NIP Camat</label>
                                <input type="text" name="nip_camat" value="{{ old('nip_camat', $desa->nip_camat) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Kabupaten -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center shadow-lg shadow-orange-500/30">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Kabupaten</h3>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Nama Kabupaten</label>
                                <input type="text" name="kabupaten" value="{{ old('kabupaten', $desa->kabupaten) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Kode Kabupaten</label>
                                <input type="text" name="kode_kabupaten"
                                    value="{{ old('kode_kabupaten', $desa->kode_kabupaten) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-600 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">Provinsi</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Nama Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi', $desa->provinsi) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50 hover:bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6">
                    <a href="{{ route('admin.identitas-desa.index') }}"
                        class="px-6 py-3 rounded-xl font-semibold text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:scale-105">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection 