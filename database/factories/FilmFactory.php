<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'age_rating' => $this->faker->randomElement(['Korhatár nélkül', '6', '12', '16', '18']),
            'language' => $this->faker->languageCode,
            'cover_image' => $this->faker->imageUrl(),
            //
        ];
    }
}
