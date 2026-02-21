@extends('layouts.admin')

@section('title', 'Kelompok')

@section('content')
<div class="bg-white rounded-2xl shadow-lg p-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">Data Kelompok</h1>
            <p class="text-slate-600">Kelola data kelompok masyarakat di desa</p>
        </div>
        <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Kelompok
        </button>
    </div>

    <!-- Search and Filter -->
    <div class="bg-slate-50 rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Cari</label>
                <input type="text" placeholder="Cari kelompok..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelompok</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option>Semua Jenis</option>
                    <option>Pokmas</option>
                    <option>Koperasi</option>
                    <option>Karang Taruna</option>
                    <option>PKK</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-slate-600 hover:bg-slate-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-slate-100">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">No</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Nama Kelompok</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Jenis</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Ketua</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Jumlah Anggota</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Status</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-sm text-slate-700">1</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Pokmas Sawah</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Pokmas</td>
                    <td class="px-6 py-4 text-sm text-slate-700">Budi Santoso</td>
                    <td class="px-6 py-4 text-sm text-slate-700">25</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Aktif</span>
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
        <p class="text-sm text-slate-600">Menampilkan 1-10 dari 25 data</p>
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
