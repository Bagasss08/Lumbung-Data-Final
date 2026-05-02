@extends('layouts.app')

@section('title', 'Ganti PIN')

@section('content')

<div class="min-h-screen bg-slate-50 flex items-start justify-center py-12 px-4">
    <div class="w-full max-w-sm">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-lg font-bold text-slate-800">Ganti PIN</h1>
            <p class="text-sm text-slate-400 mt-0.5">Perbarui PIN untuk keamanan akun Anda</p>
        </div>

        {{-- Modal sukses ganti PIN (muncul sebelum redirect ke login) --}}
        @if (session('pin_changed'))
            <div id="pin-success-overlay"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                style="background: rgba(0,0,0,0.5);">

                <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm overflow-hidden">

                    <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">PIN berhasil diperbarui</p>
                            <p class="text-xs text-slate-400">Informasi</p>
                        </div>
                    </div>

                    <div class="px-5 py-4">
                        <p class="text-sm text-slate-500 leading-relaxed">
                            PIN Anda telah berhasil diganti. Silakan login kembali menggunakan
                            <span class="font-semibold text-slate-700">PIN baru</span> Anda.
                        </p>
                    </div>

                    <div class="px-5 pb-5">
                        {{-- Logout dari layanan mandiri lalu ke halaman login --}}
                        <form action="{{ route('layanan-mandiri.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full px-4 py-2.5 text-sm font-semibold text-white
                                       bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                                OK
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endif

        {{-- Alert error --}}
        @if ($errors->any())
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-5">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <ul class="space-y-0.5">
                    @foreach ($errors->all() as $err)
                        <li class="text-sm text-red-600">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-5">

            <form action="{{ route('warga.ganti-pin.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- PIN Lama --}}
                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        PIN lama <span class="text-red-400 normal-case font-normal tracking-normal">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="pin_lama"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            placeholder="••••••"
                            required
                            class="w-full pr-10 py-2.5 px-3 border rounded-xl text-sm font-mono tracking-[0.3em]
                                   placeholder:tracking-normal placeholder:font-sans
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                   transition {{ $errors->has('pin_lama') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-slate-500 transition">
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
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Divider --}}
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-slate-100"></div>
                    <span class="text-xs text-slate-300 font-medium uppercase tracking-wider">PIN baru</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </div>

                {{-- PIN Baru --}}
                <div x-data="{ show: false, strength: 0 }">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        PIN baru <span class="text-red-400 normal-case font-normal tracking-normal">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="pin_baru"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            placeholder="••••••"
                            required
                            @input="
                                const v = $event.target.value;
                                if (!v || v.length < 6) { strength = 0; return; }
                                const allSame = /^(\d)\1+$/.test(v);
                                const seq = ['012345','123456','234567','345678','456789','987654','876543','765432','654321','543210'].includes(v);
                                if (allSame || seq) { strength = 1; return; }
                                strength = new Set(v.split('')).size <= 2 ? 2 : 3;
                            "
                            class="w-full pr-10 py-2.5 px-3 border rounded-xl text-sm font-mono tracking-[0.3em]
                                   placeholder:tracking-normal placeholder:font-sans
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                   transition {{ $errors->has('pin_baru') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-slate-500 transition">
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
                    <div x-show="strength > 0" class="mt-2">
                        <div class="flex gap-1 mb-1">
                            <div class="h-1 flex-1 rounded-full transition-all"
                                :class="strength >= 1 ? (strength === 1 ? 'bg-red-400' : strength === 2 ? 'bg-amber-400' : 'bg-emerald-500') : 'bg-slate-100'"></div>
                            <div class="h-1 flex-1 rounded-full transition-all"
                                :class="strength >= 2 ? (strength === 2 ? 'bg-amber-400' : 'bg-emerald-500') : 'bg-slate-100'"></div>
                            <div class="h-1 flex-1 rounded-full transition-all"
                                :class="strength >= 3 ? 'bg-emerald-500' : 'bg-slate-100'"></div>
                        </div>
                        <p class="text-xs"
                            :class="strength === 1 ? 'text-red-500' : strength === 2 ? 'text-amber-500' : 'text-emerald-600'"
                            x-text="strength === 1 ? 'PIN lemah' : strength === 2 ? 'PIN cukup' : 'PIN kuat'"></p>
                    </div>

                    @error('pin_baru')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi PIN Baru --}}
                <div x-data="{ show: false }">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Konfirmasi PIN baru <span class="text-red-400 normal-case font-normal tracking-normal">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="show ? 'text' : 'password'"
                            name="pin_baru_confirmation"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            placeholder="••••••"
                            required
                            class="w-full pr-10 py-2.5 px-3 border rounded-xl text-sm font-mono tracking-[0.3em]
                                   placeholder:tracking-normal placeholder:font-sans
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400
                                   transition {{ $errors->has('pin_baru_confirmation') ? 'border-red-300 bg-red-50' : 'border-slate-200' }}">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-slate-500 transition">
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
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="pt-1">
                    <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-semibold text-white
                               bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                        Simpan PIN baru
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection