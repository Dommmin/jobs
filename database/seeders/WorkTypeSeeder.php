<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Remote', 'slug' => 'remote'],
            ['name' => 'Hybrid', 'slug' => 'hybrid'],
            ['name' => 'Office', 'slug' => 'office'],
        ];

        WorkType::insert($types);
    }
}
