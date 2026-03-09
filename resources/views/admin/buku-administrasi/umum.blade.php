@extends('layouts.admin')

@section('title', 'Buku Administrasi Umum')

@section('content')

    <p class="text-lg font-semibold text-gray-700 mb-1">Buku Administrasi Umum</p>
    <p class="text-sm text-gray-400 mb-6">Kelola berbagai buku administrasi desa secara terorganisir</p>

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <a href="{{ route('admin.buku-administrasi.umum.peraturan-desa.index') }}" 
           class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Peraturan di Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola peraturan desa</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500 transition-colors">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Keputusan Kepala Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola keputusan kepala desa</p>
                </div>
            </div>
        </a>

       <a href="{{ route('admin.buku-administrasi.umum.inventaris-kekayaan-desa.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                    <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Inventaris dan Kekayaan Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat inventaris desa</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 transition-colors">
                    <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Pemerintah Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Data perangkat desa</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-teal-100 flex items-center justify-center flex-shrink-0 group-hover:bg-teal-500 transition-colors">
                    <svg class="w-6 h-6 text-teal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Tanah Kas Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat tanah kas desa</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Tanah di Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Data tanah di desa</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-cyan-100 flex items-center justify-center flex-shrink-0 group-hover:bg-cyan-500 transition-colors">
                    <svg class="w-6 h-6 text-cyan-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Agenda - Surat Keluar</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat surat keluar</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-500 transition-colors">
                    <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Agenda - Surat Masuk</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat surat masuk</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500 transition-colors">
                    <svg class="w-6 h-6 text-orange-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Ekspedisi</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat pengiriman surat</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-pink-100 flex items-center justify-center flex-shrink-0 group-hover:bg-pink-500 transition-colors">
                    <svg class="w-6 h-6 text-pink-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Lembaran Desa dan Berita Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Publikasi desa</p>
                </div>
            </div>
        </a>

    </div>

@endsection