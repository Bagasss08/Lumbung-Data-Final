@extends('layouts.admin')

@section('title', 'Pembangunan Desa')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Pembangunan Desa</h1>
                <p class="text-slate-600">Kelola proyek pembangunan desa</p>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Tambah Proyek
                </button>
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Proyek</p>
                    <p class="text-2xl font-bold text-slate-700">24</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">🏗️</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Sedang Berjalan</p>
                    <p class="text-2xl font-bold text-yellow-600">8</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">⚡</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">12</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Anggaran</p>
                    <p class="text-2xl font-bold text-emerald-600">Rp 2.5M</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <span class="text-xl">💰</span>
                </div>
            </div>
        </div>
    </div>

    <!-- PROJECTS TABLE -->
    <div class="bg-white rounded-2xl shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold text-slate-700">Daftar Proyek Pembangunan</h3>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Nama Proyek</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Kategori</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Anggaran</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Progress</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-4 px-4">
                                <div>
                                    <p class="font-medium text-slate-700">Pembangunan Jalan Desa</p>
                                    <p class="text-sm text-slate-500">Jl. Raya Desa - Dusun A</p>
                                 </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                    Infrastruktur
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    Sedang Berjalan
                                </span>
                            </td>
                            <td class="py-4 px-4 font-medium">Rp 150.000.000</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-slate-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                                    </div>
                                    <span class="text-sm text-slate-600">65%</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                        Edit
                                    </button>
                                    <button class="px-3 py-1 bg-slate-500 text-white rounded-lg text-xs hover:bg-slate-600">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-4 px-4">
                                <div>
                                    <p class="font-medium text-slate-700">Rehabilitasi Posyandu</p>
                                    <p class="text-sm text-slate-500">Posyandu Melati</p>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    Kesehatan
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    Selesai
                                </span>
                            </td>
                            <td class="py-4 px-4 font-medium">Rp 75.000.000</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-slate-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                    <span class="text-sm text-slate-600">100%</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                        Edit
                                    </button>
                                    <button class="px-3 py-1 bg-slate-500 text-white rounded-lg text-xs hover:bg-slate-600">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-4 px-4">
                                <div>
                                    <p class="font-medium text-slate-700">Pembangunan Sumur Bor</p>
                                    <p class="text-sm text-slate-500">Dusun B & C</p>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs font-medium">
                                    Sanitasi
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                    Sedang Berjalan
                                </span>
                            </td>
                            <td class="py-4 px-4 font-medium">Rp 200.000.000</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-slate-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 40%"></div>
                                    </div>
                                    <span class="text-sm text-slate-600">40%</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                        Edit
                                    </button>
                                    <button class="px-3 py-1 bg-slate-500 text-white rounded-lg text-xs hover:bg-slate-600">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-4 px-4">
                                <div>
                                    <p class="font-medium text-slate-700">Pembangunan Balai Desa</p>
                                    <p class="text-sm text-slate-500">Gedung Serbaguna</p>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                    Sarana Umum
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                    Tertunda
                                </span>
                            </td>
                            <td class="py-4 px-4 font-medium">Rp 500.000.000</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-20 bg-slate-200 rounded-full h-2">
                                        <div class="bg-red-500 h-2 rounded-full" style="width: 10%"></div>
                                    </div>
                                    <span class="text-sm text-slate-600">10%</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-2">
                                    <button class="px-3 py-1 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600">
                                        Edit
                                    </button>
                                    <button class="px-3 py-1 bg-slate-500 text-white rounded-lg text-xs hover:bg-slate-600">
                                        Detail
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CHART SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-semibold text-slate-700 mb-4">Distribusi Kategori Proyek</h3>
            <canvas id="kategoriChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-semibold text-slate-700 mb-4">Status Proyek</h3>
            <canvas id="statusChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kategori Chart
    const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
    new Chart(kategoriCtx, {
        type: 'doughnut',
        data: {
            labels: ['Infrastruktur', 'Kesehatan', 'Sanitasi', 'Sarana Umum', 'Pendidikan'],
            datasets: [{
                data: [8, 4, 3, 6, 3],
                backgroundColor: ['#3B82F6', '#10B981', '#06B6D4', '#8B5CF6', '#F59E0B']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: ['Selesai', 'Sedang Berjalan', 'Tertunda', 'Dibatalkan'],
            datasets: [{
                label: 'Jumlah Proyek',
                data: [12, 8, 3, 1],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#6B7280']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

@endsection
