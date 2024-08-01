<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //get all reservations
        $reservations = Reservation::all();

        foreach ($reservations as $reservation){
            $host = $reservation->annonce->host->user;
            $guest = $reservation->user;

            Evaluation::factory()->create([
                'reservation_id' => $reservation->id,
                'reviewer_id' => $host->id,
                'reviewee_id' => $guest->id,
            ]);

            Evaluation::factory()->create([
                'reservation_id' => $reservation->id,
                'reviewer_id' => $guest->id,
                'reviewee_id' => $host->id,
            ]);
        }
    }
}
