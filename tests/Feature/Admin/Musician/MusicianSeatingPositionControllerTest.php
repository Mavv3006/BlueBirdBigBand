<?php

namespace Admin\Musician;

use App\Models\Instrument;
use App\Models\Musician;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MusicianSeatingPositionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
        Musician::factory()
            ->for(Instrument::factory()->create(['name' => 'test', 'order' => 2]))
            ->count(2)
            ->create();
    }

    public function testShowRoute()
    {
        $this->get('admin/musicians/seating-position')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/SeatingPosition')
                    ->has(
                        'data',
                        1,
                        fn (AssertableInertia $page) => $page
                            ->has('instrument')
                            ->has(
                                'musicians',
                                2,
                                fn (AssertableInertia $page) => $page
                                    ->has('seating_position')
                                    ->etc()
                            )
                    )
            );
    }

    public function testUpdateRoute()
    {
        $musicians = Musician::all();
        $firstMusician = $musicians[0];
        $secondMusician = $musicians[1];
        $this->assertEquals(0, $secondMusician->seating_position);
        $this->assertEquals(0, $firstMusician->seating_position);

        $data = [
            'data' => [
                [
                    'instrument_id' => 1,
                    'musicians' => [
                        ['id' => $secondMusician->id],
                        ['id' => $firstMusician->id],
                    ],
                ],
            ],
        ];

        $this->put('admin/musicians/seating-position', $data)
            ->assertRedirect(route('musicians.index'));

        $new_musicians = Musician::all();
        $this->assertEquals(0, $new_musicians[1]->seating_position);
        $this->assertEquals(1, $new_musicians[0]->seating_position);
    }
}
