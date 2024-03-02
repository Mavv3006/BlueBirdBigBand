<?php

namespace Tests;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Database\Seeders\DefaultAuthorizationSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\App;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function createUserForInternalRoutes()
    {
        return User::factory()
            ->create(['status' => UserStates::Activated])
            ->assignRole('musician');
    }

    protected function createUserForAdminRoutes()
    {
        return User::factory()
            ->create(['status' => UserStates::Activated])
            ->assignRole('admin');
    }

    protected function setupMusician(): void
    {
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForInternalRoutes());
    }

    protected function setupAdmin(): void
    {
        $this->seed(DefaultAuthorizationSeeder::class);
        $this->actingAs($this->createUserForAdminRoutes());
    }

    protected function setupInertiaMetaInfo()
    {
        $service = App::make(InertiaMetaInfoDto::class);
        $service->setTitle('fjaöf');
        $service->setDescription('slfjöas');
    }
}
