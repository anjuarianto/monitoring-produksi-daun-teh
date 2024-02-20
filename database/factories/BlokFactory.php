<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blok>
 */
class BlokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => strtoupper($this->faker->randomLetter()).'-'.$this->faker->randomDigit(),
            'luas_areal' => $this->faker->randomFloat(1, 1, 30)
        ];
    }
}
