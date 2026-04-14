@extends('layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div x-data="wargaNotifPage()" x-init="init()">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Notifikasi Saya</h2>
            <p class="text-sm text-gray-600 mt-0.5">Semua pesan & pembaruan status surat</p>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row items-center justify-end gap-2 mb-6">
        <button @click="confirmDeleteSelected()" x-show="selectedItems.length > 0"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus (<span x-text="selectedItems.length"></span>)
        </button>
        <button @click="markAllRead()"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Tandai Semua Dibaca
        </button>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 mb-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
            </svg>
            Filter Data
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Status</label>
                <select x-model="filters.status" @change="applyFilters()"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                    <option value="">Semua</option>
                    <option value="unread">Belum Dibaca</option>
                    <option value="read">Sudah Dibaca</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kategori</label>
                <select x-model="filters.category" @change="applyFilters()"
                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white text-gray-800 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors">
                    <option value="">Semua</option>
                    <option value="pesan">Pesan</option>
                    <option value="surat">Surat Permohonan</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div
        class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th
                            class="px-3 sm:px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">
                            <input type="checkbox" @change="toggleSelectAll($event.target.checked)"
                                <svg class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </th>
                        <th
                            class="px-3 sm:px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            NO</th>
                        <th
                            class="hidden sm:table-cell px-3 sm:px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            KATEGORI</th>
                        <th
                            class="hidden lg:table-cell px-3 sm:px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            STATUS</th>
                        <th
                            class="px-3 sm:px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            PESAN</th>
                        <th
                            class="px-3 sm:px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">

                    <template x-if="loading">
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <svg class="animate-spin h-8 w-8 text-emerald-500 mx-auto" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <p class="text-sm text-gray-500 mt-2">Memuat...</p>
                            </td>
                        </tr>
                    </template>

                    <template x-if="!loading && filteredItems.length === 0">
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                    <p class="text-gray-500 font-medium">Tidak ada notifikasi</p>
                            </td>
                        </tr>
                    </template>

                    <template x-for="(item, index) in paginatedItems" :key="item.id">
                        <tr class="hover:bg-gray-50 transition-colors"
                            :class="!item.is_read ? 'bg-emerald-50/30' : ''">
                            <td class="px-3 sm:px-5 py-4">
                                <input type="checkbox" :value="item.id" @change="toggleSelect(item.id)"
                                    :checked="selectedItems.includes(item.id)"
                                    class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </td>
                            <td class="px-3 sm:px-5 py-4 text-sm text-gray-700 font-medium"
                                x-text="(currentPage - 1) * perPage + index + 1"></td>
                            <td class="hidden sm:table-cell px-3 sm:px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium"
                                    :class="{
                                        'bg-green-100 text-green-700': item.type === 'pesan',
                                        'bg-orange-100 text-orange-700': item.type === 'surat'
                                    }"
                                    x-text="item.type === 'pesan' ? 'Pesan' : 'Surat Permohonan'">
                                </span>
                            </td>
                            <td class="hidden lg:table-cell px-3 sm:px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium"
                                    :class="item.is_read ?
                                        'bg-gray-100 text-gray-600' :
                                        'bg-red-100 text-red-700'"
                                    x-text="item.is_read ? 'Sudah dibaca' : 'Belum dibaca'">
                                </span>
                            </td>
                            <td class="px-3 sm:px-5 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800"
                                        x-text="item.title"></p>
                                    <p class="text-xs text-gray-500 truncate max-w-xs"
                                        x-text="item.message"></p>
                                    <p class="text-[10px] text-gray-400 mt-0.5"
                                        x-text="item.time"></p>
                                </div>
                            </td>
                            <td class="px-3 sm:px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    {{-- Tandai Baca --}}
                                    <button @click="markRead(item.id, item.type)" x-show="!item.is_read"
                                        title="Tandai Dibaca"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-100 transition-all duration-150 hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <button type="button" title="Hapus"
                                        @click="confirmDeleteItem(item.id, item.type)"
                                        class="w-8 h-8 inline-flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 transition-all duration-150 hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>

            {{-- Pagination --}}
            <div
                class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 px-3 sm:px-5 py-4 border-t border-gray-100 text-sm sm:text-base">
                <p class="text-xs sm:text-sm text-gray-500">
                    Menampilkan <span x-text="paginationStart"></span> sampai
                    <span x-text="paginationEnd"></span> dari
                    <span x-text="filteredItems.length"></span> entri
                </p>
                <div class="flex items-center gap-2">
                    <button @click="prevPage()" :disabled="currentPage === 1"
                        class="px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium transition-colors"
                        :class="currentPage === 1 ?
                            'bg-gray-100 text-gray-400 cursor-not-allowed' :
                            'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                        Sebelumnya
                    </button>
                    <button @click="nextPage()" :disabled="currentPage >= totalPages"
                        class="px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium transition-colors"
                        :class="currentPage >= totalPages ?
                            'bg-gray-100 text-gray-400 cursor-not-allowed' :
                            'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                        Selanjutnya
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function wargaNotifPage() {
        return {
            items: [],
            loading: true,
            selectedItems: [],
            currentPage: 1,
            perPage: 10,
            filters: {
                status: '',
                category: ''
            },

            async init() {
                await this.fetchData();
            },

            async fetchData() {
                this.loading = true;
                try {
                    const res = await fetch('/warga/notifikasi/list', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    this.items = data.items || [];
                } catch (e) {
                    console.error('Gagal memuat notifikasi:', e);
                    this.items = [];
                } finally {
                    this.loading = false;
                }
            },

            get filteredItems() {
                let result = this.items;
                if (this.filters.status === 'unread') result = result.filter(i => !i.is_read);
                else if (this.filters.status === 'read') result = result.filter(i => i.is_read);
                if (this.filters.category) result = result.filter(i => i.type === this.filters.category);
                return result;
            },

            get totalPages() {
                return Math.ceil(this.filteredItems.length / this.perPage) || 1;
            },

            get paginatedItems() {
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredItems.slice(start, start + this.perPage);
            },

            get paginationStart() {
                if (this.filteredItems.length === 0) return 0;
                return (this.currentPage - 1) * this.perPage + 1;
            },

            get paginationEnd() {
                return Math.min(this.currentPage * this.perPage, this.filteredItems.length);
            },

            applyFilters() { this.currentPage = 1; },

            toggleSelectAll(checked) {
                this.selectedItems = checked ? this.paginatedItems.map(i => i.id) : [];
            },

            toggleSelect(id) {
                if (this.selectedItems.includes(id)) {
                    this.selectedItems = this.selectedItems.filter(i => i !== id);
                } else {
                    this.selectedItems.push(id);
                }
            },

            prevPage() { if (this.currentPage > 1) this.currentPage--; },
            nextPage() { if (this.currentPage < this.totalPages) this.currentPage++; },

            async markRead(id, type) {
                try {
                    const res = await fetch('/warga/notifikasi/baca-satu', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({ id, tipe: type })
                    });
                    if (res.ok) {
                        const item = this.items.find(i => i.id === id);
                        if (item) item.is_read = true;
                        this._updateBadge();
                    }
                } catch (e) {
                    console.error('Gagal tandai dibaca:', e);
                }
            },

            async markAllRead() {
                try {
                    const res = await fetch('/warga/notifikasi/tandai-semua', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        }
                    });
                    if (res.ok) {
                        this.items = this.items.map(item => ({ ...item, is_read: true }));
                        this._updateBadge();
                    }
                } catch (e) {
                    console.error('Gagal tandai semua:', e);
                }
            },

            confirmDeleteItem(id, type) {
                if (confirm('Hapus notifikasi ini?')) {
                    this.deleteItem(id, type);
                }
            },

            async deleteItem(id, type) {
                try {
                    const res = await fetch('/warga/notifikasi/hapus-satu', {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({ id, tipe: type })
                    });
                    if (res.ok) {
                        this.items = this.items.filter(i => i.id !== id);
                        this._updateBadge();
                    }
                } catch (e) {
                    console.error('Gagal hapus:', e);
                }
            },

            confirmDeleteSelected() {
                const count = this.selectedItems.length;
                if (count === 0) return;
                if (confirm(`Hapus ${count} notifikasi yang dipilih?`)) {
                    this._doDeleteSelected();
                }
            },

            async _doDeleteSelected() {
                try {
                    const res = await fetch('/warga/notifikasi/hapus-banyak', {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({ ids: this.selectedItems })
                    });
                    if (res.ok) {
                        this.items = this.items.filter(i => !this.selectedItems.includes(i.id));
                        this.selectedItems = [];
                        this._updateBadge();
                    }
                } catch (e) {
                    console.error('Gagal hapus:', e);
                }
            },

            _updateBadge() {
                const unreadCount = this.items.filter(i => !i.is_read).length;
                window.dispatchEvent(new CustomEvent('warga-notif-badge-changed', {
                    detail: { total: unreadCount }
                }));
            }
        };
    }
</script>
@endpush
