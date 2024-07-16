<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\AnnoncePicture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnnoncePicture>
 */
class AnnoncePictureFactory extends Factory
{
    protected $model = AnnoncePicture::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $annonce = Annonce::inRandomOrder()->first();
        $annonceId = $annonce ? $annonce->id : Annonce::factory()->create()->id;

        // Créer le dossier si nécessaire
        $directory = public_path('img/annonces/' . $annonceId);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        return [
            'annonce_id' => $annonceId,
            'path' => 'img/annonces/' . $annonceId . '/photo' . $this->faker->unique()->numberBetween(1, 10000) . '.jpg',
        ];
    }
}
