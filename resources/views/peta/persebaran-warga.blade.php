@extends('layouts.app-warga')

@section('title', 'Peta Persebaran Warga')

@section('content')
<div class="container-fluid p-0">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Leaflet Map Container -->
    <div id="map" style="height: calc(100vh - 120px); width: 100%;"></div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Initialize map centered on Cipagalo
        var map = L.map('map').setView([-6.9703054, 107.6540877], 14);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Custom icon for location markers
        var locationIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Fetch locations data
        fetch('/api/locations')
            .then(response => response.json())
            .then(locations => {
                locations.forEach(function(location) {
                    L.marker([location.latitude, location.longitude], {icon: locationIcon})
                        .bindPopup(`<b>${location.name}</b>`)
                        .addTo(map);
                });
            })
            .catch(error => console.error('Error fetching locations:', error));
    </script>
</div>
@endsection