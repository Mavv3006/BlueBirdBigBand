<?php

namespace Tests\Services\Setlist;

use App\DataTransferObjects\SetlistStatistics\SetlistCountDto;
use App\Models\Band;
use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use App\Models\Venue;
use App\Services\Setlist\SetlistStatisticsService;
use Tests\TestCase;

class SetlistStatisticsServiceTest extends TestCase
{
    public function testMostPlayed()
    {
        $song1 = Song::factory()->create();
        $song2 = Song::factory()->create();
        $band = Band::factory()->create();
        $venue = Venue::factory()->create();
        $concert1 = Concert::factory()
            ->for($band)
            ->for($venue)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($song1)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($song2)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($song1)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($song1)
            ->create();

        $result = SetlistStatisticsService::mostPlayed();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(SetlistCountDto::class, $result[0]);
        $this->assertInstanceOf(SetlistCountDto::class, $result[1]);
        $this->assertEquals($song1->id, $result[0]->song_id);
        $this->assertEquals($song2->id, $result[1]->song_id);
        $this->assertEquals(3, $result[0]->count);
        $this->assertEquals(1, $result[1]->count);
    }

    public function testMostPlayedWithLimit()
    {
        $song1 = Song::factory()->create();
        $song2 = Song::factory()->create();
        $band = Band::factory()->create();
        $venue = Venue::factory()->create();
        $concert1 = Concert::factory()
            ->for($band)
            ->for($venue)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($song1)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($song2)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($song1)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($song1)
            ->create();

        $result = SetlistStatisticsService::mostPlayed(limit: 1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(SetlistCountDto::class, $result[0]);
        $this->assertEquals($song1->id, $result[0]->song_id);
        $this->assertEquals(3, $result[0]->count);
    }
}
