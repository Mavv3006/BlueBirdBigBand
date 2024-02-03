<?php

namespace Tests\Inertia\Public;

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
        $instrument = Instrument::factory()->create(['name' => 'test', 'order' => 1]);
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
                                    ->has('tux_filepath')
                                    ->has('order')
                                    ->has('default_picture_filepath')
                            )
                            ->has(
                                'musicians',
                                3,
                                fn (AssertableInertia $page) => $page
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
