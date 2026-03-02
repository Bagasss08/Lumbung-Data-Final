@extends('layouts.admin')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

    :root {
        --bg-base: #f0f2f7;
        --surface: #ffffff;
        --surface-2: #f7f8fc;
        --border: #e4e8f0;
        --border-light: #eef1f7;
        --accent: #4f6ef7;
        --accent-dark: #3a56d4;
        --accent-soft: #eef0ff;
        --text-primary: #1a1f36;
        --text-secondary: #6b7594;
        --text-muted: #a0a8c0;
        --success: #10b981;
        --success-soft: #ecfdf5;
        --radius: 14px;
        --radius-sm: 8px;
        --shadow-md: 0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
    }

    * { box-sizing: border-box; }

    body {
        background: var(--bg-base);
        font-family: 'Sora', sans-serif;
        color: var(--text-primary);
    }

    /* ===== Page ===== */
    .detail-page {
        max-width: 780px;
        margin: 0 auto;
        padding: 36px 24px 60px;
        animation: pageIn 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes pageIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== Back Link ===== */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-muted);
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.15s;
    }

    .back-link:hover { color: var(--accent); }

    .back-link svg { transition: transform 0.15s; }
    .back-link:hover svg { transform: translateX(-3px); }

    /* ===== Header ===== */
    .page-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--accent);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .page-eyebrow::before {
        content: '';
        display: inline-block;
        width: 18px;
        height: 2px;
        background: var(--accent);
        border-radius: 2px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 24px;
    }

    /* ===== Card ===== */
    .detail-card {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    /* ===== Card Top Banner ===== */
    .card-banner {
        background: linear-gradient(135deg, #4f6ef7 0%, #6366f1 100%);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .card-banner::before {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
    }

    .card-banner::after {
        content: '';
        position: absolute;
        right: 40px;
        bottom: -50px;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }

    .banner-icon {
        width: 48px;
        height: 48px;
        background: rgba(255,255,255,0.15);
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .banner-text { flex: 1; min-width: 0; }

    .banner-nomor {
        font-family: 'JetBrains Mono', monospace;
        font-size: 16px;
        font-weight: 500;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .banner-label {
        font-size: 12px;
        color: rgba(255,255,255,0.65);
        margin-top: 3px;
    }

    /* ===== Fields Grid ===== */
    .fields-body {
        padding: 0;
    }

    .field-row {
        display: flex;
        align-items: flex-start;
        padding: 18px 28px;
        border-bottom: 1px solid var(--border-light);
        gap: 20px;
        transition: background 0.15s;
        animation: rowIn 0.35s ease both;
    }

    .field-row:last-child { border-bottom: none; }
    .field-row:hover { background: #fafbff; }

    @keyframes rowIn {
        from { opacity: 0; transform: translateX(-6px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @for($i = 0; $i < 6; $i++)
    .field-row:nth-child({{ $i + 1 }}) { animation-delay: {{ 0.08 + $i * 0.05 }}s; }
    @endfor

    .field-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .icon-blue   { background: var(--accent-soft); color: var(--accent); }
    .icon-indigo { background: #ede9fe; color: #6d28d9; }
    .icon-green  { background: var(--success-soft); color: var(--success); }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-rose   { background: #fff1f3; color: #f43f5e; }

    .field-content { flex: 1; min-width: 0; }

    .field-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 5px;
    }

    .field-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.6;
    }

    .field-value.mono {
        font-family: 'JetBrains Mono', monospace;
        font-size: 13.5px;
    }

    .field-value.empty {
        color: var(--text-muted);
        font-weight: 400;
        font-style: italic;
    }

    .field-value.multiline {
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* ===== Actions ===== */
    .card-footer {
        padding: 18px 28px;
        background: var(--surface-2);
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
        font-family: 'Sora', sans-serif;
        letter-spacing: 0.2px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }

    .btn:active {
        transform: translateY(0);
        filter: brightness(0.95);
        box-shadow: none;
    }

    .btn-download {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 2px 8px rgba(16,185,129,0.25);
    }

    .btn-back {
        background: var(--surface);
        color: var(--text-secondary);
        border: 1px solid var(--border);
    }

    .btn-back:hover { color: var(--text-primary); }
</style>

<div class="detail-page">

    {{-- Back --}}
    <a href="{{ route('arsip.index') }}" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Daftar Arsip
    </a>

    {{-- Eyebrow --}}
    <div class="page-eyebrow">Detail Dokumen</div>
    <h1 class="page-title">Arsip Surat</h1>

    <div class="detail-card">

        {{-- Banner --}}
        <div class="card-banner">
            <div class="banner-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div class="banner-text">
                <div class="banner-nomor">{{ $arsip->nomor_surat }}</div>
                <div class="banner-label">Nomor Surat</div>
            </div>
        </div>

        {{-- Fields --}}
        <div class="fields-body">

            {{-- Jenis Surat --}}
            <div class="field-row">
                <div class="field-icon icon-blue">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <div class="field-content">
                    <div class="field-label">Jenis Surat</div>
                    <div class="field-value">{{ $arsip->jenis_surat }}</div>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="field-row">
                <div class="field-icon icon-indigo">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="field-content">
                    <div class="field-label">Tanggal Surat</div>
                    <div class="field-value mono">
                        {{ \Carbon\Carbon::parse($arsip->tanggal_surat)->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>

            {{-- Perihal --}}
            <div class="field-row">
                <div class="field-icon icon-orange">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="11" y2="18"/>
                    </svg>
                </div>
                <div class="field-content">
                    <div class="field-label">Perihal</div>
                    @if($arsip->perihal)
                        <div class="field-value">{{ $arsip->perihal }}</div>
                    @else
                        <div class="field-value empty">Tidak tersedia</div>
                    @endif
                </div>
            </div>

            {{-- Isi Ringkas --}}
            <div class="field-row">
                <div class="field-icon icon-green">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <div class="field-content">
                    <div class="field-label">Isi Ringkas</div>
                    @if($arsip->isi_ringkas)
                        <div class="field-value multiline">{{ $arsip->isi_ringkas }}</div>
                    @else
                        <div class="field-value empty">Tidak tersedia</div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div class="card-footer">
            <a href="{{ route('arsip.download', $arsip->id) }}" class="btn btn-download">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Unduh File
            </a>

            <a href="{{ route('arsip.index') }}" class="btn btn-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>

    </div>

</div>

@endsection