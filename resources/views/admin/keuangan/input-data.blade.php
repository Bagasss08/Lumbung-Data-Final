@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Input Data Keuangan</h1>
                <p class="text-slate-600">Masukkan data pemasukan dan pengeluaran keuangan desa</p>
            </div>
            <a href="{{ route('admin.keuangan.laporan') }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                <i class="fas fa-list mr-2"></i>Lihat Laporan
            </a>
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

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <div class="flex items-center mb-2">
            <i class="fas fa-exclamation-triangle mr-3"></i>
            <span class="font-semibold">Terdapat kesalahan:</span>
        </div>
        <ul class="list-disc list-inside ml-6">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.keuangan.store') }}" method="POST" class="space-y-6"
            id="transaksiForm">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                        max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tanggal') border-red-500 @enderror"
                        required>
                    @error('tanggal')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jenis Transaksi <span class="text-red-500">*</span>
                    </label>
                    <select name="tipe"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tipe') border-red-500 @enderror"
                        required>
                        <option value="">Pilih jenis transaksi</option>
                        <option value="masuk" {{ old('tipe')=='masuk' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="keluar" {{ old('tipe')=='keluar' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('tipe')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Kas Desa -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Kas Desa <span class="text-red-500">*</span>
                </label>
                <select name="kas_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kas_id') border-red-500 @enderror"
                    required>
                    <option value="">Pilih kas desa</option>
                    @foreach($kasDesa as $kas)
                    <option value="{{ $kas->id }}" {{ old('kas_id')==$kas->id ? 'selected' : '' }}>{{ $kas->nama }}</option>
                    @endforeach
                </select>
                @error('kas_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Jumlah (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah" value="{{ old('jumlah') }}" step="0.01" min="0.01" placeholder="0.00"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jumlah') border-red-500 @enderror"
                    required>
                @error('jumlah')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <button type="reset" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Jenis</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Jumlah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($recentTransactions as $transaction)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-900">
                            {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->tipe === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $transaction->tipe === 'masuk' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td
                            class="px-4 py-3 whitespace-nowrap text-sm {{ $transaction->tipe === 'masuk' ? 'text-emerald-600 font-medium' : 'text-red-600 font-medium' }}">
                            Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Tersimpan
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Form validation
    document.getElementById('transaksiForm').addEventListener('submit', function(e) {
        const jumlah = parseFloat(document.querySelector('input[name="jumlah"]').value);
        if (jumlah <= 0) {
            e.preventDefault();
            alert('Jumlah harus lebih besar dari 0');
            return false;
        }
    });
</script>
@endsection
