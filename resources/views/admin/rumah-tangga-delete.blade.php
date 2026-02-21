@extends('layouts.admin')

@section('title', 'Konfirmasi Hapus Rumah Tangga')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-slate-700">Konfirmasi Hapus Rumah Tangga</h2>
            <p class="text-sm text-slate-500">Apakah Anda yakin ingin menghapus rumah tangga ini?</p>
        </div>
        <a href="{{ route('admin.rumah-tangga.index') }}"
           class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Warning Card -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-medium text-red-800 mb-2">Peringatan!</h3>
                <p class="text-sm text-red-700 mb-4">
                    Tindakan ini tidak dapat dibatalkan. Data rumah tangga yang dihapus akan hilang secara permanen.
                </p>
            </div>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Rumah Tangga</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- No. Rumah Tangga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">No. Rumah Tangga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $rumahTangga->no_rumah_tangga }}</p>
            </div>

            <!-- Kepala Rumah Tangga -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kepala Rumah Tangga</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $rumahTangga->kepala_rumah_tangga_name }}</p>
            </div>

            <!-- Wilayah -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Wilayah</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    RT {{ $rumahTangga->wilayah->rt ?? '-' }} / RW {{ $rumahTangga->wilayah->rw ?? '-' }} - {{ $rumahTangga->wilayah->dusun ?? '-' }}
                </p>
            </div>

            <!-- Tanggal Terdaftar -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Terdaftar</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">
                    @if($rumahTangga->tgl_terdaftar)
                        {{ $rumahTangga->tgl_terdaftar->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ ucfirst($rumahTangga->status) }}</p>
            </div>

            <!-- Jumlah Anggota -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Anggota</label>
                <p class="text-sm text-slate-900 bg-slate-50 px-4 py-2 rounded-lg">{{ $rumahTangga->jumlah_anggota }} orang</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.rumah-tangga.index') }}"
               class="px-6 py-2 border border-slate-300 rounded-lg text-slate-600 hover:bg-slate-50 transition duration-200">
                Batal
            </a>
            <form action="{{ route('admin.rumah-tangga.destroy', $rumahTangga) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition duration-200">
                    Ya, Hapus Rumah Tangga
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
