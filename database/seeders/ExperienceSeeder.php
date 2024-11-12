<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['name' => 'Junior', 'slug' => 'junior'],
            ['name' => 'Mid', 'slug' => 'mid'],
            ['name' => 'Senior', 'slug' => 'senior'],
        ];

        Experience::insert($levels);
    }
}
