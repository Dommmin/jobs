<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        $salaryFrom = $this->faker->numberBetween(5000, 15000);
        $salaryTo = $salaryFrom + ($salaryFrom * (random_int(25, 50) / 100));
        $createdAt = Carbon::now()->subDays(random_int(1, 30));

        return [
            'title' => $this->faker->jobTitle(),
            'salary_from' => $salaryFrom,
            'salary_to' => (int) $salaryTo,
            'description' => $this->faker->realTextBetween(500, 1000),
            'is_active' => $this->faker->boolean(),
            'tech_stack' => $this->faker->words(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'expire_at' => $createdAt->addDays(array_rand([7, 14, 30])),

            'company_id' => User::inRandomOrder()->value('id'),
        ];
    }
}
