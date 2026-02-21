@extends('layouts.admin')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --primary-light: #d1fae5;
        --secondary: #06b6d4;
        --danger: #ef4444;
        --warning: #f59e0b;
        --success: #10b981;
        --dark: #1f2937;
        --light: #f3f4f6;
    }

    * {
        font-family: 'Poppins', sans-serif;
    }

    .gradient-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-secondary {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .gradient-warm {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border: 1px solid #e5e7eb;
    }

    .stat-card:hover {
        border-color: #10b981;
    }

    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        border-radius: 12px;
        font-size: 24px;
    }

    .badge-live {
        animation: pulse-live 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse-live {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
        border-radius: 2px;
    }

    .quick-action-btn {
        padding: 16px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        background: white;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .quick-action-btn:hover {
        border-color: #10b981;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        transform: translateY(-4px);
    }

    .quick-action-btn svg {
        color: #374151;
        stroke-width: 1.5px;
    }

    .quick-action-btn:hover svg {
        color: #10b981;
    }

    .quick-action-btn .label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .quick-action-btn .desc {
        font-size: 11px;
        color: #9ca3af;
    }

    .activity-item {
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-dot {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-top: 7px;
        flex-shrink: 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .info-value {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge-active {
        background: #d1fae5;
        color: #047857;
    }

    .status-badge-update {
        background: #dbeafe;
        color: #1e40af;
    }

    .gradient-box {
        border-radius: 16px;
        overflow: hidden;
    }
</style>

<!-- PAGE HEADER -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h1 class="text-4xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-slate-600 mt-2 font-light">Selamat datang kembali, Administrator</p>
        </div>
        <div class="flex items-center gap-3">
            <div
                class="px-4 py-2 rounded-full bg-gradient-to-r from-emerald-100 to-emerald-50 text-emerald-700 font-semibold text-sm flex items-center gap-2 border border-emerald-200">
                <span class="inline-block w-2.5 h-2.5 bg-emerald-500 rounded-full badge-live"></span>
                Sistem Aktif
            </div>
            <div class="px-4 py-2 rounded-full bg-blue-50 text-blue-700 font-semibold text-sm border border-blue-200">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>
</div>

<!-- STATS GRID - ROW 1 -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Penduduk -->
    <a href="/admin/penduduk" class="stat-card card-hover rounded-xl p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-slate-600">Total Penduduk</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($pendudukCount ?? 0) }}</h3>
            </div>
            <div
                class="icon-box bg-gradient-to-br from-sky-100 to-sky-50 text-sky-600 group-hover:from-sky-200 group-hover:to-sky-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a8 8 0 00-8 8v2h16v-2a8 8 0 00-8-8z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="text-emerald-600 font-semibold">→</span>
            Lihat detail
        </div>
    </a>

    <!-- Total Keluarga -->
    <a href="/admin/keluarga" class="stat-card card-hover rounded-xl p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-slate-600">Total Keluarga</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($keluargaCount ?? 0) }}</h3>
            </div>
            <div
                class="icon-box bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 group-hover:from-emerald-200 group-hover:to-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l-4-4m0 0l-2-2m2 2l2-2m-2 2l4 4m0 0l2 2m-2-2l-2 2">
                    </path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="text-emerald-600 font-semibold">→</span>
            Lihat detail
        </div>
    </a>

    <!-- Rumah Tangga -->
    <a href="/admin/rumah-tangga" class="stat-card card-hover rounded-xl p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-slate-600">Rumah Tangga</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($rumahTanggaCount ?? 0) }}</h3>
            </div>
            <div
                class="icon-box bg-gradient-to-br from-amber-100 to-amber-50 text-amber-600 group-hover:from-amber-200 group-hover:to-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2 6a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="text-emerald-600 font-semibold">→</span>
            Lihat detail
        </div>
    </a>

    <!-- Surat Tercetak -->
    <a href="/admin/layanan-surat/cetak" class="stat-card card-hover rounded-xl p-6 group">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-slate-600">Surat Tercetak</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($suratCount ?? 0) }}</h3>
            </div>
            <div
                class="icon-box bg-gradient-to-br from-violet-100 to-violet-50 text-violet-600 group-hover:from-violet-200 group-hover:to-violet-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="text-emerald-600 font-semibold">→</span>
            Lihat detail
        </div>
    </a>

</div>

<!-- MAIN CONTENT GRID -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

    <!-- LEFT COLUMN - Statistics & Charts -->
    <div class="lg:col-span-2 space-y-8">

        <!-- Statistik Penduduk Card -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h3 class="section-title">Statistik Penduduk</h3>
                <span class="status-badge status-badge-active">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full badge-live"></span>
                    Live
                </span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div class="info-row flex-col !border-none">
                    <span class="info-label">Total Penduduk</span>
                    <span class="info-value text-emerald-600 mt-1">{{ number_format($pendudukCount ?? 0) }}</span>
                </div>
                <div class="info-row flex-col !border-none">
                    <span class="info-label">Total Keluarga</span>
                    <span class="info-value text-emerald-600 mt-1">{{ number_format($keluargaCount ?? 0) }}</span>
                </div>
                <div class="info-row flex-col !border-none">
                    <span class="info-label">Rata-rata Jiwa/KK</span>
                    <span class="info-value text-emerald-600 mt-1">{{ $keluargaCount > 0 ? number_format($pendudukCount
                        / $keluargaCount, 1) : '0' }}</span>
                </div>
            </div>
        </div>

        <!-- Master Data Card -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h3 class="section-title">Data Master</h3>
                <span class="status-badge status-badge-update">
                    Aktual
                </span>
            </div>
            <div class="space-y-0">
                <div class="info-row">
                    <span class="info-label">Wilayah Desa</span>
                    <span class="info-value">{{ number_format($wilayahCount ?? 0) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pengguna Sistem</span>
                    <span class="info-value">{{ number_format($totalUsers ?? 0) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Template Surat</span>
                    <span class="info-value">{{ number_format($suratCount ?? 0) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN - Status & Info -->
    <div class="space-y-8">

        <!-- Status Sistem Card -->
        <div class="gradient-box gradient-primary rounded-2xl p-8 text-white shadow-lg card-hover">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold">Status Sistem</h3>
                    <p class="text-emerald-100 text-sm mt-1">Monitoring Real-time</p>
                </div>
                <span class="inline-block w-3 h-3 bg-white rounded-full badge-live"></span>
            </div>
            <div class="space-y-4">
                <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur-sm">
                    <p class="text-emerald-100 text-sm font-medium">Keadaan Sistem</p>
                    <p class="text-white text-lg font-bold mt-2">✓ Aktif & Normal</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-blur-sm">
                    <p class="text-emerald-100 text-sm font-medium">Terakhir Update</p>
                    <p class="text-white text-sm font-semibold mt-2">{{ now()->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8">
            <h3 class="section-title mb-6">Info Cepat</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Lihat Statistik</p>
                        <p class="text-xs text-slate-500">Laporan Kependudukan</p>
                    </div>
                    <span class="text-slate-400">→</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Buat Surat</p>
                        <p class="text-xs text-slate-500">Template Siap Pakai</p>
                    </div>
                    <span class="text-slate-400">→</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-700">Kelola Pengguna</p>
                        <p class="text-xs text-slate-500">Hak Akses & Rolle</p>
                    </div>
                    <span class="text-slate-400">→</span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- BOTTOM SECTION - Activities & Quick Links -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Recent Activities -->
    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="section-title">Aktivitas Terbaru</h3>
            <a href="/admin/penduduk"
                class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">Lihat Semua
                →</a>
        </div>
        <div class="space-y-0">
            @forelse($recentPenduduk ?? [] as $penduduk)
            <div class="activity-item">
                <div class="activity-dot"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ $penduduk->nama ?? 'N/A' }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $penduduk->created_at ?
                        $penduduk->created_at->diffForHumans() : 'Baru saja' }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <p class="text-sm text-slate-500">Tidak ada aktivitas terbaru</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Access Menu -->
    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="section-title">Menu Cepat</h3>
            <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">6 Menu</span>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <a href="/admin/penduduk" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM12 14a8 8 0 00-8 8v2h16v-2a8 8 0 00-8-8z">
                    </path>
                </svg>
                <span class="label">Penduduk</span>
                <span class="desc">Data Master</span>
            </a>
            <a href="/admin/keluarga" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 8.646 4 4 0 010-8.646M9 10H3m6 10H3m8-6a4 4 0 11-8 0 4 4 0 018 0zM15 20h6m-3-3v6">
                    </path>
                </svg>
                <span class="label">Keluarga</span>
                <span class="desc">Data Master</span>
            </a>
            <a href="/admin/layanan-surat/cetak" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="label">Surat</span>
                <span class="desc">Layanan</span>
            </a>
            <a href="/admin/statistik/kependudukan" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <span class="label">Statistik</span>
                <span class="desc">Laporan</span>
            </a>
            <a href="/admin/artikel" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v11l3-3"></path>
                </svg>
                <span class="label">Artikel</span>
                <span class="desc">Berita</span>
            </a>
            <a href="/admin/pengguna" class="quick-action-btn">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
                <span class="label">Pengguna</span>
                <span class="desc">Kelola</span>
            </a>
        </div>

    </div>

</div>

@endsection