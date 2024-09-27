<?php

namespace Database\Factories;

use App\Models\Host;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nnjeim\World\Models\Country;
use Psy\Util\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random host or create one if none exists
        $host = Host::inRandomOrder()->first() ?? Host::factory()->create();
        $user = $host->user;

        // Tableaux pour les modèles de titre et description
        $titleTemplates = __("annonce.title_templates");
        $descriptionTemplates = __("annonce.description_templates");

        // Génération de titre et description
        $title = $this->faker->randomElement($titleTemplates);
        $description = $this->faker->randomElement($descriptionTemplates);

        // Remplacement des variables dynamiques
        $title = str_replace(
            [':city', ':cuisine', ':host'],
            [$user->city->name, Country::inRandomOrder()->first()->name, $host->user->name],
            $title
        );

        $description = str_replace(
            [':city', ':cuisine', ':host'],
            [$user->city->name, Country::inRandomOrder()->first()->name, $host->user->name],
            $description
        );

        return [
            'title' => substr($title, 0, 40), // max 40 characters
            'description' => $description,
            'schedule' => $this->faker->dateTimeBetween('-3months', '+1 year'),
            'price' => $this->faker->randomFloat(2, 10, 50),
            'max_guest' => $this->faker->numberBetween(1, 8),
            'cuisine' => Country::inRandomOrder()->first()->iso2 ?? 21, // Belgium
            'host_id' => $host->id, // foreign key
            'country_id' => $user->country_id,
        ];
    }
}

