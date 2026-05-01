{{-- MODAL PERINGATAN GANTI PIN (wajib, tidak bisa di-skip) --}}
{{-- Letakkan di layout utama, setelah @include('partials.navbar') --}}

@auth
    @if (Auth::user()->role == 'warga' && session('show_pin_warning', false) && !request()->routeIs('warga.ganti-pin'))

        {{-- Overlay penuh, tidak bisa diklik untuk tutup --}}
        <div id="pin-warning-overlay"
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
            style="background: rgba(0,0,0,0.5);">

            <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Ganti PIN default Anda</p>
                        <p class="text-xs text-slate-400">Wajib sebelum melanjutkan</p>
                    </div>
                </div>

                {{-- Body --}}
                <div class="px-5 py-4">
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Anda masih menggunakan <span class="font-semibold text-slate-700">PIN default</span>
                        dari operator desa. Ganti PIN terlebih dahulu sebelum menggunakan layanan mandiri.
                    </p>
                </div>

                {{-- Footer — hanya satu tombol, wajib ganti --}}
                <div class="px-5 pb-5">
                    <a href="{{ route('warga.ganti-pin') }}"
                        class="block w-full px-4 py-2.5 text-sm font-semibold text-white text-center
                               bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                        Ganti PIN sekarang
                    </a>
                </div>

            </div>
        </div>

    @endif
@endauth