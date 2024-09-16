<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    //use RefreshDatabase;
    use withFaker;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        // Créer un utilisateur avec un email vérifié
        $user = User::factory()->create([
            'email_verified_at' => now(),  // Email vérifié
        ]);

        // Générer un nouvel email unique avec Faker
        $newEmail = $this->faker->unique()->safeEmail;

        // Mettre à jour le profil de l'utilisateur avec un nouvel email
        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'firstname' => 'Test',
                'lastname' => 'User',
                'email' => $newEmail,  // Changer l'email
                'country_name' => 'Belgium',
                'city_name' => 'Brussels',
                'language_code' => 'fr',
            ]);

        // Vérifier qu'il n'y a pas d'erreurs et que la redirection est correcte
        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        // Rafraîchir les données de l'utilisateur pour obtenir les dernières données de la base
        $user->refresh();

        // Vérifier que les informations ont bien été mises à jour
        $this->assertSame('Test', $user->firstname);
        $this->assertSame('User', $user->lastname);
        $this->assertSame($newEmail, $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(), // Assure-toi que l'email est vérifié

        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'firstname' => 'Test',
                'lastname' => 'User',
                'email' => $user->email,
                'country_name' => 'Belgium',
                'city_name' => 'Brussels',
                'language_code' => 'fr',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
