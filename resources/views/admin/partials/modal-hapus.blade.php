{{--
PARTIAL: resources/views/admin/partials/modal-hapus.blade.php

CARA PAKAI:
@include('admin.partials.modal-hapus')

CARA TRIGGER dari tombol hapus di halaman manapun:
<button type="button" onclick="modalHapus.buka('{{ route('admin.xxx.destroy', $item->id) }}', '{{ addslashes($item->nama) }}')">
    Hapus
</button>

ATAU via Alpine dispatch (juga bisa):
<button type="button" @click="$dispatch('buka-modal-hapus', {
    action: '{{ route('admin.xxx.destroy', $item->id) }}',
    nama: '{{ addslashes($item->nama) }}'
})">Hapus</button>
--}}

<style>
    #modal-hapus-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    #modal-hapus-backdrop.mh-active {
        display: flex;
        opacity: 1;
    }
    #modal-hapus-card {
        transform: scale(0.95) translateY(10px);
        opacity: 0;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }
    #modal-hapus-backdrop.mh-active #modal-hapus-card {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
</style>

<div
    id="modal-hapus-backdrop"
    onclick="if(event.target===this) modalHapus.tutup()"
>
    <div
        id="modal-hapus-card"
        class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 dark:border-slate-700"
    >
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 dark:text-slate-100 text-base leading-tight">Konfirmasi Hapus</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
            </div>
            <button
                type="button"
                onclick="modalHapus.tutup()"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex-shrink-0"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Peringatan merah --}}
        <div class="mx-5 mt-5 p-4 bg-red-600 rounded-xl flex items-start gap-3">
            <svg class="w-5 h-5 text-white flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <div>
                <p class="text-white font-bold text-sm">Perhatian!</p>
                <p class="text-red-100 text-xs mt-0.5 leading-relaxed">
                    Penghapusan data bersifat <span class="font-bold text-white">permanen</span> dan
                    <span class="font-bold text-white">tidak dapat dikembalikan</span>.
                </p>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-5 py-5 space-y-3">
            <p class="text-sm text-gray-700 dark:text-slate-300">
                Anda akan menghapus:
                <strong id="modal-hapus-nama" class="text-gray-900 dark:text-slate-100 font-semibold"></strong>
            </p>
            <p class="text-sm text-gray-600 dark:text-slate-400">
                Apakah Anda yakin ingin menghapus data ini?
            </p>
            <div>
                <input
                    id="modal-hapus-input"
                    type="text"
                    placeholder="Ketik HAPUS untuk melanjutkan"
                    autocomplete="off"
                    oninput="modalHapus.cekInput(this.value)"
                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-slate-600 rounded-xl text-sm bg-white dark:bg-slate-900 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-500 focus:outline-none focus:border-red-400 dark:focus:border-red-500 transition-colors"
                />
                <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ketik <strong class="text-gray-600 dark:text-slate-300 mx-1">"HAPUS"</strong> (huruf kapital) untuk mengaktifkan tombol hapus
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-4 bg-gray-50 dark:bg-slate-900/60 border-t border-gray-100 dark:border-slate-700 flex items-center justify-end gap-3">
            <button
                type="button"
                onclick="modalHapus.tutup()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-gray-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 text-sm font-medium transition-all duration-200"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tutup
            </button>

            {{-- Form submit langsung, tanpa onclick di button --}}
            <form id="modal-hapus-form" method="POST" onsubmit="modalHapus.onSubmit()">
                @csrf
                @method('DELETE')
                <button
                    id="modal-hapus-btn"
                    type="submit"
                    disabled
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm
                           bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed"
                >
                    <svg id="mh-icon-trash" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <svg id="mh-icon-spin" class="w-4 h-4 animate-spin" style="display:none" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span id="mh-btn-text">Ya, Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const modalHapus = {
    buka(action, nama) {
        // Set form action & nama
        document.getElementById('modal-hapus-form').action = action;
        document.getElementById('modal-hapus-nama').textContent = nama;

        // Reset state
        const input = document.getElementById('modal-hapus-input');
        input.value = '';
        this._setDisabled(true);
        this._setLoading(false);

        // Tampilkan modal
        const backdrop = document.getElementById('modal-hapus-backdrop');
        backdrop.style.display = 'flex';
        // Double rAF agar CSS transition berjalan setelah display:flex
        requestAnimationFrame(() => requestAnimationFrame(() => {
            backdrop.classList.add('mh-active');
            setTimeout(() => input.focus(), 220);
        }));
    },

    tutup() {
        const backdrop = document.getElementById('modal-hapus-backdrop');
        backdrop.classList.remove('mh-active');
        setTimeout(() => { backdrop.style.display = 'none'; }, 210);
    },

    cekInput(val) {
        this._setDisabled(val !== 'HAPUS');
    },

    onSubmit() {
        // Ubah tampilan ke loading — form tetap submit secara native
        this._setLoading(true);
    },

    _setDisabled(disabled) {
        const btn = document.getElementById('modal-hapus-btn');
        btn.disabled = disabled;
        if (disabled) {
            btn.className = 'inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed';
        } else {
            btn.className = 'inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm hover:shadow-md bg-red-600 hover:bg-red-700 text-white cursor-pointer';
        }
    },

    _setLoading(loading) {
        document.getElementById('mh-icon-trash').style.display = loading ? 'none' : '';
        document.getElementById('mh-icon-spin').style.display  = loading ? '' : 'none';
        document.getElementById('mh-btn-text').textContent     = loading ? 'Menghapus...' : 'Ya, Hapus';
    }
};

// Support Alpine.js $dispatch
window.addEventListener('buka-modal-hapus', e => {
    modalHapus.buka(e.detail.action, e.detail.nama);
});

// ESC untuk tutup
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') modalHapus.tutup();
});
</script>