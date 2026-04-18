{{--
    resources/views/admin/statistik/kelompok-rentan.blade.php
    Laporan Kelompok Rentan — DATA PILAH KEPENDUDUKAN LAMPIRAN A-9
--}}
@extends('layouts.admin')

@section('title', 'Laporan Kelompok Rentan')

@push('styles')
<style>
/* ════════════════════════════════════════════
   TABEL
════════════════════════════════════════════ */
.lr-table {
    border-collapse: collapse;
    font-size: 0.73rem;
    width: 100%;
}
.lr-table th,
.lr-table td {
    border: 1px solid #94a3b8;
    padding: 7px 11px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}
.dark .lr-table th,
.dark .lr-table td { border-color: #475569; }

.lr-table thead th {
    font-weight: 700;
    font-size: 0.67rem;
    line-height: 1.45;
    letter-spacing: 0.02em;
}
.lr-table td.td-left { text-align: left; }

/* ── Header warna grup ── */
.th-dusun { background: #1e3a8a; color: #fff; }
.th-kk    { background: #3730a3; color: #fff; }
.th-umur  { background: #1d4ed8; color: #fff; }
.th-disab { background: #7c2d12; color: #fff; }
.th-sakit { background: #14532d; color: #fff; }
.th-hamil { background: #701a75; color: #fff; }

/* ── Body: zebra striping ── */
.lr-table tbody tr:nth-child(odd)  td { background: #ffffff; }
.lr-table tbody tr:nth-child(even) td { background: #f1f5f9; }
.lr-table tbody tr:hover td { background: #dbeafe !important; }

.lr-table tbody td { color: #1e293b; }
.lr-table tbody td.td-left {
    color: #0f172a;
    font-weight: 600;
    background: #f8fafc !important;
}

/* ── Kolom angka: biru agar mudah dibedakan dari label ── */
.lr-table tbody td:not(.td-left) { color: #1d4ed8; font-weight: 500; }

/* ── Dark body ── */
.dark .lr-table tbody tr:nth-child(odd)  td { background: #1e293b; }
.dark .lr-table tbody tr:nth-child(even) td { background: #162032; }
.dark .lr-table tbody tr:hover td { background: #1e3a5f !important; }
.dark .lr-table tbody td { color: #cbd5e1; }
.dark .lr-table tbody td.td-left {
    color: #e2e8f0;
    font-weight: 600;
    background: #243447 !important;
}
.dark .lr-table tbody td:not(.td-left) { color: #93c5fd; }

/* ── Footer total ── */
.lr-table tfoot td {
    background: #f0fdf4 !important;
    border-top: 2px solid #15803d;
    font-weight: 700;
    color: #166534;
}
.lr-table tfoot td.td-left { text-align: left; }
.dark .lr-table tfoot td {
    background: rgba(20,83,45,0.3) !important;
    border-top-color: #16a34a;
    color: #86efac;
}

/* ════════════════════════════════════════════
   PRINT
════════════════════════════════════════════ */
@media print {
    .no-print,
    aside, header { display: none !important; }

    main, section { padding: 0 !important; overflow: visible !important; }
    body, html { background: #fff !important; }
    .print-card { border: none !important; box-shadow: none !important; border-radius: 0 !important; }

    .lr-table th, .lr-table td { font-size: 6.5pt; padding: 3px 5px; border-color: #999 !important; }
    .lr-table tbody tr:nth-child(odd)  td { background: #fff !important; }
    .lr-table tbody tr:nth-child(even) td { background: #f5f5f5 !important; }
    .lr-table tbody td { color: #000 !important; }
    .lr-table tbody td.td-left { background: #ebebeb !important; color: #000 !important; }
    .lr-table tfoot td { background: #e8f5e9 !important; color: #000 !important; }
}
</style>
@endpush

@section('content')

{{-- ══ PAGE HEADER ════════════════════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-6 no-print">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Laporan Kelompok Rentan</h2>
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
        <span class="text-gray-500 dark:text-slate-400">Statistik</span>
        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 dark:text-slate-300 font-medium">Laporan Kelompok Rentan</span>
    </nav>
</div>

{{-- ══ CARD UTAMA ══════════════════════════════════════════════════════ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden print-card">

    {{-- ── FILTER + AKSI ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-100 dark:border-slate-700 no-print">

        {{-- Dropdown Dusun: auto-submit saat pilih, tanpa tombol Tampilkan --}}
        <form method="GET" action="{{ route('admin.statistik.kelompok-rentan') }}" id="form-filter">
            <input type="hidden" name="dusun" id="val-dusun" value="{{ $data['dusunFilter'] }}">

            <div x-data="{
                     open: false,
                     selected: '{{ $data['dusunFilter'] }}',
                     label: '{{ $data['dusunFilter'] ?: '' }}',
                     placeholder: '— Semua Dusun —',
                     options: {{ json_encode(array_merge(
                         [['value'=>'','label'=>'Semua Dusun']],
                         collect($data['dusunList'])->map(fn($d)=>['value'=>$d,'label'=>$d])->toArray()
                     )) }},
                     choose(opt) {
                         this.selected = opt.value;
                         this.label    = opt.value ? opt.label : '';
                         document.getElementById('val-dusun').value = opt.value;
                         this.open = false;
                         document.getElementById('form-filter').submit();
                     }
                 }"
                 @click.away="open = false"
                 class="relative flex items-center gap-2">

                <label class="text-xs font-semibold text-gray-500 dark:text-slate-400 whitespace-nowrap">Dusun</label>

                <div class="relative w-52">
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-sm
                                   bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                   border-gray-300 dark:border-slate-600
                                   hover:border-emerald-400 dark:hover:border-emerald-500 transition-colors"
                            :class="open ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''">
                        <span x-text="label || placeholder"
                              :class="label ? '' : 'text-gray-400 dark:text-slate-500'"
                              class="truncate"></span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 ml-2 transition-transform"
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
                         class="absolute left-0 top-full mt-1 w-full z-50
                                bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600
                                rounded-lg shadow-lg overflow-hidden"
                         style="display:none">
                        <ul class="max-h-56 overflow-y-auto py-1">
                            <template x-for="opt in options" :key="opt.value">
                                <li @click="choose(opt)"
                                    class="px-3 py-2 text-sm cursor-pointer transition-colors
                                           hover:bg-emerald-50 dark:hover:bg-emerald-900/20
                                           hover:text-emerald-700 dark:hover:text-emerald-400"
                                    :class="selected === opt.value
                                        ? 'bg-emerald-500 text-white hover:bg-emerald-600 hover:text-white dark:hover:text-white'
                                        : 'text-gray-700 dark:text-slate-200'"
                                    x-text="opt.label">
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </form>

        {{-- Tombol Cetak & Unduh Excel --}}
        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                    class="h-9 px-4 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600
                           hover:bg-gray-50 dark:hover:bg-slate-600
                           text-gray-700 dark:text-slate-200 text-sm font-semibold rounded-lg
                           flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>
            <button onclick="unduhExcel()"
                    class="h-9 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold
                           rounded-lg flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh Excel
            </button>
        </div>
    </div>

    {{-- ── REPORT HEADER ── --}}
    @php
        $identitas = $data['identitas'];
        $kabupaten = $identitas->kabupaten ?? ($identitas->nama_kabupaten ?? '');
        $namaDesa  = $identitas->nama_desa  ?? ($identitas->nama ?? '');
        $kecamatan = $identitas->kecamatan  ?? ($identitas->nama_kecamatan ?? '');
    @endphp

    <div class="px-5 pt-5 pb-2 text-center">
        <p class="text-sm font-extrabold text-gray-800 dark:text-slate-100 uppercase tracking-wide">
            PEMERINTAH KABUPATEN/KOTA {{ strtoupper($kabupaten) }}
        </p>
        <p class="text-xs font-bold text-gray-600 dark:text-slate-300 mt-0.5">
            DATA PILAH KEPENDUDUKAN MENURUT UMUR DAN FAKTOR KERENTANAN (LAMPIRAN A - 9)
        </p>
    </div>

    {{-- Info Row --}}
    <div class="flex flex-wrap gap-x-8 gap-y-1 text-xs text-gray-600 dark:text-slate-400 px-5 py-3
                border-b border-gray-100 dark:border-slate-700">
        <span>Desa/Kel &nbsp;: <strong class="text-gray-800 dark:text-slate-200">{{ $namaDesa }}</strong></span>
        <span>Kecamatan : <strong class="text-gray-800 dark:text-slate-200">{{ $kecamatan }}</strong></span>
        <span>Lap. Bulan : <strong class="text-gray-800 dark:text-slate-200">{{ $data['bulanList'][$data['bulan']] ?? '-' }} {{ $data['tahun'] }}</strong></span>
        <span>Dusun &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong class="text-gray-800 dark:text-slate-200">{{ $data['dusunFilter'] ?: 'Semua' }}</strong></span>
    </div>

    {{-- ── TABEL ── --}}
    <div class="overflow-x-auto">
        <table class="lr-table" style="min-width: max-content;">
            <thead>
                <tr>
                    <th rowspan="2" class="th-dusun" style="min-width:110px">DUSUN</th>
                    <th rowspan="2" class="th-dusun" style="min-width:44px">RW</th>
                    <th rowspan="2" class="th-dusun" style="min-width:44px">RT</th>
                    <th colspan="2" class="th-kk">KK</th>
                    <th colspan="6" class="th-umur">KONDISI DAN KELOMPOK UMUR</th>
                    <th colspan="7" class="th-disab">DISABILITAS</th>
                    <th colspan="2" class="th-sakit">SAKIT MENAHUN</th>
                    <th rowspan="2" class="th-hamil" style="min-width:56px">HAMIL</th>
                </tr>
                <tr>
                    <th class="th-kk"   style="min-width:38px">L</th>
                    <th class="th-kk"   style="min-width:38px">P</th>
                    <th class="th-umur" style="min-width:72px">DI BAWAH<br>1 TAHUN</th>
                    <th class="th-umur" style="min-width:54px">1-5<br>TAHUN</th>
                    <th class="th-umur" style="min-width:54px">6-12<br>TAHUN</th>
                    <th class="th-umur" style="min-width:54px">13-15<br>TAHUN</th>
                    <th class="th-umur" style="min-width:54px">16-18<br>TAHUN</th>
                    <th class="th-umur" style="min-width:72px">DI ATAS<br>60 TAHUN</th>
                    <th class="th-disab" style="min-width:74px">DISABILITAS<br>FISIK</th>
                    <th class="th-disab" style="min-width:74px">DISABILITAS<br>NETRA/<br>BUTA</th>
                    <th class="th-disab" style="min-width:74px">DISABILITAS<br>RUNGU/<br>WICARA</th>
                    <th class="th-disab" style="min-width:74px">DISABILITAS<br>MENTAL/<br>JIWA</th>
                    <th class="th-disab" style="min-width:82px">DISABILITAS<br>FISIK DAN<br>MENTAL</th>
                    <th class="th-disab" style="min-width:74px">DISABILITAS<br>LAINNYA</th>
                    <th class="th-disab" style="min-width:74px">TIDAK<br>DISABILITAS</th>
                    <th class="th-sakit" style="min-width:38px">L</th>
                    <th class="th-sakit" style="min-width:38px">P</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $colKeys = [
                        'kk_l','kk_p',
                        'umur_bawah_1','umur_1_5','umur_6_12','umur_13_15','umur_16_18','umur_atas_60',
                        'disab_fisik','disab_netra','disab_rungu','disab_mental','disab_fisik_mental','disab_lainnya','tidak_disabilitas',
                        'sakit_l','sakit_p','hamil',
                    ];
                    $totals = array_fill_keys($colKeys, 0);
                @endphp

                @forelse($data['tableRows'] as $row)
                    @php foreach ($colKeys as $c) $totals[$c] += (int)($row->$c ?? 0); @endphp
                    <tr>
                        <td class="td-left">{{ $row->dusun ?? '-' }}</td>
                        <td>{{ $row->rw  ?? '-' }}</td>
                        <td>{{ $row->rt  ?? '-' }}</td>
                        <td>{{ (int)$row->kk_l }}</td>
                        <td>{{ (int)$row->kk_p }}</td>
                        <td>{{ (int)$row->umur_bawah_1 }}</td>
                        <td>{{ (int)$row->umur_1_5 }}</td>
                        <td>{{ (int)$row->umur_6_12 }}</td>
                        <td>{{ (int)$row->umur_13_15 }}</td>
                        <td>{{ (int)$row->umur_16_18 }}</td>
                        <td>{{ (int)$row->umur_atas_60 }}</td>
                        <td>{{ (int)$row->disab_fisik }}</td>
                        <td>{{ (int)$row->disab_netra }}</td>
                        <td>{{ (int)$row->disab_rungu }}</td>
                        <td>{{ (int)$row->disab_mental }}</td>
                        <td>{{ (int)$row->disab_fisik_mental }}</td>
                        <td>{{ (int)$row->disab_lainnya }}</td>
                        <td>{{ (int)$row->tidak_disabilitas }}</td>
                        <td>{{ (int)$row->sakit_l }}</td>
                        <td>{{ (int)$row->sakit_p }}</td>
                        <td>{{ (int)$row->hamil }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="21" class="py-14 text-center">
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

            <tfoot>
                <tr>
                    <td colspan="3" class="td-left font-bold">TOTAL</td>
                    @foreach($colKeys as $c)
                        <td>{{ $totals[$c] }}</td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Footer info --}}
    <div class="px-5 py-3 text-xs text-gray-400 dark:text-slate-500 no-print">
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