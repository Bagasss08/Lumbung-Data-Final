@extends('layouts.admin')

@section('title', 'Daftar Template Surat')

@section('content')

{{-- Font DM Sans hanya untuk bagian konten ini --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* CSS Scoped untuk halaman ini agar tidak merusak layout utama Tailwind */
    :root {
        --bg:           #f0f2f5;
        --surface:      #ffffff;
        --border:       #e4e7ec;
        --border-light: #f0f2f5;
        --blue:         #2563eb;
        --blue-light:   #eff6ff;
        --green:        #16a34a;
        --green-light:  #f0fdf4;
        --red:          #dc2626;
        --amber:        #d97706;
        --text:         #111827;
        --text-mid:     #374151;
        --text-muted:   #6b7280;
        --text-light:   #9ca3af;
        --navy:         #1e3a5f;
        --radius:       10px;
    }

    /* ── MAIN ── */
    .template-main { 
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--text);
        padding: 28px; 
        max-width: 1300px; 
        margin: 0 auto; 
    }

    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
    }
    .page-header-left h1 {
        font-size: 1.4rem; font-weight: 700;
        color: var(--text); letter-spacing: -0.2px;
        margin: 0;
    }
    .breadcrumb {
        display: flex; align-items: center; gap: 5px;
        font-size: 0.8rem; color: var(--text-muted); margin-top: 5px;
    }
    .breadcrumb a { color: var(--blue); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb .sep { color: var(--text-light); }

    /* ── ALERT ── */
    .alert-success {
        background: var(--green-light);
        border: 1px solid #bbf7d0;
        border-left: 4px solid var(--green);
        padding: 12px 16px; border-radius: 8px;
        color: #166534; font-size: 0.9rem;
        margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── BTN ── */
    .btn {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 8px;
        font-size: 0.875rem; font-weight: 600;
        font-family: inherit; cursor: pointer; border: none;
        text-decoration: none; white-space: nowrap; line-height: 1;
        transition: filter 0.15s, transform 0.1s;
    }
    .btn:hover { filter: brightness(0.9); transform: translateY(-1px); }
    .btn svg { width: 15px; height: 15px; flex-shrink: 0; }
    .btn-tambah  { background: #22c55e; color: #fff; }
    .btn-hapus   { background: #ef4444; color: #fff; }
    .btn-impor   { background: #0ea5e9; color: #fff; }
    .btn-setting { background: var(--navy); color: #fff; }

    /* ── TOP BAR (header kanan atas) ── */
    .top-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    /* ── CARD ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
    }

    /* ── CARD HEADER (filter + search dalam satu bar) ── */
    .card-header {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        gap: 12px; flex-wrap: wrap;
        background: #fafbfc;
    }
    .card-header-left  { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .card-header-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .filter-select {
        padding: 8px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: inherit; font-size: 0.875rem;
        color: var(--text); background: var(--surface);
        outline: none; cursor: pointer; min-width: 150px;
        transition: border-color 0.15s;
    }
    .filter-select:focus { border-color: var(--blue); }

    .entries-ctrl {
        display: flex; align-items: center;
        gap: 7px; font-size: 0.875rem; color: var(--text-mid);
    }
    .entries-ctrl select {
        padding: 6px 10px;
        border: 1.5px solid var(--border);
        border-radius: 7px; font-family: inherit;
        font-size: 0.875rem; background: var(--surface);
        color: var(--text); cursor: pointer; outline: none;
    }

    .search-wrap {
        position: relative; display: flex; align-items: center;
    }
    .search-wrap svg {
        position: absolute; left: 10px;
        width: 15px; height: 15px; color: var(--text-light); pointer-events: none;
    }
    .search-wrap input {
        padding: 8px 12px 8px 32px;
        border: 1.5px solid var(--border);
        border-radius: 8px; font-family: inherit;
        font-size: 0.875rem; color: var(--text);
        outline: none; width: 220px;
        transition: border-color 0.15s;
    }
    .search-wrap input:focus { border-color: var(--blue); }

    /* ── TABLE ── */
    .template-main table { width: 100%; border-collapse: collapse; }

    .template-main thead tr { background: #f8fafc; }
    .template-main thead th {
        padding: 11px 16px;
        text-align: left;
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        color: var(--text-muted);
        border-bottom: 1.5px solid var(--border);
        white-space: nowrap;
    }
    .template-main thead th.c { text-align: center; }

    .col-chk  { width: 44px; }
    .col-no   { width: 52px; }
    .col-nama { /* flex */ }
    .col-kode { width: 150px; }
    .col-st   { width: 110px; }
    .col-lamp { width: 170px; }
    .col-aksi { width: 220px; text-align: right; }

    .template-main tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background 0.1s;
    }
    .template-main tbody tr:last-child { border-bottom: none; }
    .template-main tbody tr:hover { background: #f8fbff; }
    .template-main tbody tr.selected { background: #eff6ff; }

    .template-main tbody td {
        padding: 13px 16px;
        font-size: 0.9rem;
        vertical-align: middle;
        color: var(--text-mid);
    }
    .template-main tbody td.c  { text-align: center; }
    .template-main tbody td.r  { text-align: right; }

    .template-main input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--blue); cursor: pointer;
    }

    .no-cell { font-size: 0.85rem; color: var(--text-light); font-weight: 600; }

    /* Nama surat dengan sub-info */
    .nama-wrap {}
    .nama-surat { font-weight: 600; color: var(--text); font-size: 0.925rem; display: block; }
    .nama-sub   { font-size: 0.78rem; color: var(--text-light); margin-top: 2px; display: block; }

    .kode-badge {
        display: inline-block;
        background: #f1f5f9; color: #334155;
        border: 1px solid #e2e8f0;
        padding: 3px 10px; border-radius: 5px;
        font-size: 0.8rem; font-weight: 600;
    }
    .lampiran-text { font-size: 0.82rem; color: var(--text-muted); }
    .dash { color: var(--text-light); }

    /* Status badge */
    .status-badge {
        display: inline-flex; align-items: center;
        gap: 5px; padding: 4px 10px;
        border-radius: 20px; font-size: 0.78rem; font-weight: 600;
    }
    .s-aktif    { background: var(--green-light); color: #15803d; border: 1px solid #bbf7d0; }
    .s-nonaktif { background: #f9fafb; color: var(--text-muted); border: 1px solid var(--border); }
    .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

    /* ── AKSI — pill tombol teks kecil ── */
    .aksi-group {
        display: flex; align-items: center;
        justify-content: flex-end; gap: 6px; flex-wrap: wrap;
    }
    .aksi-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600;
        font-family: inherit; cursor: pointer; border: none;
        text-decoration: none; white-space: nowrap;
        transition: filter 0.15s, transform 0.1s;
        line-height: 1;
    }
    .aksi-btn:hover { filter: brightness(0.9); transform: translateY(-1px); }
    .aksi-btn svg { width: 13px; height: 13px; flex-shrink: 0; }

    .ab-edit   { background: var(--blue-light); color: var(--blue);   border: 1px solid #bfdbfe; }
    .ab-salin  { background: #f0fdf4;           color: var(--green);  border: 1px solid #bbf7d0; }
    .ab-toggle { background: #f9fafb;            color: var(--text-mid); border: 1px solid var(--border); }
    .ab-toggle.nonaktif { background: #fff7ed; color: #c2410c; border-color: #fed7aa; }
    .ab-fav    { background: #fffbeb;            color: var(--amber);  border: 1px solid #fde68a; }
    .ab-fav.on { background: #fef3c7;            color: var(--amber);  border-color: #fcd34d; }

    /* ── FOOTER ── */
    .table-footer {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 13px 20px;
        border-top: 1px solid var(--border-light);
        flex-wrap: wrap; gap: 12px;
    }
    .info-text { font-size: 0.85rem; color: var(--text-muted); }

    .template-pagination { display: flex; align-items: center; gap: 4px; }
    .page-btn {
        min-width: 36px; height: 34px; padding: 0 10px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1.5px solid var(--border); border-radius: 7px;
        background: var(--surface); color: var(--text-mid);
        font-size: 0.85rem; font-weight: 500;
        cursor: pointer; transition: all 0.15s; font-family: inherit;
    }
    .page-btn:hover:not(:disabled) {
        border-color: var(--blue); color: var(--blue); background: var(--blue-light);
    }
    .page-btn.active { background: var(--blue); color: #fff; border-color: var(--blue); }
    .page-btn:disabled { opacity: 0.35; cursor: default; }

    /* ── EMPTY ── */
    .empty-row td {
        text-align: center; padding: 56px 24px;
        color: var(--text-muted); font-size: 0.9rem;
    }

    /* ── TOAST ── */
    #toast {
        position: fixed; bottom: 24px; right: 24px;
        background: #1f2937; color: #fff;
        padding: 12px 18px; border-radius: 8px;
        font-size: 0.875rem; font-weight: 500;
        box-shadow: 0 4px 20px rgba(0,0,0,0.18);
        display: flex; align-items: center; gap: 8px;
        transform: translateY(60px); opacity: 0;
        transition: all 0.25s ease; z-index: 999;
    }
    #toast.show { transform: translateY(0); opacity: 1; }

    @media (max-width: 768px) {
        .template-main { padding: 16px; }
        .col-kode, .col-lamp { display: none; }
        .search-wrap input { width: 140px; }
    }
</style>

<div class="template-main">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1>Daftar Template Surat</h1>
            <div class="breadcrumb">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <a href="{{ route('admin.dashboard') }}">Beranda</a>
                <span class="sep">›</span>
                <span>Daftar Template Surat</span>
            </div>
        </div>
        <div class="top-actions">
            <a href="{{ route('admin.layanan-surat.template-surat.create') }}" class="btn btn-tambah">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Template
            </a>
            <button class="btn btn-hapus" onclick="hapusTerpilih()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
            <button class="btn btn-impor">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Impor / Ekspor
            </button>
            <button class="btn btn-setting">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Pengaturan
            </button>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Card --}}
    <div class="card">

        {{-- Card Header — filter + search --}}
        <div class="card-header">
            <div class="card-header-left">
                <div class="entries-ctrl">
                    Tampilkan
                    <select id="perPage">
                        <option>10</option>
                        <option selected>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    entri
                </div>
                <select class="filter-select" id="filterStatus">
                    <option value="" selected>Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
                <select class="filter-select" id="filterJenis">
                    <option value="">Semua Jenis Surat</option>
                    {{-- Diisi otomatis dari JS berdasarkan data yang ada --}}
                </select>
            </div>
            <div class="card-header-right">
                <div class="search-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="searchInput"
                           placeholder="Cari nama surat..."
                           oninput="filterTable()">
                </div>
            </div>
        </div>

        {{-- Table --}}
        <table>
            <thead>
                <tr>
                    <th class="col-chk c">
                        <input type="checkbox" id="checkAll" onchange="toggleAll(this)">
                    </th>
                    <th class="col-no">NO</th>
                    <th class="col-nama">NAMA SURAT</th>
                    <th class="col-kode">KODE / KLASIFIKASI</th>
                    <th class="col-st c">STATUS</th>
                    <th class="col-lamp">LAMPIRAN</th>
                    <th class="col-aksi" style="text-align:right">AKSI</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($templates as $t)
                <tr data-id="{{ $t->id }}"
                    data-nama="{{ strtolower($t->judul) }}"
                    data-status="{{ $t->status }}"
                    data-jenis="{{ strtolower(explode(' ', trim($t->judul))[0] ?? '') }}">

                    <td class="c">
                        <input type="checkbox" class="row-check" value="{{ $t->id }}" onchange="rowSelect(this)">
                    </td>

                    <td><span class="no-cell">{{ $loop->iteration }}</span></td>

                    <td>
                        <div class="nama-wrap">
                            <span class="nama-surat">{{ $t->judul }}</span>
                            @if(!empty($t->deskripsi))
                            <span class="nama-sub">{{ $t->deskripsi }}</span>
                            @endif
                        </div>
                    </td>

                    <td>
                        @if(!empty($t->kode_klasifikasi))
                            <span class="kode-badge">{{ $t->kode_klasifikasi }}</span>
                        @else
                            <span class="dash">—</span>
                        @endif
                    </td>

                    <td class="c">
                        <span class="status-badge {{ $t->status === 'aktif' ? 's-aktif' : 's-nonaktif' }}" id="status-{{ $t->id }}">
                            <span class="dot"></span> {{ $t->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    <td>
                        @if(!empty($t->file_path))
                            <span class="lampiran-text">{{ basename($t->file_path) }}</span>
                        @else
                            <span class="dash">—</span>
                        @endif
                    </td>

                    <td class="r">
                        <div class="aksi-group">

                            {{-- Edit --}}
                            <a href="{{ route('admin.layanan-surat.template-surat.edit', $t->id) }}"
                               class="aksi-btn ab-edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>

                            {{-- Salin --}}
                            <button class="aksi-btn ab-salin"
                                    onclick="salin('{{ addslashes($t->judul) }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Salin
                            </button>

                            {{-- Nonaktif/Aktif --}}
                            <button class="aksi-btn ab-toggle {{ $t->status !== 'aktif' ? 'nonaktif' : '' }}"
                                    id="toggle-{{ $t->id }}"
                                    onclick="toggleStatus('{{ $t->id }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     id="toggle-svg-{{ $t->id }}">
                                    @if($t->status === 'aktif')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @endif
                                </svg>
                                <span id="toggle-label-{{ $t->id }}">{{ $t->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                            </button>

                            {{-- Favorit --}}
                            <button class="aksi-btn ab-fav"
                                    id="fav-{{ $t->id }}"
                                    onclick="toggleFav('{{ $t->id }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     id="fav-svg-{{ $t->id }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span id="fav-label-{{ $t->id }}">Favorit</span>
                            </button>

                        </div>
                    </td>

                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7">Belum ada template surat. Silakan tambahkan template baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer --}}
        <div class="table-footer">
            <div class="info-text" id="infoText">
                Menampilkan 1 sampai {{ $templates->count() }} dari {{ $templates->count() }} entri
            </div>
            <div class="template-pagination" id="pagination">
                <button class="page-btn" disabled>‹ Sebelumnya</button>
                <button class="page-btn active">1</button>
                <button class="page-btn" disabled>Berikutnya ›</button>
            </div>
        </div>

    </div>{{-- /card --}}

</div>{{-- /template-main --}}

{{-- Toast --}}
<div id="toast">
    <span id="t-icon">✓</span>
    <span id="t-msg">Berhasil!</span>
</div>

<script>
    // ═══════════════════════════════════════════════════
    // STATE
    // ═══════════════════════════════════════════════════
    let currentPage  = 1;
    const stMap  = {};   // status per row  (true = aktif)
    const favMap = {};   // favorit per row

    // ═══════════════════════════════════════════════════
    // CORE — satu fungsi yang menjalankan SEMUA filter
    // sekaligus, lalu render ulang nomor urut & pagination
    // ═══════════════════════════════════════════════════
    function applyFilters() {
        const q       = document.getElementById('searchInput').value.toLowerCase().trim();
        const status  = document.getElementById('filterStatus').value;   // '' | 'aktif' | 'nonaktif'
        const jenis   = document.getElementById('filterJenis').value;    // '' | nilai jenis
        const perPage = parseInt(document.getElementById('perPage').value);

        // Kumpulkan semua baris data
        const allRows = [...document.querySelectorAll('#tableBody tr[data-nama]')];

        // 1. Filter — tentukan baris mana yang cocok
        const matched = allRows.filter(tr => {
            const namaOk   = tr.dataset.nama.includes(q);
            const statusOk = !status || tr.dataset.status === status;
            const jenisOk  = !jenis  || tr.dataset.jenis === jenis;
            return namaOk && statusOk && jenisOk;
        });

        const total   = allRows.length;
        const found   = matched.length;
        const totalPg = Math.max(1, Math.ceil(found / perPage));

        // Pastikan halaman tidak melebihi total
        if (currentPage > totalPg) currentPage = totalPg;

        const startIdx = (currentPage - 1) * perPage;   // 0-based
        const endIdx   = startIdx + perPage;

        // 2. Sembunyikan semua, lalu tampilkan hanya baris di halaman ini
        let noCounter = startIdx + 1;
        allRows.forEach(tr => { tr.style.display = 'none'; });

        matched.forEach((tr, i) => {
            if (i >= startIdx && i < endIdx) {
                tr.style.display = '';
                // Update nomor urut sesuai halaman
                const noCell = tr.querySelector('.no-cell');
                if (noCell) noCell.textContent = noCounter++;
            }
        });

        // 3. Info teks
        const showStart = found === 0 ? 0 : startIdx + 1;
        const showEnd   = Math.min(endIdx, found);
        let infoText = `Menampilkan ${showStart}–${showEnd} dari ${found} entri`;
        if (found < total) infoText += ` (difilter dari ${total} total entri)`;
        document.getElementById('infoText').textContent = infoText;

        // 4. Render pagination
        renderPagination(totalPg);

        // 5. Reset checkbox
        syncCheckAll();
    }

    // ═══════════════════════════════════════════════════
    // PAGINATION RENDER
    // ═══════════════════════════════════════════════════
    function renderPagination(totalPg) {
        const wrap = document.getElementById('pagination');
        wrap.innerHTML = '';

        const mkBtn = (label, page, isActive, isDisabled) => {
            const b = document.createElement('button');
            b.className = 'page-btn' + (isActive ? ' active' : '');
            b.disabled  = isDisabled;
            b.innerHTML = label;
            if (!isDisabled) b.onclick = () => { currentPage = page; applyFilters(); };
            return b;
        };

        // Tombol Sebelumnya
        wrap.appendChild(mkBtn('‹ Sebelumnya', currentPage - 1, false, currentPage === 1));

        // Nomor halaman (maks tampil 5 halaman di sekitar current)
        const range = [];
        for (let p = 1; p <= totalPg; p++) {
            if (p === 1 || p === totalPg ||
                (p >= currentPage - 2 && p <= currentPage + 2)) {
                range.push(p);
            }
        }
        let prev = null;
        range.forEach(p => {
            if (prev !== null && p - prev > 1) {
                const dots = document.createElement('button');
                dots.className = 'page-btn';
                dots.disabled = true;
                dots.textContent = '…';
                wrap.appendChild(dots);
            }
            wrap.appendChild(mkBtn(p, p, p === currentPage, false));
            prev = p;
        });

        // Tombol Berikutnya
        wrap.appendChild(mkBtn('Berikutnya ›', currentPage + 1, false, currentPage === totalPg));
    }

    // ═══════════════════════════════════════════════════
    // CHECKBOX
    // ═══════════════════════════════════════════════════
    function toggleAll(master) {
        // Hanya centang baris yang sedang TAMPIL
        document.querySelectorAll('#tableBody tr[data-nama]').forEach(tr => {
            if (tr.style.display !== 'none') {
                const cb = tr.querySelector('.row-check');
                if (cb) { cb.checked = master.checked; }
                tr.classList.toggle('selected', master.checked);
            }
        });
    }
    function rowSelect(cb) {
        cb.closest('tr').classList.toggle('selected', cb.checked);
        syncCheckAll();
    }
    function syncCheckAll() {
        const visibleCbs = [...document.querySelectorAll('#tableBody tr[data-nama]')]
            .filter(tr => tr.style.display !== 'none')
            .map(tr => tr.querySelector('.row-check'))
            .filter(Boolean);
        const checkedCount = visibleCbs.filter(cb => cb.checked).length;
        const master = document.getElementById('checkAll');
        master.indeterminate = checkedCount > 0 && checkedCount < visibleCbs.length;
        master.checked = visibleCbs.length > 0 && checkedCount === visibleCbs.length;
    }

    // ═══════════════════════════════════════════════════
    // HAPUS TERPILIH
    // ═══════════════════════════════════════════════════
    function hapusTerpilih() {
        const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
        if (!ids.length) { showToast('Pilih minimal satu template terlebih dahulu', '⚠️'); return; }
        if (confirm(`Hapus ${ids.length} template terpilih?\nTindakan ini tidak dapat dibatalkan.`)) {
            showToast(`${ids.length} template berhasil dihapus`, '🗑️');
            // TODO: kirim ke server
        }
    }

    // ═══════════════════════════════════════════════════
    // SALIN
    // ═══════════════════════════════════════════════════
    function salin(judul) {
        navigator.clipboard.writeText(judul).catch(() => {
            const el = Object.assign(document.createElement('textarea'), { value: judul });
            document.body.appendChild(el); el.select();
            document.execCommand('copy'); document.body.removeChild(el);
        });
        showToast(`"${judul}" berhasil disalin`, '📋');
    }

    // ═══════════════════════════════════════════════════
    // TOGGLE STATUS — juga update data-status di baris
    // sehingga filter status langsung ikut bekerja
    // ═══════════════════════════════════════════════════
    function toggleStatus(id) {
        const tr    = document.querySelector(`tr[data-id="${id}"]`);
        const isAktif = tr.dataset.status === 'aktif';
        const newStatus = isAktif ? 'nonaktif' : 'aktif';
        tr.dataset.status = newStatus; // ← update data atribut agar filter status ikut

        const badge = document.getElementById('status-' + id);
        const svg   = document.getElementById('toggle-svg-' + id);
        const btn   = document.getElementById('toggle-' + id);
        const label = document.getElementById('toggle-label-' + id);

        if (newStatus === 'aktif') {
            badge.className   = 'status-badge s-aktif';
            badge.innerHTML   = '<span class="dot"></span> Aktif';
            btn.className     = 'aksi-btn ab-toggle';
            label.textContent = 'Nonaktifkan';
            svg.innerHTML     = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>';
            showToast('Template berhasil diaktifkan kembali', '✅');
        } else {
            badge.className   = 'status-badge s-nonaktif';
            badge.innerHTML   = '<span class="dot"></span> Nonaktif';
            btn.className     = 'aksi-btn ab-toggle nonaktif';
            label.textContent = 'Aktifkan';
            svg.innerHTML     = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            showToast('Template berhasil dinonaktifkan', '🚫');
        }

        // Re-apply filter agar baris yang baru dinonaktifkan
        // langsung hilang jika filter status sedang aktif
        applyFilters();

        // TODO: fetch(`/template-surat/${id}/toggle`, { method:'POST', headers:{'X-CSRF-TOKEN':'...'} })
    }

    // ═══════════════════════════════════════════════════
    // TOGGLE FAVORIT
    // ═══════════════════════════════════════════════════
    function toggleFav(id) {
        favMap[id] = !favMap[id];
        const btn   = document.getElementById('fav-' + id);
        const svg   = document.getElementById('fav-svg-' + id);
        const label = document.getElementById('fav-label-' + id);
        if (favMap[id]) {
            btn.classList.add('on');
            svg.setAttribute('fill', 'currentColor');
            label.textContent = 'Favorit ★';
            showToast('Ditambahkan ke daftar favorit', '⭐');
        } else {
            btn.classList.remove('on');
            svg.setAttribute('fill', 'none');
            label.textContent = 'Favorit';
            showToast('Dihapus dari daftar favorit', '☆');
        }
        // TODO: fetch(`/template-surat/${id}/favorit`, { method:'POST', headers:{'X-CSRF-TOKEN':'...'} })
    }

    // ═══════════════════════════════════════════════════
    // TOAST
    // ═══════════════════════════════════════════════════
    function showToast(msg, icon) {
        const el = document.getElementById('toast');
        document.getElementById('t-msg').textContent = msg;
        document.getElementById('t-icon').textContent = icon || '✓';
        el.classList.add('show');
        clearTimeout(el._t);
        el._t = setTimeout(() => el.classList.remove('show'), 2600);
    }

    // ═══════════════════════════════════════════════════
    // EVENT LISTENERS — semua filter memanggil applyFilters
    // ═══════════════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('searchInput') .addEventListener('input',  () => { currentPage = 1; applyFilters(); });
        document.getElementById('filterStatus').addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('filterJenis') .addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('perPage')     .addEventListener('change', () => { currentPage = 1; applyFilters(); });

        // Isi dropdown Jenis Surat otomatis dari data baris yang ada
        const jenisSelect = document.getElementById('filterJenis');
        const jenisSet    = new Set();
        document.querySelectorAll('#tableBody tr[data-jenis]').forEach(tr => {
            const j = tr.dataset.jenis;
            if (j) jenisSet.add(j);
        });
        // Urutkan A-Z lalu tambahkan ke dropdown
        [...jenisSet].sort().forEach(j => {
            const opt = document.createElement('option');
            opt.value       = j;
            opt.textContent = j.charAt(0).toUpperCase() + j.slice(1); // Kapital huruf pertama
            jenisSelect.appendChild(opt);
        });

        // Run pertama kali — tampilkan semua (filter status = "")
        applyFilters();
    });
</script>

@endsection