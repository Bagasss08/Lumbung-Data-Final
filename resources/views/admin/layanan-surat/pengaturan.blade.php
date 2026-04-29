@extends('layouts.admin')

@section('title', 'Pengaturan Surat')

@section('content')
<div class="min-h-screen bg-gray-50/50 p-4 md:p-8">
    <div class="max-w-full mx-auto">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pengaturan Template Surat</h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kelola format dokumen dan persyaratan untuk setiap jenis surat.
                </p>
            </div>

            <button onclick="openModal()"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Template
            </button>
        </div>

        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
            <div class="relative max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" id="searchTemplate" placeholder="Cari nama template surat..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($templates ?? [] as $template)
            <div class="template-card group bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:border-emerald-300 transition-all duration-300 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex gap-1">
                            <button onclick="openEditModal({{ $template->id }})" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <form action="{{ route('admin.layanan-surat.pengaturan.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight group-hover:text-emerald-700">{{ $template->nama }}</h3>
                    <p class="text-xs text-gray-500 flex items-center gap-1 mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Diperbarui {{ $template->updated_at->diffForHumans() }}
                    </p>

                    <div class="space-y-2">
                        <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank"
                            class="flex items-center justify-center gap-2 w-full py-2 px-4 bg-gray-50 text-gray-700 text-sm font-medium rounded-lg hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat File
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center">
                <div class="p-4 bg-gray-50 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-gray-900 font-semibold text-lg">Belum ada template</h3>
                <p class="text-gray-500 text-sm">Klik tombol "Tambah Template" untuk memulai.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL TAMBAH (Mengikuti gaya modal yang elegan) --}}
<div id="modal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-fade-in">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Tambah Template Baru</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.layanan-surat.pengaturan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Surat</label>
                        <input type="text" name="nama" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all outline-none"
                            placeholder="Contoh: Surat Keterangan Domisili">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Template (.docx)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition-all cursor-pointer bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500">
                                        <span>Pilih file</span>
                                        <input name="file" type="file" class="sr-only" required accept=".docx">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500 italic">Hanya file .docx</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-md transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4 text-center">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-fade-in">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Edit Template Surat</h3>
                <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Surat</label>
                        <input type="text" name="nama" id="edit_nama" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Template (Opsional)</label>
                        <input type="file" name="file" accept=".docx"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                        <p class="mt-1 text-xs text-gray-400 italic font-medium">*Kosongkan jika tidak ingin mengganti file</p>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md transition-all">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal Logic
    function openModal() { document.getElementById('modal').classList.remove('hidden'); }
    function closeModal() { document.getElementById('modal').classList.add('hidden'); }

    function openEditModal(id) {
        // Logika fetch data template (sesuaikan dengan API/data Anda)
        const form = document.getElementById('formEdit');
        form.action = `/admin/layanan-surat/pengaturan/${id}`; // Sesuaikan URL route Anda

        // Contoh jika data sudah ada di loop, Anda bisa mengirimnya lewat parameter
        // Di sini saya asumsikan Anda akan memuat data sesuai ID
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeEditModal() { document.getElementById('modalEdit').classList.add('hidden'); }

    // Search Logic (Real-time Filter)
    document.getElementById('searchTemplate').addEventListener('input', function(e) {
        const keyword = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.template-card');

        cards.forEach(card => {
            const title = card.querySelector('h3').innerText.toLowerCase();
            if (title.includes(keyword)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
            closeEditModal();
        }
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.3s ease-out; }

    /* Custom Scrollbar untuk pengalaman desktop yang lebih baik */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endsection
