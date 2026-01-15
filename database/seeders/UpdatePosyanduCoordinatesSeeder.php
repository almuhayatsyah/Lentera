<?php

namespace Database\Seeders;

use App\Models\Posyandu;
use Illuminate\Database\Seeder;

class UpdatePosyanduCoordinatesSeeder extends Seeder
{
    /**
     * Update posyandu coordinates for Leaflet map.
     */
    public function run(): void
    {
        // Koordinat sample area Bandung
        $coordinates = [
            1 => ['latitude' => -6.9175, 'longitude' => 107.6191],
            2 => ['latitude' => -6.9180, 'longitude' => 107.6210],
            3 => ['latitude' => -6.9200, 'longitude' => 107.6230],
        ];

        foreach ($coordinates as $id => $coords) {
            Posyandu::where('id', $id)->update($coords);
        }

        $this->command->info('Posyandu coordinates updated!');
    }
}
