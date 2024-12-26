<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\MusicianResource;
use Tests\TestCase;

class MusicianResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_rendering_resource_page()
    {

        $this->get(MusicianResource::getUrl())
            ->assertSuccessful();
    }
}
