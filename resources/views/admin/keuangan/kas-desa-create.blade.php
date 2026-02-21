@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">Tambah Kas Desa</h1>
                <p class="text-slate-600">Tambah data kas desa baru</p>
            </div>
            <a href="{{ route('admin.keuangan.kas-desa') }}"
                class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Error Messages -->
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
        <form action="{{ route('admin.keuangan.kas-desa.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Tahun Anggaran -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tahun Anggaran <span class="text-red-500">*</span>
                </label>
                <select name="tahun_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tahun_id') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Tahun Anggaran</option>
                    @foreach($tahunAnggaran as $tahun)
                    <option value="{{ $tahun->id }}" {{ old('tahun_id')==$tahun->id ? 'selected' : '' }}>
                        {{ $tahun->tahun }}
                    </option>
                    @endforeach
                </select>
                @if($tahunAnggaran->isEmpty())
                <p class="mt-1 text-sm text-red-500">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Tahun anggaran belum tersedia. 
                    <a href="#" class="underline">Hubungi administrator</a>
                </p>
                @endif
                @error('tahun_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Kas Desa -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Nama Kas Desa <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}" 
                    placeholder="Contoh: Kas Desa Utama, Kas Pembantu, dll"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama') border-red-500 @enderror"
                    required>
                @error('nama')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Saldo Awal -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Saldo Awal (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="saldo_awal" value="{{ old('saldo_awal', 0) }}" 
                    min="0" step="0.01" placeholder="0"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('saldo_awal') border-red-500 @enderror"
                    required>
                <p class="mt-1 text-sm text-slate-500">
                    Saldo awal akan otomatis menjadi saldo akhir awal
                </p>
                @error('saldo_awal')
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
</div>
@endsection
