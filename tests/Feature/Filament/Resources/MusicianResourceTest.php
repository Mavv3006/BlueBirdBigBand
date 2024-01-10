<?php

namespace Filament\Resources;

use App\Filament\Resources\MusicianResource;
use Tests\TestCase;

class MusicianResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function testRenderingResourcePage()
    {

        $this->get(MusicianResource::getUrl())
            ->assertSuccessful();
    }
}
