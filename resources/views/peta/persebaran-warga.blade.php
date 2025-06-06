@extends('layouts.app-warga')

@section('title', 'Persebaran Kejadian')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mt-4">Peta Persebaran Kejadian</h2>
    <p class="text-muted">Visualisasi persebaran kejadian berdasarkan wilayah untuk memantau tingkat keamanan dan kegiatan di setiap daerah</p>
</div>

<div class="container-fluid p-0">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Loading indicator -->
    <div id="loading" class="text-center p-4" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Memuat data laporan...</p>
    </div>

    <!-- Leaflet Map Container -->
    <div id="map" style="height: calc(100vh - 180px); width: 100%;"></div>

    <!-- Statistics Panel -->
    <div id="statisticsPanel" class="position-absolute" style="top: 20px; right: 20px; z-index: 1000; max-width: 300px;">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Laporan</h6>
            </div>
            <div class="card-body p-3">
                <div id="statisticsContent">
                    <p class="text-muted">Memuat statistik...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Initialize map centered on Bojongsoang area
        var map = L.map('map').setView([-6.9803, 107.6640], 14);
        var markers = [];
        var markerCluster;

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Custom marker icons yang lebih sederhana dan bagus
        const markerIcons = {
            green: L.divIcon({
                className: 'custom-marker green-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            }),
            orange: L.divIcon({
                className: 'custom-marker orange-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            }),
            blue: L.divIcon({
                className: 'custom-marker blue-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            }),
            red: L.divIcon({
                className: 'custom-marker red-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            }),
            gray: L.divIcon({
                className: 'custom-marker gray-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            }),
            lightgreen: L.divIcon({
                className: 'custom-marker lightgreen-marker',
                html: '<i class="fas fa-map-marker-alt"></i>',
                iconSize: [25, 25],
                iconAnchor: [12, 25],
                popupAnchor: [0, -25]
            })
        };

        // Create legend control dengan design yang konsisten
        var legend = L.control({position: 'bottomleft'});

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info legend');
            var statuses = [
                { color: '#28a745', label: 'Diverifikasi & Ditangani' },
                { color: '#fd7e14', label: 'Diverifikasi & Belum Ditangani' },
                { color: '#007bff', label: 'Diverifikasi & Sedang Ditangani' },
                { color: '#20c997', label: 'Diverifikasi' },
                { color: '#dc3545', label: 'Ditolak' },
                { color: '#6c757d', label: 'Belum Diverifikasi' }
            ];

            div.innerHTML = '<h6><i class="fas fa-map-signs me-2"></i>Legenda Status</h6>';
            
            for (var i = 0; i < statuses.length; i++) {
                div.innerHTML +=
                    '<div class="legend-item">' +
                    '<i class="fas fa-map-marker-alt" style="color: ' + statuses[i].color + ';"></i>' +
                    '<span>' + statuses[i].label + '</span>' +
                    '</div>';
            }

            return div;
        };

        legend.addTo(map);

        // Helper function to get hex color for legend
        function getMarkerColorHex(colorName) {
            const colors = {
                green: '#28a745',
                orange: '#fd7e14',
                blue: '#007bff',
                red: '#dc3545',
                gray: '#6c757d',
                lightgreen: '#20c997'
            };
            return colors[colorName] || '#6c757d';
        }

        // Load map data
        function loadMapData() {
            document.getElementById('loading').style.display = 'block';
            
            fetch('{{ route("api.map-data") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    console.log("Map data loaded:", data);
                    
                    // Clear existing markers
                    markers.forEach(marker => map.removeLayer(marker));
                    markers = [];
                    
                    // Add markers for each laporan
                    data.features.forEach(feature => {
                        const coords = feature.geometry.coordinates;
                        const props = feature.properties;
                        
                        // Create marker with custom icon
                        const marker = L.marker([coords[1], coords[0]], {
                            icon: markerIcons[props.marker_color] || markerIcons.gray
                        }).addTo(map);
                        
                        // Add popup
                        marker.bindPopup(props.popup_content, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });
                        
                        markers.push(marker);
                    });
                    
                    // Fit map to show all markers
                    if (markers.length > 0) {
                        const group = new L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }
                    
                    // Load statistics
                    loadStatistics();
                })
                .catch(error => {
                    document.getElementById('loading').style.display = 'none';
                    console.error('Error loading map data:', error);
                    alert('Gagal memuat data peta. Silakan refresh halaman.');
                });
        }

        // Load statistics
        function loadStatistics() {
            fetch('{{ route("api.map-statistics") }}')
                .then(response => response.json())
                .then(stats => {
                    const content = `
                        <div class="mb-2">
                            <strong>Total Laporan: ${stats.total_laporan}</strong>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Status Verifikasi:</small><br>
                            <small>• Diverifikasi: ${stats.by_verification.diverifikasi}</small><br>
                            <small>• Ditolak: ${stats.by_verification.ditolak}</small><br>
                            <small>• Belum Diverifikasi: ${stats.by_verification.belum_diverifikasi}</small>
                        </div>
                        <div>
                            <small class="text-muted">Status Penanganan:</small><br>
                            <small>• Sudah Ditangani: ${stats.by_handling.sudah_ditangani}</small><br>
                            <small>• Belum Ditangani: ${stats.by_handling.belum_ditangani}</small><br>
                            <small>• Sedang Ditangani: ${stats.by_handling.sedang_ditangani}</small>
                        </div>
                    `;
                    document.getElementById('statisticsContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                    document.getElementById('statisticsContent').innerHTML = '<p class="text-danger">Gagal memuat statistik</p>';
                });
        }

        // Load data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadMapData();
        });

        // Add custom CSS for markers yang sederhana dan bagus
        var style = document.createElement('style');
        style.innerHTML = `
            /* Simple and Clean Marker Design */
            .custom-marker {
                color: white;
                text-align: center;
                line-height: 25px;
                font-size: 18px;
                text-shadow: 0 1px 3px rgba(0,0,0,0.5);
                transition: all 0.2s ease;
            }
            
            .custom-marker:hover {
                transform: scale(1.1);
                text-shadow: 0 2px 6px rgba(0,0,0,0.7);
            }
            
            /* Marker Colors - Clean and Bright */
            .green-marker { color: #28a745; }
            .orange-marker { color: #fd7e14; }
            .blue-marker { color: #007bff; }
            .red-marker { color: #dc3545; }
            .gray-marker { color: #6c757d; }
            .lightgreen-marker { color: #20c997; }
            
            /* Popup styling */
            .custom-popup .leaflet-popup-content {
                margin: 12px 16px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            
            .custom-popup .leaflet-popup-content-wrapper {
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            
            /* Legend styling */
            .legend {
                background: white;
                padding: 12px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                line-height: 20px;
                color: #333;
                border: 1px solid #ddd;
            }
            
            .legend h6 {
                margin: 0 0 10px 0;
                color: #2c3e50;
                font-weight: 600;
                font-size: 14px;
            }
            
            .legend-item {
                margin-bottom: 6px;
                display: flex;
                align-items: center;
                padding: 2px 0;
            }
            
            .legend-item i {
                margin-right: 8px;
                font-size: 16px;
                width: 20px;
                text-align: center;
            }
            
            .legend-item span {
                font-size: 13px;
                font-weight: 500;
            }
            
            /* Statistics panel styling */
            #statisticsPanel {
                max-height: 400px;
                overflow-y: auto;
            }
            
            #statisticsPanel .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            
            #statisticsPanel .card-header {
                background: linear-gradient(135deg, #007bff, #0056b3) !important;
                border-radius: 10px 10px 0 0 !important;
                padding: 12px 16px;
            }
            
            @media (max-width: 768px) {
                #statisticsPanel {
                    position: relative;
                    top: auto;
                    right: auto;
                    margin: 20px;
                    max-width: none;
                }
                
                .custom-marker {
                    font-size: 16px;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</div>

<style>
/* Animation Keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Title Styles */
h2 {
    color: #333333;
    font-weight: 600;
    margin-bottom: 10px;
    animation: fadeInUp 0.4s ease-out;
}

p {
    margin-bottom: 20px;
    animation: fadeInUp 0.4s ease-out 0.1s backwards;
}
</style>
@endsection