@extends('layouts.admin')

@section('title', 'Lumbung Data - Manajemen Pelapak')

@section('content')
<div class="min-h-screen bg-[#fcfdfe] p-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <nav class="flex text-sm text-slate-400 mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="#" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
                    <li class="flex items-center space-x-2">
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-800 font-medium">Lumbung Pelapak</span>
                    </li>
                </ol>
            </nav>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Pelapak</h1>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-2xl text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
                <i class="fa fa-download"></i> Export
            </button>
            <button
                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-sm font-semibold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all">
                <span class="text-lg leading-none">+</span> Tambah Pelapak
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <div
            class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-50/50 transition-all duration-300 relative overflow-hidden">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative flex items-center gap-5">
                <div
                    class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Produk</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-slate-800">1,280</h3>
                        <span
                            class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-50/50 transition-all duration-300 relative overflow-hidden">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative flex items-center gap-5">
                <div
                    class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Pelapak Aktif</p>
                    <h3 class="text-3xl font-black text-slate-800">45</h3>
                </div>
            </div>
        </div>

        <div
            class="group bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-orange-50/50 transition-all duration-300 relative overflow-hidden">
            <div
                class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500">
            </div>
            <div class="relative flex items-center gap-5">
                <div
                    class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-200">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Kategori</p>
                    <h3 class="text-3xl font-black text-slate-800">12</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="relative w-full md:w-96 group">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
                    <i class="fa fa-search"></i>
                </div>
                <input type="text" placeholder="Cari nama pelapak atau ID..."
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-blue-500/20 transition-all outline-none text-slate-600 placeholder:text-slate-400">
            </div>

            <div class="flex items-center gap-4">
                <select
                    class="bg-slate-50 border-none text-slate-600 text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 outline-none cursor-pointer">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Pending</option>
                </select>
                <div class="h-8 w-[1px] bg-slate-200 hidden md:block"></div>
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">Total: 45 Entri</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-xs font-bold uppercase tracking-widest border-b border-slate-50">
                        <th class="px-8 py-5">#</th>
                        <th class="px-8 py-5">Informasi Pelapak</th>
                        <th class="px-8 py-5">Kontak</th>
                        <th class="px-8 py-5 text-center">Produk</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="max-w-xs mx-auto flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h4 class="text-slate-800 font-bold mb-1">Data Belum Tersedia</h4>
                                <p class="text-slate-400 text-sm italic">Silahkan tambahkan data pelapak baru untuk
                                    memulai manajemen.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-8 bg-slate-50/50 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <button
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-600 transition-all shadow-sm">
                    <i class="fa fa-angle-left"></i>
                </button>
                <div class="flex items-center gap-1">
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-100">1</button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white text-slate-600 hover:bg-slate-100 transition-all font-semibold">2</button>
                </div>
                <button
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-600 transition-all shadow-sm">
                    <i class="fa fa-angle-right"></i>
                </button>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Halaman 1 dari 1</p>
        </div>
    </div>
</div>
@endsection