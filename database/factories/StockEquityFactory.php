<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StockEquity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockEquity>
 */
class StockEquityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'symbol' => strtoupper($this->faker->word),
            'percentage_stage' => $this->faker->randomFloat(2, 0, 1000),
            'open' => $this->faker->randomFloat(2, 0, 1000),
            'high' => $this->faker->randomFloat(2, 0, 1000),
            'low' => $this->faker->randomFloat(2, 0, 1000),
            'close' => $this->faker->randomFloat(2, 0, 1000),
            'volume' => $this->faker->randomDigit(),
            'refreshed_at' => $this->faker->date
        ];
    }
}
