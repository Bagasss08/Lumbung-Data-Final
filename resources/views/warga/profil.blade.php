@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="bg-slate-50 py-8">
    <div class="container mx-auto px-4 py-4 sm:px-6 lg:px-8 max-w-5xl">

        {{-- Page Banner --}}
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-16 h-16 bg-white/15 rounded-3xl flex items-center justify-center">
                        <span class="text-2xl font-bold">P</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Profil Saya</h1>
                        <p class="mt-1 text-emerald-100 text-base">Lihat data pribadi Anda dengan tampilan yang lebih modern dan konsisten.</p>
                    </div>
                </div>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white/10 transform skew-x-12"></div>
        </div>

        <div class="space-y-6">

        {{-- Header Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
            <div class="flex flex-col sm:flex-row items-center gap-5">
                <div class="w-20 h-20 md:w-24 md:h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl font-bold border-4 border-white shadow-lg shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="text-center sm:text-left">
                    <h1 class="text-xl md:text-2xl font-bold text-slate-800">
                        {{ $user->penduduk->nama ?? $user->name }}
                    </h1>
                    <p class="text-slate-500 font-mono bg-slate-100 px-3 py-1 rounded-lg inline-block mt-2 text-sm">
                        NIK: {{ $user->penduduk->nik ?? '-' }}
                    </p>
                    <p class="text-slate-400 text-sm mt-1">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        {{-- Biodata Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 md:px-8 py-5 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Biodata Lengkap</h2>
            </div>

            <div class="p-6 md:p-8">
                @if($user->penduduk)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-x-12 md:gap-y-6">

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Tempat, Tanggal Lahir</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{ $user->penduduk->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($user->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Jenis Kelamin</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{ $user->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Alamat</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{ $user->penduduk->alamat ?? '-' }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Agama</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{-- Jika relasi: gunakan ->agama->nama, jika string langsung: ->agama --}}
                            {{ is_object($user->penduduk->agama) ? $user->penduduk->agama->nama : ($user->penduduk->agama ?? '-') }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Pekerjaan</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{-- Jika relasi: gunakan ->pekerjaan->nama, jika string langsung: ->pekerjaan --}}
                            {{ is_object($user->penduduk->pekerjaan) ? $user->penduduk->pekerjaan->nama : ($user->penduduk->pekerjaan ?? '-') }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs md:text-sm text-slate-400 mb-1">Status Perkawinan</span>
                        <span class="block text-slate-700 font-medium text-sm md:text-base">
                            {{-- Jika relasi: gunakan ->statusKawin->nama atau ->status_kawin->nama --}}
                            {{ is_object($user->penduduk->status_kawin) ? $user->penduduk->status_kawin->nama : ($user->penduduk->status_kawin ?? '-') }}
                        </span>
                    </div>

                </div>
                @else
                <div class="p-4 bg-yellow-50 text-yellow-700 rounded-xl text-sm">
                    Data penduduk tidak terhubung. Hubungi Admin.
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
