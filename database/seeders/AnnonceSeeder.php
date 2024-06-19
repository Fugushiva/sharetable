<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Host;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nnjeim\World\Models\Country;

class AnnonceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Annonce::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $annonces = [
            [
                'host_birthdate' => Carbon::create(1990,11,21),
                'country_name' => 'Belgium',
                'title' => 'Venez découvrir la cuisine italienne',
                'description' => "J'ai grandit avec une maman italienne, je connais tout ce qu'il faut pur vous rendre fou de cette cuisine",
                'schedule' => Carbon::create(2024, 12, 06),
                'max_guest' => 4,
                'picture_name' => 'BA65D785-D807-4DA7-8D83-54E56562F52B.jpg',
                'price' => 50
            ],

            [
                'host_birthdate' => Carbon::create(1995,8,30),
                'country_name' => 'Indonesia',
                'title' => 'Discover the heart of Sumatra cuisine',
                'description' => "Best cuisine in Indonesia, Sumatra is the hearth of spices",
                'schedule' => Carbon::create(2024, 10, 03),
                'max_guest' => 4,
                'picture_name' => 'Rendang.jpg',
                'price' => '20'
            ],
            [
            'host_birthdate' => Carbon::create(1995,8,30),
            'country_name' => 'Indonesia',
            'title' => 'chinese cuisine discover',
            'description' => "ching chong",
            'schedule' => Carbon::create(2024, 10, 03),
            'max_guest' => 1,
            'picture_name' => 'Rendang.jpg',
            'price' => '20'
        ]
        ];

        foreach($annonces as &$annonce){
            $host = Host::where([
                ['birthdate', '=', $annonce['host_birthdate']]
            ])->first();
            $country = Country::where([
                ['name', '=', $annonce['country_name']]
            ])->first();

            $annonce['host_id'] = $host->id;
            $annonce['country_id'] = $country->id;

            unset($annonce['host_birthdate']);
            unset($annonce['country_name']);
        }

        DB::table('annonces')->insert($annonces);
    }
}
