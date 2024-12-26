<?php

namespace Tests\Feature\Auth;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/registrieren');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/registrieren', [
            'name' => 'Test User',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseCount('users', 1);

        $user = User::first();
        $this->assertEquals('Test User', $user->name);
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertEquals(UserStates::Registered, $user->status);
    }
}
