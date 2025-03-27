<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vetitesek>
 */
class VetitesekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'available_seats' => $this->faker->numberBetween(50, 200),
            'film_id' => Film::inRandomOrder()->first()->id,  // Random film cím
            //
        ];
    }
}
