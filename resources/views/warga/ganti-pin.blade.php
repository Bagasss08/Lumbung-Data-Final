@extends('layouts.app')

@section('title', 'Ganti PIN')

@section('content')

<div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- ── Breadcrumb ── --}}
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-emerald-600 transition flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('warga.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-emerald-600 font-semibold">Ganti PIN</span>
        </nav>

        {{-- ── Layout Grid ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ══════════════════ KOLOM KIRI — Info & Tips ══════════════════ --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Card identitas --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center border border-emerald-100">
                                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Ganti PIN</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Keamanan Akun Layanan Mandiri</p>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            PIN digunakan untuk masuk ke portal Layanan Mandiri. Pastikan PIN Anda mudah diingat namun sulit ditebak.
                        </p>
                    </div>
                </div>

                {{-- Card tips keamanan --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-6 h-6 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-700">Syarat PIN Aman</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach ([
                            ['icon' => 'M9 12l2 2 4-4', 'color' => 'emerald', 'text' => 'Tepat 6 digit angka'],
                            ['icon' => 'M9 12l2 2 4-4', 'color' => 'emerald', 'text' => 'Hindari urutan (123456)'],
                            ['icon' => 'M9 12l2 2 4-4', 'color' => 'emerald', 'text' => 'Hindari angka sama berulang (111111)'],
                            ['icon' => 'M9 12l2 2 4-4', 'color' => 'emerald', 'text' => 'Berbeda dari PIN lama'],
                            ['icon' => 'M9 12l2 2 4-4', 'color' => 'emerald', 'text' => 'Jangan bagikan PIN ke siapapun'],
                        ] as $tip)
                            <li class="flex items-start gap-2.5">
                                <div class="w-5 h-5 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $tip['icon'] }}"/>
                                    </svg>
                                </div>
                                <span class="text-xs text-slate-600 leading-relaxed">{{ $tip['text'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Card info pengguna --}}
                <div class="bg-emerald-600 rounded-2xl p-5 text-white">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'W', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-emerald-100">Login sebagai</p>
                            <p class="text-sm font-semibold">{{ Auth::user()->name ?? 'Warga' }}</p>
                        </div>
                    </div>
                    <div class="border-t border-white/20 pt-3 mt-2">
                        <p class="text-xs text-emerald-100 leading-relaxed">
                            Setelah PIN berhasil diganti, gunakan PIN baru saat login ke Layanan Mandiri berikutnya.
                        </p>
                    </div>
                </div>

            </div>

            {{-- ══════════════════ KOLOM KANAN — Form ══════════════════ --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                    {{-- Header form --}}
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Perbarui PIN Anda</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Isi ketiga kolom berikut untuk mengganti PIN</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">

                        {{-- Alert sukses --}}
                        @if (session('success'))
                            <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-3.5">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-emerald-800">PIN Berhasil Diperbarui</p>
                                    <p class="text-xs text-emerald-600 mt-0.5">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Alert error --}}
                        @if ($errors->any())
                            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3.5">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-red-700">Terjadi Kesalahan</p>
                                    <ul class="mt-1 space-y-0.5">
                                        @foreach ($errors->all() as $err)
                                            <li class="text-xs text-red-600">• {{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('warga.ganti-pin.update') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            {{-- ── PIN Lama ── --}}
                            <div x-data="pinField()">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                                    PIN Lama <span class="text-red-400 normal-case tracking-normal font-normal">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="pin_lama"
                                        placeholder="••••••"
                                        maxlength="6"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        required
                                        class="w-full pl-10 pr-10 py-3 border rounded-xl text-sm tracking-[0.3em] font-mono
                                               placeholder:tracking-normal placeholder:font-sans
                                               focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                               transition-all
                                               {{ $errors->has('pin_lama') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}">
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-3.5 flex items-center text-slate-300 hover:text-slate-500 transition">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('pin_lama')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Divider --}}
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-px bg-slate-100"></div>
                                <span class="text-xs text-slate-400 font-medium">PIN BARU</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </div>

                            {{-- ── PIN Baru ── --}}
                            <div x-data="pinField()">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                                    PIN Baru <span class="text-red-400 normal-case tracking-normal font-normal">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </div>
                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="pin_baru"
                                        id="pin_baru"
                                        placeholder="••••••"
                                        maxlength="6"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        required
                                        @input="checkStrength($event.target.value)"
                                        class="w-full pl-10 pr-10 py-3 border rounded-xl text-sm tracking-[0.3em] font-mono
                                               placeholder:tracking-normal placeholder:font-sans
                                               focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                               transition-all
                                               {{ $errors->has('pin_baru') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}">
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-3.5 flex items-center text-slate-300 hover:text-slate-500 transition">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Strength meter --}}
                                <div x-show="strength > 0" class="mt-2.5">
                                    <div class="flex gap-1.5 mb-1.5">
                                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                            :class="strength >= 1
                                                ? (strength === 1 ? 'bg-red-400' : strength === 2 ? 'bg-amber-400' : 'bg-emerald-500')
                                                : 'bg-slate-100'"></div>
                                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                            :class="strength >= 2
                                                ? (strength === 2 ? 'bg-amber-400' : 'bg-emerald-500')
                                                : 'bg-slate-100'"></div>
                                        <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                            :class="strength >= 3 ? 'bg-emerald-500' : 'bg-slate-100'"></div>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-1.5 h-1.5 rounded-full"
                                            :class="strength === 1 ? 'bg-red-400' : strength === 2 ? 'bg-amber-400' : 'bg-emerald-500'"></div>
                                        <p class="text-xs font-medium"
                                            :class="strength === 1 ? 'text-red-500' : strength === 2 ? 'text-amber-500' : 'text-emerald-600'"
                                            x-text="strength === 1 ? 'PIN lemah — hindari angka berurutan atau berulang'
                                                    : strength === 2 ? 'PIN cukup kuat'
                                                    : 'PIN kuat ✓'"></p>
                                    </div>
                                </div>

                                @error('pin_baru')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ── Konfirmasi PIN Baru ── --}}
                            <div x-data="pinField()">
                                <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">
                                    Konfirmasi PIN Baru <span class="text-red-400 normal-case tracking-normal font-normal">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="pin_baru_confirmation"
                                        placeholder="••••••"
                                        maxlength="6"
                                        inputmode="numeric"
                                        pattern="[0-9]*"
                                        required
                                        class="w-full pl-10 pr-10 py-3 border rounded-xl text-sm tracking-[0.3em] font-mono
                                               placeholder:tracking-normal placeholder:font-sans
                                               focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                               transition-all
                                               {{ $errors->has('pin_baru_confirmation') ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white hover:border-slate-300' }}">
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-3.5 flex items-center text-slate-300 hover:text-slate-500 transition">
                                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('pin_baru_confirmation')
                                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                        <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- ── Tombol Submit ── --}}
                            <div class="pt-2 flex items-center gap-3">
                                <button type="submit"
                                    class="flex-1 flex items-center justify-center gap-2 px-6 py-3.5
                                           bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800
                                           text-white font-semibold text-sm rounded-xl
                                           shadow-sm shadow-emerald-600/20
                                           transition-all duration-150 hover:-translate-y-px active:translate-y-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan PIN Baru
                                </button>
                                <a href="{{ route('warga.profil') }}"
                                    class="px-5 py-3.5 border border-slate-200 hover:border-slate-300 hover:bg-slate-50
                                           text-slate-600 font-semibold text-sm rounded-xl transition-all duration-150 whitespace-nowrap">
                                    Batal
                                </a>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function pinField() {
    return {
        show: false,
        strength: 0,
        checkStrength(val) {
            if (!val || val.length < 6) { this.strength = 0; return; }
            const allSame    = /^(\d)\1+$/.test(val);
            const sequential = ['012345','123456','234567','345678','456789',
                                '987654','876543','765432','654321','543210'].includes(val);
            if (allSame || sequential) { this.strength = 1; return; }
            const unique = new Set(val.split('')).size;
            this.strength = unique <= 2 ? 2 : 3;
        }
    };
}
</script>

@endsection