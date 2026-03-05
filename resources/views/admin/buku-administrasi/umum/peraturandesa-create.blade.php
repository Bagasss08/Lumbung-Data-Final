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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

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

    .breadcrumb-section a:hover {
        color: var(--primary-green);
    }

    .breadcrumb-section .separator {
        color: var(--gray-400);
    }

    .breadcrumb-section .current {
        color: var(--primary-green);
        font-weight: 600;
    }

    /* Card Container */
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: slideUp 0.4s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
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
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .form-card-header h4 {
        color: white;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-card-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

    /* Card Body */
    .form-card-body {
        padding: 2.5rem;
    }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-group label i {
        color: var(--primary-green);
        font-size: 1rem;
    }

    .required-mark {
        color: var(--danger);
        margin-left: 0.25rem;
    }

    /* Form Controls */
    .form-control,
    .form-select {
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

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-green);
        background: white;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        transform: translateY(-1px);
    }

    .form-control:hover,
    .form-select:hover {
        border-color: var(--gray-300);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    /* Input Icons */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        pointer-events: none;
        transition: color 0.3s;
    }

    .input-with-icon .form-control {
        padding-left: 3rem;
    }

    .input-with-icon .form-control:focus ~ i {
        color: var(--primary-green);
    }

    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 0.8rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    /* Helper Text */
    .helper-text {
        font-size: 0.85rem;
        color: var(--gray-500);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .helper-text i {
        font-size: 0.9rem;
    }

    /* Section Divider */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 2.5rem 0 2rem 0;
    }

    .section-divider-line {
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, var(--gray-200), transparent);
    }

    .section-divider-text {
        font-weight: 600;
        color: var(--gray-600);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 56px;
        height: 28px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--gray-300);
        transition: 0.3s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-switch input:checked + .toggle-slider {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(28px);
    }

    .toggle-label {
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        user-select: none;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid var(--gray-100);
    }

    .btn {
        padding: 0.875rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        justify-content: center;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .btn-secondary:hover {
        background: var(--gray-200);
    }

    .btn i {
        font-size: 1.1rem;
    }

    /* Validation Styles */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger);
        background: #fef2f2;
    }

    .invalid-feedback {
        display: block;
        color: var(--danger);
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .form-card-header {
            padding: 1.5rem;
        }

        .form-card-header h4 {
            font-size: 1.5rem;
        }

        .form-card-body {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--gray-100);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-green);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-green-dark);
    }
</style>

<div class="container-fluid">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <a href="{{ route('admin.dashboard') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <span class="separator">/</span>
        <a href="{{ route('admin.buku-administrasi.umum.index') }}">
            Buku Administrasi Umum
        </a>
        <span class="separator">/</span>
        <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}">
            Peraturan Desa
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
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h4>Tambah Data Peraturan Desa</h4>
                    <p>Lengkapi formulir di bawah ini untuk menambahkan peraturan desa baru</p>
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="form-card-body">
            <form action="{{ route('admin.buku-administrasi.umum.peraturan-desa.store') }}" method="POST" id="formPeraturan">
                @csrf

                <!-- Informasi Dasar -->
                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-hashtag"></i>
                            Nomor Peraturan
                            <span class="required-mark">*</span>
                        </label>
                        <div class="input-with-icon">
                            <input type="text" 
                                   name="nomor_ditetapkan" 
                                   class="form-control @error('nomor_ditetapkan') is-invalid @enderror" 
                                   placeholder="Contoh: 001/PERDES/2026"
                                   value="{{ old('nomor_ditetapkan') }}"
                                   required>
                            <i class="fas fa-file-contract"></i>
                        </div>
                        @error('nomor_ditetapkan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="helper-text">
                            <i class="fas fa-info-circle"></i>
                            Format: XXX/PERDES/TAHUN
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-layer-group"></i>
                            Jenis Peraturan
                            <span class="required-mark">*</span>
                        </label>
                        <select name="jenis_peraturan" 
                                class="form-select @error('jenis_peraturan') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Jenis Peraturan</option>
                            <option value="Peraturan Desa" {{ old('jenis_peraturan') == 'Peraturan Desa' ? 'selected' : '' }}>
                                Peraturan Desa (PERDES)
                            </option>
                            <option value="Peraturan Kepala Desa" {{ old('jenis_peraturan') == 'Peraturan Kepala Desa' ? 'selected' : '' }}>
                                Peraturan Kepala Desa (PERKADES)
                            </option>
                        </select>
                        @error('jenis_peraturan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-heading"></i>
                        Judul Peraturan
                        <span class="required-mark">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           class="form-control @error('judul') is-invalid @enderror" 
                           placeholder="Contoh: Anggaran Pendapatan dan Belanja Desa Tahun 2026"
                           value="{{ old('judul') }}"
                           maxlength="255"
                           id="judulInput"
                           required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="char-counter">
                        <span id="judulCount">0</span> / 255 karakter
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-align-left"></i>
                        Uraian Singkat
                    </label>
                    <textarea name="uraian_singkat" 
                              class="form-control @error('uraian_singkat') is-invalid @enderror" 
                              placeholder="Tuliskan uraian singkat tentang peraturan ini..."
                              rows="4"
                              maxlength="500"
                              id="uraianInput">{{ old('uraian_singkat') }}</textarea>
                    @error('uraian_singkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="char-counter">
                        <span id="uraianCount">0</span> / 500 karakter
                    </div>
                </div>

                <!-- Section Divider -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-text">Tanggal & Status</span>
                    <div class="section-divider-line" style="transform: scaleX(-1);"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-check"></i>
                            Tanggal Ditetapkan
                        </label>
                        <input type="date" 
                               name="tanggal_ditetapkan" 
                               class="form-control @error('tanggal_ditetapkan') is-invalid @enderror"
                               value="{{ old('tanggal_ditetapkan', date('Y-m-d')) }}">
                        @error('tanggal_ditetapkan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-calendar-plus"></i>
                            Dimuat Pada Tanggal
                        </label>
                        <input type="date" 
                               name="dimuat_pada" 
                               class="form-control @error('dimuat_pada') is-invalid @enderror"
                               value="{{ old('dimuat_pada', date('Y-m-d')) }}">
                        @error('dimuat_pada')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fas fa-toggle-on"></i>
                        Status Peraturan
                    </label>
                    <div class="toggle-label">
                        <label class="toggle-switch">
                            <input type="checkbox" 
                                   name="is_aktif" 
                                   value="1" 
                                   {{ old('is_aktif', 1) ? 'checked' : '' }}
                                   id="statusToggle">
                            <span class="toggle-slider"></span>
                        </label>
                        <span id="statusText" style="font-weight: 600; color: var(--primary-green);">
                            Aktif
                        </span>
                    </div>
                    <div class="helper-text">
                        <i class="fas fa-info-circle"></i>
                        Status aktif menunjukkan peraturan masih berlaku
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan Data
                    </button>
                    <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="btn btn-secondary">
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
document.addEventListener('DOMContentLoaded', function() {
    
    // Character Counter for Judul
    const judulInput = document.getElementById('judulInput');
    const judulCount = document.getElementById('judulCount');
    
    if (judulInput && judulCount) {
        judulInput.addEventListener('input', function() {
            judulCount.textContent = this.value.length;
        });
        // Initialize count
        judulCount.textContent = judulInput.value.length;
    }

    // Character Counter for Uraian
    const uraianInput = document.getElementById('uraianInput');
    const uraianCount = document.getElementById('uraianCount');
    
    if (uraianInput && uraianCount) {
        uraianInput.addEventListener('input', function() {
            uraianCount.textContent = this.value.length;
        });
        // Initialize count
        uraianCount.textContent = uraianInput.value.length;
    }

    // Status Toggle Text Update
    const statusToggle = document.getElementById('statusToggle');
    const statusText = document.getElementById('statusText');
    
    if (statusToggle && statusText) {
        statusToggle.addEventListener('change', function() {
            if (this.checked) {
                statusText.textContent = 'Aktif';
                statusText.style.color = 'var(--primary-green)';
            } else {
                statusText.textContent = 'Tidak Aktif';
                statusText.style.color = 'var(--gray-500)';
            }
        });
    }

    // Form Validation
    const form = document.getElementById('formPeraturan');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Add loading state
            if (submitBtn) {
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
            }
        });
    }

    // Auto-resize textarea
    if (uraianInput) {
        uraianInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>

@endsection