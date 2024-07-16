<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnoncePicture;
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

        // Chemin vers les images de test
        $testImagesPath = resource_path('test-images/annonces');

        // Créer le dossier des images de test s'il n'existe pas
        if (!File::exists($testImagesPath)) {
            File::makeDirectory($testImagesPath, 0755, true);
            // Ajouter des images de test par défaut
            $defaultImages = ['test1.jpg', 'test2.jpg', 'test3.jpg']; // Noms des images par défaut

            foreach ($defaultImages as $image) {
                $sourcePath = public_path('default-images/' . $image); // Chemin des images par défaut
                $destinationPath = $testImagesPath . '/' . $image;
                if (File::exists($sourcePath)) {
                    File::copy($sourcePath, $destinationPath);
                } else {
                    // Créer une image par défaut si elle n'existe pas
                    File::put($destinationPath, 'This is a placeholder image content.');
                }
            }
        }

        // Créer les images pour chaque annonce
        $annonces = Annonce::all();

        foreach ($annonces as $annonce) {
            // Créer le dossier si nécessaire
            $directory = public_path('img/annonces/' . $annonce->id);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Copier une image de test dans le dossier créé
            $testImage = File::files($testImagesPath)[array_rand(File::files($testImagesPath))];
            $destinationPath = $directory . '/photo1.jpg';
            File::copy($testImage->getRealPath(), $destinationPath);

            // Créer un enregistrement AnnoncePicture
            AnnoncePicture::create([
                'annonce_id' => $annonce->id,
                'path' => 'img/annonces/' . $annonce->id . '/photo1.jpg'
            ]);

            // Créer des photos supplémentaires pour chaque annonce (par exemple, entre 1 et 3 photos supplémentaires)
            $additionalPhotosCount = rand(1, 3);
            for ($i = 2; $i <= $additionalPhotosCount + 1; $i++) {
                $testImage = File::files($testImagesPath)[array_rand(File::files($testImagesPath))];
                $destinationPath = $directory . '/photo' . $i . '.jpg';
                File::copy($testImage->getRealPath(), $destinationPath);

                // Créer un enregistrement AnnoncePicture
                AnnoncePicture::create([
                    'annonce_id' => $annonce->id,
                    'path' => 'img/annonces/' . $annonce->id . '/photo' . $i . '.jpg'
                ]);
            }
        }
    }
}


