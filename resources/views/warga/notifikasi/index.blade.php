@extends('layouts.app') {{-- sesuaikan dengan layout warga Anda --}}

@section('title', 'Notifikasi Saya')

@section('content')

<div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        {{-- ── Header ── --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Notifikasi Saya</h1>
                <p class="text-sm text-slate-500 mt-0.5">Semua pesan & pembaruan status surat Anda</p>
            </div>
            {{-- Tombol Tandai Semua --}}
            <button
                id="btn-tandai-semua"
                onclick="tandaiSemuaDibaca()"
                class="hidden items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tandai Semua Dibaca
            </button>
        </div>

        {{-- ── Filter Bar ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-4 py-3 mb-4 flex flex-wrap items-center gap-3">

            {{-- Filter Status --}}
            <div class="flex items-center gap-1 bg-slate-100 rounded-xl p-1">
                <button onclick="setFilter('semua')" id="filter-semua"
                    class="filter-btn active px-3 py-1.5 text-xs font-semibold rounded-lg transition-all">
                    Semua
                </button>
                <button onclick="setFilter('belum')" id="filter-belum"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg transition-all text-slate-500">
                    Belum Dibaca
                </button>
                <button onclick="setFilter('sudah')" id="filter-sudah"
                    class="filter-btn px-3 py-1.5 text-xs font-semibold rounded-lg transition-all text-slate-500">
                    Sudah Dibaca
                </button>
            </div>

            {{-- Filter Kategori --}}
            <select id="filter-tipe" onchange="renderList()"
                class="text-xs font-medium text-slate-600 bg-slate-100 border-0 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-400 outline-none cursor-pointer">
                <option value="semua">Semua Kategori</option>
                <option value="pesan">Pesan Masuk</option>
                <option value="surat">Update Surat</option>
            </select>

            {{-- Spacer + Jumlah --}}
            <div class="ml-auto">
                <span id="notif-count" class="text-xs text-slate-400 font-medium"></span>
            </div>
        </div>

        {{-- ── List Notifikasi ── --}}
        <div id="notif-list" class="space-y-2">
            {{-- Loading skeleton --}}
            <div id="skeleton" class="space-y-2">
                @for($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-2xl border border-slate-100 px-4 py-4 animate-pulse flex gap-3">
                    <div class="w-10 h-10 bg-slate-200 rounded-full flex-shrink-0"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 bg-slate-200 rounded w-1/3"></div>
                        <div class="h-3 bg-slate-200 rounded w-2/3"></div>
                        <div class="h-2.5 bg-slate-100 rounded w-1/4"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- ── Empty state ── --}}
        <div id="empty-state" class="hidden text-center py-16">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <p class="text-slate-500 font-medium">Tidak ada notifikasi</p>
            <p class="text-slate-400 text-sm mt-1">Notifikasi akan muncul di sini</p>
        </div>

    </div>
</div>

<style>
    .filter-btn.active {
        background: #fff;
        color: #059669;
        font-weight: 700;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    /* Card notifikasi */
    .notif-card {
        background: #fff;
        border-radius: 1rem;
        border: 1px solid #f1f5f9;
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        transition: box-shadow 0.15s, background 0.15s;
        position: relative;
    }
    .notif-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.07);
    }
    .notif-card.unread {
        background: #f0fdf9;
        border-color: #d1fae5;
    }
    .notif-card.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #10b981;
        border-radius: 3px 0 0 3px;
    }

    /* Icon wrapper */
    .notif-icon {
        width: 40px;
        height: 40px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Tombol aksi kanan */
    .notif-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
        margin-left: auto;
    }
    .btn-check {
        width: 30px;
        height: 30px;
        border-radius: 9999px;
        border: 1.5px solid #d1d5db;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        flex-shrink: 0;
    }
    .btn-check:hover {
        border-color: #10b981;
        background: #ecfdf5;
    }
    .btn-check svg { width: 13px; height: 13px; stroke: #9ca3af; transition: stroke 0.15s; }
    .btn-check:hover svg { stroke: #10b981; }

    .btn-hapus {
        width: 30px;
        height: 30px;
        border-radius: 9999px;
        border: 1.5px solid #fecaca;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        flex-shrink: 0;
    }
    .btn-hapus:hover { border-color: #ef4444; background: #fef2f2; }
    .btn-hapus svg { width: 13px; height: 13px; stroke: #fca5a5; transition: stroke 0.15s; }
    .btn-hapus:hover svg { stroke: #ef4444; }

    /* Badge tipe */
    .badge-tipe {
        display: inline-flex;
        align-items: center;
        padding: 1px 8px;
        border-radius: 9999px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    /* Animasi hapus */
    @keyframes card-remove {
        0%   { opacity: 1; transform: translateX(0); max-height: 120px; }
        100% { opacity: 0; transform: translateX(20px); max-height: 0; padding: 0; margin: 0; overflow: hidden; }
    }
    .notif-card.removing {
        animation: card-remove 0.3s ease-out forwards;
        pointer-events: none;
    }
</style>

<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    let allItems   = [];
    let filterStatus = 'semua';

    // ── Fetch data dari endpoint yang sudah ada ───────────────────────
    async function fetchNotifikasi() {
        try {
            const res = await fetch('/warga/notifikasi/list', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();
            allItems = data.items ?? [];
        } catch (e) {
            allItems = [];
        }
    }

    // ── Set filter status ─────────────────────────────────────────────
    function setFilter(val) {
        filterStatus = val;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active', 'text-slate-500'));
        const active = document.getElementById('filter-' + val);
        if (active) active.classList.add('active');
        // Non-active
        document.querySelectorAll('.filter-btn:not(.active)').forEach(b => b.classList.add('text-slate-500'));
        renderList();
    }

    // ── Render list ───────────────────────────────────────────────────
    function renderList() {
        const tipe = document.getElementById('filter-tipe').value;

        let items = [...allItems];

        // Filter status
        if (filterStatus === 'belum') items = items.filter(i => !i.dibaca);
        if (filterStatus === 'sudah') items = items.filter(i => i.dibaca);

        // Filter tipe/kategori
        if (tipe === 'pesan')  items = items.filter(i => i.tipe === 'pesan');
        if (tipe === 'surat')  items = items.filter(i => i.tipe !== 'pesan');

        // Update count
        const unread = allItems.filter(i => !i.dibaca).length;
        const countEl = document.getElementById('notif-count');
        countEl.textContent = items.length + ' notifikasi' + (unread > 0 ? ' · ' + unread + ' belum dibaca' : '');

        // Tombol tandai semua
        const btnTandai = document.getElementById('btn-tandai-semua');
        if (unread > 0) btnTandai.classList.replace('hidden', 'flex');
        else btnTandai.classList.replace('flex', 'hidden');

        const container = document.getElementById('notif-list');
        const skeleton  = document.getElementById('skeleton');
        const empty     = document.getElementById('empty-state');

        skeleton.classList.add('hidden');

        if (items.length === 0) {
            container.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        container.innerHTML = items.map(item => cardHTML(item)).join('');
    }

    // ── HTML satu card ────────────────────────────────────────────────
    function cardHTML(item) {
        const iconBg = {
            pesan:   'bg-purple-100',
            success: 'bg-emerald-100',
            danger:  'bg-red-100',
            info:    'bg-blue-100',
        }[item.tipe] ?? 'bg-slate-100';

        const iconSVG = {
            pesan: `<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>`,
            success: `<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            danger: `<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            info: `<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        }[item.tipe] ?? '';

        const badgeColor = {
            pesan:   'bg-purple-50 text-purple-700',
            success: 'bg-emerald-50 text-emerald-700',
            danger:  'bg-red-50 text-red-600',
            info:    'bg-blue-50 text-blue-700',
        }[item.tipe] ?? 'bg-slate-100 text-slate-600';

        const badgeLabel = {
            pesan:   'Pesan Masuk',
            success: 'Surat Selesai',
            danger:  'Surat Ditolak',
            info:    'Update Surat',
        }[item.tipe] ?? item.tipe;

        const unreadClass = !item.dibaca ? 'unread' : '';

        const btnCentang = !item.dibaca ? `
            <button class="btn-check" onclick="tandaiSatu('${item.id}', '${item.tipe}', this)" title="Tandai dibaca">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </button>` : `
            <span class="text-[10px] text-slate-400 font-medium px-2">Dibaca</span>`;

        return `
        <div class="notif-card ${unreadClass}" data-id="${item.id}">
            <div class="notif-icon ${iconBg}">${iconSVG}</div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                    <span class="text-sm font-semibold text-slate-800">${escHtml(item.judul)}</span>
                    <span class="badge-tipe ${badgeColor}">${badgeLabel}</span>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed">${escHtml(item.pesan)}</p>
                <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    ${escHtml(item.waktu)}
                </p>
            </div>
            <div class="notif-actions">
                ${btnCentang}
                <button class="btn-hapus" onclick="hapusSatu('${item.id}', '${item.tipe}', this)" title="Hapus notifikasi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>`;
    }

    // ── Escape HTML helper ────────────────────────────────────────────
    function escHtml(str) {
        return String(str ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    }

    // ── Tandai SATU dibaca ────────────────────────────────────────────
    async function tandaiSatu(id, tipe, btn) {
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>`;

        try {
            await fetch('/warga/notifikasi/baca-satu', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify({ id, tipe })
            });

            // Update state lokal
            const item = allItems.find(i => i.id === id);
            if (item) item.dibaca = true;
            renderList();

        } catch (e) {
            btn.disabled = false;
        }
    }

    // ── Hapus SATU notifikasi ────────────────────────────────────────
    async function hapusSatu(id, tipe, btn) {
        const card = btn.closest('.notif-card');

        // Animasi hilang dulu
        card.classList.add('removing');

        try {
            await fetch('/warga/notifikasi/hapus-satu', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF,
                },
                body: JSON.stringify({ id, tipe })
            });

            // Hapus dari state lokal setelah animasi selesai
            setTimeout(() => {
                allItems = allItems.filter(i => i.id !== id);
                renderList();
            }, 300);

        } catch (e) {
            card.classList.remove('removing');
        }
    }

    // ── Tandai SEMUA dibaca ───────────────────────────────────────────
    async function tandaiSemuaDibaca() {
        const btn = document.getElementById('btn-tandai-semua');
        btn.disabled = true;
        btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Memproses...`;

        try {
            await fetch('/warga/notifikasi/surat-dibaca', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': CSRF,
                }
            });

            allItems = allItems.map(i => ({ ...i, dibaca: true }));
            renderList();

        } catch (e) {
            btn.disabled = false;
        }
    }

    // ── Init ──────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', async () => {
        await fetchNotifikasi();
        renderList();
    });
</script>

@endsection