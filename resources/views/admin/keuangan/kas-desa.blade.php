@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Kelola Kas Desa</h1>
                <p class="text-slate-600">Kelola data kas desa untuk transaksi keuangan</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.keuangan.input-data') }}"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-plus-circle mr-2"></i>Input Transaksi
                </a>
                <a href="{{ route('admin.keuangan.kas-desa.create') }}"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Kas Desa
                </a>
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

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
        <form action="{{ route('admin.keuangan.kas-desa') }}" method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama kas desa..."
                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <button type="submit"
                class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            @if(request('search'))
            <a href="{{ route('admin.keuangan.kas-desa') }}"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Nama Kas Desa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tahun Anggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Saldo Awal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Saldo Akhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($kasDesa as $index => $kas)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ $kasDesa->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                            {{ $kas->nama }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            {{ $kas->tahun->tahun ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            Rp {{ number_format($kas->saldo_awal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-emerald-600">
                            Rp {{ number_format($kas->saldo_akhir, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.keuangan.kas-desa.edit', $kas->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-xs">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.keuangan.kas-desa.destroy', $kas->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-xs">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                            <p class="mb-2">Belum ada data Kas Desa</p>
                            <a href="{{ route('admin.keuangan.kas-desa.create') }}" 
                                class="text-emerald-600 hover:text-emerald-700 font-medium">
                                Tambah Kas Desa Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($kasDesa->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $kasDesa->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
