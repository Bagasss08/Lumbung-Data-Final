@extends('layouts.admin')

@section('title', 'Data Responden – ' . $analisi->nama)

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('admin.analisis.index') }}" class="hover:text-emerald-600 transition-colors">Analisis</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('admin.analisis.show', $analisi) }}" class="hover:text-emerald-600 transition-colors">{{
            $analisi->nama }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-800 font-medium">Data Responden</span>
    </div>

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Data Responden</h3>
            <p class="text-sm text-gray-500">{{ $analisi->nama }} · {{ $analisi->subjek_label }}</p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            @if($periodeAktif)
            {{-- Export CSV --}}
            <a href="{{ route('admin.analisis.responden.export', [$analisi, 'id_periode' => $periodeAktif->id]) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export CSV
            </a>
            {{-- Export Rekap --}}
            <a href="{{ route('admin.analisis.responden.export.rekap', [$analisi, 'id_periode' => $periodeAktif->id]) }}"
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export Rekap
            </a>
            {{-- Tambah Responden --}}
            <a href="{{ route('admin.analisis.responden.create', [$analisi, 'id_periode' => $periodeAktif->id]) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl shadow hover:shadow-md transition-all hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Data
            </a>
            @endif
        </div>
    </div>

    {{-- ── Pilih Periode ── --}}
    @if($periodeList->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="flex flex-wrap gap-2">
            @foreach($periodeList as $per)
            <a href="{{ route('admin.analisis.responden.index', [$analisi, 'id_periode' => $per->id]) }}" class="px-4 py-2 text-sm font-medium rounded-xl transition-all
                      {{ $periodeAktif?->id === $per->id
                           ? 'bg-emerald-500 text-white shadow-sm'
                           : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $per->nama }}
            </a>
            @endforeach
        </div>
    </div>
    @else
    <div
        class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <svg class="w-5 h-5 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Belum ada periode. <a href="{{ route('admin.analisis.show', $analisi) }}"
                class="underline font-medium">Tambah periode di sini</a>.</span>
    </div>
    @endif

    @if($periodeAktif)
    {{-- ── Distribusi Klasifikasi Chart ── --}}
    @php
    $totalResp = $responden instanceof \Illuminate\Pagination\LengthAwarePaginator ? $responden->total() :
    $responden->count();
    $chartLabels = [];
    $chartData = [];
    $chartColors = [];
    foreach($analisi->klasifikasi as $klas) {
        $jml = $responden instanceof \Illuminate\Pagination\LengthAwarePaginator
        ? \App\Models\AnalisisResponden::where('id_master', $analisi->id)->where('id_periode',
        $periodeAktif->id)->where('kategori_hasil', $klas->nama)->count()
        : $responden->where('kategori_hasil', $klas->nama)->count();
        $chartLabels[] = $klas->nama;
        $chartData[] = $jml;
        $chartColors[] = $klas->warna ?? '#10b981';
    }
    @endphp
    @if($analisi->klasifikasi->isNotEmpty() && $totalResp > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <h4 class="font-semibold text-gray-800 mb-4">Distribusi Responden</h4>
            <div class="relative h-64">
                <canvas id="klasifikasiChart"></canvas>
            </div>
        </div>
        {{-- Cards --}}
        <div class="lg:col-span-2 space-y-4">
            {{-- Total Card --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-1">Total Responden</p>
                        <p class="text-4xl font-bold">{{ $totalResp }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Kategori Cards with Progress --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($analisi->klasifikasi as $klas)
                @php 
                $jml = $responden instanceof \Illuminate\Pagination\LengthAwarePaginator
                ? \App\Models\AnalisisResponden::where('id_master', $analisi->id)->where('id_periode',
                $periodeAktif->id)->where('kategori_hasil', $klas->nama)->count()
                : $responden->where('kategori_hasil', $klas->nama)->count();
                $persen = $totalResp > 0 ? ($jml / $totalResp * 100) : 0;
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full" style="background-color: {{ $klas->warna ?? '#10b981' }}"></div>
                            <span class="text-sm font-semibold text-gray-700">{{ $klas->nama }}</span>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full" style="background-color: {{ $klas->warna ?? '#10b981' }}20; color: {{ $klas->warna ?? '#10b981' }}">
                            {{ number_format($persen, 1) }}%
                        </span>
                    </div>
                    <div class="flex items-end gap-2">
                        <span class="text-3xl font-bold text-gray-800">{{ $jml }}</span>
                        <span class="text-xs text-gray-400 mb-1">orang</span>
                    </div>
                    <div class="mt-3 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500" style="width: {{ $persen }}%; background-color: {{ $klas->warna ?? '#10b981' }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const ctx = document.getElementById('klasifikasiChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: {!! json_encode($chartColors) !!},
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 16,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }
    </script>
    @endpush
    @endif

    {{-- ── Filter & Tabel ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Filter Bar --}}
        <div class="px-6 py-4 border-b border-gray-100">
            <form method="GET" class="flex gap-3">
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari responden..."
                        class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                </div>
                @if(!empty($kategoris))
                <select name="kategori"
                    class="px-3 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-400">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori')===$kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                @endif
                <button type="submit"
                    class="px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600">
                    Filter
                </button>
                @if(request()->anyFilled(['search','kategori']))
                <a href="{{ route('admin.analisis.responden.index', [$analisi, 'id_periode' => $periodeAktif->id]) }}"
                    class="px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200">Reset</a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
        @if($responden->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-gray-500 font-medium">Belum ada data responden</p>
            <p class="text-gray-400 text-sm mt-1">Klik "Input Data" untuk mulai menginput</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            No</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Subjek</th>
                        <th
                            class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Total Skor</th>
                        <th
                            class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Kategori</th>
                        <th
                            class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tgl Survei</th>
                        <th
                            class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($responden as $i => $resp)
                    @php
                    $klas = $analisi->klasifikasi->first(fn($k) => $k->nama === $resp->kategori_hasil);
                    @endphp
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-5 py-3.5 text-gray-400 font-medium">{{ $responden->firstItem() + $i }}</td>
                        <td class="px-5 py-3.5">
                            <span class="font-medium text-gray-800">{{ $resp->nama_subjek }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="font-bold text-gray-800">{{ number_format($resp->total_skor, 1) }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($resp->kategori_hasil)
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold text-white"
                                style="background-color: {{ $klas?->warna ?? '#6b7280' }}">
                                {{ $resp->kategori_hasil }}
                            </span>
                            @else
                            <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center text-gray-500 text-xs">
                            {{ $resp->tgl_survei?->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.analisis.responden.show', [$analisi, $resp]) }}"
                                    class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                    title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.analisis.responden.destroy', [$analisi, $resp]) }}"
                                    method="POST" onsubmit="return confirm('Hapus data responden ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($responden->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $responden->appends(request()->query())->links() }}
        </div>
        @endif
        @endif
    </div>
    @endif

</div>
@endsection