@extends('layouts.admin')

@section('title', 'Laporan Penduduk')

@section('content')

<!-- ================= HEADER ================= -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Laporan Penduduk</h1>
        <p class="text-sm text-slate-500">
            Database induk penduduk desa - sumber data utama untuk semua jenis laporan lainnya
        </p>
    </div>

    <div class="flex gap-3">
        <button onclick="exportPDF()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export PDF
        </button>
        <button onclick="exportExcel()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export Excel
        </button>
    </div>
</div>

<!-- ================= SUMMARY CARDS ================= -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-xs text-slate-500">Total Penduduk</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['total_penduduk']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-xs text-slate-500">Kepala Keluarga</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['kepala_keluarga']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-blue-600">
        <p class="text-xs">Laki-laki</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['laki_laki']) }}</h3>
    </div>

    <div class="bg-white p-5 rounded-xl shadow text-pink-600">
        <p class="text-xs">Perempuan</p>
        <h3 class="text-2xl font-bold mt-1">{{ number_format($data['perempuan']) }}</h3>
    </div>
</div>

<!-- ================= SEARCH AND FILTER ================= -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Filter Data</h3>
    <form method="GET" action="{{ route('admin.statistik.penduduk') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-2">Pencarian</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau NIK..."
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-700 mb-2">Jenis Kelamin</label>
            <select name="jenis_kelamin"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                <option value="" {{ request('jenis_kelamin') == '' ? 'selected' : '' }}>Semua</option>
                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-700 mb-2">Agama</label>
            <select name="agama"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                <option value="" {{ request('agama') == '' ? 'selected' : '' }}>Semua Agama</option>
                <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                <option value="Budha" {{ request('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.statistik.penduduk') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- ================= DATA TABLE ================= -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No KK</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tempat Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Agama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Hubungan Keluarga</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pendidikan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pekerjaan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Kawin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($data['penduduk'] as $index => $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $data['penduduk']->firstItem() + $index }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->nik }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $p->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        @php
                            $keluarga = $p->keluargas()->first();
                        @endphp
                        {{ $keluarga ? $keluarga->no_kk : '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->tempat_lahir }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->agama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        @php
                            $hubungan = $p->keluargas()->first();
                        @endphp
                        @if($hubungan)
                            {{ ucfirst(str_replace('_', ' ', $hubungan->pivot->hubungan_keluarga)) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->alamat }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->pendidikan ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->pekerjaan ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $p->status_kawin ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="13" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm font-medium text-gray-900">Tidak ada data penduduk</p>
                            <p class="text-sm text-gray-500 mt-1">Data penduduk belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($data['penduduk']->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
                @if ($data['penduduk']->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                    Sebelumnya
                </span>
                @else
                <a href="{{ $data['penduduk']->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Sebelumnya
                </a>
                @endif

                @if ($data['penduduk']->hasMorePages())
                <a href="{{ $data['penduduk']->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Selanjutnya
                </a>
                @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-white cursor-not-allowed">
                    Selanjutnya
                </span>
                @endif
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium">{{ $data['penduduk']->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $data['penduduk']->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $data['penduduk']->total() }}</span>
                        data
                    </p>
                </div>

                <div>
                    <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px" aria-label="Pagination">
                        @if ($data['penduduk']->onFirstPage())
                        <span class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @else
                        <a href="{{ $data['penduduk']->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        @endif

                        @foreach ($data['penduduk']->getUrlRange(1, $data['penduduk']->lastPage()) as $page => $url)
                        @if ($page == $data['penduduk']->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-emerald-500 bg-emerald-50 text-sm font-medium text-emerald-600">
                            {{ $page }}
                        </span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            {{ $page }}
                        </a>
                        @endif
                        @endforeach

                        @if ($data['penduduk']->hasMorePages())
                        <a href="{{ $data['penduduk']->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        @else
                        <span class="relative inline-flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function exportPDF() {
    // Implement PDF export functionality
    alert('Fitur export PDF akan segera hadir');
}

function exportExcel() {
    // Implement Excel export functionality
    alert('Fitur export Excel akan segera hadir');
}
</script>
@endpush
