@extends('layouts.admin')

@section('title', 'Informasi Publik')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Pengaturan Informasi Publik Di Desa</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola informasi publik desa yang dapat diakses masyarakat</p>
            </div>
            <a href="{{ route('admin.sekretariat.informasi-publik.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Dokumen
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div
        class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-sm">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-xl flex items-start gap-3 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span class="text-sm">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cari Dokumen</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul dokumen..."
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>

                <!-- Kategori Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="kategori"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        <option value="">Semua Kategori</option>
                        <option value="Informasi Berkala" @selected(request('kategori')=='Informasi Berkala' )>Informasi
                            Berkala</option>
                        <option value="Informasi Serta Merta" @selected(request('kategori')=='Informasi Serta Merta' )>
                            Informasi Serta Merta</option>
                        <option value="Informasi Setiap Saat" @selected(request('kategori')=='Informasi Setiap Saat' )>
                            Informasi Setiap Saat</option>
                        <option value="Informasi Dikecualikan" @selected(request('kategori')=='Informasi Dikecualikan'
                            )>Informasi Dikecualikan</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="ya" @selected(request('status')=='ya' )>Terbit</option>
                        <option value="tidak" @selected(request('status')=='tidak' )>Tidak Terbit</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.sekretariat.informasi-publik.index') }}"
                    class="px-6 py-2.5 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 font-medium transition-all">
                    Reset
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl font-medium transition-all shadow-sm hover:shadow-md">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Judul Dokumen
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Tahun
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Tanggal Terbit
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($informasiPublik as $item)
                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $item->judul_dokumen }}</div>
                            @if($item->keterangan)
                            <div class="text-sm text-slate-500 line-clamp-2 mt-1">{{ Str::limit($item->keterangan, 100)
                                }}</div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                {{ $item->tipe_dokumen === 'file' ? 'bg-blue-100 text-blue-700' : 
                                   ($item->tipe_dokumen === 'link' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($item->tipe_dokumen) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-700 rounded-full">
                                {{ $item->kategori_info_publik ?: '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            {{ $item->tahun ?: '-' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ \Carbon\Carbon::parse($item->tanggal_terbit)->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                {{ $item->status_terbit === 'ya' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->status_terbit === 'ya' ? 'Terbit' : 'Tidak Terbit' }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <!-- Download Button -->
                                @if($item->unggah_dokumen && $item->tipe_dokumen === 'file')
                                <a href="{{ route('admin.sekretariat.informasi-publik.download', $item->id) }}"
                                    class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all"
                                    title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                                @endif

                                <!-- Edit Button -->
                                <a href="{{ route('admin.sekretariat.informasi-publik.edit', $item->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST"
                                    action="{{ route('admin.sekretariat.informasi-publik.destroy', $item->id) }}"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-slate-600 font-medium mb-2">Belum ada data informasi publik</p>
                                <p class="text-sm text-slate-400">Klik tombol "Tambah Dokumen" untuk menambahkan data
                                    baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($informasiPublik->hasPages())
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
            {{ $informasiPublik->links() }}
        </div>
        @endif
    </div>

</div>
@endsection