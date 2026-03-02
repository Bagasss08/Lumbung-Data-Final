<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Data Surat</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background: #f4f6f9; color: #333; }
        .container { max-width: 800px; margin: 0 auto; }
        
        /* Tombol Navigasi */
        .action-buttons { text-align: center; margin-bottom: 20px; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; border: none; cursor: pointer; font-size: 14px; }
        .btn-pdf { background: #dc3545; }
        .btn-word { background: #198754; }
        .btn-back { background: #6c757d; }
        .btn:hover { opacity: 0.9; }

        /* Kertas Ringkasan */
        .paper { background: white; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-radius: 8px; border-top: 5px solid #007bff; }
        
        .header-title { text-align: center; border-bottom: 2px dashed #ddd; padding-bottom: 15px; margin-bottom: 25px; }
        .header-title h2 { margin: 0; color: #007bff; }
        .header-title p { margin: 5px 0 0; color: #666; font-size: 14px; }

        .section-title { font-size: 16px; font-weight: bold; background: #e9ecef; padding: 8px 12px; border-radius: 4px; margin-top: 25px; margin-bottom: 15px; }

        .table-info { width: 100%; border-collapse: collapse; }
        .table-info td { padding: 8px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        .table-info td:first-child { width: 30%; font-weight: bold; color: #555; }
        
        /* Alert Template */
        .template-alert { background: #e0f7fa; border: 1px solid #b2ebf2; padding: 15px; border-radius: 5px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
        .template-alert strong { color: #006064; }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="action-buttons">
            <a href="{{ route('letters.create') }}" class="btn btn-back">← Kembali / Buat Baru</a>
            
            <a href="{{ route('letters.download', $letter->id) }}" class="btn btn-pdf">📄 Download PDF</a>
            
            <form action="{{ route('letters.template') }}" method="POST" style="display:inline;">
                @csrf
                @foreach($letter->toArray() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                
                <button type="submit" class="btn btn-word">📝 Download Word (.docx)</button>
            </form>
        </div>

        <div class="paper">
            
            <div class="template-alert">
                <span>Template yang digunakan: <strong>{{ $letter->template_file ?? 'Tidak memilih template' }}</strong></span>
                <span style="font-size: 12px; color:#666;">*Download Word untuk melihat desain asli</span>
            </div>

            <div class="header-title">
                <h2>RINGKASAN DATA SURAT</h2>
                <p>Pastikan data di bawah ini sudah benar sebelum di-download</p>
            </div>

            <div class="section-title">Kop & Identitas Desa</div>
            <table class="table-info">
                <tr><td>Pemerintah Kabupaten</td><td>: {{ $letter->nama_kabupaten }} (Kode: {{ $letter->kode_kabupaten }})</td></tr>
                <tr><td>Kecamatan</td><td>: {{ $letter->kecamatan }}</td></tr>
                <tr><td>Desa</td><td>: {{ $letter->nama_desa }}</td></tr>
                <tr><td>Alamat Kantor</td><td>: {{ $letter->alamat_kantor }}</td></tr>
            </table>

            <div class="section-title">Data Administrasi & Penduduk</div>
            <table class="table-info">
                <tr><td>Nomor Surat</td><td>: {{ $letter->format_nomor }}</td></tr>
                <tr><td>Nama Lengkap</td><td>: {{ $letter->nama }}</td></tr>
                <tr><td>NIK / No KTP</td><td>: {{ $letter->nik }}</td></tr>
                <tr><td>No. KK</td><td>: {{ $letter->no_kk }}</td></tr>
                <tr><td>Tempat/Tanggal Lahir</td><td>: {{ $letter->tempat_lahir }}, {{ \Carbon\Carbon::parse($letter->tanggal_lahir)->format('d-m-Y') }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $letter->jenis_kelamin }}</td></tr>
                <tr><td>Agama</td><td>: {{ $letter->agama }}</td></tr>
                <tr><td>Pekerjaan</td><td>: {{ $letter->pekerjaan }}</td></tr>
                <tr><td>Alamat Lengkap</td><td>: {{ $letter->Alamat }}, Kab. {{ $letter->kabupaten }}</td></tr>
            </table>

            <div class="section-title">Keterangan & Tanda Tangan</div>
            <table class="table-info">
                <tr><td>Keperluan</td><td>: {{ $letter->form_keterangan }}</td></tr>
                <tr><td>Masa Berlaku</td><td>: {{ \Carbon\Carbon::parse($letter->mulai_berlaku)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($letter->tgl_akhir)->format('d-m-Y') }}</td></tr>
                <tr><td>Tanggal Surat</td><td>: {{ \Carbon\Carbon::parse($letter->tgl_surat)->format('d-m-Y') }}</td></tr>
                <tr><td>Penandatangan</td><td>: {{ $letter->penandatangan }} ({{ $letter->kepala_desa }})</td></tr>
                <tr><td>NIP</td><td>: {{ $letter->nip_kepala_desa ?: '-' }}</td></tr>
            </table>

        </div>
    </div>
</body>
</html>