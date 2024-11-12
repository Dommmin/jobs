<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Warszawa', 'slug' => 'warszawa'],
            ['name' => 'Wrocław', 'slug' => 'wroclaw'],
            ['name' => 'Łódź', 'slug' => 'lodz'],
            ['name' => 'Gdańsk', 'slug' => 'gdansk'],
            ['name' => 'Bydgoszcz', 'slug' => 'bydgoszcz'],
            ['name' => 'Lublin', 'slug' => 'lublin'],
            ['name' => 'Katowice', 'slug' => 'katowice'],
            ['name' => 'Poznań', 'slug' => 'poznan'],
            ['name' => 'Kraków', 'slug' => 'krakow'],
        ];

        Location::insert($locations);
    }
}
