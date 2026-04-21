@extends('layouts.admin')

@section('title', 'Tambah Anggota Keluarga')

@section('content')

{{-- PAGE HEADER --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Tambah Anggota Keluarga</h2>
        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Formulir penambahan anggota ke dalam kartu keluarga</p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.keluarga') }}"
           class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            Data Keluarga
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('admin.keluarga.show', $keluarga) }}"
           class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            Detail Keluarga
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Tambah Anggota</span>
    </nav>
</div>

{{-- INFO KELUARGA (readonly) --}}
<div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-4 mb-4 flex flex-wrap items-center gap-6">
    <div>
        <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-0.5">No. KK</p>
        <p class="text-sm font-mono font-semibold text-gray-800 dark:text-slate-200">{{ $keluarga->no_kk }}</p>
    </div>
    <div class="w-px h-8 bg-emerald-200 dark:bg-emerald-700 hidden sm:block"></div>
    <div>
        <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-0.5">Kepala Keluarga</p>
        <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">{{ $keluarga->kepalaKeluarga?->nama ?? '-' }}</p>
    </div>
    <div class="w-px h-8 bg-emerald-200 dark:bg-emerald-700 hidden sm:block"></div>
    <div>
        <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-0.5">Alamat</p>
        <p class="text-sm text-gray-700 dark:text-slate-300">
            {{ $keluarga->wilayah?->dusun ?? '-' }}
            @if($keluarga->wilayah?->rt) — RT {{ $keluarga->wilayah->rt }} / RW {{ $keluarga->wilayah->rw ?? '-' }} @endif
        </p>
    </div>
    @php $jenis = request('jenis', 'masuk'); @endphp
    <div class="ml-auto">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
            {{ $jenis === 'lahir' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' }}">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($jenis === 'lahir')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                @endif
            </svg>
            {{ $jenis === 'lahir' ? 'Kelahiran' : 'Penduduk Masuk' }}
        </span>
    </div>
</div>

<form method="POST"
      action="{{ route('admin.keluarga.anggota.store', $keluarga) }}"
      enctype="multipart/form-data">
@csrf
<input type="hidden" name="jenis_tambah" value="{{ $jenis }}">

<div class="flex items-start gap-5">

    {{-- CARD KIRI — Foto --}}
    <div class="w-52 flex-shrink-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden p-5 flex flex-col gap-3">
        <div class="rounded-lg overflow-hidden border-2 border-gray-200 dark:border-slate-600 aspect-square bg-gray-100 dark:bg-slate-700">
            <img id="preview-foto"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='%23f1f5f9'/%3E%3Ccircle cx='100' cy='78' r='40' fill='%23cbd5e1'/%3E%3Cellipse cx='100' cy='178' rx='64' ry='50' fill='%23cbd5e1'/%3E%3C/svg%3E"
                 alt="Foto" class="w-full h-full object-cover">
        </div>
        <label for="input-foto"
               class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                      bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg cursor-pointer transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Unggah Foto
        </label>
        <input type="file" id="input-foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
        <button type="button" onclick="bukaKamera()"
                class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                       bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-all shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Kamera
        </button>
        <p class="text-xs text-gray-400 dark:text-slate-500 text-center">JPG / PNG · Maks 2 MB</p>
    </div>

    {{-- CARD KANAN — Form --}}
    <div class="flex-1 min-w-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

        {{-- Tombol kembali + tanggal lapor --}}
        <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 space-y-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.keluarga.show', $keluarga) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-all shadow-sm group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali Ke Detail Keluarga
                </a>
                <a href="{{ route('admin.keluarga') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-all shadow-sm group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Daftar Keluarga
                </a>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-600 dark:text-slate-300">
                        {{ $jenis === 'lahir' ? 'Tanggal Lahir Peristiwa' : 'Tanggal Pindah Masuk' }}
                    </span>
                    <input type="date" name="tgl_peristiwa" value="{{ old('tgl_peristiwa', date('Y-m-d')) }}"
                           class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-600 dark:text-slate-300">Tanggal Lapor</span>
                    <input type="date" name="tgl_terdaftar" value="{{ old('tgl_terdaftar', date('Y-m-d')) }}"
                           class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                </div>
            </div>
        </div>

        {{-- ═══ DATA DIRI ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Diri</span>
            </div>
            <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                {{-- NIK + Checkbox NIK Sementara --}}
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
                        <span class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">
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
                            ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-400 ring-2 ring-emerald-300/30'
                            : '{{ $errors->has('nik') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}'"
                        class="w-full px-3 py-2 border rounded-lg text-sm font-mono
                          bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                          placeholder-gray-300 dark:placeholder-slate-500
                          focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition-all">
                    <div x-show="sementara" class="mt-1 flex items-center gap-2">
                        <p class="text-xs text-red-500">NIK sementara — wajib diganti dengan NIK resmi</p>
                        <button type="button" @click="generate()"
                            class="text-xs text-emerald-600 hover:underline font-medium flex-shrink-0">↺ Generate</button>
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
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Nama Lengkap <span class="text-gray-400 font-normal normal-case">(Tanpa Gelar)</span>
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           placeholder="Nama Lengkap"
                           class="w-full px-3 py-2 border rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                {{-- Hubungan Dalam Keluarga (SHDK) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Hubungan Dalam Keluarga
                    </label>
                    <select name="kk_level"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Hubungan Keluarga</option>
                        @foreach($refShdk as $shdk)
                            <option value="{{ $shdk->id }}" {{ old('kk_level') == $shdk->id ? 'selected' : '' }}>
                                {{ $shdk->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        onchange="updateWajibKtp()"
                        class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               {{ $errors->has('jenis_kelamin') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                        <option value="">Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                {{-- Agama --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Agama <span class="text-red-500">*</span>
                    </label>
                    <select name="agama_id"
                        class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               {{ $errors->has('agama_id') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                        <option value="">Pilih Agama</option>
                        @foreach($refAgama as $agama)
                            <option value="{{ $agama->id }}" {{ old('agama_id') == $agama->id ? 'selected' : '' }}>{{ $agama->nama }}</option>
                        @endforeach
                    </select>
                    @error('agama_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                {{-- Status Penduduk --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Status Penduduk
                    </label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Status Penduduk</option>
                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Tetap</option>
                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Tidak Tetap</option>
                        <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Pendatang</option>
                    </select>
                </div>

                {{-- Status Kepemilikan Identitas --}}
                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">
                        Status Kepemilikan Identitas
                    </label>
                    <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-slate-600">
                        <table class="w-full text-xs">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-slate-700/60">
                                    <th class="px-3 py-2 text-left font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Wajib Identitas</th>
                                    <th class="px-3 py-2 text-left font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Identitas Elektronik</th>
                                    <th class="px-3 py-2 text-left font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Status Rekam</th>
                                    <th class="px-3 py-2 text-left font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wide">Tag ID Card</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800">
                                <tr>
                                    <td class="px-3 py-2.5">
                                        <span id="label-wajib-ktp" class="font-semibold text-gray-500 dark:text-slate-400">BELUM WAJIB</span>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <select name="identitas_anak"
                                            class="w-full px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-xs bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                                            <option value="KIA" {{ old('identitas_anak', 'KIA') == 'KIA' ? 'selected' : '' }}>KIA</option>
                                            <option value="KTP" {{ old('identitas_anak') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <select name="status_rekam"
                                            class="w-full px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-xs bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none">
                                            <option value="">Pilih Status</option>
                                            <option value="BELUM REKAM" {{ old('status_rekam', 'BELUM REKAM') == 'BELUM REKAM' ? 'selected' : '' }}>BELUM REKAM</option>
                                            <option value="SUDAH REKAM" {{ old('status_rekam') == 'SUDAH REKAM' ? 'selected' : '' }}>SUDAH REKAM</option>
                                        </select>
                                    </td>
                                    <td class="px-3 py-2.5">
                                        <input type="text" name="tag_id_card" value="{{ old('tag_id_card') }}"
                                               placeholder="Tag ID Card"
                                               class="w-full px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-xs bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══ DATA KELAHIRAN ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Kelahiran</span>
            </div>
            <div class="p-5 grid grid-cols-3 gap-x-5 gap-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor Akta Kelahiran</label>
                    <input type="text" name="akta_lahir" value="{{ old('akta_lahir') }}"
                           placeholder="Nomor Akta Kelahiran"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           placeholder="Tempat Lahir"
                           class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('tempat_lahir') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                    @error('tempat_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           id="tanggal_lahir" onchange="updateWajibKtp()"
                           class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('tanggal_lahir') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                    @error('tanggal_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Waktu Kelahiran</label>
                    <input type="time" name="waktu_lahir" value="{{ old('waktu_lahir') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tempat Dilahirkan</label>
                    <select name="tempat_dilahirkan"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Tempat Dilahirkan</option>
                        <option value="RS/RB" {{ old('tempat_dilahirkan') == 'RS/RB' ? 'selected' : '' }}>RS/RB</option>
                        <option value="Puskesmas" {{ old('tempat_dilahirkan') == 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                        <option value="Polindes" {{ old('tempat_dilahirkan') == 'Polindes' ? 'selected' : '' }}>Polindes</option>
                        <option value="Rumah" {{ old('tempat_dilahirkan') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                        <option value="Lainnya" {{ old('tempat_dilahirkan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Jenis Kelahiran</label>
                    <select name="jenis_kelahiran"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Jenis Kelahiran</option>
                        <option value="Tunggal" {{ old('jenis_kelahiran') == 'Tunggal' ? 'selected' : '' }}>Tunggal</option>
                        <option value="Kembar 2" {{ old('jenis_kelahiran') == 'Kembar 2' ? 'selected' : '' }}>Kembar 2</option>
                        <option value="Kembar 3" {{ old('jenis_kelahiran') == 'Kembar 3' ? 'selected' : '' }}>Kembar 3</option>
                        <option value="Kembar 4" {{ old('jenis_kelahiran') == 'Kembar 4' ? 'selected' : '' }}>Kembar 4</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Anak Ke <span class="text-gray-400 font-normal normal-case">(Isi dengan angka)</span>
                    </label>
                    <input type="number" name="kelahiran_anak_ke" value="{{ old('kelahiran_anak_ke') }}"
                           placeholder="Anak Ke-" min="1"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Penolong Kelahiran</label>
                    <select name="penolong_kelahiran"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Penolong Kelahiran</option>
                        <option value="Dokter" {{ old('penolong_kelahiran') == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="Bidan/Perawat" {{ old('penolong_kelahiran') == 'Bidan/Perawat' ? 'selected' : '' }}>Bidan/Perawat</option>
                        <option value="Dukun" {{ old('penolong_kelahiran') == 'Dukun' ? 'selected' : '' }}>Dukun</option>
                        <option value="Famili" {{ old('penolong_kelahiran') == 'Famili' ? 'selected' : '' }}>Famili</option>
                        <option value="Sendiri" {{ old('penolong_kelahiran') == 'Sendiri' ? 'selected' : '' }}>Sendiri</option>
                        <option value="Lainnya" {{ old('penolong_kelahiran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Berat Lahir <span class="text-gray-400 font-normal normal-case">( Gram )</span>
                    </label>
                    <input type="number" name="berat_lahir" value="{{ old('berat_lahir') }}"
                           placeholder="Berat Lahir" step="0.01"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Panjang Lahir <span class="text-gray-400 font-normal normal-case">( cm )</span>
                    </label>
                    <input type="number" name="panjang_lahir" value="{{ old('panjang_lahir') }}"
                           placeholder="Panjang Lahir" step="0.01"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

            </div>
        </div>

        {{-- ═══ DATA PENDIDIKAN DAN PEKERJAAN ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Pendidikan Dan Pekerjaan</span>
            </div>
            <div class="p-5 grid grid-cols-3 gap-x-5 gap-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pendidikan Dalam KK</label>
                    <select name="pendidikan_kk_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Pendidikan (Dalam KK)</option>
                        @foreach($refPendidikan as $pend)
                            <option value="{{ $pend->id }}" {{ old('pendidikan_kk_id') == $pend->id ? 'selected' : '' }}>{{ $pend->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pendidikan Sedang Ditempuh</label>
                    <select name="pendidikan_sedang_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Pendidikan</option>
                        @foreach($refPendidikan as $pend)
                            <option value="{{ $pend->id }}" {{ old('pendidikan_sedang_id') == $pend->id ? 'selected' : '' }}>{{ $pend->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pekerjaan</label>
                    <select name="pekerjaan_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach($refPekerjaan as $pek)
                            <option value="{{ $pek->id }}" {{ old('pekerjaan_id') == $pek->id ? 'selected' : '' }}>{{ $pek->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pekerja Migran</label>
                    <select name="pekerja_migran"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        <option value="0" selected>Bukan Pekerja Migran</option>
                        <option value="1" {{ old('pekerja_migran') == '1' ? 'selected' : '' }}>Pekerja Migran</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- ═══ DATA KEWARGANEGARAAN ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Kewarganegaraan</span>
            </div>
            <div class="p-5 grid grid-cols-3 gap-x-5 gap-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Status Warga Negara <span class="text-red-500">*</span>
                    </label>
                    <select name="warganegara_id"
                        class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               {{ $errors->has('warganegara_id') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                        <option value="">Pilih Warga Negara</option>
                        @foreach($refWarganegara as $wn)
                            <option value="{{ $wn->id }}" {{ old('warganegara_id', 1) == $wn->id ? 'selected' : '' }}>{{ $wn->nama }}</option>
                        @endforeach
                    </select>
                    @error('warganegara_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor Paspor</label>
                    <input type="text" name="dokumen_pasport" value="{{ old('dokumen_pasport') }}"
                           placeholder="Nomor Paspor"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tgl Berakhir Paspor</label>
                    <input type="date" name="tanggal_akhir_paspor" value="{{ old('tanggal_akhir_paspor') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

            </div>
        </div>

        {{-- ═══ DATA ORANG TUA ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Orang Tua</span>
            </div>
            <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">NIK Ayah</label>
                    <input type="text" name="nik_ayah" id="nik_ayah" value="{{ old('nik_ayah') }}"
                           placeholder="Nomor NIK Ayah" maxlength="16"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                           placeholder="Nama Ayah"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">NIK Ibu</label>
                    <input type="text" name="nik_ibu" id="nik_ibu" value="{{ old('nik_ibu') }}"
                           placeholder="Nomor NIK Ibu" maxlength="16"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Nama Ibu <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                           placeholder="Nama Ibu"
                           class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama_ibu') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                    @error('nama_ibu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

            </div>
        </div>

        {{-- ═══ DATA PERKAWINAN ═══ --}}
        <div class="border-b border-gray-100 dark:border-slate-700">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data Perkawinan</span>
            </div>
            <div class="p-5 grid grid-cols-3 gap-x-5 gap-y-4">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Status Perkawinan <span class="text-red-500">*</span>
                    </label>
                    <select name="status_kawin_id" id="status_kawin_id"
                        class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                               {{ $errors->has('status_kawin_id') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                        <option value="">Pilih Status Perkawinan</option>
                        @foreach($refStatusKawin as $sk)
                            <option value="{{ $sk->id }}" {{ old('status_kawin_id') == $sk->id ? 'selected' : '' }}>{{ $sk->nama }}</option>
                        @endforeach
                    </select>
                    @error('status_kawin_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@else<p class="text-gray-400 text-xs mt-1">Wajib diisi</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        No. Akta Nikah / Perkawinan
                    </label>
                    <input type="text" name="akta_perkawinan" value="{{ old('akta_perkawinan') }}"
                           placeholder="Nomor Akta Perkawinan"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Tanggal Perkawinan
                        <span class="text-red-500 font-normal normal-case text-[10px]">(Wajib diisi apabila status KAWIN)</span>
                    </label>
                    <input type="date" name="tanggal_perkawinan" value="{{ old('tanggal_perkawinan') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Akta Perceraian</label>
                    <input type="text" name="akta_perceraian" value="{{ old('akta_perceraian') }}"
                           placeholder="Akta Perceraian"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                        Tanggal Perceraian
                        <span class="text-red-500 font-normal normal-case text-[10px]">(Wajib diisi apabila status CERAI)</span>
                    </label>
                    <input type="date" name="tanggal_perceraian" value="{{ old('tanggal_perceraian') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>

            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-slate-800/60">
            <a href="{{ route('admin.keluarga.show', $keluarga) }}"
               class="inline-flex items-center gap-2 px-5 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700
                      hover:bg-red-50 hover:border-red-300 text-gray-600 dark:text-slate-300 hover:text-red-600
                      rounded-lg font-semibold text-sm transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-7 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold text-sm transition-all shadow-sm hover:shadow-md focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Anggota
            </button>
        </div>

    </div>{{-- end card kanan --}}
</div>{{-- end 2 card --}}

</form>

{{-- MODAL KAMERA --}}
<div id="modal-kamera"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
            <span class="font-semibold text-gray-800 dark:text-slate-200 text-sm">Ambil Foto dari Kamera</span>
            <button type="button" onclick="tutupKamera()"
                    class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="relative bg-black">
            <video id="video-kamera" autoplay playsinline class="w-full" style="max-height:320px;object-fit:cover;"></video>
        </div>
        <canvas id="canvas-kamera" class="hidden"></canvas>
        <div id="kamera-error" class="hidden px-5 py-3 bg-red-50 border-b border-red-100">
            <p class="text-sm text-red-600 text-center">Kamera tidak dapat diakses.</p>
        </div>
        <div class="flex gap-3 p-4">
            <button type="button" onclick="tutupKamera()"
                    class="flex-1 px-4 py-2.5 border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 rounded-lg font-semibold text-sm transition-all">Batal</button>
            <button type="button" onclick="ambilFoto()"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
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
            reader.onload = e => { document.getElementById('preview-foto').src = e.target.result; };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Validasi angka saja
    ['nik', 'nik_ayah', 'nik_ibu'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').substring(0, 16);
        });
    });

    // Update label Wajib KTP otomatis berdasarkan tanggal lahir
    function updateWajibKtp() {
        const tgl = document.getElementById('tanggal_lahir')?.value;
        const label = document.getElementById('label-wajib-ktp');
        if (!label || !tgl) return;
        const umur = Math.floor((new Date() - new Date(tgl)) / (365.25 * 24 * 60 * 60 * 1000));
        if (umur >= 17) {
            label.textContent = 'WAJIB KTP';
            label.className = 'font-semibold text-emerald-600 dark:text-emerald-400';
        } else {
            label.textContent = 'BELUM WAJIB';
            label.className = 'font-semibold text-gray-400 dark:text-slate-500';
        }
    }

    // Kamera
    let streamKamera = null;
    async function bukaKamera() {
        const modal = document.getElementById('modal-kamera');
        const video = document.getElementById('video-kamera');
        modal.classList.remove('hidden'); modal.classList.add('flex');
        try {
            streamKamera = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
            video.srcObject = streamKamera;
        } catch { document.getElementById('kamera-error').classList.remove('hidden'); }
    }
    function tutupKamera() {
        const modal = document.getElementById('modal-kamera');
        const video = document.getElementById('video-kamera');
        if (streamKamera) { streamKamera.getTracks().forEach(t => t.stop()); streamKamera = null; }
        video.srcObject = null;
        modal.classList.add('hidden'); modal.classList.remove('flex');
    }
    function ambilFoto() {
        const video = document.getElementById('video-kamera');
        const canvas = document.getElementById('canvas-kamera');
        const preview = document.getElementById('preview-foto');
        const inputFoto = document.getElementById('input-foto');
        if (!streamKamera) return;
        canvas.width = video.videoWidth || 640; canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        ctx.translate(canvas.width, 0); ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        preview.src = canvas.toDataURL('image/jpeg', 0.92);
        canvas.toBlob(blob => {
            const file = new File([blob], 'foto-kamera.jpg', { type: 'image/jpeg' });
            const dt = new DataTransfer(); dt.items.add(file); inputFoto.files = dt.files;
        }, 'image/jpeg', 0.92);
        tutupKamera();
    }
    document.getElementById('modal-kamera')?.addEventListener('click', e => {
        if (e.target === document.getElementById('modal-kamera')) tutupKamera();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupKamera(); });

    // Init
    updateWajibKtp();
</script>
@endpush

@endsection