<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\ConcertResource;
use Tests\TestCase;

class ConcertResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_rendering_resource_page()
    {

        $this->get(ConcertResource::getUrl())
            ->assertSuccessful();
    }
}
