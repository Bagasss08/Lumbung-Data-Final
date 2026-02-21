@extends('layouts.admin')

@section('title', 'Detail Kehadiran Harian')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-emerald-50 p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            <div class="relative px-8 py-8 bg-gradient-to-br from-emerald-600 via-teal-600 to-teal-500">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]">
                </div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 via-transparent to-transparent"></div>

                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
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
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Detail Kehadiran Harian</h1>
                            <p class="text-teal-100 text-sm font-medium">Informasi lengkap kehadiran pegawai</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.kehadiran-harian.edit', $kehadiranHarian) }}"
                            class="group relative inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white border border-white/30 px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                        </a>
                        <a href="{{ route('admin.kehadiran-harian.index') }}"
                            class="group relative inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white border border-white/30 px-6 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Detail Section -->
            <div class="px-8 py-8 space-y-8">
                <!-- Pegawai Information -->
                <div class="bg-gradient-to-br from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        Informasi Pegawai
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ strtoupper(substr($kehadiranHarian->pegawai->nama_lengkap, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">{{ $kehadiranHarian->pegawai->nama_lengkap }}</h4>
                                    <p class="text-sm text-slate-600">{{ $kehadiranHarian->pegawai->jabatan }}</p>
                                    <p class="text-xs text-slate-500">NIK: {{ $kehadiranHarian->pegawai->nik }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <span class="text-sm font-medium text-slate-600">Status Kepegawaian</span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                    {{ ucfirst($kehadiranHarian->pegawai->status_kepegawaian) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-slate-100">
                                <span class="text-sm font-medium text-slate-600">Unit Kerja</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $kehadiranHarian->pegawai->unit_kerja ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-slate-600">Status Aktif</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold {{ $kehadiranHarian->pegawai->status_aktif == 'aktif' ? 'bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50' : 'bg-gradient-to-r from-slate-100 to-gray-100 text-slate-700 border border-slate-200/50' }} shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ ucfirst($kehadiranHarian->pegawai->status_aktif) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kehadiran Information -->
                <div class="bg-gradient-to-br from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        Detail Kehadiran
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Tanggal</span>
                                    <span class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($kehadiranHarian->tanggal)->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Hari</span>
                                    <span class="text-sm font-bold text-slate-900">{{ $kehadiranHarian->hari }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Jenis Kehadiran</span>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-100 to-teal-100 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                        {{ $kehadiranHarian->jenisKehadiran->nama_kehadiran }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Metode Absen</span>
                                    <span class="text-sm font-bold text-slate-900">{{ ucfirst($kehadiranHarian->metode_absen) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Jam Masuk</span>
                                    <span class="text-sm font-bold text-slate-900">{{ $kehadiranHarian->jam_masuk ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Jam Pulang</span>
                                    <span class="text-sm font-bold text-slate-900">{{ $kehadiranHarian->jam_pulang ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-slate-100">
                                    <span class="text-sm font-medium text-slate-600">Lokasi Absen</span>
                                    <span class="text-sm font-bold text-slate-900">{{ $kehadiranHarian->lokasi_absen ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-sm font-medium text-slate-600">Dibuat</span>
                                    <span class="text-sm font-bold text-slate-900">{{ $kehadiranHarian->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    @if($kehadiranHarian->keterangan)
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <h4 class="text-sm font-bold text-slate-700 mb-3">Keterangan</h4>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/50">
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $kehadiranHarian->keterangan }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.kehadiran-harian.edit', $kehadiranHarian) }}"
                        class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105 text-center">
                        Edit Kehadiran
                    </a>
                    <form action="{{ route('admin.kehadiran-harian.destroy', $kehadiranHarian) }}" method="POST"
                        class="inline" onsubmit="return confirm('Yakin ingin menghapus data kehadiran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-rose-600 to-red-600 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                            Hapus Kehadiran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(255 255 255 / 0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }
</style>
@endsection

