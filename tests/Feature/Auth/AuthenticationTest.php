<?php

namespace Tests\Feature\Auth;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered(): void
    {
        $this->get(route('login'))
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Auth/Login')
                    ->has('canResetPassword')
                    ->has('status')
            );
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(['status' => UserStates::Activated]);

        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_try_login_user_which_does_not_exist(): void
    {
        $this->assertDatabaseCount(User::class, 0);

        $this->post('/login', [
            'name' => 'test',
            'password' => 'wrong-password',
        ]);
    }
}
