<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $currency = $this->faker->randomElement(['usd', 'eur', 'uah']);
        // $exchangeRates = [
        //     'uah' => '1.00',
        //     'usd' => '40.00',
        //     'eur' => '43.00'
        // ];
        // return [
        //     'currency' => $currency,
        //     'exchange_rate' => $exchangeRates[$currency]
        // ];
        return [];
    }
}
