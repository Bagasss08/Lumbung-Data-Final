@extends('layouts.admin')

@section('title', 'Preview Surat')

@section('content')
{{-- Load TinyMCE Lokal --}}
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ─── CSS Variables ────────────────────────────────────────── */
:root {
    --pv-navy:       #0f172a;
    --pv-navy-mid:   #1e293b;
    --pv-slate:      #64748b;
    --pv-muted:      #94a3b8;
    --pv-line:       #e2e8f0;
    --pv-surface:    #f8fafc;
    --pv-blue:       #2563eb;
    --pv-blue-soft:  #eff6ff;
    --pv-green:      #059669;
    --pv-green-soft: #ecfdf5;
    --pv-radius:     12px;
    --pv-font:       'Plus Jakarta Sans', sans-serif;
    --pv-shadow-sm:  0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
    --pv-shadow-md:  0 4px 16px rgba(0,0,0,.07), 0 2px 6px rgba(0,0,0,.03);
    --pv-shadow-lg:  0 20px 40px rgba(0,0,0,.09), 0 8px 16px rgba(0,0,0,.04);
}

/* ─── Page Wrapper ─────────────────────────────────────────── */
.pv-page {
    font-family: var(--pv-font);
    padding-bottom: 110px;
}

/* ─── Page Header ──────────────────────────────────────────── */
.pv-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.pv-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.pv-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 8px;
    border: 1px solid var(--pv-line);
    background: white;
    color: var(--pv-slate);
    font-size: 0.8125rem;
    font-weight: 500;
    font-family: var(--pv-font);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
    box-shadow: var(--pv-shadow-sm);
}
.pv-back-btn:hover {
    border-color: var(--pv-blue);
    color: var(--pv-blue);
    background: var(--pv-blue-soft);
}
.pv-title-group h2 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--pv-navy-mid);
    margin: 0;
    line-height: 1.3;
}
.pv-title-group p {
    font-size: 0.75rem;
    color: var(--pv-muted);
    margin: 2px 0 0;
}
.pv-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 700;
    background: var(--pv-green-soft);
    color: var(--pv-green);
    border: 1px solid #a7f3d0;
    font-family: var(--pv-font);
}
.pv-status-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--pv-green);
    animation: pv-pulse 2s infinite;
}
@keyframes pv-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.75); }
}

/* ─── Main Grid ────────────────────────────────────────────── */
.pv-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 960px) {
    .pv-grid { grid-template-columns: 1fr; }
    .pv-sidebar { display: none; }
}

/* ─── Sidebar ──────────────────────────────────────────────── */
.pv-sidebar {
    position: sticky;
    top: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.pv-card {
    background: white;
    border: 1px solid var(--pv-line);
    border-radius: var(--pv-radius);
    overflow: hidden;
    box-shadow: var(--pv-shadow-sm);
}
.pv-card-head {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0.75rem 1rem;
    background: var(--pv-surface);
    border-bottom: 1px solid var(--pv-line);
}
.pv-card-icon {
    width: 26px; height: 26px;
    border-radius: 6px;
    background: var(--pv-blue-soft);
    color: var(--pv-blue);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.pv-card-head h3 {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--pv-slate);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin: 0;
}
.pv-card-body { padding: 0.75rem 1rem; }

.pv-meta-row {
    display: flex;
    flex-direction: column;
    gap: 1px;
    padding: 0.45rem 0;
    border-bottom: 1px dashed var(--pv-line);
}
.pv-meta-row:first-child { padding-top: 0; }
.pv-meta-row:last-child  { border-bottom: none; padding-bottom: 0; }
.pv-meta-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--pv-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.pv-meta-value {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--pv-navy-mid);
    word-break: break-word;
}

.pv-checklist { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 7px; }
.pv-checklist li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 0.775rem;
    color: var(--pv-slate);
    line-height: 1.4;
}
.pv-check-ico {
    width: 15px; height: 15px;
    border-radius: 50%;
    background: var(--pv-green-soft);
    border: 1.5px solid #a7f3d0;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
    color: var(--pv-green);
}

/* ─── Editor Area ──────────────────────────────────────────── */
.pv-editor-area { display: flex; flex-direction: column; gap: 0.875rem; }

.pv-label-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.575rem 1rem;
    background: white;
    border: 1px solid var(--pv-line);
    border-radius: var(--pv-radius);
    box-shadow: var(--pv-shadow-sm);
    flex-wrap: wrap;
    gap: 8px;
}
.pv-label-left { display: flex; align-items: center; gap: 8px; }
.pv-editor-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    background: var(--pv-blue-soft);
    color: var(--pv-blue);
    border: 1px solid #bfdbfe;
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-family: var(--pv-font);
}
.pv-hint {
    font-size: 0.775rem;
    color: var(--pv-muted);
    font-family: var(--pv-font);
}
.pv-page-badge {
    font-size: 0.7rem;
    color: var(--pv-slate);
    padding: 3px 10px;
    background: var(--pv-surface);
    border: 1px solid var(--pv-line);
    border-radius: 6px;
    font-weight: 500;
    font-family: var(--pv-font);
}

.pv-editor-card {
    background: white;
    border: 1px solid var(--pv-line);
    border-radius: var(--pv-radius);
    overflow: hidden;
    box-shadow: var(--pv-shadow-md);
    transition: box-shadow 0.2s, border-color 0.2s;
}
.pv-editor-card:focus-within {
    border-color: #93c5fd;
    box-shadow: var(--pv-shadow-lg), 0 0 0 3px rgba(37,99,235,0.07);
}

/* ─── Action Ribbon ────────────────────────────────────────── */
.pv-ribbon {
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 400;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-top: 1px solid var(--pv-line);
    padding: 0.85rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.pv-ribbon-info { display: flex; align-items: center; gap: 10px; }
.pv-ribbon-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    background: var(--pv-surface);
    border: 1px solid var(--pv-line);
    display: flex; align-items: center; justify-content: center;
    color: var(--pv-slate);
    flex-shrink: 0;
}
.pv-ribbon-text p {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--pv-navy-mid);
    margin: 0;
    font-family: var(--pv-font);
    white-space: nowrap;
    max-width: 280px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pv-ribbon-text span {
    font-size: 0.7rem;
    color: var(--pv-muted);
    font-family: var(--pv-font);
}

.pv-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Info Tercetak */
.pv-print-info {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 8px;
    background-color: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-right: 8px;
}

/* Tombol Cetak Langsung (Secondary) */
.pv-btn-direct {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 10px;
    background: white;
    color: var(--pv-navy-mid);
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid var(--pv-line);
    cursor: pointer;
    font-family: var(--pv-font);
    transition: all 0.2s;
    white-space: nowrap;
}
.pv-btn-direct:hover:not(:disabled) {
    background: var(--pv-surface);
    border-color: var(--pv-slate);
    transform: translateY(-2px);
}

/* Tombol PDF (Primary) */
.pv-btn-print {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 26px;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
    font-size: 0.875rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    font-family: var(--pv-font);
    letter-spacing: 0.01em;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.32);
    white-space: nowrap;
}
.pv-btn-print:hover:not(:disabled) {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(37,99,235,0.42);
}

/* Disabled State */
button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    filter: grayscale(1);
    transform: none !important;
}

@media (max-width: 768px) {
    .pv-ribbon { padding: 0.75rem 1rem; flex-direction: column; align-items: stretch; height: auto; }
    .pv-ribbon-info { display: none; }
    .pv-actions { flex-direction: column; width: 100%; }
    .pv-btn-direct, .pv-btn-print, .pv-print-info { width: 100%; justify-content: center; }
    .pv-print-info { margin-right: 0; margin-bottom: 8px; }
}

/* ─── TinyMCE overrides ────────────────────────────────────── */
.tox-tinymce            { border: none !important; border-radius: 0 !important; }
.tox-notification--warning,
.tox-notifications-container { display: none !important; }
.tox .tox-toolbar-overlord,
.tox .tox-toolbar__primary {
    background: var(--pv-surface) !important;
    border-bottom: 1px solid var(--pv-line) !important;
}
</style>

<div class="pv-page">

    {{-- ── Page Header ──────────────────────────────────── --}}
    <div class="pv-header">
        <div class="pv-header-left">
            <a href="javascript:history.back()" class="pv-back-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali
            </a>
            <div class="pv-title-group">
                <h2>{{ $template->judul }}</h2>
                <p>Pratinjau &amp; Editor · Periksa isi sebelum mencetak</p>
            </div>
        </div>
        <div class="pv-status-badge">
            <span class="pv-status-dot"></span>
            Siap Cetak
        </div>
    </div>

    {{-- ── Main Grid ────────────────────────────────────── --}}
    <div class="pv-grid">

        {{-- Sidebar --}}
        <aside class="pv-sidebar">
            <div class="pv-card">
                <div class="pv-card-head">
                    <span class="pv-card-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </span>
                    <h3>Info Surat</h3>
                </div>
                <div class="pv-card-body">
                    <div class="pv-meta-row">
                        <span class="pv-meta-label">No. Surat</span>
                        <span class="pv-meta-value">{{ $formData['nomor_surat'] ?? $formData['format_nomor'] ?? '—' }}</span>
                    </div>
                    <div class="pv-meta-row">
                        <span class="pv-meta-label">Nama Pemohon</span>
                        <span class="pv-meta-value">{{ $formData['nama'] ?? $formData['nama_lengkap'] ?? '—' }}</span>
                    </div>
                    <div class="pv-meta-row">
                        <span class="pv-meta-label">NIK</span>
                        <span class="pv-meta-value">{{ $formData['nik'] ?? $formData['no_nik'] ?? '—' }}</span>
                    </div>
                    <div class="pv-meta-row">
                        <span class="pv-meta-label">Tanggal Surat</span>
                        <span class="pv-meta-value">
                            {{ \Carbon\Carbon::parse($formData['tgl_surat'] ?? $formData['tanggal_surat'] ?? date('Y-m-d'))->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div class="pv-meta-row">
                        <span class="pv-meta-label">Jenis Surat</span>
                        <span class="pv-meta-value">{{ $template->judul }}</span>
                    </div>
                </div>
            </div>

            <div class="pv-card">
                <div class="pv-card-head">
                    <span class="pv-card-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </span>
                    <h3>Checklist</h3>
                </div>
                <div class="pv-card-body">
                    <ul class="pv-checklist">
                        @foreach(['Data pemohon terisi lengkap', 'Nomor surat sudah digenerate', 'Format penomoran sesuai', 'Periksa isi konten surat'] as $item)
                        <li>
                            <span class="pv-check-ico">
                                <svg width="8" height="8" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="2 6 5 9 10 3"/>
                                </svg>
                            </span>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        {{-- Editor Area --}}
        <div class="pv-editor-area">
            <div class="pv-label-bar">
                <div class="pv-label-left">
                    <span class="pv-editor-tag">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Mode Editor
                    </span>
                    <span class="pv-hint">Klik teks untuk mengedit konten surat</span>
                </div>
                <span class="pv-page-badge">A4 · 21 × 29.7 cm</span>
            </div>

            <form action="{{ route('admin.layanan-surat.cetak.generateFinal') }}" method="POST" id="form-cetak">
                @csrf
                <input type="hidden" name="template_id" value="{{ $template->id }}">
                <input type="hidden" name="nomor_surat"   value="{{ $formData['nomor_surat'] ?? $formData['format_nomor'] ?? '-' }}">
                <input type="hidden" name="nama_pemohon"  value="{{ $formData['nama'] ?? $formData['nama_lengkap'] ?? '-' }}">
                <input type="hidden" name="nik_pemohon"   value="{{ $formData['nik'] ?? $formData['no_nik'] ?? '-' }}">
                <input type="hidden" name="jenis_surat"   value="{{ $template->judul }}">
                <input type="hidden" name="tanggal_surat" value="{{ $formData['tgl_surat'] ?? $formData['tanggal_surat'] ?? date('Y-m-d') }}">

                <div class="pv-editor-card">
                    <textarea id="pv-editor" name="final_content">{!! $htmlContent !!}</textarea>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Ribbon ────────────────────────────────────────────────── --}}
<div
    class="pv-ribbon"
    x-data="{}"
    x-bind:style="$store.sidebar !== undefined
        ? 'left:' + ($store.sidebar.open ? '288px' : '80px')
        : 'left:288px'"
>
    <div class="pv-ribbon-info">
        <div class="pv-ribbon-icon">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <div class="pv-ribbon-text">
            <p>{{ $template->judul }}</p>
            <span id="ribbon-status">Selesai edit? Tekan tombol untuk memproses.</span>
        </div>
    </div>

    <div class="pv-actions">
        {{-- Badge Informasi Jumlah Cetak --}}
        @php
            $jumlahCetak = $template->klasifikasi ? $template->klasifikasi->jumlah : 0;
        @endphp
        <div class="pv-print-info">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            @if($jumlahCetak == 0)
                Belum Pernah Dicetak
            @else
                Telah dicetak {{ $jumlahCetak }}x
            @endif
        </div>

        {{-- Tombol Cetak Langsung --}}
        <button type="button" id="btn-direct" onclick="handlePrintLangsung()" class="pv-btn-direct">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2-2v5a2 2 0 0 1-2-2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span class="btn-text">Cetak Langsung</span>
        </button>

        {{-- Tombol Simpan PDF --}}
        <button type="button" id="btn-pdf" onclick="handlePdfSubmit()" class="pv-btn-print">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            <span class="btn-text">Finalisasi &amp; PDF</span>
        </button>
    </div>
</div>

@push('scripts')
<script>
// URL Redirect Tujuan
const REDIRECT_URL = "{{ route('admin.layanan-surat.cetak.index') }}"; 

// Fungsi untuk menonaktifkan tombol & memberi feedback visual
function setProcessingState(isProcessing) {
    const btnDirect = document.getElementById('btn-direct');
    const btnPdf = document.getElementById('btn-pdf');
    const statusText = document.getElementById('ribbon-status');

    if (isProcessing) {
        btnDirect.disabled = true;
        btnPdf.disabled = true;
        statusText.innerText = "⏳ Sedang memproses & menyimpan ke arsip...";
        statusText.style.color = "var(--pv-blue)";
    } else {
        btnDirect.disabled = false;
        btnPdf.disabled = false;
        statusText.innerText = "Selesai edit? Tekan tombol untuk memproses.";
        statusText.style.color = "var(--pv-muted)";
    }
}

// 1. Fungsi Handle Print Langsung & Redirect
async function handlePrintLangsung() {
    if (tinymce.get('pv-editor')) {
        setProcessingState(true);
        
        // Simpan konten terbaru ke textarea tersembunyi
        tinymce.triggerSave();
        
        const form = document.getElementById('form-cetak');
        const formData = new FormData(form);
        
        try {
            // Submit ke background agar generateFinal di controller tereksekusi
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Gagal menyimpan');

            // Panggil dialog print bawaan browser
            tinymce.get('pv-editor').execCommand('mcePrint');
            
            // Jeda agar dialog print muncul, lalu kembali ke index
            setTimeout(() => {
                window.location.href = REDIRECT_URL;
            }, 3000); 

        } catch (error) {
            console.error("Gagal merekam arsip:", error);
            alert("Terjadi kesalahan saat menyimpan arsip. Pastikan koneksi stabil.");
            setProcessingState(false);
        }
    }
}

// 2. Fungsi Handle PDF Submit & Redirect
function handlePdfSubmit() {
    const form = document.getElementById('form-cetak');
    if (form) {
        setProcessingState(true);
        
        tinymce.triggerSave();

        form.submit();
        
        setTimeout(() => {
            window.location.href = REDIRECT_URL;
        }, 4000);
    }
}

// Konfigurasi Alpine & Sidebar
document.addEventListener('alpine:init', () => {
    if (!Alpine.store('sidebar')) {
        Alpine.store('sidebar', { open: true });
    }
});

(function () {
    const observer = new MutationObserver(() => {
        const aside = document.querySelector('aside.sidebar');
        if (aside && window.Alpine && Alpine.store('sidebar')) {
            Alpine.store('sidebar').open = !aside.classList.contains('collapsed');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const aside = document.querySelector('aside.sidebar');
        if (aside) {
            observer.observe(aside, { attributes: true, attributeFilter: ['class'] });
            setTimeout(() => {
                if (Alpine.store('sidebar')) {
                    Alpine.store('sidebar').open = !aside.classList.contains('collapsed');
                }
            }, 100);
        }
    });
})();

// Inisialisasi TinyMCE dengan plugin tambahan untuk Base64 Image
tinymce.init({
    selector: '#pv-editor',
    license_key: 'gpl',
    height: 880,
    branding: false,
    promotion: false,
    elementpath: false,
    resize: false,
    
    // 🔥 PERUBAHAN: Tambahkan plugin 'image'
    plugins: 'table lists advlist autoresize print image',
    
    // 🔥 PERUBAHAN: Tambahkan tool image di toolbar
    toolbar: 'undo redo | fontfamily fontsize | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | table image | print',
    font_family_formats: 'Times New Roman=times new roman,times,serif; Arial=arial,helvetica,sans-serif;',
    font_size_formats: '9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt',
    menubar: false,
    statusbar: false,

    // 🔥 PERUBAHAN PENTING: Izinkan tag img dan base64 agar gambar logo tidak di-hapus otomatis
    paste_data_images: true,
    extended_valid_elements: 'img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style]',
    
    content_style: `
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.7;
            padding: 1.8cm 2.2cm !important;
            max-width: 21cm;
            margin: 0 auto;
            background: #ffffff;
            min-height: 29.7cm;
            box-sizing: border-box;
            color: #1a1a1a;
        }
        p { margin: 0 0 4px 0; }
        table { border-collapse: collapse; width: 100%; }
        td, th { padding: 4px 8px; }
        @media print {
            body { padding: 0 !important; margin: 0 !important; }
        }
    `,
    setup: function(editor) {
        editor.on('init', function() {
            editor.getContainer().style.transition = 'border-color 0.15s ease';
        });
    }
});
</script>
@endpush

@endsection