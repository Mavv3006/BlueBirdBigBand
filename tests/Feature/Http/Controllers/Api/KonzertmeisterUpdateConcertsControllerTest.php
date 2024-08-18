<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\BandNames;
use App\Enums\KonzertmeisterEventType;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use Database\Seeders\DefaultBandSeeder;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class KonzertmeisterUpdateConcertsControllerTest extends TestCase
{
    protected string $apiKey = 'apiKey';

    protected Band $band;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DefaultBandSeeder::class);
        $this->band = Band::whereName(BandNames::BlueBird->value)->firstOrFail();
    }

    public function testValidatingApiKey()
    {
        $this->get(route('api.concerts.pull', ['band_name' => BandNames::BlueBird]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testValidatingBandName()
    {
        $this->get(route('api.concerts.pull', ['apiKey' => $this->apiKey]))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testValidatingAllParameters()
    {
        $this->get(route('api.concerts.pull'))
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testPullData()
    {
        $this->get(route('api.concerts.pull', ['apiKey' => $this->apiKey, 'band_name' => BandNames::BlueBird]))
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertContent('');
    }

    public function testProcessSingleEvent()
    {
        $this->get(route('api.concerts.pull', ['apiKey' => $this->apiKey, 'band_name' => BandNames::BlueBird]))
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseCount(KonzertmeisterEvent::class, 4);
        $event = KonzertmeisterEvent::first();

        $this->assertnotnull($event->id);
        $this->assertnotnull($event->band);
        $this->assertnotnull($event->dtstart);
        $this->assertnotnull($event->dtend);
        $this->assertnotnull($event->summary);
        $this->assertnotnull($event->description);
        $this->assertnotnull($event->type);
        $this->assertnotnull($event->location);

        $this->assertEquals($this->band->id, $event->band->id);
        $this->assertEquals(2036713, $event->id);
        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $event->summary);
        $this->assertEquals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
        $this->assertEquals('Probe', $event->description);
        $this->assertInstanceOf(KonzertmeisterEventType::class, $event->type);
        $this->assertInstanceOf(Carbon::class, $event->dtstart);
        $this->assertInstanceOf(Carbon::class, $event->dtend);
        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
    }

    public function testProcessMultipleEvent()
    {
        $this->get(route('api.concerts.pull', ['apiKey' => $this->apiKey, 'band_name' => BandNames::BlueBird]))
            ->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseCount(KonzertmeisterEvent::class, 4);
        //        $event = KonzertmeisterEvent::first();
        //
        //        $this->assertnotnull($event->id);
        //        $this->assertnotnull($event->band);
        //        $this->assertnotnull($event->dtstart);
        //        $this->assertnotnull($event->dtend);
        //        $this->assertnotnull($event->summary);
        //        $this->assertnotnull($event->description);
        //        $this->assertnotnull($event->type);
        //        $this->assertnotnull($event->location);
        //
        //        $this->assertEquals($this->band->id, $event->band->id);
        //        $this->assertEquals(2036713, $event->id);
        //        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $event->summary);
        //        $this->assertEquals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
        //        $this->assertEquals('Probe', $event->description);
        //        $this->assertInstanceOf(KonzertmeisterEventType::class, $event->type);
        //        $this->assertInstanceOf(Carbon::class, $event->dtstart);
        //        $this->assertInstanceOf(Carbon::class, $event->dtend);
        //        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
        //        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
    }

    //    public function testUpdatingEventsInDatabase() {}
}
