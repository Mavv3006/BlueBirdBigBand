<?php

namespace Tests\Unit\Models;

use App\Enums\ConcertStatus;
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

    public function test_status_type_public()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['status' => ConcertStatus::Public]);

        $this->assertInstanceOf(ConcertStatus::class, $concert->status);
        $this->assertEquals(ConcertStatus::Public, $concert->status);
    }

    public function test_status_type_draft()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['status' => ConcertStatus::Draft]);

        $this->assertInstanceOf(ConcertStatus::class, $concert->status);
        $this->assertEquals(ConcertStatus::Draft, $concert->status);
    }

    public function test_from_draft_set_public()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['status' => ConcertStatus::Draft]);

        $concert->setPublic();

        $concert->refresh();
        $this->assertInstanceOf(ConcertStatus::class, $concert->status);
        $this->assertEquals(ConcertStatus::Public, $concert->status);
    }

    public function test_from_public_set_public()
    {
        Band::factory()->create();
        Venue::factory()->create();
        $concert = Concert::factory()->create(['status' => ConcertStatus::Public]);

        $concert->setPublic();

        $concert->refresh();
        $this->assertInstanceOf(ConcertStatus::class, $concert->status);
        $this->assertEquals(ConcertStatus::Public, $concert->status);
    }
}
