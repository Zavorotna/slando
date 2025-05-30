<?php

namespace Database\Factories;

use App\Models\Size;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductSizeFactory extends Factory
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
            'size_id' => $this->faker->randomElement(Size::pluck('id')),
            'stock' => rand(0, 100),
        ];
    }
}
