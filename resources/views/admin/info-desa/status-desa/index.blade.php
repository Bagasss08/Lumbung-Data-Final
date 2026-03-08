@extends('layouts.admin')
@section('title', 'Status Desa')

@section('content')

{{-- x-data wrapper agar $dispatch Alpine bekerja untuk modal hapus --}}
<div x-data>

{{-- ============================================================ --}}
{{-- + Breadcrumb + HEADER: Title kiri Tombol kanan               --}}
{{-- ============================================================ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Status Desa</h2>
        <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Riwayat dan perkembangan Indeks Desa Membangun (IDM) dari tahun ke tahun</p>
    </div>
    <div class="flex items-center gap-3">
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="/admin/dashboard" class="flex items-center gap-1 text-gray-400 dark:text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Status Desa</span>
        </nav>
        <div class="flex items-center gap-2">
            @include('admin.partials.export-buttons', [
                'routeExcel' => 'admin.status-desa.export.excel',
                'routePdf' => 'admin.status-desa.export.pdf',
            ])
            <a href="{{ route('admin.status-desa.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Data IDM
            </a>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- STATS CARDS                                                  --}}
{{-- ============================================================ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Total Entri</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
        </div>
    </div>

    @if($stats['terbaru'])
    @php
    $t = $stats['terbaru'];
    $colors = ['Mandiri'=>'emerald','Maju'=>'blue','Berkembang'=>'yellow','Tertinggal'=>'orange','Sangat Tertinggal'=>'red'];
    $c = $colors[$t->status] ?? 'gray';
    @endphp
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Tahun Terbaru</p>
                <p class="text-2xl font-bold text-gray-800 dark:text-slate-100 mt-1">{{ $t->tahun }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Nilai IDM</p>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($t->nilai, 4) }}</p>
            </div>
            <div class="w-11 h-11 bg-teal-50 dark:bg-teal-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-5 hover:shadow-md dark:hover:shadow-slate-900/40 transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-400">Status</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold mt-1 {{ $t->badge_class }}">
                    {{ $t->status ?? '-' }}
                </span>
            </div>
            <div class="w-11 h-11 bg-{{ $c }}-50 dark:bg-{{ $c }}-900/30 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-{{ $c }}-600 dark:text-{{ $c }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- ============================================================ --}}
{{-- Grafik Tren (jika ada ≥2 data)                              --}}
{{-- ============================================================ --}}
@if(count($stats['tren']) >= 2)
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-semibold text-gray-800 dark:text-slate-100">Tren Nilai IDM</h3>
            <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Perkembangan IKS, IKE, dan IKL per tahun</p>
        </div>
        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-slate-400">
            <span class="flex items-center gap-1.5"><span class="w-3 h-1 rounded bg-emerald-500 inline-block"></span>Total IDM</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-1 rounded bg-blue-400 inline-block"></span>IKS</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-1 rounded bg-amber-400 inline-block"></span>IKE</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-1 rounded bg-teal-400 inline-block"></span>IKL</span>
        </div>
    </div>
    <div class="h-56">
        <canvas id="chartTrenIDM"></canvas>
    </div>
</div>
@endif

{{-- ============================================================ --}}
{{-- TABLE                                                        --}}
{{-- ============================================================ --}}
<div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800 dark:text-slate-100">Riwayat Status Desa</h3>
        <span class="text-xs text-gray-400 dark:text-slate-500">{{ $statusDesa->total() }} entri</span>
    </div>

    @if($statusDesa->isEmpty())
    {{-- ============================================================ --}}
    {{-- Empty State Informatif                                   --}}
    {{-- ============================================================ --}}
    <div class="py-16 px-8 text-center">
        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 flex items-center justify-center mx-auto mb-5 border-2 border-dashed border-emerald-200 dark:border-emerald-800">
            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h4 class="font-semibold text-gray-800 dark:text-slate-200 text-base mb-2">Belum ada data IDM</h4>
        <p class="text-gray-500 dark:text-slate-400 text-sm max-w-sm mx-auto mb-6 leading-relaxed">
            Tambahkan data Indeks Desa Membangun (IDM) untuk memantau perkembangan desa dari tahun ke tahun.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center text-sm">
            <a href="{{ route('admin.status-desa.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Data IDM Pertama
            </a>
            <a href="https://idm.kemendesa.go.id" target="_blank" class="inline-flex items-center gap-2 border border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 px-6 py-2.5 rounded-xl font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Portal IDM Kemendes
            </a>
        </div>

        {{-- Panduan --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto text-left">
            @foreach([
                ['no'=>'1','judul'=>'Kunjungi Portal IDM','desc'=>'Dapatkan nilai IDM di portal resmi Kemendes PDTT'],
                ['no'=>'2','judul'=>'Input Data','desc'=>'Masukkan nilai IKS, IKE, IKL dan total IDM per tahun'],
                ['no'=>'3','judul'=>'Pantau Tren','desc'=>'Grafik tren otomatis tampil setelah ≥2 tahun data'],
            ] as $step)
            <div class="flex items-start gap-3 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <span class="w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 mt-0.5">{{ $step['no'] }}</span>
                <div>
                    <p class="font-medium text-gray-800 dark:text-slate-200 text-xs">{{ $step['judul'] }}</p>
                    <p class="text-gray-500 dark:text-slate-400 text-xs mt-0.5">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Tahun</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nama Status</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Nilai IDM</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">IKS</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">IKE</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">IKL</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @foreach($statusDesa as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/40 transition-colors">
                    <td class="px-5 py-4">
                        <span class="font-bold text-gray-900 dark:text-slate-100 text-base">{{ $item->tahun }}</span>
                    </td>
                    <td class="px-5 py-4 text-gray-700 dark:text-slate-300">{{ $item->nama_status }}</td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($item->nilai, 4) }}</span>
                            {{-- Mini progress bar --}}
                            <div class="w-16 h-1.5 bg-gray-100 dark:bg-slate-600 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full" style="width: {{ $item->progress_persen }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-center text-gray-600 dark:text-slate-400 font-mono text-xs">{{ number_format($item->skor_ketahanan_sosial, 4) }}</td>
                    <td class="px-5 py-4 text-center text-gray-600 dark:text-slate-400 font-mono text-xs">{{ number_format($item->skor_ketahanan_ekonomi, 4) }}</td>
                    <td class="px-5 py-4 text-center text-gray-600 dark:text-slate-400 font-mono text-xs">{{ number_format($item->skor_ketahanan_ekologi, 4) }}</td>
                    <td class="px-5 py-4">
                        @if($item->status)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $item->badge_class }}">
                            {{ $item->status }}
                        </span>
                        @else
                        <span class="text-gray-400 dark:text-slate-500 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.status-desa.show', $item) }}" title="Detail" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/50 border border-blue-100 dark:border-blue-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.status-desa.edit', $item) }}" title="Edit" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 border border-amber-100 dark:border-amber-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Tombol hapus dengan modal --}}
                            <button type="button" title="Hapus" @click="$dispatch('buka-modal-hapus', {
                                action: '{{ route('admin.status-desa.destroy', $item) }}',
                                nama: '{{ addslashes($item->nama_status) }} tahun {{ $item->tahun }}'
                            })" class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 border border-red-100 dark:border-red-800 transition-all duration-150 hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($statusDesa->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700">
        {{ $statusDesa->links('vendor.pagination.tailwind') }}
    </div>
    @endif
    @endif
</div>

{{-- Modal Hapus --}}
@include('admin.partials.modal-hapus')

</div>{{-- end x-data --}}
@endsection

@section('scripts')
@if(count($stats['tren']) >= 2)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function() {
    const tren  = @json($stats['tren']);
    const label = tren.map(d => d.tahun);

    const ctx = document.getElementById('chartTrenIDM').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: label,
            datasets: [
                {
                    label: 'Total IDM',
                    data: tren.map(d => d.nilai),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    borderWidth: 2.5,
                    pointRadius: 5,
                    pointBackgroundColor: '#10b981',
                    tension: 0.35,
                    fill: true,
                },
                {
                    label: 'IKS',
                    data: tren.map(d => d.iks),
                    borderColor: '#60a5fa',
                    borderWidth: 1.5,
                    pointRadius: 4,
                    borderDash: [4, 3],
                    tension: 0.35,
                    fill: false,
                },
                {
                    label: 'IKE',
                    data: tren.map(d => d.ike),
                    borderColor: '#fbbf24',
                    borderWidth: 1.5,
                    pointRadius: 4,
                    borderDash: [4, 3],
                    tension: 0.35,
                    fill: false,
                },
                {
                    label: 'IKL',
                    data: tren.map(d => d.ikl),
                    borderColor: '#2dd4bf',
                    borderWidth: 1.5,
                    pointRadius: 4,
                    borderDash: [4, 3],
                    tension: 0.35,
                    fill: false,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#f9fafb',
                    bodyColor: '#e5e7eb',
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(4)}`
                    }
                },
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                },
                y: {
                    min: 0,
                    max: 1,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 11 },
                        callback: v => v.toFixed(2)
                    }
                }
            }
        }
    });
})();
</script>
@endif
@endsection