@extends('layouts.admin')

@section('title', 'Laporan Kelompok Rentan')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

    /* ── Base ── */
    .rv-wrap * {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── CSS Variables (mirror sidebar palette) ── */
    .rv-wrap {
        --emerald-600: #059669;
        --emerald-500: #10b981;
        --teal-600: #0d9488;
        --teal-400: #2dd4bf;
        --rose-500: #f43f5e;
        --amber-500: #f59e0b;
        --purple-500: #8b5cf6;
        --radius-xl: 1rem;
        --radius-2xl: 1.25rem;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, .07), 0 2px 6px rgba(0, 0, 0, .05);
        --shadow-lg: 0 12px 40px rgba(0, 0, 0, .10), 0 4px 12px rgba(0, 0, 0, .06);
    }

    /* ── Page header banner ── */
    .rv-banner {
        background: linear-gradient(135deg, #059669 0%, #0d9488 60%, #0891b2 100%);
        border-radius: var(--radius-2xl);
        position: relative;
        overflow: hidden;
    }

    .rv-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 90% -20%, rgba(255, 255, 255, .14) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at -10% 110%, rgba(255, 255, 255, .08) 0%, transparent 55%);
        pointer-events: none;
    }

    .rv-banner::after {
        content: '';
        position: absolute;
        right: -60px;
        bottom: -60px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        border: 40px solid rgba(255, 255, 255, .06);
        pointer-events: none;
    }

    /* ── Stat cards ── */
    .rv-stat {
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-md);
        transition: transform .2s ease, box-shadow .2s ease;
        position: relative;
        overflow: hidden;
    }

    .rv-stat:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .rv-stat-glass {
        background: rgba(255, 255, 255, .92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, .8);
    }

    .rv-stat-primary {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
        border: none;
    }

    .rv-stat-amber {
        background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%);
        border: 1px solid #fde68a;
    }

    .rv-stat-purple {
        background: linear-gradient(135deg, #faf5ff 0%, #ede9fe 100%);
        border: 1px solid #ddd6fe;
    }

    /* ── Icon badge ── */
    .rv-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── Section divider ── */
    .rv-section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.25rem;
    }

    .rv-section-label-bar {
        width: 4px;
        height: 26px;
        border-radius: 4px;
    }

    .rv-section-label h2 {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        letter-spacing: -.015em;
    }

    .rv-section-label span {
        font-size: .8rem;
        color: #9ca3af;
        font-weight: 500;
    }

    /* ── Group cards ── */
    .rv-group-card {
        background: #fff;
        border-radius: var(--radius-2xl);
        border: 1px solid #f3f4f6;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .rv-group-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .rv-top-strip {
        height: 5px;
        width: 100%;
    }

    /* ── Progress bars ── */
    .rv-progress-track {
        background: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
    }

    .rv-progress-fill {
        border-radius: 999px;
        animation: rvBarGrow .9s cubic-bezier(.4, 0, .2, 1) forwards;
        transform-origin: left;
    }

    @keyframes rvBarGrow {
        from {
            width: 0 !important;
        }
    }

    /* ── Gender pill ── */
    .rv-gender-pill {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 10px;
    }

    .rv-gender-symbol {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* ── Horizontal bar chart ── */
    .rv-hbar-fill {
        border-radius: 999px;
        animation: rvBarGrow .9s cubic-bezier(.4, 0, .2, 1) forwards;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 10px;
    }

    /* ── Table ── */
    .rv-table th {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #6b7280;
        padding: 14px 18px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .rv-table td {
        padding: 14px 18px;
        font-size: .875rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .rv-table tbody tr:last-child td {
        border-bottom: none;
    }

    .rv-table tbody tr:hover td {
        background: #f9fafb;
    }

    .rv-table-total td {
        background: linear-gradient(90deg, #ecfdf5 0%, #f0fdf4 100%) !important;
        border-top: 2px solid #a7f3d0 !important;
        font-weight: 700;
    }

    /* ── Badge ── */
    .rv-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 4px 12px;
        border-radius: 8px;
        font-size: .8rem;
        font-weight: 700;
        min-width: 3rem;
    }

    /* ── Filter bar ── */
    .rv-filter-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-sm);
        padding: 20px 28px;
        margin-bottom: 28px;
    }

    .rv-select {
        height: 42px;
        padding: 0 16px;
        font-size: .875rem;
        font-weight: 500;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        color: #374151;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
        transition: border-color .15s, box-shadow .15s;
        outline: none;
    }

    .rv-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .12);
    }

    .rv-btn-primary {
        height: 42px;
        padding: 0 22px;
        background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(5, 150, 105, .25);
        transition: opacity .15s, transform .1s;
    }

    .rv-btn-primary:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    .rv-btn-reset {
        height: 42px;
        padding: 0 18px;
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background .15s;
    }

    .rv-btn-reset:hover {
        background: #e5e7eb;
    }

    .rv-btn-print {
        height: 42px;
        padding: 0 18px;
        background: #fff;
        color: #374151;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        transition: background .15s;
    }

    .rv-btn-print:hover {
        background: #f9fafb;
    }

    /* ── Info box ── */
    .rv-info-box {
        background: linear-gradient(135deg, #fffbeb 0%, #fef9c3 100%);
        border: 1px solid #fde68a;
        border-radius: var(--radius-2xl);
        padding: 28px;
    }

    .rv-info-icon {
        width: 44px;
        height: 44px;
        background: rgba(251, 191, 36, .2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ── Wilayah table row number ── */
    .rv-row-num {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f3f4f6;
        color: #6b7280;
        font-size: .75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* ── Card panel (chart + table wrapper) ── */
    .rv-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .rv-panel-header {
        padding: 20px 24px 18px;
        border-bottom: 1px solid #f3f4f6;
    }

    .rv-panel-header h3 {
        font-size: .9375rem;
        font-weight: 700;
        color: #111827;
    }

    .rv-panel-header p {
        font-size: .8rem;
        color: #9ca3af;
        margin-top: 2px;
    }

    /* ── Print ── */
    @media print {

        aside,
        header,
        form,
        .no-print {
            display: none !important;
        }

        main {
            overflow: visible !important;
        }

        section {
            padding: 0 !important;
        }

        .rv-stat,
        .rv-group-card,
        .rv-panel {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }

        .rv-banner {
            background: #059669 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<div class="rv-wrap">

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- BANNER HEADER --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div
        class="rv-banner px-8 py-7 mb-7 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 relative z-0">
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <p class="text-white/70 text-sm font-semibold tracking-wide uppercase">Laporan</p>
            </div>
            <h1 class="text-2xl font-extrabold text-white leading-tight tracking-tight">Kelompok Rentan</h1>
            <p class="text-white/75 text-sm mt-1.5">
                Total penduduk aktif:
                <span class="font-bold text-white">{{ number_format($data['total_penduduk']) }} jiwa</span>
            </p>
        </div>

        <div class="relative z-10 flex flex-wrap items-center gap-2.5 no-print">
            <form method="GET" action="{{ route('admin.statistik.kelompok-rentan') }}"
                class="flex flex-wrap items-center gap-2.5">
                <select name="wilayah_id"
                    class="h-10 px-4 text-sm border border-white/30 rounded-xl bg-white/15 backdrop-blur text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 font-medium"
                    style="color:white">
                    <option value="" style="color:#111; background:#fff">— Semua Wilayah —</option>
                    @foreach($data['wilayahList'] as $w)
                    <option value="{{ $w->id }}" {{ $data['wilayahId']==$w->id ? 'selected' : '' }} style="color:#111;
                        background:#fff">
                        {{ $w->dusun ? 'Dusun '.$w->dusun.' — ' : '' }}RT {{ $w->rt ?? '-' }} / RW {{ $w->rw ?? '-' }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="h-10 px-5 bg-white text-emerald-700 font-bold text-sm rounded-xl hover:bg-emerald-50 transition shadow-sm">
                    Tampilkan
                </button>
                @if($data['wilayahId'])
                <a href="{{ route('admin.statistik.kelompok-rentan') }}"
                    class="h-10 px-4 flex items-center bg-white/15 hover:bg-white/25 text-white font-medium text-sm rounded-xl transition">
                    Reset
                </a>
                @endif
                <button type="button" onclick="window.print()"
                    class="h-10 px-4 flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white font-medium text-sm rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- 4 SUMMARY CARDS --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        {{-- Total Penduduk --}}
        <div class="rv-stat rv-stat-glass p-6">
            <div class="rv-icon bg-emerald-50 border border-emerald-100 mb-4">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Total Penduduk</p>
            <p class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ number_format($data['total_penduduk']) }}
            </p>
            <p class="text-xs text-gray-400 mt-1.5 font-medium">jiwa aktif tercatat</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-1 bg-gradient-to-r from-emerald-400 to-teal-400 rounded-full" style="width:100%">
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Kelompok Rentan --}}
        <div class="rv-stat rv-stat-primary p-6">
            <div class="rv-icon bg-white/20 mb-4">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-white/70 mb-1">Total Kelompok Rentan</p>
            <p class="text-3xl font-extrabold text-white tracking-tight">{{ number_format($data['totalRentan']) }}</p>
            <p class="text-xs text-white/60 mt-1.5 font-medium">
                {{ $data['total_penduduk'] > 0 ? round($data['totalRentan'] / $data['total_penduduk'] * 100, 1) : 0 }}%
                dari total penduduk
            </p>
            <div class="mt-4 pt-4 border-t border-white/20">
                <div class="h-1 w-full bg-white/20 rounded-full overflow-hidden">
                    <div class="h-1 bg-white/60 rounded-full rv-progress-fill"
                        style="width: {{ $data['total_penduduk'] > 0 ? round($data['totalRentan'] / $data['total_penduduk'] * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- Rentan Usia Muda --}}
        @php $rentanMuda = collect($data['kelompokRentan'])->whereIn('nama',
        ['Balita','Anak-anak','Remaja'])->sum('total'); @endphp
        <div class="rv-stat rv-stat-amber p-6">
            <div class="rv-icon mb-4" style="background:rgba(251,191,36,.2); border:1px solid rgba(251,191,36,.3)">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-amber-600/80 mb-1">Usia Muda</p>
            <p class="text-3xl font-extrabold text-amber-700 tracking-tight">{{ number_format($rentanMuda) }}</p>
            <p class="text-xs text-amber-600/70 mt-1.5 font-medium">Balita + Anak-anak + Remaja</p>
            <div class="mt-4 pt-4 border-t border-amber-200/60">
                <div class="h-1 w-full bg-amber-100 rounded-full overflow-hidden">
                    <div class="h-1 bg-amber-400 rounded-full rv-progress-fill"
                        style="width: {{ $data['total_penduduk'] > 0 ? round($rentanMuda / $data['total_penduduk'] * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

        {{-- Lansia --}}
        @php $lansia = collect($data['kelompokRentan'])->firstWhere('nama', 'Lansia'); @endphp
        <div class="rv-stat rv-stat-purple p-6">
            <div class="rv-icon mb-4" style="background:rgba(139,92,246,.15); border:1px solid rgba(139,92,246,.25)">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-purple-600/80 mb-1">Usia Lanjut</p>
            <p class="text-3xl font-extrabold text-purple-700 tracking-tight">{{ number_format($lansia['total'] ?? 0) }}
            </p>
            <p class="text-xs text-purple-500/70 mt-1.5 font-medium">60 tahun ke atas</p>
            <div class="mt-4 pt-4 border-t border-purple-200/60">
                <div class="h-1 w-full bg-purple-100 rounded-full overflow-hidden">
                    <div class="h-1 bg-purple-400 rounded-full rv-progress-fill"
                        style="width: {{ $data['total_penduduk'] > 0 ? round(($lansia['total'] ?? 0) / $data['total_penduduk'] * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- KELOMPOK RENTAN CARDS --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    @php
    $colorMap = [
    'rose' => ['strip'=>'bg-rose-400', 'iconBg'=>'bg-rose-50', 'iconBdr'=>'border-rose-100', 'icon'=>'text-rose-500',
    'num'=>'text-rose-600', 'bar'=>'bg-rose-400', 'badgeBg'=>'bg-rose-50', 'badgeText'=>'text-rose-700'],
    'orange' => ['strip'=>'bg-orange-400', 'iconBg'=>'bg-orange-50',
    'iconBdr'=>'border-orange-100','icon'=>'text-orange-500', 'num'=>'text-orange-600', 'bar'=>'bg-orange-400',
    'badgeBg'=>'bg-orange-50', 'badgeText'=>'text-orange-700'],
    'amber' => ['strip'=>'bg-amber-400', 'iconBg'=>'bg-amber-50', 'iconBdr'=>'border-amber-100',
    'icon'=>'text-amber-500', 'num'=>'text-amber-600', 'bar'=>'bg-amber-400', 'badgeBg'=>'bg-amber-50',
    'badgeText'=>'text-amber-700'],
    'purple' => ['strip'=>'bg-purple-400', 'iconBg'=>'bg-purple-50',
    'iconBdr'=>'border-purple-100','icon'=>'text-purple-500', 'num'=>'text-purple-600', 'bar'=>'bg-purple-400',
    'badgeBg'=>'bg-purple-50', 'badgeText'=>'text-purple-700'],
    'pink' => ['strip'=>'bg-pink-400', 'iconBg'=>'bg-pink-50', 'iconBdr'=>'border-pink-100', 'icon'=>'text-pink-500',
    'num'=>'text-pink-600', 'bar'=>'bg-pink-400', 'badgeBg'=>'bg-pink-50', 'badgeText'=>'text-pink-700'],
    'slate' => ['strip'=>'bg-slate-400', 'iconBg'=>'bg-slate-50', 'iconBdr'=>'border-slate-200',
    'icon'=>'text-slate-500', 'num'=>'text-slate-600', 'bar'=>'bg-slate-400', 'badgeBg'=>'bg-slate-50',
    'badgeText'=>'text-slate-700'],
    'cyan' => ['strip'=>'bg-cyan-400', 'iconBg'=>'bg-cyan-50', 'iconBdr'=>'border-cyan-100', 'icon'=>'text-cyan-500',
    'num'=>'text-cyan-600', 'bar'=>'bg-cyan-400', 'badgeBg'=>'bg-cyan-50', 'badgeText'=>'text-cyan-700'],
    'teal' => ['strip'=>'bg-teal-400', 'iconBg'=>'bg-teal-50', 'iconBdr'=>'border-teal-100', 'icon'=>'text-teal-500',
    'num'=>'text-teal-600', 'bar'=>'bg-teal-400', 'badgeBg'=>'bg-teal-50', 'badgeText'=>'text-teal-700'],
    ];
    $iconPaths = [
    'baby' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 4a4 4 0 014 4M8 8a4 4 0 014-4m0 8v4m-4-2h8m-2 4H10m2 0v2" />',
    'child' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
    'teen' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />',
    'elder' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
    'woman' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    ',
    'alone' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    ',
    'split' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />',
    'youth' => '
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />',
    ];
    @endphp

    <div class="rv-section-label">
        <div class="rv-section-label-bar" style="background:linear-gradient(to bottom,#10b981,#0d9488)"></div>
        <h2>Rincian Kelompok Rentan</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-10">
        @foreach($data['kelompokRentan'] as $grup)
        @php $c = $colorMap[$grup['color']] ?? $colorMap['slate']; @endphp
        <div class="rv-group-card">
            <div class="rv-top-strip {{ $c['strip'] }}"></div>
            <div class="p-6">
                {{-- Header --}}
                <div class="flex items-start gap-3 mb-5">
                    <div class="rv-icon {{ $c['iconBg'] }} border {{ $c['iconBdr'] }}">
                        <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $iconPaths[$grup['icon']] ?? $iconPaths['child'] !!}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 leading-snug">{{ $grup['nama'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-snug line-clamp-2">{{ $grup['deskripsi'] }}</p>
                    </div>
                </div>

                {{-- Big number --}}
                <div class="mb-1">
                    <span class="text-4xl font-extrabold {{ $c['num'] }} tracking-tight leading-none">{{
                        number_format($grup['total']) }}</span>
                    <span class="text-sm text-gray-400 font-medium ml-1">jiwa</span>
                </div>

                {{-- Progress --}}
                <div class="mb-5 mt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-400 font-medium">Dari total penduduk</span>
                        <span class="text-xs font-bold {{ $c['num'] }} {{ $c['badgeBg'] }} px-2 py-0.5 rounded-md">{{
                            $grup['persen'] }}%</span>
                    </div>
                    <div class="rv-progress-track h-2">
                        <div class="{{ $c['bar'] }} rv-progress-fill h-2"
                            style="width: {{ min($grup['persen'], 100) }}%"></div>
                    </div>
                </div>

                {{-- Gender row --}}
                <div class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-50">
                    <div class="rv-gender-pill bg-blue-50">
                        <span class="rv-gender-symbol bg-blue-100 text-blue-600">♂</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{ number_format($grup['laki']) }}
                            </p>
                            <p class="text-xs text-gray-400">Laki-laki</p>
                        </div>
                    </div>
                    <div class="rv-gender-pill bg-pink-50">
                        <span class="rv-gender-symbol bg-pink-100 text-pink-600">♀</span>
                        <div>
                            <p class="text-sm font-bold text-gray-800 leading-tight">{{
                                number_format($grup['perempuan']) }}</p>
                            <p class="text-xs text-gray-400">Perempuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- CHART + GENDER TABLE --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="rv-section-label">
        <div class="rv-section-label-bar" style="background:linear-gradient(to bottom,#3b82f6,#6366f1)"></div>
        <h2>Perbandingan &amp; Rincian</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

        {{-- Horizontal bar chart --}}
        <div class="rv-panel">
            <div class="rv-panel-header">
                <h3>Grafik Perbandingan Jumlah</h3>
                <p>Visualisasi distribusi kelompok rentan</p>
            </div>
            <div class="p-6 space-y-4">
                @php
                $maxVal = collect($data['kelompokRentan'])->max('total') ?: 1;
                $barColors =
                ['bg-rose-400','bg-orange-400','bg-amber-400','bg-purple-400','bg-pink-400','bg-slate-400','bg-cyan-400','bg-teal-400'];
                $trackColors =
                ['bg-rose-50','bg-orange-50','bg-amber-50','bg-purple-50','bg-pink-50','bg-slate-50','bg-cyan-50','bg-teal-50'];
                @endphp
                @foreach($data['kelompokRentan'] as $i => $grup)
                @php $pct = $maxVal > 0 ? round($grup['total'] / $maxVal * 100) : 0; @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">{{ $grup['nama'] }}</span>
                        <span class="text-xs font-bold text-gray-500">{{ number_format($grup['total']) }} jiwa</span>
                    </div>
                    <div class="w-full {{ $trackColors[$i % count($trackColors)] }} rounded-full h-6 overflow-hidden">
                        <div class="{{ $barColors[$i % count($barColors)] }} rv-hbar-fill h-6"
                            style="width:{{ $pct }}%; min-width:{{ $grup['total'] > 0 ? '3rem' : '0' }}">
                            @if($grup['total'] > 0)
                            <span class="text-white text-xs font-bold">{{ $grup['persen'] }}%</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Gender breakdown table --}}
        <div class="rv-panel">
            <div class="rv-panel-header">
                <h3>Rincian Jenis Kelamin</h3>
                <p>Laki-laki dan perempuan per kelompok</p>
            </div>
            <div class="overflow-x-auto">
                <table class="rv-table w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Kelompok</th>
                            <th class="text-center" style="color:#2563eb">♂ L</th>
                            <th class="text-center" style="color:#db2777">♀ P</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['kelompokRentan'] as $grup)
                        @php $c = $colorMap[$grup['color']] ?? $colorMap['slate']; @endphp
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $c['strip'] }} flex-shrink-0"></span>
                                    <span class="text-sm font-semibold text-gray-800">{{ $grup['nama'] }}</span>
                                </div>
                            </td>
                            <td class="text-center"><span class="font-bold text-blue-600">{{
                                    number_format($grup['laki']) }}</span></td>
                            <td class="text-center"><span class="font-bold text-pink-600">{{
                                    number_format($grup['perempuan']) }}</span></td>
                            <td class="text-center">
                                <span class="rv-badge {{ $c['badgeBg'] }} {{ $c['badgeText'] }}">{{
                                    number_format($grup['total']) }}</span>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="rv-table-total">
                            <td class="text-sm">TOTAL</td>
                            <td class="text-center text-blue-700">{{
                                number_format(collect($data['kelompokRentan'])->sum('laki')) }}</td>
                            <td class="text-center text-pink-700">{{
                                number_format(collect($data['kelompokRentan'])->sum('perempuan')) }}</td>
                            <td class="text-center">
                                <span class="rv-badge bg-emerald-100 text-emerald-800">{{
                                    number_format($data['totalRentan']) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- DISTRIBUSI PER WILAYAH --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="rv-section-label">
        <div class="rv-section-label-bar" style="background:linear-gradient(to bottom,#14b8a6,#0891b2)"></div>
        <h2>Distribusi per Wilayah</h2>
        <span>(Top 10 wilayah terbanyak)</span>
    </div>

    <div class="rv-panel mb-8">
        <div class="overflow-x-auto">
            <table class="rv-table w-full">
                <thead>
                    <tr>
                        <th class="text-center w-14">#</th>
                        <th class="text-left">Wilayah</th>
                        <th class="text-center">Total Pddk</th>
                        <th class="text-center" style="color:#e11d48">Balita</th>
                        <th class="text-center" style="color:#7c3aed">Lansia</th>
                        <th class="text-center" style="color:#475569">Janda/Duda</th>
                        <th class="text-center" style="color:#059669">Total Rentan</th>
                        <th class="text-left w-40">Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['distribusiWilayah'] as $i => $w)
                    @php
                    $totalRentanW = $w->balita + $w->lansia + $w->janda_duda;
                    $pctRentanW = $w->total > 0 ? round($totalRentanW / $w->total * 100) : 0;
                    @endphp
                    <tr>
                        <td class="text-center">
                            <span class="rv-row-num">{{ $i + 1 }}</span>
                        </td>
                        <td>
                            @if($w->dusun)
                            <p class="text-sm font-bold text-gray-900">Dusun {{ $w->dusun }}</p>
                            @endif
                            <p class="text-xs text-gray-400 font-medium">RT {{ $w->rt ?? '-' }} / RW {{ $w->rw ?? '-' }}
                            </p>
                        </td>
                        <td class="text-center font-semibold text-gray-700">{{ number_format($w->total) }}</td>
                        <td class="text-center"><span class="rv-badge bg-rose-50 text-rose-700">{{
                                number_format($w->balita) }}</span></td>
                        <td class="text-center"><span class="rv-badge bg-purple-50 text-purple-700">{{
                                number_format($w->lansia) }}</span></td>
                        <td class="text-center"><span class="rv-badge bg-slate-50 text-slate-700">{{
                                number_format($w->janda_duda) }}</span></td>
                        <td class="text-center"><span class="rv-badge bg-emerald-50 text-emerald-800">{{
                                number_format($totalRentanW) }}</span></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="flex-1 rv-progress-track h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-400 to-teal-400 h-2 rv-progress-fill"
                                        style="width:{{ $pctRentanW }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600 w-9 text-right flex-shrink-0">{{
                                    $pctRentanW }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-16 text-gray-400 text-sm">Data wilayah belum tersedia</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- KETERANGAN --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="rv-info-box">
        <div class="flex items-start gap-4">
            <div class="rv-info-icon mt-0.5">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-amber-900 mb-3 tracking-tight">Penjelasan Kelompok Rentan</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2">
                    @foreach([
                    ['Balita', 'Usia 0–5 tahun, rentan gizi buruk dan penyakit.'],
                    ['Anak-anak', 'Usia 6–12 tahun, rentan putus sekolah.'],
                    ['Remaja', 'Usia 13–17 tahun, rentan pengaruh negatif.'],
                    ['Lansia', 'Usia 60+ tahun, rentan fisik dan ekonomi.'],
                    ['Perempuan Usia Subur','Usia 15–49 tahun, rentan kesehatan reproduksi.'],
                    ['Janda / Duda', 'Rentan ekonomi dan sosial (cerai mati).'],
                    ['Cerai Hidup', 'Rentan ekonomi dan sosial (cerai hidup).'],
                    ['Dewasa Muda Lajang', 'Usia 18–30 belum menikah, rentan pengangguran.'],
                    ] as [$label, $desc])
                    <div class="flex items-start gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0 mt-1.5"></span>
                        <p class="text-xs text-amber-800 leading-relaxed"><span class="font-bold">{{ $label }}</span> —
                            {{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
                <p class="text-xs text-amber-700/80 mt-4 pt-3 border-t border-amber-300/50 font-medium">
                    ⓘ Data diambil dari penduduk dengan status hidup aktif. Satu orang dapat masuk ke lebih dari satu
                    kategori.
                </p>
            </div>
        </div>
    </div>

</div>{{-- end rv-wrap --}}

@endsection