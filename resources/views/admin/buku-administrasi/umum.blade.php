@extends('layouts.admin')
@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold text-dark mb-1">
                        <i class="fas fa-book text-primary me-2"></i>Buku Administrasi Umum
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#" class="text-decoration-none">
                                    <i class="fas fa-home"></i> Beranda
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Buku Administrasi Umum</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Enhanced Modern List Menu with Advanced Animations */
        .list-menu {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            overflow: hidden;
            border: 2px solid #f1f5f9;
            padding: 8px;
        }

        .list-menu-item {
            display: flex;
            align-items: center;
            padding: 20px 24px;
            margin: 4px 0;
            color: #475569;
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 15px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            transform-origin: center;
        }

        /* Ripple Effect Background */
        .list-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        /* Glow Effect */
        .list-menu-item::after {
            content: '';
            position: absolute;
            right: -50px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.4) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.4s ease;
            z-index: 1;
        }

        /* Icon Styling */
        .list-menu-item i {
            margin-right: 14px;
            font-size: 18px;
            width: 24px;
            text-align: center;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .list-menu-item span {
            position: relative;
            z-index: 2;
        }

        /* Hover State - Green Theme */
        .list-menu-item:hover {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
            color: #059669;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.25);
            border-left: 4px solid #10b981;
            padding-left: 20px;
        }

        .list-menu-item:hover::before {
            transform: scaleX(1);
        }

        .list-menu-item:hover::after {
            opacity: 1;
            right: 24px;
        }

        .list-menu-item:hover i {
            transform: scale(1.2) rotate(5deg);
            color: #10b981;
        }

        /* Active State - Purple Gradient */
        .list-menu-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            transform: scale(1.03);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
            border-left: 5px solid #4c1d95;
            animation: pulseActive 2s ease-in-out infinite;
        }

        .list-menu-item.active::before {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            transform: scaleX(1);
        }

        .list-menu-item.active::after {
            opacity: 0;
        }

        .list-menu-item.active i {
            transform: scale(1.15);
            color: white;
        }

        .list-menu-item.active:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b42a0 100%);
            transform: scale(1.05) translateX(4px);
        }

        /* Pulse Animation for Active Item */
        @keyframes pulseActive {
            0%, 100% {
                box-shadow: 0 12px 35px rgba(102, 126, 234, 0.5);
            }
            50% {
                box-shadow: 0 12px 45px rgba(102, 126, 234, 0.7);
            }
        }

        /* Click Animation */
        .list-menu-item:active {
            transform: scale(0.98);
        }

        /* Sequential Animation on Load */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .list-menu-item {
            animation: slideInRight 0.6s ease forwards;
            opacity: 0;
        }

        .list-menu-item:nth-child(1) { animation-delay: 0.05s; }
        .list-menu-item:nth-child(2) { animation-delay: 0.1s; }
        .list-menu-item:nth-child(3) { animation-delay: 0.15s; }
        .list-menu-item:nth-child(4) { animation-delay: 0.2s; }
        .list-menu-item:nth-child(5) { animation-delay: 0.25s; }
        .list-menu-item:nth-child(6) { animation-delay: 0.3s; }
        .list-menu-item:nth-child(7) { animation-delay: 0.35s; }
        .list-menu-item:nth-child(8) { animation-delay: 0.4s; }
        .list-menu-item:nth-child(9) { animation-delay: 0.45s; }
        .list-menu-item:nth-child(10) { animation-delay: 0.5s; }

        /* History Section */
        .history-section {
            margin-top: 40px;
            animation: fadeInUp 0.8s ease;
        }

        .history-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            overflow: hidden;
            border: 2px solid #f1f5f9;
        }

        .history-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px 28px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .history-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotateGradient 10s linear infinite;
        }

        @keyframes rotateGradient {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .history-header h5 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .history-header h5 i {
            font-size: 24px;
            animation: spinSlow 3s linear infinite;
        }

        @keyframes spinSlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Modern History Table - CRUD Only */
        .history-table-wrapper {
            padding: 28px;
        }

        .history-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .history-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .history-table thead th {
            padding: 16px 20px;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            border: none;
            text-align: left;
        }

        .history-table thead th:first-child {
            border-radius: 12px 0 0 12px;
            padding-left: 24px;
        }

        .history-table thead th:last-child {
            border-radius: 0 12px 12px 0;
            padding-right: 24px;
        }

        .history-table tbody tr {
            background: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .history-table tbody tr:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.25);
            z-index: 10;
        }

        .history-table tbody td {
            padding: 18px 20px;
            font-size: 14px;
            color: #334155;
            vertical-align: middle;
            border: none;
            background: white;
        }

        .history-table tbody td:first-child {
            border-radius: 12px 0 0 12px;
            padding-left: 24px;
            font-weight: 700;
            color: #667eea;
            font-size: 16px;
        }

        .history-table tbody td:last-child {
            border-radius: 0 12px 12px 0;
            padding-right: 24px;
        }

        /* Enhanced Badge Styles */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: default;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-custom:hover {
            transform: scale(1.08);
        }

        .badge-create {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .badge-create:hover {
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
        }

        .badge-update {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .badge-update:hover {
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.5);
        }

        .badge-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .badge-delete:hover {
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
        }

        /* Time Badge */
        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: #f1f5f9;
            border-radius: 20px;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .time-badge i {
            color: #94a3b8;
        }

        /* User Badge */
        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            transition: all 0.3s ease;
        }

        .user-badge:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: scale(1.05);
        }

        .user-badge .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 28px;
            border-top: 2px solid #f1f5f9;
            background: linear-gradient(135deg, #fafbfc 0%, #f8fafc 100%);
        }

        .pagination-info {
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .pagination-info strong {
            color: #334155;
            font-weight: 700;
        }

        .pagination-nav {
            display: flex;
            gap: 10px;
        }

        .pagination-btn {
            padding: 10px 16px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            background: white;
            color: #64748b;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 14px;
        }

        .pagination-btn:hover {
            background: #f8fafc;
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .pagination-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .pagination-btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .list-menu-item {
                padding: 16px 20px;
                font-size: 14px;
            }

            .history-table-wrapper {
                padding: 20px;
                overflow-x: auto;
            }

            .history-table {
                min-width: 800px;
            }

            .pagination-wrapper {
                flex-direction: column;
                gap: 20px;
            }

            .history-header h5 {
                font-size: 18px;
            }
        }

        /* Global Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- List Menu Section -->
    <div class="row">
        <div class="col-12">
            <div class="list-menu">
                <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" class="list-menu-item">
                    <i class="fas fa-balance-scale"></i>
                    <span>Buku Peraturan di Desa</span> 
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-gavel"></i>
                    <span>Buku Keputusan Kepala Desa</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-warehouse"></i>
                    <span>Buku Inventaris dan Kekayaan Desa</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-landmark"></i>
                    <span>Buku Pemerintah Desa</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-file-contract"></i>
                    <span>Buku Tanah Kas Desa</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Buku Tanah di Desa</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>Buku Agenda - Surat Keluar</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-envelope-open-text"></i>
                    <span>Buku Agenda - Surat Masuk</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Buku Ekspedisi</span>
                </a>
                <a href="#" class="list-menu-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Buku Lembaran Desa dan Berita Desa</span>
                </a>
            </div>
        </div>
    </div>

    <!-- History Section - CRUD Only -->
    <div class="row history-section">
        <div class="col-12">
            <div class="history-card">
                <div class="history-header">
                    <h5>
                        <i class="fas fa-history"></i>
                        Riwayat Aktivitas CRUD Terbaru
                    </h5>
                </div>
                
                <div class="history-table-wrapper">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Operasi</th>
                                <th>Nama Buku</th>
                                <th>Detail Aktivitas</th>
                                <th>Pengguna</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="badge-custom badge-create">
                                        <i class="fas fa-plus-circle"></i>
                                        CREATE
                                    </span>
                                </td>
                                <td>Buku Inventaris Desa</td>
                                <td>Menambahkan data inventaris Meja Kerja Kayu - 15 Unit</td>
                                <td>
                                    <div class="user-badge">
                                        <div class="avatar">SK</div>
                                        Sekretaris Desa
                                    </div>
                                </td>
                                <td>
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        5 menit lalu
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="badge-custom badge-update">
                                        <i class="fas fa-edit"></i>
                                        UPDATE
                                    </span>
                                </td>
                                <td>Buku Peraturan di Desa</td>
                                <td>Memperbarui Perdes No. 02/2026 tentang APBDes 2026</td>
                                <td>
                                    <div class="user-badge">
                                        <div class="avatar">AD</div>
                                        Admin Desa
                                    </div>
                                </td>
                                <td>
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        15 menit lalu
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <span class="badge-custom badge-delete">
                                        <i class="fas fa-trash-alt"></i>
                                        DELETE
                                    </span>
                                </td>
                                <td>Buku Ekspedisi</td>
                                <td>Menghapus data ekspedisi surat duplikat tanggal 10 Feb 2026</td>
                                <td>
                                    <div class="user-badge">
                                        <div class="avatar">SK</div>
                                        Sekretaris Desa
                                    </div>
                                </td>
                                <td>
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        30 menit lalu
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <span class="badge-custom badge-create">
                                        <i class="fas fa-plus-circle"></i>
                                        CREATE
                                    </span>
                                </td>
                                <td>Buku Agenda - Surat Masuk</td>
                                <td>Mencatat surat masuk No. 045/SM/II/2026 dari Kecamatan</td>
                                <td>
                                    <div class="user-badge">
                                        <div class="avatar">AD</div>
                                        Admin Desa
                                    </div>
                                </td>
                                <td>
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        1 jam lalu
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <span class="badge-custom badge-update">
                                        <i class="fas fa-edit"></i>
                                        UPDATE
                                    </span>
                                </td>
                                <td>Buku Keputusan Kepala Desa</td>
                                <td>Revisi SK Kepala Desa No. 15/2026 tentang Penetapan BPD</td>
                                <td>
                                    <div class="user-badge">
                                        <div class="avatar">KD</div>
                                        Kepala Desa
                                    </div>
                                </td>
                                <td>
                                    <div class="time-badge">
                                        <i class="far fa-clock"></i>
                                        2 jam lalu
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Menampilkan <strong>1-5</strong> dari <strong>247</strong> aktivitas CRUD
                    </div>
                    <div class="pagination-nav">
                        <a href="#" class="pagination-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" class="pagination-btn active">1</a>
                        <a href="#" class="pagination-btn">2</a>
                        <a href="#" class="pagination-btn">3</a>
                        <a href="#" class="pagination-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection