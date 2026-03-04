@extends('layouts.admin')

@section('title', 'Edit Dokumen Persyaratan')

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
    .ps-breadcrumb .current { color: #f59f00; font-weight: 600; }

    .ps-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff8e1;
        color: #f08c00;
        border: 1px solid #ffe08a;
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
        background: linear-gradient(135deg, #fffdf5 0%, #fffbea 100%);
    }

    .ps-card-header .icon-wrap {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #f59f00 0%, #fcc419 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(245,159,0,0.35);
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

    .id-badge {
        margin-left: auto;
        background: #f0f1f8;
        border: 1px solid #e2e5f0;
        border-radius: 8px;
        padding: 5px 11px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7aab;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .id-badge span {
        font-family: 'DM Mono', monospace;
        color: #3b5bdb;
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

    .changed-dot {
        display: none;
        width: 7px;
        height: 7px;
        background: #f59f00;
        border-radius: 50%;
        margin-left: 6px;
        vertical-align: middle;
    }

    .changed-dot.show { display: inline-block; }

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
        border-color: #f59f00;
        background: #fff;
        box-shadow: 0 0 0 3.5px rgba(245,159,0,0.12);
    }

    .form-input::placeholder { color: #c1c6d6; }

    .form-input.is-invalid {
        border-color: #e03131;
        background: #fff8f8;
    }

    .form-input.is-invalid:focus {
        border-color: #e03131;
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

    /* ── META ROW ── */
    .meta-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding: 12px 22px;
        border-top: 1px dashed #eef0f8;
        background: #fafbfe;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.76rem;
        color: #9399b2;
        font-weight: 500;
    }

    .meta-item svg { color: #bbbfda; flex-shrink: 0; }
    .meta-item strong { color: #4a5080; font-weight: 600; }

    /* ── FORM FOOTER ── */
    .ps-form-footer {
        padding: 16px 22px;
        border-top: 1px solid #e8eaf3;
        background: linear-gradient(135deg, #fffdf5 0%, #fffbea 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }

    .footer-left { display: flex; align-items: center; gap: 6px; }
    .footer-right { display: flex; align-items: center; gap: 8px; }

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
        background: linear-gradient(135deg, #f59f00 0%, #fcc419 100%);
        color: #fff;
        box-shadow: 0 3px 10px rgba(245,159,0,0.32);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(245,159,0,0.38); }
    .btn-save:active { transform: translateY(0); }

    .btn-danger-soft {
        background: #fff0f0;
        color: #e03131;
        border: 1.5px solid #ffc9c9;
    }
    .btn-danger-soft:hover { background: #ffe3e3; color: #c92a2a; }

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

    .alert-success {
        background: #f3fdf6;
        border: 1px solid #b2f2c9;
        color: #2f9e44;
    }

    .alert-success svg { flex-shrink: 0; margin-top: 1px; }

    /* ── RIGHT PANEL ── */
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

    .ic-amber  { background: #fff8e1; color: #f08c00; }
    .ic-blue   { background: #eef1fd; color: #3b5bdb; }
    .ic-red    { background: #fff0f0; color: #e03131; }
    .ic-green  { background: #e6faf0; color: #2f9e44; }

    .info-card-header h3 {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0;
    }

    .info-card-body { padding: 15px 18px; }

    /* ── CURRENT DATA BOX ── */
    .current-box {
        background: #fffbea;
        border: 1.5px solid #ffe08a;
        border-radius: 10px;
        padding: 13px 15px;
        margin-bottom: 12px;
    }

    .current-box .cb-label {
        font-size: 0.71rem;
        font-weight: 700;
        color: #c07800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }

    .current-box .cb-value {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1a1d2e;
        word-break: break-word;
    }

    /* ── DETAIL ROW ── */
    .detail-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .detail-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 11px;
        background: #f8f9fc;
        border: 1px solid #e8eaf3;
        border-radius: 9px;
        gap: 8px;
    }

    .detail-item .di-label {
        font-size: 0.76rem;
        color: #9399b2;
        font-weight: 600;
        flex-shrink: 0;
    }

    .detail-item .di-value {
        font-size: 0.78rem;
        color: #1a1d2e;
        font-weight: 600;
        font-family: 'DM Mono', monospace;
        text-align: right;
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
        background: linear-gradient(135deg, #f59f00, #fcc419);
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

    /* ── DANGER ZONE ── */
    .danger-zone-body {
        padding: 15px 18px;
    }

    .danger-info {
        font-size: 0.78rem;
        color: #9399b2;
        font-weight: 500;
        line-height: 1.55;
        margin-bottom: 13px;
    }

    .danger-info strong { color: #e03131; }

    .btn-delete-full {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 10px;
        background: #fff0f0;
        color: #e03131;
        border: 1.5px solid #ffc9c9;
        border-radius: 9px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-delete-full:hover {
        background: #ffe3e3;
        border-color: #e03131;
        color: #c92a2a;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .ps-layout { grid-template-columns: 1fr; }
        .ps-sidebar { display: grid; grid-template-columns: 1fr 1fr; }
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
            <h1>Edit Dokumen Persyaratan</h1>
            <div class="ps-breadcrumb">
                <span>Beranda</span>
                <span class="sep">›</span>
                <span>Dokumen Persyaratan Surat</span>
                <span class="sep">›</span>
                <span class="current">Edit</span>
            </div>
        </div>
        <div class="ps-header-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Mode Edit
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

    {{-- Success Message --}}
    @if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    {{-- Two-Column Layout --}}
    <div class="ps-layout">

        {{-- LEFT: Main Form Card --}}
        <div class="ps-card">

            {{-- Card Header --}}
            <div class="ps-card-header">
                <div class="icon-wrap">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                <div>
                    <h2>Formulir Edit Dokumen</h2>
                    <p>Perbarui data persyaratan surat di bawah ini</p>
                </div>
                <div class="id-badge">
                    ID <span>#{{ $persyaratan->id }}</span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('admin.layanan-surat.persyaratan.update', $persyaratan->id) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="ps-form-body">

                    {{-- Nama Dokumen --}}
                    <div class="form-group">
                        <label class="form-label" for="nama">
                            Nama Dokumen <span class="required">*</span>
                            <span class="changed-dot" id="namaDot"></span>
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            class="form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                            value="{{ old('nama', $persyaratan->nama) }}"
                            placeholder="Contoh: Kartu Tanda Penduduk (KTP)"
                            data-original="{{ $persyaratan->nama }}"
                            autocomplete="off"
                            autofocus
                            maxlength="100"
                            oninput="handleInput(this, 'namaDot')"
                        >
                        <div class="input-meta">
                            @error('nama')
                                <div class="error-msg">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </div>
                            @else
                                <div class="hint-msg">Nama dokumen akan ditampilkan sebagai persyaratan pengajuan surat.</div>
                            @enderror
                            <span class="char-count"><span id="charNum">{{ strlen(old('nama', $persyaratan->nama)) }}</span>/100</span>
                        </div>
                    </div>

                    <hr style="border:none;border-top:1px solid #f0f1f8;margin:22px 0;">

                    {{-- Keterangan --}}
                    <div class="form-group">
                        <label class="form-label" for="keterangan">
                            Keterangan <span style="color:#9399b2;font-weight:400;text-transform:none;">(Opsional)</span>
                            <span class="changed-dot" id="keteranganDot"></span>
                        </label>
                        <textarea
                            id="keterangan"
                            name="keterangan"
                            class="form-input {{ $errors->has('keterangan') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: Fotokopi yang masih berlaku, minimal 1 lembar..."
                            data-original="{{ $persyaratan->keterangan ?? '' }}"
                            oninput="handleInput(this, 'keteranganDot')"
                        >{{ old('keterangan', $persyaratan->keterangan ?? '') }}</textarea>
                        @error('keterangan')
                            <div class="error-msg">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @else
                            <div class="hint-msg">Instruksi khusus seperti jumlah lembar, ukuran, atau format dokumen.</div>
                        @enderror
                    </div>

                </div>

                {{-- Meta Info --}}
                <div class="meta-row">
                    @if ($persyaratan->created_at)
                    <div class="meta-item">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Dibuat: <strong>{{ $persyaratan->created_at->format('d M Y, H:i') }}</strong>
                    </div>
                    @endif
                    @if ($persyaratan->updated_at && $persyaratan->updated_at != $persyaratan->created_at)
                    <div class="meta-item">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        Diperbarui: <strong>{{ $persyaratan->updated_at->format('d M Y, H:i') }}</strong>
                    </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="ps-form-footer">
                    <div class="footer-left">
                        {{-- Hapus dipindahkan ke sidebar, cukup Kembali di kiri --}}
                        <span class="hint-msg" style="margin:0;">Dot <span style="color:#f59f00;">●</span> menandakan field telah diubah</span>
                    </div>
                    <div class="footer-right">
                        <a href="{{ route('admin.layanan-surat.persyaratan.index') }}" class="btn btn-cancel">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-save" id="btnSave">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="ps-sidebar">

            {{-- Data Saat Ini --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-amber">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h3>Data Saat Ini</h3>
                </div>
                <div class="info-card-body">
                    <div class="current-box">
                        <div class="cb-label">Nama Dokumen</div>
                        <div class="cb-value">{{ $persyaratan->nama }}</div>
                    </div>
                    <div class="detail-list">
                        <div class="detail-item">
                            <span class="di-label">ID Dokumen</span>
                            <span class="di-value">#{{ $persyaratan->id }}</span>
                        </div>
                        @if ($persyaratan->created_at)
                        <div class="detail-item">
                            <span class="di-label">Tanggal Dibuat</span>
                            <span class="di-value">{{ $persyaratan->created_at->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if ($persyaratan->updated_at && $persyaratan->updated_at != $persyaratan->created_at)
                        <div class="detail-item">
                            <span class="di-label">Terakhir Edit</span>
                            <span class="di-value">{{ $persyaratan->updated_at->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Panduan Edit --}}
            <div class="info-card">
                <div class="info-card-header">
                    <div class="ic-icon ic-blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h3>Panduan Edit</h3>
                </div>
                <div class="info-card-body">
                    <ul class="step-list">
                        <li>
                            <div class="step-num">1</div>
                            <div>Ubah <strong>nama dokumen</strong> jika terdapat kesalahan penulisan atau perlu diperbarui.</div>
                        </li>
                        <li>
                            <div class="step-num">2</div>
                            <div>Dot <strong style="color:#f59f00;">●</strong> kuning pada label menandakan field tersebut telah diubah dari nilai semula.</div>
                        </li>
                        <li>
                            <div class="step-num">3</div>
                            <div>Klik <strong>Simpan Perubahan</strong> untuk menyimpan. Data lama akan digantikan.</div>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="info-card" style="border-color: #ffc9c9;">
                <div class="info-card-header" style="background: #fff5f5; border-bottom-color: #ffc9c9;">
                    <div class="ic-icon ic-red">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                    </div>
                    <h3 style="color: #c92a2a;">Zona Berbahaya</h3>
                </div>
                <div class="danger-zone-body">
                    <p class="danger-info">
                        Menghapus dokumen ini akan <strong>menghapus secara permanen</strong> dari sistem. Tindakan ini tidak dapat dibatalkan.
                    </p>
                    <form action="{{ route('admin.layanan-surat.persyaratan.destroy', $persyaratan->id) }}" method="POST" id="deleteForm" onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-full">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                            Hapus Dokumen Ini
                        </button>
                    </form>
                </div>
            </div>

        </div>{{-- end sidebar --}}

    </div>{{-- end layout --}}

</div>

<script>
function handleInput(input, dotId) {
    // Update char count if it's the nama field
    if (input.id === 'nama') {
        document.getElementById('charNum').textContent = input.value.length;
    }
    // Show changed dot
    const dot = document.getElementById(dotId);
    if (dot) {
        dot.classList.toggle('show', input.value !== input.dataset.original);
    }
}

function confirmDelete() {
    return confirm('Yakin ingin menghapus dokumen "{{ addslashes($persyaratan->nama) }}"?\nTindakan ini tidak dapat dibatalkan.');
}

// Init on load: check if old() differs from original (after validation fail)
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.form-input[data-original]').forEach(input => {
        const dotId = input.id + 'Dot';
        const dot = document.getElementById(dotId);
        if (dot) {
            dot.classList.toggle('show', input.value !== input.dataset.original);
        }
    });
});
</script>

@endsection