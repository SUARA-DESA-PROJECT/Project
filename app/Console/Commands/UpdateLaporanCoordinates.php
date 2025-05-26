<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Laporan;

class UpdateLaporanCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laporan:update-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update coordinates for existing laporans';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locationCoordinates = [
            'Bojongsoang' => [-6.9557189, 107.6542139],
            'Cipagalo' => [-6.9703054, 107.6540877],
            'Bojongsari' => [-7.000140714274355, 107.64077167336573],
            'Buahbatu' => [-6.94844518508197, 107.65802673142001],
            'Lengkong' => [-6.929528859124897, 107.62073570085082],
            'Tegalluar' => [-6.985540784951629, 107.69234489851456],
            'Desa Bojongsoang' => [-6.9557189, 107.6542139],
            'Desa Cipagalo' => [-6.9703054, 107.6540877],
            'Desa Bojongsari' => [-7.000140714274355, 107.64077167336573],
            'Desa Buahbatu' => [-6.94844518508197, 107.65802673142001],
            'Desa Lengkong' => [-6.929528859124897, 107.62073570085082],
            'Desa Tegalluar' => [-6.985540784951629, 107.69234489851456]
        ];

        $laporans = Laporan::whereNull('latitude')->orWhereNull('longitude')->get();

        foreach ($laporans as $laporan) {
            $tempat = $laporan->tempat_kejadian;
            
            // Try exact match
            if (isset($locationCoordinates[$tempat])) {
                $laporan->latitude = $locationCoordinates[$tempat][0];
                $laporan->longitude = $locationCoordinates[$tempat][1];
                $laporan->save();
                $this->info("Updated coordinates for laporan: {$laporan->judul_laporan}");
                continue;
            }

            // Try case-insensitive match
            $tempatLower = strtolower($tempat);
            foreach ($locationCoordinates as $key => $coords) {
                if (strtolower($key) === $tempatLower) {
                    $laporan->latitude = $coords[0];
                    $laporan->longitude = $coords[1];
                    $laporan->save();
                    $this->info("Updated coordinates for laporan: {$laporan->judul_laporan}");
                    continue 2;
                }
            }

            // Try partial match
            foreach ($locationCoordinates as $key => $coords) {
                if (stripos($tempat, $key) !== false || stripos($key, $tempat) !== false) {
                    $laporan->latitude = $coords[0];
                    $laporan->longitude = $coords[1];
                    $laporan->save();
                    $this->info("Updated coordinates for laporan: {$laporan->judul_laporan}");
                    continue 2;
                }
            }

            $this->warn("No coordinates found for laporan: {$laporan->judul_laporan} at {$tempat}");
        }

        $this->info('Finished updating coordinates.');
    }
}
