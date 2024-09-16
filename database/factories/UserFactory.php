<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\Language;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $imagePath = 'img/host/';
        $imageFiles = File::files(public_path($imagePath));
        $randomImage = $imageFiles[array_rand($imageFiles)];

        // Filtrer les pays qui ont des villes
        $countryWithCities = Country::has('cities')->inRandomOrder()->first();
        $city = $countryWithCities ? City::where('country_id', $countryWithCities->id)->inRandomOrder()->first() : null;
        $language = Language::inRandomOrder()->first();

        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'profile_picture' => $imagePath . $randomImage->getFilename(),
            'country_id' => $countryWithCities,
            'city_id' => $city,
            'language_id' => $language,
            'remember_token' => \Str::random(10),
        ];
    }
}
