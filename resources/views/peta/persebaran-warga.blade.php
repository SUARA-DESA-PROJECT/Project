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
    <div id="map" style="height: calc(100vh - 300px); width: 100%;"></div>

    <!-- Statistics Panel - Moved below map -->
    <div class="container-fluid mt-4 px-4">
        <div class="row">
            <div class="col-12">
                <div id="statisticsPanel" class="w-100">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Laporan</h6>
                        </div>
                        <div class="card-body p-4">
                            <div id="statisticsContent" class="row">
                                <div class="col-12 text-center">
                                    <p class="text-muted">Memuat statistik...</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                // { color: '#20c997', label: 'Diverifikasi' },
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

        // Load statistics - Updated with cleaner layout and proper alignment
        function loadStatistics() {
            fetch('{{ route("api.map-statistics") }}')
                .then(response => response.json())
                .then(stats => {
                    const content = `
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="stat-card-main h-100 d-flex align-items-center">
                                <div class="card-body text-center w-100">
                                    <div class="stat-icon mb-3">
                                        <i class="fas fa-file-alt fa-2x"></i>
                                    </div>
                                    <h3 class="stat-number">${stats.total_laporan}</h3>
                                    <p class="stat-label mb-0">Total Laporan</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="stat-card-secondary h-100">
                                <div class="card-header text-center">
                                    <h6 class="mb-0"><i class="fas fa-check-circle me-2"></i>Status Verifikasi</h6>
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-success">${stats.by_verification.diverifikasi}</div>
                                                    <div class="mini-stat-label">Diverifikasi</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-danger">${stats.by_verification.ditolak}</div>
                                                    <div class="mini-stat-label">Ditolak</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-secondary">${stats.by_verification.belum_diverifikasi}</div>
                                                    <div class="mini-stat-label">Belum Diverifikasi</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-12 mb-4">
                            <div class="stat-card-secondary h-100">
                                <div class="card-header text-center">
                                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Status Penanganan</h6>
                                </div>
                                <div class="card-body d-flex align-items-center">
                                    <div class="w-100">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-success">${stats.by_handling.sudah_ditangani}</div>
                                                    <div class="mini-stat-label">Sudah Ditangani</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-warning">${stats.by_handling.belum_ditangani}</div>
                                                    <div class="mini-stat-label">Belum Ditangani</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mini-stat">
                                                    <div class="mini-stat-number text-info">${stats.by_handling.sedang_ditangani}</div>
                                                    <div class="mini-stat-label">Sedang Ditangani</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    document.getElementById('statisticsContent').innerHTML = content;
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                    document.getElementById('statisticsContent').innerHTML = '<div class="col-12"><p class="text-danger text-center">Gagal memuat statistik</p></div>';
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
            
            /* Clean Statistics Panel Styling - Updated with colors from index.blade.php */
            #statisticsPanel .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 2px 15px rgba(0,0,0,0.08);
                margin-bottom: 0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                animation: scaleIn 0.4s ease-out;
            }
            
            #statisticsPanel .card-header {
                background: #468B94 !important;
                border-radius: 12px 12px 0 0 !important;
                padding: 15px 20px;
                border: none;
                color: white !important;
            }
            
            /* Main Statistics Card - Better vertical centering */
            .stat-card-main {
                background: linear-gradient(135deg, #fff, #f8f9fa);
                border: 2px solid #468B94;
                border-radius: 12px;
                transition: all 0.3s ease;
                box-shadow: 0 2px 15px rgba(70, 139, 148, 0.08);
                min-height: 220px;
            }
            
            .stat-card-main:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(70, 139, 148, 0.25);
                border-color: #3a7a82;
            }
            
            .stat-card-main .card-body {
                padding: 35px 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
                min-height: 220px;
            }
            
            .stat-icon {
                width: 70px;
                height: 70px;
                background: #468B94;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px auto;
                color: white;
            }
            
            .stat-number {
                font-size: 2.8rem;
                font-weight: 700;
                margin: 15px 0 10px 0;
                line-height: 1;
                color: #468B94;
            }
            
            .stat-label {
                font-size: 1.1rem;
                color: #495057;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0;
            }
            
            /* Secondary Statistics Cards - Better vertical centering */
            .stat-card-secondary {
                background: white;
                border: 1px solid #e9ecef;
                border-radius: 12px;
                transition: all 0.3s ease;
                box-shadow: 0 2px 15px rgba(0,0,0,0.08);
                min-height: 220px;
                display: flex;
                flex-direction: column;
            }
            
            .stat-card-secondary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
                border-color: #468B94;
            }
            
            .stat-card-secondary .card-header {
                background: #468B94 !important;
                border-bottom: none;
                border-radius: 12px 12px 0 0 !important;
                padding: 15px 20px;
                color: white !important;
                flex-shrink: 0;
            }
            
            .stat-card-secondary .card-header h6 {
                color: white !important;
                font-weight: 600;
                margin: 0;
                font-size: 1rem;
            }
            
            .stat-card-secondary .card-body {
                padding: 25px 20px;
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Mini Statistics - Perfect vertical centering */
            .mini-stat {
                padding: 20px 8px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100%;
                min-height: 120px;
            }
            
            .mini-stat-number {
                font-size: 2.4rem;
                font-weight: 700;
                line-height: 1;
                margin-bottom: 12px;
                display: block;
            }
            
            .mini-stat-label {
                font-size: 0.95rem;
                color: #6c757d;
                font-weight: 500;
                line-height: 1.2;
                text-align: center;
                margin: 0;
            }
            
            /* Ensure proper row alignment */
            .row.text-center {
                display: flex;
                align-items: stretch;
            }
            
            .row.text-center .col-4 {
                display: flex;
                align-items: stretch;
            }
            
            /* Equal height cards and proper vertical centering */
            .row.align-items-stretch {
                display: flex;
                align-items: stretch;
            }
            
            .h-100 {
                height: 100% !important;
            }
            
            .d-flex.align-items-center {
                display: flex !important;
                align-items: center !important;
                min-height: 160px;
            }
            
            .w-100 {
                width: 100% !important;
            }
            
            /* Animation keyframes */
            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
            
            /* Responsive Design */
            @media (max-width: 992px) {
                .stat-card-main,
                .stat-card-secondary {
                    min-height: 200px;
                }
                
                .stat-card-main .card-body {
                    min-height: 200px;
                    padding: 30px 20px;
                }
                
                .stat-number {
                    font-size: 2.4rem;
                }
                
                .mini-stat-number {
                    font-size: 2.2rem;
                }
                
                .mini-stat {
                    min-height: 100px;
                    padding: 18px 8px;
                }
                
                .stat-icon {
                    width: 60px;
                    height: 60px;
                }
            }
            
            @media (max-width: 768px) {
                .custom-marker {
                    font-size: 16px;
                }
                
                .stat-card-main,
                .stat-card-secondary {
                    min-height: 180px;
                    margin-bottom: 20px;
                }
                
                .stat-card-main .card-body {
                    min-height: 180px;
                    padding: 25px 15px;
                }
                
                .stat-number {
                    font-size: 2.2rem;
                    margin: 12px 0 8px 0;
                }
                
                .mini-stat-number {
                    font-size: 2rem;
                }
                
                .mini-stat {
                    min-height: 90px;
                    padding: 15px 6px;
                }
                
                .stat-card-secondary .card-body {
                    padding: 20px 15px;
                }
                
                .stat-icon {
                    width: 50px;
                    height: 50px;
                    margin-bottom: 12px;
                }
            }
            
            @media (max-width: 576px) {
                .mini-stat {
                    padding: 12px 4px;
                    min-height: 80px;
                }
                
                .mini-stat-label {
                    font-size: 0.85rem;
                }
                
                .mini-stat-number {
                    font-size: 1.8rem;
                    margin-bottom: 8px;
                }
                
                .stat-card-main,
                .stat-card-secondary {
                    min-height: 160px;
                }
                
                .stat-card-main .card-body {
                    min-height: 160px;
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