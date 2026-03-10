@extends('superadmin.layout.superadmin')

@section('title', 'Live Chat')
@section('header', 'Live Chat Support')

@section('content')

{{-- BUBBLE FIX: Kita olah data user di blok PHP biasa agar aman dari Parse Error --}}
@php
    $userList = $admins->map(function($a) {
        return [
            'id' => $a->id,
            'name' => $a->name,
            'role' => strtoupper($a->role),
            'unread' => $a->unread
        ];
    })->values()->toArray();
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden flex h-[calc(100vh-140px)]" x-data="liveChatApp()">
    
    <div class="w-1/3 border-r border-gray-100 flex flex-col bg-gray-50/30">
        <div class="p-4 border-b border-gray-100 bg-white">
            <h3 class="font-bold text-gray-800 text-sm">Daftar Admin</h3>
            <div class="mt-3 relative">
                <input type="text" x-model="searchQuery" placeholder="Cari admin..." class="w-full bg-gray-50 border border-gray-200 text-[13px] rounded-xl pl-10 pr-4 py-2 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto divide-y divide-gray-50">
            <template x-for="user in filteredUsers" :key="user.id">
                <div @click="selectUser(user.id, user.name, user.role)" 
                     class="flex items-center justify-between p-4 cursor-pointer transition-colors hover:bg-emerald-50"
                     :class="activeUser === user.id ? 'bg-emerald-50 border-l-4 border-emerald-500' : 'border-l-4 border-transparent'">
                    
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                            <span x-text="user.name.charAt(0).toUpperCase()"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-[13px] text-gray-800 truncate" x-text="user.name"></h4>
                            <p class="text-[11px] text-emerald-600 font-medium" x-text="user.role"></p>
                        </div>
                    </div>

                    <div x-show="user.unread > 0" class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0 ml-2 shadow-sm animate-bounce">
                        <span class="text-[10px] font-bold text-white" x-text="user.unread > 99 ? '99+' : user.unread"></span>
                    </div>

                </div>
            </template>
        </div>
    </div>

    <div class="flex-1 flex flex-col bg-[#f0f4f1] relative">
        <div x-show="!activeUser" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-10">
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700">Pilih kontak untuk mulai chat</h3>
            <p class="text-sm text-gray-400 mt-1">Pesan dari Admin akan memiliki notifikasi hijau.</p>
        </div>

        <template x-if="activeUser">
            <div class="flex flex-col h-full w-full">
                <div class="px-6 py-3.5 bg-white border-b border-gray-100 flex items-center gap-3 shadow-sm z-10">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">
                        <span x-text="activeName.charAt(0)"></span>
                    </div>
                    <div>
                        <h3 class="font-bold text-[14px] text-gray-800" x-text="activeName"></h3>
                        <p class="text-[11px] text-emerald-600 font-medium" x-text="activeRole"></p>
                    </div>
                </div>

                <div id="chat-container" class="flex-1 p-6 overflow-y-auto space-y-4">
                    <div x-show="loading" class="text-center py-4">
                        <span class="inline-block w-6 h-6 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin"></span>
                    </div>
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex flex-col" :class="msg.is_sender ? 'items-end pl-16' : 'items-start pr-16'">
                            <div class="px-4 py-2.5 text-[13px] shadow-sm max-w-[85%]"
                                 :class="msg.is_sender ? 'bg-emerald-600 text-white rounded-2xl rounded-tr-sm' : 'bg-white border border-gray-100 text-gray-700 rounded-2xl rounded-tl-sm'">
                                <span x-text="msg.pesan" style="white-space: pre-wrap;"></span>
                            </div>
                            <span class="text-[10px] text-gray-400 mt-1" :class="msg.is_sender ? 'mr-1' : 'ml-1'" x-text="msg.time"></span>
                        </div>
                    </template>
                </div>

                <div class="p-4 bg-white border-t border-gray-100">
                    <form @submit.prevent="sendMessage" class="flex items-center gap-3">
                        <input type="text" x-model="newMessage" placeholder="Ketik pesan balasan..." 
                            class="flex-1 bg-gray-50 border border-gray-200 text-[13px] rounded-full px-5 py-3 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            :disabled="sending">
                        <button type="submit" :disabled="sending || newMessage.trim() === ''"
                            class="w-11 h-11 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full flex items-center justify-center transition-colors disabled:opacity-50">
                            <svg class="w-5 h-5 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    function liveChatApp() {
        return {
            // Menerima data dari variabel PHP yang sudah aman
            users: {!! json_encode($userList) !!},
            searchQuery: '',
            
            activeUser: null,
            activeName: '',
            activeRole: '',
            messages: [],
            newMessage: '',
            loading: false,
            sending: false,
            pollInterval: null,

            get filteredUsers() {
                if (this.searchQuery === '') return this.users;
                return this.users.filter(u => u.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
            },

            selectUser(id, name, role) {
                this.activeUser = id;
                this.activeName = name;
                this.activeRole = role;

                const userIndex = this.users.findIndex(u => u.id === id);
                if(userIndex !== -1) {
                    this.users[userIndex].unread = 0;
                }

                this.fetchMessages();
                
                if(this.pollInterval) clearInterval(this.pollInterval);
                this.pollInterval = setInterval(() => this.fetchMessages(false), 5000);
            },

            async fetchMessages(showLoader = true) {
                if(!this.activeUser) return;
                if(showLoader) this.loading = true;
                try {
                    const res = await fetch(`/superadmin/livechat/fetch/${this.activeUser}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    const isNewMessage = this.messages.length !== data.messages.length;
                    this.messages = data.messages;
                    if(isNewMessage || showLoader) this.scrollToBottom();
                } catch (e) { console.error(e); } finally { this.loading = false; }
            },

            async sendMessage() {
                if(this.newMessage.trim() === '' || !this.activeUser) return;
                
                const payload = { 
                    receiver_id: this.activeUser, 
                    pesan: this.newMessage 
                };
                
                this.sending = true;
                const tempMsg = this.newMessage;
                this.newMessage = '';
                
                try {
                    const res = await fetch('{{ route("superadmin.livechat.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json', // Tambahkan ini agar Laravel tahu kita minta JSON
                            'X-Requested-With': 'XMLHttpRequest',
                            // Ubah cara ambil CSRF token menjadi blade string langsung:
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    if (res.ok) {
                        const data = await res.json();
                        // Dorong pesan baru ke array agar langsung muncul di layar
                        this.messages.push(data.message);
                        this.scrollToBottom();
                    } else {
                        // Jika server mengembalikan error (misal 500 atau 422)
                        console.error("Server error:", await res.text());
                        this.newMessage = tempMsg; // Kembalikan teks ke input
                    }
                } catch (e) { 
                    console.error("Network error:", e);
                    this.newMessage = tempMsg; // Kembalikan teks ke input
                } finally { 
                    this.sending = false; 
                }
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('chat-container');
                    if(container) container.scrollTop = container.scrollHeight;
                });
            }
        }
    }
</script>
@endsection