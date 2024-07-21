<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Transaction::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            Transaction::factory()->create([
                'user_id' => $reservation->user_id,
                'reservation_id' => $reservation->id,
                'host_id' => $reservation->annonce->host->user_id,
                'quantity' => 1,
                'payment_status' => 'completed',
                'currency' => 'EUR',
                'commission' => $reservation->annonce->price * 0.1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}
