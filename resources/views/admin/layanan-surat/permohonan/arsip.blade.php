@extends('layouts.admin')

@section('title', 'Arsip Layanan')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Arsip Layanan</h1>
                <p class="text-sm text-slate-500">Arsip surat yang telah dicetak dan diselesaikan</p>
            </div>

            <div class="flex gap-3">
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </button>
                <button class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <!-- SEARCH & FILTER -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Cari Arsip</label>
                    <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nomor surat atau nama...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Jenis Surat</label>
                    <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>Semua</option>
                        <option>Keterangan</option>
                        <option>Pengantar</option>
                        <option>Undangan</option>
                        <option>Kuasa</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Bulan</label>
                    <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>Semua</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Tahun</label>
                    <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>2024</option>
                        <option>2023</option>
                        <option>2022</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Cari</button>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Nomor Surat</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Jenis Surat</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Pemohon</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Tanggal Cetak</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Petugas</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data - replace with dynamic data -->
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">001/DS/2024</td>
                                <td class="py-3 px-4">Surat Keterangan Domisili</td>
                                <td class="py-3 px-4">
                                    <div>
                                        <p class="font-medium">Ahmad Surya</p>
                                        <p class="text-xs text-slate-500">NIK: 1234567890123456</p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">2024-01-15 10:30</td>
                                <td class="py-3 px-4">Admin Desa</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Lihat Surat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-green-600 hover:bg-green-50 rounded" title="Cetak Ulang">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-yellow-600 hover:bg-yellow-50 rounded" title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">002/DS/2024</td>
                                <td class="py-3 px-4">Surat Keterangan Tidak Mampu</td>
                                <td class="py-3 px-4">
                                    <div>
                                        <p class="font-medium">Siti Aminah</p>
                                        <p class="text-xs text-slate-500">NIK: 1234567890123457</p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">2024-01-14 14:20</td>
                                <td class="py-3 px-4">Admin Desa</td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Lihat Surat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-green-600 hover:bg-green-50 rounded" title="Cetak Ulang">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-yellow-600 hover:bg-yellow-50 rounded" title="Download PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
