<?php

namespace Filament\Resources;

use App\Filament\Resources\SongResource;
use Tests\TestCase;

class SongResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function testRenderingResourcePage()
    {

        $this->get(SongResource::getUrl())
            ->assertSuccessful();
    }
}
