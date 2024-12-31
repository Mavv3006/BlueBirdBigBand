<?php

namespace Tests\Unit\Models;

use App\Models\Band;
use App\Models\KonzertmeisterEvent;
use Tests\TestCase;

class KonzertmeisterEventTest extends TestCase
{
    public function test_long_description()
    {
        $band = Band::factory()->create();
        $description = 'Auftritt - Hallo Ihr Lieben Bird’s, großer Saal, ca. 800 Personen anwesend, alles was Rang und Namen hat. Eine gute Plattform um uns positiv zu präsentieren und in ein gutes Licht zu stellen. Eventuell daraus Folge-Gigs für 2025 generieren. Bitte zügig antworten. Danke für eure Unterstützung.';

        KonzertmeisterEvent::create([
            'band_id' => $band->id,
            'description' => $description,
            'id' => 2344446,
        ]);

        $this->assertDatabaseCount('konzertmeister_events', 1);
        $event = KonzertmeisterEvent::query()->find(2344446);
        $this->assertStringEndsWith('...', $event->description);
        $this->assertLessThanOrEqual(125, strlen($event->description));
    }

    public function test_short_description()
    {
        $band = Band::factory()->create();
        $description = 'Auftritt - ';

        KonzertmeisterEvent::create([
            'band_id' => $band->id,
            'description' => $description,
            'id' => 2344446,
        ]);

        $this->assertDatabaseCount('konzertmeister_events', 1);
        $event = KonzertmeisterEvent::query()->find(2344446);
        $this->assertStringEndsNotWith('...', $event->description);
        $this->assertLessThanOrEqual(125, strlen($event->description));
    }

    public function test_description_length_with_upsert()
    {
        $description = 'Auftritt - Hallo Ihr Lieben Bird’s, großer Saal, ca. 800 Personen anwesend, alles was Rang und Namen hat. Eine gute Plattform um uns positiv zu präsentieren und in ein gutes Licht zu stellen. Eventuell daraus Folge-Gigs für 2025 generieren. Bitte zügig antworten. Danke für eure Unterstützung.';
        $id = Band::factory()->create()->id;
        KonzertmeisterEvent::create([
            'band_id' => $id,
            'description' => 'akdsjfhalsh',
            'id' => 2344446,
        ]);

        $this->assertDatabaseCount('konzertmeister_events', 1);
        $this->assertStringStartsWith('akdsj', KonzertmeisterEvent::query()->find(2344446)->description);

        $created = KonzertmeisterEvent::whereId(2344446)->firstOrFail();
        $created->update(['description' => $description]);

        $this->assertDatabaseCount('konzertmeister_events', 1);
        $event = KonzertmeisterEvent::query()->find(2344446);
        $this->assertStringStartsWith('Auftritt - ', $event->description);
        $this->assertStringEndsWith('...', $event->description);
        $this->assertLessThanOrEqual(125, strlen($event->description));
    }
}
