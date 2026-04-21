@extends('layouts.admin')

@section('title', 'Lokasi Tempat Tinggal — ' . $rumahTangga->no_rumah_tangga)

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #peta-lokasi {
        height: 480px;
        width: 100% !important;
        display: block;
        z-index: 0;
    }

    .leaflet-control-custom {
        background: white;
        border-radius: 4px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        cursor: pointer;
    }

    .leaflet-control-custom button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        background: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: #444;
        border-radius: 4px;
    }

    .leaflet-control-custom button:hover {
        background: #f4f4f4;
        color: #222;
    }

    #layer-panel {
        display: none;
        position: absolute;
        left: 42px;
        top: 0;
        background: white;
        border-radius: 4px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4);
        padding: 8px 12px;
        z-index: 1000;
        min-width: 200px;
        font-size: 13px;
    }

    #layer-panel label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 3px 0;
        cursor: pointer;
        white-space: nowrap;
    }

    #layer-panel .separator {
        border-top: 1px solid #eee;
        margin: 4px 0;
    }
</style>

<div class="space-y-5">

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-bold text-gray-800 dark:text-slate-100">
                Lokasi Tempat Tinggal — {{ $rumahTangga->no_rumah_tangga }}
            </h2>
            <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">
                @if ($kepala)
                Kepala RT: {{ $kepala->nama }}
                @if ($kepala->nik)
                &mdash; NIK: {{ $kepala->nik }}
                @endif
                @endif
                @if ($rumahTangga->wilayah)
                &mdash; {{ $rumahTangga->wilayah->dusun }}, RT {{ $rumahTangga->wilayah->rt }}/RW
                {{ $rumahTangga->wilayah->rw }}
                @endif
            </p>
        </div>
        <nav class="flex items-center gap-1.5 text-sm">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-1 text-gray-400 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('admin.rumah-tangga.index') }}"
                class="text-gray-400 hover:text-emerald-600 transition-colors">
                Data Rumah Tangga
            </a>
            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 dark:text-slate-300 font-medium">Lokasi</span>
        </nav>
    </div>

    {{-- ── MAP CARD ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700">

        {{-- Map --}}
        <div id="peta-lokasi"></div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.rumah-tangga.lokasi.store', $rumahTangga) }}" id="form-lokasi">
            @csrf

            {{-- Input koordinat --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Latitude</label>
                        <input type="text" id="input-lat" name="latitude" value="{{ $lat }}"
                            placeholder="contoh: -7.419754"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                       bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                       focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-slate-400 mb-1.5">Longitude</label>
                        <input type="text" id="input-lng" name="longitude" value="{{ $lng }}"
                            placeholder="contoh: 109.244791"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-sm
                                       bg-white dark:bg-slate-700 text-gray-700 dark:text-slate-200
                                       focus:ring-2 focus:ring-emerald-500 outline-none font-mono">
                    </div>
                </div>
                <p class="text-xs text-gray-400 dark:text-slate-500">
                    Klik pada peta atau seret penanda untuk menentukan lokasi. Koordinat akan diperbarui otomatis.
                </p>
            </div>

            <input type="file" id="import-file" accept=".gpx,.kml" class="hidden" />

            {{-- Footer buttons --}}
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/30 rounded-b-xl">
                <div class="flex items-center gap-2 flex-wrap">

                    {{-- Kembali --}}
                    <a href="{{ route('admin.rumah-tangga.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>

                    {{-- Ekspor GPX --}}
                    <button type="button" id="btn-ekspor-gpx"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Ekspor ke GPX
                    </button>

                    {{-- Reset --}}
                    <button type="button" id="btn-reset"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                </div>

                {{-- Simpan --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function() {
        const savedLat = {
            {
                is_numeric($lat) ? $lat : 'null'
            }
        };
        const savedLng = {
            {
                is_numeric($lng) ? $lng : 'null'
            }
        };
        const wilayahLat = {
            {
                is_numeric($rumahTangga - > wilayah ? - > lat ?? null) ? $rumahTangga - > wilayah - > lat : 'null'
            }
        };
        const wilayahLng = {
            {
                is_numeric($rumahTangga - > wilayah ? - > lng ?? null) ? $rumahTangga - > wilayah - > lng : 'null'
            }
        };

        const defaultLat = savedLat ?? wilayahLat ?? -7.3800;
        const defaultLng = savedLng ?? wilayahLng ?? 109.3900;
        const hasCoord = savedLat !== null && savedLng !== null;

        const noRt = @json($rumahTangga - > no_rumah_tangga);
        const namaKepala = @json($kepala ? - > nama ?? $rumahTangga - > no_rumah_tangga);

        // ── Base layers ───────────────────────────────────────────────────────────
        const osmStandard = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        });
        const osmHot = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors, Tiles by HOT',
            maxZoom: 19
        });

        // ── Init peta ─────────────────────────────────────────────────────────────
        const map = L.map('peta-lokasi', {
            center: [defaultLat, defaultLng],
            zoom: hasCoord ? 16 : 12,
            layers: [osmStandard],
            zoomControl: true
        });

        setTimeout(() => map.invalidateSize(), 100);
        setTimeout(() => map.invalidateSize(), 500);
        window.addEventListener('resize', () => map.invalidateSize());

        // ── Marker ────────────────────────────────────────────────────────────────
        const marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            })
            .addTo(map)
            .bindPopup(`<b>${noRt}</b><br>${namaKepala}`)
            .openPopup();

        function updateInputs(lat, lng) {
            document.getElementById('input-lat').value = lat.toFixed(7);
            document.getElementById('input-lng').value = lng.toFixed(7);
        }

        marker.on('dragend', function() {
            const pos = marker.getLatLng();
            updateInputs(pos.lat, pos.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        ['input-lat', 'input-lng'].forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                const lat = parseFloat(document.getElementById('input-lat').value);
                const lng = parseFloat(document.getElementById('input-lng').value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 16);
                }
            });
        });

        // ── Control: Lokasi Saya ──────────────────────────────────────────────────
        const LocateControl = L.Control.extend({
            options: {
                position: 'topleft'
            },
            onAdd: function() {
                const div = L.DomUtil.create('div', 'leaflet-control-custom');
                div.innerHTML = `
                    <button title="Lokasi Saya">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                            <circle cx="12" cy="12" r="7" stroke-dasharray="none"/>
                        </svg>
                    </button>`;
                div.querySelector('button').addEventListener('click', function(e) {
                    L.DomEvent.stopPropagation(e);
                    map.locate({
                        setView: true,
                        maxZoom: 17
                    });
                });
                return div;
            }
        });
        map.addControl(new LocateControl());

        map.on('locationfound', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });
        map.on('locationerror', function() {
            alert('Tidak dapat mendeteksi lokasi Anda.');
        });

        // ── Control: Import GPX/KML ───────────────────────────────────────────────
        const ImportControl = L.Control.extend({
            options: {
                position: 'topleft'
            },
            onAdd: function() {
                const div = L.DomUtil.create('div', 'leaflet-control-custom');
                div.innerHTML = `
                    <button title="Import GPX / KML">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                    </button>`;
                div.querySelector('button').addEventListener('click', function(e) {
                    L.DomEvent.stopPropagation(e);
                    document.getElementById('import-file').click();
                });
                return div;
            }
        });
        map.addControl(new ImportControl());

        document.getElementById('import-file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                const parser = new DOMParser();
                const xml = parser.parseFromString(ev.target.result, 'text/xml');
                let lat = null,
                    lng = null;
                const wpt = xml.querySelector('wpt');
                if (wpt) {
                    lat = parseFloat(wpt.getAttribute('lat'));
                    lng = parseFloat(wpt.getAttribute('lon'));
                } else {
                    const coord = xml.querySelector('coordinates');
                    if (coord) {
                        const parts = coord.textContent.trim().split(',');
                        lng = parseFloat(parts[0]);
                        lat = parseFloat(parts[1]);
                    }
                }
                if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 16);
                    updateInputs(lat, lng);
                } else {
                    alert('Koordinat tidak ditemukan dalam file.');
                }
            };
            reader.readAsText(file);
            e.target.value = '';
        });

        // ── Control: Layer Switcher ───────────────────────────────────────────────
        const LayerControl = L.Control.extend({
            options: {
                position: 'topleft'
            },
            onAdd: function() {
                const container = L.DomUtil.create('div', 'leaflet-control-custom');
                container.style.position = 'relative';
                container.innerHTML = `
                    <button id="btn-layer" title="Pilih Layer Peta">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                            <polyline points="2 17 12 22 22 17"/>
                            <polyline points="2 12 12 17 22 12"/>
                        </svg>
                    </button>
                    <div id="layer-panel">
                        <label><input type="radio" name="base-layer" value="osm" checked> OpenStreetMap</label>
                        <label><input type="radio" name="base-layer" value="hot"> OpenStreetMap H.O.T.</label>
                    </div>`;

                L.DomEvent.disableClickPropagation(container);

                container.querySelector('#btn-layer').addEventListener('click', function(e) {
                    L.DomEvent.stopPropagation(e);
                    const panel = container.querySelector('#layer-panel');
                    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
                });

                container.querySelectorAll('input[name="base-layer"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'osm') {
                            map.removeLayer(osmHot);
                            map.addLayer(osmStandard);
                        } else {
                            map.removeLayer(osmStandard);
                            map.addLayer(osmHot);
                        }
                    });
                });

                document.addEventListener('click', function() {
                    const panel = container.querySelector('#layer-panel');
                    if (panel) panel.style.display = 'none';
                });

                return container;
            }
        });
        map.addControl(new LayerControl());

        // ── Tombol Reset ──────────────────────────────────────────────────────────
        document.getElementById('btn-reset').addEventListener('click', function() {
            marker.setLatLng([defaultLat, defaultLng]);
            map.setView([defaultLat, defaultLng], hasCoord ? 16 : 12);
            if (hasCoord) {
                updateInputs(defaultLat, defaultLng);
            } else {
                document.getElementById('input-lat').value = '';
                document.getElementById('input-lng').value = '';
            }
        });

        // ── Ekspor GPX ────────────────────────────────────────────────────────────
        document.getElementById('btn-ekspor-gpx').addEventListener('click', function() {
            const lat = document.getElementById('input-lat').value;
            const lng = document.getElementById('input-lng').value;
            if (!lat || !lng) {
                alert('Silakan tentukan lokasi terlebih dahulu.');
                return;
            }
            const gpx = `\x3C?xml version="1.0" encoding="UTF-8"?>
<gpx version="1.1" creator="Lumbung Data"
     xmlns="http://www.topografix.com/GPX/1/1">
  <wpt lat="${lat}" lon="${lng}">
    <name>${noRt}</name>
    <desc>Kepala RT: ${namaKepala}</desc>
  </wpt>
</gpx>`;
            const blob = new Blob([gpx], {
                type: 'application/gpx+xml'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `lokasi_rt_${noRt}.gpx`;
            a.click();
            URL.revokeObjectURL(url);
        });
    })();
</script>

@endsection