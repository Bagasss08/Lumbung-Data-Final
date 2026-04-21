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
    class="fixed inset-0 z-[9990] flex items-center justify-center bg-black/50 backdrop-blur-sm"
    style="display:none">

    <div
        @click.away="show = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-2xl mx-4 flex flex-col"
        style="max-height:90vh">

        {{-- ── HEADER ── --}}
        <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-t-2xl flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white leading-tight">Tambah Anggota Keluarga</h3>
                    <p class="text-xs text-emerald-100 mt-0.5" x-text="noKk ? 'No. KK: ' + noKk : 'Dari penduduk yang sudah ada'"></p>
                </div>
            </div>
            <button @click="show = false"
                class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-colors flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- ── BODY (scrollable) ── --}}
        <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5">

            {{-- Tabel Anggota Saat Ini --}}
            <div>
                <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    Anggota Saat Ini
                </p>
                <div class="rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-800/40">
                                <th class="px-4 py-2.5 text-left text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider w-10">NO</th>
                                <th class="px-4 py-2.5 text-left text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">NIK</th>
                                <th class="px-4 py-2.5 text-left text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">NAMA</th>
                                <th class="px-4 py-2.5 text-left text-xs font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">HUBUNGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            <template x-if="anggota.length === 0">
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center">
                                        <p class="text-sm text-gray-400 dark:text-slate-500 italic">Belum ada anggota keluarga</p>
                                    </td>
                                </tr>
                            </template>
                            <template x-for="(ang, idx) in anggota" :key="idx">
                                <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors">
                                    <td class="px-4 py-2.5 text-gray-500 dark:text-slate-400 tabular-nums text-xs" x-text="idx + 1"></td>
                                    <td class="px-4 py-2.5 font-mono text-xs text-gray-600 dark:text-slate-300" x-text="ang.nik"></td>
                                    <td class="px-4 py-2.5 font-semibold text-gray-800 dark:text-slate-200 text-xs" x-text="ang.nama"></td>
                                    <td class="px-4 py-2.5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold"
                                            :class="ang.hubungan === 'KEPALA KELUARGA' || ang.hubungan === 'Kepala Keluarga'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                                : 'bg-teal-50 text-teal-600 dark:bg-teal-900/20 dark:text-teal-400'"
                                            x-text="ang.hubungan">
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-emerald-200 dark:via-slate-600 to-transparent"></div>
                <span class="text-[10px] font-bold text-emerald-500 dark:text-emerald-400 uppercase tracking-widest">
                    Tambah Dari Penduduk
                </span>
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-emerald-200 dark:via-slate-600 to-transparent"></div>
            </div>

            {{-- Info Box --}}
            <div class="flex items-start gap-2.5 px-3.5 py-2.5 bg-teal-50 dark:bg-teal-900/20 rounded-xl border border-teal-100 dark:border-teal-800/40">
                <svg class="w-4 h-4 text-teal-500 dark:text-teal-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs text-teal-700 dark:text-teal-300 leading-relaxed">
                    Daftar hanya menampilkan <strong>penduduk aktif</strong> yang belum terdaftar di KK manapun (penduduk lepas).
                </p>
            </div>

            {{-- Dropdown Cari Penduduk --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                    NIK / Nama Penduduk <span class="text-red-500">*</span>
                </label>
                <div class="relative" @click.away="openPendudukDrop = false">
                    <button type="button" @click="openPendudukDrop = !openPendudukDrop"
                        class="w-full flex items-center justify-between px-3 py-2.5 border rounded-xl text-sm bg-white dark:bg-slate-700 focus:outline-none transition-all"
                        :class="openPendudukDrop
                            ? 'border-emerald-500 ring-2 ring-emerald-500/20 shadow-sm'
                            : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                        <span class="truncate"
                            :class="selectedLabel ? 'text-gray-800 dark:text-slate-200 font-medium' : 'text-gray-400 dark:text-slate-500'"
                            x-text="selectedLabel || '-- Silakan Cari NIK / Nama Penduduk --'"></span>
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 ml-2 transition-transform"
                            :class="openPendudukDrop ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openPendudukDrop"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-full z-[300] bg-white dark:bg-slate-800 border border-emerald-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700 bg-emerald-50/50">
                            <input type="text" x-model="searchPenduduk"
                                @keydown.escape="openPendudukDrop = false"
                                placeholder="Cari NIK atau nama penduduk..."
                                class="w-full px-3 py-1.5 text-sm bg-white dark:bg-slate-700 border border-emerald-200 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">
                        </div>
                        <ul class="max-h-52 overflow-y-auto py-1">
                            <template x-for="p in filteredPenduduk" :key="p.id">
                                <li @click="pilihPenduduk(p)"
                                    class="flex items-center gap-3 px-3 py-2.5 text-sm cursor-pointer transition-colors"
                                    :class="selectedId === p.id
                                        ? 'bg-emerald-500 text-white'
                                        : 'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700'">
                                    <span class="font-mono text-xs opacity-75 flex-shrink-0" x-text="p.nik"></span>
                                    <span class="font-medium" x-text="p.nama"></span>
                                </li>
                            </template>
                            <li x-show="filteredPenduduk.length === 0"
                                class="px-3 py-5 text-xs text-gray-400 dark:text-slate-500 italic text-center">
                                Tidak ada penduduk tanpa No. KK
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Dropdown Hubungan Keluarga --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                    Hubungan Keluarga <span class="text-red-500">*</span>
                </label>
                <div class="relative" @click.away="openHubunganDrop = false">
                    <button type="button" @click="openHubunganDrop = !openHubunganDrop"
                        class="w-full flex items-center justify-between px-3 py-2.5 border rounded-xl text-sm bg-white dark:bg-slate-700 focus:outline-none transition-all"
                        :class="openHubunganDrop
                            ? 'border-emerald-500 ring-2 ring-emerald-500/20 shadow-sm'
                            : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                        <span
                            :class="selectedHubunganLabel ? 'text-gray-800 dark:text-slate-200 font-medium' : 'text-gray-400 dark:text-slate-500'"
                            x-text="selectedHubunganLabel || '-- Silakan Cari Hubungan Keluarga --'"></span>
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0 ml-2 transition-transform"
                            :class="openHubunganDrop ? 'rotate-180' : ''"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openHubunganDrop"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-full z-[300] bg-white dark:bg-slate-800 border border-emerald-200 dark:border-slate-600 rounded-xl shadow-xl overflow-hidden"
                        style="display:none">
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="s in (window.shdkList || [])" :key="s.id">
                                <li @click="pilihHubungan(s)"
                                    class="px-3 py-2.5 text-sm cursor-pointer transition-colors"
                                    :class="selectedHubunganId == s.id
                                        ? 'bg-emerald-500 text-white'
                                        : 'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700'"
                                    x-text="s.nama">
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── FOOTER ── --}}
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/80 dark:bg-slate-800/80 flex-shrink-0 rounded-b-2xl">
            <button type="button" @click="show = false"
                class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Tutup
            </button>
            <button type="button" @click="submit()"
                class="inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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