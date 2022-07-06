<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'isbn' => $this->faker->isbn13,
            'title' => $this->faker->title,
            'year' => $this->faker->year,
            'summary' => $this->faker->sentence(),
            'etat' => $this->faker->randomElement(['good' ,'durty']),
            'status' => $this->faker->randomElement(['available' ,'loan']),
        ];
    }
}
