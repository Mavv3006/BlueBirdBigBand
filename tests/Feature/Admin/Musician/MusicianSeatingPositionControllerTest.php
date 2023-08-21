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
            ->for(Instrument::factory()->create(['name' => 'test']))
            ->count(2)
            ->create();
    }

    public function test_show_route()
    {
        $this->get('admin/musicians/seating-position')
            ->assertSuccessful()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Admin/MusicianManagement/SeatingPosition')
                    ->has('data', 1, fn (AssertableInertia $page) => $page
                        ->has('instrument')
                        ->has('musicians', 2, fn (AssertableInertia $page) => $page
                            ->has('seating_position')
                            ->etc()
                        )
                    )
            );
    }

    public function test_update_route()
    {
        $this->withoutExceptionHandling();

        $this->assertEquals(0, Musician::find(2)->seating_position);
        $this->assertEquals(0, Musician::find(1)->seating_position);

        $data = [
            'data' => [
                [
                    'instrument_id' => 1,
                    'musicians' => [
                        ['id' => 2],
                        ['id' => 1],
                    ],
                ],
            ],
        ];

        $this->put('admin/musicians/seating-position', $data)
            ->assertRedirect(route('musicians.index'));

        $this->assertEquals(0, Musician::find(2)->seating_position);
        $this->assertEquals(1, Musician::find(1)->seating_position);
    }
}
