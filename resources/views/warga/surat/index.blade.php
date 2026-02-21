@extends('layouts.app')

@section('title', 'Layanan Surat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Layanan Surat Online</h1>
        <a href="{{ route('warga.surat.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-md inline-flex items-center gap-2">
            <span>+</span> Buat Permohonan Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center">
        <div class="w-20 h-20 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-slate-700 mb-1">Belum Ada Riwayat Surat</h3>
        <p class="text-slate-500 max-w-sm mx-auto">
            Anda belum pernah mengajukan permohonan surat apapun. Silakan buat permohonan baru jika diperlukan.
        </p>
    </div>
</div>
@endsection