<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnoncePicture;
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
                'host_birthdate' => Carbon::create(1990, 11, 21),
                'country_name' => 'Belgium',
                'title' => 'Venez découvrir la cuisine italienne',
                'cuisine' => 'Italian',
                'description' => "J'ai grandit avec une maman italienne, je connais tout ce qu'il faut pur vous rendre fou de cette cuisine",
                'schedule' => Carbon::create(now()->addDays(5)),
                'max_guest' => 4,
                'price' => 50
            ],

            [
                'host_birthdate' => Carbon::create(1995, 8, 30),
                'country_name' => 'Indonesia',
                'title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'cuisine' => 'Indonesian',
                'description' => "Padang cuisine, from the Minangkabau region in Indonesia, is renowned for its bold and spicy flavors. It features a variety of dishes served in small portions, typically with rice. Key ingredients include coconut milk, chili, turmeric, and tamarind. Signature dishes include rendang (spicy stewed beef) and sambal balado (spicy chili sauce). Presentation is important, with dishes arranged for diners to sample a wide array of flavors.",
                'schedule' => Carbon::create(now()->addDays(10)),
                'max_guest' => 4,
                'price' => '20'
            ],
            [
                'host_birthdate' => Carbon::create(1992, 8, 30),
                'country_name' => 'China',
                'title' => 'Experience the Art of Cantonese Cuisine',
                'cuisine' => 'Chinese',
                'description' => "Cantonese cuisine, originating from Guangdong province in China, is known for its subtle flavors and fresh ingredients. It emphasizes preserving the natural taste of the ingredients, using minimal spices. Signature dishes include dim sum, roasted meats, and seafood. Steaming and stir-frying are common cooking methods, and presentation is elegant, highlighting the colors and textures of the food. Cantonese cuisine is highly regarded for its balance and variety, offering a diverse array of soups, noodles, and rice dishes.",
                'schedule' => Carbon::create(now()->addDays(8)),
                'max_guest' => 1,
                'price' => '20'
            ]
        ];

        AnnoncePicture::factory()->count(20)->create();

        Annonce::factory()->count(50)->create();

        foreach ($annonces as &$annonce) {
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
