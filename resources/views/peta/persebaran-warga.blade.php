@extends('layouts.app-warga')

@section('title', 'Peta Persebaran Warga')

@section('content')
<div style="width: 100%; max-width: 900px; margin: 40px auto;">
    <h3 class="mb-4">Peta Persebaran</h3>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Leaflet Map Container -->
    <div id="map" style="height: 500px; width: 100%; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.10);"></div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- Leaflet Heat Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>
    
    <script>
        // Initialize map centered on Cipagalo
        var map = L.map('map').setView([-6.9703054, 107.6540877], 14);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var points = [ 
            // Bojongsoang
            [-6.9557189, 107.6542139, 1], //tengah
            [-6.9550, 107.6540, 0.8],
            [-6.9560, 107.6545, 0.9],
            [-6.9545, 107.6535, 0.7],
            [-6.9565, 107.6550, 0.6],
            
            // Cipagalo
            [-6.9703054, 107.6540877, 1], // tengah
            [-6.9700, 107.6545, 0.9],
            [-6.9705, 107.6535, 0.8],
            [-6.9710, 107.6542, 0.7],
            [-6.9698, 107.6538, 0.8]
        ];

        // Configure and add the heatmap layer
        var heat = L.heatLayer(points, {
            radius: 25,
            blur: 15,
            maxZoom: 16,
            gradient: {
                0.4: 'blue',
                0.6: 'lime',
                0.8: 'yellow',
                1.0: 'red'
            }
        }).addTo(map);

    </script>
</div>
@endsection