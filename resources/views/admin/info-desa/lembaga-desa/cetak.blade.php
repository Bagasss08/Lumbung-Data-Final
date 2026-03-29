<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Lembaga Desa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background abu-abu gelap seperti OpenSID */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            background: #525659;
            /* abu-abu gelap */
            min-height: 100vh;
            padding: 20px;
        }

        /* Tombol aksi - kecil, icon only, seperti OpenSID */
        .btn-actions {
            text-align: center;
            margin-bottom: 12px;
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .btn-actions button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
            background: #fff;
            color: #333;
            padding: 0;
        }

        .btn-actions button:hover {
            background: #f0f0f0;
        }

        .btn-actions button svg {
            width: 18px;
            height: 18px;
        }

        /* Area dokumen putih */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 20mm;
            background: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        /* Header - logo di tengah atas, teks di bawah (vertikal centered seperti OpenSID) */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 16px;
            text-align: center;
        }

        .header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            margin-bottom: 8px;
        }

        .header-text {
            text-align: center;
        }

        .header-text .instansi {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.6;
        }

        /* Judul */
        .judul {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px 8px;
            font-size: 11px;
        }

        th {
            background: #f0f0f0;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        td {
            vertical-align: top;
        }

        td.center {
            text-align: center;
        }

        /* Tanda tangan */
        .ttd {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        .ttd-blok {
            text-align: center;
            width: 45%;
        }

        .ttd-blok .jabatan {
            font-size: 11px;
            margin-bottom: 60px;
        }

        .ttd-blok .nama {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-blok .nip {
            font-size: 11px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .no-print {
                display: none;
            }

            .page {
                padding: 10mm 15mm;
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    {{-- Tombol aksi kecil icon only (hilang saat cetak) --}}
    <div class="no-print btn-actions">
        <button onclick="window.print()" title="Cetak">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
        </button>
        <button onclick="window.close()" title="Tutup">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="page">

        {{-- Kop Surat --}}
        @php
            $logoBase64 = null;
            if ($identitas && $identitas->logo_desa) {
                $logoPath = storage_path('app/public/logo-desa/' . $identitas->logo_desa);
                if (file_exists($logoPath)) {
                    $ext = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
                    $mime = match ($ext) {
                        'png' => 'image/png',
                        'jpg', 'jpeg' => 'image/jpeg',
                        'gif' => 'image/gif',
                        'svg' => 'image/svg+xml',
                        'webp' => 'image/webp',
                        default => 'image/png',
                    };
                    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
                }
            }
        @endphp

        <div class="header">
            {{-- Logo di tengah atas --}}
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Logo Desa">
            @else
                <div
                    style="width:70px;height:70px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;border:1px solid #d1d5db;border-radius:4px;margin-bottom:8px;">
                    <svg width="32" height="32" fill="none" stroke="#9ca3af" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
            @endif

            {{-- Teks instansi di bawah logo --}}
            <div class="header-text">
                <div class="instansi">
                    PEMERINTAH KABUPATEN {{ strtoupper($identitas->kabupaten ?? '') }}<br>
                    KECAMATAN {{ strtoupper($identitas->kecamatan ?? '') }}<br>
                    DESA {{ strtoupper($identitas->nama_desa ?? '') }}
                </div>
                @if ($identitas && $identitas->alamat_kantor)
                    <div style="font-size:11px; margin-top:4px;">{{ $identitas->alamat_kantor }}</div>
                @endif
            </div>
        </div>

        {{-- Judul --}}
        <div class="judul">DATA LEMBAGA</div>

        {{-- Tabel --}}
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">NO</th>
                    <th style="width:30%;">NAMA LEMBAGA</th>
                    <th style="width:25%;">NAMA KETUA</th>
                    <th style="width:25%;">KATEGORI LEMBAGA</th>
                    <th style="width:15%;">JUMLAH ANGGOTA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lembaga as $i => $item)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            @php
                                $ketua = $item->ketua ?? '';
                                if ($ketua) {
                                    // Format: "NIK-Nama_Dengan_Underscore"
                                    // Ambil bagian setelah tanda '-' pertama, lalu ganti '_' dengan spasi
                                    $pos = strpos($ketua, '-');
                                    $nama = $pos !== false ? substr($ketua, $pos + 1) : $ketua;
                                    echo str_replace('_', ' ', trim($nama));
                                } else {
                                    echo '-';
                                }
                            @endphp
                        </td>
                        <td>{{ optional($item->kategori)->nama ?? '-' }}</td>
                        <td class="center">{{ $item->anggota_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="center" style="padding:20px; color:#999;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Tanda Tangan --}}
        <div class="ttd">
            {{-- Kiri: Mengetahui --}}
            <div class="ttd-blok">
                <div class="jabatan">
                    MENGETAHUI<br>
                    {{ $diketahui ? strtoupper('KEPALA DESA ' . ($identitas->nama_desa ?? '')) : '' }}
                </div>
                @if ($diketahui)
                    <div class="nama">{{ $diketahui->nama }}</div>
                    @if ($diketahui->nik)
                        <div class="nip">NIP : {{ $diketahui->nik }}</div>
                    @endif
                @endif
            </div>

            {{-- Kanan: Ditandatangani --}}
            <div class="ttd-blok">
                <div class="jabatan">
                    {{ strtoupper($identitas->nama_desa ?? '') }},
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    {{ $ditandatangani ? strtoupper('SEKRETARIS DESA ' . ($identitas->nama_desa ?? '')) : '' }}
                </div>
                @if ($ditandatangani)
                    <div class="nama">{{ $ditandatangani->nama }}</div>
                    @if ($ditandatangani->nik)
                        <div class="nip">NIP : {{ $ditandatangani->nik }}</div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</body>

</html>
