<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $letterSizes = [
            'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',
        ];
        $size = $this->faker->unique()->randomElement([
            rand(1,50) . '-' . rand(51, 100),
            rand(1,50) . '-' . rand(51, 100),
            rand(1,100),
            rand(1,100),
            rand(1,100),
            $this->faker->randomElement($letterSizes),
        ]);
        return [
            'name' => $size,
        ];

    }
}
