@extends('layouts.admin')

@section('title', 'Buku Administrasi Penduduk')

@section('content')

    <p class="text-lg font-semibold text-gray-700 mb-1">Buku Administrasi Penduduk</p>
    <p class="text-sm text-gray-400 mb-6">Kelola data buku administrasi kependudukan desa</p>

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <a href="{{ route('admin.buku-administrasi.penduduk.induk-penduduk.index') }}"
            class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-500 transition-colors">
                    <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-2.791M9 20H4v-2a3 3 0 015.356-2.791M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a2 2 0 11-4 0 2 2 0 014 0zM7 12a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Induk
                        Penduduk</h3>
                    <p class="text-sm text-gray-500 mt-1">Data penduduk utama</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.buku-administrasi.penduduk.mutasi-penduduk.index') }}"
            class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 transition-colors">
                    <svg class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Mutasi
                        Penduduk Desa</h3>
                    <p class="text-sm text-gray-500 mt-1">Pindah masuk & keluar</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.buku-administrasi.penduduk.rekapitulasi-penduduk.index') }}"
            class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Rekapitulasi
                        Jumlah Penduduk</h3>
                    <p class="text-sm text-gray-500 mt-1">Statistik penduduk</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.buku-administrasi.penduduk.penduduk-sementara.index') }}"
            class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                    <svg class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku Penduduk
                        Sementara</h3>
                    <p class="text-sm text-gray-500 mt-1">Penduduk sementara</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.buku-administrasi.penduduk.ktp-kk.index') }}"
            class="group bg-white rounded-xl border border-gray-200 p-5 hover:border-emerald-500 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300">
            <div class="flex items-start gap-4">
                <div
                    class="w-12 h-12 rounded-lg bg-cyan-100 flex items-center justify-center flex-shrink-0 group-hover:bg-cyan-500 transition-colors">
                    <svg class="w-6 h-6 text-cyan-600 group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">Buku KTP dan KK
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Data KTP & Kartu Keluarga</p>
                </div>
            </div>
        </a>

    </div>

@endsection
