@extends('layouts.admin')
@section('title', 'Detail Status Desa ' . $statusDesa->tahun)

@section('content')

@include('admin.partials.modal-hapus')

{{-- Breadcrumb --}}
<nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
    <a href="{{ route('admin.status-desa.index') }}" class="hover:text-emerald-600 transition-colors">Status Desa</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="font-medium text-gray-900">Tahun {{ $statusDesa->tahun }}</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Info Utama --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Card Utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div
                class="px-6 py-5 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-100 flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h2 class="text-xl font-bold text-gray-900">{{ $statusDesa->nama_status }}</h2>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-semibold border {{ $statusDesa->badge_class }}">
                            {{ $statusDesa->status ?? '-' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Tahun <strong>{{ $statusDesa->tahun }}</strong> · Diinput {{
                        $statusDesa->created_at->translatedFormat('d F Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.status-desa.edit', $statusDesa) }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <button type="button" @click="$dispatch('buka-modal-hapus', {
                            action: '{{ route('admin.status-desa.destroy', $statusDesa) }}',
                            nama: 'Status Desa tahun {{ $statusDesa->tahun }}'
                        })"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 hover:border-red-300 hover:bg-red-50 text-gray-600 hover:text-red-600 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </div>
            </div>

            {{-- Nilai Utama --}}
            <div class="px-6 py-5">
                <div class="flex items-end gap-3 mb-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Total Nilai IDM</p>
                        <p class="text-5xl font-black text-emerald-600 tabular-nums">{{
                            number_format($statusDesa->nilai, 4) }}</p>
                    </div>
                    @if($statusDesa->nilai_target)
                    <div class="mb-1.5">
                        <p class="text-xs text-gray-400">Target: {{ number_format($statusDesa->nilai_target, 4) }}</p>
                        @php $selisih = $statusDesa->selisih_target; @endphp
                        <p class="text-sm font-semibold {{ $selisih >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih, 4) }}
                            <span class="text-xs font-normal text-gray-400">dari target</span>
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Progress bar menuju Mandiri (1.0) --}}
                <div class="mb-1 flex justify-between text-xs text-gray-400">
                    <span>0.0000</span>
                    <span class="font-medium text-gray-600">{{ $statusDesa->progress_persen }}% menuju Mandiri</span>
                    <span>1.0000</span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 transition-all"
                        style="width: {{ $statusDesa->progress_persen }}%"></div>
                </div>
                @if($statusDesa->status_target)
                <p class="text-xs text-gray-400 mt-2">Target Status: <strong class="text-gray-600">{{
                        $statusDesa->status_target }}</strong></p>
                @endif
            </div>
        </div>

        {{-- 3 Dimensi IDM --}}
        <div class="grid grid-cols-3 gap-4">
            @foreach([
            ['label'=>'IKS','sub'=>'Ketahanan Sosial','val'=>$statusDesa->skor_ketahanan_sosial,'color'=>'blue'],
            ['label'=>'IKE','sub'=>'Ketahanan Ekonomi','val'=>$statusDesa->skor_ketahanan_ekonomi,'color'=>'amber'],
            ['label'=>'IKL','sub'=>'Ketahanan Ekologi','val'=>$statusDesa->skor_ketahanan_ekologi,'color'=>'teal'],
            ] as $dim)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-xs font-bold text-{{ $dim['color'] }}-600">{{ $dim['label'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $dim['sub'] }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-{{ $dim['color'] }}-50 flex items-center justify-center">
                        <span class="text-xs font-black text-{{ $dim['color'] }}-600">{{ $dim['label'] }}</span>
                    </div>
                </div>
                <p class="text-2xl font-black tabular-nums text-gray-900">{{ number_format($dim['val'], 4) }}</p>
                <div class="mt-2 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $dim['color'] }}-400 rounded-full"
                        style="width: {{ min(100, $dim['val'] * 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Keterangan --}}
        @if($statusDesa->keterangan)
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Keterangan</h4>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $statusDesa->keterangan }}</p>
        </div>
        @endif

        {{-- Grafik Tren (jika ada data) --}}
        @if(count($tren) >= 2)
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Tren IDM Semua Tahun</h4>
            <div class="h-44">
                <canvas id="chartDetail"></canvas>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Meta + Dokumen --}}
    <div class="space-y-5">

        {{-- Rentang Status IDM --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Klasifikasi Status IDM</h4>
            <div class="space-y-2">
                @foreach([
                ['Mandiri','bg-emerald-500','0.8156 – 1.0000'],
                ['Maju','bg-blue-500','0.7073 – 0.8155'],
                ['Berkembang','bg-yellow-400','0.5990 – 0.7072'],
                ['Tertinggal','bg-orange-400','0.4908 – 0.5989'],
                ['Sangat Tertinggal','bg-red-500','< 0.4908'], ] as [$nama, $bg, $range]) <div
                    class="flex items-center gap-3 {{ $statusDesa->status === $nama ? 'bg-gray-50 rounded-xl px-2 py-1.5 -mx-2' : '' }}">
                    <div class="w-2.5 h-2.5 rounded-full {{ $bg }} flex-shrink-0"></div>
                    <span class="text-sm text-gray-700 flex-1 {{ $statusDesa->status === $nama ? 'font-bold' : '' }}">{{
                        $nama }}</span>
                    <span class="text-xs text-gray-400 font-mono">{{ $range }}</span>
                    @if($statusDesa->status === $nama)
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                    </svg>
                    @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Dokumen --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Dokumen</h4>
        @if($statusDesa->dokumen)
        <a href="{{ Storage::url($statusDesa->dokumen) }}" target="_blank"
            class="flex items-center gap-3 p-3 bg-emerald-50 border border-emerald-100 rounded-xl hover:bg-emerald-100 transition-colors group">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-emerald-700 truncate">Dokumen IDM {{ $statusDesa->tahun }}</p>
                <p class="text-xs text-emerald-500">Klik untuk unduh</p>
            </div>
            <svg class="w-4 h-4 text-emerald-400 group-hover:text-emerald-600 transition-colors" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>
        @else
        <div class="flex flex-col items-center py-6 text-center">
            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-sm text-gray-400">Belum ada dokumen</p>
            <a href="{{ route('admin.status-desa.edit', $statusDesa) }}"
                class="text-xs text-emerald-600 hover:underline mt-1">Upload sekarang →</a>
        </div>
        @endif
    </div>

    {{-- Timestamp --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-sm space-y-3">
        <div class="flex justify-between">
            <span class="text-gray-500">Ditambahkan</span>
            <span class="text-gray-700 font-medium">{{ $statusDesa->created_at->translatedFormat('d M Y') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Terakhir diubah</span>
            <span class="text-gray-700 font-medium">{{ $statusDesa->updated_at->translatedFormat('d M Y') }}</span>
        </div>
    </div>

</div>
</div>

@endsection

@section('scripts')
@if(count($tren) >= 2)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function() {
    const tren = @json($tren);
    new Chart(document.getElementById('chartDetail').getContext('2d'), {
        type: 'line',
        data: {
            labels: tren.map(d => d.tahun),
            datasets: [{
                label: 'Nilai IDM',
                data: tren.map(d => d.nilai),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.08)',
                borderWidth: 2.5,
                pointRadius: 5,
                pointBackgroundColor: d => {
                    // Highlight titik tahun ini
                    return '#10b981';
                },
                tension: 0.35,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ` IDM: ${ctx.parsed.y.toFixed(4)}` }
                }
            },
            scales: {
                x: { ticks: { color: '#9ca3af', font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                y: { min: 0, max: 1, ticks: { color: '#9ca3af', font: { size: 11 }, callback: v => v.toFixed(2) }, grid: { color: 'rgba(0,0,0,0.04)' } }
            }
        }
    });

    // Highlight titik tahun aktif
    const tahunAktif = {{ $statusDesa->tahun }};
    Chart.getChart('chartDetail').data.datasets[0].pointBackgroundColor =
        tren.map(d => d.tahun === tahunAktif ? '#059669' : '#10b981');
    Chart.getChart('chartDetail').data.datasets[0].pointRadius =
        tren.map(d => d.tahun === tahunAktif ? 8 : 4);
    Chart.getChart('chartDetail').update();
})();
</script>
@endif
@endsection