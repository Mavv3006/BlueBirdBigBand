<?php

namespace Tests\Unit;

use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\SetlistHeader;
use Database\Seeders\BandSeeder;
use Database\Seeders\ConcertSeeder;
use Database\Seeders\SetlistSeeder;
use Database\Seeders\SongSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VenueSeeder;
use Tests\TestCase;

class SetlistTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this
            ->seed(UserSeeder::class)
            ->seed(VenueSeeder::class)
            ->seed(BandSeeder::class)
            ->seed(ConcertSeeder::class)
            ->seed(SongSeeder::class);
    }

    public function test_create_setlist_header()
    {
        $this->assertDatabaseCount(SetlistHeader::class, 0);

        SetlistHeader::factory()->create();

        $this->assertDatabaseCount(SetlistHeader::class, 1);
    }

    public function test_create_a_single_setlist_entry()
    {
        SetlistHeader::factory()->create();
        $this->assertDatabaseCount(SetlistHeader::class, 1);
        $this->assertDatabaseCount(SetlistEntry::class, 0);

        SetlistEntry::factory()->create();

        $this->assertDatabaseCount(SetlistEntry::class, 1);
    }

    public function test_run_setlist_seeder()
    {
        $this->seed(SetlistSeeder::class);

        $concertCount = Concert::all()->count();

        $this->assertDatabaseCount(SetlistHeader::class, $concertCount);
        $this->assertDatabaseCount(SetlistEntry::class, $concertCount * 4);

    }
}
