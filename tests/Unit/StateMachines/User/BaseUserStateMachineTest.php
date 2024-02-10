<?php

namespace Tests\Unit\StateMachines\User;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Tests\TestCase;

class BaseUserStateMachineTest extends TestCase
{
    public function test_status_cast()
    {
        $user = User::factory()->create(['status' => UserStates::Activated]);

        $this->assertInstanceOf(UserStates::class, $user->status);
    }

    public function test_default_status_value()
    {
        $user = User::factory()->create();

        $this->assertEquals(UserStates::Registered, $user->status);
    }
}
