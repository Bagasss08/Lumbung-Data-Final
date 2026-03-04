@extends('layouts.admin')

@section('title', 'Dokumen Persyaratan Surat')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@500&display=swap');

    * { box-sizing: border-box; }

    .ps-root {
        font-family: 'DM Sans', sans-serif;
        padding: 20px 24px;
        background: #f5f6fa;
        min-height: 100vh;
        font-size: 13.5px;
        color: #1a1d2e;
    }

    /* ── HEADER ── */
    .ps-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .ps-header-left h1 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1d2e;
        margin: 0 0 3px;
        letter-spacing: -0.3px;
    }

    .ps-breadcrumb {
        font-size: 0.78rem;
        color: #9399b2;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .ps-breadcrumb .sep { opacity: 0.5; }
    .ps-breadcrumb .current { color: #3b5bdb; font-weight: 600; }

    /* ── CARD ── */
    .ps-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e8eaf3;
        box-shadow: 0 1px 12px rgba(26,29,46,0.06);
        overflow: hidden;
    }

    /* ── TOOLBAR ── */
    .ps-toolbar {
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #e8eaf3;
        gap: 10px;
        flex-wrap: wrap;
        background: #fff;
    }

    .ps-toolbar-left { display: flex; gap: 8px; align-items: center; }
    .ps-toolbar-right { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        border-radius: 8px;
        padding: 7px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        line-height: 1;
    }

    .btn-add {
        background: #3b5bdb;
        color: #fff;
        box-shadow: 0 2px 8px rgba(59,91,219,0.25);
    }
    .btn-add:hover { background: #2f4ac7; color: #fff; transform: translateY(-1px); }

    .btn-delete-bulk {
        background: #fff0f0;
        color: #e03131;
        border: 1px solid #ffc9c9;
    }
    .btn-delete-bulk:hover { background: #ffe3e3; color: #e03131; }

    /* Search */
    .ps-search {
        position: relative;
    }

    .ps-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        pointer-events: none;
    }

    .ps-search input {
        border: 1px solid #e2e5f0;
        border-radius: 8px;
        padding: 7px 12px 7px 32px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        color: #1a1d2e;
        outline: none;
        width: 210px;
        background: #f8f9fc;
        transition: border-color 0.15s, background 0.15s;
    }

    .ps-search input:focus {
        border-color: #3b5bdb;
        background: #fff;
    }

    .ps-search input::placeholder { color: #c1c6d6; }

    /* Entries */
    .entries-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: #6b7280;
        font-weight: 500;
    }

    .entries-wrap select {
        border: 1px solid #e2e5f0;
        border-radius: 7px;
        padding: 6px 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.82rem;
        color: #1a1d2e;
        background: #f8f9fc;
        outline: none;
        cursor: pointer;
        font-weight: 600;
    }

    /* ── TABLE ── */
    .ps-table-wrap { overflow-x: auto; }

    table.ps-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }

    .ps-table thead th {
        padding: 10px 16px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #6b7aab;
        background: #f8f9fc;
        border-bottom: 1px solid #e8eaf3;
        white-space: nowrap;
    }

    .ps-table thead th:first-child { padding-left: 18px; }

    .ps-table tbody tr {
        border-bottom: 1px solid #f0f1f8;
        transition: background 0.12s;
    }

    .ps-table tbody tr:last-child { border-bottom: none; }
    .ps-table tbody tr:hover { background: #f8f9fd; }

    .ps-table tbody td {
        padding: 11px 16px;
        vertical-align: middle;
        color: #2d3148;
    }

    .ps-table tbody td:first-child { padding-left: 18px; }

    /* Checkbox */
    .col-check { width: 44px; text-align: center; }
    .col-no { width: 54px; text-align: center; }
    .col-aksi { width: 110px; text-align: center; white-space: nowrap; }

    input[type="checkbox"].custom-check {
        width: 15px;
        height: 15px;
        accent-color: #3b5bdb;
        cursor: pointer;
    }

    /* Row number */
    .no-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        background: #eef0fb;
        color: #3b5bdb;
        border-radius: 6px;
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Doc name */
    .doc-name {
        font-weight: 500;
        color: #1a1d2e;
        font-size: 0.86rem;
    }

    /* Action buttons */
    .btn-edit-sm {
        background: #fff8e6;
        color: #f59f00;
        border: 1px solid #ffe8a3;
        border-radius: 7px;
        padding: 5px 10px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.14s;
    }
    .btn-edit-sm:hover { background: #fff3cc; color: #f59f00; transform: translateY(-1px); }

    .btn-hapus-sm {
        background: #fff0f0;
        color: #e03131;
        border: 1px solid #ffc9c9;
        border-radius: 7px;
        padding: 5px 10px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.14s;
    }
    .btn-hapus-sm:hover { background: #ffe3e3; transform: translateY(-1px); }

    /* Empty */
    .ps-empty {
        text-align: center;
        padding: 48px 20px;
        color: #9399b2;
    }
    .ps-empty svg { opacity: 0.3; margin-bottom: 10px; }
    .ps-empty p { font-size: 0.88rem; font-weight: 500; margin: 0; }

    /* Footer */
    .ps-footer {
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #e8eaf3;
        background: #fafbfe;
        flex-wrap: wrap;
        gap: 10px;
    }

    .entry-info {
        font-size: 0.79rem;
        color: #8890aa;
        font-weight: 500;
    }

    .entry-info strong { color: #3b5bdb; font-weight: 700; }

    .pag-wrap { display: flex; gap: 4px; }

    .pag-btn {
        background: #fff;
        border: 1px solid #e2e5f0;
        color: #4a5080;
        border-radius: 7px;
        padding: 6px 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.79rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.14s;
        line-height: 1;
    }

    .pag-btn:hover, .pag-btn.active {
        background: #3b5bdb;
        border-color: #3b5bdb;
        color: #fff;
    }

    .pag-btn.disabled { opacity: 0.35; pointer-events: none; }

    /* Fade-in rows */
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .ps-table tbody tr { animation: rowIn 0.22s ease both; }
    .ps-table tbody tr:nth-child(1)  { animation-delay: 0.00s; }
    .ps-table tbody tr:nth-child(2)  { animation-delay: 0.03s; }
    .ps-table tbody tr:nth-child(3)  { animation-delay: 0.06s; }
    .ps-table tbody tr:nth-child(4)  { animation-delay: 0.09s; }
    .ps-table tbody tr:nth-child(5)  { animation-delay: 0.12s; }
    .ps-table tbody tr:nth-child(6)  { animation-delay: 0.15s; }
    .ps-table tbody tr:nth-child(7)  { animation-delay: 0.18s; }
    .ps-table tbody tr:nth-child(8)  { animation-delay: 0.21s; }
    .ps-table tbody tr:nth-child(9)  { animation-delay: 0.24s; }
    .ps-table tbody tr:nth-child(10) { animation-delay: 0.27s; }
</style>

<div class="ps-root">

    {{-- Header --}}
    <div class="ps-header">
        <div class="ps-header-left">
            <h1>Dokumen Persyaratan Surat</h1>
            <div class="ps-breadcrumb">
                <span>Beranda</span>
                <span class="sep">›</span>
                <span class="current">Dokumen Persyaratan Surat</span>
            </div>
        </div>
    </div>

    {{-- Card --}}
    <div class="ps-card">

        {{-- Toolbar --}}
        <div class="ps-toolbar">
            <div class="ps-toolbar-left">
                <a href="{{ route('admin.layanan-surat.persyaratan.create') }}" class="btn btn-add">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah
                </a>
                <a href="#" class="btn btn-delete-bulk" onclick="hapusTerpilih(event)">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus Terpilih
                </a>
            </div>
            <div class="ps-toolbar-right">
                <div class="entries-wrap">
                    <span>Tampilkan</span>
                    <select id="entri" onchange="ubahEntri(this.value)">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entri</span>
                </div>
                <div class="ps-search">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchInput" placeholder="Cari dokumen..." oninput="cariDokumen(this.value)">
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="ps-table-wrap">
            <table class="ps-table" id="tabelPersyaratan">
                <thead>
                    <tr>
                        <th class="col-check">
                            <input type="checkbox" class="custom-check" id="checkAll" onclick="toggleSemuaCheck(this)">
                        </th>
                        <th class="col-no">No</th>
                        <th class="col-aksi">Aksi</th>
                        <th>Nama Dokumen</th>
                    </tr>
                </thead>
                <tbody id="tabelBody">
                    @forelse ($persyaratan as $item)
                    <tr data-nama="{{ strtolower($item->nama) }}">
                        <td class="col-check">
                            <input type="checkbox" class="custom-check row-check" value="{{ $item->id }}">
                        </td>
                        <td class="col-no">
                            <span class="no-badge">{{ $loop->iteration }}</span>
                        </td>
                        <td class="col-aksi">
                            <a href="{{ route('admin.layanan-surat.persyaratan.edit', $item->id) }}" class="btn-edit-sm">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.layanan-surat.persyaratan.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus-sm">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M9 6V4h6v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="doc-name">{{ $item->nama }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="ps-empty">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#9399b2" stroke-width="1.5" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <p>Belum ada data persyaratan surat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="ps-footer">
            <div class="entry-info" id="entryInfo">
                Menampilkan <strong>1</strong>–<strong>{{ $persyaratan->count() }}</strong>
                dari <strong>{{ $persyaratan->count() }}</strong> entri
            </div>
            <div class="pag-wrap">
                <a href="#" class="pag-btn disabled">← Prev</a>
                <a href="#" class="pag-btn active">1</a>
                <a href="#" class="pag-btn disabled">Next →</a>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleSemuaCheck(master) {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = master.checked);
    }

    function cariDokumen(keyword) {
        const kw = keyword.toLowerCase().trim();
        document.querySelectorAll('#tabelBody tr[data-nama]').forEach(row => {
            row.style.display = (row.getAttribute('data-nama') || '').includes(kw) ? '' : 'none';
        });
    }

    function hapusTerpilih(e) {
        e.preventDefault();
        const checked = document.querySelectorAll('.row-check:checked');
        if (checked.length === 0) {
            alert('Pilih minimal satu dokumen yang ingin dihapus!');
            return;
        }
        if (confirm('Yakin ingin menghapus ' + checked.length + ' dokumen terpilih?')) {
            alert('Fitur hapus massal dapat dihubungkan ke route masing-masing.');
        }
    }

    function ubahEntri(val) {
        console.log('Tampilkan', val, 'entri');
    }
</script>

@endsection