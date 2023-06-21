<?php

namespace Intern;

use Database\Seeders\DefaultAuthorizationSeeder;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SongsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForInternalRoutes());
    }

    public function test_route_returns_successful()
    {
        $this->get('intern/songs')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('intern/songs')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Intern/Songs')
            );
    }
}
