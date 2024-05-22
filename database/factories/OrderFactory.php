<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currency = Currency::query()->inRandomOrder()->first();
        $currency1 = Currency::query()->inRandomOrder()->first();
        return [
            'username' => $this->faker->name(),
            'orders' => $this->faker->numberBetween(1, 1000),
            'completion' => $this->faker->numberBetween(1, 1000),
            'available' => $this->faker->numberBetween(1, 1000),
            'feedback' => $this->faker->numberBetween(1, 1000),
            'minimal_payment' => $this->faker->numberBetween(1, 4),
            'qr_code' => 'hQJ8o8FweRXrkCcbPVycFhCzkIhmg0vGd1dfEZB8.png',
            'сredentials' => $this->faker->creditCardNumber(),
            'currency_from' => $currency->id,
            'currency_to' => $currency1->id,
            'limit' => $this->faker->numberBetween(1, 1000),
            'bestPrice' => $this->faker->boolean(),
            'AutoMode' => $this->faker->boolean(),
        ];
    }
}
