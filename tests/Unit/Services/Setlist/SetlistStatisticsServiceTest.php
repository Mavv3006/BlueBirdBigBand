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
    protected Song $song1;

    protected Song $song2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->song1 = Song::factory()->create();
        $this->song2 = Song::factory()->create();
        $band = Band::factory()->create();
        $venue = Venue::factory()->create();
        $concert1 = Concert::factory()
            ->for($band)
            ->for($venue)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($this->song1)
            ->create();
        SetlistEntry::factory()
            ->for($concert1)
            ->for($this->song2)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($this->song1)
            ->create();
        SetlistEntry::factory()
            ->for(Concert::factory()
                ->for($band)
                ->for($venue)
                ->create())
            ->for($this->song1)
            ->create();
    }

    public function testMostPlayed()
    {
        $result = SetlistStatisticsService::mostPlayed();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(SetlistCountDto::class, $result[0]);
        $this->assertInstanceOf(SetlistCountDto::class, $result[1]);
        $this->assertEquals($this->song1->id, $result[0]->id);
        $this->assertEquals($this->song2->id, $result[1]->id);
        $this->assertEquals(3, $result[0]->count);
        $this->assertEquals(1, $result[1]->count);
        $this->assertEquals($this->song1->title, $result[0]->title);
        $this->assertEquals($this->song1->arranger, $result[0]->arranger);
        $this->assertEquals($this->song2->title, $result[1]->title);
        $this->assertEquals($this->song2->arranger, $result[1]->arranger);
    }

    public function testMostPlayedWithLimit()
    {
        $result = SetlistStatisticsService::mostPlayed(limit: 1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(SetlistCountDto::class, $result[0]);
        $this->assertEquals($this->song1->id, $result[0]->id);
        $this->assertEquals(3, $result[0]->count);
    }

    public function testLastTimePlayed()
    {
        $result = SetlistStatisticsService::lastTimePlayed();
        var_dump($result);
    }
}
