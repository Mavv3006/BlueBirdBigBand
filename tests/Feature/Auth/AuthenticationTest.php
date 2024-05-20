<?php

namespace Tests\Feature\Auth;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testLoginScreenCanBeRendered(): void
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

    public function testUsersCanAuthenticateUsingTheLoginScreen(): void
    {
        $user = User::factory()->create(['status' => UserStates::Activated]);

        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function testTryLoginUserWhichDoesNotExist(): void
    {
        $this->assertDatabaseCount(User::class, 0);
        $this->expectException(ValidationException::class);

        $this->post('/login', [
            'name' => 'test',
            'password' => 'wrong-password',
        ]);
    }
}
