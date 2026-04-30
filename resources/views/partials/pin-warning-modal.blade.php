{{-- ============================================================ --}}
{{-- MODAL PERINGATAN GANTI PIN (tampil sekali setelah login)    --}}
{{-- Letakkan di layout utama, setelah @include('partials.navbar') --}}
{{-- ============================================================ --}}

@auth
    @if (Auth::user()->role == 'warga')
        @php
            /**
             * Kondisi tampil modal:
             *  1. Session flash 'show_pin_warning' di-set oleh LoginController setelah login berhasil
             *     ATAU kolom `pin_default` di tabel users bernilai true / kolom `pin_changed_at` null.
             *
             * Sesuaikan kondisi di bawah dengan struktur database Anda.
             * Contoh menggunakan session flash (direkomendasikan):
             */
            $showPinWarning = session('show_pin_warning', false);

            /**
             * Alternatif: cek kolom di tabel users
             * $showPinWarning = !Auth::user()->pin_changed_at;
             */
        @endphp

        @if ($showPinWarning)
            {{-- ── Overlay ── --}}
            <div id="pin-warning-overlay"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                style="background: rgba(0,0,0,0.55); backdrop-filter: blur(4px);">

                <div id="pin-warning-modal"
                    class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden
                           animate-[fadeScaleIn_0.35s_ease-out_forwards]">

                    {{-- ── Header hijau ── --}}
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-8 pt-10 pb-8 text-center relative">
                        {{-- Ikon peringatan --}}
                        <div class="mx-auto mb-4 w-20 h-20 bg-white/20 rounded-full flex items-center justify-center
                                    ring-4 ring-white/30 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m0 0v2m0-2h2m-2 0H10m2-9V4m0 0a2 2 0 10-4 0 2 2 0 004 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">Keamanan Akun</h2>
                        <p class="mt-1 text-emerald-100 text-sm">Harap perhatikan informasi berikut</p>
                    </div>

                    {{-- ── Body ── --}}
                    <div class="px-8 py-7 text-center space-y-4">
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">
                            <div class="flex items-start gap-3 text-left">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                </svg>
                                <p class="text-sm text-amber-800 leading-relaxed">
                                    Anda masih menggunakan <strong>PIN default</strong> yang diberikan oleh
                                    operator desa. Segera ganti PIN Anda untuk menjaga keamanan akun.
                                </p>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500">
                            Pilih <span class="font-semibold text-emerald-600">Ganti PIN Sekarang</span> untuk
                            langsung mengganti, atau <span class="font-semibold">Nanti</span> jika ingin
                            mengganti di lain waktu.
                        </p>
                    </div>

                    {{-- ── Footer Tombol ── --}}
                    <div class="px-8 pb-8 flex flex-col gap-3">
                        <a href="{{ route('warga.ganti-pin') }}"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5
                                   bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm
                                   rounded-2xl shadow-lg shadow-emerald-600/25 transition-all duration-200
                                   hover:shadow-emerald-600/40 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Ganti PIN Sekarang
                        </a>
                        <button onclick="closePinWarning()"
                            class="w-full px-6 py-3 border border-slate-200 text-slate-500 text-sm font-medium
                                   rounded-2xl hover:bg-slate-50 hover:text-slate-700 transition-all duration-200">
                            Nanti Saja
                        </button>
                    </div>
                </div>
            </div>

            <style>
                @keyframes fadeScaleIn {
                    from { opacity: 0; transform: scale(0.9) translateY(16px); }
                    to   { opacity: 1; transform: scale(1)   translateY(0); }
                }
            </style>

            <script>
                function closePinWarning() {
                    const overlay = document.getElementById('pin-warning-overlay');
                    if (overlay) {
                        overlay.style.opacity = '0';
                        overlay.style.transition = 'opacity 0.25s ease';
                        setTimeout(() => overlay.remove(), 250);
                    }
                }
            </script>
        @endif
    @endif
@endauth