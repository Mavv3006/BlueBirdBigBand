<?php

namespace Admin\Musician;

use Database\Seeders\DefaultAuthorizationSeeder;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MusicianTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForAdminRoutes());
    }

    public function test_index_route()
    {
        $this->get('admin/musicians')
            ->assertSuccessful()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/MusiciansIndex')
            );
    }

    public function test_correct_view()
    {
        $this->get('/musiker')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Band/MusiciansPage')
            );
    }
}
