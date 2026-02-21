@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6 flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl font-bold border-4 border-white shadow-lg">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-2xl font-bold text-slate-800">{{ $user->penduduk->nama ?? $user->name }}</h1>
                <p class="text-slate-500 font-mono bg-slate-100 px-3 py-1 rounded-lg inline-block mt-2">
                    NIK: {{ $user->penduduk->nik ?? '-' }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-800">Biodata Lengkap</h2>
            </div>
            <div class="p-8">
                @if($user->penduduk)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Tempat, Tanggal Lahir</span>
                        <span class="block text-slate-700 font-medium">
                            {{ $user->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($user->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Jenis Kelamin</span>
                        <span class="block text-slate-700 font-medium">
                            {{ $user->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Alamat</span>
                        <span class="block text-slate-700 font-medium">{{ $user->penduduk->alamat ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Agama</span>
                        <span class="block text-slate-700 font-medium">{{ $user->penduduk->agama }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Pekerjaan</span>
                        <span class="block text-slate-700 font-medium">{{ $user->penduduk->pekerjaan }}</span>
                    </div>
                    <div>
                        <span class="block text-sm text-slate-400 mb-1">Status Perkawinan</span>
                        <span class="block text-slate-700 font-medium">{{ $user->penduduk->status_kawin }}</span>
                    </div>
                </div>
                @else
                <div class="p-4 bg-yellow-50 text-yellow-700 rounded-xl">
                    Data penduduk tidak terhubung. Hubungi Admin.
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection