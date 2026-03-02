@extends('layouts.admin')
@section('title', 'Tambah Data C-Desa')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah C-Desa</h1>
            <p class="text-sm text-gray-500 mt-1">Registrasi kepemilikan buku C-Desa baru</p>
        </div>
        <a href="{{ route('admin.pertanahan.c-desa.index') }}" class="inline-flex items-center text-gray-600 hover:text-emerald-600 font-medium text-sm transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.pertanahan.c-desa.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-8">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Pemilik Buku C-Desa</label>
                    <div class="flex gap-4">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="jenis_pemilik" value="warga_desa" class="peer sr-only" checked onchange="toggleForm('warga_desa')">
                            <div class="px-5 py-3 rounded-lg border border-gray-200 bg-white text-gray-600 font-medium text-sm transition-all peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 peer-checked:text-emerald-700 hover:bg-gray-50">
                                Warga Desa (Data Kependudukan)
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="jenis_pemilik" value="warga_luar" class="peer sr-only" onchange="toggleForm('warga_luar')">
                            <div class="px-5 py-3 rounded-lg border border-gray-200 bg-white text-gray-600 font-medium text-sm transition-all peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 peer-checked:text-emerald-700 hover:bg-gray-50">
                                Warga Luar Desa (Input Manual)
                            </div>
                        </label>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div id="form-warga-desa" class="md:col-span-2 space-y-1">
                        <label class="block text-sm font-semibold text-gray-700">Cari Data Penduduk <span class="text-red-500">*</span></label>
                        <select name="penduduk_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm select2">
                            <option value="">-- Ketik NIK atau Nama --</option>
                            @foreach($penduduk as $p)
                                <option value="{{ $p->id }}">{{ $p->nik }} - {{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Hanya menampilkan penduduk yang berstatus hidup.</p>
                    </div>

                    <div id="form-warga-luar" class="hidden md:col-span-2 grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">NIK (Warga Luar) <span class="text-red-500">*</span></label>
                            <input type="text" name="nik_luar" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="16 Digit NIK">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap (Warga Luar) <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_luar" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="Sesuai KTP">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat_luar" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="Alamat asal/domisili"></textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor C-Desa <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_cdesa" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="Cth: 0023" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Tertulis di C-Desa <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_di_cdesa" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" placeholder="Cth: Ltm / H. Abdullah" required>
                        <p class="text-xs text-gray-500 mt-1">Nama historis yang tertera persis di buku C-Desa fisik.</p>
                    </div>
                </div>

            </div>

            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.pertanahan.c-desa.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-emerald-500 border border-transparent rounded-lg shadow-sm hover:bg-emerald-600 transition-colors">Simpan C-Desa</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleForm(tipe) {
    const fwDesa = document.getElementById('form-warga-desa');
    const fwLuar = document.getElementById('form-warga-luar');
    
    if(tipe === 'warga_desa') {
        fwDesa.classList.remove('hidden');
        fwLuar.classList.add('hidden');
        fwLuar.classList.remove('grid'); // remove grid class when hidden
    } else {
        fwDesa.classList.add('hidden');
        fwLuar.classList.remove('hidden');
        fwLuar.classList.add('grid'); // add grid class when shown
    }
}
</script>
@endsection