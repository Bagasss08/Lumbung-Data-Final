@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 no-print">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Laporan APBDes</h1>
                <p class="text-slate-600">Anggaran Pendapatan dan Belanja Desa - Tahun {{ $tahun }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.keuangan.apbdes') }}"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-folder-open mr-2"></i>Kelola APBDes
                </a>
                <button onclick="window.print()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <button onclick="window.print()"
                    class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                    <i class="fas fa-download mr-2"></i>Export PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center no-print">
        <i class="fas fa-check-circle mr-3"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center no-print">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Period Selection -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 no-print">
        <form method="GET" action="{{ route('admin.keuangan.laporan-apbdes') }}"
            class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tahun Anggaran</label>
                <select name="tahun"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ request('tahun', $tahun)==$year ? 'selected' : '' }}>{{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Periode</label>
                <select name="periode"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="semua" {{ request('periode', $periode)=='semua' ? 'selected' : '' }}>Semua</option>
                    <option value="jan-jun" {{ request('periode', $periode)=='jan-jun' ? 'selected' : '' }}>Januari -
                        Juni</option>
                    <option value="jul-des" {{ request('periode', $periode)=='jul-des' ? 'selected' : '' }}>Juli -
                        Desember</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-search mr-2"></i>Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 no-print">
        <!-- Total Pendapatan -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-100 rounded-lg">
                    <i class="fas fa-arrow-down text-2xl text-emerald-600"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full">
                    Anggaran
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-600 mb-1">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-emerald-600 mb-2">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs text-slate-500">
                <span>Realisasi: Rp {{ number_format($realisasiPendapatan, 0, ',', '.') }}</span>
            </div>
            <!-- Progress Bar -->
            @php
            $persenPendapatan = $totalPendapatan > 0 ? round(($realisasiPendapatan / $totalPendapatan) * 100, 1) : 0;
            @endphp
            <div class="mt-3">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-slate-600">Progress</span>
                    <span class="font-semibold text-emerald-600">{{ $persenPendapatan }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full transition-all"
                        style="width: {{ min($persenPendapatan, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Total Belanja -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-arrow-up text-2xl text-red-600"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-red-100 text-red-800 rounded-full">
                    Anggaran
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-600 mb-1">Total Belanja</h3>
            <p class="text-2xl font-bold text-red-600 mb-2">
                Rp {{ number_format($totalBelanja, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs text-slate-500">
                <span>Realisasi: Rp {{ number_format($realisasiBelanja, 0, ',', '.') }}</span>
            </div>
            <!-- Progress Bar -->
            @php
            $persenBelanja = $totalBelanja > 0 ? round(($realisasiBelanja / $totalBelanja) * 100, 1) : 0;
            @endphp
            <div class="mt-3">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-slate-600">Progress</span>
                    <span class="font-semibold text-red-600">{{ $persenBelanja }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full transition-all"
                        style="width: {{ min($persenBelanja, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Surplus/Defisit -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="p-3 {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'bg-blue-100' : 'bg-amber-100' }} rounded-lg">
                    <i
                        class="fas fa-balance-scale text-2xl {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'text-blue-600' : 'text-amber-600' }}"></i>
                </div>
                <span
                    class="text-xs font-semibold px-2 py-1 {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }} rounded-full">
                    {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'Surplus' : 'Defisit' }}
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-600 mb-1">Surplus/Defisit Anggaran</h3>
            <p
                class="text-2xl font-bold {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'text-blue-600' : 'text-amber-600' }} mb-2">
                Rp {{ number_format(abs($totalPendapatan - $totalBelanja), 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs text-slate-500">
                <span>Pendapatan - Belanja</span>
            </div>
        </div>

        <!-- Sisa Anggaran -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-wallet text-2xl text-purple-600"></i>
                </div>
                <span class="text-xs font-semibold px-2 py-1 bg-purple-100 text-purple-800 rounded-full">
                    Sisa
                </span>
            </div>
            <h3 class="text-sm font-medium text-slate-600 mb-1">Sisa Anggaran Belanja</h3>
            <p class="text-2xl font-bold text-purple-600 mb-2">
                Rp {{ number_format($totalBelanja - $realisasiBelanja, 0, ',', '.') }}
            </p>
            <div class="flex items-center text-xs text-slate-500">
                <span>Belum direalisasikan</span>
            </div>
        </div>
    </div>

    <!-- APBDes Report (untuk Print) -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden" id="apbdes-report">
        <!-- Report Header -->
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <div class="text-center">
                <h2 class="text-xl font-bold text-slate-800">ANGGARAN PENDAPATAN DAN BELANJA DESA</h2>
                <p class="text-sm text-slate-600 mt-1">Tahun Anggaran {{ $tahun }}</p>
                @if($periode !== 'semua')
                <p class="text-sm text-slate-600">
                    Periode: {{ $periode === 'jan-jun' ? 'Januari - Juni' : 'Juli - Desember' }}
                </p>
                @endif
                <p class="text-sm text-slate-600">DESA LUMBUNG</p>
            </div>
        </div>

        <div class="p-6">
            <!-- Pendapatan Section -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-emerald-500 text-white px-4 py-2 rounded-lg font-semibold">
                        A. PENDAPATAN
                    </div>
                    <div class="flex-1 h-0.5 bg-emerald-500 ml-4"></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-slate-300">
                        <thead>
                            <tr class="bg-emerald-50">
                                <th
                                    class="border border-slate-300 px-4 py-3 text-left text-sm font-semibold text-slate-700">
                                    Kode
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-left text-sm font-semibold text-slate-700">
                                    Uraian Kegiatan
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-right text-sm font-semibold text-slate-700">
                                    Anggaran (Rp)
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-right text-sm font-semibold text-slate-700">
                                    Realisasi (Rp)
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-center text-sm font-semibold text-slate-700">
                                    Persentase
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendapatan as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="border border-slate-300 px-4 py-2 text-sm">
                                    {{ $item->kegiatanAnggaran->kode ?? '-' }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm">
                                    {{ $item->kegiatanAnggaran->nama_kegiatan ?? 'N/A' }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm text-right font-medium">
                                    {{ number_format($item->anggaran, 0, ',', '.') }}
                                </td>
                                <td
                                    class="border border-slate-300 px-4 py-2 text-sm text-right font-medium text-emerald-600">
                                    {{ number_format($item->total_realisasi ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm text-center">
                                    @php
                                    $persen = $item->anggaran > 0 ? round(($item->total_realisasi / $item->anggaran) *
                                    100, 1) : 0;
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $persen >= 80 ? 'bg-emerald-100 text-emerald-800' : ($persen >= 50 ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $persen }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"
                                    class="border border-slate-300 px-4 py-6 text-center text-sm text-slate-500">
                                    <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                                    Tidak ada data pendapatan untuk periode ini
                                </td>
                            </tr>
                            @endforelse
                            <tr class="bg-emerald-100 font-bold">
                                <td class="border border-slate-300 px-4 py-3 text-sm" colspan="2">
                                    <i class="fas fa-calculator mr-2"></i>JUMLAH PENDAPATAN
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-right text-emerald-800">
                                    {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-right text-emerald-800">
                                    {{ number_format($realisasiPendapatan, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-200 text-emerald-900">
                                        {{ $totalPendapatan > 0 ? number_format($realisasiPendapatan / $totalPendapatan
                                        * 100, 1) : 0 }}%
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Belanja Section -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold">
                        B. BELANJA
                    </div>
                    <div class="flex-1 h-0.5 bg-red-500 ml-4"></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-slate-300">
                        <thead>
                            <tr class="bg-red-50">
                                <th
                                    class="border border-slate-300 px-4 py-3 text-left text-sm font-semibold text-slate-700">
                                    Kode
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-left text-sm font-semibold text-slate-700">
                                    Uraian Kegiatan
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-right text-sm font-semibold text-slate-700">
                                    Anggaran (Rp)
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-right text-sm font-semibold text-slate-700">
                                    Realisasi (Rp)
                                </th>
                                <th
                                    class="border border-slate-300 px-4 py-3 text-center text-sm font-semibold text-slate-700">
                                    Persentase
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($belanja as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="border border-slate-300 px-4 py-2 text-sm">
                                    {{ $item->kegiatanAnggaran->kode ?? '-' }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm">
                                    {{ $item->kegiatanAnggaran->nama_kegiatan ?? 'N/A' }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm text-right font-medium">
                                    {{ number_format($item->anggaran, 0, ',', '.') }}
                                </td>
                                <td
                                    class="border border-slate-300 px-4 py-2 text-sm text-right font-medium text-red-600">
                                    {{ number_format($item->total_realisasi ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-2 text-sm text-center">
                                    @php
                                    $persen = $item->anggaran > 0 ? round(($item->total_realisasi / $item->anggaran) *
                                    100, 1) : 0;
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $persen >= 80 ? 'bg-red-100 text-red-800' : ($persen >= 50 ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $persen }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"
                                    class="border border-slate-300 px-4 py-6 text-center text-sm text-slate-500">
                                    <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                                    Tidak ada data belanja untuk periode ini
                                </td>
                            </tr>
                            @endforelse
                            <tr class="bg-red-100 font-bold">
                                <td class="border border-slate-300 px-4 py-3 text-sm" colspan="2">
                                    <i class="fas fa-calculator mr-2"></i>JUMLAH BELANJA
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-right text-red-800">
                                    {{ number_format($totalBelanja, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-right text-red-800">
                                    {{ number_format($realisasiBelanja, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-300 px-4 py-3 text-sm text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-200 text-red-900">
                                        {{ $totalBelanja > 0 ? number_format($realisasiBelanja / $totalBelanja * 100, 1)
                                        : 0 }}%
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Section -->
            <div
                class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl p-6 border-2 border-slate-300 shadow-sm">
                <div class="flex items-center justify-center mb-6">
                    <div class="bg-slate-700 text-white px-6 py-2 rounded-lg font-bold text-lg">
                        <i class="fas fa-chart-pie mr-2"></i>RINGKASAN APBDes
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="text-center p-5 bg-white rounded-xl border-2 border-emerald-200 shadow-sm">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-3">
                            <i class="fas fa-arrow-down text-xl text-emerald-600"></i>
                        </div>
                        <p class="text-xs text-slate-600 mb-2 uppercase tracking-wide">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-emerald-600 mb-1">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </p>
                        <div class="mt-2 pt-2 border-t border-emerald-200">
                            <p class="text-xs text-slate-500">
                                Realisasi: <span class="font-semibold text-emerald-600">{{ $totalPendapatan > 0 ?
                                    number_format($realisasiPendapatan / $totalPendapatan * 100, 1) : 0 }}%</span>
                            </p>
                        </div>
                    </div>

                    <div class="text-center p-5 bg-white rounded-xl border-2 border-red-200 shadow-sm">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-3">
                            <i class="fas fa-arrow-up text-xl text-red-600"></i>
                        </div>
                        <p class="text-xs text-slate-600 mb-2 uppercase tracking-wide">Total Belanja</p>
                        <p class="text-2xl font-bold text-red-600 mb-1">
                            Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                        </p>
                        <div class="mt-2 pt-2 border-t border-red-200">
                            <p class="text-xs text-slate-500">
                                Realisasi: <span class="font-semibold text-red-600">{{ $totalBelanja > 0 ?
                                    number_format($realisasiBelanja / $totalBelanja * 100, 1) : 0 }}%</span>
                            </p>
                        </div>
                    </div>

                    <div
                        class="text-center p-5 bg-white rounded-xl border-2 {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'border-blue-200' : 'border-amber-200' }} shadow-sm">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'bg-blue-100' : 'bg-amber-100' }} rounded-full mb-3">
                            <i
                                class="fas fa-balance-scale text-xl {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'text-blue-600' : 'text-amber-600' }}"></i>
                        </div>
                        <p class="text-xs text-slate-600 mb-2 uppercase tracking-wide">Surplus/Defisit</p>
                        <p
                            class="text-2xl font-bold {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'text-blue-600' : 'text-amber-600' }} mb-1">
                            Rp {{ number_format(abs($totalPendapatan - $totalBelanja), 0, ',', '.') }}
                        </p>
                        <div
                            class="mt-2 pt-2 border-t {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'border-blue-200' : 'border-amber-200' }}">
                            <p
                                class="text-xs font-semibold {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'text-blue-600' : 'text-amber-600' }}">
                                {{ ($totalPendapatan - $totalBelanja) >= 0 ? 'SURPLUS' : 'DEFISIT' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Detail Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <h4 class="font-semibold text-slate-700 mb-3 flex items-center">
                            <i class="fas fa-coins text-emerald-600 mr-2"></i>
                            Detail Pendapatan
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Total Anggaran:</span>
                                <span class="font-semibold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Sudah Terealisasi:</span>
                                <span class="font-semibold text-emerald-600">Rp {{ number_format($realisasiPendapatan,
                                    0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-slate-200">
                                <span class="text-slate-600">Sisa Anggaran:</span>
                                <span class="font-bold text-slate-800">Rp {{ number_format($totalPendapatan -
                                    $realisasiPendapatan, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                        <h4 class="font-semibold text-slate-700 mb-3 flex items-center">
                            <i class="fas fa-file-invoice-dollar text-red-600 mr-2"></i>
                            Detail Belanja
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Total Anggaran:</span>
                                <span class="font-semibold">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Sudah Terealisasi:</span>
                                <span class="font-semibold text-red-600">Rp {{ number_format($realisasiBelanja, 0, ',',
                                    '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-slate-200">
                                <span class="text-slate-600">Sisa Anggaran:</span>
                                <span class="font-bold text-slate-800">Rp {{ number_format($totalBelanja -
                                    $realisasiBelanja, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer untuk Print -->
            <div class="mt-12 print-only hidden">
                <div class="grid grid-cols-2 gap-12">
                    <div class="text-center">
                        <p class="mb-16">Mengetahui,</p>
                        <p class="font-semibold text-sm">Kepala Desa Lumbung</p>
                        <div class="mt-20 pt-2 border-t-2 border-slate-800 inline-block px-16">
                            <p class="text-xs">(________________________)</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="mb-16">Purwokerto, {{ date('d F Y') }}</p>
                        <p class="font-semibold text-sm">Bendahara Desa</p>
                        <div class="mt-20 pt-2 border-t-2 border-slate-800 inline-block px-16">
                            <p class="text-xs">(________________________)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function exportPDF() {
    alert('Fungsi export PDF akan segera tersedia. Untuk saat ini silakan gunakan Print to PDF dari browser.');
    window.print();
}
</script>

<style>
    @media print {
        .no-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        body {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        table {
            page-break-inside: avoid;
        }

        .shadow-sm,
        .shadow {
            box-shadow: none !important;
        }
    }
</style>
@endsection