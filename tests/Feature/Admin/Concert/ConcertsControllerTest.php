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

    public function test_show_edit_form(): void
    {
        Venue::factory()->create();
        Band::factory()->create();
        Concert::factory()->create();

        $this->get(route('concerts.edit', 1))
            ->assertSuccessful()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Admin/ConcertManagement/ConcertsEdit')
                    ->has('venues', 1, fn(AssertableInertia $page) => $page
                        ->has('plz')
                        ->has('name')
                    )
                    ->has('bands', 1, fn(AssertableInertia $page) => $page
                        ->has('id')
                        ->has('name')
                    )
                    ->has('concert', fn(AssertableInertia $page) => $page
                        ->has('id')
                        ->has('date')
                        ->has('start_time')
                        ->has('end_time')
                        ->has('band')
                        ->has('description', fn(AssertableInertia $page) => $page
                            ->has('venue')
                            ->has('event')
                        )
                        ->has('address', fn(AssertableInertia $page) => $page
                            ->has('street')
                            ->has('number')
                            ->has('plz')
                            ->has('city')
                        )
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
            ->assertRedirect(route('concerts.index'));

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

    public function test_update()
    {
        $this->withoutExceptionHandling();

        $venue = Venue::factory()->create();
        $band = Band::factory()->create();
        $concert = Concert::create([
            'date' => Carbon::today()->addDays(2),
            'band_id' => $band->id,
            'start_time' => '10:00:00',
            'end_time' => '12:00:00',
            'event_description' => 'description',
            'venue_description' => 'description',
            'venue_plz' => $venue->plz,
            'venue_street_number' => '14',
            'venue_street' => 'help street'
        ]);

        $data = [
            'date' => Carbon::today()->addDays(2),
            'band_id' => $band->id,
            'times' => [
                'start' => '10:00:00',
                'end' => '12:00:00',
            ],
            'venue' => [
                'create_new_venue' => false,
                'street' => 'street name',
                'house_number' => '12a',
                'selected_plz' => $venue->plz
            ],
            'description' => [
                'event' => 'event description',
                'venue' => 'venue description'
            ]
        ];

        $this
            ->put('/admin/concerts/' . $concert->id, $data)
            ->assertRedirect(route('concerts.index'));

        $this->assertDatabaseCount(Concert::class, 1);
        $assertConcert = Concert::first();
        $this->assertEquals('10:00:00', $assertConcert->start_time->format('H:i:s'));
        $this->assertEquals('12:00:00', $assertConcert->end_time->format('H:i:s'));
        $this->assertEquals('event description', $assertConcert->event_description);
        $this->assertEquals('venue description', $assertConcert->venue_description);
        $this->assertEquals('12a', $assertConcert->venue_street_number);
        $this->assertEquals('street name', $assertConcert->venue_street);
    }

    public function test_index()
    {
        Venue::factory()->create();
        Band::factory()->create();
        Concert::factory()->create();

        $this->assertDatabaseCount(Concert::class, 1);

        $this->get(route('concerts.index'))
            ->assertSuccessful()
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Admin/ConcertManagement/ConcertsIndex')
                    ->has('concerts', fn(AssertableInertia $page) => $page
                        ->has('upcoming')
                        ->has('past')
                    )
            );
    }

    public function test_delete_concert()
    {
        Venue::factory()->create();
        Band::factory()->create();
        $concert = Concert::factory()->create();
        $this->assertDatabaseCount(Concert::class, 1);

        $this->delete(route('concerts.destroy', $concert->id))
            ->assertRedirect();

        $this->assertDatabaseCount(Concert::class, 0);
    }
}
