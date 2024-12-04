<?php

namespace Tests\Inertia\Intern;

use Database\Seeders\DefaultAuthorizationSeeder;
use Tests\TestCase;

class HomeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForInternalRoutes());
    }

    public function test_route_redirects()
    {
        $this->get('/intern')
            ->assertStatus(301)
            ->assertRedirect(route('home'));
    }
}
