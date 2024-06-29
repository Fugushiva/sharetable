<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Reservation::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $reservations = [
            [
                'annonce_title' => 'Venez découvrir la cuisine italienne',
                'user_name' => 'Bob',
                'reservation_date' => Carbon::create(now()),
            ],
            [
                'annonce_title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'user_name' => 'Jerome',
                'reservation_date' => Carbon::create(now()),
            ],
            [
                'annonce_title' => 'Venez découvrir la cuisine italienne',
                'user_name' => 'Chen',
                'reservation_date' => Carbon::create(now()),
            ],
            [
                'annonce_title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'user_name' => 'Bob',
                'reservation_date' => Carbon::create(now()),
            ],
        ];

        foreach($reservations as &$reservation){
            $annonce = Annonce::where([
                ['title', '=', $reservation['annonce_title']]
            ])->first();
            $user = User::where([
                ['firstname', '=', $reservation['user_name']]
            ])->first();

            $reservation['annonce_id'] = $annonce->id;
            $reservation['user_id'] = $user->id;

            unset($reservation['annonce_title']);
            unset($reservation['user_name']);
        }

        DB::table('reservations')->insert($reservations);

    }
}
