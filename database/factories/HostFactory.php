<?php

namespace Database\Factories;

use App\Models\Host;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Host>
 */
class HostFactory extends Factory
{
    protected $model = Host::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ensure we only select users without hosts
        $user = User::doesntHave('host')->inRandomOrder()->first();

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
        ];

        // Randomly select an image
        $profilePicture = $images[array_rand($images)];

        return [
            'bio' => $this->faker->paragraph(),
            'birthdate' => $this->faker->date(),
            'user_id' => $user ? $user->id : null,
            'profile_picture' => 'resources/test-images/host/' . $profilePicture,
        ];
    }
}
