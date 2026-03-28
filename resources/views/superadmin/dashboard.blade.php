@extends('superadmin.layout.superadmin')

@section('title', 'Dashboard Utama')
@section('header', 'Beranda Utama')
@section('subheader', 'Pantau performa dan manajemen data desa secara real-time.')

@section('content')

<style>
    /* ── Enhanced Stat Cards ── */
    .stat-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.1);
        transform: translateY(-4px);
        border-color: #dbeafe;
    }
    .stat-icon-box {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .stat-value { font-size: 32px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
    .stat-label { font-size: 13px; font-weight: 600; color: #64748b; }
    
    /* Progress Bar Mini */
    .stat-progress { height: 6px; background: #f1f5f9; border-radius: 10px; margin-top: 15px; overflow: hidden; }
    .stat-progress-inner { height: 100%; border-radius: 10px; transition: width 1s ease-in-out; }

    /* ── Welcome Banner Modern ── */
    .welcome-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        border-radius: 24px;
        padding: 40px;
        color: #fff;
        position: relative;
        z-index: 1;
    }
    .welcome-card::after {
        content: ''; position: absolute; top: 0; right: 0; bottom: 0; left: 0;
        background: url("https://www.transparenttextures.com/patterns/cubes.png");
        opacity: 0.1; z-index: -1;
    }

    /* ── Sidebar Widget ── */
    .widget-box {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        padding: 24px;
    }

    /* ── Layouting ── */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
    }
    @media (max-width: 1024px) {
        .dashboard-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-grid">
    
    {{-- KOLOM KIRI (UTAMA) --}}
    <div class="space-y-8">
        
        {{-- Banner --}}
        <div class="welcome-card shadow-2xl shadow-blue-900/20">
            <div class="flex justify-between items-start">
                <div class="max-w-md">
                    <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                        Status Sistem: Normal
                    </span>
                    <h2 class="text-3xl font-extrabold text-white">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-blue-100/70 mt-3 text-sm leading-relaxed">
                        Data statistik diperbarui otomatis. Anda memiliki <strong>{{ $messagesToday }} pesan masuk</strong> yang perlu direspon hari ini.
                    </p>
                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('superadmin.pengumuman.index') }}" class="px-5 py-2.5 bg-white text-blue-900 rounded-xl font-bold text-sm shadow-lg hover:bg-blue-50 transition-all">
                            Buat Pengumuman
                        </a>
                        <a href="{{ route('superadmin.logs.index') }}" class="px-5 py-2.5 bg-blue-600/30 text-white border border-white/10 rounded-xl font-bold text-sm hover:bg-blue-600/50 transition-all">
                            Log Aktivitas
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 text-center">
                        <p class="text-[10px] uppercase font-bold text-blue-200">Waktu Server</p>
                        <p class="text-2xl font-mono font-bold mt-1">{{ now()->format('H:i') }}</p>
                        <p class="text-[10px] text-blue-300/60 mt-1 uppercase">{{ now()->format('T') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div>
            <div class="flex justify-between items-end mb-6">
                <h3 class="text-sm font-extrabold text-slate-400 uppercase tracking-widest">Database Overview</h3>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">Real-time Data</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card 1 --}}
                <div class="stat-card">
                    <div class="stat-icon-box bg-blue-50 text-blue-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <p class="stat-label">Total Pengguna</p>
                    <p class="stat-value">{{ number_format($totalUsers) }}</p>
                    <div class="stat-progress">
                        <div class="stat-progress-inner bg-blue-600" style="width: 75%;"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-3 font-semibold">↑ {{ $newUsersThisMonth }} User Baru</p>
                </div>

                {{-- Card 2 --}}
                <div class="stat-card">
                    <div class="stat-icon-box bg-indigo-50 text-indigo-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <p class="stat-label">Pengelola Aktif</p>
                    <p class="stat-value">{{ number_format($totalAdmins) }}</p>
                    <div class="stat-progress">
                        <div class="stat-progress-inner bg-indigo-600" style="width: 45%;"></div>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-3 font-semibold">Admin & Operator Desa</p>
                </div>

                {{-- Card 3 --}}
                <div class="stat-card">
                    <div class="stat-icon-box bg-emerald-50 text-emerald-600">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <p class="stat-label">Traffic Pesan</p>
                    <p class="stat-value">{{ number_format($messagesToday) }}</p>
                    <div class="stat-progress">
                        <div class="stat-progress-inner bg-emerald-600" style="width: 90%;"></div>
                    </div>
                    <p class="text-[11px] text-emerald-600 mt-3 font-bold">Aktivitas Hari Ini</p>
                </div>
            </div>
        </div>

        {{-- Aktivitas Terkini --}}
        <div class="widget-box shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-extrabold text-slate-800 uppercase tracking-widest">Log Aktivitas Sistem</h3>
                <a href="{{ route('superadmin.logs.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($activities as $act)
                <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: {{ $act['bg'] }}">
                        <div class="w-2.5 h-2.5 rounded-full" style="background: {{ $act['dot'] }}"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 group-hover:text-blue-700 transition-colors">{{ $act['msg'] }}</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $act['sub'] }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md">TODAY</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-sm text-slate-400">Tidak ada log aktivitas hari ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN (SIDEBAR) --}}
    <div class="space-y-6">
        
        {{-- Akses Cepat --}}
        <div class="widget-box">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-5">Shortcut</h3>
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('superadmin.users.index') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Manajemen User</span>
                </a>
                <a href="{{ route('superadmin.settings.index') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Setelan Sistem</span>
                </a>
                <a href="{{ route('superadmin.kontak.index') }}" class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                    <span class="text-sm font-bold text-slate-700">Kotak Masuk</span>
                </a>
            </div>
        </div>

        {{-- Widget Broadcast --}}
        <div class="widget-box bg-slate-900 text-white border-0 shadow-xl shadow-slate-200">
            <h3 class="text-xs font-extrabold text-blue-400 uppercase tracking-widest mb-4">Quick Broadcast</h3>
            <p class="text-[11px] text-slate-400 leading-relaxed mb-4">
                Kirim pengumuman penting ke seluruh operator desa dalam satu klik.
            </p>
            <form action="{{ route('superadmin.pengumuman.index') }}" method="GET">
                <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Mulai Broadcast
                </button>
            </form>
        </div>

        {{-- Info v1.0 --}}
        <div class="text-center p-6 border-2 border-dashed border-slate-200 rounded-3xl">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Running Version</p>
            <p class="text-lg font-black text-slate-300">SID-APP v1.2.4</p>
        </div>
    </div>
</div>

@endsection