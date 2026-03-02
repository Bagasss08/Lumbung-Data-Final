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
        --info: #3b82f6;
        --info-soft: #eff6ff;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.07), 0 1px 4px rgba(0,0,0,0.04);
        --shadow-lg: 0 10px 40px rgba(0,0,0,0.09);
        --radius: 14px;
        --radius-sm: 8px;
    }

    * { box-sizing: border-box; }

    body {
        background: var(--bg-base);
        font-family: 'Sora', sans-serif;
        color: var(--text-primary);
    }

    /* ===== Page Wrapper ===== */
    .arsip-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 36px 24px 60px;
        animation: pageIn 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes pageIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== Page Header ===== */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-header-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .page-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--accent);
        display: flex;
        align-items: center;
        gap: 6px;
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
        font-size: 26px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
        margin: 0;
    }

    .page-subtitle {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 2px 0 0;
    }

    /* ===== Stats Bar ===== */
    .stats-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-chip {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-sm);
    }

    .stat-chip .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--accent);
    }

    .stat-chip strong {
        color: var(--text-primary);
    }

    /* ===== Alerts ===== */
    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 16px;
        border: 1px solid;
        animation: alertIn 0.3s ease;
    }

    @keyframes alertIn {
        from { opacity: 0; transform: translateX(-6px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .alert-success {
        background: var(--success-soft);
        border-color: #a7f3d0;
        color: #065f46;
    }

    .alert-error {
        background: var(--danger-soft);
        border-color: #fecdd3;
        color: #9f1239;
    }

    /* ===== Card ===== */
    .card {
        background: var(--surface);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    /* ===== Table Wrapper ===== */
    .table-wrapper {
        overflow-x: auto;
    }

    /* ===== Table ===== */
    .arsip-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .arsip-table thead {
        border-bottom: 1px solid var(--border);
    }

    .arsip-table thead th {
        background: var(--surface-2);
        padding: 13px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        white-space: nowrap;
    }

    .arsip-table thead th:first-child { border-radius: 0; }
    .arsip-table thead th.center { text-align: center; }

    .arsip-table tbody tr {
        border-bottom: 1px solid var(--border-light);
        transition: background 0.15s ease;
    }

    .arsip-table tbody tr:last-child { border-bottom: none; }

    .arsip-table tbody tr:hover {
        background: #fafbff;
    }

    .arsip-table td {
        padding: 15px 20px;
        vertical-align: middle;
        color: var(--text-primary);
    }

    /* Row number */
    .row-number {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        background: var(--bg-base);
        border-radius: 6px;
        padding: 3px 9px;
        display: inline-block;
        font-family: 'JetBrains Mono', monospace;
    }

    /* Nomor surat badge */
    .badge-nomor {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--accent-soft);
        color: var(--accent);
        border: 1px solid #d4d9ff;
        padding: 5px 12px;
        border-radius: 7px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Jenis surat */
    .jenis-label {
        display: inline-block;
        font-weight: 500;
        color: var(--text-primary);
    }

    /* Tanggal */
    .tanggal-wrap {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .tanggal-main {
        font-weight: 500;
        color: var(--text-primary);
        font-family: 'JetBrains Mono', monospace;
        font-size: 13px;
    }

    /* ===== Action Buttons ===== */
    .action-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        flex-wrap: nowrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
        white-space: nowrap;
        font-family: 'Sora', sans-serif;
        letter-spacing: 0.2px;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .btn:active {
        transform: translateY(0);
        box-shadow: none;
        filter: brightness(0.95);
    }

    .btn-detail {
        background: var(--info-soft);
        color: var(--info);
        border: 1px solid #bfdbfe;
    }

    .btn-detail:hover { background: #dbeafe; }

    .btn-download {
        background: var(--success-soft);
        color: var(--success);
        border: 1px solid #a7f3d0;
    }

    .btn-download:hover { background: #d1fae5; }

    .btn-delete {
        background: var(--danger-soft);
        color: var(--danger);
        border: 1px solid #fecdd3;
    }

    .btn-delete:hover { background: #ffe4e9; }

    /* ===== Empty State ===== */
    .empty-state {
        padding: 70px 24px;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        background: var(--surface-2);
        border: 1.5px dashed var(--border);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
    }

    .empty-state h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-secondary);
        margin: 0 0 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0;
    }

    /* ===== Pagination ===== */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-top: 1px solid var(--border-light);
        background: var(--surface-2);
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-info {
        font-size: 12.5px;
        color: var(--text-muted);
    }

    /* Override Laravel pagination */
    .pagination-wrap nav > div:first-child { display: none; }

    /* ===== Row animation ===== */
    .arsip-table tbody tr {
        animation: rowIn 0.35s ease both;
    }

    @for($i = 0; $i < 15; $i++)
    .arsip-table tbody tr:nth-child({{ $i + 1 }}) {
        animation-delay: {{ $i * 0.04 }}s;
    }
    @endfor

    @keyframes rowIn {
        from { opacity: 0; transform: translateX(-8px); }
        to   { opacity: 1; transform: translateX(0); }
    }
</style>

<div class="arsip-page">

    {{-- Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <span class="page-eyebrow">Sistem Kearsipan</span>
            <h1 class="page-title">Arsip Surat</h1>
            <p class="page-subtitle">Kelola seluruh arsip surat yang telah diterbitkan</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-bar">
        <div class="stat-chip">
            <span class="dot"></span>
            Total: <strong>{{ $arsip->total() }} arsip</strong>
        </div>
        <div class="stat-chip">
            <span class="dot" style="background:#10b981"></span>
            Halaman {{ $arsip->currentPage() }} / {{ $arsip->lastPage() }}
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Main Card --}}
    <div class="card">
        <div class="table-wrapper">
            <table class="arsip-table">

                <thead>
                    <tr>
                        <th style="width:52px">#</th>
                        <th>Nomor Surat</th>
                        <th>Jenis Surat</th>
                        <th>Tanggal</th>
                        <th class="center" style="width:260px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($arsip as $key => $item)
                    <tr>
                        <td>
                            <span class="row-number">{{ $arsip->firstItem() + $key }}</span>
                        </td>

                        <td>
                            <span class="badge-nomor">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                {{ $item->nomor_surat }}
                            </span>
                        </td>

                        <td>
                            <span class="jenis-label">{{ $item->jenis_surat }}</span>
                        </td>

                        <td>
                            <div class="tanggal-wrap">
                                <span class="tanggal-main">
                                    {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="action-group">

                                {{-- Detail --}}
                                <a href="{{ route('arsip.show', $item->id) }}" class="btn btn-detail">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    Detail
                                </a>

                                {{-- Download --}}
                                <a href="{{ route('arsip.download', $item->id) }}" class="btn btn-download">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    Unduh
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('arsip.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus arsip ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <h3>Belum ada arsip</h3>
                                <p>Arsip surat yang diterbitkan akan tampil di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        @if($arsip->hasPages())
        <div class="pagination-wrap">
            <span class="pagination-info">
                Menampilkan {{ $arsip->firstItem() }}–{{ $arsip->lastItem() }} dari {{ $arsip->total() }} arsip
            </span>
            <div>
                {{ $arsip->links() }}
            </div>
        </div>
        @endif

    </div>

</div>

@endsection