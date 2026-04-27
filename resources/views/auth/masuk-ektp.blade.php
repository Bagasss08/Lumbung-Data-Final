<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk E-KTP – {{ $identitas->nama_desa ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --em-600: #059669;
            --em-500: #10b981;
            --em-400: #34d399;
            --em-700: #047857;
            --em-900: #064e3b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            background: var(--em-900);
        }

        /* ── FULL-PAGE BACKGROUND ─────────────── */
        .lm-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: var(--em-900);
        }

        .lm-bg.has-img {
            background-size: cover;
            background-position: center;
        }

        .lm-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(16, 185, 129, 0.25) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 80% 30%, rgba(5, 150, 105, 0.2) 0%, transparent 65%);
        }

        .lm-bg.has-img::after {
            background: rgba(4, 47, 30, 0.72);
        }

        .lm-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            z-index: 1;
        }

        /* ── CARD ─────────────────────────────── */
        .lm-card {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 540px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.06);
            animation: cardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── LEFT PANEL ───────────────────────── */
        .lm-left {
            width: 45%;
            background: var(--em-600);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .lm-left::before {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            top: -80px;
            right: -80px;
        }

        .lm-left::after {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            bottom: -50px;
            left: -50px;
        }

        .lm-left-inner {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .lm-logo-wrap {
            width: 92px;
            height: 92px;
            margin: 0 auto 1.25rem;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.18);
            border: 2.5px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .lm-logo-wrap img {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .lm-logo-placeholder {
            font-size: 2.6rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .lm-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.75);
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
        }

        .lm-desa-name {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
            margin-bottom: 0.85rem;
        }

        .lm-divider {
            width: 36px;
            height: 2px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 99px;
            margin: 0 auto 0.85rem;
        }

        .lm-info {
            font-size: 0.83rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.85;
            margin-bottom: 1.25rem;
        }

        .lm-notice {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.65;
            background: rgba(0, 0, 0, 0.18);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            margin-bottom: 1rem;
        }

        .lm-ip-info {
            font-size: 0.68rem;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.85;
        }

        .lm-copy-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.35);
            padding: 0;
            vertical-align: middle;
            margin-left: 3px;
            transition: color 0.15s;
        }

        .lm-copy-btn:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        /* ── RIGHT PANEL ──────────────────────── */
        .lm-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2.5rem;
        }

        .lm-form-wrap {
            width: 100%;
            max-width: 320px;
            animation: fadeUp 0.45s 0.1s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .lm-form-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a2e22;
            margin-bottom: 0.2rem;
        }

        .lm-form-sub {
            font-size: 0.8rem;
            color: #8a9ba0;
            margin-bottom: 1.5rem;
        }

        /* Alert */
        .lm-alert {
            background: #fef3c7;
            border-left: 3px solid #f59e0b;
            border-radius: 6px;
            padding: 0.6rem 0.85rem;
            margin-bottom: 1.25rem;
            font-size: 0.8rem;
            color: #92400e;
        }

        .lm-alert-danger {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .lm-alert-success {
            background: #f0fdf4;
            border-left-color: #22c55e;
            color: #166534;
        }

        /* ── CARD READER AREA ─────────────────── */
        .lm-reader-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-align: center;
            margin-bottom: 0.65rem;
            letter-spacing: 0.3px;
        }

        .lm-reader-wrap {
            position: relative;
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
            padding: 1.5rem 1rem;
            margin-bottom: 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            min-height: 130px;
            transition: border-color 0.3s, background 0.3s;
            overflow: hidden;
        }

        .lm-reader-wrap.waiting {
            border-color: #d1d5db;
            background: #f9fafb;
        }

        .lm-reader-wrap.reading {
            border-color: var(--em-500);
            border-style: solid;
            background: rgba(16, 185, 129, 0.04);
        }

        .lm-reader-wrap.success {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .lm-reader-wrap.error-state {
            border-color: #ef4444;
            background: #fef2f2;
        }

        /* Card reader icon */
        .lm-reader-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* The bracket/frame corners - mimicking OpenSID style */
        .lm-reader-frame {
            width: 56px;
            height: 44px;
            position: relative;
        }

        .lm-reader-frame::before,
        .lm-reader-frame::after,
        .lm-reader-frame .fr-tr,
        .lm-reader-frame .fr-bl {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-color: #9ca3af;
            border-style: solid;
        }

        .lm-reader-wrap.reading .lm-reader-frame::before,
        .lm-reader-wrap.reading .lm-reader-frame::after,
        .lm-reader-wrap.reading .lm-reader-frame .fr-tr,
        .lm-reader-wrap.reading .lm-reader-frame .fr-bl {
            border-color: var(--em-500);
        }

        .lm-reader-wrap.success .lm-reader-frame::before,
        .lm-reader-wrap.success .lm-reader-frame::after,
        .lm-reader-wrap.success .lm-reader-frame .fr-tr,
        .lm-reader-wrap.success .lm-reader-frame .fr-bl {
            border-color: #22c55e;
        }

        .lm-reader-frame::before {
            top: 0;
            left: 0;
            border-width: 2.5px 0 0 2.5px;
            border-radius: 3px 0 0 0;
        }

        .lm-reader-frame::after {
            bottom: 0;
            right: 0;
            border-width: 0 2.5px 2.5px 0;
            border-radius: 0 0 3px 0;
        }

        /* Extra corners via child elements */
        .lm-reader-frame .fr-tr {
            top: 0;
            right: 0;
            border-width: 2.5px 2.5px 0 0;
            border-radius: 0 3px 0 0;
        }

        .lm-reader-frame .fr-bl {
            bottom: 0;
            left: 0;
            border-width: 0 0 2.5px 2.5px;
            border-radius: 0 0 0 3px;
        }

        /* KTP card inside frame */
        .lm-reader-frame .fr-card {
            position: absolute;
            inset: 8px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lm-reader-wrap.reading .lm-reader-frame .fr-card {
            opacity: 0.6;
        }

        .lm-reader-wrap.success .lm-reader-frame .fr-card {
            opacity: 1;
            background: linear-gradient(135deg, #bbf7d0, #86efac);
        }

        .lm-reader-frame .fr-card::after {
            content: '';
            width: 8px;
            height: 6px;
            background: rgba(5, 150, 105, 0.5);
            border-radius: 1px;
        }

        /* Scan line animation inside reader */
        .lm-reader-scanline {
            position: absolute;
            left: 10px;
            right: 10px;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, var(--em-400), transparent);
            top: 10px;
            border-radius: 99px;
            box-shadow: 0 0 6px rgba(52, 211, 153, 0.5);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lm-reader-wrap.reading .lm-reader-scanline {
            opacity: 1;
            animation: readerScan 1.8s ease-in-out infinite;
        }

        @keyframes readerScan {
            0% {
                top: 10px;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                top: calc(100% - 10px);
                opacity: 0;
            }
        }

        /* Pulse ring when reading */
        .lm-reader-pulse {
            position: absolute;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid var(--em-400);
            opacity: 0;
            pointer-events: none;
        }

        .lm-reader-wrap.reading .lm-reader-pulse {
            animation: readerPulse 1.8s ease-out infinite;
        }

        @keyframes readerPulse {
            0% {
                opacity: 0.6;
                transform: scale(0.6);
            }

            100% {
                opacity: 0;
                transform: scale(1.4);
            }
        }

        /* Reader status text */
        .lm-reader-text {
            font-size: 0.75rem;
            font-weight: 500;
            color: #9ca3af;
            text-align: center;
            line-height: 1.5;
            transition: color 0.2s;
            position: relative;
            z-index: 2;
        }

        .lm-reader-wrap.waiting .lm-reader-text {
            color: #9ca3af;
        }

        .lm-reader-wrap.reading .lm-reader-text {
            color: var(--em-600);
            font-weight: 600;
        }

        .lm-reader-wrap.success .lm-reader-text {
            color: #16a34a;
            font-weight: 600;
        }

        .lm-reader-wrap.error-state .lm-reader-text {
            color: #ef4444;
        }

        /* Success checkmark overlay */
        .lm-reader-check {
            display: none;
            color: #22c55e;
        }

        .lm-reader-wrap.success .lm-reader-check {
            display: block;
        }

        .lm-reader-wrap.success .lm-reader-frame {
            display: none;
        }

        .lm-reader-check svg {
            width: 36px;
            height: 36px;
        }

        /* NIK badge shown after read */
        .lm-nik-badge {
            display: none;
            align-items: center;
            gap: 6px;
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 6px;
            padding: 0.4rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #15803d;
            margin-bottom: 0.85rem;
            width: 100%;
            justify-content: center;
        }

        .lm-nik-badge.visible {
            display: flex;
        }

        .lm-nik-badge svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
        }

        /* Fields */
        .lm-field {
            margin-bottom: 1rem;
        }

        .lm-field-label {
            font-size: 0.73rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 5px;
        }

        .lm-input-wrap {
            position: relative;
        }

        .lm-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            display: flex;
        }

        .lm-input-icon svg {
            width: 16px;
            height: 16px;
        }

        .lm-input {
            width: 100%;
            padding: 0.7rem 0.85rem 0.7rem 2.5rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.875rem;
            font-family: inherit;
            color: #111827;
            background: #f9fafb;
            outline: none;
            transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
        }

        .lm-input::placeholder {
            color: #c0c9cc;
        }

        .lm-input:focus {
            border-color: var(--em-500);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
        }

        .lm-input:disabled {
            background: #f3f4f6;
            color: #6b7280;
            cursor: not-allowed;
        }

        .lm-input.is-error {
            border-color: #ef4444;
        }

        .lm-pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 3px;
            display: flex;
            transition: color 0.15s;
        }

        .lm-pw-toggle:hover {
            color: var(--em-600);
        }

        .lm-pw-toggle svg {
            width: 16px;
            height: 16px;
        }

        .lm-error-msg {
            font-size: 0.73rem;
            color: #ef4444;
            margin-top: 4px;
            padding-left: 2px;
        }

        /* Buttons */
        .lm-buttons-wrap {
            margin-top: 1.25rem;
        }

        .lm-btn {
            display: block;
            width: 100%;
            padding: 0.68rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            font-family: inherit;
            text-align: center;
            cursor: pointer;
            transition: all 0.18s;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            text-decoration: none;
            border: 2px solid var(--em-600);
        }

        .lm-btn+.lm-btn {
            margin-top: 0.55rem;
        }

        .lm-btn-primary,
        .lm-btn-outline {
            background: transparent;
            color: var(--em-600);
        }

        .lm-btn-primary:hover,
        .lm-btn-outline:hover {
            background: var(--em-600);
            color: #fff;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        }

        .lm-btn:disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        .lm-btn.loading {
            opacity: 0.72;
            pointer-events: none;
        }

        .lm-spinner {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 2px solid currentColor;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 5px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .lm-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af;
            line-height: 1.85;
        }

        .lm-footer a {
            color: var(--em-600);
            text-decoration: none;
            font-weight: 600;
        }

        .lm-footer a:hover {
            text-decoration: underline;
        }

        /* ── RESPONSIVE ───────────────────────── */
        @media (max-width: 700px) {
            body {
                padding: 0;
                align-items: stretch;
            }

            .lm-card {
                flex-direction: column;
                border-radius: 0;
                min-height: 100vh;
                box-shadow: none;
            }

            .lm-left {
                width: 100%;
                padding: 2.5rem 1.5rem 2rem;
                min-height: auto;
            }

            .lm-right {
                padding: 2rem 1.5rem 2.5rem;
            }
        }
    </style>
</head>

<body>

    @php
        $identitas = \App\Models\IdentitasDesa::first();
        $pengaturan = \App\Models\LayananMandiriPengaturan::first();
        $latarLogin = optional($pengaturan)->latar_login;
        $latarPath = $latarLogin ? storage_path('app/public/layanan-mandiri/' . $latarLogin) : null;
        $hasLatar = $latarPath && file_exists($latarPath);
        $logoPath = optional($identitas)->logo_desa
            ? storage_path('app/public/logo-desa/' . $identitas->logo_desa)
            : null;
        $hasLogo = $logoPath && file_exists($logoPath);
    @endphp

    {{-- BACKGROUND --}}
    <div class="lm-bg{{ $hasLatar ? ' has-img' : '' }}"
        @if ($hasLatar) style="background-image: url('{{ asset('storage/layanan-mandiri/' . $latarLogin) }}')" @endif>
    </div>

    {{-- CARD --}}
    <div class="lm-card">

        {{-- LEFT PANEL --}}
        <div class="lm-left">
            <div class="lm-left-inner">

                <div class="lm-logo-wrap">
                    @if ($hasLogo)
                        <img src="{{ asset('storage/logo-desa/' . $identitas->logo_desa) }}" alt="Logo Desa">
                    @else
                        <span class="lm-logo-placeholder">
                            {{ strtoupper(substr(optional($identitas)->nama_desa ?? 'D', 0, 1)) }}
                        </span>
                    @endif
                </div>

                <div class="lm-label">Layanan Mandiri</div>
                <div class="lm-desa-name">{{ optional($identitas)->nama_desa ?? 'Desa' }}</div>
                <div class="lm-divider"></div>

                <div class="lm-info">
                    @if (optional($identitas)->kecamatan)
                        <div>Kecamatan {{ $identitas->kecamatan }}</div>
                    @endif
                    @if (optional($identitas)->kabupaten)
                        <div>Kabupaten {{ $identitas->kabupaten }}</div>
                    @endif
                    @if (optional($identitas)->kode_pos)
                        <div>{{ $identitas->kode_pos }}</div>
                    @endif
                </div>

                <div class="lm-notice">
                    Tempelkan e-KTP pada Card Reader, lalu masukkan PIN untuk masuk.
                </div>

                <div class="lm-ip-info">
                    <div>IP Address: {{ request()->ip() }}</div>
                    <div>
                        ID Pengunjung :
                        <span id="lm-visitor-id">{{ substr(md5(request()->ip() . session()->getId()), 0, 32) }}</span>
                        <button class="lm-copy-btn" onclick="copyText('lm-visitor-id')" title="Salin">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="lm-right">
            <div class="lm-form-wrap">

                <div class="lm-form-title">Masuk dengan E-KTP</div>
                <div class="lm-form-sub">Tempelkan e-KTP pada card reader lalu masukkan PIN</div>

                @if ($errors->any())
                    <div class="lm-alert lm-alert-danger">{{ $errors->first() }}</div>
                @endif
                @if (session('error'))
                    <div class="lm-alert lm-alert-danger">{{ session('error') }}</div>
                @endif

                {{-- CARD READER AREA --}}
                <p class="lm-reader-label">Tempelkan e-KTP Pada Card Reader</p>

                <div class="lm-reader-wrap waiting" id="reader-wrap">
                    {{-- Pulse ring (visible saat reading) --}}
                    <div class="lm-reader-pulse"></div>

                    {{-- Scanline (visible saat reading) --}}
                    <div class="lm-reader-scanline"></div>

                    {{-- Icon frame (waiting / reading) --}}
                    <div class="lm-reader-icon">
                        <div class="lm-reader-frame" id="reader-frame">
                            <span class="fr-tr"></span>
                            <span class="fr-bl"></span>
                            <span class="fr-card"></span>
                        </div>
                        {{-- Checkmark (success) --}}
                        <div class="lm-reader-check" id="reader-check">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>

                    <p class="lm-reader-text" id="reader-text">Menunggu kartu…</p>
                </div>

                {{-- NIK badge muncul setelah berhasil dibaca --}}
                <div class="lm-nik-badge" id="nik-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    NIK: <span id="nik-badge-value">—</span>
                </div>

                {{-- FORM --}}
                <form method="POST" action="{{ route('layanan-mandiri.masuk-ektp.proses') }}" id="lm-form">
                    @csrf

                    {{-- NIK hidden – diisi otomatis dari card reader --}}
                    <input type="hidden" name="nik" id="nik-hidden">

                    {{-- PIN --}}
                    <div class="lm-field">
                        <div class="lm-field-label">PIN</div>
                        <div class="lm-input-wrap">
                            <span class="lm-input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input type="password" id="pin" name="pin"
                                class="lm-input{{ $errors->has('pin') ? ' is-error' : '' }}"
                                placeholder="Masukkan PIN Anda" maxlength="20" autocomplete="current-password"
                                style="padding-right: 2.5rem;" required>
                            <button type="button" class="lm-pw-toggle" id="toggle-pin" title="Tampilkan PIN">
                                <svg id="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('pin')
                            <div class="lm-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="lm-buttons-wrap">
                        <button type="submit" class="lm-btn lm-btn-primary" id="lm-submit">
                            MASUK
                        </button>
                        <a href="{{ route('layanan-mandiri') }}" class="lm-btn lm-btn-outline">
                            MASUK DENGAN NIK
                        </a>
                        <a href="{{ route('layanan-mandiri.lupa-pin') }}" class="lm-btn lm-btn-outline">
                            LUPA PIN
                        </a>
                    </div>

                </form>

                <div class="lm-footer">
                    <div>Login sebagai Administrator? <a href="{{ route('login') }}">Halaman Admin</a></div>
                    <div style="margin-top:0.25rem">
                        {{ config('app.name') }} {{ config('app.version', 'v1.0.0') }}
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        /* ── UTILS ─────────────────────────────── */
        function copyText(elId) {
            const text = document.getElementById(elId)?.innerText || '';
            navigator.clipboard.writeText(text).catch(() => {});
        }

        /* ── PIN TOGGLE ────────────────────────── */
        const pinInput = document.getElementById('pin');
        const toggleBtn = document.getElementById('toggle-pin');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        function setPinVisibility(show) {
            pinInput.type = show ? 'text' : 'password';
            eyeOpen.style.display = show ? 'none' : 'block';
            eyeClosed.style.display = show ? 'block' : 'none';
        }
        toggleBtn.addEventListener('click', () => setPinVisibility(pinInput.type === 'password'));

        /* ── FORM SUBMIT ───────────────────────── */
        document.getElementById('lm-form').addEventListener('submit', function() {
            const btn = document.getElementById('lm-submit');
            btn.classList.add('loading');
            btn.innerHTML = '<span class="lm-spinner"></span> Memproses...';
        });

        /* ═══════════════════════════════════════════
           CARD READER – NIK via HID keyboard input
           ═══════════════════════════════════════════
           Card reader ACR122U / Omnikey / dsb. biasanya
           mengemulasi keyboard dan mengoutput data kartu
           sebagai string yang diakhiri Enter.

           Strategi:
           - Dengarkan keystroke saat halaman aktif
           - Kumpulkan karakter dengan interval < 50 ms
             (input dari card reader jauh lebih cepat
              daripada ketikan manusia)
           - Jika ditemukan 16 digit, anggap itu NIK
           - Fallback: parse format NIK|NAMA|... (e-KTP)
        ═══════════════════════════════════════════ */

        const readerWrap = document.getElementById('reader-wrap');
        const readerText = document.getElementById('reader-text');
        const nikHidden = document.getElementById('nik-hidden');
        const nikBadge = document.getElementById('nik-badge');
        const nikBadgeVal = document.getElementById('nik-badge-value');
        const submitBtn = document.getElementById('lm-submit');

        let buffer = '';
        let bufferTimer = null;
        let nikFound = false;

        /** Ekstrak 16-digit NIK dari string card reader */
        function extractNIK(raw) {
            // Format pipe-separated (e.g. "NAMA|NIK|...")
            const parts = raw.split(/[|\t;,]/);
            for (const p of parts) {
                const s = p.trim();
                if (/^\d{16}$/.test(s)) return s;
            }
            // Cari 16 digit berurutan
            const m = raw.match(/\b\d{16}\b/);
            return m ? m[0] : null;
        }

        function setReaderState(state, text) {
            readerWrap.className = 'lm-reader-wrap ' + state;
            readerText.textContent = text;
        }

        function onNIKFound(nik) {
            nikFound = true;
            nikHidden.value = nik;
            nikBadgeVal.textContent = nik;
            nikBadge.classList.add('visible');
            submitBtn.disabled = false; // tetap aktif
            setReaderState('success', 'Kartu berhasil dibaca!');
            // Fokus ke PIN supaya user langsung bisa ketik
            setTimeout(() => pinInput.focus(), 200);
        }

        function resetReader() {
            nikFound = false;
            nikHidden.value = '';
            nikBadge.classList.remove('visible');
            // submitBtn tetap aktif saat reset
            buffer = '';
            setReaderState('waiting', 'Menunggu kartu…');
        }

        /** Proses buffer setelah jeda input */
        function processBuffer() {
            const raw = buffer.trim();
            buffer = '';

            if (!raw) return;

            const nik = extractNIK(raw);
            if (nik) {
                onNIKFound(nik);
            } else if (raw.length > 3) {
                // Ada input tapi bukan NIK
                setReaderState('error-state', 'Format kartu tidak dikenali. Coba tempelkan ulang.');
                setTimeout(resetReader, 2500);
            }
        }

        /**
         * Tangkap input dari card reader (HID keyboard emulation).
         * Karakter datang sangat cepat (< 5 ms antar karakter).
         * Kita bedakan dari ketikan manusia dengan timer 80 ms.
         */
        document.addEventListener('keydown', function(e) {
            // Abaikan jika fokus di PIN input (user sedang mengetik PIN)
            if (document.activeElement === pinInput) return;
            // Abaikan modifier keys
            if (e.ctrlKey || e.altKey || e.metaKey) return;

            if (e.key === 'Enter') {
                clearTimeout(bufferTimer);
                processBuffer();
                return;
            }

            if (e.key.length === 1) {
                // Tandai sedang membaca
                if (!nikFound) {
                    setReaderState('reading', 'Membaca kartu…');
                }
                buffer += e.key;
                clearTimeout(bufferTimer);
                bufferTimer = setTimeout(processBuffer, 80);
                // Cegah karakter masuk ke form input lain
                e.preventDefault();
            }
        });

        /* Animasi idle: frame berkedip tiap 2 detik */
        setInterval(() => {
            if (readerWrap.classList.contains('waiting')) {
                readerWrap.classList.add('reading');
                readerText.textContent = 'Mendeteksi kartu…';
                setTimeout(() => {
                    if (!nikFound) {
                        readerWrap.classList.remove('reading');
                        readerWrap.classList.add('waiting');
                        readerText.textContent = 'Menunggu kartu…';
                    }
                }, 800);
            }
        }, 3000);
    </script>
</body>

</html>
