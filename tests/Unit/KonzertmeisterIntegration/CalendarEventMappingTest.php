<?php

namespace Tests\Unit\KonzertmeisterIntegration;

use App\Models\Band;
use App\Services\KonzertmeisterIntegration\CalendarEventMapping;
use Carbon\Carbon;
use ICal\Event;
use Tests\TestCase;

class CalendarEventMappingTest extends TestCase
{
    public function test_description_null()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            null
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->toArray()['description'];

        $this->assertNull($description);
    }

    public function test_description_non_null()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            'sdlfhwsf'
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->toArray()['description'];

        $this->assertNotNull($description);
        $this->assertEquals('sdlfhwsf', $description);
    }

    public function test_trimming_description()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            '(+) BBBB Probe (BlueBirdBigBand)'
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->trimDescription()
            ->toArray()['description'];

        $this->assertStringStartsNotWith('(+)', $description);
        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $description);
    }

    public function test_trimming_description2()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            'BBBB Probe (BlueBirdBigBand)'
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->trimDescription()
            ->toArray()['description'];

        $this->assertStringStartsNotWith('(+)', $description);
        $this->assertEquals('BBBB Probe (BlueBirdBigBand)', $description);
    }

    public function test_having_all_null()
    {
        $event = new Event([
            'summary' => 'TP: *BBBB Golfclub Dackenheim  25. Jubiläum',
            'dtstart' => '20250802T150000Z',
            'dtend' => '20250802T170000Z',
            'duration' => null,
            'dtstamp' => '20250213T193328Z',
            'dtstart_tz' => '20250802T170000',
            'dtend_tz' => '20250802T190000',
            'uid' => '2603142191706',
            'created' => null,
            'last_modified' => null,
            'description' => null,
            'location' => null,
            'sequence' => null,
            'status' => null,
            'transp' => null,
            'organizer' => null,
            'attendee' => null,
        ]);
        $array = CalendarEventMapping::fromICalEvent($event)
            ->setType(null)
            ->setBand(Band::factory()->create())
            ->splitLocation()
            ->toArray();

        $this->assertNull($array['type']);
        $this->assertNull($array['location']);
        $this->assertNull($array['description']);
        $this->assertEquals('20250802T150000Z', $array['dtstart']->format('Ymd\THis\Z'));
        $this->assertEquals('20250802T170000Z', $array['dtend']->format('Ymd\THis\Z'));
        $this->assertEquals('TP: *BBBB Golfclub Dackenheim  25. Jubiläum', $array['summary']);
    }

    public function test_long_description()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            'Auftritt - Hallo Ihr Lieben Bird’s, großer Saal, ca. 800 Personen anwesend, alles was Rang und Namen hat. Eine gute Plattform um uns positiv zu präsentieren und in ein gutes Licht zu stellen. Eventuell daraus Folge-Gigs für 2025 generieren. Bitte zügig antworten. Danke für eure Unterstützung.'
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->shortenDescription()
            ->toArray()['description'];

        $this->assertStringEndsWith('...', $description);
        $this->assertLessThanOrEqual(125, strlen($description));
    }

    public function test_short_description()
    {
        $mapping = new CalendarEventMapping(
            'sdflkj',
            'sdlöfkj',
            'sdölfkj',
            Carbon::now(),
            Carbon::now(),
            'Auftritt - '
        );
        $description = $mapping
            ->setBand(Band::factory()->create())
            ->setType(null)
            ->shortenDescription()
            ->toArray()['description'];

        $this->assertStringEndsNotWith('...', $description);
        $this->assertLessThanOrEqual(125, strlen($description));
    }
}
