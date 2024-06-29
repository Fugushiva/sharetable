<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnoncePicture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AnnoncePictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        AnnoncePicture::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        //path => img/annonces/user_id/pictureName

        $dataset = [
            [
                'annonce_title' => 'Venez découvrir la cuisine italienne',
                'path' => 'img/annonces/1/photo1.jpg'
            ],
            [
                'annonce_title' => 'Venez découvrir la cuisine italienne',
                'path' => 'img/annonces/1/photo2.jpg'
            ],
            [
                'annonce_title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'path' => 'img/annonces/2/photo1.jpg'
            ],
            [
                'annonce_title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'path' => 'img/annonces/2/photo2.jpg'
            ],
            [
                'annonce_title' => 'Discover the Flavors: Exploring Padang Cuisine',
                'path' => 'img/annonces/2/photo3.jpg'
            ],
            [
                'annonce_title' => 'Experience the Art of Cantonese Cuisine',
                'path' => 'img/annonces/3/photo1.jpg'
            ],
            [
                'annonce_title' => 'Experience the Art of Cantonese Cuisine',
                'path' => 'img/annonces/3/photo2.jpg'
            ],
            [
                'annonce_title' => 'Experience the Art of Cantonese Cuisine',
                'path' => 'img/annonces/3/photo3.jpg'
            ],
        ];

        foreach($dataset as &$data){
            $annonce = Annonce::where([
                ['title', '=', $data['annonce_title']]
            ])->first();

            $data['annonce_id'] = $annonce->id;

            // Créer le dossier si nécessaire
            $directory = public_path('img/annonces/' . $annonce->id);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            unset($data['annonce_title']);
        }

        DB::table('annonces_pictures')->insert($dataset);
    }
}
