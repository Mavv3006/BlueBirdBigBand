<?php

namespace Tests;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Database\Seeders\DefaultAuthorizationSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function createUserForInternalRoutes()
    {
        return User::factory()
            ->create(['activated' => true])
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
}
