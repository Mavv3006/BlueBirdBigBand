<?php

namespace Tests\Feature\Filament\InstrumentResource;

use App\Filament\Resources\InstrumentResource;
use Tests\TestCase;

class InstrumentResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function testRenderingResourcePage()
    {
        $this->get(InstrumentResource::getUrl())
            ->assertSuccessful();
    }
}
