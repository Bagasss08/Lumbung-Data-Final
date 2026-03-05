@extends('layouts.admin')

@section('content')

<style>
    /* Modern Color Palette - Green Theme */
    :root {
        --primary-green: #10b981;
        --primary-green-dark: #059669;
        --primary-green-light: #d1fae5;
        --secondary: #6366f1;
        --danger: #ef4444;
        --warning: #f59e0b;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        min-height: 100vh;
    }

    .container-fluid {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .breadcrumb-section {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .breadcrumb-section a {
        color: var(--gray-600);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb-section a:hover { color: var(--primary-green); }
    .breadcrumb-section .separator { color: var(--gray-400); }
    .breadcrumb-section .current { color: var(--primary-green); font-weight: 600; }

    /* Card Container */
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: slideUp 0.4s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Card Header */
    .form-card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .form-card-header::before {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .form-card-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 60px; height: 60px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 28px; color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .form-card-header h4 {
        color: white; font-size: 1.75rem; font-weight: 700;
        margin: 0; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-card-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0; font-size: 0.95rem;
    }

    /* Card Body */
    .form-card-body { padding: 2.5rem; }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 0;
    }

    .form-row-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 0;
    }

    .form-group { margin-bottom: 1.5rem; }

    .form-group label {
        display: flex; align-items: center; gap: 0.5rem;
        font-weight: 600; color: var(--gray-700);
        margin-bottom: 0.5rem; font-size: 0.95rem;
    }

    .form-group label i { color: var(--primary-green); font-size: 1rem; }

    .required-mark { color: var(--danger); margin-left: 0.25rem; }

    /* Form Controls */
    .form-control, .form-select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 0.95rem;
        color: var(--gray-800);
        background: var(--gray-50);
        transition: all 0.3s ease;
        outline: none;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        transform: translateY(-1px);
    }

    .form-control:hover, .form-select:hover { border-color: var(--gray-300); }

    textarea.form-control {
        resize: vertical; min-height: 120px; font-family: inherit;
    }

    /* Input with prefix (Rp) */
    .input-prefix-wrapper {
        display: flex;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        overflow: hidden;
        background: var(--gray-50);
        transition: all 0.3s ease;
    }

    .input-prefix-wrapper:focus-within {
        border-color: var(--primary-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    .input-prefix {
        padding: 0.875rem 1rem;
        background: var(--primary-green-light);
        color: var(--primary-green-dark);
        font-weight: 700;
        font-size: 0.9rem;
        white-space: nowrap;
        display: flex;
        align-items: center;
        border-right: 2px solid var(--gray-200);
    }

    .input-prefix-wrapper .form-control {
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        transform: none !important;
        background: transparent;
    }

    /* Helper Text */
    .helper-text {
        font-size: 0.85rem; color: var(--gray-500);
        margin-top: 0.5rem;
        display: flex; align-items: center; gap: 0.5rem;
    }

    .helper-text i { font-size: 0.9rem; }

    /* Section Divider */
    .section-divider {
        display: flex; align-items: center;
        gap: 1rem; margin: 2.5rem 0 2rem 0;
    }

    .section-divider-line {
        flex: 1; height: 2px;
        background: linear-gradient(to right, var(--gray-200), transparent);
    }

    .section-divider-text {
        font-weight: 600; color: var(--gray-600);
        font-size: 0.9rem; text-transform: uppercase;
        letter-spacing: 0.05em; white-space: nowrap;
    }

    /* Total Summary Box */
    .total-summary {
        background: linear-gradient(135deg, var(--primary-green-light) 0%, #a7f3d0 100%);
        border: 2px solid var(--primary-green);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .total-summary-label {
        font-weight: 700; font-size: 1rem;
        color: var(--primary-green-dark);
        display: flex; align-items: center; gap: 0.5rem;
    }

    .total-summary-value {
        font-weight: 800; font-size: 1.4rem;
        color: var(--primary-green-dark);
        font-family: 'Courier New', monospace;
    }

    /* Validation Styles */
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger); background: #fef2f2;
    }

    .invalid-feedback {
        display: block; color: var(--danger);
        font-size: 0.85rem; margin-top: 0.5rem;
    }

    /* Action Buttons */
    .form-actions {
        display: flex; gap: 1rem;
        margin-top: 2.5rem; padding-top: 2rem;
        border-top: 2px solid var(--gray-100);
    }

    .btn {
        padding: 0.875rem 2rem; border: none;
        border-radius: 10px; font-weight: 600;
        font-size: 0.95rem; cursor: pointer;
        display: inline-flex; align-items: center; gap: 0.5rem;
        transition: all 0.3s ease; text-decoration: none;
        justify-content: center;
    }

    .btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
    .btn:active { transform: translateY(0); }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover { box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4); color: white; }

    .btn-secondary { background: var(--gray-100); color: var(--gray-700); }
    .btn-secondary:hover { background: var(--gray-200); color: var(--gray-700); }
    .btn i { font-size: 1.1rem; }

    /* Loading State */
    .btn-loading { position: relative; pointer-events: none; opacity: 0.7; }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 900px) {
        .form-row-4 { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .container-fluid { padding: 1rem; }
        .form-card-header { padding: 1.5rem; }
        .form-card-header h4 { font-size: 1.5rem; }
        .form-card-body { padding: 1.5rem; }
        .form-row { grid-template-columns: 1fr; }
        .form-row-4 { grid-template-columns: 1fr 1fr; }
        .form-actions { flex-direction: column; }
        .btn { width: 100%; }
    }

    @media (max-width: 480px) {
        .form-row-4 { grid-template-columns: 1fr; }
    }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--gray-100); }
    ::-webkit-scrollbar-thumb { background: var(--primary-green); border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--primary-green-dark); }
</style>

<div class="container-fluid">

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span class="separator">/</span>
        <a href="{{ route('admin.buku-administrasi.pembangunan.index') }}">
            Buku Administrasi Pembangunan
        </a>
        <span class="separator">/</span>
        <a href="{{ route('admin.buku-administrasi.pembangunan.rencana.index') }}">
            Rencana Kerja Pembangunan
        </a>
        <span class="separator">/</span>
        <span class="current">Tambah Data</span>
    </div>

    <!-- Form Card -->
    <div class="form-card">

        <!-- Card Header -->
        <div class="form-card-header">
            <div class="form-card-header-content">
                <div class="header-icon">
                    <i class="fas fa-drafting-compass"></i>
                </div>
                <div>
                    <h4>Tambah Rencana Kerja Pembangunan</h4>
                    <p>Lengkapi formulir di bawah ini untuk menambahkan rencana pembangunan desa baru</p>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="form-card-body">
            <form action="{{ route('admin.buku-administrasi.pembangunan.rencana.store') }}" method="POST" id="formRencana">
                @csrf

                <!-- ── Informasi Proyek ── -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-text"><i class="fas fa-project-diagram"></i>&nbsp; Informasi Proyek</span>
                    <div class="section-divider-line" style="transform: scaleX(-1);"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-hard-hat"></i>
                            Nama Proyek / Kegiatan
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text"
                               name="nama_proyek"
                               class="form-control @error('nama_proyek') is-invalid @enderror"
                               placeholder="Contoh: Pembangunan Jalan Desa RT 03"
                               value="{{ old('nama_proyek') }}"
                               maxlength="255"
                               id="namaProyekInput"
                               required>
                        @error('nama_proyek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-map-marker-alt"></i>
                            Lokasi
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text"
                               name="lokasi"
                               class="form-control @error('lokasi') is-invalid @enderror"
                               placeholder="Contoh: Dusun Makmur, RT 03/RW 01"
                               value="{{ old('lokasi') }}"
                               maxlength="255"
                               required>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-user-tie"></i>
                            Pelaksana
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text"
                               name="pelaksana"
                               class="form-control @error('pelaksana') is-invalid @enderror"
                               placeholder="Contoh: Tim Pelaksana Desa / CV. Maju Jaya"
                               value="{{ old('pelaksana') }}"
                               maxlength="255"
                               required>
                        @error('pelaksana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-leaf"></i>
                            Manfaat
                        </label>
                        <input type="text"
                               name="manfaat"
                               class="form-control @error('manfaat') is-invalid @enderror"
                               placeholder="Contoh: Meningkatkan akses mobilitas warga"
                               value="{{ old('manfaat') }}"
                               maxlength="255">
                        @error('manfaat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-sticky-note"></i>
                        Keterangan
                    </label>
                    <textarea name="keterangan"
                              class="form-control @error('keterangan') is-invalid @enderror"
                              placeholder="Tuliskan keterangan tambahan jika diperlukan..."
                              rows="3"
                              id="keteranganInput">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ── Sumber Dana ── -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-text"><i class="fas fa-wallet"></i>&nbsp; Sumber Dana</span>
                    <div class="section-divider-line" style="transform: scaleX(-1);"></div>
                </div>

                <div class="helper-text" style="margin-bottom: 1.5rem;">
                    <i class="fas fa-info-circle" style="color: var(--primary-green);"></i>
                    Masukkan nominal dalam Rupiah (angka saja, tanpa titik atau koma). Jumlah total akan dihitung otomatis.
                </div>

                <div class="form-row-4">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-university"></i>
                            Dana Pemerintah
                        </label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input type="number"
                                   name="dana_pemerintah"
                                   class="form-control dana-input @error('dana_pemerintah') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('dana_pemerintah', 0) }}"
                                   min="0">
                        </div>
                        @error('dana_pemerintah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-building"></i>
                            Dana Provinsi
                        </label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input type="number"
                                   name="dana_provinsi"
                                   class="form-control dana-input @error('dana_provinsi') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('dana_provinsi', 0) }}"
                                   min="0">
                        </div>
                        @error('dana_provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-city"></i>
                            Dana Kab/Kota
                        </label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input type="number"
                                   name="dana_kab_kota"
                                   class="form-control dana-input @error('dana_kab_kota') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('dana_kab_kota', 0) }}"
                                   min="0">
                        </div>
                        @error('dana_kab_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-hands-helping"></i>
                            Dana Swadaya
                        </label>
                        <div class="input-prefix-wrapper">
                            <span class="input-prefix">Rp</span>
                            <input type="number"
                                   name="dana_swadaya"
                                   class="form-control dana-input @error('dana_swadaya') is-invalid @enderror"
                                   placeholder="0"
                                   value="{{ old('dana_swadaya', 0) }}"
                                   min="0">
                        </div>
                        @error('dana_swadaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah Total (auto-calculated, readonly) -->
                <div class="total-summary">
                    <div class="total-summary-label">
                        <i class="fas fa-calculator"></i>
                        Jumlah Total Anggaran
                    </div>
                    <div class="total-summary-value" id="totalDisplay">
                        Rp 0
                    </div>
                </div>

                {{-- Hidden field jumlah_total yang dikirim ke server --}}
                <input type="hidden" name="jumlah_total" id="jumlahTotalInput" value="{{ old('jumlah_total', 0) }}">

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan Data
                    </button>
                    <a href="{{ route('admin.buku-administrasi.pembangunan.rencana.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const danaInputs = document.querySelectorAll('.dana-input');
    const totalDisplay = document.getElementById('totalDisplay');
    const jumlahTotalInput = document.getElementById('jumlahTotalInput');

    // Format number to Rupiah display
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    // Calculate total from all dana inputs
    function hitungTotal() {
        let total = 0;
        danaInputs.forEach(function (input) {
            const val = parseFloat(input.value) || 0;
            total += val;
        });
        totalDisplay.textContent = formatRupiah(total);
        jumlahTotalInput.value = total;
    }

    // Bind event to each dana input
    danaInputs.forEach(function (input) {
        input.addEventListener('input', hitungTotal);
    });

    // Run once on load to handle old() values
    hitungTotal();

    // Auto-resize textarea
    const keteranganInput = document.getElementById('keteranganInput');
    if (keteranganInput) {
        keteranganInput.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    // Submit loading state
    const form = document.getElementById('formRencana');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', function () {
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }
        });
    }
});
</script>

@endsection