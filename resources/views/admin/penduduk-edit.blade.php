@extends('layouts.admin')

@section('title', 'Edit Penduduk')

@section('content')

    {{-- ══ PAGE HEADER ══ --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Biodata Penduduk</h2>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Formulir perubahan data penduduk</p>
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
            <span class="text-gray-600 dark:text-slate-300 font-medium">Ubah Biodata</span>
        </nav>
    </div>

    <form method="POST" action="{{ route('admin.penduduk.update', $penduduk) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex items-start gap-5">

            {{-- KOLOM KIRI: Foto --}}
            <div
                class="w-52 flex-shrink-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden p-5 flex flex-col gap-3">
                <div
                    class="rounded-lg overflow-hidden border-2 border-gray-200 dark:border-slate-600 aspect-square bg-gray-100 dark:bg-slate-700">
                    <img id="preview-foto"
                        src="{{ $penduduk->foto_url ?? 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 200 200\'%3E%3Crect width=\'200\' height=\'200\' fill=\'%23f1f5f9\'/%3E%3Ccircle cx=\'100\' cy=\'78\' r=\'40\' fill=\'%23cbd5e1\'/%3E%3Cellipse cx=\'100\' cy=\'178\' rx=\'64\' ry=\'50\' fill=\'%23cbd5e1\'/%3E%3C/svg%3E' }}"
                        alt="{{ $penduduk->nama }}" class="w-full h-full object-cover">
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

            {{-- KOLOM KANAN: Form --}}
            <div
                class="flex-1 min-w-0 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700">

                {{-- Tombol Kembali + Tanggal Lapor --}}
                <div class="px-5 py-4 border-b border-gray-100 dark:border-slate-700 space-y-3 rounded-t-xl">
                    <a href="{{ route('admin.penduduk.show', $penduduk) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600
                      text-white text-xs font-semibold rounded-lg transition-all shadow-sm group">
                        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali Ke Detail Penduduk
                    </a>
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-semibold text-gray-600 dark:text-slate-300">Tanggal Lapor</span>
                        <input type="date" name="tgl_terdaftar"
                            value="{{ old('tgl_terdaftar', $penduduk->tgl_terdaftar?->format('Y-m-d')) }}"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                              bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                              focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
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
                            sementara: {{ old('is_nik_sementara', $penduduk->is_nik_sementara ?? false) ? 'true' : 'false' }},
                            nikVal: '{{ old('nik', $penduduk->nik) }}'
                        }">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span
                                    class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide">
                                    NIK <span class="text-red-500">*</span>
                                </span>
                                <label class="flex items-center gap-1.5 cursor-pointer select-none ml-1">
                                    <input type="checkbox" name="is_nik_sementara" id="is_nik_sementara" value="1"
                                        x-model="sementara"
                                        {{ old('is_nik_sementara', $penduduk->is_nik_sementara ?? false) ? 'checked' : '' }}
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
                                    '{{ $errors->has('nik') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}'"
                                class="w-full px-3 py-2 border rounded-lg text-sm font-mono bg-white dark:bg-slate-700
                                  text-gray-800 dark:text-slate-200 placeholder-gray-300 dark:placeholder-slate-500
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                            <div x-show="sementara">
                                <p class="text-xs text-red-500 mt-1">NIK sementara — wajib diganti dengan NIK resmi</p>
                            </div>
                            <div x-show="!sementara">
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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
                            <input type="text" name="nama" value="{{ old('nama', $penduduk->nama) }}"
                                class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                  text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kartu Keluarga + SHDK — DIUBAH: dari pivot ke FK langsung --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                No. Kartu Keluarga
                            </label>
                            @php
                                $selectedKeluargaId = old('keluarga_id', $penduduk->keluarga_id ?? '');
                                $selectedKeluargaNama = $keluarga->firstWhere('id', $selectedKeluargaId)
                                    ? $keluarga->firstWhere('id', $selectedKeluargaId)->no_kk .
                                        ($keluarga->firstWhere('id', $selectedKeluargaId)->kepalaKeluarga
                                            ? ' — ' .
                                                $keluarga->firstWhere('id', $selectedKeluargaId)->kepalaKeluarga->nama
                                            : '')
                                    : '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-keluarga" name="keluarga_id"
                                value="{{ $selectedKeluargaId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedKeluargaId }}',
                                label: '{{ addslashes($selectedKeluargaNama) }}',
                                placeholder: 'Pilih No. KK',
                                options: [
                                    @foreach ($keluarga as $kk)
                                        { value: '{{ $kk->id }}', label: '{{ addslashes($kk->no_kk . ($kk->kepalaKeluarga ? ' — ' . $kk->kepalaKeluarga->nama : '')) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-keluarga').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari No. KK..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih No. KK
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- SHDK — DIUBAH: dari hubungan_keluarga string ke kk_level FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Hubungan Dalam Keluarga (SHDK)
                            </label>
                            @php
                                $selectedShdkId = old('kk_level', $penduduk->kk_level ?? '');
                                $selectedShdkNama = $refShdk->firstWhere('id', $selectedShdkId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-shdk" name="kk_level" value="{{ $selectedShdkId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedShdkId }}',
                                label: '{{ addslashes($selectedShdkNama) }}',
                                placeholder: 'Pilih SHDK',
                                options: [
                                    @foreach ($refShdk as $shdk)
                                        { value: '{{ $shdk->id }}', label: '{{ addslashes($shdk->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-shdk').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari SHDK..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih SHDK
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            @php
                                $selectedJenisKelamin = old('jenis_kelamin', $penduduk->jenis_kelamin ?? '');
                                $selectedJenisKelaminLabel =
                                    $selectedJenisKelamin == 'L'
                                        ? 'Laki-laki'
                                        : ($selectedJenisKelamin == 'P'
                                            ? 'Perempuan'
                                            : '');
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-jenis-kelamin" name="jenis_kelamin"
                                value="{{ $selectedJenisKelamin }}">

                            <div class="relative" x-data="{
                                open: false,
                                selected: '{{ $selectedJenisKelamin }}',
                                label: '{{ addslashes($selectedJenisKelaminLabel) }}',
                                placeholder: 'Pilih Jenis Kelamin',
                                options: [
                                    { value: 'L', label: 'Laki-laki' },
                                    { value: 'P', label: 'Perempuan' }
                                ],
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-jenis-kelamin').value = opt.value;
                                    this.open = false;
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        '{{ $errors->has('jenis_kelamin') ? 'border-red-400' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500' }}'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Jenis Kelamin
                                        </li>

                                        <template x-for="opt in options" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Agama — DIUBAH: dari string ke agama_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Agama <span class="text-red-500">*</span>
                            </label>
                            @php
                                $selectedAgamaId = old('agama_id', $penduduk->agama_id ?? '');
                                $selectedAgamaNama = $refAgama->firstWhere('id', $selectedAgamaId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-agama" name="agama_id" value="{{ $selectedAgamaId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedAgamaId }}',
                                label: '{{ addslashes($selectedAgamaNama) }}',
                                placeholder: 'Pilih Agama',
                                options: [
                                    @foreach ($refAgama as $agama)
                                        { value: '{{ $agama->id }}', label: '{{ addslashes($agama->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-agama').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        '{{ $errors->has('agama_id') ? 'border-red-400' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500' }}'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari agama..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Agama
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            @error('agama_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jenis Tambah — DIUBAH: hapus 'meninggal' --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Cara Terdaftar
                            </label>
                            @php
                                $selectedJenisTambah = old('jenis_tambah', $penduduk->jenis_tambah ?? '');
                                $selectedJenisTambahLabel =
                                    $selectedJenisTambah == 'lahir'
                                        ? 'Lahir'
                                        : ($selectedJenisTambah == 'masuk'
                                            ? 'Masuk / Datang'
                                            : '');
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-jenis-tambah" name="jenis_tambah"
                                value="{{ $selectedJenisTambah }}">

                            <div class="relative" x-data="{
                                open: false,
                                selected: '{{ $selectedJenisTambah }}',
                                label: '{{ addslashes($selectedJenisTambahLabel) }}',
                                placeholder: 'Pilih Cara Terdaftar',
                                options: [
                                    { value: 'lahir', label: 'Lahir' },
                                    { value: 'masuk', label: 'Masuk / Datang' }
                                ],
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-jenis-tambah').value = opt.value;
                                    this.open = false;
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Cara Terdaftar
                                        </li>

                                        <template x-for="opt in options" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Status Penduduk — DIUBAH: dari status_hidup ke status (jenis penduduk) --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Jenis Penduduk <span class="text-red-500">*</span>
                            </label>
                            @php
                                $selectedStatus = old('status', $penduduk->status ?? '');
                                $selectedStatusLabel =
                                    $selectedStatus == 1
                                        ? 'Tetap'
                                        : ($selectedStatus == 2
                                            ? 'Tidak Tetap'
                                            : ($selectedStatus == 3
                                                ? 'Pendatang'
                                                : ''));
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-status" name="status" value="{{ $selectedStatus }}">

                            <div class="relative" x-data="{
                                open: false,
                                selected: '{{ $selectedStatus }}',
                                label: '{{ addslashes($selectedStatusLabel) }}',
                                placeholder: 'Pilih Jenis Penduduk',
                                options: [
                                    { value: '1', label: 'Tetap' },
                                    { value: '2', label: 'Tidak Tetap' },
                                    { value: '3', label: 'Pendatang' }
                                ],
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-status').value = opt.value;
                                    this.open = false;
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Jenis Penduduk
                                        </li>

                                        <template x-for="opt in options" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Tag ID Card --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tag
                                ID Card</label>
                            <input type="text" name="tag_id_card"
                                value="{{ old('tag_id_card', $penduduk->tag_id_card) }}" placeholder="Tag ID Card"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
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
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tempat
                                Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" placeholder="Kota / Kabupaten"
                                class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                  text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('tempat_lahir') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('tempat_lahir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                                Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir?->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                  text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('tanggal_lahir') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                                Peristiwa</label>
                            <input type="date" name="tgl_peristiwa"
                                value="{{ old('tgl_peristiwa', $penduduk->tgl_peristiwa?->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
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

                        {{-- DIUBAH: dari string ke pendidikan_kk_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pendidikan
                                Dalam KK</label>
                            @php
                                $selectedPendidikanId = old('pendidikan_kk_id', $penduduk->pendidikan_kk_id ?? '');
                                $selectedPendidikanNama =
                                    $refPendidikan->firstWhere('id', $selectedPendidikanId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-pendidikan" name="pendidikan_kk_id"
                                value="{{ $selectedPendidikanId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedPendidikanId }}',
                                label: '{{ addslashes($selectedPendidikanNama) }}',
                                placeholder: 'Pilih Pendidikan',
                                options: [
                                    @foreach ($refPendidikan as $pend)
                                        { value: '{{ $pend->id }}', label: '{{ addslashes($pend->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-pendidikan').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari pendidikan..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Pendidikan
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- DIUBAH: dari string ke pekerjaan_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Pekerjaan</label>
                            @php
                                $selectedPekerjaanId = old('pekerjaan_id', $penduduk->pekerjaan_id ?? '');
                                $selectedPekerjaanNama =
                                    $refPekerjaan->firstWhere('id', $selectedPekerjaanId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-pekerjaan" name="pekerjaan_id"
                                value="{{ $selectedPekerjaanId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedPekerjaanId }}',
                                label: '{{ addslashes($selectedPekerjaanNama) }}',
                                placeholder: 'Pilih Pekerjaan',
                                options: [
                                    @foreach ($refPekerjaan as $pek)
                                        { value: '{{ $pek->id }}', label: '{{ addslashes($pek->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-pekerjaan').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari pekerjaan..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Pekerjaan
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
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

                        {{-- DIUBAH: dari string ke warganegara_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Status
                                Warga Negara <span class="text-red-500">*</span></label>
                            @php
                                $selectedWarganegaraId = old('warganegara_id', $penduduk->warganegara_id ?? '');
                                $selectedWarganegaraNama =
                                    $refWarganegara->firstWhere('id', $selectedWarganegaraId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-warganegara" name="warganegara_id"
                                value="{{ $selectedWarganegaraId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedWarganegaraId }}',
                                label: '{{ addslashes($selectedWarganegaraNama) }}',
                                placeholder: 'Pilih Warga Negara',
                                options: [
                                    @foreach ($refWarganegara as $wn)
                                        { value: '{{ $wn->id }}', label: '{{ addslashes($wn->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-warganegara').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        '{{ $errors->has('warganegara_id') ? 'border-red-400' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500' }}'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari warga negara..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Warga Negara
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            @error('warganegara_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- DIUBAH: dari string ke golongan_darah_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Golongan
                                Darah</label>
                            @php
                                $selectedGolDarahId = old('golongan_darah_id', $penduduk->golongan_darah_id ?? '');
                                $selectedGolDarahNama =
                                    $refGolDarah->firstWhere('id', $selectedGolDarahId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-gol-darah" name="golongan_darah_id"
                                value="{{ $selectedGolDarahId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedGolDarahId }}',
                                label: '{{ addslashes($selectedGolDarahNama) }}',
                                placeholder: 'Pilih Golongan Darah',
                                options: [
                                    @foreach ($refGolDarah as $gd)
                                        { value: '{{ $gd->id }}', label: '{{ addslashes($gd->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-gol-darah').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari golongan darah..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Golongan Darah
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
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
                            <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $penduduk->nama_ayah) }}"
                                placeholder="Nama Lengkap Ayah"
                                class="w-full px-3 py-2 border rounded-lg text-sm
          bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
          focus:ring-2 focus:ring-emerald-400 outline-none transition-all
          {{ $errors->has('nama_ayah') ? 'border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama_ayah')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @else
                                <p class="text-gray-400 dark:text-slate-500 text-xs mt-1">Wajib diisi</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama
                                Ibu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $penduduk->nama_ibu) }}"
                                placeholder="Nama Lengkap Ibu"
                                class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700
                                  text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all
                                  {{ $errors->has('nama_ibu') ? 'border-red-400 bg-red-50' : 'border-gray-300 dark:border-slate-600' }}">
                            @error('nama_ibu')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- BARU: NIK Ayah & Ibu --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">NIK
                                Ayah</label>
                            <input type="text" name="nik_ayah" id="nik_ayah"
                                value="{{ old('nik_ayah', $penduduk->nik_ayah) }}" placeholder="16 digit NIK Ayah"
                                maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">NIK
                                Ibu</label>
                            <input type="text" name="nik_ibu" id="nik_ibu"
                                value="{{ old('nik_ibu', $penduduk->nik_ibu) }}" placeholder="16 digit NIK Ibu"
                                maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm font-mono
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
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
                        selectedDusun: '',
                        selectedRw: '',
                        selectedWilayahId: '{{ old('wilayah_id', $penduduk->wilayah_id) }}',
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
                    }" x-init="const existing = wilayahAll.find(w => w.id == selectedWilayahId);
                    if (existing) {
                        selectedDusun = existing.dusun;
                        $nextTick(() => { selectedRw = existing.rw; });
                    }">

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
                                            <option :value="dusun" x-text="dusun"
                                                :selected="dusun === selectedDusun"></option>
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
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                Sekarang</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $penduduk->alamat) }}"
                                placeholder="Jl. Contoh No. 1"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                        <div class="col-span-2">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat
                                Sebelumnya</label>
                            <input type="text" name="alamat_sebelumnya"
                                value="{{ old('alamat_sebelumnya', $penduduk->alamat_sebelumnya) }}"
                                placeholder="Alamat asal sebelumnya"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nomor
                                Telepon</label>
                            <input type="text" name="no_telp" id="no_telp"
                                value="{{ old('no_telp', $penduduk->no_telp) }}" placeholder="08xxxxxxxxxx"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $penduduk->email) }}"
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
                </div>

                {{-- ════════ DATA PERKAWINAN ════════ --}}
                <div class="border-b border-gray-100 dark:border-slate-700">
                    <div
                        class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40 px-5 py-2">
                        <span
                            class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest">Data
                            Perkawinan</span>
                    </div>
                    <div class="p-5 grid grid-cols-2 gap-x-5 gap-y-4">

                        {{-- DIUBAH: dari string ke status_kawin_id FK --}}
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Status Perkawinan <span class="text-red-500">*</span>
                            </label>
                            @php
                                $selectedStatusKawinId = old('status_kawin_id', $penduduk->status_kawin_id ?? '');
                                $selectedStatusKawinNama =
                                    $refStatusKawin->firstWhere('id', $selectedStatusKawinId)?->nama ?? '';
                            @endphp

                            {{-- Hidden input that carries the real value --}}
                            <input type="hidden" id="hidden-status-kawin" name="status_kawin_id"
                                value="{{ $selectedStatusKawinId }}">

                            <div class="relative" x-data="{
                                open: false,
                                search: '',
                                selected: '{{ $selectedStatusKawinId }}',
                                label: '{{ addslashes($selectedStatusKawinNama) }}',
                                placeholder: 'Pilih Status Perkawinan',
                                options: [
                                    @foreach ($refStatusKawin as $sk)
                                        { value: '{{ $sk->id }}', label: '{{ addslashes($sk->nama) }}' }, @endforeach
                                ],
                                get filtered() {
                                    if (!this.search) return this.options;
                                    return this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                                },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.label = opt.label;
                                    document.getElementById('hidden-status-kawin').value = opt.value;
                                    this.open = false;
                                    this.search = '';
                                    // Call the original onchange function
                                    if (typeof toggleDetailKawin === 'function') {
                                        toggleDetailKawin(opt.value);
                                    }
                                }
                            }" @click.away="open = false">

                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                                               bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                               focus:outline-none transition-colors"
                                    :class="[
                                        open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        '{{ $errors->has('status_kawin_id') ? 'border-red-400' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500' }}'
                                    ]">
                                    <span x-text="label || placeholder"
                                        :class="label ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform flex-shrink-0 ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute left-0 top-full mt-1 w-full z-50
                                            bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                            rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">

                                    {{-- Search box --}}
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari status perkawinan..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700
                                                      border border-gray-200 dark:border-slate-600 rounded
                                                      text-gray-700 dark:text-slate-200 outline-none
                                                      focus:border-emerald-500">
                                    </div>

                                    {{-- List --}}
                                    <ul class="max-h-48 overflow-y-auto py-1">
                                        {{-- Permanently-disabled placeholder row --}}
                                        <li
                                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 cursor-not-allowed select-none italic">
                                            Pilih Status Perkawinan
                                        </li>

                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors
                                                       hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                                       hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected === opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'">
                                                <span x-text="opt.label"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                            @error('status_kawin_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="detail-kawin"
                            class="{{ in_array(old('status_kawin_id', $penduduk->status_kawin_id), [2, 3, 4, 5, 6]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">No.
                                Akta Nikah / Perkawinan</label>
                            <input type="text" name="akta_perkawinan"
                                value="{{ old('akta_perkawinan', $penduduk->akta_perkawinan) }}" placeholder="Nomor akta"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>

                        <div id="detail-kawin-tgl"
                            class="{{ in_array(old('status_kawin_id', $penduduk->status_kawin_id), [2, 3, 4, 5, 6]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                                Perkawinan</label>
                            <input type="date" name="tanggal_perkawinan"
                                value="{{ old('tanggal_perkawinan', $penduduk->tanggal_perkawinan?->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>

                        <div id="detail-cerai"
                            class="{{ in_array(old('status_kawin_id', $penduduk->status_kawin_id), [4, 5]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                No. Akta Perceraian
                                <span class="font-normal normal-case text-gray-400 ml-1">(Cerai Tercatat jika diisi)</span>
                            </label>
                            <input type="text" name="akta_perceraian"
                                value="{{ old('akta_perceraian', $penduduk->akta_perceraian) }}"
                                placeholder="Nomor akta perceraian"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 placeholder-gray-300
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>

                        <div id="detail-cerai-tgl"
                            class="{{ in_array(old('status_kawin_id', $penduduk->status_kawin_id), [4, 5]) ? '' : 'hidden' }}">
                            <label
                                class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tanggal
                                Perceraian</label>
                            <input type="date" name="tanggal_perceraian"
                                value="{{ old('tanggal_perceraian', $penduduk->tanggal_perceraian?->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                  bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200
                                  focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                        </div>

                    </div>
                </div>

                {{-- ════════ TOMBOL AKSI ════════ --}}
                <div class="flex items-center justify-between px-5 py-4 bg-gray-50 dark:bg-slate-800/60">
                    <a href="{{ route('admin.penduduk.show', $penduduk) }}"
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
                        Simpan
                    </button>
                </div>

            </div>{{-- end card kanan --}}
        </div>{{-- end layout --}}

    </form>

    {{-- MODAL KAMERA --}}
    <div id="modal-kamera" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">
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
                <video id="video-kamera" autoplay playsinline class="w-full"
                    style="max-height:320px;object-fit:cover;"></video>
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

            function toggleDetailKawin(val) {
                const id = parseInt(val);
                const sudahKawin = [2, 3, 4, 5, 6].includes(id);
                const sudahCerai = [4, 5].includes(id);
                document.getElementById('detail-kawin')?.classList.toggle('hidden', !sudahKawin);
                document.getElementById('detail-kawin-tgl')?.classList.toggle('hidden', !sudahKawin);
                document.getElementById('detail-cerai')?.classList.toggle('hidden', !sudahCerai);
                document.getElementById('detail-cerai-tgl')?.classList.toggle('hidden', !sudahCerai);
            }

            // Init saat page load
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
                            facingMode: 'user'
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
