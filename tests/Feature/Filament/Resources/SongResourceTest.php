<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\SongResource;
use Tests\TestCase;

class SongResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_rendering_resource_page()
    {

        $this->get(SongResource::getUrl())
            ->assertSuccessful();
    }
}
