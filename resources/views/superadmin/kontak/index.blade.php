@extends('superadmin.layout.superadmin')

@section('title', 'Kotak Masuk Internal')
@section('header', 'Kotak Masuk')
@section('subheader', 'Pesan masuk dari Admin & Operator')

@section('content')

<style>
    .inbox-table th {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #9ca3af;
        padding: 12px 20px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
    }
    .inbox-row {
        transition: background 0.14s ease;
        border-bottom: 1px solid #f5f5f5;
    }
    .inbox-row:last-child { border-bottom: none; }
    .inbox-row:hover { background: #f8fbff; }
    .inbox-row.unread { background: #f0f6ff; }
    .inbox-row.unread:hover { background: #e8f2ff; }
    .inbox-row td { padding: 14px 20px; vertical-align: top; }

    .sender-avatar {
        width: 34px; height: 34px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
    }
    .role-badge {
        display: inline-block;
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.07em;
        color: #3b82f6; margin-top: 2px;
    }
    .unread-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #3b82f6; flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }
    .broadcast-tag {
        display: inline-block; margin-top: 6px;
        padding: 2px 8px; border-radius: 5px;
        background: #f3f4f6; color: #6b7280;
        font-size: 10px; font-weight: 600;
        border: 1px solid #e5e7eb;
    }
    .time-main { font-size: 12.5px; color: #6b7280; font-weight: 500; white-space: nowrap; }
    .time-sub  { font-size: 11px; color: #c0c5cc; margin-top: 3px; }

    .empty-state {
        padding: 64px 24px;
        text-align: center;
    }
    .empty-icon {
        width: 56px; height: 56px; border-radius: 16px;
        background: #f3f4f6;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }
</style>

<div class="bg-white rounded-2xl border border-[#f0f0f0] overflow-hidden shadow-[0_1px_8px_rgba(0,0,0,0.05)]">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-[#f0f0f0]">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: #eff6ff;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <div>
                <p class="text-[14px] font-bold text-gray-800">Pesan dari Admin / Operator</p>
                <p class="text-[11px] text-gray-400">Komunikasi internal sistem</p>
            </div>
        </div>

        {{-- Unread count badge --}}
        @php $unreadCount = $messages->where('is_read', false)->count(); @endphp
        @if($unreadCount > 0)
        <span class="flex items-center gap-1.5 text-[11px] font-700 px-3 py-1.5 rounded-full"
              style="background:#eff6ff; color:#3b82f6; font-weight:700; border:1px solid #dbeafe;">
            <span class="unread-dot" style="width:6px;height:6px;box-shadow:none;"></span>
            {{ $unreadCount }} belum dibaca
        </span>
        @endif
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full inbox-table">
            <thead>
                <tr>
                    <th style="width:220px;">Pengirim</th>
                    <th>Subjek &amp; Pesan</th>
                    <th style="width:140px;">Waktu</th>
                </tr>
            </thead>
            <tbody>

                @forelse($messages as $msg)
                <tr class="inbox-row {{ $msg->is_read ? '' : 'unread' }}">

                    {{-- Pengirim --}}
                    <td>
                        <div class="flex items-center gap-3">
                            @if(!$msg->is_read)
                                <div class="unread-dot"></div>
                            @else
                                <div style="width:7px;flex-shrink:0;"></div>
                            @endif
                            <div class="sender-avatar">
                                {{ strtoupper(substr($msg->sender->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[13px] font-semibold text-gray-800 leading-tight">
                                    {{ $msg->sender->name ?? 'User Dihapus' }}
                                </p>
                                <p class="role-badge">{{ $msg->sender->role ?? '-' }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Pesan --}}
                    <td>
                        <p class="text-[13.5px] font-bold leading-tight mb-1 {{ $msg->is_read ? 'text-gray-800' : 'text-blue-700' }}">
                            {{ $msg->judul }}
                        </p>
                        <p class="text-[12.5px] text-gray-500 leading-relaxed">
                            {{ $msg->pesan }}
                        </p>
                        @if(is_null($msg->receiver_id))
                            <span class="broadcast-tag">📢 Broadcast ke Semua</span>
                        @endif
                    </td>

                    {{-- Waktu --}}
                    <td>
                        <p class="time-main">{{ $msg->created_at->diffForHumans() }}</p>
                        <p class="time-sub">{{ $msg->created_at->format('d M Y, H:i') }}</p>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <p class="text-[14px] font-semibold text-gray-500">Kotak masuk kosong</p>
                            <p class="text-[12.5px] text-gray-400 mt-1">Belum ada pesan dari Admin atau Operator.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection