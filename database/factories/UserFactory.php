<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\City;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // List of available images
        $images = [
            'alex.jpg',
            'annie.jpg',
            'blob.jpg',
            'ch.jpg',
            'henry.jpg',
            'jule.jpg',
            'mathilde.jpg',
            'max.jpg',
            'phem.jpg',
            'chinese.png',
            'french.png',
            'indonesian.png',
        ];

        // Randomly select an image
        $profilePicture = $images[array_rand($images)];

        // Ensure we find a country and a city within that country
        $country = Country::inRandomOrder()->first();
        $city = City::where('country_id', $country->id)->inRandomOrder()->first();

        // If no city is found, keep searching until we find a country with at least one city
        while (!$city) {
            $country = Country::inRandomOrder()->first();
            $city = City::where('country_id', $country->id)->inRandomOrder()->first();
        }

        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->dateTimeBetween('-1year', '+1 year'),
            'password' => static::$password ??= Hash::make('epfc'),
            'remember_token' => Str::random(10),
            'language_id' => 47,
            'profile_picture' => 'img/profiles/' . $profilePicture,
            'country_id' => $country->id,
            'city_id' => $city->id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
