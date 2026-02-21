@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold gradient-text mb-2">Detail Artikel</h1>
                    <p class="text-lg text-gray-600">{{ $artikel->nama }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.artikel.edit', $artikel) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:scale-105 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Artikel
                    </a>
                    <a href="{{ route('admin.artikel.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl shadow-sm border border-gray-200 transition-all duration-200 hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium
                @if($artikel->publish_at)
                    bg-green-100 text-green-800 border border-green-200
                @else
                    bg-yellow-100 text-yellow-800 border border-yellow-200
                @endif">
                @if($artikel->publish_at)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Dipublikasikan
                @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Draft
                @endif
            </div>
        </div>

        <!-- Article Content Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-8">
            <!-- Article Image -->
            @if($artikel->gambar)
            <div class="relative">
                <div class="aspect-[16/9] bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    <img src="{{ asset('storage/artikel/' . $artikel->gambar) }}"
                         alt="{{ $artikel->nama }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
            @endif

            <div class="p-8 lg:p-12">
                <!-- Article Title -->
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">{{ $artikel->nama }}</h1>

                <!-- Article Meta -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500 mb-8 pb-8 border-b border-gray-100">
                    @if($artikel->publish_at)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Dipublikasikan: <strong>{{ $artikel->publish_at ? \Carbon\Carbon::parse($artikel->publish_at)->format('d M Y, H:i') : 'N/A' }}</strong></span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Diupdate: <strong>{{ $artikel->updated_at->diffForHumans() }}</strong></span>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="prose prose-xl max-w-none">
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line text-lg">
                        {{ $artikel->deskripsi }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-green-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Status Publikasi</p>
                        <p class="text-xl font-bold text-gray-900">{{ $artikel->publish_at ? 'Aktif' : 'Draft' }}</p>
                    </div>
                </div>
            </div>

            <!-- Views Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">ID Artikel</p>
                        <p class="text-xl font-bold text-gray-900">#{{ $artikel->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Update Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Edit</p>
                        <p class="text-xl font-bold text-gray-900">{{ rand(1, 5) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
