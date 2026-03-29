@extends('layouts.admin')

@section('title', 'Ubah Anggota Lembaga')

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Ubah Anggota Lembaga</h2>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Formulir perubahan data anggota lembaga desa</p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.lembaga-desa.index') }}"
                class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Daftar Lembaga
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.lembaga-desa.show', $lembaga->id) }}"
                class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                {{ $lembaga->nama }}
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Ubah Anggota</span>
        </nav>
    </div>

    <form action="{{ route('admin.lembaga-desa.anggota.update', [$lembaga->id, $anggota->id]) }}"
          method="POST" id="formEdit">
        @csrf
        @method('PUT')

        <div class="flex items-start gap-5">

            {{-- ══ KOLOM KIRI: Foto ══ --}}
            <div class="w-52 flex-shrink-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden p-5 flex flex-col gap-3">
                <div class="rounded-lg overflow-hidden border-2 border-gray-200 dark:border-slate-600 aspect-square bg-gray-100 dark:bg-slate-700">
                    @if(!empty($anggota->penduduk->foto))
                        <img src="{{ asset('storage/' . $anggota->penduduk->foto) }}"
                             id="preview-foto"
                             alt="Foto Anggota" class="w-full h-full object-cover">
                    @else
                        <img id="preview-foto"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Crect width='200' height='200' fill='%23f1f5f9'/%3E%3Ccircle cx='100' cy='78' r='40' fill='%23cbd5e1'/%3E%3Cellipse cx='100' cy='178' rx='64' ry='50' fill='%23cbd5e1'/%3E%3C/svg%3E"
                             alt="Foto Anggota" class="w-full h-full object-cover">
                    @endif
                </div>
                <label for="input-foto"
                    class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                      bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg cursor-pointer transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Ganti Foto
                </label>
                <input type="file" id="input-foto" name="foto" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">
                <button type="button" onclick="bukaKamera()"
                    class="flex items-center justify-center gap-1.5 w-full px-3 py-2
                       bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kamera
                </button>
                <p class="text-xs text-gray-400 dark:text-slate-500 text-center">JPG / PNG · Maks 2 MB</p>
                <p class="text-xs text-gray-400 dark:text-slate-500 text-center -mt-2">Kosongkan jika tidak diubah</p>
            </div>

            {{-- ══ KOLOM KANAN: Form ══ --}}
            <div class="flex-1 min-w-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">

                {{-- Tombol Kembali --}}
                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <a href="{{ route('admin.lembaga-desa.anggota.index', $lembaga->id) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600
                      text-white text-xs font-semibold rounded-lg transition-all shadow-sm group">
                        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali Ke Daftar Anggota Lembaga
                    </a>
                </div>

                {{-- ════════ DATA ANGGOTA ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div class="bg-cyan-50 dark:bg-cyan-900/20 border-b border-cyan-100 dark:border-cyan-800/40 px-5 py-2">
                        <span class="text-xs font-bold text-cyan-700 dark:text-cyan-400 uppercase tracking-widest">Data Anggota</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- Nama Anggota (Penduduk select) --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nama Anggota <span class="text-red-500">*</span>
                            </label>
                            <select name="penduduk_id" id="penduduk_id" required
                                    onchange="isiDataPenduduk(this)"
                                    class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                      text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-cyan-400 outline-none transition-all
                                      {{ $errors->has('penduduk_id') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Penduduk</option>
                                @foreach($penduduk as $p)
                                    <option value="{{ $p->id }}"
                                            data-tempat="{{ strtoupper($p->tempat_lahir) }}"
                                            data-tgl="{{ strtoupper(\Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d F Y')) }}"
                                            data-umur="{{ \Carbon\Carbon::parse($p->tanggal_lahir)->age }} TAHUN"
                                            data-alamat="RT {{ $p->rt ?? '-' }} / RW {{ $p->rw ?? '-' }} - {{ strtoupper($p->dusun ?? '') }}"
                                            data-pendidikan="{{ strtoupper($p->pendidikan_kk ?? 'TIDAK/BELUM SEKOLAH') }}"
                                            data-wn="{{ $p->warganegara ?? 'WNI' }}"
                                            data-agama="{{ strtoupper($p->agama ?? '') }}"
                                            {{ old('penduduk_id', $anggota->penduduk_id) == $p->id ? 'selected' : '' }}>
                                        NIK : {{ $p->nik }} - {{ strtoupper($p->nama) }} - RT {{ $p->rt ?? '-' }} / RW {{ $p->rw ?? '-' }} - {{ strtoupper($p->dusun ?? '') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penduduk_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nomor Anggota --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Nomor Anggota
                            </label>
                            <input type="text" name="no_anggota"
                                   value="{{ old('no_anggota', $anggota->no_anggota) }}"
                                   maxlength="50"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                            <p class="text-red-400 text-xs mt-1">*Pastikan nomor anggota belum pernah dipakai.</p>
                        </div>

                        {{-- Jabatan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Jabatan <span class="text-red-500">*</span>
                            </label>
                            <select name="jabatan" required
                                    class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                      text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-cyan-400 outline-none transition-all
                                      {{ $errors->has('jabatan') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                                <option value="">Pilih Jabatan</option>
                                @foreach(['Ketua','Wakil Ketua','Sekretaris','Bendahara','Anggota'] as $jab)
                                    <option value="{{ strtoupper($jab) }}"
                                        {{ old('jabatan', $anggota->jabatan) == strtoupper($jab) ? 'selected' : '' }}>
                                        {{ strtoupper($jab) }}
                                    </option>
                                @endforeach
                                @php
                                    $stdJabatan = ['KETUA','WAKIL KETUA','SEKRETARIS','BENDAHARA','ANGGOTA'];
                                    $curJabatan = strtoupper(old('jabatan', $anggota->jabatan));
                                @endphp
                                @if($curJabatan && !in_array($curJabatan, $stdJabatan))
                                    <option value="{{ $curJabatan }}" selected>{{ $curJabatan }}</option>
                                @endif
                            </select>
                            @error('jabatan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ════════ INFO PENDUDUK (Read-only) ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div class="bg-cyan-50 dark:bg-cyan-900/20 border-b border-cyan-100 dark:border-cyan-800/40 px-5 py-2">
                        <span class="text-xs font-bold text-cyan-700 dark:text-cyan-400 uppercase tracking-widest">Info Penduduk</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- Tempat Lahir --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tempat Lahir</label>
                            <input type="text" id="info_tempat" readonly
                                   value="{{ strtoupper($anggota->penduduk->tempat_lahir ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                     bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                        </div>

                        {{-- Tanggal Lahir / Umur --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal Lahir / Umur</label>
                            <div class="flex gap-2">
                                <input type="text" id="info_tgl" readonly
                                       value="{{ $anggota->penduduk ? strtoupper(\Carbon\Carbon::parse($anggota->penduduk->tanggal_lahir)->translatedFormat('d F Y')) : '' }}"
                                       class="flex-1 px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                         bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                                <input type="text" id="info_umur" readonly
                                       value="{{ $anggota->penduduk ? \Carbon\Carbon::parse($anggota->penduduk->tanggal_lahir)->age . ' TAHUN' : '' }}"
                                       class="w-24 px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                         bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat</label>
                            <input type="text" id="info_alamat" readonly
                                   value="{{ $anggota->penduduk ? 'RT ' . ($anggota->penduduk->rt ?? '-') . ' / RW ' . ($anggota->penduduk->rw ?? '-') . ' - ' . strtoupper($anggota->penduduk->dusun ?? '') : '' }}"
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                     bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                        </div>

                        {{-- Pendidikan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pendidikan</label>
                            <input type="text" id="info_pendidikan" readonly
                                   value="{{ strtoupper($anggota->penduduk->pendidikan_kk ?? 'TIDAK/BELUM SEKOLAH') }}"
                                   class="w-full px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                     bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                        </div>

                        {{-- Warga Negara / Agama --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Warga Negara / Agama</label>
                            <div class="flex gap-2">
                                <input type="text" id="info_wn" readonly
                                       value="{{ $anggota->penduduk->warganegara ?? 'WNI' }}"
                                       class="flex-1 px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                         bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                                <input type="text" id="info_agama" readonly
                                       value="{{ strtoupper($anggota->penduduk->agama ?? '') }}"
                                       class="flex-1 px-3 py-2 border border-gray-200 dark:border-slate-600 rounded-lg text-sm
                                         bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ════════ DATA SK ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div class="bg-cyan-50 dark:bg-cyan-900/20 border-b border-cyan-100 dark:border-cyan-800/40 px-5 py-2">
                        <span class="text-xs font-bold text-cyan-700 dark:text-cyan-400 uppercase tracking-widest">Data SK</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- Nomor SK Jabatan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor SK Jabatan</label>
                            <input type="text" name="nomor_sk_jabatan"
                                   value="{{ old('nomor_sk_jabatan', $anggota->nomor_sk_jabatan) }}"
                                   placeholder="Nomor SK Jabatan" maxlength="255"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                        {{-- Masa Jabatan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Masa Jabatan</label>
                            <input type="text" name="masa_jabatan"
                                   value="{{ old('masa_jabatan', $anggota->masa_jabatan) }}"
                                   placeholder="Contoh: 6 Tahun Periode Pertama (2015 s/d 2021)"
                                   maxlength="255"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                        {{-- Nomor SK Pengangkatan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor SK Pengangkatan</label>
                            <input type="text" name="nomor_sk_pengangkatan"
                                   value="{{ old('nomor_sk_pengangkatan', $anggota->nomor_sk_pengangkatan) }}"
                                   placeholder="Nomor SK Pengangkatan" maxlength="255"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                        {{-- Tanggal SK Pengangkatan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal SK Pengangkatan</label>
                            <input type="date" name="tanggal_sk_pengangkatan"
                                   value="{{ old('tanggal_sk_pengangkatan', $anggota->tanggal_sk_pengangkatan) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                        {{-- Nomor SK Pemberhentian --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor SK Pemberhentian</label>
                            <input type="text" name="nomor_sk_pemberhentian"
                                   value="{{ old('nomor_sk_pemberhentian', $anggota->nomor_sk_pemberhentian) }}"
                                   placeholder="Nomor SK Pemberhentian" maxlength="255"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                        {{-- Tanggal SK Pemberhentian --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal SK Pemberhentian</label>
                            <input type="date" name="tanggal_sk_pemberhentian"
                                   value="{{ old('tanggal_sk_pemberhentian', $anggota->tanggal_sk_pemberhentian) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                     bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                     focus:ring-2 focus:ring-cyan-400 outline-none transition-all">
                        </div>

                    </div>
                </div>

                {{-- ════════ KETERANGAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div class="bg-cyan-50 dark:bg-cyan-900/20 border-b border-cyan-100 dark:border-cyan-800/40 px-5 py-2">
                        <span class="text-xs font-bold text-cyan-700 dark:text-cyan-400 uppercase tracking-widest">Keterangan</span>
                    </div>
                    <div class="p-5">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Keterangan</label>
                        <textarea name="keterangan" rows="4" maxlength="500"
                                  placeholder="Ketua lembaga"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                    bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                    focus:ring-2 focus:ring-cyan-400 outline-none transition-all resize-vertical">{{ old('keterangan', $anggota->keterangan) }}</textarea>
                    </div>
                </div>

                {{-- ════════ TOMBOL AKSI ════════ --}}
                <div class="flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-slate-800/60">
                    <a href="{{ route('admin.lembaga-desa.anggota.index', $lembaga->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2 border border-gray-300 dark:border-slate-600
                          bg-white dark:bg-slate-700 hover:bg-red-50 hover:border-red-300 hover:text-red-600
                          text-gray-600 dark:text-slate-300 rounded-lg font-semibold text-sm transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-7 py-2 bg-emerald-600 hover:bg-emerald-700
                           text-white rounded-lg font-semibold text-sm transition-all shadow-sm hover:shadow-md
                           focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>{{-- end card kanan --}}
        </div>{{-- end layout --}}

    </form>

    {{-- MODAL KAMERA --}}
    <div id="modal-kamera" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                <span class="font-semibold text-gray-800 dark:text-slate-200 text-sm">Ambil Foto dari Kamera</span>
                <button type="button" onclick="tutupKamera()"
                    class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative bg-black">
                <video id="video-kamera" autoplay playsinline class="w-full" style="max-height:320px;object-fit:cover;"></video>
                <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                    <div class="w-40 h-48 border-2 border-white/40 rounded-xl"></div>
                </div>
            </div>
            <canvas id="canvas-kamera" class="hidden"></canvas>
            <div id="kamera-error" class="hidden px-5 py-3 bg-red-50 dark:bg-red-900/20">
                <p class="text-sm text-red-600 text-center">Kamera tidak dapat diakses.</p>
            </div>
            <div class="flex gap-3 p-4">
                <button type="button" onclick="tutupKamera()"
                    class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-600 dark:text-slate-300 rounded-lg font-semibold text-sm transition-all">Batal</button>
                <button type="button" onclick="ambilFoto()"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold text-sm transition-all">
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
            // Auto-fill read-only fields saat penduduk dipilih
            function isiDataPenduduk(sel) {
                const opt = sel.options[sel.selectedIndex];
                document.getElementById('info_tempat').value     = opt.dataset.tempat     ?? '';
                document.getElementById('info_tgl').value        = opt.dataset.tgl        ?? '';
                document.getElementById('info_umur').value       = opt.dataset.umur       ?? '';
                document.getElementById('info_alamat').value     = opt.dataset.alamat     ?? '';
                document.getElementById('info_pendidikan').value = opt.dataset.pendidikan ?? '';
                document.getElementById('info_wn').value         = opt.dataset.wn         ?? '';
                document.getElementById('info_agama').value      = opt.dataset.agama      ?? '';
            }

            // Preview foto sebelum upload
            function previewFoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const preview = document.getElementById('preview-foto');
                        if (preview) preview.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Kamera
            let streamKamera = null;
            async function bukaKamera() {
                const modal  = document.getElementById('modal-kamera');
                const video  = document.getElementById('video-kamera');
                const errBox = document.getElementById('kamera-error');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                errBox.classList.add('hidden');
                try {
                    streamKamera = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
                    video.srcObject = streamKamera;
                } catch (err) {
                    errBox.classList.remove('hidden');
                }
            }

            function tutupKamera() {
                const modal = document.getElementById('modal-kamera');
                const video = document.getElementById('video-kamera');
                if (streamKamera) { streamKamera.getTracks().forEach(t => t.stop()); streamKamera = null; }
                video.srcObject = null;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            function ambilFoto() {
                const video    = document.getElementById('video-kamera');
                const canvas   = document.getElementById('canvas-kamera');
                const inputFoto = document.getElementById('input-foto');
                if (!streamKamera) return;
                canvas.width  = video.videoWidth  || 640;
                canvas.height = video.videoHeight || 480;
                const ctx = canvas.getContext('2d');
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(blob => {
                    const file = new File([blob], 'foto-kamera.jpg', { type: 'image/jpeg' });
                    const dt   = new DataTransfer();
                    dt.items.add(file);
                    inputFoto.files = dt.files;
                    // Update preview jika ada img tag
                    const preview = document.getElementById('preview-foto');
                    if (preview) preview.src = canvas.toDataURL('image/jpeg', 0.92);
                }, 'image/jpeg', 0.92);
                tutupKamera();
            }

            document.getElementById('modal-kamera')?.addEventListener('click', e => {
                if (e.target === document.getElementById('modal-kamera')) tutupKamera();
            });
            document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupKamera(); });
        </script>
    @endpush

@endsection