@extends('layouts.admin')
@section('title', 'Tulis Pesan')

@section('content')
<div class="w-full p-6 bg-slate-50 min-h-screen">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tulis Pesan</h1>
            <p class="text-sm text-gray-500 mt-1">Kirim pesan pemberitahuan atau balasan ke warga</p>
        </div>
        <a href="{{ route('admin.hubung-warga.inbox') }}" class="inline-flex items-center text-gray-600 hover:text-emerald-600 font-medium text-sm transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Kotak Masuk
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.hubung-warga.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kepada (Warga) <span class="text-red-500">*</span></label>
                    <select name="penerima_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm bg-gray-50 py-2.5 px-3" required>
                        <option value="">-- Pilih Penerima Pesan --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->id }}" {{ (isset($replyTo) && $replyTo == $w->id) ? 'selected' : '' }}>
                                {{ $w->name }} (NIK: {{ $w->penduduk->nik ?? 'Belum dilink' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek Pesan <span class="text-red-500">*</span></label>
                    <input type="text" name="subjek" value="{{ $subject ?? '' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm px-4 py-2.5" placeholder="Contoh: Pemberitahuan Dokumen Kurang Lengkap" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Pesan <span class="text-red-500">*</span></label>
                    <textarea name="isi_pesan" rows="8" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm px-4 py-3" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                    <p class="text-xs text-gray-500 mt-2">Pesan ini akan langsung masuk ke Dashboard Warga terkait.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.hubung-warga.inbox') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 shadow-md shadow-emerald-500/20 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection