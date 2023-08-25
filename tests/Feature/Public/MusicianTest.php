<?php

namespace Public;

use App\Models\Instrument;
use App\Models\Musician;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MusicianTest extends TestCase
{
    public function testRouteReturnsSuccessful()
    {
        $this->get('/musiker')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/musiker')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Band/MusiciansPage')
            );
    }

    public function testCorrectData()
    {
        $instrument = Instrument::factory()->create(['name' => 'test']);
        Musician::factory()
            ->count(3)
            ->for($instrument)
            ->create();

        $this->get('/musiker')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->has(
                        'data',
                        1,
                        fn (AssertableInertia $page) => $page
                            ->has(
                                'instrument',
                                fn (AssertableInertia $page) => $page
                                    ->has('name')
                                    ->has('id')
                                    ->has('default_picture_filepath')
                            )
                            ->has(
                                'musicians',
                                3,
                                fn (AssertableInertia $page) => $page
                                    ->has('isActive')
                                    ->has('firstname')
                                    ->has('id')
                                    ->has('lastname')
                                    ->has('instrument_id')
                                    ->etc()
                            )
                    )
            );
    }
}
