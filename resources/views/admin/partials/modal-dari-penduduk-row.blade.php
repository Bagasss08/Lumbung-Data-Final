{{-- ══════════════════════════════════════════════════════════════
     MODAL: DARI PENDUDUK SUDAH ADA — Per-baris (index keluarga)
     Simpan di: resources/views/admin/partials/modal-dari-penduduk-row.blade.php
     Include di dalam div x-data utama pada keluarga/index.blade.php
══════════════════════════════════════════════════════════════ --}}

{{-- JS: data pendudukLepas & SHDK (variabel sudah tersedia dari controller) --}}
<script>
    window.pendudukLepas = [
        @foreach ($pendudukLepas as $p)
            { id: {{ $p->id }}, nik: "{{ $p->nik }}", nama: "{{ addslashes($p->nama) }}" },
        @endforeach
    ];
    window.shdkList = [
        @foreach ($refShdk as $s)
            { id: {{ $s->id }}, nama: "{{ addslashes($s->nama) }}" },
        @endforeach
    ];
    {{-- Base URL untuk form action dinamis berdasarkan kkId yang diklik --}}
    window.kkAnggotaDariPendudukBaseUrl = "{{ url('admin/keluarga') }}";
</script>

{{-- ════════════ MODAL ════════════ --}}
<div
    x-data="{
        show: false,
        kkId: null,
        noKk: '',
        anggota: [],

        selectedId: '',
        selectedLabel: '',
        selectedHubunganId: '',

        openPendudukDrop: false,
        openHubunganDrop: false,
        searchPenduduk: '',

        get filteredPenduduk() {
            const list = window.pendudukLepas || [];
            if (!this.searchPenduduk) return list;
            const q = this.searchPenduduk.toLowerCase();
            return list.filter(p =>
                p.nik.includes(q) || p.nama.toLowerCase().includes(q)
            );
        },
        get selectedHubunganLabel() {
            if (!this.selectedHubunganId) return '';
            const found = (window.shdkList || []).find(s => s.id == this.selectedHubunganId);
            return found ? found.nama : '';
        },
        pilihPenduduk(p) {
            this.selectedId    = p.id;
            this.selectedLabel = p.nik + ' — ' + p.nama;
            this.openPendudukDrop = false;
            this.searchPenduduk   = '';
        },
        pilihHubungan(s) {
            this.selectedHubunganId = s.id;
            this.openHubunganDrop   = false;
        },
        submit() {
            if (!this.selectedId) {
                alert('Pilih penduduk terlebih dahulu.');
                return;
            }
            if (!this.selectedHubunganId) {
                alert('Pilih hubungan keluarga terlebih dahulu.');
                return;
            }
            const form = document.getElementById('form-tambah-anggota-dari-penduduk');
            form.setAttribute('action', window.kkAnggotaDariPendudukBaseUrl + '/' + this.kkId + '/anggota/dari-penduduk');
            form.querySelector('[name=penduduk_id]').value = this.selectedId;
            form.querySelector('[name=kk_level]').value    = this.selectedHubunganId;
            form.submit();
        }
    }"
    @buka-modal-dari-penduduk-row.window="
        show    = true;
        kkId    = $event.detail.kkId;
        noKk    = $event.detail.noKk  || '';
        anggota = $event.detail.anggota || [];
        selectedId = ''; selectedLabel = '';
        selectedHubunganId = '';
        searchPenduduk = '';
        openPendudukDrop = false;
        openHubunganDrop = false;
    "
    @keydown.escape.window="show && (show = false)"
    x-show="show"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @keydown.escape.window="show = false"
    style="display:none">

    {{-- Backdrop klik tutup --}}
    <div class="absolute inset-0" @click="show = false"></div>

    {{-- Modal box --}}
    <div class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden"
         style="max-height:90vh"
         @click.stop>

        {{-- ── HEADER ── --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-red-500 bg-white dark:bg-slate-800">
            <div>
                <h3 class="font-semibold text-gray-800 dark:text-slate-200 text-sm">Tambah Anggota Keluarga</h3>
                <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5"
                   x-text="noKk ? 'No. KK: ' + noKk : 'Dari penduduk yang sudah ada'"></p>
            </div>
            <button type="button" @click="show = false"
                    class="w-7 h-7 flex items-center justify-center rounded text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ── BODY (scrollable) ── --}}
        <div class="p-5 space-y-4 overflow-y-auto" style="max-height:calc(90vh - 130px)">

            {{-- Tabel Anggota Saat Ini --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-300 mb-1.5">
                    Anggota Saat Ini
                </label>
                <div class="rounded border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-8">No</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">NIK</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Hubungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            <template x-if="anggota.length === 0">
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-xs text-gray-400 dark:text-slate-500 italic">
                                        Belum ada anggota keluarga
                                    </td>
                                </tr>
                            </template>
                            <template x-for="(ang, idx) in anggota" :key="idx">
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                                    <td class="px-3 py-2 text-xs text-gray-500 dark:text-slate-400 tabular-nums" x-text="idx + 1"></td>
                                    <td class="px-3 py-2 font-mono text-xs text-gray-600 dark:text-slate-300" x-text="ang.nik"></td>
                                    <td class="px-3 py-2 text-xs font-semibold text-gray-800 dark:text-slate-200" x-text="ang.nama"></td>
                                    <td class="px-3 py-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold"
                                            :class="ang.hubungan === 'KEPALA KELUARGA' || ang.hubungan === 'Kepala Keluarga'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                                : 'bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-300'"
                                            x-text="ang.hubungan">
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Info Box --}}
            <div class="flex items-start gap-2 px-3 py-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-100 dark:border-blue-800/40 text-xs text-blue-700 dark:text-blue-300">
                <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p>Daftar hanya menampilkan <strong>penduduk aktif</strong> yang belum terdaftar di KK manapun (penduduk lepas).</p>
            </div>

            {{-- Dropdown Cari Penduduk --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-300 mb-1.5">
                    NIK / Nama Penduduk <span class="text-red-500">*</span>
                </label>
                <div class="relative" x-data="{ openDrop: false }" @click.away="openDrop = false">
                    <div @click="openPendudukDrop = !openPendudukDrop"
                         class="flex items-center justify-between w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer hover:border-emerald-400 transition-colors">
                        <span x-text="selectedLabel || '-- Silakan Cari NIK / Nama Penduduk --'"
                              :class="selectedLabel ? 'text-gray-800 dark:text-slate-100' : 'text-gray-400 dark:text-slate-500'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                             :class="openPendudukDrop ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div x-show="openPendudukDrop" x-transition
                         class="absolute left-0 top-full mt-1 w-full z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                         style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="searchPenduduk"
                                   placeholder="Cari NIK atau nama penduduk..."
                                   @keydown.escape="openPendudukDrop = false"
                                   class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-400">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="p in filteredPenduduk" :key="p.id">
                                <li @click="pilihPenduduk(p)"
                                    class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selectedId === p.id ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'">
                                    <span class="font-mono text-xs opacity-75 mr-1" x-text="p.nik"></span>
                                    <span class="font-medium" x-text="p.nama"></span>
                                </li>
                            </template>
                            <li x-show="filteredPenduduk.length === 0"
                                class="px-3 py-2 text-sm text-gray-400 dark:text-slate-500 text-center italic">
                                Tidak ada penduduk tanpa No. KK
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Dropdown Hubungan Keluarga --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-slate-300 mb-1.5">
                    Hubungan Keluarga <span class="text-red-500">*</span>
                </label>
                <div class="relative" @click.away="openHubunganDrop = false">
                    <div @click="openHubunganDrop = !openHubunganDrop"
                         class="flex items-center justify-between w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded text-sm bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 cursor-pointer hover:border-emerald-400 transition-colors">
                        <span x-text="selectedHubunganLabel || '-- Silakan Cari Hubungan Keluarga --'"
                              :class="selectedHubunganLabel ? 'text-gray-800 dark:text-slate-100' : 'text-gray-400 dark:text-slate-500'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                             :class="openHubunganDrop ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    <div x-show="openHubunganDrop" x-transition
                         class="absolute left-0 top-full mt-1 w-full z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                         style="display:none">
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="s in (window.shdkList || [])" :key="s.id">
                                <li @click="pilihHubungan(s)"
                                    class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                    :class="selectedHubunganId == s.id ? 'bg-emerald-500 text-white' : 'text-gray-700 dark:text-slate-200'"
                                    x-text="s.nama">
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── FOOTER ── --}}
        <div class="flex items-center justify-end gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
            <button type="button" @click="show = false"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup
            </button>
            <button type="button" @click="submit()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- Hidden form — action di-set dinamis oleh JS submit() --}}
<form id="form-tambah-anggota-dari-penduduk" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="penduduk_id">
    <input type="hidden" name="kk_level">
</form>