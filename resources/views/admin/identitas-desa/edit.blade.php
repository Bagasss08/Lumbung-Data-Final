@extends('layouts.admin')

@section('title', 'Edit Identitas Desa')

@section('content')

{{-- ============================================================ --}}
{{-- HEADER: Title kiri + Breadcrumb + Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Edit Identitas Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Perbarui informasi identitas dan profil desa</p>
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
            <a href="{{ route('admin.identitas-desa.index') }}" class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-medium">
                Identitas Desa
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Edit</span>
        </nav>
        <a href="{{ route('admin.identitas-desa.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 text-xs font-semibold rounded-xl shadow-sm border border-gray-200 dark:border-slate-600 transition-all duration-200 hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.identitas-desa.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Sidebar -->
        <div class="space-y-6">

            <!-- Logo Desa -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Logo Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4 flex justify-center">
                        <div class="w-32 h-32 rounded-2xl bg-gray-50 dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 flex items-center justify-center overflow-hidden shadow-inner">
                            @if($desa->logo_desa && file_exists(storage_path('app/public/logo-desa/'.$desa->logo_desa)))
                            <img src="{{ asset('storage/logo-desa/'.$desa->logo_desa) }}" class="w-full h-full object-contain p-2" alt="Logo Desa">
                            @else
                            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Dimensi Logo (px)</label>
                            <input type="text" name="dimensi_logo" placeholder="Contoh: 512"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-gray-400 dark:placeholder:text-slate-500 bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Kosongkan untuk dimensi otomatis</p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Upload Logo Baru</label>
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Klik untuk upload</p>
                                    <p class="text-xs text-gray-400 dark:text-slate-500">PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <input type="file" name="logo_desa" accept="image/*" class="hidden">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gambar Kantor -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kantor Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="w-full h-40 rounded-xl bg-gray-50 dark:bg-slate-700 border-2 border-gray-200 dark:border-slate-600 flex items-center justify-center overflow-hidden shadow-inner">
                            @if($desa->gambar_kantor && file_exists(storage_path('app/public/gambar-kantor/'.$desa->gambar_kantor)))
                            <img src="{{ asset('storage/gambar-kantor/'.$desa->gambar_kantor) }}" class="w-full h-full object-cover" alt="Kantor Desa">
                            @else
                            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Upload Gambar Baru</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-slate-700/50 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-xs text-gray-500 dark:text-slate-400 font-medium">Klik untuk upload</p>
                                <p class="text-xs text-gray-400 dark:text-slate-500">PNG, JPG (MAX. 5MB)</p>
                            </div>
                            <input type="file" name="gambar_kantor" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="lg:col-span-3 space-y-6">

            <!-- Identitas Desa -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Identitas Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Desa <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode Desa</label>
                            <input type="text" name="kode_desa" value="{{ old('kode_desa', $desa->kode_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode BPS Desa</label>
                            <input type="text" name="kode_bps_desa" value="{{ old('kode_bps_desa', $desa->kode_bps_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode Pos</label>
                            <input type="text" name="kode_pos" value="{{ old('kode_pos', $desa->kode_pos) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kepala Desa -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Kepala Desa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Kepala Desa</label>
                            <input type="text" name="kepala_desa" value="{{ old('kepala_desa', $desa->kepala_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">NIP Kepala Desa</label>
                            <input type="text" name="nip_kepala_desa" value="{{ old('nip_kepala_desa', $desa->nip_kepala_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak Desa -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-teal-50 to-emerald-50 dark:from-teal-900/30 dark:to-emerald-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-600 to-emerald-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Kontak Desa</h3>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Alamat Kantor Desa</label>
                        <textarea name="alamat_kantor" rows="3"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100 resize-none">{{ old('alamat_kantor', $desa->alamat_kantor) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Link Embed Google Maps (Iframe URL)</label>
                        <textarea name="link_peta" id="link_peta" rows="3"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100 resize-none"
                            placeholder="Contoh: https://www.google.com/maps/embed?pb=...">{{ old('link_peta', $desa->link_peta) }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Buka Google Maps > Cari Desa > Klik Bagikan > Pilih 'Sematkan Peta' > Salin hanya bagian URL di dalam src="..."</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Email Desa</label>
                            <input type="email" name="email_desa" value="{{ old('email_desa', $desa->email_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Telepon Desa</label>
                            <input type="text" name="telepon_desa" value="{{ old('telepon_desa', $desa->telepon_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Ponsel Desa</label>
                            <input type="text" name="ponsel_desa" value="{{ old('ponsel_desa', $desa->ponsel_desa) }}"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Website Desa</label>
                        <input type="text" name="website_desa" value="{{ old('website_desa', $desa->website_desa) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100"
                            placeholder="https://desa.example.com">
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- MEDIA SOSIAL CARD (BARU)                                      -->
            <!-- ============================================================ -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/30 dark:to-purple-900/30 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-600 to-purple-600 flex items-center justify-center shadow-lg shadow-violet-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-slate-100">Media Sosial</h3>
                            <p class="text-xs text-gray-500 dark:text-slate-400">Isi dengan URL lengkap, contoh: https://facebook.com/namahalaman</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- Facebook --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded bg-blue-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </span>
                                    Facebook
                                </span>
                            </label>
                            <input type="url" name="facebook" value="{{ old('facebook', $desa->facebook) }}"
                                placeholder="https://facebook.com/namahalaman"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100 placeholder:text-gray-400 dark:placeholder:text-slate-500">
                            @if($desa->facebook)
                                <a href="{{ $desa->facebook }}" target="_blank" class="inline-flex items-center gap-1 mt-1.5 text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Lihat halaman
                                </a>
                            @endif
                        </div>

                        {{-- Instagram --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.665-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </span>
                                    Instagram
                                </span>
                            </label>
                            <input type="url" name="instagram" value="{{ old('instagram', $desa->instagram) }}"
                                placeholder="https://instagram.com/namaakun"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100 placeholder:text-gray-400 dark:placeholder:text-slate-500">
                            @if($desa->instagram)
                                <a href="{{ $desa->instagram }}" target="_blank" class="inline-flex items-center gap-1 mt-1.5 text-xs text-pink-600 dark:text-pink-400 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Lihat profil
                                </a>
                            @endif
                        </div>

                        {{-- YouTube --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded bg-red-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    </span>
                                    YouTube
                                </span>
                            </label>
                            <input type="url" name="youtube" value="{{ old('youtube', $desa->youtube) }}"
                                placeholder="https://youtube.com/@namachannel"
                                class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100 placeholder:text-gray-400 dark:placeholder:text-slate-500">
                            @if($desa->youtube)
                                <a href="{{ $desa->youtube }}" target="_blank" class="inline-flex items-center gap-1 mt-1.5 text-xs text-red-600 dark:text-red-400 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Lihat channel
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- Wilayah Administratif -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kecamatan -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/30 dark:to-pink-900/30 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kecamatan</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Kecamatan</label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan', $desa->kecamatan) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode Kecamatan</label>
                            <input type="text" name="kode_kecamatan" value="{{ old('kode_kecamatan', $desa->kode_kecamatan) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Camat</label>
                            <input type="text" name="nama_camat" value="{{ old('nama_camat', $desa->nama_camat) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">NIP Camat</label>
                            <input type="text" name="nip_camat" value="{{ old('nip_camat', $desa->nip_camat) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                    </div>
                </div>

                <!-- Kabupaten -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center shadow-lg shadow-orange-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Kabupaten</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Kabupaten</label>
                            <input type="text" name="kabupaten" value="{{ old('kabupaten', $desa->kabupaten) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode Kabupaten</label>
                            <input type="text" name="kode_kabupaten" value="{{ old('kode_kabupaten', $desa->kode_kabupaten) }}"
                                class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                        </div>
                    </div>
                </div>

                <!-- Provinsi -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/30 dark:to-blue-900/30 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-600 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/30">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-slate-100">Provinsi</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Nama Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi', $desa->provinsi) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-2">Kode Provinsi</label>
                                <input type="text" name="kode_provinsi" value="{{ old('kode_provinsi', $desa->kode_provinsi) }}"
                                    class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 dark:border-slate-600 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all bg-gray-50 dark:bg-slate-700 hover:bg-white dark:hover:bg-slate-600 text-gray-900 dark:text-slate-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-2">
                <a href="{{ route('admin.identitas-desa.index') }}"
                    class="px-6 py-3 rounded-xl font-semibold text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 border border-gray-300 dark:border-slate-600 transition-all duration-200 shadow-sm hover:shadow-md">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</form>

@endsection