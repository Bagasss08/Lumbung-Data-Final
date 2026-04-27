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

        /* ── QR SCANNER ───────────────────────── */
        .lm-scanner-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
            border: 2px dashed #d1d5db;
            transition: border-color 0.3s;
        }

        .lm-scanner-wrap.active {
            border-color: var(--em-500);
            border-style: solid;
        }

        .lm-scanner-wrap.success {
            border-color: #22c55e;
            border-style: solid;
        }

        #lm-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
            border-radius: 10px;
        }

        #lm-canvas {
            display: none;
        }

        /* Placeholder icon */
        .lm-scanner-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #9ca3af;
            font-size: 0.78rem;
            font-weight: 500;
            text-align: center;
            padding: 1rem;
            transition: opacity 0.3s;
        }

        .lm-scanner-placeholder svg {
            width: 52px;
            height: 52px;
            color: #d1d5db;
        }

        /* Scanning corners overlay */
        .lm-scan-corners {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: none;
        }

        .lm-scan-corners.visible {
            display: block;
        }

        .lm-scan-corners::before,
        .lm-scan-corners::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 28px;
            border-color: var(--em-400);
            border-style: solid;
        }

        .lm-scan-corners::before {
            top: 16px;
            left: 16px;
            border-width: 3px 0 0 3px;
            border-radius: 4px 0 0 0;
        }

        .lm-scan-corners::after {
            bottom: 16px;
            right: 16px;
            border-width: 0 3px 3px 0;
            border-radius: 0 0 4px 0;
        }

        /* Extra corners using box shadow trick via inner divs */
        .lm-corner-tr,
        .lm-corner-bl {
            position: absolute;
            width: 28px;
            height: 28px;
            border-color: var(--em-400);
            border-style: solid;
            display: none;
        }

        .lm-scan-corners.visible~.lm-corner-tr,
        .lm-scan-corners.visible~.lm-corner-bl {
            display: block;
        }

        .lm-corner-tr {
            top: 16px;
            right: 16px;
            border-width: 3px 3px 0 0;
            border-radius: 0 4px 0 0;
        }

        .lm-corner-bl {
            bottom: 16px;
            left: 16px;
            border-width: 0 0 3px 3px;
            border-radius: 0 0 0 4px;
        }

        /* Scan line animation */
        .lm-scan-line {
            position: absolute;
            left: 20px;
            right: 20px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--em-400), transparent);
            top: 20px;
            display: none;
            border-radius: 99px;
            box-shadow: 0 0 8px rgba(52, 211, 153, 0.6);
            animation: scanLine 2s ease-in-out infinite;
        }

        .lm-scan-line.visible {
            display: block;
        }

        @keyframes scanLine {
            0% {
                top: 20px;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                top: calc(100% - 20px);
                opacity: 0;
            }
        }

        /* Success checkmark */
        .lm-scan-success {
            position: absolute;
            inset: 0;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(240, 253, 244, 0.92);
            gap: 0.4rem;
        }

        .lm-scan-success.visible {
            display: flex;
        }

        .lm-scan-success svg {
            width: 40px;
            height: 40px;
            color: #22c55e;
        }

        .lm-scan-success span {
            font-size: 0.78rem;
            font-weight: 600;
            color: #166534;
        }

        /* Status text */
        .lm-scan-status {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 0.85rem;
            min-height: 1.2rem;
            transition: color 0.2s;
        }

        .lm-scan-status.scanning {
            color: var(--em-600);
            font-weight: 500;
        }

        .lm-scan-status.found {
            color: #22c55e;
            font-weight: 600;
        }

        .lm-scan-status.error {
            color: #ef4444;
        }

        /* Start Camera Button */
        .lm-btn-camera {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.18s;
            background: rgba(5, 150, 105, 0.08);
            color: var(--em-700);
            border: 1.5px solid rgba(5, 150, 105, 0.25);
            margin-bottom: 0.85rem;
        }

        .lm-btn-camera:hover {
            background: rgba(5, 150, 105, 0.15);
            border-color: var(--em-600);
        }

        .lm-btn-camera svg {
            width: 15px;
            height: 15px;
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

        .lm-input.is-filled {
            border-color: #22c55e;
            background: #f0fdf4;
            color: #166534;
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
                    Arahkan kamera ke QR Code yang ada di e-KTP Anda, lalu masukkan PIN untuk masuk.
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
                <div class="lm-form-sub">Scan QR Code e-KTP, lalu masukkan PIN Anda</div>

                @if ($errors->any())
                    <div class="lm-alert lm-alert-danger">{{ $errors->first() }}</div>
                @endif
                @if (session('error'))
                    <div class="lm-alert lm-alert-danger">{{ session('error') }}</div>
                @endif

                {{-- QR SCANNER AREA --}}
                <div class="lm-scanner-wrap" id="scanner-wrap">
                    <video id="lm-video" playsinline autoplay muted></video>
                    <canvas id="lm-canvas"></canvas>

                    <div class="lm-scanner-placeholder" id="scan-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" />
                            <rect x="7" y="7" width="4" height="4" rx="0.5" stroke-width="1.5" />
                            <rect x="13" y="7" width="4" height="4" rx="0.5" stroke-width="1.5" />
                            <rect x="7" y="13" width="4" height="4" rx="0.5" stroke-width="1.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 15h4m0-2v4" />
                        </svg>
                        <span>Tekan tombol di bawah untuk<br>mengaktifkan kamera</span>
                    </div>

                    <div class="lm-scan-corners" id="scan-corners"></div>
                    <div class="lm-corner-tr" id="corner-tr"></div>
                    <div class="lm-corner-bl" id="corner-bl"></div>
                    <div class="lm-scan-line" id="scan-line"></div>

                    <div class="lm-scan-success" id="scan-success">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>QR Code Berhasil Dibaca</span>
                    </div>
                </div>

                <p class="lm-scan-status" id="scan-status">Siap memindai e-KTP Anda</p>

                <button type="button" class="lm-btn-camera" id="btn-camera">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Aktifkan Kamera
                </button>

                {{-- FORM --}}
                <form method="POST" action="{{ route('layanan-mandiri.masuk-ektp.proses') }}" id="lm-form">
                    @csrf

                    {{-- NIK (hidden, diisi otomatis dari QR) --}}
                    <input type="hidden" name="nik" id="nik-hidden">

                    {{-- NIK display (readonly) --}}
                    <div class="lm-field">
                        <div class="lm-field-label">NIK (dari QR Code)</div>
                        <div class="lm-input-wrap">
                            <span class="lm-input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                </svg>
                            </span>
                            <input type="text" id="nik-display" class="lm-input"
                                placeholder="NIK akan muncul setelah scan QR" readonly disabled>
                        </div>
                    </div>

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
                        <button type="submit" class="lm-btn lm-btn-primary" id="lm-submit" disabled>
                            MASUK
                        </button>
                        <a href="{{ route('layanan-mandiri.login') }}" class="lm-btn lm-btn-outline">
                            MASUK DENGAN NIK
                        </a>
                        <button type="button" class="lm-btn lm-btn-outline"
                            onclick="alert('Silakan hubungi operator desa untuk reset PIN Anda.')">
                            LUPA PIN
                        </button>
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

    {{-- jsQR library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsqr/1.4.0/jsQR.min.js"></script>

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

        /* ── QR SCANNER ────────────────────────── */
        const video = document.getElementById('lm-video');
        const canvas = document.getElementById('lm-canvas');
        const ctx = canvas.getContext('2d');
        const btnCamera = document.getElementById('btn-camera');
        const scanWrap = document.getElementById('scanner-wrap');
        const scanCorners = document.getElementById('scan-corners');
        const cornerTr = document.getElementById('corner-tr');
        const cornerBl = document.getElementById('corner-bl');
        const scanLine = document.getElementById('scan-line');
        const scanSuccess = document.getElementById('scan-success');
        const placeholder = document.getElementById('scan-placeholder');
        const statusEl = document.getElementById('scan-status');
        const nikHidden = document.getElementById('nik-hidden');
        const nikDisplay = document.getElementById('nik-display');
        const submitBtn = document.getElementById('lm-submit');

        let stream = null;
        let scanInterval = null;
        let nikFound = false;

        /**
         * Ekstrak NIK dari data QR Code e-KTP Indonesia.
         * Format QR e-KTP: data dipisah '|' dengan NIK di indeks ke-3 (0-based).
         * Fallback: cari string 16 digit angka.
         */
        function extractNIK(qrData) {
            // Format resmi e-KTP: NAMA|NIK|... atau NIK|...
            const parts = qrData.split('|');
            for (const part of parts) {
                const cleaned = part.trim();
                if (/^\d{16}$/.test(cleaned)) return cleaned;
            }
            // Fallback: cari 16 digit berurutan
            const match = qrData.match(/\b\d{16}\b/);
            return match ? match[0] : null;
        }

        function setStatus(msg, type = '') {
            statusEl.className = 'lm-scan-status' + (type ? ' ' + type : '');
            statusEl.textContent = msg;
        }

        function showScanning() {
            placeholder.style.opacity = '0';
            video.style.display = 'block';
            scanWrap.classList.add('active');
            scanCorners.classList.add('visible');
            cornerTr.style.display = 'block';
            cornerBl.style.display = 'block';
            scanLine.classList.add('visible');
            setStatus('Mendeteksi QR Code e-KTP…', 'scanning');
            btnCamera.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Matikan Kamera`;
        }

        function showFound(nik) {
            clearInterval(scanInterval);
            video.style.display = 'none';
            scanLine.classList.remove('visible');
            scanSuccess.classList.add('visible');
            scanWrap.classList.remove('active');
            scanWrap.classList.add('success');
            setStatus('NIK berhasil ditemukan: ' + nik, 'found');
            nikHidden.value = nik;
            nikDisplay.value = nik;
            nikDisplay.classList.add('is-filled');
            submitBtn.disabled = false;
            btnCamera.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Scan Ulang`;
            nikFound = true;
        }

        function resetScanner() {
            scanSuccess.classList.remove('visible');
            scanWrap.classList.remove('success');
            nikHidden.value = '';
            nikDisplay.value = '';
            nikDisplay.classList.remove('is-filled');
            submitBtn.disabled = true;
            nikFound = false;
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
            clearInterval(scanInterval);
            video.style.display = 'none';
            placeholder.style.opacity = '1';
            scanCorners.classList.remove('visible');
            cornerTr.style.display = 'none';
            cornerBl.style.display = 'none';
            scanLine.classList.remove('visible');
            scanWrap.classList.remove('active');
            setStatus('Siap memindai e-KTP Anda');
            btnCamera.innerHTML = `
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="15" height="15">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Aktifkan Kamera`;
        }

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: {
                            ideal: 640
                        },
                        height: {
                            ideal: 640
                        }
                    }
                });
                video.srcObject = stream;
                await video.play();
                showScanning();
                scanInterval = setInterval(scanFrame, 250);
            } catch (err) {
                setStatus('Gagal mengakses kamera: ' + (err.message || 'Izin ditolak'), 'error');
            }
        }

        function scanFrame() {
            if (video.readyState !== video.HAVE_ENOUGH_DATA) return;
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert'
            });
            if (code) {
                const nik = extractNIK(code.data);
                if (nik) {
                    showFound(nik);
                } else {
                    setStatus('QR terbaca tapi NIK tidak ditemukan, coba lagi…', 'error');
                }
            }
        }

        btnCamera.addEventListener('click', async () => {
            if (nikFound) {
                // Scan ulang
                resetScanner();
                scanSuccess.classList.remove('visible');
                await startCamera();
            } else if (stream) {
                stopCamera();
            } else {
                await startCamera();
            }
        });

        // Stop camera saat keluar halaman
        window.addEventListener('beforeunload', stopCamera);
    </script>
</body>

</html>
