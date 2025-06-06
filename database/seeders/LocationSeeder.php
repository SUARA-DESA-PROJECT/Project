<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Bojongsoang',
                // 'latitude' => -6.9557189,
                // 'longitude' => 107.6542139,
            ],
            [
                'name' => 'Cipagalo',
                // 'latitude' => -6.9703054,
                // 'longitude' => 107.6540877,
            ],
            [
                'name' => 'Bojongsari',
                // 'latitude' => -7.000140714274355,
                // 'longitude' => 107.64077167336573,
            ],
            [
                'name' => 'Buahbatu',
                // 'latitude' => -6.94844518508197,
                // 'longitude' => 107.65802673142001,
            ],
            [
                'name' => 'Lengkong',
                // 'latitude' => -6.929528859124897,
                // 'longitude' => 107.62073570085082,
            ],
            [
                'name' => 'Tegalluar',
                // 'latitude' => -6.985540784951629,
                // 'longitude' => 107.69234489851456,
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
