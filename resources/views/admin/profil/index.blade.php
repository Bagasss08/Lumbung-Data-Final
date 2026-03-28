@extends('layouts.admin')

@section('title', 'Profil Pengguna')

@section('content')

    @php
        $user = Auth::user();
        $initials = strtoupper(substr($user->name ?? 'Ad', 0, 2));
        $roleName = 'Administrator';
        if (method_exists($user, 'getRoleNames')) {
            $roleName = $user->getRoleNames()->first() ?? 'Administrator';
        } elseif (!empty($user->role)) {
            $roleName = $user->role;
        }
        
        $hasPasswordErrors = $errors->has('otp') || $errors->has('new_password');
    @endphp

    <div class="flex flex-col md:flex-row gap-6" x-data="{ activeTab: '{{ $hasPasswordErrors ? 'sandi' : 'profil' }}' }">

        {{-- Sidebar Foto --}}
        <div class="md:w-60 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 px-5 py-8 flex flex-col items-center text-center">
                    @if (!empty($user->foto))
                        <img src="{{ asset('storage/' . $user->foto) }}" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-white/30 shadow-xl" alt="{{ $user->name }}">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-2xl ring-4 ring-white/30 shadow-xl">
                            {{ $initials }}
                        </div>
                    @endif
                    <p class="mt-3 font-bold text-white text-sm">{{ $user->name ?? 'Pengguna' }}</p>
                    <p class="text-white/60 text-xs mt-0.5">{{ $user->email ?? '-' }}</p>
                    <span class="mt-2 px-2.5 py-0.5 bg-white/20 text-white text-xs font-medium rounded-full">{{ $roleName }}</span>
                </div>

                <div class="p-4">
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="username" value="{{ $user->username ?? '' }}">

                        <label class="block text-xs font-semibold text-gray-600 mb-2">Ganti Foto</label>
                        <input type="file" name="foto" id="inputFoto" accept="image/jpeg,image/png,image/gif"
                            class="w-full text-xs text-gray-500 border border-gray-200 rounded-xl p-2 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer"
                            onchange="document.getElementById('btnSimpanFoto').style.display='block'">
                        <p class="text-xs text-gray-400 mt-1.5">JPG, PNG, GIF · Maks. 2MB</p>
                        <button type="submit" id="btnSimpanFoto" style="display:none" class="mt-2 w-full py-2 bg-gradient-to-br from-emerald-500 to-teal-600 text-white text-xs font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-500/25 transition-all">
                            Simpan Foto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="flex-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Tabs --}}
                <div class="flex gap-1 p-1 bg-gray-50 border-b border-gray-100">
                    <button @click="activeTab = 'profil'" :class="activeTab === 'profil' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-white'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Profil
                    </button>
                    <button @click="activeTab = 'sandi'" :class="activeTab === 'sandi' ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-white'" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> Ubah Password
                    </button>
                </div>

                {{-- Tab: Profil --}}
                <div x-show="activeTab === 'profil'">
                    <div class="px-6 py-4 border-b border-gray-50">
                        <h3 class="font-semibold text-gray-700">Informasi Akun</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Perbarui data profil Anda</p>
                    </div>
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all">
                            @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <a href="/admin/dashboard" class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Batal</a>
                            <button type="submit" class="px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-emerald-500/25 transition-all">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Ubah Password dengan OTP REAL-TIME --}}
                <div x-show="activeTab === 'sandi'" style="display:none" 
                     x-data="{ 
                        showNew: false, 
                        showConfirm: false,
                        pwdStep: {{ $hasPasswordErrors ? 2 : 1 }},
                        otpLoading: false,
                        isVerifying: false,
                        otpVerified: false, 
                        countdown: 0,
                        message: '',
                        messageType: '',
                        otpInput: '{{ old('otp') ?? '' }}',
                        
                        sendOtp() {
                            if(this.countdown > 0) return;
                            this.otpLoading = true;
                            this.message = '';
                            
                            fetch('{{ route('admin.profil.send-otp') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                this.otpLoading = false;
                                if(data.success) {
                                    this.message = data.message || 'OTP terkirim ke email Anda.';
                                    this.messageType = 'success';
                                    this.pwdStep = 2;
                                    this.startCountdown();
                                } else {
                                    this.message = data.message || 'Gagal mengirim OTP.';
                                    this.messageType = 'error';
                                }
                            }).catch(() => {
                                this.otpLoading = false;
                                this.message = 'Error jaringan saat mengirim OTP.';
                                this.messageType = 'error';
                            });
                        },
                        
                        // FUNGSI BARU: NGECEK OTP KE DATABASE
                        checkOtp() {
                            if(this.otpInput.length !== 6) return;
                            
                            this.isVerifying = true;
                            this.message = 'Mengecek kode OTP...';
                            this.messageType = 'info';
                            
                            fetch('{{ route('admin.profil.verify-otp') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ otp: this.otpInput })
                            })
                            .then(res => res.json())
                            .then(data => {
                                this.isVerifying = false;
                                if(data.success) {
                                    this.otpVerified = true;
                                    this.message = '✅ OTP Cocok! Silakan masukkan password baru Anda.';
                                    this.messageType = 'success';
                                } else {
                                    this.otpVerified = false;
                                    this.message = '🚨 ' + data.message; // Munculkan pesan salah dari database
                                    this.messageType = 'error';
                                }
                            }).catch(() => {
                                this.isVerifying = false;
                                this.message = 'Error jaringan saat mengecek OTP.';
                                this.messageType = 'error';
                            });
                        },

                        startCountdown() {
                            this.countdown = 60;
                            let timer = setInterval(() => {
                                this.countdown--;
                                if(this.countdown <= 0) clearInterval(timer);
                            }, 1000);
                        }
                     }">
                    
                    <div class="px-6 py-4 border-b border-gray-50">
                        <h3 class="font-semibold text-gray-700">Ubah Password</h3>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="pwdStep === 1 ? 'Langkah 1: Verifikasi Keamanan' : 'Langkah 2: Perbarui Password'"></p>
                    </div>

                    <div class="p-6">
                        {{-- Alert Messages --}}
                        <div x-show="message" x-transition 
                             :class="{
                                'bg-emerald-50 text-emerald-700 border-emerald-200': messageType === 'success',
                                'bg-red-50 text-red-700 border-red-200': messageType === 'error',
                                'bg-blue-50 text-blue-700 border-blue-200': messageType === 'info'
                             }"
                             class="p-3 mb-4 rounded-xl text-sm border flex items-start gap-2" style="display: none;">
                            <span x-text="message"></span>
                        </div>

                        {{-- STEP 1: Tombol Kirim OTP --}}
                        <div x-show="pwdStep === 1" class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 mb-4 ring-4 ring-emerald-50/50">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800 mb-2">Verifikasi Identitas Anda</h4>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Untuk alasan keamanan, kami perlu mengirimkan kode OTP ke email Anda (<strong>{{ $user->email }}</strong>).</p>
                            <button type="button" @click="sendOtp()" :disabled="otpLoading" class="px-6 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-emerald-500/25 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!otpLoading">Kirim Kode OTP</span>
                                <span x-show="otpLoading">Memproses...</span>
                            </button>
                        </div>

                        {{-- STEP 2: Form Password --}}
                        <form x-show="pwdStep === 2" action="{{ route('admin.profil.password') }}" method="POST" class="space-y-4" style="display: none;">
                            @csrf
                            @method('PUT')

                            {{-- Input OTP (Otomatis ngecek saat diketik 6 angka) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kode OTP <span class="text-red-500">*</span></label>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="text" name="otp" x-model="otpInput" 
                                        @keyup="checkOtp()" {{-- Memicu pengecekan database setiap ngetik --}}
                                        :readonly="otpVerified" {{-- Kunci input kalau udah valid --}}
                                        :class="otpVerified ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-white border-gray-200 focus:ring-emerald-500'"
                                        class="flex-1 border rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:border-transparent outline-none tracking-widest uppercase transition-colors"
                                        placeholder="Masukkan 6 digit OTP" maxlength="6" required>
                                    
                                    <button type="button" @click="sendOtp()" :disabled="countdown > 0 || otpLoading || otpVerified"
                                        class="shrink-0 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed min-w-[140px]">
                                        <span x-show="!otpLoading && countdown === 0">Kirim Ulang</span>
                                        <span x-show="otpLoading">Mengirim...</span>
                                        <span x-show="countdown > 0" x-text="`Tunggu ${countdown}s`" style="display:none"></span>
                                    </button>
                                </div>
                                @error('otp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <hr class="border-gray-100 my-4">
                            
                            {{-- Peringatan Kunci form --}}
                            <p x-show="!otpVerified" class="text-xs font-medium text-amber-600 bg-amber-50 p-2.5 rounded-lg border border-amber-100 transition-all">
                                🔒 Form terkunci. Silakan masukkan OTP yang benar untuk membuka form password.
                            </p>

                            {{-- Form Password Baru (Disable kalau otpVerified = false) --}}
                            <div x-show="otpVerified" x-transition>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input :type="showNew ? 'text' : 'password'" name="new_password"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all"
                                            placeholder="Minimal 8 karakter" required>
                                        <button type="button" @click="showNew = !showNew" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg x-show="!showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            <svg x-show="showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                        </button>
                                    </div>
                                    @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-10 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all"
                                            placeholder="Ulangi password baru" required>
                                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                        </button>
                                    </div>
                                    @error('new_password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-gray-100 mt-4">
                                <button type="button" @click="pwdStep = 1" class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                                    Kembali
                                </button>
                                <button type="submit" 
                                    x-show="otpVerified"
                                    class="px-5 py-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-emerald-500/25 transition-all">
                                    Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection