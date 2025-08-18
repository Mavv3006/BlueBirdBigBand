<?php

namespace Tests\Feature\Services\Song;

use App\Models\Song;
use App\Services\Song\SongService;
use Tests\TestCase;

class SongServiceTest extends TestCase
{
    protected SongService $songService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->songService = new SongService;
    }

    public function test_sorting_songs_by_title()
    {
        Song::factory()
            ->count(4)
            ->sequence(
                ['title' => 'bbb'],
                ['title' => 'aaa'],
                ['title' => 'zte'],
                ['title' => 'cer'],
            )
            ->create();

        $songs = $this->songService->all();

        $this->assertEquals('aaa', $songs[0]['title']);
        $this->assertEquals('bbb', $songs[1]['title']);
        $this->assertEquals('cer', $songs[2]['title']);
        $this->assertEquals('zte', $songs[3]['title']);

    }
}
