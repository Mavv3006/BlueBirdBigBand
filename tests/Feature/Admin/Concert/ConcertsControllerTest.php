<?php

namespace Admin\Concert;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ConcertsControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_show_create_form(): void
    {
        Venue::create(['plz' => 12000, 'name' => 'test']);
        Band::create(['name' => 'test']);

        $this->get(route('concerts.create'))
            ->assertSuccessful()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Admin/ConcertManagement/ConcertsCreate')
                    ->has('venues', 1, fn(AssertableInertia $page) => $page
                        ->has('plz')
                        ->has('name')
                    )
                    ->has('bands', 1, fn(AssertableInertia $page) => $page
                        ->has('id')
                        ->has('name')
                    )
            );
    }

    public function test_store()
    {
        $data = [
            'date' => Carbon::today()->addDays(2),
            'band_id' => Band::create(['name' => 'test'])->id,
            'times' => [
                'start' => '10:00:00',
                'end' => '12:00:00',
            ],
            'venue' => [
                'create_new_venue' => true,
                'new_plz' => 12000,
                'new_name' => 'test 2',
                'street' => 'street name',
                'house_number' => '12a'
            ],
            'description' => [
                'event' => 'event description',
                'venue' => 'venue description'
            ]
        ];

        $this
            ->post('/admin/concerts', $data)
            ->assertRedirect(route('concerts.show', 1));

        $this->assertDatabaseCount(Concert::class, 1);
        $concert = Concert::first();
        $this->assertEquals('test', $concert->band->name);
        $this->assertEquals('10:00:00', $concert->start_time->format('H:i:s'));
        $this->assertEquals('12:00:00', $concert->end_time->format('H:i:s'));
        $this->assertEquals('event description', $concert->event_description);
        $this->assertEquals('venue description', $concert->venue_description);

        $this->assertDatabaseCount(Venue::class, 1);
        $venue = Venue::first();
        $this->assertEquals(12000, $venue->plz);
        $this->assertEquals('test 2', $venue->name);
    }
}
