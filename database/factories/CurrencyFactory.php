<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Currency::class;
    public function definition(): array
    {
        return [
            'symbol' => $this->faker->word,
            'name' => $this->faker->word,
            'course' => $this->faker->numberBetween(1,100),
            'spending_limit' => $this->faker->boolean,
            'type' => $this->faker->randomElement(['crypto', 'fiat'])
        ];
    }
}
