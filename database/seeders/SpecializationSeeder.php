<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'Java', 'slug' => 'java'],
            ['name' => 'C#', 'slug' => 'c#'],
            ['name' => 'Python', 'slug' => 'python'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'C++', 'slug' => 'c++'],
            ['name' => 'C', 'slug' => 'c'],
            ['name' => 'Ruby', 'slug' => 'ruby'],
            ['name' => 'Go', 'slug' => 'go'],
            ['name' => 'Swift', 'slug' => 'swift'],
            ['name' => 'TypeScript', 'slug' => 'typescript'],
            ['name' => 'Kotlin', 'slug' => 'kotlin'],
        ];

        Specialization::insert($specializations);
    }
}
