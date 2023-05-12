<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

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
    public function definition(): array
    {
        $datetime = fake()->date() . ' ' . fake()->time();

        return [
            'user_id' => User::all()->random()->id,
            'title' => $this->faker->realText($manNbChars = 30),
            'published' => $datetime,
            'author' => fake()->name(),
            'description' => $this->faker->realText($maxNbChar = 100),
            'isbn' => $this->faker->isbn10(),
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];
    }
}
