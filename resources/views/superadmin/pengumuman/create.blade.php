@extends('superadmin.layout.superadmin')

@section('title', 'Buat Pengumuman')
@section('header', 'Buat Pengumuman Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden">
    <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/30">
        <h2 class="text-xl font-bold text-gray-800">Tulis Pengumuman Sistem</h2>
        <p class="text-[13.5px] text-gray-500 mt-1.5">Informasi ini akan muncul sebagai alert/notifikasi di dashboard target audiens.</p>
    </div>

    <div class="p-6 md:p-8">
        <form action="{{ route('superadmin.pengumuman.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="group">
                <label class="block text-[13.5px] font-bold text-gray-700 mb-2">Target Audiens <span class="text-red-500">*</span></label>
                <select name="target_role" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm">
                    <option value="semua">Semua Pengguna (Admin & Warga)</option>
                    <option value="admin">Hanya Semua Admin / Operator</option>
                    <option value="warga">Hanya Warga Desa</option>
                </select>
            </div>

            <div class="group">
                <label class="block text-[13.5px] font-bold text-gray-700 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="Contoh: Pemeliharaan Server Rutin..." 
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm">
            </div>

            <div class="group">
                <label class="block text-[13.5px] font-bold text-gray-700 mb-2">Isi Pengumuman <span class="text-red-500">*</span></label>
                <textarea name="isi" rows="6" required placeholder="Tuliskan detail pengumuman di sini..." 
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm resize-y"></textarea>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('superadmin.pengumuman.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 shadow-md transform transition-transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Kirim & Sebarkan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection