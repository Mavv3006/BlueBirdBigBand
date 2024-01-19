<?php

namespace Tests\Inertia\Intern;

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

    public function testRouteReturnsSuccessful()
    {
        $this->get('intern/songs')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('intern/songs')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Intern/Songs')
            );
    }

    public function testCorrectView2()
    {
        $this->get(route('intern.songs'))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Intern/Songs')
            );
    }
}
