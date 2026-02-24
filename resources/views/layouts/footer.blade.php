@php
    // Ambil data identitas desa langsung di view agar dinamis di semua halaman
    $identitas_footer = \App\Models\IdentitasDesa::first();
@endphp

<footer class="bg-emerald-900 text-slate-200 border-t-4 border-emerald-500 font-sans mt-20 relative overflow-hidden">
    
    <div class="absolute inset-0 opacity-5 pattern-grid-lg pointer-events-none mix-blend-overlay" 
         style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
            
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    @if($identitas_footer && $identitas_footer->logo_desa && file_exists(storage_path('app/public/logo-desa/'.$identitas_footer->logo_desa)))
                        <img src="{{ asset('storage/logo-desa/'.$identitas_footer->logo_desa) }}" alt="Logo" class="h-12 w-12 object-contain drop-shadow-lg bg-white/10 rounded-lg p-1">
                    @else
                        <div class="h-12 w-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight leading-none">
                            {{ $identitas_footer->nama_desa ?? config('app.name', 'Pemerintah Desa') }}
                        </h3>
                        <span class="text-xs text-emerald-400 font-bold uppercase tracking-widest">
                            Kec. {{ $identitas_footer->kecamatan ?? 'Kecamatan' }}
                        </span>
                    </div>
                </div>
                
                <p class="text-slate-300 text-base leading-relaxed font-medium">
                    Website resmi Pemerintah Desa yang berkomitmen melayani masyarakat dengan transparansi, akuntabilitas, dan inovasi digital.
                </p>

                <div class="flex items-center gap-4 pt-2">
                    <a href="#" class="group w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-blue-600 hover:border-blue-500 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="group w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-pink-600 hover:border-pink-500 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.665-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="group w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white hover:bg-red-600 hover:border-red-500 transition-all duration-300 hover:-translate-y-1 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-bold text-white mb-6">Jelajahi</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Beranda Utama
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profil') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Profil Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pemerintahan') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Struktur Pemerintahan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data-desa') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Data & Statistik
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('artikel') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Berita & Artikel
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold text-white mb-6">Layanan Publik</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Layanan Surat Online
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kontak') }}" class="flex items-center gap-2 text-slate-300 hover:text-emerald-400 hover:translate-x-1 transition-all duration-300 group">
                            <svg class="w-4 h-4 text-white group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Pengaduan Masyarakat
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-bold text-white mb-6">Hubungi Kami</h4>
                <ul class="space-y-4">
                    
                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-900 flex items-center justify-center text-white border border-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs text-emerald-400 font-bold uppercase tracking-wider mb-1">Alamat Kantor</span>
                            <span class="text-sm text-slate-300 leading-snug block">
                                {{ $identitas_footer->alamat_kantor ?? 'Alamat belum diatur' }}
                            </span>
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-900 flex items-center justify-center text-white border border-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs text-emerald-400 font-bold uppercase tracking-wider mb-1">Email Resmi</span>
                            <a href="mailto:{{ $identitas_footer->email_desa ?? '#' }}" class="text-sm text-slate-300 hover:text-white transition block break-all">
                                {{ $identitas_footer->email_desa ?? 'Belum diatur' }}
                            </a>
                        </div>
                    </li>

                    <li class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-900 flex items-center justify-center text-white border border-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-xs text-emerald-400 font-bold uppercase tracking-wider mb-1">Telepon</span>
                            <div class="flex flex-col">
                                <span class="text-sm text-slate-300">{{ $identitas_footer->telepon_desa ?? '-' }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-emerald-800 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} 
                    <span class="text-white font-bold">{{ $identitas_footer->nama_desa ?? config('app.name') }}</span>. 
                    Hak Cipta Dilindungi Undang-Undang.
                </p>
                
                <div class="flex flex-wrap justify-center gap-6 text-sm text-slate-400">
                    <a href="{{ route('kebijakan-privasi') }}" class="hover:text-white transition">Kebijakan Privasi</a>
                    <a href="{{ Route::has('syarat-ketentuan') ? route('syarat-ketentuan') : '#' }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="{{ route('faq') }}" class="hover:text-emerald-400 transition">Pertanyaan Umum (FAQ)</a>
                    <a href="{{ Route::has('peta-situs') ? route('peta-situs') : '#' }}" class="hover:text-white transition">Peta Situs</a>
                </div>
            </div>
        </div>
    </div>
</footer>