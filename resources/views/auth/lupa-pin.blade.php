<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa PIN – {{ $identitas->nama_desa ?? config('app.name') }}</title>
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

        .lm-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: var(--em-900);
        }

        .lm-bg.has-img { background-size: cover; background-position: center; }

        .lm-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(16, 185, 129, 0.25) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 80% 30%, rgba(5, 150, 105, 0.2) 0%, transparent 65%);
        }

        .lm-bg.has-img::after { background: rgba(4, 47, 30, 0.72); }

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
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
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
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            top: -80px; right: -80px;
        }

        .lm-left::after {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            bottom: -50px; left: -50px;
        }

        .lm-left-inner { position: relative; z-index: 2; width: 100%; }

        .lm-logo-wrap {
            width: 92px; height: 92px;
            margin: 0 auto 1.25rem;
            border-radius: 50%;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.18);
            border: 2.5px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .lm-logo-wrap img { width: 68px; height: 68px; object-fit: contain; }

        .lm-logo-placeholder { font-size: 2.6rem; font-weight: 800; color: #fff; line-height: 1; }

        .lm-label {
            font-size: 0.72rem; font-weight: 600;
            color: rgba(255, 255, 255, 0.75);
            letter-spacing: 2.5px; text-transform: uppercase;
            margin-bottom: 0.35rem;
        }

        .lm-desa-name {
            font-size: 1.5rem; font-weight: 800;
            color: #fff; text-transform: uppercase;
            letter-spacing: 0.5px; line-height: 1.2;
            margin-bottom: 0.85rem;
        }

        .lm-divider {
            width: 36px; height: 2px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 99px;
            margin: 0 auto 0.85rem;
        }

        .lm-info {
            font-size: 0.83rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.85; margin-bottom: 1.25rem;
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
            background: none; border: none; cursor: pointer;
            color: rgba(255, 255, 255, 0.35);
            padding: 0; vertical-align: middle; margin-left: 3px;
            transition: color 0.15s;
        }
        .lm-copy-btn:hover { color: rgba(255, 255, 255, 0.7); }

        /* ── RIGHT PANEL ──────────────────────── */
        .lm-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .lm-form-wrap {
            width: 100%;
            max-width: 320px;
            animation: fadeUp 0.45s 0.1s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .lm-form-title {
            font-size: 1.25rem; font-weight: 700;
            color: #1a2e22; margin-bottom: 0.2rem;
        }

        .lm-form-sub {
            font-size: 0.8rem; color: #8a9ba0;
            margin-bottom: 1.75rem;
        }

        /* Alert */
        .lm-alert {
            background: #fef3c7;
            border-left: 3px solid #f59e0b;
            border-radius: 6px;
            padding: 0.6rem 0.85rem;
            margin-bottom: 1.25rem;
            font-size: 0.8rem; color: #92400e;
        }
        .lm-alert-danger  { background: #fef2f2; border-left-color: #ef4444; color: #991b1b; }
        .lm-alert-success { background: #f0fdf4; border-left-color: #22c55e; color: #166534; }
        .lm-alert-info    { background: #eff6ff; border-left-color: #3b82f6; color: #1e40af; }

        /* Fields */
        .lm-field { margin-bottom: 1rem; }

        .lm-input-wrap { position: relative; }

        .lm-input-icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af; pointer-events: none; display: flex;
        }
        .lm-input-icon svg { width: 16px; height: 16px; }

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
        .lm-input::placeholder { color: #c0c9cc; }
        .lm-input:focus {
            border-color: var(--em-500);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
        }
        .lm-input.is-error { border-color: #ef4444; }

        .lm-error-msg {
            font-size: 0.73rem; color: #ef4444;
            margin-top: 4px; padding-left: 2px;
        }

        /* ── CHANNEL BUTTONS ──────────────────── */
        .lm-channel-label {
            font-size: 0.73rem; font-weight: 600;
            color: #6b7280; margin-bottom: 0.6rem;
        }

        .lm-channels {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
            margin-bottom: 1.25rem;
        }

        .lm-channel-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            font-family: inherit;
            text-align: left;
            cursor: pointer;
            transition: all 0.18s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            border: 2px solid var(--em-600);
            background: transparent;
            color: var(--em-600);
            position: relative;
        }

        .lm-channel-btn:hover {
            background: var(--em-600);
            color: #fff;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        }

        .lm-channel-btn svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* Telegram icon color */
        .lm-channel-btn.telegram svg { color: #2ca5e0; }
        .lm-channel-btn.telegram:hover svg { color: #fff; }

        /* Email icon color */
        .lm-channel-btn.email svg { color: #f59e0b; }
        .lm-channel-btn.email:hover svg { color: #fff; }

        /* Badge "tidak tersedia" */
        .lm-channel-btn .lm-unavail {
            margin-left: auto;
            font-size: 0.62rem;
            font-weight: 600;
            color: #9ca3af;
            background: #f3f4f6;
            border-radius: 4px;
            padding: 2px 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.18s;
        }

        .lm-channel-btn:hover .lm-unavail {
            background: rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
        }

        /* Divider */
        .lm-sep {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin: 1rem 0;
            color: #d1d5db;
            font-size: 0.72rem;
            font-weight: 500;
        }
        .lm-sep::before,
        .lm-sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        /* Nav buttons */
        .lm-btn {
            display: block; width: 100%;
            padding: 0.68rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem; font-weight: 700;
            font-family: inherit; text-align: center;
            cursor: pointer; transition: all 0.18s;
            letter-spacing: 0.8px; text-transform: uppercase;
            text-decoration: none;
            border: 2px solid var(--em-600);
        }
        .lm-btn + .lm-btn { margin-top: 0.55rem; }
        .lm-btn-outline { background: transparent; color: var(--em-600); }
        .lm-btn-outline:hover {
            background: var(--em-600); color: #fff;
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3);
        }

        .lm-btn.loading { opacity: 0.72; pointer-events: none; }

        .lm-spinner {
            display: inline-block; width: 13px; height: 13px;
            border: 2px solid currentColor; border-top-color: transparent;
            border-radius: 50%; animation: spin 0.7s linear infinite;
            vertical-align: middle; margin-right: 5px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .lm-footer {
            margin-top: 1.5rem; text-align: center;
            font-size: 0.75rem; color: #9ca3af; line-height: 1.85;
        }
        .lm-footer a { color: var(--em-600); text-decoration: none; font-weight: 600; }
        .lm-footer a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ───────────────────────── */
        @media (max-width: 700px) {
            body { padding: 0; align-items: stretch; }
            .lm-card { flex-direction: column; border-radius: 0; min-height: 100vh; box-shadow: none; }
            .lm-left { width: 100%; padding: 2.5rem 1.5rem 2rem; min-height: auto; }
            .lm-right { padding: 2rem 1.5rem 2.5rem; }
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

        // Cek apakah channel tersedia
        $adaTelegram = optional($pengaturan)->telegram_bot_token && optional($pengaturan)->telegram_chat_id;
        $adaEmail    = optional($pengaturan)->smtp_host || config('mail.mailers.smtp.host');
    @endphp

    <div class="lm-bg{{ $hasLatar ? ' has-img' : '' }}"
        @if ($hasLatar) style="background-image: url('{{ asset('storage/layanan-mandiri/' . $latarLogin) }}')" @endif>
    </div>

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
                    Masukkan NIK Anda, lalu pilih metode pengiriman PIN baru.
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

                <div class="lm-form-title">Lupa PIN</div>
                <div class="lm-form-sub">Masukkan NIK, lalu pilih cara pengiriman PIN baru</div>

                @if ($errors->any())
                    <div class="lm-alert lm-alert-danger">{{ $errors->first() }}</div>
                @endif
                @if (session('error'))
                    <div class="lm-alert lm-alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="lm-alert lm-alert-success">{{ session('success') }}</div>
                @endif

                {{-- Form NIK --}}
                <form method="POST" action="{{ route('layanan-mandiri.lupa-pin.kirim') }}" id="lm-form">
                    @csrf

                    {{-- Channel (diisi saat klik tombol) --}}
                    <input type="hidden" name="channel" id="channel-input">

                    {{-- NIK --}}
                    <div class="lm-field">
                        <div class="lm-input-wrap">
                            <span class="lm-input-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                </svg>
                            </span>
                            <input type="text" id="nik" name="nik"
                                class="lm-input{{ $errors->has('nik') ? ' is-error' : '' }}"
                                placeholder="Masukkan NIK 16 digit"
                                value="{{ old('nik') }}"
                                maxlength="16" inputmode="numeric"
                                autocomplete="off" required autofocus>
                        </div>
                        @error('nik')
                            <div class="lm-error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Channel --}}
                    <div class="lm-channel-label">Kirim PIN baru via:</div>
                    <div class="lm-channels">

                        {{-- Telegram --}}
                        <button type="submit" class="lm-channel-btn telegram" id="btn-telegram"
                            onclick="setChannel('telegram')"
                            {{ !$adaTelegram ? 'title=Telegram belum dikonfigurasi' : '' }}>
                            {{-- Telegram icon --}}
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.447 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.12l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.194 1.006.131.833.941z"/>
                            </svg>
                            Telegram
                            @if (!$adaTelegram)
                                <span class="lm-unavail">Belum diatur</span>
                            @endif
                        </button>

                        {{-- Email --}}
                        <button type="submit" class="lm-channel-btn email" id="btn-email"
                            onclick="setChannel('email')"
                            {{ !$adaEmail ? 'title=Email belum dikonfigurasi' : '' }}>
                            {{-- Mail icon --}}
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email
                            @if (!$adaEmail)
                                <span class="lm-unavail">Belum diatur</span>
                            @endif
                        </button>

                    </div>

                </form>

                <div class="lm-sep">atau</div>

                {{-- Navigasi --}}
                <a href="{{ route('layanan-mandiri') }}" class="lm-btn lm-btn-outline">
                    MASUK DENGAN NIK
                </a>

                @if (optional($pengaturan)->tampilkan_ektp === 'Ya')
                    <a href="{{ route('layanan-mandiri.masuk-ektp') }}" class="lm-btn lm-btn-outline" style="margin-top:0.55rem">
                        MASUK DENGAN E-KTP
                    </a>
                @endif

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
        function copyText(elId) {
            const text = document.getElementById(elId)?.innerText || '';
            navigator.clipboard.writeText(text).catch(() => {});
        }

        function setChannel(ch) {
            document.getElementById('channel-input').value = ch;
            const btn = ch === 'telegram'
                ? document.getElementById('btn-telegram')
                : document.getElementById('btn-email');
            btn.innerHTML = btn.innerHTML.replace(
                /^(<svg[\s\S]*?<\/svg>)\s*/,
                '$1 <span class="lm-spinner"></span> '
            );
        }

        document.getElementById('nik').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>
</body>

</html>