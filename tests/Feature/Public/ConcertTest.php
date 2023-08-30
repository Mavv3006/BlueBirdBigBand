<?php

namespace Public;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ConcertTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Band::factory()->create();
        Venue::factory()->create();
        Concert::factory()
            ->count(5)
            ->state(
                new Sequence(
                    ['date' => Carbon::today()->addDays()],
                    ['date' => Carbon::today()->addDays(3)],
                    ['date' => Carbon::today()->addDays(2)],
                    ['date' => Carbon::today()->addDays(5)],
                    ['date' => Carbon::today()->addDays(4)],
                )
            )
            ->create();
    }

    public function testRouteReturnsSuccessful()
    {
        $this->get('/auftritte')
            ->assertSuccessful();
    }

    public function testCorrectView()
    {
        $this->get('/auftritte')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('LatestInfos/ConcertsPage')
            );
    }

    public function testCorrectValuesAsViewArguments()
    {
        $this->assertDatabaseCount('concerts', 5);

        $this->get('/auftritte')
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->has(
                        'concerts',
                        5,
                        fn (AssertableInertia $page) => $page
                            ->has('date')
                            ->has('id')
                            ->has('start_time')
                            ->has('end_time')
                            ->has('band')
                            ->has('description')
                            ->has('description.venue')
                            ->has('description.event')
                            ->has('address')
                            ->has('address.street')
                            ->has('address.number')
                            ->has('address.plz')
                            ->has('address.city')
                    )
            );
    }

    public function testOrderOfConcerts()
    {
        $this->get('/auftritte')
            ->assertInertia(
                function (AssertableInertia $page) {
                    $props = $page->toArray()['props']['concerts'];
                    $this->assertEquals(5, count($props));
                    $this->assertTrue(Carbon::parse($props[0]['date']) <= Carbon::parse($props[1]['date']));
                    $this->assertTrue(Carbon::parse($props[1]['date']) <= Carbon::parse($props[2]['date']));
                    $this->assertTrue(Carbon::parse($props[2]['date']) <= Carbon::parse($props[3]['date']));
                    $this->assertTrue(Carbon::parse($props[3]['date']) <= Carbon::parse($props[4]['date']));
                }
            );
    }
}
