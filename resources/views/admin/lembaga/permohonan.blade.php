@extends('layouts.admin')

@section('title', 'Permohonan Surat')

@section('content')
<div class="min-h-screen bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Permohonan Surat</h1>
                <p class="text-sm text-slate-500">Kelola permohonan surat dari warga</p>
            </div>

            <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white text-sm font-bold rounded-xl shadow-md transition" onclick="openModal()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Permohonan
            </button>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Menunggu</p>
                        <p class="text-2xl font-bold text-yellow-600">12</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600">28</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600">5</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Total</p>
                        <p class="text-2xl font-bold text-slate-800">45</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">No. Permohonan</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Pemohon</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Jenis Surat</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Tanggal</th>
                                <th class="text-left py-3 px-4 font-semibold text-slate-600">Status</th>
                                <th class="text-center py-3 px-4 font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample data - replace with dynamic data -->
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">#001</td>
                                <td class="py-3 px-4">
                                    <div>
                                        <p class="font-medium">Ahmad Surya</p>
                                        <p class="text-xs text-slate-500">NIK: 1234567890123456</p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">Surat Keterangan Domisili</td>
                                <td class="py-3 px-4">2024-01-15</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-green-600 hover:bg-green-50 rounded" title="Setujui">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-red-600 hover:bg-red-50 rounded" title="Tolak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="py-3 px-4 font-medium">#002</td>
                                <td class="py-3 px-4">
                                    <div>
                                        <p class="font-medium">Siti Aminah</p>
                                        <p class="text-xs text-slate-500">NIK: 1234567890123457</p>
                                    </div>
                                </td>
                                <td class="py-3 px-4">Surat Keterangan Tidak Mampu</td>
                                <td class="py-3 px-4">2024-01-14</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Disetujui</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-1 text-blue-600 hover:bg-blue-50 rounded" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-green-600 hover:bg-green-50 rounded" title="Cetak Surat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Tambah Permohonan Surat</h3>

                <form>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">NIK Pemohon</label>
                            <input type="text" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Masukkan NIK">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Jenis Surat</label>
                            <select class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option>Surat Keterangan Domisili</option>
                                <option>Surat Keterangan Tidak Mampu</option>
                                <option>Surat Pengantar Nikah</option>
                                <option>Surat Keterangan Usaha</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Keperluan</label>
                            <textarea class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" rows="3" placeholder="Jelaskan keperluan surat"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Upload Dokumen Pendukung</label>
                            <input type="file" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" multiple>
                            <p class="text-xs text-slate-500 mt-1">Upload KTP, KK, atau dokumen pendukung lainnya</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition" onclick="closeModal()">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Ajukan Permohonan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>
@endsection
