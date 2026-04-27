<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri – {{ $identitas->nama_desa ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0d4f3c;
        }

        /* ── LEFT PANEL ─────────────────────────────────────────── */
        .lm-left {
            width: 42%;
            min-height: 100vh;
            background: linear-gradient(160deg, #0f7a5a 0%, #0a5c43 40%, #073d2c 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        /* decorative rings */
        .lm-left::before,
        .lm-left::after {
            content: '';
            position: absolute;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.07);
            pointer-events: none;
        }
        .lm-left::before {
            width: 500px; height: 500px;
            top: -120px; left: -120px;
        }
        .lm-left::after {
            width: 350px; height: 350px;
            bottom: -80px; right: -80px;
        }

        .lm-left-inner {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .lm-logo-wrap {
            width: 88px; height: 88px;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(6px);
            overflow: hidden;
        }
        .lm-logo-wrap img {
            width: 64px; height: 64px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }
        .lm-logo-placeholder {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -1px;
        }

        .lm-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            line-height: 1.2;
            text-transform: uppercase;
        }
        .lm-desa-name {
            font-size: 1.75rem;
            font-weight: 800;
            color: #6ee7c0;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            margin-top: 0.2rem;
        }

        .lm-divider {
            width: 48px; height: 3px;
            background: rgba(255,255,255,0.25);
            border-radius: 99px;
            margin: 1.25rem auto;
        }

        .lm-info {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.8;
        }
        .lm-info strong {
            color: rgba(255,255,255,0.85);
            font-weight: 600;
        }

        .lm-notice {
            margin-top: 1.75rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            padding: 0.9rem 1.1rem;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.6;
            text-align: left;
        }
        .lm-notice svg {
            width: 14px; height: 14px;
            display: inline-block;
            vertical-align: middle;
            margin-right: 4px;
            flex-shrink: 0;
            color: #6ee7c0;
        }
        .lm-notice-row {
            display: flex;
            align-items: flex-start;
            gap: 0.35rem;
        }

        .lm-ip-info {
            margin-top: 1.5rem;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.3);
            line-height: 1.7;
        }
        .lm-copy-btn {
            background: none; border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.4);
            padding: 0;
            vertical-align: middle;
            margin-left: 3px;
            transition: color 0.15s;
        }
        .lm-copy-btn:hover { color: rgba(255,255,255,0.7); }

        /* ── RIGHT PANEL ─────────────────────────────────────────── */
        .lm-right {
            flex: 1;
            background: #f8fafb;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            min-height: 100vh;
        }

        .lm-form-card {
            width: 100%;
            max-width: 380px;
        }

        .lm-form-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a2e27;
            margin-bottom: 0.35rem;
            text-align: center;
        }
        .lm-form-sub {
            font-size: 0.78rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
        }

        .lm-field {
            margin-bottom: 1rem;
        }
        .lm-field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .lm-input-wrap {
            position: relative;
        }
        .lm-input-wrap svg {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: #9ca3af;
            pointer-events: none;
        }
        .lm-input {
            width: 100%;
            padding: 0.75rem 0.85rem 0.75rem 2.5rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: inherit;
            background: #fff;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .lm-input:focus {
            border-color: #0f7a5a;
            box-shadow: 0 0 0 3px rgba(15,122,90,0.12);
        }
        .lm-input::placeholder { color: #9ca3af; }

        /* PIN toggle */
        .lm-pin-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }
        .lm-pin-toggle:hover { color: #0f7a5a; }
        .lm-pin-toggle svg { width: 17px; height: 17px; }

        .lm-show-pin {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.5rem;
        }
        .lm-show-pin input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: #0f7a5a;
            cursor: pointer;
        }
        .lm-show-pin label {
            font-size: 0.78rem;
            color: #6b7280;
            cursor: pointer;
        }

        /* Error */
        .lm-alert {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            font-size: 0.8rem;
            color: #dc2626;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .lm-alert svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }

        /* Buttons */
        .lm-btn {
            display: block;
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: none;
            font-size: 0.875rem;
            font-weight: 700;
            font-family: inherit;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .lm-btn-primary {
            background: #0f7a5a;
            color: #fff;
            box-shadow: 0 4px 14px rgba(15,122,90,0.25);
            margin-bottom: 0.7rem;
        }
        .lm-btn-primary:hover {
            background: #0a5c43;
            box-shadow: 0 6px 18px rgba(15,122,90,0.35);
            transform: translateY(-1px);
        }
        .lm-btn-primary:active { transform: translateY(0); }

        .lm-btn-outline {
            background: #fff;
            color: #0f7a5a;
            border: 1.5px solid #0f7a5a;
            margin-bottom: 0.7rem;
        }
        .lm-btn-outline:hover {
            background: #f0fdf8;
            transform: translateY(-1px);
        }

        .lm-btn-ghost {
            background: transparent;
            color: #6b7280;
            border: 1.5px solid #e5e7eb;
        }
        .lm-btn-ghost:hover {
            background: #f9fafb;
            color: #374151;
        }

        .lm-separator {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0.5rem 0 0.75rem;
        }
        .lm-separator-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }
        .lm-separator span {
            font-size: 0.7rem;
            color: #9ca3af;
            white-space: nowrap;
        }

        .lm-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.7rem;
            color: #9ca3af;
        }
        .lm-footer a {
            color: #0f7a5a;
            text-decoration: none;
            font-weight: 600;
        }
        .lm-footer a:hover { text-decoration: underline; }

        /* ── RESPONSIVE ───────────────────────────────────────────── */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .lm-left {
                width: 100%;
                min-height: auto;
                padding: 2.5rem 1.5rem 2rem;
            }
            .lm-title { font-size: 1.25rem; }
            .lm-desa-name { font-size: 1.35rem; }
            .lm-right {
                padding: 2rem 1.5rem;
            }
        }

        /* Loading spinner on submit */
        .lm-btn-primary.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        .lm-spinner {
            display: inline-block;
            width: 14px; height: 14px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 6px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Fade-in animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .lm-form-card { animation: fadeUp 0.45s ease both; }
        .lm-left-inner { animation: fadeUp 0.4s ease 0.05s both; }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════════════
         LEFT — Identitas Desa
    ════════════════════════════════════════════════════ --}}
    @php
        $identitas = \App\Models\IdentitasDesa::first();
        $logoPath  = optional($identitas)->logo_desa
            ? storage_path('app/public/logo-desa/' . $identitas->logo_desa)
            : null;
        $hasLogo   = $logoPath && file_exists($logoPath);
    @endphp

    <div class="lm-left">
        <div class="lm-left-inner">

            {{-- Logo --}}
            <div class="lm-logo-wrap">
                @if($hasLogo)
                    <img src="{{ asset('storage/logo-desa/' . $identitas->logo_desa) }}"
                         alt="Logo Desa">
                @else
                    <span class="lm-logo-placeholder">
                        {{ strtoupper(substr(optional($identitas)->nama_desa ?? 'D', 0, 1)) }}
                    </span>
                @endif
            </div>

            {{-- Judul --}}
            <div class="lm-title">Layanan Mandiri</div>
            <div class="lm-desa-name">{{ optional($identitas)->nama_desa ?? 'Desa' }}</div>

            <div class="lm-divider"></div>

            {{-- Info desa --}}
            <div class="lm-info">
                @if(optional($identitas)->kecamatan)
                    <div>Kecamatan <strong>{{ $identitas->kecamatan }}</strong></div>
                @endif
                @if(optional($identitas)->kabupaten)
                    <div>Kabupaten <strong>{{ $identitas->kabupaten }}</strong></div>
                @endif
                @if(optional($identitas)->kode_pos)
                    <div>Kodepos <strong>{{ $identitas->kode_pos }}</strong></div>
                @endif
            </div>

            {{-- Petunjuk --}}
            <div class="lm-notice">
                <div class="lm-notice-row">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Gunakan NIK dan PIN yang diberikan oleh operator desa untuk masuk.</span>
                </div>
            </div>

            {{-- IP & ID Pengunjung --}}
            <div class="lm-ip-info">
                <div>IP Address: <strong id="lm-ip">{{ request()->ip() }}</strong></div>
                <div>
                    ID Pengunjung:
                    <strong id="lm-visitor-id">{{ substr(md5(request()->ip() . session()->getId()), 0, 32) }}</strong>
                    <button class="lm-copy-btn" onclick="copyText('lm-visitor-id')" title="Salin ID">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         RIGHT — Form Login
    ════════════════════════════════════════════════════ --}}
    <div class="lm-right">
        <div class="lm-form-card">

            <div class="lm-form-title">Masuk ke Layanan Mandiri</div>
            <div class="lm-form-sub">Masukkan NIK dan PIN Anda untuk melanjutkan</div>

            {{-- Alert Error --}}
            @if($errors->any())
                <div class="lm-alert">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="lm-alert">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('layanan-mandiri.login') }}" id="lm-form">
                @csrf

                {{-- NIK --}}
                <div class="lm-field">
                    <label for="nik">NIK</label>
                    <div class="lm-input-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c0 1.306.835 2.418 2 2.83V19h-2v1h6v-1h-2v-1.17A3.001 3.001 0 0015 14"/>
                        </svg>
                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            class="lm-input"
                            placeholder="Masukkan 16 digit NIK"
                            value="{{ old('nik') }}"
                            maxlength="16"
                            inputmode="numeric"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>
                </div>

                {{-- PIN --}}
                <div class="lm-field">
                    <label for="pin">PIN</label>
                    <div class="lm-input-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input
                            type="password"
                            id="pin"
                            name="pin"
                            class="lm-input"
                            placeholder="Masukkan PIN Anda"
                            maxlength="20"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="lm-pin-toggle" id="toggle-pin" title="Tampilkan PIN">
                            <svg id="eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>

                    <div class="lm-show-pin">
                        <input type="checkbox" id="show-pin-check">
                        <label for="show-pin-check">Tampilkan PIN</label>
                    </div>
                </div>

                {{-- Tombol MASUK --}}
                <button type="submit" class="lm-btn lm-btn-primary" id="lm-submit">
                    MASUK
                </button>

                {{-- Lupa PIN --}}
                <button type="button" class="lm-btn lm-btn-ghost"
                        onclick="alert('Silakan hubungi operator desa untuk reset PIN Anda.')">
                    LUPA PIN
                </button>

            </form>

            {{-- Footer --}}
            <div class="lm-footer">
                <p>Login sebagai Administrator?
                    <a href="{{ route('login') }}">Halaman Admin</a>
                </p>
                <p style="margin-top:0.5rem; color: #d1d5db;">
                    &copy; {{ date('Y') }} {{ optional($identitas)->nama_desa ?? config('app.name') }}
                </p>
            </div>

        </div>
    </div>

    <script>
        // Toggle PIN visibility (button icon)
        const pinInput   = document.getElementById('pin');
        const toggleBtn  = document.getElementById('toggle-pin');
        const eyeOpen    = document.getElementById('eye-open');
        const eyeClosed  = document.getElementById('eye-closed');
        const pinCheck   = document.getElementById('show-pin-check');

        function setPinVisibility(show) {
            pinInput.type   = show ? 'text' : 'password';
            eyeOpen.style.display   = show ? 'none' : 'block';
            eyeClosed.style.display = show ? 'block' : 'none';
            pinCheck.checked = show;
        }

        toggleBtn.addEventListener('click', () => setPinVisibility(pinInput.type === 'password'));
        pinCheck.addEventListener('change', () => setPinVisibility(pinCheck.checked));

        // Loading spinner on submit
        document.getElementById('lm-form').addEventListener('submit', function () {
            const btn = document.getElementById('lm-submit');
            btn.classList.add('loading');
            btn.innerHTML = '<span class="lm-spinner"></span> Memproses...';
        });

        // NIK — hanya angka
        document.getElementById('nik').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });

        // Copy to clipboard
        function copyText(elId) {
            const text = document.getElementById(elId)?.innerText || '';
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.currentTarget;
                btn.title = 'Tersalin!';
                setTimeout(() => { btn.title = 'Salin ID'; }, 1500);
            }).catch(() => {});
        }
    </script>
</body>
</html>