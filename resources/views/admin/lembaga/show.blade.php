@extends('layouts.admin')

@section('title', 'Detail Lembaga')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
    <div class="flex justify-between items-end mb-6">
        <div>
            <div class="text-sm text-gray-500 mb-1">
                Info Desa <span class="mx-1">&rsaquo;</span> 
                <a href="{{ route('admin.lembaga.index') }}" class="hover:text-emerald-600 transition">Master Lembaga</a> <span class="mx-1">&rsaquo;</span> 
                <span class="text-emerald-600 font-semibold">Detail</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Informasi Lengkap Lembaga</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.lembaga.edit', $lembaga->id) }}" class="px-5 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow-sm flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit
            </a>
            <a href="{{ route('admin.lembaga.index') }}" class="px-5 py-2 text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center gap-2 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 flex flex-col items-center justify-center text-center shadow-sm h-full">
                <div class="w-32 h-32 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 mb-6">
                    <span class="text-4xl font-black">{{ substr($lembaga->singkatan ?? $lembaga->nama, 0, 2) }}</span>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-2 leading-tight">{{ $lembaga->nama }}</h3>
                <p class="text-sm font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full mb-6">{{ $lembaga->jenis ?? 'Lembaga Umum' }}</p>
                <div class="bg-emerald-100 text-emerald-700 font-bold text-xs uppercase px-4 py-1.5 rounded-full tracking-wider">
                    Status: Aktif
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-6 pb-3 border-b border-gray-100">IDENTITAS UTAMA</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">NAMA LENGKAP LEMBAGA</p>
                        <p class="text-sm font-bold text-gray-900">{{ $lembaga->nama }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">KODE / SINGKATAN</p>
                        <p class="text-sm font-bold text-gray-900">{{ $lembaga->singkatan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm
