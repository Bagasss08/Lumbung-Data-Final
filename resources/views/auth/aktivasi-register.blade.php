@extends('layouts.app')

@section('title', 'Buat Akun Warga')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
        
        <div class="text-center">
            <div class="mx-auto h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">
                Buat Keamanan Akun
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Data Anda ditemukan! Silakan buat password untuk login.
            </p>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
            <h3 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Identitas Terverifikasi</h3>
            <div class="flex flex-col gap-1">
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">Nama Lengkap</span>
                    <span class="text-sm font-semibold text-slate-700 text-right">{{ $penduduk->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">NIK</span>
                    <span class="text-sm font-semibold text-slate-700 text-right">{{ $penduduk->nik }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">Alamat</span>
                    <span class="text-sm font-semibold text-slate-700 text-right">{{ $penduduk->alamat_sekarang ?? 'Desa setempat' }}</span>
                </div>
            </div>
        </div>

        <form class="space-y-6" action="{{ route('aktivasi.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="penduduk_id" value="{{ $penduduk->id }}">

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                        Alamat Email (Opsional)
                    </label>
                    <input id="email" name="email" type="email" 
                        class="appearance-none block w-full px-3 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm" 
                        placeholder="contoh@email.com">
                    <p class="mt-1 text-xs text-slate-400">Berguna jika Anda lupa password.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                        Password Baru
                    </label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none block w-full px-3 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                        placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                        Ulangi Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="appearance-none block w-full px-3 py-3 border border-slate-300 placeholder-slate-400 text-slate-900 rounded-xl focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                        placeholder="Ketik ulang password">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    Aktifkan Akun Saya
                </button>
            </div>
            
            <div class="text-center mt-2">
                <a href="{{ route('aktivasi.index') }}" class="font-medium text-sm text-slate-500 hover:text-slate-700 transition">
                    Batalkan
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
