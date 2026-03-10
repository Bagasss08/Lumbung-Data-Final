@extends('superadmin.layout.superadmin')

@section('title', 'Dashboard Utama')
@section('header', 'Beranda')
@section('subheader', 'Ringkasan sistem hari ini')

@section('content')

<style>
    /* ── Stat Cards (Blue Theme) ── */
    .stat-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .stat-card:hover {
        box-shadow: 0 6px 24px rgba(59, 130, 246, 0.08);
        transform: translateY(-2px);
    }
    .stat-icon {
        width: 46px; height: 46px; border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.07em; }
    .stat-value { font-size: 27px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-top: 3px; }
    .stat-badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 2px 8px; border-radius: 99px; margin-top: 5px;
    }
    .badge-blue { background: #eff6ff; color: #2563eb; }
    .badge-gray  { background: #f8fafc; color: #64748b; }

    /* ── Welcome Banner (Dark Blue Gradient) ── */
    .welcome-card {
        background: linear-gradient(130deg, #0a0f1e 0%, #1e3a8a 60%, #312e81 100%);
        border-radius: 18px;
        padding: 28px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(59, 130, 246, 0.2);
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.15);
    }
    .welcome-card .orb-1 {
        position: absolute; top: -50px; right: -50px;
        width: 200px; height: 200px; border-radius: 50%;
        background: radial-gradient(circle, rgba(96, 165, 250, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }
    .welcome-card .orb-2 {
        position: absolute; bottom: -60px; right: 120px;
        width: 160px; height: 160px; border-radius: 50%;
        background: radial-gradient(circle, rgba(129, 140, 248, 0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── Quick links ── */
    .quick-link {
        display: flex; align-items: center; gap: 11px;
        padding: 13px 15px;
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        color: #334155; font-size: 13px; font-weight: 600;
        text-decoration: none;
        transition: all 0.17s ease;
    }
    .quick-link:hover {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.1);
    }
    .quick-link:hover .ql-icon { background: #dbeafe; color: #2563eb; }
    .ql-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: #f8fafc;
        display: flex; align-items: center; justify-content: center;
        color: #64748b; flex-shrink: 0;
        transition: all 0.17s ease;
    }

    /* ── Section title ── */
    .section-title {
        font-size: 10.5px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px;
    }

    /* ── Activity table ── */
    .activity-row {
        display: flex; align-items: center; gap: 13px;
        padding: 12px 18px;
        transition: background 0.14s ease;
    }
    .activity-row:hover { background: #f8fafc; }
    .activity-dot {
        width: 30px; height: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .dot-core { width: 7px; height: 7px; border-radius: 50%; }
</style>

{{-- ── Welcome Banner ── --}}
<div class="welcome-card mb-8">
    <div class="orb-1"></div>
    <div class="orb-2"></div>
    <div class="relative z-10">
        <p style="color: rgba(147, 197, 253, 0.8); font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px;">
            Panel Kontrol Superadmin
        </p>
        <h2 style="font-size: 24px; font-weight: 800; color: #fff; line-height: 1.2;">
            Halo, {{ Auth::user()->name ?? 'Super Admin' }} 
        </h2>
        <p style="font-size: 13px; color: rgba(191, 219, 254, 0.7); margin-top: 6px;">
            {{ now()->translatedFormat('l, d F Y') }} &nbsp;·&nbsp; Sistem Informasi Desa
        </p>
        <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(59, 130, 246, 0.2); color: #93c5fd; font-size: 11px; font-weight: 600; padding: 5px 12px; border-radius: 99px; border: 1px solid rgba(59, 130, 246, 0.3);">
                <span style="width: 6px; height: 6px; background: #60a5fa; border-radius: 50%; display: inline-block; animation: pulse 1.8s infinite;"></span>
                Sistem Online
            </span>
            <span style="color: rgba(255,255,255,0.2); font-size: 12px;">·</span>
            <span style="color: rgba(255,255,255,0.4); font-size: 11px; font-weight: 500;">v1.0.0</span>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
</style>

{{-- ── Stat Cards ── --}}
<p class="section-title">Statistik Database</p>
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

    {{-- Total Pengguna --}}
    <div class="stat-card">
        <div class="stat-icon" style="background: #eff6ff;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Total Pengguna</p>
            <p class="stat-value">{{ number_format($totalUsers) }}</p>
            <span class="stat-badge badge-blue">↑ +{{ $newUsersThisMonth }} bulan ini</span>
        </div>
    </div>

    {{-- Admin Aktif --}}
    <div class="stat-card">
        <div class="stat-icon" style="background: #eef2ff;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Admin / Operator</p>
            <p class="stat-value">{{ number_format($totalAdmins) }}</p>
            <span class="stat-badge badge-gray">akun pengelola aktif</span>
        </div>
    </div>

    {{-- Aktivitas / Pesan Hari Ini --}}
    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdfa;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Pesan Hari Ini</p>
            <p class="stat-value">{{ number_format($messagesToday) }}</p>
            <span class="stat-badge badge-gray">pesan internal dikirim</span>
        </div>
    </div>

</div>

{{-- ── Quick Access ── --}}
<p class="section-title">Akses Cepat</p>
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-8">

    <a href="{{ route('superadmin.users.index') }}" class="quick-link">
        <div class="ql-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
        </div>
        Manajemen User
    </a>

    <a href="{{ route('superadmin.settings.index') }}" class="quick-link">
        <div class="ql-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
        </div>
        Pengaturan
    </a>

    <a href="{{ route('superadmin.logs.index') }}" class="quick-link">
        <div class="ql-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        Log Sistem
    </a>

    <a href="{{ route('superadmin.kontak.index') }}" class="quick-link">
        <div class="ql-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </div>
        Pesan Masuk
    </a>

</div>

{{-- ── Aktivitas Terkini (Real Database) ── --}}
<p class="section-title">Aktivitas Terkini</p>
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">

    @forelse($activities as $act)
    <div class="activity-row {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
        <div class="activity-dot" style="background: {{ $act['bg'] }};">
            <div class="dot-core" style="background: {{ $act['dot'] }};"></div>
        </div>
        <div class="flex-1 min-w-0">
            <p style="font-size: 13.5px; font-weight: 700; color: #1e293b;">{{ $act['msg'] }}</p>
            <p style="font-size: 12px; font-weight: 500; color: #64748b; margin-top: 2px;">{{ $act['sub'] }}</p>
        </div>
    </div>
    @empty
    <div class="p-8 text-center">
        <p class="text-sm text-gray-500 font-medium">Belum ada aktivitas di sistem hari ini.</p>
    </div>
    @endforelse

    <div style="padding: 12px 18px; border-top: 1px solid #f1f5f9; background: #f8fafc;">
        <a href="{{ route('superadmin.logs.index') }}"
           style="font-size: 12.5px; font-weight: 700; color: #2563eb; text-decoration: none; transition: color 0.2s ease;"
           onmouseover="this.style.color='#1d4ed8'"
           onmouseout="this.style.color='#2563eb'">
            Lihat semua log →
        </a>
    </div>
</div>

@endsection