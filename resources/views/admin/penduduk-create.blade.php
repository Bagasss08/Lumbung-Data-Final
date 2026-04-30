@extends('layouts.admin')

@section('title', 'Tambah Penduduk')

@section('content')

    @php
        // DIUBAH: hapus 'meninggal' — meninggal bukan jenis tambah
        $judulJenis = match ($jenis) {
            'masuk' => 'Penduduk Masuk',
            default => 'Penduduk Lahir',
        };
    @endphp

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Biodata Penduduk</h2>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Formulir penambahan data {{ $judulJenis }}</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.penduduk') }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                Data Penduduk
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">{{ $judulJenis }}</span>
        </nav>
    </div>

    <form method="POST" action="{{ route('admin.penduduk.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="jenis_tambah" value="{{ $jenis }}">

        <div class="flex items-start gap-5">

            {{-- ╔══════════════════════════════╗
         ║  CARD KIRI — Foto Penduduk  ║
         ╚══════════════════════════════╝ --}}
            <div
                class="w-52 flex-shrink-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden p-5 flex flex-col gap-3">

                <div
                    class="rounded-lg overflow-hidden border-2 border-gray-200 dark:border-slate-600 aspect-square bg-gray-100 dark:bg-slate-700">
                    <img id="preview-foto"
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='%23f1f5f9'/%3E%3Ccircle cx='100' cy='78' r='40' fill='%23cbd5e1'/%3E%3Cellipse cx='100' cy='178' rx='64' ry='50' fill='%23cbd5e1'/%3E%3C/svg%3E"
                        alt="Foto Penduduk" class="w-full h-full object-cover">
                </div>

                <label for="input-foto"
                    class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                      bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700
                      text-white text-xs font-semibold rounded-lg cursor-pointer
                      transition-all duration-200 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Unggah Foto
                </label>
                <input type="file" id="input-foto" name="foto" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">

                <button type="button" onclick="bukaKamera()"
                    class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                       bg-red-500 hover:bg-red-600 active:bg-red-700
                       text-white text-xs font-semibold rounded-lg
                       transition-all duration-200 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kamera
                </button>

                <p class="text-xs text-gray-400 dark:text-slate-500 text-center">JPG / PNG · Maks 2 MB</p>
            </div>

            {{-- ╔═══════════════════════════════════╗
         ║  CARD KANAN — Form Data Penduduk  ║
         ╚═══════════════════════════════════╝ --}}
            <div
                class="flex-1 min-w-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 space-y-3">
                    <a href="{{ route('admin.penduduk') }}"
                        class="inline-flex items-center gap-2 px-4 py-2
                      bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700
                      text-white text-xs font-semibold rounded-lg
                      transition-all duration-200 shadow-sm group">
                        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali Ke Daftar Penduduk
                    </a>

                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 dark:text-slate-500 flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-semibold text-gray-600 dark:text-slate-300">Tanggal Lapor</span>
                        <input type="date" name="tgl_terdaftar" value="{{ old('tgl_terdaftar', date('Y-m-d')) }}"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                              bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                              focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                    </div>
                </div>

                {{-- ════════ DATA DIRI ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Diri</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- ✅ NIK + Checkbox NIK Sementara (PATCHED) --}}
                        <div x-data="{
                            sementara: {{ old('is_nik_sementara') ? 'true' : 'false' }},
                            nikVal: '{{ old('nik') }}',
                            generate() {
                                const now = new Date();
                                const dd = String(now.getDate()).padStart(2, '0');
                                const mm = String(now.getMonth() + 1).padStart(2, '0');
                                const yy = String(now.getFullYear()).slice(-2);
                                const urut = String(Math.floor(Math.random() * 9000) + 1000);
                                this.nikVal = '000000' + dd + mm + yy + urut;
                                document.getElementById('nik').value = this.nikVal;
                            }
                        }">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span
                                    class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">
                                    NIK <span class="text-red-500">*</span>
                                </span>
                                <label class="flex items-center gap-1.5 cursor-pointer select-none ml-1">
                                    <input type="checkbox" name="is_nik_sementara" id="is_nik_sementara" value="1"
                                        x-model="sementara" @change="sementara && nikVal.trim() === '' && generate()"
                                        {{ old('is_nik_sementara') ? 'checked' : '' }}
                                        class="w-3.5 h-3.5 rounded border-gray-300 text-emerald-500 focus:ring-emerald-400 cursor-pointer">
                                    <span class="text-xs font-normal normal-case transition-colors"
                                        :class="sementara ? 'text-red-500 font-semibold' : 'text-gray-400 dark:text-slate-500'">
                                        (Sementara)
                                    </span>
                                </label>
                            </div>
                            <input type="text" name="nik" id="nik" x-model="nikVal"
                                placeholder="16 digit NIK" maxlength="16"
                                :class="sementara
                                    ?
                                    'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-400 ring-2 ring-emerald-300/30' :
                                    '{{ $errors->has('nik') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}'"
                                class="w-full px-3 py-2 border rounded-lg text-sm font-mono
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                            <div x-show="sementara" class="mt-1 flex items-center gap-2">
                                <p class="text-xs text-red-500">NIK sementara — wajib diganti dengan NIK resmi</p>
                                <button type="button" @click="generate()"
                                    class="text-xs text-emerald-600 hover:underline font-medium flex-shrink-0">↺
                                    Generate</button>
                            </div>
                            <div x-show="!sementara">
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @else
                                    <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nama Lengkap <span class="text-gray-400 font-normal normal-case">(Tanpa Gelar)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Kartu Keluarga --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                No. Kartu Keluarga
                            </label>
                            <select name="keluarga_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                                <option value="">Pilih No. KK</option>
                                @foreach ($keluarga as $kk)
                                    <option value="{{ $kk->id }}"
                                        {{ old('keluarga_id') == $kk->id ? 'selected' : '' }}>
                                        {{ $kk->no_kk }}
                                        @if ($kk->kepalaKeluarga)
                                            — {{ $kk->kepalaKeluarga->nama }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Kosongkan jika KK belum ada</p>
                        </div>

                        {{-- SHDK — DIUBAH: dari hubungan_keluarga string ke kk_level FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Hubungan Dalam Keluarga (SHDK) <span class="text-red-500">*</span>
                            </label>
                            <select name="kk_level"
                                class="w-full px-3 py-2 border rounded-lg text-sm
           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
           focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
           {{ $errors->has('kk_level') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih SHDK</option>
                                @foreach ($refShdk as $shdk)
                                    <option value="{{ $shdk->id }}"
                                        {{ old('kk_level') == $shdk->id ? 'selected' : '' }}>
                                        {{ $shdk->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kk_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_kelamin"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                               {{ $errors->has('jenis_kelamin') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Agama — DIUBAH: dari string ke agama_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Agama <span class="text-red-500">*</span>
                            </label>
                            <select name="agama_id"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                               {{ $errors->has('agama_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Agama</option>
                                @foreach ($refAgama as $agama)
                                    <option value="{{ $agama->id }}"
                                        {{ old('agama_id') == $agama->id ? 'selected' : '' }}>
                                        {{ $agama->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agama_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Status Penduduk — DIUBAH: dari status_hidup tetap/tidak_tetap ke status 1/2/3 --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Penduduk <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Tetap</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Tidak Tetap</option>
                                <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Pendatang</option>
                            </select>
                        </div>

                        {{-- Tag ID Card --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tag ID Card
                            </label>
                            <input type="text" name="tag_id_card" value="{{ old('tag_id_card') }}"
                                placeholder="Tag ID Card"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                    </div>
                </div>

                {{-- ════════ DATA KELAHIRAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Kelahiran</span>
                    </div>
                    <div class="p-5 grid grid-cols-3 gap-x-5 gap-y-4">

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                placeholder="Kota / Kabupaten"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                                  {{ $errors->has('tempat_lahir') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('tempat_lahir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                                  {{ $errors->has('tanggal_lahir') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Peristiwa
                                <span class="font-normal normal-case text-gray-400 ml-1">
                                    @if ($jenis === 'masuk')
                                        (Tgl Datang)
                                    @else
                                        (Opsional)
                                    @endif
                                </span>
                            </label>
                            <input type="date" name="tgl_peristiwa" value="{{ old('tgl_peristiwa') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                    </div>
                </div>

                {{-- ════════ DATA PENDIDIKAN & PEKERJAAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Pendidikan &amp; Pekerjaan</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        @php
                            $defaultPekerjaanId = old(
                                'pekerjaan_id',
                                $refPekerjaan->first(
                                    fn($p) => str_contains(strtolower($p->nama), 'belum') ||
                                        str_contains(strtolower($p->nama), 'tidak bekerja'),
                                )?->id,
                            );

                            $defaultPendidikanId = old(
                                'pendidikan_kk_id',
                                $refPendidikan->first(
                                    fn($p) => str_contains(strtolower($p->nama), 'belum') ||
                                        str_contains(strtolower($p->nama), 'tidak sekolah'),
                                )?->id,
                            );
                        @endphp

                        {{-- Pendidikan dalam KK — DIUBAH: dari string ke pendidikan_kk_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Pendidikan Dalam KK
                            </label>
                            <select name="pendidikan_kk_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                                <option value="">Pilih Pendidikan</option>
                                @foreach ($refPendidikan as $pend)
                                    <option value="{{ $pend->id }}"
                                        {{ old('pendidikan_kk_id') == $pend->id ? 'selected' : '' }}>
                                        {{ $pend->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pekerjaan — DIUBAH: dari string ke pekerjaan_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Pekerjaan
                            </label>
                            <select name="pekerjaan_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                                <option value="">Pilih Pekerjaan</option>
                                @foreach ($refPekerjaan as $pek)
                                    <option value="{{ $pek->id }}"
                                        {{ old('pekerjaan_id') == $pek->id ? 'selected' : '' }}>
                                        {{ $pek->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                {{-- ════════ DATA KEWARGANEGARAAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Kewarganegaraan</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- Warga Negara — DIUBAH: dari string ke warganegara_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Warga Negara <span class="text-red-500">*</span>
                            </label>
                            <select name="warganegara_id"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                               {{ $errors->has('warganegara_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Warga Negara</option>
                                @foreach ($refWarganegara as $wn)
                                    <option value="{{ $wn->id }}"
                                        {{ old('warganegara_id', 1) == $wn->id ? 'selected' : '' }}>
                                        {{ $wn->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warganegara_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Golongan Darah — DIUBAH: dari string ke golongan_darah_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Golongan Darah <span class="text-red-500">*</span>
                            </label>
                            <select name="golongan_darah_id"
                                class="w-full px-3 py-2 border rounded-lg text-sm
           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
           focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
           {{ $errors->has('golongan_darah_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Golongan Darah</option>
                                @foreach ($refGolDarah as $gd)
                                    <option value="{{ $gd->id }}"
                                        {{ old('golongan_darah_id') == $gd->id ? 'selected' : '' }}>
                                        {{ $gd->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('golongan_darah_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- ════════ DATA ORANG TUA ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Orang Tua</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nama Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                placeholder="Nama Lengkap Ayah"
                                class="w-full px-3 py-2 border rounded-lg text-sm
          bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
          placeholder-gray-300 dark:placeholder-slate-500
          focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
          {{ $errors->has('nama_ayah') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama_ayah')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nama Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                placeholder="Nama Lengkap Ibu"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama_ibu') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama_ibu')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- BARU: NIK Ayah & NIK Ibu --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                NIK Ayah
                            </label>
                            <input type="text" name="nik_ayah" id="nik_ayah" value="{{ old('nik_ayah') }}"
                                placeholder="16 digit NIK Ayah" maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                            <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Opsional — untuk relasi antar
                                penduduk</p>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                NIK Ibu
                            </label>
                            <input type="text" name="nik_ibu" id="nik_ibu" value="{{ old('nik_ibu') }}"
                                placeholder="16 digit NIK Ibu" maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                            <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Opsional — untuk relasi antar
                                penduduk</p>
                        </div>

                    </div>
                </div>

                {{-- ════════ DATA ALAMAT ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Alamat</span>
                    </div>
                    <div class="p-5 space-y-4" x-data="{
                        wilayahAll: {{ $wilayah->toJson() }},
                        selectedDusun: '{{ old('_dusun', '') }}',
                        selectedRw: '{{ old('_rw', '') }}',
                        selectedWilayahId: '{{ old('wilayah_id', '') }}',
                        get dusunList() {
                            return [...new Set(this.wilayahAll.map(w => w.dusun))].sort();
                        },
                        get rwList() {
                            if (!this.selectedDusun) return [];
                            return [...new Set(this.wilayahAll.filter(w => w.dusun === this.selectedDusun).map(w => w.rw))].sort();
                        },
                        get rtList() {
                            if (!this.selectedDusun || !this.selectedRw) return [];
                            return this.wilayahAll.filter(w => w.dusun === this.selectedDusun && w.rw === this.selectedRw)
                                .sort((a, b) => a.rt.localeCompare(b.rt));
                        },
                        onDusunChange() {
                            this.selectedRw = '';
                            this.selectedWilayahId = '';
                        },
                        onRwChange() { this.selectedWilayahId = ''; },
                    }">

                        {{-- Cascading Wilayah --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">
                                Wilayah Tempat Tinggal <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-400 dark:text-slate-500 mb-1">Dusun</label>
                                    <select x-model="selectedDusun" @change="onDusunChange()"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                                        <option value="">— Pilih Dusun —</option>
                                        <template x-for="dusun in dusunList" :key="dusun">
                                            <option :value="dusun" x-text="dusun"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 dark:text-slate-500 mb-1">RW</label>
                                    <select x-model="selectedRw" @change="onRwChange()" :disabled="!selectedDusun"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               disabled:opacity-40 disabled:cursor-not-allowed">
                                        <option value="">— Pilih RW —</option>
                                        <template x-for="rw in rwList" :key="rw">
                                            <option :value="rw" x-text="'RW ' + rw"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 dark:text-slate-500 mb-1">RT</label>
                                    <select x-model="selectedWilayahId" :disabled="!selectedRw"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               disabled:opacity-40 disabled:cursor-not-allowed">
                                        <option value="">— Pilih RT —</option>
                                        <template x-for="w in rtList" :key="w.id">
                                            <option :value="w.id" x-text="'RT ' + w.rt"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="wilayah_id" :value="selectedWilayahId">
                            @error('wilayah_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi — pilih Dusun → RW → RT
                                </p>
                            @enderror
                        </div>

                        {{-- Alamat Sekarang --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                Sekarang</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}"
                                placeholder="Jl. Contoh No. 1, RT/RW"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                       bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                       focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>

                        {{-- Alamat Sebelumnya (khusus jenis masuk) --}}
                        @if ($jenis === 'masuk')
                            <div class="grid grid-cols-2 gap-5">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                        Alamat Sebelumnya
                                    </label>
                                    <input type="text" name="alamat_sebelumnya"
                                        value="{{ old('alamat_sebelumnya') }}" placeholder="Alamat asal sebelum pindah"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                           focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">No.
                                        KK Sebelumnya</label>
                                    <input type="text" name="no_kk_sebelumnya" value="{{ old('no_kk_sebelumnya') }}"
                                        placeholder="No. KK di desa asal" maxlength="16"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                           focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                                </div>
                            </div>
                        @endif

                        {{-- Kontak --}}
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor
                                    Telepon</label>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                           focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    placeholder="contoh@email.com"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                           bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                           focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                           {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">Format email tidak valid</p>
                                @enderror
                            </div>
                        </div>

                    </div>{{-- end x-data --}}
                </div>{{-- end DATA ALAMAT --}}

                {{-- ════════ DATA PERKAWINAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Perkawinan</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- Status Kawin — DIUBAH: dari string ke status_kawin_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Perkawinan <span class="text-red-500">*</span>
                            </label>
                            <select name="status_kawin_id" id="status_kawin_id"
                                class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                               focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all
                               {{ $errors->has('status_kawin_id') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}"
                                onchange="toggleDetailKawin(this.value)">
                                <option value="">Pilih Status Perkawinan</option>
                                @foreach ($refStatusKawin as $sk)
                                    <option value="{{ $sk->id }}"
                                        {{ old('status_kawin_id') == $sk->id ? 'selected' : '' }}>
                                        {{ $sk->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_kawin_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>

                        {{-- Detail perkawinan (muncul jika kawin/cerai) --}}
                        <div id="detail-kawin"
                            class="{{ in_array(old('status_kawin_id'), [2, 3, 4, 5, 6]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                No. Akta Nikah / Perkawinan
                            </label>
                            <input type="text" name="akta_perkawinan" value="{{ old('akta_perkawinan') }}"
                                placeholder="Nomor akta"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                        <div id="detail-kawin-tgl"
                            class="{{ in_array(old('status_kawin_id'), [2, 3, 4, 5, 6]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Perkawinan
                            </label>
                            <input type="date" name="tanggal_perkawinan" value="{{ old('tanggal_perkawinan') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                        {{-- Detail perceraian (id 4=Cerai Tercatat, 5=Cerai Tidak Tercatat) --}}
                        <div id="detail-cerai" class="{{ in_array(old('status_kawin_id'), [4, 5]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                No. Akta Perceraian
                                <span class="font-normal normal-case text-gray-400 ml-1">(Cerai Tercatat jika diisi)</span>
                            </label>
                            <input type="text" name="akta_perceraian" value="{{ old('akta_perceraian') }}"
                                placeholder="Nomor akta perceraian"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                        <div id="detail-cerai-tgl"
                            class="{{ in_array(old('status_kawin_id'), [4, 5]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Tanggal Perceraian
                            </label>
                            <input type="date" name="tanggal_perceraian" value="{{ old('tanggal_perceraian') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                        </div>

                    </div>
                </div>

                {{-- ════════ TOMBOL AKSI ════════ --}}
                <div class="flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-slate-800/60">
                    <a href="{{ route('admin.penduduk') }}"
                        class="inline-flex items-center gap-2 px-5 py-2
                      border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700
                      hover:bg-red-50 dark:hover:bg-red-900/10 hover:border-red-300 dark:hover:border-red-700
                      text-gray-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400
                      rounded-lg font-semibold text-sm transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-7 py-2
                           bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800
                           text-white rounded-lg font-semibold text-sm
                           transition-all duration-200 shadow-sm hover:shadow-md
                           focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>

            </div>{{-- end card kanan --}}
        </div>{{-- end 2 card --}}

    </form>

    {{-- ══ MODAL KAMERA ══ --}}
    <div id="modal-kamera" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-gray-800 dark:text-slate-200 text-sm">Ambil Foto dari Kamera</span>
                </div>
                <button type="button" onclick="tutupKamera()"
                    class="w-7 h-7 rounded-lg flex items-center justify-center
                           text-gray-400 hover:text-gray-600 dark:hover:text-slate-200
                           hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="relative bg-black">
                <video id="video-kamera" autoplay playsinline class="w-full"
                    style="max-height:320px;object-fit:cover;"></video>
                <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                    <div class="w-40 h-48 border-2 border-white/40 rounded-xl"></div>
                </div>
            </div>
            <canvas id="canvas-kamera" class="hidden"></canvas>

            <div id="kamera-error" class="hidden px-5 py-3 bg-red-50 dark:bg-red-900/20 border-b border-red-100">
                <p class="text-sm text-red-600 dark:text-red-400 text-center">
                    Kamera tidak dapat diakses. Pastikan izin kamera sudah diberikan.
                </p>
            </div>

            <div class="flex gap-3 p-4">
                <button type="button" onclick="tutupKamera()"
                    class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600
                           bg-white dark:bg-slate-700 text-gray-600 dark:text-slate-300
                           hover:bg-gray-50 rounded-lg font-semibold text-sm transition-all">
                    Batal
                </button>
                <button type="button" onclick="ambilFoto()"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5
                           bg-red-500 hover:bg-red-600 text-white
                           rounded-lg font-semibold text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ambil Foto
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function previewFoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        document.getElementById('preview-foto').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // ✅ PATCHED: NIK utama dikontrol x-model Alpine — nik_ayah & nik_ibu tetap listener
            ['nik_ayah', 'nik_ibu'].forEach(id => {
                document.getElementById(id)?.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').substring(0, 16);
                });
            });
            document.getElementById('nik')?.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').substring(0, 16);
            });
            document.getElementById('no_telp')?.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            // Tampilkan/sembunyikan field perkawinan berdasarkan status kawin
            function toggleDetailKawin(val) {
                const idKawin = parseInt(val);
                // id 2=Kawin Tercatat, 3=Kawin Belum Tercatat, 4=Cerai Tercatat, 5=Cerai Tidak Tercatat, 6=Cerai Mati
                const sudahKawin = [2, 3, 4, 5, 6].includes(idKawin);
                const sudahCerai = [4, 5].includes(idKawin);

                document.getElementById('detail-kawin')?.classList.toggle('hidden', !sudahKawin);
                document.getElementById('detail-kawin-tgl')?.classList.toggle('hidden', !sudahKawin);
                document.getElementById('detail-cerai')?.classList.toggle('hidden', !sudahCerai);
                document.getElementById('detail-cerai-tgl')?.classList.toggle('hidden', !sudahCerai);
            }

            // Init saat page load (untuk old value saat validasi gagal)
            toggleDetailKawin(document.getElementById('status_kawin_id')?.value ?? '');

            let streamKamera = null;

            async function bukaKamera() {
                const modal = document.getElementById('modal-kamera');
                const video = document.getElementById('video-kamera');
                const errBox = document.getElementById('kamera-error');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                errBox.classList.add('hidden');
                try {
                    streamKamera = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user',
                            width: {
                                ideal: 640
                            },
                            height: {
                                ideal: 480
                            }
                        },
                        audio: false
                    });
                    video.srcObject = streamKamera;
                } catch (err) {
                    errBox.classList.remove('hidden');
                }
            }

            function tutupKamera() {
                const modal = document.getElementById('modal-kamera');
                const video = document.getElementById('video-kamera');
                if (streamKamera) {
                    streamKamera.getTracks().forEach(t => t.stop());
                    streamKamera = null;
                }
                video.srcObject = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function ambilFoto() {
                const video = document.getElementById('video-kamera');
                const canvas = document.getElementById('canvas-kamera');
                const preview = document.getElementById('preview-foto');
                const inputFoto = document.getElementById('input-foto');
                if (!streamKamera) return;
                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                const ctx = canvas.getContext('2d');
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                preview.src = canvas.toDataURL('image/jpeg', 0.92);
                canvas.toBlob(blob => {
                    const file = new File([blob], 'foto-kamera.jpg', {
                        type: 'image/jpeg'
                    });
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    inputFoto.files = dt.files;
                }, 'image/jpeg', 0.92);
                tutupKamera();
            }

            document.getElementById('modal-kamera')?.addEventListener('click', e => {
                if (e.target === document.getElementById('modal-kamera')) tutupKamera();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') tutupKamera();
            });
        </script>
    @endpush

@endsection
