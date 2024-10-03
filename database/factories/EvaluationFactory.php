<?php

namespace Database\Factories;

use App\Models\Evaluation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    protected $model = Evaluation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $reservation = Reservation::inRandomOrder()->first();
        $host = $reservation->annonce->host->user;
        $guest = $reservation->user;

        // Determine if this evaluation is for the host or the guest
        $isHostEvaluation = $this->faker->boolean;

        $evaluationTemplate = __("profile.evaluationTemplate");


        return [
            'reservation_id' => $reservation->id,
            'reviewer_id' => $isHostEvaluation ? $host->id : $guest->id,
            'reviewee_id' => $isHostEvaluation ? $guest->id : $host->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->randomElement($evaluationTemplate),
        ];
    }
}
