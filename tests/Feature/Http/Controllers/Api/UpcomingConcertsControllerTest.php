<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Tests\TestCase;

class UpcomingConcertsControllerTest extends TestCase
{
    /* Zu testen:
     * Erfolgsfall (200 OK)
     * - JSON Struktur muss passen
     * - Sortierung muss passsen
     * - Nur zukünftige Konzerte sollten in Liste sein
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
        Concert::factory()->create();
        $this->assertCount(1, Concert::all());


        $this->get()
    }
}
