@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Laporan Keuangan</h1>
                <p class="text-slate-600">Kelola dan pantau laporan keuangan desa</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.keuangan.input-data') }}"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                </a>
                <button onclick="window.print()"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-check-circle mr-3"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
        <i class="fas fa-exclamation-circle mr-3"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form method="GET" action="{{ route('admin.keuangan.laporan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                <select name="tahun"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua</option>
                    @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ request('tahun')==$year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                <select name="bulan"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @foreach($bulanOptions as $key => $bulanName)
                    <option value="{{ $key }}" {{ request('bulan')==$key ? 'selected' : '' }}>{{ $bulanName }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Laporan</label>
                <select name="jenis"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="Semua" {{ request('jenis')=='Semua' ? 'selected' : '' }}>Semua</option>
                    <option value="Pemasukan" {{ request('jenis')=='Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="Pengeluaran" {{ request('jenis')=='Pengeluaran' ? 'selected' : '' }}>Pengeluaran
                    </option>
                    <option value="Saldo" {{ request('jenis')=='Saldo' ? 'selected' : '' }}>Saldo</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laporan..."
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit"
                    class="flex-1 px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.keuangan.laporan') }}"
                    class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-emerald-100 rounded-lg">
                    <i class="fas fa-arrow-up text-2xl text-emerald-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-600">Total Pemasukan</p>
                    <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-arrow-down text-2xl text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-600">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-wallet text-2xl text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-600">Saldo Saat Ini</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($saldoSaatIni, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-amber-100 rounded-lg">
                    <i class="fas fa-chart-line text-2xl text-amber-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-slate-600">Rata-rata Bulanan</p>
                    <p class="text-2xl font-bold text-amber-600">
                        Rp {{ number_format($averageMonthly ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">No
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Pemasukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Pengeluaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Saldo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($transactions as $index => $transaction)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ $transactions->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->tipe === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $transaction->tipe === 'masuk' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm {{ $transaction->tipe === 'masuk' ? 'text-emerald-600 font-medium' : 'text-slate-400' }}">
                            {{ $transaction->tipe === 'masuk' ? 'Rp ' . number_format($transaction->jumlah, 0, ',', '.')
                            : '-' }}
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm {{ $transaction->tipe === 'keluar' ? 'text-red-600 font-medium' : 'text-slate-400' }}">
                            {{ $transaction->tipe === 'keluar' ? 'Rp ' . number_format($transaction->jumlah, 0, ',',
                            '.') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-medium">
                            Rp {{ number_format($transaction->running_balance, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <form action="{{ route('admin.keuangan.destroy', $transaction->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500">
                            <i class="fas fa-inbox text-4xl mb-3 block text-slate-300"></i>
                            <p class="font-medium">Tidak ada data transaksi</p>
                            <p class="text-xs mt-1">Silakan tambah transaksi baru atau ubah filter pencarian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-slate-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($transactions->onFirstPage())
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-400 bg-white cursor-not-allowed">
                        Previous
                    </span>
                    @else
                    <a href="{{ $transactions->previousPageUrl() }}"
                        class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                        Previous
                    </a>
                    @endif

                    @if($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50">
                        Next
                    </a>
                    @else
                    <span
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-slate-400 bg-white cursor-not-allowed">
                        Next
                    </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-700">
                            Menampilkan
                            <span class="font-medium">{{ $transactions->firstItem() ?? 0 }}</span>
                            sampai
                            <span class="font-medium">{{ $transactions->lastItem() ?? 0 }}</span>
                            dari
                            <span class="font-medium">{{ $transactions->total() }}</span>
                            transaksi
                        </p>
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
