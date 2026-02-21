@extends('layouts.admin')

@section('title', 'Edit Dusun')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap');

    .page-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-height: 100vh;
        background: #f0f4f8;
        padding: 2rem;
    }

    .page-wrapper::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background:
            radial-gradient(ellipse 800px 500px at 10% 20%, rgba(234, 179, 8, 0.06) 0%, transparent 70%),
            radial-gradient(ellipse 600px 400px at 90% 80%, rgba(16, 185, 129, 0.06) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .page-wrapper > * { position: relative; z-index: 1; }

    /* Header Card */
    .header-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 24px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.75rem;
        animation: slideDown 0.4s ease;
    }

    .header-accent {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, #d97706, #f59e0b);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
    }

    .page-title {
        font-family: 'Instrument Serif', serif;
        font-size: 1.9rem;
        font-style: italic;
        color: #0f172a;
        line-height: 1.1;
        margin: 0;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 0.3rem;
    }

    .breadcrumb span.active { color: #475569; font-weight: 600; }
    .breadcrumb .sep { color: #cbd5e1; }

    /* Main Form Card */
    .form-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 8px 32px rgba(0,0,0,0.07);
        overflow: hidden;
        animation: slideUp 0.45s ease;
    }

    .form-card-header {
        background: linear-gradient(135deg, #1c1007 0%, #292012 100%);
        padding: 1.5rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .form-card-header::after {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 180px; height: 180px;
        background: rgba(245, 158, 11, 0.12);
        border-radius: 50%;
    }

    .form-card-header::before {
        content: '';
        position: absolute;
        right: 40px; bottom: -60px;
        width: 120px; height: 120px;
        background: rgba(16, 185, 129, 0.08);
        border-radius: 50%;
    }

    .form-card-header h2 {
        font-size: 1rem;
        font-weight: 700;
        color: white;
        margin: 0 0 0.2rem;
        position: relative;
        z-index: 1;
    }

    .form-card-header p {
        font-size: 0.8rem;
        color: #94a3b8;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* Current data badge */
    .current-badge {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.75rem;
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-radius: 100px;
        padding: 0.3rem 0.8rem;
        font-size: 0.75rem;
        color: #fbbf24;
        font-weight: 600;
    }

    .form-body { padding: 2rem; }

    /* Section label */
    .section-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #d97706;
        background: #fffbeb;
        border: 1px solid #fde68a;
        padding: 0.3rem 0.8rem;
        border-radius: 100px;
        display: inline-block;
        margin-bottom: 1.2rem;
    }

    /* Form Groups */
    .form-group { margin-bottom: 1.5rem; }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.5rem;
        letter-spacing: 0.01em;
    }

    .form-group label .req { color: #ef4444; margin-left: 2px; }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.875rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a;
        background: #f8fafc;
        transition: all 0.2s ease;
        box-sizing: border-box;
        outline: none;
    }

    .form-input::placeholder { color: #94a3b8; }

    .form-input:focus {
        border-color: #f59e0b;
        background: white;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .form-input:hover:not(:focus) {
        border-color: #cbd5e1;
        background: white;
    }

    /* Input with icon */
    .input-wrapper { position: relative; }

    .input-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
        transition: color 0.2s;
    }

    .input-wrapper:focus-within .input-icon { color: #f59e0b; }
    .input-wrapper .form-input { padding-left: 2.75rem; }

    /* Grid */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Number input */
    input[type=number] { appearance: textfield; -moz-appearance: textfield; }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Counter widget */
    .counter-wrapper {
        display: flex;
        align-items: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        overflow: hidden;
        transition: all 0.2s;
    }

    .counter-wrapper:focus-within {
        border-color: #f59e0b;
        background: white;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    }

    .counter-btn {
        padding: 0.75rem 1rem;
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 1.1rem;
        font-weight: 700;
        transition: all 0.15s;
        flex-shrink: 0;
        line-height: 1;
    }

    .counter-btn:hover { background: #fef3c7; color: #d97706; }
    .counter-btn:active { background: #fde68a; transform: scale(0.95); }

    .counter-input {
        flex: 1;
        border: none;
        background: transparent;
        text-align: center;
        font-size: 0.9rem;
        font-weight: 700;
        color: #0f172a;
        font-family: 'Plus Jakarta Sans', sans-serif;
        outline: none;
        padding: 0.75rem 0;
        min-width: 0;
    }

    /* Divider */
    .form-divider {
        border: none;
        border-top: 1px dashed #e2e8f0;
        margin: 1.75rem 0;
    }

    /* Error */
    .error-msg {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Info tip */
    .info-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 10px;
        padding: 0.6rem 0.9rem;
        font-size: 0.78rem;
        color: #92400e;
        margin-bottom: 1.5rem;
    }

    /* Footer */
    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 2rem;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }

    .form-footer-right {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-cancel {
        background: white;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #374151;
        transform: translateY(-1px);
    }

    .btn-save {
        background: linear-gradient(135deg, #d97706, #f59e0b);
        color: white;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #b45309, #d97706);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
    }

    .btn-save:active { transform: translateY(0); }

    /* Changed indicator */
    .changed-dot {
        display: none;
        width: 7px; height: 7px;
        background: #f59e0b;
        border-radius: 50%;
        margin-left: 0.3rem;
        animation: pulse 1.5s infinite;
    }

    .is-changed .changed-dot { display: inline-block; }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }

    /* Animations */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="page-wrapper">

    {{-- Header --}}
    <div class="header-card">
        <div style="display:flex; align-items:center; gap:1rem;">
            <div class="header-accent">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="page-title">Edit Dusun</h1>
                <div class="breadcrumb">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5m4 0h5a1 1 0 001-1V10"/>
                    </svg>
                    <span>Beranda</span>
                    <span class="sep">/</span>
                    <span>Info Desa</span>
                    <span class="sep">/</span>
                    <span>Wilayah Administratif</span>
                    <span class="sep">/</span>
                    <span class="active">Edit Dusun</span>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.info-desa.wilayah-administratif') }}" class="btn btn-cancel">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="form-card">

        {{-- Card Header --}}
        <div class="form-card-header">
            <h2>✏️ Perbarui Data Dusun</h2>
            <p>Ubah informasi dusun sesuai data terbaru yang valid</p>
            <div class="current-badge">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $wilayah['nama'] ?? 'Dusun' }}
            </div>
        </div>

        <form method="POST" action="{{ route('admin.info-desa.wilayah-administratif.update', $wilayah['id']) }}">
            @csrf
            @method('PUT')

            <div class="form-body">

                {{-- Info tip --}}
                <div class="info-badge">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Perubahan akan disimpan setelah menekan <strong style="color:#d97706;">Simpan Perubahan</strong>. Pastikan semua data sudah benar.
                </div>

                {{-- Section: Identitas --}}
                <div class="section-label">Identitas Wilayah</div>

                {{-- Nama Dusun --}}
                <div class="form-group">
                    <label for="nama">
                        Nama Dusun <span class="req">*</span>
                        <span class="changed-dot" id="dot-nama"></span>
                    </label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <input type="text" name="nama" id="nama"
                               value="{{ old('nama', $wilayah['nama']) }}" required
                               class="form-input" placeholder="Contoh: Dusun Krajan"
                               data-original="{{ $wilayah['nama'] }}">
                    </div>
                    @error('nama')
                        <p class="error-msg">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="white" d="M11 8h2v5h-2zm0 7h2v2h-2z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Kepala Wilayah --}}
                <div class="form-group">
                    <label for="kepala_wilayah">
                        Kepala Wilayah <span class="req">*</span>
                        <span class="changed-dot" id="dot-kepala_wilayah"></span>
                    </label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" name="kepala_wilayah" id="kepala_wilayah"
                               value="{{ old('kepala_wilayah', $wilayah['kepala_wilayah']) }}" required
                               class="form-input" placeholder="Nama lengkap kepala wilayah"
                               data-original="{{ $wilayah['kepala_wilayah'] }}">
                    </div>
                    @error('kepala_wilayah')
                        <p class="error-msg">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="white" d="M11 8h2v5h-2zm0 7h2v2h-2z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <hr class="form-divider">

                {{-- Section: Struktur RT/RW --}}
                <div class="section-label">Struktur RT / RW</div>

                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    {{-- RW --}}
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="rw">
                            Jumlah RW <span class="req">*</span>
                            <span class="changed-dot" id="dot-rw"></span>
                        </label>
                        <div class="counter-wrapper">
                            <button type="button" class="counter-btn" onclick="changeVal('rw', -1)">−</button>
                            <input type="number" name="rw" id="rw"
                                   value="{{ old('rw', $wilayah['rw']) }}" min="1" required
                                   class="counter-input" data-original="{{ $wilayah['rw'] }}">
                            <button type="button" class="counter-btn" onclick="changeVal('rw', 1)">+</button>
                        </div>
                        @error('rw')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- RT --}}
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="rt">
                            Jumlah RT <span class="req">*</span>
                            <span class="changed-dot" id="dot-rt"></span>
                        </label>
                        <div class="counter-wrapper">
                            <button type="button" class="counter-btn" onclick="changeVal('rt', -1)">−</button>
                            <input type="number" name="rt" id="rt"
                                   value="{{ old('rt', $wilayah['rt']) }}" min="1" required
                                   class="counter-input" data-original="{{ $wilayah['rt'] }}">
                            <button type="button" class="counter-btn" onclick="changeVal('rt', 1)">+</button>
                        </div>
                        @error('rt')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="form-divider">

                {{-- Section: Data Penduduk --}}
                <div class="section-label">Data Penduduk</div>

                {{-- KK --}}
                <div class="form-group">
                    <label for="kk">
                        Jumlah Kepala Keluarga (KK) <span class="req">*</span>
                        <span class="changed-dot" id="dot-kk"></span>
                    </label>
                    <div class="counter-wrapper">
                        <button type="button" class="counter-btn" onclick="changeVal('kk', -10)">−10</button>
                        <button type="button" class="counter-btn" onclick="changeVal('kk', -1)">−</button>
                        <input type="number" name="kk" id="kk"
                               value="{{ old('kk', $wilayah['kk']) }}" min="0" required
                               class="counter-input" data-original="{{ $wilayah['kk'] }}">
                        <button type="button" class="counter-btn" onclick="changeVal('kk', 1)">+</button>
                        <button type="button" class="counter-btn" onclick="changeVal('kk', 10)">+10</button>
                    </div>
                    @error('kk')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid-2">
                    {{-- Laki-laki --}}
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="laki_laki">
                            <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                                <span style="color:#3b82f6;">♂</span> Jumlah Laki-laki
                            </span> <span class="req">*</span>
                            <span class="changed-dot" id="dot-laki_laki"></span>
                        </label>
                        <div class="counter-wrapper">
                            <button type="button" class="counter-btn" onclick="changeVal('laki_laki', -1)">−</button>
                            <input type="number" name="laki_laki" id="laki_laki"
                                   value="{{ old('laki_laki', $wilayah['laki_laki']) }}" min="0" required
                                   class="counter-input" data-original="{{ $wilayah['laki_laki'] }}">
                            <button type="button" class="counter-btn" onclick="changeVal('laki_laki', 1)">+</button>
                        </div>
                        @error('laki_laki')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Perempuan --}}
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="perempuan">
                            <span style="display:inline-flex; align-items:center; gap:0.4rem;">
                                <span style="color:#ec4899;">♀</span> Jumlah Perempuan
                            </span> <span class="req">*</span>
                            <span class="changed-dot" id="dot-perempuan"></span>
                        </label>
                        <div class="counter-wrapper">
                            <button type="button" class="counter-btn" onclick="changeVal('perempuan', -1)">−</button>
                            <input type="number" name="perempuan" id="perempuan"
                                   value="{{ old('perempuan', $wilayah['perempuan']) }}" min="0" required
                                   class="counter-input" data-original="{{ $wilayah['perempuan'] }}">
                            <button type="button" class="counter-btn" onclick="changeVal('perempuan', 1)">+</button>
                        </div>
                        @error('perempuan')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Live total --}}
                <div style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <div id="total-penduduk" style="flex:1; padding: 0.75rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; font-size: 0.8rem; color: #065f46; display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                        Total penduduk: <strong id="total-num">0</strong> jiwa
                    </div>
                    <div id="change-counter" style="display:none; padding: 0.75rem 1rem; background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; font-size: 0.8rem; color: #92400e; align-items: center; gap: 0.5rem;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span id="change-text">0 field diubah</span>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <div style="font-size: 0.75rem; color: #94a3b8; display:flex; align-items:center; gap:0.4rem;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    ID Dusun: <strong style="color:#64748b;">{{ $wilayah['id'] }}</strong>
                </div>
                <div class="form-footer-right">
                    <a href="{{ route('admin.info-desa.wilayah-administratif') }}" class="btn btn-cancel">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<script>
    function changeVal(id, delta) {
        const input = document.getElementById(id);
        const min = parseInt(input.min) || 0;
        input.value = Math.max(min, (parseInt(input.value) || 0) + delta);
        checkChanged(input);
        updateTotal();
    }

    function checkChanged(input) {
        const original = input.dataset.original;
        const current = input.value;
        const fieldName = input.name;
        const dot = document.getElementById('dot-' + fieldName);
        if (dot) {
            if (String(current) !== String(original)) {
                dot.parentElement.classList.add('is-changed');
            } else {
                dot.parentElement.classList.remove('is-changed');
            }
        }
        updateChangedCount();
    }

    function updateChangedCount() {
        const inputs = document.querySelectorAll('[data-original]');
        let count = 0;
        inputs.forEach(input => {
            if (String(input.value) !== String(input.dataset.original)) count++;
        });

        const counter = document.getElementById('change-counter');
        const text = document.getElementById('change-text');
        if (count > 0) {
            counter.style.display = 'flex';
            text.textContent = count + ' field diubah';
        } else {
            counter.style.display = 'none';
        }
    }

    function updateTotal() {
        const ll = parseInt(document.getElementById('laki_laki').value) || 0;
        const pr = parseInt(document.getElementById('perempuan').value) || 0;
        document.getElementById('total-num').textContent = (ll + pr).toLocaleString('id-ID');
    }

    // Watch all inputs for changes
    document.querySelectorAll('[data-original]').forEach(input => {
        input.addEventListener('input', function () {
            checkChanged(this);
            updateTotal();
        });
    });

    updateTotal();
</script>

@endsection