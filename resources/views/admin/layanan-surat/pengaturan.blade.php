@extends('layouts.admin')

@section('title', 'Pengaturan Surat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 mb-2">Template Surat</h1>
                    <p class="text-slate-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Kelola template surat dalam format Word atau PDF
                    </p>
                </div>

                <button onclick="openModal()" 
                    class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-sm font-medium rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Template
                </button>
            </div>
        </div>

        <!-- ALERT -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-xl shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Daftar Template</h3>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-slate-200">
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[25%]">Nama Template</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[20%]">Jenis Surat</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[10%]">Versi</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[15%]">File</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[12%]">Tanggal Berlaku</th>
                                <th class="py-4 px-6 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-[10%]">Status</th>
                                <th class="py-4 px-6 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider w-[8%]">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($templates as $t)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">

                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-md flex-shrink-0">
                                                {{ strtoupper(substr($t->nama_template, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-slate-800 truncate">{{ $t->nama_template }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">ID: {{ $t->id }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-5 px-6">
                                        @if($t->jenisSurat)
                                            <div class="inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-purple-50 to-purple-100 text-purple-700 rounded-lg border border-purple-200">
                                                <span class="font-mono text-xs font-bold">{{ $t->jenisSurat->kode }}</span>
                                                <span class="text-xs">-</span>
                                                <span class="text-xs font-medium">{{ Str::limit($t->jenisSurat->nama, 15) }}</span>
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="py-5 px-6">
                                        <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-xs font-bold shadow-sm">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            v{{ $t->versi_template }}
                                        </span>
                                    </td>

                                    <td class="py-5 px-6">
                                        @if($t->file_template)
                                            <a href="{{ Storage::url($t->file_template) }}" 
                                               target="_blank"
                                               class="inline-flex items-center gap-2 px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded-lg hover:from-blue-100 hover:to-indigo-100 transition-all duration-200 group border border-blue-200">
                                                <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span class="text-xs font-medium truncate max-w-[120px]">{{ basename($t->file_template) }}</span>
                                            </a>
                                        @else
                                            <span class="text-slate-400 text-xs italic">Tidak ada file</span>
                                        @endif
                                    </td>

                                    <td class="py-5 px-6">
                                        @if($t->tanggal_berlaku)
                                            <div class="flex items-center gap-2 text-slate-600">
                                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-sm font-medium">{{ $t->tanggal_berlaku->format('d/m/Y') }}</span>
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="py-5 px-6">
                                        @if($t->is_active)
                                            <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full text-xs font-bold shadow-sm">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Aktif
                                                
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-full text-xs font-bold shadow-sm">
                                                <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-5 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick='openEditModal(@json($t))'
                                                class="inline-flex items-center p-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-200 group"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form method="POST"
                                                action="{{ route('admin.layanan-surat.template.destroy', $t->id) }}"
                                                onsubmit="return confirm('Yakin hapus template ini?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="inline-flex items-center p-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors duration-200 group"
                                                    title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 text-lg font-medium mb-2">Belum ada template surat</p>
                                            <p class="text-slate-400 text-sm">Klik tombol "Tambah Template" untuk membuat template pertama</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- MODAL TAMBAH -->
<div id="modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header - Fixed -->
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Tambah Template Surat</h3>
                            <p class="text-emerald-100 text-sm mt-0.5">Buat template surat baru untuk sistem</p>
                        </div>
                    </div>
                    <button onclick="closeModal()" type="button" class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="overflow-y-auto flex-1">
                <form method="POST" action="{{ route('admin.layanan-surat.template.store') }}" enctype="multipart/form-data" class="px-8 py-6">
                    @csrf

                    <div class="space-y-6">

                        <!-- Jenis Surat -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Jenis Surat
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="jenis_surat_id" required
                                    class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all appearance-none text-slate-700 font-medium">
                                    <option value="">Pilih Jenis Surat</option>
@foreach($jenisSurat ?? [] as $js)
    <option value="{{ $js->id }}">{{ $js->kode }} - {{ $js->nama }}</option>
@endforeach

<option value="">Pilih Jenis Surat</option>
@foreach($jenisSurat ?? [] as $js)
    <option value="{{ $js->id }}">{{ $js->nama_jenis_surat }}</option>
@endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pilih kategori jenis surat sesuai kebutuhan
                            </p>
                        </div>

                        <!-- Nama Template -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                Nama Template
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_template" required
                                placeholder="Contoh: Template Surat Keterangan Usaha"
                                class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-400 text-slate-700 font-medium">
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Berikan nama yang deskriptif dan mudah dikenali
                            </p>
                        </div>

                        <!-- Versi Template -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Versi Template
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="versi_template" value="1.0" required
                                placeholder="1.0"
                                class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all placeholder:text-slate-400 text-slate-700 font-medium">
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Format: Mayor.Minor (contoh: 1.0, 1.1, 2.0)
                            </p>
                        </div>

                        <!-- File Template -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                File Template (Word/PDF)
                            </label>
                            <div class="relative border-2 border-dashed border-slate-300 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-6 hover:border-emerald-500 hover:bg-emerald-50/50 transition-all cursor-pointer">
                                <input type="file" name="file_template" 
                                    accept=".doc,.docx,.pdf"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="updateFileName(this)">
                                <div class="flex flex-col items-center justify-center gap-3 pointer-events-none">
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-2xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-slate-700 font-semibold mb-1">Klik untuk memilih file</p>
                                        <p class="text-xs text-slate-500">atau seret dan lepas file di sini</p>
                                    </div>
                                    <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-xs font-medium text-slate-600">.DOC, .DOCX, .PDF</span>
                                        <span class="text-xs text-slate-400">• Max 5MB</span>
                                    </div>
                                </div>
                            </div>
                            <div id="file-name-display" class="mt-3 hidden">
                                <div class="flex items-center gap-3 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-emerald-700" id="selected-file-name"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Berlaku -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Tanggal Berlaku
                            </label>
                            <input type="date" name="tanggal_berlaku" 
                                class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-slate-700 font-medium">
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tentukan kapan template ini mulai berlaku
                            </p>
                        </div>

                        <!-- Status Aktif -->
                        <div>
                            <div class="flex items-center justify-between p-5 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl border-2 border-emerald-200 hover:border-emerald-300 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">Status Template</p>
                                        <p class="text-xs text-slate-600 mt-0.5">Aktifkan template agar dapat digunakan</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                    <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500"></div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
                        <button type="button" onclick="closeModal()" 
                            class="px-6 py-3 text-slate-600 font-semibold hover:bg-slate-100 rounded-xl transition-all duration-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </div>
                        </button>
                        <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Template
                            </div>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<!-- MODAL EDIT -->
<div id="modalEdit" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            
            <!-- Modal Header - Fixed -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Edit Template Surat</h3>
                            <p class="text-blue-100 text-sm mt-0.5">Perbarui informasi template surat</p>
                        </div>
                    </div>
                    <button onclick="closeEditModal()" type="button" class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="overflow-y-auto flex-1">
                <form id="formEdit"
      method="POST"
      action="{{ route('admin.layanan-surat.template.update', $template->id ?? 0) }}"
      enctype="multipart/form-data"
      class="px-8 py-6">

    @csrf
    @method('PUT')

    <div class="space-y-6">

        <!-- Jenis Surat -->
        <div>
            <label class="flex items-center gap-2 text-sm font-bold text-slate-700 mb-3">
                Jenis Surat
                <span class="text-red-500">*</span>
            </label>

            <div class="relative">
                <select name="jenis_surat_id" required>
                    <option value="">-- Pilih Jenis Surat --</option>
@foreach($jenisSurat as $js)
    <option value="{{ $js->id }}"
        {{ isset($template) && $template->jenis_surat_id == $js->id ? 'selected' : '' }}>
        {{ $js->kode }} - {{ $js->nama }}
    </option>
@endforeach

<option value="">-- Pilih Jenis Surat --</option>
@foreach($jenisSurat as $js)
    <option value="{{ $js->id }}"
        {{ isset($template) && $template->jenis_surat_id == $js->id ? 'selected' : '' }}>
        {{ $js->nama_jenis_surat }}
    </option>
@endforeach
                </select>
            </div>
        </div>

        <!-- Nama Template -->
        <div>
            <label class="text-sm font-bold text-slate-700 mb-3">
                Nama Template
                <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="nama_template"
                   value="{{ $template->nama_template ?? '' }}"
                   required
                   class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl">
        </div>

        <!-- Versi Template -->
        <div>
            <label class="text-sm font-bold text-slate-700 mb-3">
                Versi Template
                <span class="text-red-500">*</span>
            </label>

            <input type="text"
                   name="versi_template"
                   value="{{ $template->versi_template ?? '' }}"
                   required
                   class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl">
        </div>

        <!-- File Template -->
        <div>
            <label class="text-sm font-bold text-slate-700 mb-3">
                File Template Baru (Opsional)
            </label>

            <div class="relative border-2 border-dashed border-slate-300 rounded-xl bg-gradient-to-br from-slate-50 to-slate-100 p-6">
                <input type="file"
                       name="file_template"
                       accept=".doc,.docx,.pdf"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
            </div>
        </div>

        <!-- Tanggal Berlaku -->
        <div>
            <label class="text-sm font-bold text-slate-700 mb-3">
                Tanggal Berlaku
            </label>

            <input type="date"
                   name="tanggal_berlaku"
                   value="{{ $template->tanggal_berlaku ?? '' }}"
                   class="w-full bg-gradient-to-br from-slate-50 to-slate-100 border-2 border-slate-300 px-4 py-3.5 rounded-xl">
        </div>

        <!-- Status Aktif -->
        <div>
            <div class="flex items-center justify-between p-5 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-2 border-blue-200">
                <div>
                    <p class="text-sm font-bold text-slate-800">Status Template</p>
                </div>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ isset($template) && $template->is_active ? 'checked' : '' }}
                           class="sr-only peer">

                    <div class="w-14 h-7 bg-slate-300 rounded-full peer-checked:bg-blue-500"></div>
                </label>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-200">

        <button type="button"
                onclick="closeEditModal()"
                class="px-6 py-3 text-slate-600 font-semibold hover:bg-slate-100 rounded-xl">
            Batal
        </button>

        <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl">
            Update Template
        </button>

    </div>

</form>

            </div>

        </div>
    </div>
</div>


<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset form
    document.getElementById('file-name-display').classList.add('hidden');
}

function openEditModal(template) {
    document.getElementById('modalEdit').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    document.getElementById('formEdit').action = `/admin/layanan-surat/template/${template.id}`;
    document.getElementById('edit_jenis_surat_id').value = template.jenis_surat_id;
    document.getElementById('edit_nama_template').value = template.nama_template;
    document.getElementById('edit_versi_template').value = template.versi_template;
    document.getElementById('edit_tanggal_berlaku').value = template.tanggal_berlaku;
    document.getElementById('edit_is_active').checked = template.is_active;
    
    if (template.file_template) {
        const currentFileDiv = document.getElementById('current_file');
        const currentFileName = document.getElementById('current_file_name');
        currentFileDiv.classList.remove('hidden');
        currentFileName.textContent = 'File saat ini: ' + template.file_template.split('/').pop();
    }
}

function closeEditModal() {
    document.getElementById('modalEdit').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Reset file displays
    document.getElementById('current_file').classList.add('hidden');
    document.getElementById('edit-file-name-display').classList.add('hidden');
}

function updateFileName(input) {
    const fileDisplay = document.getElementById('file-name-display');
    const fileName = document.getElementById('selected-file-name');
    
    if (input.files && input.files[0]) {
        fileDisplay.classList.remove('hidden');
        fileName.textContent = input.files[0].name;
    } else {
        fileDisplay.classList.add('hidden');
    }
}

function updateEditFileName(input) {
    const fileDisplay = document.getElementById('edit-file-name-display');
    const fileName = document.getElementById('edit-selected-file-name');
    
    if (input.files && input.files[0]) {
        fileDisplay.classList.remove('hidden');
        fileName.textContent = 'File baru: ' + input.files[0].name;
    } else {
        fileDisplay.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.getElementById('modalEdit').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Escape key to close modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeEditModal();
    }
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Custom scrollbar untuk modal */
#modal > div > div:last-child,
#modalEdit > div > div:last-child {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

#modal > div > div:last-child::-webkit-scrollbar,
#modalEdit > div > div:last-child::-webkit-scrollbar {
    width: 8px;
}

#modal > div > div:last-child::-webkit-scrollbar-track,
#modalEdit > div > div:last-child::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

#modal > div > div:last-child::-webkit-scrollbar-thumb,
#modalEdit > div > div:last-child::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

#modal > div > div:last-child::-webkit-scrollbar-thumb:hover,
#modalEdit > div > div:last-child::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

@endsection