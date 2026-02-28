@extends('layouts.app')
@section('title', 'Tulis Pesan')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    
    <a href="{{ route('warga.pesan.index') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 font-medium mb-6 transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Batal Menulis
    </a>

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 font-medium">
            <svg class="w-5 h-5 inline-block mr-1 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
            <h1 class="text-xl font-bold text-slate-800">Tulis Pesan ke Admin Desa</h1>
            <p class="text-sm text-slate-500 mt-1">Sampaikan pertanyaan, keluhan, atau laporan Anda langsung ke admin.</p>
        </div>

        @if($errors->any())
            <div class="mx-8 mt-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200">
                <ul class="list-disc pl-5 text-sm font-medium">
                    @foreach($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('warga.pesan.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            @if(isset($replyTo))
                <input type="hidden" name="reply_to" value="{{ $replyTo }}">
            @endif

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Subjek Pesan <span class="text-red-500">*</span></label>
                <input type="text" name="subjek" value="{{ request('subject', $subject ?? '') }}" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none" required placeholder="Contoh: Pertanyaan seputar Bantuan Sosial">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Isi Pesan <span class="text-red-500">*</span></label>
                <textarea name="isi_pesan" rows="8" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none" required placeholder="Tuliskan pesan Anda secara detail di sini..."></textarea>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500">Pesan akan langsung terkirim ke Dashboard Admin.</p>
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transform hover:-translate-y-0.5 transition-all">
                    Kirim Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection