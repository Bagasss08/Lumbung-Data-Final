<div class="space-y-4">
    {{-- Sasaran Program --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Sasaran Program <span class="text-red-500">*</span>
        </label>
        <div class="flex-1">
            <input type="hidden" name="sasaran" x-model="sasaran">
            <div class="relative" @click.away="sasaranOpen = false">
                <button type="button" @click="sasaranOpen = !sasaranOpen"
                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                          bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                          transition-colors focus:outline-none"
                    :class="sasaranOpen ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                    <span x-text="sasaranLabel || 'Pilih Sasaran Program'"
                        :class="sasaranLabel ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="sasaranOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="sasaranOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                    style="display:none">
                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                        <input type="text" x-model="sasaranSearch" @keydown.escape="sasaranOpen = false"
                            placeholder="Cari sasaran..."
                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                    </div>
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in filteredSasaran" :key="opt.value">
                            <li @click="chooseSasaran(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="sasaran === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                        <li x-show="filteredSasaran.length === 0"
                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center">
                            Tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>
            <p x-show="errors.sasaran" x-text="errors.sasaran"
                class="text-red-500 text-xs mt-1"></p>
        </div>
    </div>

    {{-- Nama Program --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Nama Program <span class="text-red-500">*</span>
        </label>
        <div class="flex-1">
            <input type="text" name="nama" x-model="nama"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-gray-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors"
                placeholder="Masukkan nama program bantuan">
            <p x-show="errors.nama" x-text="errors.nama"
                class="text-red-500 text-xs mt-1"></p>
            @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Keterangan
        </label>
        <div class="flex-1">
            <textarea name="keterangan" rows="3" x-model="keterangan"
                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-gray-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors resize-none"
                placeholder="Tuliskan keterangan program..."></textarea>
        </div>
    </div>

    {{-- Asal Dana --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Asal Dana
        </label>
        <div class="flex-1">
            <input type="hidden" name="asal_dana" x-model="asalDana">
            <div class="relative" @click.away="asalDanaOpen = false">
                <button type="button" @click="asalDanaOpen = !asalDanaOpen"
                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                          bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                          transition-colors focus:outline-none"
                    :class="asalDanaOpen ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                    <span x-text="asalDanaLabel || 'Pilih Asal Dana'"
                        :class="asalDanaLabel ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="asalDanaOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="asalDanaOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                    style="display:none">
                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                        <input type="text" x-model="asalDanaSearch" @keydown.escape="asalDanaOpen = false"
                            placeholder="Cari asal dana..."
                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                    </div>
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in filteredAsalDana" :key="opt.value">
                            <li @click="chooseAsalDana(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="asalDana === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                        <li x-show="filteredAsalDana.length === 0"
                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center">
                            Tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Rentang Waktu Program --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Rentang Waktu Program
        </label>
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
                <input type="date" name="tanggal_mulai" x-model="tanggalMulai"
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-gray-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors"
                    placeholder="Tanggal mulai">
            </div>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
                <input type="date" name="tanggal_selesai" x-model="tanggalSelesai"
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm text-gray-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors"
                    placeholder="Tanggal selesai">
            </div>
        </div>
    </div>

    {{-- Publikasi --}}
    <div class="flex flex-col sm:flex-row sm:items-start gap-3 py-4 border-b border-gray-100 dark:border-slate-700">
        <label class="sm:w-48 text-sm font-medium text-gray-700 dark:text-slate-300 pt-2.5">
            Publikasi
        </label>
        <div class="flex-1">
            <input type="hidden" name="publikasi" x-model="publikasi">
            <div class="relative" @click.away="publikasiOpen = false">
                <button type="button" @click="publikasiOpen = !publikasiOpen"
                    class="w-full flex items-center justify-between px-4 py-2.5 border rounded-lg text-sm cursor-pointer
                          bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                          transition-colors focus:outline-none"
                    :class="publikasiOpen ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                    <span x-text="publikasiLabel || 'Pilih Publikasi'"
                        :class="publikasiLabel ? 'text-gray-700 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" :class="publikasiOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="publikasiOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 top-full mt-1 w-full z-50 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                    style="display:none">
                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                        <input type="text" x-model="publikasiSearch" @keydown.escape="publikasiOpen = false"
                            placeholder="Cari publikasi..."
                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                    </div>
                    <ul class="max-h-48 overflow-y-auto py-1">
                        <template x-for="opt in filteredPublikasi" :key="opt.value">
                            <li @click="choosePublikasi(opt)"
                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                :class="publikasi === opt.value ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white' : 'text-gray-700 dark:text-slate-200'"
                                x-text="opt.label">
                            </li>
                        </template>
                        <li x-show="filteredPublikasi.length === 0"
                            class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center">
                            Tidak ditemukan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>