{{--
    resources/views/admin/statistik/kelompok-rentan.blade.php
    Laporan Kelompok Rentan — DATA PILAH KEPENDUDUKAN LAMPIRAN A-9
--}}
@extends('layouts.admin')

@section('title', 'Laporan Kelompok Rentan')

@push('styles')
<style>
.lr-table { border-collapse: collapse; font-size: 0.75rem; }
.lr-table th, .lr-table td {
    border: 1px solid #cbd5e1;
    padding: 6px 10px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}
.lr-table thead th { font-weight: 700; font-size: 0.72rem; line-height: 1.35; }
.lr-table td.td-left { text-align: left; font-weight: 600; }

.th-dusun { background: #1e40af; color: #fff; }
.th-umur  { background: #1d4ed8; color: #fff; }
.th-disab { background: #92400e; color: #fff; }
.th-sakit { background: #166534; color: #fff; }
.th-hamil { background: #86198f; color: #fff; }
.th-kk    { background: #4338ca; color: #fff; }

.lr-table tbody td { color: #1e40af; font-weight: 500; }
.lr-table tbody td.td-left { color: #1e293b; }
.lr-table tbody tr:nth-child(even) td { background: #f8fafc; }
.lr-table tbody tr:hover td { background: #eff6ff; }

.lr-table tfoot td {
    background: #f0fdf4;
    border-top: 2px solid #16a34a;
    font-weight: 700;
    color: #14532d;
}
.lr-table tfoot td.td-left { color: #14532d; }

@media print {
    .no-print { display: none !important; }
    .lr-table th, .lr-table td { font-size: 7.5pt; padding: 3px 5px; }
}
</style>
@endpush

@section('content')

<div class="p-5">

    {{-- ══ FILTER BAR ══════════════════════════════════════════════════════ --}}
    <div class="no-print bg-white border border-slate-200 rounded-xl shadow-sm px-5 py-4 mb-5 flex flex-wrap items-center justify-between gap-3">

        <form method="GET" action="{{ route('admin.statistik.kelompok-rentan') }}"
              class="flex flex-wrap items-center gap-3">

            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-slate-500 whitespace-nowrap">Lap. Bulan</label>
                <select name="bulan"
                    class="h-9 px-3 text-sm border border-slate-300 rounded-lg bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @foreach($data['bulanList'] as $num => $nama)
                        <option value="{{ $num }}" {{ $data['bulan'] == $num ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-semibold text-slate-500">Dusun</label>
                <select name="dusun"
                    class="h-9 px-3 text-sm border border-slate-300 rounded-lg bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">— Pilih Dusun —</option>
                    @foreach($data['dusunList'] as $d)
                        <option value="{{ $d }}" {{ $data['dusunFilter'] == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                class="h-9 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-1.5 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Tampilkan
            </button>

            @if($data['dusunFilter'])
                <a href="{{ route('admin.statistik.kelompok-rentan') }}"
                   class="h-9 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-lg flex items-center transition-colors">
                    Reset
                </a>
            @endif
        </form>

        <div class="flex items-center gap-2">
            <button onclick="window.print()"
                class="h-9 px-4 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>
            <button onclick="unduhExcel()"
                class="h-9 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg flex items-center gap-1.5 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh Excel
            </button>
        </div>
    </div>

    {{-- ══ REPORT HEADER ═══════════════════════════════════════════════════ --}}
    @php
        $identitas = $data['identitas'];
        $kabupaten = $identitas->kabupaten ?? ($identitas->nama_kabupaten ?? '');
        $namaDesa  = $identitas->nama_desa  ?? ($identitas->nama ?? '');
        $kecamatan = $identitas->kecamatan  ?? ($identitas->nama_kecamatan ?? '');
    @endphp

    <div class="text-center mb-3">
        <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-wide">
            PEMERINTAH KABUPATEN/KOTA {{ strtoupper($kabupaten) }}
        </h2>
        <h3 class="text-sm font-bold text-slate-700 mt-0.5">
            DATA PILAH KEPENDUDUKAN MENURUT UMUR DAN FAKTOR KERENTANAN (LAMPIRAN A - 9)
        </h3>
    </div>

    {{-- ══ INFO ROW ════════════════════════════════════════════════════════ --}}
    <div class="flex flex-wrap gap-x-8 gap-y-1 text-sm text-slate-600 mb-4 px-1">
        <div>Desa/Kel &nbsp;: <span class="font-bold text-slate-800">{{ $namaDesa }}</span></div>
        <div>Kecamatan : <span class="font-bold text-slate-800">{{ $kecamatan }}</span></div>
        <div>Lap. Bulan : <span class="font-bold text-slate-800">{{ $data['bulanList'][$data['bulan']] ?? '-' }}</span></div>
        <div>Dusun &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span class="font-bold text-slate-800">{{ $data['dusunFilter'] ?: 'Semua' }}</span></div>
    </div>

    {{-- ══ TABLE ═══════════════════════════════════════════════════════════ --}}
    {{-- overflow-x-auto + w-full agar scroll dari paling kiri --}}
    <div style="overflow-x: auto; width: 100%; border: 1px solid #e2e8f0; border-radius: 12px;">
        <table class="lr-table" style="min-width: max-content; width: 100%;">
            <thead>
                <tr>
                    <th rowspan="2" class="th-dusun" style="min-width:90px">DUSUN</th>
                    <th rowspan="2" class="th-dusun" style="min-width:44px">RW</th>
                    <th rowspan="2" class="th-dusun" style="min-width:44px">RT</th>
                    <th colspan="2" class="th-kk">KK</th>
                    <th colspan="6" class="th-umur">KONDISI DAN KELOMPOK UMUR</th>
                    <th colspan="7" class="th-disab">DISABILITAS</th>
                    <th colspan="2" class="th-sakit">SAKIT MENAHUN</th>
                    <th rowspan="2" class="th-hamil" style="min-width:52px">HAMIL</th>
                </tr>
                <tr>
                    <th class="th-kk" style="min-width:36px">L</th>
                    <th class="th-kk" style="min-width:36px">P</th>
                    <th class="th-umur" style="min-width:68px">DI BAWAH<br>1 TAHUN</th>
                    <th class="th-umur" style="min-width:52px">1-5<br>TAHUN</th>
                    <th class="th-umur" style="min-width:52px">6-12<br>TAHUN</th>
                    <th class="th-umur" style="min-width:54px">13-15<br>TAHUN</th>
                    <th class="th-umur" style="min-width:54px">16-18<br>TAHUN</th>
                    <th class="th-umur" style="min-width:68px">DI ATAS<br>60 TAHUN</th>
                    <th class="th-disab" style="min-width:72px">DISABILITAS<br>FISIK</th>
                    <th class="th-disab" style="min-width:72px">DISABILITAS<br>NETRA/<br>BUTA</th>
                    <th class="th-disab" style="min-width:72px">DISABILITAS<br>RUNGU/<br>WICARA</th>
                    <th class="th-disab" style="min-width:72px">DISABILITAS<br>MENTAL/<br>JIWA</th>
                    <th class="th-disab" style="min-width:80px">DISABILITAS<br>FISIK DAN<br>MENTAL</th>
                    <th class="th-disab" style="min-width:72px">DISABILITAS<br>LAINNYA</th>
                    <th class="th-disab" style="min-width:72px">TIDAK<br>DISABILITAS</th>
                    <th class="th-sakit" style="min-width:36px">L</th>
                    <th class="th-sakit" style="min-width:36px">P</th>
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
                        <td colspan="21" class="py-12 text-center text-slate-400 text-sm">
                            Data belum tersedia untuk filter yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="td-left">Total</td>
                    @foreach($colKeys as $c)
                        <td>{{ $totals[$c] }}</td>
                    @endforeach
                </tr>
            </tfoot>
        </table>
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