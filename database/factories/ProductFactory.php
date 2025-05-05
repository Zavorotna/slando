<?php

namespace Database\Factories;

use App\Models\Rate;
use App\Models\Subsubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_subcategory_id' => $this->faker->randomElement(Subsubcategory::pluck('id')),
            'currency_id' => $this->faker->randomElement(Rate::pluck('id')),
            'title' => $this->faker->text(50),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'saleprice' => $this->faker->randomFloat(2, 100, 10000),
            'availability' => $this->faker->randomElement(['available', 'not available']),
            'discount' => rand(0, 100),
            'orders_count' => rand(0, 10)
        ];
    }
}
