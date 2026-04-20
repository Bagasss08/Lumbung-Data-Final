@extends('layouts.admin')

@section('title', 'Statistik Kependudukan')

@section('content')

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Statistik Kependudukan</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Informasi distribusi dan sebaran data penduduk desa
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
            <span class="text-gray-400 dark:text-slate-500">Statistik</span>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Statistik Kependudukan</span>
        </nav>
    </div>

    {{-- ===== LAYOUT ===== --}}
    <div class="flex gap-5">

        {{-- ================================================================
         SIDEBAR — accordion dengan 4 grup (mirip OpenSID)
         Grup aktif (Statistik Penduduk) selalu terbuka.
         Grup lain (Keluarga / RTM / Program Bantuan) = coming soon.
         ================================================================ --}}
        {{-- ================================================================
     SIDEBAR
     ================================================================ --}}
        @php
            $pendudukKeys = [
                'usia',
                'pendidikan',
                'pekerjaan',
                'status_kawin',
                'agama',
                'jenis_kelamin',
                'golongan_darah',
                'wilayah',
            ];
            $isPendudukActive = in_array($data['kategori'], $pendudukKeys);

            $pendudukMenus = [
                ['key' => 'usia', 'label' => 'Distribusi Usia'],
                ['key' => 'pendidikan', 'label' => 'Pendidikan Dalam KK'],
                ['key' => 'pekerjaan', 'label' => 'Pekerjaan'],
                ['key' => 'status_kawin', 'label' => 'Status Perkawinan'],
                ['key' => 'agama', 'label' => 'Agama'],
                ['key' => 'jenis_kelamin', 'label' => 'Jenis Kelamin'],
                ['key' => 'golongan_darah', 'label' => 'Golongan Darah'],
                ['key' => 'wilayah', 'label' => 'Sebaran Wilayah'],
            ];

            $soonGroups = [
                [
                    'label' => 'Statistik Keluarga',
                    'items' => ['Kelas Sosial', 'Kepemilikan Aset', 'Sumber Penghasilan'],
                ],
                ['label' => 'Statistik RTM', 'items' => ['BDT', 'DTSEN']],
                [
                    'label' => 'Statistik Program Bantuan',
                    'items' => [
                        'Bantuan Penduduk',
                        'Bantuan Keluarga',
                        'BPNT',
                        'BLSM',
                        'PKH',
                        'Bedah Rumah',
                        'JAMKESMAS',
                    ],
                ],
            ];
        @endphp

        <div class="w-56 flex-shrink-0 flex flex-col gap-2">

            {{-- Grup 1: Statistik Penduduk --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden"
                x-data="{ open: {{ $isPendudukActive ? 'true' : 'false' }} }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors border-l-4 border-emerald-500">
                    <span>Statistik Penduduk</span>
                    <span class="text-lg font-light leading-none text-gray-400" x-text="open ? '−' : '+'"></span>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1">
                    @foreach ($pendudukMenus as $menu)
                        <a href="{{ request()->fullUrlWithQuery(['kategori' => $menu['key']]) }}"
                            class="block px-4 py-2.5 text-sm border-t border-gray-100 dark:border-slate-700 transition-colors
                    {{ $data['kategori'] === $menu['key']
                        ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-semibold border-l-4 border-l-emerald-500 pl-3'
                        : 'text-slate-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-700/50 pl-4' }}">
                            {{ $menu['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Grup 2, 3, 4: Coming soon --}}
            @foreach ($soonGroups as $group)
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden"
                    x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors border-l-4 border-emerald-500">
                        <span>{{ $group['label'] }}</span>
                        <span class="text-lg font-light leading-none text-gray-400" x-text="open ? '−' : '+'"></span>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1">
                        @foreach ($group['items'] as $item)
                            <span
                                class="flex items-center justify-between px-4 py-2.5 text-sm border-t border-gray-100 dark:border-slate-700 text-slate-400 dark:text-slate-500 cursor-not-allowed select-none">
                                {{ $item }}
                                <span
                                    class="text-xs bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 px-1.5 py-0.5 rounded font-medium">soon</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
        {{-- end sidebar --}}


        {{-- ================================================================
         KONTEN
         ================================================================ --}}
        <div class="flex-1 min-w-0">

            @php
                $judulMap = [
                    'usia' => 'Distribusi Usia',
                    'pendidikan' => 'Pendidikan Dalam KK',
                    'pekerjaan' => 'Mata Pencaharian / Pekerjaan',
                    'status_kawin' => 'Status Perkawinan',
                    'agama' => 'Agama',
                    'jenis_kelamin' => 'Jenis Kelamin',
                    'golongan_darah' => 'Golongan Darah',
                    'wilayah' => 'Sebaran Penduduk per Dusun',
                ];
                $judulAktif = $judulMap[$data['kategori']] ?? 'Statistik';
                $rows = $data[$data['kategori']] ?? [];
                $totalRow = array_sum(array_column($rows, 'total'));
                $totalLaki = array_sum(array_column($rows, 'laki'));
                $totalPerempuan = array_sum(array_column($rows, 'perempuan'));
                $belumMengisi = max(0, $data['total_penduduk'] - $totalRow);
            @endphp

            {{-- TOOLBAR --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 mb-4 flex flex-wrap items-center gap-2">

                <button onclick="openModal('modalCetak')"
                    class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Data
                </button>

                <button onclick="openModal('modalUnduh')"
                    class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-teal-600 hover:bg-teal-700 text-white transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh Data
                </button>

                <button onclick="showChart('bar')"
                    class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Grafik Data
                </button>

                <button onclick="showChart('pie')"
                    class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white transition font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    Pie Data
                </button>

                {{-- Filter Dusun --}}
                <div class="ml-auto">
                    <form method="GET" id="form-filter-dusun">
                        <input type="hidden" name="kategori" value="{{ $data['kategori'] }}">
                        <input type="hidden" name="dusun" id="input-dusun" value="{{ $data['dusunFilter'] }}">

                        <div x-data="{
                            open: false,
                            search: '',
                            selected: '{{ $data['dusunFilter'] }}',
                            options: {{ json_encode(
                                array_merge(
                                    [['value' => '', 'label' => '— Pilih Dusun —']],
                                    collect($data['dusunList'])->map(fn($d) => ['value' => $d, 'label' => strtoupper($d)])->toArray(),
                                ),
                            ) }},
                            get filtered() {
                                return !this.search ?
                                    this.options :
                                    this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            get selectedLabel() {
                                const f = this.options.find(o => o.value === this.selected);
                                return f ? f.label : '— Pilih Dusun —';
                            },
                            choose(opt) {
                                this.selected = opt.value;
                                document.getElementById('input-dusun').value = opt.value;
                                this.open = false;
                                this.search = '';
                                document.getElementById('form-filter-dusun').submit();
                            }
                        }" @click.away="open = false" class="relative w-48">

                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                                    'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                                <span x-text="selectedLabel"
                                    :class="selected ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"
                                    class="truncate text-sm"></span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
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
                                class="absolute right-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                                style="display:none">
                                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                    <input type="text" x-model="search" @keydown.escape="open = false"
                                        placeholder="Cari dusun..."
                                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                                </div>
                                <ul class="max-h-48 overflow-y-auto py-1">
                                    <template x-for="opt in filtered" :key="opt.value">
                                        <li @click="choose(opt)"
                                            class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                            :class="selected === opt.value ?
                                                'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                                'text-gray-700 dark:text-slate-200'"
                                            x-text="opt.label">
                                        </li>
                                    </template>
                                    <li x-show="filtered.length === 0" class="px-3 py-2 text-xs text-gray-400 italic">
                                        Tidak ditemukan</li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CHART AREA --}}
            <div id="chartArea"
                class="hidden bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6 mb-4">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-700 dark:text-slate-200">
                        Jumlah dan Persentase Penduduk Berdasarkan {{ $judulAktif }}
                        @if ($data['dusunFilter'])
                            <span class="text-sm font-normal text-emerald-600 dark:text-emerald-400">— Dusun
                                {{ strtoupper($data['dusunFilter']) }}</span>
                        @endif
                    </h4>
                    <button onclick="hideChart()"
                        class="text-slate-400 hover:text-slate-600 p-1 rounded hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="h-80"><canvas id="mainChart"></canvas></div>
            </div>

            {{-- ================================================================
             TABEL — dengan sortable columns via Alpine.js
             rowsData sudah tersedia sebagai JS variable dari @json($rows)
             ================================================================ --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6"
                id="tabelUtama">

                {{-- Judul tabel --}}
                <div class="text-center mb-4">
                    <p class="font-bold text-base">
                        Jumlah dan Persentase Penduduk Berdasarkan {{ $judulAktif }}
                    </p>
                    @if ($data['dusunFilter'])
                        <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-0.5">
                            Dusun {{ strtoupper($data['dusunFilter']) }}
                        </p>
                    @endif
                </div>

                <div class="overflow-x-auto" x-data="{
                    sortCol: null,
                    sortDir: 'asc',
                    rows: rowsData,
                    get sorted() {
                        if (!this.sortCol) return this.rows;
                        const col = this.sortCol;
                        const dir = this.sortDir === 'asc' ? 1 : -1;
                        return [...this.rows].sort((a, b) => {
                            if (col === 'label') return dir * a.label.localeCompare(b.label, 'id');
                            return dir * ((parseFloat(a[col]) || 0) - (parseFloat(b[col]) || 0));
                        });
                    },
                    toggleSort(col) {
                        if (this.sortCol === col) {
                            this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                        } else {
                            this.sortCol = col;
                            this.sortDir = 'asc';
                        }
                    },
                    fmt(v) {
                        if (!v && v !== 0) return '-';
                        if (v === 0) return '-';
                        return new Intl.NumberFormat('id-ID').format(v);
                    },
                    pct(v) {
                        return Number(v || 0).toFixed(2).replace('.', ',') + '%';
                    }
                }">
                    <table class="w-full border-collapse text-xs" id="tabelData">
                        <thead>
                            {{-- Baris 1: Grup besar --}}
                            <tr class="bg-slate-100 text-center text-slate-700 font-semibold">
                                <th rowspan="2" class="border border-slate-400 px-2 py-2 w-8">NO</th>

                                {{-- Kolom JENIS KELOMPOK — sortable --}}
                                <th rowspan="2"
                                    class="border border-slate-400 px-3 py-2 text-left min-w-48 cursor-pointer select-none hover:bg-slate-200 transition-colors group"
                                    @click="toggleSort('label')">
                                    <div class="flex items-center gap-1">
                                        JENIS KELOMPOK
                                        <span class="flex flex-col">
                                            <svg class="w-2.5 h-2.5 transition-colors"
                                                :class="sortCol === 'label' && sortDir==='asc' ? 'text-emerald-600' :
                                                    'text-slate-300 group-hover:text-slate-400'"
                                                viewBox="0 0 10 6" fill="currentColor">
                                                <path d="M5 0L10 6H0z" />
                                            </svg>
                                            <svg class="w-2.5 h-2.5 transition-colors"
                                                :class="sortCol === 'label' && sortDir==='desc' ? 'text-emerald-600' :
                                                    'text-slate-300 group-hover:text-slate-400'"
                                                viewBox="0 0 10 6" fill="currentColor">
                                                <path d="M5 6L0 0H10z" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>

                                <th colspan="2" class="border border-slate-400 px-2 py-1">JUMLAH</th>
                                <th colspan="2" class="border border-slate-400 px-2 py-1">LAKI-LAKI</th>
                                <th colspan="2" class="border border-slate-400 px-2 py-1">PEREMPUAN</th>
                            </tr>

                            {{-- Baris 2: Sub-kolom — semua sortable --}}
                            <tr class="bg-slate-100 text-center text-slate-700 font-semibold">
                                @php
                                    $sortCols = [
                                        ['col' => 'total', 'label' => 'TOTAL'],
                                        ['col' => 'persen', 'label' => 'PERSEN'],
                                        ['col' => 'laki', 'label' => 'TOTAL'],
                                        ['col' => 'persen_laki', 'label' => 'PERSEN'],
                                        ['col' => 'perempuan', 'label' => 'TOTAL'],
                                        ['col' => 'persen_perempuan', 'label' => 'PERSEN'],
                                    ];
                                @endphp
                                @foreach ($sortCols as $sc)
                                    <th class="border border-slate-400 px-2 py-1 w-16 cursor-pointer select-none hover:bg-slate-200 transition-colors group"
                                        @click="toggleSort('{{ $sc['col'] }}')">
                                        <div class="flex items-center justify-center gap-1">
                                            {{ $sc['label'] }}
                                            <span class="flex flex-col">
                                                <svg class="w-2.5 h-2.5 transition-colors"
                                                    :class="sortCol === '{{ $sc['col'] }}' && sortDir==='asc' ?
                                                        'text-emerald-600' : 'text-slate-300 group-hover:text-slate-400'"
                                                    viewBox="0 0 10 6" fill="currentColor">
                                                    <path d="M5 0L10 6H0z" />
                                                </svg>
                                                <svg class="w-2.5 h-2.5 transition-colors"
                                                    :class="sortCol === '{{ $sc['col'] }}' && sortDir==='desc' ?
                                                        'text-emerald-600' : 'text-slate-300 group-hover:text-slate-400'"
                                                    viewBox="0 0 10 6" fill="currentColor">
                                                    <path d="M5 6L0 0H10z" />
                                                </svg>
                                            </span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>

                            {{-- Baris 3: Nomor kolom --}}
                            <tr class="bg-slate-200 text-center font-bold text-slate-600">
                                @foreach (range(1, 8) as $n)
                                    <th class="border border-slate-400 px-2 py-1">{{ $n }}</th>
                                @endforeach
                            </tr>

                            {{-- Chip info saat sedang diurutkan --}}
                            <tr x-show="sortCol !== null">
                                <td colspan="8" class="border-0 px-0 py-1">
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span>Diurutkan berdasarkan:
                                            <strong x-text="sortCol" class="text-emerald-700"></strong>
                                            (<span
                                                x-text="sortDir === 'asc' ? 'A → Z / terkecil' : 'Z → A / terbesar'"></span>)
                                        </span>
                                        <button @click="sortCol = null; sortDir = 'asc';"
                                            class="text-red-400 hover:text-red-600 underline">reset</button>
                                    </div>
                                </td>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Render dari Alpine x-for agar sortable --}}
                            @if (count($rows) > 0)
                                <template x-for="(row, i) in sorted" :key="i">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 text-center transition-colors">
                                        <td class="border border-slate-300 px-2 py-2 text-slate-500" x-text="i + 1"></td>
                                        <td class="border border-slate-300 px-3 py-2 text-left text-slate-700 dark:text-slate-200"
                                            x-text="row.label"></td>
                                        {{-- JUMLAH --}}
                                        <td class="border border-slate-300 px-2 py-2"
                                            :class="row.total ? 'text-emerald-600 font-semibold' : 'text-slate-400'"
                                            x-text="fmt(row.total)"></td>
                                        <td class="border border-slate-300 px-2 py-2 text-slate-500"
                                            x-text="pct(row.persen)"></td>
                                        {{-- LAKI-LAKI --}}
                                        <td class="border border-slate-300 px-2 py-2"
                                            :class="row.laki ? 'text-emerald-600 font-semibold' : 'text-slate-400'"
                                            x-text="fmt(row.laki)"></td>
                                        <td class="border border-slate-300 px-2 py-2 text-slate-500"
                                            x-text="pct(row.persen_laki)"></td>
                                        {{-- PEREMPUAN --}}
                                        <td class="border border-slate-300 px-2 py-2"
                                            :class="row.perempuan ? 'text-emerald-600 font-semibold' : 'text-slate-400'"
                                            x-text="fmt(row.perempuan)"></td>
                                        <td class="border border-slate-300 px-2 py-2 text-slate-500"
                                            x-text="pct(row.persen_perempuan)"></td>
                                    </tr>
                                </template>
                            @else
                                <tr>
                                    <td colspan="8" class="border border-slate-300 py-10 text-center text-slate-400">
                                        Belum ada data
                                    </td>
                                </tr>
                            @endif
                        </tbody>

                        @if (count($rows) > 0)
                            <tfoot>
                                {{-- JUMLAH --}}
                                <tr class="bg-slate-50 dark:bg-slate-700/30 font-medium text-center">
                                    <td class="border border-slate-400 px-2 py-2 text-slate-500">—</td>
                                    <td
                                        class="border border-slate-400 px-3 py-2 text-left text-slate-700 dark:text-slate-200">
                                        JUMLAH</td>
                                    <td
                                        class="border border-slate-400 px-2 py-2 {{ $totalRow ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                                        {{ $totalRow ? number_format($totalRow) : '-' }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-slate-500">100,00%</td>
                                    <td
                                        class="border border-slate-400 px-2 py-2 {{ $totalLaki ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                                        {{ $totalLaki ? number_format($totalLaki) : '-' }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-slate-500">
                                        {{ $totalRow > 0 ? number_format(($totalLaki / $totalRow) * 100, 2) : '0,00' }}%
                                    </td>
                                    <td
                                        class="border border-slate-400 px-2 py-2 {{ $totalPerempuan ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                                        {{ $totalPerempuan ? number_format($totalPerempuan) : '-' }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-slate-500">
                                        {{ $totalRow > 0 ? number_format(($totalPerempuan / $totalRow) * 100, 2) : '0,00' }}%
                                    </td>
                                </tr>
                                {{-- BELUM MENGISI --}}
                                <tr class="bg-slate-50 dark:bg-slate-700/30 italic text-center text-slate-500">
                                    <td class="border border-slate-400 px-2 py-2">—</td>
                                    <td class="border border-slate-400 px-3 py-2 text-left">BELUM MENGISI</td>
                                    <td
                                        class="border border-slate-400 px-2 py-2 {{ $belumMengisi ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                                        {{ $belumMengisi ? number_format($belumMengisi) : '-' }}</td>
                                    <td class="border border-slate-400 px-2 py-2">
                                        {{ $data['total_penduduk'] > 0 && $belumMengisi > 0 ? number_format(($belumMengisi / $data['total_penduduk']) * 100, 2) : '0,00' }}%
                                    </td>
                                    <td class="border border-slate-400 px-2 py-2 text-slate-400">-</td>
                                    <td class="border border-slate-400 px-2 py-2">0,00%</td>
                                    <td class="border border-slate-400 px-2 py-2 text-slate-400">-</td>
                                    <td class="border border-slate-400 px-2 py-2">0,00%</td>
                                </tr>
                                {{-- TOTAL --}}
                                <tr class="bg-emerald-50 dark:bg-emerald-900/20 font-bold text-center">
                                    <td class="border border-slate-400 px-2 py-2 text-slate-500">—</td>
                                    <td
                                        class="border border-slate-400 px-3 py-2 text-left text-emerald-800 dark:text-emerald-300">
                                        TOTAL</td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-700 dark:text-emerald-300">
                                        {{ number_format($data['total_penduduk']) }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-600 dark:text-emerald-400">
                                        100,00%</td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-700 dark:text-emerald-300">
                                        {{ number_format($totalLaki) }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-600 dark:text-emerald-400">
                                        {{ $data['total_penduduk'] > 0 ? number_format(($totalLaki / $data['total_penduduk']) * 100, 2) : '0,00' }}%
                                    </td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-700 dark:text-emerald-300">
                                        {{ number_format($totalPerempuan) }}</td>
                                    <td class="border border-slate-400 px-2 py-2 text-emerald-600 dark:text-emerald-400">
                                        {{ $data['total_penduduk'] > 0 ? number_format(($totalPerempuan / $data['total_penduduk']) * 100, 2) : '0,00' }}%
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL CETAK ===== --}}
    <div id="modalCetak" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Cetak Data</h3>
                <button onclick="closeModal('modalCetak')"
                    class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div x-data="{
                    open: false,
                    search: '',
                    selected: '',
                    selectedLabel: '',
                    options: [
                        @foreach ($data['perangkatList'] as $p)
                            {value:'{{ $p->nama }}', label:'{{ addslashes($p->nama) }}{{ !empty($p->jabatan) ? ' (' . addslashes($p->jabatan) . ')' : '' }}'}, @endforeach
                    ],
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        this.selectedLabel = opt.label;
                        document.getElementById('cetakPenandatangan').value = opt.value;
                        this.open = false;
                        this.search = '';
                    }
                }" @click.away="open = false" class="relative">
                    <input type="hidden" id="cetakPenandatangan" value="">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Laporan
                        Ditandatangani</label>
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                        :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' :
                            'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                        <span
                            :class="selectedLabel ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"
                            x-text="selectedLabel || 'Pilih Staf Pemerintah Desa'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-full z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                        style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false"
                                placeholder="Cari nama..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <li @click="selected=''; selectedLabel=''; document.getElementById('cetakPenandatangan').value=''; open=false; search='';"
                                class="px-3 py-2 text-sm cursor-pointer text-gray-400 dark:text-slate-500 italic hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                                Pilih Staf Pemerintah Desa</li>
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected == opt.value ?
                                        'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white' :
                                        'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                            <li x-show="filtered.length === 0" class="px-3 py-2 text-xs text-gray-400 italic">Tidak
                                ditemukan</li>
                        </ul>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Laporan No. <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="cetakNomor" placeholder="Wajib diisi"
                        class="w-full text-sm border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-colors"
                        oninput="clearError('cetakNomorError', this)">
                    <p id="cetakNomorError" class="hidden mt-1 text-xs text-red-500 font-medium">⚠ Laporan No. wajib diisi
                        sebelum mencetak.</p>
                </div>
            </div>
            <div class="flex justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 gap-3">
                <button onclick="closeModal('modalCetak')"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
                <button onclick="doCetak()"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
            </div>
        </div>
    </div>

    {{-- ===== MODAL UNDUH ===== --}}
    <div id="modalUnduh" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Unduh Data</h3>
                <button onclick="closeModal('modalUnduh')"
                    class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div x-data="{
                    open: false,
                    search: '',
                    selected: '',
                    selectedLabel: '',
                    options: [
                        @foreach ($data['perangkatList'] as $p)
                            {value:'{{ $p->nama }}', label:'{{ addslashes($p->nama) }}{{ !empty($p->jabatan) ? ' (' . addslashes($p->jabatan) . ')' : '' }}'}, @endforeach
                    ],
                    get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                    choose(opt) {
                        this.selected = opt.value;
                        this.selectedLabel = opt.label;
                        document.getElementById('unduhPenandatangan').value = opt.value;
                        this.open = false;
                        this.search = '';
                    }
                }" @click.away="open = false" class="relative">
                    <input type="hidden" id="unduhPenandatangan" value="">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Laporan
                        Ditandatangani</label>
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                        :class="open ? 'border-teal-500 ring-2 ring-teal-500/20' :
                            'border-gray-300 dark:border-slate-600 hover:border-teal-400'">
                        <span
                            :class="selectedLabel ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"
                            x-text="selectedLabel || 'Pilih Staf Pemerintah Desa'"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute left-0 top-full mt-1 w-full z-[200] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                        style="display:none">
                        <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                            <input type="text" x-model="search" @keydown.escape="open = false"
                                placeholder="Cari nama..."
                                class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-teal-500">
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <li @click="selected=''; selectedLabel=''; document.getElementById('unduhPenandatangan').value=''; open=false; search='';"
                                class="px-3 py-2 text-sm cursor-pointer text-gray-400 dark:text-slate-500 italic hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                                Pilih Staf Pemerintah Desa</li>
                            <template x-for="opt in filtered" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700 dark:hover:text-teal-400"
                                    :class="selected == opt.value ?
                                        'bg-teal-500 text-white hover:bg-teal-600 hover:text-white' :
                                        'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label"></li>
                            </template>
                            <li x-show="filtered.length === 0" class="px-3 py-2 text-xs text-gray-400 italic">Tidak
                                ditemukan</li>
                        </ul>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Laporan No. <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="unduhNomor" placeholder="Wajib diisi"
                        class="w-full text-sm border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none transition-colors"
                        oninput="clearError('unduhNomorError', this)">
                    <p id="unduhNomorError" class="hidden mt-1 text-xs text-red-500 font-medium">⚠ Laporan No. wajib diisi
                        sebelum mengunduh.</p>
                </div>
            </div>
            <div class="flex justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 gap-3">
                <button onclick="closeModal('modalUnduh')"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </button>
                <button onclick="doUnduh()"
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        const chartLabels = @json(array_column($rows, 'label'));
        const chartLaki = @json(array_column($rows, 'laki'));
        const chartPerempuan = @json(array_column($rows, 'perempuan'));
        const chartTotal = @json(array_column($rows, 'total'));
        const rowsData = @json($rows); // ← dipakai Alpine sortable table
        const judulAktif = @json($judulAktif);

        let chartInstance = null;

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        ['modalCetak', 'modalUnduh'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) closeModal(id);
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('modalCetak');
                closeModal('modalUnduh');
            }
        });

        function clearError(errorId, inputEl) {
            const errEl = document.getElementById(errorId);
            if (errEl && inputEl.value.trim() !== '') {
                errEl.classList.add('hidden');
                inputEl.classList.remove('border-red-500');
            }
        }

        function showError(errorId, inputId) {
            const errEl = document.getElementById(errorId);
            const inputEl = document.getElementById(inputId);
            if (errEl) errEl.classList.remove('hidden');
            if (inputEl) {
                inputEl.classList.add('border-red-500');
                inputEl.focus();
            }
        }

        function showChart(type) {
            const area = document.getElementById('chartArea');
            area.classList.remove('hidden');
            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }
            const ctx = document.getElementById('mainChart');
            const colors = ['#3B82F6', '#EC4899', '#8B5CF6', '#F59E0B', '#10B981', '#F97316', '#EF4444', '#06B6D4',
                '#6366F1', '#84CC16'
            ];

            if (type === 'bar') {
                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                                label: 'Laki-laki',
                                data: chartLaki,
                                backgroundColor: '#3B82F6',
                                borderRadius: 4
                            },
                            {
                                label: 'Perempuan',
                                data: chartPerempuan,
                                backgroundColor: '#EC4899',
                                borderRadius: 4
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 16
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } else {
                chartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: chartTotal,
                            backgroundColor: colors.slice(0, chartLabels.length),
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    padding: 12,
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(ctx) {
                                        const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        const pct = total > 0 ? ((ctx.raw / total) * 100).toFixed(2) : 0;
                                        return ` ${ctx.label}: ${ctx.raw} (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        function hideChart() {
            document.getElementById('chartArea').classList.add('hidden');
            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }
        }

        function doCetak() {
            const nomor = document.getElementById('cetakNomor').value.trim();
            if (!nomor) {
                showError('cetakNomorError', 'cetakNomor');
                return;
            }
            const penandatangan = document.getElementById('cetakPenandatangan').value;
            let info = document.getElementById('printInfo');
            if (!info) {
                info = document.createElement('div');
                info.id = 'printInfo';
                info.className = 'print-only mb-3 text-sm';
                document.getElementById('tabelUtama').prepend(info);
            }
            info.innerHTML =
                `<p><strong>No. Laporan:</strong> ${nomor}</p><p><strong>Ditandatangani:</strong> ${penandatangan}</p>`;
            closeModal('modalCetak');
            setTimeout(() => window.print(), 200);
        }

        function doUnduh() {
            const nomor = document.getElementById('unduhNomor').value.trim();
            if (!nomor) {
                showError('unduhNomorError', 'unduhNomor');
                return;
            }
            const header = ['No', 'Kelompok', 'Total', 'Persen (%)', 'Laki-laki', 'Persen L (%)', 'Perempuan',
                'Persen P (%)'
            ];
            const lines = [
                '"Statistik ' + judulAktif + '"',
                '"No. Laporan: ' + nomor + '"',
                header.join(',')
            ];
            rowsData.forEach((r, i) => {
                lines.push([i + 1, '"' + r.label + '"', r.total, r.persen, r.laki, r.persen_laki, r.perempuan, r
                    .persen_perempuan
                ].join(','));
            });
            lines.push(['', 'JUMLAH', {{ $totalRow }}, '100.00', {{ $totalLaki }}, '', {{ $totalPerempuan }}, '']
                .join(','));
            const blob = new Blob([lines.join('\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'statistik_{{ $data['kategori'] }}.csv';
            a.click();
            closeModal('modalUnduh');
        }
    </script>

    <style>
        .print-only {
            display: none;
        }

        @media print {

            nav,
            aside,
            header,
            #modalCetak,
            #modalUnduh,
            button,
            form,
            #chartArea {
                display: none !important;
            }

            .print-only {
                display: block !important;
            }

            body {
                background: white !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #cbd5e1 !important;
                padding: 4px 8px;
                font-size: 11px;
            }
        }
    </style>

@endsection
