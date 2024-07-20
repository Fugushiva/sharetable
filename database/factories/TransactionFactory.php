<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reservation = Reservation::inRandomOrder()->first() ?? Reservation::factory()->create();
        return [
            'user_id' => $reservation->user_id,
            'reservation_id' => $reservation->id,
            'host_id' => $reservation->annonce->host->user_id,
            'quantity' => 1,
            'payment_status' => 'completed',
            'currency' => 'EUR',
            'stripe_transaction_id' => $this->faker->uuid,
            'commission' => $reservation->annonce->price * 0.1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
