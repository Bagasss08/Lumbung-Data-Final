{{-- resources/views/admin/pengaduan/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb / Back --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.pengaduan.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-600 hover:text-gray-800 text-sm font-medium rounded-xl border border-gray-200 shadow-sm transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
        <div class="text-gray-400 text-sm">
            <span>Pengaduan</span>
            <span class="mx-2">/</span>
            <span class="text-gray-700 font-medium">Detail #{{ $pengaduan->id }}</span>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition
        class="flex items-center justify-between gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ===== Kolom Kiri: Detail ===== --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Info Pelapor + Status --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Header Card --}}
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($pengaduan->nama, 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">{{ $pengaduan->nama }}</h4>
                            <p class="text-xs text-white/70">Pelapor</p>
                        </div>
                    </div>
                    @php
                    $badgeMap = [
                    'warning' => 'bg-amber-100 text-amber-700',
                    'info' => 'bg-blue-100 text-blue-700',
                    'success' => 'bg-emerald-100 text-emerald-700',
                    'danger' => 'bg-red-100 text-red-700',
                    ];
                    $badgeClass = $badgeMap[$pengaduan->status_badge] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span
                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $badgeClass }}">
                        {{ $pengaduan->status_label }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5 space-y-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if($pengaduan->penduduk)
                        <div class="bg-gray-50 rounded-xl p-3.5">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">NIK</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ $pengaduan->penduduk->nik ?? '-' }}</dd>
                        </div>
                        @endif
                    
                        {{-- Email selalu tampil, di luar @if penduduk --}}
                        <div class="bg-gray-50 rounded-xl p-3.5">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Email</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ $pengaduan->email ?? '-' }}</dd>
                        </div>
                    
                        <div class="bg-gray-50 rounded-xl p-3.5">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Tanggal Pengaduan</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ $pengaduan->created_at->format('d F Y, H:i') }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3.5">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">IP Address</dt>
                            <dd class="text-sm font-mono text-gray-800">{{ $pengaduan->ip_address ?? '-' }}</dd>
                        </div>
                        @if($pengaduan->petugas)
                        <div class="bg-gray-50 rounded-xl p-3.5">
                            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Ditangani Oleh</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ $pengaduan->petugas->name }}</dd>
                        </div>
                        @endif
                    </dl>

                    {{-- Subjek --}}
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Subjek</p>
                        <p class="text-base font-semibold text-gray-800">{{ $pengaduan->subjek }}</p>
                    </div>

                    {{-- Isi Pengaduan --}}
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Isi Pengaduan</p>
                        <div
                            class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                            {!! nl2br(e($pengaduan->isi)) !!}
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    @if($pengaduan->lampiran)
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Lampiran</p>
                        <a href="{{ Storage::url($pengaduan->lampiran) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-xl border border-blue-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            Lihat Lampiran
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tanggapan Sebelumnya --}}
            @if($pengaduan->tanggapan)
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 overflow-hidden">
                <div class="bg-emerald-50 border-b border-emerald-100 px-6 py-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-emerald-800 text-sm">Tanggapan Admin</p>
                        @if($pengaduan->petugas)
                        <p class="text-xs text-emerald-600">Oleh {{ $pengaduan->petugas->name }}</p>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {!! nl2br(e($pengaduan->tanggapan)) !!}
                    </p>
                </div>
            </div>
            @endif

        </div>

        {{-- ===== Kolom Kanan: Form Tanggapan ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h5 class="font-semibold text-gray-800">Berikan Tanggapan</h5>
                </div>

                {{-- Form --}}
                <div class="px-6 py-5">
                    <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan) }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Status --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Status Pengaduan
                            </label>
                            <select name="status"
                                class="w-full px-3.5 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition bg-white @error('status') border-red-400 ring-2 ring-red-200 @enderror">
                                @foreach($statusList as $val => $label)
                                <option value="{{ $val }}" {{ $pengaduan->status == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Isi Tanggapan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Isi Tanggapan
                            </label>
                            <textarea name="tanggapan" rows="7"
                                class="w-full px-3.5 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none @error('tanggapan') border-red-400 ring-2 ring-red-200 @enderror"
                                placeholder="Tulis tanggapan resmi Anda di sini...">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                            @error('tanggapan')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-3 bg-gradient-to-br from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Simpan Tanggapan
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection