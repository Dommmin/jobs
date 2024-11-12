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
        $salaryMin = $this->faker->numberBetween(5000, 15000);
        $salaryMax = $salaryMin + ($salaryMin * (rand(25, 50) / 100));
        $createdAt = Carbon::now()->subDays(rand(1, 30));

        return [
            'title' => $this->faker->jobTitle(),
            'salary_min' => $salaryMin,
            'salary_max' => (int) $salaryMax,
            'description' => $this->faker->realTextBetween(500, 1000),
            'is_active' => $this->faker->boolean(),
            'tech_stack' => $this->faker->words(),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'expire_at' => $createdAt->addDays(array_rand([7, 14, 30])),

            'company_id' => User::inRandomOrder()->pluck('id')->first(),
        ];
    }
}
