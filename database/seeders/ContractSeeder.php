<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = [
          ['name' => 'B2B', 'slug' => 'b2b'],
          ['name' => 'UOP', 'slug' => 'uop'],
          ['name' => 'UZ', 'slug' => 'uz'],
        ];

        Contract::insert($contracts);
    }
}
