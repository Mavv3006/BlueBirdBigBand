<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\BandName;
use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use App\Services\KonzertmeisterIntegration\KonzertmeisterIntegrationService;
use Carbon\Carbon;
use Database\Seeders\DefaultBandSeeder;
use DirectoryIterator;
use ICal\Event;
use ICal\ICal;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Tests\TestCase;

class KonzertmeisterUpdateConcertsControllerTest extends TestCase
{
    protected string $apiKey = 'apiKey';

    protected Band $band;

    protected KonzertmeisterIntegrationService $service;

    protected array $params;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(KonzertmeisterIntegrationService::class);
        $this->seed(DefaultBandSeeder::class);
        $this->band = Band::whereName(BandName::BlueBird->value)->firstOrFail();
        $this->params = ['apiKey' => $this->apiKey, 'band_name' => BandName::BlueBird];

        $this->mock(ICal::class, function (MockInterface $mock) {
            $mock->shouldReceive('events')->andReturn($this->mockedEvents());
        });
    }

    public function test_konzertmeister_url_is_set()
    {
        $this->assertStringContainsString('/Feature/Http/Controllers/api/mockEvents.ics', config('app.konzertmeister_url'));
    }

    public function test_validating_api_key()
    {
        $this->get(route('api.concerts.pull', ['band_name' => BandName::BlueBird]))
            ->assertBadRequest();
    }

    public function test_validating_band_name()
    {
        $this->get(route('api.concerts.pull', ['apiKey' => $this->apiKey]))
            ->assertBadRequest();
    }

    public function test_validating_all_parameters()
    {
        $this->get(route('api.concerts.pull'))
            ->assertBadRequest();
    }

    public function test_content_of_created_event()
    {
        $this->withoutExceptionHandling();

        $this->get(route('api.concerts.pull', $this->params))
            ->assertOk();

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
        $this->assertnotnull($event->conversion_state);

        $this->assertEquals($this->band->id, $event->band->id);
        $this->assertEquals(2036713, $event->id);
        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $event->summary);
        $this->assertEquals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
        $this->assertEquals('Probe', $event->description);
        $this->assertInstanceOf(KonzertmeisterEventType::class, $event->type);
        $this->assertInstanceOf(KonzertmeisterEventConversionState::class, $event->conversion_state);
        $this->assertInstanceOf(Carbon::class, $event->dtstart);
        $this->assertInstanceOf(Carbon::class, $event->dtend);
        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
        $this->assertEquals(KonzertmeisterEventConversionState::Open, $event->conversion_state);
    }

    public function test_verify_ids_of_all_events()
    {
        $this->get(route('api.concerts.pull', $this->params));

        $events = KonzertmeisterEvent::query()->get();

        if (count($events) === 0) {
            $this->fail('No events were found');
        }

        for ($i = 0; $i < count($events); $i++) {
            $this->assertEquals(
                expected: [2036713, 2036716, 2036717, 2036720][$i],
                actual: $events[$i]->id);
        }
    }

    public function test_update_open_events()
    {
        KonzertmeisterEvent::factory()->create([
            'band_id' => $this->band->id,
            'dtstart' => Carbon::parse('20220904T180000Z'),
            'dtend' => Carbon::parse('20220904T200000Z'),
            'summary' => 'Probe',
            'description' => 'hi hi hi',
            'location' => 'Deutschland',
            'type' => KonzertmeisterEventType::Auftritt,
            'id' => 2036713,
            'conversion_state' => KonzertmeisterEventConversionState::Open,
        ]);

        $this->get(route('api.concerts.pull', $this->params));

        $event = KonzertmeisterEvent::first();
        $this->assertequals(2036713, $event->id);
        $this->assertequals('Probe', $event->description);
        $this->assertequals('BBBB Probe (BlueBirdBigBand)', $event->summary);
        $this->assertequals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
        $this->assertEquals(2024, $event->dtstart->year);
        $this->assertEquals(2024, $event->dtend->year);
        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
    }

    public function test_update_converted_events()
    {
        KonzertmeisterEvent::factory()->create([
            'band_id' => $this->band->id,
            'dtstart' => Carbon::parse('20220904T180000Z'),
            'dtend' => Carbon::parse('20220904T200000Z'),
            'summary' => 'Probe',
            'description' => 'hi hi hi',
            'location' => 'Deutschland',
            'type' => KonzertmeisterEventType::Auftritt,
            'id' => 2036713,
            'conversion_state' => KonzertmeisterEventConversionState::Converted,
        ]);

        $this->get(route('api.concerts.pull', $this->params));

        $event = KonzertmeisterEvent::first();
        $this->assertequals(2036713, $event->id);
        $this->assertequals('Probe', $event->description);
        $this->assertequals('BBBB Probe (BlueBirdBigBand)', $event->summary);
        $this->assertequals('Mausbergweg 144, 67346 Speyer, Deutschland', $event->location);
        $this->assertEquals(2024, $event->dtstart->year);
        $this->assertEquals(2024, $event->dtend->year);
        $this->assertEquals(Carbon::parse('20240828T180000Z'), $event->dtstart);
        $this->assertEquals(Carbon::parse('20240828T200000Z'), $event->dtend);
        $this->assertEquals(KonzertmeisterEventType::Probe, $event->type);
    }

    public function test_do_not_update_rejected_events()
    {
        $summary = 'Probe';
        $description = 'hi hi hi';
        $location = 'Deutschland';
        KonzertmeisterEvent::factory()->create([
            'band_id' => $this->band->id,
            'dtstart' => Carbon::parse('20220904T180000Z'),
            'dtend' => Carbon::parse('20220904T200000Z'),
            'summary' => $summary,
            'description' => $description,
            'location' => $location,
            'id' => 2036713,
            'conversion_state' => KonzertmeisterEventConversionState::Rejected,
        ]);

        $this->get(route('api.concerts.pull', $this->params));

        $event = KonzertmeisterEvent::first();
        $this->assertequals(2036713, $event->id);
        $this->assertequals($description, $event->description);
        $this->assertequals($summary, $event->summary);
        $this->assertequals($location, $event->location);
        $this->assertEquals(2022, $event->dtstart->year);
        $this->assertEquals(2022, $event->dtend->year);
        $this->assertEquals(Carbon::parse('20220904T180000Z'), $event->dtstart);
        $this->assertEquals(Carbon::parse('20220904T200000Z'), $event->dtend);
    }

    public function test_with_faulty_description()
    {
        $id = 2036720;

        $this->get(route('api.concerts.pull', $this->params));

        $this->assertDatabaseHas('konzertmeister_events', ['id' => $id]);
        $event = KonzertmeisterEvent::find($id);
        $this->assertEquals(KonzertmeisterEventType::Sonstiges, $event->type);
    }

    /**
     * @return Event[]
     */
    public function mockedEvents(): array
    {
        return [
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240828T180000Z',
                'DTEND' => '20240828T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036713',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036713',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Mausbergweg 144\, 67346 Speyer\, Deutschland',
                'DESCRIPTION' => 'Probe',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240904T180000Z',
                'DTEND' => '20240904T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036716',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036716',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Langgasse 66\, 67454 Haßloch\, Deutschland',
                'DESCRIPTION' => 'Probe',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240911T180000Z',
                'DTEND' => '20240911T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036717',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036717',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Mausbergweg 144\, 67346 Speyer\, Deutschland',
                'DESCRIPTION' => 'Auftritt - Brauerei-Saal alter Löwer 2x40min\, 20min Pause dazwischen\, danach 1 Runde Glühwein auf dem Weihnachtsmarkt Haßloch',
            ]),
            new Event([
                'DTSTAMP' => '20240812T143121Z',
                'DTSTART' => '20240918T180000Z',
                'DTEND' => '20240918T200000Z',
                'SUMMARY' => 'BBBB Probe (BlueBirdBigBand)',
                'UID' => '2036720',
                'TZID' => 'Europe/Berlin',
                'URL' => 'https://web.konzertmeister.app/appointment/2036720',
                'GEO' => '49.3276295;8.4352534',
                'LOCATION' => 'Martin-Luther-Straße 44\, 67433 Neustadt an der Weinstraße\, Deutschland',
                'DESCRIPTION' => 'lkasjdföalskdjf',
            ]),
        ];
    }
}
