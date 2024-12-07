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

    public function testCanAccessIndex()
    {
        $this->get('/intern')
            ->assertStatus(301)
            ->assertRedirect(route('home'));
    }

    public function testCanAccessEmails()
    {
        $this->get('/intern/emails')
            ->assertSuccessful();
    }

    public function testCanAccessSongs()
    {
        $this->get('/intern/songs')
            ->assertSuccessful();
    }
}
