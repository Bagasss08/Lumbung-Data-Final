@extends('layouts.admin')

@section('title', 'Daftar Template Surat')

@section('content')

{{-- Font DM Sans hanya untuk bagian konten ini --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
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

    /* ── TOP BAR ── */
    .top-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    /* ── CARD ── */
    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
    }

    /* ── CARD HEADER ── */
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
    .col-kode { width: 200px; }
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

    /* Nama surat */
    .nama-surat { font-weight: 600; color: var(--text); font-size: 0.925rem; display: block; }
    .nama-sub   { font-size: 0.78rem; color: var(--text-light); margin-top: 2px; display: block; }

    /* ── KODE KLASIFIKASI BADGE ── */
    .klasifikasi-wrap {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .kode-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eef2ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        width: fit-content;
    }
    .kode-badge svg {
        width: 11px; height: 11px; flex-shrink: 0;
    }
    .nama-klasifikasi-text {
        font-size: 0.75rem;
        color: var(--text-muted);
        line-height: 1.3;
        max-width: 180px;
        white-space: normal;
    }
    .retensi-wrap {
        display: flex;
        gap: 6px;
        margin-top: 2px;
    }
    .retensi-pill {
        font-size: 0.7rem;
        padding: 2px 7px;
        border-radius: 20px;
        font-weight: 500;
    }
    .retensi-aktif   { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .retensi-inaktif { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

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

    /* ── AKSI ── */
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

    .ab-edit   { background: var(--blue-light); color: var(--blue);  border: 1px solid #bfdbfe; }
    .ab-salin  { background: #f0fdf4;           color: var(--green); border: 1px solid #bbf7d0; }
    .ab-hapus  { background: #fee2e2;            color: #dc2626; border: 1px solid #fecaca; }

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
            <a href="{{ route('admin.layanan-surat.template-surat.pengaturan') }}" class="btn btn-setting" style="text-decoration: none;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Pengaturan
            </a>
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

        {{-- Card Header --}}
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
                    <option value="noaktif">Nonaktif</option>
                </select>
                <select class="filter-select" id="filterKlasifikasi">
                    <option value="">Semua Klasifikasi</option>
                    {{-- Diisi dinamis dari data template --}}
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
                    data-klasifikasi="{{ $t->klasifikasi ? strtolower($t->klasifikasi->kode) : '' }}">

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

                    {{-- KOLOM KODE / KLASIFIKASI --}}
                    <td>
                        @if($t->klasifikasi)
                            <div class="klasifikasi-wrap">
                                {{-- Kode utama --}}
                                <span class="kode-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $t->klasifikasi->kode }}
                                </span>

                                {{-- Nama klasifikasi (dari kolom nama_klasifikasi) --}}
                                @if(!empty($t->klasifikasi->nama_klasifikasi))
                                <span class="nama-klasifikasi-text" title="{{ $t->klasifikasi->nama_klasifikasi }}">
                                    {{ Str::limit($t->klasifikasi->nama_klasifikasi, 30) }}
                                </span>
                                @endif

                                {{-- Retensi (opsional, tampilkan jika ada data) --}}
                                @if(!empty($t->klasifikasi->retensi_aktif) || !empty($t->klasifikasi->retensi_inaktif))
                                <div class="retensi-wrap">
                                    @if(!empty($t->klasifikasi->retensi_aktif))
                                    <span class="retensi-pill retensi-aktif" title="Retensi Aktif">
                                        A: {{ $t->klasifikasi->retensi_aktif }}
                                    </span>
                                    @endif
                                    @if(!empty($t->klasifikasi->retensi_inaktif))
                                    <span class="retensi-pill retensi-inaktif" title="Retensi Inaktif">
                                        I: {{ $t->klasifikasi->retensi_inaktif }}
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        @else
                            <span class="dash">—</span>
                        @endif
                    </td>

                    <td class="c">
                        <span class="status-badge {{ $t->status === 'aktif' ? 's-aktif' : 's-nonaktif' }}" id="status-{{ $t->id }}">
                            <span class="dot"></span>
                            {{ $t->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    <td>
                        @if(!empty($t->lampiran))
                            <span class="lampiran-text">{{ $t->lampiran }}</span>
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

                            {{-- Hapus --}}
                            <form action="{{ route('admin.layanan-surat.template-surat.destroy', $t->id) }}" method="POST"
                                  style="margin:0;padding:0;" onsubmit="return confirm('Yakin ingin menghapus template ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="aksi-btn ab-hapus">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>

                            {{-- Salin --}}
                            <button class="aksi-btn ab-salin"
                                    onclick="salin('{{ addslashes($t->judul) }}')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                Salin
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

    </div>

</div>

{{-- Toast --}}
<div id="toast">
    <span id="t-icon">✓</span>
    <span id="t-msg">Berhasil!</span>
</div>

<script>
    // ═══════════════════════════════════════════════════
    // STATE
    // ═══════════════════════════════════════════════════
    let currentPage = 1;

    // ═══════════════════════════════════════════════════
    // FILTER & PAGINATION
    // ═══════════════════════════════════════════════════
    function filterTable() { currentPage = 1; applyFilters(); }

    function applyFilters() {
        const q            = document.getElementById('searchInput').value.toLowerCase().trim();
        const status       = document.getElementById('filterStatus').value;
        const klasifikasi  = document.getElementById('filterKlasifikasi').value;
        const perPage      = parseInt(document.getElementById('perPage').value);

        const allRows = [...document.querySelectorAll('#tableBody tr[data-nama]')];

        const matched = allRows.filter(tr => {
            const namaOk          = tr.dataset.nama.includes(q);
            const statusOk        = !status       || tr.dataset.status === status;
            const klasifikasiOk   = !klasifikasi  || tr.dataset.klasifikasi === klasifikasi;
            return namaOk && statusOk && klasifikasiOk;
        });

        const total   = allRows.length;
        const found   = matched.length;
        const totalPg = Math.max(1, Math.ceil(found / perPage));

        if (currentPage > totalPg) currentPage = totalPg;

        const startIdx = (currentPage - 1) * perPage;
        const endIdx   = startIdx + perPage;

        let noCounter = startIdx + 1;
        allRows.forEach(tr => { tr.style.display = 'none'; });

        matched.forEach((tr, i) => {
            if (i >= startIdx && i < endIdx) {
                tr.style.display = '';
                const noCell = tr.querySelector('.no-cell');
                if (noCell) noCell.textContent = noCounter++;
            }
        });

        const showStart = found === 0 ? 0 : startIdx + 1;
        const showEnd   = Math.min(endIdx, found);
        let infoText = `Menampilkan ${showStart}–${showEnd} dari ${found} entri`;
        if (found < total) infoText += ` (difilter dari ${total} total entri)`;
        document.getElementById('infoText').textContent = infoText;

        renderPagination(totalPg);
        syncCheckAll();
    }

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

        wrap.appendChild(mkBtn('‹ Sebelumnya', currentPage - 1, false, currentPage === 1));

        const range = [];
        for (let p = 1; p <= totalPg; p++) {
            if (p === 1 || p === totalPg || (p >= currentPage - 2 && p <= currentPage + 2)) {
                range.push(p);
            }
        }
        let prev = null;
        range.forEach(p => {
            if (prev !== null && p - prev > 1) {
                const dots = document.createElement('button');
                dots.className = 'page-btn';
                dots.disabled  = true;
                dots.textContent = '…';
                wrap.appendChild(dots);
            }
            wrap.appendChild(mkBtn(p, p, p === currentPage, false));
            prev = p;
        });

        wrap.appendChild(mkBtn('Berikutnya ›', currentPage + 1, false, currentPage === totalPg));
    }

    // ═══════════════════════════════════════════════════
    // CHECKBOX
    // ═══════════════════════════════════════════════════
    function toggleAll(master) {
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
        if (master) {
            master.indeterminate = checkedCount > 0 && checkedCount < visibleCbs.length;
            master.checked       = visibleCbs.length > 0 && checkedCount === visibleCbs.length;
        }
    }

    // ═══════════════════════════════════════════════════
    // HAPUS TERPILIH
    // ═══════════════════════════════════════════════════
    async function hapusTerpilih() {
        const checkboxes = document.querySelectorAll('.row-check:checked');
        const ids = [...checkboxes].map(c => c.value);
        if (!ids.length) {
            showToast('Pilih minimal satu template terlebih dahulu', '⚠️');
            return;
        }

        if (confirm(`Yakin ingin menghapus ${ids.length} template terpilih?`)) {
            const csrfToken = "{{ csrf_token() }}";
            const baseUrl   = "{{ url('admin/layanan-surat/template-surat') }}";
            let successCount = 0;

            document.body.style.cursor = 'wait';

            for (const id of ids) {
                try {
                    const response = await fetch(`${baseUrl}/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    });
                    if (response.ok) successCount++;
                } catch (e) { console.error(e); }
            }

            document.body.style.cursor = 'default';
            showToast(`${successCount} template dihapus`, '🗑️');
            setTimeout(() => window.location.reload(), 1000);
        }
    }

    // ═══════════════════════════════════════════════════
    // SALIN & TOAST
    // ═══════════════════════════════════════════════════
    function salin(judul) {
        navigator.clipboard.writeText(judul).catch(() => {
            const el = Object.assign(document.createElement('textarea'), { value: judul });
            document.body.appendChild(el); el.select();
            document.execCommand('copy'); document.body.removeChild(el);
        });
        showToast(`"${judul}" disalin`, '📋');
    }

    function showToast(msg, icon) {
        const el = document.getElementById('toast');
        document.getElementById('t-msg').textContent  = msg;
        document.getElementById('t-icon').textContent = icon || '✓';
        el.classList.add('show');
        clearTimeout(el._t);
        el._t = setTimeout(() => el.classList.remove('show'), 2600);
    }

    // ═══════════════════════════════════════════════════
    // INIT
    // ═══════════════════════════════════════════════════
    document.addEventListener('DOMContentLoaded', () => {

        // Event listeners filter
        document.getElementById('filterStatus')      .addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('filterKlasifikasi') .addEventListener('change', () => { currentPage = 1; applyFilters(); });
        document.getElementById('perPage')           .addEventListener('change', () => { currentPage = 1; applyFilters(); });

        // Isi dropdown filter klasifikasi secara dinamis dari data tabel
        const klasifikasiSelect = document.getElementById('filterKlasifikasi');
        const kodeSet           = new Map(); // Map<kode_lowercase, label_asli>

        document.querySelectorAll('#tableBody tr[data-klasifikasi]').forEach(tr => {
            const kode = tr.dataset.klasifikasi;
            if (kode && !kodeSet.has(kode)) {
                // Ambil label asli dari badge di kolom kode
                const badgeEl = tr.querySelector('.kode-badge');
                const label   = badgeEl ? badgeEl.textContent.trim() : kode.toUpperCase();
                kodeSet.set(kode, label);
            }
        });

        // Urutkan dan tambahkan ke dropdown
        [...kodeSet.entries()]
            .sort((a, b) => a[0].localeCompare(b[0]))
            .forEach(([value, label]) => {
                const opt       = document.createElement('option');
                opt.value       = value;
                opt.textContent = label;
                klasifikasiSelect.appendChild(opt);
            });

        applyFilters();
    });
</script>

@endsection