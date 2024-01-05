<?php

namespace Models;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Tests\TestCase;

class ConcertTest extends TestCase
{
    public function testIsUpcoming()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['date' => now()->addDays(2)->toDate()]);

        $this->assertTrue($concert->isUpcoming());
    }

    public function testIsPlayed()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['date' => now()->subDays(2)->toDate()]);

        $this->assertTrue($concert->isPlayed());
    }
}
