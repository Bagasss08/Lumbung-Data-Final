@extends('layouts.admin')

@section('title', 'Cetak Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Cetak Surat</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih template surat dan isi data untuk mencetak surat</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Side - Template Selection -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pilih Template Surat</h3>
                    <p class="text-sm text-gray-500 mt-1">Klik template untuk memulai</p>
                </div>

                <!-- Search Template -->
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" id="searchTemplate" 
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                            placeholder="Cari template...">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Template List -->
                <div class="p-4 max-h-[600px] overflow-y-auto" id="templateList">
                    @forelse($templates as $template)
                    <div class="template-item mb-3 p-4 border-2 border-gray-200 rounded-lg hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer" 
                         data-template-id="{{ $template->id }}"
                         data-template-name="{{ $template->nama_template }}"
                         data-template-jenis="{{ $template->jenisSurat->nama ?? '' }}"
                         data-template-fields='{{ json_encode(json_decode($template->fields_json, true)) }}'
                         onclick='selectTemplate(this)'>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $template->nama_template }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $template->jenisSurat->nama ?? '' }}</p>
                                @if($template->keterangan)
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($template->keterangan, 50) }}</p>
                                @endif
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 template-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-900">Belum ada template</p>
                        <p class="text-sm text-gray-500 mt-1">Silakan buat template surat terlebih dahulu</p>
                        <a href="{{ route('admin.layanan-surat.pengaturan') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Buat Template
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side - Form Input -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <!-- Form Header -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900" id="formTitle">Form Pengisian Surat</h3>
                    <p class="text-sm text-gray-500 mt-1" id="formSubtitle">Pilih template di sebelah kiri untuk memulai</p>
                </div>

                <!-- Form Content -->
                <div id="formContainer" class="p-6">
                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-16">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Template Dipilih</h4>
                        <p class="text-sm text-gray-500">Pilih template surat dari daftar di sebelah kiri untuk mulai mengisi data</p>
                    </div>

                    <!-- Dynamic Form -->
                    <form id="dynamicForm" action="{{ route('admin.layanan-surat.cetak.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="hidden" name="template_id" id="selectedTemplateId">
                        
                        <!-- NIK Search Section -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200">
                            <label for="searchNik" class="block text-sm font-bold text-blue-900 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari Data Penduduk (Auto-Fill)
                            </label>
                            <div class="flex gap-2">
                                <div class="flex-1 relative">
                                    <input type="text" id="searchNik" 
                                        class="w-full pl-10 pr-4 py-3 text-sm border-2 border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                        placeholder="Masukkan 16 digit NIK..."
                                        maxlength="16"
                                        pattern="[0-9]{16}">
                                    <svg class="w-5 h-5 text-blue-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <button type="button" onclick="searchPenduduk()" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Cari
                                    </span>
                                </button>
                            </div>
                            <div class="flex items-start gap-2 mt-3 p-2 bg-blue-100 rounded">
                                <svg class="w-4 h-4 text-blue-700 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-xs text-blue-800 font-medium">
                                    Data penduduk dan data desa akan otomatis terisi setelah NIK ditemukan
                                </p>
                            </div>
                        </div>

                        <!-- Dynamic fields will be inserted here -->
                        <div id="dynamicFields" class="space-y-5">
                            <!-- Fields generated by JavaScript -->
                        </div>

                        <!-- Fixed Fields -->
                        <div class="mt-8 pt-6 border-t-2 border-gray-200">
                            <h4 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Informasi Surat
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Nomor Surat -->
                                <div>
                                    <label for="nomor_surat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Nomor Surat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nomor_surat" name="nomor_surat" 
                                        class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                                        placeholder="Contoh: 001/DS/2024" required>
                                </div>

                                <!-- Tanggal Surat -->
                                <div>
                                    <label for="tanggal_surat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Surat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                                </div>

                                <!-- Perihal -->
                                <div class="md:col-span-2">
                                    <label for="perihal" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Perihal <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="perihal" name="perihal" 
                                        class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                                        placeholder="Perihal surat" required>
                                </div>

                                <!-- Keterangan -->
                                <div class="md:col-span-2">
                                    <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Keterangan Tambahan
                                    </label>
                                    <textarea id="keterangan" name="keterangan" rows="3"
                                        class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" 
                                        placeholder="Keterangan tambahan (opsional)"></textarea>
                                </div>

                                <!-- File Upload -->
                                <div class="md:col-span-2">
                                    <label for="file_surat" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Upload File Pendukung (Opsional)
                                    </label>
                                    <input type="file" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx"
                                        class="w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        Format: PDF, DOC, DOCX (Max: 2MB)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t-2 border-gray-200">
                            <button type="button" onclick="showPreview()" 
                                class="px-6 py-3 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm hover:shadow-md">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </span>
                            </button>
                            <button type="button" onclick="resetForm()" 
                                class="px-6 py-3 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-all shadow-sm hover:shadow-md">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Reset
                                </span>
                            </button>
                            <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg text-sm font-bold hover:from-emerald-700 hover:to-green-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    Buat & Cetak Surat
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Riwayat Surat yang Sudah Dicetak -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Riwayat Surat</h3>
                    <p class="text-sm text-gray-500 mt-1">Daftar surat yang sudah dicetak</p>
                </div>
                
                <!-- Filter -->
                <div class="flex items-center gap-3">
                    <select id="filterStatus" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="diarsipkan">Diarsipkan</option>
                        <option value="musnah">Musnah</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No. Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Template</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Perihal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($cetakSurat as $surat)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $surat->nomor_surat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $surat->template->nama_template ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($surat->perihal, 40) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($surat->status == 'aktif')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @elseif($surat->status == 'diarsipkan')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Diarsipkan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Musnah
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.layanan-surat.cetak.show', $surat->id) }}" 
                                    class="text-blue-600 hover:text-blue-800 font-medium transition-colors" title="Lihat">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.layanan-surat.cetak.print', $surat->id) }}" target="_blank"
                                    class="text-green-600 hover:text-green-800 font-medium transition-colors" title="Cetak">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.layanan-surat.cetak.edit', $surat->id) }}"
                                    class="text-yellow-600 hover:text-yellow-800 font-medium transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.layanan-surat.cetak.destroy', $surat->id) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-sm font-medium text-gray-900">Belum ada riwayat surat</p>
                            <p class="text-sm text-gray-500 mt-1">Surat yang sudah dicetak akan muncul di sini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($cetakSurat->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $cetakSurat->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Preview Modal -->
<div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Preview Surat</h3>
            <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="previewContent" class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <svg class="animate-spin h-12 w-12 mx-auto text-emerald-600 mb-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Memuat preview...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alert Templates -->
@if(session('success'))
<div id="successAlert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="errorAlert" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
    {{ session('error') }}
</div>
@endif

@push('styles')
<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}

/* Loading spinner animation */
@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s ease;
}

/* Form field focus effect */
input:focus, textarea:focus, select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Custom scrollbar */
#templateList::-webkit-scrollbar {
    width: 8px;
}

#templateList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#templateList::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 10px;
}

#templateList::-webkit-scrollbar-thumb:hover {
    background: #059669;
}
</style>
@endpush

@push('scripts')
<script>
let currentFormData = {};
let currentTemplateFields = [];

// Template selection
function selectTemplate(element) {
    const templateId = element.getAttribute('data-template-id');
    const templateName = element.getAttribute('data-template-name');
    const templateJenis = element.getAttribute('data-template-jenis');
    const fieldsJsonStr = element.getAttribute('data-template-fields');
    
    console.log('Template selected:', {
        id: templateId,
        name: templateName,
        jenis: templateJenis,
        fields: fieldsJsonStr
    });
    
    try {
        // Parse fields JSON
        const fieldsJson = JSON.parse(fieldsJsonStr);
        console.log('Parsed fields:', fieldsJson);
        
        // Update selected template ID
        document.getElementById('selectedTemplateId').value = templateId;
        
        // Update form title
        document.getElementById('formTitle').textContent = templateName;
        document.getElementById('formSubtitle').textContent = `Jenis: ${templateJenis} - Lengkapi data di bawah ini`;
        
        // Hide empty state, show form
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('dynamicForm').classList.remove('hidden');
        
        // Remove previous selection highlight
        document.querySelectorAll('.template-item').forEach(item => {
            item.classList.remove('border-emerald-500', 'bg-emerald-50', 'shadow-md');
            item.querySelector('.template-check').classList.add('hidden');
        });
        
        // Highlight selected template
        element.classList.add('border-emerald-500', 'bg-emerald-50', 'shadow-md');
        element.querySelector('.template-check').classList.remove('hidden');
        
        // Store current template fields
        currentTemplateFields = fieldsJson;
        
        // Generate dynamic fields
        generateDynamicFields(fieldsJson);
        
    } catch (error) {
        console.error('Error selecting template:', error);
        showNotification('Error memuat template: ' + error.message, 'error');
    }
}

// Generate dynamic form fields based on template
function generateDynamicFields(fieldsJson) {
    const container = document.getElementById('dynamicFields');
    container.innerHTML = '';
    
    try {
        let fields = [];
        
        // Parse fieldsJson if still string
        if (typeof fieldsJson === 'string') {
            fields = JSON.parse(fieldsJson);
        } else if (Array.isArray(fieldsJson)) {
            fields = fieldsJson;
        } else if (fieldsJson && typeof fieldsJson === 'object') {
            // If object, convert to array
            fields = Object.values(fieldsJson);
        }
        
        console.log('Generating fields:', fields);
        
        if (!fields || fields.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 bg-yellow-50 rounded-lg border-2 border-yellow-200">
                    <svg class="w-12 h-12 mx-auto text-yellow-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm font-medium text-yellow-800">Template ini tidak memiliki field khusus</p>
                    <p class="text-xs text-yellow-600 mt-1">Isi informasi surat di bagian bawah</p>
                </div>
            `;
            return;
        }
        
        // Create title
        const titleDiv = document.createElement('div');
        titleDiv.className = 'mb-4 pb-3 border-b-2 border-gray-200';
        titleDiv.innerHTML = `
            <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Data Template Surat
            </h4>
            <p class="text-xs text-gray-500 mt-1">Field yang ditandai <span class="text-red-500">*</span> wajib diisi</p>
        `;
        container.appendChild(titleDiv);
        
        // Create grid container
        const gridDiv = document.createElement('div');
        gridDiv.className = 'grid grid-cols-1 md:grid-cols-2 gap-5';
        
        // Auto-fill fields from database
        const autoFillFields = [
            'nama', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 
            'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 'status_hidup',
            'kewarganegaraan', 'alamat', 'no_telp', 'email', 'golongan_darah',
            'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan',
            // Fields dari identitas_desa  
            'kode_bps_desa', 'kode_kecamatan', 'nama_camat', 'nip_camat',
            'kode_kabupaten', 'kode_provinsi', 'kantor_desa', 'email_desa',
            'telepon_desa', 'ponsel_desa', 'website_desa', 'kepala_desa',
            'nip_kepala_desa', 'nama_penanggung_jawab_desa', 'no_ppwa',
            // Fields dari desa
            'kode_desa', 'nama_desa', 'kabupaten', 'provinsi',
            'kode_pos', 'luas_wilayah', 'klasifikasi_desa', 'alamat_kantor',
            'telp', 'logo_desa', 'gambar_kantor'
        ];
        
        fields.forEach((field, index) => {
            const fieldDiv = document.createElement('div');
            
            // Full width for textarea
            if (field.type === 'textarea') {
                fieldDiv.className = 'md:col-span-2';
            }
            
            // Create label
            const label = document.createElement('label');
            label.className = 'block text-sm font-semibold text-gray-700 mb-2';
            label.htmlFor = `field_${field.name}`;
            
            // Add icon for auto-fill fields
            const isAutoFill = autoFillFields.includes(field.name);
            if (isAutoFill) {
                label.innerHTML = `
                    <span class="flex items-center gap-1">
                        ${field.label || field.name}
                        ${field.required ? '<span class="text-red-500">*</span>' : ''}
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20" title="Auto-fill dari database">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </span>
                `;
            } else {
                label.textContent = field.label || field.name;
                if (field.required) {
                    const required = document.createElement('span');
                    required.className = 'text-red-500';
                    required.textContent = ' *';
                    label.appendChild(required);
                }
            }
            
            // Create input element
            let input;
            
            switch (field.type) {
                case 'textarea':
                    input = document.createElement('textarea');
                    input.rows = 3;
                    break;
                    
                case 'select':
                    input = document.createElement('select');
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = `Pilih ${field.label || field.name}`;
                    input.appendChild(defaultOption);
                    
                    if (field.options && Array.isArray(field.options)) {
                        field.options.forEach(option => {
                            const opt = document.createElement('option');
                            opt.value = option;
                            opt.textContent = option;
                            input.appendChild(opt);
                        });
                    }
                    break;
                    
                case 'date':
                    input = document.createElement('input');
                    input.type = 'date';
                    break;
                    
                case 'number':
                    input = document.createElement('input');
                    input.type = 'number';
                    break;
                    
                case 'email':
                    input = document.createElement('input');
                    input.type = 'email';
                    break;
                    
                case 'tel':
                    input = document.createElement('input');
                    input.type = 'tel';
                    break;
                    
                default:
                    input = document.createElement('input');
                    input.type = 'text';
            }
            
            // Set input attributes
            input.name = `data_warga[${field.name}]`;
            input.id = `field_${field.name}`;
            input.className = 'w-full px-4 py-2.5 text-sm border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all';
            input.placeholder = field.placeholder || `Masukkan ${field.label || field.name}`;
            
            // Add readonly and styling for auto-filled fields
            if (isAutoFill) {
                input.readOnly = true;
                input.classList.add('bg-blue-50', 'cursor-not-allowed', 'border-blue-200', 'text-blue-900', 'font-medium');
                input.title = 'Field ini akan otomatis terisi dari database';
            }
            
            if (field.required) {
                input.required = true;
            }
            
            // Append elements
            fieldDiv.appendChild(label);
            fieldDiv.appendChild(input);
            gridDiv.appendChild(fieldDiv);
        });
        
        container.appendChild(gridDiv);
        
    } catch (error) {
        console.error('Error generating fields:', error);
        container.innerHTML = `
            <div class="text-center py-8 bg-red-50 rounded-lg border-2 border-red-200">
                <svg class="w-12 h-12 mx-auto text-red-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-red-800">Error memuat field template</p>
                <p class="text-xs text-red-600 mt-1">${error.message}</p>
            </div>
        `;
    }
}

// Search penduduk by NIK with enhanced UX
function searchPenduduk() {
    const nikInput = document.getElementById('searchNik');
    const nik = nikInput.value.trim();
    
    // Validation
    if (!nik) {
        showNotification('Masukkan NIK terlebih dahulu', 'error');
        nikInput.focus();
        return;
    }
    
    if (nik.length !== 16) {
        showNotification('NIK harus 16 digit', 'error');
        nikInput.focus();
        return;
    }
    
    if (!/^\d+$/.test(nik)) {
        showNotification('NIK harus berupa angka', 'error');
        nikInput.focus();
        return;
    }
    
    // Show loading state
    const searchBtn = event.target;
    const originalHTML = searchBtn.innerHTML;
    searchBtn.innerHTML = `
        <span class="flex items-center gap-2">
            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Mencari...
        </span>
    `;
    searchBtn.disabled = true;
    nikInput.disabled = true;
    
    // Fetch data from server
    fetch(`/admin/layanan-surat/cetak/penduduk/${nik}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success && data.data) {
                fillFormData(data.data);
                showNotification('✓ Data berhasil dimuat!', 'success');
                
                // Highlight auto-filled fields briefly
                document.querySelectorAll('input[readonly], textarea[readonly], select[disabled]').forEach(field => {
                    field.classList.add('ring-2', 'ring-green-400');
                    setTimeout(() => {
                        field.classList.remove('ring-2', 'ring-green-400');
                    }, 2000);
                });
            } else {
                showNotification(data.message || 'Data penduduk tidak ditemukan', 'error');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showNotification('Terjadi kesalahan saat mengambil data. Silakan coba lagi.', 'error');
        })
        .finally(() => {
            // Restore button state
            searchBtn.innerHTML = originalHTML;
            searchBtn.disabled = false;
            nikInput.disabled = false;
        });
}

// Fill form with fetched data
function fillFormData(data) {
    console.log('Filling form with data:', data);
    currentFormData = data;
    
    // Fill all matching fields
    Object.keys(data).forEach(key => {
        const field = document.getElementById(`field_${key}`);
        if (field) {
            const value = data[key];
            
            // Handle different input types
            if (field.tagName === 'SELECT') {
                // For select fields, try to match the option
                const option = Array.from(field.options).find(opt => 
                    opt.value.toLowerCase() === String(value).toLowerCase()
                );
                if (option) {
                    field.value = option.value;
                }
            } else if (field.type === 'date') {
                // For date fields, format properly
                if (value) {
                    const date = new Date(value);
                    if (!isNaN(date.getTime())) {
                        field.value = date.toISOString().split('T')[0];
                    }
                }
            } else {
                // For text, textarea, number, etc.
                field.value = value || '';
            }
            
            console.log(`Filled ${key}:`, field.value);
        }
    });
}

// Show notification with enhanced styling
function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-pink-600';
    const icon = type === 'success' 
        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />';
    
    const alert = document.createElement('div');
    alert.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-2xl z-50 flex items-center gap-3 animate-slide-in transform hover:scale-105 transition-transform`;
    alert.innerHTML = `
        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${icon}
        </svg>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateX(100%)';
        setTimeout(() => alert.remove(), 300);
    }, 3000);
}

// Format date to Indonesian
function formatDateIndonesian(dateString) {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}

// Show preview with complete data
function showPreview() {
    const form = document.getElementById('dynamicForm');
    
    // Validate required fields
    if (!form.checkValidity()) {
        form.reportValidity();
        showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
        return;
    }
    
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('previewContent');
    
    modal.classList.remove('hidden');
    
    // Get form data
    const formData = new FormData(form);
    const previewData = {};
    
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('data_warga[')) {
            const fieldName = key.match(/data_warga\[(.*?)\]/)[1];
            previewData[fieldName] = value;
        }
    }
    
    // Merge with current form data (auto-filled data)
    const allData = { ...currentFormData, ...previewData };
    
    console.log('Preview data:', allData);
    
    // Generate preview HTML
    const nomorSurat = document.getElementById('nomor_surat').value;
    const tanggalSurat = document.getElementById('tanggal_surat').value;
    const perihal = document.getElementById('perihal').value;
    
    content.innerHTML = `
        <div class="bg-white p-8 rounded-lg shadow-sm max-w-3xl mx-auto border-2 border-gray-200" style="font-family: 'Times New Roman', serif;">
            <!-- Header -->
            <div class="text-center mb-6 border-b-4 border-gray-800 pb-4">
                <div class="flex items-center justify-center gap-4 mb-2">
                    ${allData.logo_desa ? `<img src="${allData.logo_desa}" alt="Logo" class="h-16 w-16 object-contain">` : ''}
                    <div>
                        <h3 class="text-lg font-bold uppercase">PEMERINTAH ${allData.kabupaten || ''}</h3>
                        <h4 class="text-base font-semibold">KECAMATAN ${allData.kecamatan || ''}</h4>
                        <h4 class="text-base font-semibold">${allData.nama_desa || 'DESA'}</h4>
                    </div>
                </div>
                <p class="text-sm mt-1">${allData.alamat_kantor || ''}</p>
                <p class="text-xs">Telp: ${allData.telp || allData.telepon_desa || '-'} | Email: ${allData.email_desa || '-'}</p>
            </div>
            
            <!-- Title -->
            <div class="text-center my-6">
                <h2 class="text-xl font-bold underline mb-2">${perihal.toUpperCase()}</h2>
                <p class="text-sm">Nomor: ${nomorSurat}</p>
            </div>
            
            <!-- Content -->
            <div class="text-justify mb-4 text-sm leading-relaxed">
                <p class="mb-4 indent-8">Yang bertanda tangan di bawah ini Kepala Desa ${allData.nama_desa || ''}, Kecamatan ${allData.kecamatan || ''}, Kabupaten ${allData.kabupaten || ''}, menerangkan bahwa:</p>
                
                <table class="w-full text-sm mb-4">
                    ${generatePreviewTable(allData, previewData)}
                </table>
                
                <p class="mb-4 indent-8">Adalah benar-benar warga Desa ${allData.nama_desa || ''} dan data yang tercantum di atas adalah benar sesuai dengan yang bersangkutan.</p>
                
                <p class="mb-8 indent-8">Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <!-- Signature -->
            <div class="flex justify-between mt-12">
                <div class="text-center invisible">
                    <p class="mb-16">Placeholder</p>
                    <p class="font-bold mt-16">Placeholder</p>
                </div>
                <div class="text-center">
                    <p class="mb-16">${allData.nama_desa || ''}, ${formatDateIndonesian(tanggalSurat)}</p>
                    <p class="mb-1">Kepala Desa ${allData.nama_desa || ''}</p>
                    <p class="font-bold mt-16 underline">${allData.kepala_desa || ''}</p>
                    ${allData.nip_kepala_desa ? `<p class="text-sm">NIP: ${allData.nip_kepala_desa}</p>` : ''}
                </div>
            </div>
        </div>
    `;
}

// Generate preview table based on template fields
function generatePreviewTable(allData, previewData) {
    let tableHTML = '';
    let counter = 1;
    
    // Combine data
    const combinedData = { ...allData, ...previewData };
    
    // Common fields to display
    const displayFields = [
        { key: 'nama', label: 'Nama Lengkap' },
        { key: 'nik', label: 'NIK / No KTP' },
        { key: 'tempat_lahir', label: 'Tempat Lahir' },
        { key: 'tanggal_lahir', label: 'Tanggal Lahir' },
        { key: 'jenis_kelamin', label: 'Jenis Kelamin' },
        { key: 'agama', label: 'Agama' },
        { key: 'status_kawin', label: 'Status Perkawinan' },
        { key: 'pekerjaan', label: 'Pekerjaan' },
        { key: 'pendidikan', label: 'Pendidikan' },
        { key: 'alamat', label: 'Alamat' },
        { key: 'kewarganegaraan', label: 'Kewarganegaraan' }
    ];
    
    // Add fields from template
    if (currentTemplateFields && Array.isArray(currentTemplateFields)) {
        currentTemplateFields.forEach(field => {
            if (combinedData[field.name] && !displayFields.find(f => f.key === field.name)) {
                displayFields.push({
                    key: field.name,
                    label: field.label || field.name
                });
            }
        });
    }
    
    // Generate table rows
    displayFields.forEach(field => {
        if (combinedData[field.key]) {
            let value = combinedData[field.key];
            
            // Format date if needed
            if (field.key.includes('tanggal') && value.includes('-')) {
                value = formatDateIndonesian(value);
            }
            
            tableHTML += `
                <tr>
                    <td class="py-1.5 align-top w-8">${counter}.</td>
                    <td class="py-1.5 align-top w-56">${field.label}</td>
                    <td class="py-1.5 align-top w-8">:</td>
                    <td class="py-1.5">${value}</td>
                </tr>
            `;
            counter++;
        }
    });
    
    return tableHTML || '<tr><td colspan="4" class="text-center py-4 text-gray-500">Data tidak tersedia</td></tr>';
}

function closePreview() {
    document.getElementById('previewModal').classList.add('hidden');
}

// Reset form with confirmation
function resetForm() {
    if (confirm('Yakin ingin mereset form? Semua data yang sudah diisi akan hilang.')) {
        // Hide form, show empty state
        document.getElementById('dynamicForm').classList.add('hidden');
        document.getElementById('emptyState').classList.remove('hidden');
        
        // Reset form
        document.getElementById('dynamicForm').reset();
        document.getElementById('searchNik').value = '';
        currentFormData = {};
        currentTemplateFields = [];
        
        // Update title
        document.getElementById('formTitle').textContent = 'Form Pengisian Surat';
        document.getElementById('formSubtitle').textContent = 'Pilih template di sebelah kiri untuk memulai';
        
        // Remove selection highlight
        document.querySelectorAll('.template-item').forEach(item => {
            item.classList.remove('border-emerald-500', 'bg-emerald-50', 'shadow-md');
            item.querySelector('.template-check').classList.add('hidden');
        });
        
        showNotification('Form berhasil direset', 'success');
    }
}

// Search template functionality
document.getElementById('searchTemplate')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.template-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        const name = item.getAttribute('data-template-name').toLowerCase();
        const jenis = item.getAttribute('data-template-jenis').toLowerCase();
        
        if (name.includes(searchTerm) || jenis.includes(searchTerm)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show message if no results
    const listContainer = document.getElementById('templateList');
    let noResultsMsg = document.getElementById('noResultsMessage');
    
    if (visibleCount === 0 && searchTerm) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.id = 'noResultsMessage';
            noResultsMsg.className = 'text-center py-8';
            noResultsMsg.innerHTML = `
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm text-gray-500">Tidak ada template yang cocok</p>
            `;
            listContainer.appendChild(noResultsMsg);
        }
    } else if (noResultsMsg) {
        noResultsMsg.remove();
    }
});

// Auto-hide alerts
setTimeout(() => {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    
    if (successAlert) {
        successAlert.style.opacity = '0';
        successAlert.style.transform = 'translateX(100%)';
        setTimeout(() => successAlert.remove(), 300);
    }
    
    if (errorAlert) {
        errorAlert.style.opacity = '0';
        errorAlert.style.transform = 'translateX(100%)';
        setTimeout(() => errorAlert.remove(), 300);
    }
}, 3000);

// Close preview on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePreview();
    }
});

// Add Enter key support for NIK search
document.getElementById('searchNik')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchPenduduk();
    }
});

// Form validation before submit
document.getElementById('dynamicForm')?.addEventListener('submit', function(e) {
    const templateId = document.getElementById('selectedTemplateId').value;
    
    if (!templateId) {
        e.preventDefault();
        showNotification('Silakan pilih template terlebih dahulu', 'error');
        return false;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            </span>
        `;
    }
});

console.log('Script loaded successfully');
</script>
@endpush

@endsection