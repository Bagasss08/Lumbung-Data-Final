@extends('layouts.admin')

@section('title', 'Pengaturan Layanan Mandiri')

@section('content')

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Pengaturan Layanan Mandiri</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Konfigurasi tampilan dan akses Layanan Mandiri</p>
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
            <span class="text-gray-400 dark:text-slate-500">Layanan Mandiri</span>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Pengaturan</span>
        </nav>
    </div>

    {{-- ── ALERT ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-xl px-4 py-3 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-xl px-4 py-3 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.layanan-mandiri.pengaturan.update') }}"
          enctype="multipart/form-data" id="form-pengaturan">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

            {{-- ── LATAR LOGIN MANDIRI ── --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100 text-sm">Latar Login Mandiri</h3>
                </div>
                <div class="p-5">

                    {{-- Preview --}}
                    <div class="mb-3 rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 bg-gray-50 dark:bg-slate-700/40"
                         style="height: 180px; position: relative;">
                        @if($pengaturan?->latar_login && file_exists(storage_path('app/public/layanan-mandiri/' . $pengaturan->latar_login)))
                            <img id="preview-latar"
                                 src="{{ asset('storage/layanan-mandiri/' . $pengaturan->latar_login) }}"
                                 alt="Latar Login"
                                 class="w-full h-full object-cover">
                        @else
                            <div id="preview-placeholder"
                                 class="w-full h-full flex flex-col items-center justify-center text-gray-300 dark:text-slate-600 gap-2">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs">Belum ada gambar latar</span>
                            </div>
                            <img id="preview-latar" src="" alt="" class="w-full h-full object-cover" style="display:none">
                        @endif
                    </div>

                    <p class="text-xs text-orange-500 dark:text-orange-400 mb-3 italic">
                        (Kosongkan, jika latar login mandiri tidak berubah)
                    </p>

                    {{-- Upload button --}}
                    <label for="latar_login"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold rounded-lg cursor-pointer transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Unggah
                    </label>
                    <input type="file" id="latar_login" name="latar_login"
                           accept="image/*" class="hidden" onchange="previewGambar(this)">

                    @if($pengaturan?->latar_login)
                        <label class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg cursor-pointer transition-colors ml-2">
                            <input type="checkbox" name="hapus_latar" value="1" class="hidden" id="cb-hapus-latar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Latar
                        </label>
                    @endif

                    @error('latar_login')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror

                </div>
            </div>

            {{-- ── PENGATURAN DASAR ── --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100 text-sm">Pengaturan Dasar</h3>
                </div>
                <div class="p-5">
                    <table class="w-full text-sm">
                        <tbody>
                            {{-- Layanan Mandiri aktif/tidak --}}
                            <tr class="border-b border-gray-50 dark:border-slate-700">
                                <td class="py-3 pr-4 text-gray-600 dark:text-slate-300 font-medium w-48">
                                    Layanan Mandiri
                                </td>
                                <td class="py-3 pr-4 w-6 text-gray-400">:</td>
                                <td class="py-3">
                                    <div x-data="selectDropdown('aktif', '{{ $pengaturan?->aktif ?? 'Ya' }}', [
                                        { value: 'Ya', label: 'Ya' },
                                        { value: 'Tidak', label: 'Tidak' },
                                    ])" class="relative w-32">
                                        <button type="button" @click="open = !open" @click.away="open = false"
                                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 transition-colors"
                                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform ml-1" :class="open ? 'rotate-180' : ''"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        <input type="hidden" :name="fieldName" :value="selected">
                                        <div x-show="open" x-transition
                                            class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                            style="display:none">
                                            <ul class="py-1">
                                                <template x-for="opt in options" :key="opt.value">
                                                    <li @click="choose(opt)"
                                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                        :class="selected === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                                        x-text="opt.label"></li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pl-4 text-xs text-gray-400 dark:text-slate-500">
                                    Apakah layanan mandiri ditampilkan atau tidak
                                </td>
                            </tr>

                            {{-- Tampilkan Pendaftaran --}}
                            <tr class="border-b border-gray-50 dark:border-slate-700">
                                <td class="py-3 pr-4 text-gray-600 dark:text-slate-300 font-medium">
                                    Tampilkan Pendaftaran
                                </td>
                                <td class="py-3 pr-4 text-gray-400">:</td>
                                <td class="py-3">
                                    <div x-data="selectDropdown('tampilkan_pendaftaran', '{{ $pengaturan?->tampilkan_pendaftaran ?? 'Tidak' }}', [
                                        { value: 'Ya', label: 'Ya' },
                                        { value: 'Tidak', label: 'Tidak' },
                                    ])" class="relative w-32">
                                        <button type="button" @click="open = !open" @click.away="open = false"
                                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 transition-colors"
                                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform ml-1" :class="open ? 'rotate-180' : ''"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        <input type="hidden" :name="fieldName" :value="selected">
                                        <div x-show="open" x-transition
                                            class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                            style="display:none">
                                            <ul class="py-1">
                                                <template x-for="opt in options" :key="opt.value">
                                                    <li @click="choose(opt)"
                                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                        :class="selected === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                                        x-text="opt.label"></li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pl-4 text-xs text-gray-400 dark:text-slate-500">
                                    Aktifkan / Nonaktifkan Pendaftaran Layanan Mandiri
                                </td>
                            </tr>

                            {{-- Tampilkan E-KTP Login --}}
                            <tr>
                                <td class="py-3 pr-4 text-gray-600 dark:text-slate-300 font-medium">
                                    Login dengan E-KTP
                                </td>
                                <td class="py-3 pr-4 text-gray-400">:</td>
                                <td class="py-3">
                                    <div x-data="selectDropdown('tampilkan_ektp', '{{ $pengaturan?->tampilkan_ektp ?? 'Tidak' }}', [
                                        { value: 'Ya', label: 'Ya' },
                                        { value: 'Tidak', label: 'Tidak' },
                                    ])" class="relative w-32">
                                        <button type="button" @click="open = !open" @click.away="open = false"
                                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 transition-colors"
                                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                                            <svg class="w-4 h-4 text-gray-400 transition-transform ml-1" :class="open ? 'rotate-180' : ''"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                        <input type="hidden" :name="fieldName" :value="selected">
                                        <div x-show="open" x-transition
                                            class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                            style="display:none">
                                            <ul class="py-1">
                                                <template x-for="opt in options" :key="opt.value">
                                                    <li @click="choose(opt)"
                                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                        :class="selected === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                                        x-text="opt.label"></li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 pl-4 text-xs text-gray-400 dark:text-slate-500">
                                    Tampilkan tombol Login dengan E-KTP
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── ACTION BUTTONS ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 px-5 py-4 mb-5">
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </form>

    {{-- ── PINTASAN ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-5 py-3.5 border-b border-gray-100 dark:border-slate-700">
            <h3 class="font-semibold text-gray-800 dark:text-slate-100 text-sm">Pintasan</h3>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Pendaftar --}}
            <a href="{{ route('admin.layanan-mandiri.pendaftar.index') }}"
               class="flex items-center justify-between p-4 rounded-xl text-white transition-all hover:opacity-90 hover:shadow-lg"
               style="background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%)">
                <div>
                    <div class="font-bold text-base">Pendaftar</div>
                    <div class="text-xs text-white/80 mt-0.5">Lihat Pengaturan →</div>
                </div>
                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </a>

            {{-- Pengaturan Surat (contoh pintasan) --}}
            <a href="#"
               class="flex items-center justify-between p-4 rounded-xl text-white transition-all hover:opacity-90 hover:shadow-lg"
               style="background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%)">
                <div>
                    <div class="font-bold text-base">Pengaturan Surat</div>
                    <div class="text-xs text-white/80 mt-0.5">Lihat Pengaturan →</div>
                </div>
                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </a>

            {{-- Syarat Surat --}}
            <a href="#"
               class="flex items-center justify-between p-4 rounded-xl text-white transition-all hover:opacity-90 hover:shadow-lg"
               style="background: linear-gradient(135deg, #00bcd4 0%, #0097a7 100%)">
                <div>
                    <div class="font-bold text-base">Syarat Surat</div>
                    <div class="text-xs text-white/80 mt-0.5">Lihat Pengaturan →</div>
                </div>
                <svg class="w-8 h-8 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </a>

        </div>
    </div>

    <script>
        // Reusable Alpine.js dropdown factory
        function selectDropdown(name, initial, opts) {
            return {
                fieldName: name,
                open: false,
                selected: initial,
                options: opts,
                get label() {
                    return this.options.find(o => o.value === this.selected)?.label ?? initial;
                },
                choose(opt) {
                    this.selected = opt.value;
                    this.open = false;
                }
            };
        }

        // Image preview
        function previewGambar(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-latar');
                const placeholder = document.getElementById('preview-placeholder');
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }

        // Hapus latar checkbox toggle
        const cbHapus = document.getElementById('cb-hapus-latar');
        if (cbHapus) {
            cbHapus.closest('label').addEventListener('click', function(e) {
                e.preventDefault();
                cbHapus.checked = !cbHapus.checked;
                this.style.opacity = cbHapus.checked ? '0.7' : '1';
                this.querySelector('svg').style.color = cbHapus.checked ? '#fff' : '';
                this.innerHTML = cbHapus.checked
                    ? this.innerHTML.replace('Hapus Latar', '✓ Hapus Latar')
                    : this.innerHTML.replace('✓ Hapus Latar', 'Hapus Latar');
            });
        }
    </script>

@endsection