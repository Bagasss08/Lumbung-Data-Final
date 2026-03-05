@extends('layouts.admin')

@section('title', 'Buku Administrasi Pembangunan')

@section('content')

    <p class="text-lg font-semibold text-gray-700 mb-1">Buku Administrasi Pembangunan</p>
    <p class="text-sm text-gray-400 mb-6">Kelola data pembangunan dan pemberdayaan masyarakat desa</p>

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <a href="{{ route('admin.buku-administrasi.pembangunan.rencana.index') }}" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500 transition-colors">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Rencana Kerja Pembangunan</h3>
                    <p class="text-sm text-gray-500 mt-1">Rencana pembangunan tahunan</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                    <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Kegiatan Pembangunan</h3>
                    <p class="text-sm text-gray-500 mt-1">Monitoring kegiatan</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Inventaris Hasil-Hasil Pembangunan</h3>
                    <p class="text-sm text-gray-500 mt-1">Data hasil pembangunan</p>
                </div>
            </div>
        </a>

        <a href="#" class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 transition-colors">
                    <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Kader Pemberdayaan Masyarakat</h3>
                    <p class="text-sm text-gray-500 mt-1">Data kader PPM</p>
                </div>
            </div>
        </a>

    </div>

@endsection

