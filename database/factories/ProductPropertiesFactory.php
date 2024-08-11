<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductProperties>
 */
class ProductPropertiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        switch (fake()->randomNumber() % 3) {
            case 0:
                return [
                    'key' => 'цвет',
                    'string_value' => fake()->colorName(),
                ];
            case 1:
                return [
                    'key' => 'размер',
                    'int_value' => fake()->numberBetween(40, 64),
                ];
            default:
                return [
                    'key' => 'пол',
                    'bool_value' => fake()->boolean(),
                ];
        }
    }
}
