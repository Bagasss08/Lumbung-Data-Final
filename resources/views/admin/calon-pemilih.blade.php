@extends('layouts.admin')

@section('title', 'Calon Pemilih')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Data Calon Pemilih</h1>
            <p class="text-slate-600">Kelola data calon pemilih untuk pemilihan</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Import Data
            </button>
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Calon
            </button>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-slate-50 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Cari</label>
                <input type="text" placeholder="Cari nama..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Usia</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option>Semua Usia</option>
                    <option>17-25 tahun</option>
                    <option>26-35 tahun</option>
                    <option>36-45 tahun</option>
                    <option>46+ tahun</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option>Semua Status</option>
                    <option>Belum Memilih</option>
                    <option>Sudah Memilih</option>
                    <option>Tidak Memilih</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-slate-600 hover:bg-slate-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Calon</p>
                    <p class="text-2xl font-bold">1,240</p>
                </div>
                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Sudah Memilih</p>
                    <p class="text-2xl font-bold">980</p>
                </div>
                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Belum Memilih</p>
                    <p class="text-2xl font-bold">240</p>
                </div>
                <svg class="w-8 h-8 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Tidak Memilih</p>
                    <p class="text-2xl font-bold">20</p>
                </div>
                <svg class="w-8 h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-slate-100">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">NIK</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tempat Lahir</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Tanggal Lahir</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Usia</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm text-slate-700">1</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Ahmad Surya</td>
                    <td class="px-6 py-4 text-sm text-slate-700">3201234567890001</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Bandung</td>
                    <td class="px-6 py-4 text-sm text-slate-700">15-05-1990</td>
                    <td class="px-6 py-4 text-sm text-slate-700">34</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Sudah Memilih</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat</button>
                            <button class="text-emerald-600 hover:text-emerald-800 font-medium">Edit</button>
                            <button class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                        </div>
                    </td>
                </tr>
                <!-- More rows would be added here -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-between items-center">
        <p class="text-sm text-slate-600">Menampilkan 1-10 dari 1240 data</p>
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">Sebelumnya</button>
            <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg">1</button>
            <button class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">2</button>
            <button class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">3</button>
            <button class="px-4 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection
