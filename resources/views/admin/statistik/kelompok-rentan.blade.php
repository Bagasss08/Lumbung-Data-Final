@extends('layouts.admin')

@section('title', 'Laporan Kelompok Rentan')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Laporan Kelompok Rentan</h1>
        <p class="text-sm text-slate-500">
            Data kelompok rentan dan penerima bantuan sosial
        </p>
    </div>

    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </button>
    </div>
</div>

<!-- ================= RINGKASAN ================= -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Kelompok Rentan</p>
                <h3 class="text-2xl font-bold text-red-600">
                    {{ array_sum($data['kelompok_rentan']) }}
                </h3>
            </div>
            <div class="p-3 bg-red-100 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Penerima Bantuan</p>
                <h3 class="text-2xl font-bold text-green-600">
                    {{ array_sum($data['bantuan']) }}
                </h3>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Coverage Bantuan</p>
                <h3 class="text-2xl font-bold text-blue-600">
                    {{ round((array_sum($data['bantuan']) / array_sum($data['kelompok_rentan'])) * 100, 1) }}%
                </h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Belum Terbantu</p>
                <h3 class="text-2xl font-bold text-orange-600">
                    {{ array_sum($data['kelompok_rentan']) - array_sum($data['bantuan']) }}
                </h3>
            </div>
            <div class="p-3 bg-orange-100 rounded-lg">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
        </div>
    </div>

</div>

<!-- ================= DETAIL KELOMPOK RENTAN ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- KELOMPOK RENTAN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            Kelompok Rentan
        </h4>

        <div class="space-y-3">
            @foreach($data['kelompok_rentan'] as $kategori => $jumlah)
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                        <span class="text-xs font-bold text-red-600">{{ substr($jumlah, 0, 2) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-red-800">{{ ucwords(str_replace('_', ' ', $kategori)) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-red-600">{{ $jumlah }}</p>
                    <p class="text-xs text-red-500">orang</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- PENERIMA BANTUAN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Penerima Bantuan Sosial
        </h4>

        <div class="space-y-3">
            @foreach($data['bantuan'] as $program => $jumlah)
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                        <span class="text-xs font-bold text-green-600">{{ substr($jumlah, 0, 2) }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-green-800">{{ $program }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold text-green-600">{{ $jumlah }}</p>
                    <p class="text-xs text-green-500">KK</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- ================= ANALISIS ================= -->
<div class="bg-white rounded-xl shadow p-6">
    <h4 class="font-semibold mb-4">Analisis Kelompok Rentan</h4>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- PRIORITAS BANTUAN -->
        <div class="space-y-3">
            <h5 class="font-medium text-slate-700">Prioritas Bantuan</h5>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Lansia Sendiri</span>
                    <span class="font-medium">{{ $data['kelompok_rentan']['lansia_sendiri'] }} orang</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Disabilitas</span>
                    <span class="font-medium">{{ $data['kelompok_rentan']['disabilitas'] }} orang</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Janda/Duda</span>
                    <span class="font-medium">{{ $data['kelompok_rentan']['janda_duda'] }} orang</span>
                </div>
            </div>
        </div>

        <!-- COVERAGE PROGRAM -->
        <div class="space-y-3">
            <h5 class="font-medium text-slate-700">Coverage Program</h5>
            <div class="space-y-2">
                @foreach($data['bantuan'] as $program => $jumlah)
                <div class="flex justify-between text-sm">
                    <span>{{ $program }}</span>
                    <span class="font-medium">{{ round(($jumlah / array_sum($data['kelompok_rentan'])) * 100, 1) }}%</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- REKOMENDASI -->
        <div class="space-y-3">
            <h5 class="font-medium text-slate-700">Rekomendasi</h5>
            <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-800">
                    <strong>{{ array_sum($data['kelompok_rentan']) - array_sum($data['bantuan']) }}</strong> orang kelompok rentan belum mendapat bantuan. Perlu intervensi program sosial tambahan.
                </p>
            </div>
        </div>

    </div>
</div>

@endsection
