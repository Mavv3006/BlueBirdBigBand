<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpcomingConcertsControllerTest extends TestCase
{
    /* Zu testen:
     * Erfolgsfall (200 OK)
     * - Wenn keine zukünftigen Konzerte, soll Liste leer sein
     * */

    protected function setUp(): void
    {
        parent::setUp();
        Band::factory()->create();
        Venue::factory()->create();
    }

    public function test_single_concert()
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 14));
        $date = Carbon::now()->addDay();
        $concert = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'Test213',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::factory()->create(['plz' => 12398, 'name' => 'Speyer'])->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);

        $response = $this->get(route('api.concerts.upcoming'));

        $response->assertOk();
        $response->assertJson(fn (AssertableJson $json) => $json
            ->has(1)
            ->first(fn (AssertableJson $json) => $json
                ->has('id')
                ->has('start_at')
                ->has('end_at')
                ->has('location_name')
                ->has('description')
                ->has('address', fn (AssertableJson $json) => $json
                    ->has('street')
                    ->has('house_number')
                    ->has('zip_code')
                    ->has('city')
                    ->has('full_address')
                )
            )
        );

        $response_concert = $response->json('0');
        $this->assertEquals('Stadthalle Speyer', $response_concert['location_name']);
        $this->assertEquals('Test213', $response_concert['description']);
        $this->assertEquals($concert->id, $response_concert['id']);
        $this->assertEquals($concert->start_at->toIso8601String(), $response_concert['start_at']);
        $this->assertEquals($concert->end_at->toIso8601String(), $response_concert['end_at']);
        $this->assertEquals('Langgasse', $response_concert['address']['street']);
        $this->assertEquals('123ab', $response_concert['address']['house_number']);
        $this->assertEquals('12398', $response_concert['address']['zip_code']);
        $this->assertEquals('Speyer', $response_concert['address']['city']);
        $this->assertEquals('Langgasse 123ab, 12398 Speyer', $response_concert['address']['full_address']);
    }

    public function test_only_upcoming()
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 14));
        $date = Carbon::now()->addDay();
        $upcoming = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'Upcoming Concert',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::first()->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);
        $date = Carbon::now()->subDays(2);
        $past = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'Past Concert',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::first()->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);

        $this->assertTrue($past->start_at < $upcoming->start_at);
        $this->assertTrue($upcoming->isUpcoming());
        $this->assertFalse($upcoming->isPlayed());
        $this->assertFalse($past->isUpcoming());
        $this->assertTrue($past->isPlayed());

        $response = $this->get(route('api.concerts.upcoming'));

        $response->assertOk();
        $response->assertJsonCount(1);
        $response_concert = $response->json('0');
        $this->assertEquals('Upcoming Concert', $response_concert['description']);
    }

    public function test_empty_if_no_upcoming()
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 14));
        $date = Carbon::now()->subDays(2);
        $past = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'Past Concert',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::first()->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);

        $response = $this->get(route('api.concerts.upcoming'));

        $response->assertOk();
        $response->assertJsonCount(0);
        $this->assertEquals([], $response->json());
    }

    public function test_sorting()
    {
        Carbon::setTestNow(Carbon::create(2026, 2, 14));
        $date = Carbon::now()->addDays(5);
        $second = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'Second Concert',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::first()->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);
        $date = Carbon::now();
        $first = Concert::factory()->create([
            'band_id' => Band::first()->id,
            'event_description' => 'First Concert',
            'venue_description' => 'Stadthalle Speyer',
            'venue_street' => 'Langgasse',
            'venue_street_number' => '123ab',
            'venue_plz' => Venue::first()->plz,
            'start_at' => $date->setHour(11)->setMinute(0)->setSecond(0),
            'end_at' => $date->setHour(13)->setMinute(0)->setSecond(0),
        ]);
        $this->assertTrue($first->start_at < $second->start_at);

        $response = $this->get(route('api.concerts.upcoming'));

        $response->assertOk();
        $response->assertJsonCount(2);
        $response_concerts = $response->json();
        $this->assertEquals('First Concert', $response_concerts[0]['description']);
        $this->assertEquals('Second Concert', $response_concerts[1]['description']);
    }
}
