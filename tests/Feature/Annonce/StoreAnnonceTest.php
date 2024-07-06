<?php

namespace Annonce;

use App\Models\Annonce;
use App\Models\Host;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAnnonceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        //$this->artisan('db:seed', ['--class' => 'WorldSeeder', '--env' => 'testing']);
        //$this->artisan('db:seed', ['--env' => 'testing']);
    }

    public function test_store_annonce(): void
    {
        // Simuler le stockage des fichiers
        Storage::fake('public');

        // Créer un utilisateur et un hôte associé
        $user = User::factory()->create();
        $host = Host::factory()->create(['user_id' => $user->id]);

        // Authentifier l'utilisateur
        $this->actingAs($user);

        // Créer des fichiers simulés pour les images
        $pictures = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg')
        ];

        // Les données de la requête
        $data = [
            'title' => 'Test Annonce',
            'description' => 'Test Description de l\'annonce & Test Description de l\'annonce',
            'schedule' => now()->addDays(10),
            'price' => 100.00,
            'max_guest' => 4,
            'cuisine' => 'France',
            'country_id' => 21, // Belgium
            'pictures' => $pictures,
        ];

        // Exécuter la requête POST vers la méthode store
        $response = $this->post(route('annonce.store'), $data);

        // Vérifier que l'annonce a été créée dans la base de données
        $this->assertDatabaseHas('annonces', [
            'cuisine' => 'France',
        ]);

        // Récupérer l'annonce récemment créée
        $annonce = Annonce::where('title', 'Test Annonce')->first();

        // Appeler la méthode uploadPictures sur l'annonce
        $uploadedFiles = [];
        foreach ($pictures as $picture) {
            $filename = generateUniqueImageName($picture);
            $path = "img/annonces/{$annonce->id}/{$filename}";
            Storage::disk('public')->put($path, file_get_contents($picture));
            $uploadedFiles[] = $filename;
        }



        // Vérifier que les images ont été enregistrées dans le bon dossier
        foreach ($uploadedFiles as $picture) {
            Storage::disk('public')->assertExists("img/annonces/{$annonce->id}/$filename" );
        }

        // Vérifier la redirection et le message de succès
        $response->assertRedirect(route('annonce.index'));
        $response->assertSessionHas('success', 'Annonce créée avec succès');
    }
}
