{{--
    Partial: Modal "Dari Penduduk Sudah Ada"
    Include ini di keluarga.blade.php:
    @include('admin.partials.keluarga-dari-penduduk-modal', ['pendudukLepas' => $pendudukLepas])

    Trigger dengan Alpine event:
    $dispatch('buka-modal-dari-penduduk')
--}}

<div
    x-data="{
        show: false,
        searchQuery: '',
        selectedId: '',
        selectedNama: '',
        noKk: '',
        cbSementara: false,
        generate() {
            const now = new Date();
            const dd = String(now.getDate()).padStart(2, '0');
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const yy = String(now.getFullYear()).slice(-2);
            const urut = String(Math.floor(Math.random() * 9000) + 1000);
            this.noKk = '000000' + dd + mm + yy + urut;
        },
        get filtered() {
            if (!this.searchQuery) return pendudukLepas;
            const q = this.searchQuery.toLowerCase();
            return pendudukLepas.filter(p =>
                p.nama.toLowerCase().includes(q) || p.nik.includes(q)
            );
        }
    }"
    x-init="
        $watch('cbSementara', (val) => {
            if (val) {
                if (!noKk || String(noKk).trim() === '') generate();
            } else {
                noKk = '';
            }
        });
    "
    @buka-modal-dari-penduduk.window="show = true; searchQuery = ''; selectedId = ''; selectedNama = ''; noKk = ''; cbSementara = false;"
    x-show="show"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @keydown.escape.window="show = false"
    style="display:none">

    {{-- Backdrop klik tutup --}}
    <div class="absolute inset-0" @click="show = false"></div>

    {{-- Modal box --}}
    <div class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden"
         @click.stop>

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-red-500 bg-white dark:bg-slate-800">
            <h3 class="font-semibold text-gray-800 dark:text-slate-200 text-sm">Dari Penduduk Sudah Ada</h3>
            <button type="button" @click="show = false"
                    class="w-7 h-7 flex items-center justify-center rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5 space-y-4">

            {{-- Search + Select Kepala Keluarga --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-300 mb-1.5">
                    Kepala Keluarga (dari penduduk yang tidak memiliki No. KK)
                </label>
                <div class="relative" x-data="{ openDrop: false }" @click.away="openDrop = false">
                    <div @click="openDrop = !openDrop"
                         class="flex items-center justify-between w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer hover:border-emerald-400 transition-colors">
                        <span x-text="selectedNama || '-- Silakan Cari NIK / Nama Kepala Keluarga --'"
                              :class="selectedNama ? 'text-gray-800 dark:text-slate-100' : 'text-gray-400 dark:text-slate-500'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform" :class="openDrop ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div x-show="openDrop" x-transition
                         class="absolute left-0 top-full mt-1 w-full z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                         style="display:none">
                        {{-- Search input --}}
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="searchQuery"
                                   placeholder="Cari NIK atau nama..."
                                   @keydown.escape="openDrop = false"
                                   class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-400">
                        </div>
                        {{-- List --}}
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-if="filtered.length === 0">
                                <li class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center">
                                    Tidak ada penduduk lepas
                                </li>
                            </template>
                            <template x-for="p in filtered" :key="p.id">
                                <li @click="selectedId = p.id; selectedNama = p.nama + ' (' + p.nik + ')'; openDrop = false; searchQuery = '';"
                                    class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selectedId === p.id ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'">
                                    <span class="font-medium" x-text="p.nama"></span>
                                    <span class="text-xs font-mono ml-1 opacity-75" x-text="'(' + p.nik + ')'"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Nomor KK --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-300 mb-1.5">
                    Nomor Kartu Keluarga (KK)
                    <span id="modal-label-kk-sementara"
                          x-show="cbSementara"
                          class="ml-1 text-amber-500 font-normal normal-case"
                          style="display:none">(Sementara)</span>
                </label>
                <div class="flex items-center gap-2">
                    <input type="checkbox" x-model="cbSementara"
                           class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-400 cursor-pointer flex-shrink-0"
                           title="Gunakan No. KK Sementara">
                    <input type="text" x-model="noKk"
                           :readonly="cbSementara"
                           :class="cbSementara ? 'bg-gray-50 dark:bg-slate-600 cursor-not-allowed' : 'bg-white dark:bg-slate-700'"
                           placeholder="Nomor KK" maxlength="16"
                           class="flex-1 px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm font-mono text-gray-800 dark:text-slate-200 placeholder-gray-300 focus:ring-2 focus:ring-emerald-400 outline-none transition-all">
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
            <button type="button" @click="show = false"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup
            </button>

            <form method="POST" action="{{ route('admin.keluarga.store.dari-penduduk') }}"
                  @submit.prevent="
                    if (!selectedId) { alert('Pilih penduduk terlebih dahulu'); return; }
                    if (!noKk) { alert('Nomor KK wajib diisi'); return; }
                    $el.submit();
                  ">
                @csrf
                <input type="hidden" name="kepala_keluarga_id" :value="selectedId">
                <input type="hidden" name="no_kk" :value="noKk">
                <input type="hidden" name="tgl_terdaftar" value="{{ date('Y-m-d') }}">
                {{-- wilayah_id akan diambil dari wilayah penduduk yang dipilih --}}
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </form>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    // Data penduduk lepas untuk Alpine — diinjek dari PHP
    const pendudukLepas = @json($pendudukLepas ?? []);
</script>
@endpush
@endonce