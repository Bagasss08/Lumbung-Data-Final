@extends('layouts.admin')

@section('title', 'Daftar Surat - Pengaturan Surat')

@section('content')

{{-- Font DM Sans untuk UI form --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

{{-- 1. Load TinyMCE dari folder public (Local) --}}
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

<style>
    :root {
        --bg:           #f0f2f5;
        --surface:      #ffffff;
        --border:       #e4e7ec;
        --blue:         #2563eb;
        --blue-hover:   #1d4ed8;
        --text:         #111827;
        --text-mid:     #374151;
        --text-muted:   #6b7280;
        --radius:       8px;
    }

    .template-main { 
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        padding: 20px; 
        max-width: 1100px;
        margin: 0 auto; 
    }

    /* --- STYLING UNTUK HEADER & TAB NAVIGASI --- */
    .page-header {
        display: flex;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 20px;
    }
    .page-header h1 {
        font-size: 1.5rem; 
        font-weight: 500;
        color: var(--text); 
        margin: 0;
    }
    .page-header span {
        font-size: 1.1rem;
        color: var(--text-muted);
    }

    .nav-tabs {
        display: flex;
        border-bottom: 1px solid var(--border);
        margin-bottom: 24px;
        overflow-x: auto;
        background: var(--surface);
        padding: 0 10px;
    }
    .nav-tab {
        padding: 14px 20px;
        text-decoration: none;
        color: var(--text-mid);
        font-weight: 500;
        font-size: 0.95rem;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .nav-tab:hover {
        color: var(--blue);
    }
    .nav-tab.active {
        color: var(--blue);
        border-bottom-color: var(--blue);
    }
    /* ------------------------------------------- */

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .alert-success {
        background: #f0fdf4; color: #166534; 
        padding: 12px 16px; border-radius: var(--radius); 
        border: 1px solid #bbf7d0; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }

    .info-box {
        background: #eff6ff; border: 1px solid #bfdbfe;
        padding: 15px; border-radius: var(--radius); margin-bottom: 20px;
        font-size: 0.9rem; color: #1e40af; line-height: 1.6;
    }
    .info-box code {
        background: #fff; padding: 3px 6px; border-radius: 4px;
        font-weight: 600; color: #d97706; font-family: monospace;
    }

    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block; font-weight: 600; margin-bottom: 12px; color: var(--text-mid);
    }

    .action-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
    .btn-save {
        background: var(--blue); color: #fff;
        padding: 10px 24px; border-radius: 6px;
        font-weight: 500; border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;
    }
    .btn-save:hover { background: var(--blue-hover); }
    .btn-cancel {
        background: #f3f4f6; color: var(--text-mid);
        padding: 10px 24px; border-radius: 6px;
        font-weight: 500; text-decoration: none; transition: 0.2s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
</style>

<div class="template-main">
    
    {{-- Header Halaman --}}
    <div class="page-header">
        <h1>Daftar Surat</h1>
        <span>Pengaturan Surat</span>
    </div>

    {{-- Menu Tab Navigasi ala OpenSID --}}
    <div class="nav-tabs">
        <a href="#" class="nav-tab active">Header</a>
        <a href="#" class="nav-tab">Footer</a>
        <a href="#" class="nav-tab">Alur Surat</a>
        <a href="#" class="nav-tab">Pengaturan TTE</a>
        <a href="#" class="nav-tab">Form Penduduk Luar</a>
        <a href="#" class="nav-tab">Kode Isian Alias</a>
        <a href="#" class="nav-tab">Lainnya</a>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.layanan-surat.template-surat.simpan-pengaturan') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Pengaturan Header (Kop Surat)</label>
                
                {{-- Box Info untuk contekan kode isian --}}
                <div class="info-box">
                    <strong>💡 Panduan Kode Isian (Otomatis berubah sesuai data desa):</strong><br>
                    Gunakan <code>[logo_desa]</code> untuk memanggil logo instansi. <br>
                    Gunakan <code>[kabupaten]</code>, <code>[kecamatan]</code>, <code>[nama_desa]</code>, dan <code>[provinsi]</code> untuk teks dinamis.
                </div>

                {{-- Area TinyMCE --}}
                <textarea id="headerEditor" name="header_surat">
                    {{-- Default HTML Kop Surat sesuai permintaan --}}
                    {!! $setting['header_surat'] ?? '
                    <table border="0" width="100%" style="border-bottom: 3px solid black; margin-bottom: 15px;">
                    <tbody>
                    <tr>
                    <td align="center" width="15%"><img src="[logo_desa]" width="80" alt="Logo"></td>
                    <td align="center" width="85%">
                        <span style="font-size: 14pt;"><strong>PEMERINTAH KABUPATEN [kabupaten]</strong></span><br>
                        <span style="font-size: 14pt;"><strong>KECAMATAN [kecamatan]</strong></span><br>
                        <span style="font-size: 16pt;"><strong>DESA [nama_desa]</strong></span><br>
                        <span style="font-size: 11pt;">Alamat Desa [nama_desa], Kecamatan [kecamatan], Kabupaten [kabupaten], Provinsi [provinsi]</span>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    ' !!}
                </textarea>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 2. Inisialisasi TinyMCE --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: '#headerEditor',
            height: 400,
            
            /* Menambahkan baris ini untuk menghilangkan error "License key not provided" */
            license_key: 'gpl',

            menubar: 'file edit view insert format tools table',
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | table | bullist numlist outdent indent | removeformat | code | help',
            
            // CSS ini membuat tampilan di dalam editor terlihat seperti kertas surat
            content_style: `
                body { 
                    font-family: "Times New Roman", Times, serif; 
                    font-size: 12pt; 
                    padding: 20px;
                    line-height: 1.2;
                }
                table { border-collapse: collapse; }
                td, th { padding: 5px; }
            `,
            
            // Agar HTML tag tidak berantakan saat disimpan
            verify_html: false,
            valid_elements: '*[*]',
            
            // Branding dimatikan agar terlihat lebih profesional
            branding: false,
            promotion: false
        });
    });
</script>

@endsection