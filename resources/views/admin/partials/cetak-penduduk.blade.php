<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Penduduk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #888;
        }

        /* ── Toolbar cetak (tidak ikut dicetak) ── */
        .print-toolbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 10px 20px;
            background: #374151;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,.4);
        }
        .print-toolbar button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 18px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-print  { background: #2563eb; color: #fff; }
        .btn-print:hover { background: #1d4ed8; }
        .btn-close  { background: #dc2626; color: #fff; }
        .btn-close:hover { background: #b91c1c; }
        .btn-print svg, .btn-close svg { width: 16px; height: 16px; }

        /* ── Wrapper kertas ── */
        .page-wrapper {
            margin-top: 52px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0 40px;
        }

        /* ── Kertas A4 landscape ── */
        .paper {
            width: 297mm;
            min-height: 210mm;
            background: #fff;
            padding: 12mm 14mm 14mm;
            box-shadow: 0 4px 24px rgba(0,0,0,.25);
        }

        /* ── Header surat ── */
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header .desa-name {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .header .sub-title {
            font-size: 11px;
            color: #555;
            margin-top: 1px;
        }
        .header .doc-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 8px;
            letter-spacing: 1px;
        }
        .header hr {
            border: none;
            border-top: 2.5px solid #1a1a1a;
            margin: 6px 0 0;
        }
        .header hr.thin {
            border-top-width: 1px;
            margin-top: 2px;
        }

        /* ── Filter aktif ── */
        .filter-info {
            font-size: 9.5px;
            color: #555;
            margin-bottom: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 4px 12px;
        }
        .filter-info span { white-space: nowrap; }
        .filter-info strong { color: #1a1a1a; }

        /* ── Tabel ── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }
        thead tr {
            background: #1e293b;
            color: #fff;
        }
        thead th {
            padding: 5px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 8.5px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
            border: 1px solid #334155;
        }
        thead th.center { text-align: center; }

        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:hover { background: #ecfdf5; }

        tbody td {
            padding: 4px 6px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
            line-height: 1.4;
        }
        tbody td.center { text-align: center; }
        tbody td.mono   { font-family: 'Courier New', monospace; font-size: 9px; }

        /* Badge status dasar */
        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 50px;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .badge-hidup  { background: #d1fae5; color: #065f46; }
        .badge-mati   { background: #f1f5f9; color: #475569; }
        .badge-pindah { background: #dbeafe; color: #1d4ed8; }
        .badge-hilang { background: #ffedd5; color: #9a3412; }
        .badge-pergi  { background: #fef9c3; color: #854d0e; }
        .badge-default{ background: #f1f5f9; color: #64748b; }

        /* NIK sensor */
        .sensor { letter-spacing: 2px; color: #94a3b8; font-size: 8px; }

        /* ── Footer ── */
        .footer-info {
            margin-top: 10px;
            font-size: 9px;
            color: #64748b;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer-info .total { font-weight: 700; color: #1a1a1a; }
        .footer-info .generated { text-align: right; }

        /* ── Print media ── */
        @media print {
            body { background: #fff; }
            .print-toolbar { display: none !important; }
            .page-wrapper { margin: 0; padding: 0; }
            .paper {
                width: 100%;
                min-height: unset;
                box-shadow: none;
                padding: 8mm 10mm;
            }
            tbody tr:hover { background: inherit; }
            @page { size: A4 landscape; margin: 0; }
        }
    </style>
</head>
<body>

    {{-- Toolbar --}}
    <div class="print-toolbar">
        <button class="btn-print" onclick="window.print()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak
        </button>
        <button class="btn-close" onclick="window.close()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Tutup
        </button>
    </div>

    <div class="page-wrapper">
        <div class="paper">

            {{-- ── HEADER ── --}}
            <div class="header">
                <div class="desa-name">Pemerintah Desa {{ $desaConfig->nama_desa ?? config('app.nama_desa', 'Desa') }}</div>
                <div class="sub-title">
                    Kecamatan {{ $desaConfig->nama_kecamatan ?? '-' }},
                    Kabupaten {{ $desaConfig->nama_kabupaten ?? '-' }},
                    Provinsi {{ $desaConfig->nama_provinsi ?? '-' }}
                </div>
                <div class="doc-title">Data Penduduk</div>
                <hr>
                <hr class="thin">
            </div>

            {{-- ── FILTER AKTIF ── --}}
            @php
                $filterLabels = [];
                if (request('status'))       $filterLabels[] = 'Status: ' . ['1'=>'Tetap','2'=>'Tidak Tetap','3'=>'Pendatang'][request('status')] ?? request('status');
                if (request('status_dasar')) $filterLabels[] = 'Status Dasar: ' . ucfirst(str_replace('_',' ',request('status_dasar')));
                if (request('jenis_kelamin'))$filterLabels[] = 'Jenis Kelamin: ' . (request('jenis_kelamin')=='L'?'Laki-laki':'Perempuan');
                if (request('dusun'))        $filterLabels[] = 'Dusun: ' . request('dusun');
                if (request('search'))       $filterLabels[] = 'Pencarian: "' . request('search') . '"';
                if (request('nik_sementara'))$filterLabels[] = 'NIK Sementara';
                $sensorNik = request()->boolean('sensor_nik');
            @endphp
            @if (count($filterLabels))
                <div class="filter-info">
                    <span><strong>Filter Aktif:</strong></span>
                    @foreach($filterLabels as $fl)
                        <span>• {{ $fl }}</span>
                    @endforeach
                </div>
            @endif

            {{-- ── TABEL ── --}}
            <table>
                <thead>
                    <tr>
                        <th class="center" style="width:24px">NO</th>
                        <th style="width:90px">NO. KK</th>
                        <th style="width:100px">NIK</th>
                        <th style="width:130px">NAMA</th>
                        <th style="width:60px">SHDK</th>
                        <th style="width:140px">ALAMAT</th>
                        <th style="width:70px">DUSUN</th>
                        <th class="center" style="width:24px">RW</th>
                        <th class="center" style="width:24px">RT</th>
                        <th style="width:60px">JK</th>
                        <th class="center" style="width:28px">UMUR</th>
                        <th style="width:70px">PEKERJAAN</th>
                        <th style="width:55px">KAWIN</th>
                        <th style="width:50px">STATUS</th>
                        <th style="width:65px">TGL LAHIR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                        @php
                            $keluargaP    = $p->keluarga;
                            $wilayahP     = $p->wilayah;
                            $noKk  = $sensorNik ? (substr($keluargaP?->no_kk ?? '', 0, 4) . 'XXXXXXXX') : ($keluargaP?->no_kk ?? '-');
                            $nik   = $sensorNik ? (substr($p->nik, 0, 4) . 'XXXXXXXXXX') : $p->nik;
                            $badgeClass = match($p->status_dasar) {
                                'hidup'  => 'badge-hidup',
                                'mati'   => 'badge-mati',
                                'pindah' => 'badge-pindah',
                                'hilang' => 'badge-hilang',
                                'pergi'  => 'badge-pergi',
                                default  => 'badge-default',
                            };
                        @endphp
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td class="mono">{{ $noKk }}</td>
                            <td class="mono {{ $sensorNik ? 'sensor' : '' }}">{{ $nik }}</td>
                            <td style="font-weight:600">{{ $p->nama }}</td>
                            <td>{{ $p->shdk?->nama ?? '-' }}</td>
                            <td>{{ $p->alamat ?: '-' }}</td>
                            <td>{{ $wilayahP?->dusun ?? '-' }}</td>
                            <td class="center">{{ $wilayahP?->rw ?? '-' }}</td>
                            <td class="center">{{ $wilayahP?->rt ?? '-' }}</td>
                            <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : ($p->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
                            <td class="center">{{ $p->umur ?? '-' }}</td>
                            <td>{{ $p->pekerjaan?->nama ?? '-' }}</td>
                            <td>{{ $p->statusKawin?->nama ?? '-' }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ $p->label_status_dasar }}</span></td>
                            <td>{{ $p->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" style="text-align:center; padding: 20px; color: #94a3b8">
                                Tidak ada data penduduk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ── FOOTER ── --}}
            <div class="footer-info">
                <div>
                    <div class="total">Total: {{ number_format($penduduk instanceof \Illuminate\Pagination\LengthAwarePaginator ? $penduduk->total() : $penduduk->count()) }} jiwa</div>
                    @if($sensorNik)
                        <div style="color:#dc2626; font-size:8px; margin-top:2px">⚠ NIK/No. KK disensor</div>
                    @endif
                </div>
                <div class="generated">
                    Dicetak oleh: {{ auth()->user()->name ?? 'Administrator' }}<br>
                    {{ now()->isoFormat('dddd, D MMMM Y • HH:mm') }} WIB
                </div>
            </div>

        </div>{{-- /.paper --}}
    </div>

</body>
</html>