<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\InstrumentResource;
use Tests\TestCase;

class InstrumentResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_rendering_resource_page()
    {

        $this->get(InstrumentResource::getUrl())
            ->assertSuccessful();
    }
}
