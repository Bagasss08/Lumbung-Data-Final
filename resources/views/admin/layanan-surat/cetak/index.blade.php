@extends('layouts.admin')

@section('title', 'Cetak Surat')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Cetak Surat</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih template surat dan lengkapi data untuk cetak otomatis</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pilih Template Surat</h3>
                </div>

                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" id="searchTemplate" 
                            class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-emerald-500" 
                            placeholder="Cari template...">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="p-4 max-h-[600px] overflow-y-auto" id="templateList">
                    @forelse($templates as $template)
                    <div class="template-item mb-3 p-4 border-2 border-gray-200 rounded-lg hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer" 
                         data-template-id="{{ $template->id }}"
                         data-template-name="{{ $template->nama_template }}"
                         data-template-jenis="{{ $template->jenis_surat }}"
                         data-template-fields="{{ json_encode(is_string($template->fields_json) ? json_decode($template->fields_json, true) : ($template->fields_json ?? [])) }}"
                         onclick="selectTemplate(this)">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900">{{ $template->nama_template }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $template->jenis_surat }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 template-check hidden" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-sm font-medium text-gray-900">Belum ada template</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm" id="formWrapper">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900" id="formTitle">Form Pengisian Surat</h3>
                </div>

                <div id="formContainer" class="p-6">
                    <div id="emptyState" class="text-center py-16">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Pilih Template Terlebih Dahulu</h4>
                        <p class="text-sm text-gray-500">Klik daftar template di sebelah kiri.</p>
                    </div>

                    <form id="dynamicForm" action="{{ route('admin.layanan-surat.cetak.store') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="hidden" name="template_id" id="selectedTemplateId">
                        
                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200">
                            <label class="block text-sm font-bold text-blue-900 mb-2">Cari Data Penduduk (Tarik Data Otomatis)</label>
                            <div class="flex gap-2">
                                <input type="text" id="searchNik" 
                                    class="flex-1 px-4 py-3 text-sm border-2 border-blue-300 rounded-lg" 
                                    placeholder="Masukkan 16 digit NIK..." maxlength="16">
                                <button type="button" onclick="searchPenduduk()" 
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-all">
                                    Cari NIK
                                </button>
                            </div>
                        </div>

                        <div id="hiddenPendudukData"></div>

                        <div id="dynamicFields" class="space-y-5 mb-8"></div>

                        <div class="mt-8 pt-6 border-t-2 border-gray-200">
                            <h4 class="text-base font-bold text-gray-900 mb-4">Informasi Surat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Surat <span class="text-red-500">*</span></label>
                                    <input type="text" id="format_nomor" name="format_nomor" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Surat <span class="text-red-500">*</span></label>
                                    <input type="date" id="tgl_surat" name="tgl_surat" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keperluan (form_keterangan) <span class="text-red-500">*</span></label>
                                    <input type="text" name="form_keterangan" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg" placeholder="Cth: Mengurus pembuatan SKCK di Polsek" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mulai Berlaku <span class="text-red-500">*</span></label>
                                    <input type="date" name="mulai_berlaku" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal (tgl_akhir) <span class="text-red-500">*</span></label>
                                    <input type="date" name="tgl_akhir" class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t-2 border-gray-200">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 transition-all shadow-md">
                                Generate Word & Cetak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function selectTemplate(element) {
    const templateId = element.getAttribute('data-template-id');
    const fieldsJsonStr = element.getAttribute('data-template-fields');
    
    document.getElementById('selectedTemplateId').value = templateId;
    document.getElementById('emptyState').classList.add('hidden');
    document.getElementById('dynamicForm').classList.remove('hidden');
    
    document.querySelectorAll('.template-item').forEach(item => {
        item.classList.remove('border-emerald-500', 'bg-emerald-50');
        item.querySelector('.template-check').classList.add('hidden');
    });
    element.classList.add('border-emerald-500', 'bg-emerald-50');
    element.querySelector('.template-check').classList.remove('hidden');
}

function searchPenduduk() {
    const nik = document.getElementById('searchNik').value;
    if (nik.length !== 16) return alert('NIK harus 16 digit');
    
    fetch(`/admin/layanan-surat/cetak/penduduk/${nik}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data) {
                // Buat input hidden untuk semua data agar dikirim ke backend (Controller)
                const hiddenContainer = document.getElementById('hiddenPendudukData');
                hiddenContainer.innerHTML = ''; // bersihkan data sebelumnya
                
                Object.keys(data.data).forEach(key => {
                    // Agar sesuai dgn template Anda, perbaiki format huruf kecil jika perlu
                    // Namun kita kirim apa adanya dulu, controller yg mengolah.
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `data_warga[${key}]`; // dikirim sbg array data_warga
                    input.value = data.data[key] || '';
                    hiddenContainer.appendChild(input);
                });
                alert('Data Penduduk Ditemukan & Siap Digenerate!');
            } else {
                alert('Data tidak ditemukan');
            }
        });
}
</script>
@endpush
@endsection