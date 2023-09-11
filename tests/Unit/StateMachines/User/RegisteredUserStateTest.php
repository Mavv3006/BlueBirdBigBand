<?php

namespace StateMachines\User;

use App\Enums\StateMachines\UserStates;
use App\Models\User;
use Tests\TestCase;

class RegisteredUserStateTest extends TestCase
{
    public function test_activate_user()
    {
        $user = User::factory()->create();

        $user->state()->activate();

        $this->assertTrue($user->activated);
        $this->assertEquals(UserStates::Activated, $user->status);
    }
}
