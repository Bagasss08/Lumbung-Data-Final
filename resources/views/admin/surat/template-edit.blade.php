@extends('layouts.admin')

@section('title', 'Edit Template Surat')

@section('content')
<style>
/* ─── Tom Select Override ─── */
.ts-wrapper { width: 100%; }
.ts-control {
    width: 100% !important;
    min-height: 42px !important; /* FIX: Mencegah kotak menciut/gepeng saat diklik & kosong */
    padding: .58rem .95rem !important;
    font-size: .875rem !important;
    color: #1e293b !important;
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 9px !important;
    box-shadow: none !important;
    cursor: text !important;
    display: flex !important;
    flex-wrap: nowrap !important;
    align-items: center !important;
}
.ts-wrapper.focus .ts-control {
    border-color: #6ea8fe !important;
    background: #fff !important;
    box-shadow: 0 0 0 3.5px rgba(37,99,235,.1) !important;
}
.ts-control input {
    font-size: .875rem !important;
    color: #1e293b !important;
    padding: 0 !important;
    margin: 0 !important;
    min-width: 80px !important;
}
.ts-control input::placeholder { color: #b0bad0 !important; }
.ts-wrapper .item {
    font-size: .875rem !important;
    color: #1e293b !important;
    background: none !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    font-weight: 500;
    display: flex !important;
    align-items: center !important;
    gap: .45rem !important;
}
.ts-dropdown {
    border: 1.5px solid #dde3ec !important;
    border-radius: 12px !important;
    box-shadow: 0 12px 32px rgba(15,23,42,.13), 0 2px 8px rgba(15,23,42,.06) !important;
    margin-top: 6px !important;
    overflow: hidden !important;
    background: #fff !important;
    padding: 5px !important;
    z-index: 9999 !important;
}
.ts-dropdown-content { max-height: 240px !important; padding: 0 !important; }
.ts-dropdown .option {
    padding: .6rem .85rem !important;
    font-size: .845rem !important;
    color: #374151 !important;
    border-radius: 8px !important;
    margin: 1px 0 !important;
    transition: background .12s !important;
    display: flex !important;
    align-items: center !important;
    gap: .6rem !important;
    cursor: pointer !important;
}
.ts-opt-code {
    display: inline-flex; align-items: center;
    background: #eff6ff; color: #2563eb;
    font-size: .72rem; font-weight: 700;
    padding: .1rem .45rem; border-radius: 5px;
    flex-shrink: 0; letter-spacing: .01em;
    border: 1px solid #bfdbfe;
}
.ts-opt-name { color: #374151; font-size: .845rem; }
.ts-dropdown .option:hover,
.ts-dropdown .option.active { background: #eff6ff !important; }
.ts-dropdown .option:hover .ts-opt-name,
.ts-dropdown .option.active .ts-opt-name { color: #1d4ed8 !important; }
.ts-dropdown .option.selected { background: #dbeafe !important; }
.ts-dropdown .option.selected .ts-opt-code { background: #2563eb; color: #fff; border-color: #2563eb; }
.ts-dropdown .option.selected .ts-opt-name { color: #1e40af !important; font-weight: 600; }
.ts-dropdown .no-results { padding: 1rem !important; font-size: .82rem !important; color: #94a3b8 !important; text-align: center !important; border-radius: 8px !important; }

/* ─── Reset & Base ─── */
.te * { box-sizing: border-box; }

/* ─── Page Header ─── */
.te-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2rem;
    gap: 1rem;
}
.te-header-left h1 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 .2rem;
    letter-spacing: -.02em;
}
.te-header-left p {
    font-size: .83rem;
    color: #64748b;
    margin: 0;
}
.te-header-left p strong { color: #1e40af; }

.te-breadcrumb {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .75rem;
    color: #94a3b8;
    background: #f1f5f9;
    padding: .4rem .85rem;
    border-radius: 99px;
    white-space: nowrap;
}
.te-breadcrumb a { color: #94a3b8; text-decoration: none; transition: color .15s; }
.te-breadcrumb a:hover { color: #2563eb; }
.te-breadcrumb .sep { color: #cbd5e1; font-size: .7rem; }
.te-breadcrumb .current { color: #475569; font-weight: 500; }

/* ─── Two Column Layout ─── */
.te-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 900px) {
    .te-layout { grid-template-columns: 1fr; }
    .te-sidebar { order: -1; }
}

/* ─── Cards ─── */
.te-card {
    background: #fff;
    border: 1px solid #e8edf3;
    border-radius: 14px;
    box-shadow: 0 1px 3px rgba(15,23,42,.05), 0 4px 20px rgba(15,23,42,.04);
}
.te-card-header {
    padding: 1.1rem 1.4rem;
    border-radius: 14px 14px 0 0;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: .65rem;
    background: #fafbfc;
}
.te-card-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.te-card-icon.blue  { background: #eff6ff; color: #2563eb; }
.te-card-icon.indigo { background: #eef2ff; color: #4f46e5; }
.te-card-icon.violet { background: #f5f3ff; color: #7c3aed; }
.te-card-icon.emerald { background: #ecfdf5; color: #059669; }
.te-card-header-text h3 {
    font-size: .88rem; font-weight: 700; color: #1e293b; margin: 0;
}
.te-card-header-text p {
    font-size: .74rem; color: #94a3b8; margin: 0;
}
.te-card-body { padding: 1.4rem; }

/* ─── Form Fields ─── */
.te-field { margin-bottom: 1.1rem; }
.te-field:last-child { margin-bottom: 0; }

.te-label {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .45rem;
}
.te-label .req {
    font-size: .65rem; color: #fff;
    background: #ef4444; border-radius: 3px;
    padding: .05rem .3rem; font-weight: 700;
    line-height: 1.5;
}
.te-label .opt {
    font-size: .68rem; color: #94a3b8;
    font-weight: 400;
}

.te-input, .te-select {
    width: 100%;
    padding: .6rem .95rem;
    font-size: .875rem;
    color: #1e293b;
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    outline: none;
    transition: all .18s;
}
.te-input::placeholder { color: #b0bad0; }
.te-input:hover, .te-select:hover { border-color: #c7d2e7; background: #fff; }
.te-input:focus, .te-select:focus {
    border-color: #6ea8fe;
    background: #fff;
    box-shadow: 0 0 0 3.5px rgba(37,99,235,.1);
}

/* Input row helper */
.te-row { display: grid; gap: .9rem; }
.te-row-31 { grid-template-columns: 2fr 1fr; }
@media (max-width: 520px) {
    .te-row-31 { grid-template-columns: 1fr; }
}

/* ─── Status Toggle ─── */
.te-status-group { display: flex; gap: .5rem; }
.te-status-opt { flex: 1; }
.te-status-opt input[type=radio] { display: none; }
.te-status-opt label {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    padding: .55rem .5rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    font-size: .82rem; font-weight: 500;
    color: #64748b;
    cursor: pointer;
    transition: all .18s;
    background: #f8fafc;
}
.te-status-opt label:hover { border-color: #c7d2e7; background: #fff; }
.te-status-opt input:checked + label {
    border-color: transparent;
    font-weight: 600;
}
.te-status-opt.is-aktif input:checked + label  { background: #dcfce7; color: #16a34a; border-color: #bbf7d0; }
.te-status-opt.is-noaktif input:checked + label { background: #fee2e2; color: #dc2626; border-color: #fecaca; }
.te-status-dot {
    width: 7px; height: 7px; border-radius: 50%;
    flex-shrink: 0;
}
.is-aktif .te-status-dot   { background: #22c55e; }
.is-noaktif .te-status-dot { background: #f87171; }

/* ─── Persyaratan ─── */
.te-syarat-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: .4rem;
}
.te-syarat-item {
    display: flex; align-items: center; gap: .7rem;
    padding: .6rem .85rem;
    border: 1.5px solid #e8edf3;
    border-radius: 9px;
    background: #f8fafc;
    cursor: pointer;
    transition: all .15s;
    user-select: none;
}
.te-syarat-item:hover { border-color: #bfdbfe; background: #eff6ff; }
.te-syarat-item:has(input:checked) {
    border-color: #93c5fd;
    background: #eff6ff;
}
.te-syarat-item input[type=checkbox] {
    accent-color: #2563eb; width: 15px; height: 15px; flex-shrink: 0;
    cursor: pointer;
}
.te-syarat-item span {
    font-size: .81rem; color: #374151; line-height: 1.3;
}
.te-syarat-item:has(input:checked) span { color: #1d4ed8; font-weight: 500; }

/* ─── Editor ─── */
.te-editor-wrap {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .18s, box-shadow .18s;
    background: #f8fafc;
}
.te-editor-wrap.focused {
    border-color: #6ea8fe;
    box-shadow: 0 0 0 3.5px rgba(37,99,235,.1);
    background: #fff;
}

/* ─── Action Bar ─── */
.te-action-bar {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; padding-top: 1.2rem;
    border-top: 1px solid #f1f5f9;
    margin-top: 1.5rem;
}
.te-hint { font-size: .75rem; color: #b0bad0; margin: 0; }

/* ─── Buttons ─── */
.te-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .58rem 1.25rem;
    font-size: .84rem; font-weight: 600;
    border-radius: 9px; border: 1.5px solid transparent;
    cursor: pointer; text-decoration: none; white-space: nowrap;
    transition: all .18s;
    line-height: 1;
}
.te-btn svg { flex-shrink: 0; }
.te-btn-ghost { background: #fff; border-color: #e2e8f0; color: #64748b; }
.te-btn-ghost:hover { background: #f8fafc; border-color: #c7d2e7; color: #1e293b; }
.te-btn-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    border-color: #2563eb; color: #fff;
    box-shadow: 0 2px 8px rgba(37,99,235,.3);
}
.te-btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    box-shadow: 0 4px 14px rgba(37,99,235,.4);
    color: #fff;
    transform: translateY(-1px);
}
.te-btn-primary:active { transform: scale(.98); box-shadow: none; }

/* ─── Alert ─── */
.te-alert-err {
    background: #fef2f2; border: 1.5px solid #fecaca;
    border-radius: 10px; padding: .9rem 1.1rem; margin-bottom: 1.4rem;
    display: flex; gap: .75rem;
}
.te-alert-err-icon { flex-shrink: 0; margin-top: .05rem; }
.te-alert-err-title { font-weight: 700; font-size: .84rem; color: #dc2626; margin-bottom: .3rem; }
.te-alert-err ul { margin: 0; padding-left: 1.1rem; }
.te-alert-err li { font-size: .81rem; color: #b91c1c; }

/* ─── Sidebar Info Block ─── */
.te-info-block {
    display: flex; gap: .65rem; align-items: flex-start;
    padding: .8rem;
    background: #f8fafc;
    border: 1px solid #e8edf3;
    border-radius: 9px;
    margin-bottom: .65rem;
}
.te-info-block:last-child { margin-bottom: 0; }
.te-info-block-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: .85rem;
}
.te-info-block-text { font-size: .77rem; color: #64748b; line-height: 1.5; }
.te-info-block-text strong { color: #1e293b; display: block; font-size: .8rem; margin-bottom: .1rem; }
</style>

<div class="te" style="margin-bottom:1.75rem">
    <div style="display:flex;justify-content:flex-end;margin-bottom:.65rem">
        <div class="te-breadcrumb">
            <a href="{{ route('admin.layanan-surat.template-surat.index') }}">Layanan Surat</a>
            <span class="sep">›</span>
            <a href="{{ route('admin.layanan-surat.template-surat.index') }}">Daftar Template</a>
            <span class="sep">›</span>
            <span class="current">Edit Template</span>
        </div>
    </div>
    <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem">
        <div class="te-header-left">
            <h1>Edit Template Surat</h1>
            <p>Mengedit: <strong>{{ $template->judul }}</strong></p>
        </div>
        <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="te-btn te-btn-ghost" style="flex-shrink:0">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.layanan-surat.template-surat.update', $template->id) }}" class="te">
    @csrf
    @method('PUT')

    <div class="te-layout">

        {{-- ════════════════════════════════════ MAIN COLUMN ════════════════════════════════════ --}}
        <div>

            @if ($errors->any())
            <div class="te-alert-err">
                <div class="te-alert-err-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r=".5" fill="#dc2626"/></svg>
                </div>
                <div>
                    <div class="te-alert-err-title">Terdapat kesalahan pada input berikut:</div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- ── Card: Informasi Dasar ── --}}
            <div class="te-card" style="margin-bottom:1.25rem">
                <div class="te-card-header">
                    <div class="te-card-icon blue">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="te-card-header-text">
                        <h3>Informasi Dasar</h3>
                        <p>Identitas dan konfigurasi umum template</p>
                    </div>
                </div>
                <div class="te-card-body">
                    
                    <div class="te-field">
                        <div class="te-label">Judul Template <span class="req">WAJIB</span></div>
                        <input type="text" name="judul" value="{{ old('judul', $template->judul) }}" class="te-input" placeholder="cth: Surat Keterangan Domisili" required>
                    </div>

                    <div class="te-field">
                        <div class="te-label">Status Template</div>
                        <div class="te-status-group">
                            <div class="te-status-opt is-aktif">
                                <input type="radio" name="status" value="aktif" id="st_aktif" {{ old('status', $template->status) == 'aktif' ? 'checked' : '' }}>
                                <label for="st_aktif"><span class="te-status-dot"></span> Aktif</label>
                            </div>
                            <div class="te-status-opt is-noaktif">
                                <input type="radio" name="status" value="noaktif" id="st_noaktif" {{ old('status', $template->status) == 'noaktif' ? 'checked' : '' }}>
                                <label for="st_noaktif"><span class="te-status-dot"></span> Non-Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="te-row te-row-31">
                        <div class="te-field" style="margin:0">
                            <div class="te-label">Kode Klasifikasi <span class="req">WAJIB</span></div>
                            {{-- FIX: value dikirim menggunakan ID ($k->id) sesuai DB --}}
                            <select id="select-klasifikasi" name="klasifikasi_surat_id" required>
                                <option value="">— Pilih Klasifikasi —</option>
                                @if(isset($klasifikasis))
                                    @foreach($klasifikasis as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('klasifikasi_surat_id', $template->klasifikasi_surat_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->kode }} – {{ $k->nama_klasifikasi }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="te-field" style="margin:0">
                            <div class="te-label">Lampiran <span class="opt">opsional</span></div>
                            <input type="text" name="lampiran" value="{{ old('lampiran', $template->lampiran) }}" class="te-input" placeholder="cth: 1 Berkas">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Card: Isi Template ── --}}
            <div class="te-card">
                <div class="te-card-header">
                    <div class="te-card-icon indigo">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/></svg>
                    </div>
                    <div class="te-card-header-text">
                        <h3>Isi Template Surat</h3>
                        <p>Desain layout dan isi konten surat</p>
                    </div>
                </div>
                <div class="te-card-body">
                    <div class="te-editor-wrap" id="editorWrap">
                        <textarea id="editor" name="konten_template" rows="20">{!! old('konten_template', $template->konten_template) !!}</textarea>
                    </div>

                    <div class="te-action-bar">
                        <p class="te-hint"><span style="color:#ef4444">*</span> Kolom bertanda WAJIB harus diisi</p>
                        <div style="display:flex;gap:.6rem;flex-wrap:wrap">
                            <a href="{{ route('admin.layanan-surat.template-surat.index') }}" class="te-btn te-btn-ghost">Batal</a>
                            <button type="submit" class="te-btn te-btn-primary">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════ SIDEBAR ════════════════════════════════════ --}}
        <div class="te-sidebar">

            <div class="te-card" style="margin-bottom:1.25rem">
                <div class="te-card-header">
                    <div class="te-card-icon emerald">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div class="te-card-header-text">
                        <h3>Persyaratan</h3>
                        <p>Dokumen yang dibutuhkan</p>
                    </div>
                </div>
                <div class="te-card-body">
                    @if(isset($persyaratans) && count($persyaratans) > 0)
                        @php
                            $persyaratanTerpilih = old('persyaratan', $template->persyaratan->pluck('id')->toArray());
                        @endphp
                        <p style="font-size:.75rem;color:#94a3b8;margin:0 0 .75rem;line-height:1.5">Centang dokumen yang wajib dilampirkan pemohon.</p>
                        <div class="te-syarat-grid">
                            @foreach($persyaratans as $syarat)
                                <label class="te-syarat-item" for="syarat_{{ $syarat->id }}">
                                    <input type="checkbox" name="persyaratan[]" value="{{ $syarat->id }}" id="syarat_{{ $syarat->id }}" {{ in_array($syarat->id, $persyaratanTerpilih) ? 'checked' : '' }}>
                                    <span>{{ $syarat->nama_persyaratan ?? $syarat->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align:center;padding:.5rem 0">
                            <p style="font-size:.78rem;color:#94a3b8;margin:0;line-height:1.5">Belum ada data persyaratan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="te-card">
                <div class="te-card-header">
                    <div class="te-card-icon violet">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <div class="te-card-header-text">
                        <h3>Panduan Singkat</h3>
                        <p>Tips pengisian template</p>
                    </div>
                </div>
                <div class="te-card-body">
                    <div class="te-info-block">
                        <div class="te-info-block-icon" style="background:#eff6ff">📝</div>
                        <div class="te-info-block-text"><strong>Variabel Dinamis</strong> Gunakan <code style="background:#f1f5f9;padding:.1rem .3rem;border-radius:4px;font-size:.75rem">@{{nama_pemohon}}</code> untuk sisip data otomatis.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/css/tom-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.1/js/tom-select.complete.min.js"></script>
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 520,
        menubar: 'file edit view insert format tools table',
        plugins: 'preview searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | table | fullscreen preview',
        branding: false,
        promotion: false,
        license_key: 'gpl',
        skin: 'oxide',
        content_style: 'body { font-family: "Times New Roman", Georgia, serif; font-size: 13px; line-height: 2; padding: 2rem 2.5rem; color: #1e293b; }',
        setup: function (editor) {
            editor.on('change', function () { tinymce.triggerSave(); });
            editor.on('focus', function () { document.getElementById('editorWrap').classList.add('focused'); });
            editor.on('blur', function () { document.getElementById('editorWrap').classList.remove('focused'); });
        }
    });

    // FIX TOM SELECT
    new TomSelect('#select-klasifikasi', {
        placeholder: '— Pilih Klasifikasi —',
        allowEmptyOption: true,
        maxOptions: 100,
        searchField: ['text'],
        onFocus: function() {
            // Ini yang kamu minta: Saat form di klik, isinya langsung terhapus
            this.clear();
        },
        render: {
            option: function(data, escape) {
                // FIX: Jika value kosong, jangan jalankan fungsi split
                if (!data.value) return '<div>' + escape(data.text) + '</div>';

                var parts = data.text.split(' – ');
                var kode = parts[0] ? parts[0].trim() : '';
                var nama = parts[1] ? parts[1].trim() : data.text;
                return '<div style="display:flex;align-items:center;gap:.6rem">' +
                    '<span class="ts-opt-code">' + escape(kode) + '</span>' +
                    '<span class="ts-opt-name">' + escape(nama) + '</span>' +
                    '</div>';
            },
            item: function(data, escape) {
                // FIX: Jika value kosong, biarkan teks default muncul
                if (!data.value) return '<div>' + escape(data.text) + '</div>';

                var parts = data.text.split(' – ');
                var kode = parts[0] ? parts[0].trim() : '';
                var nama = parts[1] ? parts[1].trim() : data.text;
                return '<div style="display:flex;align-items:center;gap:.45rem">' +
                    '<span class="ts-opt-code" style="font-size:.7rem">' + escape(kode) + '</span>' +
                    '<span style="color:#1e293b;font-size:.875rem">' + escape(nama) + '</span>' +
                    '</div>';
            },
            no_results: function(data, escape) {
                return '<div class="no-results">Tidak ditemukan hasil untuk <strong>&ldquo;' + escape(data.input) + '&rdquo;</strong></div>';
            }
        }
    });
</script>
@endpush