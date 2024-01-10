<?php

namespace Filament\Resources;

use App\Filament\Resources\UserResource;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function testRenderingResourcePage()
    {

        $this->get(UserResource::getUrl())
            ->assertSuccessful();
    }
}
