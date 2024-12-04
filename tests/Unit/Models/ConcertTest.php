<?php

namespace Tests\Unit\Models;

use App\Models\Band;
use App\Models\Concert;
use App\Models\Venue;
use Tests\TestCase;

class ConcertTest extends TestCase
{
    public function test_is_upcoming()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['date' => now()->addDays(2)->toDate()]);

        $this->assertTrue($concert->isUpcoming());
    }

    public function test_is_played()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['date' => now()->subDays(2)->toDate()]);

        $this->assertTrue($concert->isPlayed());
    }
}
