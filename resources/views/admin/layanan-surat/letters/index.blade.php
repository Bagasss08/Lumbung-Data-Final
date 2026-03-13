@extends('layouts.admin')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap');

    :root {
        --green-50: #f0fdf4;
        --green-100: #dcfce7;
        --green-200: #bbf7d0;
        --green-400: #4ade80;
        --green-500: #22c55e;
        --green-600: #16a34a;
        --green-700: #15803d;
        --green-800: #166534;
        --green-900: #14532d;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .surat-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 2rem;
        background: var(--gray-50);
        min-height: 100vh;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-header-left {
        display: flex;
        flex-direction: column;
        gap: .35rem;
    }

    .page-eyebrow {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--green-600);
    }

    .page-eyebrow span.dot {
        width: 6px;
        height: 6px;
        background: var(--green-500);
        border-radius: 50%;
        display: inline-block;
        animation: pulse-dot 2s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%      { opacity: .5; transform: scale(.7); }
    }

    .page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--gray-900);
        letter-spacing: -.02em;
        margin: 0;
    }

    .page-subtitle {
        font-size: .875rem;
        color: var(--gray-500);
        margin: 0;
    }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 14px;
        padding: 1.1rem 1.3rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: box-shadow .2s, transform .2s;
    }

    .stat-card:hover {
        box-shadow: 0 6px 20px rgba(22,163,74,.1);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon.green  { background: var(--green-100); color: var(--green-600); }
    .stat-icon.blue   { background: #dbeafe;          color: #2563eb; }
    .stat-icon.red    { background: #fee2e2;          color: #dc2626; }

    .stat-icon svg { width: 20px; height: 20px; }

    .stat-info p  { margin: 0; font-size: .72rem; color: var(--gray-500); font-weight: 500; }
    .stat-info h4 { margin: 0; font-size: 1.35rem; font-weight: 700; color: var(--gray-900); }

    /* ── Card ── */
    .surat-card {
        background: #fff;
        border: 1px solid var(--gray-200);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.04);
    }

    /* ── Card Toolbar ── */
    .card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .toolbar-icon {
        width: 38px;
        height: 38px;
        background: var(--green-100);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green-600);
    }

    .toolbar-icon svg { width: 18px; height: 18px; }

    .toolbar-title {
        font-size: .95rem;
        font-weight: 600;
        color: var(--gray-800);
        margin: 0;
    }

    .toolbar-desc {
        font-size: .775rem;
        color: var(--gray-400);
        margin: 0;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: .5rem;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: 10px;
        padding: .45rem .9rem;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-box:focus-within {
        border-color: var(--green-400);
        box-shadow: 0 0 0 3px rgba(74,222,128,.15);
    }

    .search-box svg { width: 15px; height: 15px; color: var(--gray-400); flex-shrink: 0; }

    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        font-size: .83rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--gray-700);
        width: 200px;
    }

    .search-box input::placeholder { color: var(--gray-400); }

    /* ── Table ── */
    .surat-table {
        width: 100%;
        border-collapse: collapse;
    }

    .surat-table thead tr {
        background: var(--gray-50);
    }

    .surat-table thead th {
        padding: .85rem 1.25rem;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--gray-500);
        border-bottom: 1px solid var(--gray-200);
        white-space: nowrap;
        text-align: left;
    }

    .surat-table thead th:first-child { border-radius: 0; padding-left: 1.5rem; }
    .surat-table thead th:last-child  { padding-right: 1.5rem; }

    .surat-table tbody tr {
        border-bottom: 1px solid var(--gray-100);
        transition: background .15s;
    }

    .surat-table tbody tr:last-child { border-bottom: none; }

    .surat-table tbody tr:hover { background: var(--green-50); }

    .surat-table tbody td {
        padding: 1rem 1.25rem;
        font-size: .875rem;
        color: var(--gray-700);
        vertical-align: middle;
    }

    .surat-table tbody td:first-child { padding-left: 1.5rem; }
    .surat-table tbody td:last-child  { padding-right: 1.5rem; }

    /* ── No Column ── */
    .no-cell {
        font-family: 'DM Mono', monospace;
        font-size: .78rem;
        color: var(--gray-400);
        font-weight: 500;
    }

    /* ── Judul Cell ── */
    .judul-cell {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .judul-icon {
        width: 36px;
        height: 36px;
        background: var(--green-50);
        border: 1px solid var(--green-200);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--green-600);
        flex-shrink: 0;
    }

    .judul-icon svg { width: 16px; height: 16px; }

    .judul-text { font-weight: 600; color: var(--gray-800); }

    /* ── Kode Badge ── */
    .kode-badge {
        font-family: 'DM Mono', monospace;
        font-size: .75rem;
        font-weight: 500;
        background: var(--gray-100);
        color: var(--gray-600);
        padding: .3rem .65rem;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: .04em;
    }

    /* ── Status Badge ── */
    .badge-aktif, .badge-nonaktif {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 600;
    }

    .badge-aktif {
        background: var(--green-100);
        color: var(--green-700);
        border: 1px solid var(--green-200);
    }

    .badge-nonaktif {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-aktif   .badge-dot { background: var(--green-500); }
    .badge-nonaktif .badge-dot { background: #ef4444; }

    /* ── Action Buttons ── */
    .btn-cetak {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .48rem 1rem;
        background: var(--green-600);
        color: #fff;
        border: none;
        border-radius: 9px;
        font-size: .8rem;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        text-decoration: none;
        transition: background .2s, transform .15s, box-shadow .2s;
    }

    .btn-cetak:hover {
        background: var(--green-700);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(22,163,74,.35);
        color: #fff;
        text-decoration: none;
    }

    .btn-cetak:active { transform: translateY(0); }

    .btn-cetak svg { width: 14px; height: 14px; }

    .btn-disabled {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .48rem 1rem;
        background: var(--gray-100);
        color: var(--gray-400);
        border: 1px solid var(--gray-200);
        border-radius: 9px;
        font-size: .8rem;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: not-allowed;
    }

    .btn-disabled svg { width: 14px; height: 14px; }

    /* ── Empty State ── */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        background: var(--green-50);
        border: 2px dashed var(--green-200);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        color: var(--green-400);
    }

    .empty-state-icon svg { width: 32px; height: 32px; }

    .empty-state h5 {
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: .4rem;
    }

    .empty-state p {
        font-size: .875rem;
        color: var(--gray-400);
        margin: 0;
    }

    /* ── Row enter animation ── */
    .surat-table tbody tr {
        animation: row-in .3s ease both;
    }

    .surat-table tbody tr:nth-child(1)  { animation-delay: .00s; }
    .surat-table tbody tr:nth-child(2)  { animation-delay: .04s; }
    .surat-table tbody tr:nth-child(3)  { animation-delay: .08s; }
    .surat-table tbody tr:nth-child(4)  { animation-delay: .12s; }
    .surat-table tbody tr:nth-child(5)  { animation-delay: .16s; }
    .surat-table tbody tr:nth-child(6)  { animation-delay: .20s; }
    .surat-table tbody tr:nth-child(7)  { animation-delay: .24s; }
    .surat-table tbody tr:nth-child(8)  { animation-delay: .28s; }
    .surat-table tbody tr:nth-child(9)  { animation-delay: .32s; }
    .surat-table tbody tr:nth-child(10) { animation-delay: .36s; }
    /* dan seterusnya ... */

    @keyframes row-in {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="surat-wrapper">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-eyebrow">
                <span class="dot"></span>
                Layanan Administrasi
            </div>
            <h1 class="page-title">Cetak Surat Warga</h1>
            <p class="page-subtitle">Pilih template untuk mulai mencetak surat resmi.</p>
        </div>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="stat-info">
                <p>Total Template</p>
                <h4>{{ $templates->count() }}</h4>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <p>Aktif</p>
                <h4>{{ $templates->where('status','aktif')->count() }}</h4>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-info">
                <p>Nonaktif</p>
                <h4>{{ $templates->where('status','!=','aktif')->count() }}</h4>
            </div>
        </div>
    </div>

    {{-- ── Main Card ── --}}
    <div class="surat-card">

        {{-- Toolbar --}}
        <div class="card-toolbar">
            <div class="toolbar-left">
                <div class="toolbar-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10"/></svg>
                </div>
                <div>
                    <p class="toolbar-title">Daftar Template</p>
                    <p class="toolbar-desc">{{ $templates->count() }} template tersedia</p>
                </div>
            </div>
            <div class="search-box">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Cari template...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table class="surat-table" id="suratTable">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Judul Surat</th>
                        <th style="width:16%">Kode Klasifikasi</th>
                        <th style="width:15%">Lampiran</th>
                        <th style="width:12%">Status</th>
                        <th style="width:16%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $index => $template)
                        <tr>
                            <td class="no-cell">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="judul-cell">
                                    <div class="judul-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <span class="judul-text">{{ $template->judul }}</span>
                                </div>
                            </td>
                            <td>
                                @if($template->kode_klasifikasi)
                                    <span class="kode-badge" title="{{ optional($template->klasifikasi)->nama_klasifikasi }}">
                                        {{ $template->kode_klasifikasi }}
                                    </span>
                                @else
                                    <span style="color:var(--gray-400);font-size:.8rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($template->lampiran)
                                    <span style="font-size: .85rem; color: var(--gray-600);">{{ $template->lampiran }}</span>
                                @else
                                    <span style="color:var(--gray-400);font-size:.8rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($template->status === 'aktif')
                                    <span class="badge-aktif"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @if($template->status === 'aktif')
                                    <a href="{{ route('admin.layanan-surat.cetak.create', ['id' => $template->id]) }}" class="btn-cetak">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        Cetak Surat
                                    </a>
                                @else
                                    <span class="btn-disabled">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <h5>Belum Ada Template</h5>
                                    <p>Template surat belum ditambahkan oleh administrator.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Live search
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#suratTable tbody tr').forEach(tr => {
            const text = tr.textContent.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    });
</script>
@endsection