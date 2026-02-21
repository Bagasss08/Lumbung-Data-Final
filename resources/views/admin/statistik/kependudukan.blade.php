@extends('layouts.admin')

@section('title', 'Statistik Kependudukan')

@section('content')

<!-- ================= RINGKASAN UTAMA ================= -->
<div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8">

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow">
        <p class="text-xs text-slate-500">Total Penduduk</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['total_penduduk']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow">
        <p class="text-xs text-slate-500">Kepala Keluarga</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['kepala_keluarga']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow">
        <p class="text-xs text-slate-500">RT / RW</p>
        <h3 class="text-2xl font-bold mt-1">{{ $data['rt'] }} / {{ $data['rw'] }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow text-blue-600">
        <p class="text-xs font-medium">Laki-laki</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['laki_laki']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow text-pink-600">
        <p class="text-xs font-medium">Perempuan</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['perempuan']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition-shadow text-green-600">
        <p class="text-xs font-medium">Rasio Gender</p>
        <h3 class="text-2xl font-bold mt-1">
            {{ $data['perempuan'] > 0 ? round(($data['laki_laki'] / $data['perempuan']) * 100, 1) : 0 }}%
        </h3>
    </div>

</div>

<!-- ================= DISTRIBUSI USIA & GENDER ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <!-- DISTRIBUSI USIA -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Distribusi Usia</h4>
        <div class="relative h-80">
            <canvas id="usiaChart"></canvas>
        </div>
    </div>

    <!-- GENDER DISTRIBUTION -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Distribusi Jenis Kelamin</h4>
        <div class="relative h-80">
            <canvas id="genderChart"></canvas>
        </div>
    </div>

</div>

<!-- ================= PENDIDIKAN & PEKERJAAN ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- PENDIDIKAN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Tingkat Pendidikan</h4>
        <div class="relative h-80">
            <canvas id="pendidikanChart"></canvas>
        </div>
    </div>

    <!-- PEKERJAAN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Mata Pencaharian</h4>
        <div class="relative h-80">
            <canvas id="pekerjaanChart"></canvas>
        </div>
    </div>

</div>

<!-- ================= AGAMA ================= -->
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h4 class="font-semibold mb-4 text-lg">Distribusi Agama</h4>
    <div class="relative h-80">
        <canvas id="agamaChart"></canvas>
    </div>
</div>

<!-- ================= GOLONGAN DARAH & WILAYAH ================= -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- GOLONGAN DARAH -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Distribusi Golongan Darah</h4>
        <div class="relative h-80">
            <canvas id="golonganDarahChart"></canvas>
        </div>
    </div>

    <!-- WILAYAH/DUSUN -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-semibold mb-4 text-lg">Sebaran Penduduk per Kelompok/Dusun</h4>
        <div class="relative h-80">
            <canvas id="wilayahChart"></canvas>
        </div>
    </div>

</div>

<!-- ================= TABEL DETIL ================= -->
@if(count($data['pendidikan']) > 0)
<div class="bg-white rounded-xl shadow p-6 mb-8">
    <h4 class="font-semibold mb-4">Detail Pendidikan</h4>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b">
                <tr>
                    <th class="text-left px-4 py-2">Tingkat Pendidikan</th>
                    <th class="text-right px-4 py-2">Jumlah</th>
                    <th class="text-right px-4 py-2">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['pendidikan'] as $item)
                <tr class="border-b hover:bg-slate-50">
                    <td class="px-4 py-2">{{ $item['label'] }}</td>
                    <td class="text-right px-4 py-2 font-semibold">{{ number_format($item['jumlah']) }}</td>
                    <td class="text-right px-4 py-2">{{ round(($item['jumlah'] / $data['total_penduduk']) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
    // Color palettes
    const colorPalette = [
        '#3B82F6', '#EC4899', '#8B5CF6', '#F59E0B', '#10B981',
        '#F97316', '#EF4444', '#06B6D4', '#6366F1', '#84CC16'
    ];

    // ===== DISTRIBUSI USIA CHART =====
    const usiaCtx = document.getElementById('usiaChart');
    if (usiaCtx) {
        new Chart(usiaCtx, {
            type: 'doughnut',
            data: {
                labels: ['Balita (0-4)', 'Remaja (5-18)', 'Dewasa (19-59)', 'Lansia (60+)'],
                datasets: [{
                    data: [{{ $data['usia']['balita'] }}, {{ $data['usia']['remaja'] }}, {{ $data['usia']['dewasa'] }}, {{ $data['usia']['lansia'] }}],
                    backgroundColor: ['#FCA5A5', '#FED7AA', '#86EFAC', '#93C5FD'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true,
                        }
                    }
                }
            }
        });
    }

    // ===== GENDER CHART =====
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $data['laki_laki'] }}, {{ $data['perempuan'] }}],
                    backgroundColor: ['#3B82F6', '#EC4899'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true,
                        }
                    }
                }
            }
        });
    }

    // ===== PENDIDIKAN CHART =====
    const pendidikanCtx = document.getElementById('pendidikanChart');
    if (pendidikanCtx) {
        const pendidikanLabels = @json(array_column($data['pendidikan'], 'label'));
        const pendidikanData = @json(array_column($data['pendidikan'], 'jumlah'));
        
        new Chart(pendidikanCtx, {
            type: 'bar',
            data: {
                labels: pendidikanLabels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: pendidikanData,
                    backgroundColor: '#3B82F6',
                    borderColor: '#1E40AF',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 }
                        }
                    },
                    y: {
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }

    // ===== PEKERJAAN CHART =====
    const pekerjaanCtx = document.getElementById('pekerjaanChart');
    if (pekerjaanCtx) {
        const pekerjaanLabels = @json(array_column($data['pekerjaan'], 'label'));
        const pekerjaanData = @json(array_column($data['pekerjaan'], 'jumlah'));
        
        new Chart(pekerjaanCtx, {
            type: 'bar',
            data: {
                labels: pekerjaanLabels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: pekerjaanData,
                    backgroundColor: '#8B5CF6',
                    borderColor: '#6D28D9',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 }
                        }
                    },
                    y: {
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }

    // ===== AGAMA CHART =====
    const agamaCtx = document.getElementById('agamaChart');
    if (agamaCtx) {
        const agamaLabels = @json(array_column($data['agama'], 'label'));
        const agamaData = @json(array_column($data['agama'], 'jumlah'));
        
        new Chart(agamaCtx, {
            type: 'pie',
            data: {
                labels: agamaLabels,
                datasets: [{
                    data: agamaData,
                    backgroundColor: colorPalette.slice(0, agamaLabels.length),
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true,
                        }
                    }
                }
            }
        });
    }

    // ===== GOLONGAN DARAH CHART =====
    const golonganDarahCtx = document.getElementById('golonganDarahChart');
    if (golonganDarahCtx) {
        const golonganDarahLabels = @json(array_column($data['golongan_darah'], 'label'));
        const golonganDarahData = @json(array_column($data['golongan_darah'], 'jumlah'));
        
        new Chart(golonganDarahCtx, {
            type: 'doughnut',
            data: {
                labels: golonganDarahLabels,
                datasets: [{
                    data: golonganDarahData,
                    backgroundColor: ['#FCA5A5', '#FED7AA', '#FBBF24', '#A78BFA'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 12 },
                            padding: 15,
                            usePointStyle: true,
                        }
                    }
                }
            }
        });
    }

    // ===== WILAYAH/DUSUN CHART =====
    const wilayahCtx = document.getElementById('wilayahChart');
    if (wilayahCtx) {
        const wilayahLabels = @json(array_column($data['wilayah'], 'label'));
        const wilayahData = @json(array_column($data['wilayah'], 'jumlah'));
        
        new Chart(wilayahCtx, {
            type: 'bar',
            data: {
                labels: wilayahLabels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: wilayahData,
                    backgroundColor: '#10B981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 }
                        }
                    },
                    y: {
                        ticks: {
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    }
</script>

@endsection
