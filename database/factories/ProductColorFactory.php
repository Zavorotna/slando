<?php

namespace Database\Factories;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductColor>
 */
class ProductColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->faker->randomElement(Product::pluck('id')),
            'color_id' => $this->faker->randomElement(Color::pluck('id')),
        ];
    }
}
