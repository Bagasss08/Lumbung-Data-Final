@extends('layouts.admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root {
    --bg-page: #f9fbff;
    --surface-primary: #ffffff;
    --surface-secondary: #f3f6fc;
    --border-primary: #e2e8f0;
    --border-secondary: #cbd5e1;
    --brand-main: #3b82f6;
    --brand-hover: #2563eb;
    --brand-light: #eff6ff;
    --text-heading: #1e293b;
    --text-body: #334155;
    --text-muted: #64748b;
    --status-success: #10b981;
    --status-warning: #f59e0b;
    --status-error: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --radius-md: 10px;
    --radius-sm: 6px;
}
body { font-family: 'Sora', sans-serif; background-color: var(--bg-page); color: var(--text-body); font-size: 14px; }
.pg-container { max-width: 900px; margin: 0 auto; padding: 2rem; }

.page-header { margin-bottom: 2rem; animation: fadeInDown 0.5s ease-out; }
@keyframes fadeInDown { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }
.eyebrow {
    color: var(--brand-main); font-size: 0.75rem; text-transform: uppercase;
    letter-spacing: 0.1em; font-weight: 600; margin-bottom: 0.5rem;
    display: inline-flex; align-items: center; gap: 0.5rem;
}
.eyebrow::before { content:''; width:1rem; height:2px; background:var(--brand-main); }
.page-title { font-size: 1.75rem; color: var(--text-heading); margin: 0 0 0.5rem 0; font-weight: 600; }

.alert { padding: 0.85rem 1.25rem; border-radius: var(--radius-sm); margin-bottom: 1.25rem; font-size: 0.875rem; }
.alert-success { background:#ecfdf5; border:1px solid #6ee7b7; color:#065f46; }
.alert-error   { background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; }

/* Nomor Surat Card */
.nomor-card {
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    border: 2px solid var(--brand-main);
    border-radius: var(--radius-md);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm);
}
.nomor-card-title {
    font-size: 0.8rem; font-weight: 700; color: var(--brand-main);
    text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.6rem;
    display: flex; align-items: center; gap: 0.4rem;
}
.nomor-input {
    width: 100%; padding: 0.7rem 1rem; border: 2px solid var(--brand-main);
    border-radius: var(--radius-sm); font-size: 1rem; font-weight: 600;
    font-family: 'JetBrains Mono', monospace; box-sizing: border-box;
    background: white; color: var(--text-heading); transition: box-shadow 0.2s;
}
.nomor-input:focus { outline: none; box-shadow: 0 0 0 4px var(--brand-light); }
.nomor-input.is-invalid { border-color: var(--status-error); background: #fff5f5; }
.nomor-error { font-size: 0.78rem; color: var(--status-error); margin-top: 0.35rem; font-weight: 500; }
.nomor-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 0.4rem; margin-bottom: 0; }

/* Search Card */
.search-card {
    background: var(--surface-primary); border: 1px solid var(--border-primary);
    border-radius: var(--radius-md); padding: 1.25rem; margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm); position: relative;
}
.search-controls { display: flex; gap: 1rem; align-items: stretch; }
.search-input-wrapper {
    flex-grow: 1; display: flex; align-items: center;
    background-color: var(--surface-secondary); border: 1px solid var(--border-primary);
    border-radius: var(--radius-sm); padding: 0 1rem; transition: border-color 0.2s;
}
.search-input-wrapper:focus-within { border-color: var(--brand-main); box-shadow: 0 0 0 3px var(--brand-light); }
.search-icon { color: var(--text-muted); margin-right: 0.5rem; flex-shrink: 0; }
.search-input {
    flex-grow: 1; border: none; background: transparent;
    padding: 0.75rem 0; font-size: 0.95rem; outline: none; font-family: 'Sora', sans-serif;
}
.btn-search {
    background-color: var(--brand-main); color: white; border: none;
    padding: 0 1.25rem; border-radius: var(--radius-sm); font-weight: 600;
    cursor: pointer; font-family: 'Sora', sans-serif; font-size: 0.875rem;
    transition: background-color 0.2s; white-space: nowrap;
}
.btn-search:hover { background-color: var(--brand-hover); }
.suggestions-box {
    display: none; position: absolute; top: calc(100% - 0.25rem);
    left: 1.25rem; right: 1.25rem; background: white;
    border: 1px solid var(--border-primary); border-top: none;
    border-radius: 0 0 var(--radius-md) var(--radius-md);
    box-shadow: var(--shadow-md); z-index: 100; max-height: 220px; overflow-y: auto;
}
.suggestion-item {
    padding: 0.75rem 1rem; cursor: pointer; display: flex;
    justify-content: space-between; align-items: center;
    border-bottom: 1px solid var(--border-primary); transition: background 0.15s;
}
.suggestion-item:last-child { border-bottom: none; }
.suggestion-item:hover { background-color: var(--brand-light); }
.sug-name { font-weight: 500; color: var(--text-heading); }
.sug-nik  { font-size: 0.8rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; }

.status-pill {
    display: inline-flex; align-items: center; gap: 0.35rem;
    font-size: 0.75rem; padding: 0.3rem 0.65rem; border-radius: 99px;
    margin-top: 0.5rem; font-weight: 500; transition: all 0.2s;
}
.status-idle    { background:#f1f5f9; color:var(--text-muted); }
.status-loading { background:#eff6ff; color:var(--brand-main); }
.status-ok      { background:#ecfdf5; color:var(--status-success); }
.status-err     { background:#fef2f2; color:var(--status-error); }

.form-section {
    background: var(--surface-primary); border: 1px solid var(--border-primary);
    border-radius: var(--radius-md); margin-bottom: 1.5rem; overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.section-header {
    background-color: var(--surface-secondary); padding: 0.75rem 1.25rem;
    border-bottom: 1px solid var(--border-primary);
    display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;
}
.section-title { font-weight: 600; font-size: 0.9rem; color: var(--text-heading); margin: 0; }
.autofill-badge {
    font-size: 0.7rem; background: var(--brand-light); color: var(--brand-main);
    padding: 0.2rem 0.5rem; border-radius: 99px; font-weight: 600;
}
.section-body {
    padding: 1.25rem; display: grid;
    grid-template-columns: repeat(2, 1fr); gap: 1rem;
}
.full-width { grid-column: span 2; }
.field-group label {
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.8rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-muted);
}
.form-input {
    width: 100%; padding: 0.6rem 0.8rem; border: 1px solid var(--border-secondary);
    border-radius: var(--radius-sm); font-size: 0.9rem; box-sizing: border-box;
    font-family: 'Sora', sans-serif; transition: border-color 0.2s, box-shadow 0.2s;
    background: var(--surface-primary); color: var(--text-body);
}
.form-input:focus { border-color: var(--brand-main); outline: none; box-shadow: 0 0 0 3px var(--brand-light); }
.form-input.autofilled { background-color: #f0fdf4; border-color: #6ee7b7; }
.var-badge {
    font-family: 'JetBrains Mono', monospace; font-size: 0.65rem;
    background: #f1f5f9; padding: 2px 5px; border-radius: 4px; color: #64748b;
}

.btn { padding: 0.75rem 1.5rem; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; border: none; transition: all 0.2s; font-family: 'Sora', sans-serif; font-size: 0.9rem; }
.btn-primary { background: var(--brand-main); color: white; display:flex; align-items:center; justify-content:center; gap:0.5rem; }
.btn-primary:hover { background: var(--brand-hover); transform:translateY(-1px); box-shadow:0 4px 12px rgba(59,130,246,0.3); }
.btn-outline { background: white; border: 1px solid var(--border-secondary); color: var(--text-body); text-align:center; text-decoration:none; display:flex; align-items:center; justify-content:center; }
.btn-outline:hover { background: var(--surface-secondary); }
.form-footer { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; }
.footer-secondary { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }

@media (max-width: 640px) {
    .section-body { grid-template-columns: 1fr; }
    .full-width { grid-column: span 1; }
    .footer-secondary { grid-template-columns: 1fr; }
    .search-controls { flex-direction: column; }
}
</style>

<div class="pg-container">
    @php
        $templateJudul = $selectedTemplate->judul ?? 'Template Tidak Diketahui';

        $rawVars = [];
        if (isset($selectedTemplate) && $selectedTemplate->konten_template) {
            preg_match_all('/\[([a-zA-Z0-9_]+)\]/i', $selectedTemplate->konten_template, $matches);
            $seen = [];
            foreach ($matches[1] ?? [] as $v) {
                $lower = strtolower($v);
                
                // Abaikan [logo_desa] agar tidak muncul sebagai inputan manual di form
                if (!isset($seen[$lower]) && $lower !== 'logo_desa') {
                    $seen[$lower] = true;
                    $rawVars[] = $v;
                }
            }
        }

        $nomorKeys = ['nomor_surat','no_surat','format_nomor','nomor','no_urut'];

        $wargaKeys = [
            'nik','no_nik','nama','nama_lengkap','tempat_lahir','tanggal_lahir','tgl_lahir',
            'jenis_kelamin','kelamin','jk','agama','pekerjaan','status_kawin',
            'status_perkawinan','alamat','rt','rw','warga_negara','pendidikan',
        ];

        $keluargaKeys = [
            'no_kk','nomor_kk','kepala_kk','kepala_keluarga',
            'nik_kepala','alamat_kk','alamat_keluarga',
        ];

        $suratKeys = ['tgl_surat','tanggal_surat','penandatangan','jabatan','perihal','judul_surat'];

        $desaKeys = [
            'nama_desa','desa','kecamatan','kabupaten','provinsi',
            'alamat_kantor','kode_pos','nama_kades','nip_kades','kepala_desa','nip_kepala_desa',
        ];

        $wargaFields    = [];
        $keluargaFields = [];
        $suratFields    = [];
        $desaFields     = [];
        $otherFields    = [];

        foreach ($rawVars as $var) {
            $key = strtolower($var);
            if (in_array($key, $nomorKeys))         { /* skip — ditangani di nomor card */ }
            elseif (in_array($key, $desaKeys))      $desaFields[]     = $var;
            elseif (in_array($key, $wargaKeys))     $wargaFields[]    = $var;
            elseif (in_array($key, $keluargaKeys))  $keluargaFields[] = $var;
            elseif (in_array($key, $suratKeys))     $suratFields[]    = $var;
            else                                    $otherFields[]    = $var;
        }

        function getFieldType(string $v): string {
            $n = strtolower($v);
            return (str_contains($n,'tanggal') || str_contains($n,'tgl')) ? 'date' : 'text';
        }

        $getDefault = function (string $v) use ($templateJudul): string {
            $n = strtolower($v);
            if (in_array($n, ['tgl_surat','tanggal_surat']))  return date('Y-m-d');
            if (in_array($n, ['penandatangan','jabatan']))    return 'Kepala Desa';
            if (in_array($n, ['judul_surat','perihal']))      return strtoupper($templateJudul);
            return '';
        };

        $lbl = fn(string $v) => ucwords(str_replace('_', ' ', $v));
    @endphp

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div class="eyebrow">Layanan Surat Digital</div>
        <h1 class="page-title">{{ $templateJudul }}</h1>
        <p style="color:var(--text-muted); margin:0;">
            Cari NIK atau nama warga — data pribadi, keluarga, dan desa akan otomatis terisi.
        </p>
    </div>

    {{-- Flash / Validation Messages --}}
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <strong>Terdapat kesalahan:</strong>
            <ul style="margin:0.4rem 0 0 1rem; padding:0;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===== SEARCH WARGA (di luar form, hanya UI helper) ===== --}}
    <div class="search-card">
        <div class="search-controls">
            <div class="search-input-wrapper">
                <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Ketik NIK atau Nama Warga..."
                    autocomplete="off"
                >
            </div>
            <button type="button" id="btnSearch" class="btn-search">🔍 Cari Data</button>
        </div>
        <div id="searchStatus" class="status-pill status-idle">● Siap mencari</div>
        <div id="suggestionsBox" class="suggestions-box"></div>
    </div>

    {{-- ╔══════════════════════════════════════════════════════╗
         ║  FORM MULAI DI SINI — semua field harus di dalam     ║
         ╚══════════════════════════════════════════════════════╝ --}}
    <form id="mainLetterForm" method="POST">
        @csrf
        <input type="hidden" name="template_id" value="{{ $selectedTemplate->id ?? '' }}">

        {{-- Hidden: untuk generateFinal --}}
        <input type="hidden" id="hidden_nama_pemohon" name="nama_pemohon" value="">
        <input type="hidden" id="hidden_nik_pemohon"  name="nik_pemohon"  value="">

        {{-- Hidden alias nomor: agar tag [nomor_surat], [no_surat] dll di template ikut terganti --}}
        <input type="hidden" id="alias_nomor_surat" name="nomor_surat" value="">
        <input type="hidden" id="alias_no_surat"    name="no_surat"    value="">
        <input type="hidden" id="alias_nomor"       name="nomor"       value="">
        <input type="hidden" id="alias_no_urut"     name="no_urut"     value="">

        {{-- Hidden: Data Desa --}}
        @foreach($desaFields as $dv)
            <input type="hidden" id="field_{{ strtolower($dv) }}" name="{{ $dv }}" value="{{ old($dv, '') }}">
        @endforeach

        {{-- ===== NOMOR SURAT — DI DALAM FORM ===== --}}
        <div class="nomor-card">
            <div class="nomor-card-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Nomor Surat
            </div>

            {{-- --- Menampilkan Preview Format Nomor yang Ditangkap dari Controller --- --}}
            <input
                type="text"
                id="input_format_nomor"
                name="format_nomor"
                class="nomor-input{{ $errors->has('format_nomor') ? ' is-invalid' : '' }}"
                placeholder="Contoh: S-41/001/9202172009/III/2026"
                value="{{ old('format_nomor', $autoNomorSurat ?? '') }}" 
                autocomplete="off"
            >

            @error('format_nomor')
                <p class="nomor-error">⚠️ {{ $message }}</p>
            @enderror

            <p class="nomor-hint">
                💡 Nomor surat di atas dibuat secara otomatis (auto-generate). Anda tetap dapat mengubahnya secara manual jika diperlukan.
            </p>
        </div>

        {{-- SECTION: Detail Surat --}}
        @if(count($suratFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">📄 Detail Surat</h3>
            </div>
            <div class="section-body">
                @foreach($suratFields as $var)
                    @php $isFull = in_array(strtolower($var), ['judul_surat','perihal']); @endphp
                    <div class="field-group {{ $isFull ? 'full-width' : '' }}">
                        <label>{{ $lbl($var) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input
                            type="{{ getFieldType($var) }}"
                            id="field_{{ strtolower($var) }}"
                            name="{{ $var }}"
                            class="form-input"
                            value="{{ old($var, $getDefault($var)) }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SECTION: Identitas Pemohon --}}
        @if(count($wargaFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">👤 Identitas Pemohon</h3>
                <span class="autofill-badge">Auto-fill NIK</span>
            </div>
            <div class="section-body">
                @foreach($wargaFields as $var)
                    @php $isFull = in_array(strtolower($var), ['nama','nama_lengkap','alamat']); @endphp
                    <div class="field-group {{ $isFull ? 'full-width' : '' }}">
                        <label>{{ $lbl($var) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input
                            type="{{ getFieldType($var) }}"
                            id="field_{{ strtolower($var) }}"
                            name="{{ $var }}"
                            class="form-input"
                            value="{{ old($var, '') }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SECTION: Data Keluarga --}}
        @if(count($keluargaFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">👨‍👩‍👧‍👦 Data Keluarga</h3>
                <span class="autofill-badge">Auto-fill KK</span>
            </div>
            <div class="section-body">
                @foreach($keluargaFields as $var)
                    @php $isFull = in_array(strtolower($var), ['alamat_kk','alamat_keluarga','kepala_kk','kepala_keluarga']); @endphp
                    <div class="field-group {{ $isFull ? 'full-width' : '' }}">
                        <label>{{ $lbl($var) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input
                            type="text"
                            id="field_{{ strtolower($var) }}"
                            name="{{ $var }}"
                            class="form-input"
                            value="{{ old($var, '') }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- SECTION: Keterangan Tambahan --}}
        @if(count($otherFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">📝 Keterangan Tambahan</h3>
            </div>
            <div class="section-body">
                @foreach($otherFields as $var)
                    <div class="field-group full-width">
                        <label>{{ $lbl($var) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input
                            type="text"
                            id="field_{{ strtolower($var) }}"
                            name="{{ $var }}"
                            class="form-input"
                            value="{{ old($var, '') }}"
                        >
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(count($rawVars) === 0)
        <div class="form-section">
            <div class="section-body" style="grid-template-columns:1fr;">
                <p style="color:var(--text-muted); font-size:0.875rem; margin:0; grid-column:span 2;">
                    ℹ️ Template ini tidak memiliki variabel <code>[tag]</code>. Isi nomor surat lalu lanjutkan ke preview.
                </p>
            </div>
        </div>
        @endif

        {{-- AKSI --}}
        <div class="form-footer">
            <button
                type="submit"
                formaction="{{ route('admin.layanan-surat.cetak.preview') }}"
                class="btn btn-primary"
                style="font-size:1rem; padding:1rem;"
            >
                🚀 Lanjutkan ke Preview &amp; Edit
            </button>
            <div class="footer-secondary">
                <button
                    type="submit"
                    formaction="{{ route('admin.layanan-surat.cetak.store') }}"
                    class="btn btn-outline"
                >
                    💾 Simpan Draft
                </button>
                <a
                    href="{{ route('admin.layanan-surat.cetak.index') }}"
                    class="btn btn-outline"
                    style="text-decoration:none;"
                >
                    ✕ Batal
                </a>
            </div>
        </div>

    </form>
    {{-- ╔══════════════════════════╗
         ║  FORM SELESAI DI SINI   ║
         ╚══════════════════════════╝ --}}

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var inputField  = document.getElementById('searchInput');
    var suggestBox  = document.getElementById('suggestionsBox');
    var statusEl    = document.getElementById('searchStatus');
    var btnSearch   = document.getElementById('btnSearch');
    var nomorInput  = document.getElementById('input_format_nomor');

    /* ── Status ── */
    function setStatus(msg, type) {
        type = type || 'idle';
        var map = { idle:'status-idle', loading:'status-loading', ok:'status-ok', err:'status-err' };
        statusEl.className = 'status-pill ' + (map[type] || 'status-idle');
        statusEl.textContent = msg;
    }

    /* ── Sync nilai format_nomor ke semua hidden alias ──
       Tujuan: tag [nomor_surat], [no_surat], [nomor], [no_urut]
       di konten_template juga terganti oleh str_ireplace controller */
    function syncNomorAliases() {
        var val = nomorInput ? nomorInput.value : '';
        var ids = ['alias_nomor_surat','alias_no_surat','alias_nomor','alias_no_urut'];
        ids.forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = val;
        });
    }

    if (nomorInput) {
        nomorInput.addEventListener('input', syncNomorAliases);
        // Jalankan sekali saat pertama kali di-load supaya sinkron ke semua alias
        syncNomorAliases();
    }

    var mainForm = document.getElementById('mainLetterForm');
    if (mainForm) {
        mainForm.addEventListener('submit', syncNomorAliases);
    }

    /* ── setInputValue ── */
    function setInputValue(name, val) {
        if (val === null || val === undefined || String(val).trim() === '') return;
        var candidates = [
            document.querySelector('[name="' + name + '"]:not([type="hidden"])'),
            document.querySelector('[name="' + name.toLowerCase() + '"]:not([type="hidden"])'),
            document.getElementById('field_' + name.toLowerCase()),
        ];
        for (var i = 0; i < candidates.length; i++) {
            if (candidates[i]) {
                candidates[i].value = val;
                candidates[i].classList.add('autofilled');
                break;
            }
        }
    }

    /* Khusus set hidden field desa */
    function setHiddenValue(id, val) {
        var el = document.getElementById(id);
        if (el && val) el.value = val;
    }

    /* ── Live search ── */
    var debounceTimer;
    inputField.addEventListener('input', function () {
        var query = this.value.trim();
        suggestBox.style.display = 'none';
        if (query.length < 2) return;

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            var url = '{{ route("admin.layanan-surat.cetak.liveSearchNik") }}?keyword=' + encodeURIComponent(query);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    suggestBox.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(function (item) {
                            var div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.innerHTML = '<span class="sug-name">' + item.nama + '</span><span class="sug-nik">' + item.nik + '</span>';
                            div.addEventListener('click', function () {
                                inputField.value = item.nik;
                                suggestBox.style.display = 'none';
                                fetchFullData(item.nik);
                            });
                            suggestBox.appendChild(div);
                        });
                        suggestBox.style.display = 'block';
                    }
                })
                .catch(function () {});
        }, 380);
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.search-card')) suggestBox.style.display = 'none';
    });

    inputField.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            suggestBox.style.display = 'none';
            fetchFullData(this.value.trim());
        }
    });

    btnSearch.addEventListener('click', function () {
        fetchFullData(inputField.value.trim());
    });

    /* ── Fetch full data NIK ── */
    function fetchFullData(nik) {
        if (!nik) return;
        setStatus('⏳ Menarik data warga & keluarga...', 'loading');

        var url = '{{ route("admin.layanan-surat.cetak.getDataByNik", ":nik") }}'.replace(':nik', encodeURIComponent(nik));

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function (res) {
                if (!res.success) {
                    setStatus('❌ ' + (res.message || 'Warga tidak ditemukan.'), 'err');
                    return;
                }

                var p = res.penduduk || {};
                var d = res.desa     || {};
                var k = res.keluarga || null;

                /* 1. DATA WARGA */
                setInputValue('nik',               p.nik);
                setInputValue('no_nik',            p.nik);
                setInputValue('nama',              p.nama);
                setInputValue('nama_lengkap',      p.nama);
                setInputValue('tempat_lahir',      p.tempat_lahir);
                setInputValue('tanggal_lahir',     fmtDate(p.tanggal_lahir));
                setInputValue('tgl_lahir',         fmtDate(p.tanggal_lahir));
                setInputValue('jenis_kelamin',     p.jenis_kelamin);
                setInputValue('kelamin',           p.jenis_kelamin);
                setInputValue('jk',                p.jenis_kelamin);
                setInputValue('agama',             p.agama);
                setInputValue('pekerjaan',         p.pekerjaan);
                setInputValue('status_kawin',      p.status_kawin);
                setInputValue('status_perkawinan', p.status_kawin);
                setInputValue('alamat',            p.alamat);
                setInputValue('rt',                p.rt);
                setInputValue('rw',                p.rw);
                setInputValue('warga_negara',      p.warga_negara || 'WNI');
                setInputValue('pendidikan',        p.pendidikan);

                var hNama = document.getElementById('hidden_nama_pemohon');
                var hNik  = document.getElementById('hidden_nik_pemohon');
                if (hNama) hNama.value = p.nama || '';
                if (hNik)  hNik.value  = p.nik  || '';

                /* 2. DATA KELUARGA */
                if (k) {
                    setInputValue('no_kk',           k.no_kk);
                    setInputValue('nomor_kk',        k.no_kk);
                    setInputValue('kepala_kk',       k.kepala_keluarga);
                    setInputValue('kepala_keluarga', k.kepala_keluarga);
                    setInputValue('nik_kepala',      k.nik_kepala);
                    setInputValue('alamat_kk',       k.alamat_kk);
                    setInputValue('alamat_keluarga', k.alamat_kk);
                }

                /* 3. DATA DESA — isi hidden fields */
                if (d) {
                    setHiddenValue('field_nama_desa',       d.nama_desa);
                    setHiddenValue('field_desa',            d.nama_desa);
                    setHiddenValue('field_kecamatan',       d.kecamatan);
                    setHiddenValue('field_kabupaten',       d.kabupaten);
                    setHiddenValue('field_provinsi',        d.provinsi);
                    setHiddenValue('field_alamat_kantor',   d.alamat_kantor);
                    setHiddenValue('field_kode_pos',        d.kode_pos);
                    setHiddenValue('field_nama_kades',      d.kepala_desa);
                    setHiddenValue('field_kepala_desa',     d.kepala_desa);
                    setHiddenValue('field_nip_kades',       d.nip_kepala_desa);
                    setHiddenValue('field_nip_kepala_desa', d.nip_kepala_desa);
                }

                var kkInfo = k ? ' + Data KK terisi.' : ' (Data KK tidak ditemukan.)';
                setStatus('✅ Data warga berhasil diisi!' + kkInfo, 'ok');
            })
            .catch(function (err) {
                setStatus('❌ Gagal terhubung ke server: ' + err.message, 'err');
            });
    }

    function fmtDate(val) {
        if (!val) return '';
        return String(val).split(' ')[0];
    }
    /* ── AUTO-FILL DARI DATA PERMOHONAN (JIKA ADA) ── */
    @if(isset($permohonan) && $permohonan->penduduk)
        var autoNik = '{{ $permohonan->penduduk->nik }}';
        if(autoNik && inputField) {
            // Isi kolom pencarian
            inputField.value = autoNik;
            
            // Beri jeda 0.5 detik agar DOM form siap, lalu jalankan fungsi tarik data otomatis
            setTimeout(function() { 
                fetchFullData(autoNik); 
                
                // Auto-fill field Keperluan/Perihal dari permohonan
                @if($permohonan->keperluan)
                    setInputValue('keperluan', `{{ $permohonan->keperluan }}`);
                    setInputValue('perihal', `{{ $permohonan->keperluan }}`);
                @endif

                // Auto-fill dari Data Isian tambahan (jika warga mengisi form tambahan)
                @if(is_array($permohonan->data_isian))
                    @foreach($permohonan->data_isian as $key => $val)
                        setInputValue('{{ strtolower($key) }}', `{{ $val }}`);
                    @endforeach
                @endif
                
            }, 500);
        }
    @endif

});
</script>

@endsection