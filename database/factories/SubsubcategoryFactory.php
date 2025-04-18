<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subsubcategory>
 */
class SubsubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->unique()->word();
        return [
            'subcategory_id' => $this->faker->randomElement(Subcategory::pluck('id')),
            'title' => $title,
            'slug' => str($title)->slug()
        ];
    }
}
