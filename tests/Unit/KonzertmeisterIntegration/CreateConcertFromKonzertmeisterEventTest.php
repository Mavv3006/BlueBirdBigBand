<?php

namespace KonzertmeisterIntegration;

use App\Enums\KonzertmeisterEventType;
use App\Enums\StateMachines\KonzertmeisterEventConversionState;
use App\Models\Band;
use App\Models\Concert;
use App\Models\KonzertmeisterEvent;
use App\Models\Venue;
use Tests\TestCase;

class CreateConcertFromKonzertmeisterEventTest extends TestCase
{
    public function test_create_concert_from_konzertmeister_event_test()
    {
        KonzertmeisterEvent::create([
            'id' => 2029880,
            'band_id' => Band::factory()->create()->id,
            'dtstart' => '2025-03-14 18:00:00',
            'dtend' => '2025-03-14 21:00:00',
            'summary' => '(+) *BBBB XXIV. Swing im Dreieck LU (BlueBirdBigBand)',
            'description' => 'Auftritt - Ich kann noch nicht sagen ob wir 19-20h oder 20-21h spielen',
            'type' => KonzertmeisterEventType::Auftritt,
            'location' => 'Bahnhofstraße 30, 67059 Ludwigshafen am Rhein, Deutschland',
            'conversion_state' => KonzertmeisterEventConversionState::Open,
        ]);

        $event = KonzertmeisterEvent::first();

        $concert = Concert::create([
            'date' => $event->dtstart,
            'band_id' => $event->band_id,
            'start_time' => $event->dtstart,
            'end_time' => $event->dtend,
            'event_description' => $event->summary, // << manuell erfassen >> <-- prefill
            'venue_description' => '<<>>', // << manuell erfassen >>
            'venue_street' => '<<>>', // << manuell erfassen >>
            'venue_street_number' => '<<>>', // << manuell erfassen >>
            'venue_plz' => Venue::factory()->create()->plz, // << manuell erfassen >>
            'konzertmeister_event_id' => $event->id,
        ]);

        $this->assertDatabaseCount(Concert::class, 1);
        $this->assertEquals(2029880, $event->id);
        $this->assertEquals($event->id, $concert->konzertmeister_event_id);
    }
}
