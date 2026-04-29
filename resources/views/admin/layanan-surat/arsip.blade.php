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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-[#00c0ef] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Permohonan</p>
                    <p class="text-3xl font-extrabold">{{ $statPermohonan ?? 0 }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statPermohonan ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-[#00a65a] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Arsip</p>
                    <p class="text-3xl font-extrabold">{{ $statArsip ?? 0 }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statArsip ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-[#dd4b39] rounded-xl shadow-md overflow-hidden text-white flex">
                <div class="w-1/3 bg-black/10 flex items-center justify-center p-4">
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="w-2/3 p-4 flex flex-col justify-center">
                    <p class="text-sm font-bold uppercase tracking-wider opacity-90">Ditolak</p>
                    <p class="text-3xl font-extrabold">{{ $statDitolak ?? 0 }}</p>
                    <p class="text-xs mt-1 border-t border-white/20 pt-1">Total : {{ $statDitolak ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 mb-6">

            <form action="{{ route('admin.layanan-surat.arsip') }}" method="GET" class="flex flex-col lg:flex-row justify-between items-end gap-4">

                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">

                    {{-- Filter Tahun --}}
                    <select name="tahun" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Pilih Tahun</option>
                        @if(isset($tahunList))
                            @foreach($tahunList as $thn)
                                <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        @endif
                    </select>

                    {{-- Filter Bulan — value & perbandingan sama-sama pakai str_pad --}}
                    <select name="bulan" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Pilih Bulan</option>
                        @foreach(range(1, 12) as $bln)
                            @php $blnPad = str_pad($bln, 2, '0', STR_PAD_LEFT); @endphp
                            <option value="{{ $blnPad }}" {{ request('bulan') == $blnPad ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $bln, 1)) }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Filter Jenis Surat — pakai $suratTemplates dengan field judul --}}
                    <select name="jenis_surat" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 outline-none max-w-[200px]">
                        <option value="">Pilih Jenis Surat</option>
                        @if(isset($suratTemplates))
                            @foreach($suratTemplates as $template)
                                <option value="{{ $template->id }}" {{ request('jenis_surat') == $template->id ? 'selected' : '' }}>
                                    {{ $template->judul }}
                                </option>
                            @endforeach
                        @endif
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
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
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
                            <th class="py-3 px-4 font-bold">Nomor Surat</th>
                            <th class="py-3 px-4 font-bold">Surat</th>
                            <th class="py-3 px-4 font-bold">Pemohon</th>
                            <th class="py-3 px-4 font-bold">NIK</th>
                            <th class="py-3 px-4 font-bold">Tanggal Surat</th>
                            <th class="py-3 px-4 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($arsip as $key => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 text-center text-slate-600">{{ $arsip->firstItem() + $key }}</td>
                            <td class="py-3 px-4 text-center">
                                @if($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                       class="inline-flex items-center justify-center bg-[#00a65a] hover:bg-green-700 text-white p-2 rounded shadow-sm transition"
                                       title="Lihat/Unduh File">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-800 font-medium">{{ $item->nomor_surat ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $item->jenis_surat ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $item->nama_pemohon ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $item->nik ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600 whitespace-nowrap">
                                {{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @php
                                    $bg = 'bg-slate-100 text-slate-700';
                                    $statusStr = strtolower($item->status ?? '');
                                    if(str_contains($statusStr, 'sudah diambil'))                                  { $bg = 'bg-green-100 text-green-700'; }
                                    elseif(str_contains($statusStr, 'batal') || str_contains($statusStr, 'tolak')) { $bg = 'bg-red-100 text-red-700'; }
                                    elseif(str_contains($statusStr, 'periksa') || str_contains($statusStr, 'proses')) { $bg = 'bg-amber-100 text-amber-700'; }
                                    elseif(str_contains($statusStr, 'siap'))                                       { $bg = 'bg-blue-100 text-blue-700'; }
                                @endphp
                                <span class="px-2 py-1 {{ $bg }} rounded text-[11px] font-bold uppercase tracking-wider whitespace-nowrap">
                                    {{ $item->status ?? 'Draft' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-500">
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