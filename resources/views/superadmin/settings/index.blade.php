@extends('superadmin.layout.superadmin')

@section('title', 'Pengaturan Server')
@section('header', 'Pengaturan Sistem Server')
@section('subheader', 'Konfigurasi global aplikasi, kontak pusat, dan mode pemeliharaan.')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{ activeTab: 'server' }">

    {{-- ── Alert Success ── --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex items-start gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="text-sm font-bold text-emerald-800">Berhasil Disimpan!</h3>
                <p class="text-sm text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-6">
        
        {{-- ── Kolom Kiri: Navigasi Tab ── --}}
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-2 md:sticky md:top-6">
                <nav class="flex flex-col space-y-1">
                    <button @click="activeTab = 'server'" 
                            :class="activeTab === 'server' ? 'bg-slate-800 text-white font-bold' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                            class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition-all text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        Konfigurasi Server
                    </button>

                    <button @click="activeTab = 'kontak'" 
                            :class="activeTab === 'kontak' ? 'bg-slate-800 text-white font-bold' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                            class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition-all text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Kontak Pusat Bantuan
                    </button>

                    <button @click="activeTab = 'sistem'" 
                            :class="activeTab === 'sistem' ? 'bg-slate-800 text-white font-bold' : 'text-slate-600 hover:bg-slate-50 font-medium'"
                            class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition-all text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Preferensi Akses
                    </button>
                </nav>
            </div>
        </div>

        {{-- ── Kolom Kanan: Konten Form ── --}}
        <div class="flex-1 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            
            <form action="{{ route('superadmin.settings.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}

                {{-- TAB 1: KONFIGURASI SERVER --}}
                <div x-show="activeTab === 'server'" x-cloak class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Identitas Aplikasi Induk</h3>
                        <p class="text-sm text-slate-500 mt-1">Pengaturan identitas pusat yang mengelola seluruh data tenant (desa).</p>
                    </div>
                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Aplikasi Induk</label>
                            <input type="text" name="app_name" value="{{ config('app.name') }}" class="w-full md:w-2/3 border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Contoh: Sistem Informasi Desa Pusat">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Logo Global Superadmin</label>
                            <div class="flex items-center gap-5">
                                <div class="w-16 h-16 rounded-xl bg-slate-50 border-2 border-dashed border-slate-300 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="app_logo" accept="image/*" class="block w-full md:w-2/3 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-slate-800 file:text-white hover:file:bg-slate-700 transition-all cursor-pointer border border-slate-200 rounded-lg">
                                    <p class="text-[11px] text-slate-400 mt-2">Format: JPG/PNG. Digunakan sebagai ikon login Superadmin.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Timezone Server Default</label>
                            <select name="timezone" class="w-full md:w-1/3 border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-blue-500 shadow-sm">
                                <option value="Asia/Jakarta" selected>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: KONTAK PUSAT BANTUAN --}}
                <div x-show="activeTab === 'kontak'" x-cloak class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Kontak Pusat Bantuan (Helpdesk)</h3>
                        <p class="text-sm text-slate-500 mt-1">Kontak ini digunakan oleh Admin Desa jika mereka membutuhkan bantuan teknis ke Superadmin.</p>
                    </div>
                    <hr class="border-slate-100">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Helpdesk Support</label>
                            <input type="email" name="support_email" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="support@domainanda.com">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">WhatsApp Teknisi / Support</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm font-bold">+62</span>
                                <input type="text" name="support_wa" class="w-full border border-slate-300 rounded-r-lg px-4 py-2.5 text-sm text-slate-800 focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="81234567890">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 3: PREFERENSI AKSES --}}
                <div x-show="activeTab === 'sistem'" x-cloak class="p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Preferensi & Akses Sistem</h3>
                        <p class="text-sm text-slate-500 mt-1">Pengaturan teknis yang memengaruhi jalannya aplikasi secara global.</p>
                    </div>
                    <hr class="border-slate-100">

                    <div class="space-y-4">
                        {{-- Maintenance Mode Toggle --}}
                        <div class="flex items-start justify-between p-5 rounded-xl border border-red-100 bg-red-50/30">
                            <div>
                                <h4 class="text-sm font-bold text-red-800">Mode Pemeliharaan Server (Maintenance Mode)</h4>
                                <p class="text-[13px] text-slate-500 mt-1 max-w-lg">Jika aktif, seluruh tenant (desa) tidak dapat mengakses aplikasi, kecuali Superadmin. Gunakan hanya saat sedang update server.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4 mt-1">
                                <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600 shadow-inner"></div>
                            </label>
                        </div>

                        {{-- Registrasi Tenant Toggle --}}
                        <div class="flex items-start justify-between p-5 rounded-xl border border-slate-200 bg-white shadow-sm">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Izinkan Pendaftaran Desa Mandiri</h4>
                                <p class="text-[13px] text-slate-500 mt-1 max-w-lg">Jika aktif, pengunjung web pusat dapat mengisi form untuk mendaftarkan desa mereka sendiri tanpa melalui Superadmin.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0 ml-4 mt-1">
                                <input type="checkbox" name="open_tenant_registration" value="1" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-800 shadow-inner"></div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ── Footer Form (Tombol Simpan) ── --}}
                <div class="px-6 py-5 border-t border-slate-200 bg-slate-50 flex justify-end gap-3 rounded-b-xl">
                    <button type="reset" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">Batalkan</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-800 border border-transparent rounded-lg hover:bg-slate-900 shadow-sm transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Konfigurasi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection