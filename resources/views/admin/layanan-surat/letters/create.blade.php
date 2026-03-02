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
        --danger: #f43f5e;
        --danger-soft: #fff1f3;
        --warning-soft: #fffbeb;
        --warning: #f59e0b;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
        --radius: 14px;
        --radius-sm: 8px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Sora', sans-serif;
        background: var(--bg-base);
        color: var(--text-primary);
    }

    /* ===== Page ===== */
    .letter-page {
        max-width: 780px;
        margin: 0 auto;
        padding: 36px 24px 80px;
        animation: pageIn 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes pageIn {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== Page Header ===== */
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
        width: 18px; height: 2px;
        background: var(--accent);
        border-radius: 2px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .page-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }

    /* ===== Alert Info ===== */
    .alert-info {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        background: var(--accent-soft);
        border: 1px solid #d4d9ff;
        border-radius: var(--radius-sm);
        padding: 13px 16px;
        font-size: 13px;
        color: #3a56d4;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .alert-info .alert-icon {
        flex-shrink: 0;
        width: 32px; height: 32px;
        background: rgba(79,110,247,0.12);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }

    .alert-info strong { font-weight: 600; }

    .alert-info code {
        background: rgba(79,110,247,0.12);
        padding: 1px 6px;
        border-radius: 5px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
    }

    /* ===== Search Bar ===== */
    .search-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        padding: 16px 18px;
        margin-bottom: 16px;
        position: relative;
    }

    .search-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .search-label svg { color: var(--accent); }

    .search-row {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input-wrap {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface-2);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 0 14px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .search-input-wrap:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,110,247,0.1);
        background: #fff;
    }

    .search-input-wrap svg { color: var(--text-muted); flex-shrink: 0; }

    .search-input-wrap input {
        flex: 1;
        border: none;
        background: transparent;
        font-family: 'Sora', sans-serif;
        font-size: 14px;
        color: var(--text-primary);
        outline: none;
        padding: 11px 0;
    }

    .search-input-wrap input::placeholder { color: var(--text-muted); }

    #search_status {
        font-size: 12.5px;
        font-weight: 600;
        white-space: nowrap;
        padding: 6px 0;
    }

    #btn_search {
        padding: 10px 18px;
        border-radius: var(--radius-sm);
        background: var(--accent);
        color: #fff;
        border: none;
        font-family: 'Sora', sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s, transform 0.15s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    #btn_search:hover { background: var(--accent-dark); transform: translateY(-1px); }
    #btn_search:active { transform: translateY(0); }

    /* Dropdown Saran */
    #kotak_saran {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 18px; right: 18px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        z-index: 999;
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .saran-item {
        padding: 11px 16px;
        cursor: pointer;
        font-size: 13.5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-light);
        transition: background 0.1s;
    }

    .saran-item:last-child { border-bottom: none; }
    .saran-item:hover { background: var(--accent-soft); }
    .saran-item .name { font-weight: 600; color: var(--text-primary); }
    .saran-item .nik  { font-size: 12px; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; }
    .saran-error { padding: 12px 16px; color: var(--danger); font-size: 13px; }

    /* ===== Sections ===== */
    .form-section {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        margin-bottom: 14px;
        overflow: hidden;
        animation: cardIn 0.4s ease both;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-section:nth-child(1) { animation-delay: 0.05s; }
    .form-section:nth-child(2) { animation-delay: 0.1s; }
    .form-section:nth-child(3) { animation-delay: 0.15s; }
    .form-section:nth-child(4) { animation-delay: 0.2s; }

    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--border-light);
        background: var(--surface-2);
    }

    .section-icon {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .icon-blue   { background: var(--accent-soft); color: var(--accent); }
    .icon-green  { background: var(--success-soft); color: var(--success); }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-purple { background: #ede9fe; color: #7c3aed; }

    .section-title-text {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .section-body {
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 18px;
    }

    .field-full { grid-column: 1 / -1; }

    /* ===== Field ===== */
    .field label {
        display: block;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--text-muted);
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }

    .field label .var-hint {
        font-family: 'JetBrains Mono', monospace;
        font-size: 10.5px;
        background: var(--accent-soft);
        color: var(--accent);
        padding: 1px 5px;
        border-radius: 4px;
        margin-left: 4px;
        font-weight: 500;
    }

    .field input,
    .field select {
        width: 100%;
        padding: 10px 13px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'Sora', sans-serif;
        font-size: 13.5px;
        color: var(--text-primary);
        background: var(--surface);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        -webkit-appearance: none;
    }

    .field input:focus,
    .field select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(79,110,247,0.1);
    }

    .field input[readonly] {
        background: var(--surface-2);
        color: var(--text-muted);
        cursor: not-allowed;
        border-color: var(--border-light);
    }

    .field select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23a0a8c0' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 13px center;
        padding-right: 36px;
        cursor: pointer;
    }

    .field input[type="date"] {
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
    }

    /* Divider in section */
    .field-divider {
        grid-column: 1 / -1;
        border: none;
        border-top: 1px dashed var(--border);
        margin: 4px 0;
    }

    /* ===== Actions Footer ===== */
    .form-actions {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        padding: 16px 20px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 22px;
        border-radius: var(--radius-sm);
        font-family: 'Sora', sans-serif;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }

    .btn:active { transform: translateY(0); filter: brightness(0.95); box-shadow: none; }

    .btn-save {
        background: var(--surface);
        color: var(--text-secondary);
        border: 1.5px solid var(--border);
    }
    .btn-save:hover { color: var(--text-primary); background: var(--surface-2); }

    .btn-generate {
        background: linear-gradient(135deg, var(--accent) 0%, #6366f1 100%);
        color: #fff;
        box-shadow: 0 2px 10px rgba(79,110,247,0.3);
    }

    /* ===== Responsive ===== */
    @media (max-width: 560px) {
        .section-body { grid-template-columns: 1fr; }
        .field-full { grid-column: 1; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
        .search-row { flex-wrap: wrap; }
        #btn_search { width: 100%; justify-content: center; }
    }
</style>

<div class="letter-page">

    {{-- Header --}}
    <div class="page-eyebrow">Surat Desa</div>
    <h1 class="page-title">Buat Surat Otomatis</h1>
    <p class="page-subtitle">Generate surat dari berbagai template Microsoft Word dengan data warga secara otomatis.</p>

    {{-- Alert Info --}}
    <div class="alert-info">
        <div class="alert-icon">💡</div>
        <div>
            <strong>Cara penggunaan template:</strong> Variabel di dalam file Word menggunakan tanda kurung siku.<br>
            Contoh: <code>[nama]</code>, <code>[nik]</code>, <code>[nama_desa]</code>, <code>[form_keterangan]</code>
        </div>
    </div>

    {{-- Search Warga --}}
    <div class="search-card">
        <div class="search-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Cari Data Warga
        </div>
        <div class="search-row">
            <div class="search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search_nik" placeholder="Ketik NIK atau nama warga..." autocomplete="off">
            </div>
            <span id="search_status"></span>
            <button type="button" id="btn_search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                </svg>
                Isi Otomatis
            </button>
        </div>
        <div id="kotak_saran"></div>
    </div>

    {{-- Form --}}
    <form method="POST" id="letterForm">
        @csrf

        {{-- 1. Template Surat --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon icon-purple">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <span class="section-title-text">Pilih Format Surat</span>
            </div>
            <div class="section-body">
                <div class="field field-full">
                    <label>File Template <span class="var-hint">.docx</span></label>
                    <select name="template_file" required>
                        <option value="">— Pilih template surat —</option>
                        @if(isset($templates) && count($templates) > 0)
                            @foreach($templates as $template)
                                <option value="{{ $template }}">{{ $template }}</option>
                            @endforeach
                        @else
                            <option disabled>Tidak ada file di storage/app/public/templates</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>

        {{-- 2. Data Desa --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon icon-green">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span class="section-title-text">Data Desa</span>
            </div>
            <div class="section-body">
                <div class="field">
                    <label>Nama Desa</label>
                    <input type="text" name="nama_desa">
                </div>
                <div class="field">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan">
                </div>
                <div class="field">
                    <label>Kabupaten</label>
                    <input type="text" name="nama_kabupaten">
                </div>
                <div class="field">
                    <label>Kode Provinsi</label>
                    <input type="text" name="kode_provinsi">
                </div>
                <div class="field field-full">
                    <label>Kantor Desa</label>
                    <input type="text" name="kantor_desa">
                </div>
                <div class="field field-full">
                    <label>Alamat Kantor</label>
                    <input type="text" name="alamat_kantor">
                </div>
                <input type="hidden" name="kode_kabupaten">
            </div>
        </div>

        {{-- 3. Data Warga --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon icon-blue">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="section-title-text">Data Warga</span>
            </div>
            <div class="section-body">
                <div class="field">
                    <label>NIK <span class="var-hint">[nik]</span></label>
                    <input type="text" name="nik" required readonly>
                </div>
                <div class="field">
                    <label>No. KK <span class="var-hint">[no_kk]</span></label>
                    <input type="text" name="no_kk">
                </div>
                <div class="field field-full">
                    <label>Nama Lengkap <span class="var-hint">[nama]</span></label>
                    <input type="text" name="nama" required>
                </div>
                <div class="field">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir">
                </div>
                <div class="field">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir">
                </div>
                <div class="field">
                    <label>Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin">
                </div>
                <div class="field">
                    <label>Agama</label>
                    <input type="text" name="agama">
                </div>
                <div class="field">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan">
                </div>
                <div class="field">
                    <label>Status Perkawinan</label>
                    <input type="text" name="status">
                </div>
                <div class="field field-full">
                    <label>Alamat Lengkap</label>
                    <input type="text" name="Alamat">
                </div>
                <input type="hidden" name="kepala_kk">
                <input type="hidden" name="kabupaten">
                <input type="hidden" name="Pendidikan">
                <input type="hidden" name="warga_negara" value="WNI">
            </div>
        </div>

        {{-- 4. Keterangan & TTD --}}
        <div class="form-section">
            <div class="section-header">
                <div class="section-icon icon-orange">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <span class="section-title-text">Keterangan &amp; Tanda Tangan</span>
            </div>
            <div class="section-body">
                <div class="field">
                    <label>Nomor Surat <span class="var-hint">[format_nomor]</span></label>
                    <input type="text" name="format_nomor" value="470/..../2024">
                </div>
                <div class="field">
                    <label>Keperluan <span class="var-hint">[form_keterangan]</span></label>
                    <input type="text" name="form_keterangan" placeholder="Contoh: Mengurus KTP">
                </div>
                <div class="field">
                    <label>Berlaku Mulai <span class="var-hint">[mulai_berlaku]</span></label>
                    <input type="date" name="mulai_berlaku">
                </div>
                <div class="field">
                    <label>Berlaku Sampai <span class="var-hint">[tgl_akhir]</span></label>
                    <input type="date" name="tgl_akhir">
                </div>

                <hr class="field-divider">

                <div class="field">
                    <label>Tanggal Surat <span class="var-hint">[tgl_surat]</span></label>
                    <input type="date" name="tgl_surat" value="{{ date('Y-m-d') }}">
                </div>
                <div class="field">
                    <label>Jabatan TTD <span class="var-hint">[penandatangan]</span></label>
                    <input type="text" name="penandatangan" value="Kepala Desa">
                </div>
                <div class="field">
                    <label>Nama TTD <span class="var-hint">[kepala_desa]</span></label>
                    <input type="text" name="kepala_desa">
                </div>
                <div class="field">
                    <label>NIP TTD <span class="var-hint">[nip_kepala_desa]</span></label>
                    <input type="text" name="nip_kepala_desa">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        {{-- Actions --}}
        <div class="form-actions">
            <button type="submit" formaction="{{ route('admin.layanan-surat.cetak.store') }}" class="btn btn-save">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan ke Database
            </button>
            <button type="submit" formaction="{{ route('admin.layanan-surat.cetak.template') }}" class="btn btn-generate">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Generate ke Word
            </button>
        </div>

    </form>
</div>

<script>
    const searchInput = document.getElementById('search_nik');
    const kotakSaran  = document.getElementById('kotak_saran');
    const statusText  = document.getElementById('search_status');
    let searchTimeout;

    searchInput.addEventListener('input', function () {
        const kw = this.value.trim();
        
        if (kw.length < 1) { 
            kotakSaran.style.display = 'none'; 
            return; 
        }

        if (kw.length === 16 && !isNaN(kw)) {
            kotakSaran.style.display = 'none';
            loadData(kw);
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            // Menggunakan route name dengan awalan admin.
            let searchUrl = "{{ route('admin.layanan-surat.cetak.liveSearchNik') }}?keyword=" + encodeURIComponent(kw);

            fetch(searchUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => {
                if (!r.ok) throw new Error('Response error');
                return r.json();
            })
            .then(data => {
                kotakSaran.innerHTML = '';
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const d = document.createElement('div');
                        d.className = 'saran-item';
                        d.innerHTML = `<span class="name">${item.nama}</span><span class="nik">${item.nik}</span>`;
                        
                        d.addEventListener('click', () => {
                            searchInput.value = item.nik;
                            kotakSaran.style.display = 'none';
                            loadData(item.nik);
                        });
                        kotakSaran.appendChild(d);
                    });
                } else {
                    kotakSaran.innerHTML = '<div class="saran-error">Data tidak ditemukan</div>';
                }
                kotakSaran.style.display = 'block';
            })
            .catch(err => console.error("Error fetching suggestions:", err));
        }, 300);
    });

    document.addEventListener('click', e => {
        if (!searchInput.contains(e.target) && !kotakSaran.contains(e.target)) {
            kotakSaran.style.display = 'none';
        }
    });

    document.getElementById('btn_search').addEventListener('click', () => {
        if (!searchInput.value.trim()) { 
            alert('Masukkan NIK terlebih dahulu!'); 
            return; 
        }
        loadData(searchInput.value.trim());
    });

    function loadData(nik) {
        statusText.textContent = '⏳ Memuat...';
        statusText.style.color = '#a0a8c0';
        
        // Menggunakan route name dengan awalan admin.
        let dataUrl = "{{ route('admin.layanan-surat.cetak.getDataByNik', ':nik') }}";
        dataUrl = dataUrl.replace(':nik', encodeURIComponent(nik));

        fetch(dataUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => {
            if (!r.ok) throw new Error('Response error');
            return r.json();
        })
        .then(data => {
            if (data.success) {
                statusText.textContent = '✅ Data terisi';
                statusText.style.color = '#10b981';
                
                if (data.desa) {
                    s('kode_kabupaten',  data.desa.kode_kabupaten);
                    s('nama_kabupaten',  data.desa.kabupaten);
                    s('kecamatan',       data.desa.kecamatan);
                    s('kantor_desa',     data.desa.kantor_desa || 'Kantor Desa');
                    s('nama_desa',       data.desa.nama_desa);
                    s('alamat_kantor',   data.desa.alamat_kantor);
                    s('kode_provinsi',   data.desa.kode_provinsi);
                    s('kepala_desa',     data.desa.kepala_desa);
                    s('nip_kepala_desa', data.desa.nip_kepala_desa);
                    s('kabupaten',       data.desa.kabupaten);
                }
                
                if (data.penduduk) {
                    s('nama',          data.penduduk.nama);
                    s('nik',           data.penduduk.nik);
                    s('no_kk',         data.penduduk.no_kk);
                    s('kepala_kk',     data.penduduk.kepala_kk);
                    s('tempat_lahir',  data.penduduk.tempat_lahir);
                    
                    if (data.penduduk.tanggal_lahir) {
                        s('tanggal_lahir', new Date(data.penduduk.tanggal_lahir).toISOString().split('T')[0]);
                    }
                    
                    s('jenis_kelamin', data.penduduk.jenis_kelamin);
                    s('Alamat',        data.penduduk.alamat);
                    s('agama',         data.penduduk.agama);
                    s('status',        data.penduduk.status_kawin);
                    s('Pendidikan',    data.penduduk.pendidikan);
                    s('pekerjaan',     data.penduduk.pekerjaan);
                    s('warga_negara',  data.penduduk.kewarganegaraan || 'WNI');
                }
            } else {
                statusText.textContent = '❌ Tidak ditemukan';
                statusText.style.color = '#f43f5e';
                s('nama',''); s('nik',''); 
            }
        })
        .catch(err => {
            console.error("Error fetching detail:", err);
            statusText.textContent = '❌ Gagal terhubung';
            statusText.style.color = '#f43f5e';
        });
    }

    function s(name, val) {
        const el = document.querySelector('[name="' + name + '"]');
        if (el) el.value = val || '';
    }
</script>

@endsection