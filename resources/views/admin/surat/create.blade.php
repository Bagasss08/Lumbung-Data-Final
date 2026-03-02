<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Template Surat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CKEditor 4 -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <style>
        body {
            background: #f4f6f9;
        }
        .card-editor {
            background: #fff;
            border-radius: 6px;
            padding: 20px;
        }
        .editor-paper {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body>

<div class="container-fluid py-3">

    <!-- Breadcrumb -->
    <div class="mb-2 text-muted">
        Beranda &gt; Daftar Surat &gt; Tambah Template Surat
    </div>

    <div class="card">
        <div class="card-header">
            <strong>Tambah Template Surat</strong>
        </div>

        <div class="card-body">

            <!-- Button back -->
            <a href="/surat" class="btn btn-info btn-sm mb-3">
                ← Kembali Ke Daftar Surat
            </a>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('template-surat.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Judul Surat</label>
                        <input type="text" name="judul" class="form-control"
                               placeholder="Contoh: Surat Keterangan Domisili"
                               value="{{ old('judul') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Format Nomor Surat</label>
                        <input type="text" name="format_nomor" class="form-control"
                               placeholder="470/XX/II/2026"
                               value="{{ old('format_nomor') }}">
                    </div>
                </div>

                <!-- PILIH TEMPLATE DOCX DARI STORAGE -->
                <div class="mb-4">
                    <label class="form-label">Pilih Template Word (.docx)</label>
                    <select name="template_file" class="form-select">
                        <option value="">-- Pilih Template Dari storage/app/public/templates --</option>
                        @isset($templates)
                            @foreach($templates as $template)
                                <option value="{{ $template }}">
                                    {{ $template }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <small class="text-muted">
                        File dibaca otomatis dari folder: <b>storage/app/public/templates</b>
                    </small>
                </div>

                <hr>

                <!-- Editor Manual -->
                <div class="card-editor">
                    <label class="form-label">Atau Buat Template Manual (Optional)</label>

                    <div class="editor-paper">
                        <textarea id="editor" name="konten_template">
<h3 style="text-align:center;">[judul_surat]</h3>
<p style="text-align:center;">Nomor : [format_nomor]</p>

<h4>I. DATA KELUARGA</h4>
<table border="1" width="100%" cellpadding="6">
<tr><td width="40%">Nama Kepala Keluarga</td><td>[kepala_kk]</td></tr>
<tr><td>Nomor KK</td><td>[no_kk]</td></tr>
<tr><td>Alamat</td><td>[alamat]</td></tr>
</table>

<h4>II. DATA INDIVIDU</h4>
<table border="1" width="100%" cellpadding="6">
<tr><td width="40%">Nama Lengkap</td><td>[nama]</td></tr>
<tr><td>NIK</td><td>[nik]</td></tr>
<tr><td>Tempat Lahir</td><td>[tempat_lahir]</td></tr>
<tr><td>Tanggal Lahir</td><td>[tanggal_lahir]</td></tr>
<tr><td>Jenis Kelamin</td><td>[jenis_kelamin]</td></tr>
<tr><td>Agama</td><td>[agama]</td></tr>
<tr><td>Pekerjaan</td><td>[pekerjaan]</td></tr>
</table>

<p style="margin-top:40px;">
Surat ini dibuat untuk dipergunakan sebagaimana mestinya.
</p>

<p style="text-align:right;">
[kabupaten], [tgl_surat]
<br><br><br>
<b>[penandatangan]</b>
</p>
                        </textarea>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="/surat" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        Simpan dan Keluar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    CKEDITOR.replace('editor', {
        height: 500
    });
</script>

</body>
</html>