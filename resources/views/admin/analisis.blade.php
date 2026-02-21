@extends('layouts.admin')

@section('title', 'Analisis Data Desa')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-700">
                📊 Analisis Data Desa
            </h2>
            <p class="text-sm text-slate-500">
                Analisis mendalam data kependudukan, ekonomi, kesehatan, dan pendidikan
            </p>
        </div>

        <div class="flex gap-2">
            <select id="tahunSelect" class="border rounded-xl px-3 py-2 text-sm">
                <option value="2024">2024</option>
                <option value="2025" selected>2025</option>
                <option value="2026">2026</option>
            </select>

            <button onclick="exportLaporan('pdf')" class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm hover:bg-red-600">
                📄 Export PDF
            </button>

            <button onclick="exportLaporan('excel')" class="px-4 py-2 bg-green-500 text-white rounded-xl text-sm hover:bg-green-600">
                📊 Export Excel
            </button>
        </div>
    </div>

    <!-- TABS -->
    <div class="bg-white rounded-2xl shadow">
        <div class="border-b">
            <nav class="flex">
                <button onclick="showTab('kependudukan')" class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600">
                    👥 Kependudukan
                </button>
                <button onclick="showTab('ekonomi')" class="tab-button px-6 py-4 text-sm font-medium text-slate-500 hover:text-slate-700">
                    💰 Ekonomi
                </button>
                <button onclick="showTab('kesehatan')" class="tab-button px-6 py-4 text-sm font-medium text-slate-500 hover:text-slate-700">
                    🏥 Kesehatan
                </button>
                <button onclick="showTab('pendidikan')" class="tab-button px-6 py-4 text-sm font-medium text-slate-500 hover:text-slate-700">
                    🎓 Pendidikan
                </button>
            </nav>
        </div>

        <!-- KEPENDUDUKAN TAB -->
        <div id="kependudukan-tab" class="tab-content p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-blue-600">2.5%</div>
                    <div class="text-sm text-slate-600">Pertumbuhan Penduduk</div>
                </div>
                <div class="bg-green-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-green-600">68.5%</div>
                    <div class="text-sm text-slate-600">Usia Produktif</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-yellow-600">31.5%</div>
                    <div class="text-sm text-slate-600">Usia Non Produktif</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-purple-600">1,240</div>
                    <div class="text-sm text-slate-600">Total Penduduk</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border rounded-xl p-4">
                    <h3 class="font-semibold mb-4">Distribusi Usia</h3>
                    <canvas id="usiaChart"></canvas>
                </div>
                <div class="bg-white border rounded-xl p-4">
                    <h3 class="font-semibold mb-4">Tren Kelahiran & Kematian</h3>
                    <canvas id="trenChart"></canvas>
                </div>
            </div>
        </div>

        <!-- EKONOMI TAB -->
        <div id="ekonomi-tab" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-green-600">Rp 2.5M</div>
                    <div class="text-sm text-slate-600">Pendapatan Rata-rata</div>
                </div>
                <div class="bg-red-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-red-600">12.5%</div>
                    <div class="text-sm text-slate-600">Tingkat Kemiskinan</div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-blue-600">5.2%</div>
                    <div class="text-sm text-slate-600">Pengangguran</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-yellow-600">45.2%</div>
                    <div class="text-sm text-slate-600">Sektor Pertanian</div>
                </div>
            </div>

            <div class="bg-white border rounded-xl p-4">
                <h3 class="font-semibold mb-4">Distribusi Sektor Ekonomi</h3>
                <canvas id="ekonomiChart"></canvas>
            </div>
        </div>

        <!-- KESEHATAN TAB -->
        <div id="kesehatan-tab" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-red-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-red-600">18.5%</div>
                    <div class="text-sm text-slate-600">Rate Stunting</div>
                </div>
                <div class="bg-green-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-green-600">87.3%</div>
                    <div class="text-sm text-slate-600">Cakupan Vaksinasi</div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-blue-600">245</div>
                    <div class="text-sm text-slate-600">Kasus ISPA</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-yellow-600">12</div>
                    <div class="text-sm text-slate-600">Posyandu</div>
                </div>
            </div>

            <div class="bg-white border rounded-xl p-4">
                <h3 class="font-semibold mb-4">Penyakit Umum</h3>
                <canvas id="penyakitChart"></canvas>
            </div>
        </div>

        <!-- PENDIDIKAN TAB -->
        <div id="pendidikan-tab" class="tab-content p-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-blue-600">92.8%</div>
                    <div class="text-sm text-slate-600">Tingkat Melek Huruf</div>
                </div>
                <div class="bg-green-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-green-600">98.5%</div>
                    <div class="text-sm text-slate-600">Partisipasi SD</div>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-yellow-600">3.2%</div>
                    <div class="text-sm text-slate-600">Angka Putus Sekolah</div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-purple-600">8</div>
                    <div class="text-sm text-slate-600">Sekolah Dasar</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border rounded-xl p-4">
                    <h3 class="font-semibold mb-4">Partisipasi Sekolah</h3>
                    <canvas id="partisipasiChart"></canvas>
                </div>
                <div class="bg-white border rounded-xl p-4">
                    <h3 class="font-semibold mb-4">Fasilitas Pendidikan</h3>
                    <canvas id="fasilitasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-b-2', 'border-blue-500', 'text-blue-600');
        btn.classList.add('text-slate-500');
    });

    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');

    // Add active class to clicked button
    event.target.classList.add('active', 'border-b-2', 'border-blue-500', 'text-blue-600');
    event.target.classList.remove('text-slate-500');
}

function exportLaporan(type) {
    const tahun = document.getElementById('tahunSelect').value;
    if (type === 'pdf') {
        window.open(`/admin/analisis/print/${type}?tahun=${tahun}`, '_blank');
    } else {
        window.location.href = `/admin/analisis/export/${type}?tahun=${tahun}`;
    }
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Usia Chart
    const usiaCtx = document.getElementById('usiaChart').getContext('2d');
    new Chart(usiaCtx, {
        type: 'doughnut',
        data: {
            labels: ['Produktif', 'Tidak Produktif'],
            datasets: [{
                data: [68.5, 31.5],
                backgroundColor: ['#3B82F6', '#F59E0B']
            }]
        }
    });

    // Tren Chart
    const trenCtx = document.getElementById('trenChart').getContext('2d');
    new Chart(trenCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Kelahiran',
                data: [45, 52, 48, 55, 50, 58, 53, 60, 55, 62, 58, 65],
                borderColor: '#10B981',
                backgroundColor: '#10B98120'
            }, {
                label: 'Kematian',
                data: [12, 15, 10, 18, 14, 16, 11, 19, 15, 17, 13, 20],
                borderColor: '#EF4444',
                backgroundColor: '#EF444420'
            }]
        }
    });

    // Ekonomi Chart
    const ekonomiCtx = document.getElementById('ekonomiChart').getContext('2d');
    new Chart(ekonomiCtx, {
        type: 'bar',
        data: {
            labels: ['Pertanian', 'Perdagangan', 'Jasa', 'Industri'],
            datasets: [{
                data: [45.2, 25.8, 18.7, 10.3],
                backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#8B5CF6']
            }]
        }
    });

    // Penyakit Chart
    const penyakitCtx = document.getElementById('penyakitChart').getContext('2d');
    new Chart(penyakitCtx, {
        type: 'bar',
        data: {
            labels: ['ISPA', 'Diare', 'Demam Berdarah', 'Malaria'],
            datasets: [{
                data: [245, 156, 89, 34],
                backgroundColor: ['#EF4444', '#F59E0B', '#3B82F6', '#10B981']
            }]
        }
    });

    // Partisipasi Chart
    const partisipasiCtx = document.getElementById('partisipasiChart').getContext('2d');
    new Chart(partisipasiCtx, {
        type: 'bar',
        data: {
            labels: ['SD', 'SMP', 'SMA', 'PT'],
            datasets: [{
                data: [98.5, 85.2, 72.1, 15.8],
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6']
            }]
        }
    });

    // Fasilitas Chart
    const fasilitasCtx = document.getElementById('fasilitasChart').getContext('2d');
    new Chart(fasilitasCtx, {
        type: 'doughnut',
        data: {
            labels: ['SD', 'SMP', 'SMA', 'PAUD'],
            datasets: [{
                data: [8, 3, 2, 15],
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6']
            }]
        }
    });
});
</script>

@endsection
