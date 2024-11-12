<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 100;
        $consoleOutput = $this->command->getOutput();
        $consoleOutput->progressStart($total);

        User::factory()
            ->count($total)
            ->make()
            ->each(function ($user) use ($consoleOutput) {
                $user->save();
                $consoleOutput->progressAdvance();
            });

        $consoleOutput->progressFinish();
    }
}
