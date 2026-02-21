@extends('layouts.admin')

@section('title', 'Detail Klasifikasi Surat')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1
                    class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                    Detail Klasifikasi Surat
                </h1>
                <p class="text-sm text-gray-500 mt-1">Informasi lengkap klasifikasi surat</p>
            </div>
            <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
                class="text-gray-600 hover:text-gray-800 transition-colors p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.sekretariat.klasifikasi-surat.edit', $klasifikasi->id) }}"
            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Klasifikasi
        </a>
        <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
            class="flex-1 bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-xl font-medium hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-lg font-bold rounded-lg">
                            {{ $klasifikasi->kode }}
                        </span>
                        @if($klasifikasi->status)
                        <span
                            class="inline-flex px-3 py-1 text-xs font-semibold bg-white/20 backdrop-blur-sm text-white rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Aktif
                        </span>
                        @else
                        <span
                            class="inline-flex px-3 py-1 text-xs font-semibold bg-white/20 backdrop-blur-sm text-white rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tidak Aktif
                        </span>
                        @endif
                    </div>
                    <h2 class="text-2xl font-bold text-white">{{ $klasifikasi->nama_klasifikasi }}</h2>
                </div>
                @php
                $categoryColors = [
                'administrasi' => 'bg-purple-100 text-purple-700',
                'kependudukan' => 'bg-blue-100 text-blue-700',
                'pembangunan' => 'bg-orange-100 text-orange-700',
                'keuangan' => 'bg-green-100 text-green-700',
                'kesehatan' => 'bg-red-100 text-red-700',
                'pendidikan' => 'bg-indigo-100 text-indigo-700',
                'pertanian' => 'bg-lime-100 text-lime-700',
                'lainnya' => 'bg-gray-100 text-gray-700',
                ];
                $colorClass = $categoryColors[$klasifikasi->kategori] ?? $categoryColors['lainnya'];
                @endphp
                <span class="inline-flex px-4 py-2 text-sm font-bold {{ $colorClass }} rounded-xl shadow-md">
                    {{ ucfirst($klasifikasi->kategori) }}
                </span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-8">

            <!-- Primary Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-600 mb-1">Retensi Aktif</p>
                            <p class="text-3xl font-bold text-blue-900">{{ $klasifikasi->retensi_aktif }}</p>
                            <p class="text-sm text-blue-700 mt-1">Tahun penyimpanan aktif</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-purple-600 mb-1">Retensi Inaktif</p>
                            <p class="text-3xl font-bold text-purple-900">{{ $klasifikasi->retensi_inaktif }}</p>
                            <p class="text-sm text-purple-700 mt-1">Tahun penyimpanan inaktif</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Keterangan -->
            @if($klasifikasi->keterangan)
            <div class="mb-8">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Keterangan</p>
                            <p class="text-gray-900 leading-relaxed">{{ $klasifikasi->keterangan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Metadata -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi Sistem
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Dibuat</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $klasifikasi->created_at->format('d M
                                    Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $klasifikasi->created_at->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">Terakhir Diubah</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $klasifikasi->updated_at->format('d M
                                    Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $klasifikasi->updated_at->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">ID Klasifikasi</p>
                                <p class="text-sm font-semibold text-gray-900">#{{ str_pad($klasifikasi->id, 5, '0',
                                    STR_PAD_LEFT) }}</p>
                                <p class="text-xs text-gray-500">Database ID</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- Action Buttons -->
    <div class="flex items-center justify-between gap-3">
        <form method="POST" action="{{ route('admin.sekretariat.klasifikasi-surat.destroy', $klasifikasi->id) }}"
            class="inline"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus klasifikasi surat ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus Klasifikasi
            </button>
        </form>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.sekretariat.klasifikasi-surat') }}"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
            <a href="{{ route('admin.sekretariat.klasifikasi-surat.edit', $klasifikasi->id) }}"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Klasifikasi
            </a>
        </div>
    </div>

</div>
@endsection