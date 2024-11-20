<?php

namespace Tests\Unit\Services\Setlist;

use App\DataTransferObjects\SetlistStatistics\SetlistCountDto;
use App\Models\Band;
use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use App\Models\Venue;
use App\Services\Setlist\SetlistStatisticsService;
use Carbon\Carbon;
use Tests\TestCase;

class SetlistStatisticsServiceTest extends TestCase
{
    protected Song $song1;

    protected Song $song2;

    private function setupMostPlayed(): void
    {
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

    public function test_most_played()
    {
        $this->setupMostPlayed();

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

    public function test_most_played_with_limit()
    {
        $this->setupMostPlayed();

        $result = SetlistStatisticsService::mostPlayed(limit: 1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(SetlistCountDto::class, $result[0]);
        $this->assertEquals($this->song1->id, $result[0]->id);
        $this->assertEquals(3, $result[0]->count);
    }

    public function test_last_time_played()
    {
        $this->song1 = Song::factory()->create();
        $band = Band::factory()->create();
        $venue = Venue::factory()->create();
        $date1 = Carbon::createFromDate(2023, 10, 12);
        $date2 = Carbon::createFromDate(2023, 12, 12);
        $concert1 = Concert::factory()
            ->for($band)
            ->for($venue)
            ->create([
                'date' => $date1,
            ]);
        $concert2 = Concert::factory()
            ->for($band)
            ->for($venue)
            ->create([
                'date' => $date2,
            ]);
        SetlistEntry::factory()
            ->for($concert1)
            ->for($this->song1)
            ->create();
        SetlistEntry::factory()
            ->for($concert2)
            ->for($this->song1)
            ->create();

        $result = SetlistStatisticsService::lastTimePlayed();

        $this->assertCount(1, $result);
        $this->assertEquals($date2->toDateString(), $result[0]->lastPlayedDate->toDateString());
        $this->assertEquals($this->song1->id, $result[0]->id);
        $this->assertEquals($this->song1->arranger, $result[0]->arranger);
        $this->assertEquals($this->song1->title, $result[0]->title);
    }
}
