@extends('layouts.admin')

@section('content')
{{-- Load TinyMCE Lokal --}}
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600&display=swap" rel="stylesheet">
<style>
    :root {
        --bg-preview: #f1f5f9;
        --accent-color: #3b82f6;
        --danger-color: #ef4444;
        --text-dark: #1e293b;
        --text-muted: #64748b;
    }

    body {
        background-color: var(--bg-preview);
        font-family: 'Sora', sans-serif;
    }

    .preview-container {
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Header Styling */
    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        background: white;
        padding: 1.25rem 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .preview-header h1 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .btn-back {
        text-decoration: none;
        color: var(--text-muted);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s;
    }

    .btn-back:hover { color: var(--accent-color); }

    /* Editor Wrapper (Simulasi Kertas) */
    .editor-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
    }

    /* Floating Action Button (Footer) */
    .action-bar {
        position: sticky;
        bottom: 2rem;
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        z-index: 100;
    }

    .btn-generate {
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-generate:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 20px -3px rgba(239, 68, 68, 0.5);
    }

    .btn-generate:active { transform: translateY(0); }

    /* Custom TinyMCE Toolbar Look */
    .tox-tinymce {
        border: none !important;
        border-radius: 0 !important;
    }
</style>

<div class="preview-container">
    <div class="preview-header">
        <div>
            <h1><span style="color: var(--accent-color);">Editor:</span> {{ $template->judul }}</h1>
            <p style="color: var(--text-muted); margin: 4px 0 0 0; font-size: 0.85rem;">Periksa kembali format penomoran dan isi sebelum mencetak.</p>
        </div>
        <a href="javascript:history.back()" class="btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.layanan-surat.cetak.generateFinal') }}" method="POST">
        @csrf
        {{-- Data Hidden untuk Arsip --}}
        <input type="hidden" name="nomor_surat" value="{{ $formData['nomor_surat'] ?? $formData['format_nomor'] ?? '-' }}">
        <input type="hidden" name="nama_pemohon" value="{{ $formData['nama'] ?? $formData['nama_lengkap'] ?? '-' }}">
        <input type="hidden" name="nik_pemohon" value="{{ $formData['nik'] ?? $formData['no_nik'] ?? '-' }}">
        <input type="hidden" name="jenis_surat" value="{{ $template->judul }}">
        <input type="hidden" name="tanggal_surat" value="{{ $formData['tgl_surat'] ?? $formData['tanggal_surat'] ?? date('Y-m-d') }}">

        <div class="editor-card">
            <textarea id="editor" name="final_content">
                {!! $htmlContent !!}
            </textarea>
        </div>

        <div class="action-bar">
            <button type="submit" class="btn-generate">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Finalisasi & Cetak PDF
            </button>
        </div>
    </form>
</div>

<script>
    tinymce.init({
        selector: '#editor',
        height: 900,
        // Menghilangkan statusbar di bawah (termasuk "Powered by Tiny")
        branding: false,
        promotion: false,
        plugins: 'table lists advlist autoresize',
        toolbar: 'undo redo | fontfamily fontsize | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table',
        
        // Agar font family dan size terlihat default seperti surat resmi
        font_family_formats: 'Times New Roman=times new roman,times,serif; Arial=arial,helvetica,sans-serif; Sora=Sora,sans-serif',
        content_style: `
            body { 
                font-family: "Times New Roman", Times, serif; 
                font-size: 12pt; 
                line-height: 1.5;
                padding: 2.5cm 2.5cm !important; 
                max-width: 21cm; 
                margin: auto; 
                background: white;
                min-height: 29.7cm;
                box-sizing: border-box;
            }
            p { margin: 0; }
        `,
        setup: function (editor) {
            editor.on('init', function () {
                editor.getContainer().style.transition = "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out";
            });
        }
    });
</script>
@endsection