    @extends('layouts.admin')

@section('title', 'Laporan Bulanan')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Laporan Bulanan Mutasi Penduduk</h1>
        <p class="text-sm text-slate-500">
            Data mutasi penduduk untuk bulan {{ $data['bulan'] }} (real-time)
        </p>
    </div>

    <div class="flex gap-3">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </button>
    </div>
</div>

<!-- ================= MONTH SELECTOR ================= -->
<div class="mb-6 flex gap-3 items-center">
    @php
        $currentDate = \Carbon\Carbon::now();
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
    @endphp
    
    <a href="?month={{ $prevMonth->month }}&year={{ $prevMonth->year }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Bulan Sebelumnya
    </a>
    
    <div class="flex-1 text-center">
        <span class="text-lg font-semibold text-slate-800">{{ $data['bulan'] }}</span>
    </div>
    
    <a href="?month={{ $nextMonth->month }}&year={{ $nextMonth->year }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition flex items-center gap-2">
        Bulan Berikutnya
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

<!-- ================= SUMMARY CARDS ================= -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Penduduk Hidup</p>
                <h3 class="text-3xl font-bold mt-2 text-slate-800">{{ number_format($data['total_penduduk']) }}</h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-green-600 font-medium">Kelahiran</p>
                <h3 class="text-3xl font-bold mt-2 text-green-600">{{ $data['mutasi']['lahir'] }}</h3>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-red-600 font-medium">Kematian</p>
                <h3 class="text-3xl font-bold mt-2 text-red-600">{{ $data['mutasi']['meninggal'] }}</h3>
            </div>
            <div class="p-3 bg-red-100 rounded-lg">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-600 font-medium">Net Migration</p>
                <h3 class="text-3xl font-bold mt-2 text-blue-600">
                    {{ $data['mutasi']['datang'] - $data['mutasi']['pindah'] }}
                </h3>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </div>
        </div>
    </div>

</div>

<!-- ================= MUTASI DETAIL ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- MUTASI PENDUDUK CARDS -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 flex items-center gap-2 text-slate-800">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Rincian Mutasi Penduduk
        </h4>

        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200 hover:border-green-300 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800">Kelahiran</p>
                        <p class="text-xs text-green-600">Penambahan penduduk</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">{{ $data['mutasi']['lahir'] }}</p>
                    <p class="text-xs text-green-500">orang</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200 hover:border-red-300 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-red-800">Kematian</p>
                        <p class="text-xs text-red-600">Pengurangan penduduk</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-red-600">{{ $data['mutasi']['meninggal'] }}</p>
                    <p class="text-xs text-red-500">orang</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200 hover:border-blue-300 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-blue-800">Pendatang</p>
                        <p class="text-xs text-blue-600">Masuk dari luar desa</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-blue-600">{{ $data['mutasi']['datang'] }}</p>
                    <p class="text-xs text-blue-500">orang</p>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg border border-orange-200 hover:border-orange-300 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-orange-800">Pindah</p>
                        <p class="text-xs text-orange-600">Keluar ke luar desa</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-orange-600">{{ $data['mutasi']['pindah'] }}</p>
                    <p class="text-xs text-orange-500">orang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- LAPORAN DETAIL TABLE -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 flex items-center gap-2 text-slate-800">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Detail Persentase Mutasi
        </h4>

        <div class="overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-4 font-semibold text-slate-700">Kategori</th>
                        <th class="text-center py-3 px-4 font-semibold text-slate-700">Jumlah</th>
                        <th class="text-right py-3 px-4 font-semibold text-slate-700">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['laporan'] as $item)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg {{ $item['persen'][0] === '+' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                                    <span class="text-xs font-bold {{ $item['persen'][0] === '+' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $item['persen'][0] }}
                                    </span>
                                </div>
                                <span class="font-medium text-slate-800">{{ $item['kategori'] }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center font-semibold">{{ $item['jumlah'] }}</td>
                        <td class="py-3 px-4 text-right {{ $item['persen'][0] === '+' ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $item['persen'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= ANALISIS & KPI ================= -->
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h4 class="font-semibold mb-6 text-slate-800 text-lg">Analisis & KPI Mutasi Bulanan</h4>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- PERTUMBUHAN PENDUDUK -->
        <div class="p-5 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg border border-emerald-200">
            <h5 class="font-semibold text-emerald-800 mb-2 text-sm">Pertumbuhan Penduduk</h5>
            <div class="text-3xl font-bold text-emerald-600 mb-2">
                {{ $data['mutasi']['lahir'] - $data['mutasi']['meninggal'] + $data['mutasi']['datang'] - $data['mutasi']['pindah'] }}
            </div>
            <p class="text-xs text-emerald-600">net growth bulan ini</p>
        </div>

        <!-- RASIO NATALITY/MORTALITY -->
        <div class="p-5 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg border border-cyan-200">
            <h5 class="font-semibold text-cyan-800 mb-2 text-sm">Rasio Kelahiran/Kematian</h5>
            <div class="text-3xl font-bold text-cyan-600 mb-2">
                @if($data['mutasi']['meninggal'] > 0)
                    {{ round($data['mutasi']['lahir'] / $data['mutasi']['meninggal'], 2) }}
                @else
                    <span class="text-2xl">∞</span>
                @endif
            </div>
            <p class="text-xs text-cyan-600">kelahiran per kematian</p>
        </div>

        <!-- MOBILITY RATE -->
        <div class="p-5 bg-gradient-to-br from-violet-50 to-violet-100 rounded-lg border border-violet-200">
            <h5 class="font-semibold text-violet-800 mb-2 text-sm">Mobility Rate</h5>
            <div class="text-3xl font-bold text-violet-600 mb-2">
                {{ round((($data['mutasi']['datang'] + $data['mutasi']['pindah']) / max(1, $data['total_penduduk'])) * 100, 2) }}%
            </div>
            <p class="text-xs text-violet-600">dari total penduduk</p>
        </div>

        <!-- NATURAL INCREASE -->
        <div class="p-5 bg-gradient-to-br from-rose-50 to-rose-100 rounded-lg border border-rose-200">
            <h5 class="font-semibold text-rose-800 mb-2 text-sm">Natural Increase</h5>
            <div class="text-3xl font-bold text-rose-600 mb-2">
                {{ $data['mutasi']['lahir'] - $data['mutasi']['meninggal'] }}
            </div>
            <p class="text-xs text-rose-600">kelahiran - kematian</p>
        </div>

    </div>

    <!-- REKOMENDASI -->
    <div class="mt-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
        <h5 class="font-semibold text-slate-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Rekomendasi & Catatan
        </h5>
        <ul class="text-sm text-slate-700 space-y-2 ml-2">
            <li class="flex items-start gap-2">
                <span class="text-lg leading-none">•</span>
                <span>
                    @if($data['mutasi']['lahir'] > $data['mutasi']['meninggal'])
                        ✓ Pertumbuhan penduduk positif dengan kelahiran melebihi kematian. Tren demografis sehat.
                    @else
                        ⚠ Perlu perhatian khusus pada kesehatan masyarakat karena angka kematian tinggi relative terhadap kelahiran.
                    @endif
                </span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-lg leading-none">•</span>
                <span>
                    @if($data['mutasi']['datang'] > $data['mutasi']['pindah'])
                        ✓ Migrasi masuk lebih tinggi dari keluar, menunjukkan daya tarik desa yang baik untuk pendatang.
                    @else
                        ⚠ Tingginya migrasi keluar dibanding masuk perlu dianalisis lebih lanjut, mungkin ada faktor ekonomi.
                    @endif
                </span>
            </li>
            <li class="flex items-start gap-2">
                <span class="text-lg leading-none">•</span>
                <span>Total mutasi bulan ini: {{ $data['mutasi']['lahir'] + $data['mutasi']['meninggal'] + $data['mutasi']['datang'] + $data['mutasi']['pindah'] }} orang atau {{ round((($data['mutasi']['lahir'] + $data['mutasi']['meninggal'] + $data['mutasi']['datang'] + $data['mutasi']['pindah']) / max(1, $data['total_penduduk'])) * 100, 2) }}% dari total penduduk.</span>
            </li>
        </ul>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

@endsection
