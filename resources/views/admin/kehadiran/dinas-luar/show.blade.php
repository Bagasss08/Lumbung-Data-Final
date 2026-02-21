@extends('layouts.admin')

@section('title', 'Detail Dinas Luar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-500">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-5">
                        <div class="relative group">
                            <div
                                class="absolute inset-0 bg-white/30 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-300">
                            </div>
                            <div
                                class="relative w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Detail Dinas Luar</h1>
                            <p class="text-teal-100 text-sm font-medium">Informasi lengkap kegiatan dinas luar</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.dinas-luar.index') }}"
                        class="group inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-5 py-3 rounded-xl font-semibold border border-white/30 shadow-lg hover:bg-white/30 transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Content -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="p-8">
                <!-- Data Pegawai Section -->
                <div class="mb-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Data Pegawai</h3>
                            <p class="text-sm text-slate-600 font-medium">Informasi pegawai yang melaksanakan dinas luar
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pegawai Info -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pegawai</label>
                            <div class="flex items-center gap-4 p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <div class="relative group/avatar">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl blur opacity-50 group-hover/avatar:opacity-75 transition-opacity">
                                    </div>
                                    <div
                                        class="relative w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ strtoupper(substr($dinasLuar->pegawai->nama_lengkap ?? 'N', 0, 2)) }}
                                    </div>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-900">{{ $dinasLuar->pegawai->nama_lengkap ??
                                        'N/A' }}</p>
                                    <p class="text-sm text-slate-600">{{ $dinasLuar->pegawai->jabatan ?? 'N/A' }} - {{
                                        $dinasLuar->pegawai->unit_kerja ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Kegiatan Section -->
                <div class="mb-10 pt-10 border-t-2 border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Data Kegiatan</h3>
                            <p class="text-sm text-slate-600 font-medium">Informasi detail kegiatan dinas luar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Kegiatan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kegiatan</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base font-semibold text-slate-900">{{ $dinasLuar->nama_kegiatan }}</p>
                            </div>
                        </div>

                        <!-- Lokasi Kegiatan -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi Kegiatan</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base font-semibold text-slate-900">{{ $dinasLuar->lokasi_kegiatan }}</p>
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base font-semibold text-slate-900">{{
                                    \Carbon\Carbon::parse($dinasLuar->tanggal_selesai)->format('d F Y') }}</p>
                            </div>
                        </div>

                        <!-- Instansi Tujuan -->
                        @if($dinasLuar->instasi_tujuan)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Instansi Tujuan</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base font-semibold text-slate-900">{{ $dinasLuar->instasi_tujuan }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Surat Tugas -->
                        @if($dinasLuar->surat_tugas)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Surat Tugas</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base font-semibold text-slate-900">{{ $dinasLuar->surat_tugas }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Keterangan -->
                        @if($dinasLuar->keterangan)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan</label>
                            <div class="p-4 bg-slate-50 border-2 border-slate-200 rounded-xl">
                                <p class="text-base text-slate-900 leading-relaxed">{{ $dinasLuar->keterangan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 pt-8 border-t-2 border-slate-100">
                    <a href="{{ route('admin.dinas-luar.edit', $dinasLuar->id) }}"
                        class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-amber-600 to-orange-700 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="relative">Edit Dinas Luar</span>
                    </a>
                    <form action="{{ route('admin.dinas-luar.destroy', $dinasLuar->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="group relative inline-flex items-center gap-2 bg-gradient-to-r from-rose-600 to-red-600 text-white px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden"
                            onclick="return confirm('Yakin ingin menghapus dinas luar ini?')">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-rose-700 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <svg class="relative w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span class="relative">Hapus Dinas Luar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection
