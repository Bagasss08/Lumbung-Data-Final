@extends('layouts.admin')

@section('title', 'Tambah Dokumen Persyaratan')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap');

    * { box-sizing: border-box; }

    .ps-root {
        font-family: 'DM Sans', sans-serif;
        padding: 28px 32px;
        background: #f0f2f9;
        min-height: 100vh;
        font-size: 13.5px;
        color: #1a1d2e;
    }

    /* ── HEADER ── */
    .ps-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .ps-header-left h1 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0 0 4px;
        letter-spacing: -0.4px;
    }

    .ps-breadcrumb {
        font-size: 0.78rem;
        color: #9399b2;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .ps-breadcrumb .sep { opacity: 0.45; }
    .ps-breadcrumb .current { color: #3b5bdb; font-weight: 600; }

    .ps-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #eef1fd;
        color: #3b5bdb;
        border: 1px solid #c5d0fb;
        border-radius: 20px;
        padding: 5px 13px;
        font-size: 0.77rem;
        font-weight: 600;
    }

    /* ── TWO-COLUMN LAYOUT ── */
    .ps-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }

    /* ── CARD SHARED ── */
    .ps-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e4e7f3;
        box-shadow: 0 2px 16px rgba(26,29,46,0.06);
        overflow: hidden;
    }

    /* ── CARD HEADER ── */
    .ps-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #e8eaf3;
        display: flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #f7f8fe 0%, #fafbfe 100%);
    }

    .ps-card-header .icon-wrap {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #3b5bdb 0%, #5c7cfa 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(59,91,219,0.3);
    }

    .ps-card-header h2 {
        font-size: 0.94rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0 0 2px;
    }

    .ps-card-header p {
        font-size: 0.76rem;
        color: #9399b2;
        margin: 0;
        font-weight: 500;
    }

    /* ── FORM BODY ── */
    .ps-form-body {
        padding: 26px 22px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-of-type { margin-bottom: 0; }

    label.form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #3d4166;
        margin-bottom: 7px;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    label.form-label .required {
        color: #e03131;
        margin-left: 2px;
    }

    .form-input {
        width: 100%;
        border: 1.5px solid #e2e5f0;
        border-radius: 10px;
        padding: 11px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        color: #1a1d2e;
        background: #f8f9fc;
        outline: none;
        transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        line-height: 1.5;
    }

    .form-input:focus {
        border-color: #3b5bdb;
        background: #fff;
        box-shadow: 0 0 0 3.5px rgba(59,91,219,0.12);
    }

    .form-input::placeholder { color: #c1c6d6; }

    .form-input.is-invalid {
        border-color: #e03131;
        background: #fff8f8;
    }

    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 3.5px rgba(224,49,49,0.10);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 100px;
    }

    .error-msg {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 6px;
        font-size: 0.76rem;
        color: #e03131;
        font-weight: 600;
    }

    .hint-msg {
        margin-top: 6px;
        font-size: 0.76rem;
        color: #9399b2;
        font-weight: 500;
        line-height: 1.5;
    }

    /* ── CHARACTER COUNTER ── */
    .input-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 6px;
    }

    .char-count {
        font-size: 0.73rem;
        color: #b0b5cc;
        font-family: 'DM Mono', monospace;
    }

    /* ── EXAMPLE CHIPS ── */
    .example-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 10px;
    }

    .example-chips span {
        font-size: 0.73rem;
        color: #9399b2;
        font-weight: 500;
        margin-right: 2px;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f0f2fd;
        border: 1px solid #dde2f7;
        color: #3b5bdb;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 0.73rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.12s;
        user-select: none;
    }

    .chip:hover {
        background: #e0e5fb;
        border-color: #3b5bdb;
        transform: translateY(-1px);
    }

    /* ── FORM FOOTER ── */
    .ps-form-footer {
        padding: 16px 22px;
        border-top: 1px solid #e8eaf3;
        background: linear-gradient(135deg, #f7f8fe 0%, #fafbfe 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .footer-note {
        font-size: 0.75rem;
        color: #b0b5cc;
        font-weight: 500;
    }

    .footer-note strong { color: #e03131; }

    .footer-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        border-radius: 9px;
        padding: 9px 18px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        line-height: 1;
    }

    .btn-cancel {
        background: #f0f1f8;
        color: #4a5080;
        border: 1.5px solid #e2e5f0;
    }
    .btn-cancel:hover { background: #e4e6f5; color: #2d3148; }

    .btn-save {
        background: linear-gradient(135deg, #3b5bdb 0%, #5c7cfa 100%);
        color: #fff;
        box-shadow: 0 3px 10px rgba(59,91,219,0.3);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(59,91,219,0.35); }
    .btn-save:active { transform: translateY(0); }

    /* ── ALERT ── */
    .alert {
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 0.82rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background: #fff5f5;
        border: 1px solid #ffc9c9;
        color: #c92a2a;
    }

    .alert-danger svg { flex-shrink: 0; margin-top: 1px; }

    .alert-danger ul {
        margin: 4px 0 0;
        padding-left: 16px;
        list-style: disc;
    }

    .alert-danger ul li { margin-bottom: 2px; }

    /* ── RIGHT PANEL: INFO CARDS ── */
    .ps-sidebar {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e4e7f3;
        box-shadow: 0 2px 16px rgba(26,29,46,0.05);
        overflow: hidden;
    }

    .info-card-header {
        padding: 13px 18px;
        border-bottom: 1px solid #e8eaf3;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fafbfe;
    }

    .info-card-header .ic-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .ic-blue { background: #eef1fd; color: #3b5bdb; }
    .ic-green { background: #e6faf0; color: #2f9e44; }
    .ic-amber { background: #fff8e1; color: #f08c00; }
    .ic-purple { background: #f3ecfd; color: #7048e8; }

    .info-card-header h3 {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
    }

    .info-card-body {
        padding: 15px 18px;
    }

    /* ── STEP LIST ── */
    .step-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    .step-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.8rem;
        color: #4a5080;
        line-height: 1.5;
        font-weight: 500;
    }

    .step-num {
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, #3b5bdb, #5c7cfa);
        color: #fff;
        border-radius: 50%;
        font-size: 0.67rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ── FORMAT LIST ── */
    .format-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .format-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 11px;
        background: #f8f9fc;
        border: 1px solid #e8eaf3;
        border-radius: 9px;
    }

    .format-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .format-item p {
        font-size: 0.78rem;
        color: #1a1d2e;
        font-weight: 600;
        margin: 0 0 1px;
    }

    .format-item span {
        font-size: 0.72rem;
        color: #9399b2;
        font-weight: 500;
    }

    /* ── STATS GRID ── */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .stat-box {
        background: #f8f9fc;
        border: 1px solid #e8eaf3;
        border-radius: 10px;
        padding: 12px;
        text-align: center;
    }

    .stat-box .stat-val {
        font-size: 1.4rem;
        font-weight: 700;
        color: #3b5bdb;
        line-height: 1;
        margin-bottom: 4px;
        font-family: 'DM Mono', monospace;
    }

    .stat-box .stat-label {
        font-size: 0.72rem;
        color: #9399b2;
        font-weight: 600;
        line-height: 1.3;
    }

    /* ── TIP BOX ── */
    .tip-box {
        background: linear-gradient(135deg, #fffbeb 0%, #fff8e1 100%);
        border: 1px solid #ffe08a;
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        align-items: flex-start;
        gap: 9px;
    }

    .tip-box svg { flex-shrink: 0; margin-top: 1px; color: #f08c00; }

    .tip-box p {
        font-size: 0.78rem;
        color: #7d5a00;
        margin: 0;
        font-weight: 500;
        line-height: 1.5;
    }

    .tip-box strong { font-weight: 700; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .ps-layout {
            grid-template-columns: 1fr;
        }

        .ps-sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 600px) {
        .ps-root { padding: 16px; }
        .ps-sidebar { grid-template-columns: 1fr; }
    }
</style>

<div class="ps-root">

    {{-- Header --}}
    <div class="ps-header">
        <div class="ps-header-left">
            <h1>Tambah Dokumen Persyaratan</h1>
            <div class="ps-breadcrumb">
                <span>Beranda</span>
                <span class="sep">›</span>
                <span>Dokumen Persyaratan Surat</span>
                <span class="sep">›</span>
                <span class="current">Tambah</span>
            </div>
        </div>
        <div class="ps-header-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Dokumen Baru
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 20px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <strong>Terdapat kesalahan pada input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Two-Column Layout --}}
    <div class="ps-layout">

        {{-- LEFT: Main Form Card --}}
        <div class="ps-card">

            {{-- Card Header --}}
            <div class="ps-card-header">
                <div class="icon-wrap">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <div>
                    <h2>Formulir Tambah Dokumen</h2>
                    <p>Isi data persyaratan surat baru di bawah ini</p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.layanan-surat.persyaratan.store') }}" method="POST" id="docForm">
                @csrf

                <div class="ps-form-body">

                    {{-- Nama Dokumen --}}
                    <div class="form-group">
                        <label class="form-label" for="nama">
                            Nama Dokumen <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                            value="{{ old('nama') }}"
                            placeholder="Contoh: Kartu Tanda Penduduk (KTP)"
                            autofocus
                            autocomplete="off"
                            maxlength="100"
                            oninput="updateCharCount(this)"
                        >
                        <div class="input-meta">
                            @error('nama')
                                <div class="error-msg">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </div>
                            @else
                                <div class="hint-msg">Nama dokumen harus jelas dan mudah dipahami masyarakat.</div>
                            @enderror
                            <span class="char-count" id="charCount"><span id="charNum">{{ strlen(old('nama', '')) }}</span>/100</span>
                        </div>

                        {{-- Quick-fill chips --}}
                        <div class="example-chips">
                            <span>Cepat isi:</span>
                            <div class="chip" onclick="fillInput('Kartu Tanda Penduduk (KTP)')">KTP</div>
                            <div class="chip" onclick="fillInput('Kartu Keluarga (KK)')">KK</div>
                            <div class="chip" onclick="fillInput('Akta Kelahiran')">Akta Lahir</div>
                            <div class="chip" onclick="fillInput('Surat Nikah / Akta Perkawinan')">Surat Nikah</div>
                            <div class="chip" onclick="fillInput('Ijazah Terakhir')">Ijazah</div>
                            <div class="chip" onclick="fillInput('Pas Foto 3x4')">Pas Foto</div>
                        </div>
                    </div>

                    <hr style="border:none;border-top:1px solid #f0f1f8;margin:22px 0;">

                    {{-- Keterangan --}}
                    <div class="form-group">
                        <label class="form-label" for="keterangan">
                            Keterangan <span style="color:#9399b2;font-weight:400;text-transform:none;">(Opsional)</span>
                        </label>
                        <textarea
                            id="keterangan"
                            name="keterangan"
                            class="form-input {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: Fotokopi KTP yang masih berlaku, minimal 1 lembar..."
                        >{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="error-msg">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @else
                            <div class="hint-msg">Tambahkan instruksi spesifik seperti jumlah fotokopi, ukuran, atau format dokumen yang dibutuhkan.</div>
                        @enderror
                    </div>

                </div>

                {{-- Footer --}}
                <div class="ps-form-footer">
                    <div class="footer-note">Kolom bertanda <strong>*</strong> wajib diisi</div>
                    <div class="footer-actions">
                        <a href="{{ route('admin.layanan-surat.persyaratan.index') }}" class="btn btn-cancel">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-save">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Dokumen
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- RIGHT: Sidebar Info --}}
        <div class="ps-sidebar">

            {{-- Panduan Pengisian --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h3>Panduan Pengisian</h3>
                </div>
                <div class="info-card-body">
                    <ul class="step-list">
                        <li>
                            <div class="step-num">1</div>
                            <div>Isi <strong>nama dokumen</strong> secara lengkap, sertakan singkatan jika ada (misal: KTP, KK).</div>
                        </li>
                        <li>
                            <div class="step-num">2</div>
                            <div>Gunakan tombol <strong>cepat isi</strong> untuk memilih dokumen umum yang sering digunakan.</div>
                        </li>
                        <li>
                            <div class="step-num">3</div>
                            <div>Tambahkan <strong>keterangan</strong> jika ada instruksi khusus seperti jumlah lembar atau format.</div>
                        </li>
                        <li>
                            <div class="step-num">4</div>
                            <div>Klik <strong>Simpan Dokumen</strong> untuk menyimpan data ke sistem.</div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Format Dokumen Umum --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-green">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <h3>Dokumen Umum</h3>
                </div>
                <div class="info-card-body">
                    <div class="format-list">
                        <div class="format-item">
                            <div class="format-dot" style="background:#3b5bdb;"></div>
                            <div>
                                <p>KTP / KK</p>
                                <span>Identitas penduduk resmi</span>
                            </div>
                        </div>
                        <div class="format-item">
                            <div class="format-dot" style="background:#2f9e44;"></div>
                            <div>
                                <p>Akta Kelahiran / Nikah</p>
                                <span>Dokumen catatan sipil</span>
                            </div>
                        </div>
                        <div class="format-item">
                            <div class="format-dot" style="background:#f08c00;"></div>
                            <div>
                                <p>Surat Keterangan RT/RW</p>
                                <span>Surat domisili & pengantar</span>
                            </div>
                        </div>
                        <div class="format-item">
                            <div class="format-dot" style="background:#7048e8;"></div>
                            <div>
                                <p>Pas Foto Terbaru</p>
                                <span>Ukuran 3×4 atau 4×6 cm</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tip --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-amber">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <h3>Tips & Saran</h3>
                </div>
                <div class="info-card-body">
                    <div class="tip-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <p><strong>Gunakan nama yang baku.</strong> Pastikan penamaan dokumen sesuai dengan istilah resmi yang dikenal masyarakat agar tidak membingungkan saat pengajuan surat.</p>
                    </div>
                </div>
            </div>

        </div>{{-- end sidebar --}}

    </div>{{-- end layout --}}

</div>

<script>
function updateCharCount(input) {
    document.getElementById('charNum').textContent = input.value.length;
}

function fillInput(value) {
    const input = document.getElementById('nama');
    input.value = value;
    input.focus();
    updateCharCount(input);
    // subtle highlight effect
    input.style.borderColor = '#3b5bdb';
    input.style.boxShadow = '0 0 0 3.5px rgba(59,91,219,0.15)';
    setTimeout(() => {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    }, 800);
}
</script>

@endsection