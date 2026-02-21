<aside
    :class="sidebarCollapsed ? 'collapsed' : ''"
    class="w-72 bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-700 text-white flex-shrink-0 shadow-2xl overflow-y-auto"
    x-data="{
        sidebarCollapsed: true,
        infoDesa: {{ request()->is('admin/identitas-desa*') || request()->is('admin/wilayah*') || request()->is('admin/pemerintah-desa*') || request()->is('admin/lembaga*') || request()->is('admin/status-desa*') || request()->is('admin/layanan-pelanggan*') || request()->is('admin/kerjasama*') ? 'true' : 'false' }},
        kependudukan: {{ request()->is('admin/penduduk*') || request()->is('admin/keluarga*') || request()->is('admin/rumah-tangga*') || request()->is('admin/kelompok*') || request()->is('admin/data-suplemen*') || request()->is('admin/calon-pemilih*') ? 'true' : 'false' }},
        statistik: {{ request()->is('admin/statistik*') ? 'true' : 'false' }},
        kesehatan: {{ request()->is('admin/kesehatan*') ? 'true' : 'false' }},
        kehadiran: {{ request()->is('admin/kehadiran*') ? 'true' : 'false' }},
        layananSurat: {{ request()->is('admin/layanan-surat*') ? 'true' : 'false' }},
        sekretariat: {{ request()->is('admin/sekretariat*') ? 'true' : 'false' }},
        suratDinas: {{ request()->is('admin/surat-dinas*') ? 'true' : 'false' }},
        bukuAdministrasi: {{ request()->is('admin/buku-administrasi*') ? 'true' : 'false' }},
        keuangan: {{ request()->is('admin/keuangan*') ? 'true' : 'false' }},
        pertanahan: {{ request()->is('admin/pertanahan*') ? 'true' : 'false' }},
        opendk: {{ request()->is('admin/opendk*') ? 'true' : 'false' }},
        sistem: {{ request()->is('admin/pengguna*') || request()->is('admin/role*') || request()->is('admin/pengaturan*') || request()->is('admin/backup*') || request()->is('admin/log*') ? 'true' : 'false' }}
    }"
    @mouseenter="sidebarCollapsed = false" @mouseleave="sidebarCollapsed = true">

    <div class="p-6">
        <!-- LOGO -->
        <div class="flex items-center gap-3 mb-8 pb-6 border-b border-white/10">
            <div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center text-xl font-bold shadow-lg">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold">Lumbung Data</h1>
                <p class="text-xs text-white/70">Admin Panel</p>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="space-y-1">
            {{-- Navigation items copied from original layout --}}
            {{-- ... keep the same menu markup as in the layout (omitted here for brevity) --}}
            @include('layouts._sidebar_items')
        </nav>

        <!-- Logout Button -->
        <div class="mt-8 pt-6 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 rounded-lg text-sm font-medium transition-all duration-200 backdrop-blur-sm border border-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
