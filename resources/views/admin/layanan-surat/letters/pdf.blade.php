<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'EB Garamond', 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.7;
            color: #1a1a2e;
            background: #fff;
            padding: 30px 40px;
        }

        /* ===== KOP SURAT ===== */
        .kop-surat {
            display: flex;
            align-items: center;
            gap: 18px;
            padding-bottom: 14px;
            margin-bottom: 22px;
            border-bottom: 4px double #1a1a2e;
            position: relative;
        }

        .kop-surat::after {
            content: '';
            display: block;
            position: absolute;
            bottom: -7px;
            left: 0; right: 0;
            height: 1px;
            background: #1a1a2e;
        }

        .kop-logo {
            width: 72px;
            height: 72px;
            flex-shrink: 0;
        }

        .kop-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .kop-logo-placeholder {
            width: 72px;
            height: 72px;
            border: 2px solid #1a1a2e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8pt;
            color: #555;
            text-align: center;
            flex-shrink: 0;
        }

        .kop-text {
            flex: 1;
            text-align: center;
        }

        .kop-text h3 {
            font-family: 'EB Garamond', serif;
            font-size: 11pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 2px;
        }

        .kop-text h2 {
            font-family: 'Cinzel', 'Times New Roman', serif;
            font-size: 16pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 3px;
            line-height: 1.2;
        }

        .kop-text p {
            font-size: 10pt;
            color: #444;
            letter-spacing: 0.3px;
        }

        /* ===== JUDUL SURAT ===== */
        .judul-surat {
            text-align: center;
            margin: 24px 0 20px;
            position: relative;
        }

        .judul-surat::before,
        .judul-surat::after {
            content: '✦';
            font-size: 10pt;
            color: #888;
            margin: 0 12px;
        }

        .judul-surat h3 {
            display: inline;
            font-family: 'Cinzel', serif;
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 4px;
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .judul-surat p {
            margin-top: 5px;
            font-size: 11pt;
            color: #333;
            letter-spacing: 0.5px;
        }

        /* ===== PEMBUKA ===== */
        .pembuka {
            text-indent: 40px;
            text-align: justify;
            margin-bottom: 18px;
            font-size: 12pt;
        }

        /* ===== TABEL DATA ===== */
        .data-wrapper {
            border: 1.5px solid #1a1a2e;
            margin: 18px 0;
            position: relative;
        }

        .data-wrapper::before {
            content: '';
            position: absolute;
            top: 3px; left: 3px; right: 3px; bottom: 3px;
            border: 0.5px solid #999;
            pointer-events: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr {
            border-bottom: 0.5px solid #ddd;
        }

        table tr:last-child {
            border-bottom: none;
        }

        table tr:nth-child(even) td {
            background-color: #f7f6f1;
        }

        td {
            vertical-align: top;
            padding: 5px 12px;
            font-size: 11.5pt;
        }

        .td-label {
            width: 30%;
            font-weight: 600;
            color: #222;
        }

        .td-titikdua {
            width: 3%;
            text-align: center;
            color: #555;
        }

        /* ===== PENUTUP ===== */
        .penutup {
            text-indent: 40px;
            text-align: justify;
            margin-top: 18px;
            font-size: 12pt;
        }

        /* ===== TTD ===== */
        .ttd-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .ttd {
            width: 42%;
            text-align: center;
            font-size: 11.5pt;
        }

        .ttd-nama {
            margin-top: 60px;
            padding-top: 6px;
            border-top: 1.5px solid #1a1a2e;
            display: inline-block;
            min-width: 80%;
            font-weight: 700;
            font-size: 12pt;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .ttd-nip {
            margin-top: 2px;
            font-size: 10.5pt;
            color: #444;
        }

        /* ===== ORNAMENT FOOTER ===== */
        .footer-ornament {
            text-align: center;
            margin-top: 30px;
            color: #bbb;
            font-size: 9pt;
            letter-spacing: 3px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="kop-logo-placeholder">LOGO</div>
        <div class="kop-text">
            <h3>PEMERINTAH {{ $letter->kode_kabupaten }} {{ $letter->nama_kabupaten }}</h3>
            <h3>KECAMATAN {{ $letter->kecamatan }}</h3>
            <h2>{{ $letter->kantor_desa }} {{ $letter->nama_desa }}</h2>
            <p>{{ $letter->alamat_kantor }}</p>
        </div>
        <div class="kop-logo-placeholder">LOGO</div>
    </div>

    <div class="judul-surat">
        <h3>SURAT JALAN</h3>
        <p>Nomor : {{ $letter->format_nomor }}</p>
    </div>

    <p class="pembuka">
        Yang bertanda tangan di bawah ini {{ $letter->penandatangan }} {{ $letter->nama_desa }}, Kecamatan {{ $letter->kecamatan }}, Kabupaten {{ $letter->nama_kabupaten }}, Provinsi {{ $letter->kode_provinsi }} menerangkan dengan sebenarnya bahwa :
    </p>

    <div class="data-wrapper">
        <table>
            <tr><td class="td-label">Nama Lengkap</td><td class="td-titikdua">:</td><td>{{ $letter->nama }}</td></tr>
            <tr><td class="td-label">NIK / No KTP</td><td class="td-titikdua">:</td><td>{{ $letter->nik }}</td></tr>
            <tr><td class="td-label">No. KK</td><td class="td-titikdua">:</td><td>{{ $letter->no_kk }}</td></tr>
            <tr><td class="td-label">Kepala Keluarga</td><td class="td-titikdua">:</td><td>{{ $letter->kepala_kk }}</td></tr>
            <tr><td class="td-label">Tempat/Tanggal Lahir</td><td class="td-titikdua">:</td><td>{{ $letter->tempat_lahir }} / {{ \Carbon\Carbon::parse($letter->tanggal_lahir)->format('d-m-Y') }}</td></tr>
            <tr><td class="td-label">Jenis Kelamin</td><td class="td-titikdua">:</td><td>{{ $letter->jenis_kelamin }}</td></tr>
            <tr><td class="td-label">Alamat/Tempat Tinggal</td><td class="td-titikdua">:</td><td>{{ $letter->Alamat }} {{ $letter->nama_desa }}, Kecamatan {{ $letter->kecamatan }}, Kabupaten {{ $letter->kabupaten }}</td></tr>
            <tr><td class="td-label">Agama</td><td class="td-titikdua">:</td><td>{{ $letter->agama }}</td></tr>
            <tr><td class="td-label">Status</td><td class="td-titikdua">:</td><td>{{ $letter->status }}</td></tr>
            <tr><td class="td-label">Pendidikan</td><td class="td-titikdua">:</td><td>{{ $letter->Pendidikan }}</td></tr>
            <tr><td class="td-label">Pekerjaan</td><td class="td-titikdua">:</td><td>{{ $letter->pekerjaan }}</td></tr>
            <tr><td class="td-label">Kewarganegaraan</td><td class="td-titikdua">:</td><td>{{ $letter->warga_negara }}</td></tr>
            <tr><td class="td-label">Keperluan</td><td class="td-titikdua">:</td><td>{{ $letter->form_keterangan }}</td></tr>
            <tr><td class="td-label">Berlaku mulai</td><td class="td-titikdua">:</td><td>{{ \Carbon\Carbon::parse($letter->mulai_berlaku)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($letter->tgl_akhir)->format('d-m-Y') }}</td></tr>
        </table>
    </div>

    <p class="penutup">
        Orang tersebut adalah benar-benar warga Desa {{ $letter->nama_desa }} dengan data seperti di atas. Demikian surat keterangan ini dibuat, untuk dipergunakan sebagaimana mestinya.
    </p>

    <div class="ttd-wrapper">
        <div class="ttd">
            <p>{{ $letter->nama_desa }}, {{ \Carbon\Carbon::parse($letter->tgl_surat)->format('d F Y') }}<br>
            {{ $letter->penandatangan }}</p>
            <p class="ttd-nama">{{ $letter->kepala_desa }}</p>
            <p class="ttd-nip">NIP: {{ $letter->nip_kepala_desa ?: '-' }}</p>
        </div>
    </div>

    <div class="footer-ornament">— ✦ —</div>

</body>
</html>