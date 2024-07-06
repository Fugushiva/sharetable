<?php

namespace Database\Seeders;

use App\Models\AnnoncePicture;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();
        $this->call(
            [

                UserSeeder::class,
                RoleSeeder::class,
                RoleUserSeeder::class,
                ProfileSeeder::class,
                ProfileUserSeeder::class,
                HostSeeder::class,
                AnnonceSeeder::class,
                ReservationSeeder::class,
                AnnoncePictureSeeder::class,
                TransactionSeeder::class,

            ]
        );

    }
}
