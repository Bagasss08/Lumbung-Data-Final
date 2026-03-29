{{-- MODAL: CETAK DATA PENDUDUK --}}
<div
    x-data="{
        show: false,
        sensorNik: false,
        semuaData: false,
        get urlCetak() {
            let base = '{{ route('admin.penduduk.cetak-data') }}';
            let q = new URLSearchParams({{ json_encode(request()->query()) }});
            if (this.sensorNik)  q.set('sensor_nik', '1');
            if (this.semuaData)  q.set('semua', '1');
            return base + '?' + q.toString();
        }
    }"
    @buka-modal-cetak.window="show = true"
    @keydown.escape.window="show && (show = false)"
>
    <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
        @click="show = false" style="display:none"></div>

    <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-2.5">
                    <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Cetak</h3>
                </div>
                <button @click="show = false"
                    class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">

                {{-- Info Box --}}
                <div class="rounded-xl bg-emerald-500 p-4 space-y-2">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-bold text-white">Informasi Batasan Data</span>
                    </div>
                    <p class="text-sm text-white/90 leading-relaxed">
                        <strong class="text-white">Tampilan di Layar:</strong>
                        Dibatasi maksimal <strong class="text-white">{{ request('per_page', 10) }} baris per halaman</strong>
                        untuk menjaga performa sistem. Gunakan pencarian, filter, atau paginasi untuk melihat data lainnya.
                    </p>
                    <p class="text-sm text-white/90 leading-relaxed">
                        <strong class="text-white">Opsi Cetak/Unduh Semua Data:</strong>
                        Centang untuk memproses data tanpa paginasi. Untuk dataset sangat besar (&gt;10.000 baris),
                        proses mungkin memakan waktu lama atau <em>timeout</em>.
                        Pertimbangkan menggunakan filter atau pencarian untuk mempersempit data terlebih dahulu.
                    </p>
                </div>

                {{-- Opsi Sensor NIK --}}
                <div class="flex items-start gap-3 p-3.5 rounded-lg border border-gray-200 dark:border-slate-600
                            hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors cursor-pointer"
                     @click="sensorNik = !sensorNik">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="checkbox" x-model="sensorNik"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            @click.stop>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-slate-200">Sensor NIK/No. KK</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                            Centang kotak berikut apabila NIK/No. KK ingin disensor pada hasil cetak.
                        </p>
                    </div>
                </div>

                {{-- Opsi Semua Data --}}
                <div class="flex items-start gap-3 p-3.5 rounded-lg border border-gray-200 dark:border-slate-600
                            hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors cursor-pointer"
                     @click="semuaData = !semuaData">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="checkbox" x-model="semuaData"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            @click.stop>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-slate-200">Cetak/Unduh Semua Data</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                            Memproses seluruh data dalam sistem (mungkin memerlukan waktu lebih lama).
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                <button type="button" @click="show = false"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
                <a :href="urlCetak" target="_blank" @click="show = false"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </a>
            </div>
        </div>
    </div>
</div>


{{-- MODAL: UNDUH DATA PENDUDUK --}}
<div
    x-data="{
        show: false,
        sensorNik: false,
        semuaData: false,
        get urlUnduh() {
            let base = '{{ route('admin.penduduk.export.excel') }}';
            let q = new URLSearchParams({{ json_encode(request()->query()) }});
            if (this.sensorNik)  q.set('sensor_nik', '1');
            if (this.semuaData)  q.set('semua', '1');
            return base + '?' + q.toString();
        }
    }"
    @buka-modal-unduh.window="show = true"
    @keydown.escape.window="show && (show = false)"
>
    <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-[200]"
        @click="show = false" style="display:none"></div>

    <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[201] flex items-center justify-center p-4" style="display:none">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg" @click.stop>

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-2.5">
                    <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-800 dark:text-slate-100">Unduh</h3>
                </div>
                <button @click="show = false"
                    class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">

                {{-- Info Box --}}
                <div class="rounded-xl bg-emerald-500 p-4 space-y-2">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-bold text-white">Informasi Batasan Data</span>
                    </div>
                    <p class="text-sm text-white/90 leading-relaxed">
                        <strong class="text-white">Tampilan di Layar:</strong>
                        Dibatasi maksimal <strong class="text-white">{{ request('per_page', 10) }} baris per halaman</strong>
                        untuk menjaga performa sistem. Gunakan pencarian, filter, atau paginasi untuk melihat data lainnya.
                    </p>
                    <p class="text-sm text-white/90 leading-relaxed">
                        <strong class="text-white">Opsi Cetak/Unduh Semua Data:</strong>
                        Centang untuk memproses data tanpa paginasi. Untuk dataset sangat besar (&gt;10.000 baris),
                        proses mungkin memakan waktu lama atau <em>timeout</em>.
                        Pertimbangkan menggunakan filter atau pencarian untuk mempersempit data terlebih dahulu.
                    </p>
                </div>

                {{-- Opsi Sensor NIK --}}
                <div class="flex items-start gap-3 p-3.5 rounded-lg border border-gray-200 dark:border-slate-600
                            hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors cursor-pointer"
                     @click="sensorNik = !sensorNik">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="checkbox" x-model="sensorNik"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            @click.stop>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-slate-200">Sensor NIK/No. KK</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                            Centang kotak berikut apabila NIK/No. KK ingin disensor pada hasil unduhan.
                        </p>
                    </div>
                </div>

                {{-- Opsi Semua Data --}}
                <div class="flex items-start gap-3 p-3.5 rounded-lg border border-gray-200 dark:border-slate-600
                            hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors cursor-pointer"
                     @click="semuaData = !semuaData">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="checkbox" x-model="semuaData"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-500 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                            @click.stop>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-slate-200">Cetak/Unduh Semua Data</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                            Memproses seluruh data dalam sistem (mungkin memerlukan waktu lebih lama).
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                <button type="button" @click="show = false"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
                <a :href="urlUnduh" @click="show = false"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh
                </a>
            </div>
        </div>
    </div>
</div>