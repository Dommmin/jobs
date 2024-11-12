<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Experience;
use App\Models\Location;
use App\Models\Offer;
use App\Models\Specialization;
use App\Models\WorkType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 100;
        $consoleOutput = $this->command->getOutput();
        $consoleOutput->progressStart($total);

        Offer::factory($total)->create([
            'tech_stack' => ['php', 'laravel'],
        ])->each(function ($offer) use ($consoleOutput) {
            $locations = Location::inRandomOrder()->take(rand(1, 4))->pluck('id')->toArray();
            $experiences = Experience::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $contracts = Contract::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $specializations = Specialization::inRandomOrder()->take(rand(1, 2))->pluck('id')->toArray();
            $workTypes = WorkType::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();

            $offer->locations()->sync($locations);
            $offer->experiences()->sync($experiences);
            $offer->contracts()->sync($contracts);
            $offer->specializations()->sync($specializations);
            $offer->workTypes()->sync($workTypes);

            $consoleOutput->progressAdvance();
        });

        $consoleOutput->progressFinish();
    }
}
