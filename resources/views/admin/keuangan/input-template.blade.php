@extends('layouts.admin')

@section('content')
    <div x-data="{}" class="font-sans text-slate-800 dark:text-slate-200">

        {{-- ══ Page Header ══ --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Template Anggaran Keuangan</h2>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Kelola data template anggaran keuangan desa</p>
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
                <span class="text-gray-600 dark:text-slate-300 font-medium">Template Anggaran</span>
            </nav>
        </div>

        {{-- ══ Main Card ══ --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700"
            style="overflow: visible">

            {{-- ── Toolbar ── --}}
            <div class="flex flex-wrap items-center gap-2 px-5 pt-5 pb-4 border-b border-gray-100 dark:border-slate-700">

                {{-- Tambah Template --}}
                <button type="button" onclick="openModal('modalTambahTemplate')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Template
                </button>

                {{-- ✅ FIX: Impor sekarang buka modal, bukan pindah halaman --}}
                <button type="button" onclick="openModal('modalImpor')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    Impor
                </button>

            </div>

            {{-- ── Filter Bar ──
             overflow: visible agar dropdown tidak ter-clip --}}
            <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50"
                style="overflow: visible">
                <form method="GET" action="{{ route('admin.keuangan.input.index') }}" id="filterForm"
                    class="flex flex-wrap items-center gap-2" style="overflow: visible">

                    <input type="hidden" name="filter_kode" id="val-filter-kode" value="{{ request('filter_kode') }}">
                    <input type="hidden" name="tahun" id="val-tahun" value="{{ $tahunDipilih }}">

                    {{-- ── Pilih Jenis Anggaran ──
                     ✅ FIX WIDTH: tombol fixed w-56, dropdown list min-width 340px (lebih lebar)
                     ✅ FIX TRUNCATE: teks panjang di-truncate di tombol, list tampil penuh --}}
                    <div class="relative" style="overflow: visible; width: 14rem;" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ request('filter_kode') }}',
                        placeholder: 'Pilih Jenis Anggaran',
                        options: [
                            @if (isset($groupedDataDropdown)) {{-- ← ganti dari $groupedData --}}
        @foreach ($groupedDataDropdown as $lvl1Kode => $dataL1)
            @if ($dataL1['induk'])
                @php
                    $l1k = $dataL1['induk']->akunRekening->kode_rekening;
                    $l1u = $dataL1['induk']->akunRekening->uraian;
                @endphp
                { value: '{{ $l1k }}', label: '{{ $l1k }} – {{ addslashes($l1u) }}', indent: 0 },
                @foreach ($dataL1['kelompok'] as $lvl2Kode => $dataL2)
                    @if ($dataL2['header'])
                        @php
                            $l2k = $dataL2['header']->akunRekening->kode_rekening;
                            $l2u = $dataL2['header']->akunRekening->uraian;
                        @endphp
                        { value: '{{ $l2k }}', label: '{{ $l2k }} – {{ addslashes($l2u) }}', indent: 1 }, @endif
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-filter-kode').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('filterForm').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-filter-kode').value = '';
                            this.open = false;
                            this.search = '';
                            document.getElementById('filterForm').submit();
                        }
                    }"
                        @click.away="open = false">

                        {{-- Tombol trigger: lebar fixed, teks di-truncate --}}
                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between gap-2 px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors min-w-0"
                            :class="open
                                ?
                                'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                            {{-- ✅ overflow:hidden + truncate agar tidak gendut --}}
                            <span class="truncate min-w-0 flex-1 text-left" x-text="label || placeholder"
                                :class="label ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown list: LEBIH LEBAR dari tombol agar teks terbaca penuh --}}
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-0 top-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                            style="z-index: 9999; min-width: 340px; display: none;">

                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari jenis anggaran..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                            </div>

                            <ul class="max-h-60 overflow-y-auto py-1">
                                <li @click="reset()"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors whitespace-nowrap"
                                    :class="selected === ''
                                        ?
                                        'bg-emerald-500 text-white' :
                                        'text-gray-400 dark:text-slate-500 italic hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700'">
                                    Semua Jenis Anggaran
                                </li>

                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)"
                                        class="py-2 text-sm cursor-pointer transition-colors whitespace-nowrap"
                                        :class="[
                                            selected === opt.value ?
                                            'bg-emerald-500 text-white' :
                                            'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700',
                                            opt.indent === 1 ? 'pl-7 pr-3' : 'px-3'
                                        ]"
                                        x-text="opt.label">
                                    </li>
                                </template>

                                <li x-show="filtered.length === 0"
                                    class="px-3 py-3 text-sm text-center text-gray-400 dark:text-slate-500 italic">
                                    Tidak ada hasil
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- ── Pilih Tahun Anggaran ── --}}
                    <div class="relative" style="overflow: visible; width: 12rem;" x-data="{
                        open: false,
                        search: '',
                        selected: '{{ $tahunDipilih }}',
                        placeholder: 'Pilih Tahun Anggaran',
                        options: [
                            @foreach ($availableYears as $y)
                            { value: '{{ $y }}', label: 'Tahun {{ $y }}' }, @endforeach
                        ],
                        get label() { return this.options.find(o => o.value === this.selected)?.label ?? ''; },
                        get filtered() { return !this.search ? this.options : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase())); },
                        choose(opt) {
                            this.selected = opt.value;
                            document.getElementById('val-tahun').value = opt.value;
                            this.open = false;
                            this.search = '';
                            document.getElementById('filterForm').submit();
                        },
                        reset() {
                            this.selected = '';
                            document.getElementById('val-tahun').value = '';
                            this.open = false;
                            this.search = '';
                            document.getElementById('filterForm').submit();
                        }
                    }"
                        @click.away="open = false">

                        <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between gap-2 px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                            :class="open
                                ?
                                'border-emerald-500 ring-2 ring-emerald-500/20' :
                                'border-gray-300 dark:border-slate-600 hover:border-emerald-400 dark:hover:border-emerald-500'">
                            <span class="truncate flex-1 text-left" x-text="label || placeholder"
                                :class="label ? 'text-gray-800 dark:text-slate-200' : 'text-gray-400 dark:text-slate-500'"></span>
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-0 top-full mt-1 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-xl overflow-hidden"
                            style="z-index: 9999; display: none;">

                            <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                                <input type="text" x-model="search" @keydown.escape="open = false"
                                    placeholder="Cari tahun..."
                                    class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                            </div>

                            <ul class="max-h-48 overflow-y-auto py-1">
                                <li @click="reset()" class="px-3 py-2 text-sm cursor-pointer transition-colors"
                                    :class="selected === ''
                                        ?
                                        'bg-emerald-500 text-white' :
                                        'text-gray-400 dark:text-slate-500 italic hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700'">
                                    Semua Tahun
                                </li>
                                <template x-for="opt in filtered" :key="opt.value">
                                    <li @click="choose(opt)" class="px-3 py-2 text-sm cursor-pointer transition-colors"
                                        :class="selected === opt.value ?
                                            'bg-emerald-500 text-white' :
                                            'text-gray-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700'"
                                        x-text="opt.label">
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                </form>
            </div>

            {{-- ── Cari ── --}}
            @php
                $totalEntri = 0;
                if (isset($groupedData)) {
                    foreach ($groupedData as $d1) {
                        foreach ($d1['kelompok'] as $d2) {
                            $totalEntri += count($d2['items']);
                        }
                    }
                }
            @endphp
            <div
                class="flex flex-wrap items-center justify-end gap-3 px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <form method="GET" action="{{ route('admin.keuangan.input.index') }}" class="flex items-center gap-2">
                    @foreach (request()->except('search', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <label class="text-sm text-gray-600 dark:text-slate-400">Cari:</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="kata kunci pencarian" maxlength="50"
                            class="px-3 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm w-52">
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
                </form>
            </div>

            {{-- ══ Tabel ══ --}}
            @if (isset($groupedData) && count($groupedData) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="mainTable">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-10">
                                    NO</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-16">
                                    AKSI</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-36">
                                    KODE REKENING</th>
                                <th
                                    class="px-3 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">
                                    URAIAN</th>
                                <th
                                    class="px-3 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-44">
                                    ANGGARAN</th>
                                <th
                                    class="px-3 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider w-44">
                                    REALISASI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700" id="tableBody">
                            @php
                                $rowNo = 0;
                                $l1Kode = null;
                            @endphp

                            @foreach ($groupedData as $lvl1Kode => $dataL1)

                                @if ($dataL1['induk'])
                                    @php
                                        $itemL1 = $dataL1['induk'];
                                        $rowNo++;
                                        $l1Kode = $itemL1->akunRekening->kode_rekening;
                                    @endphp
                                    <tr class="tabel-row border-b-2 border-gray-300 dark:border-slate-600"
                                        data-id="{{ $itemL1->id }}" data-kode="{{ $l1Kode }}"
                                        data-anggaran="{{ $itemL1->anggaran }}"
                                        data-realisasi="{{ $itemL1->realisasi }}" data-editable="0">
                                        <td class="px-3 py-3 text-xs text-gray-600 dark:text-slate-400">
                                            {{ $rowNo }}</td>
                                        <td class="px-3 py-3"></td>
                                        <td
                                            class="px-3 py-3 font-mono text-xs font-bold text-gray-800 dark:text-slate-200">
                                            {{ $l1Kode }}</td>
                                        <td
                                            class="px-3 py-3 text-xs font-bold text-gray-900 dark:text-slate-100 uppercase tracking-wide">
                                            {{ $itemL1->akunRekening->uraian }}</td>
                                        <td
                                            class="px-3 py-3 text-right text-xs font-bold text-gray-800 dark:text-slate-200">
                                            Rp <span
                                                class="anggaran-display">{{ number_format($itemL1->anggaran, 0, ',', '.') }}</span>
                                        </td>
                                        <td
                                            class="px-3 py-3 text-right text-xs font-bold text-gray-800 dark:text-slate-200">
                                            Rp <span
                                                class="realisasi-display">{{ number_format($itemL1->realisasi, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endif

                                @foreach ($dataL1['kelompok'] as $lvl2Kode => $dataL2)

                                    @if ($dataL2['header'])
                                        @php
                                            $itemL2 = $dataL2['header'];
                                            $rowNo++;
                                            $l2Kode = $itemL2->akunRekening->kode_rekening;
                                        @endphp
                                        <tr class="tabel-row bg-gray-50 dark:bg-slate-700/30"
                                            data-id="{{ $itemL2->id }}" data-kode="{{ $l2Kode }}"
                                            data-anggaran="{{ $itemL2->anggaran }}"
                                            data-realisasi="{{ $itemL2->realisasi }}" data-editable="0">
                                            <td class="px-3 py-2.5 text-xs text-gray-500 dark:text-slate-400">
                                                {{ $rowNo }}</td>
                                            <td class="px-3 py-2.5"></td>
                                            <td
                                                class="px-3 py-2.5 font-mono text-xs font-bold text-gray-700 dark:text-slate-300">
                                                {{ $l2Kode }}</td>
                                            <td class="px-3 py-2.5 text-sm font-bold text-gray-800 dark:text-slate-200">
                                                {{ $itemL2->akunRekening->uraian }}</td>
                                            <td
                                                class="px-3 py-2.5 text-right text-sm font-bold text-gray-700 dark:text-slate-300">
                                                Rp <span
                                                    class="anggaran-display">{{ number_format($itemL2->anggaran, 0, ',', '.') }}</span>
                                            </td>
                                            <td
                                                class="px-3 py-2.5 text-right text-sm font-bold text-gray-700 dark:text-slate-300">
                                                Rp <span
                                                    class="realisasi-display">{{ number_format($itemL2->realisasi, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endif

                                    @foreach ($dataL2['items'] as $item)
                                        @php
                                            $isInduk = !$item->akunRekening->is_editable;
                                            $kode = $item->akunRekening->kode_rekening;
                                            $level = max(substr_count($kode, '.') - 1, 0);
                                            $indent = $level * 16 + 12;
                                            $rowNo++;
                                        @endphp
                                        <tr class="tabel-row hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors {{ $isInduk ? 'bg-gray-50 dark:bg-slate-700/20' : 'bg-white dark:bg-slate-800' }}"
                                            data-id="{{ $item->id }}" data-kode="{{ $kode }}"
                                            data-anggaran="{{ $item->anggaran }}"
                                            data-realisasi="{{ $item->realisasi }}"
                                            data-editable="{{ $isInduk ? '0' : '1' }}">

                                            <td class="px-3 py-2.5 text-xs text-gray-500 dark:text-slate-400 tabular-nums">
                                                {{ $rowNo }}</td>

                                            <td class="px-3 py-2.5">
                                                @if (!$isInduk)
                                                    <button type="button" title="Edit Nominal"
                                                        onclick="openEditModal({{ $item->id }}, {{ $item->anggaran }}, {{ $item->realisasi }}, '{{ addslashes($item->akunRekening->uraian) }}', '{{ $kode }}')"
                                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </td>

                                            <td
                                                class="px-3 py-2.5 font-mono text-xs font-semibold text-gray-500 dark:text-slate-400">
                                                {{ $kode }}</td>

                                            <td class="py-2.5 text-sm {{ $isInduk ? 'font-semibold text-gray-700 dark:text-slate-300' : 'text-gray-600 dark:text-slate-400' }}"
                                                style="padding-left: {{ $indent }}px; padding-right: 12px;">
                                                {{ $item->akunRekening->uraian }}
                                            </td>

                                            <td
                                                class="px-3 py-2.5 text-right text-sm {{ $isInduk ? 'font-bold text-gray-800 dark:text-slate-200' : 'font-medium text-gray-700 dark:text-slate-300' }}">
                                                Rp <span
                                                    class="anggaran-display">{{ number_format($item->anggaran, 0, ',', '.') }}</span>
                                            </td>

                                            <td
                                                class="px-3 py-2.5 text-right text-sm {{ $isInduk ? 'font-bold text-gray-800 dark:text-slate-200' : 'font-medium text-gray-700 dark:text-slate-300' }}">
                                                Rp <span
                                                    class="realisasi-display">{{ number_format($item->realisasi, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (count($dataL2['items']) === 0)
                                        <tr class="bg-white dark:bg-slate-800">
                                            <td colspan="6"
                                                class="px-6 py-5 text-center text-sm text-gray-400 dark:text-slate-500 italic">
                                                Belum ada sub-rekening di kelompok ini.
                                            </td>
                                        </tr>
                                    @endif

                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                    <p class="text-sm text-gray-500 dark:text-slate-400">
                        @if ($totalEntri > 0)
                            Menampilkan <span class="font-medium text-gray-700 dark:text-slate-200">1</span>
                            sampai <span class="font-medium text-gray-700 dark:text-slate-200">{{ $totalEntri }}</span>
                            dari <span class="font-medium text-gray-700 dark:text-slate-200">{{ $totalEntri }}</span>
                            entri
                        @else
                            Menampilkan 0 sampai 0 dari 0 entri
                        @endif
                    </p>
                </div>
            @else
                <div class="flex flex-col items-center gap-3 py-20">
                    <svg class="w-14 h-14 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 dark:text-slate-400 font-medium">Data kosong untuk tahun {{ $tahunDipilih }}
                    </p>
                    <p class="text-sm text-gray-400 dark:text-slate-500">
                        Klik <strong class="text-gray-600 dark:text-slate-300">Tambah Template</strong> untuk memulai.
                    </p>
                </div>
            @endif

        </div>{{-- /.main-card --}}
    </div>


    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- MODALS                                                                 --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}

    {{-- ── Modal: Tambah Template ── --}}
    <div id="modalTambahTemplate" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[10000] items-center justify-center"
        style="display:none;">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-sm mx-4 border border-gray-200 dark:border-slate-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100">Tambah Template</h3>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Buat template anggaran untuk tahun baru</p>
                </div>
                <button onclick="closeModal('modalTambahTemplate')"
                    class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.keuangan.input.tambah-template') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Tahun
                        Anggaran</label>
                    <input type="number" name="tahun_baru" required value="{{ date('Y') }}" min="1945"
                        max="{{ date('Y') }}"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-colors">
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                    <button type="button" onclick="closeModal('modalTambahTemplate')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Modal: Edit Nominal ── --}}
    <div id="modalEditNominal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[10000] items-center justify-center"
        style="display:none;">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-sm mx-4 border border-gray-200 dark:border-slate-700">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <div
                    class="w-9 h-9 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-500 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100">Edit Nominal</h3>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Ubah nilai anggaran &amp; realisasi
                        rekening</p>
                </div>
                <button onclick="closeModal('modalEditNominal')"
                    class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="formEditNominal" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" id="edit_kode_rekening" value="">

                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Uraian
                        Rekening</label>
                    <input type="text" id="edit_uraian" readonly
                        class="w-full px-3 py-2 border border-gray-100 dark:border-slate-700 rounded-lg text-sm bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed">
                </div>

                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Anggaran
                        (Rp)</label>
                    <input type="number" name="anggaran" id="edit_anggaran" required min="0" step="1"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-colors">
                </div>

                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Realisasi
                        (Rp)</label>
                    <input type="number" name="realisasi" id="edit_realisasi" required min="0" step="1"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-colors">
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                    <button type="button" onclick="closeModal('modalEditNominal')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <button type="submit" id="btnSimpanEdit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- ✅ Modal: Impor Data Siskeudes (BARU — menggantikan navigasi halaman)  --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    <div id="modalImpor" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[10000] items-center justify-center"
        style="display:none;">
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 dark:border-slate-700">

            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 dark:text-slate-100">Impor Data Siskeudes</h3>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">Unggah berkas database Siskeudes dalam
                        format .zip</p>
                </div>
                <button onclick="closeModal('modalImpor'); resetImporForm()"
                    class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <form id="formImpor" action="{{ route('admin.keuangan.input.impor') }}" method="POST"
                enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                {{-- Drop-zone Upload --}}
                <div>
                    <label
                        class="block text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wide mb-2">
                        Berkas Database Siskeudes
                    </label>

                    <div id="dropZone"
                        class="relative border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-xl p-6 text-center
                            hover:border-emerald-400 dark:hover:border-emerald-500 hover:bg-emerald-50/40 dark:hover:bg-emerald-900/10
                            transition-colors cursor-pointer"
                        onclick="document.getElementById('fileImpor').click()" ondragover="handleDragOver(event)"
                        ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">

                        {{-- Icon cloud upload --}}
                        <svg id="dropIcon"
                            class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-slate-600 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v8" />
                        </svg>

                        <p id="dropText" class="text-sm text-gray-500 dark:text-slate-400">
                            Seret &amp; lepas berkas di sini, atau
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">klik untuk memilih</span>
                        </p>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-1">Format: <strong>.zip</strong> berisi data
                            CSV Siskeudes</p>

                        {{-- Nama file terpilih --}}
                        <div id="fileInfo"
                            class="hidden mt-3 flex items-center justify-center gap-2 px-3 py-2 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                            <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span id="fileName"
                                class="text-xs font-medium text-emerald-700 dark:text-emerald-400 truncate max-w-xs"></span>
                            <button type="button" onclick="clearFile(event)"
                                class="ml-1 text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <input type="file" id="fileImpor" name="berkas_siskeudes" accept=".zip" class="hidden"
                        onchange="handleFileSelect(this)">
                </div>

                {{-- Info box --}}
                <div
                    class="flex gap-3 px-4 py-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs text-blue-700 dark:text-blue-300 space-y-0.5">
                        <p class="font-semibold">Panduan format berkas:</p>
                        <p>Pastikan berkas <strong>.zip</strong> berisi data Siskeudes dalam format <strong>.csv</strong>.
                        </p>
                        <p>Data lama untuk tahun yang sama akan ditimpa setelah impor berhasil.</p>
                    </div>
                </div>

                {{-- Progress bar (tersembunyi saat idle) --}}
                <div id="uploadProgress" class="hidden">
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400 mb-1.5">
                        <span>Mengupload berkas…</span>
                        <span id="progressPct">0%</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                            style="width: 0%"></div>
                    </div>
                </div>

                {{-- Footer tombol --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-slate-700">
                    <button type="button" onclick="closeModal('modalImpor'); resetImporForm()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>

                    <button type="submit" id="btnSimpanImpor"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="btnImporLabel">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    {{-- JAVASCRIPT                                                             --}}
    {{-- ══════════════════════════════════════════════════════════════════════ --}}
    <script>
        (function() {
            'use strict';

            /* ══════════════════════════
             * 1. MODAL HANDLER
             * ══════════════════════════ */
            function openModal(id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.style.display = 'flex';
                el.style.alignItems = 'center';
                el.style.justifyContent = 'center';
                document.body.style.overflow = 'hidden';
            }

            function closeModal(id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.style.display = 'none';
                document.body.style.overflow = '';
            }
            window.openModal = openModal;
            window.closeModal = closeModal;

            ['modalTambahTemplate', 'modalEditNominal', 'modalImpor'].forEach(function(id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('click', function(e) {
                    if (e.target === el) {
                        closeModal(id);
                        if (id === 'modalImpor') resetImporForm();
                    }
                });
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    ['modalTambahTemplate', 'modalEditNominal', 'modalImpor'].forEach(closeModal);
                    resetImporForm();
                }
            });


            /* ══════════════════════════
             * 2. AUTO-SUM (parent recalculation)
             * ══════════════════════════ */
            function getRowMap() {
                var map = {};
                document.querySelectorAll('.tabel-row[data-kode]').forEach(function(tr) {
                    map[tr.dataset.kode] = {
                        row: tr,
                        anggaran: parseFloat(tr.dataset.anggaran) || 0,
                        realisasi: parseFloat(tr.dataset.realisasi) || 0,
                        editable: tr.dataset.editable === '1'
                    };
                });
                return map;
            }

            function getParentKode(kode) {
                var dot = kode.lastIndexOf('.');
                return dot > -1 ? kode.substring(0, dot) : null;
            }

            function updateRowDisplay(tr, anggaran, realisasi) {
                var a = tr.querySelector('.anggaran-display');
                var r = tr.querySelector('.realisasi-display');
                if (a) a.textContent = Math.round(anggaran).toLocaleString('id-ID');
                if (r) r.textContent = Math.round(realisasi).toLocaleString('id-ID');
                tr.dataset.anggaran = anggaran;
                tr.dataset.realisasi = realisasi;
            }

            function recalcParents(changedKode, newAnggaran, newRealisasi) {
                var map = getRowMap();
                if (map[changedKode]) {
                    map[changedKode].anggaran = newAnggaran;
                    map[changedKode].realisasi = newRealisasi;
                    updateRowDisplay(map[changedKode].row, newAnggaran, newRealisasi);
                }
                var ancestors = [];
                var cursor = getParentKode(changedKode);
                while (cursor) {
                    ancestors.push(cursor);
                    cursor = getParentKode(cursor);
                }
                ancestors.forEach(function(pk) {
                    if (!map[pk]) return;
                    var sumA = 0,
                        sumR = 0;
                    Object.keys(map).forEach(function(k) {
                        if (k.indexOf(pk + '.') === 0 && map[k].editable) {
                            sumA += map[k].anggaran;
                            sumR += map[k].realisasi;
                        }
                    });
                    map[pk].anggaran = sumA;
                    map[pk].realisasi = sumR;
                    updateRowDisplay(map[pk].row, sumA, sumR);
                });
            }

            function calculateAllParentsOnLoad() {
                var map = getRowMap();
                Object.keys(map).forEach(function(kode) {
                    if (!map[kode].editable) {
                        var sumA = 0,
                            sumR = 0;
                        Object.keys(map).forEach(function(childKode) {
                            if (childKode.indexOf(kode + '.') === 0 && map[childKode].editable) {
                                sumA += map[childKode].anggaran;
                                sumR += map[childKode].realisasi;
                            }
                        });
                        updateRowDisplay(map[kode].row, sumA, sumR);
                    }
                });
            }


            /* ══════════════════════════
             * 3. MODAL EDIT — AJAX
             * ══════════════════════════ */
            window.openEditModal = function(id, anggaran, realisasi, uraian, kode) {
                var form = document.getElementById('formEditNominal');
                form.action = '{{ url('admin/keuangan/input-template') }}/' + id;
                document.getElementById('edit_kode_rekening').value = kode;
                document.getElementById('edit_uraian').value = uraian;
                document.getElementById('edit_anggaran').value = anggaran;
                document.getElementById('edit_realisasi').value = realisasi;
                openModal('modalEditNominal');
                setTimeout(function() {
                    document.getElementById('edit_anggaran').focus();
                }, 120);
            };

            document.getElementById('formEditNominal').addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                var kode = document.getElementById('edit_kode_rekening').value;
                var newAnggaran = parseFloat(document.getElementById('edit_anggaran').value) || 0;
                var newRealisasi = parseFloat(document.getElementById('edit_realisasi').value) || 0;
                var btn = document.getElementById('btnSimpanEdit');

                btn.disabled = true;
                btn.textContent = 'Menyimpan…';

                fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        recalcParents(kode, newAnggaran, newRealisasi);
                        closeModal('modalEditNominal');
                    })
                    .catch(function() {
                        alert('Gagal via AJAX, mencoba metode standar…');
                        form.submit();
                    })
                    .finally(function() {
                        btn.disabled = false;
                        btn.textContent = 'Simpan Perubahan';
                    });
            });


            /* ══════════════════════════
             * 4. MODAL IMPOR — file drag & drop + XHR upload
             * ══════════════════════════ */

            /* — Drag & drop handlers — */
            window.handleDragOver = function(e) {
                e.preventDefault();
                document.getElementById('dropZone').classList.add('border-emerald-400', 'bg-emerald-50/60');
            };
            window.handleDragLeave = function(e) {
                document.getElementById('dropZone').classList.remove('border-emerald-400', 'bg-emerald-50/60');
            };
            window.handleDrop = function(e) {
                e.preventDefault();
                document.getElementById('dropZone').classList.remove('border-emerald-400', 'bg-emerald-50/60');
                var files = e.dataTransfer.files;
                if (files.length > 0) applyFile(files[0]);
            };

            /* — Input file change — */
            window.handleFileSelect = function(input) {
                if (input.files.length > 0) applyFile(input.files[0]);
            };

            function applyFile(file) {
                // Validasi ekstensi
                if (!file.name.toLowerCase().endsWith('.zip')) {
                    alert('Format berkas tidak valid. Harap unggah berkas .zip');
                    return;
                }

                // Tampilkan nama berkas
                document.getElementById('dropText').classList.add('hidden');
                document.getElementById('dropIcon').classList.add('hidden');
                var info = document.getElementById('fileInfo');
                info.classList.remove('hidden');
                info.classList.add('flex');
                document.getElementById('fileName').textContent = file.name + ' (' + formatBytes(file.size) + ')';

                // Aktifkan tombol simpan
                document.getElementById('btnSimpanImpor').disabled = false;

                // Sinkronkan ke input file jika drop
                try {
                    var dt = new DataTransfer();
                    dt.items.add(file);
                    document.getElementById('fileImpor').files = dt.files;
                } catch (err) {
                    /* Firefox lama tidak support DataTransfer constructor */
                }
            }

            /* — Hapus file — */
            window.clearFile = function(e) {
                e.stopPropagation();
                resetImporForm();
            };

            /* — Reset form impor — */
            window.resetImporForm = function() {
                document.getElementById('fileImpor').value = '';
                document.getElementById('fileName').textContent = '';
                document.getElementById('fileInfo').classList.add('hidden');
                document.getElementById('fileInfo').classList.remove('flex');
                document.getElementById('dropText').classList.remove('hidden');
                document.getElementById('dropIcon').classList.remove('hidden');
                document.getElementById('btnSimpanImpor').disabled = true;
                document.getElementById('uploadProgress').classList.add('hidden');
                document.getElementById('progressBar').style.width = '0%';
                document.getElementById('progressPct').textContent = '0%';
                document.getElementById('btnImporLabel').textContent = 'Simpan';;
            };

            /* — Submit dengan XHR agar ada progress — */
            document.getElementById('formImpor').addEventListener('submit', function(e) {
                e.preventDefault();
                var form = this;
                var fileEl = document.getElementById('fileImpor');
                if (!fileEl.files.length) {
                    alert('Pilih berkas .zip terlebih dahulu.');
                    return;
                }

                var btn = document.getElementById('btnSimpanImpor');
                btn.disabled = true;
                document.getElementById('btnImporLabel').textContent = 'Mengupload…';
                document.getElementById('uploadProgress').classList.remove('hidden');

                var xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onprogress = function(ev) {
                    if (ev.lengthComputable) {
                        var pct = Math.round((ev.loaded / ev.total) * 100);
                        document.getElementById('progressBar').style.width = pct + '%';
                        document.getElementById('progressPct').textContent = pct + '%';
                    }
                };

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        document.getElementById('btnImporLabel').textContent = 'Berhasil!';
                        setTimeout(function() {
                            closeModal('modalImpor');
                            resetImporForm();
                            window.location.reload();
                        }, 800);
                    } else {
                        try {
                            var json = JSON.parse(xhr.responseText);
                            alert('Gagal: ' + (json.message || 'Terjadi kesalahan saat impor.'));
                        } catch (err) {
                            alert('Gagal mengimpor data. Silakan coba lagi.');
                        }
                        btn.disabled = false;
                        document.getElementById('btnImporLabel').textContent = 'Simpan';;
                        document.getElementById('uploadProgress').classList.add('hidden');
                    }
                };

                xhr.onerror = function() {
                    alert('Koneksi gagal. Periksa jaringan Anda dan coba lagi.');
                    btn.disabled = false;
                    document.getElementById('btnImporLabel').textContent = 'Simpan';;
                    document.getElementById('uploadProgress').classList.add('hidden');
                };

                xhr.send(new FormData(form));
            });

            function formatBytes(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            }


            /* ══════════════════════════
             * 5. INIT
             * ══════════════════════════ */
            calculateAllParentsOnLoad();

        })();
    </script>

    {{-- ✅ Sembunyikan elemen Alpine sebelum Alpine siap (mencegah flash) --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
