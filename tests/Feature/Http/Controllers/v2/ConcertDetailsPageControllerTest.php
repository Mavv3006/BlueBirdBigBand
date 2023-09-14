<?php

namespace Http\Controllers\v2;

use App\Models\Band;
use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\SetlistHeader;
use App\Models\Song;
use App\Models\Venue;
use Tests\TestCase;

class ConcertDetailsPageControllerTest extends TestCase
{
    public function testDatabasePreparation()
    {
        $this->seedDatabase();

        $this->assertDatabaseCount(Band::class, 1);
        $this->assertDatabaseCount(Venue::class, 1);
        $this->assertDatabaseCount(Concert::class, 1);
        $this->assertDatabaseCount(Song::class, 1);
        $this->assertDatabaseCount(SetlistHeader::class, 1);
        $this->assertDatabaseCount(SetlistEntry::class, 1);
    }

    public function testController()
    {
        $this->seedDatabase();

        $this->get(route('concert-details-page', [
            'concert' => Concert::all()->first(),
        ]))
            ->assertSuccessful();
    }

    private function seedDatabase(): void
    {
        Venue::factory()->create();
        Band::factory()->create();
        Concert::factory()->create();
        Song::factory()->create();
        SetlistHeader::factory()->create();
        SetlistEntry::factory()->create();
    }
}
