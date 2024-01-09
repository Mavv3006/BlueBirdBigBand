<?php

namespace Tests\Unit\Models;

use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use Tests\TestCase;

class SongQueryTest extends TestCase
{
    public function test_query()
    {
        Song::factory()->count(10)->create();
        Concert::factory()->count(15)->create();
        SetlistEntry::factory()->count(25)->create();
    }
}
