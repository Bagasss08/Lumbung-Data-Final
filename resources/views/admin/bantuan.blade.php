@extends('layouts.admin')

@section('title','Data Bantuan Sosial')

@section('content')

<div class="p-8 bg-[#f8fafc] min-h-screen font-sans text-slate-900">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-2">Program Bantuan</h1>
            <p class="text-slate-500 text-sm flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                Kelola data penyaluran bantuan sosial desa secara terpusat.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button
                class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Impor Data
            </button>
            <button
                class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-800 transition-all flex items-center gap-2 shadow-md">
                <span class="text-lg leading-none">+</span>
                Tambah Program
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        @php
        $stats = [
        ['label' => 'Total Program', 'value' => '12', 'sub' => 'Aktif saat ini'],
        ['label' => 'Peserta', 'value' => '450', 'sub' => 'Jiwa terdaftar'],
        ['label' => 'Total Dana', 'value' => '120jt', 'sub' => 'Tahun 2026'],
        ['label' => 'Status Salur', 'value' => '85%', 'sub' => 'Rata-rata desa'],
        ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $s['label'] }}</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $s['value'] }}</h3>
            <p class="text-[10px] text-slate-400 mt-1 font-medium">{{ $s['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm overflow-hidden">

        <div
            class="p-6 flex flex-col md:flex-row gap-4 items-center justify-between bg-slate-50/50 border-b border-slate-100">
            <div class="relative w-full md:w-80">
                <input type="text" placeholder="Cari nama program..."
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                <svg class="w-4 h-4 absolute left-3.5 top-3 text-slate-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <select
                    class="bg-white border border-slate-200 text-slate-600 text-sm rounded-xl px-4 py-2.5 outline-none w-full md:w-44 focus:ring-2 focus:ring-blue-500/10 transition-all cursor-pointer font-medium">
                    <option>Semua Sasaran</option>
                    <option>Keluarga</option>
                    <option>Individu</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[11px] font-bold uppercase tracking-[0.1em]">
                        <th class="px-8 py-5 border-b border-slate-100">Info Program</th>
                        <th class="px-8 py-5 border-b border-slate-100">Asal Dana</th>
                        <th class="px-8 py-5 border-b border-slate-100 text-center">Sasaran</th>
                        <th class="px-8 py-5 border-b border-slate-100 text-center">Status</th>
                        <th class="px-8 py-5 border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 mb-0.5">BLT Dana Desa</span>
                                <span class="text-xs text-slate-400 font-medium tracking-tight">Keluarga Ahmad Fauzi •
                                    320401***</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">Dana Desa (DD)</span>
                                <span class="text-[10px] text-slate-400 uppercase font-semibold">Januari 2026</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span
                                class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full uppercase tracking-tighter">
                                Keluarga
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold rounded-full uppercase">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                Tersalurkan
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                <button class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-rose-50 text-rose-600 rounded-lg transition-colors"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800 mb-0.5">PKH Tahap 1</span>
                                <span class="text-xs text-slate-400 font-medium tracking-tight">Ibu Siti Aminah •
                                    320401***</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">APBN / Kemensos</span>
                                <span class="text-[10px] text-slate-400 uppercase font-semibold">Februari 2026</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span
                                class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full uppercase tracking-tighter">
                                Individu
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-full uppercase">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Sedang Proses
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                <button class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-rose-50 text-rose-600 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="p-6 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.05em]">Halaman 1 dari 45</p>
            <div class="flex gap-2">
                <button
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-xs shadow-lg shadow-blue-200">1</button>
                <button
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-600 hover:border-blue-500 hover:text-blue-500 font-bold text-xs transition-all">2</button>
                <button
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-blue-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection