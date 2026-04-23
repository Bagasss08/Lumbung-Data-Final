@extends('layouts.admin')

@section('title', 'Rincian Rumah Tangga ' . $rumahTangga->no_rumah_tangga)

@section('content')

    @php
        $hubunganRtMap = [
            1 => 'Kepala Rumah Tangga',
            2 => 'Anggota',
        ];

        $shdkMap = [
            1 => 'Kepala Keluarga',
            2 => 'Suami/Istri',
            3 => 'Anak',
            4 => 'Menantu',
            5 => 'Cucu',
            6 => 'Orang Tua',
            7 => 'Mertua',
            8 => 'Famili Lain',
            9 => 'Pembantu',
            10 => 'Lainnya',
        ];

        // Flatten semua anggota dari semua KK dalam RT ini
        $kepalaRt = $rumahTangga->getKepalaRumahTangga();
        $totalKk = $rumahTangga->keluarga->count();
        $totalAnggota = $rumahTangga->keluarga->sum(fn($kk) => $kk->anggota->count());

        $allAnggota = collect();
        foreach ($rumahTangga->keluarga as $kk) {
            foreach ($kk->anggota->sortBy('kk_level') as $anggota) {
                $anggota->_no_kk = $kk->no_kk;
                $anggota->_kk_id = $kk->id;
                $anggota->_alamat = $kk->wilayah
                    ? 'RT ' .
                        ($kk->wilayah->rt ?? '—') .
                        ' / RW ' .
                        ($kk->wilayah->rw ?? '—') .
                        ' — Dusun ' .
                        ($kk->wilayah->dusun ?? '—')
                    : $kk->alamat ?? '—';
                // Hubungan dalam konteks RT: apakah dia kepala RT atau anggota
                $anggota->_hubungan_rt =
                    $kepalaRt && $anggota->id === $kepalaRt->id ? 'Kepala Rumah Tangga' : 'Anggota';
                $allAnggota->push($anggota);
            }
        }
    @endphp

    {{-- ROOT WRAPPER --}}
    <div x-data="rtShow()" @selection-changed.window="selectedCount = $event.detail.count">

        {{-- ── PAGE HEADER ── --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Data Anggota Rumah Tangga</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5 font-mono">{{ $rumahTangga->no_rumah_tangga }}</p>
            </div>
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">
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
                <a href="{{ route('admin.rumah-tangga.index') }}"
                    class="text-gray-400 dark:text-slate-500 hover:text-emerald-600 transition-colors">Data Rumah Tangga</a>
                <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Data Anggota Rumah Tangga</span>
            </nav>
        </div>

        {{-- ── FLASH MESSAGES ── --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-start gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-end="opacity-0"
                class="flex items-center gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl mb-5">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        {{-- ═══ SINGLE CARD ═══ --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

            {{-- ── TOMBOL AKSI (sesuai OpenSID: Tambah, Hapus, Kartu RT, Kembali) ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah Anggota --}}
                <button type="button" @click="bukaTambah()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>

                {{-- Hapus (bulk) --}}
                <button type="button" @click="bukaHapusBulk()" :disabled="selectedCount === 0"
                    :class="selectedCount > 0 ?
                        'bg-red-500 hover:bg-red-600 cursor-pointer' :
                        'bg-red-300 opacity-60 cursor-not-allowed'"
                    class="inline-flex items-center gap-2 px-4 py-2 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                    <span x-show="selectedCount > 0">(<span x-text="selectedCount"></span>)</span>
                </button>

                {{-- Kartu Rumah Tangga --}}
                <a href="{{ route('admin.rumah-tangga.cetak', ['search' => $rumahTangga->no_rumah_tangga]) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Kartu Rumah Tangga
                </a>

                {{-- Kembali --}}
                <a href="{{ route('admin.rumah-tangga.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-all shadow-sm group">
                    <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Ke Daftar Rumah Tangga
                </a>
            </div>

            {{-- ── RINCIAN RUMAH TANGGA ── --}}
            <div class="border-b border-gray-100 dark:border-slate-700">
                <div class="px-6 py-3 border-b border-gray-100 dark:border-slate-700">
                    <span class="text-sm font-bold text-gray-700 dark:text-slate-200">Rincian Keluarga</span>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-slate-700">

                    {{-- Nomor RT --}}
                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Nomor Rumah Tangga (RT)</p>
                        <p class="col-span-2 text-sm font-mono text-gray-700 dark:text-slate-300 flex items-center gap-2">
                            <span>:</span>
                            <span>{{ $rumahTangga->no_rumah_tangga }}</span>
                        </p>
                    </div>

                    {{-- Kepala Rumah Tangga --}}
                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Kepala Rumah Tangga</p>
                        <div class="col-span-2 flex items-center gap-1.5">
                            <span class="text-sm text-gray-500">:</span>
                            @if ($kepalaRt)
                                <a href="{{ route('admin.penduduk.show', $kepalaRt) }}"
                                    class="text-sm text-gray-700 dark:text-slate-300 hover:text-emerald-600 transition-colors">
                                    {{ $kepalaRt->nama }}
                                </a>
                            @else
                                <p class="text-sm text-gray-400 italic">Belum ada kepala rumah tangga</p>
                            @endif
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="grid grid-cols-3 px-6 py-3 items-start">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400 pt-0.5">Alamat</p>
                        <div class="col-span-2 flex gap-1.5">
                            <span class="text-sm text-gray-500">:</span>
                            <div>
                                @if ($rumahTangga->wilayah)
                                    <p class="text-sm text-gray-700 dark:text-slate-300">
                                        RT {{ $rumahTangga->wilayah->rt ?? '—' }} / RW
                                        {{ $rumahTangga->wilayah->rw ?? '—' }} —
                                        Dusun {{ $rumahTangga->wilayah->dusun ?? '—' }}
                                    </p>
                                @endif
                                @if ($rumahTangga->alamat)
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $rumahTangga->alamat }}
                                    </p>
                                @endif
                                @if (!$rumahTangga->wilayah && !$rumahTangga->alamat)
                                    <p class="text-sm text-gray-400 italic">—</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Jumlah KK --}}
                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Jumlah KK</p>
                        <p class="col-span-2 text-sm text-gray-700 dark:text-slate-300 flex items-center gap-2">
                            <span>:</span>
                            <span>{{ $totalKk }}</span>
                        </p>
                    </div>

                    {{-- Jumlah Anggota --}}
                    <div class="grid grid-cols-3 px-6 py-3 items-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Jumlah Anggota</p>
                        <p class="col-span-2 text-sm text-gray-700 dark:text-slate-300 flex items-center gap-2">
                            <span>:</span>
                            <span>{{ $totalAnggota }}</span>
                        </p>
                    </div>

                    {{-- BDT --}}
                    @if (isset($rumahTangga->bdt))
                        <div class="grid grid-cols-3 px-6 py-3 items-center">
                            <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">BDT</p>
                            <p class="col-span-2 text-sm text-gray-700 dark:text-slate-300 flex items-center gap-2">
                                <span>:</span>
                                <span>{{ $rumahTangga->bdt ?? '—' }}</span>
                            </p>
                        </div>
                    @endif

                    {{-- Program Bantuan / Klasifikasi --}}
                    @if ($rumahTangga->jenis_bantuan_aktif)
                        <div class="grid grid-cols-3 px-6 py-3 items-center">
                            <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Program Bantuan</p>
                            <div class="col-span-2 flex items-center gap-1.5">
                                <span class="text-sm text-gray-500">:</span>
                                <span class="px-2.5 py-0.5 text-xs font-bold rounded bg-teal-500 text-white">
                                    {{ $rumahTangga->jenis_bantuan_aktif }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-3 px-6 py-3 items-center">
                            <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Program Bantuan</p>
                            <p class="col-span-2 text-sm text-gray-700 dark:text-slate-300 flex items-center gap-2">
                                <span>:</span>
                                <span>—</span>
                            </p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ── DAFTAR ANGGOTA (flat, seperti OpenSID) ── --}}
            <div x-data="{
                search: '',
                perPage: 10,
                currentPage: 1,
                selectedIds: [],
                selectAll: false,
            
                allRows: {{ Js::from(
                    $allAnggota->map(
                        fn($a) => [
                            'id' => $a->id,
                            'nik' => $a->nik ?? '—',
                            'no_kk' => $a->_no_kk,
                            'nama' => $a->nama,
                            'jk' => $a->jenis_kelamin === 'L' ? 'LAKI-LAKI' : 'PEREMPUAN',
                            'alamat' => $a->_alamat,
                            'hubungan' => $a->_hubungan_rt,
                            'editUrl' => route('admin.penduduk.edit', $a),
                            'showUrl' => route('admin.penduduk.show', $a),
                            'hubunganRt' => $a->_hubungan_rt,
                        ],
                    ),
                ) }},
            
                get filtered() {
                    if (!this.search) return this.allRows;
                    const s = this.search.toLowerCase();
                    return this.allRows.filter(r =>
                        r.nik.toLowerCase().includes(s) ||
                        r.no_kk.toLowerCase().includes(s) ||
                        r.nama.toLowerCase().includes(s) ||
                        r.hubungan.toLowerCase().includes(s)
                    );
                },
                get totalPages() {
                    return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
                },
                get paginated() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filtered.slice(start, start + this.perPage);
                },
                get startEntry() {
                    return this.filtered.length === 0 ? 0 : (this.currentPage - 1) * this.perPage + 1;
                },
                get endEntry() {
                    return Math.min(this.currentPage * this.perPage, this.filtered.length);
                },
                toggleSelectAll() {
                    if (this.selectAll) {
                        this.selectedIds = this.paginated.map(r => r.id);
                    } else {
                        this.selectedIds = [];
                    }
                    this.$dispatch('selection-changed', { count: this.selectedIds.length });
                },
                toggleRow(id) {
                    const idx = this.selectedIds.indexOf(id);
                    if (idx === -1) this.selectedIds.push(id);
                    else this.selectedIds.splice(idx, 1);
                    this.selectAll = this.paginated.every(r => this.selectedIds.includes(r.id));
                    this.$dispatch('selection-changed', { count: this.selectedIds.length });
                },
                changePage(p) {
                    if (p < 1 || p > this.totalPages) return;
                    this.currentPage = p;
                    this.selectAll = false;
                },
                watchSearch() {
                    this.currentPage = 1;
                    this.selectAll = false;
                    this.selectedIds = [];
                    this.$dispatch('selection-changed', { count: 0 });
                },
                watchPerPage() {
                    this.currentPage = 1;
                    this.selectAll = false;
                    this.selectedIds = [];
                    this.$dispatch('selection-changed', { count: 0 });
                },
            }" x-init="$watch('search', () => watchSearch());
            $watch('perPage', () => watchPerPage())">

                {{-- Header: Tampilkan + Cari --}}
                <div
                    class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                        <span>Tampilkan</span>

                        {{-- Custom dropdown perPage --}}
                        <div class="relative w-20" x-data="{
                            open: false,
                            options: [{ value: 10, label: '10' }, { value: 25, label: '25' }, { value: 50, label: '50' }, { value: 100, label: '100' }],
                        }" @click.away="open = false">
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-1.5 border rounded-lg text-sm bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                <span x-text="perPage" class="text-gray-700 dark:text-slate-200"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-1"
                                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
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
                                        <li @click="perPage = opt.value; open = false"
                                            class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                            :class="perPage === opt.value ?
                                                'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label"></li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <span>entri</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                        <span>Cari:</span>
                        <div class="relative group">
                            <input type="text" x-model="search" placeholder="kata kunci pencarian" maxlength="50"
                                class="px-3 py-1.5 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none w-52">
                            <div
                                class="absolute bottom-full right-0 mb-2 hidden group-focus-within:block z-50 pointer-events-none">
                                <div
                                    class="bg-gray-800 dark:bg-slate-700 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                    Masukkan kata kunci untuk mencari (maksimal 50 karakter)
                                    <div
                                        class="absolute top-full right-4 border-4 border-transparent border-t-gray-800 dark:border-t-slate-700">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div style="overflow-x: auto;">
                    <table class="w-full text-sm" style="min-width: 820px;">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                                <th class="px-3 py-3 w-10 text-center">
                                    <input type="checkbox" x-model="selectAll" @change="toggleSelectAll()"
                                        class="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-12">
                                    NO</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    AKSI</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NIK</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NOMOR KK</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    NAMA</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    JENIS KELAMIN</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    ALAMAT</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    HUBUNGAN</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            <template x-for="(row, idx) in paginated" :key="row.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">

                                    {{-- Checkbox --}}
                                    <td class="px-3 py-3 text-center">
                                        <input type="checkbox" :checked="selectedIds.includes(row.id)"
                                            @change="toggleRow(row.id)"
                                            class="rounded border-gray-300 text-emerald-500 focus:ring-emerald-500 cursor-pointer">
                                    </td>

                                    {{-- NO --}}
                                    <td class="px-3 py-3 text-center text-xs text-gray-500 dark:text-slate-400 tabular-nums"
                                        x-text="startEntry + idx"></td>

                                    {{-- AKSI: Edit, Ubah Hubungan, Hapus --}}
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-1">
                                            {{-- Edit biodata --}}
                                            <a :href="row.editUrl" title="Ubah Biodata"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            {{-- Ubah Hubungan RT --}}
                                            <button type="button" title="Ubah Hubungan RT"
                                                @click="bukaUbahHubungan(row)"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-teal-500 hover:bg-teal-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                            </button>
                                            {{-- Hapus dari RT --}}
                                            <button type="button" title="Hapus dari Rumah Tangga"
                                                @click="bukaHapus(row)"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-500 hover:bg-red-600 text-white transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- NIK --}}
                                    <td class="px-3 py-3 font-mono text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap"
                                        x-text="row.nik"></td>

                                    {{-- NOMOR KK --}}
                                    <td class="px-3 py-3 font-mono text-xs text-emerald-600 dark:text-emerald-400 whitespace-nowrap"
                                        x-text="row.no_kk"></td>

                                    {{-- NAMA --}}
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <a :href="row.showUrl"
                                            class="text-xs font-medium text-gray-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors"
                                            x-text="row.nama"></a>
                                    </td>

                                    {{-- JENIS KELAMIN --}}
                                    <td class="px-3 py-3 text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap"
                                        x-text="row.jk"></td>

                                    {{-- ALAMAT --}}
                                    <td class="px-3 py-3 text-xs text-gray-600 dark:text-slate-300" x-text="row.alamat">
                                    </td>

                                    {{-- HUBUNGAN RT --}}
                                    <td class="px-3 py-3 text-xs text-gray-600 dark:text-slate-300 whitespace-nowrap"
                                        x-text="row.hubungan"></td>

                                </tr>
                            </template>

                            {{-- Empty state --}}
                            <tr x-show="paginated.length === 0">
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-gray-400 dark:text-slate-500 text-sm"
                                            x-text="search ? 'Tidak ada data yang cocok.' : 'Belum ada anggota dalam rumah tangga ini.'">
                                        </p>
                                        <button x-show="!search" type="button" @click="bukaTambah()"
                                            class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                            Tambah Anggota Sekarang
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Footer: info entri + paginasi --}}
                <div
                    class="flex flex-wrap items-center justify-between gap-3 px-5 py-3 border-t border-gray-100 dark:border-slate-700 text-sm text-gray-500 dark:text-slate-400">
                    <span
                        x-text="filtered.length === 0
                        ? 'Menampilkan 0 sampai 0 dari 0 entri'
                        : 'Menampilkan ' + startEntry + ' sampai ' + endEntry + ' dari ' + filtered.length + ' entri'"></span>

                    <div class="flex items-center gap-1">
                        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                            class="px-3 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-slate-600 disabled:opacity-40 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Sebelumnya
                        </button>
                        <template x-for="p in totalPages" :key="p">
                            <button @click="changePage(p)"
                                :class="p === currentPage ?
                                    'bg-emerald-500 text-white border-emerald-500' :
                                    'border-gray-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700'"
                                class="w-8 h-8 text-xs rounded-lg border transition-colors" x-text="p"></button>
                        </template>
                        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages"
                            class="px-3 py-1.5 text-xs rounded-lg border border-gray-200 dark:border-slate-600 disabled:opacity-40 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                            Selanjutnya
                        </button>
                    </div>
                </div>

            </div>{{-- /x-data tabel --}}
        </div>{{-- /single card --}}
        {{-- Hidden form untuk bulk destroy anggota --}}
        <form id="form-bulk-hapus-anggota" method="POST"
            action="{{ route('admin.rumah-tangga.anggota.bulk-destroy', $rumahTangga) }}" style="display:none">
            @csrf
            @method('DELETE')
        </form>

        @include('admin.partials.modal-hapus')


        {{-- ══════════════════════════════════════════════════════════
         MODAL — TAMBAH ANGGOTA
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalTambah.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalTambah.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-lg mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Tambah Anggota Rumah Tangga</h3>
                    <button @click="modalTambah.open = false"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{--
                    Sesuaikan action route dengan controller yang digunakan.
                    Jika pakai RumahTanggaAnggotaController:
                        route('admin.rumah-tangga-anggota.store', $rumahTangga)
                    Jika pakai RumahTanggaController dengan method tambahKk (saat ini):
                        route('admin.rumah-tangga.tambah-kk', $rumahTangga)
                --}}
                <form method="POST" action="{{ route('admin.rumah-tangga.tambah-kk', $rumahTangga) }}">
                    @csrf
                    <div class="p-5 space-y-4">
                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Pilih Kartu Keluarga <span class="text-red-500">*</span>
                            </label>
                            <div x-data="{
                                open: false,
                                search: '',
                                selected: '',
                                options: {{ Js::from(
                                    $kkTersedia->map(
                                        fn($kk) => [
                                            'value' => $kk->id,
                                            'label' => $kk->no_kk . ($kk->kepalaKeluarga ? ' — ' . $kk->kepalaKeluarga->nama : ''),
                                        ],
                                    ),
                                ) }},
                                get labelText() { return this.options.find(o => o.value == this.selected)?.label ?? ''; },
                                get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                                choose(opt) {
                                    this.selected = opt.value;
                                    this.open = false;
                                    this.search = '';
                                }
                            }" @click.away="open = false" class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm bg-white dark:bg-slate-700 transition-colors focus:outline-none"
                                    :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                        'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                    <span x-text="labelText || 'Pilih KK yang belum masuk RT'"
                                        :class="labelText ? 'text-gray-800 dark:text-slate-200' :
                                            'text-gray-400 dark:text-slate-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition
                                    class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                    style="display:none">
                                    <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                        <input type="text" x-model="search" @keydown.escape="open = false"
                                            placeholder="Cari No. KK atau nama kepala..."
                                            class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded outline-none focus:border-emerald-500 text-gray-700 dark:text-slate-200">
                                    </div>
                                    <ul class="max-h-56 overflow-y-auto py-1">
                                        <template x-for="opt in filtered" :key="opt.value">
                                            <li @click="choose(opt)"
                                                class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                                :class="selected == opt.value ?
                                                    'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                    'text-gray-700 dark:text-slate-200'"
                                                x-text="opt.label"></li>
                                        </template>
                                        <li x-show="filtered.length === 0"
                                            class="px-3 py-4 text-center text-sm text-gray-400 dark:text-slate-500">
                                            Tidak ada KK tersedia
                                        </li>
                                    </ul>
                                </div>
                                <input type="hidden" name="keluarga_id" :value="selected" required>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-slate-500 mt-1.5">
                                Hanya menampilkan KK yang belum terdaftar di rumah tangga manapun.
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalTambah.open = false"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors ml-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Tambahkan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════════════════════
         MODAL — UBAH HUBUNGAN RT
        ═══════════════════════════════════════════════════════════════ --}}
        <div x-show="modalHubungan.open"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" @click.self="modalHubungan.open = false" style="display:none">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 w-full max-w-md mx-4 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                    <h3 class="font-semibold text-gray-800 dark:text-slate-100">Ubah Hubungan Rumah Tangga</h3>
                    <button @click="modalHubungan.open = false"
                        class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Sesuaikan action dengan route ubah hubungan RT yang ada --}}
                <form method="POST" :action="modalHubungan.action">
                    @csrf
                    @method('PATCH')
                    <div class="p-5 space-y-4">
                        <div
                            class="divide-y divide-gray-100 dark:divide-slate-700 border border-gray-200 dark:border-slate-600 rounded-xl overflow-hidden">
                            <div class="grid grid-cols-3 px-4 py-3 items-center">
                                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">NIK</p>
                                <p class="col-span-2 text-sm font-mono text-gray-700 dark:text-slate-200 flex gap-2">
                                    <span>:</span><span x-text="modalHubungan.nik"></span>
                                </p>
                            </div>
                            <div class="grid grid-cols-3 px-4 py-3 items-center">
                                <p class="text-xs font-semibold text-gray-500 dark:text-slate-400">Nama</p>
                                <p class="col-span-2 text-sm font-semibold text-gray-700 dark:text-slate-200 flex gap-2">
                                    <span>:</span><span x-text="modalHubungan.nama"></span>
                                </p>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wide mb-1.5">
                                Hubungan dalam Rumah Tangga <span class="text-red-500">*</span>
                            </label>
                            <select name="hubungan_rumah_tangga" required
                                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="Kepala Rumah Tangga"
                                    :selected="modalHubungan.hubungan === 'Kepala Rumah Tangga'">Kepala Rumah Tangga
                                </option>
                                <option value="Anggota" :selected="modalHubungan.hubungan === 'Anggota'">Anggota
                                </option>
                            </select>
                        </div>
                    </div>

                    <div
                        class="flex gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-800/60 border-t border-gray-100 dark:border-slate-700">
                        <button type="button" @click="modalHubungan.open = false"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors ml-auto">
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

        {{-- ══════════════════════════════════════════════════════════════
     ALPINE JS
    ═══════════════════════════════════════════════════════════════════ --}}
        <script>
            function rtShow() {
                return {
                    selectedCount: 0,

                    modalTambah: {
                        open: false
                    },
                    bukaTambah() {
                        this.modalTambah.open = true;
                    },

                    modalHubungan: {
                        open: false,
                        action: '',
                        nik: '',
                        nama: '',
                        hubungan: 'Anggota',
                    },
                    bukaUbahHubungan(row) {
                        this.modalHubungan.nik = row.nik;
                        this.modalHubungan.nama = row.nama;
                        this.modalHubungan.hubungan = row.hubunganRt;
                        this.modalHubungan.action = `/admin/rumah-tangga/{{ $rumahTangga->id }}/anggota/${row.id}/hubungan`;
                        this.modalHubungan.open = true;
                    },

                    bukaHapus(row) {
                        this.$dispatch('buka-modal-hapus', {
                            action: `/admin/rumah-tangga/{{ $rumahTangga->id }}/anggota/${row.id}`,
                            nama: row.nama,
                        });
                    },

                    bukaHapusBulk() {
                        this.$dispatch('ambil-selected');
                    },
                };
            }

            // Listener untuk ambil selectedIds dari tabel Alpine ke root Alpine
            document.addEventListener('alpine:init', () => {
                document.addEventListener('ambil-selected', () => {
                    const tabelEl = document.querySelector('[x-data*="allRows"]');
                    if (!tabelEl) return;

                    const tabelData = Alpine.$data(tabelEl);

                    if (tabelData.selectedIds.length === 0) {
                        alert('Pilih minimal satu anggota untuk dihapus.');
                        return;
                    }

                    // Inject IDs ke hidden form
                    const form = document.getElementById('form-bulk-hapus-anggota');
                    form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());
                    tabelData.selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    // Buka modal partials dengan callback
                    window.dispatchEvent(new CustomEvent('buka-modal-hapus', {
                        detail: {
                            bulkCount: tabelData.selectedIds.length,
                            onConfirm: () => form.submit(),
                        }
                    }));
                });
            });
        </script>

    @endsection
