@extends('layouts.admin')

@section('title', 'Pendaftar Layanan Mandiri')

@section('content')

    <script>
        window.pendudukList = [
            @foreach ($pendudukList as $p)
                {
                    id: {{ $p->id }},
                    nik: "{{ $p->nik }}",
                    nama: "{{ addslashes($p->nama) }}"
                },
            @endforeach
        ];
    </script>
    <div x-data="{
        selectedIds: [],
        selectAll: false,
    
        showTambah: false,
        searchQuery: '',
    
        get pendudukResults() {
            const list = window.pendudukList || [];
            if (!this.searchQuery.trim()) return list;
            const q = this.searchQuery.toLowerCase();
            return list.filter(p =>
                p.nik.includes(q) || p.nama.toLowerCase().includes(q)
            );
        },
    
        selectedId: '',
        selectedNama: '',
        selectedNik: '',
    
        showResetPin: false,
        resetTarget: null,
        resetTargetNama: '',
    
        showTelepon: false,
        teleponError: '',
        teleponInputVal: '',
        teleponTarget: null,
        teleponTargetNik: '',
        teleponTargetNama: '',
        teleponTargetNilai: '',
    
        toggleAll() {
            if (this.selectAll) {
                this.selectedIds = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
            } else {
                this.selectedIds = [];
            }
        },
        toggleOne() {
            const all = Array.from(document.querySelectorAll('.row-checkbox')).map(el => el.value);
            this.selectAll = all.every(id => this.selectedIds.includes(id));
        },
    
        pilihPenduduk(item) {
            this.selectedId = item.id;
            this.selectedNama = item.nama;
            this.selectedNik = item.nik;
            this.searchQuery = '';
        },
        resetModal() {
            this.searchQuery = '';
            this.selectedId = '';
            this.selectedNama = '';
            this.selectedNik = '';
        },
        bukaResetPin(id, nama) {
            this.resetTarget = id;
            this.resetTargetNama = nama;
            this.showResetPin = true;
        },
        bukaTelepon(id, nik, nama, noTelepon) {
            this.teleponTarget = id;
            this.teleponTargetNik = nik;
            this.teleponTargetNama = nama;
            this.teleponTargetNilai = noTelepon;
            this.teleponInputVal = noTelepon;
            this.teleponError = '';
            this.showTelepon = true;
        },
    }">

        {{-- ── PAGE HEADER ── --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Pendaftar Layanan Mandiri</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola akun warga untuk aplikasi Layanan Mandiri
                </p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Pendaftar</span>
            </nav>
        </div>

        {{-- ── CARD UTAMA ── --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow:visible">

            {{-- ── TOOLBAR ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah --}}
                <button type="button" @click="showTambah = true; resetModal()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>

                {{-- Hapus Bulk --}}
                <form method="POST" action="{{ route('admin.layanan-mandiri.pendaftar.destroy', '__ID__') }}"
                    id="form-bulk-hapus">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="button" :disabled="selectedIds.length === 0"
                        @click="selectedIds.length > 0 && $dispatch('buka-modal-hapus', {
                        bulkCount: selectedIds.length,
                        onConfirm: () => document.getElementById('form-bulk-hapus').submit()
                    })"
                        :class="selectedIds.length > 0 ? 'bg-red-500 hover:bg-red-600 cursor-pointer' :
                            'bg-red-300 opacity-60 cursor-not-allowed'"
                        class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                        <span x-show="selectedIds.length > 0">(<span x-text="selectedIds.length"></span>)</span>
                    </button>
                </form>

            </div>

            {{-- ── TOOLBAR: Per-page + Search ── --}}
            <div
                class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">

                {{-- Tampilkan X entri --}}
                <form method="GET" action="{{ route('admin.layanan-mandiri.pendaftar.index') }}" id="form-per-page"
                    class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                    @foreach (request()->except('per_page', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <input type="hidden" name="per_page" id="val-per-page" value="{{ request('per_page', 10) }}">

                    <span>Tampilkan</span>

                    <div class="relative w-24" x-data="{
                        open: false,
                        selected: '{{ request('per_page', 10) }}',
                        options: [
                            { value: '10', label: '10' },
                            { value: '25', label: '25' },
                            { value: '50', label: '50' },
                            { value: '100', label: '100' },
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? '10'; },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-per-page').value = opt.value;
                            this.open = false;
                            document.getElementById('form-per-page').submit();
                        }
                    }" @click.away="open = false">
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                            <span x-text="label" class="text-gray-700 dark:text-slate-200"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-1"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                            style="display:none">
                            <ul class="py-1">
                                <template x-for="opt in options" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                            'text-gray-700 dark:text-slate-200'"
                                        x-text="opt.label"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <span>entri</span>
                </form>

                {{-- Search --}}
                <form method="GET" action="{{ route('admin.layanan-mandiri.pendaftar.index') }}"
                    class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="kata kunci pencarian" maxlength="50" @input.debounce.400ms="$el.form.submit()"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
                        <div
                            class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                            <div
                                class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                Cari berdasarkan NIK atau nama penduduk
                                <div
                                    class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            {{-- ── TABEL ── --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                            <th class="px-3 py-3 w-10">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                    class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                            </th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                                NO</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider"
                                style="min-width:112px">AKSI</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NIK</th>
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NAMA PENDUDUK</th>
                            {{-- Kolom No. Telepon (tidak ada di OpenSID asli, tambahan fitur) --}}
                            <th
                                class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                NO. TELEPON</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                TANGGAL BUAT</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                LOGIN TERAKHIR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse ($pendaftar as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors"
                                :class="selectedIds.includes('{{ $item->id }}') ? 'bg-emerald-50 dark:bg-emerald-900/10' :
                                    ''">

                                {{-- CHECKBOX --}}
                                <td class="px-3 py-3 text-center">
                                    <input type="checkbox"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer"
                                        value="{{ $item->id }}" x-model="selectedIds" @change="toggleOne()">
                                </td>

                                {{-- NO --}}
                                <td class="px-3 py-3 text-gray-500 dark:text-slate-400 tabular-nums text-sm">
                                    {{ $pendaftar->firstItem() + $index }}
                                </td>

                                {{-- AKSI --}}
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1 flex-nowrap">

                                        {{-- Reset PIN --}}
                                        <button type="button"
                                            @click="bukaResetPin({{ $item->id }}, '{{ addslashes($item->penduduk?->nama ?? '') }}')"
                                            title="Reset PIN Warga"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </button>

                                        {{-- Tambah / Ubah Telepon --}}
                                        <button type="button"
                                            @click="bukaTelepon(
                                            {{ $item->id }},
                                            '{{ addslashes($item->penduduk?->nik ?? '') }}',
                                            '{{ addslashes($item->penduduk?->nama ?? '') }}',
                                            '{{ addslashes($item->no_telepon ?? '') }}'
                                        )"
                                            title="Tambah / Ubah Nomor Telepon"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </button>

                                        {{-- Hapus --}}
                                        <button type="button" title="Hapus Pendaftar"
                                            @click="$dispatch('buka-modal-hapus', {
                                            action: '{{ route('admin.layanan-mandiri.pendaftar.destroy', $item) }}',
                                            nama: '{{ addslashes($item->penduduk?->nama ?? 'Pendaftar ini') }}'
                                        })"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>

                                {{-- NIK --}}
                                <td
                                    class="px-3 py-3 font-mono text-xs text-gray-500 dark:text-slate-400 whitespace-nowrap">
                                    {{ $item->penduduk?->nik ?? '—' }}
                                </td>

                                {{-- NAMA PENDUDUK --}}
                                <td class="px-3 py-3 font-medium text-gray-900 dark:text-slate-100 whitespace-nowrap">
                                    {{ $item->penduduk?->nama ?? '—' }}
                                </td>

                                {{-- NO. TELEPON --}}
                                <td class="px-3 py-3 whitespace-nowrap">
                                    @if ($item->no_telepon)
                                        <span
                                            class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 font-mono text-xs">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            {{ $item->no_telepon }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-slate-600 text-xs italic">Belum diisi</span>
                                    @endif
                                </td>

                                {{-- TANGGAL BUAT --}}
                                <td
                                    class="px-3 py-3 text-center text-gray-500 dark:text-slate-400 whitespace-nowrap tabular-nums">
                                    {{ $item->created_at?->format('d M Y H:i:s') ?? '—' }}
                                </td>

                                {{-- LOGIN TERAKHIR --}}
                                <td class="px-3 py-3 text-center whitespace-nowrap">
                                    @if ($item->last_login_at)
                                        <span class="text-gray-600 dark:text-slate-300 tabular-nums text-sm">
                                            {{ $item->last_login_at->format('d M Y H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-slate-500 text-sm">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div
                                            class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-emerald-300 dark:text-emerald-700" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 dark:text-slate-400 font-medium">Belum ada pendaftar
                                            layanan mandiri</p>
                                        <p class="text-xs text-gray-400 dark:text-slate-500">Klik tombol
                                            <strong>Tambah</strong> untuk mendaftarkan warga
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── PAGINATION ── --}}
            <div
                class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
                <p class="text-sm text-gray-500 dark:text-slate-400">
                    @if ($pendaftar->total() > 0)
                        Menampilkan {{ $pendaftar->firstItem() }} sampai {{ $pendaftar->lastItem() }}
                        dari {{ number_format($pendaftar->total()) }} entri
                    @else
                        Menampilkan 0 sampai 0 dari 0 entri
                    @endif
                </p>
                <div class="flex items-center gap-1">
                    @if ($pendaftar->onFirstPage())
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Sebelumnya</span>
                    @else
                        <a href="{{ $pendaftar->appends(request()->query())->previousPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Sebelumnya</a>
                    @endif

                    @php
                        $cp = $pendaftar->currentPage();
                        $lp = $pendaftar->lastPage();
                    @endphp
                    @for ($p = max(1, $cp - 2); $p <= min($lp, $cp + 2); $p++)
                        @if ($p == $cp)
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-emerald-600 border border-emerald-600 rounded-lg">{{ $p }}</span>
                        @else
                            <a href="{{ $pendaftar->appends(request()->query())->url($p) }}"
                                class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">{{ $p }}</a>
                        @endif
                    @endfor

                    @if ($pendaftar->hasMorePages())
                        <a href="{{ $pendaftar->appends(request()->query())->nextPageUrl() }}"
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-slate-300 border border-gray-200 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 hover:bg-gray-50 transition-colors">Selanjutnya</a>
                    @else
                        <span
                            class="px-3 py-1.5 text-sm text-gray-400 border border-gray-200 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 cursor-not-allowed">Selanjutnya</span>
                    @endif
                </div>
            </div>
        </div>


        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- MODAL TAMBAH PENDAFTAR                                  --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div x-show="showTambah" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showTambah = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">

                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700 sticky top-0 bg-white dark:bg-slate-800 rounded-t-2xl z-10">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Tambah Data</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Daftarkan warga ke Layanan Mandiri</p>
                    </div>
                    <button @click="showTambah = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.layanan-mandiri.pendaftar.store') }}" method="POST" class="p-6 space-y-5"
                    x-data="{ pendudukError: false }"
                    @submit.prevent="
                    if (!selectedId) { pendudukError = true; return; }
                    pendudukError = false;
                    $el.submit();
                ">
                    @csrf

                    {{-- NIK / Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">
                            NIK / Nama Penduduk <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" x-data="{ openDrop: false }" @click.away="openDrop = false">
                            <div @click="
                                openDrop = !openDrop;
                               if (openDrop) {
    $nextTick(() => $refs.pendudukSearchInput?.focus());
}
                            "
                                class="flex items-center justify-between w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 cursor-pointer transition-colors"
                                :class="pendudukError
                                    ?
                                    'border-red-400 ring-2 ring-red-400/20' :
                                    openDrop ?
                                    'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                                <span
                                    x-text="selectedNama ? selectedNama + ' (' + selectedNik + ')' : '-- Silakan Cari NIK - Nama Penduduk --'"
                                    :class="selectedNama ? 'text-gray-800 dark:text-slate-200' :
                                        'text-gray-400 dark:text-slate-500'">
                                </span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                    :class="openDrop ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                            <input type="hidden" name="penduduk_id" :value="selectedId">
                            <div x-show="openDrop" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-ref="pendudukSearchInput" x-model="searchQuery"
                                        @keydown.escape="openDrop = false" placeholder="Cari NIK atau nama..."
                                        autocomplete="off"
                                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                </div>
                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-for="item in pendudukResults" :key="item.id">
                                        <li @click="pilihPenduduk(item); openDrop = false; pendudukError = false;"
                                            class="px-3 py-2 text-sm cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors"
                                            :class="selectedId === item.id ? 'bg-emerald-500 text-white' :
                                                'text-gray-700 dark:text-slate-200'">
                                            <span class="font-medium" x-text="item.nama"></span>
                                            <span class="text-xs font-mono ml-1 opacity-75"
                                                x-text="'(' + item.nik + ')'"></span>
                                        </li>
                                    </template>
                                    <template x-if="pendudukResults.length === 0">
                                        <li class="px-3 py-3 text-sm text-gray-400 dark:text-slate-500 text-center italic">
                                            Data tidak ditemukan
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                        <p x-show="pendudukError" x-transition class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            NIK / Nama Penduduk wajib dipilih
                        </p>
                    </div>

                    {{-- PIN --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">PIN</label>
                        <input type="text" name="pin" placeholder="PIN Warga" maxlength="6" inputmode="numeric"
                            pattern="\d{6}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors tracking-widest font-mono">
                        <div class="mt-2.5 space-y-1">
                            <p class="text-xs text-red-500 flex items-start gap-1.5">
                                <span class="font-semibold flex-shrink-0">1.</span>
                                Jika PIN tidak di isi maka sistem akan menghasilkan PIN secara acak.
                            </p>
                            <p class="text-xs text-red-500 flex items-start gap-1.5">
                                <span class="font-semibold flex-shrink-0">2.</span>
                                6 (enam) digit Angka.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showTambah = false"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- MODAL RESET PIN                                         --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div x-show="showResetPin" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showResetPin = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Reset PIN Warga</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5" x-text="'Untuk: ' + resetTargetNama">
                        </p>
                    </div>
                    <button @click="showResetPin = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" id="form-reset-pin" class="p-6 space-y-4"
                    :action="'{{ url('admin/layanan-mandiri/pendaftar') }}/' + resetTarget + '/reset-pin'">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">PIN</label>
                        <!-- BARU -->
                        <input type="text" name="pin" placeholder="PIN akan digenerate otomatis" maxlength="6"
                            inputmode="numeric" pattern="\d{6}" disabled
                            class="w-full px-3 py-2 border border-gray-200 dark:border-slate-700 rounded-lg text-sm bg-gray-100 dark:bg-slate-700/50 text-gray-400 dark:text-slate-500 outline-none tracking-widest font-mono cursor-not-allowed opacity-70">
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs text-red-500 flex items-start gap-1.5"><span
                                class="font-semibold flex-shrink-0">1.</span>Sistem akan menghasilkan PIN secara acak
                            dengan cara menekan tombol 'Reset PIN'.</p>
                        <p class="text-xs text-red-500 flex items-start gap-1.5"><span
                                class="font-semibold flex-shrink-0">2.</span>PIN berisi 6 (enam) digit Angka.</p>
                        <p class="text-xs text-red-500 flex items-start gap-1.5"><span
                                class="font-semibold flex-shrink-0">3.</span>PIN akan dikirimkan ke akun Telegram atau
                            Email yang sudah diverifikasi.</p>
                        <p class="text-xs text-red-500 flex items-start gap-1.5"><span
                                class="font-semibold flex-shrink-0">4.</span>Cara Verifikasi Telegram atau Email di menu
                            Verifikasi pada Layanan Mandiri.</p>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showResetPin = false"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Reset PIN
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- MODAL TAMBAH / UBAH TELEPON                             --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        <div x-show="showTelepon" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display:none">

            <div @click.outside="showTelepon = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-slate-100 text-base">Tambah Telepon</h3>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Nomor HP warga untuk verifikasi layanan
                            mandiri</p>
                    </div>
                    <button @click="showTelepon = false"
                        class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" id="form-tambah-telepon" class="p-6 space-y-5"
                    :action="'{{ url('admin/layanan-mandiri/pendaftar') }}/' + teleponTarget + '/simpan-telepon'"
                    @submit.prevent="
        if (!teleponInputVal || !teleponInputVal.trim()) {
            teleponError = 'Nomor telepon wajib diisi.';
            return;
        }
        if (teleponError) return;
        $el.submit();
    ">
                    @csrf

                    <div
                        class="rounded-xl bg-gray-50 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 overflow-hidden">
                        <table class="w-full text-sm">
                            <tbody>
                                <tr class="border-b border-gray-100 dark:border-slate-600">
                                    <td class="px-4 py-3 font-medium text-gray-500 dark:text-slate-400 w-36">NIK</td>
                                    <td class="px-2 py-3 text-gray-400 dark:text-slate-500 w-4">:</td>
                                    <td class="px-4 py-3 font-mono text-sm text-gray-800 dark:text-slate-100"
                                        x-text="teleponTargetNik"></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-500 dark:text-slate-400">Nama Warga</td>
                                    <td class="px-2 py-3 text-gray-400 dark:text-slate-500">:</td>
                                    <td class="px-4 py-3 text-gray-800 dark:text-slate-100 font-medium"
                                        x-text="teleponTargetNama"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Nomor
                            Telepon</label>
                        <input type="tel" name="no_telepon" x-model="teleponInputVal" placeholder="No. HP Warga"
                            maxlength="20"
                            @input="
                const v = teleponInputVal;
                if (!v) { teleponError = ''; return; }
                const stripped = v.startsWith('+') ? v.slice(1) : v;
                if (/[^0-9]/.test(stripped) || v.split('+').length > 2) {
                    teleponError = 'Field ini hanya boleh diisi dengan angka.';
                } else if (v.replace(/[^0-9]/g, '').length < 8) {
                    teleponError = 'Silakan masukkan sedikitnya 8 karakter.';
                } else {
                    teleponError = '';
                }
            "
                            :class="teleponError ? 'border-red-400 ring-2 ring-red-400/20' :
                                'border-emerald-400 dark:border-emerald-600'"
                            class="w-full px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                        <p x-show="teleponError" x-text="teleponError"
                            class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="showTelepon = false"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════ --}}
        {{-- MODAL PIN RESULT (muncul setelah tambah / reset PIN)    --}}
        {{-- ════════════════════════════════════════════════════════ --}}
        @if (session('pin_result'))
            @php
                $pr = session('pin_result');
                $noTelepon = $pr['no_telepon'] ?? '';
                // Format nomor WA: 08xxx → 628xxx, +62xxx → 62xxx
                $waNumber = preg_replace('/^\+/', '', $noTelepon);
                $waNumber = preg_replace('/^0/', '62', $waNumber);

                $identitas = \App\Models\IdentitasDesa::first();
                $desaName = $identitas?->nama_desa ?? 'Desa';
                $mandiriUrl = url('layanan-mandiri');

                // BARU
                $waText =
                    "Selamat Datang di Layanan Mandiri Desa {$desaName}\n\n" .
                    "Untuk Menggunakan Layanan Mandiri, silakan kunjungi {$mandiriUrl}\n\n" .
                    "Akses Layanan Mandiri :\n" .
                    "- NIK : {$pr['nik']}\n" .
                    "- PIN : {$pr['pin']}\n\n" .
                    "Harap merahasiakan NIK dan PIN untuk keamanan data anda.\n" .
                    "Hormat kami\n" .
                    "Kepala Desa {$desaName}";

                $waUrl = $waNumber
                    ? 'https://api.whatsapp.com/send?phone=' . $waNumber . '&text=' . rawurlencode($waText)
                    : '';
            @endphp

            <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">

                <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4">

                    {{-- Header --}}
                    <div class="px-6 py-4 rounded-t-2xl"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <h3 class="font-bold text-white text-base">
                            PIN Warga
                            @if ($pr['nama'])
                                ({{ $pr['nama'] }})
                            @endif
                        </h3>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 space-y-4">
                        <p class="text-sm text-gray-600 dark:text-slate-300 leading-relaxed">
                            Berikut adalah kode pin yang baru saja di hasilkan, silakan dicatat atau di ingat dengan baik,
                            kode pin ini sangat rahasia, dan hanya bisa dilihat sekali ini lalu setelah itu hanya bisa di
                            reset saja.
                        </p>

                        {{-- PIN Display --}}
                        <div
                            class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-gray-200 dark:border-slate-600">
                            <div
                                class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 dark:text-slate-500 mb-0.5">Kode PIN</p>
                                <p class="text-2xl font-bold tracking-[0.3em] font-mono text-gray-900 dark:text-slate-100">
                                    {{ $pr['pin'] }}
                                </p>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-slate-700">
                            <button type="button" @click="show = false"
                                class="inline-flex items-center gap-2 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tutup
                            </button>

                            @if ($waUrl)
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    {{-- WhatsApp icon --}}
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                    Kirim
                                </a>
                            @else
                                <button type="button" disabled title="Nomor telepon warga belum diisi"
                                    class="inline-flex items-center gap-2 px-5 py-2 bg-emerald-300 opacity-60 cursor-not-allowed text-white text-sm font-semibold rounded-lg">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                    Kirim
                                </button>
                            @endif
                        </div>

                        @if (!$waUrl)
                            <p class="text-xs text-amber-500 text-center -mt-2">
                                ⚠ Nomor telepon warga belum diisi — tombol Kirim tidak aktif
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @include('admin.partials.modal-hapus')

    </div>
@endsection
