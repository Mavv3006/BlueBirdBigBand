<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use Database\Seeders\DefaultBandSeeder;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Tests\TestCase;

class KonzertmeisterUpdateConcertsControllerTest extends TestCase
{
    /* Zu testen:
     * Authentifizierung:
     * - 401: ohne API-Key
     * - 204: Daten holen erfolgreich
     * - 502: Konzertmeister nicht erreichbar
     * funktional:
     * - keine Duplicate bei mehrfacher Ausführung
     * */

    protected array $params;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DefaultBandSeeder::class);
        $this->params = ['apiKey' => config('app.konzertmeister_api_key')];
    }

    public function test_validating_api_key()
    {
        $response = $this->get(route('api.concerts.pull'))
            ->assertUnauthorized();

        $response->assertJsonValidationErrors('apiKey');
    }

    public function test_it_can_parse_concerts_from_external_ical()
    {
        $this->withoutExceptionHandling();
        //        $mockIcsPath = base_path('tests/Fixtures/ical/mockEvents.ics');
        $mockIcsPath = base_path('tests/Fixtures/ical/single_rehearsal.ics');
        $mockIcsContent = file_get_contents($mockIcsPath);

        Http::fake([
            config('app.konzertmeister_url') => Http::response($mockIcsContent, SymfonyResponse::HTTP_ACCEPTED),
        ]);

        $this->get(route('api.concerts.pull', $this->params))
            ->assertAccepted();

        $this->assertDatabaseCount(KonzertmeisterEvent::class, 1);
    }

    //    public function test_content_of_created_event()
    //    {
    //        $this->withoutExceptionHandling();
    //
    //        $this->get(route('api.concerts.pull', $this->params))
    //            ->assertAccepted();
    //
    //        $this->assertDatabaseCount(KonzertmeisterEvent::class, 4);
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
    //        $this->assertnotnull($event->conversion_state);
    //
    //        $this->assertEquals($this->band->id, $event->band->id);
    //        $this->assertEquals(2036713, $event->id);
    //        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $event->summary);
    //        $this->assertEquals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
    //        $this->assertEquals('Probe', $event->description);
    //        $this->assertInstanceOf(KonzertmeisterEventType::class, $event->type);
    //        $this->assertInstanceOf(KonzertmeisterEventConversionState::class, $event->conversion_state);
    //        $this->assertInstanceOf(Carbon::class, $event->dtstart);
    //        $this->assertInstanceOf(Carbon::class, $event->dtend);
    //        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
    //        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
    //        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
    //        $this->assertEquals(KonzertmeisterEventConversionState::Open, $event->conversion_state);
    //    }
    //
    //    public function testVerifyIdsOfAllEvents()
    //    {
    //        $this->get(route('api.concerts.pull', $this->params));
    //
    //        $events = KonzertmeisterEvent::query()->get();
    //        for ($i = 0; $i < count($events); $i++) {
    //            $this->assertEquals(
    //                expected: [2036713, 2036716, 2036717, 2036720][$i],
    //                actual: $events[$i]->id);
    //        }
    //    }
    //
    //    public function testUpdateOpenEvents()
    //    {
    //        KonzertmeisterEvent::factory()->create([
    //            'band_id' => $this->band->id,
    //            'dtstart' => Carbon::parse('20220904T180000Z'),
    //            'dtend' => Carbon::parse('20220904T200000Z'),
    //            'summary' => 'Probe',
    //            'description' => 'hi hi hi',
    //            'location' => 'Deutschland',
    //            'type' => KonzertmeisterEventType::Auftritt,
    //            'id' => 2036713,
    //            'conversion_state' => KonzertmeisterEventConversionState::Open,
    //        ]);
    //
    //        $this->get(route('api.concerts.pull', $this->params));
    //
    //        $event = KonzertmeisterEvent::first();
    //        $this->assertequals(2036713, $event->id);
    //        $this->assertequals('Probe', $event->description);
    //        $this->assertequals('BBBB Probe (BlueBirdBigBand)', $event->summary);
    //        $this->assertequals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
    //        $this->assertEquals(2024, $event->dtstart->year);
    //        $this->assertEquals(2024, $event->dtend->year);
    //        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
    //        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
    //        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
    //    }
    //
    //    public function testUpdateConvertedEvents()
    //    {
    //        KonzertmeisterEvent::factory()->create([
    //            'band_id' => $this->band->id,
    //            'dtstart' => Carbon::parse('20220904T180000Z'),
    //            'dtend' => Carbon::parse('20220904T200000Z'),
    //            'summary' => 'Probe',
    //            'description' => 'hi hi hi',
    //            'location' => 'Deutschland',
    //            'type' => KonzertmeisterEventType::Auftritt,
    //            'id' => 2036713,
    //            'conversion_state' => KonzertmeisterEventConversionState::Converted,
    //        ]);
    //
    //        $this->get(route('api.concerts.pull', $this->params));
    //
    //        $event = KonzertmeisterEvent::first();
    //        $this->assertequals(2036713, $event->id);
    //        $this->assertequals('Probe', $event->description);
    //        $this->assertequals('BBBB Probe (BlueBirdBigBand)', $event->summary);
    //        $this->assertequals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
    //        $this->assertEquals(2024, $event->dtstart->year);
    //        $this->assertEquals(2024, $event->dtend->year);
    //        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
    //        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
    //        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
    //    }
    //
    //    public function testDoNotUpdateRejectedEvents()
    //    {
    //        $summary = 'Probe';
    //        $description = 'hi hi hi';
    //        $location = 'Deutschland';
    //        KonzertmeisterEvent::factory()->create([
    //            'band_id' => $this->band->id,
    //            'dtstart' => Carbon::parse('20220904T180000Z'),
    //            'dtend' => Carbon::parse('20220904T200000Z'),
    //            'summary' => $summary,
    //            'description' => $description,
    //            'location' => $location,
    //            'id' => 2036713,
    //            'conversion_state' => KonzertmeisterEventConversionState::Rejected,
    //        ]);
    //
    //        $this->get(route('api.concerts.pull', $this->params));
    //
    //        $event = KonzertmeisterEvent::first();
    //        $this->assertequals(2036713, $event->id);
    //        $this->assertequals($description, $event->description);
    //        $this->assertequals($summary, $event->summary);
    //        $this->assertequals($location, $event->location);
    //        $this->assertEquals(2022, $event->dtstart->year);
    //        $this->assertEquals(2022, $event->dtend->year);
    //        $this->assertEquals(Carbon::parse('20220904T180000Z'), $event->dtstart);
    //        $this->assertEquals(Carbon::parse('20220904T200000Z'), $event->dtend);
    //    }
    //
    //    public function testWithFaultyDescription()
    //    {
    //        $this->get(route('api.concerts.pull', $this->params))->assertAccepted();
    //
    //        $event = KonzertmeisterEvent::find(2036720);
    //        $this->assertEquals(KonzertmeisterEventType::Sonstiges, $event->type);
    //    }
}
