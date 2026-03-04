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

body {
    font-family: 'Sora', sans-serif;
    background-color: var(--bg-page);
    color: var(--text-body);
    font-size: 14px;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem;
}

/* --- Header Section --- */
.page-header {
    margin-bottom: 2rem;
    animation: fadeInDown 0.5s ease-out;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.eyebrow {
    color: var(--brand-main);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.eyebrow::before {
    content: '';
    width: 1rem;
    height: 2px;
    background-color: var(--brand-main);
}
.page-title {
    font-size: 1.75rem;
    color: var(--text-heading);
    margin: 0 0 0.5rem 0;
    font-weight: 600;
}

/* --- Search Card --- */
.search-card {
    background: var(--surface-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-sm);
    position: relative;
}
.search-controls {
    display: flex;
    gap: 1rem;
    align-items: stretch;
}
.search-input-wrapper {
    flex-grow: 1;
    display: flex;
    align-items: center;
    background-color: var(--surface-secondary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-sm);
    padding: 0 1rem;
}
.search-input {
    flex-grow: 1;
    border: none;
    background: transparent;
    padding: 0.75rem 0;
    font-size: 0.95rem;
    outline: none;
}
.btn-search {
    background-color: var(--brand-main);
    color: white;
    border: none;
    padding: 0 1.25rem;
    border-radius: var(--radius-sm);
    font-weight: 500;
    cursor: pointer;
}

/* --- Suggestions --- */
.suggestions-box {
    display: none;
    position: absolute;
    top: calc(100% + 5px);
    left: 1.25rem;
    right: 1.25rem;
    background: white;
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    z-index: 100;
    max-height: 200px;
    overflow-y: auto;
}
.suggestion-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
}
.suggestion-item:hover { background-color: var(--brand-light); }

/* --- Form Design --- */
.form-section {
    background: var(--surface-primary);
    border: 1px solid var(--border-primary);
    border-radius: var(--radius-md);
    margin-bottom: 1.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.section-header {
    background-color: var(--surface-secondary);
    padding: 0.75rem 1.25rem;
    border-bottom: 1px solid var(--border-primary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.section-title { font-weight: 600; font-size: 0.9rem; color: var(--text-heading); margin:0; }
.section-body { padding: 1.25rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
.full-width { grid-column: span 2; }

.field-group label { display: block; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--text-muted); }
.form-input {
    width: 100%;
    padding: 0.6rem 0.8rem;
    border: 1px solid var(--border-secondary);
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    box-sizing: border-box;
}
.form-input:focus { border-color: var(--brand-main); outline: none; box-shadow: 0 0 0 3px var(--brand-light); }
.var-badge { font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; background: #f1f5f9; padding: 2px 4px; border-radius: 4px; margin-left: 4px; color: #64748b; }

.btn { padding: 0.75rem 1.5rem; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; border: none; transition: 0.2s; }
.btn-primary { background: var(--brand-main); color: white; }
.btn-outline { background: white; border: 1px solid var(--border-secondary); color: var(--text-body); }

@media (max-width: 640px) {
    .section-body { grid-template-columns: 1fr; }
    .full-width { grid-column: span 1; }
}
</style>

<div class="container">
    @php
        $rawVars = [];
        $templateJudul = $selectedTemplate->judul ?? 'Template Tidak Diketahui';

        if(isset($selectedTemplate) && $selectedTemplate->konten_template) {
            preg_match_all('/\[([a-zA-Z0-9_]+)\]/i', $selectedTemplate->konten_template, $matches);
            $uniqueVars = [];
            foreach($matches[1] ?? [] as $v) {
                $lower = strtolower($v);
                if(!isset($uniqueVars[$lower])) { $uniqueVars[$lower] = $v; }
            }
            $rawVars = array_values($uniqueVars);
        }

        // KAMUS KATEGORI
        $wargaKeys = ['nik', 'no_nik', 'nama', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'tgl_lahir', 'jenis_kelamin', 'kelamin', 'jk', 'agama', 'pekerjaan', 'status_kawin', 'alamat', 'rt', 'rw', 'no_kk'];
        
        $suratKeys = ['nomor_surat', 'no_surat', 'format_nomor', 'tgl_surat', 'tanggal_surat', 'penandatangan', 'jabatan', 'perihal', 'judul_surat'];
        
        $desaKeys = ['nama_desa', 'desa', 'kecamatan', 'kabupaten', 'provinsi', 'alamat_kantor', 'kode_pos', 'nama_kades', 'nip_kades'];

        $wargaFields = []; $suratFields = []; $desaFields = []; $otherFields = [];

        foreach($rawVars as $var) {
            $key = strtolower($var);
            if(in_array($key, $wargaKeys)) $wargaFields[] = $var;
            elseif(in_array($key, $suratKeys)) $suratFields[] = $var;
            elseif(in_array($key, $desaKeys)) $desaFields[] = $var;
            else $otherFields[] = $var;
        }

        function getFieldType($varName) {
            $n = strtolower($varName);
            if(str_contains($n, 'tanggal') || str_contains($n, 'tgl')) return 'date';
            return 'text';
        }

        $getDefaultVal = function($varName) use ($templateJudul) {
            $n = strtolower($varName);
            if(in_array($n, ['tgl_surat', 'tanggal_surat'])) return date('Y-m-d');
            if(in_array($n, ['penandatangan', 'jabatan'])) return 'Kepala Desa';
            if(in_array($n, ['nomor_surat', 'no_surat'])) return '.../..../'.date('Y');
            if(in_array($n, ['judul_surat', 'perihal'])) return strtoupper($templateJudul);
            return '';
        };
    @endphp

    <div class="page-header">
        <div class="eyebrow">Layanan Surat Digital</div>
        <h1 class="page-title">{{ $templateJudul }}</h1>
        <p style="color: var(--text-muted);">Lengkapi data di bawah ini. Nomor surat dan data warga akan otomatis terisi setelah pencarian.</p>
    </div>

    {{-- Pencarian NIK --}}
    <div class="search-card">
        <div class="search-controls">
            <div class="search-input-wrapper">
                <input type="text" id="searchInput" class="search-input" placeholder="Cari NIK atau Nama Warga..." autocomplete="off">
            </div>
            <button type="button" id="btnSearch" class="btn-search">Cari Data</button>
        </div>
        <div id="searchStatus" style="font-size: 0.75rem; margin-top: 5px; color: var(--text-muted);">Siap mencari...</div>
        <div id="suggestionsBox" class="suggestions-box"></div>
    </div>

    <form id="mainLetterForm" method="POST">
        @csrf
        <input type="hidden" name="template_id" value="{{ $selectedTemplate->id ?? '' }}">

        {{-- 1. HIDDEN FIELDS (Hanya Data Desa) --}}
        @foreach($desaFields as $hiddenVar)
            <input type="hidden" name="{{ $hiddenVar }}" value="{{ $getDefaultVal($hiddenVar) }}">
        @endforeach

        {{-- 2. SECTION DETAIL SURAT (Penting untuk Arsip) --}}
        @if(count($suratFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">📦 Informasi Penomoran & Surat</h3>
            </div>
            <div class="section-body">
                @foreach($suratFields as $var)
                    <div class="field-group {{ str_contains(strtolower($var), 'nomor') ? 'full-width' : '' }}">
                        <label>{{ ucwords(str_replace('_', ' ', $var)) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input type="{{ getFieldType($var) }}" name="{{ $var }}" class="form-input" value="{{ $getDefaultVal($var) }}" required>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 3. SECTION IDENTITAS WARGA --}}
        @if(count($wargaFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">👤 Identitas Pemohon</h3>
            </div>
            <div class="section-body">
                @foreach($wargaFields as $var)
                    @php $isFull = in_array(strtolower($var), ['nama', 'nama_lengkap', 'alamat']); @endphp
                    <div class="field-group {{ $isFull ? 'full-width' : '' }}">
                        <label>{{ ucwords(str_replace('_', ' ', $var)) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input type="{{ getFieldType($var) }}" name="{{ $var }}" class="form-input" required>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 4. SECTION TAMBAHAN (Lain-lain) --}}
        @if(count($otherFields) > 0)
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">📝 Keterangan Tambahan</h3>
            </div>
            <div class="section-body">
                @foreach($otherFields as $var)
                    <div class="field-group full-width">
                        <label>{{ ucwords(str_replace('_', ' ', $var)) }} <span class="var-badge">[{{ $var }}]</span></label>
                        <input type="text" name="{{ $var }}" class="form-input" required>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- AKSI --}}
        <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem;">
            <button type="submit" formaction="{{ route('admin.layanan-surat.cetak.preview') }}" class="btn btn-primary" style="font-size: 1.1rem; padding: 1rem;">
                🚀 Lanjutkan ke Preview & Edit
            </button>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <button type="submit" formaction="{{ route('admin.layanan-surat.cetak.store') }}" class="btn btn-outline">Simpan Draft</button>
                <a href="{{ route('admin.layanan-surat.cetak.index') }}" class="btn btn-outline" style="text-align:center; text-decoration:none;">Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById('searchInput');
    const suggestBox = document.getElementById('suggestionsBox');
    const statusLabel = document.getElementById('searchStatus');
    const btnSearch = document.getElementById('btnSearch');
    let debounceTimer;

    inputField.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) { suggestBox.style.display = 'none'; return; }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const searchUrl = `{{ route('admin.layanan-surat.cetak.liveSearchNik') }}?keyword=${encodeURIComponent(query)}`;
            fetch(searchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    suggestBox.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.innerHTML = `<span>${item.nama}</span> <small>${item.nik}</small>`;
                            div.onclick = () => {
                                inputField.value = item.nik;
                                suggestBox.style.display = 'none';
                                fetchFullData(item.nik);
                            };
                            suggestBox.appendChild(div);
                        });
                        suggestBox.style.display = 'block';
                    }
                });
        }, 400);
    });

    function setInputValue(name, val) {
        const el = document.querySelector(`[name="${name}" i]`);
        if (el && val) el.value = val;
    }

    function fetchFullData(nik) {
        statusLabel.textContent = 'Menarik data...';
        let url = "{{ route('admin.layanan-surat.cetak.getDataByNik', ':nik') }}".replace(':nik', nik);
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    const p = resData.penduduk;
                    const d = resData.desa;
                    
                    // Isi data warga (Visible)
                    setInputValue('nik', p.nik);
                    setInputValue('no_nik', p.nik);
                    setInputValue('nama', p.nama);
                    setInputValue('nama_lengkap', p.nama);
                    setInputValue('tempat_lahir', p.tempat_lahir);
                    if(p.tanggal_lahir) setInputValue('tanggal_lahir', p.tanggal_lahir.split(' ')[0]);
                    setInputValue('alamat', p.alamat);
                    setInputValue('rt', p.rt);
                    setInputValue('rw', p.rw);
                    setInputValue('pekerjaan', p.pekerjaan);
                    setInputValue('agama', p.agama);

                    // Isi data desa (Hidden/Visible)
                    if(d) {
                        setInputValue('nama_desa', d.nama_desa);
                        setInputValue('kecamatan', d.kecamatan);
                        setInputValue('nama_kades', d.kepala_desa);
                    }

                    statusLabel.textContent = 'Data ditemukan!';
                    statusLabel.style.color = 'var(--status-success)';
                }
            });
    }

    btnSearch.onclick = () => fetchFullData(inputField.value);
});
</script>
@endsection