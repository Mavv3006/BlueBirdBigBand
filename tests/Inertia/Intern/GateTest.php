<?php

namespace Tests\Inertia\Intern;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Database\Seeders\DefaultAuthorizationSeeder;
use Tests\TestCase;

class GateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs(
            User::factory()
                ->create(['status' => UserStates::Activated])
                ->givePermissionTo('route.access-intern')
        );
    }

    public function test_can_access_index()
    {
        $this->get('/intern')
            ->assertStatus(301)
            ->assertRedirect(route('home'));
    }

    public function test_can_access_emails()
    {
        $this->get('/intern/emails')
            ->assertSuccessful();
    }

    public function test_can_access_songs()
    {
        $this->get('/intern/songs')
            ->assertSuccessful();
    }
}
