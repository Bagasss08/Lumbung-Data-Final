@extends('layouts.admin')

@section('title', 'Arsip Layanan Surat')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Arsip Layanan Surat</h1>
                <div class="text-sm text-slate-500 flex items-center gap-2 mt-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600"><i class="fas fa-home"></i> Beranda</a>
                    <span>/</span>
                    <span class="text-slate-700 font-medium">Arsip Layanan Surat</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-green-700 font-bold">&times;</button>
            </div>
        @endif

        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm mb-6 flex gap-4">
            <div class="text-amber-500 mt-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-800 text-lg mb-1">Info Penting!</h3>
                <p class="text-sm text-amber-700 leading-relaxed">
                    Fitur Sinkronisasi Surat TTE ke Kecamatan saat ini masih berupa demo menunggu proses penyempurnaan dan terdapat Kecamatan yang sudah mengimplementasikan TTE. Kami juga menghimbau kepada seluruh pengguna memberikan masukan terkait penyempurnaan fitur ini.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-[#00c0ef] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Permohonan</p>
                    <p class="text-3xl font-extrabold">{{ $statPermohonan }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statPermohonan }}</p>
                </div>
            </div>

            <div class="bg-[#00a65a] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Arsip</p>
                    <p class="text-3xl font-extrabold">{{ $statArsip }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statArsip }}</p>
                </div>
            </div>

            <div class="bg-[#dd4b39] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Ditolak</p>
                    <p class="text-3xl font-extrabold">{{ $statDitolak }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statDitolak }}</p>
                </div>
            </div>

            <div class="bg-[#f39c12] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Kecamatan</p>
                    <p class="text-3xl font-extrabold">0</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : 0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-6">
            
            <div class="flex flex-wrap gap-2 mb-5 pb-5 border-b border-slate-100">
                <button class="bg-[#00a65a] hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekam Surat Perorangan
                </button>
                <button class="bg-[#f39c12] hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Pie Surat Keluar
                </button>
                <button class="bg-[#605ca8] hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak
                </button>
                <button class="bg-[#001f3f] hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh
                </button>
            </div>

            <form action="{{ route('admin.layanan-surat.arsip') }}" method="GET" class="flex flex-col lg:flex-row justify-between items-end gap-4">
                
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <select name="tahun" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Pilih Tahun</option>
                        @foreach($tahunList as $thn)
                            <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                        @endforeach
                    </select>

                    <select name="bulan" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Pilih Bulan</option>
                        @foreach(range(1, 12) as $bln)
                            <option value="{{ str_pad($bln, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == $bln ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $bln, 1)) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="jenis_surat" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none max-w-[200px]">
                        <option value="">Pilih Jenis Surat</option>
                        @foreach($jenisSuratList as $js)
                            <option value="{{ $js->id }}" {{ request('jenis_surat') == $js->id ? 'selected' : '' }}>{{ $js->nama_jenis_surat }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition">
                        Perbarui
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto justify-end">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Tampilkan</span>
                        <select name="per_page" class="px-2 py-1.5 bg-slate-50 border border-slate-300 rounded text-sm focus:ring-emerald-500" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        </select>
                        <span class="text-sm text-slate-500">entri</span>
                    </div>

                    <div class="flex items-center">
                        <span class="text-sm text-slate-500 mr-2">Cari:</span>
                        <input type="text" name="search" value="{{ request('search') }}" class="w-48 px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-l-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="kata kunci pencarian">
                        <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-600 px-3 py-1.5 rounded-r-lg border border-l-0 border-slate-300 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 border-b border-slate-200 text-slate-700">
                        <tr>
                            <th class="py-3 px-4 font-bold w-12 text-center">No</th>
                            <th class="py-3 px-4 font-bold text-center">Aksi</th>
                            <th class="py-3 px-4 font-bold">Kode Surat</th>
                            <th class="py-3 px-4 font-bold">No Urut</th>
                            <th class="py-3 px-4 font-bold">Jenis Surat</th>
                            <th class="py-3 px-4 font-bold">Pemohon</th>
                            <th class="py-3 px-4 font-bold">Keterangan</th>
                            <th class="py-3 px-4 font-bold">Tanggal</th>
                            <th class="py-3 px-4 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($arsip as $key => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 text-center text-slate-600">{{ $arsip->firstItem() + $key }}</td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('admin.layanan-surat.arsip.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data arsip ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#e83e8c] hover:bg-pink-700 text-white p-2 rounded shadow-sm transition" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-slate-600">S-{{ str_pad($item->jenis_surat_id, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $item->id }}</td>
                            <td class="py-3 px-4 text-slate-800 font-medium">
                                {{ $item->jenisSurat->nama_jenis_surat ?? 'Lainnya' }}
                            </td>
                            <td class="py-3 px-4 text-slate-700">
                                {{ $item->penduduk->nama ?? 'Warga (Dihapus)' }}
                            </td>
                            <td class="py-3 px-4 text-slate-500 max-w-[200px] truncate" title="{{ $item->keperluan }}">
                                {{ $item->keperluan ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y') }}<br>
                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $bg = 'bg-slate-100 text-slate-700';
                                    if($item->status == 'sudah diambil') { $bg = 'bg-green-100 text-green-700'; }
                                    elseif($item->status == 'dibatalkan') { $bg = 'bg-red-100 text-red-700'; }
                                    elseif($item->status == 'sedang diperiksa') { $bg = 'bg-amber-100 text-amber-700'; }
                                    elseif($item->status == 'siap diambil') { $bg = 'bg-blue-100 text-blue-700'; }
                                @endphp
                                <span class="px-2 py-1 {{ $bg }} rounded text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                                    {{ $item->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p>Tidak ada data arsip surat yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($arsip->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $arsip->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
