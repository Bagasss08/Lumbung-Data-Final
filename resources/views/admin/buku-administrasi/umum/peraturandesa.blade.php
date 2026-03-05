@extends('layouts.admin')
@section('content')

<style>
    /* Modern Premium Color Palette */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --secondary: #8b5cf6;
        --success: #10b981;
        --success-light: #34d399;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #06b6d4;
        --dark: #1e293b;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-attachment: fixed;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
        min-height: 100vh;
    }

    .container-fluid {
        padding: 2rem !important;
        max-width: 100%;
        margin: 0 auto;
    }

    /* Glass Morphism Card */
    .premium-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 2rem;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Premium Header with Gradient */
    .premium-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .premium-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .premium-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .header-title h4 {
        color: white;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .header-title p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        margin: 0.25rem 0 0 0;
    }

    .header-stats {
        display: flex;
        gap: 1.5rem;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        display: block;
    }

    .stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Premium Action Bar */
    .action-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 1.5rem 2.5rem;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid var(--gray-200);
    }

    /* Premium Buttons */
    .btn {
        border-radius: 12px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        padding: 12px 24px !important;
        border: none !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2) !important;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
    }

    .btn-dark {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(30, 41, 59, 0.4) !important;
    }

    /* Filter Section with Glass Effect */
    .filter-section {
        background: rgba(248, 250, 252, 0.8);
        backdrop-filter: blur(10px);
        padding: 1.5rem 2.5rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .filter-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: block;
    }

    /* Premium Form Controls */
    .form-select,
    .form-control {
        border: 2px solid var(--gray-200) !important;
        border-radius: 10px !important;
        padding: 10px 16px !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        background: white !important;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        outline: none !important;
        transform: translateY(-1px);
    }

    /* Table Section - Separate Card */
    .table-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        animation-delay: 0.1s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    /* Table Controls */
    .table-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid var(--gray-200);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .entries-control,
    .search-control {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        color: var(--gray-700);
    }

    .search-control {
        position: relative;
    }

    .search-control input {
        width: 320px;
        padding-left: 40px !important;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        pointer-events: none;
    }

    /* Premium Table */
    .table-wrapper {
        overflow-x: auto;
        background: white;
        padding: 1.5rem 2rem;
    }

    .table {
        margin: 0 !important;
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 10px !important;
    }

    .table thead {
        background: transparent !important;
    }

    .table thead th {
        color: var(--gray-600) !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 16px !important;
        border: none !important;
        white-space: nowrap !important;
        background: transparent !important;
    }

    .table tbody tr {
        background: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
    }

    .table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15) !important;
        background: linear-gradient(to right, #f8fafc 0%, #ffffff 100%) !important;
    }

    .table tbody td {
        padding: 20px 16px !important;
        font-size: 14px !important;
        color: var(--gray-700) !important;
        vertical-align: middle !important;
        border: none !important;
    }

    .table tbody td:first-child {
        border-radius: 12px 0 0 12px;
    }

    .table tbody td:last-child {
        border-radius: 0 12px 12px 0;
    }

    /* Premium Checkbox */
    input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary);
        border-radius: 6px;
    }

    /* Premium Badge */
    .badge {
        padding: 8px 14px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
        color: #065f46 !important;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .badge-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%) !important;
        color: #991b1b !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
    }

    /* Sort Icon */
    .sort-icon {
        display: inline-block;
        margin-left: 6px;
        opacity: 0.3;
        transition: all 0.3s;
        cursor: pointer;
    }

    th:hover .sort-icon {
        opacity: 1;
        color: var(--primary);
        transform: translateY(-2px);
    }

    /* Premium Action Buttons */
    .btn-action {
        width: 36px !important;
        height: 36px !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 10px !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.4s, height 0.4s;
    }

    .btn-action:hover::before {
        width: 100px;
        height: 100px;
    }

    .btn-action.btn-info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
    }

    .btn-action.btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: white !important;
    }

    .btn-action.btn-secondary {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;
        color: white !important;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    .empty-state-icon i {
        font-size: 48px;
        color: var(--gray-400);
    }

    .empty-state h5 {
        font-size: 20px;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--gray-500);
        margin: 0;
    }

    /* Premium Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 2rem;
        background: linear-gradient(to top, #ffffff 0%, #f8fafc 100%);
        border-top: 1px solid var(--gray-200);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        font-size: 14px;
        font-weight: 500;
        color: var(--gray-600);
    }

    .pagination {
        display: flex;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .page-item {
        list-style: none;
    }

    .page-link {
        border: 2px solid transparent !important;
        border-radius: 10px !important;
        color: var(--gray-700) !important;
        padding: 8px 14px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        min-width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        background: white !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-link:hover {
        background: var(--gray-50) !important;
        border-color: var(--primary) !important;
        color: var(--primary) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2) !important;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        border-color: transparent !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Tooltip */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
    }

    [data-tooltip]::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(-8px);
        padding: 6px 12px;
        background: var(--gray-900);
        color: white;
        font-size: 12px;
        font-weight: 500;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s;
        z-index: 1000;
    }

    [data-tooltip]:hover::after {
        opacity: 1;
        transform: translateX(-50%) translateY(-4px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .header-stats {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem !important;
        }

        .premium-header {
            padding: 1.5rem;
        }

        .header-title h4 {
            font-size: 1.25rem;
        }

        .action-bar,
        .filter-section,
        .table-controls {
            padding: 1rem !important;
        }

        .search-control input {
            width: 100%;
        }

        .table-wrapper {
            padding: 1rem;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .table {
            min-width: 1000px;
        }
    }

    /* Smooth Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-100);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary) 100%);
    }
</style>

<div class="container-fluid">
    
    <!-- Header Card -->
    <div class="premium-card">
        <!-- Premium Header -->
        <div class="premium-header">
            <div class="premium-header-content">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div>
                        <h4>Buku Peraturan di Desa</h4>
                        <p>Kelola dan pantau peraturan desa dengan mudah</p>
                    </div>
                </div>
                <div class="header-stats">
                    <div class="stat-item">
                        <span class="stat-number">{{ $data_peraturan->total() }}</span>
                        <span class="stat-label">Total Data</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $data_peraturan->where('is_aktif', 1)->count() }}</span>
                        <span class="stat-label">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-bar">
            <button class="btn btn-success" onclick="window.location='{{ route('admin.buku-administrasi.umum.peraturan-desa.create') }}'">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Data</span>
            </button>
            <button class="btn btn-danger" onclick="deleteSelected()">
                <i class="fas fa-trash-alt"></i>
                <span>Hapus Terpilih</span>
            </button>
            <button class="btn btn-primary" onclick="printData()">
                <i class="fas fa-print"></i>
                <span>Cetak</span>
            </button>
            <button class="btn btn-dark" onclick="downloadData()">
                <i class="fas fa-download"></i>
                <span>Export Excel</span>
            </button>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="filter-section">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="filter-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>✓ Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>✗ Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="filter-label">Jenis Peraturan</label>
                    <select name="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="Peraturan Desa" {{ request('jenis') == 'Peraturan Desa' ? 'selected' : '' }}>📜 Peraturan Desa</option>
                        <option value="Peraturan Kepala Desa" {{ request('jenis') == 'Peraturan Kepala Desa' ? 'selected' : '' }}>📋 Peraturan Kepala Desa</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Tahun</label>
                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    @if(request()->hasAny(['status', 'jenis', 'tahun']))
                        <label class="filter-label">&nbsp;</label>
                        <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="btn btn-secondary w-100" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%) !important;">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card (Separate & Full Width) -->
    <div class="table-card">
        <!-- Table Controls -->
        <div class="table-controls">
            <div class="entries-control">
                <span>Tampilkan</span>
                <select class="form-select" style="width: 80px;" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>entri</span>
            </div>
            <div class="search-control">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control" placeholder="Cari peraturan..." id="searchInput" value="{{ request('search') }}">
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th style="width: 60px;">No</th>
                        <th style="width: 120px;">Aksi</th>
                        <th style="min-width: 300px;">
                            Judul
                            <i class="fas fa-sort sort-icon"></i>
                        </th>
                        <th style="min-width: 180px;">Jenis Peraturan</th>
                        <th style="min-width: 220px;">
                            No./Tgl Ditetapkan
                            <i class="fas fa-sort sort-icon"></i>
                        </th>
                        <th style="min-width: 280px;">Uraian Singkat</th>
                        <th class="text-center" style="width: 120px;">
                            Status
                            <i class="fas fa-sort sort-icon"></i>
                        </th>
                        <th style="min-width: 150px;">
                            Dimuat Pada
                            <i class="fas fa-sort sort-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_peraturan as $index => $item)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="row-checkbox">
                        </td>
                        <td class="text-center" style="font-weight: 700; color: var(--primary);">
                            {{ $data_peraturan->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-action btn-info" 
                                        data-tooltip="Edit" 
                                        onclick="window.location='{{ route('admin.buku-administrasi.umum.peraturan-desa.edit', $item->id) }}'">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-action btn-danger" 
                                        data-tooltip="Hapus" 
                                        onclick="deleteItem({{ $item->id }}, '{{ addslashes($item->judul) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn btn-action btn-secondary" 
                                        data-tooltip="Detail" 
                                        onclick="viewItem({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--gray-800); line-height: 1.5;">
                                {{ $item->judul }}
                            </div>
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: var(--gray-100); border-radius: 8px; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-file-alt" style="color: var(--primary);"></i>
                                {{ $item->jenis_peraturan }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: var(--gray-800);">{{ $item->nomor_ditetapkan }}</div>
                            <small style="color: var(--gray-500); display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $item->tanggal_ditetapkan ? $item->tanggal_ditetapkan->format('d M Y') : '-' }}
                            </small>
                        </td>
                        <td>
                            <div style="line-height: 1.6; color: var(--gray-600);">
                                {{ Str::limit($item->uraian_singkat, 70) }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->is_aktif ? 'badge-success' : 'badge-danger' }}">
                                <i class="fas {{ $item->is_aktif ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $item->is_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <span style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: var(--gray-600);">
                                <i class="fas fa-calendar-check" style="color: var(--info);"></i>
                                {{ $item->dimuat_pada ? $item->dimuat_pada->format('d M Y') : '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h5>Belum Ada Data</h5>
                                <p>Klik tombol "Tambah Data" untuk menambahkan peraturan desa baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                @if($data_peraturan->total() > 0)
                    Menampilkan <strong>{{ $data_peraturan->firstItem() }}</strong> 
                    sampai <strong>{{ $data_peraturan->lastItem() }}</strong> 
                    dari <strong>{{ $data_peraturan->total() }}</strong> entri
                @else
                    Tidak ada data untuk ditampilkan
                @endif
            </div>
            <div>
                {{ $data_peraturan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Search functionality with debounce
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const url = new URL(window.location.href);
                if (this.value) {
                    url.searchParams.set('search', this.value);
                } else {
                    url.searchParams.delete('search');
                }
                window.location.href = url.toString();
            }, 800);
        });
    }
});

// Change entries per page
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
}

// Delete single item with confirmation
function deleteItem(id, title) {
    if (confirm(`Apakah Anda yakin ingin menghapus peraturan:\n"${title}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.buku-administrasi.umum.peraturan-desa.index") }}/' + id;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Delete selected items
function deleteSelected() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('⚠️ Pilih setidaknya satu data untuk dihapus');
        return;
    }
    
    if (confirm(`🗑️ Apakah Anda yakin ingin menghapus ${checkedBoxes.length} data yang dipilih?`)) {
        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        console.log('Delete IDs:', ids);
        // Implement bulk delete logic here
        alert('Fitur bulk delete akan segera hadir!');
    }
}

// View item detail
function viewItem(id) {
    window.location.href = '{{ route("admin.buku-administrasi.umum.peraturan-desa.index") }}/' + id;
}

// Print data
function printData() {
    window.print();
}

// Download data as Excel
function downloadData() {
    window.location.href = '{{ route("admin.buku-administrasi.umum.peraturan-desa.index") }}?export=excel';
}
</script>

@endsection