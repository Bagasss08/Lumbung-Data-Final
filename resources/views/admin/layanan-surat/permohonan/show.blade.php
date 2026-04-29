@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.layanan-surat.permohonan.index') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 transition font-medium text-sm mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Permohonan
                </a>
                <h1 class="text-2xl font-extrabold text-slate-800">Detail Permohonan Surat</h1>
            </div>

            @php
                $bg = 'bg-slate-100'; $text = 'text-slate-700';
                if($permohonan->status == 'belum lengkap') { $bg = 'bg-red-100'; $text = 'text-red-700'; }
                elseif($permohonan->status == 'sedang diperiksa') { $bg = 'bg-yellow-100'; $text = 'text-yellow-700'; }
                elseif($permohonan->status == 'menunggu tandatangan') { $bg = 'bg-blue-100'; $text = 'text-blue-700'; }
                elseif($permohonan->status == 'siap diambil') { $bg = 'bg-emerald-100'; $text = 'text-emerald-700'; }
                elseif($permohonan->status == 'sudah diambil') { $bg = 'bg-green-100'; $text = 'text-green-700'; }
                elseif($permohonan->status == 'dibatalkan') { $bg = 'bg-rose-100'; $text = 'text-rose-700'; }

                // {{-- Tentukan apakah status sudah final (terkunci) --}}
                $isFinal = in_array($permohonan->status, ['sudah diambil', 'dibatalkan']);
            @endphp
            <div class="px-4 py-2 {{ $bg }} {{ $text }} rounded-xl text-sm font-bold uppercase tracking-wider border border-white/20 shadow-sm">
                Status: {{ $permohonan->status }}
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm flex justify-between items-center">
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-700 font-bold">&times;</button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <h3 class="font-bold text-slate-800 text-lg">Informasi Surat & Pemohon</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Jenis Surat Diajukan</p>
                            <p class="text-base font-bold text-emerald-700">
                                {{ $permohonan->suratTemplate->judul ?? $permohonan->suratTemplate->nama_template ?? 'Lainnya' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Waktu Pengajuan</p>
                            <p class="text-base font-medium text-slate-800">
                                {{ \Carbon\Carbon::parse($permohonan->created_at)->translatedFormat('l, d F Y') }}
                                <span class="text-slate-400 ml-1">({{ \Carbon\Carbon::parse($permohonan->created_at)->format('H:i') }} WIB)</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Pemohon</p>
                            <p class="text-base font-medium text-slate-800">{{ $permohonan->penduduk->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nomor Induk Kependudukan (NIK)</p>
                            <p class="text-base font-medium text-slate-800">{{ $permohonan->penduduk->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nomor HP/WhatsApp</p>
                            <p class="text-base font-medium text-slate-800">{{ $permohonan->penduduk->no_telp ?? 'Tidak dicantumkan' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Keperluan / Keterangan</p>
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-slate-700 mt-1">
                                {{ $permohonan->keperluan }}
                            </div>
                        </div>
                    </div>
                </div>

                @if($permohonan->dokumen_pendukung)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <h3 class="font-bold text-slate-800 text-lg">Dokumen Pendukung (Lampiran)</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-100 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-200 text-blue-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700">Lampiran Warga</p>
                                    <p class="text-xs text-slate-500">Klik tombol di samping untuk melihat atau mengunduh</p>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $permohonan->dokumen_pendukung) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
                                Lihat Dokumen
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @if($permohonan->data_isian && is_array($permohonan->data_isian))
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <h3 class="font-bold text-slate-800 text-lg">Data Isian Tambahan</h3>
                    </div>
                    <div class="p-6">
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-slate-100 border-t border-slate-100">
                                @foreach($permohonan->data_isian as $key => $value)
                                    <tr class="hover:bg-slate-50 transition">
                                        <th class="py-3 px-4 font-semibold text-slate-600 w-1/3">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                        <td class="py-3 px-4 text-slate-800">
                                            @if(is_array($value))
                                                <ul class="space-y-2">
                                                    @foreach($value as $subKey => $subValue)
                                                        <li>
                                                            @if(is_string($subKey))
                                                                <span class="font-semibold">{{ ucwords(str_replace('_', ' ', $subKey)) }}:</span>
                                                            @endif
                                                            @if(is_string($subValue) && preg_match('/\.(jpg|jpeg|png|pdf)$/i', $subValue))
                                                                <a href="{{ asset('storage/' . $subValue) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($subValue) }}</a>
                                                            @else
                                                                {{ $subValue }}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @elseif(is_string($value) && preg_match('/\.(jpg|jpeg|png|pdf)$/i', $value))
                                                <a href="{{ asset('storage/' . $value) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($value) }}</a>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>

            {{-- ===== SIDEBAR: Tindak Lanjut ===== --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md border-t-4 {{ $isFinal ? 'border-t-slate-400' : 'border-t-emerald-500' }} overflow-hidden sticky top-6">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between gap-2">
                        <h3 class="font-bold text-slate-800 text-lg">Tindak Lanjut & Status</h3>
                        @if($isFinal)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Terkunci
                            </span>
                        @endif
                    </div>

                    <div class="p-6">

                        {{-- ===== KONDISI: STATUS FINAL — TAMPILKAN RINGKASAN SAJA ===== --}}
                        @if($isFinal)
                            <div class="mb-5">
                                @if($permohonan->status == 'sudah diambil')
                                    <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                                        <div class="mt-0.5 flex-shrink-0 w-8 h-8 bg-green-200 text-green-700 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-green-800 text-sm">Permohonan Selesai</p>
                                            <p class="text-green-700 text-xs mt-1">Surat telah diambil oleh warga. Status ini tidak dapat diubah kembali.</p>
                                        </div>
                                    </div>
                                @elseif($permohonan->status == 'dibatalkan')
                                    <div class="flex items-start gap-3 p-4 bg-rose-50 border border-rose-200 rounded-xl">
                                        <div class="mt-0.5 flex-shrink-0 w-8 h-8 bg-rose-200 text-rose-700 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-rose-800 text-sm">Permohonan Dibatalkan</p>
                                            <p class="text-rose-700 text-xs mt-1">Permohonan ini telah dibatalkan dan tidak dapat diproses kembali.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Tampilkan catatan petugas jika ada --}}
                            @if($permohonan->catatan_petugas)
                                <div class="mb-4">
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Catatan Petugas</p>
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 text-sm leading-relaxed">
                                        {{ $permohonan->catatan_petugas }}
                                    </div>
                                </div>
                            @endif

                            <p class="text-xs text-slate-400 text-center mt-4 flex items-center justify-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Status akhir tidak dapat diubah
                            </p>

                        {{-- ===== KONDISI: STATUS BELUM FINAL — TAMPILKAN FORM ===== --}}
                        @else
                            <form action="{{ route('admin.layanan-surat.permohonan.update-status', $permohonan->id) }}" method="POST" id="form-update-status">
                                @csrf
                                @method('PUT')

                                <div class="mb-5">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ubah Status</label>
                                    <div class="relative">
                                        <select name="status" id="select-status" onchange="handleStatusChange(this.value)" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none appearance-none font-medium text-slate-700">
                                            <option value="belum lengkap" {{ $permohonan->status == 'belum lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                                            <option value="sedang diperiksa" {{ $permohonan->status == 'sedang diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                                            <option value="menunggu tandatangan" {{ $permohonan->status == 'menunggu tandatangan' ? 'selected' : '' }}>Menunggu Tandatangan</option>
                                            <option value="siap diambil" {{ $permohonan->status == 'siap diambil' ? 'selected' : '' }}>Siap Diambil</option>
                                            <option value="sudah diambil" {{ $permohonan->status == 'sudah diambil' ? 'selected' : '' }}>✓ Sudah Diambil / Selesai</option>
                                            <option value="dibatalkan" {{ $permohonan->status == 'dibatalkan' ? 'selected' : '' }}>✕ Dibatalkan</option>
                                        </select>

                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Peringatan khusus saat pilih "dibatalkan" --}}
                                <div id="warning-dibatalkan" class="mb-4 hidden">
                                    <div class="flex items-start gap-2 p-3 bg-rose-50 border border-rose-200 rounded-xl">
                                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <p class="text-xs text-rose-700 font-medium">Pembatalan bersifat <strong>permanen</strong>. Wajib isi catatan alasan pembatalan di bawah agar warga mengetahui penyebabnya.</p>
                                    </div>
                                </div>

                                {{-- Peringatan khusus saat pilih "sudah diambil" --}}
                                <div id="warning-selesai" class="mb-4 hidden">
                                    <div class="flex items-start gap-2 p-3 bg-green-50 border border-green-200 rounded-xl">
                                        <svg class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-xs text-green-700 font-medium">Status <strong>Sudah Diambil</strong> bersifat <strong>permanen</strong>. Setelah disimpan, status tidak dapat diubah kembali.</p>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2" id="label-catatan">
                                        Catatan Petugas
                                        <span id="catatan-required-badge" class="hidden ml-1 text-xs font-bold text-rose-600">* Wajib diisi</span>
                                        <span class="text-slate-400 font-normal text-xs ml-1">(Tampil ke Warga)</span>
                                    </label>
                                    <textarea
                                        name="catatan_petugas"
                                        id="catatan_petugas"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition outline-none text-sm"
                                        rows="4"
                                        placeholder="Contoh: Berkas KTP kurang jelas, mohon upload ulang...">{{ old('catatan_petugas', $permohonan->catatan_petugas) }}</textarea>
                                    <p class="text-xs text-slate-500 mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Warga dapat melihat catatan ini di akun mereka.
                                    </p>
                                </div>

                                <button type="submit" id="btn-submit" class="w-full px-4 py-3 bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 hover:shadow-emerald-600/40 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Simpan Perubahan
                                </button>

                                {{-- Modifikasi Link Cetak: Mengirim ID Permohonan agar bisa auto-fill --}}
                                @if(in_array($permohonan->status, ['menunggu tandatangan', 'siap diambil']))
                                    <div class="mt-6 pt-6 border-t border-slate-200">
                                        <p class="text-sm text-slate-600 text-center mb-3">Lanjutkan proses pembuatan surat?</p>
                                        <a href="{{ route('admin.layanan-surat.letters.create', ['permohonan_id' => $permohonan->id]) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-300 text-slate-700 rounded-xl font-bold hover:border-emerald-500 hover:text-emerald-700 transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Proses Cetak Surat
                                        </a>
                                    </div>
                                @endif

                            </form>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function handleStatusChange(value) {
    const warningBatal = document.getElementById('warning-dibatalkan');
    const warningSelesai = document.getElementById('warning-selesai');
    const badgeRequired = document.getElementById('catatan-required-badge');
    const textarea = document.getElementById('catatan_petugas');

    // Sembunyikan semua warning dulu
    warningBatal.classList.add('hidden');
    warningSelesai.classList.add('hidden');
    badgeRequired.classList.add('hidden');
    textarea.removeAttribute('required');

    if (value === 'dibatalkan') {
        warningBatal.classList.remove('hidden');
        badgeRequired.classList.remove('hidden');
        textarea.setAttribute('required', 'required');
        textarea.placeholder = 'Wajib: Tuliskan alasan pembatalan permohonan ini...';
    } else if (value === 'sudah diambil') {
        warningSelesai.classList.remove('hidden');
        textarea.placeholder = 'Contoh: Surat telah diambil oleh pemohon...';
    } else {
        textarea.placeholder = 'Contoh: Berkas KTP kurang jelas, mohon upload ulang...';
    }
}

// Jalankan saat halaman load untuk sinkronisasi tampilan awal
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('select-status');
    if (select) {
        handleStatusChange(select.value);
    }

    // Konfirmasi sebelum simpan status final
    const form = document.getElementById('form-update-status');
    if (form) {
        form.addEventListener('submit', function (e) {
            const status = document.getElementById('select-status').value;
            const catatan = document.getElementById('catatan_petugas').value.trim();

            if (status === 'dibatalkan' && catatan === '') {
                e.preventDefault();
                alert('Catatan petugas wajib diisi sebelum membatalkan permohonan.');
                document.getElementById('catatan_petugas').focus();
                return false;
            }

            if (status === 'sudah diambil') {
                if (!confirm('Anda akan menandai permohonan ini sebagai "Sudah Diambil". Status ini TIDAK DAPAT diubah kembali setelah disimpan.\n\nLanjutkan?')) {
                    e.preventDefault();
                    return false;
                }
            }

            if (status === 'dibatalkan') {
                if (!confirm('Anda akan MEMBATALKAN permohonan ini secara permanen. Status ini TIDAK DAPAT diubah kembali.\n\nLanjutkan?')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
});
</script>
@endsection
