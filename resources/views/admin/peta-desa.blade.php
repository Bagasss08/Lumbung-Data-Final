@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-extrabold text-slate-800 mb-4">
        Peta Wilayah Desa
    </h1>

    <div id="map" class="w-full h-[500px] rounded-2xl border border-slate-200 shadow-md"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([-7.123456, 110.654321], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Marker Kantor Desa
    L.marker([-7.123456, 110.654321])
        .addTo(map)
        .bindPopup('<b>Kantor Desa</b>')
        .openPopup();

    // Contoh polygon wilayah desa
    const wilayahDesa = [
        [-7.1245, 110.6521],
        [-7.1212, 110.6584],
        [-7.1188, 110.6542],
        [-7.1221, 110.6498],
    ];

    L.polygon(wilayahDesa, {
        color: '#10b981',
        fillColor: '#10b981',
        fillOpacity: 0.3
    }).addTo(map).bindPopup('Wilayah Desa');
</script>
@endsection