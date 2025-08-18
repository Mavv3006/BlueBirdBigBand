<?php

namespace Tests\Inertia\Intern;

use App\Models\Song;
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

    public function test_correct_props()
    {
        Song::factory()->count(2)->create();
        $this->assertDatabaseCount('songs', 2);

        $response = $this->get('intern/songs');
        $response->assertOk();

        $first_song = $response->inertiaProps()['songs'][0];
        $this->assertArrayHasKey('title', $first_song);
        $this->assertArrayHasKey('id', $first_song);
        $this->assertArrayHasKey('arranger', $first_song);
        $this->assertArrayHasKey('genre', $first_song);
        $this->assertArrayHasKey('file_path', $first_song);
    }

    public function test_correct_component()
    {
        $this->get(route('intern.songs'))
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Intern/Songs')
            );
    }
}
