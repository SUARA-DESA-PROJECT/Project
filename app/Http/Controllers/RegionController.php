<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function getRegionsGeoJson()
    {
        // Get locations from the database
        $locations = Location::all();
        
        // Define GeoJSON structure
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];
        
        // Define the specific regions with more accurate boundaries
        $regionBoundaries = [
            'Bojongsari' => [
                'coordinates' => [[[107.6270, -6.9815], [107.6330, -6.9838], [107.6350, -6.9900], [107.6300, -6.9950], [107.6220, -6.9930], [107.6210, -6.9850], [107.6270, -6.9815]]],
                'center' => [107.6280, -6.9880],
                'color' => '#FF5733'
            ],
            'Bojongsoang' => [
                'coordinates' => [[[107.6400, -6.9715], [107.6475, -6.9750], [107.6490, -6.9820], [107.6460, -6.9880], [107.6360, -6.9860], [107.6340, -6.9780], [107.6400, -6.9715]]],
                'center' => [107.6420, -6.9800],
                'color' => '#33A8FF'
            ],
            'Buahbatu' => [
                'coordinates' => [[[107.6350, -6.9480], [107.6395, -6.9495], [107.6410, -6.9520], [107.6390, -6.9560], [107.6340, -6.9570], [107.6310, -6.9540], [107.6350, -6.9480]]],
                'center' => [107.6360, -6.9525],
                'color' => '#33FF57'
            ],
            'Cipagalo' => [
                'coordinates' => [[[107.6440, -6.9650], [107.6470, -6.9630], [107.6490, -6.9600], [107.6470, -6.9570], [107.6420, -6.9560], [107.6390, -6.9600], [107.6440, -6.9650]]],
                'center' => [107.6440, -6.9600],
                'color' => '#A833FF'
            ],
            'Lengkong' => [
                'coordinates' => [[[107.6190, -6.9390], [107.6250, -6.9395], [107.6270, -6.9430], [107.6240, -6.9470], [107.6200, -6.9475], [107.6170, -6.9440], [107.6190, -6.9390]]],
                'center' => [107.6220, -6.9430],
                'color' => '#FF33A8'
            ],
            'Tegalluar' => [
                'coordinates' => [[[107.6840, -6.9650], [107.6900, -6.9630], [107.6920, -6.9680], [107.6880, -6.9720], [107.6820, -6.9710], [107.6800, -6.9670], [107.6840, -6.9650]]],
                'center' => [107.6860, -6.9680],
                'color' => '#FFBD33'
            ]
        ];
        
        // Create GeoJSON features for each region
        foreach ($regionBoundaries as $regionName => $boundary) {
            // Generate random dummy data between 100-1000
            $dummyCount = rand(100, 1000);
            
            $geojson['features'][] = [
                'type' => 'Feature',
                'properties' => [
                    'name' => $regionName,
                    'density' => $dummyCount,
                    'color' => $boundary['color']
                ],
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => $boundary['coordinates']
                ]
            ];
        }
        
        return response()->json($geojson);
    }
    
    /**
     * Calculate distance between two points using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earthRadius = 6371; // Radius of the earth in km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;
        
        return $distance;
    }
    
    public function getIncidentCounts()
    {
        try {
            // Get counts of incidents by region
            $counts = [];
            
            // Query the database to count incidents by region
            $results = Laporan::select('tempat_kejadian', DB::raw('count(*) as total'))
                ->groupBy('tempat_kejadian')
                ->get();
            
            // Map region names to standardized names
            $regionMapping = [
                'Bojongsari' => ['bojongsari', 'desa bojongsari', 'kelurahan bojongsari'],
                'Bojongsoang' => ['bojongsoang', 'desa bojongsoang', 'kelurahan bojongsoang'],
                'Buahbatu' => ['buahbatu', 'desa buahbatu', 'kelurahan buahbatu'],
                'Cipagalo' => ['cipagalo', 'desa cipagalo', 'kelurahan cipagalo'],
                'Lengkong' => ['lengkong', 'desa lengkong', 'kelurahan lengkong'],
                'Tegalluar' => ['tegalluar', 'desa tegalluar', 'kelurahan tegalluar']
            ];
            
            // Initialize counts for all regions to 0
            foreach ($regionMapping as $region => $aliases) {
                $counts[$region] = 0;
            }
            
            // Count incidents for each region
            foreach ($results as $result) {
                if ($result->tempat_kejadian) {
                    $location = strtolower($result->tempat_kejadian);
                    
                    foreach ($regionMapping as $region => $aliases) {
                        foreach ($aliases as $alias) {
                            if (strpos($location, $alias) !== false) {
                                $counts[$region] += $result->total;
                                break 2; // Break out of both loops once a match is found
                            }
                        }
                    }
                }
            }
            
            return response()->json($counts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}