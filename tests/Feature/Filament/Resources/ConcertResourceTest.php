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

    public function testRenderingResourcePage()
    {

        $this->get(ConcertResource::getUrl())
            ->assertSuccessful();
    }
}
