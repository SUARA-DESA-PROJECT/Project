@extends('layouts.app-warga')

@section('title', 'Persebaran Kejadian')

@section('content')
<div class="container-fluid p-0">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Leaflet Map Container -->
    <div id="map" style="height: calc(100vh - 120px); width: 100%;"></div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <script>
        // Initialize map centered on Bojongsoang area
        var map = L.map('map').setView([-6.9803, 107.6640], 14);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Function to get color based on density value
        function getColor(d) {
            return d > 20 ? '#084594' :
                   d > 15 ? '#2171b5' :
                   d > 10 ? '#4292c6' :
                   d > 5 ? '#6baed6' :
                   d > 1 ? '#9ecae1' :
                              '#c6dbef';
        }

        // Function to style each region
        function style(feature) {
            return {
                fillColor: feature.properties.color || getColor(feature.properties.density),
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        // Function to highlight region on hover
        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });

            if (info) {
                info.update(layer.feature.properties);
            }
        }

        // Function to reset highlight
        function resetHighlight(e) {
            if (geojsonLayer) {
                geojsonLayer.resetStyle(e.target);
            }
            if (info) {
                info.update();
            }
        }

        // Function to zoom to region on click
        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        // Function to add listeners to region layers
        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
            
            // Add a label with the region name
            layer.bindTooltip(feature.properties.name, {
                permanent: true,
                direction: 'center',
                className: 'region-label'
            });
        }

        // Create info control
        var info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };

        info.update = function (props) {
            this._div.innerHTML = '<h4>Persebaran Kejadian</h4>' +  (props ?
                '<b>' + props.name + '</b><br />' + props.density + ' kejadian'
                : 'Arahkan kursor ke wilayah');
        };

        info.addTo(map);

        // Create legend control
        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 1, 5, 10, 15, 20],
                labels = [];

            // Loop through density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                div.innerHTML +=
                    '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                    grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
            }

            return div;
        };

        legend.addTo(map);

        // Add CSS for info and legend
        var style = document.createElement('style');
        style.innerHTML = `
            .info {
                padding: 6px 8px;
                font: 14px/16px Arial, Helvetica, sans-serif;
                background: white;
                background: rgba(255,255,255,0.8);
                box-shadow: 0 0 15px rgba(0,0,0,0.2);
                border-radius: 5px;
            }
            .info h4 {
                margin: 0 0 5px;
                color: #777;
            }
            .legend {
                line-height: 18px;
                color: #555;
            }
            .legend i {
                width: 18px;
                height: 18px;
                float: left;
                margin-right: 8px;
                opacity: 0.7;
            }
            .region-label {
                background: transparent;
                border: none;
                box-shadow: none;
                font-weight: bold;
                font-size: 14px;
                text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;
            }
        `;
        document.head.appendChild(style);

        var geojsonLayer;
        
        // Use the static JSON file with fixed data
        fetch('/regions-data.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log("GeoJSON data:", data);
                
                // Add GeoJSON layer to map
                try {
                    geojsonLayer = L.geoJson(data, {
                        style: style,
                        onEachFeature: onEachFeature
                    }).addTo(map);
                    
                    // Fit map to the bounds of all regions
                    if (geojsonLayer.getBounds) {
                        map.fitBounds(geojsonLayer.getBounds());
                    }
                } catch (e) {
                    console.error("Error creating GeoJSON layer:", e);
                    alert('Error creating GeoJSON layer: ' + e.message);
                }
            })
            .catch(error => {
                console.error('Error fetching GeoJSON data:', error);
                alert('Failed to load region data. Please check the console for details.');
            });
    </script>
</div>
@endsection