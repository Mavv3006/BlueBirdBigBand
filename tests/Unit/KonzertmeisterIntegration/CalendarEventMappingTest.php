<?php

namespace KonzertmeisterIntegration;

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
        $mapping->setBand(Band::factory()->create());
        $mapping->setType(null);

        $description = $mapping->toArray()['description'];
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
        $mapping->setBand(Band::factory()->create());
        $mapping->setType(null);

        $description = $mapping->toArray()['description'];
        $this->assertNotNull($description);
        $this->assertEquals('sdlfhwsf', $description);
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
}
