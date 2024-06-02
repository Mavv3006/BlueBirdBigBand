<?php

namespace Tests\Feature\Repertoire;

use App\Models\Band;
use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use App\Models\Venue;
use App\Services\RepertoireService;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RepertoireTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seedDB();
    }

    public function testUserCanAccessPage()
    {
        $this->get('/repertoire')
            ->assertSuccessful()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('LatestInfos/Repertoire')
                ->has('repertoire', 5, fn (AssertableInertia $page) => $page
                    ->has('title')
                    ->has('author')
                    ->has('genre')
                    ->has('arranger')
                )
            );
    }

    public function testRepertoireDataLimit()
    {
        $this->assertCount(5, RepertoireService::getCurrentRepertoire());
        $this->assertCount(3, RepertoireService::getCurrentRepertoire(3));
        $this->assertCount(6, RepertoireService::getCurrentRepertoire(6));
    }

    public function testRepertoireDataFormat()
    {
        $firstSong = RepertoireService::getCurrentRepertoire()->first();

        $this->assertArrayHasKey('title', $firstSong);
        $this->assertArrayHasKey('genre', $firstSong);
        $this->assertArrayHasKey('author', $firstSong);
        $this->assertArrayHasKey('arranger', $firstSong);
    }

    protected function seedDB(int $count = 10): void
    {
        Concert::factory()
            ->for(Band::factory()->create())
            ->for(Venue::factory()->create())
            ->count($count)
            ->sequence(
                fn (Sequence $sequence) => ['date' => Carbon::now()->subDays(($sequence->index + 1) * 2)],
            )
            ->create();

        foreach (Concert::all() as $concert) {
            SetlistEntry::factory()
                ->for($concert)
                ->for(Song::factory()->create())
                ->create();
        }
    }
}
