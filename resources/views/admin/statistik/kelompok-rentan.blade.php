{{--
    resources/views/admin/statistik/kelompok-rentan.blade.php
    Laporan Kelompok Rentan — DATA PILAH KEPENDUDUKAN LAMPIRAN A-9
--}}
@extends('layouts.admin')

@section('title', 'Laporan Kelompok Rentan')

@push('styles')
<style>
/* ── Header grup warna — emerald/teal palette ── */
.th-dusun { background: #064e3b !important; color: #fff; } /* emerald-900 */
.th-kk    { background: #065f46 !important; color: #fff; } /* emerald-800 */
.th-umur  { background: #0f766e !important; color: #fff; } /* teal-700    */
.th-disab { background: #334155 !important; color: #fff; } /* slate-700   */
.th-sakit { background: #166534 !important; color: #fff; } /* green-800   */
.th-hamil { background: #115e59 !important; color: #fff; } /* teal-800    */

@media print {
    .no-print, aside, header { display: none !important; }
    main, section { padding: 0 !important; overflow: visible !important; }
    body, html { background: #fff !important; }
    .print-card { border: none !important; box-shadow: none !important; border-radius: 0 !important; }
    table th, table td { font-size: 6pt !important; padding: 3px 4px !important; }
}
</style>
@endpush

@section('content')

{{-- ══ PAGE HEADER ════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-5 no-print">
    <div>
        <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">Laporan Kelompok Rentan</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
            Data pilah kependudukan menurut umur dan faktor kerentanan (Lampiran A-9)
        </p>
    </div>
    <nav class="flex items-center gap-1.5 text-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Beranda
        </a>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-400 dark:text-slate-500">Statistik</span>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Laporan Kelompok Rentan</span>
    </nav>
</div>

{{-- ══ TOMBOL CETAK & UNDUH — identik dengan laporan-bulanan ══════════ --}}
<div class="flex gap-3 mb-5 no-print">
    <button onclick="window.print()"
        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Cetak
    </button>
    <button onclick="unduhExcel()"
        class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition flex items-center gap-2 text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        Unduh Excel
    </button>
</div>

{{-- ══ CARD UTAMA ══════════════════════════════════════════════════════ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-6 print-card">

    {{-- ── FILTER — identik strukturnya dengan laporan-bulanan ── --}}
    <form method="GET" action="{{ route('admin.statistik.kelompok-rentan') }}" id="form-filter"
          class="flex flex-wrap gap-4 mb-6 items-end no-print">
        <input type="hidden" name="dusun" id="val-dusun" value="{{ $data['dusunFilter'] }}">

        {{-- Custom dropdown Dusun dengan search ── --}}
        <div x-data="{
                open: false,
                search: '',
                selected: '{{ $data['dusunFilter'] }}',
                options: {{ json_encode(array_merge(
                    [['value' => '', 'label' => 'Semua Dusun']],
                    collect($data['dusunList'])->map(fn($d) => ['value' => $d, 'label' => $d])->toArray()
                )) }},
                get filtered() {
                    return !this.search
                        ? this.options
                        : this.options.filter(o => o.label.toLowerCase().includes(this.search.toLowerCase()));
                },
                get selectedLabel() {
                    const f = this.options.find(o => o.value === this.selected);
                    return f ? f.label : 'Semua Dusun';
                },
                choose(opt) {
                    this.selected = opt.value;
                    document.getElementById('val-dusun').value = opt.value;
                    this.open = false;
                    this.search = '';
                    document.getElementById('form-filter').submit();
                }
            }"
            @click.away="open = false"
            class="relative w-52">

            <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1 uppercase tracking-wide">Dusun</label>

            <button type="button" @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm cursor-pointer bg-white dark:bg-slate-700 focus:outline-none transition-colors"
                :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-gray-300 dark:border-slate-600 hover:border-emerald-400'">
                <span x-text="selectedLabel" class="text-gray-800 dark:text-slate-200 truncate"></span>
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform ml-2"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="absolute left-0 top-full mt-1 w-full z-[100] bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg overflow-hidden"
                style="display:none">

                {{-- Search box — sama dengan laporan-bulanan --}}
                <div class="p-2 border-b border-gray-100 dark:border-slate-700">
                    <input type="text" x-model="search" @keydown.escape="open = false"
                        placeholder="Cari dusun..."
                        class="w-full px-2 py-1.5 text-sm bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded text-gray-700 dark:text-slate-200 outline-none focus:border-emerald-500">
                </div>

                <ul class="max-h-48 overflow-y-auto py-1">
                    <template x-for="opt in filtered" :key="opt.value">
                        <li @click="choose(opt)"
                            class="px-3 py-2 text-sm cursor-pointer transition-colors hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-400"
                            :class="selected === opt.value
                                ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white'
                                : 'text-gray-700 dark:text-slate-200'"
                            x-text="opt.label">
                        </li>
                    </template>
                    <li x-show="filtered.length === 0"
                        class="px-3 py-2 text-xs text-gray-400 italic">Tidak ditemukan</li>
                </ul>
            </div>
        </div>
    </form>

    {{-- ── KOP LAPORAN — identik dengan laporan-bulanan ── --}}
    @php
        $identitas = $data['identitas'];
        $kabupaten = $identitas->kabupaten ?? ($identitas->nama_kabupaten ?? '');
        $namaDesa  = $identitas->nama_desa  ?? ($identitas->nama ?? '');
        $kecamatan = $identitas->kecamatan  ?? ($identitas->nama_kecamatan ?? '');
    @endphp

    <div class="text-center mb-4">
        <p class="font-bold text-base uppercase">
            PEMERINTAH KABUPATEN/KOTA {{ strtoupper($kabupaten) }}
        </p>
        <p class="font-bold text-sm uppercase mt-1">
            DATA PILAH KEPENDUDUKAN MENURUT UMUR DAN FAKTOR KERENTANAN (LAMPIRAN A - 9)
        </p>
    </div>

    {{-- Info Desa & Periode — identik dengan laporan-bulanan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 mb-5 text-sm">
        <div class="flex gap-2">
            <span class="w-32 text-slate-500">Desa/Kelurahan</span>
            <span class="font-semibold">: {{ $namaDesa }}</span>
        </div>
        <div class="flex gap-2">
            <span class="w-32 text-slate-500">Kecamatan</span>
            <span class="font-semibold">: {{ $kecamatan }}</span>
        </div>
        <div class="flex gap-2">
            <span class="w-32 text-slate-500">Tahun</span>
            <span class="font-semibold">: {{ $data['tahun'] }}</span>
        </div>
        <div class="flex gap-2">
            <span class="w-32 text-slate-500">Bulan</span>
            <span class="font-semibold">: {{ $data['bulanList'][$data['bulan']] ?? '-' }}</span>
        </div>
        <div class="flex gap-2">
            <span class="w-32 text-slate-500">Dusun</span>
            <span class="font-semibold">: {{ $data['dusunFilter'] ?: 'Semua' }}</span>
        </div>
    </div>

    {{-- ══ TABEL — border/padding/font identik dengan laporan-bulanan ══ --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-xs" style="min-width: max-content;">
            <thead>
                {{-- Baris 1: Grup besar --}}
                <tr class="text-center">
                    <th rowspan="2" class="th-dusun border border-slate-400 px-2 py-2" style="min-width:110px">DUSUN</th>
                    <th rowspan="2" class="th-dusun border border-slate-400 px-2 py-2 w-10">RW</th>
                    <th rowspan="2" class="th-dusun border border-slate-400 px-2 py-2 w-10">RT</th>
                    <th colspan="2" class="th-kk    border border-slate-400 px-2 py-1">KK</th>
                    <th colspan="6" class="th-umur  border border-slate-400 px-2 py-1">KONDISI DAN KELOMPOK UMUR</th>
                    <th colspan="7" class="th-disab border border-slate-400 px-2 py-1">DISABILITAS</th>
                    <th colspan="2" class="th-sakit border border-slate-400 px-2 py-1">SAKIT MENAHUN</th>
                    <th rowspan="2" class="th-hamil border border-slate-400 px-2 py-2 w-12">HAMIL</th>
                </tr>
                {{-- Baris 2: Sub-kolom --}}
                <tr class="text-center">
                    <th class="th-kk    border border-slate-400 px-2 py-1 w-10">L</th>
                    <th class="th-kk    border border-slate-400 px-2 py-1 w-10">P</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1" style="min-width:66px">DI BAWAH<br>1 TAHUN</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1 w-12">1-5<br>TAHUN</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1 w-12">6-12<br>TAHUN</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1 w-12">13-15<br>TAHUN</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1 w-12">16-18<br>TAHUN</th>
                    <th class="th-umur  border border-slate-400 px-2 py-1" style="min-width:66px">DI ATAS<br>60 TAHUN</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">DISABILITAS<br>FISIK</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">DISABILITAS<br>NETRA/<br>BUTA</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">DISABILITAS<br>RUNGU/<br>WICARA</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">DISABILITAS<br>MENTAL/<br>JIWA</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:78px">DISABILITAS<br>FISIK DAN<br>MENTAL</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">DISABILITAS<br>LAINNYA</th>
                    <th class="th-disab border border-slate-400 px-2 py-1" style="min-width:70px">TIDAK<br>DISABILITAS</th>
                    <th class="th-sakit border border-slate-400 px-2 py-1 w-10">L</th>
                    <th class="th-sakit border border-slate-400 px-2 py-1 w-10">P</th>
                </tr>
                {{-- Baris 3: Nomor kolom — identik dengan laporan-bulanan --}}
                <tr class="bg-slate-200 text-center font-bold text-slate-600">
                    @foreach(range(1, 21) as $n)
                        <th class="border border-slate-400 px-2 py-1">{{ $n }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @php
                    $colKeys   = [
                        'kk_l','kk_p',
                        'umur_bawah_1','umur_1_5','umur_6_12','umur_13_15','umur_16_18','umur_atas_60',
                        'disab_fisik','disab_netra','disab_rungu','disab_mental','disab_fisik_mental','disab_lainnya','tidak_disabilitas',
                        'sakit_l','sakit_p','hamil',
                    ];
                    $totals    = array_fill_keys($colKeys, 0);
                    $numClass  = 'text-emerald-600 font-semibold';
                    $zeroClass = 'text-slate-400';
                    $fmt = fn($v) => $v ? $v : '-';
                    $cls = fn($v) => $v ? $numClass : $zeroClass;
                @endphp

                @forelse($data['tableRows'] as $row)
                    @php foreach ($colKeys as $c) $totals[$c] += (int)($row->$c ?? 0); @endphp
                    <tr class="hover:bg-gray-50 text-center">
                        <td class="border border-slate-300 px-3 py-2 text-left text-slate-700 font-semibold">{{ $row->dusun ?? '-' }}</td>
                        <td class="border border-slate-300 px-2 py-2 text-slate-500">{{ $row->rw ?? '-' }}</td>
                        <td class="border border-slate-300 px-2 py-2 text-slate-500">{{ $row->rt ?? '-' }}</td>

                        @foreach($colKeys as $c)
                            @php $val = (int)($row->$c ?? 0); @endphp
                            <td class="border border-slate-300 px-2 py-2 {{ $cls($val) }}">{{ $fmt($val) }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="21" class="border border-slate-300 py-14 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">
                                    Data belum tersedia untuk filter yang dipilih.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- Footer total — konsisten warna emerald --}}
            <tfoot>
                <tr class="bg-emerald-50 dark:bg-emerald-900/20 font-bold text-center">
                    <td class="border border-slate-400 px-3 py-2 text-left text-emerald-800 dark:text-emerald-300"
                        colspan="3">TOTAL</td>
                    @foreach($colKeys as $c)
                        <td class="border border-slate-400 px-2 py-2 text-emerald-700 dark:text-emerald-300">
                            {{ $totals[$c] }}
                        </td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Footer info --}}
    <div class="mt-3 text-xs text-gray-400 dark:text-slate-500 no-print">
        Menampilkan {{ count($data['tableRows']) }} baris data
        @if($data['dusunFilter'])
            &mdash; Dusun: <span class="font-semibold text-gray-600 dark:text-slate-300">{{ $data['dusunFilter'] }}</span>
        @endif
    </div>

</div>

<script>
function unduhExcel() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("admin.statistik.kelompok-rentan") }}?' + params.toString();
}
</script>

@endsection