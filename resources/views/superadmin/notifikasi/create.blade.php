@extends('superadmin.layout.superadmin')

@section('title', 'Kirim Pesan')
@section('header', 'Kirim Pesan')
@section('subheader', 'Komunikasi internal ke Admin & Operator')

@section('content')

<style>
    .form-wrap {
        min-height: calc(100vh - 60px - 56px); /* tinggi layar dikurangi topbar & padding */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 0;
    }

    .form-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        width: 100%;
        max-width: 600px;
    }

    .form-header {
        padding: 22px 28px;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .form-header-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: #eff6ff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .form-body { padding: 26px 28px; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.01em;
    }
    .form-label .req { color: #ef4444; }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-size: 13.5px;
        color: #111827;
        background: #fafafa;
        border: 1px solid #e9eaec;
        border-radius: 11px;
        outline: none;
        transition: all 0.16s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .form-control:focus {
        background: #fff;
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .form-control::placeholder { color: #c8cdd6; }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.65;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px;
        cursor: pointer;
    }

    .hint-text {
        font-size: 11px;
        color: #b0b7c3;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-divider { height: 1px; background: #f5f5f5; }

    .form-footer {
        padding: 16px 28px;
        border-top: 1px solid #f5f5f5;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .btn-reset {
        padding: 9px 18px;
        font-size: 12.5px; font-weight: 600;
        color: #6b7280;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-reset:hover { background: #f3f4f6; color: #374151; border-color: #d1d5db; }

    .btn-send {
        padding: 9px 20px;
        font-size: 12.5px; font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        border-radius: 9px;
        cursor: pointer;
        display: flex; align-items: center; gap: 7px;
        box-shadow: 0 2px 10px rgba(59,130,246,0.28);
        transition: all 0.16s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .btn-send:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        box-shadow: 0 4px 16px rgba(59,130,246,0.38);
        transform: translateY(-1px);
    }
    .btn-send:active { transform: translateY(0); }

    .alert-success {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 11px;
        font-size: 12.5px; font-weight: 600; color: #15803d;
    }
</style>

<div class="form-wrap">
    <div class="form-card">

        {{-- Header --}}
        <div class="form-header">
            <div class="form-header-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </div>
            <div>
                <p style="font-size:14px; font-weight:700; color:#111827;">Tulis Pesan Baru</p>
                <p style="font-size:11.5px; color:#9ca3af; margin-top:2px;">Komunikasi internal khusus pengelola sistem.</p>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
        <div style="padding: 18px 28px 0;">
            <div class="alert-success">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('superadmin.notifikasi.store') }}" method="POST">
            @csrf

            <div class="form-body space-y-5">

                {{-- Penerima --}}
                <div class="form-group">
                    <label class="form-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        Penerima <span class="req">*</span>
                    </label>
                    <select name="receiver_id" class="form-control">
                        <option value="">— Kirim ke Semua Admin &amp; Operator —</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }} &nbsp;·&nbsp; {{ strtoupper($admin->role) }}</option>
                        @endforeach
                    </select>
                    <p class="hint-text">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Biarkan kosong untuk broadcast ke semua
                    </p>
                </div>

                <div class="form-divider"></div>

                {{-- Subjek --}}
                <div class="form-group">
                    <label class="form-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" y1="6" x2="20" y2="6"/>
                            <line x1="4" y1="12" x2="14" y2="12"/>
                            <line x1="4" y1="18" x2="18" y2="18"/>
                        </svg>
                        Subjek / Judul <span class="req">*</span>
                    </label>
                    <input
                        type="text"
                        name="judul"
                        required
                        placeholder="Contoh: Jadwal Maintenance Server"
                        class="form-control"
                        value="{{ old('judul') }}"
                    >
                </div>

                {{-- Isi Pesan --}}
                <div class="form-group">
                    <label class="form-label">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Isi Pesan <span class="req">*</span>
                    </label>
                    <textarea
                        name="pesan"
                        rows="5"
                        required
                        placeholder="Tuliskan pesan koordinasi di sini..."
                        class="form-control"
                    >{{ old('pesan') }}</textarea>
                </div>

            </div>

            {{-- Footer --}}
            <div class="form-footer">
                <p style="font-size:11px; color:#c0c5cc;">
                    <span style="color:#ef4444;">*</span> Wajib diisi
                </p>
                <div style="display:flex; align-items:center; gap:10px;">
                    <button type="reset" class="btn-reset">Reset</button>
                    <button type="submit" class="btn-send">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Pesan
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection