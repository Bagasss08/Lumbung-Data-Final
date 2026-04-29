@extends('layouts.admin')

@section('title', 'Detail Penduduk')

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Detail Penduduk</h2>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Data kependudukan</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.penduduk') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Data
                Penduduk</a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Biodata Penduduk</span>
        </nav>
    </div>

    {{-- ══ MAIN CARD ══ --}}
    <div
        class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

        {{-- ── ACTION BUTTONS ── --}}
        <div
            class="flex flex-wrap items-center gap-2 p-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/60">

            {{-- Manajemen Dokumen --}}
            <a href="{{ route('admin.penduduk.dokumen', $penduduk) }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
                  bg-emerald-500 hover:bg-emerald-600 text-white transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Manajemen Dokumen
            </a>

            {{-- Ubah Biodata --}}
            <a href="{{ route('admin.penduduk.edit', $penduduk) }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
                  bg-amber-500 hover:bg-amber-600 text-white transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Ubah Biodata
            </a>

            {{-- Cetak Biodata --}}
            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
                       bg-indigo-500 hover:bg-indigo-600 text-white transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Biodata
            </button>

            {{-- Anggota Keluarga --}}
            @if ($penduduk->keluarga)
                <a href="{{ route('admin.keluarga.show', $penduduk->keluarga) }}"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
                  bg-red-500 hover:bg-red-600 text-white transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Anggota Keluarga
                </a>
            @endif
            {{-- Tambah Penduduk --}}
            <a href="{{ route('admin.penduduk.create') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
          bg-emerald-500 hover:bg-emerald-600 text-white transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Penduduk
            </a>



            {{-- Kembali --}}
            <a href="{{ route('admin.penduduk') }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded text-xs font-semibold
                  bg-emerald-500 hover:bg-emerald-600 text-white transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali Ke Daftar Penduduk
            </a>
        </div>

        {{-- ── JUDUL BIODATA + INFO WAKTU ── --}}
        <div class="px-6 pt-5 pb-2">
            <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">
                Biodata Penduduk (NIK : {{ $penduduk->nik }})
            </h3>
            <div class="flex flex-wrap gap-4 mt-1 text-xs text-gray-400 dark:text-slate-500">
                <span>Terdaftar sebelum: &#128344; {{ $penduduk->created_at->format('d M Y H:i:s') }}</span>
                <span>Terakhir diubah: &#128344; {{ $penduduk->updated_at->format('d M Y H:i:s') }} &#128100;
                    Administrator</span>
            </div>
        </div>

        {{-- ── FOTO ── --}}
        <div class="flex justify-center py-5 border-b border-gray-100 dark:border-slate-700">
            <div
                class="w-40 h-40 rounded overflow-hidden border-2 border-gray-300 dark:border-slate-600 bg-gray-100 dark:bg-slate-700">
                <img src="{{ $penduduk->foto_url }}" alt="{{ $penduduk->nama }}" class="w-full h-full object-cover"
                    onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 200 200%27%3E%3Crect width=%27200%27 height=%27200%27 fill=%27%23f1f5f9%27/%3E%3Ccircle cx=%27100%27 cy=%2778%27 r=%2740%27 fill=%27%23cbd5e1%27/%3E%3Cellipse cx=%27100%27 cy=%27178%27 rx=%2764%27 ry=%2750%27 fill=%27%23cbd5e1%27/%3E%3C/svg%3E'">
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- ── TABEL DATA (label : nilai) ── --}}
        {{-- ═══════════════════════════════════════════════ --}}
        @php
            // Helper untuk baris data
            $row = fn(string $label, $val) => ['label' => $label, 'val' => $val ?: ''];
        @endphp

        {{-- ═══ DATA DIRI ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">DATA DIRI</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @foreach ([['Status Dasar', strtoupper($penduduk->label_status_dasar)], ['Nama', $penduduk->nama], ['NIK', $penduduk->nik . ($penduduk->is_nik_sementara ? ' (NIK Sementara)' : '')], ['Jenis Kelamin', $penduduk->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN'], ['Agama', strtoupper($penduduk->agama?->nama ?? ($penduduk->agama_lama ?? '—'))], ['Status Penduduk', strtoupper($penduduk->label_status)], ['Cara Terdaftar', strtoupper($penduduk->label_jenis_tambah)], ['Tag ID Card', $penduduk->tag_id_card ?: '—']] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach

                {{-- Status Kepemilikan Identitas --}}
                <tr class="bg-white dark:bg-slate-800">
                    <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">Status Kepemilikan
                        Identitas</td>
                    <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                    <td class="px-3 py-2.5">
                        <table class="text-xs text-gray-700 dark:text-slate-300">
                            <thead>
                                <tr>
                                    <th class="pr-8 pb-1 font-semibold text-gray-500 dark:text-slate-400">Wajib Identitas
                                    </th>
                                    <th class="pr-8 pb-1 font-semibold text-gray-500 dark:text-slate-400">Identitas-EL</th>
                                    <th class="pr-8 pb-1 font-semibold text-gray-500 dark:text-slate-400">Status Rekam</th>
                                    <th class="pb-1 font-semibold text-gray-500 dark:text-slate-400">Tag ID Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pr-8 text-gray-800 dark:text-slate-100 font-semibold">
                                        {{ $penduduk->umur >= 17 ? 'WAJIB KTP' : 'BELUM WAJIB' }}
                                    </td>
                                    <td class="pr-8 text-gray-800 dark:text-slate-100 font-semibold">
                                        {{ $penduduk->ktp_el ? 'YA' : '—' }}
                                    </td>
                                    <td class="pr-8 text-gray-800 dark:text-slate-100 font-semibold">
                                        {{ $penduduk->status_rekam ?: '—' }}
                                    </td>
                                    <td class="text-gray-800 dark:text-slate-100 font-semibold">
                                        {{ $penduduk->tag_id_card ?: '—' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                @foreach ([['Nomor Kartu Keluarga', $penduduk->keluarga?->no_kk ?? '—'], ['Nomor KK Sebelumnya', $penduduk->no_kk_sebelumnya ?: '—'], ['Hubungan Dalam Keluarga', strtoupper($penduduk->shdk?->nama ?? '—')]] as $i => [$label, $val])
                    <tr
                        class="{{ ($i + 1) % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        {{-- ═══ DATA PENDIDIKAN DAN PEKERJAAN ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">DATA PENDIDIKAN DAN PEKERJAAN</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @foreach ([['Pendidikan dalam KK', strtoupper($penduduk->pendidikanKk?->nama ?? ($penduduk->pendidikan_lama ?? '—'))], ['Pekerjaan', strtoupper($penduduk->pekerjaan?->nama ?? ($penduduk->pekerjaan_lama ?? '—'))]] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>





        {{-- ═══ ORANG TUA ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">ORANG TUA</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @foreach ([['NIK Ayah', $penduduk->nik_ayah ?: '—'], ['Nama Ayah', $penduduk->nama_ayah ?: '—'], ['NIK Ibu', $penduduk->nik_ibu ?: '—'], ['Nama Ibu', $penduduk->nama_ibu ?: '—']] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ═══ ALAMAT ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">ALAMAT</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @php
                    $alamatKK = $penduduk->keluarga
                        ? ($penduduk->keluarga->alamat ?:
                        ($penduduk->wilayah
                            ? $penduduk->wilayah->dusun .
                                ' RT ' .
                                $penduduk->wilayah->rt .
                                '/ RW ' .
                                $penduduk->wilayah->rw
                            : '—'))
                        : '—';
                @endphp
                @foreach ([['Alamat KK', $alamatKK], ['Alamat Sekarang', $penduduk->alamat ?: '—'], ['Alamat Sebelumnya', $penduduk->alamat_sebelumnya ?: '—'], ['Dusun', strtoupper($penduduk->wilayah?->dusun ?? '—')], ['RT/ RW', $penduduk->wilayah ? $penduduk->wilayah->rt . ' / ' . ($penduduk->wilayah->rw ?: '-') : '—'], ['Nomor Telepon', $penduduk->no_telp ?: '—'], ['Alamat Email', $penduduk->email ?: '—']] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ═══ DATA PERKAWINAN ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">DATA PERKAWINAN</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @foreach ([['Status Kawin', strtoupper($penduduk->statusKawin?->nama ?? ($penduduk->status_kawin_lama ?? '—'))]] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ═══ DATA KESEHATAN ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">DATA KESEHATAN</span></div>
        <table class="w-full text-sm border-b border-gray-100 dark:border-slate-700">
            <tbody>
                @foreach ([['Golongan Darah', strtoupper($penduduk->golonganDarah?->nama ?? ($penduduk->golongan_darah_lama ?? '—'))]] as $i => [$label, $val])
                    <tr class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                        <td class="w-64 pl-6 pr-3 py-2.5 text-gray-500 dark:text-slate-400 font-medium">
                            {{ $label }}</td>
                        <td class="px-3 py-2.5 text-gray-400 dark:text-slate-500 w-4">:</td>
                        <td class="px-3 py-2.5 text-gray-800 dark:text-slate-100 font-semibold">{{ $val }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>



        {{-- ═══ UBAH STATUS DASAR ═══ --}}
        @if ($penduduk->status_dasar === 'hidup')
            <div id="section-ubah-status">
                <div class="bg-orange-500 dark:bg-orange-600 px-6 py-2"><span
                        class="text-xs font-bold text-white uppercase tracking-widest">UBAH STATUS DASAR</span></div>
                <div class="p-6 border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">
                        Gunakan formulir ini untuk mencatat perubahan status penduduk (meninggal, pindah, hilang).
                        @if ($penduduk->kk_level == \App\Models\Penduduk::SHDK_KEPALA_KELUARGA)
                            <span class="text-orange-500 font-semibold block mt-1">
                                ⚠ Penduduk ini adalah Kepala Keluarga. Tetapkan Kepala Keluarga pengganti sebelum mengubah
                                status menjadi Meninggal.
                            </span>
                        @endif
                    </p>
                    <form method="POST" action="{{ route('admin.penduduk.ubah-status-dasar', $penduduk) }}"
                        class="flex flex-wrap gap-4 items-end">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Status Baru <span class="text-red-500">*</span>
                            </label>
                            <select name="status_dasar" required
                                class="px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-orange-400 outline-none">
                                @if ($penduduk->kk_level != \App\Models\Penduduk::SHDK_KEPALA_KELUARGA)
                                    <option value="mati">Meninggal</option>
                                @endif
                                <option value="pindah">Pindah</option>
                                <option value="hilang">Hilang</option>
                                <option value="pergi">Pergi</option>
                                <option value="tidak_valid">Tidak Valid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Tanggal Peristiwa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tgl_peristiwa" required value="{{ date('Y-m-d') }}"
                                class="px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-orange-400 outline-none">
                        </div>
                        <div class="flex-1 min-w-48">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
                                Keterangan
                            </label>
                            <input type="text" name="keterangan" placeholder="Keterangan tambahan (opsional)"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-orange-400 outline-none">
                        </div>
                        <div>
                            <button type="submit"
                                class="px-5 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded
                                   font-semibold text-sm transition-colors shadow-sm">
                                Simpan Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- ═══ PROGRAM BANTUAN ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">PROGRAM BANTUAN</span></div>
        <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
            <table class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded overflow-hidden">
                <thead>
                    <tr
                        class="bg-gray-100 dark:bg-slate-700 text-xs text-gray-600 dark:text-slate-300 font-semibold uppercase">
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600 w-12">NO</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600">WAKTU / TANGGAL</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600">NAMA PROGRAM</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @if (class_exists(\App\Models\ProgramPeserta::class) && $penduduk->programPeserta && $penduduk->programPeserta->count())
                        @foreach ($penduduk->programPeserta as $i => $peserta)
                            <tr
                                class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600">{{ $i + 1 }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600">
                                    {{ $peserta->program?->created_at?->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600 font-semibold">
                                    {{ $peserta->program?->nama ?? '—' }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600">
                                    {{ $peserta->program?->keterangan ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4"
                                class="px-4 py-4 text-center text-gray-400 dark:text-slate-500 text-xs italic">
                                Tidak ada data program bantuan
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ═══ DOKUMEN / KELENGKAPAN PENDUDUK ═══ --}}
        <div class="bg-emerald-500 dark:bg-emerald-600 px-6 py-2"><span
                class="text-xs font-bold text-white uppercase tracking-widest">DOKUMEN / KELENGKAPAN PENDUDUK</span></div>
        <div class="p-4 bg-white dark:bg-slate-800">
            <table class="w-full text-sm border border-gray-200 dark:border-slate-600 rounded overflow-hidden">
                <thead>
                    <tr
                        class="bg-gray-100 dark:bg-slate-700 text-xs text-gray-600 dark:text-slate-300 font-semibold uppercase">
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600 w-12">NO</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600 w-28">AKSI</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600">NAMA DOKUMEN</th>
                        <th class="px-4 py-2.5 text-left border border-gray-200 dark:border-slate-600">TANGGAL UPLOAD</th>
                    </tr>
                </thead>
                <tbody>
                    @if (class_exists(\App\Models\DokumenPenduduk::class))
                        @php
                            $dokumens = \App\Models\DokumenPenduduk::where('penduduk_id', $penduduk->id)
                                ->latest()
                                ->get();
                        @endphp
                        @forelse($dokumens as $i => $dok)
                            <tr
                                class="{{ $i % 2 == 0 ? 'bg-white dark:bg-slate-800' : 'bg-gray-50 dark:bg-slate-700/30' }}">
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600">{{ $i + 1 }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600">
                                    <div class="flex gap-1.5">
                                        <a href="{{ Storage::url($dok->file_path) }}" download
                                            class="inline-flex items-center justify-center w-7 h-7 rounded bg-indigo-500 hover:bg-indigo-600 text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                        <a href="{{ Storage::url($dok->file_path) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded bg-emerald-500 hover:bg-emerald-600 text-white">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600 font-semibold">
                                    {{ $dok->nama_dokumen }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200 dark:border-slate-600 text-gray-500">
                                    {{ $dok->created_at->format('d F Y H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-4 py-4 text-center text-gray-400 dark:text-slate-500 text-xs italic">
                                    Tidak ada dokumen
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="4"
                                class="px-4 py-4 text-center text-gray-400 dark:text-slate-500 text-xs italic">
                                Tidak ada dokumen
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>


        </div>

    </div>{{-- END MAIN CARD --}}

    @include('admin.partials.modal-hapus')

@endsection
