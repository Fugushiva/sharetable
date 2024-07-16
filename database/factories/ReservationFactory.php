<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random annonce or create one if none exists
        $annonce = Annonce::inRandomOrder()->first() ?? Annonce::factory()->create();
        // Get a random user or create one if none exists and make sure it's not the host of the annonce
        $user = User::inRandomOrder()->where('id', '!=', $annonce->host->user_id)->first() ?? User::factory()->create();
        return [
            'annonce_id' => $annonce->id,
            'user_id' => $user->id,
        ];
    }
}
