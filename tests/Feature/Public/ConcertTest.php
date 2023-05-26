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
                    ['date' => Carbon::today()->addDays(2)],
                    ['date' => Carbon::today()->addDays(3)],
                    ['date' => Carbon::today()->addDays(4)],
                    ['date' => Carbon::today()->addDays(5)],
                )
            )
            ->create();
    }

    public function test_route_returns_successful()
    {
        $this->get('/auftritte')
            ->assertSuccessful();
    }

    public function test_correct_view()
    {
        $this->get('/auftritte')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('LatestInfos/ConcertsPage')
            );
    }

    public function test_correct_values_as_view_arguments()
    {
        $this->assertDatabaseCount('concerts', 5);

        $this->get('/auftritte')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->has(
                        'concerts',
                        5,
                        fn(AssertableInertia $page) => $page
                            ->has('date')
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
}
