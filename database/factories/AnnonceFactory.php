<?php

namespace Database\Factories;

use App\Models\Host;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'schedule' => $this->faker->dateTimeBetween('now', '+1 year'),
            'price' => $this->faker->randomFloat(2, 0.01, 1000),
            'max_guest' => $this->faker->numberBetween(1, 8),
            'cuisine' => 'France', // cuisine must be a valid country name
            'host_id' => Host::factory(), // foreign key
            'country_id' => 21, // Belgium
        ];
    }
}
