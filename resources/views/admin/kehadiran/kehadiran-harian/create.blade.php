@extends('layouts.admin')

@section('title', 'Tambah Kehadiran Harian')

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
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-1.5 tracking-tight">Tambah Kehadiran Harian</h1>
                            <p class="text-teal-100 text-sm font-medium">Catat kehadiran pegawai untuk hari ini</p>
                        </div>
                    </div>
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

            <!-- Form Section -->
            <div class="px-8 py-8">
                <form action="{{ route('admin.kehadiran-harian.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Basic Information -->
                    <div class="bg-gradient-to-br from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/60">
                        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Informasi Kehadiran
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pegawai -->
                            <div class="space-y-2">
                                <label for="id_pegawai" class="block text-sm font-bold text-slate-700">Pegawai <span class="text-red-500">*</span></label>
                                <select id="id_pegawai" name="id_pegawai"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md"
                                    required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }} - {{ $p->jabatan }}</option>
                                    @endforeach
                                </select>
                                @error('id_pegawai')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kehadiran -->
                            <div class="space-y-2">
                                <label for="id_jenis_kehadiran" class="block text-sm font-bold text-slate-700">Jenis Kehadiran <span class="text-red-500">*</span></label>
                                <select id="id_jenis_kehadiran" name="id_jenis_kehadiran"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md"
                                    required>
                                    <option value="">Pilih Jenis Kehadiran</option>
                                    @foreach($jenisKehadiran as $jk)
                                    <option value="{{ $jk->id }}">{{ $jk->nama_kehadiran }}</option>
                                    @endforeach
                                </select>
                                @error('id_jenis_kehadiran')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal -->
                            <div class="space-y-2">
                                <label for="tanggal" class="block text-sm font-bold text-slate-700">Tanggal <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md"
                                    required>
                                @error('tanggal')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hari -->
                            <div class="space-y-2">
                                <label for="hari" class="block text-sm font-bold text-slate-700">Hari <span class="text-red-500">*</span></label>
                                <input type="text" id="hari" name="hari" value="{{ \Carbon\Carbon::now()->translatedFormat('l') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md"
                                    required readonly>
                                @error('hari')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="bg-gradient-to-br from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/60">
                        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Waktu Kehadiran
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jam Masuk -->
                            <div class="space-y-2">
                                <label for="jam_masuk" class="block text-sm font-bold text-slate-700">Jam Masuk</label>
                                <input type="time" id="jam_masuk" name="jam_masuk"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                @error('jam_masuk')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jam Pulang -->
                            <div class="space-y-2">
                                <label for="jam_pulang" class="block text-sm font-bold text-slate-700">Jam Pulang</label>
                                <input type="time" id="jam_pulang" name="jam_pulang"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                @error('jam_pulang')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="bg-gradient-to-br from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/60">
                        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Informasi Tambahan
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Metode Absen -->
                            <div class="space-y-2">
                                <label for="metode_absen" class="block text-sm font-bold text-slate-700">Metode Absen <span class="text-red-500">*</span></label>
                                <select id="metode_absen" name="metode_absen"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md"
                                    required>
                                    <option value="">Pilih Metode</option>
                                    <option value="manual">Manual</option>
                                    <option value="fingerprint">Fingerprint</option>
                                    <option value="qr">QR Code</option>
                                </select>
                                @error('metode_absen')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Absen -->
                            <div class="space-y-2">
                                <label for="lokasi_absen" class="block text-sm font-bold text-slate-700">Lokasi Absen</label>
                                <input type="text" id="lokasi_absen" name="lokasi_absen" placeholder="Masukkan lokasi absen"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                @error('lokasi_absen')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mt-6 space-y-2">
                            <label for="keterangan" class="block text-sm font-bold text-slate-700">Keterangan</label>
                            <textarea id="keterangan" name="keterangan" rows="4" placeholder="Masukkan keterangan jika ada"
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white/50 backdrop-blur-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md resize-none"></textarea>
                            @error('keterangan')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-slate-200">
                        <a href="{{ route('admin.kehadiran-harian.index') }}"
                            class="px-8 py-3.5 rounded-xl border border-slate-300 bg-white text-slate-700 font-semibold shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105 text-center">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                            Simpan Kehadiran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-fill hari based on tanggal
document.getElementById('tanggal').addEventListener('change', function() {
    const date = new Date(this.value);
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    document.getElementById('hari').value = days[date.getDay()];
});
</script>

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

