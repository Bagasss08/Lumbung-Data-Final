@extends('layouts.admin')

@section('title', 'Tambah Peserta — ' . $bantuan->nama)

@section('content')

    <div x-data="{
        openDrop: false,
        query: '',
        semuaData: {{ Js::from($penduduk) }},
        selected: null,
        penduduk: null,
        dropRect: null,

        get hasil() {
            if (!this.query.trim()) return this.semuaData;
            const q = this.query.toLowerCase();
            return this.semuaData.filter(
                p => p.nik.includes(q) || p.nama.toLowerCase().includes(q)
            );
        },

        pilih(item) {
            this.selected = item;
            this.penduduk = item;
            this.openDrop = false;
            this.query    = '';
            this.$nextTick(() => {
                document.getElementById('kartu_nik').value           = item.nik               ?? '';
                document.getElementById('kartu_nama').value          = item.nama              ?? '';
                document.getElementById('kartu_tempat_lahir').value  = item.tempat_lahir      ?? '';
                document.getElementById('kartu_tanggal_lahir').value = item.tanggal_lahir_iso ?? '';
                document.getElementById('kartu_alamat').value        = item.alamat            ?? '';
            });
        },

        batal() {
            this.selected = null;
            this.penduduk = null;
            this.query    = '';
            this.openDrop = false;
            ['kartu_nik','kartu_nama','kartu_tempat_lahir','kartu_tanggal_lahir','kartu_alamat']
                .forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
        },

        bukaDropdown() {
            if (this.selected) return;
            const btn = this.$refs.triggerBtn;
            if (btn) {
                const r = btn.getBoundingClientRect();
                this.dropRect = {
                    top:   r.bottom + window.scrollY + 4,
                    left:  r.left   + window.scrollX,
                    width: r.width,
                };
            }
            this.openDrop = true;
            this.$nextTick(() => document.getElementById('search-peserta-input')?.focus());
        },

        previewSrc: null,
        handleFile(e) {
            const f = e.target.files[0];
            if (!f) { this.previewSrc = null; return; }
            const r = new FileReader();
            r.onload = ev => this.previewSrc = ev.target.result;
            r.readAsDataURL(f);
        }
    }" @keydown.escape.window="openDrop = false">

        {{-- ── Flash ── --}}
        @if(session('error'))
        <div class="flex items-center gap-3 p-3 mb-4 bg-red-50 border border-red-200 rounded-lg">
            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
        @endif

        {{-- ── Page Header ── --}}
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-bold text-gray-700 dark:text-slate-200">Tambah Peserta Program Bantuan</h2>
                <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Tambah peserta baru untuk program {{ $bantuan->nama }}</p>
            </div>
            <nav class="flex items-center gap-1 text-xs">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Beranda</a>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.bantuan.index') }}" class="text-gray-400 hover:text-emerald-600 transition-colors">Program Bantuan</a>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('admin.bantuan.show', $bantuan) }}" class="text-gray-400 hover:text-emerald-600 transition-colors truncate max-w-[120px]">{{ $bantuan->nama }}</a>
                <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-600 font-medium">Tambah Peserta</span>
            </nav>
        </div>

        {{-- ── MAIN CARD ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-4 pt-4 pb-3 border-b border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.bantuan.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar Program Bantuan
                </a>
                <a href="{{ route('admin.bantuan.show', $bantuan) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Detail Program Bantuan
                </a>
            </div>

            {{-- ── RINCIAN PROGRAM ── --}}
            <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">Rincian Program</h3>
                <table class="w-full">
                    <tbody>
                        <tr>
                            <td class="py-1 pr-4 w-36 text-gray-500 dark:text-slate-400 text-xs">Nama Program</td>
                            <td class="py-1 pr-2 text-gray-400 w-4 text-xs">:</td>
                            <td class="py-1 text-gray-800 dark:text-slate-200 text-sm font-medium">{{ $bantuan->nama }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4 text-gray-500 dark:text-slate-400 text-xs">Sasaran Peserta</td>
                            <td class="py-1 pr-2 text-gray-400 text-xs">:</td>
                            <td class="py-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                    {{ $bantuan->sasaran == 1 ? 'bg-violet-100 text-violet-700' :
                                       ($bantuan->sasaran == 2 ? 'bg-orange-100 text-orange-700' :
                                       ($bantuan->sasaran == 3 ? 'bg-teal-100 text-teal-700' :
                                       ($bantuan->sasaran == 4 ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-500'))) }}">
                                    {{ $bantuan->sasaran_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-1 pr-4 text-gray-500 dark:text-slate-400 text-xs">Masa Berlaku</td>
                            <td class="py-1 pr-2 text-gray-400 text-xs">:</td>
                            <td class="py-1 text-gray-800 dark:text-slate-200 text-xs">
                                @if($bantuan->tanggal_mulai || $bantuan->tanggal_selesai)
                                    {{ optional($bantuan->tanggal_mulai)->format('d M Y') ?? '-' }}
                                    <span class="text-gray-400 mx-1">s/d</span>
                                    {{ optional($bantuan->tanggal_selesai)->format('d M Y') ?? '-' }}
                                @else -
                                @endif
                            </td>
                        </tr>
                        @if($bantuan->keterangan)
                        <tr>
                            <td class="py-1 pr-4 text-gray-500 dark:text-slate-400 text-xs">Keterangan</td>
                            <td class="py-1 pr-2 text-gray-400 text-xs">:</td>
                            <td class="py-1 text-gray-800 dark:text-slate-200 text-xs">{{ $bantuan->keterangan }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- ── FORM TAMBAH PESERTA ── --}}
            <div class="px-4 py-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-200 mb-3 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </span>
                    Tambah Peserta Program
                </h3>

                {{-- ── DROPDOWN CARI PENDUDUK ── --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 dark:text-slate-400 mb-1">
                        Cari NIK / Nama Penduduk <span class="text-red-500">*</span>
                    </label>
                    <div class="relative max-w-xl">
                        <button type="button"
                            x-ref="triggerBtn"
                            @click="bukaDropdown()"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors"
                            :class="openDrop
                                ? 'border-emerald-500 ring-2 ring-emerald-500/20'
                                : selected
                                    ? 'border-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 cursor-default'
                                    : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                            <span
                                :class="selected ? 'text-gray-800 dark:text-slate-200 font-medium text-sm' : 'text-gray-400 dark:text-slate-500 text-sm'"
                                x-text="selected ? selected.nama + ' (' + selected.nik + ')' : '-- Silakan Cari NIK / Nama Penduduk --'">
                            </span>
                            <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                                <span x-show="selected" @click.stop="batal()"
                                    class="text-gray-400 hover:text-red-500 transition-colors cursor-pointer text-lg leading-none">&times;</span>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                                    :class="openDrop ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>

                        <template x-teleport="body">
                            <div
                                x-show="openDrop"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                @click.outside="openDrop = false"
                                class="absolute z-[9999] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                                :style="dropRect ? `top:${dropRect.top}px; left:${dropRect.left}px; width:${dropRect.width}px;` : 'display:none'"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input
                                        type="text"
                                        id="search-peserta-input"
                                        x-model="query"
                                        placeholder="Cari NIK atau nama..."
                                        autocomplete="off"
                                        class="w-full px-3 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500 transition-colors">
                                </div>
                                <ul class="max-h-56 overflow-y-auto py-1">
                                    <template x-for="item in hasil" :key="item.id">
                                        <li @click="pilih(item)"
                                            class="flex items-start gap-2.5 px-3 py-2 cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors border-b border-gray-50 dark:border-slate-700 last:border-0">
                                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mt-0.5">
                                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-200" x-text="item.nama + ' (' + item.nik + ')'"></p>
                                                <p class="text-xs text-gray-400 dark:text-slate-500" x-text="item.alamat"></p>
                                            </div>
                                        </li>
                                    </template>
                                    <li x-show="hasil.length === 0 && query.trim() !== ''"
                                        class="px-4 py-4 text-sm text-gray-400 text-center italic">
                                        Tidak ada hasil untuk "<span x-text="query"></span>"
                                    </li>
                                    <li x-show="semuaData.length === 0"
                                        class="px-4 py-4 text-sm text-gray-400 text-center italic">
                                        Tidak ada penduduk tersedia
                                    </li>
                                </ul>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- ── TWO PANELS ── --}}
                <div x-show="!!selected"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="display:none">

                    <form method="POST" action="{{ route('admin.bantuan.peserta.store', $bantuan) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="penduduk_id" :value="selected?.id">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            {{-- LEFT: Konfirmasi Peserta --}}
                            <div class="rounded-lg border border-teal-200 dark:border-teal-800 overflow-hidden">
                                <div class="px-3 py-2 bg-teal-500 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <h4 class="text-xs font-semibold text-white uppercase tracking-wide">Konfirmasi Peserta</h4>
                                </div>
                                <div class="bg-teal-50/40 dark:bg-teal-900/10">
                                    <table class="w-full">
                                        <tbody class="divide-y divide-teal-100 dark:divide-teal-900/30">
                                            <tr>
                                                <td class="py-2 px-3 w-40 text-gray-500 text-xs font-medium">NIK Penduduk</td>
                                                <td class="py-2 pr-3 text-gray-800 font-mono text-xs font-semibold" x-text="penduduk?.nik ?? '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Nama Penduduk</td>
                                                <td class="py-2 pr-3 text-gray-800 text-xs font-semibold" x-text="penduduk?.nama ?? '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Alamat</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="penduduk?.alamat ?? '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Tempat, Tgl. Lahir</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="(penduduk?.tempat_lahir ?? '-') + ', ' + (penduduk?.tanggal_lahir ?? '-')"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Jenis Kelamin</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="penduduk?.jenis_kelamin ?? '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Umur</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="penduduk?.umur ? penduduk.umur + ' Tahun' : '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">Pendidikan</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="penduduk?.pendidikan ?? '-'"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium">WN / Agama</td>
                                                <td class="py-2 pr-3 text-gray-700 text-xs" x-text="'WNI / ' + (penduduk?.agama ?? '-')"></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-3 text-gray-500 text-xs font-medium align-top">Bantuan Aktif</td>
                                                <td class="py-2 pr-3 text-xs">
                                                    <template x-if="penduduk?.bantuan_aktif?.length">
                                                        <div class="flex flex-wrap gap-1">
                                                            <template x-for="b in penduduk.bantuan_aktif" :key="b">
                                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 text-xs font-medium" x-text="b"></span>
                                                            </template>
                                                        </div>
                                                    </template>
                                                    <template x-if="!penduduk?.bantuan_aktif?.length">
                                                        <span class="text-gray-400 italic">Tidak ada bantuan aktif</span>
                                                    </template>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- RIGHT: Identitas Pada Kartu Peserta --}}
                            <div class="rounded-lg border border-emerald-200 dark:border-emerald-800 overflow-hidden">
                                <div class="px-3 py-2 bg-emerald-500 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <h4 class="text-xs font-semibold text-white uppercase tracking-wide">Identitas Pada Kartu Peserta</h4>
                                </div>
                                <div class="p-3 space-y-3">

                                    <div>
                                        <label for="kartu_no_id" class="block text-xs font-medium text-gray-600 mb-1">Nomor Kartu Peserta</label>
                                        <input type="text" id="kartu_no_id" name="kartu_no_id" value="{{ old('kartu_no_id') }}" placeholder="Nomor Kartu Peserta"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 outline-none transition-colors @error('kartu_no_id') border-red-400 @enderror">
                                        @error('kartu_no_id')<p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Gambar Kartu Peserta</label>
                                        <div class="flex items-center gap-2">
                                            <label class="flex-1 flex items-center gap-2 px-2.5 py-1.5 border border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/50 transition-colors">
                                                <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span class="text-xs text-gray-500">Pilih gambar kartu…</span>
                                                <input type="file" name="gambar_kartu" accept="image/*" class="hidden" @change="handleFile($event)">
                                            </label>
                                            <div x-show="previewSrc" class="w-12 h-12 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0" style="display:none">
                                                <img :src="previewSrc" class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5">Kosongkan jika tidak ingin mengunggah gambar</p>
                                        @error('gambar_kartu')<p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="kartu_nik" class="block text-xs font-medium text-gray-600 mb-1">NIK <span class="text-red-500">*</span></label>
                                        <input type="text" id="kartu_nik" name="kartu_nik" value="{{ old('kartu_nik') }}" placeholder="NIK pada kartu peserta" maxlength="16"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 outline-none font-mono transition-colors @error('kartu_nik') border-red-400 @enderror">
                                        @error('kartu_nik')<p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="kartu_nama" class="block text-xs font-medium text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                                        <input type="text" id="kartu_nama" name="kartu_nama" value="{{ old('kartu_nama') }}" placeholder="Nama pada kartu peserta"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 outline-none transition-colors @error('kartu_nama') border-red-400 @enderror">
                                        @error('kartu_nama')<p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="kartu_tempat_lahir" class="block text-xs font-medium text-gray-600 mb-1">Tempat Lahir</label>
                                        <input type="text" id="kartu_tempat_lahir" name="kartu_tempat_lahir" value="{{ old('kartu_tempat_lahir') }}" placeholder="Tempat lahir"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                    </div>

                                    <div>
                                        <label for="kartu_tanggal_lahir" class="block text-xs font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                                        <input type="date" id="kartu_tanggal_lahir" name="kartu_tanggal_lahir" value="{{ old('kartu_tanggal_lahir') }}"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-colors">
                                    </div>

                                    <div>
                                        <label for="kartu_alamat" class="block text-xs font-medium text-gray-600 mb-1">Alamat</label>
                                        <textarea id="kartu_alamat" name="kartu_alamat" rows="2" placeholder="Alamat pada kartu peserta"
                                            class="w-full px-2.5 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 outline-none resize-none transition-colors">{{ old('kartu_alamat') }}</textarea>
                                    </div>

                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                                        <button type="button" @click="batal()"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Simpan
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>{{-- end grid --}}
                    </form>
                </div>{{-- end two panels --}}

            </div>{{-- end form section --}}
        </div>{{-- end main card --}}

    </div>{{-- end x-data --}}

@endsection