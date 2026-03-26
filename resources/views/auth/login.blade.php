<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Informasi Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10b981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen flex items-center justify-center p-4">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-cyan-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-4000"></div>
    </div>

    <div class="relative bg-white/80 backdrop-blur-sm p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md border border-white/20">
        
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300 overflow-hidden p-2 border border-emerald-100">
                @if($desa && $desa->logo_desa && file_exists(storage_path('app/public/logo-desa/'.$desa->logo_desa)))
                    <img src="{{ asset('storage/logo-desa/'.$desa->logo_desa) }}" class="w-full h-full object-contain" alt="Logo Desa">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($desa->nama_desa ?? 'D', 0, 1) }}
                    </div>
                @endif
            </div>
        </div>

        <h2 class="text-3xl font-bold text-center mb-2 bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
            Selamat Datang
        </h2>
        <p class="text-center text-gray-500 mb-8">Silakan login ke dalam sistem</p>

        @error('login')
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start animate-shake">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ $message }}</span>
            </div>
        @enderror

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Username / Email / NIK
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" name="login" 
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 outline-none transition-all duration-300 bg-gray-50 focus:bg-white" 
                        placeholder="Masukkan Username, Email, atau NIK"
                        value="{{ old('login') }}"
                        required autofocus>
                </div>
            </div>

            <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kata Sandi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" 
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 outline-none transition-all duration-300 bg-gray-50 focus:bg-white" 
                        placeholder="••••••••"
                        required>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                    <span class="ml-2 text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
                </label>
                <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium hover:underline transition-colors">
                    Lupa password?
                </a>
            </div>

            <button type="submit" 
                class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3.5 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center group">
                <span>Masuk</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </button>

            <div class="relative flex items-center py-2">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-xs uppercase tracking-widest font-medium">Atau masuk dengan</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <a href="{{ route('login.google') }}" 
                class="w-full bg-white border-2 border-gray-100 hover:border-emerald-500 text-gray-700 font-semibold py-3 rounded-xl shadow-sm hover:shadow-md transform transition-all duration-300 flex items-center justify-center space-x-3 group">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span class="group-hover:text-emerald-600 transition-colors">Akun Google</span>
            </a>
            
            <div class="text-center mt-4">
                <p class="text-sm text-gray-500">Belum punya akun warga?</p>
                <a href="{{ route('aktivasi.index') }}" class="text-emerald-600 font-semibold hover:underline">
                    Aktivasi akun disini
                </a>
            </div>

        </form>

    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

</body>
</html>