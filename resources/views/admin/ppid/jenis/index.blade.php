@extends('layouts.admin')

@section('title', 'Jenis Dokumen PPID')

@push('head')
<style>
    .hue-slider {
        -webkit-appearance: none; appearance: none;
        height: 12px; border-radius: 6px; outline: none; cursor: pointer;
        background: linear-gradient(to right,
            hsl(0,100%,50%),hsl(30,100%,50%),hsl(60,100%,50%),hsl(90,100%,50%),
            hsl(120,100%,50%),hsl(150,100%,50%),hsl(180,100%,50%),hsl(210,100%,50%),
            hsl(240,100%,50%),hsl(270,100%,50%),hsl(300,100%,50%),hsl(330,100%,50%),hsl(360,100%,50%)
        );
    }
    .hue-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 18px; height: 18px; border-radius: 50%;
        background: white; border: 2px solid rgba(0,0,0,0.2);
        cursor: pointer; box-shadow: 0 1px 4px rgba(0,0,0,0.3);
    }
    .hue-slider::-moz-range-thumb {
        width: 18px; height: 18px; border-radius: 50%;
        background: white; border: 2px solid rgba(0,0,0,0.2);
        cursor: pointer; box-shadow: 0 1px 4px rgba(0,0,0,0.3);
    }
    [x-cloak] { display: none !important; }
</style>
@endpush

@php
/**
 * Map ikon → SVG path d= (Heroicons outline, MIT license)
 * Key ini yang disimpan ke kolom `icon` di database.
 */
$iconMap = [
    'document'        => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
    'document-check'  => 'M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12',
    'document-text'   => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
    'document-report' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
    'folder'          => 'M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z',
    'folder-open'     => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776',
    'archive'         => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
    'newspaper'       => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z',
    'clipboard'       => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z',
    'clipboard-check' => 'M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75',
    'envelope'        => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
    'envelope-open'   => 'M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z',
    'bell'            => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
    'megaphone'       => 'M10.34 15.84c-.196-.138-.374-.291-.533-.459l-3.978 3.978a1.5 1.5 0 002.121 2.122l3.978-3.978a6.065 6.065 0 01-.458-.532 6.035 6.035 0 01-.13-.131zM20.78 4.22a4.5 4.5 0 010 6.363l-1.757 1.757a4.5 4.5 0 01-6.364-6.364l1.757-1.756a4.5 4.5 0 016.364 0zm-3.536 8.485l-3.536-3.535a1.5 1.5 0 00-2.121 2.12l3.535 3.536a1.5 1.5 0 002.122-2.121z',
    'chat'            => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z',
    'users'           => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
    'user'            => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
    'shield-check'    => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
    'shield-x'        => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M12 2.699c-3.196 0-6.1 1.248-8.25 3.285A11.959 11.959 0 003.598 6a11.99 11.99 0 00-.598 3.748c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-2.15-2.037-5.054-3.285-8.25-3.285z',
    'lock-closed'     => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',
    'lock-open'       => 'M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',
    'eye'             => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
    'eye-slash'       => 'M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88',
    'globe'           => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
    'building'        => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
    'home'            => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
    'chart-bar'       => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z',
    'chart-pie'       => 'M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z',
    'calendar'        => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
    'clock'           => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
    'key'             => 'M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z',
    'bolt'            => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
    'fire'            => 'M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z',
    'star'            => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z',
    'heart'           => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
    'tag'             => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z M6 6h.008v.008H6V6z',
    'flag'            => 'M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 0 00-6.208-.682L3 4.5M3 15V4.5',
    'information'     => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
    'exclamation'     => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
    'check-circle'    => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    'x-circle'        => 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    'cash'            => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
    'printer'         => 'M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z',
    'phone'           => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z',
    'book-open'       => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25',
    'cog'             => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
    'server'          => 'M21.75 17.25v2.25a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25v-2.25M21.75 6.75v2.25a2.25 2.25 0 01-2.25 2.25H4.5A2.25 2.25 0 012.25 9V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
    'map'             => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z',
    'academic'        => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
    'photo'           => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
    'credit-card'     => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z',
];
@endphp

@section('content')

<div x-data="jenisApp()" x-init="init()" x-cloak>

    {{-- PAGE HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-700 dark:text-slate-200">Jenis Dokumen</h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">Master data jenis dokumen PPID</p>
        </div>
        <div class="flex items-center gap-3">
            <nav class="flex items-center gap-1.5 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-1 text-gray-400 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Beranda
                </a>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-gray-600 dark:text-slate-300 font-medium">Jenis Dokumen</span>
            </nav>
            {{-- Tombol Hapus Terpilih --}}
            <button
                @click="openHapusBulk()"
                :disabled="selectedIds.length === 0"
                :class="selectedIds.length > 0
                    ? 'bg-red-600 hover:bg-red-700 text-white shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-0.5 cursor-pointer'
                    : 'bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-slate-500 cursor-not-allowed'"
                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span x-text="selectedIds.length > 0 ? 'Hapus (' + selectedIds.length + ')' : 'Hapus Terpilih'"></span>
            </button>
            <button @click="openAdd()"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-emerald-500/20 transition-all duration-200 hover:shadow-lg hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jenis
            </button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-4 flex items-center gap-2 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-400 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-4 flex items-center gap-2 px-4 py-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 rounded-lg text-sm">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50 border-b border-gray-200 dark:border-slate-700">
                    <th class="px-4 py-4 w-10">
                        @php $checkableIds = $jenis->filter(fn($i) => !in_array($i->nama, ['Secara Berkala','Serta Merta','Tersedia Setiap Saat','Dikecualikan']))->pluck('id')->toArray(); @endphp
                        <input type="checkbox"
                            :checked="selectAll"
                            @change="toggleSelectAll({{ json_encode($checkableIds) }})"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-red-600 focus:ring-red-500 cursor-pointer"
                            title="Pilih semua"
                        >
                    </th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-12">NO</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-32">AKSI</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">NAMA KATEGORI</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">DESKRIPSI</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider w-36">ICON</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($jenis as $item)
                @php
                    $isProtected = in_array($item->nama, ['Secara Berkala','Serta Merta','Tersedia Setiap Saat','Dikecualikan']);
                    $svgPath     = $iconMap[$item->icon] ?? $iconMap['document'];
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="px-4 py-4">
                        @unless($isProtected)
                        <input type="checkbox"
                            :checked="selectedIds.includes({{ $item->id }})"
                            @change="selectedIds.includes({{ $item->id }}) ? selectedIds.splice(selectedIds.indexOf({{ $item->id }}), 1) : selectedIds.push({{ $item->id }}); updateSelectAll({{ json_encode($checkableIds) }})"
                            class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-red-600 focus:ring-red-500 cursor-pointer"
                        >
                        @endunless
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-slate-400">{{ $jenis->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1 flex-wrap">
                            {{-- Edit --}}
                            <button type="button" title="Edit"
                                @click="openEdit({ id: {{ $item->id }}, nama: @js($item->nama), keterangan: @js($item->keterangan ?? ''), icon: @js($item->icon ?? 'document'), warna_background: @js($item->warna_background ?? '#3b82f6'), status: @js($item->status) })"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            {{-- Toggle Status --}}
                            @if($item->status === 'aktif')
                            <button type="button" title="Nonaktifkan" @click="toggleStatus({{ $item->id }}, 'aktif')"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-500 hover:bg-slate-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </button>
                            @else
                            <button type="button" title="Aktifkan" @click="toggleStatus({{ $item->id }}, 'tidak_aktif')"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            @endif
                            {{-- Hapus: hanya non-bawaan --}}
                            @unless($isProtected)
                            <button type="button" title="Hapus" @click="openHapus({ id: {{ $item->id }}, nama: @js($item->nama) })"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                            @endunless
                        </div>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium text-gray-800 dark:text-slate-200">{{ $item->nama }}</td>
                    <td class="px-4 py-4 text-sm text-gray-600 dark:text-slate-400 max-w-sm">
                        <span class="line-clamp-2">{{ $item->keterangan ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                                 style="background-color: {{ $item->warna_background ?? '#6b7280' }}">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}"/>
                                </svg>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-semibold rounded {{ $item->status === 'aktif' ? 'bg-emerald-500 text-white' : 'bg-gray-400 text-white' }}">
                                {{ $item->status === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-14 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500 dark:text-slate-400 font-medium">Belum ada jenis dokumen</p>
                            <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Silakan tambah jenis dokumen baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($jenis->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between flex-wrap gap-3">
            <p class="text-sm text-gray-500 dark:text-slate-400">
                Menampilkan {{ $jenis->firstItem() }}–{{ $jenis->lastItem() }} dari {{ $jenis->total() }} data
            </p>
            {{ $jenis->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL TAMBAH / EDIT                                           --}}
    {{-- ============================================================ --}}
    <div x-show="showForm"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto" style="display:none">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showForm = false"></div>
        <div x-show="showForm"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-lg z-10 my-4">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-base font-bold text-gray-700 dark:text-slate-200" x-text="isEdit ? 'Ubah Data' : 'Tambah Data'"></h3>
                <button @click="showForm = false" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto">
                <template x-if="Object.keys(formErrors).length > 0">
                    <div class="p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg">
                        <template x-for="(msgs, field) in formErrors" :key="field">
                            <p class="text-xs text-red-600 dark:text-red-400" x-text="msgs[0]"></p>
                        </template>
                    </div>
                </template>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" x-model="formData.nama" placeholder="Nama Kategori"
                           :class="formErrors.nama ? 'border-red-400' : 'border-gray-300 dark:border-slate-600'"
                           class="w-full px-4 py-2.5 border rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">
                    <p x-show="formErrors.nama" class="text-xs text-red-500 mt-1" x-text="formErrors.nama ? formErrors.nama[0] : ''"></p>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
                    <textarea x-model="formData.keterangan" rows="3" placeholder="Deskripsi singkat..."
                              class="w-full px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none resize-none text-sm"></textarea>
                </div>

                {{-- Icon --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Icon</label>
                    <div class="flex gap-2 items-center">
                        <div class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700/50 flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                                 :style="'background-color:' + (formData.warna_background || '#3b82f6')">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="iconPaths[formData.icon] || iconPaths['document']"></path>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-slate-400 truncate" x-text="formData.icon || 'Pilih icon...'"></span>
                        </div>
                        <button type="button" @click="showIconPicker = true"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                            Pilih Icon
                        </button>
                    </div>
                </div>

                {{-- Warna Background --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Warna Background Icon</label>
                    <div class="relative">
                        <button type="button" @click="openColorPicker()"
                                class="w-full h-10 rounded-lg border border-gray-300 dark:border-slate-600 flex items-center px-3 gap-3 hover:ring-2 hover:ring-emerald-500 transition-all"
                                :style="'background-color:' + (formData.warna_background || '#3b82f6')">
                            <span class="text-xs font-mono text-white drop-shadow" x-text="formData.warna_background"></span>
                        </button>
                        <div x-show="showCP" @click.outside="showCP = false"
                             x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute left-0 top-12 z-[70] bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-gray-200 dark:border-slate-600 p-3 select-none"
                             style="width:248px;display:none">
                            <canvas x-ref="cpCanvas" width="224" height="148"
                                    class="rounded-lg cursor-crosshair w-full block border border-gray-100 dark:border-slate-600"
                                    @mousedown.prevent="cpStartDrag($event)" @touchstart.prevent="cpStartDragTouch($event)"></canvas>
                            <div class="flex items-center gap-2.5 mt-3">
                                <div class="w-9 h-9 rounded-full border-2 border-white shadow-md flex-shrink-0" :style="'background-color:' + (formData.warna_background || '#3b82f6')"></div>
                                <input type="range" x-ref="hueSlider" :value="cpHue" min="0" max="360" @input="cpOnHueChange($event.target.value)" class="flex-1 hue-slider">
                            </div>
                            <div class="flex gap-1.5 mt-3">
                                <div class="flex-1 text-center">
                                    <input type="number" :value="cpRgb.r" min="0" max="255" @change="cpOnRGBChange('r',$event.target.value)" class="w-full text-center text-xs px-1 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-300 outline-none focus:ring-1 focus:ring-cyan-500">
                                    <span class="text-xs text-gray-400 mt-0.5 block">R</span>
                                </div>
                                <div class="flex-1 text-center">
                                    <input type="number" :value="cpRgb.g" min="0" max="255" @change="cpOnRGBChange('g',$event.target.value)" class="w-full text-center text-xs px-1 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-300 outline-none focus:ring-1 focus:ring-cyan-500">
                                    <span class="text-xs text-gray-400 mt-0.5 block">G</span>
                                </div>
                                <div class="flex-1 text-center">
                                    <input type="number" :value="cpRgb.b" min="0" max="255" @change="cpOnRGBChange('b',$event.target.value)" class="w-full text-center text-xs px-1 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-300 outline-none focus:ring-1 focus:ring-cyan-500">
                                    <span class="text-xs text-gray-400 mt-0.5 block">B</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" :value="formData.warna_background" @change="cpOnHexChange($event.target.value)"
                                       class="w-full text-center text-xs px-2 py-1.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-300 font-mono outline-none focus:ring-1 focus:ring-cyan-500" placeholder="#000000">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Status</label>
                    <select x-model="formData.status" class="w-full sm:w-48 px-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none text-sm">
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-700/20 rounded-b-xl">
                <button @click="showForm = false" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    Batal
                </button>
                <button @click="submitForm()" :disabled="isSubmitting"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed text-white rounded-lg font-medium text-sm transition-colors">
                    <svg x-show="!isSubmitting" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL ICON PICKER (SVG Heroicons, tanpa CDN)                  --}}
    {{-- ============================================================ --}}
    <div x-show="showIconPicker"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display:none">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showIconPicker = false"></div>
        <div x-show="showIconPicker"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white dark:bg-slate-800 rounded-xl shadow-2xl w-full max-w-2xl z-10">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-700">
                <h3 class="text-base font-bold text-gray-700 dark:text-slate-200">Pilih Icon</h3>
                <button @click="showIconPicker = false" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="px-5 py-3 border-b border-gray-100 dark:border-slate-700">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input type="text" x-model="iconSearch" placeholder="Cari icon (folder, envelope, shield, bolt...)..."
                           class="w-full pl-9 pr-4 py-2.5 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-300 text-sm outline-none focus:ring-2 focus:ring-cyan-500">
                </div>
            </div>

            <div class="p-4 max-h-[360px] overflow-y-auto">
                <div class="grid grid-cols-6 sm:grid-cols-8 gap-1.5">
                    <template x-for="[key, path] in filteredIcons" :key="key">
                        <button type="button"
                                @click="formData.icon = key; showIconPicker = false; iconSearch = ''"
                                :class="formData.icon === key
                                    ? 'bg-cyan-500 text-white ring-2 ring-cyan-400 ring-offset-1'
                                    : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 hover:bg-cyan-100 dark:hover:bg-cyan-900/40'"
                                class="flex flex-col items-center justify-center rounded-xl transition-all gap-1 p-2 aspect-square"
                                :title="key">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="path"></path>
                            </svg>
                            <span class="text-[9px] leading-tight text-center truncate w-full" x-text="key"></span>
                        </button>
                    </template>
                </div>
                <div x-show="filteredIcons.length === 0" class="py-10 text-center text-gray-400 dark:text-slate-500 text-sm">
                    Tidak ada icon untuk "<span x-text="iconSearch"></span>"
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODAL HAPUS (pakai partial bersama)                            --}}
    {{-- ============================================================ --}}
    @include('admin.partials.modal-hapus')

</div>

<script>
const ICON_PATHS = @json($iconMap);

function jenisApp() {
    return {
        showForm:false, isEdit:false, isSubmitting:false,
        formData:{ id:null, nama:'', keterangan:'', icon:'document', warna_background:'#3b82f6', status:'aktif' },
        formErrors:{},
        showIconPicker:false, iconSearch:'',
        showHapus:false, hapusId:null, hapusNama:'', isDeleting:false,
        showCP:false, cpHue:213, cpSat:0.76, cpVal:0.96, cpRgb:{r:59,g:130,b:246}, cpDragging:false,
        iconPaths: ICON_PATHS,
        selectedIds: [],
        selectAll: false,
        isDeletingBulk: false,

        get filteredIcons() {
            const entries = Object.entries(ICON_PATHS);
            if (!this.iconSearch) return entries;
            const q = this.iconSearch.toLowerCase();
            return entries.filter(([k]) => k.includes(q));
        },

        init() {},

        openAdd() {
            this.formData   = { id:null, nama:'', keterangan:'', icon:'document', warna_background:'#3b82f6', status:'aktif' };
            this.formErrors = {}; this.isEdit = false; this.showForm = true; this.showCP = false;
            this.$nextTick(() => this.cpInitFromHex('#3b82f6'));
        },
        openEdit(item) {
            this.formData   = {...item}; this.formErrors = {}; this.isEdit = true; this.showForm = true; this.showCP = false;
            this.$nextTick(() => this.cpInitFromHex(item.warna_background));
        },
        openHapus({id,nama}) { this.hapusId=id; this.hapusNama=nama; modalHapus.bukaJs(nama, () => this.konfirmasiHapus()); },

        async submitForm() {
            if (!this.formData.nama.trim()) { this.formErrors={nama:['Nama kategori wajib diisi.']}; return; }
            this.isSubmitting=true; this.formErrors={};
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const url  = this.isEdit ? `{{ url('admin/ppid/jenis') }}/${this.formData.id}` : `{{ route('admin.ppid.jenis.store') }}`;
            const body = new FormData();
            body.append('_token',csrf);
            if (this.isEdit) body.append('_method','PUT');
            body.append('nama',this.formData.nama);
            body.append('keterangan',this.formData.keterangan||'');
            body.append('icon',this.formData.icon||'document');
            body.append('warna_background',this.formData.warna_background||'#3b82f6');
            body.append('status',this.formData.status);
            try {
                const res=await fetch(url,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'},body});
                const data=await res.json();
                if (res.ok) window.location.reload();
                else if (res.status===422) this.formErrors=data.errors||{};
                else alert(data.message||'Terjadi kesalahan.');
            } catch { alert('Terjadi kesalahan koneksi.'); }
            this.isSubmitting=false;
        },

        async toggleStatus(id,currentStatus) {
            const newStatus = currentStatus==='aktif'?'tidak_aktif':'aktif';
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const body = new FormData();
            body.append('_token',csrf); body.append('_method','PATCH'); body.append('status',newStatus);
            try {
                const res=await fetch(`{{ url('admin/ppid/jenis') }}/${id}/toggle-status`,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'},body});
                if (res.ok) window.location.reload();
                else { const d=await res.json(); alert(d.message||'Gagal mengubah status.'); }
            } catch { alert('Terjadi kesalahan koneksi.'); }
        },

        toggleSelectAll(checkableIds) {
            if (this.selectedIds.length === checkableIds.length) {
                this.selectedIds = [];
                this.selectAll = false;
            } else {
                this.selectedIds = [...checkableIds];
                this.selectAll = true;
            }
        },

        updateSelectAll(checkableIds) {
            this.selectAll = checkableIds.length > 0 && this.selectedIds.length === checkableIds.length;
        },

        openHapusBulk() {
            if (this.selectedIds.length === 0) return;
            const nama = this.selectedIds.length + ' item terpilih';
            modalHapus.bukaJs(nama, () => this.konfirmasiHapusBulk());
        },

        async konfirmasiHapusBulk() {
            this.isDeletingBulk = true;
            const csrf = document.querySelector('meta[name="csrf-token"]').content;
            const body = new FormData();
            body.append('_token', csrf);
            body.append('_method', 'DELETE');
            this.selectedIds.forEach(id => body.append('ids[]', id));
            try {
                const res = await fetch(`{{ url('admin/ppid/jenis/bulk-destroy') }}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body
                });
                if (res.ok) window.location.reload();
                else { const d = await res.json(); alert(d.message || 'Gagal menghapus.'); }
            } catch { alert('Terjadi kesalahan koneksi.'); }
            this.isDeletingBulk = false;
        },

                async konfirmasiHapus() {
            this.isDeleting=true;
            const csrf=document.querySelector('meta[name="csrf-token"]').content;
            const body=new FormData();
            body.append('_token',csrf); body.append('_method','DELETE');
            try {
                const res=await fetch(`{{ url('admin/ppid/jenis') }}/${this.hapusId}`,{method:'POST',headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'},body});
                if (res.ok) window.location.reload();
                else { const d=await res.json(); alert(d.message||'Gagal menghapus.'); }
            } catch { alert('Terjadi kesalahan koneksi.'); }
            this.isDeleting=false;
        },

        // Color Picker
        openColorPicker() {
            this.showCP=!this.showCP;
            if (this.showCP) this.$nextTick(()=>{ this.cpInitFromHex(this.formData.warna_background); this.cpDrawCanvas(); });
        },
        cpInitFromHex(hex) {
            const rgb=this.cpHexToRgb(hex); if(!rgb)return;
            this.cpRgb=rgb; const hsv=this.cpRgbToHsv(rgb.r,rgb.g,rgb.b);
            this.cpHue=hsv.h; this.cpSat=hsv.s; this.cpVal=hsv.v;
        },
        cpDrawCanvas() {
            const c=this.$refs.cpCanvas; if(!c)return;
            const ctx=c.getContext('2d'),w=c.width,h=c.height;
            const sg=ctx.createLinearGradient(0,0,w,0); sg.addColorStop(0,'#fff'); sg.addColorStop(1,`hsl(${this.cpHue},100%,50%)`);
            ctx.fillStyle=sg; ctx.fillRect(0,0,w,h);
            const vg=ctx.createLinearGradient(0,0,0,h); vg.addColorStop(0,'rgba(0,0,0,0)'); vg.addColorStop(1,'rgba(0,0,0,1)');
            ctx.fillStyle=vg; ctx.fillRect(0,0,w,h);
            const cx=this.cpSat*w, cy=(1-this.cpVal)*h;
            ctx.beginPath(); ctx.arc(cx,cy,7,0,Math.PI*2); ctx.strokeStyle='white'; ctx.lineWidth=2.5; ctx.stroke();
            ctx.beginPath(); ctx.arc(cx,cy,7,0,Math.PI*2); ctx.strokeStyle='rgba(0,0,0,.25)'; ctx.lineWidth=1; ctx.stroke();
        },
        cpStartDrag(e) {
            this.cpDragging=true; this.cpUpdateFromCanvas(e);
            const mv=me=>{ if(this.cpDragging)this.cpUpdateFromCanvas(me); };
            const up=()=>{ this.cpDragging=false; document.removeEventListener('mousemove',mv); document.removeEventListener('mouseup',up); };
            document.addEventListener('mousemove',mv); document.addEventListener('mouseup',up);
        },
        cpStartDragTouch(e) { if(e.touches.length)this.cpUpdateFromCanvas(e.touches[0]); },
        cpUpdateFromCanvas(e) {
            const c=this.$refs.cpCanvas; if(!c)return;
            const r=c.getBoundingClientRect(),sx=c.width/r.width,sy=c.height/r.height;
            const x=Math.max(0,Math.min(c.width,(e.clientX-r.left)*sx));
            const y=Math.max(0,Math.min(c.height,(e.clientY-r.top)*sy));
            this.cpSat=x/c.width; this.cpVal=1-y/c.height; this.cpUpdateColor();
        },
        cpOnHueChange(h)     { this.cpHue=parseInt(h); this.cpUpdateColor(); },
        cpOnRGBChange(ch,v)  {
            this.cpRgb={...this.cpRgb,[ch]:Math.max(0,Math.min(255,parseInt(v)||0))};
            const hsv=this.cpRgbToHsv(this.cpRgb.r,this.cpRgb.g,this.cpRgb.b);
            this.cpHue=hsv.h; this.cpSat=hsv.s; this.cpVal=hsv.v;
            this.formData.warna_background=this.cpRgbToHex(this.cpRgb.r,this.cpRgb.g,this.cpRgb.b);
            this.$nextTick(()=>this.cpDrawCanvas());
        },
        cpOnHexChange(hex)   { if(/^#[0-9a-fA-F]{6}$/.test(hex)){this.formData.warna_background=hex;this.cpInitFromHex(hex);this.$nextTick(()=>this.cpDrawCanvas());} },
        cpUpdateColor() {
            const rgb=this.cpHsvToRgb(this.cpHue,this.cpSat,this.cpVal);
            this.cpRgb=rgb; this.formData.warna_background=this.cpRgbToHex(rgb.r,rgb.g,rgb.b);
            this.$nextTick(()=>this.cpDrawCanvas());
        },
        cpHexToRgb(hex) { const r=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex); return r?{r:parseInt(r[1],16),g:parseInt(r[2],16),b:parseInt(r[3],16)}:null; },
        cpRgbToHex(r,g,b) { return '#'+[r,g,b].map(x=>Math.round(x).toString(16).padStart(2,'0')).join(''); },
        cpHsvToRgb(h,s,v) {
            const i=Math.floor(h/60)%6,f=h/60-Math.floor(h/60),p=v*(1-s),q=v*(1-f*s),t=v*(1-(1-f)*s);
            const m=[[v,t,p],[q,v,p],[p,v,t],[p,q,v],[t,p,v],[v,p,q]][i]||[0,0,0];
            return {r:Math.round(m[0]*255),g:Math.round(m[1]*255),b:Math.round(m[2]*255)};
        },
        cpRgbToHsv(r,g,b) {
            r/=255;g/=255;b/=255;
            const max=Math.max(r,g,b),min=Math.min(r,g,b),d=max-min;
            let h,s=max===0?0:d/max,v=max;
            if(max===min){h=0;}
            else{switch(max){case r:h=((g-b)/d+(g<b?6:0))*60;break;case g:h=((b-r)/d+2)*60;break;case b:h=((r-g)/d+4)*60;break;}}
            return {h:Math.round(h),s,v};
        },
    }
}
</script>

@endsection