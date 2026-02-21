@extends('layouts.app')

@section('title', 'Hubungi Kami')
@section('description', 'Informasi kontak dan layanan pengaduan Desa Serayu Larangan')

@section('content')

<x-hero-section 
    title="Layanan & Kontak"
    subtitle="Kami siap melayani aspirasi dan pertanyaan Anda dengan sepenuh hati."
    :breadcrumb="[
        ['label' => 'Beranda', 'url' => route('home')],
        ['label' => 'Kontak', 'url' => '#']
    ]"
/>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
            
            <div class="lg:w-5/12 space-y-10">
                
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi Kontak</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Kunjungi kantor kami atau hubungi melalui saluran resmi di bawah ini untuk mendapatkan pelayanan yang Anda butuhkan.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Alamat Kantor</h4>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $infoKontak['alamat'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Kontak Resmi</h4>
                            <div class="space-y-1">
                                <a href="tel:{{ $infoKontak['telepon'] }}" class="block text-emerald-600 font-medium hover:underline">{{ $infoKontak['telepon'] }}</a>
                                <a href="mailto:{{ $infoKontak['email'] }}" class="block text-emerald-600 font-medium hover:underline">{{ $infoKontak['email'] }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Jam Pelayanan</h4>
                            <p class="text-gray-600 text-sm mb-1">{{ $infoKontak['jam_operasional'] }}</p>
                            <span class="inline-block text-xs font-semibold text-amber-600 bg-amber-100 px-2 py-0.5 rounded">Minggu Tutup</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-100 rounded-3xl overflow-hidden h-64 border border-gray-200 shadow-inner">
                    <iframe 
                        src="{{ $infoKontak['link_peta'] }}" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        class="grayscale hover:grayscale-0 transition duration-500">
                    </iframe>
                </div>

            </div>

            <div class="lg:w-7/12 order-1 lg:order-2">
                <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-xl border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Kirim Pesan / Pengaduan</h3>
                        <p class="text-gray-500 mb-8">Formulir ini terhubung langsung dengan sistem pelayanan desa.</p>

                        @if(session('success'))
                            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-700 flex items-center gap-3 animate-fade-in">
                                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('kontak.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="nama" class="text-sm font-bold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" id="nama" name="nama" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition duration-200" placeholder="Nama Anda" value="{{ old('nama') }}" required>
                                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="text-sm font-bold text-gray-700">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition duration-200" placeholder="email@anda.com" value="{{ old('email') }}" required>
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="subjek" class="text-sm font-bold text-gray-700">Subjek <span class="text-red-500">*</span></label>
                                <input type="text" id="subjek" name="subjek" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition duration-200" placeholder="Perihal pesan" value="{{ old('subjek') }}" required>
                                @error('subjek') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="pesan" class="text-sm font-bold text-gray-700">Isi Pesan <span class="text-red-500">*</span></label>
                                <textarea id="pesan" name="pesan" rows="5" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none transition duration-200 resize-none" placeholder="Tuliskan pesan atau pengaduan Anda secara detail..." required>{{ old('pesan') }}</textarea>
                                @error('pesan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="w-full px-8 py-4 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition transform active:scale-95 shadow-lg shadow-emerald-200 flex justify-center items-center gap-2 group">
                                <span>Kirim Pesan</span>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection