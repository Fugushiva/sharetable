<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    //use RefreshDatabase;
    use WithFaker;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $email = $this->faker->unique()->safeEmail;

        $response = $this->post('/register', [
            'firstname' => 'Test User',
            'lastname' => 'Test User',
            'email' => $email,
            'password' => 'password1234',
            'password_confirmation' => 'password1234',
            'country_name' => 'Belgium',
            'city_name' => 'Brussels',
            'language_name' => 'français'
        ]);


        $this->assertAuthenticated();
        $response->assertRedirect(route('welcome', absolute: false));
    }
}
