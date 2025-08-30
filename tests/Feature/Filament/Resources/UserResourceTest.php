<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\Users\UserResource;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setupAdmin();
    }

    public function test_rendering_resource_page()
    {

        $this->get(UserResource::getUrl())
            ->assertSuccessful();
    }
}
