<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Color>
 */
class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $names = [
            'Червоний', 'Зелений', 'Синій', 'Жовтий', 'Фіолетовий', 'Блакитний', 'Білий', 'Чорний',
            'Помаранчевий', 'Коричневий', 'Рожевий', 'Сірий', 'Золотий', 'Срібний', 'Лимонний', 'Оливковий',
        ];

        $name = array_shift($names);

        static $hexes = [
            '#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ffffff', '#000000',
            '#ffa500', '#a52a2a', '#ffc0cb', '#808080', '#ffd700', '#c0c0c0', '#fff700', '#808000',
        ];

        $hex = array_shift($hexes);

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
            'hex' => $hex,
        ];
    }
}
